<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=response;charset=utf8mb4', 'root', 'Al04@95annur');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 1. Delete module ID 3 if it exists
    $stmtDel = $pdo->prepare("DELETE FROM modules WHERE id = 3 OR slug = 'prophets-tree'");
    $stmtDel->execute();
    echo "Module 3 deleted successfully.\n";

    // 2. Insert fresh Module 3
    $stmtIns = $pdo->prepare("INSERT INTO modules (id, title, slug, icon, url, content, order_index, status, created_at) VALUES (3, :title, :slug, :icon, :url, :content, :order_index, :status, NOW())");
    $stmtIns->execute([
        'title'       => 'নবীদের পূর্ণাঙ্গ নসবনামা (Prophets Tree)',
        'slug'        => 'prophets-tree',
        'icon'        => 'fa-solid fa-sitemap',
        'url'         => '/home/module/3',
        'content'     => '',
        'order_index' => 1,
        'status'      => 'active'
    ]);
    echo "Module 3 recreated successfully!\n";

    // 3. Verify module 3
    $stmtCheck = $pdo->query("SELECT * FROM modules WHERE id = 3");
    print_r($stmtCheck->fetch());

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
