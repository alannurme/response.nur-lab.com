<?php
header("Content-Type: application/manifest+json; charset=utf-8");

$site_name = "Response with Nur-Lab";
$site_short = "NUR-LAB";

try {
    $env_file = __DIR__ . '/.env';
    if (!file_exists($env_file)) {
        $env_file = dirname(__DIR__) . '/.env';
    }
    if (file_exists($env_file)) {
        $lines = file($env_file);
        $env = [];
        foreach ($lines as $line) {
            $parts = explode('=', trim($line), 2);
            if (count($parts) === 2) {
                $env[trim($parts[0])] = trim($parts[1], " '\"");
            }
        }
        $host = $env['database.default.hostname'] ?? 'localhost';
        $user = $env['database.default.username'] ?? 'root';
        $pass = $env['database.default.password'] ?? '';
        $dbname = $env['database.default.database'] ?? 'responsi_nr';

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key = 'site_title'");
        if ($stmt) {
            $rows = $stmt->fetchAll();
            foreach ($rows as $r) {
                if ($r['setting_key'] === 'site_title' && !empty($r['setting_value'])) {
                    $site_name = $r['setting_value'];
                    $site_short = mb_substr($r['setting_value'], 0, 15);
                }
            }
        }
    }
} catch (Throwable $e) {}

$manifest = [
    "name" => $site_name,
    "short_name" => $site_short,
    "description" => $site_name . " - ইসলাম, দর্শন, বিজ্ঞান ও সমসাময়িক বিষয়ের অনলাইন প্ল্যাটফর্ম",
    "start_url" => "/",
    "scope" => "/",
    "display" => "standalone",
    "background_color" => "#060b18",
    "theme_color" => "#044e39",
    "orientation" => "any",
    "categories" => ["books", "lifestyle", "education"],
    "icons" => [
        [
            "src" => "/public/img/icon-192.png",
            "sizes" => "192x192",
            "type" => "image/png",
            "purpose" => "any"
        ],
        [
            "src" => "/public/img/icon-512.png",
            "sizes" => "512x512",
            "type" => "image/png",
            "purpose" => "any"
        ],
        [
            "src" => "/public/img/icon-maskable-512.png",
            "sizes" => "512x512",
            "type" => "image/png",
            "purpose" => "maskable"
        ]
    ]
];

echo json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
