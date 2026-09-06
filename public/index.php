<?php
// Define project base path
define('APPROOT', dirname(__DIR__) . '/app');

require_once APPROOT . '/init.php';

use App\Core\App;

$app = new App();
