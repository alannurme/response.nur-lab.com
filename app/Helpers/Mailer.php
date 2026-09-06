<?php
namespace App\Helpers;

class Mailer {
    public static function send($to, $subject, $message, $siteSettings) {
        $method     = $siteSettings['mail_method'] ?? 'smtp'; // 'sendmail' or 'smtp'
        $from_email = $siteSettings['smtp_user'] ?? ($siteSettings['mail_from_email'] ?? 'no-reply@example.com');
        $from_name  = $siteSettings['smtp_from_name'] ?? $siteSettings['site_title'] ?? 'Response with Nur-Lab';

        // ── SENDMAIL (PHP native mail()) ──────────────────────────────────────
        if ($method === 'sendmail') {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: =?UTF-8?B?" . base64_encode($from_name) . "?= <" . $from_email . ">\r\n";
            $headers .= "Reply-To: " . $from_email . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            return mail($to, "=?UTF-8?B?" . base64_encode($subject) . "?=", $message, $headers);
        }

        // ── SMTP ─────────────────────────────────────────────────────────────
        $host       = $siteSettings['smtp_host'] ?? '';
        $port       = $siteSettings['smtp_port'] ?? '25';
        $user       = $siteSettings['smtp_user'] ?? '';
        $pass       = $siteSettings['smtp_pass'] ?? '';
        $encryption = $siteSettings['smtp_encryption'] ?? 'none';

        if (empty($host) || empty($user) || empty($pass)) {
            // Fallback to PHP native mail() if SMTP not configured
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: <" . $from_email . ">\r\n";
            return mail($to, $subject, $message, $headers);
        }

        $socket_host = ($encryption === 'ssl') ? 'ssl://' . $host : $host;
        $socket = @fsockopen($socket_host, $port, $errno, $errstr, 15);
        if (!$socket) {
            // Fallback to native mail()
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: <" . $from_email . ">\r\n";
            return mail($to, $subject, $message, $headers);
        }

        // Helper to read multi-line SMTP response
        $readResponse = function($socket) {
            $response = "";
            while ($line = fgets($socket, 512)) {
                $response .= $line;
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }
            return $response;
        };

        $readResponse($socket); // 220 welcome

        fwrite($socket, "EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "\r\n");
        $readResponse($socket); // 250 response lines

        if ($encryption === 'tls') {
            fwrite($socket, "STARTTLS\r\n");
            $readResponse($socket);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                return false;
            }
            fwrite($socket, "EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "\n");
            $readResponse($socket);
        }

        fwrite($socket, "AUTH LOGIN\r\n");
        $readResponse($socket);
        fwrite($socket, base64_encode($user) . "\r\n");
        $readResponse($socket);
        fwrite($socket, base64_encode($pass) . "\r\n");
        $readResponse($socket);

        fwrite($socket, "MAIL FROM: <$user>\r\n");
        $readResponse($socket);
        fwrite($socket, "RCPT TO: <$to>\r\n");
        $readResponse($socket);

        fwrite($socket, "DATA\r\n");
        $readResponse($socket);

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "To: <$to>\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($from_name) . "?= <$user>\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n\r\n";

        fwrite($socket, $headers . $message . "\r\n.\r\n");
        $readResponse($socket);

        fwrite($socket, "QUIT\r\n");
        fclose($socket);

        return true;
    }

    public static function sendAsync($to, $subject, $message, $siteSettings) {
        $data = [
            'to'       => $to,
            'subject'  => $subject,
            'message'  => $message,
            'settings' => $siteSettings
        ];
        $cache_dir = APPROOT . '/cache';
        if (!is_dir($cache_dir)) {
            @mkdir($cache_dir, 0777, true);
        }
        $file = $cache_dir . '/mail_' . uniqid() . '_' . time() . '.json';
        @file_put_contents($file, json_encode($data));

        $script  = APPROOT . '/send_mail_bg.php';
        $phpPath = PHP_BINARY;

        if (stristr(PHP_OS, 'WIN')) {
            // Windows background execution
            $cmd = 'start /B "" ' . escapeshellarg($phpPath) . ' ' . escapeshellarg($script) . ' ' . escapeshellarg($file);
            @pclose(@popen($cmd, "r"));
        } else {
            // Unix background execution
            $cmd = escapeshellarg($phpPath) . " " . escapeshellarg($script) . " " . escapeshellarg($file) . " > /dev/null 2>&1 &";
            @exec($cmd);
        }
        return true;
    }
}
