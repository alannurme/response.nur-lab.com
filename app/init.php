<?php
if (session_status() === PHP_SESSION_NONE) {
    // Keep session alive for 30 days unless they explicitly log out
    ini_set('session.cookie_lifetime', 2592000);
    ini_set('session.gc_maxlifetime', 2592000);
    
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 2592000,
        'path' => '/',
        'domain' => '',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Disable browser/proxy caching for all PHP requests
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Define URL Root dynamically (Works for both root domain and subfolder installations)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_dir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
$clean_dir = rtrim(str_replace('\\', '/', $script_dir), '/');
$urlroot = $protocol . $host . $clean_dir;
define('URLROOT', $urlroot);
define('PUBROOT', dirname(__DIR__) . '/public');

require_once 'Core/App.php';
require_once 'Core/Controller.php';
require_once 'Core/Model.php';
require_once 'Config/Database.php';

if (!function_exists('resolve_dynamic_url')) {
    function resolve_dynamic_url($path, $default_subfolder = '/public/img/') {
        if (empty($path)) {
            return '';
        }
        
        // If the path contains "public/", extract the relative part and prepend URLROOT
        $public_pos = strpos($path, 'public/');
        if ($public_pos !== false) {
            $relative = substr($path, $public_pos);
            return URLROOT . '/' . $relative;
        }
        
        // If it starts with http:// or https://, it's external, return as is
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }
        
        // Fallback
        return URLROOT . $default_subfolder . basename($path);
    }
}

if (!function_exists('clean_localhost_url')) {
    function clean_localhost_url($url) {
        if (empty($url)) {
            return '';
        }
        // If it starts with localhost or 127.0.0.1, replace the host part with URLROOT
        if (preg_match('/https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?(\/[a-zA-Z0-9_\-]+)?/i', $url, $matches)) {
            return str_replace($matches[0], URLROOT, $url);
        }
        return $url;
    }
}

if (!function_exists('resolve_setting_image')) {
    function resolve_setting_image($path) {
        return resolve_dynamic_url($path, '/public/');
    }
}

if (!function_exists('resolve_blog_image')) {
    function resolve_blog_image($path) {
        if (empty($path)) {
            return URLROOT . '/public/img/earth.jpg'; // fallback image
        }
        return resolve_dynamic_url($path, '/public/img/');
    }
}

// Auto-run database schema synchronization (Disabled for performance. Runs only on updates/clears)
// \App\Core\SchemaSync::sync();

// Check if the current visitor's IP is banned (associated with any banned user)
$client_ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
if (!empty($client_ip)) {
    if (strpos($client_ip, ',') !== false) {
        $client_ip = trim(explode(',', $client_ip)[0]);
    }
    
    try {
        $db = \App\Config\Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) FROM customer_users WHERE ip_address = ? AND is_banned = 1");
        $stmt->execute([$client_ip]);
        if ($stmt->fetchColumn() > 0) {
            http_response_code(403);
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Access Denied</title>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #334155; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                    .container { text-align: center; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 500px; border-top: 5px solid #ef4444; }
                    h1 { color: #ef4444; font-size: 2rem; margin-top: 0; }
                    p { font-size: 1.1rem; line-height: 1.6; }
                    .ip-box { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 1.1rem; font-weight: bold; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Access Denied</h1>
                    <p>Your IP address has been blocked from accessing this website.</p>
                    <div class='ip-box'>IP: " . htmlspecialchars($client_ip) . "</div>
                    <p style='font-size: 0.9rem; color: #64748b;'>If you believe this is an error, please contact the administrator.</p>
                </div>
            </body>
            </html>";
            exit;
        }
    } catch (\Exception $e) {
        // Silently catch database errors to avoid crashing the site
    }
}
