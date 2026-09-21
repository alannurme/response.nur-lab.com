<?php

namespace Config;

use CodeIgniter\Database\Config as FrameworkDbConfig;

class Database extends FrameworkDbConfig
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => 'Al04@95annur',
        'database'     => 'response',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => true,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
        'foundRows'    => false,
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    private static $pdoInstance = null;

    public function __construct()
    {
        parent::__construct();

        $configFile = APPPATH . 'Config/db.config.php';
        if (file_exists($configFile)) {
            $dbConfig = require $configFile;
            if (!empty($dbConfig['host'])) $this->default['hostname'] = $dbConfig['host'];
            if (!empty($dbConfig['db']))   $this->default['database'] = $dbConfig['db'];
            if (isset($dbConfig['user']))  $this->default['username'] = $dbConfig['user'];
            if (isset($dbConfig['pass']))  $this->default['password'] = $dbConfig['pass'];
        }
    }

    public static function pdoConnect() {
        if (self::$pdoInstance !== null) {
            return self::$pdoInstance;
        }

        try {
            $host = 'localhost';
            $db   = 'response';
            $user = 'root';
            $pass = 'Al04@95annur';

            $configFile = APPPATH . 'Config/db.config.php';
            if (file_exists($configFile)) {
                $dbConfig = require $configFile;
                $host = $dbConfig['host'] ?? $host;
                $db   = $dbConfig['db']   ?? $db;
                $user = $dbConfig['user'] ?? $user;
                $pass = $dbConfig['pass'] ?? $pass;
            } else {
                $host = env('database.default.hostname', 'localhost');
                $envDb = env('database.default.database');
                $db   = (!empty($envDb) && $envDb !== 'hospital') ? $envDb : 'response';
                $user = env('database.default.username', 'root');
                $pass = env('database.default.password', '');
            }

            self::$pdoInstance = new \PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);
            return self::$pdoInstance;
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

