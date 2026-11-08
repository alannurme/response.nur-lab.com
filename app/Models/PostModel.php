<?php
namespace App\Models;
use App\Core\Model;

class PostModel extends Model {
    public function getAllPosts($limit = 10, $offset = 0, $include_drafts = false) {
        $statusClause = $include_drafts ? "" : "WHERE p.status = 'published'";
        $stmt = $this->db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, 
                                           COALESCE(GROUP_CONCAT(DISTINCT c.name SEPARATOR ', '), c2.name) as category_name,
                                           COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    LEFT JOIN categories c2 ON p.category_id = c2.id
                                    LEFT JOIN post_authors pa ON p.id = pa.post_id
                                    LEFT JOIN authors a ON pa.author_id = a.id
                                    $statusClause 
                                    GROUP BY p.id
                                    ORDER BY p.created_at DESC 
                                    LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalPostsCount($include_drafts = false) {
        $statusClause = $include_drafts ? "" : "WHERE status = 'published'";
        $stmt = $this->db->query("SELECT COUNT(*) FROM posts $statusClause");
        return (int)$stmt->fetchColumn();
    }

    public function getPostBySlug($slug) {
        $stmt = $this->db->prepare("SELECT p.*, COALESCE(GROUP_CONCAT(c.name SEPARATOR ', '), c2.name) as category_name 
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    LEFT JOIN categories c2 ON p.category_id = c2.id
                                    WHERE p.slug = :slug
                                    GROUP BY p.id");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function getPostCategories($post_id) {
        $stmt = $this->db->prepare("SELECT c.* FROM categories c 
                                    JOIN post_categories pc ON c.id = pc.category_id 
                                    WHERE pc.post_id = :post_id 
                                    ORDER BY c.order_index ASC, c.name ASC");
        $stmt->execute(['post_id' => $post_id]);
        $cats = $stmt->fetchAll();
        if (empty($cats)) {
            $stmt2 = $this->db->prepare("SELECT c.* FROM categories c 
                                         JOIN posts p ON c.id = p.category_id 
                                         WHERE p.id = :post_id");
            $stmt2->execute(['post_id' => $post_id]);
            $cats = $stmt2->fetchAll();
        }
        return $cats;
    }

    public function getPostAuthors($post_id) {
        $stmt = $this->db->prepare("SELECT a.* FROM authors a 
                                    JOIN post_authors pa ON a.id = pa.author_id 
                                    WHERE pa.post_id = :post_id 
                                    ORDER BY a.name ASC");
        $stmt->execute(['post_id' => $post_id]);
        $authors = $stmt->fetchAll();
        if (empty($authors)) {
            $stmt2 = $this->db->prepare("SELECT author as name FROM posts WHERE id = :post_id");
            $stmt2->execute(['post_id' => $post_id]);
            $author_name = $stmt2->fetchColumn() ?: 'Admin';
            $authors = [['name' => $author_name, 'email' => '']];
        }
        return $authors;
    }

    public function getPostById($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY order_index ASC, name ASC");
        return $stmt->fetchAll();
    }

    public function getRandomPostsForMainCategories($limitPerCategory = 12) {
        // 1. Get all categories and build hierarchy
        $allCategories = $this->db->query("SELECT id, name, slug, description, parent_id, order_index FROM categories ORDER BY order_index ASC, id ASC")->fetchAll();
        if (empty($allCategories)) {
            return [];
        }

        $subCatMap = [];
        $mainCats = [];
        foreach ($allCategories as $cat) {
            if (empty($cat['parent_id'])) {
                $mainCats[] = $cat;
            } else {
                $subCatMap[$cat['parent_id']][] = (int)$cat['id'];
            }
        }

        $getDescendants = function($parentId) use (&$getDescendants, $subCatMap) {
            $ids = [$parentId];
            if (!empty($subCatMap[$parentId])) {
                foreach ($subCatMap[$parentId] as $childId) {
                    $ids = array_merge($ids, $getDescendants($childId));
                }
            }
            return $ids;
        };

        // 2. Fetch published post-to-category associations
        $postCatRows = $this->db->query("SELECT DISTINCT p.id as post_id, pc.category_id 
                                         FROM posts p 
                                         JOIN post_categories pc ON p.id = pc.post_id 
                                         WHERE p.status = 'published'")->fetchAll();

        $catToPostMap = [];
        foreach ($postCatRows as $row) {
            $catToPostMap[$row['category_id']][] = (int)$row['post_id'];
        }

        // Direct posts mapped by p.category_id
        $directPosts = $this->db->query("SELECT id, category_id FROM posts WHERE status = 'published' AND category_id IS NOT NULL")->fetchAll();
        foreach ($directPosts as $row) {
            $catToPostMap[$row['category_id']][] = (int)$row['id'];
        }

        $selectedIdsByCat = [];
        $allSelectedIds = [];
        foreach ($mainCats as $mainCat) {
            $catIds = $getDescendants((int)$mainCat['id']);
            $postIds = [];
            foreach ($catIds as $cid) {
                if (!empty($catToPostMap[$cid])) {
                    $postIds = array_merge($postIds, $catToPostMap[$cid]);
                }
            }
            $postIds = array_unique($postIds);
            if (!empty($postIds)) {
                shuffle($postIds);
                $picked = array_slice($postIds, 0, (int)$limitPerCategory);
                $selectedIdsByCat[$mainCat['id']] = $picked;
                $allSelectedIds = array_merge($allSelectedIds, $picked);
            }
        }

        $allSelectedIds = array_unique($allSelectedIds);
        $postsById = [];
        if (!empty($allSelectedIds)) {
            $inList = implode(',', array_map('intval', $allSelectedIds));
            $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, 
                           p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at,
                           COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'এডমিন') as author_name
                    FROM posts p
                    LEFT JOIN post_authors pa ON p.id = pa.post_id
                    LEFT JOIN authors a ON pa.author_id = a.id
                    WHERE p.id IN ($inList)
                    GROUP BY p.id";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch()) {
                $postsById[$row['id']] = $row;
            }
        }

        $categorySections = [];
        foreach ($mainCats as $mainCat) {
            $secPosts = [];
            if (isset($selectedIdsByCat[$mainCat['id']])) {
                foreach ($selectedIdsByCat[$mainCat['id']] as $pid) {
                    if (isset($postsById[$pid])) {
                        $secPosts[] = $postsById[$pid];
                    }
                }
            }
            $categorySections[] = [
                'category' => $mainCat,
                'posts'    => $secPosts
            ];
        }

        return $categorySections;
    }

    public function getSlides() {
        $stmt = $this->db->query("SELECT * FROM slides ORDER BY order_index ASC");
        return $stmt->fetchAll();
    }

    public function getRelatedPosts($category_id, $current_post_id, $limit = 3) {
        $stmt = $this->db->prepare("SELECT DISTINCT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at FROM posts p 
                                    JOIN post_categories pc ON p.id = pc.post_id
                                    WHERE pc.category_id = :category_id 
                                    AND p.id != :current_id 
                                    AND p.status = 'published' 
                                    ORDER BY p.created_at DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':category_id', $category_id, \PDO::PARAM_INT);
        $stmt->bindValue(':current_id', $current_post_id, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function incrementViews($id) {
        $stmt = $this->db->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getPostViews($id) {
        $stmt = $this->db->prepare("SELECT views FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return (int)$stmt->fetchColumn();
    }

    public function getPopularPosts($limit = 5) {
        $stmt = $this->db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    WHERE p.status = 'published' 
                                    GROUP BY p.id
                                    ORDER BY p.views DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostsByCategoryForAdmin($categoryId = null, $limit = 100, $offset = 0, $showMode = 'all') {
        if ($categoryId === null) {
            $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at,
                           c2.name as main_category,
                           GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as secondary_categories,
                           COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                     FROM posts p
                     LEFT JOIN post_categories pc ON p.id = pc.post_id
                     LEFT JOIN categories c ON pc.category_id = c.id
                     LEFT JOIN categories c2 ON p.category_id = c2.id
                     LEFT JOIN post_authors pa ON p.id = pa.post_id
                     LEFT JOIN authors a ON pa.author_id = a.id
                     GROUP BY p.id
                     ORDER BY p.created_at DESC
                     LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
        } else {
            $whereClause = ($showMode === 'primary') ? "p.category_id = :category_id" : "(p.category_id = :category_id OR pc.category_id = :category_id)";
            $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at,
                            c2.name as main_category,
                            GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as secondary_categories,
                            COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                    FROM posts p
                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                    LEFT JOIN categories c ON pc.category_id = c.id
                    LEFT JOIN categories c2 ON p.category_id = c2.id
                    LEFT JOIN post_authors pa ON p.id = pa.post_id
                    LEFT JOIN authors a ON pa.author_id = a.id
                    WHERE $whereClause
                    GROUP BY p.id
                    ORDER BY p.created_at DESC
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':category_id', (int)$categoryId, \PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostsCountByCategoryForAdmin($categoryId = null, $showMode = 'all') {
        if ($categoryId === null) {
            // Root folder = ALL posts
            $sql = "SELECT COUNT(DISTINCT p.id) FROM posts p";
            $stmt = $this->db->prepare($sql);
        } else {
            $whereClause = ($showMode === 'primary') ? "p.category_id = :category_id" : "(p.category_id = :category_id OR pc.category_id = :category_id)";
            $sql = "SELECT COUNT(DISTINCT p.id) 
                    FROM posts p
                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                    WHERE $whereClause";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':category_id', (int)$categoryId, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getTreePosts() {
        $stmt = $this->db->query("
            SELECT p.id, p.title, p.slug, COALESCE(pc.category_id, p.category_id) as category_id 
            FROM posts p
            LEFT JOIN post_categories pc ON p.id = pc.post_id
            ORDER BY p.title ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Helper to extract common Bengali root/stem by stripping grammatical suffixes (বিভক্তি / বহুবচন)
     */
    private function getBengaliStem($w) {
        $w = trim($w);
        $suffixes = ['গুলোর', 'গুলো', 'গুলির', 'গুলি', 'সমূহের', 'সমূহ', 'দের', 'য়ের', 'এর', 'ের', 'কে', 'তে', 'র', 'ে', 'য়'];
        foreach ($suffixes as $suf) {
            if (mb_strlen($w, 'UTF-8') > (mb_strlen($suf, 'UTF-8') + 2)) {
                if (mb_substr($w, -mb_strlen($suf, 'UTF-8'), null, 'UTF-8') === $suf) {
                    return mb_substr($w, 0, -mb_strlen($suf, 'UTF-8'), 'UTF-8');
                }
            }
        }
        return $w;
    }

    /**
     * Generate common Bengali spelling / phonetic variants (e.g. দ <-> ধ, ু <-> ূ, স <-> শ <-> ষ, জ <-> য, ি <-> ী)
     */
    private function getBengaliSearchVariants($w) {
        $vars = [$w];
        $stem = $this->getBengaliStem($w);
        if ($stem !== $w) $vars[] = $stem;
        
        $swaps = [
            ['দ', 'ধ'],
            ['ু', 'ূ'],
            ['স', 'শ'],
            ['শ', 'ষ'],
            ['স', 'ষ'],
            ['জ', 'য'],
            ['ি', 'ী'],
            ['ত', 'থ'],
            ['ব', 'ভ'],
            ['ন', 'ণ'],
            ['ড়', 'ঢ়'],
            ['র', 'ড়']
        ];

        foreach ([$w, $stem] as $item) {
            foreach ($swaps as [$from, $to]) {
                if (mb_strpos($item, $from) !== false) {
                    $vars[] = str_replace($from, $to, $item);
                }
                if (mb_strpos($item, $to) !== false) {
                    $vars[] = str_replace($to, $from, $item);
                }
            }
        }

        return array_unique(array_filter($vars));
    }

    /**
     * Get lightweight indexed catalogue of all posts for instant 0ms client-side live search.
     * Cached in memory for high-performance instant filtering.
     */
    public function getAllPostsForSearchCatalog() {
        return \App\Helpers\Cache::remember('all_posts_search_catalog', 1800, function() {
            $stmt = $this->db->query("SELECT p.id, p.title, p.slug, p.status, p.created_at, p.views, p.excerpt, p.seo_keywords, p.category_id
                                      FROM posts p
                                      ORDER BY p.id DESC");
            $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $catStmt = $this->db->query("SELECT pc.post_id, c.name FROM post_categories pc JOIN categories c ON pc.category_id = c.id");
            $catMap = [];
            while ($row = $catStmt->fetch(\PDO::FETCH_ASSOC)) {
                $catMap[$row['post_id']][] = $row['name'];
            }

            $c2Stmt = $this->db->query("SELECT id, name FROM categories");
            $directCatMap = [];
            while ($row = $c2Stmt->fetch(\PDO::FETCH_ASSOC)) {
                $directCatMap[$row['id']] = $row['name'];
            }

            foreach ($posts as &$p) {
                $main = $directCatMap[$p['category_id']] ?? ($catMap[$p['id']][0] ?? 'ইসলাম');
                $p['main_category'] = $main;
                $p['secondary_categories'] = isset($catMap[$p['id']]) ? implode(', ', $catMap[$p['id']]) : '';
                unset($p['category_id']);
            }
            return $posts;
        });
    }

    /**
     * Ultra-fast multi-tier ranked search across posts:
     * - Searches Title, Content, Excerpt, SEO Keywords, and Categories.
     * - Matches even partial words ("olpo milleu") and Bengali phonetic typos (বিদান <-> বিধান).
     * - Ranks exact same-to-same title and phrase matches at the very top (Priority 1).
     * - Multi-tier execution: Fast metadata scan (~15ms) + targeted content scan + caching.
     */
    public function searchPostsFast($query, $limit = 60, $include_drafts = false, $categoryId = null) {
        $q = trim($query);
        if (empty($q)) return [];

        $cacheKey = 'fast_search_' . md5($q . '_' . ($include_drafts ? '1' : '0') . '_' . ($categoryId ?? 'root') . '_' . $limit);
        $cached = \App\Helpers\Cache::get($cacheKey);
        if ($cached !== null && is_array($cached)) {
            return $cached;
        }

        $statusClause = $include_drafts ? "1=1" : "p.status = 'published'";
        $categoryClause = "";
        if ($categoryId !== null) {
            $categoryClause = "AND (p.category_id = " . (int)$categoryId . " OR pc.category_id = " . (int)$categoryId . ")";
        }

        $words = preg_split('/\s+/u', $q, -1, PREG_SPLIT_NO_EMPTY);
        $params = [
            'q_exact' => $q,
            'q_start' => $q . '%',
            'q_like'  => '%' . $q . '%'
        ];

        $matchTitleParts = [
            "(p.title LIKE :q_like OR p.seo_keywords LIKE :q_like OR p.excerpt LIKE :q_like)"
        ];

        $wordConditions = [];
        $highlightTerms = [$q];

        foreach ($words as $idx => $w) {
            $variants = $this->getBengaliSearchVariants($w);
            $wConditions = [];
            foreach ($variants as $vIdx => $v) {
                $highlightTerms[] = $v;
                $paramKey = "w_{$idx}_{$vIdx}";
                $params[$paramKey] = '%' . $v . '%';
                $wConditions[] = "(p.title LIKE :$paramKey OR p.seo_keywords LIKE :$paramKey OR p.excerpt LIKE :$paramKey)";
            }
            $matchTitleParts[] = "(" . implode(" OR ", $wConditions) . ")";
            $wordConditions[] = "(" . implode(" OR ", $wConditions) . ")";
        }

        $caseBonus = "";
        if (count($words) > 1 && count($words) <= 5) {
            $caseBonus .= "WHEN (" . implode(" AND ", $wordConditions) . ") THEN 500\n";
        }

        $partialScores = "";
        foreach ($wordConditions as $wc) {
            $partialScores .= "WHEN $wc THEN 150\n";
        }

        $whereTitleSql = "(" . implode(" OR ", $matchTitleParts) . ")";

        // Tier 1: Fast metadata search (Title, SEO Keywords, Excerpt) - finishes in ~15ms!
        $sqlTier1 = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, 
                            p.post_type, p.views, p.fake_views, p.status, p.created_at, p.seo_title, p.seo_keywords,
                            (CASE 
                                 WHEN LOWER(TRIM(p.title)) = LOWER(:q_exact) THEN 1000
                                 WHEN LOWER(p.title) LIKE LOWER(:q_start) THEN 800
                                 WHEN LOWER(p.title) LIKE LOWER(:q_like) THEN 600
                                 $caseBonus
                                 WHEN LOWER(p.seo_keywords) LIKE LOWER(:q_like) THEN 450
                                 WHEN LOWER(p.excerpt) LIKE LOWER(:q_like) THEN 400
                                 $partialScores
                                 ELSE 50 
                             END) as relevance_score
                     FROM posts p
                     WHERE $statusClause $categoryClause AND $whereTitleSql
                     ORDER BY 
                         relevance_score DESC,
                         p.views DESC,
                         p.id DESC
                     LIMIT :limit";

        $stmt = $this->db->prepare($sqlTier1);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        // Tier 2: If Tier 1 has fewer than 25 results, search content body
        if (count($posts) < 25) {
            $existingIds = !empty($posts) ? array_column($posts, 'id') : [];
            $notInClause = !empty($existingIds) ? ("AND p.id NOT IN (" . implode(',', array_map('intval', $existingIds)) . ")") : "";
            
            $contentWhere = "(p.content LIKE :qc_like)";
            $contentParams = ['qc_like' => '%' . $q . '%'];

            if (!empty($words)) {
                $cWordOr = [];
                foreach ($words as $wIdx => $w) {
                    $variants = $this->getBengaliSearchVariants($w);
                    $subOr = [];
                    foreach ($variants as $vIdx => $v) {
                        $cKey = "cw_{$wIdx}_{$vIdx}";
                        $contentParams[$cKey] = '%' . $v . '%';
                        $subOr[] = "p.content LIKE :$cKey";
                    }
                    $cWordOr[] = "(" . implode(" OR ", $subOr) . ")";
                }
                $contentWhere = "(p.content LIKE :qc_like OR (" . implode(" OR ", $cWordOr) . "))";
            }

            $neededLimit = max(10, min(20, (int)$limit - count($posts)));
            $sqlTier2 = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, 
                                p.post_type, p.views, p.fake_views, p.status, p.created_at, p.seo_title, p.seo_keywords,
                                (CASE 
                                     WHEN p.content LIKE :qc_like THEN 350
                                     ELSE 80 
                                 END) as relevance_score
                         FROM posts p
                         WHERE $statusClause $categoryClause $notInClause AND $contentWhere
                         ORDER BY relevance_score DESC, p.views DESC
                         LIMIT " . (int)$neededLimit;

            $stmt2 = $this->db->prepare($sqlTier2);
            foreach ($contentParams as $k => $v) {
                $stmt2->bindValue(':' . $k, $v);
            }
            $stmt2->execute();
            $contentPosts = $stmt2->fetchAll();
            if (!empty($contentPosts)) {
                $posts = array_merge($posts, $contentPosts);
            }
        }

        // Resolve categories & short content snippets for matched posts
        if (!empty($posts)) {
            $postIds = array_column($posts, 'id');
            $inClause = implode(',', array_map('intval', $postIds));
            
            $catStmt = $this->db->query("SELECT p.id, COALESCE(c2.name, c.name, 'ইসলাম') as main_category, 
                                           GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as secondary_categories
                                    FROM posts p
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id
                                    LEFT JOIN categories c2 ON p.category_id = c2.id
                                    WHERE p.id IN ($inClause)
                                    GROUP BY p.id");
            $catsMap = [];
            while ($row = $catStmt->fetch()) {
                $catsMap[$row['id']] = $row;
            }

            // Fetch small content sample only for matched posts
            $contentStmt = $this->db->query("SELECT id, SUBSTRING(content, 1, 6000) as sample_content FROM posts WHERE id IN ($inClause)");
            $contentMap = [];
            while ($cRow = $contentStmt->fetch()) {
                $contentMap[$cRow['id']] = $cRow['sample_content'];
            }

            $highlightTerms = array_unique(array_filter($highlightTerms));
            usort($highlightTerms, function($a, $b) {
                return mb_strlen($b, 'UTF-8') <=> mb_strlen($a, 'UTF-8');
            });

            $qLower = mb_strtolower($q, 'UTF-8');

            foreach ($posts as &$post) {
                $id = $post['id'];
                $post['main_category'] = $catsMap[$id]['main_category'] ?? 'ইসলাম';
                $post['secondary_categories'] = $catsMap[$id]['secondary_categories'] ?? '';

                $titleLower = mb_strtolower($post['title'], 'UTF-8');
                $keywordsLower = mb_strtolower($post['seo_keywords'] ?? '', 'UTF-8');
                $excerptLower = mb_strtolower($post['excerpt'] ?? '', 'UTF-8');
                $rawContent = $contentMap[$id] ?? '';
                $cleanContent = trim(preg_replace('/\s+/u', ' ', strip_tags($rawContent)));

                $isTitleMatch = false;
                foreach ($highlightTerms as $ht) {
                    if (mb_strlen($ht, 'UTF-8') >= 2 && mb_strpos($titleLower, mb_strtolower($ht, 'UTF-8')) !== false) {
                        $isTitleMatch = true;
                        break;
                    }
                }

                if ($isTitleMatch) {
                    $post['match_badge'] = 'Title Match';
                } elseif (mb_strpos($keywordsLower, $qLower) !== false || mb_strpos($excerptLower, $qLower) !== false) {
                    $post['match_badge'] = 'Keyword Match';
                } else {
                    $post['match_badge'] = 'Content Match';
                }

                // Safe Title Highlighting
                $highlightedTitle = htmlspecialchars($post['title']);
                foreach ($highlightTerms as $term) {
                    if (mb_strlen($term, 'UTF-8') >= 2) {
                        $highlightedTitle = preg_replace('/(' . preg_quote($term, '/') . ')/iu', '<mark style="background:#fef08a; color:#854d0e; padding:1px 4px; border-radius:3px; font-weight:700;">$1</mark>', $highlightedTitle);
                    }
                }
                $post['highlighted_title'] = $highlightedTitle;

                // Snippet extraction around matched words
                $snippetText = '';
                $pos = mb_stripos($cleanContent, $q, 0, 'UTF-8');
                if ($pos === false) {
                    foreach ($highlightTerms as $ht) {
                        if (mb_strlen($ht, 'UTF-8') >= 3) {
                            $pos = mb_stripos($cleanContent, $ht, 0, 'UTF-8');
                            if ($pos !== false) break;
                        }
                    }
                }

                if ($pos !== false) {
                    $start = max(0, $pos - 45);
                    $length = mb_strlen($q, 'UTF-8') + 120;
                    $snippetPart = mb_substr($cleanContent, $start, $length, 'UTF-8');
                    $prefix = ($start > 0) ? '... ' : '';
                    $suffix = (mb_strlen($cleanContent, 'UTF-8') > ($start + $length)) ? ' ...' : '';
                    $snippetText = $prefix . $snippetPart . $suffix;
                } elseif (!empty($post['excerpt'])) {
                    $snippetText = trim(strip_tags($post['excerpt']));
                } else {
                    $snippetText = mb_substr($cleanContent, 0, 130, 'UTF-8') . (mb_strlen($cleanContent, 'UTF-8') > 130 ? '...' : '');
                }

                $post['snippet'] = $snippetText;

                // Highlighted Snippet
                $escapedSnippet = htmlspecialchars($snippetText);
                $highlightedSnippet = $escapedSnippet;
                foreach ($highlightTerms as $term) {
                    if (mb_strlen($term, 'UTF-8') >= 2) {
                        $highlightedSnippet = preg_replace('/(' . preg_quote($term, '/') . ')/iu', '<mark style="background:#fef08a; color:#854d0e; padding:1px 4px; border-radius:3px; font-weight:700;">$1</mark>', $highlightedSnippet);
                    }
                }
                $post['highlighted_snippet'] = $highlightedSnippet;
                $post['content'] = $snippetText;
            }
        }

        // Cache search results for 5 minutes (300 seconds)
        \App\Helpers\Cache::set($cacheKey, $posts, 300);

        return $posts;
    }
}
