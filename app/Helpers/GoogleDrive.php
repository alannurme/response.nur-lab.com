<?php
namespace App\Helpers;

class GoogleDrive {
    private static $tokenCache = [];

    /**
     * Base64 URL safe encoding (RFC 4648)
     */
    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Get access token for a drive config (Service Account or OAuth2)
     */
    public static function getAccessToken($drive) {
        $driveId = $drive['id'] ?? md5(json_encode($drive));
        if (isset(self::$tokenCache[$driveId]) && self::$tokenCache[$driveId]['expires_at'] > time() + 60) {
            return self::$tokenCache[$driveId]['token'];
        }

        $authType = $drive['auth_type'] ?? 'service_account';

        if ($authType === 'service_account') {
            $jsonStr = trim($drive['service_account_json'] ?? '');
            if (empty($jsonStr)) {
                throw new \Exception('Service Account JSON is empty');
            }
            $sa = json_decode($jsonStr, true);
            if (!$sa || empty($sa['client_email']) || empty($sa['private_key'])) {
                throw new \Exception('Invalid Service Account JSON key format (missing client_email or private_key)');
            }

            $now = time();
            $header = ['alg' => 'RS256', 'typ' => 'JWT'];
            $payload = [
                'iss' => $sa['client_email'],
                'scope' => 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file',
                'aud' => 'https://oauth2.googleapis.com/token',
                'exp' => $now + 3600,
                'iat' => $now
            ];

            $dataToSign = self::base64UrlEncode(json_encode($header)) . '.' . self::base64UrlEncode(json_encode($payload));
            $privateKey = $sa['private_key'];
            $signature = '';

            $res = openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            if (!$res) {
                throw new \Exception('Failed to sign JWT with private key. Ensure OpenSSL can parse the key.');
            }

            $jwt = $dataToSign . '.' . self::base64UrlEncode($signature);

            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt
            ]));
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);
            if ($httpCode !== 200 || empty($data['access_token'])) {
                $err = $data['error_description'] ?? ($data['error'] ?? 'HTTP ' . $httpCode);
                throw new \Exception('Google OAuth token error: ' . $err);
            }

            self::$tokenCache[$driveId] = [
                'token' => $data['access_token'],
                'expires_at' => $now + ($data['expires_in'] ?? 3600)
            ];

            return $data['access_token'];
        } elseif ($authType === 'oauth2') {
            $clientId = trim($drive['client_id'] ?? '');
            $clientSecret = trim($drive['client_secret'] ?? '');
            $refreshToken = trim($drive['refresh_token'] ?? '');

            if (empty($clientId) || empty($clientSecret) || empty($refreshToken)) {
                throw new \Exception('Missing OAuth2 Client ID, Client Secret, or Refresh Token');
            }

            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'refresh_token' => $refreshToken,
                'grant_type'    => 'refresh_token'
            ]));
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);
            if ($httpCode !== 200 || empty($data['access_token'])) {
                $err = $data['error_description'] ?? ($data['error'] ?? 'HTTP ' . $httpCode);
                throw new \Exception('OAuth2 refresh token error: ' . $err);
            }

            self::$tokenCache[$driveId] = [
                'token' => $data['access_token'],
                'expires_at' => time() + ($data['expires_in'] ?? 3600)
            ];

            return $data['access_token'];
        }

        throw new \Exception('Unsupported authentication type: ' . $authType);
    }

    /**
     * Test connection to a specific Google Drive configuration
     */
    public static function testConnection($drive) {
        try {
            $token = self::getAccessToken($drive);
            $folderId = trim($drive['folder_id'] ?? '');

            if (!empty($folderId)) {
                $url = 'https://www.googleapis.com/drive/v3/files/' . urlencode($folderId) . '?fields=id,name,mimeType,capabilities,trashed';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token
                ]);
                curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $resp = curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $data = json_decode($resp, true);

                if ($code === 200 && !empty($data['id'])) {
                    if (!empty($data['trashed'])) {
                        return [
                            'success' => false,
                            'error' => "The specified folder '{$data['name']}' is in the Trash. Please select an active folder."
                        ];
                    }
                    $canAdd = $data['capabilities']['canAddChildren'] ?? true;
                    return [
                        'success' => true,
                        'message' => "Successfully connected! Target Folder: '{$data['name']}' (ID: {$data['id']})" . (!$canAdd ? ' (Warning: Read-only access)' : ' (Write Permission: OK)'),
                        'folder_name' => $data['name']
                    ];
                } elseif ($code === 404) {
                    return [
                        'success' => false,
                        'error' => "Target Folder ID '{$folderId}' not found. Please ensure the folder exists and you have shared it with the Service Account email as 'Editor'."
                    ];
                } else {
                    $err = $data['error']['message'] ?? ('HTTP Error ' . $code);
                    return [
                        'success' => false,
                        'error' => 'Folder access error: ' . $err
                    ];
                }
            } else {
                // Check root drive info
                $ch = curl_init('https://www.googleapis.com/drive/v3/about?fields=user,storageQuota');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
                curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $resp = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($resp, true);
                $userName = $data['user']['displayName'] ?? 'Google User';
                $userEmail = $data['user']['emailAddress'] ?? '';

                return [
                    'success' => true,
                    'message' => "Successfully connected to Google Drive account ({$userName} <{$userEmail}>)!",
                    'user' => $userName
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Upload a file to Google Drive
     */
    public static function uploadFile($localFilePath, $fileName, $mimeType, $drive) {
        $token = self::getAccessToken($drive);
        $folderId = trim($drive['folder_id'] ?? '');

        if (!file_exists($localFilePath)) {
            throw new \Exception('Local file not found: ' . $localFilePath);
        }

        $fileContent = file_get_contents($localFilePath);
        $boundary = '-------314159265358979323846';
        $delimiter = "\r\n--" . $boundary . "\r\n";
        $closeDelimiter = "\r\n--" . $boundary . "--";

        $metadata = [
            'name' => $fileName
        ];
        if (!empty($folderId)) {
            $metadata['parents'] = [$folderId];
        }

        $body = $delimiter
            . "Content-Type: application/json; charset=UTF-8\r\n\r\n"
            . json_encode($metadata)
            . $delimiter
            . "Content-Type: " . $mimeType . "\r\n\r\n"
            . $fileContent
            . $closeDelimiter;

        $ch = curl_init('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: multipart/related; boundary=' . $boundary,
            'Content-Length: ' . strlen($body)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);
        if ($httpCode !== 200 || empty($result['id'])) {
            $err = $result['error']['message'] ?? ('HTTP Error ' . $httpCode);
            throw new \Exception('Google Drive upload failed: ' . $err);
        }

        $fileId = $result['id'];

        // Make publicly readable so images and files load seamlessly on the website
        self::makePublic($fileId, $token);

        // High speed direct CDN URL for Google Drive images:
        $directUrl = 'https://lh3.googleusercontent.com/d/' . $fileId;
        $exportUrl = 'https://drive.google.com/uc?id=' . $fileId . '&export=view';

        return [
            'success'      => true,
            'file_id'      => $fileId,
            'file_name'    => $fileName,
            'url'          => $directUrl,
            'export_url'   => $exportUrl,
            'web_link'     => $result['webViewLink'] ?? $exportUrl,
            'drive_id'     => $drive['id'] ?? '',
            'drive_name'   => $drive['name'] ?? 'Google Drive'
        ];
    }

    /**
     * Set file permission to anyone with link can view (reader)
     */
    public static function makePublic($fileId, $token) {
        $ch = curl_init('https://www.googleapis.com/drive/v3/files/' . urlencode($fileId) . '/permissions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'role' => 'reader',
            'type' => 'anyone'
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
        return true;
    }

    /**
     * Upload with multi-drive fallback
     */
    public static function uploadWithFallback($localFilePath, $fileName, $mimeType, $settings) {
        $drivesJson = $settings['google_drives'] ?? '[]';
        $drives = json_decode($drivesJson, true) ?: [];

        // Filter active drives
        $activeDrives = array_filter($drives, function($d) {
            return !isset($d['status']) || $d['status'] === 'active';
        });

        if (empty($activeDrives)) {
            throw new \Exception('No active Google Drive account configured in settings.');
        }

        // Put default drive first
        usort($activeDrives, function($a, $b) {
            $defA = !empty($a['is_default']) ? 1 : 0;
            $defB = !empty($b['is_default']) ? 1 : 0;
            return $defB <=> $defA;
        });

        $allowFallback = ($settings['gdrive_auto_fallback'] ?? '1') === '1';
        $lastError = null;

        foreach ($activeDrives as $drive) {
            try {
                return self::uploadFile($localFilePath, $fileName, $mimeType, $drive);
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                if (!$allowFallback) {
                    break;
                }
            }
        }

        throw new \Exception('Upload failed on all available Google Drives. Last error: ' . $lastError);
    }
}

