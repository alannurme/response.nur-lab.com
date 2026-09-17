<?php
namespace App\Controllers;
use App\Core\Controller;

class Admin extends Controller {
    protected $adminModel;
    protected $siteSettings;

    public function __construct() {
        service('session');

        $uri = service('request')->getUri()->getPath();
        $isLoginRoute = (strpos($uri, 'login') !== false || (isset($_GET['url']) && strpos($_GET['url'], 'login') !== false));

        if (!$isLoginRoute && empty($_SESSION['admin_id'])) {
            header('Location: ' . base_url('admin/login'));
            exit;
        }

        $this->adminModel = $this->model('AdminModel');
        $this->siteSettings = $this->adminModel->getSettings();
    }

    public function proxy_tts() {
        $text = isset($_GET['text']) ? trim($_GET['text']) : '';
        if (empty($text)) {
            header("HTTP/1.1 400 Bad Request");
            exit("Text is required");
        }
        
        $lang = isset($_GET['lang']) ? trim($_GET['lang']) : 'bn';
        
        $url = "https://translate.google.com/translate_tts?ie=UTF-8&tl=" . urlencode($lang) . "&client=tw-ob&q=" . urlencode($text);
        
        $audio = false;

        // Try cURL first with SSL verification disabled for local XAMPP/localhost support
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $audio = curl_exec($ch);
            curl_close($ch);
        }

        if ($audio === false) {
            $options = [
                "http" => [
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36\r\n"
                ]
            ];
            $context = stream_context_create($options);
            $audio = @file_get_contents($url, false, $context);
        }

        if ($audio === false) {
            header("HTTP/1.1 500 Internal Server Error");
            exit("Failed to retrieve audio from TTS engine");
        }
        
