<?php
namespace App\Models;
use App\Core\Model;

class AdminModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->migrateUsersTableColumns();
        $this->migrateCategoriesTable();
        $this->initModulesTable();
        // Database tables are initialized once. Commented out to prevent performance overhead on every page load.
        /*
        $this->initAuthorsTable();
        $this->initPostAuthorsTable();
        $this->initPostCategoriesTable();
        $this->initSocialLinksTable();
        $this->migrateMenusTable();
        $this->migrateCategoriesTable();
        $this->initDonationsTable();
        $this->initScopesTable();
        $this->initAboutSectionsTable();
        $this->initReviewsTable();
        $this->initFaqsTable();
        $this->initJoinCardsTable();
        $this->initDeliveryChargesTable();
        $this->migratePostsSeoColumns();
        */
    }

    private function migrateUsersTableColumns() {
        // Ensure email column exists
        try {
            $this->db->query("SELECT email FROM users LIMIT 1");
        } catch (\PDOException $e) {
            try {
                $this->db->query("ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL DEFAULT NULL");
            } catch (\PDOException $ex) {}
        }

        // Ensure role column exists
        try {
            $this->db->query("SELECT role FROM users LIMIT 1");
        } catch (\PDOException $e) {
            try {
                $this->db->query("ALTER TABLE users ADD COLUMN role ENUM('admin', 'editor') NULL DEFAULT 'admin'");
            } catch (\PDOException $ex) {}
        }

        // Ensure permissions column exists
        try {
            $this->db->query("SELECT permissions FROM users LIMIT 1");
        } catch (\PDOException $e) {
            try {
                $this->db->query("ALTER TABLE users ADD COLUMN permissions TEXT NULL DEFAULT NULL");
            } catch (\PDOException $ex) {}
        }

        // Ensure created_at column exists
        try {
            $this->db->query("SELECT created_at FROM users LIMIT 1");
        } catch (\PDOException $e) {
            try {
                $this->db->query("ALTER TABLE users ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
            } catch (\PDOException $ex) {}
        }
    }

    private function migratePostsSeoColumns() {
        try {
            $this->db->query("SELECT seo_title FROM posts LIMIT 1");
        } catch (\PDOException $e) {
            try {
                $this->db->query("ALTER TABLE posts ADD COLUMN seo_title VARCHAR(255) NULL DEFAULT NULL");
                $this->db->query("ALTER TABLE posts ADD COLUMN seo_description TEXT NULL DEFAULT NULL");
                $this->db->query("ALTER TABLE posts ADD COLUMN seo_keywords TEXT NULL DEFAULT NULL");
            } catch (\PDOException $ex) {
                // ignore
            }
        }
    }

    private function initAuthorsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS authors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NULL,
            image VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed with default admin if empty
        $count = $this->db->query("SELECT COUNT(*) FROM authors")->fetchColumn();
        if ($count == 0) {
            $stmt = $this->db->prepare("INSERT INTO authors (name, email) VALUES (:name, :email)");
            $stmt->execute(['name' => 'Admin', 'email' => 'info@nur-lab.com']);
        }
    }

    private function initPostAuthorsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS post_authors (
            post_id INT NOT NULL,
            author_id INT NOT NULL,
            PRIMARY KEY (post_id, author_id),
            FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
            FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed with existing authors from posts table
        $count = $this->db->query("SELECT COUNT(*) FROM post_authors")->fetchColumn();
        if ($count == 0) {
            $admin_id = $this->db->query("SELECT id FROM authors WHERE name = 'Admin' LIMIT 1")->fetchColumn();
            if ($admin_id) {
                $posts = $this->db->query("SELECT id, author FROM posts")->fetchAll();
                foreach ($posts as $post) {
                    $author_name = !empty($post['author']) ? $post['author'] : 'Admin';
                    $stmt = $this->db->prepare("SELECT id FROM authors WHERE name = :name LIMIT 1");
                    $stmt->execute(['name' => $author_name]);
                    $auth_id = $stmt->fetchColumn();
                    if (!$auth_id) {
                        $stmt_ins = $this->db->prepare("INSERT INTO authors (name) VALUES (:name)");
                        $stmt_ins->execute(['name' => $author_name]);
                        $auth_id = $this->db->lastInsertId();
                    }
                    $stmt_pa = $this->db->prepare("INSERT IGNORE INTO post_authors (post_id, author_id) VALUES (:post_id, :author_id)");
                    $stmt_pa->execute(['post_id' => $post['id'], 'author_id' => $auth_id]);
                }
            }
        }
    }

    private function initPostCategoriesTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS post_categories (
            post_id INT NOT NULL,
            category_id INT NOT NULL,
            PRIMARY KEY (post_id, category_id),
            FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed/populate existing post categories if post_categories is empty
        $count = $this->db->query("SELECT COUNT(*) FROM post_categories")->fetchColumn();
        if ($count == 0) {
            $this->db->query("INSERT INTO post_categories (post_id, category_id) 
                              SELECT id, category_id FROM posts WHERE category_id IS NOT NULL");
        }
    }

    private function migrateCategoriesTable() {
        try {
            $this->db->query("SELECT parent_id FROM categories LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE categories ADD COLUMN parent_id INT NULL DEFAULT NULL");
        }
        try {
            $this->db->query("SELECT order_index FROM categories LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE categories ADD COLUMN order_index INT DEFAULT 0");
        }
    }

    private function migrateMenusTable() {
        // Check if parent_id exists in menus table
        try {
            $this->db->query("SELECT parent_id FROM menus LIMIT 1");
        } catch (\PDOException $e) {
            // Add columns
            $this->db->query("ALTER TABLE menus ADD COLUMN parent_id INT NULL DEFAULT NULL");
            $this->db->query("ALTER TABLE menus ADD COLUMN icon VARCHAR(100) NULL DEFAULT NULL");
        }

        // Check if menu_type exists in menus table
        try {
            $this->db->query("SELECT menu_type FROM menus LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE menus ADD COLUMN menu_type VARCHAR(50) DEFAULT 'custom'");
            $this->db->query("ALTER TABLE menus ADD COLUMN category_source TEXT NULL");
        }

        // Seed default Services mega menu if not already populated
        $has_children = $this->db->query("SELECT COUNT(*) FROM menus WHERE parent_id IS NOT NULL")->fetchColumn();
        if ($has_children == 0) {
            // Find or create 'Services' menu
            $stmt = $this->db->prepare("SELECT id FROM menus WHERE title LIKE :title LIMIT 1");
            $stmt->execute(['title' => '%Services%']);
            $parent = $stmt->fetch();
            if ($parent) {
                $parent_id = $parent['id'];
            } else {
                $stmt = $this->db->prepare("INSERT INTO menus (title, url, order_index) VALUES (:title, :url, :order_index)");
                $stmt->execute(['title' => 'Services', 'url' => '#', 'order_index' => 2]);
                $parent_id = $this->db->lastInsertId();
            }

            // Add tabs
            $tabs = [
                ['title' => 'SOFTWARE SOLUTIONS (SAAS)', 'icon' => 'fas fa-cloud', 'order' => 1, 'items' => [
                    ['title' => 'ISP MANAGMENT SYSTEM', 'icon' => 'fas fa-network-wired', 'url' => '#'],
                    ['title' => 'EduNur School, College & Madrasha Management Software', 'icon' => 'fas fa-graduation-cap', 'url' => '#'],
                    ['title' => 'POS SOFTWARE', 'icon' => 'fas fa-cash-register', 'url' => '#'],
                    ['title' => 'ADVOCATE GO - Complete Legal Case Management Solution', 'icon' => 'fas fa-scale-balanced', 'url' => '#'],
                    ['title' => 'Our Physical Product', 'icon' => 'fas fa-store', 'url' => '#'],
                    ['title' => 'SECURE CHAT', 'icon' => 'fas fa-lock', 'url' => '#'],
                    ['title' => 'Use Your Android Phone as SMS/MMS Gateway', 'icon' => 'fas fa-sms', 'url' => '#']
                ]],
                ['title' => 'WEB DEVELOPMENT', 'icon' => 'fas fa-code', 'order' => 2, 'items' => []],
                ['title' => 'INTERNET SERVICE', 'icon' => 'fas fa-wifi', 'order' => 3, 'items' => []],
                ['title' => 'CYBER SECURITY SERVICES', 'icon' => 'fas fa-user-secret', 'order' => 4, 'items' => []],
                ['title' => 'GRAPHICS & BRANDING', 'icon' => 'fas fa-palette', 'order' => 5, 'items' => []],
                ['title' => 'MOBILE APPS', 'icon' => 'fas fa-mobile-alt', 'order' => 6, 'items' => []]
            ];

            foreach ($tabs as $tab) {
                $stmt_tab = $this->db->prepare("INSERT INTO menus (title, url, order_index, parent_id, icon) VALUES (:title, '#', :order_index, :parent_id, :icon)");
                $stmt_tab->execute([
                    'title' => $tab['title'],
                    'order_index' => $tab['order'],
                    'parent_id' => $parent_id,
                    'icon' => $tab['icon']
                ]);
                $tab_id = $this->db->lastInsertId();

                foreach ($tab['items'] as $item_index => $item) {
                    $stmt_item = $this->db->prepare("INSERT INTO menus (title, url, order_index, parent_id, icon) VALUES (:title, :url, :order_index, :parent_id, :icon)");
                    $stmt_item->execute([
                        'title' => $item['title'],
                        'url' => $item['url'],
                        'order_index' => $item_index + 1,
                        'parent_id' => $tab_id,
                        'icon' => $item['icon']
                    ]);
                }
            }
        }
    }

    private function initSocialLinksTable() {
        // Create table if not exists
        $this->db->query("CREATE TABLE IF NOT EXISTS social_links (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            icon VARCHAR(100) NOT NULL,
            url VARCHAR(255) NOT NULL,
            order_index INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed with existing values from settings if empty
        $count = $this->db->query("SELECT COUNT(*) FROM social_links")->fetchColumn();
        if ($count == 0) {
            $settings = $this->getSettings();
            $socials = [
                ['name' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'key' => 'social_facebook', 'order' => 1],
                ['name' => 'Twitter', 'icon' => 'fab fa-twitter', 'key' => 'social_twitter', 'order' => 2],
                ['name' => 'YouTube', 'icon' => 'fab fa-youtube', 'key' => 'social_youtube', 'order' => 3],
                ['name' => 'Instagram', 'icon' => 'fab fa-instagram', 'key' => 'social_instagram', 'order' => 4],
            ];
            foreach ($socials as $s) {
                if (!empty($settings[$s['key']])) {
                    $stmt = $this->db->prepare("INSERT INTO social_links (name, icon, url, order_index) VALUES (:name, :icon, :url, :order_index)");
                    $stmt->execute([
                        'name' => $s['name'],
                        'icon' => $s['icon'],
                        'url' => $settings[$s['key']],
                        'order_index' => $s['order']
                    ]);
                }
            }
        }
    }

    public function getSocialLinks() {
        $stmt = $this->db->query("SELECT * FROM social_links ORDER BY order_index ASC, id ASC");
        return $stmt->fetchAll();
    }

    public function getSocialLinkById($id) {
        $stmt = $this->db->prepare("SELECT * FROM social_links WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addSocialLink($data) {
        $stmt = $this->db->prepare("INSERT INTO social_links (name, icon, url, order_index) VALUES (:name, :icon, :url, :order_index)");
        return $stmt->execute($data);
    }

    public function updateSocialLink($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE social_links SET name = :name, icon = :icon, url = :url, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteSocialLink($id) {
        $stmt = $this->db->prepare("DELETE FROM social_links WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :user OR email = :user LIMIT 1");
        $stmt->execute(['user' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function saveRememberToken($user_id, $token) {
        // Ensure column exists (SchemaSync will handle it, but safeguard here too)
        try {
            $hashed = hash('sha256', $token);
            $stmt = $this->db->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->execute(['token' => $hashed, 'id' => $user_id]);
        } catch (\Exception $e) {
            // Column may not exist yet — silently ignore
        }
    }

    public function getUserByRememberToken($token) {
        try {
            $hashed = hash('sha256', $token);
            $stmt = $this->db->prepare("SELECT * FROM users WHERE remember_token = :token LIMIT 1");
            $stmt->execute(['token' => $hashed]);
            return $stmt->fetch() ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function clearRememberToken($token) {
        try {
            $hashed = hash('sha256', $token);
            $stmt = $this->db->prepare("UPDATE users SET remember_token = NULL WHERE remember_token = :token");
            $stmt->execute(['token' => $hashed]);
        } catch (\Exception $e) {
            // Silently ignore
        }
    }

    public function createPost($data) {
        $category_ids = $data['category_ids'] ?? [];
        $data['category_id'] = !empty($category_ids) ? $category_ids[0] : null;
        unset($data['category_ids']);

        $author_ids = $data['author_ids'] ?? [];
        unset($data['author_ids']);

        // Find primary author name
        $primary_author = 'Admin';
        if (!empty($author_ids)) {
            $stmt_auth = $this->db->prepare("SELECT name FROM authors WHERE id = :id");
            $stmt_auth->execute(['id' => $author_ids[0]]);
            $primary_author = $stmt_auth->fetchColumn() ?: 'Admin';
        }
        $data['author'] = $primary_author;
        $data['status'] = !empty($data['status']) ? $data['status'] : 'published';
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : date('Y-m-d H:i:s');
        $data['views'] = isset($data['views']) ? intval($data['views']) : 0;
        
        // Auto-generate excerpt if empty
        if (empty($data['excerpt'])) {
            $data['excerpt'] = mb_substr(strip_tags($data['content']), 0, 180, 'UTF-8') . '...';
        }

        // Auto-generate SEO fields if empty
        if (empty($data['seo_title'])) {
            $data['seo_title'] = mb_substr(strip_tags($data['title']), 0, 60, 'UTF-8');
        }
        if (empty($data['seo_description'])) {
            $descSource = !empty($data['excerpt']) ? $data['excerpt'] : $data['content'];
            $data['seo_description'] = mb_substr(strip_tags($descSource), 0, 155, 'UTF-8');
        }
        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->generateSeoKeywords($data['title'], $data['content']);
        }
        $data['schema_data'] = isset($data['schema_data']) ? $data['schema_data'] : null;

        $stmt = $this->db->prepare("INSERT INTO posts (category_id, title, slug, content, excerpt, featured_image, post_type, author, fake_views, status, created_at, views, seo_title, seo_description, seo_keywords, schema_data) 
                                    VALUES (:category_id, :title, :slug, :content, :excerpt, :featured_image, :post_type, :author, :fake_views, :status, :created_at, :views, :seo_title, :seo_description, :seo_keywords, :schema_data)");
        if ($stmt->execute($data)) {
            $post_id = $this->db->lastInsertId();
            
            // Insert categories
            if (!empty($category_ids)) {
                $stmt_cat = $this->db->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (:post_id, :category_id)");
                foreach ($category_ids as $cat_id) {
                    $stmt_cat->execute(['post_id' => $post_id, 'category_id' => $cat_id]);
                }
            }

            // Insert authors
            if (!empty($author_ids)) {
                $stmt_pa = $this->db->prepare("INSERT INTO post_authors (post_id, author_id) VALUES (:post_id, :author_id)");
                foreach ($author_ids as $auth_id) {
                    $stmt_pa->execute(['post_id' => $post_id, 'author_id' => $auth_id]);
                }
            } else {
                // Default to admin author if none selected
                $admin_id = $this->db->query("SELECT id FROM authors WHERE name = 'Admin' LIMIT 1")->fetchColumn();
                if ($admin_id) {
                    $stmt_pa = $this->db->prepare("INSERT INTO post_authors (post_id, author_id) VALUES (:post_id, :author_id)");
                    $stmt_pa->execute(['post_id' => $post_id, 'author_id' => $admin_id]);
                }
            }
            \App\Helpers\Cache::clear();
            return true;
        }
        return false;
    }

    public function deletePost($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $res = $stmt->execute(['id' => $id]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function updatePost($data) {
        $category_ids = $data['category_ids'] ?? [];
        $data['category_id'] = !empty($category_ids) ? $category_ids[0] : null;
        unset($data['category_ids']);

        $author_ids = $data['author_ids'] ?? [];
        unset($data['author_ids']);

        // Find primary author name
        $primary_author = 'Admin';
        if (!empty($author_ids)) {
            $stmt_auth = $this->db->prepare("SELECT name FROM authors WHERE id = :id");
            $stmt_auth->execute(['id' => $author_ids[0]]);
            $primary_author = $stmt_auth->fetchColumn() ?: 'Admin';
        }
        $data['author'] = $primary_author;
        $data['status'] = !empty($data['status']) ? $data['status'] : 'published';
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : date('Y-m-d H:i:s');
        $data['views'] = isset($data['views']) ? intval($data['views']) : 0;

        // Auto-generate excerpt if empty
        if (empty($data['excerpt'])) {
            $data['excerpt'] = mb_substr(strip_tags($data['content']), 0, 180, 'UTF-8') . '...';
        }

        // Auto-generate SEO fields if empty
        if (empty($data['seo_title'])) {
            $data['seo_title'] = mb_substr(strip_tags($data['title']), 0, 60, 'UTF-8');
        }
        if (empty($data['seo_description'])) {
            $descSource = !empty($data['excerpt']) ? $data['excerpt'] : $data['content'];
            $data['seo_description'] = mb_substr(strip_tags($descSource), 0, 155, 'UTF-8');
        }
        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->generateSeoKeywords($data['title'], $data['content']);
        }
        $data['schema_data'] = isset($data['schema_data']) ? $data['schema_data'] : null;

        $stmt = $this->db->prepare("UPDATE posts SET category_id = :category_id, title = :title, slug = :slug, content = :content, excerpt = :excerpt, featured_image = :featured_image, author = :author, fake_views = :fake_views, status = :status, created_at = :created_at, views = :views, seo_title = :seo_title, seo_description = :seo_description, seo_keywords = :seo_keywords, schema_data = :schema_data WHERE id = :id");
        if ($stmt->execute($data)) {
            // Remove existing categories
            $stmt_delete = $this->db->prepare("DELETE FROM post_categories WHERE post_id = :post_id");
            $stmt_delete->execute(['post_id' => $data['id']]);

            // Add new ones
            if (!empty($category_ids)) {
                $stmt_cat = $this->db->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (:post_id, :category_id)");
                foreach ($category_ids as $cat_id) {
                    $stmt_cat->execute(['post_id' => $data['id'], 'category_id' => $cat_id]);
                }
            }

            // Remove existing authors
            $stmt_delete_auth = $this->db->prepare("DELETE FROM post_authors WHERE post_id = :post_id");
            $stmt_delete_auth->execute(['post_id' => $data['id']]);

            // Add new ones
            if (!empty($author_ids)) {
                $stmt_pa = $this->db->prepare("INSERT INTO post_authors (post_id, author_id) VALUES (:post_id, :author_id)");
                foreach ($author_ids as $auth_id) {
                    $stmt_pa->execute(['post_id' => $data['id'], 'author_id' => $auth_id]);
                }
            } else {
                $admin_id = $this->db->query("SELECT id FROM authors WHERE name = 'Admin' LIMIT 1")->fetchColumn();
                if ($admin_id) {
                    $stmt_pa = $this->db->prepare("INSERT INTO post_authors (post_id, author_id) VALUES (:post_id, :author_id)");
                    $stmt_pa->execute(['post_id' => $data['id'], 'author_id' => $admin_id]);
                }
            }
            \App\Helpers\Cache::clear();
            return true;
        }
        return false;
    }

    public function getPostCategoryIds($post_id) {
        $stmt = $this->db->prepare("SELECT category_id FROM post_categories WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getPostAuthorIds($post_id) {
        $stmt = $this->db->prepare("SELECT author_id FROM post_authors WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    // Authors CRUD
    public function getAuthors() {
        $stmt = $this->db->query("SELECT * FROM authors ORDER BY name ASC");
        $authors = $stmt->fetchAll();
        foreach ($authors as &$author) {
            if (!empty($author['image']) && strpos($author['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $author['image'] = str_replace('/insightzone/', URLROOT . '/', $author['image']);
            }
        }
        return $authors;
    }

    public function getAuthorById($id) {
        $stmt = $this->db->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $author = $stmt->fetch();
        if ($author) {
            if (!empty($author['image']) && strpos($author['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $author['image'] = str_replace('/insightzone/', URLROOT . '/', $author['image']);
            }
        }
        return $author;
    }

    public function addAuthor($data) {
        $stmt = $this->db->prepare("INSERT INTO authors (name, email, image) VALUES (:name, :email, :image)");
        return $stmt->execute($data);
    }

    public function updateAuthor($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE authors SET name = :name, email = :email, image = :image WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteAuthor($id) {
        $stmt = $this->db->prepare("DELETE FROM authors WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getSettings() {
        $stmt = $this->db->query("SELECT * FROM settings");
        $results = $stmt->fetchAll();
        $settings = [];
        foreach ($results as $row) {
            $val = $row['setting_value'];
            if (!empty($val)) {
                // If it contains the old domain path, clean it up
                if (strpos($val, '/islamic.nur-lab.com/') !== false) {
                    $val = str_replace('/islamic.nur-lab.com/', '/', $val);
                }
                
                // If it starts with /insightzone/ but we are on another domain
                if (strpos($val, '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                    $val = str_replace('/insightzone/', URLROOT . '/', $val);
                }
                
                // If it is a relative path starting with /public/ or public/
                if (strpos($val, '/public/') === 0) {
                    $val = URLROOT . $val;
                } elseif (strpos($val, 'public/') === 0) {
                    $val = URLROOT . '/' . $val;
                }
            }
            $settings[$row['setting_key']] = $val;
        }
        return $settings;
    }

    public function updateSettings($data) {
        foreach ($data as $key => $value) {
            $stmt = $this->db->prepare("INSERT INTO settings (setting_key, setting_value) 
                                        VALUES (:key, :value) 
                                        ON DUPLICATE KEY UPDATE setting_value = :value");
            $stmt->execute(['key' => $key, 'value' => $value]);
        }
        \App\Helpers\Cache::clear();
        return true;
    }
    
    public function updateSetting($key, $value) {
        return $this->updateSettings([$key => $value]);
    }

    // Slide Management
    public function getSlides() {
        $stmt = $this->db->query("SELECT * FROM slides ORDER BY order_index ASC");
        $slides = $stmt->fetchAll();
        foreach ($slides as &$slide) {
            if (!empty($slide['image']) && strpos($slide['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $slide['image'] = str_replace('/insightzone/', URLROOT . '/', $slide['image']);
            }
        }
        return $slides;
    }

    public function getSlideById($id) {
        $stmt = $this->db->prepare("SELECT * FROM slides WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $slide = $stmt->fetch();
        if ($slide) {
            if (!empty($slide['image']) && strpos($slide['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $slide['image'] = str_replace('/insightzone/', URLROOT . '/', $slide['image']);
            }
        }
        return $slide;
    }

    public function addSlide($data) {
        $stmt = $this->db->prepare("INSERT INTO slides (title, subtitle, image, link, btn_text, order_index) 
                                    VALUES (:title, :subtitle, :image, :link, :btn_text, :order_index)");
        $res = $stmt->execute([
            'title' => $data['title'] ?? '',
            'subtitle' => $data['subtitle'] ?? '',
            'image' => $data['image'] ?? '',
            'link' => $data['link'] ?? '',
            'btn_text' => $data['btn_text'] ?? null,
            'order_index' => $data['order_index'] ?? 0
        ]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function updateSlide($id, $data) {
        $stmt = $this->db->prepare("UPDATE slides SET title = :title, subtitle = :subtitle, image = :image, link = :link, btn_text = :btn_text, order_index = :order_index WHERE id = :id");
        $res = $stmt->execute([
            'id' => $id,
            'title' => $data['title'] ?? '',
            'subtitle' => $data['subtitle'] ?? '',
            'image' => $data['image'] ?? '',
            'link' => $data['link'] ?? '',
            'btn_text' => $data['btn_text'] ?? null,
            'order_index' => $data['order_index'] ?? 0
        ]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function deleteSlide($id) {
        $stmt = $this->db->prepare("DELETE FROM slides WHERE id = :id");
        $res = $stmt->execute(['id' => $id]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function getStats() {
        $stats = [];
        $stats['total_posts'] = $this->db->query("SELECT COUNT(*) FROM posts")->fetchColumn();
        $stats['total_categories'] = $this->db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $stats['total_slides'] = $this->db->query("SELECT COUNT(*) FROM slides")->fetchColumn();
        $stats['total_views'] = $this->db->query("SELECT SUM(views) FROM posts")->fetchColumn() ?: 0;
        return $stats;
    }

    public function getChartData() {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dayName = date('D', strtotime($date));
            $data[$date] = [
                'label' => $dayName,
                'count' => 0
            ];
        }

        $stmt = $this->db->query("SELECT DATE(created_at) as post_date, COUNT(*) as count 
                                  FROM posts 
                                  WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) 
                                  GROUP BY DATE(created_at)");
        $results = $stmt->fetchAll();
        foreach ($results as $row) {
            if (isset($data[$row['post_date']])) {
                $data[$row['post_date']]['count'] = (int)$row['count'];
            }
        }

        return [
            'labels' => array_column($data, 'label'),
            'data' => array_column($data, 'count')
        ];
    }

    public function getTopPosts($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT p.id, p.title, p.slug, p.views, p.created_at,
                   GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ', ') AS category_names
            FROM posts p
            LEFT JOIN post_categories pc ON p.id = pc.post_id
            LEFT JOIN categories c ON pc.category_id = c.id
            WHERE p.status = 'published'
            GROUP BY p.id
            ORDER BY p.views DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLeastViewedPosts($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT p.id, p.title, p.slug, p.views, p.created_at,
                   GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ', ') AS category_names
            FROM posts p
            LEFT JOIN post_categories pc ON p.id = pc.post_id
            LEFT JOIN categories c ON pc.category_id = c.id
            WHERE p.status = 'published'
            GROUP BY p.id
            ORDER BY p.views ASC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getDraftPostsCount() {
        return (int)$this->db->query("SELECT COUNT(*) FROM posts WHERE status = 'draft'")->fetchColumn();
    }

    public function getViewsChartData() {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dayName = date('D d', strtotime($date));
            $data[$date] = [
                'label' => $dayName,
                'views' => 0,
                'posts' => 0
            ];
        }

        // Get daily views (sum of all published posts created in last 7 days weighted)
        $stmt = $this->db->query("
            SELECT DATE(created_at) AS post_date, COUNT(*) AS cnt
            FROM posts
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(created_at)
        ");
        foreach ($stmt->fetchAll() as $row) {
            if (isset($data[$row['post_date']])) {
                $data[$row['post_date']]['posts'] = (int)$row['cnt'];
            }
        }

        return [
            'labels' => array_column($data, 'label'),
            'posts'  => array_column($data, 'posts')
        ];
    }

    public function getCategoryDistribution() {
        $stmt = $this->db->query("
            SELECT c.name, COUNT(pc.post_id) AS post_count
            FROM categories c
            LEFT JOIN post_categories pc ON c.id = pc.category_id
            LEFT JOIN posts p ON pc.post_id = p.id AND p.status = 'published'
            WHERE c.parent_id IS NULL
            GROUP BY c.id, c.name
            ORDER BY post_count DESC
            LIMIT 8
        ");
        return $stmt->fetchAll();
    }

    public function getMonthlyPostsChart() {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $label = date('M y', strtotime("-$i months"));
            $data[$month] = ['label' => $label, 'count' => 0];
        }
        $stmt = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count
            FROM posts
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
            GROUP BY month
        ");
        foreach ($stmt->fetchAll() as $row) {
            if (isset($data[$row['month']])) {
                $data[$row['month']]['count'] = (int)$row['count'];
            }
        }
        return [
            'labels' => array_column($data, 'label'),
            'data'   => array_column($data, 'count')
        ];
    }

    public function getContentHealth() {
        $noImage = $this->db->query("
            SELECT COUNT(*) FROM posts 
            WHERE (featured_image IS NULL OR featured_image = '') AND status = 'published'
        ")->fetchColumn();

        $zeroViews = $this->db->query("
            SELECT COUNT(*) FROM posts 
            WHERE views = 0 AND status = 'published'
        ")->fetchColumn();

        $noSeo = 0;
        $brokenPostsList = [];
        try {
            $stmt = $this->db->query("SELECT id, title, seo_title, seo_keywords FROM posts WHERE status = 'published'");
            $posts = $stmt->fetchAll();
            $brokenList = ['ইসল', 'রআন', 'ঘটন', 'একট', 'হওয', 'ইবন', 'সময'];
            foreach ($posts as $post) {
                $isBroken = false;
                $reason = '';
                $trimmedTitle = trim($post['seo_title'] ?? '');
                if (empty($trimmedTitle)) {
                    $isBroken = true;
                    $reason = 'Missing Title';
                } else if (!empty($post['seo_keywords'])) {
                    $keywordsArray = array_map('trim', explode(',', $post['seo_keywords']));
                    foreach ($brokenList as $broken) {
                        if (in_array($broken, $keywordsArray, true)) {
                            $isBroken = true;
                            $reason = "Broken Keyword: '$broken'";
                            break;
                        }
                    }
                }
                
                if ($isBroken) {
                    $noSeo++;
                    $brokenPostsList[] = [
                        'id' => $post['id'],
                        'title' => $post['title'],
                        'reason' => $reason
                    ];
                }
            }
        } catch (\Exception $e) { $noSeo = 0; }

        $totalPublished = $this->db->query("
            SELECT COUNT(*) FROM posts WHERE status = 'published'
        ")->fetchColumn() ?: 1;

        return [
            'no_image'     => (int)$noImage,
            'zero_views'   => (int)$zeroViews,
            'no_seo'       => (int)$noSeo,
            'total'        => (int)$totalPublished,
            'broken_posts' => $brokenPostsList,
        ];
    }

    public function getRecentSubscribers($limit = 5) {
        $stmt = $this->db->prepare("SELECT * FROM subscribers ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMediaStats() {
        $mediaPath = APPROOT . '/../public/uploads';
        $count = 0;
        $size = 0;
        if (is_dir($mediaPath)) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($mediaPath, \FilesystemIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $count++;
                    $size += $file->getSize();
                }
            }
        }
        return [
            'count' => $count,
            'size_mb' => round($size / 1048576, 2)
        ];
    }

    // Category Management
    public function getCategories() {
        // Heal orphaned subcategories by setting parent_id to NULL if parent category doesn't exist
        $this->db->query("UPDATE categories c LEFT JOIN categories p ON c.parent_id = p.id SET c.parent_id = NULL WHERE c.parent_id IS NOT NULL AND p.id IS NULL");
        
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY order_index ASC, name ASC");
        return $stmt->fetchAll();
    }

    public function getActivePostCategories() {
        $stmt = $this->db->query("SELECT DISTINCT c.* FROM categories c 
                                  JOIN post_categories pc ON c.id = pc.category_id 
                                  ORDER BY c.order_index ASC, c.name ASC");
        return $stmt->fetchAll();
    }

    public function addCategory($name, $parent_id = null, $slug = null) {
        if (empty($slug)) {
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($name, 'UTF-8')), '-');
        } else {
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($slug, 'UTF-8')), '-');
        }
        
        // Ensure unique slug
        $original_slug = $slug;
        $count = 1;
        while (true) {
            $stmt_check = $this->db->prepare("SELECT id FROM categories WHERE slug = :slug LIMIT 1");
            $stmt_check->execute(['slug' => $slug]);
            if ($stmt_check->fetch()) {
                $count++;
                $slug = $original_slug . '-' . $count;
            } else {
                break;
            }
        }

        $stmt = $this->db->prepare("INSERT INTO categories (name, slug, parent_id) VALUES (:name, :slug, :parent_id)");
        $res = $stmt->execute([
            'name' => $name, 
            'slug' => $slug,
            'parent_id' => !empty($parent_id) ? $parent_id : null
        ]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateCategory($id, $name, $parent_id = null, $slug = null) {
        if (empty($slug)) {
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($name, 'UTF-8')), '-');
        } else {
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($slug, 'UTF-8')), '-');
        }

        // Ensure unique slug
        $original_slug = $slug;
        $count = 1;
        while (true) {
            $stmt_check = $this->db->prepare("SELECT id FROM categories WHERE slug = :slug AND id != :id LIMIT 1");
            $stmt_check->execute(['slug' => $slug, 'id' => $id]);
            if ($stmt_check->fetch()) {
                $count++;
                $slug = $original_slug . '-' . $count;
            } else {
                break;
            }
        }

        $stmt = $this->db->prepare("UPDATE categories SET name = :name, slug = :slug, parent_id = :parent_id WHERE id = :id");
        $res = $stmt->execute([
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'parent_id' => !empty($parent_id) ? $parent_id : null
        ]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function deleteCategory($id) {
        // Set children's parent_id to NULL so they become top-level categories instead of being hidden/orphaned
        $stmt_sub = $this->db->prepare("UPDATE categories SET parent_id = NULL WHERE parent_id = :id");
        $stmt_sub->execute(['id' => $id]);

        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $res = $stmt->execute(['id' => $id]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function updateCategoriesOrder($ids) {
        $stmt = $this->db->prepare("UPDATE categories SET order_index = :order_index WHERE id = :id");
        foreach ($ids as $index => $id) {
            $stmt->execute([
                'order_index' => $index,
                'id' => (int)$id
            ]);
        }
        \App\Helpers\Cache::clear();
        return true;
    }

    public function updateCategoryParent($id, $parent_id = null) {
        $stmt = $this->db->prepare("UPDATE categories SET parent_id = :parent_id WHERE id = :id");
        $res = $stmt->execute([
            'id' => $id,
            'parent_id' => !empty($parent_id) ? $parent_id : null
        ]);
        if ($res) {
            \App\Helpers\Cache::clear();
        }
        return $res;
    }

    public function updateMenusOrder($ids) {
        $stmt = $this->db->prepare("UPDATE menus SET order_index = :order_index WHERE id = :id");
        foreach ($ids as $index => $id) {
            $stmt->execute([
                'order_index' => $index,
                'id' => (int)$id
            ]);
        }
        \App\Helpers\Cache::clear();
        return true;
    }

    // Page Management
    public function getPages() {
        $stmt = $this->db->query("SELECT * FROM pages ORDER BY title ASC");
        return $stmt->fetchAll();
    }

    public function addPage($data) {
        $data['slug'] = strtolower(str_replace(' ', '-', $data['title']));
        $stmt = $this->db->prepare("INSERT INTO pages (title, slug, content) VALUES (:title, :slug, :content)");
        return $stmt->execute($data);
    }

    public function deletePage($id) {
        $stmt = $this->db->prepare("DELETE FROM pages WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // User/Admin Management
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUsers() {
        return $this->getAllUsers();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateUser($data) {
        $fields = "username = :username";
        $params = [
            'id' => $data['id'],
            'username' => $data['username']
        ];

        if (isset($data['password']) && $data['password'] !== null) {
            $fields .= ", password = :password";
            $params['password'] = $data['password'];
        }

        if (isset($data['email'])) {
            $fields .= ", email = :email";
            $params['email'] = $data['email'];
        }

        if (isset($data['role'])) {
            $fields .= ", role = :role";
            $params['role'] = $data['role'];
        }

        if (isset($data['permissions'])) {
            $fields .= ", permissions = :permissions";
            $params['permissions'] = json_encode($data['permissions']);
        }

        $stmt = $this->db->prepare("UPDATE users SET $fields WHERE id = :id");
        return $stmt->execute($params);
    }

    public function addUser($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        return $stmt->execute($data);
    }

    // Customer/Shop Users Management
    public function getCustomers() {
        // Auto-create customer_users table if not exists
        $this->db->query("CREATE TABLE IF NOT EXISTS customer_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Migration to add email column
        try {
            $this->db->query("SELECT email FROM customer_users LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE customer_users ADD COLUMN email VARCHAR(150) NULL UNIQUE");
        }

        // Migration to add is_banned column
        try {
            $this->db->query("SELECT is_banned FROM customer_users LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE customer_users ADD COLUMN is_banned TINYINT(1) DEFAULT 0");
        }

        // Migration to add ip_address column
        try {
            $this->db->query("SELECT ip_address FROM customer_users LIMIT 1");
        } catch (\PDOException $e) {
            $this->db->query("ALTER TABLE customer_users ADD COLUMN ip_address VARCHAR(45) NULL");
        }

        $stmt = $this->db->query("SELECT * FROM customer_users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getCustomerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customer_users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateCustomer($data) {
        $fields = "name = :name";
        $params = [
            'id' => $data['id'],
            'name' => $data['name']
        ];
        
        if (isset($data['phone'])) {
            $fields .= ", phone = :phone";
            $params['phone'] = $data['phone'];
        }

        if (isset($data['email'])) {
            $fields .= ", email = :email";
            $params['email'] = $data['email'];
        }

        if (isset($data['password']) && $data['password'] !== null) {
            $fields .= ", password = :password";
            $params['password'] = $data['password'];
        }

        if (isset($data['is_banned'])) {
            $fields .= ", is_banned = :is_banned";
            $params['is_banned'] = $data['is_banned'];
        }
        
        $stmt = $this->db->prepare("UPDATE customer_users SET $fields WHERE id = :id");
        return $stmt->execute($params);
    }

    public function deleteCustomer($id) {
        $stmt = $this->db->prepare("DELETE FROM customer_users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function banCustomer($id) {
        $stmt = $this->db->prepare("UPDATE customer_users SET is_banned = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function unbanCustomer($id) {
        $stmt = $this->db->prepare("UPDATE customer_users SET is_banned = 0 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Comment Management
    public function getComments() {
        $stmt = $this->db->query("SELECT c.*, p.title as post_title FROM comments c JOIN posts p ON c.post_id = p.id ORDER BY c.created_at DESC");
        return $stmt->fetchAll();
    }

    public function approveComment($id) {
        $stmt = $this->db->prepare("UPDATE comments SET status = 'approved' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteComment($id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function bulkDeleteComments($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function bulkApproveComments($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE comments SET status = 'approved' WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    // Prayer Times
    public function getPrayerTimes() {
        $stmt = $this->db->query("SELECT * FROM prayer_times WHERE id = 1");
        return $stmt->fetch();
    }

    public function updatePrayerTimes($data) {
        $stmt = $this->db->prepare("UPDATE prayer_times SET fajr = :fajr, sunrise = :sunrise, dhuhr = :dhuhr, asr = :asr, maghrib = :maghrib, isha = :isha WHERE id = 1");
        return $stmt->execute($data);
    }

    // Newsletter & Messages
    public function getSubscribers() {
        $stmt = $this->db->query("SELECT * FROM subscribers ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function deleteSubscriber($id) {
        $stmt = $this->db->prepare("DELETE FROM subscribers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function bulkDeleteSubscribers($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM subscribers WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function addMessage($data) {
        $stmt = $this->db->prepare("INSERT INTO messages (name, email, subject, message, status) VALUES (:name, :email, :subject, :message, 'unread')");
        return $stmt->execute($data);
    }

    public function getMessages() {
        $stmt = $this->db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function markMessageRead($id) {
        $stmt = $this->db->prepare("UPDATE messages SET status = 'read' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteMessage($id) {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function bulkDeleteMessages($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function bulkMarkMessagesRead($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE messages SET status = 'read' WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    // Breaking News Management
    public function getBreakingNews() {
        $stmt = $this->db->query("SELECT * FROM breaking_news ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function addBreakingNews($title, $link) {
        $stmt = $this->db->prepare("INSERT INTO breaking_news (title, link) VALUES (:title, :link)");
        return $stmt->execute(['title' => $title, 'link' => $link]);
    }

    public function deleteBreakingNews($id) {
        $stmt = $this->db->prepare("DELETE FROM breaking_news WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Team Management
    public function getTeamMembers() {
        $stmt = $this->db->query("SELECT * FROM team_members ORDER BY order_index ASC");
        $members = $stmt->fetchAll();
        foreach ($members as &$member) {
            if (!empty($member['image']) && strpos($member['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $member['image'] = str_replace('/insightzone/', URLROOT . '/', $member['image']);
            }
        }
        return $members;
    }

    public function getTeamMemberById($id) {
        $stmt = $this->db->prepare("SELECT * FROM team_members WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $member = $stmt->fetch();
        if ($member) {
            if (!empty($member['image']) && strpos($member['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $member['image'] = str_replace('/insightzone/', URLROOT . '/', $member['image']);
            }
        }
        return $member;
    }

    public function addTeamMember($data) {
        $stmt = $this->db->prepare("INSERT INTO team_members (name, designation, image, facebook_link, twitter_link, order_index) 
                                    VALUES (:name, :designation, :image, :facebook_link, :twitter_link, :order_index)");
        return $stmt->execute($data);
    }

    public function updateTeamMember($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE team_members SET name = :name, designation = :designation, image = :image, 
                                    facebook_link = :facebook_link, twitter_link = :twitter_link, order_index = :order_index 
                                    WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteTeamMember($id) {
        $stmt = $this->db->prepare("DELETE FROM team_members WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Menu Management
    public function getMenus() {
        $stmt = $this->db->query("SELECT * FROM menus ORDER BY order_index ASC");
        return $stmt->fetchAll();
    }

    public function getMenuById($id) {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addMenu($data) {
        $stmt = $this->db->prepare("INSERT INTO menus (title, url, order_index, parent_id, icon, menu_type, category_source) VALUES (:title, :url, :order_index, :parent_id, :icon, :menu_type, :category_source)");
        return $stmt->execute([
            'title' => $data['title'],
            'url' => $data['url'],
            'order_index' => $data['order_index'],
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'icon' => !empty($data['icon']) ? $data['icon'] : null,
            'menu_type' => !empty($data['menu_type']) ? $data['menu_type'] : 'custom',
            'category_source' => !empty($data['category_source']) ? $data['category_source'] : null
        ]);
    }

    public function updateMenu($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE menus SET title = :title, url = :url, order_index = :order_index, parent_id = :parent_id, icon = :icon, menu_type = :menu_type, category_source = :category_source WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'url' => $data['url'],
            'order_index' => $data['order_index'],
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'icon' => !empty($data['icon']) ? $data['icon'] : null,
            'menu_type' => !empty($data['menu_type']) ? $data['menu_type'] : 'custom',
            'category_source' => !empty($data['category_source']) ? $data['category_source'] : null
        ]);
    }

    public function deleteMenu($id) {
        $stmt = $this->db->prepare("DELETE FROM menus WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Sub Menu Management
    public function getSubMenus() {
        $stmt = $this->db->query("SELECT * FROM sub_menus ORDER BY order_index ASC");
        return $stmt->fetchAll();
    }

    public function getSubMenuById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sub_menus WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addSubMenu($data) {
        $stmt = $this->db->prepare("INSERT INTO sub_menus (title, url, order_index) VALUES (:title, :url, :order_index)");
        return $stmt->execute($data);
    }

    public function updateSubMenu($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE sub_menus SET title = :title, url = :url, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteSubMenu($id) {
        $stmt = $this->db->prepare("DELETE FROM sub_menus WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // YouTube Video Management
    public function getYTSubCategories() {
        $stmt = $this->db->query("SELECT * FROM yt_categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function addYTCategory($data) {
        $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
        $stmt = $this->db->prepare("INSERT INTO yt_categories (name, slug) VALUES (:name, :slug)");
        return $stmt->execute($data);
    }

    public function deleteYTCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM yt_categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getYTVideos() {
        $stmt = $this->db->query("SELECT v.*, c.name as category_name FROM yt_videos v LEFT JOIN yt_categories c ON v.category_id = c.id ORDER BY v.created_at DESC");
        return $stmt->fetchAll();
    }

    public function addYTVideo($data) {
        // Extract Video ID
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data['video_url'], $match);
        $data['video_id'] = $match[1] ?? '';
        
        $stmt = $this->db->prepare("INSERT INTO yt_videos (category_id, title, video_url, video_id, description) 
                                    VALUES (:category_id, :title, :video_url, :video_id, :description)");
        return $stmt->execute($data);
    }

    public function deleteYTVideo($id) {
        $stmt = $this->db->prepare("DELETE FROM yt_videos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initDonationsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS donations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            donor_name VARCHAR(150) NOT NULL,
            donor_email VARCHAR(150) NULL,
            donor_phone VARCHAR(20) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            purpose VARCHAR(255) NULL,
            payment_method VARCHAR(50) NOT NULL,
            payment_id VARCHAR(100) NULL,
            status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        try {
            $this->db->query("ALTER TABLE donations MODIFY COLUMN donor_email VARCHAR(150) NULL");
        } catch (\PDOException $e) {
            // Already modified or error
        }
    }

    public function getDonations() {
        $stmt = $this->db->query("SELECT * FROM donations ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getDonationById($id) {
        $stmt = $this->db->prepare("SELECT * FROM donations WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getDonationByPaymentId($payment_id) {
        $stmt = $this->db->prepare("SELECT * FROM donations WHERE payment_id = :payment_id");
        $stmt->execute(['payment_id' => $payment_id]);
        return $stmt->fetch();
    }

    public function updateDonationStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE donations SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function deleteDonation($id) {
        $stmt = $this->db->prepare("DELETE FROM donations WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function bulkDeleteDonations($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM donations WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function bulkUpdateDonationsStatus($ids, $status) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE donations SET status = ? WHERE id IN ($placeholders)");
        return $stmt->execute(array_merge([$status], $ids));
    }

    public function updateDonationPaymentId($id, $payment_id) {
        $stmt = $this->db->prepare("UPDATE donations SET payment_id = :payment_id WHERE id = :id");
        return $stmt->execute(['id' => $id, 'payment_id' => $payment_id]);
    }

    public function addDonation($data) {
        $stmt = $this->db->prepare("INSERT INTO donations (donor_name, donor_email, donor_phone, amount, purpose, payment_method, payment_id, status) 
                                    VALUES (:donor_name, :donor_email, :donor_phone, :amount, :purpose, :payment_method, :payment_id, :status)");
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    private function initScopesTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS scopes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            icon VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            order_index INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed default scopes if empty
        $count = $this->db->query("SELECT COUNT(*) FROM scopes")->fetchColumn();
        if ($count == 0) {
            $default_scopes = [
                [
                    'title' => 'ইসলাম',
                    'icon' => 'fas fa-mosque',
                    'description' => 'আমরা ইসলাম সম্পর্কে প্রচলিত ভ্রান্ত ধারণা ও মিথ্যা দাবিগুলো খণ্ডন করতে বদ্ধপরিকর। গভীর বিশ্লেষণ ও যৌক্তিক আলোচনার মাধ্যমে আমরা সত্যকে পরিষ্কারভাবে উপস্থাপন করতে চাই। লাইভ পডকাস্ট ও আলোচনার আয়োজনের মাধ্যমে আমরা মানুষের সংশয় দূর করা, সত্য প্রকাশ করা এবং ইসলামবিরোধী প্রচারণার জবাবে প্রমাণভিত্তিক যুক্তি প্রদান করার লক্ষ্য রাখি।',
                    'order_index' => 1
                ],
                [
                    'title' => 'তুলনামূলক ধর্মতত্ত্ব',
                    'icon' => 'fas fa-book-open',
                    'description' => 'আমরা তুলনামূলক ধর্মতত্ত্বের অধ্যয়নে নিয়োজিত, যাতে বিশ্বপ্রধান ধর্মগুলোর মৌলিক বিশ্বাস, দর্শন ও ঐতিহাসিক বিকাশকে অনুসন্ধান করা যায়। এর মাধ্যমে বিশেষভাবে ইসলামের অনন্য দৃষ্টিভঙ্গি সুস্পষ্টভাবে তুলে ধরা আমাদের মূল উদ্দেশ্য।',
                    'order_index' => 2
                ],
                [
                    'title' => 'দর্শন ও নীতিবিদ্যা',
                    'icon' => 'fas fa-graduation-cap',
                    'description' => 'আমরা দর্শনের বিভিন্ন শাখা যেমন মেটাফিজিক্স, এপিস্টেমোলজি, নীতি-দর্শন ও যুক্তিবিদ্যা, ইসলামী দৃষ্টিকোণ থেকে বিশ্লেষণ করি। আমাদের লক্ষ্য হলো পাঠকদের সামনে ইসলামী দর্শনের গভীরতা ও তার যৌক্তিক কাঠামোকে সুস্পষ্টভাবে উপস্থাপন করা।',
                    'order_index' => 3
                ]
            ];
            $stmt = $this->db->prepare("INSERT INTO scopes (title, icon, description, order_index) VALUES (:title, :icon, :description, :order_index)");
            foreach ($default_scopes as $scope) {
                $stmt->execute($scope);
            }
        }
    }

    public function getScopes() {
        $stmt = $this->db->query("SELECT * FROM scopes ORDER BY order_index ASC, id ASC");
        return $stmt->fetchAll();
    }

    public function getScopeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM scopes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addScope($data) {
        $stmt = $this->db->prepare("INSERT INTO scopes (title, icon, description, order_index) VALUES (:title, :icon, :description, :order_index)");
        return $stmt->execute($data);
    }

    public function updateScope($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE scopes SET title = :title, icon = :icon, description = :description, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteScope($id) {
        $stmt = $this->db->prepare("DELETE FROM scopes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initAboutSectionsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS about_sections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            highlight_title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            order_index INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed default about section if empty
        $count = $this->db->query("SELECT COUNT(*) FROM about_sections")->fetchColumn();
        if ($count == 0) {
            $default_about = [
                'image' => 'https://images.unsplash.com/photo-1590273466070-40c466b4432c?q=80&w=600',
                'subtitle' => 'আমাদের সম্পর্কে',
                'title' => 'আমাদের প্রত্যয়',
                'highlight_title' => 'আমাদের উদ্দেশ্য',
                'description' => 'response with nur-lab একটি অলাভজনক অনলাইন প্ল্যাটফর্ম, যেখানে বিশ্বের বিভিন্ন প্রান্তের মুসলিম লেখকরা ইসলাম, দর্শন, বিজ্ঞান ও সমসাময়িক বিষয় নিয়ে আলোচনা ও গবেষণায় যুক্ত হন। এই প্ল্যাটফর্মটি বিশেষভাবে ইসলাম নিয়ে প্রচলিত ভ্রান্ত ধারণা ও মিথ্যা অভিযোগ, বিশেষত অমুসলিমদের উত্থাপিত অভিযোগগুলোর যুক্তিসঙ্গত জবাব দেওয়ার জন্য কাজ করে। গবেষণালব্ধ লেখা, বুদ্ধিবৃত্তিক, সংলাপভিত্তিক আলোচনা এবং লাইভ পডকাস্টের মাধ্যমে response with nur-lab সত্যকে স্পষ্টভাবে উপস্থাপন করতে এবং সমালোচনামূলক ও জ্ঞানভিত্তিক চিন্তার সংস্কৃতি গড়ে তুলতে চায়। এছাড়াও, প্ল্যাটফর্মটি গুরুত্বপূর্ণ সামাজিক ও রাজনৈতিক বিষয় নিয়ে জনসচেতনতা সৃষ্টি করে এবং বৈশ্বিক মুসলিম সম্প্রদায়ের অধিকার ও স্বার্থ রক্ষায় কাজ করে।',
                'order_index' => 1
            ];
            $stmt = $this->db->prepare("INSERT INTO about_sections (image, subtitle, title, highlight_title, description, order_index) VALUES (:image, :subtitle, :title, :highlight_title, :description, :order_index)");
            $stmt->execute($default_about);
        }
    }

    public function getAboutSections() {
        $stmt = $this->db->query("SELECT * FROM about_sections ORDER BY order_index ASC, id ASC");
        $sections = $stmt->fetchAll();
        foreach ($sections as &$section) {
            if (!empty($section['image']) && strpos($section['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $section['image'] = str_replace('/insightzone/', URLROOT . '/', $section['image']);
            }
        }
        return $sections;
    }

    public function getAboutSectionById($id) {
        $stmt = $this->db->prepare("SELECT * FROM about_sections WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $section = $stmt->fetch();
        if ($section) {
            if (!empty($section['image']) && strpos($section['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $section['image'] = str_replace('/insightzone/', URLROOT . '/', $section['image']);
            }
        }
        return $section;
    }

    public function addAboutSection($data) {
        $stmt = $this->db->prepare("INSERT INTO about_sections (image, subtitle, title, highlight_title, description, order_index) VALUES (:image, :subtitle, :title, :highlight_title, :description, :order_index)");
        return $stmt->execute($data);
    }

    public function updateAboutSection($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE about_sections SET image = :image, subtitle = :subtitle, title = :title, highlight_title = :highlight_title, description = :description, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteAboutSection($id) {
        $stmt = $this->db->prepare("DELETE FROM about_sections WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initReviewsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            designation VARCHAR(255) NULL,
            image VARCHAR(255) NULL,
            rating INT DEFAULT 5,
            review_text TEXT NOT NULL,
            order_index INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed with 6 reviews if empty (so they slide properly)
        $count = $this->db->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
        if ($count == 0) {
            $default_reviews = [
                [
                    'name' => 'আব্দুর রহমান',
                    'designation' => 'নিয়মিত পাঠক',
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&h=150&fit=crop',
                    'rating' => 5,
                    'review_text' => 'এই পোর্টালের কন্টেন্টগুলো অত্যন্ত তথ্যবহুল এবং গবেষণালব্ধ। বিশেষ করে সমসাময়িক বিষয়ের যৌক্তিক ব্যাখ্যাগুলো দারুণ।',
                    'order_index' => 1
                ],
                [
                    'name' => 'ফাতেমা আক্তার',
                    'designation' => 'শিক্ষিকা',
                    'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&h=150&fit=crop',
                    'rating' => 5,
                    'review_text' => 'তুলনামূলক ধর্মতত্ত্বের ওপর অসাধারণ কিছু আর্টিকেল পেয়েছি এখানে। সহজ ভাষায় কঠিন বিষয়গুলো বোঝানো হয়েছে।',
                    'order_index' => 2
                ],
                [
                    'name' => 'মোহাম্মদ আলী',
                    'designation' => 'বিশ্ববিদ্যালয় শিক্ষার্থী',
                    'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150&h=150&fit=crop',
                    'rating' => 5,
                    'review_text' => 'ইসলামী দর্শন এবং যুক্তিবিদ্যার ওপর লেখাগুলো তরুণ প্রজন্মের সংশয় দূর করতে অত্যন্ত কার্যকরী ভূমিকা রাখছে।',
                    'order_index' => 3
                ],
                [
                    'name' => 'আয়েশা সিদ্দিকা',
                    'designation' => 'গৃহিণী',
                    'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150&h=150&fit=crop',
                    'rating' => 4,
                    'review_text' => 'পোর্টালে নিয়মিত লেখা পড়ি। ভাষা খুব সাবলীল এবং ইসলামের সঠিক দিকনির্দেশনা ফুটে ওঠে প্রতিটি আর্টিকেলে।',
                    'order_index' => 4
                ],
                [
                    'name' => 'হাসান মাহমুদ',
                    'designation' => 'সফটওয়্যার ইঞ্জিনিয়ার',
                    'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=150&h=150&fit=crop',
                    'rating' => 5,
                    'review_text' => 'ডিজাইন ও প্রযুক্তিগত দিক থেকে সাইটটি চমৎকার এবং কন্টেন্ট কোয়ালিটি অত্যন্ত মানসম্মত। শুভকামনা পোর্টালের জন্য।',
                    'order_index' => 5
                ],
                [
                    'name' => 'সাজিদ হাসান',
                    'designation' => 'গবেষক',
                    'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=150&h=150&fit=crop',
                    'rating' => 5,
                    'review_text' => 'ইসলামবিরোধী অপপ্রচারের দাঁতভাঙা ও তথ্যভিত্তিক যৌক্তিক জবাব দেওয়ার জন্য এই প্ল্যাটফর্মটি সত্যিই প্রশংসনীয়।',
                    'order_index' => 6
                ]
            ];
            $stmt = $this->db->prepare("INSERT INTO reviews (name, designation, image, rating, review_text, order_index) VALUES (:name, :designation, :image, :rating, :review_text, :order_index)");
            foreach ($default_reviews as $rev) {
                $stmt->execute($rev);
            }
        }
    }

    public function getReviews() {
        $stmt = $this->db->query("SELECT * FROM reviews ORDER BY order_index ASC, id ASC");
        $reviews = $stmt->fetchAll();
        foreach ($reviews as &$review) {
            if (!empty($review['image']) && strpos($review['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $review['image'] = str_replace('/insightzone/', URLROOT . '/', $review['image']);
            }
        }
        return $reviews;
    }

    public function getReviewById($id) {
        $stmt = $this->db->prepare("SELECT * FROM reviews WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $review = $stmt->fetch();
        if ($review) {
            if (!empty($review['image']) && strpos($review['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $review['image'] = str_replace('/insightzone/', URLROOT . '/', $review['image']);
            }
        }
        return $review;
    }

    public function addReview($data) {
        $stmt = $this->db->prepare("INSERT INTO reviews (name, designation, image, rating, review_text, order_index) VALUES (:name, :designation, :image, :rating, :review_text, :order_index)");
        return $stmt->execute($data);
    }

    public function updateReview($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE reviews SET name = :name, designation = :designation, image = :image, rating = :rating, review_text = :review_text, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteReview($id) {
        $stmt = $this->db->prepare("DELETE FROM reviews WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initFaqsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS faqs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question VARCHAR(500) NOT NULL,
            answer TEXT NOT NULL,
            status VARCHAR(50) DEFAULT 'active',
            order_index INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $count = $this->db->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
        if ($count == 0) {
            $default_faqs = [
                [
                    'question' => 'আপনাদের সম্পর্কে জানতে চাই।',
                    'answer' => 'response with nur-lab একটি অলাভজনক অনলাইন প্ল্যাটফর্ম, যেখানে বিশ্বের বিভিন্ন প্রান্তের মুসলিম লেখকরা ইসলাম, দর্শন, বিজ্ঞান ও সমসাময়িক বিষয় নিয়ে আলোচনা ও গবেষণায় যুক্ত হন। এই প্ল্যাটফর্মটি বিশেষভাবে ইসলাম নিয়ে প্রচলিত ভ্রান্ত ধারণা ও মিথ্যা অভিযোগ, বিশেষত অমুসলিমদের উত্থাপিত অভিযোগগুলোর যুক্তিসঙ্গত জবাব দেওয়ার জন্য কাজ করে। গবেষণালব্ধ লেখা, বুদ্ধিবৃত্তিক, সংলাপভিত্তিক আলোচনা এবং লাইভ পডকাস্টের মাধ্যমে response with nur-lab সত্যকে স্পষ্টভাবে উপস্থাপন করতে এবং সমালোচনামূলক ও জ্ঞানভিত্তিক চিন্তার সংস্কৃতি গড়ে তুলতে চায়। এছাড়াও, প্ল্যাটফর্মটি গুরুত্বপূর্ণ সামাজিক ও রাজনৈতিক বিষয় নিয়ে জনসচেতনতা সৃষ্টি করে এবং বৈশ্বিক মুসলিম সম্প্রদায়ের অধিকার ও স্বার্থ রক্ষায় কাজ করে।',
                    'status' => 'active',
                    'order_index' => 1
                ],
                [
                    'question' => 'আপনাদের বইগুলো কোথায় পাওয়া যাবে?',
                    'answer' => 'আমাদের বইগুলো একমাত্র অনলাইনে পাওয়া যায়। সরাসরি আমাদের থেকে কিনতে পারেন। <a href="#" style="color: #2563eb; font-weight: 700;">অর্ডার লিংক</a> এছাড়াও রকমারি, ওয়াফিলাইফ সহ বেশ কিছু প্ল্যাটফর্ম আমাদের বই বিক্রি করে থাকেন।',
                    'status' => 'active',
                    'order_index' => 2
                ],
                [
                    'question' => 'আপনাদের লাইভে কিভাবে যুক্ত হবো?',
                    'answer' => 'লাইভ শুরু হলে ডেসক্রিপশনে এবং পিন কমেন্টে লিংক দেওয়া থাকে। সেই লিংক থেকে যুক্ত হতে পারবেন।',
                    'status' => 'active',
                    'order_index' => 3
                ]
            ];
            $stmt = $this->db->prepare("INSERT INTO faqs (question, answer, status, order_index) VALUES (:question, :answer, :status, :order_index)");
            foreach ($default_faqs as $faq) {
                $stmt->execute($faq);
            }
        }
    }

    public function getFaqs($only_active = false) {
        $sql = "SELECT * FROM faqs";
        if ($only_active) {
            $sql .= " WHERE status = 'active'";
        }
        $sql .= " ORDER BY order_index ASC, id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getFaqById($id) {
        $stmt = $this->db->prepare("SELECT * FROM faqs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addFaq($data) {
        $stmt = $this->db->prepare("INSERT INTO faqs (question, answer, status, order_index) VALUES (:question, :answer, :status, :order_index)");
        return $stmt->execute($data);
    }

    public function updateFaq($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE faqs SET question = :question, answer = :answer, status = :status, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteFaq($id) {
        $stmt = $this->db->prepare("DELETE FROM faqs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initJoinCardsTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS join_cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            icon VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            order_index INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed default cards if empty
        $count = $this->db->query("SELECT COUNT(*) FROM join_cards")->fetchColumn();
        if ($count == 0) {
            $default_cards = [
                [
                    'title' => 'লেখালেখি & আলোচনা',
                    'icon' => 'fas fa-pen-nib',
                    'description' => 'আপনি যদি লেখালেখি কিংবা লাইভে আলোচনা করতে আগ্রহী হন, তাহলে আপনার লেখা এবং আলোচনার ১-২টি স্যাম্পল, আমাদের পাঠাতে হবে কোন বিষয়ে লিখতে বা আলোচনা করতে স্বাচ্ছন্দ্যবোধ করেন (ইসলাম, দর্শন, সমসাময়িক ইস্যু ইত্যাদি) তা উল্লেখ করবেন।',
                    'order_index' => 1
                ],
                [
                    'title' => 'টেকনিক্যাল সাপোর্ট (Technical Support)',
                    'icon' => 'fas fa-desktop',
                    'description' => 'আপনি যদি টেকনিক্যালভাবে সাহায্য করতে চান, তাহলে আপনি কোন কোন ক্ষেত্রে কাজ করতে পারবেন (যেমন: ওয়েবসাইট ম্যানেজমেন্ট, WordPress, ডিজাইন, SEO, ভিডিও এডিটিং, ইত্যাদি) পূর্বের কাজের অভিজ্ঞতা থাকলে সেটার উদাহরণ দিন।',
                    'order_index' => 2
                ],
                [
                    'title' => 'মিডিয়া ও কনটেন্ট ক্রিয়েশন',
                    'icon' => 'fas fa-photo-film',
                    'description' => 'ভিডিও এডিটিং, গ্রাফিক্স ডিজাইন, থাম্বনেইল তৈরি ইত্যাদি করতে পারলে আপনার কাজের স্যাম্পল বা পোর্টফোলিও শেয়ার করুন।',
                    'order_index' => 3
                ]
            ];
            $stmt = $this->db->prepare("INSERT INTO join_cards (title, icon, description, order_index) VALUES (:title, :icon, :description, :order_index)");
            foreach ($default_cards as $card) {
                $stmt->execute($card);
            }
        }
    }

    public function getJoinCards() {
        $stmt = $this->db->query("SELECT * FROM join_cards ORDER BY order_index ASC, id ASC");
        return $stmt->fetchAll();
    }

    public function getJoinCardById($id) {
        $stmt = $this->db->prepare("SELECT * FROM join_cards WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addJoinCard($data) {
        $stmt = $this->db->prepare("INSERT INTO join_cards (title, icon, description, order_index) VALUES (:title, :icon, :description, :order_index)");
        return $stmt->execute($data);
    }

    public function updateJoinCard($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE join_cards SET title = :title, icon = :icon, description = :description, order_index = :order_index WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteJoinCard($id) {
        $stmt = $this->db->prepare("DELETE FROM join_cards WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function initDeliveryChargesTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS delivery_charges (
            id INT AUTO_INCREMENT PRIMARY KEY,
            location VARCHAR(255) NOT NULL,
            team VARCHAR(255) NOT NULL,
            charge DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Seed some default data if empty (only once, tracked via settings)
        $seeded = $this->db->query("SELECT COUNT(*) FROM settings WHERE setting_key = 'delivery_charges_seeded'")->fetchColumn();
        if ($seeded == 0) {
            $default_rules = [
                ['location' => 'ঢাকা সিটি (Inside Dhaka)', 'team' => 'RedX Delivery', 'charge' => 60.00],
                ['location' => 'ঢাকা সিটি (Inside Dhaka)', 'team' => 'Pathao Courier', 'charge' => 70.00],
                ['location' => 'ঢাকার বাইরে (Outside Dhaka)', 'team' => 'SA Paribahan', 'charge' => 130.00],
                ['location' => 'ঢাকার বাইরে (Outside Dhaka)', 'team' => 'Steadfast Courier', 'charge' => 120.00],
                ['location' => 'চট্টগ্রাম (Chittagong)', 'team' => 'RedX Delivery', 'charge' => 100.00]
            ];
            foreach ($default_rules as $rule) {
                $stmt = $this->db->prepare("INSERT INTO delivery_charges (location, team, charge) VALUES (:location, :team, :charge)");
                $stmt->execute($rule);
            }
            
            // Mark as seeded
            $this->db->query("INSERT INTO settings (setting_key, setting_value) VALUES ('delivery_charges_seeded', '1')");
        }
    }

    public function getDeliveryCharges() {
        $stmt = $this->db->query("SELECT * FROM delivery_charges ORDER BY location ASC, team ASC");
        return $stmt->fetchAll();
    }

    public function getDeliveryChargeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM delivery_charges WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getDeliveryChargeRule($location, $team) {
        $stmt = $this->db->prepare("SELECT * FROM delivery_charges WHERE location = :location AND team = :team LIMIT 1");
        $stmt->execute(['location' => $location, 'team' => $team]);
        return $stmt->fetch();
    }

    public function addDeliveryCharge($location, $team, $charge) {
        $stmt = $this->db->prepare("INSERT INTO delivery_charges (location, team, charge) VALUES (:location, :team, :charge)");
        return $stmt->execute([
            'location' => $location,
            'team' => $team,
            'charge' => $charge
        ]);
    }

    public function updateDeliveryCharge($id, $location, $team, $charge) {
        $stmt = $this->db->prepare("UPDATE delivery_charges SET location = :location, team = :team, charge = :charge WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'location' => $location,
            'team' => $team,
            'charge' => $charge
        ]);
    }

    public function deleteDeliveryCharge($id) {
        $stmt = $this->db->prepare("DELETE FROM delivery_charges WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // User Questions Management (Updated)
    public function getUserQuestions($limit = 100, $status = null) {
        $sql = "SELECT q.*, c.name as category_name, c.slug as category_slug 
                FROM user_questions q
                LEFT JOIN question_categories c ON q.category_id = c.id";
        $params = [];
        if ($status !== null) {
            $sql .= " WHERE q.status = :status";
            $params['status'] = $status;
        }
        $sql .= " ORDER BY q.created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(':' . $key, $val);
        }
        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserQuestionById($id) {
        $stmt = $this->db->prepare("SELECT q.*, c.name as category_name, c.slug as category_slug 
                                    FROM user_questions q 
                                    LEFT JOIN question_categories c ON q.category_id = c.id 
                                    WHERE q.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addUserQuestion($data) {
        $stmt = $this->db->prepare("INSERT INTO user_questions (name, email, question, category_id, status) VALUES (:name, :email, :question, :category_id, 'pending')");
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function answerUserQuestion($id, $answer) {
        $stmt = $this->db->prepare("UPDATE user_questions SET answer = :answer, status = 'answered', answered_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id, 'answer' => $answer]);
    }

    public function deleteUserQuestion($id) {
        $stmt = $this->db->prepare("DELETE FROM user_questions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function bulkDeleteUserQuestions($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM user_questions WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function bulkApproveUserQuestions($ids) {
        if (empty($ids)) return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE user_questions SET answer = '', status = 'answered', answered_at = NOW() WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    // Question Categories CRUD
    public function getQuestionCategories() {
        $stmt = $this->db->query("SELECT * FROM question_categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getQuestionCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM question_categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addQuestionCategory($name, $slug) {
        $stmt = $this->db->prepare("INSERT INTO question_categories (name, slug) VALUES (:name, :slug)");
        return $stmt->execute(['name' => $name, 'slug' => $slug]);
    }

    public function updateQuestionCategory($id, $name, $slug) {
        $stmt = $this->db->prepare("UPDATE question_categories SET name = :name, slug = :slug WHERE id = :id");
        return $stmt->execute(['id' => $id, 'name' => $name, 'slug' => $slug]);
    }

    public function deleteQuestionCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM question_categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Guest Answers Management
    public function getQuestionAnswers($question_id, $status = null) {
        $sql = "SELECT * FROM question_answers WHERE question_id = :question_id";
        $params = ['question_id' => $question_id];
        if ($status !== null) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }
        $sql .= " ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getAllAnswers($status = null) {
        $sql = "SELECT a.*, q.question FROM question_answers a JOIN user_questions q ON a.question_id = q.id";
        $params = [];
        if ($status !== null) {
            $sql .= " WHERE a.status = :status";
            $params['status'] = $status;
        }
        $sql .= " ORDER BY a.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getQuestionAnswerById($id) {
        $stmt = $this->db->prepare("SELECT a.*, q.question FROM question_answers a JOIN user_questions q ON a.question_id = q.id WHERE a.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addQuestionAnswer($data) {
        $stmt = $this->db->prepare("INSERT INTO question_answers (question_id, name, email, answer, status) VALUES (:question_id, :name, :email, :answer, 'pending')");
        return $stmt->execute($data);
    }

    public function approveQuestionAnswer($id) {
        $stmt = $this->db->prepare("UPDATE question_answers SET status = 'approved', approved_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function updateQuestionAnswer($id, $answer) {
        $stmt = $this->db->prepare("UPDATE question_answers SET answer = :answer WHERE id = :id");
        return $stmt->execute(['id' => $id, 'answer' => $answer]);
    }

    public function deleteQuestionAnswer($id) {
        $stmt = $this->db->prepare("DELETE FROM question_answers WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function addComment($data) {
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, name, email, comment, status) VALUES (:post_id, :name, :email, :comment, 'pending')");
        return $stmt->execute($data);
    }

    // Sidebar Slides methods
    public function getSidebarSlides() {
        $stmt = $this->db->query("SELECT * FROM sidebar_slides ORDER BY order_index ASC");
        $slides = $stmt->fetchAll();
        foreach ($slides as &$slide) {
            if (!empty($slide['image']) && strpos($slide['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $slide['image'] = str_replace('/insightzone/', URLROOT . '/', $slide['image']);
            }
        }
        return $slides;
    }

    public function getSidebarSlideById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sidebar_slides WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $slide = $stmt->fetch();
        if ($slide) {
            if (!empty($slide['image']) && strpos($slide['image'], '/insightzone/') === 0 && URLROOT !== '/insightzone') {
                $slide['image'] = str_replace('/insightzone/', URLROOT . '/', $slide['image']);
            }
        }
        return $slide;
    }

    public function addSidebarSlide($data) {
        $stmt = $this->db->prepare("INSERT INTO sidebar_slides (image, link, order_index) VALUES (:image, :link, :order_index)");
        return $stmt->execute([
            'image' => $data['image'] ?? '',
            'link' => $data['link'] ?? '',
            'order_index' => $data['order_index'] ?? 0
        ]);
    }

    public function updateSidebarSlide($id, $data) {
        $stmt = $this->db->prepare("UPDATE sidebar_slides SET image = :image, link = :link, order_index = :order_index WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'image' => $data['image'] ?? '',
            'link' => $data['link'] ?? '',
            'order_index' => $data['order_index'] ?? 0
        ]);
    }

    public function deleteSidebarSlide($id) {
        $stmt = $this->db->prepare("DELETE FROM sidebar_slides WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function initBookmarksTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS customer_bookmarked_questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            question_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY user_question (user_id, question_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function toggleBookmark($user_id, $question_id) {
        $this->initBookmarksTable();
        $stmt = $this->db->prepare("SELECT id FROM customer_bookmarked_questions WHERE user_id = :user_id AND question_id = :question_id");
        $stmt->execute(['user_id' => $user_id, 'question_id' => $question_id]);
        $bookmark = $stmt->fetch();

        if ($bookmark) {
            $stmt = $this->db->prepare("DELETE FROM customer_bookmarked_questions WHERE user_id = :user_id AND question_id = :question_id");
            $stmt->execute(['user_id' => $user_id, 'question_id' => $question_id]);
            return 'removed';
        } else {
            $stmt = $this->db->prepare("INSERT INTO customer_bookmarked_questions (user_id, question_id) VALUES (:user_id, :question_id)");
            $stmt->execute(['user_id' => $user_id, 'question_id' => $question_id]);
            return 'added';
        }
    }

    public function getBookmarkedQuestionIds($user_id) {
        $this->initBookmarksTable();
        $stmt = $this->db->prepare("SELECT question_id FROM customer_bookmarked_questions WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getBookmarkedQuestions($user_id) {
        $this->initBookmarksTable();
        $stmt = $this->db->prepare("SELECT q.*, c.name as category_name, c.slug as category_slug 
                                    FROM user_questions q
                                    LEFT JOIN question_categories c ON q.category_id = c.id
                                    JOIN customer_bookmarked_questions b ON q.id = b.question_id
                                    WHERE b.user_id = :user_id AND q.status = 'answered'
                                    ORDER BY b.created_at DESC");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function generateSeoKeywords($title, $content) {
        $text = $title . ' ' . strip_tags($content);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\p{M}\s]+/u', ' ', $text);
        $words = explode(' ', mb_strtolower($text, 'UTF-8'));
        
        $stopwords = [
            'এবং', 'ও', 'আর', 'না', 'হবে', 'করতে', 'করে', 'হলে', 'সেই', 'এই', 'যে', 'কে', 'একটি', 'হলো', 'করা', 'ছিল', 'থেকে', 'জন্য', 'পর', 'পারে',
            'the', 'and', 'a', 'of', 'to', 'is', 'in', 'that', 'it', 'on', 'for', 'with', 'as', 'was', 'at', 'by'
        ];
        
        $filteredWords = [];
        foreach ($words as $word) {
            $word = trim($word);
            if (mb_strlen($word, 'UTF-8') >= 3 && !in_array($word, $stopwords) && !is_numeric($word)) {
                $filteredWords[] = $word;
            }
        }
        
        $wordCounts = array_count_values($filteredWords);
        arsort($wordCounts);
        
        $keywords = array_keys(array_slice($wordCounts, 0, 8));
        return implode(', ', $keywords);
    }

    public function bulkGenerateMissingSeo() {
        try {
            $stmt = $this->db->query("SELECT id, title, content, excerpt, seo_title, seo_keywords FROM posts");
            $allPosts = $stmt->fetchAll();
            
            $brokenList = ['ইসল', 'রআন', 'ঘটন', 'একট', 'হওয', 'ইবন', 'সময'];
            $postsToUpdate = [];
            
            foreach ($allPosts as $post) {
                $needUpdate = false;
                $trimmedTitle = trim($post['seo_title'] ?? '');
                if (empty($trimmedTitle)) {
                    $needUpdate = true;
                } else if (!empty($post['seo_keywords'])) {
                    $keywordsArray = array_map('trim', explode(',', $post['seo_keywords']));
                    foreach ($brokenList as $broken) {
                        if (in_array($broken, $keywordsArray, true)) {
                            $needUpdate = true;
                            break;
                        }
                    }
                }
                
                if ($needUpdate) {
                    $postsToUpdate[] = $post;
                }
            }
            
            $updateStmt = $this->db->prepare("UPDATE posts SET seo_title = :seo_title, seo_description = :seo_description, seo_keywords = :seo_keywords WHERE id = :id");
            
            foreach ($postsToUpdate as $post) {
                $rawTitle = trim(strip_tags($post['title']));
                $seoTitle = !empty($rawTitle) ? mb_substr($rawTitle, 0, 60, 'UTF-8') : "Response Article #" . $post['id'];
                
                $descSource = !empty($post['excerpt']) ? $post['excerpt'] : $post['content'];
                $rawDesc = trim(strip_tags($descSource));
                $seoDesc = !empty($rawDesc) ? mb_substr($rawDesc, 0, 155, 'UTF-8') : "Read response article about " . $seoTitle;
                
                $seoKeywords = $this->generateSeoKeywords($post['title'], $post['content']);
                if (empty($seoKeywords)) {
                    $seoKeywords = "article, response, islamic, post";
                }
                
                $updateStmt->execute([
                    'seo_title' => $seoTitle,
                    'seo_description' => $seoDesc,
                    'seo_keywords' => $seoKeywords,
                    'id' => $post['id']
                ]);
            }
            
            \App\Helpers\Cache::clear();
            if (file_exists(APPROOT . '/cache/seo_error.log')) {
                @unlink(APPROOT . '/cache/seo_error.log');
            }
            return count($postsToUpdate);
        } catch (\Exception $e) {
            @file_put_contents(APPROOT . '/cache/seo_error.log', $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    public function getCommentsByPostId($post_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM comments WHERE post_id = :post_id AND status = 'approved' ORDER BY created_at DESC");
            $stmt->execute(['post_id' => $post_id]);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function initModulesTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS modules (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            icon VARCHAR(100) DEFAULT 'fa-solid fa-cube',
            url VARCHAR(255) DEFAULT '#',
            content LONGTEXT NULL,
            order_index INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function getModules() {
        $this->initModulesTable();
        $stmt = $this->db->query("SELECT * FROM modules ORDER BY order_index ASC, id ASC");
        return $stmt->fetchAll();
    }

    public function getModuleById($id) {
        $this->initModulesTable();
        $stmt = $this->db->prepare("SELECT * FROM modules WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addModule($data) {
        $this->initModulesTable();
        $stmt = $this->db->prepare("INSERT INTO modules (title, icon, url, content, order_index, status) VALUES (:title, :icon, :url, :content, :order_index, :status)");
        return $stmt->execute([
            'title' => $data['title'],
            'icon' => !empty($data['icon']) ? $data['icon'] : 'fa-solid fa-cube',
            'url' => !empty($data['url']) ? $data['url'] : '#',
            'content' => $data['content'] ?? '',
            'order_index' => isset($data['order_index']) ? intval($data['order_index']) : 0,
            'status' => $data['status'] ?? 'active'
        ]);
    }

    public function updateModule($id, $data) {
        $this->initModulesTable();
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE modules SET title = :title, icon = :icon, url = :url, content = :content, order_index = :order_index, status = :status WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'icon' => !empty($data['icon']) ? $data['icon'] : 'fa-solid fa-cube',
            'url' => !empty($data['url']) ? $data['url'] : '#',
            'content' => $data['content'] ?? '',
            'order_index' => isset($data['order_index']) ? intval($data['order_index']) : 0,
            'status' => $data['status'] ?? 'active'
        ]);
    }

    public function deleteModule($id) {
        $this->initModulesTable();
        $stmt = $this->db->prepare("DELETE FROM modules WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
