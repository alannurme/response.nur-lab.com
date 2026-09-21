<?php
namespace App\Core;

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (isset($url[0])) {
            // Map q&a to qa controller method
            if (strtolower($url[0]) === 'q&a') {
                $url[0] = 'qa';
            }

            // Handle robots.txt request
            if (strtolower($url[0]) === 'robots.txt') {
                $file = APPROOT . '/../robots.txt';
                if (!file_exists($file)) {
                    $file = APPROOT . '/../public/robots.txt';
                }
                if (file_exists($file)) {
                    header('Content-Type: text/plain; charset=utf-8');
                    readfile($file);
                    exit();
                }
            }

            // Handle sitemap.xml request dynamically
            if (strtolower($url[0]) === 'sitemap.xml') {
                $this->controller = 'Home';
                $this->method = 'sitemap';
                $this->params = [];
            }

            if (strtolower($url[0]) === 'p' && isset($url[1]) && is_numeric($url[1])) {
                require_once APPROOT . '/Config/Database.php';
                $db = \Config\Database::pdoConnect();

                $stmt = $db->prepare("SELECT slug FROM posts WHERE id = ? LIMIT 1");
                $stmt->execute([$url[1]]);
                $post = $stmt->fetch();
                if ($post) {
                    header('Location: ' . URLROOT . '/' . $post['slug'], true, 301);
                    exit();
                }
            }

            if (strtolower($url[0]) === 'posts') {
                header('Location: ' . URLROOT . '/blog' . (isset($url[1]) ? '/' . $url[1] : ''), true, 301);
                exit();
            }

            $firstSegment = ucfirst($url[0]);
            
            // 1. If it's a standard controller (other than Home), route to it normally
            if (file_exists(APPROOT . '/Controllers/' . $firstSegment . '.php') && strtolower($firstSegment) !== 'home') {
                $this->controller = $firstSegment;
                unset($url[0]);
                
                if (isset($url[1])) {
                    require_once APPROOT . '/Controllers/' . $this->controller . '.php';
                    $controllerClass = "App\Controllers\\" . $this->controller;
                    if (method_exists($controllerClass, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    }
                }
                $this->params = $url ? array_values($url) : [];
            }
            // 2. If it's a method on the default Home controller (e.g. videos, posts)
            else {
                require_once APPROOT . '/Controllers/Home.php';
                if (method_exists("App\Controllers\Home", $url[0])) {
                    $this->controller = 'Home';
                    $this->method = $url[0];
                    unset($url[0]);
                    $this->params = $url ? array_values($url) : [];
                }
                // 3. Otherwise, check if it's a slug/id in the database
                else {
                    $slug = $url[0];
                    require_once APPROOT . '/Config/Database.php';
                    $db = \Config\Database::pdoConnect();

                    
                    // A. Check if it's a Post Slug
                    $stmt = $db->prepare("SELECT id FROM posts WHERE slug = ? LIMIT 1");
                    $stmt->execute([$slug]);
                    if ($stmt->fetch()) {
                        $this->controller = 'Home';
                        $this->method = 'post';
                        $this->params = [$slug];
                    }
                    // B. Check if it's a Post Category Slug
                    else {
                        $stmt = $db->prepare("SELECT id FROM categories WHERE slug = ? LIMIT 1");
                        $stmt->execute([$slug]);
                        if ($stmt->fetch()) {
                            $this->controller = 'Home';
                            $this->method = 'blog';
                            $this->params = [$slug];
                        }
                        // C. Check if it's a Product Category Slug
                        else {
                            $stmt = $db->prepare("SELECT id FROM product_categories WHERE slug = ? LIMIT 1");
                            $stmt->execute([$slug]);
                            if ($stmt->fetch()) {
                                $this->controller = 'Shop';
                                $this->method = 'index';
                                $this->params = [$slug];
                            }
                            // D. Check if it's a Product ID (numeric)
                            else if (is_numeric($slug)) {
                                $stmt = $db->prepare("SELECT id FROM products WHERE id = ? LIMIT 1");
                                $stmt->execute([$slug]);
                                if ($stmt->fetch()) {
                                    $this->controller = 'Shop';
                                    $this->method = 'product';
                                    $this->params = [$slug];
                                }
                            }
                        }
                    }
                }
            }
        }

        // Load controller if not already loaded as object
        if (!is_object($this->controller)) {
            require_once APPROOT . '/Controllers/' . $this->controller . '.php';
            $controllerClass = "App\Controllers\\" . $this->controller;
            $this->controller = new $controllerClass;
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            // Separate query string from path
            $parts = explode('?', $requestUri, 2);
            $path = $parts[0];
            
            // Get base path from SCRIPT_NAME (e.g. /insightzone/index.php -> /insightzone)
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $basePath = dirname($scriptName);
            $basePath = str_replace('\\', '/', $basePath);
            if ($basePath !== '/') {
                $basePath = rtrim($basePath, '/');
            }
            
            // Strip base path from path
            if ($basePath !== '' && $basePath !== '/' && strpos($path, $basePath) === 0) {
                $path = substr($path, strlen($basePath));
            }
            
            $path = trim($path, '/');
            if ($path !== '') {
                return explode('/', rawurldecode($path));
            }
        }

        if (isset($_GET['url'])) {
            return explode('/', rtrim(rawurldecode($_GET['url']), '/'));
        }
        return [];
    }
}