        header("Content-Type: audio/mpeg");
        header("Content-Length: " . strlen($audio));
        echo $audio;
        exit;
    }

    public function index() {
        $postModel = $this->model('PostModel');
        $adminModel = $this->model('AdminModel');
        
        $posts = $postModel->getAllPosts(5); // Show only last 5 on dashboard
        $stats = $adminModel->getStats();
        $chartData = $adminModel->getChartData();
        
        // Fetch pending comments (limit to 5)
        $allComments = $adminModel->getComments();
        $pendingComments = array_slice(array_filter($allComments, function($c) {
            return $c['status'] === 'pending';
        }), 0, 5);

        // Fetch unread messages (limit to 5)
        $allMessages = $adminModel->getMessages();
        $unreadMessages = array_slice(array_filter($allMessages, function($m) {
            return $m['status'] === 'unread';
        }), 0, 5);

        // Fetch unanswered questions (limit to 5)
        $unansweredQuestions = $adminModel->getUserQuestions(5, 'pending');

        // Fetch orders stats (E-commerce disabled)
        $totalSales = 0;
        $pendingOrdersCount = 0;
        $recentOrders = [];

        // Fetch donations stats
        $donations = $adminModel->getDonations();
        $totalDonationsAmount = 0;
        $pendingDonationsCount = 0;
        foreach ($donations as $donation) {
            if ($donation['status'] === 'completed') {
                $totalDonationsAmount += $donation['amount'];
            }
            if ($donation['status'] === 'pending') {
                $pendingDonationsCount++;
            }
        }
        $recentDonations = array_slice($donations, 0, 5);

        // Fetch subscribers
        $subscribers = $adminModel->getSubscribers();
        $totalSubscribersCount = count($subscribers);

        // Fetch pending questions & guest answers counts
        $pendingQuestionsCount = count($adminModel->getUserQuestions(null, 'pending'));
        $pendingGuestAnswersCount = count($adminModel->getAllAnswers('pending'));

        // Top viewed posts
        $topPosts = $adminModel->getTopPosts(5);
        $leastViewedPosts = $adminModel->getLeastViewedPosts(5);

        // Draft posts count
        $draftPostsCount = $adminModel->getDraftPostsCount();

        // Category distribution for donut chart
        $categoryDistribution = $adminModel->getCategoryDistribution();

        // Monthly posts chart (12 months)
        $monthlyChartData = $adminModel->getMonthlyPostsChart();

        // Content health check
        $contentHealth = $adminModel->getContentHealth();

        // Recent subscribers
        $recentSubscribers = $adminModel->getRecentSubscribers(5);

        // Media stats
        $mediaStats = $adminModel->getMediaStats();

        // Server info
        $projectPath = dirname(APPROOT);
        $serverInfo = [
            'php_version'  => PHP_VERSION,
            'disk_total'   => function_exists('disk_total_space') ? @disk_total_space($projectPath) : 0,
            'disk_free'    => function_exists('disk_free_space') ? @disk_free_space($projectPath) : 0,
            'memory_limit' => ini_get('memory_limit'),
            'upload_max'   => ini_get('upload_max_filesize'),
        ];

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'posts' => $posts,
            'stats' => $stats,
            'chartData' => $chartData,
            'top_posts' => $topPosts,
            'least_viewed_posts' => $leastViewedPosts,
            'draft_posts_count' => $draftPostsCount,
            'category_distribution' => $categoryDistribution,
            'monthly_chart' => $monthlyChartData,
            'content_health' => $contentHealth,
            'recent_subscribers' => $recentSubscribers,
            'media_stats' => $mediaStats,
            'server_info' => $serverInfo,
            'pending_comments' => $pendingComments,
            'unread_messages' => $unreadMessages,
            'unanswered_questions' => $unansweredQuestions,
            'total_sales' => $totalSales,
            'pending_orders_count' => $pendingOrdersCount,
            'recent_orders' => $recentOrders,
            'total_donations_amount' => $totalDonationsAmount,
            'pending_donations_count' => $pendingDonationsCount,
            'recent_donations' => $recentDonations,
            'total_subscribers_count' => $totalSubscribersCount,
            'pending_questions_count' => $pendingQuestionsCount,
            'pending_guest_answers_count' => $pendingGuestAnswersCount,
            'current_page' => 'dashboard',
            'settings' => $this->siteSettings
        ]);
    }

    public function get_post_ajax($id) {
        header('Content-Type: application/json; charset=utf-8');
        $postModel = $this->model('PostModel');
        $post = $postModel->getPostById($id);
        if ($post) {
            $data = [
                'success' => true,
                'id' => $post['id'],
                'title' => $post['title'] ?? '',
                'content' => $post['content'] ?? '',
                'image' => !empty($post['featured_image']) ? URLROOT . '/' . $post['featured_image'] : '',
                'created_at' => !empty($post['created_at']) ? date('Y/m/d', strtotime($post['created_at'])) : '',
                'status' => $post['status'] ?? 'published',
                'slug' => $post['slug'] ?? ''
            ];
            
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
            if ($json === false) {
                echo json_encode([
                    'success' => false,
                    'error' => 'JSON encoding failed: ' . json_last_error_msg()
                ]);
            } else {
                echo $json;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Post not found']);
        }
        exit;
    }

    public function get_folder_posts_ajax($category_id) {
        header('Content-Type: application/json; charset=utf-8');
        $db = \Config\Database::pdoConnect();
        $stmt = $db->prepare("SELECT p.id, p.title, p.status, p.slug 
                              FROM posts p 
                              LEFT JOIN post_categories pc ON p.id = pc.post_id 
                              WHERE p.category_id = :cat_id OR pc.category_id = :cat_id 
                              GROUP BY p.id 
                              ORDER BY p.title ASC");
        $stmt->execute(['cat_id' => (int)$category_id]);
        $posts = $stmt->fetchAll();
        echo json_encode([
            'success' => true,
            'posts' => $posts
        ]);
        exit;
    }

    public function posts() {
        $postModel = $this->model('PostModel');
        $adminModel = $this->model('AdminModel');
        
        $categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int)$_GET['category_id'] : null;
        
        $allCategories = $adminModel->getCategories();
        
        // Find current category info if not root
        $currentCategory = null;
        if ($categoryId !== null) {
            foreach ($allCategories as $cat) {
                if ((int)$cat['id'] === $categoryId) {
                    $currentCategory = $cat;
                    break;
                }
            }
            if (!$currentCategory) {
                header('Location: ' . URLROOT . '/admin/posts');
                exit;
            }
        }
        
        // Filter subfolders (categories where parent_id matches current categoryId)
        $subFolders = array_filter($allCategories, function($cat) use ($categoryId) {
            if ($categoryId === null) {
                return $cat['parent_id'] === null || $cat['parent_id'] == 0;
            }
            return (int)$cat['parent_id'] === $categoryId;
        });
        
        // Build breadcrumbs
        $breadcrumbs = [];
        $tempId = $categoryId;
        while ($tempId !== null) {
            $found = false;
            foreach ($allCategories as $c) {
                if ((int)$c['id'] === $tempId) {
                    array_unshift($breadcrumbs, $c);
                    $tempId = $c['parent_id'] ? (int)$c['parent_id'] : null;
                    $found = true;
                    break;
                }
            }
            if (!$found) break;
        }
        
        // Pagination logic
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $showMode = 'all';
        if (isset($_GET['show_mode'])) {
            $showMode = $_GET['show_mode'] === 'primary' ? 'primary' : 'all';
            setcookie('show_mode', $showMode, time() + (86400 * 30), "/");
        } elseif (isset($_COOKIE['show_mode'])) {
            $showMode = $_COOKIE['show_mode'] === 'primary' ? 'primary' : 'all';
        }
        
        // Fetch posts inside this folder
        $posts = $postModel->getPostsByCategoryForAdmin($categoryId, $limit, $offset, $showMode);
        
        // Get total counts
        $totalCount = $postModel->getPostsCountByCategoryForAdmin($categoryId, $showMode);
        $totalPages = ceil($totalCount / $limit);
        
        // Fetch posts only for the active folder tree branch to populate the tree on load
        $allPosts = [];
        if ($categoryId !== null) {
            $db = \Config\Database::pdoConnect();
            $stmt_all = $db->prepare("SELECT p.id, p.title, p.status, p.slug, p.category_id 
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    WHERE p.category_id = :cat_id OR pc.category_id = :cat_id
                                    GROUP BY p.id
                                    ORDER BY p.title ASC");
            $stmt_all->execute(['cat_id' => $categoryId]);
            $allPosts = $stmt_all->fetchAll();
            foreach ($allPosts as &$p) {
                $p['category_id'] = $categoryId;
            }
        }

        // Fetch categories that contain posts to know if we should show chevron toggles
        $db = \Config\Database::pdoConnect();
        $stmt_cats_with_posts = $db->query("
            SELECT category_id FROM posts WHERE category_id IS NOT NULL
            UNION
            SELECT category_id FROM post_categories
        ");
        $catsWithPosts = $stmt_cats_with_posts->fetchAll(\PDO::FETCH_COLUMN);

        $this->view('admin/posts', [
            'title' => $currentCategory ? htmlspecialchars($currentCategory['name']) : 'All Posts (Root)',
            'posts' => $posts,
            'subFolders' => $subFolders,
            'breadcrumbs' => $breadcrumbs,
            'categoryId' => $categoryId,
            'currentCategory' => $currentCategory,
            'allCategories' => $allCategories,
            'allPosts' => $allPosts,
            'catsWithPosts' => $catsWithPosts,
            'current_page' => 'posts',
            'currentPageNum' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'showMode' => $showMode,
            'settings' => $this->siteSettings
        ]);
    }

    public function add_folder() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            if ($name !== '') {
                $adminModel->addCategory($name, $parent_id);
            }
            $redirectUrl = URLROOT . '/admin/posts' . ($parent_id !== null ? '?category_id=' . $parent_id : '');
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public function rename_folder() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = trim($_POST['name'] ?? '');
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            if ($name !== '') {
                $adminModel->updateCategory($id, $name, $parent_id);
            }
            $redirectUrl = URLROOT . '/admin/posts' . ($parent_id !== null ? '?category_id=' . $parent_id : '');
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public function delete_folder($id = null) {
        $adminModel = $this->model('AdminModel');
        $id = $id !== null ? (int)$id : (isset($_GET['id']) ? (int)$_GET['id'] : null);
        $parent_id = isset($_GET['parent_id']) && $_GET['parent_id'] !== '' ? (int)$_GET['parent_id'] : null;
        
        if ($id !== null) {
            $adminModel->deleteCategory($id);
        }
        $redirectUrl = URLROOT . '/admin/posts' . ($parent_id !== null ? '?category_id=' . $parent_id : '');
        header('Location: ' . $redirectUrl);
        exit;
    }

    public function get_available_posts_ajax() {
        header('Content-Type: application/json; charset=utf-8');
        
        $db = \Config\Database::pdoConnect();
        $stmt = $db->prepare("
            SELECT p.id, p.title, c.name as category_name, p.category_id 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.title ASC
        ");
        $stmt->execute();
        $posts = $stmt->fetchAll();
        echo json_encode([
            'success' => true,
            'posts' => $posts
        ]);
        exit;
    }

    public function add_posts_to_folder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $folder_id = !empty($_POST['folder_id']) ? (int)$_POST['folder_id'] : null;
            $post_ids = !empty($_POST['post_ids']) ? $_POST['post_ids'] : [];
            
            if ($folder_id !== null && !empty($post_ids)) {
                $db = \Config\Database::pdoConnect();
                $stmt_post = $db->prepare("UPDATE posts SET category_id = :folder_id WHERE id = :post_id");
                $stmt_check = $db->prepare("SELECT COUNT(*) FROM post_categories WHERE post_id = :post_id AND category_id = :category_id");
                $stmt_ins_cat = $db->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (:post_id, :category_id)");
                
                foreach ($post_ids as $post_id) {
                    $post_id = (int)$post_id;
                    $stmt_post->execute(['folder_id' => $folder_id, 'post_id' => $post_id]);
                    
                    // Only insert mapping if it doesn't exist to keep existing categories intact
                    $stmt_check->execute(['post_id' => $post_id, 'category_id' => $folder_id]);
                    if ($stmt_check->fetchColumn() == 0) {
                        $stmt_ins_cat->execute(['post_id' => $post_id, 'category_id' => $folder_id]);
                    }
                }
                
                \App\Helpers\Cache::clear();
                
                header('Location: ' . URLROOT . '/admin/posts?category_id=' . $folder_id . '&msg=posts_added');
                exit;
            }
            
            $redirectUrl = URLROOT . '/admin/posts' . ($folder_id !== null ? '?category_id=' . $folder_id : '');
            header('Location: ' . $redirectUrl);
            exit;
        }
    }


    public function categories() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : null;
            $adminModel->addCategory($_POST['name'], $parent_id, $slug);
            header('Location: ' . URLROOT . '/admin/categories');
            exit;
        }
        $categories = $adminModel->getCategories();
        $this->view('admin/categories', [
            'categories' => $categories,
            'current_page' => 'categories',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_category($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteCategory($id);
        header('Location: ' . URLROOT . '/admin/categories');
        exit;
    }

    public function edit_category($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : null;
            $adminModel->updateCategory($id, $_POST['name'], $parent_id, $slug);
            header('Location: ' . URLROOT . '/admin/categories');
            exit;
        }
        $category = $adminModel->getCategoryById($id);
        $categories = $adminModel->getCategories();
        $this->view('admin/edit_category', [
            'category' => $category,
            'categories' => $categories,
            'settings' => $this->siteSettings
        ]);
    }

    public function authors() {
        $adminModel = $this->model('AdminModel');
        $authors = $adminModel->getAuthors();
        $this->view('admin/authors', [
            'authors' => $authors,
            'current_page' => 'authors',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_author() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'] ?? null,
                'image' => $_POST['image'] ?? null
            ];
            if ($adminModel->addAuthor($data)) {
                header('Location: ' . URLROOT . '/admin/authors');
                exit;
            }
        }
        $this->view('admin/add_author', [
            'current_page' => 'authors',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_author($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'] ?? null,
                'image' => $_POST['image'] ?? null
            ];
            if ($adminModel->updateAuthor($id, $data)) {
                header('Location: ' . URLROOT . '/admin/authors');
                exit;
            }
        }
        $author = $adminModel->getAuthorById($id);
        $this->view('admin/edit_author', [
            'author' => $author,
            'current_page' => 'authors',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_author($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteAuthor($id);
        header('Location: ' . URLROOT . '/admin/authors');
        exit;
    }

    public function pages() {
        $adminModel = $this->model('AdminModel');
        $pages = $adminModel->getPages();
        $this->view('admin/pages', [
            'pages' => $pages,
            'current_page' => 'pages',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_page() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $adminModel->addPage(['title' => $_POST['title'], 'content' => $_POST['content']]);
            header('Location: ' . URLROOT . '/admin/pages');
            exit;
        }
        $this->view('admin/add_page', ['settings' => $this->siteSettings]);
    }

    public function delete_page($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deletePage($id);
        header('Location: ' . URLROOT . '/admin/pages');
        exit;
    }


    public function comments() {
        $adminModel = $this->model('AdminModel');
        $comments = $adminModel->getComments();
        $this->view('admin/comments', [
            'comments' => $comments,
            'settings' => $this->siteSettings
        ]);
    }

    public function approve_comment($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->approveComment($id);
        header('Location: ' . URLROOT . '/admin/comments');
        exit;
    }

    public function delete_comment($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteComment($id);
        header('Location: ' . URLROOT . '/admin/comments');
        exit;
    }

    public function bulk_comments() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $ids = $_POST['comment_ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $ids = array_map('intval', $ids);
                $adminModel = $this->model('AdminModel');
                if ($action === 'delete') {
                    $adminModel->bulkDeleteComments($ids);
                } elseif ($action === 'approve') {
                    $adminModel->bulkApproveComments($ids);
                }
            }
        }
        header('Location: ' . URLROOT . '/admin/comments');
        exit;
    }

    public function media() {
        $adminModel = $this->model('AdminModel');
        
        $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || isset($_GET['ajax']));

        // Handle Upload
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['media_file'])) {
                $file = $_FILES['media_file'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errors = [
                        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
                    ];
                    $error_msg = $errors[$file['error']] ?? 'Unknown upload error.';
                    if ($is_ajax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'error' => $error_msg]);
                        exit;
                    }
                } else {
                    $upload_dir = \PUBROOT . '/img/';
                    if (!is_dir($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            if ($is_ajax) {
                                header('Content-Type: application/json');
                                echo json_encode(['success' => false, 'error' => 'Failed to create upload directory: ' . $upload_dir]);
                                exit;
                            }
                        }
                    }
                    if (!is_writable($upload_dir)) {
                        if ($is_ajax) {
                            header('Content-Type: application/json');
                            echo json_encode(['success' => false, 'error' => 'Upload directory is not writable: ' . $upload_dir]);
                            exit;
                        }
                    }
                    
                    $file_name = time() . '_' . $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $upload_dir . $file_name)) {
                        if ($is_ajax) {
                            header('Content-Type: application/json');
                            echo json_encode(['success' => true, 'url' => URLROOT . '/public/img/' . $file_name]);
                            exit;
                        }
                        $data['success'] = "Image uploaded successfully!";
                    } else {
                        if ($is_ajax) {
                            header('Content-Type: application/json');
                            echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file. Check directory permissions.']);
                            exit;
                        }
                    }
                }
            } else {
                if ($is_ajax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'No media_file field found in request.']);
                    exit;
                }
            }
        }

        $img_dir = \PUBROOT . '/img';
        $upload_dir = \PUBROOT . '/uploads/settings';
        $all_files = [];
        
        if (is_dir($img_dir)) {
            $img_files = array_diff(scandir($img_dir), array('..', '.'));
            foreach ($img_files as $f) {
                $path = $img_dir . '/' . $f;
                $all_files[] = [
                    'name' => $f, 
                    'url' => URLROOT . '/public/img/' . $f,
                    'path' => $path,
                    'mtime' => file_exists($path) ? filemtime($path) : 0
                ];
            }
        }
        
        if (is_dir($upload_dir)) {
            $setting_files = array_diff(scandir($upload_dir), array('..', '.'));
            foreach ($setting_files as $f) {
                $path = $upload_dir . '/' . $f;
                $all_files[] = [
                    'name' => $f, 
                    'url' => URLROOT . '/public/uploads/settings/' . $f,
                    'path' => $path,
                    'mtime' => file_exists($path) ? filemtime($path) : 0
                ];
            }
        }

        // Sort by modification time descending (newest first)
        usort($all_files, function($a, $b) {
            return $b['mtime'] - $a['mtime'];
        });

        // Pagination parameters
        $limit = 24;
        $total_files = count($all_files);
        $total_pages = ceil($total_files / $limit);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        $offset = ($page - 1) * $limit;
        $sliced_files = array_slice($all_files, $offset, $limit);

        // Fetch details (like size) ONLY for sliced files to improve disk read efficiency
        $files = [];
        foreach ($sliced_files as $file) {
            $size = '0 KB';
            if (file_exists($file['path'])) {
                $size = round(filesize($file['path']) / 1024, 2) . ' KB';
            }
            $files[] = [
                'name' => $file['name'],
                'url' => $file['url'],
                'path' => $file['path'],
                'size' => $size
            ];
        }

        $this->view('admin/media', [
            'files' => $files,
            'page' => $page,
            'total_pages' => $total_pages,
            'total_files' => $total_files,
            'settings' => $this->siteSettings,
            'success' => $data['success'] ?? ''
        ]);
    }

    public function api_media() {
        $img_dir = \PUBROOT . '/img';
        $upload_dir = \PUBROOT . '/uploads/settings';
        $all_files = [];
        
        if (is_dir($img_dir)) {
            $img_files = array_diff(scandir($img_dir), array('..', '.'));
            foreach ($img_files as $f) {
                $path = $img_dir . '/' . $f;
                $all_files[] = [
                    'name' => $f, 
                    'url' => URLROOT . '/public/img/' . $f,
                    'mtime' => file_exists($path) ? filemtime($path) : 0
                ];
            }
        }
        
        if (is_dir($upload_dir)) {
            $setting_files = array_diff(scandir($upload_dir), array('..', '.'));
            foreach ($setting_files as $f) {
                $path = $upload_dir . '/' . $f;
                $all_files[] = [
                    'name' => $f, 
                    'url' => URLROOT . '/public/uploads/settings/' . $f,
                    'mtime' => file_exists($path) ? filemtime($path) : 0
                ];
            }
        }

        // Sort by modification time descending (newest first)
        usort($all_files, function($a, $b) {
            return $b['mtime'] - $a['mtime'];
        });

        // Limit the JSON response to prevent frontend rendering lag in modals (e.g. latest 150 items)
        $limit = 150;
        $sliced_files = array_slice($all_files, 0, $limit);

        $files = [];
        foreach ($sliced_files as $file) {
            $files[] = [
                'name' => $file['name'],
                'url' => $file['url']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($files);
        exit;
    }

    public function delete_media() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file_path'])) {
            $path = $_POST['file_path'];
            $realPath = realpath($path);
            $realPubroot = realpath(\PUBROOT);
            // Security: Ensure path is within public directory (case-insensitive check for Windows drive letter compatibility)
            if ($realPath && $realPubroot && strpos(strtolower($realPath), strtolower($realPubroot)) === 0 && file_exists($realPath)) {
                unlink($realPath);
            }
        }
        header('Location: ' . URLROOT . '/admin/media');
        exit;
    }

    public function prayer_times() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fajr' => $_POST['fajr'],
                'sunrise' => $_POST['sunrise'],
                'dhuhr' => $_POST['dhuhr'],
                'asr' => $_POST['asr'],
                'maghrib' => $_POST['maghrib'],
                'isha' => $_POST['isha']
            ];
            $adminModel->updatePrayerTimes($data);
            $data['success'] = 'Prayer times updated successfully';
        }
        $times = $adminModel->getPrayerTimes();
        $this->view('admin/prayer_times', [
            'times' => $times, 
            'success' => $data['success'] ?? '',
            'current_page' => 'prayer_times',
            'settings' => $this->siteSettings
        ]);
    }

    public function subscribers() {
        $adminModel = $this->model('AdminModel');
        $subscribers = $adminModel->getSubscribers();
        $this->view('admin/subscribers', [
            'subscribers' => $subscribers,
            'current_page' => 'subscribers',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_subscriber($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteSubscriber($id);
        header('Location: ' . URLROOT . '/admin/subscribers');
        exit;
    }

    public function bulk_delete_subscribers() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = $_POST['subscriber_ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $ids = array_map('intval', $ids);
                $adminModel = $this->model('AdminModel');
                $adminModel->bulkDeleteSubscribers($ids);
            }
        }
        header('Location: ' . URLROOT . '/admin/subscribers');
        exit;
    }

    public function messages() {
        $adminModel = $this->model('AdminModel');
        $messages = $adminModel->getMessages();
        $this->view('admin/messages', [
            'messages' => $messages,
            'settings' => $this->siteSettings
        ]);
    }

    public function bulk_messages() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $ids = $_POST['message_ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $ids = array_map('intval', $ids);
                $adminModel = $this->model('AdminModel');
                if ($action === 'delete') {
                    $adminModel->bulkDeleteMessages($ids);
                } elseif ($action === 'read') {
                    $adminModel->bulkMarkMessagesRead($ids);
                }
            }
        }
        header('Location: ' . URLROOT . '/admin/messages');
        exit;
    }

    public function mark_read($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->markMessageRead($id);
        header('Location: ' . URLROOT . '/admin/messages');
        exit;
    }

    public function delete_message($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteMessage($id);
        header('Location: ' . URLROOT . '/admin/messages');
        exit;
    }

    public function breaking_news() {
        header('Location: ' . URLROOT . '/admin');
        exit;
    }

    public function delete_breaking_news($id) {
        header('Location: ' . URLROOT . '/admin');
        exit;
    }

    public function clear_cache() {
        \App\Helpers\Cache::clear();
        header('Location: ' . URLROOT . '/admin?msg=cache_cleared');
        exit;
    }

    public function backup() {
        // Simple backup info page
        $this->view('admin/backup', [
            'current_page' => 'backup',
            'settings' => $this->siteSettings
        ]);
    }

    public function export_db() {
        // Prevent execution timeout and increase memory limit
        @set_time_limit(0);
        @ini_set('memory_limit', '512M');

        try {
            $pdo = \Config\Database::pdoConnect();
            
            // Get all tables
            $tables = [];
            $query = $pdo->query("SHOW TABLES");
            while ($row = $query->fetch(\PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
            
            // Send headers for download
            $filename = 'backup_' . \Config\Database::$default['database'] . '_' . date('Y-m-d_H-i-s') . '.sql';

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            // Clean output buffering to start streaming immediately
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            echo "-- Islamic Nur-Lab Database Backup\n";
            echo "-- Generated: " . date('Y-m-d H:i:s') . "\n";
            echo "-- ------------------------------------------------------\n\n";
            echo "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            foreach ($tables as $table) {
                // Table structure
                echo "--\n";
                echo "-- Table structure for table `$table`\n";
                echo "--\n\n";
                echo "DROP TABLE IF EXISTS `$table`;\n";
                
                $showCreate = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(\PDO::FETCH_ASSOC);
                echo $showCreate['Create Table'] . ";\n\n";
                
                // Table data
                echo "--\n";
                echo "-- Dumping data for table `$table`\n";
                echo "--\n\n";
                
                // Use unbuffered query style by using query() and fetching row by row to save memory
                $stmt = $pdo->query("SELECT * FROM `$table`");
                $first = true;
                
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    if ($first) {
                        echo "INSERT INTO `$table` VALUES\n";
                        $first = false;
                    } else {
                        echo ",\n";
                    }
                    
                    $values = [];
                    foreach ($row as $val) {
                        if (is_null($val)) {
                            $values[] = "NULL";
                        } else {
                            $values[] = $pdo->quote($val);
                        }
                    }
                    echo "(" . implode(", ", $values) . ")";
                }
                
                if (!$first) {
                    echo ";\n";
                }
                echo "\n-- ------------------------------------------------------\n\n";
                
                // Flush outputs to browser
                flush();
            }
            
            echo "SET FOREIGN_KEY_CHECKS=1;\n";
            exit;
        } catch (\Exception $e) {
            die("Backup failed: " . $e->getMessage());
        }
    }

    public function login() {
        // Auto-login from remember_me cookie if session expired
        if (!isset($_SESSION['admin_id']) && isset($_COOKIE['admin_remember'])) {
            $adminModel = $this->model('AdminModel');
            $token = $_COOKIE['admin_remember'];
            $user = $adminModel->getUserByRememberToken($token);
            if ($user) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Refresh cookie lifetime
                setcookie('admin_remember', $token, [
                    'expires' => time() + (365 * 24 * 3600),
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                ]);
                header('Location: ' . base_url('admin'));
                exit;
            }
        }

        if (isset($_SESSION['admin_id'])) {
            header('Location: ' . base_url('admin'));
            exit;
        }

        $adminModel = $this->model('AdminModel');
        $data['settings'] = $adminModel->getSettings();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $adminModel->login($username, $password);

            if ($user) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Set a long-lived remember-me cookie (1 year) if checked
                if (isset($_POST['remember'])) {
                    $token = bin2hex(random_bytes(32));
                    $adminModel->saveRememberToken($user['id'], $token);
                    setcookie('admin_remember', $token, [
                        'expires' => time() + (365 * 24 * 3600),
                        'path' => '/',
                        'httponly' => true,
                        'samesite' => 'Lax',
                        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                    ]);
                }

                header('Location: ' . base_url('admin'));
                exit;
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }

        $this->view('admin/login', $data);
    }

    public function logout() {
        // Clear remember-me cookie and token from DB
        if (isset($_COOKIE['admin_remember'])) {
            $adminModel = $this->model('AdminModel');
            $adminModel->clearRememberToken($_COOKIE['admin_remember']);
            setcookie('admin_remember', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
            ]);
        }
        session_destroy();
        header('Location: ' . URLROOT . '/admin/login');
        exit;
    }

    public function add_post() {
        $postModel = $this->model('PostModel');
        $adminModel = $this->model('AdminModel');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $_POST['title'];
            $data = [
                'category_ids' => $_POST['category_ids'] ?? [],
                'author_ids' => $_POST['author_ids'] ?? [],
                'title' => $_POST['title'],
                'slug' => trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($slug, 'UTF-8')), '-'),
                'content' => $_POST['content'],
                'excerpt' => $_POST['excerpt'],
                'featured_image' => $_POST['featured_image'],
                'post_type' => 'blog',
                'fake_views' => !empty($_POST['fake_views']) ? intval($_POST['fake_views']) : 0,
                'status' => $_POST['status'] ?? 'published',
                'created_at' => !empty($_POST['created_at']) ? date('Y-m-d H:i:s', strtotime($_POST['created_at'])) : date('Y-m-d H:i:s'),
                'views' => !empty($_POST['views']) ? intval($_POST['views']) : 0,
                'seo_title' => !empty($_POST['seo_title']) ? trim($_POST['seo_title']) : null,
                'seo_description' => !empty($_POST['seo_description']) ? trim($_POST['seo_description']) : null,
                'seo_keywords' => !empty($_POST['seo_keywords']) ? trim($_POST['seo_keywords']) : null,
                'schema_data' => !empty($_POST['schema_data']) ? $_POST['schema_data'] : null
            ];

            if ($adminModel->createPost($data)) {
                header('Location: ' . URLROOT . '/admin/posts');
                exit;
            }
        }

        $categories = $postModel->getCategories();
        $authors = $adminModel->getAuthors();
        $this->view('admin/add_post', [
            'categories' => $categories,
            'authors' => $authors,
            'settings' => $this->siteSettings
        ]);
    }

    public function import_doc() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['doc_file'])) {
            $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            $file = $_FILES['doc_file'];
            $tmpPath = $file['tmp_name'];
            $fileName = $file['name'];
            $title = pathinfo($fileName, PATHINFO_FILENAME); // Fallback title
            
            $content = '';
            
            // DOCX files are zip packages containing word/document.xml
            $zip = new \ZipArchive();
            if ($zip->open($tmpPath) === true) {
                if (($xmlIndex = $zip->locateName('word/document.xml')) !== false) {
                    $xmlData = $zip->getFromIndex($xmlIndex);
                    
                    // Simple XML Parser to strip styling but maintain paragraphs
                    $dom = new \DOMDocument();
                    // Suppress warning/errors for invalid XML markup structures
                    @$dom->loadXML($xmlData);
                    
                    $paragraphs = $dom->getElementsByTagName('p');
                    $firstParaText = '';
                    
                    foreach ($paragraphs as $para) {
                        $textNodes = $para->getElementsByTagName('t');
                        $paraText = '';
                        foreach ($textNodes as $t) {
                            $paraText .= $t->nodeValue;
                        }
                        
                        $paraText = trim($paraText);
                        if (!empty($paraText)) {
                            // First populated paragraph in docx is often the heading/title
                            if (empty($firstParaText)) {
                                $firstParaText = $paraText;
                            }
                            $content .= '<p>' . htmlspecialchars($paraText, ENT_QUOTES, 'UTF-8') . '</p>';
                        }
                    }
                    
                    if (!empty($firstParaText)) {
                        $title = $firstParaText;
                        // Strip the first heading paragraph from content body to avoid duplicate titles
                        $content = preg_replace('/^<p>' . preg_quote(htmlspecialchars($firstParaText, ENT_QUOTES, 'UTF-8'), '/') . '<\/p>/u', '', $content);
                    }
                }
                $zip->close();
            } else {
                // If it's a legacy .doc file or binary raw text fallback
                $contentStr = file_get_contents($tmpPath);
                $lines = explode("\n", $contentStr);
                foreach ($lines as $line) {
                    $trimmed = trim(strip_tags($line));
                    if (!empty($trimmed)) {
                        $content .= '<p>' . htmlspecialchars($trimmed, ENT_QUOTES, 'UTF-8') . '</p>';
                    }
                }
            }

            // Create Post Draft
            $adminModel = $this->model('AdminModel');
            
            // Get default Admin/Staff author ID as fallback
            $authors = $adminModel->getAuthors();
            $authorId = !empty($authors) ? $authors[0]['id'] : 1;
            
            // Clean content to ensure it is not empty
            if (empty(trim($content))) {
                $content = '<p>Imported Content</p>';
            }

            // Generate clean slug
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($title, 'UTF-8')), '-');
            if (empty($slug)) {
                $slug = 'imported-post-' . time();
            }

            $postData = [
                'category_ids' => $categoryId ? [$categoryId] : [],
                'author_ids' => [$authorId],
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => mb_substr(strip_tags($content), 0, 150, 'UTF-8'),
                'featured_image' => '',
                'post_type' => 'blog',
                'fake_views' => 0,
                'status' => 'draft', // Saved as Draft for safety
                'created_at' => date('Y-m-d H:i:s'),
                'views' => 0,
                'seo_title' => $title,
                'seo_description' => mb_substr(strip_tags($content), 0, 150, 'UTF-8'),
                'seo_keywords' => ''
            ];

            $adminModel->createPost($postData);
            
            // Redirect back to current folder explorer
            $redirectUrl = URLROOT . '/admin/posts';
            if ($categoryId) {
                $redirectUrl .= '?category_id=' . $categoryId;
            }
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public function youtube() {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = $_POST['settings'];
            $adminModel->updateSettings($settings);
            $data['success'] = 'YouTube settings updated successfully';
        }

        $data['settings'] = $adminModel->getSettings();
        $data['current_page'] = 'youtube';
        $this->view('admin/youtube', $data);
    }

    public function settings() {
        $adminModel = $this->model('AdminModel');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['settings'])) {
                $settings = $_POST['settings'];

                // Handle multi-select sub categories
                if (isset($settings['dont_miss_sub_categories']) && is_array($settings['dont_miss_sub_categories'])) {
                    $settings['dont_miss_sub_categories'] = implode(',', $settings['dont_miss_sub_categories']);
                } else if (!isset($settings['dont_miss_sub_categories'])) {
                    $settings['dont_miss_sub_categories'] = '';
                }

                // Handle File Uploads
                $upload_dir = \PUBROOT . '/uploads/settings/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                foreach (['site_logo', 'site_favicon'] as $file_key) {
                    if (!empty($_FILES[$file_key]['name'])) {
                        $file_name = time() . '_' . $_FILES[$file_key]['name'];
                        $target_file = $upload_dir . $file_name;
                        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $target_file)) {
                            $settings[$file_key] = 'public/uploads/settings/' . $file_name;
                        }
                    }
                }

                // Handle show_scopes checkbox fallback
                if (!isset($settings['show_scopes'])) {
                    $settings['show_scopes'] = '0';
                }

                $adminModel->updateSettings($settings);
                \App\Helpers\Cache::clear();
                $data['success'] = 'Settings updated successfully';
            }
        }

        $data['settings'] = $adminModel->getSettings();
        $data['categories'] = $adminModel->getCategories();
        $data['current_page'] = 'settings';
        $this->view('admin/settings', $data);
    }

    public function system_update() {
        $adminModel = $this->model('AdminModel');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check for System Update ZIP upload
            if (isset($_FILES['update_zip']) && $_FILES['update_zip']['error'] === UPLOAD_ERR_OK) {
                $zipFile = $_FILES['update_zip']['tmp_name'];
                
                $tempExtractDir = \PUBROOT . '/uploads/update_temp_' . time() . '/';
                if (!is_dir($tempExtractDir)) {
                    mkdir($tempExtractDir, 0777, true);
                }
                
                $zip = new \ZipArchive();
                if ($zip->open($zipFile) === TRUE) {
                    $zip->extractTo($tempExtractDir);
                    $zip->close();

                    // Database Auto-Update check
                    $dbUpdateError = null;
                    $dbUpdateMessage = "";
                    try {
                        $pdo = \Config\Database::pdoConnect();
                        
                        // 1. Check for update.sql
                        $sqlFile = $tempExtractDir . 'update.sql';
                        if (file_exists($sqlFile)) {
                            $sql = file_get_contents($sqlFile);
                            if (!empty(trim($sql))) {
                                $pdo->exec($sql);
                                $dbUpdateMessage .= "Executed database update queries (update.sql). ";
                            }
                        }
                        
                        // 2. Check for update.php
                        $phpFile = $tempExtractDir . 'update.php';
                        if (file_exists($phpFile)) {
                            include $phpFile;
                            $dbUpdateMessage .= "Executed database update script (update.php). ";
                        }

                        // 3. Automatically clean up legacy folder prefixes (like islamic.nur-lab.com) from settings & other tables
                        $tables = [];
                        $q_tables = $pdo->query("SHOW TABLES");
                        while ($row = $q_tables->fetch(\PDO::FETCH_NUM)) {
                            $tables[] = $row[0];
                        }
                        foreach ($tables as $table) {
                            $columns = $pdo->query("SHOW COLUMNS FROM `$table`")->fetchAll(\PDO::FETCH_COLUMN);
                            foreach ($columns as $column) {
                                try {
                                    $update_stmt = $pdo->prepare("UPDATE `$table` SET `$column` = REPLACE(REPLACE(`$column`, '/islamic.nur-lab.com/', ''), 'islamic.nur-lab.com/', '') WHERE `$column` LIKE '%islamic.nur-lab.com%'");
                                    $update_stmt->execute();
                                } catch (\Exception $e_col) {
                                    // Skip column error
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        $dbUpdateError = "Database update error: " . $e->getMessage();
                    }
                    
                    $rootDir = dirname(APPROOT) . '/';
                    $copyCount = 0;
                    $errorCount = 0;
                    
                    $iterator = new \RecursiveIteratorIterator(
                         new \RecursiveDirectoryIterator($tempExtractDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                         \RecursiveIteratorIterator::SELF_FIRST
                    );
                    
                    foreach ($iterator as $item) {
                        $subPath = substr($item->getPathname(), strlen($tempExtractDir));
                        $normalizedSubPath = str_replace('\\', '/', $subPath);
                        
                        // Rule 1: Protect config directory from being overwritten
                        if (strpos($normalizedSubPath, 'app/Config/') === 0) {
                            continue;
                        }
                        
                        // Rule 2: Protect the system update page view itself so it remains untouched
                        if ($normalizedSubPath === 'app/Views/admin/system_update.php') {
                            continue;
                        }
                        
                        // Rule 3: Skip DB update scripts so they aren't copied to destination
                        if ($normalizedSubPath === 'update.sql' || $normalizedSubPath === 'update.php') {
                            continue;
                        }
                        
                        $destPath = $rootDir . $subPath;
                        
                        if ($item->isDir()) {
                            if (!is_dir($destPath)) {
                                mkdir($destPath, 0777, true);
                            }
                        } else {
                            $destDir = dirname($destPath);
                            if (!is_dir($destDir)) {
                                mkdir($destDir, 0777, true);
                            }
                            
                            // Copy file and overwrite (destination directories public/img and public/uploads are NOT cleared)
                            if (copy($item->getPathname(), $destPath)) {
                                $copyCount++;
                            } else {
                                $errorCount++;
                            }
                        }
                    }
                    
                    // Clean up temp folder recursively
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($tempExtractDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::CHILD_FIRST
                    );
                    
                    foreach ($files as $fileinfo) {
                        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                        $todo($fileinfo->getRealPath());
                    }
                    rmdir($tempExtractDir);
                    
                    // Run database schema synchronization automatically
                    \App\Core\SchemaSync::sync();
                    
                    if ($dbUpdateError) {
                        $data['error'] = "Files updated successfully ($copyCount files), but database update failed. " . $dbUpdateError;
                    } else {
                        $dbMsg = !empty($dbUpdateMessage) ? " Database: " . trim($dbUpdateMessage) : "";
                        if ($errorCount === 0) {
                            $data['success'] = "System updated successfully! Overwrote $copyCount files.{$dbMsg} Config directory and uploaded images were preserved.";
                        } else {
                            $data['success'] = "System update completed with warnings. Copied $copyCount files, failed to copy $errorCount files.{$dbMsg}";
                        }
                    }
                } else {
                    $data['error'] = 'Failed to open the uploaded ZIP file.';
                }
            } else {
                $data['error'] = 'Please select a valid update ZIP file.';
            }
        }

        $data['settings'] = $adminModel->getSettings();
        $data['current_page'] = 'system_update';
        $data['title'] = 'System Update';
        $this->view('admin/system_update', $data);
    }

    public function facebook_pixel() {
        $adminModel = $this->model('AdminModel');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['settings'])) {
                $settings = $_POST['settings'];
                $adminModel->updateSettings($settings);
                $data['success'] = 'Facebook Pixel settings updated successfully';
            }
        }

        $data['settings'] = $adminModel->getSettings();
        $data['current_page'] = 'facebook_pixel';
        $this->view('admin/facebook_pixel', $data);
    }

    public function google_analytics() {
        $adminModel = $this->model('AdminModel');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['settings'])) {
                $settings = $_POST['settings'];
                $adminModel->updateSettings($settings);
                $data['success'] = 'Google Analytics settings updated successfully';
            }
        }

        $data['settings'] = $adminModel->getSettings();
        $data['current_page'] = 'google_analytics';
        $this->view('admin/google_analytics', $data);
    }

    public function payment_gateway() {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = $_POST['settings'];
            $adminModel->updateSettings($settings);
            $data['success'] = 'Payment gateway settings updated successfully';
        }

        $data['settings'] = $adminModel->getSettings();
        $data['current_page'] = 'payment_gateway';
        $this->view('admin/payment_gateway', $data);
    }

    public function social_links() {
        $adminModel = $this->model('AdminModel');
        $social_links = $adminModel->getSocialLinks();

        $this->view('admin/social_links', [
            'social_links' => $social_links,
            'current_page' => 'social_links',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_social_link() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addSocialLink($data)) {
                header('Location: ' . URLROOT . '/admin/social_links');
                exit;
            }
        }
        $this->view('admin/add_social_link', [
            'current_page' => 'social_links',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_social_link($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateSocialLink($id, $data)) {
                header('Location: ' . URLROOT . '/admin/social_links');
                exit;
            }
        }
        $link = $adminModel->getSocialLinkById($id);
        $this->view('admin/edit_social_link', [
            'link' => $link,
            'current_page' => 'social_links',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_social_link($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteSocialLink($id)) {
            header('Location: ' . URLROOT . '/admin/social_links');
            exit;
        }
    }

    public function slides() {
        $adminModel = $this->model('AdminModel');
        $slides = $adminModel->getSlides();
        $this->view('admin/slides', [
            'title' => 'Hero Slider Management',
            'slides' => $slides,
            'settings' => $this->siteSettings
        ]);
    }

    public function add_slide() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'subtitle' => $_POST['subtitle'],
                'image' => $_POST['image'],
                'link' => $_POST['link'],
                'btn_text' => $_POST['btn_text'] ?? null,
                'order_index' => $_POST['order_index']
            ];

            $adminModel = $this->model('AdminModel');
            if ($adminModel->addSlide($data)) {
                header('Location: ' . URLROOT . '/admin/slides');
                exit;
            }
        }
        $this->view('admin/add_slide', ['settings' => $this->siteSettings]);
    }

    public function edit_slide($id) {
        $adminModel = $this->model('AdminModel');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'subtitle' => $_POST['subtitle'],
                'image' => $_POST['image'],
                'link' => $_POST['link'],
                'btn_text' => $_POST['btn_text'] ?? null,
                'order_index' => $_POST['order_index']
            ];

            if ($adminModel->updateSlide($id, $data)) {
                header('Location: ' . URLROOT . '/admin/slides');
                exit;
            }
        }

        $slide = $adminModel->getSlideById($id);
        $this->view('admin/edit_slide', [
            'slide' => $slide,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_slide($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteSlide($id)) {
            header('Location: ' . URLROOT . '/admin/slides');
            exit;
        }
    }

    public function sidebar_slides() {
        $adminModel = $this->model('AdminModel');
        $slides = $adminModel->getSidebarSlides();
        $this->view('admin/sidebar_slides', [
            'title' => 'Sidebar Slider (1:1) Management',
            'slides' => $slides,
            'current_page' => 'sidebar_slides',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_sidebar_slide() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'image' => $_POST['image'],
                'link' => $_POST['link'],
                'order_index' => $_POST['order_index']
            ];

            $adminModel = $this->model('AdminModel');
            if ($adminModel->addSidebarSlide($data)) {
                header('Location: ' . URLROOT . '/admin/sidebar_slides');
                exit;
            }
        }
        $this->view('admin/add_sidebar_slide', [
            'title' => 'Add Sidebar Slide',
            'current_page' => 'sidebar_slides',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_sidebar_slide($id) {
        $adminModel = $this->model('AdminModel');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'image' => $_POST['image'],
                'link' => $_POST['link'],
                'order_index' => $_POST['order_index']
            ];

            if ($adminModel->updateSidebarSlide($id, $data)) {
                header('Location: ' . URLROOT . '/admin/sidebar_slides');
                exit;
            }
        }

        $slide = $adminModel->getSidebarSlideById($id);
        $this->view('admin/edit_sidebar_slide', [
            'title' => 'Edit Sidebar Slide',
            'slide' => $slide,
            'current_page' => 'sidebar_slides',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_sidebar_slide($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteSidebarSlide($id)) {
            header('Location: ' . URLROOT . '/admin/sidebar_slides');
            exit;
        }
    }

    public function users() {
        $adminModel = $this->model('AdminModel');
        $users = $adminModel->getUsers();
        $this->view('admin/users', [
            'users' => $users,
            'current_page' => 'users',
            'settings' => $this->siteSettings
        ]);
    }

    public function permissions($id = null) {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = [
                'id' => $id,
                'username' => $_POST['username'], // Keep existing username
                'role' => $_POST['role'],
                'permissions' => $_POST['permissions'] ?? []
            ];
            if ($adminModel->updateUser($data)) {
                header('Location: ' . URLROOT . '/admin/permissions');
                exit;
            }
        }

        if ($id) {
            $user = $adminModel->getUserById($id);
            $this->view('admin/manage_permissions', [
                'user' => $user,
                'current_page' => 'permissions',
                'settings' => $this->siteSettings
            ]);
        } else {
            $users = $adminModel->getUsers();
            $this->view('admin/permissions', [
                'users' => $users,
                'current_page' => 'permissions',
                'settings' => $this->siteSettings
            ]);
        }
    }

    public function add_user() {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $_POST['role']
            ];

            if ($adminModel->addUser($data)) {
                header('Location: ' . URLROOT . '/admin/users');
                exit;
            }
        }

        $this->view('admin/add_user', [
            'current_page' => 'users',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_user($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'username' => $_POST['username'],
                'email' => $_POST['email'] ?? '',
                'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null
            ];
            if ($adminModel->updateUser($data)) {
                header('Location: ' . URLROOT . '/admin/users');
                exit;
            }
        }
        $user = $adminModel->getUserById($id);
        $this->view('admin/edit_user', [
            'user' => $user,
            'current_page' => 'users',
            'settings' => $this->siteSettings
        ]);
    }

    public function customers() {
        $customers = $this->adminModel->getCustomers();
        $this->view('admin/customers', [
            'title' => 'Registered Customers',
            'customers' => $customers,
            'current_page' => 'customers',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_customer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client_ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
            if ($client_ip && strpos($client_ip, ',') !== false) {
                $client_ip = trim(explode(',', $client_ip)[0]);
            }

            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => !empty($_POST['email']) ? $_POST['email'] : null,
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'ip_address' => $client_ip
            ];
            
            $db = \Config\Database::pdoConnect();
            $stmt = $db->prepare("INSERT INTO customer_users (name, phone, email, password, ip_address) VALUES (:name, :phone, :email, :password, :ip_address)");
            try {
                $stmt->execute($data);
                header('Location: ' . URLROOT . '/admin/customers');
                exit;
            } catch (\PDOException $e) {
                $_SESSION['admin_customer_error'] = 'এই মোবাইল বা ইমেইল ইতিমধ্যে ব্যবহৃত হচ্ছে!';
            }
        }
        $this->view('admin/add_customer', [
            'current_page' => 'customers',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_customer($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => !empty($_POST['email']) ? $_POST['email'] : null,
                'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null,
                'is_banned' => isset($_POST['is_banned']) ? intval($_POST['is_banned']) : 0
            ];
            if ($this->adminModel->updateCustomer($data)) {
                header('Location: ' . URLROOT . '/admin/customers');
                exit;
            }
        }
        $customer = $this->adminModel->getCustomerById($id);
        $this->view('admin/edit_customer', [
            'customer' => $customer,
            'current_page' => 'customers',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_customer($id) {
        if ($this->adminModel->deleteCustomer($id)) {
            header('Location: ' . URLROOT . '/admin/customers');
            exit;
        }
    }

    public function ban_customer($id) {
        if ($this->adminModel->banCustomer($id)) {
            header('Location: ' . URLROOT . '/admin/customers');
            exit;
        }
    }

    public function unban_customer($id) {
        if ($this->adminModel->unbanCustomer($id)) {
            header('Location: ' . URLROOT . '/admin/customers');
            exit;
        }
    }

    public function edit_post($id) {
        $adminModel = $this->model('AdminModel');
        $postModel = $this->model('PostModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $_POST['title'];
            $data = [
                'id' => $id,
                'title' => $_POST['title'],
                'category_ids' => $_POST['category_ids'] ?? [],
                'author_ids' => $_POST['author_ids'] ?? [],
                'content' => $_POST['content'],
                'excerpt' => $_POST['excerpt'],
                'featured_image' => $_POST['featured_image'],
                'slug' => trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($slug, 'UTF-8')), '-'),
                'fake_views' => !empty($_POST['fake_views']) ? intval($_POST['fake_views']) : 0,
                'status' => $_POST['status'] ?? 'published',
                'created_at' => !empty($_POST['created_at']) ? date('Y-m-d H:i:s', strtotime($_POST['created_at'])) : date('Y-m-d H:i:s'),
                'views' => !empty($_POST['views']) ? intval($_POST['views']) : 0,
                'seo_title' => !empty($_POST['seo_title']) ? trim($_POST['seo_title']) : null,
                'seo_description' => !empty($_POST['seo_description']) ? trim($_POST['seo_description']) : null,
                'seo_keywords' => !empty($_POST['seo_keywords']) ? trim($_POST['seo_keywords']) : null,
                'schema_data' => !empty($_POST['schema_data']) ? $_POST['schema_data'] : null
            ];

            if ($adminModel->updatePost($data)) {
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                header('Location: ' . URLROOT . '/admin/edit_post/' . $id . '?page=' . $page . '&msg=success');
                exit;
            }
        }

        $post = $postModel->getPostById($id);
        $categories = $adminModel->getCategories();
        $authors = $adminModel->getAuthors();
        $post_category_ids = $adminModel->getPostCategoryIds($id);
        $post_author_ids = $adminModel->getPostAuthorIds($id);
        
        $this->view('admin/edit_post', [
            'post' => $post,
            'categories' => $categories,
            'authors' => $authors,
            'post_category_ids' => $post_category_ids,
            'post_author_ids' => $post_author_ids,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_post($id) {
        $adminModel = $this->model('AdminModel');
        $ids = explode(',', $id);
        foreach ($ids as $singleId) {
            $singleId = trim($singleId);
            if (is_numeric($singleId)) {
                $adminModel->deletePost($singleId);
            }
        }
        header('Location: ' . URLROOT . '/admin/posts');
        exit;
    }

    public function team() {
        $adminModel = $this->model('AdminModel');
        $members = $adminModel->getTeamMembers();
        $this->view('admin/team', [
            'members' => $members,
            'current_page' => 'team',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_team_member() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
                'image' => $_POST['image'],
                'facebook_link' => $_POST['facebook_link'],
                'twitter_link' => $_POST['twitter_link'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addTeamMember($data)) {
                \App\Helpers\Cache::clear();
                header('Location: ' . URLROOT . '/admin/team');
                exit;
            }
        }
        $this->view('admin/add_team_member', ['settings' => $this->siteSettings]);
    }

    public function edit_team_member($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
                'image' => $_POST['image'],
                'facebook_link' => $_POST['facebook_link'],
                'twitter_link' => $_POST['twitter_link'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateTeamMember($id, $data)) {
                \App\Helpers\Cache::clear();
                header('Location: ' . URLROOT . '/admin/team');
                exit;
            }
        }
        $member = $adminModel->getTeamMemberById($id);
        $this->view('admin/edit_team_member', [
            'member' => $member,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_team_member($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteTeamMember($id)) {
            \App\Helpers\Cache::clear();
            header('Location: ' . URLROOT . '/admin/team');
            exit;
        }
    }

    public function scopes() {
        $adminModel = $this->model('AdminModel');
        $scopes = $adminModel->getScopes();
        $this->view('admin/scopes', [
            'scopes' => $scopes,
            'current_page' => 'scopes',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_scope() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'title' => $_POST['title'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addScope($data)) {
                header('Location: ' . URLROOT . '/admin/scopes');
                exit;
            }
        }
        $this->view('admin/add_scope', ['settings' => $this->siteSettings]);
    }

    public function edit_scope($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateScope($id, $data)) {
                header('Location: ' . URLROOT . '/admin/scopes');
                exit;
            }
        }
        $scope = $adminModel->getScopeById($id);
        $this->view('admin/edit_scope', [
            'scope' => $scope,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_scope($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteScope($id)) {
            header('Location: ' . URLROOT . '/admin/scopes');
            exit;
        }
    }

    public function join_cards() {
        $adminModel = $this->model('AdminModel');
        $cards = $adminModel->getJoinCards();
        $this->view('admin/join_cards', [
            'cards' => $cards,
            'current_page' => 'join_cards',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_join_card() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'title' => $_POST['title'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addJoinCard($data)) {
                header('Location: ' . URLROOT . '/admin/join_cards');
                exit;
            }
        }
        $this->view('admin/add_join_card', ['settings' => $this->siteSettings]);
    }

    public function edit_join_card($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateJoinCard($id, $data)) {
                header('Location: ' . URLROOT . '/admin/join_cards');
                exit;
            }
        }
        $card = $adminModel->getJoinCardById($id);
        $this->view('admin/edit_join_card', [
            'card' => $card,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_join_card($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteJoinCard($id)) {
            header('Location: ' . URLROOT . '/admin/join_cards');
            exit;
        }
    }

    public function about_sections() {
        $adminModel = $this->model('AdminModel');
        $about_sections = $adminModel->getAboutSections();
        $this->view('admin/about_sections', [
            'about_sections' => $about_sections,
            'current_page' => 'about_sections',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_about_section() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'image' => $_POST['image'],
                'subtitle' => $_POST['subtitle'],
                'title' => $_POST['title'],
                'highlight_title' => $_POST['highlight_title'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addAboutSection($data)) {
                header('Location: ' . URLROOT . '/admin/about_sections');
                exit;
            }
        }
        $this->view('admin/add_about_section', ['settings' => $this->siteSettings]);
    }

    public function edit_about_section($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'image' => $_POST['image'],
                'subtitle' => $_POST['subtitle'],
                'title' => $_POST['title'],
                'highlight_title' => $_POST['highlight_title'],
                'description' => $_POST['description'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateAboutSection($id, $data)) {
                header('Location: ' . URLROOT . '/admin/about_sections');
                exit;
            }
        }
        $about = $adminModel->getAboutSectionById($id);
        $this->view('admin/edit_about_section', [
            'about' => $about,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_about_section($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteAboutSection($id)) {
            header('Location: ' . URLROOT . '/admin/about_sections');
            exit;
        }
    }

    public function reviews() {
        $adminModel = $this->model('AdminModel');
        $reviews = $adminModel->getReviews();
        $this->view('admin/reviews', [
            'reviews' => $reviews,
            'current_page' => 'reviews',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_review() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
                'image' => $_POST['image'],
                'rating' => $_POST['rating'],
                'review_text' => $_POST['review_text'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addReview($data)) {
                header('Location: ' . URLROOT . '/admin/reviews');
                exit;
            }
        }
        $this->view('admin/add_review', ['settings' => $this->siteSettings]);
    }

    public function edit_review($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
                'image' => $_POST['image'],
                'rating' => $_POST['rating'],
                'review_text' => $_POST['review_text'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateReview($id, $data)) {
                header('Location: ' . URLROOT . '/admin/reviews');
                exit;
            }
        }
        $review = $adminModel->getReviewById($id);
        $this->view('admin/edit_review', [
            'review' => $review,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_review($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteReview($id)) {
            header('Location: ' . URLROOT . '/admin/reviews');
            exit;
        }
    }

    public function menus() {
        $adminModel = $this->model('AdminModel');
        $menus = $adminModel->getMenus();
        $this->view('admin/menus', [
            'menus' => $menus,
            'categories' => $adminModel->getCategories(),
            'current_page' => 'menus',
            'settings' => $adminModel->getSettings()
        ]);
    }

    public function blog_manager() {
        header('Location: ' . base_url('admin'));
        exit;
    }

    public function add_menu() {
        $adminModel = $this->model('AdminModel');
        $productModel = $this->model('ProductModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['menu_type'] ?? 'custom';
            $cats = [];
            if ($type === 'post_mega') {
                $cats = $_POST['post_cats'] ?? [];
            } elseif ($type === 'product_mega') {
                $cats = $_POST['product_cats'] ?? [];
            }
            $data = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index'],
                'parent_id' => $_POST['parent_id'] !== '' ? $_POST['parent_id'] : null,
                'icon' => $_POST['icon'] !== '' ? $_POST['icon'] : null,
                'menu_type' => $type,
                'category_source' => !empty($cats) ? json_encode($cats) : null
            ];
            if ($adminModel->addMenu($data)) {
                header('Location: ' . URLROOT . '/admin/menus');
                exit;
            }
        }
        $menus = $adminModel->getMenus();
        $post_categories = $adminModel->getCategories();
        $product_categories = $productModel->getCategories();
        $this->view('admin/add_menu', [
            'menus' => $menus,
            'post_categories' => $post_categories,
            'product_categories' => $product_categories,
            'current_page' => 'menus',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_menu($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['menu_type'] ?? 'custom';
            $cats = [];
            if ($type === 'post_mega') {
                $cats = $_POST['post_cats'] ?? [];
            } elseif ($type === 'product_mega') {
                $cats = $_POST['product_cats'] ?? [];
            }
            $data = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index'],
                'parent_id' => $_POST['parent_id'] !== '' ? $_POST['parent_id'] : null,
                'icon' => $_POST['icon'] !== '' ? $_POST['icon'] : null,
                'menu_type' => $type,
                'category_source' => !empty($cats) ? json_encode($cats) : null
            ];
            if ($adminModel->updateMenu($id, $data)) {
                header('Location: ' . URLROOT . '/admin/menus');
                exit;
            }
        }
        $menu = $adminModel->getMenuById($id);
        $menus = $adminModel->getMenus();
        $post_categories = $adminModel->getCategories();
        $product_categories = [];
        $this->view('admin/edit_menu', [
            'menu' => $menu,
            'menus' => $menus,
            'post_categories' => $post_categories,
            'product_categories' => $product_categories,
            'current_page' => 'menus',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_menu($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteMenu($id)) {
            header('Location: ' . URLROOT . '/admin/menus');
            exit;
        }
    }

    public function reorder_categories() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $ids = $data['ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $adminModel = $this->model('AdminModel');
                $adminModel->updateCategoriesOrder($ids);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error']);
        exit;
    }

    public function move_folder() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $parent_id = isset($_POST['new_parent_id']) && $_POST['new_parent_id'] !== '' ? (int)$_POST['new_parent_id'] : null;
            
            // Check safety to prevent cyclic dependency
            $category = $adminModel->getCategoryById($id);
            if ($category) {
                $allCategories = $adminModel->getCategories();
                $forbiddenIds = [$id];
                $toCheck = [$id];
                while (!empty($toCheck)) {
                    $next = array_pop($toCheck);
                    foreach ($allCategories as $cat) {
                        if ($cat['parent_id'] == $next) {
                            $forbiddenIds[] = $cat['id'];
                            $toCheck[] = $cat['id'];
                        }
                    }
                }
                
                if (!in_array($parent_id, $forbiddenIds)) {
                    $adminModel->updateCategoryParent($id, $parent_id);
                }
            }
            
            $redirectUrl = URLROOT . '/admin/posts' . ($parent_id !== null ? '?category_id=' . $parent_id : '');
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public function move_and_reorder_category() {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $id = isset($data['id']) ? (int)$data['id'] : null;
            $parent_id = isset($data['parent_id']) && $data['parent_id'] !== '' ? (int)$data['parent_id'] : null;
            $sibling_ids = $data['sibling_ids'] ?? [];

            $adminModel = $this->model('AdminModel');
            if ($id !== null) {
                $category = $adminModel->getCategoryById($id);
                if ($category) {
                    $allCategories = $adminModel->getCategories();
                    $forbiddenIds = [$id];
                    $toCheck = [$id];
                    while (!empty($toCheck)) {
                        $next = array_pop($toCheck);
                        foreach ($allCategories as $cat) {
                            if ($cat['parent_id'] == $next) {
                                $forbiddenIds[] = $cat['id'];
                                $toCheck[] = $cat['id'];
                            }
                        }
                    }
                    
                    if (!in_array($parent_id, $forbiddenIds)) {
                        $adminModel->updateCategoryParent($id, $parent_id);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Cyclic hierarchy not allowed']);
                        exit;
                    }
                }
            }

            if (!empty($sibling_ids) && is_array($sibling_ids)) {
                $adminModel->updateCategoriesOrder($sibling_ids);
            }

            echo json_encode(['status' => 'success']);
            exit;
        }
        echo json_encode(['status' => 'error']);
        exit;
    }

    public function reorder_menus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $ids = $data['ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $adminModel = $this->model('AdminModel');
                $adminModel->updateMenusOrder($ids);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error']);
        exit;
    }

    public function create_menu_from_category($id) {
        $adminModel = $this->model('AdminModel');
        $category = $adminModel->getCategoryById($id);
        if (!$category) {
            header('Location: ' . URLROOT . '/admin/categories');
            exit;
        }
        // Check if a menu with the same URL already exists
        $all_menus = $adminModel->getMenus();
        $cat_url = '/' . $category['slug'];
        foreach ($all_menus as $m) {
            if (rtrim($m['url'], '/') === rtrim($cat_url, '/')) {
                // Menu already exists - redirect to menus list
                header('Location: ' . URLROOT . '/admin/menus?msg=already_exists');
                exit;
            }
        }
        // Get order_index for new menu (append to end)
        $top_menus = array_filter($all_menus, function($m) { return empty($m['parent_id']); });
        $max_order = count($top_menus) > 0 ? max(array_column(array_values($top_menus), 'order_index')) : 0;
        
        $data = [
            'title' => $category['name'],
            'url'   => $cat_url,
            'order_index' => $max_order + 1,
            'parent_id'   => null,
            'icon'   => null,
            'menu_type' => 'custom',
            'category_source' => null
        ];
        $adminModel->addMenu($data);
        header('Location: ' . URLROOT . '/admin/menus?msg=created');
        exit;
    }

    public function sub_menus() {
        $adminModel = $this->model('AdminModel');
        $menus = $adminModel->getSubMenus();
        $this->view('admin/sub_menus', [
            'menus' => $menus,
            'current_page' => 'sub_menus',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_sub_menu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addSubMenu($data)) {
                header('Location: ' . URLROOT . '/admin/sub_menus');
                exit;
            }
        }
        $this->view('admin/add_sub_menu', [
            'current_page' => 'sub_menus',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_sub_menu($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateSubMenu($id, $data)) {
                header('Location: ' . URLROOT . '/admin/sub_menus');
                exit;
            }
        }
        $menu = $adminModel->getSubMenuById($id);
        $this->view('admin/edit_sub_menu', [
            'menu' => $menu,
            'current_page' => 'sub_menus',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_sub_menu($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteSubMenu($id)) {
            header('Location: ' . URLROOT . '/admin/sub_menus');
            exit;
        }
    }

    // YouTube Video Management
    public function yt_videos() {
        $adminModel = $this->model('AdminModel');
        $videos = $adminModel->getYTVideos();
        $this->view('admin/yt_videos', [
            'videos' => $videos,
            'current_page' => 'yt_videos',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_yt_video() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'video_url' => $_POST['video_url'],
                'description' => $_POST['description']
            ];
            if ($adminModel->addYTVideo($data)) {
                header('Location: ' . URLROOT . '/admin/yt_videos');
                exit;
            }
        }
        $categories = $adminModel->getYTSubCategories();
        $this->view('admin/add_yt_video', [
            'categories' => $categories,
            'current_page' => 'add_yt_video',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_yt_video($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteYTVideo($id)) {
            header('Location: ' . URLROOT . '/admin/yt_videos');
            exit;
        }
    }

    public function yt_categories() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['name' => $_POST['name']];
            if ($adminModel->addYTCategory($data)) {
                header('Location: ' . URLROOT . '/admin/yt_categories');
                exit;
            }
        }
        $categories = $adminModel->getYTSubCategories();
        $this->view('admin/yt_categories', [
            'categories' => $categories,
            'current_page' => 'yt_categories',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_yt_category($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteYTCategory($id)) {
            header('Location: ' . URLROOT . '/admin/yt_categories');
            exit;
        }
    }

    // E-Commerce Products CRUD
    public function products() {
        $productModel = $this->model('ProductModel');
        $products = $productModel->getProducts('all');
        $this->view('admin/products', [
            'products' => $products,
            'current_page' => 'products',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_product() {
        $productModel = $this->model('ProductModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = $_POST['image_url'] ?? '';
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_dir = \PUBROOT . '/uploads/products/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_name = time() . '_' . $_FILES['image']['name'];
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_url = URLROOT . '/public/uploads/products/' . $file_name;
                }
            }

            $pdf_preview = $_POST['pdf_preview_url'] ?? '';
            
            // Handle PDF upload
            if (!empty($_FILES['pdf_preview']['name'])) {
                $upload_dir = \PUBROOT . '/uploads/pdf/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_name = time() . '_' . str_replace(' ', '_', $_FILES['pdf_preview']['name']);
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['pdf_preview']['tmp_name'], $target_file)) {
                    $pdf_preview = URLROOT . '/public/uploads/pdf/' . $file_name;
                }
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                'delivery_charge' => !empty($_POST['delivery_charge']) ? floatval($_POST['delivery_charge']) : 0.00,
                'image' => $image_url,
                'pdf_preview' => $pdf_preview,
                'author' => !empty($_POST['author']) ? $_POST['author'] : null,
                'publisher' => !empty($_POST['publisher']) ? $_POST['publisher'] : null,
                'isbn' => !empty($_POST['isbn']) ? $_POST['isbn'] : null,
                'edition' => !empty($_POST['edition']) ? $_POST['edition'] : null,
                'pages' => !empty($_POST['pages']) ? $_POST['pages'] : null,
                'country' => !empty($_POST['country']) ? $_POST['country'] : null,
                'language' => !empty($_POST['language']) ? $_POST['language'] : null,
                'stock' => $_POST['stock'],
                'status' => $_POST['status']
            ];
            if ($productModel->addProduct($data)) {
                header('Location: ' . URLROOT . '/admin/products');
                exit;
            }
        }
        $categories = $productModel->getCategories();
        $this->view('admin/add_product', [
            'categories' => $categories,
            'current_page' => 'products',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_product($id) {
        $productModel = $this->model('ProductModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = $_POST['image_url'] ?? '';
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_dir = \PUBROOT . '/uploads/products/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_name = time() . '_' . $_FILES['image']['name'];
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_url = URLROOT . '/public/uploads/products/' . $file_name;
                }
            }

            $pdf_preview = $_POST['pdf_preview_url'] ?? '';
            
            // Handle PDF upload
            if (!empty($_FILES['pdf_preview']['name'])) {
                $upload_dir = \PUBROOT . '/uploads/pdf/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_name = time() . '_' . str_replace(' ', '_', $_FILES['pdf_preview']['name']);
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['pdf_preview']['tmp_name'], $target_file)) {
                    $pdf_preview = URLROOT . '/public/uploads/pdf/' . $file_name;
                }
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                'delivery_charge' => !empty($_POST['delivery_charge']) ? floatval($_POST['delivery_charge']) : 0.00,
                'image' => $image_url,
                'pdf_preview' => $pdf_preview,
                'author' => !empty($_POST['author']) ? $_POST['author'] : null,
                'publisher' => !empty($_POST['publisher']) ? $_POST['publisher'] : null,
                'isbn' => !empty($_POST['isbn']) ? $_POST['isbn'] : null,
                'edition' => !empty($_POST['edition']) ? $_POST['edition'] : null,
                'pages' => !empty($_POST['pages']) ? $_POST['pages'] : null,
                'country' => !empty($_POST['country']) ? $_POST['country'] : null,
                'language' => !empty($_POST['language']) ? $_POST['language'] : null,
                'stock' => $_POST['stock'],
                'status' => $_POST['status']
            ];
            if ($productModel->updateProduct($id, $data)) {
                header('Location: ' . URLROOT . '/admin/products');
                exit;
            }
        }
        $product = $productModel->getProductById($id);
        $categories = $productModel->getCategories();
        $this->view('admin/edit_product', [
            'product' => $product,
            'categories' => $categories,
            'current_page' => 'products',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_product($id) {
        $productModel = $this->model('ProductModel');
        if ($productModel->deleteProduct($id)) {
            header('Location: ' . URLROOT . '/admin/products');
            exit;
        }
    }

    // E-Commerce Categories CRUD
    public function product_categories() {
        $productModel = $this->model('ProductModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $slug = strtolower(str_replace(' ', '-', $name));
            if ($productModel->addCategory(['name' => $name, 'slug' => $slug])) {
                header('Location: ' . URLROOT . '/admin/product_categories');
                exit;
            }
        }
        $categories = $productModel->getCategories();
        $this->view('admin/product_categories', [
            'categories' => $categories,
            'current_page' => 'product_categories',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_product_category($id) {
        $productModel = $this->model('ProductModel');
        if ($productModel->deleteCategory($id)) {
            header('Location: ' . URLROOT . '/admin/product_categories');
            exit;
        }
    }

    // E-Commerce Orders Log
    public function orders() {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getOrders();
        $this->view('admin/orders', [
            'orders' => $orders,
            'current_page' => 'orders',
            'settings' => $this->siteSettings
        ]);
    }

    public function order_detail($id) {
        $orderModel = $this->model('OrderModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            $orderModel->updateOrderStatus($id, $_POST['status']);
            header('Location: ' . URLROOT . '/admin/order_detail/' . $id);
            exit;
        }
        $order = $orderModel->getOrderById($id);
        $items = $orderModel->getOrderItems($id);
        $this->view('admin/order_detail', [
            'order' => $order,
            'items' => $items,
            'current_page' => 'orders',
            'settings' => $this->siteSettings
        ]);
    }

    public function donations() {
        $adminModel = $this->model('AdminModel');
        $donations = $adminModel->getDonations();
        
        $data = [
            'title' => 'Donation Logs',
            'donations' => $donations,
            'current_page' => 'donations',
            'settings' => $this->siteSettings
        ];
        
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        
        $this->view('admin/donations', $data);
    }

    public function update_donation_status($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            $adminModel = $this->model('AdminModel');
            $adminModel->updateDonationStatus($id, $_POST['status']);
            $_SESSION['success'] = 'Donation status updated successfully';
        }
        header('Location: ' . URLROOT . '/admin/donations');
        exit;
    }

    public function delete_donation($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            if ($adminModel->deleteDonation($id)) {
                $_SESSION['success'] = 'Donation deleted successfully';
            }
        }
        header('Location: ' . URLROOT . '/admin/donations');
        exit;
    }

    public function bulk_donations() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $ids = $_POST['donation_ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $ids = array_map('intval', $ids);
                $adminModel = $this->model('AdminModel');
                if ($action === 'delete') {
                    if ($adminModel->bulkDeleteDonations($ids)) {
                        $_SESSION['success'] = 'Selected donations deleted successfully';
                    }
                } elseif ($action === 'completed') {
                    if ($adminModel->bulkUpdateDonationsStatus($ids, 'completed')) {
                        $_SESSION['success'] = 'Selected donations marked as completed';
                    }
                } elseif ($action === 'failed') {
                    if ($adminModel->bulkUpdateDonationsStatus($ids, 'failed')) {
                        $_SESSION['success'] = 'Selected donations marked as failed';
                    }
                }
            }
        }
        header('Location: ' . URLROOT . '/admin/donations');
        exit;
    }

    public function faqs() {
        $adminModel = $this->model('AdminModel');
        $faqs = $adminModel->getFaqs();
        $this->view('admin/faqs', [
            'faqs' => $faqs,
            'current_page' => 'faqs',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_faq() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $data = [
                'question' => $_POST['question'],
                'answer' => $_POST['answer'],
                'status' => $_POST['status'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->addFaq($data)) {
                header('Location: ' . URLROOT . '/admin/faqs');
                exit;
            }
        }
        $this->view('admin/add_faq', ['settings' => $this->siteSettings]);
    }

    public function edit_faq($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'question' => $_POST['question'],
                'answer' => $_POST['answer'],
                'status' => $_POST['status'],
                'order_index' => $_POST['order_index']
            ];
            if ($adminModel->updateFaq($id, $data)) {
                header('Location: ' . URLROOT . '/admin/faqs');
                exit;
            }
        }
        $faq = $adminModel->getFaqById($id);
        $this->view('admin/edit_faq', [
            'faq' => $faq,
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_faq($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteFaq($id)) {
            header('Location: ' . URLROOT . '/admin/faqs');
            exit;
        }
    }

    public function delivery_charges() {
        $adminModel = $this->model('AdminModel');
        $charges = $adminModel->getDeliveryCharges();
        
        $this->view('admin/delivery_charges', [
            'title' => 'Delivery Charges',
            'charges' => $charges,
            'current_page' => 'delivery_charges',
            'settings' => $this->siteSettings
        ]);
    }

    public function add_delivery_charge() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $location = trim($_POST['location']);
            $team = !empty($_POST['team']) ? trim($_POST['team']) : 'Default';
            $charge = floatval($_POST['charge']);

            if (!empty($location)) {
                $adminModel->addDeliveryCharge($location, $team, $charge);
                header('Location: ' . URLROOT . '/admin/delivery_charges?msg=added');
                exit;
            }
        }
        $this->view('admin/add_delivery_charge', [
            'title' => 'Add Delivery Charge',
            'current_page' => 'delivery_charges',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_delivery_charge($id) {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $location = trim($_POST['location']);
            $team = !empty($_POST['team']) ? trim($_POST['team']) : 'Default';
            $charge = floatval($_POST['charge']);

            if (!empty($location)) {
                $adminModel->updateDeliveryCharge($id, $location, $team, $charge);
                header('Location: ' . URLROOT . '/admin/delivery_charges?msg=updated');
                exit;
            }
        }
        $charge_rule = $adminModel->getDeliveryChargeById($id);
        $this->view('admin/edit_delivery_charge', [
            'title' => 'Edit Delivery Charge',
            'charge' => $charge_rule,
            'current_page' => 'delivery_charges',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_delivery_charge($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteDeliveryCharge($id);
        header('Location: ' . URLROOT . '/admin/delivery_charges?msg=deleted');
        exit;
    }

    // User Questions Management
    public function questions() {
        $questions = $this->adminModel->getUserQuestions(null);
        
        foreach ($questions as &$q) {
            $q['pending_answers'] = $this->adminModel->getQuestionAnswers($q['id'], 'pending');
        }
        
        $this->view('admin/questions', [
            'title' => 'User Questions',
            'questions' => $questions,
            'current_page' => 'questions',
            'settings' => $this->siteSettings
        ]);
    }

    public function answer_question($id) {
        $question = $this->adminModel->getUserQuestionById($id);
        if (!$question) {
            header('Location: ' . URLROOT . '/admin/questions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $answer = trim($_POST['answer']);
            if (!empty($answer)) {
                $this->adminModel->answerUserQuestion($id, $answer);

                // Send email notification to user
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
                $host = $_SERVER['HTTP_HOST'];
                $question_url = $protocol . $host . URLROOT . '/question/' . $id;

                $subject = "আপনার প্রশ্নের উত্তর দেওয়া হয়েছে - " . ($this->siteSettings['site_title'] ?? 'Islamic News Portal');
                $message = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px;'>
                    <h2 style='color: #0b7c4d; text-align: center;'>" . htmlspecialchars($this->siteSettings['site_title'] ?? 'Islamic News Portal') . "</h2>
                    <p>আসসালামু আলাইকুম <strong>" . htmlspecialchars($question['name']) . "</strong>,</p>
                    <p>আপনার পাঠানো প্রশ্নটির উত্তর দেওয়া হয়েছে।</p>
                    
                    <div style='background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0b7c4d;'>
                        <strong>আপনার প্রশ্ন:</strong><br>
                        " . nl2br(htmlspecialchars($question['question'])) . "
                    </div>

                    <div style='background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2563eb;'>
                        <strong>উত্তর:</strong><br>
                        " . $answer . "
                    </div>

                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='" . $question_url . "' style='background: #0b7c4d; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: bold;'>উত্তরটি দেখতে এখানে ক্লিক করুন</a>
                    </p>

                    <p style='color: #64748b; font-size: 0.95rem;'>যদি উপরের বাটনটি কাজ না করে, তবে নিচের লিংকটি কপি করে আপনার ব্রাউজারে প্রবেশ করান:</p>
                    <p style='word-break: break-all; font-size: 0.9rem; color: #0b7c4d;'><a href='" . $question_url . "'>" . $question_url . "</a></p>
                    
                    <hr style='border: none; border-top: 1px solid #eee; margin: 25px 0;'>
                    <p style='font-size: 0.8rem; color: #94a3b8; text-align: center;'>ধন্যবাদান্তে,<br>" . htmlspecialchars($this->siteSettings['site_title'] ?? 'Islamic News Portal') . "</p>
                </div>";

                try {
                    \App\Helpers\Mailer::sendAsync($question['email'], $subject, $message, $this->siteSettings);
                } catch (\Exception $e) {
                    // Ignore mail error on local environment
                }

                header('Location: ' . URLROOT . '/admin/questions?msg=answered');
                exit;
            }
        }

        $answers = $this->adminModel->getQuestionAnswers($id);

        $this->view('admin/answer_question', [
            'title' => 'Answer Question',
            'question' => $question,
            'answers' => $answers,
            'current_page' => 'questions',
            'settings' => $this->siteSettings
        ]);
    }

    public function approve_question($id) {
        $this->adminModel->answerUserQuestion($id, '');
        header('Location: ' . URLROOT . '/admin/questions?msg=answered');
        exit;
    }

    public function delete_question($id) {
        $this->adminModel->deleteUserQuestion($id);
        header('Location: ' . URLROOT . '/admin/questions?msg=deleted');
        exit;
    }

    public function bulk_questions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $ids = $_POST['question_ids'] ?? [];
            if (!empty($ids) && is_array($ids)) {
                $ids = array_map('intval', $ids);
                if ($action === 'delete') {
                    $this->adminModel->bulkDeleteUserQuestions($ids);
                    header('Location: ' . URLROOT . '/admin/questions?msg=deleted');
                    exit;
                } elseif ($action === 'approve') {
                    $this->adminModel->bulkApproveUserQuestions($ids);
                    header('Location: ' . URLROOT . '/admin/questions?msg=approved');
                    exit;
                }
            }
        }
        header('Location: ' . URLROOT . '/admin/questions');
        exit;
    }

    // Question Categories CRUD
    public function question_categories() {
        $adminModel = $this->model('AdminModel');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($name, 'UTF-8')), '-');
            if (!empty($name)) {
                $adminModel->addQuestionCategory($name, $slug);
                header('Location: ' . URLROOT . '/admin/question_categories?msg=added');
                exit;
            }
        }
        $categories = $adminModel->getQuestionCategories();
        $this->view('admin/question_categories', [
            'categories' => $categories,
            'current_page' => 'question_categories',
            'settings' => $this->siteSettings
        ]);
    }

    public function edit_question_category($id) {
        $adminModel = $this->model('AdminModel');
        $category = $adminModel->getQuestionCategoryById($id);
        if (!$category) {
            header('Location: ' . URLROOT . '/admin/question_categories');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($name, 'UTF-8')), '-');
            if (!empty($name)) {
                $adminModel->updateQuestionCategory($id, $name, $slug);
                header('Location: ' . URLROOT . '/admin/question_categories?msg=updated');
                exit;
            }
        }

        $this->view('admin/edit_question_category', [
            'category' => $category,
            'current_page' => 'question_categories',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_question_category($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->deleteQuestionCategory($id);
        header('Location: ' . URLROOT . '/admin/question_categories?msg=deleted');
        exit;
    }

    // Guest Answers Approval & Moderation
    public function approve_answer($id) {
        $adminModel = $this->model('AdminModel');
        $answer = $adminModel->getQuestionAnswerById($id);
        if (!$answer) {
            header('Location: ' . URLROOT . '/admin/questions');
            exit;
        }

        $adminModel->approveQuestionAnswer($id);

        // Notify asker if email exists
        $question = $adminModel->getUserQuestionById($answer['question_id']);
        if ($question) {
            if ($question['status'] === 'pending') {
                $adminModel->answerUserQuestion($question['id'], 'অন্যান্য উত্তর দেখুন।');
            }

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $question_url = $protocol . $host . URLROOT . '/question/' . $question['id'];

            $subject = "আপনার প্রশ্নের একটি নতুন উত্তর অ্যাপ্রুভ করা হয়েছে - " . ($this->siteSettings['site_title'] ?? 'Islamic News Portal');
            $message = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px;'>
                <h2 style='color: #0b7c4d; text-align: center;'>" . htmlspecialchars($this->siteSettings['site_title'] ?? 'Islamic News Portal') . "</h2>
                <p>আসসালামু আলাইকুম <strong>" . htmlspecialchars($question['name']) . "</strong>,</p>
                <p>আপনার পাঠানো প্রশ্নটির একটি নতুন উত্তর এডমিন প্যানেল থেকে অ্যাপ্রুভ করা হয়েছে।</p>
                
                <div style='background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0b7c4d;'>
                    <strong>আপনার প্রশ্ন:</strong><br>
                    " . nl2br(htmlspecialchars($question['question'])) . "
                </div>

                <div style='background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2563eb;'>
                    <strong>নতুন উত্তর (অ্যাপ্রুভকৃত):</strong><br>
                    " . nl2br(htmlspecialchars($answer['answer'])) . "
                </div>

                <p style='text-align: center; margin: 30px 0;'>
                    <a href='" . $question_url . "' style='background: #0b7c4d; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: bold;'>উত্তরটি দেখতে এখানে ক্লিক করুন</a>
                </p>

                <p style='color: #64748b; font-size: 0.95rem;'>যদি উপরের বাটনটি কাজ না করে, তবে নিচের লিংকটি কপি করে আপনার ব্রাউজারে প্রবেশ করান:</p>
                <p style='word-break: break-all; font-size: 0.9rem; color: #0b7c4d;'><a href='" . $question_url . "'>" . $question_url . "</a></p>
                
                <hr style='border: none; border-top: 1px solid #eee; margin: 25px 0;'>
                <p style='font-size: 0.8rem; color: #94a3b8; text-align: center;'>ধন্যবাদান্তে,<br>" . htmlspecialchars($this->siteSettings['site_title'] ?? 'Islamic News Portal') . "</p>
            </div>";

            try {
                \App\Helpers\Mailer::sendAsync($question['email'], $subject, $message, $this->siteSettings);
            } catch (\Exception $e) {
                // Ignore mail error
            }
        }

        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'answer_question/' . $answer['question_id'];
        header('Location: ' . URLROOT . '/admin/' . $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . 'msg=approved');
        exit;
    }

    public function edit_answer($id) {
        $adminModel = $this->model('AdminModel');
        $answer = $adminModel->getQuestionAnswerById($id);
        if (!$answer) {
            header('Location: ' . URLROOT . '/admin/questions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_answer = trim($_POST['answer']);
            if (!empty($new_answer)) {
                $adminModel->updateQuestionAnswer($id, $new_answer);
                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'answer_question/' . $answer['question_id'];
                header('Location: ' . URLROOT . '/admin/' . $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . 'msg=updated');
                exit;
            }
        }

        $this->view('admin/edit_answer', [
            'answer' => $answer,
            'current_page' => 'questions',
            'settings' => $this->siteSettings
        ]);
    }

    public function delete_answer($id) {
        $adminModel = $this->model('AdminModel');
        $answer = $adminModel->getQuestionAnswerById($id);
        if ($answer) {
            $adminModel->deleteQuestionAnswer($id);
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'answer_question/' . $answer['question_id'];
            $msg = ($redirect === 'questions') ? 'ans_deleted' : 'deleted';
            header('Location: ' . URLROOT . '/admin/' . $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . 'msg=' . $msg);
            exit;
        }
        header('Location: ' . URLROOT . '/admin/questions');
        exit;
    }

    public function send_test_email() {
        header('Content-Type: application/json');
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $to = trim($data['test_email'] ?? '');
        
        if (empty($to)) {
            echo json_encode(['success' => false, 'message' => 'অনুগ্রহ করে একটি সঠিক ইমেইল ঠিকানা প্রদান করুন।']);
            exit;
        }
        
        $settings = [
            'mail_method'    => $data['mail_method'] ?? 'smtp',
            'mail_from_email'=> $data['mail_from_email'] ?? '',
            'smtp_host'      => $data['smtp_host'] ?? '',
            'smtp_port'      => $data['smtp_port'] ?? '',
            'smtp_user'      => $data['smtp_user'] ?? '',
            'smtp_pass'      => $data['smtp_pass'] ?? '',
            'smtp_encryption'=> $data['smtp_encryption'] ?? '',
            'smtp_from_name' => $data['smtp_from_name'] ?? '',
            'site_title'     => $this->siteSettings['site_title'] ?? 'Response with Nur-Lab'
        ];
        
        $subject = "মেইল সার্ভার টেস্ট (SMTP Live Connection Test)";
        $message = "
        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px; max-width: 500px; margin: 0 auto;'>
            <h2 style='color: #10b981; text-align: center;'>" . htmlspecialchars($settings['site_title']) . "</h2>
            <p>আসসালামু আলাইকুম,</p>
            <p>আপনার মেইল সার্ভার কনফিগারেশন সফলভাবে কাজ করছে! এটি একটি লাইভ টেস্ট ইমেইল।</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
            <p style='font-size: 0.8rem; color: #94a3b8; text-align: center;'>ধন্যবাদান্তে,<br>" . htmlspecialchars($settings['site_title']) . "</p>
        </div>";
        
        try {
            if (\App\Helpers\Mailer::send($to, $subject, $message, $settings)) {
                echo json_encode(['success' => true, 'message' => 'টেস্ট ইমেইল সফলভাবে পাঠানো হয়েছে! অনুগ্রহ করে ' . htmlspecialchars($to) . ' ঠিকানার ইনবক্স বা স্প্যাম ফোল্ডার চেক করুন।']);
            } else {
                echo json_encode(['success' => false, 'message' => 'টেস্ট মেইল পাঠাতে ব্যর্থ হয়েছে! আপনার SMTP হোস্ট, পোর্ট, ইউজারনেম বা পাসওয়ার্ড চেক করুন।']);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'SMTP সংযোগ ত্রুটি: ' . $e->getMessage()]);
        }
        exit;
    }

    public function sitemap() {
        $adminModel = $this->model('AdminModel');
        $data = [];
        
        // Handle regeneration request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
            try {
                $db = \Config\Database::pdoConnect();
                
                // Get all published posts
                $stmt = $db->query("SELECT slug, created_at FROM posts WHERE status = 'published' ORDER BY created_at DESC");
                $posts = $stmt->fetchAll();
                
                // Get all categories
                $stmt = $db->query("SELECT slug FROM categories ORDER BY name ASC");
                $categories = $stmt->fetchAll();
                
                // Get all answered questions
                $stmt = $db->query("SELECT id, question, created_at FROM user_questions WHERE status = 'answered' ORDER BY created_at DESC");
                $questions = $stmt->fetchAll();
                
                // Base static pages
                $staticUrls = [
                    '',
                    'about',
                    'contact',
                    'donate',
                    'join',
                    'ask',
                    'qa',
                    'videos',
                    'blog'
                ];
                
                // Start building XML
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                
                // Add static pages
                foreach ($staticUrls as $url) {
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . URLROOT . ($url !== '' ? '/' . $url : '') . '</loc>' . "\n";
                    $xml .= '    <changefreq>daily</changefreq>' . "\n";
                    $xml .= '    <priority>1.00</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                }
                
                // Add posts
                foreach ($posts as $post) {
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . URLROOT . '/' . htmlspecialchars($post['slug']) . '</loc>' . "\n";
                    $xml .= '    <lastmod>' . date('Y-m-d', strtotime($post['created_at'])) . '</lastmod>' . "\n";
                    $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                    $xml .= '    <priority>0.80</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                }
                
                // Add post categories
                foreach ($categories as $cat) {
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . URLROOT . '/' . htmlspecialchars($cat['slug']) . '</loc>' . "\n";
                    $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                    $xml .= '    <priority>0.70</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                }
                
                // Add questions
                foreach ($questions as $q) {
                    $trimmed_question = mb_strimwidth($q['question'], 0, 100);
                    $correct_slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($trimmed_question, 'UTF-8')), '-');
                    
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . URLROOT . '/question/' . $q['id'] . '/' . urlencode($correct_slug) . '</loc>' . "\n";
                    $xml .= '    <lastmod>' . date('Y-m-d', strtotime($q['created_at'])) . '</lastmod>' . "\n";
                    $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                    $xml .= '    <priority>0.64</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                }
                
                $xml .= '</urlset>';
                
                // Write XML to root directory (htdocs/response.nur-lab.com/sitemap.xml)
                if (file_put_contents(APPROOT . '/../sitemap.xml', $xml)) {
                    $data['success'] = 'Sitemap (sitemap.xml) generated successfully!';
                } else {
                    $data['error'] = 'Could not write sitemap.xml. Check file permissions.';
                }
            } catch (\Exception $e) {
                $data['error'] = 'Error generating sitemap: ' . $e->getMessage();
            }
        }
        
        // Fetch sitemap stats for viewing
        $data['sitemap_exists'] = file_exists(APPROOT . '/../sitemap.xml');
        if ($data['sitemap_exists']) {
            $data['sitemap_last_modified'] = date("Y-m-d H:i:s", filemtime(APPROOT . '/../sitemap.xml'));
            $data['sitemap_size'] = round(filesize(APPROOT . '/../sitemap.xml') / 1024, 2) . ' KB';
        } else {
            $data['sitemap_last_modified'] = 'Never';
            $data['sitemap_size'] = '0 KB';
        }
        
        try {
            $db = \Config\Database::pdoConnect();
            $data['count_posts'] = $db->query("SELECT COUNT(*) FROM posts WHERE status = 'published'")->fetchColumn();
            $data['count_categories'] = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
            $data['count_questions'] = $db->query("SELECT COUNT(*) FROM user_questions WHERE status = 'answered'")->fetchColumn();
        } catch (\Exception $ex) {
            $data['count_posts'] = 0;
            $data['count_categories'] = 0;
            $data['count_questions'] = 0;
        }
        
        $data['settings'] = $this->siteSettings;
        $data['current_page'] = 'sitemap';
        
        $this->view('admin/sitemap', $data);
    }

    public function restore_db() {
        set_time_limit(0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['backup_file'])) {
            $file = $_FILES['backup_file'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['restore_error'] = 'File upload failed with error code ' . $file['error'];
                header('Location: ' . URLROOT . '/admin/backup');
                exit;
            }
            
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) !== 'sql') {
                $_SESSION['restore_error'] = 'Invalid file type. Only .sql files are allowed.';
                header('Location: ' . URLROOT . '/admin/backup');
                exit;
            }
            
            try {
                $db = \Config\Database::pdoConnect();
                
                // Read SQL file content line by line to build queries
                $queries = [];
                $current_query = '';
                
                $handle = fopen($file['tmp_name'], "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        // Skip SQL comments
                        if (substr(trim($line), 0, 2) === '--' || substr(trim($line), 0, 2) === '/*' || trim($line) === '') {
                            continue;
                        }
                        $current_query .= $line;
                        if (substr(trim($line), -1) === ';') {
                            $queries[] = $current_query;
                            $current_query = '';
                        }
                    }
                    fclose($handle);
                }
                
                $db->exec("SET FOREIGN_KEY_CHECKS=0;");
                foreach ($queries as $query) {
                    if (trim($query) !== '') {
                        $db->exec($query);
                    }
                }
                $db->exec("SET FOREIGN_KEY_CHECKS=1;");
                
                $_SESSION['restore_success'] = 'Database restored successfully!';
                header('Location: ' . URLROOT . '/admin/backup');
                exit;
            } catch (\Exception $e) {
                try {
                    $db = \Config\Database::pdoConnect()->exec("SET FOREIGN_KEY_CHECKS=1;");
                } catch (\Exception $ex) {}
                
                $_SESSION['restore_error'] = 'Database restore failed: ' . $e->getMessage();
                header('Location: ' . URLROOT . '/admin/backup');
                exit;
            }
        }
        
        header('Location: ' . URLROOT . '/admin/backup');
        exit;
    }

    public function auto_generate_seo() {
        $adminModel = $this->model('AdminModel');
        $count = $adminModel->bulkGenerateMissingSeo();
        if ($count !== false) {
            header('Location: ' . URLROOT . '/admin/index?msg=seo_generated&count=' . $count);
        } else {
            header('Location: ' . URLROOT . '/admin/index?msg=seo_error');
        }
        exit;
    }
}

