<?php
namespace App\Models;

use App\Core\Model;

class ProphetsTreeModel extends Model {
    
    /**
     * Get summary metadata & statistics for Prophets Tree
     */
    public function getTreeMetadata() {
        return [
            'total_prophets_mentioned' => 25,
            'title_bn'                 => 'নবীদের পূর্ণাঙ্গ নসবনামা',
            'title_ar'                 => 'شجرة الأنبياء عليهم السلام',
            'description'              => 'আদম (আ.) থেকে শেষ নবী মুহাম্মদ (সা.) পর্যন্ত নবীদের বংশলতিকা ও সম্পর্কিত তথ্যাবলী।'
        ];
    }

    public function getProphetsData() {
        // SQLite Database placed directly inside the module folder
        $dbPath = APPPATH . 'Views/modules/prophets_tree/prophets_tree.sqlite';
        if (!file_exists($dbPath)) {
            $dbPath = APPPATH . '../app/writable/database/prophets_tree.sqlite';
        }

        if (file_exists($dbPath)) {
            try {
                $db = new \PDO('sqlite:' . $dbPath);
                $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $stmt = $db->query("SELECT * FROM prophets ORDER BY CAST(seq AS INTEGER) ASC");
                $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if (!empty($results)) {
                    $formattedData = [];
                    foreach ($results as $row) {
                        $formattedData[$row['id']] = $row;
                    }
                    return $formattedData;
                }
            } catch (\Exception $e) {
                // Fallback if PDO SQLite query encounters an issue
            }
        }

        // Fallback to PHP array data file
        $viewDataPath = APPPATH . 'Views/modules/prophets_tree/data.php';
        if (file_exists($viewDataPath)) {
            return require $viewDataPath;
        }

        $jsonPath = FCPATH . 'public/js/modules/prophets_data.json';
        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        }
        return [];
    }

}
