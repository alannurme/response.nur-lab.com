<?php
namespace App\Config;

class Database {
    public static $host = 'localhost';
    public static $user = 'root';
    public static $pass = 'Al04@95annur';
    public static $db   = 'response';

    public static function connect() {
        try {
            $pdo = new \PDO("mysql:host=".self::$host.";dbname=".self::$db.";charset=utf8mb4", self::$user, self::$pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            return $pdo;
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
