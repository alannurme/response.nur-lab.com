<?php
namespace App\Core;

class Model {
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::pdoConnect();
    }
}
