<?php
namespace App\Core;

use Config\Database;


class SchemaSync {
    public static function sync() {
        try {
            $db = Database::connect();
            $schemaFile = APPROOT . '/Database/schema.json';
            
            if (!file_exists($schemaFile)) {
                return;
            }
            
            $schema = json_decode(file_get_contents($schemaFile), true);
            if (!$schema) {
                return;
            }
            
            // Get existing tables
            $existingTables = $db->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
            
            foreach ($schema as $tableName => $columns) {
                if ($tableName === 'migrations') continue;
                
                if (!in_array($tableName, $existingTables)) {
                    // Create Table
                    $colDefs = [];
                    $primaryKey = null;
                    
                    foreach ($columns as $col) {
                        $field = $col['Field'];
                        $type = $col['Type'];
                        $null = $col['Null'] === 'YES' ? 'NULL' : 'NOT NULL';
                        $extra = $col['Extra'];
                        
                        $default = '';
                        if (isset($col['Default']) && $col['Default'] !== null) {
                            if ($col['Default'] === 'current_timestamp()' || $col['Default'] === 'CURRENT_TIMESTAMP') {
                                $default = 'DEFAULT CURRENT_TIMESTAMP';
                            } else {
                                $default = 'DEFAULT ' . $db->quote($col['Default']);
                            }
                        }
                        
                        $def = "`$field` $type $null $default $extra";
                        $colDefs[] = trim($def);
                        
                        if ($col['Key'] === 'PRI') {
                            $primaryKey = $field;
                        }
                    }
                    
                    if ($primaryKey) {
                        $colDefs[] = "PRIMARY KEY (`$primaryKey`)";
                    }
                    
                    $sql = "CREATE TABLE `$tableName` (\n  " . implode(",\n  ", $colDefs) . "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
                    $db->exec($sql);
                    
                } else {
                    // Table exists, check columns
                    $dbColumns = $db->query("SHOW COLUMNS FROM `$tableName`")->fetchAll(\PDO::FETCH_ASSOC);
                    $dbColNames = array_column($dbColumns, 'Field');
                    
                    // Add missing columns
                    foreach ($columns as $col) {
                        $field = $col['Field'];
                        if (!in_array($field, $dbColNames)) {
                            $type = $col['Type'];
                            $null = $col['Null'] === 'YES' ? 'NULL' : 'NOT NULL';
                            $extra = $col['Extra'];
                            
                            $default = '';
                            if (isset($col['Default']) && $col['Default'] !== null) {
                                if ($col['Default'] === 'current_timestamp()' || $col['Default'] === 'CURRENT_TIMESTAMP') {
                                    $default = 'DEFAULT CURRENT_TIMESTAMP';
                                } else {
                                    $default = 'DEFAULT ' . $db->quote($col['Default']);
                                }
                            }
                            
                            $sql = "ALTER TABLE `$tableName` ADD `$field` $type $null $default $extra";
                            $db->exec($sql);
                        }
                    }
                }
            }
            
            // Perform data cleanup for image paths on the live database
            $cleanups = [
                'settings' => ['setting_value'],
                'about_sections' => ['image'],
                'posts' => ['content', 'featured_image'],
                'products' => ['image', 'pdf_preview'],
                'sidebar_slides' => ['image'],
                'slides' => ['image', 'link'],
                'team_members' => ['image']
            ];
            
            foreach ($cleanups as $table => $cols) {
                if (in_array($table, $existingTables)) {
                    foreach ($cols as $col) {
                        try {
                            $db->exec("UPDATE `$table` SET `$col` = REPLACE(REPLACE(`$col`, '/islamic.nur-lab.com/', 'public/'), 'islamic.nur-lab.com/', 'public/') WHERE `$col` LIKE '%islamic.nur-lab.com%'");
                            $db->exec("UPDATE `$table` SET `$col` = REPLACE(`$col`, 'public/public/', 'public/') WHERE `$col` LIKE '%public/public/%'");
                        } catch (\Exception $e_clean) {
                            // Ignore
                        }
                    }
                }
            }
            
        } catch (\Exception $e) {
            error_log("Schema Sync Error: " . $e->getMessage());
        }
    }
    
    // Automatically dump schema locally for developer use
    public static function dump() {
        try {
            $db = Database::connect();
            $tables = $db->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
            $schema = [];
            foreach ($tables as $table) {
                if ($table === 'migrations') continue;
                $columns = $db->query("SHOW COLUMNS FROM `$table`")->fetchAll(\PDO::FETCH_ASSOC);
                $schema[$table] = $columns;
            }
            
            $schemaDir = APPROOT . '/Database';
            if (!is_dir($schemaDir)) {
                mkdir($schemaDir, 0777, true);
            }
            
            file_put_contents($schemaDir . '/schema.json', json_encode($schema, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            error_log("Schema Dump Error: " . $e->getMessage());
        }
    }
}
