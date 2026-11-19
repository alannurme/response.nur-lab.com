<?php
namespace App\Controllers;
use App\Core\Controller;

class McpApi extends Controller {

    public function index() {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        // 1. Authenticate Request
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Unauthorized: Invalid or missing MCP API Key (Bearer Token).'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // 2. Read Request Payload
        $rawInput = file_get_contents('php://input');
        $payload = [];
        if (!empty($rawInput)) {
            $decoded = json_decode($rawInput, true);
            if (is_array($decoded)) {
                $payload = $decoded;
            }
        }
        $payload = array_merge($_GET, $_POST, $payload);

        $action = trim($payload['action'] ?? $payload['method'] ?? 'ping');

        // Handle JSON-RPC standard method call format
        if (strpos($action, 'response_') === 0) {
            $action = substr($action, strlen('response_'));
        }

        try {
            switch ($action) {
                case 'ping':
                    $this->ping();
                    break;

                case 'search_posts':
                    $this->searchPosts($payload);
                    break;

                case 'get_post':
                    $this->getPost($payload);
                    break;

                case 'create_post':
                case 'publish_post':
                    $this->createPost($payload);
                    break;

                case 'upload_docx_post':
                    $this->uploadDocxPost($payload);
                    break;

                case 'list_categories':
                    $this->listCategories($payload);
                    break;

                case 'create_category':
                    $this->createCategory($payload);
                    break;

                case 'list_questions':
                    $this->listQuestions($payload);
                    break;

                case 'add_question':
                case 'create_question':
                    $this->addQuestion($payload);
                    break;

                case 'answer_question':
                    $this->answerQuestion($payload);
                    break;

                case 'list_comments':
                    $this->listComments($payload);
                    break;

                case 'moderate_comment':
                    $this->moderateComment($payload);
                    break;

                case 'update_post_status':
                    $this->updatePostStatus($payload);
                    break;

                case 'delete_post':
                    $this->deletePost($payload);
                    break;

                case 'clear_cache':
                    $this->clearCache();
                    break;

                case 'get_settings':
                    $this->getSettings();
                    break;

                case 'get_site_stats':
                    $this->getSiteStats();
                    break;

                case 'fast_index':
                    $this->fastIndex();
                    break;

                case 'optimize_search_index':
                    $this->optimizeSearchIndex();
                    break;

                case 'resequence_posts':
                    $this->resequencePosts();
                    break;

                default:
                    http_response_code(400);
                    echo json_encode([
                        'status' => 'error',
                        'message' => "Unknown action: {$action}"
                    ], JSON_UNESCAPED_UNICODE);
                    break;
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    private function authenticate() {
        $db = \Config\Database::pdoConnect();
        $stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('post_api_key', 'mcp_api_key')");
        $storedKeys = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

        if (empty($storedKeys)) {
            // Default fallback if no key generated yet
            return true;
        }

        $providedKey = '';

        // 1. Check X-API-KEY header
        if (!empty($_SERVER['HTTP_X_API_KEY'])) {
            $providedKey = trim($_SERVER['HTTP_X_API_KEY']);
        }

        // 2. Check Authorization header
        if (empty($providedKey)) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
            if (empty($authHeader) && function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
                $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
            }

            if (!empty($authHeader)) {
                if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
                    $providedKey = trim($matches[1]);
                } else {
                    $providedKey = trim($authHeader);
                }
            }
        }

        // 3. Check GET or POST param
        if (empty($providedKey)) {
            $providedKey = trim($_GET['api_key'] ?? $_POST['api_key'] ?? '');
        }

        // 4. Check JSON payload body
        if (empty($providedKey)) {
            $rawInput = file_get_contents('php://input');
            if (!empty($rawInput)) {
                $j = json_decode($rawInput, true);
                if (!empty($j['api_key'])) {
                    $providedKey = trim($j['api_key']);
                }
            }
        }

        if (empty($providedKey)) {
            return false;
        }

        foreach ($storedKeys as $k => $val) {
            if (!empty($val) && hash_equals($val, $providedKey)) {
                return true;
            }
        }

        return false;
    }

    private function ping() {
        $db = \Config\Database::pdoConnect();
        $siteTitle = $db->query("SELECT setting_value FROM settings WHERE setting_key = 'site_title'")->fetchColumn() ?: 'Response';

        echo json_encode([
            'status' => 'success',
            'server' => 'Response MCP Server',
            'version' => '1.0.0',
            'site_title' => $siteTitle,
            'base_url' => rtrim(URLROOT, '/'),
            'timestamp' => time()
        ], JSON_UNESCAPED_UNICODE);
    }

    private function searchPosts($payload) {
        $query = trim($payload['query'] ?? $payload['keyword'] ?? $payload['q'] ?? '');
        $limit = max(1, min(2000, (int)($payload['limit'] ?? 10)));
        $categoryId = !empty($payload['category_id']) ? (int)$payload['category_id'] : null;

        $db = \Config\Database::pdoConnect();
        
        $sql = "SELECT p.id, p.title, p.slug, p.excerpt, p.status, p.views, p.created_at,
                       c.id AS category_id, c.name AS category_name, c.parent_id,
                       pc.name AS parent_category_name
                FROM posts p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN categories pc ON c.parent_id = pc.id
                WHERE 1=1";
        $params = [];

        if (!empty($query)) {
            $sql .= " AND (p.title LIKE :q1 OR p.slug LIKE :q2 OR p.seo_title LIKE :q3 OR p.seo_keywords LIKE :q4 OR p.content LIKE :q5)";
            $searchTerm = "%{$query}%";
            $params['q1'] = $searchTerm;
            $params['q2'] = $searchTerm;
            $params['q3'] = $searchTerm;
            $params['q4'] = $searchTerm;
            $params['q5'] = $searchTerm;
        }

        if ($categoryId !== null) {
            $sql .= " AND (p.category_id = :cat_id OR p.category_id IN (SELECT id FROM categories WHERE parent_id = :p_cat_id))";
            $params['cat_id'] = $categoryId;
            $params['p_cat_id'] = $categoryId;
        }

        $sql .= " ORDER BY p.created_at DESC, p.id DESC LIMIT " . (int)$limit;

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $results = [];
        $baseUrl = rtrim(URLROOT, '/');

        foreach ($posts as $post) {
            $cleanExcerpt = strip_tags($post['excerpt'] ?? '');
            if (empty($cleanExcerpt)) {
                $cleanExcerpt = mb_substr(strip_tags($post['title']), 0, 150);
            }

            $results[] = [
                'id' => (int)$post['id'],
                'title' => $post['title'],
                'slug' => $post['slug'],
                'url' => $baseUrl . '/post/' . $post['slug'],
                'category' => $post['category_name'] ?: 'General',
                'parent_category' => $post['parent_category_name'] ?: null,
                'status' => $post['status'],
                'views' => (int)$post['views'],
                'created_at' => $post['created_at'],
                'excerpt' => $cleanExcerpt
            ];
        }

        echo json_encode([
            'status' => 'success',
            'query' => $query,
            'count' => count($results),
            'posts' => $results
        ], JSON_UNESCAPED_UNICODE);
    }

    private function getPost($payload) {
        $slugOrId = trim($payload['slug'] ?? $payload['slug_or_id'] ?? $payload['id'] ?? '');
        if (empty($slugOrId)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'slug or id parameter is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $db = \Config\Database::pdoConnect();
        if (is_numeric($slugOrId)) {
            $stmt = $db->prepare("SELECT p.*, c.name AS category_name, pc.name AS parent_category_name
                                  FROM posts p
                                  LEFT JOIN categories c ON p.category_id = c.id
                                  LEFT JOIN categories pc ON c.parent_id = pc.id
                                  WHERE p.id = :id LIMIT 1");
            $stmt->execute(['id' => (int)$slugOrId]);
        } else {
            $stmt = $db->prepare("SELECT p.*, c.name AS category_name, pc.name AS parent_category_name
                                  FROM posts p
                                  LEFT JOIN categories c ON p.category_id = c.id
                                  LEFT JOIN categories pc ON c.parent_id = pc.id
                                  WHERE p.slug = :slug LIMIT 1");
            $stmt->execute(['slug' => $slugOrId]);
        }

        $post = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$post) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Post not found.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $baseUrl = rtrim(URLROOT, '/');
        $post['url'] = $baseUrl . '/post/' . $post['slug'];

        echo json_encode([
            'status' => 'success',
            'post' => $post
        ], JSON_UNESCAPED_UNICODE);
    }

    private function createPost($payload) {
        $title = trim($payload['title'] ?? '');
        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'title is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $rawSlug = !empty($payload['slug']) ? $payload['slug'] : $title;
        $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($rawSlug, 'UTF-8')), '-');

        // Resolve Category & Parent Category
        $targetCategory = trim($payload['category'] ?? '');
        $targetParent = trim($payload['parent_category'] ?? '');
        $categoryId = $this->resolveCategory($targetCategory, $targetParent);

        // Content & Parts
        $content = '';
        if (!empty($payload['parts']) && is_array($payload['parts'])) {
            $partHtmls = [];
            foreach ($payload['parts'] as $part) {
                $pTitle = trim($part['title'] ?? '');
                $pHtml = trim($part['html'] ?? $part['content'] ?? '');
                if ($pTitle !== '') {
                    $partHtmls[] = '<h2>' . htmlspecialchars($pTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
                }
                if ($pHtml !== '') {
                    $partHtmls[] = $pHtml;
                }
            }
            $content = implode("\n", $partHtmls);
        } else {
            $content = trim($payload['content'] ?? '');
        }

        // Clean double blockquotes if present
        $content = preg_replace('/<\/blockquote>\s*<blockquote[^>]*>/i', '<br>', $content);

        $excerpt = trim($payload['excerpt'] ?? '');
        if (empty($excerpt) && !empty($content)) {
            $cleanP = strip_tags($content);
            $excerpt = mb_substr($cleanP, 0, 160) . (mb_strlen($cleanP) > 160 ? '...' : '');
        }

        $status = in_array(strtolower($payload['status'] ?? ''), ['draft', 'published']) ? strtolower($payload['status']) : 'published';

        $data = [
            'category_ids' => [$categoryId],
            'category_id' => $categoryId,
            'author_ids' => [1],
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $payload['featured_image'] ?? '',
            'post_type' => 'blog',
            'fake_views' => 0,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
            'views' => 0,
            'seo_title' => $payload['seo_title'] ?? $title,
            'seo_description' => $payload['seo_description'] ?? $excerpt,
            'seo_keywords' => $payload['seo_keywords'] ?? '',
            'schema_data' => null
        ];

        $adminModel = $this->model('AdminModel');
        if ($adminModel->createPost($data)) {
            $db = \Config\Database::pdoConnect();
            $newId = $db->query("SELECT id, slug FROM posts WHERE slug = " . $db->quote($slug) . " ORDER BY id DESC LIMIT 1")->fetch(\PDO::FETCH_ASSOC);

            $baseUrl = rtrim(URLROOT, '/');
            $finalSlug = $newId ? $newId['slug'] : $slug;
            $postUrl = $baseUrl . '/post/' . $finalSlug;

            \App\Helpers\Cache::clear();

            echo json_encode([
                'status' => 'success',
                'message' => 'Post created successfully!',
                'post_id' => $newId ? (int)$newId['id'] : null,
                'slug' => $finalSlug,
                'url' => $postUrl,
                'category_id' => $categoryId,
                'post_status' => $status
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to save post to database.'], JSON_UNESCAPED_UNICODE);
        }
    }

    private function uploadDocxPost($payload) {
        $tempDocxPath = '';
        $shouldDeleteTemp = false;

        if (!empty($_FILES['docx_file']['tmp_name'])) {
            $tempDocxPath = $_FILES['docx_file']['tmp_name'];
        } elseif (!empty($payload['docx_base64'])) {
            $tempDocxPath = tempnam(sys_get_temp_dir(), 'mcp_docx_') . '.docx';
            file_put_contents($tempDocxPath, base64_decode($payload['docx_base64']));
            $shouldDeleteTemp = true;
        } elseif (!empty($payload['docx_file_path']) && file_exists($payload['docx_file_path'])) {
            $tempDocxPath = $payload['docx_file_path'];
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'docx_file, docx_base64 or valid docx_file_path is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Parse DOCX via ZipArchive
        $zip = new \ZipArchive();
        if ($zip->open($tempDocxPath) !== true) {
            if ($shouldDeleteTemp && file_exists($tempDocxPath)) unlink($tempDocxPath);
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid or unreadable DOCX file.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $xmlData = '';
        if (($xmlIndex = $zip->locateName('word/document.xml')) !== false) {
            $xmlData = $zip->getFromIndex($xmlIndex);
        }
        $zip->close();
        if ($shouldDeleteTemp && file_exists($tempDocxPath)) unlink($tempDocxPath);

        if (empty($xmlData)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'No word/document.xml found in DOCX package.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $dom = new \DOMDocument();
        @$dom->loadXML($xmlData);

        // Extract metadata table if present
        $metadata = [
            'title' => '',
            'slug' => '',
            'category' => '',
            'parent_category' => '',
            'seo_title' => '',
            'seo_description' => '',
            'seo_keywords' => ''
        ];

        $tables = $dom->getElementsByTagName('tbl');
        if ($tables->length > 0) {
            $firstTable = $tables->item(0);
            $rows = $firstTable->getElementsByTagName('tr');
            foreach ($rows as $tr) {
                $cells = $tr->getElementsByTagName('tc');
                if ($cells->length >= 2) {
                    $k = trim($cells->item(0)->textContent);
                    $v = trim($cells->item(1)->textContent);
                    $normKey = strtolower(preg_replace('/[\s\-_:]+/', '_', $k));
                    if ($normKey === 'categories') $normKey = 'category';
                    if ($normKey === 'parent' || $normKey === 'parent_cat') $normKey = 'parent_category';
                    if (array_key_exists($normKey, $metadata) && empty($metadata[$normKey])) {
                        $metadata[$normKey] = $v;
                    }
                }
            }
        }

        // Extract paragraphs and headings
        $paragraphs = $dom->getElementsByTagName('p');
        $rawLines = [];
        $h1Title = '';

        foreach ($paragraphs as $para) {
            $pStyle = '';
            $pStyleNodes = $para->getElementsByTagName('pStyle');
            if ($pStyleNodes->length > 0) {
                $pStyle = $pStyleNodes->item(0)->getAttribute('w:val');
            }
            $text = '';
            $textNodes = $para->getElementsByTagName('t');
            foreach ($textNodes as $t) {
                $text .= $t->nodeValue;
            }
            $tTrim = trim($text);
            if ($tTrim === '') continue;

            $isH1 = stripos($pStyle, 'Heading1') !== false || stripos($pStyle, '1') === 0;
            $isH2 = stripos($pStyle, 'Heading2') !== false || stripos($pStyle, '2') === 0;
            $isH3 = stripos($pStyle, 'Heading3') !== false || stripos($pStyle, '3') === 0;

            if ($isH1 && empty($h1Title)) {
                $h1Title = $tTrim;
            }

            $rawLines[] = [
                'text' => $tTrim,
                'isH1' => $isH1,
                'isH2' => $isH2,
                'isH3' => $isH3
            ];
        }

        if (empty($metadata['title'])) {
            $metadata['title'] = $h1Title ?: ($rawLines[0]['text'] ?? 'Untitled Article');
        }

        // Split into parts by H2
        $parts = [];
        $currentPartTitle = '';
        $currentPartHtml = '';

        foreach ($rawLines as $item) {
            $txt = $item['text'];
            // Skip metadata frontmatter markers
            if ($txt === '---' || preg_match('/^(title|slug|category|parent_category|seo_):/i', $txt)) {
                continue;
            }
            if ($item['isH1'] || $txt === $metadata['title']) {
                continue;
            }

            if ($item['isH2']) {
                if (!empty($currentPartTitle) || !empty($currentPartHtml)) {
                    $parts[] = [
                        'title' => $currentPartTitle,
                        'html' => $currentPartHtml
                    ];
                }
                $currentPartTitle = $txt;
                $currentPartHtml = '';
            } else {
                $escaped = htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
                if ($item['isH3']) {
                    $currentPartHtml .= '<h3>' . $escaped . '</h3>';
                } else {
                    $currentPartHtml .= '<p>' . $escaped . '</p>';
                }
            }
        }

        if (!empty($currentPartTitle) || !empty($currentPartHtml)) {
            $parts[] = [
                'title' => $currentPartTitle,
                'html' => $currentPartHtml
            ];
        }

        // Delegate to createPost
        $postPayload = [
            'title' => $metadata['title'],
            'slug' => $metadata['slug'] ?: $metadata['title'],
            'category' => $metadata['category'],
            'parent_category' => $metadata['parent_category'],
            'seo_title' => $metadata['seo_title'] ?: $metadata['title'],
            'seo_description' => $metadata['seo_description'],
            'seo_keywords' => $metadata['seo_keywords'],
            'parts' => $parts,
            'status' => $payload['status'] ?? 'published'
        ];

        $this->createPost($postPayload);
    }

    private function resolveCategory($targetCategory, $targetParent) {
        $db = \Config\Database::pdoConnect();

        if (empty($targetCategory)) {
            $firstCat = (int)$db->query("SELECT id FROM categories ORDER BY id ASC LIMIT 1")->fetchColumn();
            return $firstCat ?: 1;
        }

        $targetCategory = trim(trim($targetCategory, '"\'“”‘’'));
        $targetParent = trim(trim($targetParent, '"\'“”‘’'));

        // Check if category exists
        $stmt = $db->prepare("SELECT id, name, parent_id FROM categories WHERE LOWER(name) = LOWER(:name) LIMIT 1");
        $stmt->execute(['name' => $targetCategory]);
        $existing = $stmt->fetch(\PDO::FETCH_ASSOC);

        $parentId = null;
        if (!empty($targetParent)) {
            $pStmt = $db->prepare("SELECT id FROM categories WHERE LOWER(name) = LOWER(:pname) LIMIT 1");
            $pStmt->execute(['pname' => $targetParent]);
            $parentId = $pStmt->fetchColumn();
            if (!$parentId) {
                // Auto-create parent
                $pSlug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($targetParent, 'UTF-8')), '-');
                $insP = $db->prepare("INSERT INTO categories (name, slug, parent_id) VALUES (:name, :slug, NULL)");
                $insP->execute(['name' => $targetParent, 'slug' => $pSlug]);
                $parentId = (int)$db->lastInsertId();
            }
        }

        if ($existing) {
            $catId = (int)$existing['id'];
            // If existing category has no parent or wrong parent and targetParent is supplied, update parent
            if ($parentId && (int)$existing['parent_id'] !== (int)$parentId) {
                $upd = $db->prepare("UPDATE categories SET parent_id = :pid WHERE id = :id");
                $upd->execute(['pid' => $parentId, 'id' => $catId]);
            }
            return $catId;
        }

        // Auto-create category
        $cSlug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($targetCategory, 'UTF-8')), '-');
        $ins = $db->prepare("INSERT INTO categories (name, slug, parent_id) VALUES (:name, :slug, :pid)");
        $ins->execute([
            'name' => $targetCategory,
            'slug' => $cSlug,
            'pid' => $parentId ?: null
        ]);

        return (int)$db->lastInsertId();
    }

    private function listCategories($payload) {
        $db = \Config\Database::pdoConnect();
        $cats = $db->query("SELECT c.id, c.name, c.slug, c.parent_id, 
                                   (SELECT COUNT(*) FROM posts WHERE category_id = c.id) AS post_count,
                                   p.name AS parent_name
                            FROM categories c
                            LEFT JOIN categories p ON c.parent_id = p.id
                            ORDER BY c.parent_id ASC, c.name ASC")->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'count' => count($cats),
            'categories' => $cats
        ], JSON_UNESCAPED_UNICODE);
    }

    private function createCategory($payload) {
        $name = trim($payload['name'] ?? '');
        $parentName = trim($payload['parent_name'] ?? '');

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'name is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $id = $this->resolveCategory($name, $parentName);
        \App\Helpers\Cache::clear();

        echo json_encode([
            'status' => 'success',
            'category_id' => $id,
            'name' => $name,
            'parent_name' => $parentName
        ], JSON_UNESCAPED_UNICODE);
    }

    private function listQuestions($payload) {
        $status = strtolower($payload['status'] ?? 'all');
        $limit = max(1, min(2000, (int)($payload['limit'] ?? 10)));
        $query = trim($payload['query'] ?? '');

        $questions = [];
        try {
            $db = \Config\Database::pdoConnect();
            
            // Check user_questions first (primary app table)
            $sql = "SELECT q.id, q.question, q.answer, q.status, q.created_at, q.name as user_name, q.email, c.name as category_name 
                    FROM user_questions q 
                    LEFT JOIN question_categories c ON q.category_id = c.id 
                    WHERE 1=1";
            $params = [];

            if ($status === 'unanswered') {
                $sql .= " AND (q.status = 'pending' OR q.answer IS NULL OR q.answer = '')";
            } elseif ($status === 'answered') {
                $sql .= " AND (q.status = 'answered' AND q.answer IS NOT NULL AND q.answer != '')";
            }

            if (!empty($query)) {
                $sql .= " AND (q.question LIKE :q OR q.answer LIKE :q2)";
                $params['q'] = "%{$query}%";
                $params['q2'] = "%{$query}%";
            }

            $sql .= " ORDER BY q.id DESC LIMIT " . (int)$limit;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $questions = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Fallback to legacy questions table if user_questions had no matching rows
            if (empty($questions)) {
                $this->ensureQuestionsTable($db);
                $sqlLegacy = "SELECT id, question, answer, status, created_at, user_name, email FROM questions WHERE 1=1";
                $legacyParams = [];
                if ($status === 'unanswered') {
                    $sqlLegacy .= " AND (status = 'pending' OR answer IS NULL OR answer = '')";
                } elseif ($status === 'answered') {
                    $sqlLegacy .= " AND (status = 'answered' AND answer IS NOT NULL AND answer != '')";
                }
                if (!empty($query)) {
                    $sqlLegacy .= " AND (question LIKE :q OR answer LIKE :q2)";
                    $legacyParams['q'] = "%{$query}%";
                    $legacyParams['q2'] = "%{$query}%";
                }
                $sqlLegacy .= " ORDER BY id DESC LIMIT " . (int)$limit;
                $stmtLegacy = $db->prepare($sqlLegacy);
                $stmtLegacy->execute($legacyParams);
                $questions = $stmtLegacy->fetchAll(\PDO::FETCH_ASSOC);
            }
        } catch (\Throwable $e) {}

        echo json_encode([
            'status' => 'success',
            'count' => count($questions),
            'questions' => $questions
        ], JSON_UNESCAPED_UNICODE);
    }

    private function ensureQuestionsTable($db) {
        $db->exec("CREATE TABLE IF NOT EXISTS questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question TEXT NOT NULL,
            answer LONGTEXT NULL,
            user_name VARCHAR(255) DEFAULT 'Anonymous',
            email VARCHAR(255) NULL,
            status ENUM('pending', 'answered') DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    private function addQuestion($payload) {
        $question = trim($payload['question'] ?? '');
        $userName = trim($payload['user_name'] ?? $payload['name'] ?? 'Anonymous');
        $email = trim($payload['email'] ?? '');
        $categoryName = trim($payload['category'] ?? $payload['category_name'] ?? '');
        $categoryId = !empty($payload['category_id']) ? (int)$payload['category_id'] : null;
        $answer = trim($payload['answer'] ?? '');
        $status = !empty($answer) ? 'answered' : (trim($payload['status'] ?? 'pending'));

        if (empty($question)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'question is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            $db = \Config\Database::pdoConnect();

            // Resolve or create question category if provided
            if ($categoryId === null && !empty($categoryName)) {
                try {
                    $catStmt = $db->prepare("SELECT id FROM question_categories WHERE name = :cname LIMIT 1");
                    $catStmt->execute(['cname' => $categoryName]);
                    $foundCat = $catStmt->fetch(\PDO::FETCH_ASSOC);
                    if ($foundCat) {
                        $categoryId = (int)$foundCat['id'];
                    } else {
                        $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($categoryName, 'UTF-8')), '-');
                        $insCat = $db->prepare("INSERT INTO question_categories (name, slug) VALUES (:cname, :cslug)");
                        $insCat->execute(['cname' => $categoryName, 'cslug' => $slug]);
                        $categoryId = (int)$db->lastInsertId();
                    }
                } catch (\Throwable $catErr) {}
            }

            $newId = 0;
            $answeredAt = ($status === 'answered') ? date('Y-m-d H:i:s') : null;

            // 1. Insert into primary user_questions table (used by website & admin panel)
            try {
                $stmtUserQ = $db->prepare("INSERT INTO user_questions (name, email, question, answer, category_id, status, answered_at, created_at) 
                                           VALUES (:name, :email, :question, :answer, :category_id, :status, :answered_at, NOW())");
                $stmtUserQ->execute([
                    'name'        => !empty($userName) ? $userName : 'Anonymous',
                    'email'       => !empty($email) ? $email : null,
                    'question'    => $question,
                    'answer'      => !empty($answer) ? $answer : null,
                    'category_id' => $categoryId,
                    'status'      => $status,
                    'answered_at' => $answeredAt
                ]);
                $newId = (int)$db->lastInsertId();
            } catch (\Throwable $uqErr) {}

            // 2. Also keep legacy questions table synchronized
            try {
                $this->ensureQuestionsTable($db);
                $stmtLegacy = $db->prepare("INSERT INTO questions (question, answer, user_name, email, status, created_at, updated_at) 
                                            VALUES (:question, :answer, :user_name, :email, :status, NOW(), NOW())");
                $stmtLegacy->execute([
                    'question'  => $question,
                    'answer'    => !empty($answer) ? $answer : null,
                    'user_name' => $userName,
                    'email'     => !empty($email) ? $email : null,
                    'status'    => $status
                ]);
                if (!$newId) {
                    $newId = (int)$db->lastInsertId();
                }
            } catch (\Throwable $qErr) {}

            // 3. Auto-sync previous rows from questions table to user_questions if missing
            try {
                $db->exec("INSERT INTO user_questions (name, email, question, answer, status, answered_at, created_at)
                           SELECT q.user_name, q.email, q.question, q.answer, q.status, NOW(), q.created_at 
                           FROM questions q 
                           WHERE NOT EXISTS (SELECT 1 FROM user_questions uq WHERE uq.question = q.question)");
            } catch (\Throwable $syncErr) {}

            \App\Helpers\Cache::clear();

            echo json_encode([
                'status' => 'success',
                'message' => 'Question added successfully!',
                'question_id' => $newId,
                'category_id' => $categoryId,
                'status_state' => $status
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function answerQuestion($payload) {
        $id = (int)($payload['question_id'] ?? $payload['id'] ?? 0);
        $answer = trim($payload['answer'] ?? '');

        if (!$id || empty($answer)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'question_id and answer are required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            $db = \Config\Database::pdoConnect();
            
            // Update primary user_questions table
            try {
                $stmt = $db->prepare("UPDATE user_questions SET answer = :ans, status = 'answered', answered_at = NOW() WHERE id = :id");
                $stmt->execute(['ans' => $answer, 'id' => $id]);
            } catch (\Throwable $e1) {}

            // Update legacy questions table
            try {
                $stmt2 = $db->prepare("UPDATE questions SET answer = :ans, status = 'answered', updated_at = NOW() WHERE id = :id");
                $stmt2->execute(['ans' => $answer, 'id' => $id]);
            } catch (\Throwable $e2) {}

            \App\Helpers\Cache::clear();

            echo json_encode([
                'status' => 'success',
                'message' => 'Question answered successfully!',
                'question_id' => $id
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

            echo json_encode([
                'status' => 'success',
                'message' => 'Question answered successfully!',
                'question_id' => $id
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function listComments($payload) {
        $status = strtolower($payload['status'] ?? 'all');
        $limit = max(1, min(2000, (int)($payload['limit'] ?? 10)));

        $comments = [];
        try {
            $db = \Config\Database::pdoConnect();
            $sql = "SELECT c.id, c.post_id, p.title AS post_title, p.slug AS post_slug, 
                           c.name, c.email, c.comment, c.status, c.created_at
                    FROM comments c
                    LEFT JOIN posts p ON c.post_id = p.id
                    WHERE 1=1";
            $params = [];

            if ($status !== 'all') {
                $sql .= " AND c.status = :st";
                $params['st'] = $status;
            }

            $sql .= " ORDER BY c.id DESC LIMIT " . (int)$limit;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {}

        echo json_encode([
            'status' => 'success',
            'count' => count($comments),
            'comments' => $comments
        ], JSON_UNESCAPED_UNICODE);
    }

    private function moderateComment($payload) {
        $id = (int)($payload['comment_id'] ?? $payload['id'] ?? 0);
        $action = strtolower($payload['moderation_action'] ?? $payload['action_type'] ?? 'approve');

        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'comment_id is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            $db = \Config\Database::pdoConnect();
            if ($action === 'delete') {
                $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $msg = 'Comment deleted successfully.';
            } else {
                $status = ($action === 'spam') ? 'spam' : (($action === 'pending') ? 'pending' : 'approved');
                $stmt = $db->prepare("UPDATE comments SET status = :st WHERE id = :id");
                $stmt->execute(['st' => $status, 'id' => $id]);
                $msg = "Comment marked as {$status}.";
            }
            \App\Helpers\Cache::clear();

            echo json_encode(['status' => 'success', 'message' => $msg, 'comment_id' => $id], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function updatePostStatus($payload) {
        $id = (int)($payload['post_id'] ?? $payload['id'] ?? 0);
        $status = strtolower($payload['status'] ?? 'published');

        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'post_id is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $allowed = ['published', 'draft'];
        if (!in_array($status, $allowed)) {
            $status = 'published';
        }

        try {
            $db = \Config\Database::pdoConnect();
            $stmt = $db->prepare("UPDATE posts SET status = :status WHERE id = :id");
            $stmt->execute(['status' => $status, 'id' => $id]);
            \App\Helpers\Cache::clear();

            echo json_encode(['status' => 'success', 'message' => "Post #{$id} status updated to {$status}."], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function deletePost($payload) {
        $id = (int)($payload['post_id'] ?? $payload['id'] ?? 0);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'post_id is required.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            $db = \Config\Database::pdoConnect();
            // Delete relations
            $db->prepare("DELETE FROM post_categories WHERE post_id = :id")->execute(['id' => $id]);
            $db->prepare("DELETE FROM post_authors WHERE post_id = :id")->execute(['id' => $id]);
            $db->prepare("DELETE FROM comments WHERE post_id = :id")->execute(['id' => $id]);
            $db->prepare("DELETE FROM posts WHERE id = :id")->execute(['id' => $id]);
            \App\Helpers\Cache::clear();

            echo json_encode(['status' => 'success', 'message' => "Post #{$id} deleted successfully."], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function clearCache() {
        \App\Helpers\Cache::clear();
        echo json_encode([
            'status' => 'success',
            'message' => 'Website cache cleared successfully!'
        ], JSON_UNESCAPED_UNICODE);
    }

    private function getSettings() {
        $db = \Config\Database::pdoConnect();
        $settings = $db->query("SELECT setting_key, setting_value FROM settings")->fetchAll(\PDO::FETCH_KEY_PAIR);
        // Exclude secret keys from public read
        unset($settings['post_api_key'], $settings['mcp_api_key'], $settings['db_password']);

        echo json_encode([
            'status' => 'success',
            'settings' => $settings
        ], JSON_UNESCAPED_UNICODE);
    }

    private function getSiteStats() {
        $db = \Config\Database::pdoConnect();

        $totalPosts = 0;
        $publishedPosts = 0;
        $totalViews = 0;
        $totalCategories = 0;
        $totalQuestions = 0;
        $unansweredQuestions = 0;
        $totalComments = 0;

        try { $totalPosts = (int)$db->query("SELECT COUNT(*) FROM posts")->fetchColumn(); } catch (\Throwable $e) {}
        try { $publishedPosts = (int)$db->query("SELECT COUNT(*) FROM posts WHERE status = 'published'")->fetchColumn(); } catch (\Throwable $e) {}
        try { $totalViews = (int)$db->query("SELECT SUM(views + fake_views) FROM posts")->fetchColumn(); } catch (\Throwable $e) {}
        try { $totalCategories = (int)$db->query("SELECT COUNT(*) FROM categories")->fetchColumn(); } catch (\Throwable $e) {}
        try { 
            $totalQuestions = (int)$db->query("SELECT COUNT(*) FROM user_questions")->fetchColumn(); 
        } catch (\Throwable $e) {
            try { $totalQuestions = (int)$db->query("SELECT COUNT(*) FROM questions")->fetchColumn(); } catch (\Throwable $e2) {}
        }
        try { 
            $unansweredQuestions = (int)$db->query("SELECT COUNT(*) FROM user_questions WHERE status = 'pending' OR answer IS NULL OR answer = ''")->fetchColumn(); 
        } catch (\Throwable $e) {
            try { $unansweredQuestions = (int)$db->query("SELECT COUNT(*) FROM questions WHERE status = 'pending' OR answer IS NULL OR answer = ''")->fetchColumn(); } catch (\Throwable $e2) {}
        }
        try { $totalComments = (int)$db->query("SELECT COUNT(*) FROM comments")->fetchColumn(); } catch (\Throwable $e) {}

        echo json_encode([
            'status' => 'success',
            'stats' => [
                'total_posts' => $totalPosts,
                'published_posts' => $publishedPosts,
                'total_views' => $totalViews,
                'total_categories' => $totalCategories,
                'total_questions' => $totalQuestions,
                'unanswered_questions' => $unansweredQuestions,
                'total_comments' => $totalComments
            ]
        ], JSON_UNESCAPED_UNICODE);
    }

    private function fastIndex() {
        $db = \Config\Database::pdoConnect();
        $sql = "SELECT p.id, p.title, p.slug, p.seo_keywords, p.status, p.views, p.created_at,
                       c.name AS category_name, pc.name AS parent_category_name
                FROM posts p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN categories pc ON c.parent_id = pc.id
                WHERE p.status = 'published'
                ORDER BY p.created_at DESC, p.id DESC";
        $posts = $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        $baseUrl = rtrim(URLROOT, '/');
        if (strpos($baseUrl, 'localhost') !== false) {
            $baseUrl = 'https://response.nur-lab.com';
        }

        foreach ($posts as &$post) {
            $post['url'] = $baseUrl . '/post/' . $post['slug'];
        }

        echo json_encode([
            'status' => 'success',
            'count' => count($posts),
            'timestamp' => time(),
            'posts' => $posts
        ], JSON_UNESCAPED_UNICODE);
    }

    private function optimizeSearchIndex() {
        $db = \Config\Database::pdoConnect();
        $messages = [];

        try {
            $db->exec("ALTER TABLE posts ADD FULLTEXT INDEX idx_ft_title_keywords (title, seo_keywords)");
            $messages[] = "Created FULLTEXT index on posts (title, seo_keywords)";
        } catch (\Throwable $e) {
            $messages[] = "Index notice: " . $e->getMessage();
        }

        echo json_encode([
            'status' => 'success',
            'messages' => $messages
        ], JSON_UNESCAPED_UNICODE);
    }

    private function resequencePosts() {
        $db = \Config\Database::pdoConnect();

        try {
            $stmt = $db->query("SELECT id, created_at FROM posts ORDER BY id ASC");
            $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($posts)) {
                echo json_encode(['status' => 'success', 'message' => 'কোনো পোস্ট পাওয়া যায়নি।'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $firstTime = !empty($posts[0]['created_at']) ? strtotime($posts[0]['created_at']) : 0;
            if ($firstTime <= 0) {
                $firstTime = strtotime('2026-01-01 00:00:00');
            }

            $upd = $db->prepare("UPDATE posts SET created_at = :cat WHERE id = :id");

            $curr = $firstTime;
            $count = 0;

            foreach ($posts as $p) {
                $curr += 60; // 1 minute increment
                $newDate = date('Y-m-d H:i:s', $curr);
                $upd->execute([
                    'cat' => $newDate,
                    'id' => (int)$p['id']
                ]);
                $count++;
            }

            \App\Helpers\Cache::clear();

            echo json_encode([
                'status' => 'success',
                'count' => $count,
                'message' => "মোট {$count}টি পোস্টের টাইমস্ট্যাম্প ১ মিনিট ব্যবধানে ক্রমানুসারে (ID ASC) সফলভাবে সাজানো হয়েছে!"
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }
}
