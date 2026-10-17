<?php
namespace App\Controllers;

use App\Core\Controller;

class Api extends Controller {
    protected $adminModel;
    protected $postModel;

    public function __construct() {
        $this->adminModel = $this->model('AdminModel');
        $this->postModel = $this->model('PostModel');
    }

    /**
     * Handle OPTIONS preflight requests for CORS
     */
    public function options() {
        $this->sendCorsHeaders();
        http_response_code(200);
        exit;
    }

    /**
     * API Information / Ping endpoint
     */
    public function info() {
        $this->sendCorsHeaders();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'api_name' => 'Nur-Lab Post Creation REST API',
            'version' => '1.0',
            'endpoint' => URLROOT . '/api/post/create',
            'method' => 'POST',
            'auth' => 'X-API-KEY header or Bearer Token',
            'supported_fields' => [
                'title' => 'required (string)',
                'content' => 'required (HTML or text string)',
                'slug' => 'optional (string, auto-generated if omitted)',
                'excerpt' => 'optional (string, auto-generated if omitted)',
                'featured_image' => 'optional (URL or file path string)',
                'categories' => 'optional (array of category names or IDs, e.g. ["Quran", "Science"])',
                'author' => 'optional (author name or ID, e.g. "Admin")',
                'status' => 'optional ("published" or "draft", default: "published")',
                'created_at' => 'optional (datetime string, default: current time)',
                'seo_title' => 'optional (string)',
                'seo_description' => 'optional (string)',
                'seo_keywords' => 'optional (comma-separated string)',
                'schema_data' => 'optional (JSON-LD string or object)'
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Create Post via REST API
     */
    public function create_post() {
        $this->sendCorsHeaders();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'error' => 'Method Not Allowed. Please use HTTP POST.'
            ]);
            exit;
        }

