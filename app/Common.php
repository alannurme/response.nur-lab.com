<?php

/**
 * Common Functions
 *
 * This file contains global helper functions for the application.
 */


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

        // If absolute URL provided
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            // If it's a live server link, check if local file exists
            if (strpos($path, 'response.nur-lab.com') !== false || strpos($path, 'localhost') !== false) {
                $path_parts = parse_url($path);
                $relative_path = ltrim($path_parts['path'] ?? '', '/');
                // Remove project base directory if duplicated
                $relative_path = preg_replace('/^(response\.nur-lab\.com\/|islam\/)/i', '', $relative_path);
                $local_file_path = FCPATH . '../' . $relative_path;
                
                if (file_exists($local_file_path) || file_exists(FCPATH . $relative_path)) {
                    return URLROOT . '/' . $relative_path;
                }
            }
            return $url = clean_localhost_url($path);
        }
        
        $public_pos = strpos($path, 'public/');
        if ($public_pos !== false) {
            $relative = substr($path, $public_pos);
            $local_file = FCPATH . '../' . $relative;
            
            if (file_exists($local_file)) {
                return URLROOT . '/' . $relative;
            } else {
                // If local file missing, fallback to live server URL
                return 'https://response.nur-lab.com/' . $relative;
            }
        }
        
        $relative_sub = ltrim($default_subfolder, '/') . basename($path);
        $local_file_sub = FCPATH . '../' . $relative_sub;
        if (file_exists($local_file_sub)) {
            return URLROOT . '/' . $relative_sub;
        }

        return URLROOT . $default_subfolder . basename($path);
    }
}

if (!function_exists('clean_localhost_url')) {
    function clean_localhost_url($url) {
        if (empty($url)) {
            return '';
        }
        // If on localhost, replace live domain if local file exists or keep URLROOT
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

if (!function_exists('helper')) {
    /**
     * Safe override for helper() function to ensure missing vendor helper files
     * (e.g. system/Helpers/kint_helper.php) don't trigger fatal include_once errors on live server.
     *
     * @param list<string>|string $filenames
     */
    function helper($filenames): void
    {
        static $loaded = [];

        $loader = service('locator');

        if (!is_array($filenames)) {
            $filenames = [$filenames];
        }

        $includes = [];

        foreach ($filenames as $filename) {
            $systemHelper  = '';
            $appHelper     = '';
            $localIncludes = [];

            if (!str_contains($filename, '_helper')) {
                $filename .= '_helper';
            }

            if (in_array($filename, $loaded, true)) {
                continue;
            }

            if (str_contains($filename, '\\')) {
                $path = $loader->locateFile($filename, 'Helpers');
                if ($path !== false && is_file($path)) {
                    $includes[] = $path;
                    $loaded[]   = $filename;
                }
            } else {
                $paths = $loader->search('Helpers/' . $filename);

                foreach ($paths as $path) {
                    if (str_starts_with($path, APPPATH . 'Helpers' . DIRECTORY_SEPARATOR)) {
                        $appHelper = $path;
                    } elseif (str_starts_with($path, SYSTEMPATH . 'Helpers' . DIRECTORY_SEPARATOR)) {
                        $systemHelper = $path;
                    } else {
                        $localIncludes[] = $path;
                        $loaded[]        = $filename;
                    }
                }

                if ($appHelper !== '' && is_file($appHelper)) {
                    $includes[] = $appHelper;
                    $loaded[]   = $filename;
                }

                $includes = [...$includes, ...$localIncludes];

                if ($systemHelper !== '' && is_file($systemHelper)) {
                    $includes[] = $systemHelper;
                    $loaded[]   = $filename;
                }
            }
        }

        foreach ($includes as $path) {
            if (is_file($path)) {
                include_once $path;
            }
        }
    }
}
