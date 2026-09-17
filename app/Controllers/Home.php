<?php
namespace App\Controllers;
use App\Core\Controller;

class Home extends Controller {
    public function proxy_tts() {
        $text = isset($_GET['text']) ? trim($_GET['text']) : '';
        if (empty($text)) {
            header("HTTP/1.1 400 Bad Request");
            exit("Text is required");
        }
        
        $lang = isset($_GET['lang']) ? trim($_GET['lang']) : 'bn';
        
        $url = "https://translate.google.com/translate_tts?ie=UTF-8&tl=" . urlencode($lang) . "&client=tw-ob&q=" . urlencode($text);
        
        $audio = false;

        // Try cURL first (which works on live hosts where allow_url_fopen is disabled)
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

        // Fallback to file_get_contents if cURL was disabled or failed
        if ($audio === false) {
            $options = [
                "http" => [
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36\r\n",
                    "timeout" => 10
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
        $data = \App\Helpers\Cache::get('home_page');
        if ($data === null) {
            $postModel = $this->model('PostModel');
            $adminModel = $this->model('AdminModel');
            
            $data = [
                'title' => 'Home',
                'posts' => $postModel->getAllPosts(12),
                'slides' => $adminModel->getSlides(),
                'breaking_news' => $adminModel->getBreakingNews(),
                'prayer_times' => $adminModel->getPrayerTimes(),
                'team' => $adminModel->getTeamMembers(),
                'scopes' => $adminModel->getScopes(),
                'about_sections' => $adminModel->getAboutSections(),
                'reviews' => $adminModel->getReviews(),
                'faqs' => $adminModel->getFaqs(true),
                'menus' => $adminModel->getMenus(),
                'sub_menus' => $adminModel->getSubMenus(),
                'settings' => $adminModel->getSettings(),
                'yt_videos' => $adminModel->getYTVideos(),
                'recent_questions' => $adminModel->getUserQuestions(18, 'answered')
            ];
            \App\Helpers\Cache::set('home_page', $data, 300);
        }

        $isMobile = false;
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
        }

        if ($isMobile) {
            $this->view('home/mobile_index', $data);
        } else {
            $this->view('home/index', $data);
        }
    }

    public function post($slug) {
        $cache_key = 'post_page_' . $slug;
        $data = \App\Helpers\Cache::get($cache_key);
        
        $postModel = $this->model('PostModel');
        
        if ($data === null) {
            $post = \App\Helpers\Cache::get('post_lookup_' . $slug);
            if ($post === null) {
                $post = $postModel->getPostBySlug($slug);
                if ($post) {
                    \App\Helpers\Cache::set('post_lookup_' . $slug, $post, 300);
                }
            }
            
            if (!$post) {
                header('Location: ' . URLROOT);
                exit;
            }

            $adminModel = $this->model('AdminModel');
            $db = \Config\Database::pdoConnect();
            $stmt = $db->prepare("SELECT * FROM comments WHERE post_id = ? AND status = 'approved' ORDER BY created_at ASC");
            $stmt->execute([$post['id']]);
            $comments = $stmt->fetchAll();

            $data = [
                'title' => $post['title'],
                'post' => $post,
                'post_categories' => $postModel->getPostCategories($post['id']),
                'post_authors' => $postModel->getPostAuthors($post['id']),
                'related_posts' => $postModel->getRelatedPosts($post['category_id'], $post['id'], 5),
                'recent_posts' => $postModel->getAllPosts(5),
                'popular_posts' => $postModel->getPopularPosts(5),
                'comments' => $comments,
                'sidebar_slides' => $adminModel->getSidebarSlides(),
                'recent_questions' => $adminModel->getUserQuestions(5, 'answered'),
                'settings' => $adminModel->getSettings(),
                'menus' => $adminModel->getMenus(),
                'sub_menus' => $adminModel->getSubMenus(),
                'breaking_news' => $adminModel->getBreakingNews(),
                'prayer_times' => $adminModel->getPrayerTimes()
            ];
            \App\Helpers\Cache::set($cache_key, $data, 300);
        }

        // Increment views and load live view count from database to bypass cache
        $postModel->incrementViews($data['post']['id']);
        $data['post']['views'] = $postModel->getPostViews($data['post']['id']);

        $this->view('home/post', $data);
    }

    public function videos() {
        $data = \App\Helpers\Cache::get('videos_page');
        if ($data === null) {
            $adminModel = $this->model('AdminModel');
            $data = [
                'title' => 'সবগুলো ভিডিও',
                'yt_videos' => $adminModel->getYTVideos(),
                'breaking_news' => $adminModel->getBreakingNews(),
                'slides' => $adminModel->getSlides(),
                'settings' => $adminModel->getSettings(),
                'menus' => $adminModel->getMenus(),
                'sub_menus' => $adminModel->getSubMenus(),
                'prayer_times' => $adminModel->getPrayerTimes()
            ];
            \App\Helpers\Cache::set('videos_page', $data, 300);
        }

        $this->view('home/videos', $data);
    }

    public function blog($category_slug = null) {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page < 1) $page = 1;
        $cache_key = 'blog_page_' . ($category_slug ?? 'all') . '_' . md5($search) . '_page_' . $page;
        
        $data = \App\Helpers\Cache::get($cache_key);
        
        if ($data === null) {
            $postModel = $this->model('PostModel');
            $adminModel = $this->model('AdminModel');
            
            $category_id = null;
            $category_name = 'সবগুলো নিবন্ধ';
            
            if ($category_slug !== null) {
                $db = \Config\Database::pdoConnect();
                $stmt = $db->prepare("SELECT * FROM categories WHERE slug = :slug");
                $stmt->execute(['slug' => $category_slug]);
                $category = $stmt->fetch();
                if ($category) {
                    $category_id = $category['id'];
                    $category_name = $category['name'];
                }
            }
            
            if (!empty($search)) {
                $category_name = 'সার্চ ফলাফল: ' . htmlspecialchars($search);
                $db = \Config\Database::pdoConnect();
                $stmt = $db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                                      FROM posts p 
                                      LEFT JOIN post_categories pc ON p.id = pc.post_id
                                      LEFT JOIN categories c ON pc.category_id = c.id 
                                      WHERE p.status = 'published' AND (p.title LIKE :search OR p.content LIKE :search) 
                                      GROUP BY p.id
                                      ORDER BY p.created_at DESC");
                $stmt->execute(['search' => '%' . $search . '%']);
                $posts = $stmt->fetchAll();
                
                foreach ($posts as &$post) {
                    if (empty($post['category_name']) && !empty($post['category_id'])) {
                        $stmt2 = $db->prepare("SELECT name FROM categories WHERE id = :cat_id");
                        $stmt2->execute(['cat_id' => $post['category_id']]);
                        $post['category_name'] = $stmt2->fetchColumn();
                    }
                }
            } elseif ($category_id !== null) {
                $db = \Config\Database::pdoConnect();
                $stmt = $db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                                      FROM posts p 
                                      LEFT JOIN post_categories pc ON p.id = pc.post_id
                                      LEFT JOIN categories c ON pc.category_id = c.id 
                                      WHERE p.status = 'published' 
                                      AND (p.category_id = :category_id OR p.id IN (SELECT post_id FROM post_categories WHERE category_id = :category_id))
                                      GROUP BY p.id
                                      ORDER BY p.created_at DESC");
                $stmt->execute(['category_id' => $category_id]);
                $posts = $stmt->fetchAll();

                foreach ($posts as &$post) {
                    if (empty($post['category_name']) && !empty($post['category_id'])) {
                        $stmt2 = $db->prepare("SELECT name FROM categories WHERE id = :cat_id");
                        $stmt2->execute(['cat_id' => $post['category_id']]);
                        $post['category_name'] = $stmt2->fetchColumn();
                    }
                }
            } else {
                $posts = $postModel->getAllPosts(2000);
            }
            
            // Pagination logic (15 posts per page)
            $limit = 15;
            $total_posts = count($posts);
            $total_pages = ceil($total_posts / $limit);
            if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
            $offset = ($page - 1) * $limit;
            $paginated_posts = array_slice($posts, $offset, $limit);
            
            $settings = $adminModel->getSettings();
            
            $dont_miss_posts = [];
            $dont_miss_slug = $settings['dont_miss_category'] ?? '';
            if (!empty($dont_miss_slug)) {
                $db = \Config\Database::pdoConnect();
                $stmt = $db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                                      FROM posts p 
                                      LEFT JOIN post_categories pc ON p.id = pc.post_id
                                      LEFT JOIN categories c ON pc.category_id = c.id 
                                      WHERE p.status = 'published' 
                                      AND (c.slug = :slug OR p.category_id IN (SELECT id FROM categories WHERE slug = :slug))
                                      GROUP BY p.id
                                      ORDER BY p.created_at DESC LIMIT 5");
                $stmt->execute(['slug' => $dont_miss_slug]);
                $dont_miss_posts = $stmt->fetchAll();
                
                foreach ($dont_miss_posts as &$post) {
                    if (empty($post['category_name']) && !empty($post['category_id'])) {
                        $stmt2 = $db->prepare("SELECT name FROM categories WHERE id = :cat_id");
                        $stmt2->execute(['cat_id' => $post['category_id']]);
                        $post['category_name'] = $stmt2->fetchColumn();
                    }
                }
            }
            
            $data = [
                'title' => $category_name,
                'posts' => $paginated_posts,
                'current_page' => $page,
                'total_pages' => $total_pages,
                'dont_miss_posts' => $dont_miss_posts,
                'categories' => $postModel->getCategories(),
                'popular_posts' => $postModel->getPopularPosts(5),
                'breaking_news' => $adminModel->getBreakingNews(),
                'settings' => $settings,
                'menus' => $adminModel->getMenus(),
                'sub_menus' => $adminModel->getSubMenus(),
                'prayer_times' => $adminModel->getPrayerTimes(),
                'category_slug' => $category_slug,
                'search' => $search,
                'sidebar_slides' => $adminModel->getSidebarSlides(),
                'recent_questions' => $adminModel->getUserQuestions(5, 'answered'),
                'recent_posts' => $postModel->getAllPosts(5)
            ];
            
            \App\Helpers\Cache::set($cache_key, $data, 300);
        }

        $this->view('home/blog', $data);
    }

    public function dont_miss_posts_ajax() {
        $slug = $_GET['category'] ?? '';
        if (empty($slug)) {
            echo '<div style="grid-column: 1 / span 2; padding: 40px; text-align: center; color: #64748b; font-style: italic;">No category selected.</div>';
            exit;
        }

        $cache_key = 'ajax_dont_miss_' . $slug;
        $html = \App\Helpers\Cache::get($cache_key);
        if ($html !== null) {
            echo $html;
            exit;
        }

        ob_start();
        $db = \Config\Database::pdoConnect();
        $stmt = $db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                              FROM posts p 
                              LEFT JOIN post_categories pc ON p.id = pc.post_id
                              LEFT JOIN categories c ON pc.category_id = c.id 
                              WHERE p.status = 'published' 
                              AND (c.slug = :slug OR p.category_id IN (SELECT id FROM categories WHERE slug = :slug))
                              GROUP BY p.id
                              ORDER BY p.created_at DESC LIMIT 5");
        $stmt->execute(['slug' => $slug]);
        $posts = $stmt->fetchAll();
        
        foreach ($posts as &$post) {
            if (empty($post['category_name']) && !empty($post['category_id'])) {
                $stmt2 = $db->prepare("SELECT name FROM categories WHERE id = :cat_id");
                $stmt2->execute(['cat_id' => $post['category_id']]);
                $post['category_name'] = $stmt2->fetchColumn();
            }
        }

        if (empty($posts)) {
            echo '<div style="grid-column: 1 / span 2; padding: 40px; text-align: center; color: #64748b; font-style: italic;">No posts found in this category.</div>';
            $html = ob_get_clean();
            \App\Helpers\Cache::set($cache_key, $html, 300);
            echo $html;
            exit;
        }

        $resolve_image = function($img) {
            if (empty($img)) {
                return URLROOT . '/public/img/placeholder.jpg';
            }
            if (strpos($img, 'http') === 0) {
                return $img;
            }
            $clean_name = basename($img);
            return URLROOT . '/public/img/' . $clean_name;
        };

        $left_html = '';
        $right_html = '';

        if (isset($posts[0])) {
            $dm_feat = $posts[0];
            $dm_feat_img = $resolve_image($dm_feat['featured_image']);
            $feat_url = URLROOT . '/' . $dm_feat['slug'];
            $feat_cat = htmlspecialchars($dm_feat['category_name'] ?? 'ইসলামিক');
            $feat_title = htmlspecialchars($dm_feat['title']);
            $feat_date = date('d M, Y', strtotime($dm_feat['created_at']));
            $feat_excerpt = htmlspecialchars(strip_tags(!empty($dm_feat['excerpt']) ? $dm_feat['excerpt'] : $dm_feat['content']));
            if (mb_strlen($feat_excerpt) > 180) {
                $feat_excerpt = mb_substr($feat_excerpt, 0, 180) . '...';
            }

            $left_html = '
            <div style="display: flex; flex-direction: column;">
                <div style="position: relative; overflow: hidden; height: 350px; background: #f1f5f9; border-radius: 2px; margin-bottom: 15px;">
                    <a href="' . $feat_url . '" style="display: block; width: 100%; height: 100%;">
                        <img src="' . $dm_feat_img . '" alt="' . $feat_title . '" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;" onmouseover="this.style.transform=\'scale(1.05)\';" onmouseout="this.style.transform=\'scale(1)\';">
                    </a>
                    <span style="position: absolute; bottom: 15px; left: 15px; background: #111; color: #fff; padding: 3px 8px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                        ' . $feat_cat . '
                    </span>
                </div>
                <h3 style="font-family: \'Noto Serif Bengali\', serif; font-size: 1.7rem; font-weight: 700; line-height: 1.3; margin-bottom: 10px;">
                    <a href="' . $feat_url . '" style="color: #111; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color=\'#FFC81E\';" onmouseout="this.style.color=\'#111\';">
                        ' . $feat_title . '
                    </a>
                </h3>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <span style="color: #111;">এডমিন</span>
                    <span>-</span>
                    <span>' . $feat_date . '</span>
                    <span>-</span>
                    <span style="background: #111; color: #fff; padding: 2px 6px; font-size: 0.65rem; font-weight: 700; border-radius: 2px;">
                        <i class="far fa-comments"></i> 0
                    </span>
                </div>
                <p style="font-size: 0.92rem; color: #64748b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 15px;">
                    ' . $feat_excerpt . '
                </p>
                <div style="display: flex; gap: 5px;">
                    <button style="border: 1px solid #e2e8f0; background: #fff; width: 32px; height: 30px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.75rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor=\'#111\'; this.style.color=\'#111\';" onmouseout="this.style.borderColor=\'#e2e8f0\'; this.style.color=\'#64748b\';">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button style="border: 1px solid #e2e8f0; background: #fff; width: 32px; height: 30px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.75rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor=\'#111\'; this.style.color=\'#111\';" onmouseout="this.style.borderColor=\'#e2e8f0\'; this.style.color=\'#64748b\';">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            ';
        }

        $right_html = '<div style="display: flex; flex-direction: column; gap: 20px;">';
        foreach (array_slice($posts, 1) as $dm_post) {
            $dm_post_img = $resolve_image($dm_post['featured_image']);
            $post_url = URLROOT . '/' . $dm_post['slug'];
            $post_title = htmlspecialchars($dm_post['title']);
            $post_date = date('M d, Y', strtotime($dm_post['created_at']));
            
            $right_html .= '
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <div style="flex: 0 0 140px; height: 95px; overflow: hidden; background: #f1f5f9; border-radius: 2px;">
                    <a href="' . $post_url . '" style="display: block; width: 100%; height: 100%;">
                        <img src="' . $dm_post_img . '" alt="' . $post_title . '" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;" onmouseover="this.style.transform=\'scale(1.05)\';" onmouseout="this.style.transform=\'scale(1)\';">
                    </a>
                </div>
                <div style="flex: 1;">
                    <h4 style="font-family: \'Noto Serif Bengali\', serif; font-size: 1.05rem; font-weight: 700; line-height: 1.3; margin-bottom: 6px;">
                        <a href="' . $post_url . '" style="color: #111; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color=\'#FFC81E\';" onmouseout="this.style.color=\'#111\';">
                            ' . $post_title . '
                        </a>
                    </h4>
                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">
                        ' . $post_date . '
                    </span>
                </div>
            </div>
            ';
        }
        $right_html .= '</div>';

        echo $left_html . $right_html;
        $html = ob_get_clean();
        \App\Helpers\Cache::set($cache_key, $html, 300);
        echo $html;
        exit;
    }

    public function category_posts_ajax() {
        $slug = $_GET['category'] ?? '';
        if (empty($slug)) {
            echo '<div style="grid-column: 1 / span 2; padding: 40px; text-align: center; color: #64748b; font-style: italic;">No category selected.</div>';
            exit;
        }

        $cache_key = 'ajax_category_posts_' . $slug;
        $html = \App\Helpers\Cache::get($cache_key);
        if ($html !== null) {
            echo $html;
            exit;
        }

        ob_start();
        $db = \Config\Database::pdoConnect();
        
        $stmt_cat = $db->prepare("SELECT id, name FROM categories WHERE slug = ? LIMIT 1");
        $stmt_cat->execute([$slug]);
        $category = $stmt_cat->fetch();
        if (!$category) {
            echo '<div style="grid-column: 1 / span 2; padding: 40px; text-align: center; color: #64748b; font-style: italic;">Category not found.</div>';
            $html = ob_get_clean();
            \App\Helpers\Cache::set($cache_key, $html, 300);
            echo $html;
            exit;
        }
        $category_id = $category['id'];
        $category_name = $category['name'];

        $stmt = $db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                              FROM posts p 
                              LEFT JOIN post_categories pc ON p.id = pc.post_id
                              LEFT JOIN categories c ON pc.category_id = c.id 
                              WHERE p.status = 'published' 
                              AND (p.category_id = :category_id OR p.id IN (SELECT post_id FROM post_categories WHERE category_id = :category_id))
                              GROUP BY p.id
                              ORDER BY p.created_at DESC LIMIT 6");
        $stmt->execute(['category_id' => $category_id]);
        $posts_list = $stmt->fetchAll();

        foreach ($posts_list as &$post) {
            if (empty($post['category_name']) && !empty($post['category_id'])) {
                $stmt2 = $db->prepare("SELECT name FROM categories WHERE id = :cat_id");
                $stmt2->execute(['cat_id' => $post['category_id']]);
                $post['category_name'] = $stmt2->fetchColumn();
            }
        }

        if (empty($posts_list)) {
            echo '<div style="grid-column: 1 / span 2; padding: 40px; text-align: center; color: #64748b; font-style: italic;">No posts found in this category.</div>';
            $html = ob_get_clean();
            \App\Helpers\Cache::set($cache_key, $html, 300);
            echo $html;
            exit;
        }

        $resolve_image = function($img) {
            if (empty($img)) {
                return URLROOT . '/public/img/earth.jpg';
            }
            if (strpos($img, 'http') === 0) {
                return $img;
            }
            return URLROOT . '/public/img/' . basename($img);
        };

        echo '<div>';
        if (isset($posts_list[0])) {
            $p = $posts_list[0];
            $img = $resolve_image($p['featured_image']);
            $excerpt = strip_tags(!empty($p['excerpt']) ? $p['excerpt'] : $p['content']);
            if (mb_strlen($excerpt) > 180) {
                $excerpt = mb_substr($excerpt, 0, 180) . '...';
            }
            echo '
            <div class="np-post-card">
                <div class="np-post-image" style="height: 180px;">
                    <img src="' . $img . '" alt="' . htmlspecialchars($p['title']) . '">
                </div>
                <h3 class="np-post-title"><a href="' . URLROOT . '/' . $p['slug'] . '">' . htmlspecialchars($p['title']) . '</a></h3>
                <div class="np-post-meta">
                    <span>Admin</span>
                    <span>-</span>
                    <span>' . date('M d, Y', strtotime($p['created_at'])) . '</span>
                </div>
                <p class="np-post-excerpt">' . $excerpt . '</p>
            </div>';
        }

        for ($i = 2; $i <= 3; $i++) {
            if (isset($posts_list[$i])) {
                $p = $posts_list[$i];
                $img = $resolve_image($p['featured_image']);
                echo '
                <div class="np-list-item">
                    <div class="np-list-thumb">
                        <img src="' . $img . '" alt="' . htmlspecialchars($p['title']) . '">
                    </div>
                    <div>
                        <h4 class="np-list-title"><a href="' . URLROOT . '/' . $p['slug'] . '">' . htmlspecialchars($p['title']) . '</a></h4>
                        <div class="np-list-meta">' . date('M d, Y', strtotime($p['created_at'])) . '</div>
                    </div>
                </div>';
            }
        }
        echo '</div>';

        echo '<div>';
        if (isset($posts_list[1])) {
            $p = $posts_list[1];
            $img = $resolve_image($p['featured_image']);
            $excerpt = strip_tags(!empty($p['excerpt']) ? $p['excerpt'] : $p['content']);
            if (mb_strlen($excerpt) > 180) {
                $excerpt = mb_substr($excerpt, 0, 180) . '...';
            }
            echo '
            <div class="np-post-card">
                <div class="np-post-image" style="height: 180px;">
                    <img src="' . $img . '" alt="' . htmlspecialchars($p['title']) . '">
                </div>
                <h3 class="np-post-title"><a href="' . URLROOT . '/' . $p['slug'] . '">' . htmlspecialchars($p['title']) . '</a></h3>
                <div class="np-post-meta">
                    <span>Admin</span>
                    <span>-</span>
                    <span>' . date('M d, Y', strtotime($p['created_at'])) . '</span>
                </div>
                <p class="np-post-excerpt">' . $excerpt . '</p>
            </div>';
        }

        for ($i = 4; $i <= 5; $i++) {
            if (isset($posts_list[$i])) {
                $p = $posts_list[$i];
                $img = $resolve_image($p['featured_image']);
                echo '
                <div class="np-list-item">
                    <div class="np-list-thumb">
                        <img src="' . $img . '" alt="' . htmlspecialchars($p['title']) . '">
                    </div>
                    <div>
                        <h4 class="np-list-title"><a href="' . URLROOT . '/' . $p['slug'] . '">' . htmlspecialchars($p['title']) . '</a></h4>
                        <div class="np-list-meta">' . date('M d, Y', strtotime($p['created_at'])) . '</div>
                    </div>
                </div>';
            }
        }
        echo '</div>';
        $html = ob_get_clean();
        \App\Helpers\Cache::set($cache_key, $html, 300);
        echo $html;
        exit;
    }

    public function about() {
        $adminModel = $this->model('AdminModel');
        $data = [
            'title' => 'আমাদের সম্পর্কে',
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'about_sections' => $adminModel->getAboutSections(),
            'team' => $adminModel->getTeamMembers(),
            'scopes' => $adminModel->getScopes(),
            'yt_videos' => $adminModel->getYTVideos(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes()
        ];
        $this->view('home/about', $data);
    }

    public function donate() {
        $adminModel = $this->model('AdminModel');
        $data = [
            'title' => 'দান তহবিল',
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus()
        ];
        $this->view('home/donate', $data);
    }

    public function submit_donation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $settings = $adminModel->getSettings();

            $donor_name = $_POST['donor_name'];
            $donor_email = !empty($_POST['donor_email']) ? $_POST['donor_email'] : null;
            $donor_phone = $_POST['donor_phone'];
            $amount = $_POST['amount'];
            $payment_method = $_POST['payment_method'];

            $donation_data = [
                'donor_name' => $donor_name,
                'donor_email' => $donor_email,
                'donor_phone' => $donor_phone,
                'amount' => $amount,
                'purpose' => null,
                'payment_method' => $payment_method,
                'payment_id' => null,
                'status' => 'pending'
            ];

            if ($payment_method === 'PipraPay') {
                $apiKey = $settings['piprapay_api_key'] ?? '';
                $apiUrl = $settings['piprapay_api_url'] ?? '';

                if (empty($apiUrl)) {
                    $apiUrl = 'https://pay.nur-lab.com/api/checkout/redirect';
                }

                $donation_id = $adminModel->addDonation($donation_data);

                if ($donation_id) {
                    $absoluteRoot = str_replace('://www.', '://', URLROOT);

                    $postData = [
                        'full_name'     => $donor_name,
                        'email_address' => !empty($donor_email) ? $donor_email : 'donor@nur-lab.com',
                        'mobile_number' => $donor_phone,
                        'amount'        => number_format((float)$amount, 2, '.', ''),
                        'currency'      => 'BDT',
                        'return_url'    => $absoluteRoot . '/donation_callback?status=success&donation_id=' . $donation_id,
                        'webhook_url'   => $absoluteRoot . '/donation_callback?status=webhook',
                        'metadata'      => [
                            'donation_id' => $donation_id
                        ]
                    ];

                    $ch = curl_init($apiUrl);
                    curl_setopt_array($ch, [
                        CURLOPT_POST           => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER     => [
                            'MHS-PIPRAPAY-API-KEY: ' . $apiKey,
                            'Content-Type: application/json'
                        ],
                        CURLOPT_POSTFIELDS     => json_encode($postData),
                        CURLOPT_SSL_VERIFYPEER => false
                    ]);

                    $response = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);

                    if (!$err) {
                        $result = json_decode($response, true);
                        if (isset($result['pp_url'])) {
                            if (!empty($result['pp_id'])) {
                                $adminModel->updateDonationPaymentId($donation_id, $result['pp_id']);
                            }
                            header('Location: ' . $result['pp_url']);
                            exit;
                        } else {
                            $_SESSION['donation_error'] = 'পেমেন্ট গেটওয়েতে সংযোগ করতে সমস্যা হয়েছে: ' . ($result['error']['message'] ?? $result['message'] ?? 'Unknown Error');
                            header('Location: ' . URLROOT . '/donate');
                            exit;
                        }
                    } else {
                        $_SESSION['donation_error'] = 'পেমেন্ট গেটওয়ে নেটওয়ার্ক ত্রুটি। আবার চেষ্টা করুন।';
                        header('Location: ' . URLROOT . '/donate');
                        exit;
                    }
                }
            } else {
                $donation_id = $adminModel->addDonation($donation_data);
                if ($donation_id) {
                    $_SESSION['donation_success'] = 'আপনার অফলাইন অনুদান অনুরোধটি পেন্ডিং অবস্থায় সিস্টেমে রেকর্ড করা হয়েছে। অনুগ্রহ করে ব্যাংকে বা ক্যাশ টাকা পরিশোধের পর যোগাযোগ করুন। ধন্যবাদ।';
                    header('Location: ' . URLROOT . '/donate');
                    exit;
                }
            }
        }
        header('Location: ' . URLROOT . '/donate');
        exit;
    }

    public function donation_callback() {
        $donation_id = $_GET['donation_id'] ?? '';
        $status = $_GET['status'] ?? '';
        
        $adminModel = $this->model('AdminModel');
        $donation = $adminModel->getDonationById($donation_id);
        if (!$donation) {
            header('Location: ' . URLROOT);
            exit;
        }
        
        if ($status === 'success') {
            $payment_id = $donation['payment_id'];
            $settings = $adminModel->getSettings();
            $apiKey = $settings['piprapay_api_key'] ?? '';
            $apiUrlSetting = $settings['piprapay_api_url'] ?? '';
            
            if (empty($apiUrlSetting)) {
                $apiUrlSetting = 'https://pay.nur-lab.com/api/checkout/redirect';
            }
            
            $base_url = preg_replace('/\/api\/checkout\/redirect\/?$/i', '', $apiUrlSetting);
            $apiUrl = $base_url . '/api/verify-payment';
            
            $postData = [
                'pp_id' => $payment_id
            ];
            
            $ch = curl_init($apiUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => [
                    "accept: application/json",
                    "content-type: application/json",
                    "MHS-PIPRAPAY-API-KEY: " . $apiKey
                ],
                CURLOPT_POSTFIELDS     => json_encode($postData),
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            
            if (!$err) {
                $result = json_decode($response, true);
                $paymentStatus = strtolower($result['status'] ?? $result['payment_status'] ?? '');
                if ($paymentStatus === 'completed' || $paymentStatus === 'success' || ($result['success'] ?? false) === true) {
                    $adminModel->updateDonationStatus($donation['id'], 'completed');
                    $_SESSION['donation_success'] = 'আপনার অনলাইন অনুদানটি সফলভাবে সম্পন্ন হয়েছে। দ্বীনি কাজে অবদান রাখার জন্য আপনাকে আন্তরিক ধন্যবাদ।';
                    header('Location: ' . URLROOT . '/donate');
                    exit;
                }
            }
            
            $adminModel->updateDonationStatus($donation['id'], 'failed');
            $_SESSION['donation_error'] = 'পেমেন্ট ভেরিফিকেশন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।';
            header('Location: ' . URLROOT . '/donate');
            exit;
        } else {
            $_SESSION['donation_error'] = 'পেমেন্ট প্রক্রিয়াটি বাতিল করা হয়েছে।';
            header('Location: ' . URLROOT . '/donate');
            exit;
        }
    }

    public function contact() {
        $adminModel = $this->model('AdminModel');
        $data = [
            'title' => 'যোগাযোগ',
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes()
        ];
        $this->view('home/contact', $data);
    }

    public function submit_contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
                $msg_data = [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                ];
                
                if ($adminModel->addMessage($msg_data)) {
                    $_SESSION['contact_success'] = 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই যোগাযোগ করব। ধন্যবাদ।';
                } else {
                    $_SESSION['contact_error'] = 'দুঃখিত, বার্তাটি পাঠানো সম্ভব হয়নি। আবার চেষ্টা করুন।';
                }
            } else {
                $_SESSION['contact_error'] = 'অনুগ্রহ করে সবগুলো ঘর পূরণ করুন।';
            }
        }
        header('Location: ' . URLROOT . '/contact');
        exit;
    }

    public function join() {
        $adminModel = $this->model('AdminModel');
        $data = [
            'title' => 'আমাদের সাথে যুক্ত হোন',
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes(),
            'join_cards' => $adminModel->getJoinCards()
        ];
        $this->view('home/join', $data);
    }

    public function ask() {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $question = trim($_POST['question'] ?? '');
            $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

            if (!empty($name) && !empty($email) && !empty($question)) {
                $q_data = [
                    'name' => $name,
                    'email' => $email,
                    'question' => $question,
                    'category_id' => $category_id
                ];

                if ($adminModel->addUserQuestion($q_data)) {
                    $_SESSION['ask_success'] = 'আপনার প্রশ্নটি সফলভাবে জমা দেওয়া হয়েছে! এডমিন উত্তর প্রদান করলে বা কোনো উত্তর অ্যাপ্রুভ করা হলে আপনার ইমেইলে নোটিফিকেশন পাঠানো হবে।';
                } else {
                    $_SESSION['ask_error'] = 'দুঃখিত, আপনার প্রশ্নটি জমা দেওয়া সম্ভব হয়নি। আবার চেষ্টা করুন।';
                }
            } else {
                $_SESSION['ask_error'] = 'অনুগ্রহ করে সবগুলো ঘর পূরণ করুন।';
            }
            header('Location: ' . URLROOT . '/ask');
            exit;
        }

        $categories = $adminModel->getQuestionCategories();

        $data = [
            'title' => 'প্রশ্ন পাঠান',
            'categories' => $categories,
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes()
        ];
        $this->view('home/ask', $data);
    }

    public function question($id, $slug = null) {
        $adminModel = $this->model('AdminModel');
        $question = $adminModel->getUserQuestionById($id);

        if (!$question) {
            header('Location: ' . URLROOT);
            exit;
        }

        // Generate the slug from the question text
        $trimmed_question = mb_strimwidth($question['question'], 0, 100);
        $correct_slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($trimmed_question, 'UTF-8')), '-');

        // Redirect if slug is missing or incorrect
        if (!empty($correct_slug) && rawurldecode($slug) !== $correct_slug) {
            header('Location: ' . URLROOT . '/question/' . $id . '/' . $correct_slug, true, 301);
            exit;
        }

        $answers = $adminModel->getQuestionAnswers($id, 'approved');
        $categories = $adminModel->getQuestionCategories();

        $data = [
            'title' => 'প্রশ্নোত্তর বিবরণ',
            'question' => $question,
            'answers' => $answers,
            'categories' => $categories,
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes()
        ];
        $this->view('home/question', $data);
    }

    public function submit_answer($question_id) {
        $adminModel = $this->model('AdminModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $answer = trim($_POST['answer'] ?? '');

            if (!empty($name) && !empty($email) && !empty($answer)) {
                $a_data = [
                    'question_id' => $question_id,
                    'name' => $name,
                    'email' => $email,
                    'answer' => $answer
                ];

                if ($adminModel->addQuestionAnswer($a_data)) {
                    $_SESSION['answer_success'] = 'আপনার উত্তরটি সফলভাবে জমা দেওয়া হয়েছে! এডমিন রিভিউ করে অ্যাপ্রুভ করার পর এটি প্রকাশ করা হবে।';
                } else {
                    $_SESSION['answer_error'] = 'দুঃখিত, উত্তরটি জমা দেওয়া সম্ভব হয়নি। আবার চেষ্টা করুন।';
                }
            } else {
                $_SESSION['answer_error'] = 'অনুগ্রহ করে সবগুলো ঘর পূরণ করুন।';
            }
        }
        header('Location: ' . URLROOT . '/question/' . $question_id);
        exit;
    }

    public function qa() {
        $adminModel = $this->model('AdminModel');
        $questions = $adminModel->getUserQuestions(null, 'answered');
        $categories = $adminModel->getQuestionCategories();

        $category_slug = isset($_GET['category']) ? trim($_GET['category']) : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;


        $show_bookmarks = isset($_GET['bookmarks']) && $_GET['bookmarks'] == 1;
        if ($show_bookmarks && isset($_SESSION['user_id'])) {
            $questions = $adminModel->getBookmarkedQuestions($_SESSION['user_id']);
            $title = 'পছন্দের প্রশ্নসমূহ';
        } else {
            $questions = $adminModel->getUserQuestions(null, 'answered');
            $title = 'সকল প্রশ্নোত্তর';
        }
        
        if ($category_slug) {
            $filtered_questions = [];
            foreach ($questions as $q) {
                if (isset($q['category_slug']) && $q['category_slug'] === $category_slug) {
                    $filtered_questions[] = $q;
                }
            }
            $questions = $filtered_questions;
            
            foreach ($categories as $cat) {
                if ($cat['slug'] === $category_slug) {
                    $title = htmlspecialchars($cat['name']) . ' - প্রশ্নোত্তর';
                    break;
                }
            }
        }

        if ($search) {
            $filtered_questions = [];
            foreach ($questions as $q) {
                if (stripos($q['question'], $search) !== false || (isset($q['answer']) && stripos($q['answer'], $search) !== false)) {
                    $filtered_questions[] = $q;
                }
            }
            $questions = $filtered_questions;
            $title = 'সার্চ ফলাফল: ' . htmlspecialchars($search);
        }

        $bookmarked_ids = [];
        if (isset($_SESSION['user_id'])) {
            $bookmarked_ids = $adminModel->getBookmarkedQuestionIds($_SESSION['user_id']);
        }

        // Pagination logic
        $limit = 10;
        $total_questions = count($questions);
        $total_pages = ceil($total_questions / $limit);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        $offset = ($page - 1) * $limit;
        $paginated_questions = array_slice($questions, $offset, $limit);

        $data = [
            'title' => $title,
            'questions' => $paginated_questions,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'categories' => $categories,
            'bookmarked_ids' => $bookmarked_ids,
            'settings' => $adminModel->getSettings(),
            'menus' => $adminModel->getMenus(),
            'sub_menus' => $adminModel->getSubMenus(),
            'breaking_news' => $adminModel->getBreakingNews(),
            'prayer_times' => $adminModel->getPrayerTimes()
        ];
        $this->view('home/qa', $data);
    }

    public function toggle_bookmark($question_id) {

        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'not_logged_in', 'login_url' => URLROOT . '/shop/account']);
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $adminModel = $this->model('AdminModel');
        $result = $adminModel->toggleBookmark($user_id, $question_id);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'action' => $result]);
        exit;
    }

    public function comment($post_id) {
        $adminModel = $this->model('AdminModel');
        $postModel = $this->model('PostModel');
        
        $post = $postModel->getPostById($post_id);
        if (!$post) {
            header('Location: ' . URLROOT);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $comment = trim($_POST['comment'] ?? '');

            if (!empty($name) && !empty($comment)) {
                $c_data = [
                    'post_id' => $post_id,
                    'name' => $name,
                    'email' => $email,
                    'comment' => $comment
                ];

                if ($adminModel->addComment($c_data)) {
                    $_SESSION['comment_success'] = 'আপনার মন্তব্যটি সফলভাবে জমা দেওয়া হয়েছে! এডমিন রিভিউ করে অ্যাপ্রুভ করার পর এটি প্রকাশ করা হবে।';
                } else {
                    $_SESSION['comment_error'] = 'দুঃখিত, মন্তব্যটি জমা দেওয়া সম্ভব হয়নি। আবার চেষ্টা করুন।';
                }
            } else {
                $_SESSION['comment_error'] = 'অনুগ্রহ করে সবগুলো ঘর পূরণ করুন।';
            }
        }
        header('Location: ' . URLROOT . '/' . $post['slug']);
        exit;
    }

    public function sitemap() {
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
            
            header('Content-Type: application/xml; charset=utf-8');
            echo $xml;
            exit();
        } catch (\Exception $e) {
            header('Content-Type: text/plain; charset=utf-8');
            echo "Error generating sitemap dynamically: " . $e->getMessage();
            exit();
        }
    }

    public function redirectBlog($category_slug = null) {
        if ($category_slug !== null) {
            header('Location: ' . base_url($category_slug));
        } else {
            return $this->blog();
        }
        exit;
    }

    public function redirectPostById($id) {
        $postModel = $this->model('PostModel');
        $post = $postModel->getPostById($id);
        if ($post && !empty($post['slug'])) {
            header('Location: ' . base_url($post['slug']));
            exit;
        }
        header('Location: ' . base_url());
        exit;
    }
}