        // 1. Authenticate Request
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Unauthorized: Invalid or missing API Key. Pass your key via the X-API-KEY header.'
            ]);
            exit;
        }

        // 2. Parse Incoming Payload
        $rawInput = file_get_contents('php://input');
        $input = [];

        if (!empty($rawInput)) {
            $jsonParsed = json_decode($rawInput, true);
            if (is_array($jsonParsed)) {
                $input = $jsonParsed;
            }
        }

        // Fallback to form post if JSON was not provided
        if (empty($input) && !empty($_POST)) {
            $input = $_POST;
        }

        // Handle case where post data is wrapped in a 'post' key
        if (isset($input['post']) && is_array($input['post'])) {
            $input = array_merge($input['post'], $input);
        }

        // 3. Validate Required Fields
        $title = isset($input['title']) ? trim((string)$input['title']) : '';
        $content = isset($input['content']) ? trim((string)$input['content']) : '';

        if (empty($title)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'error' => 'Validation error: The "title" field is required.'
            ]);
            exit;
        }

        if (empty($content)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'error' => 'Validation error: The "content" field is required.'
            ]);
            exit;
        }

        // 4. Resolve Categories
        $resolvedCategoryIds = $this->resolveCategories($input);

        // 5. Resolve Authors
        $resolvedAuthorIds = $this->resolveAuthors($input);

        // 6. Generate / Sanitize Slug
        $customSlug = isset($input['slug']) ? trim((string)$input['slug']) : '';
        $slugBase = !empty($customSlug) ? $customSlug : $title;
        $cleanSlug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($slugBase, 'UTF-8')), '-');
        if (empty($cleanSlug)) {
            $cleanSlug = 'post-' . time();
        }

        // 7. Schema Data formatting
        $schemaData = null;
        if (isset($input['schema_data'])) {
            if (is_array($input['schema_data'])) {
                $schemaData = json_encode($input['schema_data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            } else {
                $schemaData = trim((string)$input['schema_data']);
            }
        }

        // 8. Prepare Post Data Array
        $status = isset($input['status']) && in_array(strtolower($input['status']), ['draft', 'pending', 'published'])
            ? strtolower($input['status'])
            : 'published';

        $createdAt = !empty($input['created_at'])
            ? date('Y-m-d H:i:s', strtotime($input['created_at']))
            : date('Y-m-d H:i:s');

        $excerpt = isset($input['excerpt']) ? trim((string)$input['excerpt']) : '';
        if (empty($excerpt)) {
            $plainText = strip_tags($content);
            $excerpt = mb_substr($plainText, 0, 180, 'UTF-8') . (mb_strlen($plainText, 'UTF-8') > 180 ? '...' : '');
        }

        $postData = [
            'category_ids' => $resolvedCategoryIds,
            'author_ids' => $resolvedAuthorIds,
            'title' => $title,
            'slug' => $cleanSlug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => isset($input['featured_image']) ? trim((string)$input['featured_image']) : '',
            'post_type' => 'blog',
            'fake_views' => isset($input['fake_views']) ? (int)$input['fake_views'] : 0,
            'status' => $status,
            'created_at' => $createdAt,
            'views' => isset($input['views']) ? (int)$input['views'] : 0,
            'seo_title' => isset($input['seo_title']) ? trim((string)$input['seo_title']) : null,
            'seo_description' => isset($input['seo_description']) ? trim((string)$input['seo_description']) : null,
            'seo_keywords' => isset($input['seo_keywords']) ? trim((string)$input['seo_keywords']) : null,
            'schema_data' => !empty($schemaData) ? $schemaData : null
        ];

        // 9. Insert Post into Database
        try {
            $postId = $this->adminModel->createPost($postData);

            if ($postId) {
                $createdPost = $this->postModel->getPostById((int)$postId);
                $finalSlug = $createdPost['slug'] ?? $cleanSlug;
                $finalUrl = URLROOT . '/' . $finalSlug;

                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'Post created successfully!',
                    'data' => [
                        'post_id' => (int)$postId,
                        'title' => $createdPost['title'] ?? $title,
                        'slug' => $finalSlug,
                        'status' => $createdPost['status'] ?? $status,
                        'url' => $finalUrl,
                        'created_at' => $createdPost['created_at'] ?? $createdAt
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to save post in database.'
                ]);
                exit;
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Server error while creating post: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Authenticate incoming request using Secret API Key
     */
    protected function authenticate(): bool {
        $settings = $this->adminModel->getSettings();
        $storedKey = $settings['post_api_key'] ?? '';

        // If no API Key configured in database yet, auto-generate one
        if (empty($storedKey)) {
            $storedKey = 'nur_' . bin2hex(random_bytes(16));
            $this->adminModel->updateSettings(['post_api_key' => $storedKey]);
        }

        $providedKey = '';

        // Check X-API-KEY header
        if (!empty($_SERVER['HTTP_X_API_KEY'])) {
            $providedKey = trim($_SERVER['HTTP_X_API_KEY']);
        } elseif (!empty($_SERVER['X_API_KEY'])) {
            $providedKey = trim($_SERVER['X_API_KEY']);
        }

        // Check Authorization Bearer header
        if (empty($providedKey)) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
            if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
                $providedKey = trim($matches[1]);
            }
        }

        // Check query parameter or POST param as fallback
        if (empty($providedKey)) {
            if (isset($_GET['api_key'])) {
                $providedKey = trim($_GET['api_key']);
            } elseif (isset($_POST['api_key'])) {
                $providedKey = trim($_POST['api_key']);
            }
        }

        if (empty($providedKey)) {
            return false;
        }

        return hash_equals($storedKey, $providedKey);
    }

    /**
     * Resolve category IDs from inputs (supports category names or IDs)
     */
    protected function resolveCategories(array $input): array {
        $categoriesInput = $input['categories'] ?? $input['category_ids'] ?? $input['category_names'] ?? $input['category'] ?? [];
        if (!is_array($categoriesInput)) {
            $categoriesInput = [$categoriesInput];
        }

        $allCategories = $this->adminModel->getCategories() ?: [];
        $nameToIdMap = [];
        $validIds = [];

        foreach ($allCategories as $cat) {
            $id = (int)$cat['id'];
            $validIds[] = $id;
            $nameToIdMap[mb_strtolower(trim($cat['name']), 'UTF-8')] = $id;
            if (!empty($cat['slug'])) {
                $nameToIdMap[mb_strtolower(trim($cat['slug']), 'UTF-8')] = $id;
            }
        }

        $matchedIds = [];
        foreach ($categoriesInput as $item) {
            if (is_numeric($item)) {
                $intId = (int)$item;
                if (in_array($intId, $validIds) && !in_array($intId, $matchedIds)) {
                    $matchedIds[] = $intId;
                }
            } elseif (is_string($item)) {
                $cleanName = mb_strtolower(trim($item), 'UTF-8');
                if (isset($nameToIdMap[$cleanName]) && !in_array($nameToIdMap[$cleanName], $matchedIds)) {
                    $matchedIds[] = $nameToIdMap[$cleanName];
                }
            }
        }

        // Handle main category preference if specified
        if (!empty($input['main_category'])) {
            $mainItem = $input['main_category'];
            $mainId = null;
            if (is_numeric($mainItem)) {
                $mainId = (int)$mainItem;
            } elseif (is_string($mainItem)) {
                $cleanMain = mb_strtolower(trim($mainItem), 'UTF-8');
                if (isset($nameToIdMap[$cleanMain])) {
                    $mainId = $nameToIdMap[$cleanMain];
                }
            }
            if ($mainId && in_array($mainId, $validIds)) {
                $matchedIds = array_diff($matchedIds, [$mainId]);
                array_unshift($matchedIds, $mainId);
            }
        }

        // If no category matched, fallback to first category in DB
        if (empty($matchedIds) && !empty($allCategories)) {
            $matchedIds[] = (int)$allCategories[0]['id'];
        }

        return array_values($matchedIds);
    }

    /**
     * Resolve author IDs from inputs (supports author names or IDs)
     */
    protected function resolveAuthors(array $input): array {
        $authorInput = $input['author'] ?? $input['authors'] ?? $input['author_ids'] ?? $input['author_names'] ?? [];
        if (!is_array($authorInput)) {
            $authorInput = [$authorInput];
        }

        $allAuthors = $this->adminModel->getAuthors() ?: [];
        $nameToIdMap = [];
        $validIds = [];

        foreach ($allAuthors as $auth) {
            $id = (int)$auth['id'];
            $validIds[] = $id;
            $nameToIdMap[mb_strtolower(trim($auth['name']), 'UTF-8')] = $id;
        }

        $matchedIds = [];
        foreach ($authorInput as $item) {
            if (is_numeric($item)) {
                $intId = (int)$item;
                if (in_array($intId, $validIds) && !in_array($intId, $matchedIds)) {
                    $matchedIds[] = $intId;
                }
            } elseif (is_string($item)) {
                $cleanName = mb_strtolower(trim($item), 'UTF-8');
                if (isset($nameToIdMap[$cleanName]) && !in_array($nameToIdMap[$cleanName], $matchedIds)) {
                    $matchedIds[] = $nameToIdMap[$cleanName];
                } else {
                    // Partial match fallback
                    foreach ($nameToIdMap as $existingName => $existingId) {
                        if (strpos($existingName, $cleanName) !== false || strpos($cleanName, $existingName) !== false) {
                            if (!in_array($existingId, $matchedIds)) {
                                $matchedIds[] = $existingId;
                                break;
                            }
                        }
                    }
                }
            }
        }

        // If no author matched, fallback to Admin or first author
        if (empty($matchedIds)) {
            if (isset($nameToIdMap['admin'])) {
                $matchedIds[] = $nameToIdMap['admin'];
            } elseif (!empty($allAuthors)) {
                $matchedIds[] = (int)$allAuthors[0]['id'];
            }
        }

        return array_values($matchedIds);
    }

    /**
     * Send standard CORS headers
     */
    protected function sendCorsHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-API-KEY, Authorization, X-Requested-With');
        header('Access-Control-Max-Age: 86400');
    }
}
