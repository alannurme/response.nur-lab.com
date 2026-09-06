<?php
/**
 * Coordinator Framework Root Entry
 */

// Define project base path
define('APPROOT', __DIR__ . '/app');

// Include initialization
require_once APPROOT . '/init.php';

use App\Core\App;

$app = new App();
