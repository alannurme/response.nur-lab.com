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
     * Intelligent ranked search across posts:
     * - Searches Title, Content, Excerpt, SEO Keywords, and Categories.
     * - Ranks exact same-to-same title and phrase matches at the very top (Priority 1).
     * - Matches in body content are included with high-relevance snippet extraction.
     */
    public function searchPostsFast($query, $limit = 60, $include_drafts = false, $categoryId = null) {
        $q = trim($query);
        if (empty($q)) return [];

        $statusClause = $include_drafts ? "1=1" : "p.status = 'published'";
        $categoryClause = "";
        $params = [
            'q_exact' => $q,
            'q_start' => $q . '%',
            'q_like'  => '%' . $q . '%'
        ];

        if ($categoryId !== null) {
            $categoryClause = "AND (p.category_id = :cat_id OR pc.category_id = :cat_id)";
            $params['cat_id'] = (int)$categoryId;
        }

        $words = preg_split('/\s+/u', $q, -1, PREG_SPLIT_NO_EMPTY);
        $whereParts = [
            "(p.title LIKE :q_like OR p.seo_keywords LIKE :q_like OR p.excerpt LIKE :q_like OR p.content LIKE :q_like OR c2.name LIKE :q_like OR c.name LIKE :q_like)"
        ];

        $titleWordConditions = [];
        $contentWordConditions = [];

        if (count($words) > 1 && count($words) <= 6) {
            $wordConditions = [];
            foreach ($words as $idx => $w) {
                $paramName = 'w_' . $idx;
                $params[$paramName] = '%' . $w . '%';
                $wordConditions[] = "(p.title LIKE :$paramName OR p.content LIKE :$paramName OR p.seo_keywords LIKE :$paramName OR p.excerpt LIKE :$paramName)";
                $titleWordConditions[] = "p.title LIKE :$paramName";
                $contentWordConditions[] = "p.content LIKE :$paramName";
            }
            $whereParts[] = "(" . implode(" AND ", $wordConditions) . ")";
        }

        $whereSql = "(" . implode(" OR ", $whereParts) . ")";

        $caseScoreExtra = "";
        if (!empty($titleWordConditions)) {
            $caseScoreExtra .= "WHEN (" . implode(" AND ", $titleWordConditions) . ") THEN 500\n";
        }
        if (!empty($contentWordConditions)) {
            $caseScoreExtra .= "WHEN (" . implode(" AND ", $contentWordConditions) . ") THEN 200\n";
        }

        $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, 
                       p.post_type, p.views, p.fake_views, p.status, p.created_at, p.seo_title, p.seo_keywords,
                       p.content,
                       COALESCE(c2.name, c.name, 'ইসলাম') as main_category,
                       GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as secondary_categories,
                       (CASE 
                            WHEN LOWER(TRIM(p.title)) = LOWER(:q_exact) THEN 1000
                            WHEN LOWER(p.title) LIKE LOWER(:q_start) THEN 800
                            WHEN LOWER(p.title) LIKE LOWER(:q_like) THEN 600
                            $caseScoreExtra
                            WHEN LOWER(p.seo_keywords) LIKE LOWER(:q_like) THEN 450
                            WHEN LOWER(p.excerpt) LIKE LOWER(:q_like) THEN 400
                            WHEN LOWER(p.content) LIKE LOWER(:q_like) THEN 350
                            ELSE 100 
                        END) as relevance_score
                FROM posts p
                LEFT JOIN post_categories pc ON p.id = pc.post_id
                LEFT JOIN categories c ON pc.category_id = c.id
                LEFT JOIN categories c2 ON p.category_id = c2.id
                WHERE $statusClause $categoryClause AND $whereSql
                GROUP BY p.id
                ORDER BY 
                    relevance_score DESC,
                    p.views DESC,
                    p.id DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        // Process badges, snippets, and highlights
        $qLower = mb_strtolower($q, 'UTF-8');
        $highlightTerms = array_merge([$q], $words);
        usort($highlightTerms, function($a, $b) {
            return mb_strlen($b, 'UTF-8') <=> mb_strlen($a, 'UTF-8');
        });

        foreach ($posts as &$post) {
            $titleLower = mb_strtolower($post['title'], 'UTF-8');
            $keywordsLower = mb_strtolower($post['seo_keywords'] ?? '', 'UTF-8');
            $excerptLower = mb_strtolower($post['excerpt'] ?? '', 'UTF-8');
            $rawContent = $post['content'] ?? '';
            $cleanContent = trim(preg_replace('/\s+/u', ' ', strip_tags($rawContent)));
            $contentLower = mb_strtolower($cleanContent, 'UTF-8');

            $isExactTitle = ($titleLower === $qLower);
            $isTitleMatch = (mb_strpos($titleLower, $qLower) !== false);
            $isKeywordMatch = (mb_strpos($keywordsLower, $qLower) !== false || mb_strpos($excerptLower, $qLower) !== false);
            $isContentMatch = (mb_strpos($contentLower, $qLower) !== false);

            if (!$isTitleMatch && count($words) > 1) {
                $allInTitle = true;
                foreach ($words as $w) {
                    if (mb_strpos($titleLower, mb_strtolower($w, 'UTF-8')) === false) {
                        $allInTitle = false;
                        break;
                    }
                }
                if ($allInTitle) $isTitleMatch = true;
            }

            if ($isExactTitle || $isTitleMatch) {
                $post['match_badge'] = 'Title Match';
            } elseif ($isKeywordMatch) {
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

            // Snippet extraction around the matched word
            $snippetText = '';
            $pos = mb_stripos($cleanContent, $q, 0, 'UTF-8');
            if ($pos === false && !empty($words)) {
                foreach ($words as $w) {
                    $pos = mb_stripos($cleanContent, $w, 0, 'UTF-8');
                    if ($pos !== false) break;
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

            // Set content to short snippet so memory & JSON payload remain light
            $post['content'] = $snippetText;
        }

        return $posts;
    }
}
