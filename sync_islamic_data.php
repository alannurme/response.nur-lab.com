<?php
/**
 * Islamic Data Sync Script
 * Fetches Quran and Hadith data from public APIs and caches them in the local database.
 * 
 * Run via: http://localhost/response.nur-lab.com/sync_islamic_data.php?action=quran&surah=1
 *          http://localhost/response.nur-lab.com/sync_islamic_data.php?action=quran_all
 *          http://localhost/response.nur-lab.com/sync_islamic_data.php?action=hadith&book=ben-bukhari
 *          http://localhost/response.nur-lab.com/sync_islamic_data.php?action=hadith_all
 *
 * Or from CLI (XAMPP):
 *   C:\xampp\php\php.exe sync_islamic_data.php quran_all
 *   C:\xampp\php\php.exe sync_islamic_data.php hadith_all
 */

set_time_limit(0);
ini_set('memory_limit', '512M');

// Load .env
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
                $value = substr($value, 1, -1);
            }
            $_ENV[$key] = $value;
        }
    }
}

// Establish PDO connection using .env or default parameters
$host = $_ENV['database.default.hostname'] ?? 'localhost';
$db   = $_ENV['database.default.database'] ?? 'response';
$user = $_ENV['database.default.username'] ?? 'root';
$pass = $_ENV['database.default.password'] ?? '';
$port = $_ENV['database.default.port'] ?? '3306';

$pdo = null;
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("DB Connection Error: " . $e->getMessage());
}

