<?php
namespace App\Helpers;

if (!class_exists(\App\Helpers\Cache::class)) {
    require_once APPPATH . 'Helpers/Cache.php';
}

class YouTubeService {

    /**
     * Resolve the uploads playlist ID for a channel.
     * Uses only 1 quota unit.
     */
    public static function getUploadsPlaylistId(string $apiKey, string $channelIdOrHandle): ?string {
        $channelIdOrHandle = trim($channelIdOrHandle);
        if (empty($apiKey) || empty($channelIdOrHandle)) {
            return null;
        }

        $cacheKey = 'yt_uploads_pl_' . md5($channelIdOrHandle);
        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }

        $isHandle = (strpos($channelIdOrHandle, '@') === 0) || !preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $channelIdOrHandle);
        
        if ($isHandle) {
            $handle = ltrim($channelIdOrHandle, '@');
            $url = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forHandle=' . urlencode($handle) . '&key=' . urlencode($apiKey);
        } else {
            $url = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=' . urlencode($channelIdOrHandle) . '&key=' . urlencode($apiKey);
        }

        $res = self::makeRequest($url);
        if (!empty($res['items'][0]['contentDetails']['relatedPlaylists']['uploads'])) {
            $uploadsId = $res['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
            Cache::set($cacheKey, $uploadsId, 86400 * 7); // Cache for 7 days
            return $uploadsId;
        }

        // Fallback for custom username
        if ($isHandle) {
            $url2 = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=' . urlencode($handle) . '&key=' . urlencode($apiKey);
            $res2 = self::makeRequest($url2);
            if (!empty($res2['items'][0]['contentDetails']['relatedPlaylists']['uploads'])) {
                $uploadsId = $res2['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
                Cache::set($cacheKey, $uploadsId, 86400 * 7);
                return $uploadsId;
            }
        }

        return null;
    }

    /**
     * Fetch latest videos from channel's uploads playlist.
     * Costs only 1 quota unit.
     */
    public static function fetchLatestVideos(string $apiKey, string $channelIdOrHandle, int $maxResults = 20): array {
        $uploadsPlaylistId = self::getUploadsPlaylistId($apiKey, $channelIdOrHandle);
        if (!$uploadsPlaylistId) {
            return ['success' => false, 'error' => 'চ্যানেল বা আপলোড প্লেলিস্ট খুঁজে পাওয়া যায়নি। অনুগ্রহ করে Channel ID বা Handle চেক করুন।'];
        }

        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=' . urlencode($uploadsPlaylistId) . '&maxResults=' . min($maxResults, 50) . '&key=' . urlencode($apiKey);
        $res = self::makeRequest($url);

        if (!empty($res['error'])) {
            return ['success' => false, 'error' => $res['error']['message'] ?? 'YouTube API রিকোয়েস্ট ব্যর্থ হয়েছে।'];
        }

        if (empty($res['items'])) {
            return ['success' => true, 'videos' => []];
        }

        $videos = [];
        foreach ($res['items'] as $item) {
            $snippet = $item['snippet'] ?? [];
            $videoId = $snippet['resourceId']['videoId'] ?? null;
            if (!$videoId) continue;

            $title = $snippet['title'] ?? 'ভিডিও';
            if ($title === 'Private video' || $title === 'Deleted video') continue;

            $videos[] = [
                'video_id'    => $videoId,
                'title'       => $title,
                'description' => $snippet['description'] ?? '',
                'video_url'   => 'https://www.youtube.com/watch?v=' . $videoId,
                'published_at'=> !empty($snippet['publishedAt']) ? date('Y-m-d H:i:s', strtotime($snippet['publishedAt'])) : date('Y-m-d H:i:s'),
                'thumbnail'   => $snippet['thumbnails']['high']['url'] ?? ($snippet['thumbnails']['default']['url'] ?? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"),
            ];
        }

        return ['success' => true, 'videos' => $videos];
    }

    /**
     * Sync latest videos into `yt_videos` table.
     */
    public static function syncVideosToDatabase(string $apiKey, string $channelIdOrHandle, ?int $categoryId = null): array {
        try {
            $result = self::fetchLatestVideos($apiKey, $channelIdOrHandle, 30);
            if (!$result['success']) {
                return $result;
            }

            $videos = $result['videos'];
            if (empty($videos)) {
                return ['success' => true, 'added' => 0, 'total' => 0, 'message' => 'চ্যানেলে কোনো পাবলিক ভিডিও পাওয়া যায়নি।'];
            }

            $pdo = \Config\Database::pdoConnect();
            
            // Fetch existing video IDs
            $existing = $pdo->query("SELECT video_id FROM yt_videos WHERE video_id IS NOT NULL")->fetchAll(\PDO::FETCH_COLUMN);
            $existingMap = array_flip($existing);

            $insertedCount = 0;
            $insertStmt = $pdo->prepare("INSERT INTO yt_videos (category_id, title, video_url, video_id, description, created_at) VALUES (:cat_id, :title, :url, :vid, :desc, :created)");

            foreach ($videos as $v) {
                if (isset($existingMap[$v['video_id']])) {
                    continue; // Already in database
                }

                $insertStmt->execute([
                    'cat_id'  => $categoryId,
                    'title'   => $v['title'],
                    'url'     => $v['video_url'],
                    'vid'     => $v['video_id'],
                    'desc'    => $v['description'],
                    'created' => $v['published_at']
                ]);
                $insertedCount++;
            }

            // Update last sync time
            $adminModel = new \App\Models\AdminModel();
            $adminModel->updateSetting('youtube_last_sync', date('Y-m-d H:i:s'));
            \App\Helpers\Cache::clear();

            return [
                'success' => true,
                'added'   => $insertedCount,
                'total'   => count($videos),
                'message' => "সফলভাবে সিঙ্ক সম্পন্ন হয়েছে! {$insertedCount}টি নতুন ভিডিও ডাটাবেসে যুক্ত হয়েছে।"
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => 'সিঙ্ক প্রক্রিয়ায় ত্রুটি: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check if the channel is currently live streaming.
     * Caches result for 5 minutes (300 seconds) to conserve quota.
     */
    public static function checkLiveStream(string $apiKey, string $channelIdOrHandle, bool $force = false): array {
        $channelIdOrHandle = trim($channelIdOrHandle);
        if (empty($apiKey) || empty($channelIdOrHandle)) {
            return ['is_live' => false, 'video_id' => null, 'title' => null];
        }

        $cacheKey = 'yt_live_state_' . md5($channelIdOrHandle);
        if (!$force) {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        // Resolve exact UC... Channel ID if handle was provided
        $channelId = $channelIdOrHandle;
        if (!preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $channelIdOrHandle)) {
            $resolved = self::resolveChannelId($apiKey, $channelIdOrHandle);
            if ($resolved) {
                $channelId = $resolved;
            }
        }

        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . urlencode($channelId) . '&type=video&eventType=live&key=' . urlencode($apiKey);
        $res = self::makeRequest($url);

        if (!empty($res['items'][0]['id']['videoId'])) {
            $liveData = [
                'is_live'  => true,
                'video_id' => $res['items'][0]['id']['videoId'],
                'title'    => $res['items'][0]['snippet']['title'] ?? 'আমরা এখন লাইভে আছি!',
                'checked_at' => date('Y-m-d H:i:s')
            ];
            Cache::set($cacheKey, $liveData, 180); // Cache for 3 minutes when live
            return $liveData;
        }

        $offlineData = [
            'is_live'  => false,
            'video_id' => null,
            'title'    => null,
            'checked_at' => date('Y-m-d H:i:s')
        ];
        Cache::set($cacheKey, $offlineData, 300); // Cache for 5 minutes when offline
        return $offlineData;
    }

    /**
     * Resolve handle/username to canonical channel ID
     */
    public static function resolveChannelId(string $apiKey, string $handle): ?string {
        $clean = ltrim(trim($handle), '@');
        $url = 'https://www.googleapis.com/youtube/v3/channels?part=id&forHandle=' . urlencode($clean) . '&key=' . urlencode($apiKey);
        $res = self::makeRequest($url);
        if (!empty($res['items'][0]['id'])) {
            return $res['items'][0]['id'];
        }
        return null;
    }

    private static function makeRequest(string $url): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'NurLab-YouTubeBot/1.0');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($response)) {
            $decoded = json_decode($response, true);
            return $decoded ?: ['error' => ['message' => "HTTP {$httpCode} error from YouTube API"]];
        }

        return json_decode($response, true) ?: [];
    }
}

