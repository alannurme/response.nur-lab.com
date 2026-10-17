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

        // If GET request received, serve interactive tester page or JSON status (Never 404)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
            if (strpos($accept, 'text/html') !== false) {
                $this->renderTesterPage();
                exit;
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => true,
                'status' => 'online',
                'api_name' => 'Nur-Lab Post Creation REST API',
                'endpoint' => URLROOT . '/api/post/create',
                'method' => 'POST',
                'message' => 'Endpoint is active and ready to receive POST requests. To test in browser, visit this URL directly or send a POST request with Content-Type: application/json.',
                'authentication' => [
                    'headers' => ['X-API-KEY: your_api_key', 'Authorization: Bearer your_api_key'],
                    'json_body' => '{"api_key": "your_api_key", ...}'
                ],
                'required_fields' => ['title', 'content'],
                'optional_fields' => ['categories', 'slug', 'status', 'author', 'featured_image', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords'],
                'example_curl' => 'curl -X POST "' . URLROOT . '/api/post/create" -H "Content-Type: application/json" -H "X-API-KEY: YOUR_KEY" -d \'{"title": "Title", "content": "<p>Content</p>"}\''
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'error' => 'Method Not Allowed. Please use HTTP POST.'
            ]);
            exit;
        }

        // 1. Parse Incoming Payload (before auth to support JSON body api_key)
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

        // 2. Authenticate Request
        if (!$this->authenticate($input)) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Unauthorized: Invalid or missing API Key. Provide via X-API-KEY header, Authorization: Bearer <key>, or "api_key" in JSON body.'
            ]);
            exit;
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
     * Supports:
     * - Headers: X-API-KEY, Authorization (Bearer or raw) via getallheaders() or $_SERVER
     * - Payload: api_key, apiKey, token, key in JSON body
     * - Fallback: ?api_key= query parameter or POST param
     */
    protected function authenticate(array $input = []): bool {
        $settings = $this->adminModel->getSettings();
        $storedKey = $settings['post_api_key'] ?? '';

        // If no API Key configured in database yet, auto-generate one
        if (empty($storedKey)) {
            $storedKey = 'nur_' . bin2hex(random_bytes(16));
            $this->adminModel->updateSettings(['post_api_key' => $storedKey]);
        }

        $providedKey = '';

        // 1. Check getallheaders() if available in Apache
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            foreach ($headers as $headerName => $headerValue) {
                $hLower = strtolower($headerName);
                if ($hLower === 'x-api-key' || $hLower === 'api-key') {
                    $providedKey = trim($headerValue);
                    break;
                }
                if ($hLower === 'authorization') {
                    if (preg_match('/Bearer\s+(\S+)/i', $headerValue, $matches)) {
                        $providedKey = trim($matches[1]);
                        break;
                    } elseif (!empty($headerValue) && strpos($headerValue, ' ') === false) {
                        $providedKey = trim($headerValue);
                        break;
                    }
                }
            }
        }

        // 2. Check X-API-KEY in $_SERVER
        if (empty($providedKey)) {
            if (!empty($_SERVER['HTTP_X_API_KEY'])) {
                $providedKey = trim($_SERVER['HTTP_X_API_KEY']);
            } elseif (!empty($_SERVER['X_API_KEY'])) {
                $providedKey = trim($_SERVER['X_API_KEY']);
            }
        }

        // 3. Check Authorization Bearer in $_SERVER
        if (empty($providedKey)) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
            if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
                $providedKey = trim($matches[1]);
            }
        }

        // 4. Check JSON payload body (api_key, apiKey, token, key)
        if (empty($providedKey) && !empty($input)) {
            if (!empty($input['api_key'])) {
                $providedKey = trim((string)$input['api_key']);
            } elseif (!empty($input['apiKey'])) {
                $providedKey = trim((string)$input['apiKey']);
            } elseif (!empty($input['token'])) {
                $providedKey = trim((string)$input['token']);
            } elseif (!empty($input['key'])) {
                $providedKey = trim((string)$input['key']);
            }
        }

        // 5. Check query parameter or POST param as fallback
        if (empty($providedKey)) {
            if (isset($_POST['api_key'])) {
                $providedKey = trim($_POST['api_key']);
            } elseif (isset($_GET['api_key'])) {
                $providedKey = trim($_GET['api_key']);
            }
        }

        if (empty($providedKey)) {
            return false;
        }

        return hash_equals($storedKey, $providedKey);
    }

    /**
     * Render interactive web tester and live documentation for browser visits
     */
    protected function renderTesterPage() {
        $endpoint = URLROOT . '/api/post/create';
        ?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Creation REST API — Interactive Playground & Documentation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #0b0f19;
            --bg-card: #111827;
            --bg-input: #1f2937;
            --border-color: #374151;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.15);
            --accent: #10b981;
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
            --font-sans: 'Inter', 'Hind Siliguri', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-mono: 'Fira Code', monospace;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-sans);
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            padding: 30px 20px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        .header-title h1 {
            font-size: 26px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #a5b4fc 0%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
        }
        .endpoint-banner {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 30px;
            font-family: var(--font-mono);
            font-size: 14px;
            flex-wrap: wrap;
        }
        .method-pill {
            background: #4338ca;
            color: #ffffff;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .endpoint-url {
            color: #e0e7ff;
            word-break: break-all;
            flex: 1;
        }
        .btn-copy-url {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-copy-url:hover {
            background: #374151;
            border-color: #4b5563;
        }
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 40px;
        }
        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
        }
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }
        .card-header h2 {
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 6px;
        }
        .form-label .req {
            color: #ef4444;
            font-size: 11px;
            font-weight: 700;
        }
        .form-label .opt {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
        }
        .input-wrapper {
            position: relative;
        }
        .form-control {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }
        .toggle-pwd {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
        }
        .toggle-pwd:hover { color: #ffffff; }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
            font-family: var(--font-mono);
            font-size: 13px;
        }
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .response-console {
            background: #080c14;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 16px;
            min-height: 380px;
            max-height: 520px;
            overflow-y: auto;
            font-family: var(--font-mono);
            font-size: 13px;
            color: #e2e8f0;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .response-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #1e293b;
            font-size: 12px;
        }
        .status-pill {
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
        }
        .status-pill.s-200 { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .status-pill.s-400 { background: rgba(239, 68, 68, 0.2); color: #f87171; }
        .docs-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
        }
        .tabs {
            display: flex;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        .tab-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .tab-btn.active {
            color: #ffffff;
            border-bottom-color: var(--primary);
        }
        .code-box {
            position: relative;
            background: #080c14;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 16px;
            font-family: var(--font-mono);
            font-size: 13px;
            color: #93c5fd;
            overflow-x: auto;
            white-space: pre;
        }
        .copy-snippet-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #1e293b;
            border: 1px solid #334155;
            color: #cbd5e1;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .copy-snippet-btn:hover { background: #334155; color: #ffffff; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-bar">
            <div class="header-title">
                <h1><i class="fas fa-network-wired" style="color: #6366f1;"></i> Nur-Lab Post Creation REST API</h1>
            </div>
            <div class="status-badge">
                <span class="status-dot"></span>
                API Endpoint Active (HTTP POST Ready)
            </div>
        </div>

        <!-- Endpoint Banner -->
        <div class="endpoint-banner">
            <span class="method-pill">POST</span>
            <span class="endpoint-url" id="endpointDisplay"><?= htmlspecialchars($endpoint) ?></span>
            <button type="button" class="btn-copy-url" onclick="copyEndpoint()">
                <i class="far fa-copy"></i> <span id="copyUrlText">Copy URL</span>
            </button>
        </div>

        <!-- Playground Grid -->
        <div class="main-grid">
            <!-- Left: Interactive Tester -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-vial" style="color: #6366f1;"></i> Interactive API Tester</h2>
                    <span style="font-size: 12px; color: var(--text-muted);">Test directly from browser</span>
                </div>

                <form id="apiTesterForm" onsubmit="executeTestPost(event)">
                    <div class="form-group">
                        <label class="form-label">
                            <span>Secret API Key</span>
                            <span class="req">REQUIRED</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="password" id="inputApiKey" class="form-control" placeholder="nur_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                            <button type="button" class="toggle-pwd" onclick="togglePlaygroundKey()">
                                <i class="far fa-eye" id="pwdEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span>Post Title</span>
                            <span class="req">REQUIRED</span>
                        </label>
                        <input type="text" id="inputTitle" class="form-control" placeholder="আপনার পোস্টের আকর্ষণীয় শিরোনাম..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span>Categories (কমা দিয়ে একাধিক)</span>
                            <span class="opt">OPTIONAL</span>
                        </label>
                        <input type="text" id="inputCategories" class="form-control" placeholder="বিজ্ঞান ও দর্শন, কুরআন সম্পর্কিত">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span>Post Status</span>
                            <span class="opt">OPTIONAL</span>
                        </label>
                        <select id="inputStatus" class="form-control">
                            <option value="published" selected>Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span>Post Content (HTML or Text)</span>
                            <span class="req">REQUIRED</span>
                        </label>
                        <textarea id="inputContent" class="form-control" placeholder="<h2>ভূমিকা</h2><p>এখানে বিস্তারিত লিখুন...</p>" required></textarea>
                    </div>

                    <button type="submit" id="submitBtn" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Send POST Request
                    </button>
                </form>
            </div>

            <!-- Right: Live Response Console -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-terminal" style="color: #10b981;"></i> Response Console</h2>
                    <span id="responseStatusBadge" style="font-size: 12px; color: var(--text-muted);">Idle</span>
                </div>

                <div class="response-console" id="responseConsole">
// Welcome to the Nur-Lab Post Creation API Playground!
// Enter your API Key and Post details on the left, then click "Send POST Request".
//
// The live JSON response and created post URL will be rendered here.
// You can also use cURL, Python, or external automation tools shown below.
                </div>
            </div>
        </div>

        <!-- Documentation & Snippets -->
        <div class="docs-card">
            <div class="tabs">
                <button type="button" class="tab-btn active" onclick="switchSnippet('curl', this)">cURL (Terminal)</button>
                <button type="button" class="tab-btn" onclick="switchSnippet('python', this)">Python (requests)</button>
                <button type="button" class="tab-btn" onclick="switchSnippet('js', this)">JavaScript (fetch)</button>
            </div>

            <div id="snippetContainer" style="position: relative;">
                <button type="button" class="copy-snippet-btn" onclick="copyCurrentSnippet(this)">
                    <i class="far fa-copy"></i> Copy Code
                </button>
                <div class="code-box" id="activeCodeBox"></div>
            </div>
        </div>
    </div>

    <script>
        const ENDPOINT = <?= json_encode($endpoint) ?>;
        let currentTab = 'curl';

        // Load saved key from localStorage if available
        document.addEventListener('DOMContentLoaded', () => {
            const savedKey = localStorage.getItem('nur_api_key');
            if (savedKey) {
                document.getElementById('inputApiKey').value = savedKey;
            }
            renderSnippet();
            
            // Listen for key changes to update snippets
            document.getElementById('inputApiKey').addEventListener('input', (e) => {
                localStorage.setItem('nur_api_key', e.target.value.trim());
                renderSnippet();
            });
        });

        function togglePlaygroundKey() {
            const input = document.getElementById('inputApiKey');
            const icon = document.getElementById('pwdEyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'far fa-eye';
            }
        }

        function copyEndpoint() {
            navigator.clipboard.writeText(ENDPOINT).then(() => {
                const text = document.getElementById('copyUrlText');
                text.textContent = 'Copied!';
                setTimeout(() => { text.textContent = 'Copy URL'; }, 2000);
            });
        }

        function switchSnippet(tab, btn) {
            currentTab = tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
            renderSnippet();
        }

        function getActiveKey() {
            const val = document.getElementById('inputApiKey').value.trim();
            return val ? val : 'YOUR_API_KEY';
        }

        function renderSnippet() {
            const key = getActiveKey();
            const codeBox = document.getElementById('activeCodeBox');
            if (currentTab === 'curl') {
                codeBox.textContent = `curl -X POST "${ENDPOINT}" \\
  -H "Content-Type: application/json" \\
  -H "X-API-KEY: ${key}" \\
  -d '{
    "title": "আপনার পোস্টের শিরোনাম",
    "content": "<h2>ভূমিকা</h2><p>এখানে বিস্তারিত লিখুন...</p>",
    "categories": ["কুরআন সম্পর্কিত", "বিজ্ঞান ও দর্শন"],
    "status": "published"
  }'`;
            } else if (currentTab === 'python') {
                codeBox.textContent = `import requests

url = "${ENDPOINT}"
headers = {
    "Content-Type": "application/json",
    "X-API-KEY": "${key}"
}
payload = {
    "title": "আপনার পোস্টের শিরোনাম",
    "content": "<h2>ভূমিকা</h2><p>এখানে বিস্তারিত লিখুন...</p>",
    "categories": ["কুরআন সম্পর্কিত", "বিজ্ঞান ও দর্শন"],
    "status": "published"
}

response = requests.post(url, json=payload, headers=headers)
print("Status:", response.status_code)
print("Response:", response.json())`;
            } else if (currentTab === 'js') {
                codeBox.textContent = `fetch("${ENDPOINT}", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "X-API-KEY": "${key}"
  },
  body: JSON.stringify({
    title: "আপনার পোস্টের শিরোনাম",
    content: "<h2>ভূমিকা</h2><p>এখানে বিস্তারিত লিখুন...</p>",
    categories: ["কুরআন সম্পর্কিত", "বিজ্ঞান ও দর্শন"],
    status: "published"
  })
})
.then(res => res.json())
.then(data => console.log(data))
.catch(err => console.error(err));`;
            }
        }

        function copyCurrentSnippet(btn) {
            const code = document.getElementById('activeCodeBox').textContent;
            navigator.clipboard.writeText(code).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check" style="color: #34d399;"></i> Copied!';
                setTimeout(() => { btn.innerHTML = orig; }, 2000);
            });
        }

        function executeTestPost(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const consoleBox = document.getElementById('responseConsole');
            const statusBadge = document.getElementById('responseStatusBadge');

            const key = document.getElementById('inputApiKey').value.trim();
            const title = document.getElementById('inputTitle').value.trim();
            const rawCats = document.getElementById('inputCategories').value.trim();
            const status = document.getElementById('inputStatus').value;
            const content = document.getElementById('inputContent').value.trim();

            const categories = rawCats ? rawCats.split(',').map(s => s.trim()).filter(Boolean) : [];

            const payload = {
                title: title,
                content: content,
                categories: categories,
                status: status
            };

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting Request...';
            statusBadge.innerHTML = '<span style="color: #f59e0b;">Sending...</span>';
            consoleBox.textContent = '>> Sending HTTP POST request to ' + ENDPOINT + '...\n\nPayload:\n' + JSON.stringify(payload, null, 2);

            const startTime = performance.now();

            fetch(ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-API-KEY': key
                },
                body: JSON.stringify(payload)
            })
            .then(async res => {
                const duration = Math.round(performance.now() - startTime);
                const isJson = (res.headers.get('content-type') || '').includes('application/json');
                const data = isJson ? await res.json() : await res.text();

                if (res.ok) {
                    statusBadge.innerHTML = `<span class="status-pill s-200">HTTP ${res.status} OK (${duration}ms)</span>`;
                } else {
                    statusBadge.innerHTML = `<span class="status-pill s-400">HTTP ${res.status} Error (${duration}ms)</span>`;
                }

                let outputText = `>> HTTP Status: ${res.status} ${res.statusText} (${duration}ms)\n\n`;
                if (typeof data === 'object') {
                    outputText += JSON.stringify(data, null, 2);
                    if (data.data && data.data.url) {
                        outputText += `\n\n🎉 Success! View your live post at:\n${data.data.url}`;
                    }
                } else {
                    outputText += data;
                }
                consoleBox.textContent = outputText;
            })
            .catch(err => {
                statusBadge.innerHTML = `<span class="status-pill s-400">Network Error</span>`;
                consoleBox.textContent = '>> Network / Fetch Error:\n' + err.message;
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send POST Request';
            });
        }
    </script>
</body>
</html>
        <?php
        exit;
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
