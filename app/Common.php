<?php

/**
 * Common Functions
 *
 * This file contains global helper functions for the application.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('URLROOT')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script_dir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $clean_dir = rtrim(str_replace('\\', '/', $script_dir), '/');
    define('URLROOT', $protocol . $host . $clean_dir);
}

if (!defined('PUBROOT')) {
    define('PUBROOT', APPPATH . '../public');
}

if (!function_exists('resolve_dynamic_url')) {
    function resolve_dynamic_url($path, $default_subfolder = '/public/img/') {
        if (empty($path)) {
            return '';
        }
        
        $public_pos = strpos($path, 'public/');
        if ($public_pos !== false) {
            $relative = substr($path, $public_pos);
            return URLROOT . '/' . $relative;
        }
        
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }
        
        return URLROOT . $default_subfolder . basename($path);
    }
}

if (!function_exists('clean_localhost_url')) {
    function clean_localhost_url($url) {
        if (empty($url)) {
            return '';
        }
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
            return URLROOT . '/public/img/earth.jpg';
        }
        return resolve_dynamic_url($path, '/public/img/');
    }
}
