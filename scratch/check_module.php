<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=response;charset=utf8mb4', 'root', 'Al04@95annur');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->query('SHOW TABLES');
    print_r($stmt->fetchAll());
} catch(Exception $e) {
    echo $e->getMessage();
}