// ============================================================
// AUTO-CREATE TABLES (runs every time, safe due to IF NOT EXISTS)
// Live server-এও আলাদা setup ছাড়াই কাজ করবে
// ============================================================
$pdo->exec("
    CREATE TABLE IF NOT EXISTS `quran_cache` (
        `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `surah_num`   TINYINT UNSIGNED NOT NULL,
        `ayah_num`    SMALLINT UNSIGNED NOT NULL,
        `arabic`      TEXT CHARACTER SET utf8mb4 NOT NULL,
        `bangla`      TEXT CHARACTER SET utf8mb4 NOT NULL,
        `surah_name_bn`    VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
        `surah_name_ar`    VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
        `total_ayahs`      SMALLINT UNSIGNED NOT NULL DEFAULT 0,
        `tafsir_text`      MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL,
        `audio_url`        VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL,
        `cached_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `uq_surah_ayah` (`surah_num`, `ayah_num`),
        KEY `idx_surah` (`surah_num`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

// Check and add missing columns cleanly
$columnsStmt = $pdo->query("SHOW COLUMNS FROM `quran_cache` LIKE 'audio_url'");
if ($columnsStmt->rowCount() === 0) {
    $pdo->exec("ALTER TABLE `quran_cache` ADD COLUMN `audio_url` VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL");
}
$transStmt = $pdo->query("SHOW COLUMNS FROM `quran_cache` LIKE 'transliteration'");
if ($transStmt->rowCount() === 0) {
    $pdo->exec("ALTER TABLE `quran_cache` ADD COLUMN `transliteration` TEXT CHARACTER SET utf8mb4 DEFAULT NULL");
}

$pdo->exec("
    CREATE TABLE IF NOT EXISTS `hadith_cache` (
        `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `book_key`     VARCHAR(60) NOT NULL,
        `chapter_num`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
        `hadith_num`   INT UNSIGNED NOT NULL,
        `text_bn`      MEDIUMTEXT CHARACTER SET utf8mb4,
        `text_ar`      MEDIUMTEXT CHARACTER SET utf8mb4,
        `chapter_name` VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL,
        `cached_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `uq_book_hadith` (`book_key`, `hadith_num`),
        KEY `idx_book_chapter` (`book_key`, `chapter_num`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS `islamic_sync_log` (
        `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `type`        VARCHAR(30) NOT NULL,
        `source`      VARCHAR(100) NOT NULL,
        `records_saved` INT UNSIGNED NOT NULL DEFAULT 0,
        `status`      VARCHAR(20) NOT NULL DEFAULT 'success',
        `message`     TEXT,
        `synced_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

$isCLI = (php_sapi_name() === 'cli');


function latinToBnTranslit($str, $bnTranslation = '') {
    if (empty($str)) return $bnTranslation;
    if (preg_match('/[\x{0980}-\x{09FF}]/u', $str)) {
        return $str;
    }
    $syllableRules = [
        '/bismillaahir/i' => 'বিসমিল্লাহির', '/rahmaanir/i' => 'রাহমানির', '/raheem/i' => 'রাহীম',
        '/alhamdu/i' => 'আলহামদু', '/lillaahi/i' => 'লিল্লাহি', '/rabbil/i' => 'রাব্বিল',
        '/aalameen|\'aalameen/i' => 'আলামীন', '/maaliki/i' => 'মালিকি', '/yawmid/i' => 'ইয়াওমিদ',
        '/deen/i' => 'দীন', '/iyyaaka/i' => 'ইয়্যাকা', '/nabudu|na\'budu/i' => 'নাবুদু',
        '/nastaeen|nasta\'een/i' => 'নাস্তাইন', '/ihdinas/i' => 'ইহদিনাস', '/siraat|siraatal/i' => 'সিরাতাল',
        '/mustaqeem/i' => 'মুস্তাকীম', '/lazeena|lazina/i' => 'লাজিনা', '/anamta|an\'amta/i' => 'আনআমতা',
        '/alaihim|\'alaihim/i' => 'আলাইহিম', '/ghayril/i' => 'গাইরিল', '/maghdoobi/i' => 'মাগদূবি',
        '/daalleen/i' => 'দ্বাল্লীন', '/allaah|allah/i' => 'আল্লাহ', '/ilahi|ilaah/i' => 'ইলাহ',
    ];
    $res = $str;
    foreach ($syllableRules as $pat => $rep) {
        $res = preg_replace($pat, $rep, $res);
    }
    $charMap = [
        'sh' => 'শ', 'ch' => 'চ', 'kh' => 'খ', 'gh' => 'গ', 'ph' => 'ফ', 'th' => 'থ', 'dh' => 'ধ', 'zh' => 'ঝ',
        'aa' => 'আ', 'ee' => 'ঈ', 'oo' => 'ঊ', 'ou' => 'উ', 'ai' => 'আই', 'au' => 'আউ',
        'a' => 'আ', 'b' => 'ব', 'c' => 'ক', 'd' => 'দ', 'e' => 'এ', 'f' => 'ফ', 'g' => 'গ', 'h' => 'হ',
        'i' => 'ই', 'j' => 'জ', 'k' => 'ক', 'l' => 'ল', 'm' => 'ম', 'n' => 'ন', 'o' => 'ও', 'p' => 'প',
        'q' => 'ক', 'r' => 'র', 's' => 'স', 't' => 'ত', 'u' => 'উ', 'v' => 'ভ', 'w' => 'ওয়া', 'x' => 'ক্স',
        'y' => 'ইয়', 'z' => 'জ', "'" => '', '`' => ''
    ];
    $words = explode(' ', $res);
    $finalWords = [];
    foreach ($words as $w) {
        if (preg_match('/[a-zA-Z]/', $w)) {
            $wl = strtolower($w);
            foreach ($charMap as $f => $t) {
                $wl = str_replace($f, $t, $wl);
            }
            $finalWords[] = $wl;
        } else {
            $finalWords[] = $w;
        }
    }
    $out = implode(' ', $finalWords);
    return (empty($out) || preg_match('/[a-zA-Z]/', $out)) ? preg_replace('/[।?]/u', '', $bnTranslation) : $out;
}

function log_msg($msg) {
    global $isCLI;
    if ($isCLI) {
        echo $msg . "\n";
    } else {
        echo "<br>" . htmlspecialchars($msg);
        flush();
        ob_flush();
    }
}

function http_get($url, $timeout = 60) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($err || $httpCode >= 400 || empty($resp)) {
        return false;
    }
    return $resp;
}

// ============================================================
// ACTION ROUTER
// ============================================================
$action = $isCLI ? ($argv[1] ?? 'help') : ($_GET['action'] ?? 'help');

if (!$isCLI) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Islamic Data Sync</title></head><body>';
    echo '<h2>Islamic Data Sync</h2>';
}

switch ($action) {
    case 'quran_all':
        $tafsirId = $isCLI ? ($argv[2] ?? 'all') : ($_GET['tafsir'] ?? 'all');
        $reciter  = $isCLI ? ($argv[3] ?? 'ar.alafasy') : ($_GET['reciter'] ?? 'ar.alafasy');
        syncQuranAll($pdo, $tafsirId, $reciter);
        break;
    case 'quran':
        $surah    = $isCLI ? ($argv[2] ?? 1) : ($_GET['surah'] ?? 1);
        $tafsirId = $isCLI ? ($argv[3] ?? 'all') : ($_GET['tafsir'] ?? 'all');
        $reciter  = $isCLI ? ($argv[4] ?? 'ar.alafasy') : ($_GET['reciter'] ?? 'ar.alafasy');
        syncQuranSurah($pdo, (int)$surah, null, $tafsirId, $reciter);
        break;
    case 'hadith_all':
        syncHadithAll($pdo);
        break;
    case 'hadith':
        $book = $isCLI ? ($argv[2] ?? 'ben-bukhari') : ($_GET['book'] ?? 'ben-bukhari');
        syncHadithBook($pdo, $book);
        break;
    case 'status':
        showStatus($pdo);
        break;
    default:
        echo '<h3>Available actions:</h3>';
        echo '<ul>';
        echo '<li><a href="?action=quran_all">Sync All Quran (114 Surahs)</a></li>';
        echo '<li><a href="?action=quran&surah=1">Sync Surah 1 (Al-Fatiha)</a></li>';
        echo '<li><a href="?action=hadith_all">Sync All Hadith Books</a></li>';
        echo '<li><a href="?action=hadith&book=ben-bukhari">Sync Bukhari</a></li>';
        echo '<li><a href="?action=status">Show Sync Status</a></li>';
        echo '</ul>';
}

if (!$isCLI) {
    echo '</body></html>';
}

// ============================================================
// QURAN SYNC FUNCTIONS
// ============================================================

function syncQuranAll($pdo, $tafsirId = 'all', $reciter = 'ar.alafasy') {
    log_msg("=== Starting Full Quran Sync (Tafsir ID: $tafsirId, Reciter: $reciter) ===");
    $totalSaved = 0;

    // Surah metadata (Bangla names)
    $surahNames = getSurahMetadata();

    for ($s = 1; $s <= 114; $s++) {
        $saved = syncQuranSurah($pdo, $s, $surahNames, $tafsirId, $reciter);
        $totalSaved += $saved;
        usleep(300000); // 300ms delay between surahs to be polite to API
    }

    // Log to DB
    $stmt = $pdo->prepare("INSERT INTO islamic_sync_log (type, source, records_saved, status, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['quran', 'alquran.cloud+quran.com', $totalSaved, 'success', "Full sync: $totalSaved ayahs cached with Reciter $reciter"]);

    log_msg("=== Quran Sync Complete: $totalSaved ayahs saved ===");
}

function syncQuranSurah($pdo, $surahNum, $surahNames = null, $tafsirId = 'all', $reciter = 'ar.alafasy') {
    if ($surahNames === null) {
        $surahNames = getSurahMetadata();
    }

    log_msg("Syncing Surah $surahNum...");

    $data = null;

    // Try API 1: alquran.cloud (Arabic + Bangla in one call)
    $url1 = "https://api.alquran.cloud/v1/surah/$surahNum/editions/quran-simple,bn.bengali,en.transliteration";
    $resp = http_get($url1, 20);
    if ($resp) {
        $json = json_decode($resp, true);
        if (isset($json['data'][0]['ayahs']) && isset($json['data'][1]['ayahs'])) {
            $data = [
                'arabic' => $json['data'][0]['ayahs'],
                'bangla' => $json['data'][1]['ayahs'],
                'translit' => $json['data'][2]['ayahs'] ?? null
            ];
        }
    }

    // Try API 2: quran.com v4 (Arabic only, then fetch Bangla)
    if (!$data) {
        $url2ar = "https://api.quran.com/api/v4/quran/verses/uthmani?chapter_number=$surahNum";
        $url2bn = "https://api.quran.com/api/v4/verses/by_chapter/$surahNum?language=bn&translations=161&fields=text_uthmani&per_page=300";
        
        $respAr = http_get($url2ar, 20);
        $respBn = http_get($url2bn, 20);
        
        if ($respAr && $respBn) {
            $arData = json_decode($respAr, true);
            $bnData = json_decode($respBn, true);
            
            if (isset($arData['verses']) && isset($bnData['verses'])) {
                $arMap = [];
                foreach ($arData['verses'] as $v) {
                    $vNum = explode(':', $v['verse_key'])[1] ?? $v['id'];
                    $arMap[(int)$vNum] = $v['text_uthmani'];
                }
                $bnMap = [];
                foreach ($bnData['verses'] as $v) {
                    $vNum = explode(':', $v['verse_key'])[1] ?? $v['id'];
                    $bnMap[(int)$vNum] = $v['translations'][0]['text'] ?? '';
                }
                
                if (!empty($arMap) && !empty($bnMap)) {
                    $data = ['ar_map' => $arMap, 'bn_map' => $bnMap];
                }
            }
        }
    }

    // Try API 3: fawazahmed0 CDN
    if (!$data) {
        $urlAr3 = "https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/ara-quranindopak/$surahNum.json";
        $urlBn3 = "https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/ben-muhiuddinkhan/$surahNum.json";
        
        $respAr3 = http_get($urlAr3, 20);
        $respBn3 = http_get($urlBn3, 20);
        
        if ($respAr3 && $respBn3) {
            $arData3 = json_decode($respAr3, true);
            $bnData3 = json_decode($respBn3, true);
            
            if (isset($arData3['chapter']) && isset($bnData3['chapter'])) {
                $arMap3 = [];
                foreach ($arData3['chapter'] as $v) {
                    $arMap3[(int)$v['verse']] = $v['text'];
                }
                $bnMap3 = [];
                foreach ($bnData3['chapter'] as $v) {
                    $bnMap3[(int)$v['verse']] = $v['text'];
                }
                if (!empty($arMap3) && !empty($bnMap3)) {
                    $data = ['ar_map' => $arMap3, 'bn_map' => $bnMap3];
                }
            }
        }
    }

    if (!$data) {
        log_msg("  ❌ Failed to fetch Surah $surahNum from all APIs");
        return 0;
    }

    $meta = $surahNames[$surahNum] ?? ['bn' => "সূরা $surahNum", 'ar' => "سورة $surahNum", 'total' => 0];

    // Fetch selected Tafsir(s) from Quran.com v4 API
    $tafsirIdsToSync = ($tafsirId === 'all' || empty($tafsirId)) ? [165, 166, 164, 381, 169, 168] : [(int)$tafsirId];
    $tafsirMap = []; // $tafsirMap[$vNum][(string)$tid] = text

    foreach ($tafsirIdsToSync as $tid) {
        $urlTafsir = "https://api.quran.com/api/v4/tafsirs/$tid/by_chapter/$surahNum";
        $respTafsir = http_get($urlTafsir, 25);
        if ($respTafsir) {
            $jsonT = json_decode($respTafsir, true);
            if (isset($jsonT['tafsirs']) && is_array($jsonT['tafsirs'])) {
                foreach ($jsonT['tafsirs'] as $tItem) {
                    $vKey = $tItem['verse_key'] ?? '';
                    $parts = explode(':', $vKey);
                    if (count($parts) === 2) {
                        $vNum = (int)$parts[1];
                        if (!empty($tItem['text'])) {
                            $tafsirMap[$vNum][(string)$tid] = $tItem['text'];
                        }
                    }
                }
            }
        }
    }

    // Fetch existing Tafsir JSON from DB for this surah to merge and preserve previously synced tafsirs
    $existingTafsirs = [];
    try {
        $existingTafsirStmt = $pdo->prepare("SELECT ayah_num, tafsir_text FROM quran_cache WHERE surah_num = ?");
        $existingTafsirStmt->execute([$surahNum]);
        foreach ($existingTafsirStmt->fetchAll() as $row) {
            $d = json_decode($row['tafsir_text'] ?? '', true);
            if (is_array($d)) {
                $existingTafsirs[$row['ayah_num']] = $d;
            } elseif (!empty($row['tafsir_text'])) {
                $existingTafsirs[$row['ayah_num']] = ['165' => $row['tafsir_text']];
            }
        }
    } catch (\Throwable $e) {}

    // Insert into DB
    $stmt = $pdo->prepare("
        INSERT INTO quran_cache (surah_num, ayah_num, arabic, bangla, surah_name_bn, surah_name_ar, total_ayahs, tafsir_text, audio_url, transliteration)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE arabic = VALUES(arabic), bangla = VALUES(bangla),
            surah_name_bn = VALUES(surah_name_bn), surah_name_ar = VALUES(surah_name_ar),
            total_ayahs = VALUES(total_ayahs), tafsir_text = VALUES(tafsir_text),
            audio_url = VALUES(audio_url), transliteration = VALUES(transliteration), updated_at = NOW()
    ");

    $saved = 0;

    if (isset($data['arabic'])) {
        // Format from alquran.cloud
        $arabic = $data['arabic'];
        $bangla = $data['bangla'];
        $total = count($arabic);
        $meta['total'] = $total;

        foreach ($arabic as $i => $ayah) {
            $ayahNum = $ayah['numberInSurah'];
            $ar = $ayah['text'];
            $bn = $bangla[$i]['text'] ?? '';

            // Merge tafsirs
            $mergedT = $existingTafsirs[$ayahNum] ?? [];
            if (isset($tafsirMap[$ayahNum])) {
                foreach ($tafsirMap[$ayahNum] as $tid => $txt) {
                    $mergedT[(string)$tid] = $txt;
                }
            }
            $tf = !empty($mergedT) ? json_encode($mergedT, JSON_UNESCAPED_UNICODE) : null;

            $audioNum = $ayah['number'] ?? null;
            $sPad = str_pad($surahNum, 3, '0', STR_PAD_LEFT);
            $aPad = str_pad($ayahNum, 3, '0', STR_PAD_LEFT);

            $audioMap = [
                'ar.alafasy'            => $audioNum ? "https://cdn.islamic.network/quran/audio/128/ar.alafasy/$audioNum.mp3" : "https://everyayah.com/data/Alafasy_128kbps/{$sPad}{$aPad}.mp3",
                'ar.abdulbasitmurattal' => $audioNum ? "https://cdn.islamic.network/quran/audio/128/ar.abdulbasitmurattal/$audioNum.mp3" : "https://everyayah.com/data/Abdul_Basit_Murattal_192kbps/{$sPad}{$aPad}.mp3",
                'ar.sudais'             => $audioNum ? "https://cdn.islamic.network/quran/audio/128/ar.sudais/$audioNum.mp3" : "https://everyayah.com/data/Abdurrahmaan_As-Sudais_192kbps/{$sPad}{$aPad}.mp3",
                'ar.shatri'             => $audioNum ? "https://cdn.islamic.network/quran/audio/128/ar.shatri/$audioNum.mp3" : "https://everyayah.com/data/Abu_Bakr_Ash-Shaatree_128kbps/{$sPad}{$aPad}.mp3",
            ];
            $audioUrl = json_encode($audioMap, JSON_UNESCAPED_SLASHES);

            $rawTr = isset($data['translit'][$i]['text']) ? $data['translit'][$i]['text'] : null;
            $tr = latinToBnTranslit($rawTr, $bn);
            $stmt->execute([$surahNum, $ayahNum, $ar, $bn, $meta['bn'], $meta['ar'], $total, $tf, $audioUrl, $tr]);
            $saved++;
        }
    } elseif (isset($data['ar_map'])) {
        // Format from quran.com or fawazahmed0
        $arMap = $data['ar_map'];
        $bnMap = $data['bn_map'];
        $total = count($arMap);
        if ($meta['total'] == 0) $meta['total'] = $total;

        foreach ($arMap as $ayahNum => $ar) {
            $bn = $bnMap[$ayahNum] ?? '';

            // Merge tafsirs
            $mergedT = $existingTafsirs[$ayahNum] ?? [];
            if (isset($tafsirMap[$ayahNum])) {
                foreach ($tafsirMap[$ayahNum] as $tid => $txt) {
                    $mergedT[(string)$tid] = $txt;
                }
            }
            $tf = !empty($mergedT) ? json_encode($mergedT, JSON_UNESCAPED_UNICODE) : null;

            $sPad = str_pad($surahNum, 3, '0', STR_PAD_LEFT);
            $aPad = str_pad($ayahNum, 3, '0', STR_PAD_LEFT);

            $audioMap = [
                'ar.alafasy'            => "https://everyayah.com/data/Alafasy_128kbps/{$sPad}{$aPad}.mp3",
                'ar.abdulbasitmurattal' => "https://everyayah.com/data/Abdul_Basit_Murattal_192kbps/{$sPad}{$aPad}.mp3",
                'ar.sudais'             => "https://everyayah.com/data/Abdurrahmaan_As-Sudais_192kbps/{$sPad}{$aPad}.mp3",
                'ar.shatri'             => "https://everyayah.com/data/Abu_Bakr_Ash-Shaatree_128kbps/{$sPad}{$aPad}.mp3",
            ];
            $audioUrl = json_encode($audioMap, JSON_UNESCAPED_SLASHES);

            $rawTr = isset($data['translit'][$i]['text']) ? $data['translit'][$i]['text'] : null;
            $tr = latinToBnTranslit($rawTr, $bn);
            $stmt->execute([$surahNum, $ayahNum, $ar, $bn, $meta['bn'], $meta['ar'], $total, $tf, $audioUrl, $tr]);
            $saved++;
        }
    }

    log_msg("  ✅ Surah $surahNum: $saved ayahs saved");
    return $saved;
}

function getSurahMetadata() {
    return [
        1  => ['bn' => 'আল-ফাতিহা', 'ar' => 'الفاتحة', 'total' => 7],
        2  => ['bn' => 'আল-বাকারা', 'ar' => 'البقرة', 'total' => 286],
        3  => ['bn' => 'আল-ইমরান', 'ar' => 'آل عمران', 'total' => 200],
        4  => ['bn' => 'আন-নিসা', 'ar' => 'النساء', 'total' => 176],
        5  => ['bn' => 'আল-মায়িদা', 'ar' => 'المائدة', 'total' => 120],
        6  => ['bn' => 'আল-আনআম', 'ar' => 'الأنعام', 'total' => 165],
        7  => ['bn' => 'আল-আরাফ', 'ar' => 'الأعراف', 'total' => 206],
        8  => ['bn' => 'আল-আনফাল', 'ar' => 'الأنفال', 'total' => 75],
        9  => ['bn' => 'আত-তাওবা', 'ar' => 'التوبة', 'total' => 129],
        10 => ['bn' => 'ইউনুস', 'ar' => 'يونس', 'total' => 109],
        11 => ['bn' => 'হূদ', 'ar' => 'هود', 'total' => 123],
        12 => ['bn' => 'ইউসুফ', 'ar' => 'يوسف', 'total' => 111],
        13 => ['bn' => 'আর-রাদ', 'ar' => 'الرعد', 'total' => 43],
        14 => ['bn' => 'ইবরাহীম', 'ar' => 'إبراهيم', 'total' => 52],
        15 => ['bn' => 'আল-হিজর', 'ar' => 'الحجر', 'total' => 99],
        16 => ['bn' => 'আন-নাহল', 'ar' => 'النحل', 'total' => 128],
        17 => ['bn' => 'আল-ইসরা', 'ar' => 'الإسراء', 'total' => 111],
        18 => ['bn' => 'আল-কাহফ', 'ar' => 'الكهف', 'total' => 110],
        19 => ['bn' => 'মারইয়াম', 'ar' => 'مريم', 'total' => 98],
        20 => ['bn' => 'ত্বা-হা', 'ar' => 'طه', 'total' => 135],
        21 => ['bn' => 'আল-আম্বিয়া', 'ar' => 'الأنبياء', 'total' => 112],
        22 => ['bn' => 'আল-হজ্জ', 'ar' => 'الحج', 'total' => 78],
        23 => ['bn' => 'আল-মুমিনুন', 'ar' => 'المؤمنون', 'total' => 118],
        24 => ['bn' => 'আন-নূর', 'ar' => 'النور', 'total' => 64],
        25 => ['bn' => 'আল-ফুরকান', 'ar' => 'الفرقان', 'total' => 77],
        26 => ['bn' => 'আশ-শুআরা', 'ar' => 'الشعراء', 'total' => 227],
        27 => ['bn' => 'আন-নামল', 'ar' => 'النمل', 'total' => 93],
        28 => ['bn' => 'আল-কাসাস', 'ar' => 'القصص', 'total' => 88],
        29 => ['bn' => 'আল-আনকাবুত', 'ar' => 'العنكبوت', 'total' => 69],
        30 => ['bn' => 'আর-রূম', 'ar' => 'الروم', 'total' => 60],
        31 => ['bn' => 'লুকমান', 'ar' => 'لقمان', 'total' => 34],
        32 => ['bn' => 'আস-সাজদা', 'ar' => 'السجدة', 'total' => 30],
        33 => ['bn' => 'আল-আহযাব', 'ar' => 'الأحزاب', 'total' => 73],
        34 => ['bn' => 'সাবা', 'ar' => 'سبأ', 'total' => 54],
        35 => ['bn' => 'ফাতির', 'ar' => 'فاطر', 'total' => 45],
        36 => ['bn' => 'ইয়া-সীন', 'ar' => 'يس', 'total' => 83],
        37 => ['bn' => 'আস-সাফফাত', 'ar' => 'الصافات', 'total' => 182],
        38 => ['bn' => 'সাদ', 'ar' => 'ص', 'total' => 88],
        39 => ['bn' => 'আয-যুমার', 'ar' => 'الزمر', 'total' => 75],
        40 => ['bn' => 'গাফির', 'ar' => 'غافر', 'total' => 85],
        41 => ['bn' => 'ফুস্সিলাত', 'ar' => 'فصلت', 'total' => 54],
        42 => ['bn' => 'আশ-শূরা', 'ar' => 'الشورى', 'total' => 53],
        43 => ['bn' => 'আয-যুখরুফ', 'ar' => 'الزخرف', 'total' => 89],
        44 => ['bn' => 'আদ-দুখান', 'ar' => 'الدخان', 'total' => 59],
        45 => ['bn' => 'আল-জাসিয়া', 'ar' => 'الجاثية', 'total' => 37],
        46 => ['bn' => 'আল-আহকাফ', 'ar' => 'الأحقاف', 'total' => 35],
        47 => ['bn' => 'মুহাম্মদ', 'ar' => 'محمد', 'total' => 38],
        48 => ['bn' => 'আল-ফাতহ', 'ar' => 'الفتح', 'total' => 29],
        49 => ['bn' => 'আল-হুজুরাত', 'ar' => 'الحجرات', 'total' => 18],
        50 => ['bn' => 'ক্বাফ', 'ar' => 'ق', 'total' => 45],
        51 => ['bn' => 'আয-যারিয়াত', 'ar' => 'الذاريات', 'total' => 60],
        52 => ['bn' => 'আত-তূর', 'ar' => 'الطور', 'total' => 49],
        53 => ['bn' => 'আন-নাজম', 'ar' => 'النجم', 'total' => 62],
        54 => ['bn' => 'আল-ক্বামার', 'ar' => 'القمر', 'total' => 55],
        55 => ['bn' => 'আর-রাহমান', 'ar' => 'الرحمن', 'total' => 78],
        56 => ['bn' => 'আল-ওয়াকিআ', 'ar' => 'الواقعة', 'total' => 96],
        57 => ['bn' => 'আল-হাদীদ', 'ar' => 'الحديد', 'total' => 29],
        58 => ['bn' => 'আল-মুজাদালা', 'ar' => 'المجادلة', 'total' => 22],
        59 => ['bn' => 'আল-হাশর', 'ar' => 'الحشر', 'total' => 24],
        60 => ['bn' => 'আল-মুমতাহিনা', 'ar' => 'الممتحنة', 'total' => 13],
        61 => ['bn' => 'আস-সাফ', 'ar' => 'الصف', 'total' => 14],
        62 => ['bn' => 'আল-জুমুআ', 'ar' => 'الجمعة', 'total' => 11],
        63 => ['bn' => 'আল-মুনাফিকুন', 'ar' => 'المنافقون', 'total' => 11],
        64 => ['bn' => 'আত-তাগাবুন', 'ar' => 'التغابن', 'total' => 18],
        65 => ['bn' => 'আত-তালাক', 'ar' => 'الطلاق', 'total' => 12],
        66 => ['bn' => 'আত-তাহরীম', 'ar' => 'التحريم', 'total' => 12],
        67 => ['bn' => 'আল-মুলক', 'ar' => 'الملك', 'total' => 30],
        68 => ['bn' => 'আল-কালাম', 'ar' => 'القلم', 'total' => 52],
        69 => ['bn' => 'আল-হাক্কা', 'ar' => 'الحاقة', 'total' => 52],
        70 => ['bn' => 'আল-মাআরিজ', 'ar' => 'المعارج', 'total' => 44],
        71 => ['bn' => 'নূহ', 'ar' => 'نوح', 'total' => 28],
        72 => ['bn' => 'আল-জিন', 'ar' => 'الجن', 'total' => 28],
        73 => ['bn' => 'আল-মুয্যাম্মিল', 'ar' => 'المزمل', 'total' => 20],
        74 => ['bn' => 'আল-মুদ্দাসসির', 'ar' => 'المدثر', 'total' => 56],
        75 => ['bn' => 'আল-কিয়ামা', 'ar' => 'القيامة', 'total' => 40],
        76 => ['bn' => 'আল-ইনসান', 'ar' => 'الإنسان', 'total' => 31],
        77 => ['bn' => 'আল-মুরসালাত', 'ar' => 'المرسلات', 'total' => 50],
        78 => ['bn' => 'আন-নাবা', 'ar' => 'النبأ', 'total' => 40],
        79 => ['bn' => 'আন-নাযিআত', 'ar' => 'النازعات', 'total' => 46],
        80 => ['bn' => 'আবাসা', 'ar' => 'عبس', 'total' => 42],
        81 => ['bn' => 'আত-তাকবীর', 'ar' => 'التكوير', 'total' => 29],
        82 => ['bn' => 'আল-ইনফিতার', 'ar' => 'الانفطار', 'total' => 19],
        83 => ['bn' => 'আল-মুতাফফিফীন', 'ar' => 'المطففين', 'total' => 36],
        84 => ['bn' => 'আল-ইনশিকাক', 'ar' => 'الانشقاق', 'total' => 25],
        85 => ['bn' => 'আল-বুরূজ', 'ar' => 'البروج', 'total' => 22],
        86 => ['bn' => 'আত-তারিক', 'ar' => 'الطارق', 'total' => 17],
        87 => ['bn' => 'আল-আলা', 'ar' => 'الأعلى', 'total' => 19],
        88 => ['bn' => 'আল-গাশিয়া', 'ar' => 'الغاشية', 'total' => 26],
        89 => ['bn' => 'আল-ফজর', 'ar' => 'الفجر', 'total' => 30],
        90 => ['bn' => 'আল-বালাদ', 'ar' => 'البلد', 'total' => 20],
        91 => ['bn' => 'আশ-শামস', 'ar' => 'الشمس', 'total' => 15],
        92 => ['bn' => 'আল-লাইল', 'ar' => 'الليل', 'total' => 21],
        93 => ['bn' => 'আদ-দুহা', 'ar' => 'الضحى', 'total' => 11],
        94 => ['bn' => 'আশ-শারহ', 'ar' => 'الشرح', 'total' => 8],
        95 => ['bn' => 'আত-তীন', 'ar' => 'التين', 'total' => 8],
        96 => ['bn' => 'আল-আলাক', 'ar' => 'العلق', 'total' => 19],
        97 => ['bn' => 'আল-কদর', 'ar' => 'القدر', 'total' => 5],
        98 => ['bn' => 'আল-বাইয়িনা', 'ar' => 'البينة', 'total' => 8],
        99 => ['bn' => 'আয-যালযালা', 'ar' => 'الزلزلة', 'total' => 8],
        100 => ['bn' => 'আল-আদিয়াত', 'ar' => 'العاديات', 'total' => 11],
        101 => ['bn' => 'আল-ক্বারিআ', 'ar' => 'القارعة', 'total' => 11],
        102 => ['bn' => 'আত-তাকাসুর', 'ar' => 'التكاثر', 'total' => 8],
        103 => ['bn' => 'আল-আসর', 'ar' => 'العصر', 'total' => 3],
        104 => ['bn' => 'আল-হুমাযা', 'ar' => 'الهمزة', 'total' => 9],
        105 => ['bn' => 'আল-ফীল', 'ar' => 'الفيل', 'total' => 5],
        106 => ['bn' => 'কুরাইশ', 'ar' => 'قريش', 'total' => 4],
        107 => ['bn' => 'আল-মাউন', 'ar' => 'الماعون', 'total' => 7],
        108 => ['bn' => 'আল-কাওসার', 'ar' => 'الكوثر', 'total' => 3],
        109 => ['bn' => 'আল-কাফিরুন', 'ar' => 'الكافرون', 'total' => 6],
        110 => ['bn' => 'আন-নাসর', 'ar' => 'النصر', 'total' => 3],
        111 => ['bn' => 'আল-মাসাদ', 'ar' => 'المسد', 'total' => 5],
        112 => ['bn' => 'আল-ইখলাস', 'ar' => 'الإخلاص', 'total' => 4],
        113 => ['bn' => 'আল-ফালাক', 'ar' => 'الفلق', 'total' => 5],
        114 => ['bn' => 'আন-নাস', 'ar' => 'الناس', 'total' => 6],
    ];
}

// ============================================================
// HADITH SYNC FUNCTIONS
// ============================================================

function getHadithBooks() {
    return [
        'ben-bukhari'       => 'সহীহ বুখারী',
        'ben-muslim'        => 'সহীহ মুসলিম',
        'ben-abudawud'      => 'সূনানে আবু দাউদ',
        'ben-tirmidhi'      => 'জামে আত-তিরমিযী',
        'ben-nasai'         => 'সূনানে আন-নাসায়ী',
        'ben-ibnmajah'      => 'সূনানে ইবনে মাজাহ',
        'ben-malik'         => 'মুয়াত্তা মালিক',
        'ben-nawawi'        => '৪০ হাদিস (ইমাম নববী)',
    ];
}

function syncHadithAll($pdo) {
    log_msg("=== Starting Full Hadith Sync ===");
    $books = getHadithBooks();
    $totalSaved = 0;

    foreach ($books as $bookKey => $bookName) {
        log_msg("Syncing $bookName ($bookKey)...");
        $saved = syncHadithBook($pdo, $bookKey);
        $totalSaved += $saved;
        sleep(1); // Be polite to CDN
    }

    $stmt = $pdo->prepare("INSERT INTO islamic_sync_log (type, source, records_saved, status, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['hadith', 'fawazahmed0-cdn', $totalSaved, 'success', "Full sync: $totalSaved hadiths cached"]);

    log_msg("=== Hadith Sync Complete: $totalSaved hadiths saved ===");
}

function syncHadithBook($pdo, $bookKey) {
    // 1. Fetch Bangla Hadiths
    $cdnUrls = [
        "https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/$bookKey.min.json",
        "https://cdn.fastly.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/$bookKey.min.json",
        "https://raw.githubusercontent.com/fawazahmed0/hadith-api/1/editions/$bookKey.min.json",
    ];

    $resp = false;
    foreach ($cdnUrls as $url) {
        log_msg("  Trying Bangla: $url");
        $resp = http_get($url, 60);
        if ($resp && strlen($resp) > 100) break;
        usleep(300000);
    }

    if (!$resp || strlen($resp) < 100) {
        log_msg("  ❌ Failed to fetch $bookKey (Bangla) from CDNs");
        return 0;
    }

    $data = json_decode($resp, true);
    if (!isset($data['hadiths'])) {
        log_msg("  ❌ Invalid data format for $bookKey");
        return 0;
    }

    // 2. Fetch Arabic Hadiths for the same book
    $araBookKey = str_replace('ben-', 'ara-', $bookKey);
    $araCdnUrls = [
        "https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/$araBookKey.min.json",
        "https://cdn.fastly.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/$araBookKey.min.json",
        "https://raw.githubusercontent.com/fawazahmed0/hadith-api/1/editions/$araBookKey.min.json",
    ];

    $araMap = [];
    $araResp = false;
    foreach ($araCdnUrls as $url) {
        log_msg("  Trying Arabic: $url");
        $araResp = http_get($url, 60);
        if ($araResp && strlen($araResp) > 100) break;
        usleep(300000);
    }

    if ($araResp && strlen($araResp) > 100) {
        $araData = json_decode($araResp, true);
        if (isset($araData['hadiths'])) {
            foreach ($araData['hadiths'] as $ah) {
                $hNum = (int)($ah['hadithnumber'] ?? 0);
                if ($hNum > 0 && !empty($ah['text'])) {
                    $araMap[$hNum] = $ah['text'];
                }
            }
            log_msg("  ✅ Loaded " . count($araMap) . " Arabic hadith texts");
        }
    }

    $stmt = $pdo->prepare("
        INSERT INTO hadith_cache (book_key, chapter_num, hadith_num, text_bn, text_ar, chapter_name)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE text_bn = VALUES(text_bn), text_ar = VALUES(text_ar),
            chapter_num = VALUES(chapter_num), chapter_name = VALUES(chapter_name), updated_at = NOW()
    ");

    $saved = 0;
    foreach ($data['hadiths'] as $hadith) {
        $num     = (int)($hadith['hadithnumber'] ?? 0);
        $textBn  = $hadith['text'] ?? '';
        $textAr  = $araMap[$num] ?? null;
        $chapter = (int)($hadith['reference']['book'] ?? $hadith['reference']['chapter'] ?? $hadith['chapter'] ?? 0);
        $chapName= $hadith['chaptername'] ?? ($data['metadata']['sections'][(string)$chapter] ?? null);

        if ($num > 0 && !empty($textBn)) {
            $stmt->execute([$bookKey, $chapter, $num, $textBn, $textAr, $chapName]);
            $saved++;
        }
    }

    log_msg("  ✅ $bookKey: $saved Bangla & Arabic hadiths saved to local DB");
    return $saved;
}

function showStatus($pdo) {
    echo "<h3>Quran Cache:</h3>";
    $stmt = $pdo->query("SELECT surah_num, COUNT(*) as ayahs, MIN(updated_at) as first, MAX(updated_at) as last FROM quran_cache GROUP BY surah_num ORDER BY surah_num");
    $rows = $stmt->fetchAll();
    echo "<p>Surahs cached: " . count($rows) . " / 114</p>";
    
    $stmt2 = $pdo->query("SELECT COUNT(*) FROM quran_cache");
    echo "<p>Total Ayahs: " . $stmt2->fetchColumn() . " / 6236</p>";

    echo "<h3>Hadith Cache:</h3>";
    $stmt3 = $pdo->query("SELECT book_key, COUNT(*) as cnt, MAX(updated_at) as updated FROM hadith_cache GROUP BY book_key ORDER BY book_key");
    $hrows = $stmt3->fetchAll();
    foreach ($hrows as $r) {
        echo "<p>{$r['book_key']}: {$r['cnt']} hadiths (updated: {$r['updated']})</p>";
    }

    echo "<h3>Sync Log (Last 20):</h3>";
    $stmt4 = $pdo->query("SELECT * FROM islamic_sync_log ORDER BY synced_at DESC LIMIT 20");
    $logs = $stmt4->fetchAll();
    echo "<table border='1' cellpadding='4'><tr><th>Type</th><th>Source</th><th>Records</th><th>Status</th><th>Time</th></tr>";
    foreach ($logs as $l) {
        echo "<tr><td>{$l['type']}</td><td>{$l['source']}</td><td>{$l['records_saved']}</td><td>{$l['status']}</td><td>{$l['synced_at']}</td></tr>";
    }
    echo "</table>";
}
