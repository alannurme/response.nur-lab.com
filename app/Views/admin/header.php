<?php 
$current_page = $current_page ?? ''; 

// Automatically detect current page based on the request URL if it was not explicitly passed
if (empty($current_page)) {
    $url_path = $_GET['url'] ?? '';
    $url_parts = explode('/', rtrim($url_path, '/'));
    $action = $url_parts[1] ?? '';
    
    if (empty($action) || $action === 'index') {
        $current_page = 'dashboard';
    } else {
        // Map common secondary/edit/add action URLs back to their parent sidebar items
        $mappings = [
            'edit_post'              => 'posts',
            'add_author'             => 'authors',
            'edit_author'            => 'authors',
            'edit_category'          => 'categories',
            'answer_question'        => 'questions',
            'add_page'               => 'pages',
            'edit_page'              => 'pages',
            'add_menu'               => 'menus',
            'edit_menu'              => 'menus',
            'add_sub_menu'           => 'sub_menus',
            'edit_sub_menu'          => 'sub_menus',
            'add_social_link'        => 'social_links',
            'edit_social_link'       => 'social_links',
            'add_product'            => 'products',
            'edit_product'           => 'products',
            'edit_customer'          => 'customers',
            'add_delivery_charge'    => 'delivery_charges',
            'edit_delivery_charge'   => 'delivery_charges',
            'order_detail'           => 'orders',
            'add_team_member'        => 'team',
            'edit_team_member'       => 'team',
            'add_scope'              => 'scopes',
            'edit_scope'             => 'scopes',
            'add_join_card'          => 'join_cards',
            'edit_join_card'         => 'join_cards',
            'add_about_section'      => 'about_sections',
            'edit_about_section'     => 'about_sections',
            'add_review'             => 'reviews',
            'edit_review'            => 'reviews',
            'add_faq'                => 'faqs',
            'edit_faq'               => 'faqs',
            'add_slide'              => 'slides',
            'edit_slide'             => 'slides',
            'add_sidebar_slide'      => 'sidebar_slides',
            'edit_sidebar_slide'     => 'sidebar_slides',
            'add_yt_video'           => 'yt_videos',
            'edit_yt_video'          => 'yt_videos',
            'add_user'               => 'users',
            'edit_user'              => 'users',
            'manage_permissions'     => 'permissions'
        ];
        
        if (isset($mappings[$action])) {
            $current_page = $mappings[$action];
        } else {
            $current_page = $action;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['settings']['site_title'] ?? 'Admin Panel' ?> - Dashboard</title>
    
    <!-- Favicon -->
    <?php if (!empty($data['settings']['site_favicon'])): ?>
        <link rel="icon" type="image/png" href="<?= $data['settings']['site_favicon'] ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/admin.css?v=<?= @filemtime(FCPATH . 'css/admin.css') ?: '2.0' ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>if(typeof Chart==='undefined'){document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"><\/script>');}</script>
    <script>if(typeof Chart==='undefined'){document.write('<script src="https://unpkg.com/chart.js@4.4.1/dist/chart.umd.js"><\/script>');}</script>
    <!-- jQuery & Cropper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --primary-dark: #1d4ed8;
            --bg-light: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --gold: #c5a059;
        }
        body {
            background: var(--bg-light) !important;
        }
        body.sidebar-collapsed .sidebar {
            width: 80px !important;
        }
        body.sidebar-collapsed .main-content {
            margin-left: 80px !important;
            width: calc(100% - 80px) !important;
            padding: 1.5rem !important;
        }
        body.sidebar-collapsed #admin-3d-canvas {
            left: 80px !important;
            width: calc(100% - 80px) !important;
        }
        body.sidebar-collapsed .sidebar-logo span,
        body.sidebar-collapsed .sidebar-logo h2,
        body.sidebar-collapsed .nav-item span,
        body.sidebar-collapsed .nav-label,
        body.sidebar-collapsed .dropdown-arrow {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar {
            overflow-y: auto !important;
            overflow-x: visible !important;
        }
        body.sidebar-collapsed .sidebar-nav {
            overflow: visible !important;
            max-height: none !important;
        }
        body.sidebar-collapsed .sidebar-logo {
            justify-content: center !important;
            padding: 15px 5px !important;
        }
        body.sidebar-collapsed .sidebar-logo a {
            justify-content: center;
        }
        body.sidebar-collapsed .nav-item {
            justify-content: center !important;
            padding: 12px !important;
            border-right: none !important;
        }
        body.sidebar-collapsed .nav-item i:first-child {
            margin-right: 0 !important;
            font-size: 1.25rem;
        }
        body.sidebar-collapsed #sidebar-collapse-btn i {
            transform: rotate(180deg);
        }
        
        /* Collapsed Sidebar Hover Submenu CSS */
        body.sidebar-collapsed .nav-group {
            position: relative;
        }
        body.sidebar-collapsed .dropdown-wrapper {
            position: relative;
            z-index: 105;
        }
        body.sidebar-collapsed .dropdown-wrapper .dropdown-content {
            display: none;
            position: fixed !important;
            left: 65px !important;
            top: 0;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
            padding: 8px !important;
            width: 220px !important;
            z-index: 9999 !important;
            flex-direction: column !important;
            gap: 2px !important;
        }
        body.sidebar-collapsed .dropdown-content a {
            display: flex !important;
            padding: 8px 12px !important;
            color: #64748b !important;
            text-decoration: none !important;
            font-size: 0.88rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            transition: all 0.2s !important;
            gap: 8px !important;
        }
        body.sidebar-collapsed .dropdown-content a:hover {
            background: #eff6ff !important;
            color: #2563eb !important;
        }
        body.sidebar-collapsed .dropdown-content a i {
            display: inline-block !important;
        }
        body {
            color: var(--text-main) !important;
            margin: 0;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            width: 300px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid #f1f5f9;
        }
        .main-content {
            margin-left: 300px;
            padding: 2.5rem;
            min-height: 100vh;
            background: var(--bg-light);
            position: relative;
            z-index: 1;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1.5rem;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 1rem;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .avatar {
            width: 35px;
            height: 35px;
            background: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        #admin-3d-canvas {
            position: fixed;
            top: 0;
            left: 300px;
            width: calc(100% - 300px);
            height: 100%;
            z-index: 0;
            opacity: 0.1;
            pointer-events: none;
        }
        .tox-tinymce-aux {
            z-index: 9990 !important;
        }
        .btn-visit-site {
            background: white;
            border: 1.5px solid var(--primary);
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-visit-site:hover { background: var(--primary); color: white; }
        
        .dashboard-two-col {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
        }
        
        .grid-two-equal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .full-width { 
            grid-column: span 2; 
        }
        
        @media (max-width: 992px) {
            .sidebar { 
                width: 270px !important; 
                transform: translateX(-100%) !important; 
                transition: transform 0.3s !important; 
                overflow-y: auto !important;
                overflow-x: hidden !important;
            }
            .sidebar.mobile-active { transform: translateX(0) !important; }
            body.sidebar-collapsed .sidebar {
                width: 270px !important;
                transform: translateX(-100%) !important;
            }
            body.sidebar-collapsed .sidebar.mobile-active {
                transform: translateX(0) !important;
            }
            body.sidebar-collapsed .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 8px !important;
            }
            body.sidebar-collapsed .sidebar-logo span,
            body.sidebar-collapsed .sidebar-logo h2,
            body.sidebar-collapsed .nav-item span,
            body.sidebar-collapsed .nav-label,
            body.sidebar-collapsed .dropdown-arrow {
                display: inline-block !important;
            }
            body.sidebar-collapsed .sidebar-logo {
                justify-content: space-between !important;
                padding: 20px 16px !important;
            }
            body.sidebar-collapsed .nav-item {
                justify-content: flex-start !important;
                padding: 10px 14px !important;
            }
            body.sidebar-collapsed .nav-item i:first-child {
                margin-right: 14px !important;
            }
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 8px !important; }
            #admin-3d-canvas { left: 0 !important; width: 100% !important; }
            .mobile-nav-toggle { display: flex !important; }
            .top-navbar {
                padding: 10px 0 !important;
                margin-bottom: 20px !important;
            }
            .admin-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1.5rem !important;
                margin-bottom: 2rem !important;
            }
            .admin-header-title-section {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1rem !important;
            }
            .dashboard-two-col {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .categories-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .grid-two-equal {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .admin-card {
                padding: 12px !important;
                border-radius: 12px !important;
            }
            .data-table-container, .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                width: 100% !important;
            }
            .data-table th, .data-table td, .admin-table th, .admin-table td {
                white-space: normal !important;
                word-break: break-word !important;
            }
            .data-table th:nth-child(2), .data-table td:nth-child(2),
            .data-table th:nth-child(3), .data-table td:nth-child(3),
            .data-table th:nth-child(4), .data-table td:nth-child(4) {
                display: none !important;
            }
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
            }
            .full-width {
                grid-column: span 1 !important;
            }
            #yt-preview iframe {
                height: 220px !important;
            }
        }

        /* Crisp Light Modern Sidebar (Matching exact reference screenshot) */
        .sidebar {
            width: 300px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.2) transparent;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            box-shadow: 1px 0 6px rgba(0, 0, 0, 0.02);
        }
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.4);
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-logo {
            padding: 12px 14px 10px 14px;
            border-bottom: 1px solid #f8fafc;
            margin-bottom: 4px;
        }

        .sidebar-logo #sidebar-collapse-btn {
            color: #94a3b8 !important;
        }
        .sidebar-logo #sidebar-collapse-btn:hover {
            color: #475569 !important;
            background: #f8fafc !important;
        }

        .sidebar-nav {
            padding: 0 8px 25px;
            display: flex;
            flex-direction: column;
            gap: 0px !important;
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 4px !important;
            gap: 0px !important;
        }

        .nav-label {
            font-size: 0.64rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 700;
            padding: 6px 10px 2px !important;
            margin: 0 !important;
            font-family: inherit;
        }

        /* Ultra-compact, clean spacing between menus */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 4px 10px !important;
            color: #1e293b !important;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.87rem !important;
            font-weight: 600;
            line-height: 1.2;
            transition: all 0.12s ease;
            margin: 0 0 1px 0 !important;
            border-right: none !important;
            background: transparent;
            cursor: pointer;
            user-select: none;
            letter-spacing: -0.01em;
            min-height: 30px !important;
            height: 30px !important;
            box-sizing: border-box;
        }

        .nav-item i:first-child {
            width: 18px;
            margin-right: 8px !important;
            font-size: 0.94rem !important;
            color: #64748b;
            transition: all 0.12s ease;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: #f8fafc;
            color: #0f172a !important;
            transform: none !important;
        }

        .nav-item:hover i:first-child {
            color: #334155;
        }

        /* Active / Selected Item */
        .nav-item.active {
            background: #f0f4f9 !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            box-shadow: none !important;
        }

        .nav-item.active i:first-child {
            color: #0f172a !important;
        }

        /* Dropdown Chevron arrow */
        .dropdown-arrow {
            margin-left: auto;
            font-size: 0.68rem;
            color: #64748b;
            font-weight: 600;
            transition: transform 0.2s ease, color 0.12s;
        }

        .nav-item:hover .dropdown-arrow {
            color: #334155;
        }

        .dropdown-content {
            display: none;
            padding-left: 8px;
            margin: 1px 0 2px 10px !important;
            border-left: 1.5px solid #e2e8f0;
            flex-direction: column;
            gap: 0px !important;
        }

        .dropdown-content a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 8px !important;
            color: #475569 !important;
            text-decoration: none;
            font-size: 0.83rem !important;
            font-weight: 500;
            border-radius: 5px;
            transition: all 0.12s ease;
            min-height: 26px !important;
            height: 26px !important;
            margin-bottom: 1px !important;
        }

        .dropdown-content a i {
            font-size: 0.78rem;
            color: #94a3b8;
            width: 14px;
            text-align: center;
            transition: all 0.15s ease;
        }

        .dropdown-content a:hover, 
        .dropdown-content a.active-sub {
            background: #f1f5f9;
            color: #0f172a !important;
            font-weight: 600;
        }

        .dropdown-content a:hover i, 
        .dropdown-content a.active-sub i {
            color: #0f172a;
        }

        /* Subcontent Folder Tree in Left Sidebar */
        #sidebar-posts-subcontent .folder-tree-node {
            color: #475569 !important;
            border-radius: 6px;
        }
        #sidebar-posts-subcontent .folder-tree-node a {
            color: #475569 !important;
            font-size: 13px;
        }
        #sidebar-posts-subcontent .folder-tree-node:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }
        #sidebar-posts-subcontent .folder-tree-node:hover a {
            color: #0f172a !important;
        }
        #sidebar-posts-subcontent .folder-tree-node.active {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            font-weight: 600 !important;
        }
        #sidebar-posts-subcontent .folder-tree-node.active a {
            color: #1d4ed8 !important;
        }

        /* User Profile & Other elements */
        .user-profile-dropdown {
            position: relative;
        }
        
        .user-profile {
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 12px;
            transition: 0.3s;
        }
        
        .user-profile:hover {
            background: rgba(0,0,0,0.03);
        }
        
        .profile-dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            min-width: 180px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
            z-index: 1100;
            overflow: hidden;
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .profile-dropdown-content a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #475569;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.2s;
        }
        
        .profile-dropdown-content a:hover {
            background: #f8fafc;
            color: var(--primary);
        }
    </style>

    <script>
        window.onerror = function(msg, url, line) {
            if (msg && (msg.indexOf('Chart is not defined') !== -1 || msg.indexOf('Script error') !== -1 || msg.indexOf('Unexpected end of input') !== -1 || msg.indexOf('SyntaxError') !== -1)) {
                console.warn("Handled Non-Fatal Admin Script Error:", msg, "at line:", line, "URL:", url);
                return true;
            }
            console.error("Global Admin Script Error:", msg, "URL:", url, "Line:", line);
            return false;
        };

        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        window.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.style.display = 'none';
        });

        function toggleSidebarCollapse(event) {
            if (event) event.stopPropagation();
            document.body.classList.toggle('sidebar-collapsed');
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed ? 'true' : 'false');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sidebar .nav-item').forEach(item => {
                const span = item.querySelector('span');
                if (span) {
                    item.setAttribute('title', span.textContent.trim());
                }
            });

            // Collapsed Sidebar Fixed Submenu JS Positioning & Hover Bridge
            const wrappers = document.querySelectorAll('.dropdown-wrapper');
            wrappers.forEach(wrap => {
                const navItem = wrap.querySelector('.nav-item');
                const content = wrap.querySelector('.dropdown-content');
                let hoverTimeout;

                function showSubmenu() {
                    clearTimeout(hoverTimeout);
                    if (!document.body.classList.contains('sidebar-collapsed')) return;
                    
                    const rect = navItem.getBoundingClientRect();
                    content.style.top = rect.top + 'px';
                    content.style.display = 'flex';
                }

                function hideSubmenu() {
                    hoverTimeout = setTimeout(() => {
                        if (document.body.classList.contains('sidebar-collapsed')) {
                            content.style.display = 'none';
                        }
                    }, 350); // Increased delay to allow slower mouse transition
                }

                wrap.addEventListener('mouseenter', showSubmenu);
                wrap.addEventListener('mouseleave', hideSubmenu);
                content.addEventListener('mouseenter', showSubmenu);
                content.addEventListener('mouseleave', hideSubmenu);
            });
        });
    </script>
<body class="<?= $current_page === 'posts' ? 'sidebar-collapsed' : '' ?>">
    <script>
        // Immediately restore sidebar preference if saved in localStorage
        if (localStorage.getItem('sidebar-collapsed') !== null) {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
            } else {
                document.body.classList.remove('sidebar-collapsed');
            }
        }
    </script>
    
    <!-- Mobile Header/Toggle -->
    <div class="mobile-nav-toggle" style="position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1100; background: var(--primary); color: white; width: 45px; height: 45px; border-radius: 12px; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0, 107, 67, 0.35);">
        <i class="fas fa-bars" style="font-size: 1.2rem;"></i>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" style="position: fixed; inset: 0; background: rgba(15,23,42,0.4); backdrop-filter: blur(4px); z-index: 95; display: none;"></div>

    <div class="sidebar">
        <div class="sidebar-logo" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <a href="<?= URLROOT ?>/admin" style="text-decoration: none; display: flex; align-items: center; gap: 10px; overflow: hidden; white-space: nowrap; min-width: 0;">
                <?php if (!empty($settings['site_logo'])): ?>
                    <img src="<?= resolve_setting_image($settings['site_logo']) ?>" alt="Logo" style="max-height: 40px; width: auto; object-fit: contain; flex-shrink: 0;">
                <?php else: ?>
                    <h2 style="color: #0f172a; margin: 0; font-size: 1.35rem; font-weight: 800; letter-spacing: -0.02em; flex-shrink: 0;">NUR<span style="color: #2563eb;">LAB</span></h2>
                <?php endif; ?>
            </a>
            <button id="sidebar-collapse-btn" onclick="toggleSidebarCollapse(event)" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;">
                <i class="fas fa-angle-double-left" style="font-size: 1.25rem;"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <div style="margin-bottom: 4px; display: flex; flex-direction: column; gap: 1px;">
                <a href="<?= URLROOT ?>/admin" class="nav-item <?= $current_page == 'dashboard' || $current_page == '' ? 'active' : '' ?>">
                    <i class="fas fa-border-all"></i><span>Dashboard</span>
                </a>
                <a href="<?= URLROOT ?>/" target="_blank" class="nav-item">
                    <i class="fas fa-globe"></i><span>Visit Website</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Content Management</div>
                <div class="nav-item-sub-wrapper">
                    <a href="<?= URLROOT ?>/admin/posts" class="nav-item <?= $current_page == 'posts' ? 'active' : '' ?>">
                        <i class="fas fa-newspaper"></i><span>All Posts</span>
                    </a>
                    <div id="sidebar-posts-subcontent" style="padding-left: 0px; margin-top: 5px; <?= $current_page == 'posts' ? '' : 'display: none;' ?>"></div>
                </div>
                <a href="<?= URLROOT ?>/admin/add_post" class="nav-item <?= $current_page == 'add_post' ? 'active' : '' ?>">
                    <i class="fas fa-plus-circle"></i><span>Add New Post</span>
                </a>
                <a href="<?= URLROOT ?>/admin/authors" class="nav-item <?= $current_page == 'authors' ? 'active' : '' ?>">
                    <i class="fas fa-user-pen"></i><span>Authors</span>
                </a>

                <a href="<?= URLROOT ?>/admin/media" class="nav-item <?= $current_page == 'media' ? 'active' : '' ?>">
                    <i class="fas fa-photo-video"></i><span>Media Library</span>
                </a>
                <a href="<?= URLROOT ?>/admin/comments" class="nav-item <?= $current_page == 'comments' ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i><span>Comments</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Communication</div>
                <a href="<?= URLROOT ?>/admin/questions" class="nav-item <?= $current_page == 'questions' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i><span>User Questions</span>
                </a>
                <a href="<?= URLROOT ?>/admin/question_categories" class="nav-item <?= $current_page == 'question_categories' ? 'active' : '' ?>">
                    <i class="fas fa-folder-open"></i><span>Q&A Categories</span>
                </a>
                <a href="<?= URLROOT ?>/admin/subscribers" class="nav-item <?= $current_page == 'subscribers' ? 'active' : '' ?>">
                    <i class="fas fa-envelope-open-text"></i><span>Newsletter</span>
                </a>
                <a href="<?= URLROOT ?>/admin/messages" class="nav-item <?= $current_page == 'messages' ? 'active' : '' ?>">
                    <i class="fas fa-inbox"></i><span>Inbox Messages</span>
                </a>
                <a href="<?= URLROOT ?>/admin/donations" class="nav-item <?= $current_page == 'donations' ? 'active' : '' ?>">
                    <i class="fas fa-hand-holding-heart"></i><span>Donation Logs</span>
                </a>
                <a href="<?= URLROOT ?>/admin/sync_islamic" class="nav-item <?= $current_page == 'sync_islamic' ? 'active' : '' ?>">
                    <i class="fas fa-sync-alt" style="color: #10b981;"></i><span>Islamic Data Sync</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">System Control</div>
                <a href="<?= URLROOT ?>/admin/pages" class="nav-item <?= $current_page == 'pages' ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i><span>Static Pages</span>
                </a>
                <?php $menu_manager_active = in_array($current_page, ['menus', 'sub_menus', 'social_links', 'add_menu', 'edit_menu', 'add_sub_menu', 'edit_sub_menu']); ?>
                <div class="dropdown-wrapper">
                    <div class="nav-item has-dropdown <?= $menu_manager_active ? 'active' : '' ?>">
                        <i class="fas fa-list"></i><span>Menu Manager</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-content" <?= $menu_manager_active ? 'style="display: block;"' : '' ?>>
                        <a href="<?= URLROOT ?>/admin/menus" class="<?= in_array($current_page, ['menus', 'add_menu', 'edit_menu']) ? 'active-sub' : '' ?>">
                            <i class="fas fa-bars"></i> Main Menu Bar
                        </a>
                        <a href="<?= URLROOT ?>/admin/sub_menus" class="<?= in_array($current_page, ['sub_menus', 'add_sub_menu', 'edit_sub_menu']) ? 'active-sub' : '' ?>">
                            <i class="fas fa-link"></i> Top Menu Bar
                        </a>
                        <a href="<?= URLROOT ?>/admin/social_links" class="<?= $current_page == 'social_links' ? 'active-sub' : '' ?>">
                            <i class="fas fa-share-nodes"></i> Social Media Links
                        </a>
                    </div>
                </div>

                <a href="<?= URLROOT ?>/admin/team" class="nav-item <?= $current_page == 'team' ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i><span>Team Members</span>
                </a>
                <a href="<?= URLROOT ?>/admin/scopes" class="nav-item <?= $current_page == 'scopes' ? 'active' : '' ?>">
                    <i class="fas fa-briefcase"></i><span>Scopes of Work</span>
                </a>
                <a href="<?= URLROOT ?>/admin/join_cards" class="nav-item <?= $current_page == 'join_cards' ? 'active' : '' ?>">
                    <i class="fas fa-handshake"></i><span>Join Us Cards</span>
                </a>
                <a href="<?= URLROOT ?>/admin/about_sections" class="nav-item <?= $current_page == 'about_sections' ? 'active' : '' ?>">
                    <i class="fas fa-circle-info"></i><span>About Sections</span>
                </a>
                <a href="<?= URLROOT ?>/admin/reviews" class="nav-item <?= $current_page == 'reviews' ? 'active' : '' ?>">
                    <i class="fas fa-star"></i><span>Reader Reviews</span>
                </a>
                <a href="<?= URLROOT ?>/admin/faqs" class="nav-item <?= $current_page == 'faqs' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i><span>FAQs</span>
                </a>

                <a href="<?= URLROOT ?>/admin/hero_section" class="nav-item <?= $current_page == 'hero_section' ? 'active' : '' ?>">
                    <i class="fas fa-desktop"></i><span>Hero Section</span>
                </a>

                <a href="<?= URLROOT ?>/admin/sidebar_slides" class="nav-item <?= $current_page == 'sidebar_slides' ? 'active' : '' ?>">
                    <i class="fas fa-image"></i><span>Sidebar Slider (1:1)</span>
                </a>

                <div class="dropdown-wrapper">
                    <div class="nav-item has-dropdown <?= $current_page == 'youtube' ? 'active' : '' ?>">
                        <i class="fab fa-youtube"></i><span>YouTube Settings</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-content" <?= $current_page == 'youtube' || strpos($current_page, 'yt_') === 0 ? 'style="display: block;"' : '' ?>>
                        <a href="<?= URLROOT ?>/admin/youtube" class="<?= $current_page == 'youtube' ? 'active-sub' : '' ?>">
                            <i class="fas fa-broadcast-tower"></i> YouTube Live & Notification
                        </a>
                        <a href="<?= URLROOT ?>/admin/yt_videos" class="<?= $current_page == 'yt_videos' ? 'active-sub' : '' ?>">
                            <i class="fas fa-play-circle"></i> All YouTube Video
                        </a>
                        <a href="<?= URLROOT ?>/admin/add_yt_video" class="<?= $current_page == 'add_yt_video' ? 'active-sub' : '' ?>">
                            <i class="fas fa-plus-square"></i> Add YouTube Video
                        </a>
                        <a href="<?= URLROOT ?>/admin/yt_categories" class="<?= $current_page == 'yt_categories' ? 'active-sub' : '' ?>">
                            <i class="fas fa-tags"></i> Category
                        </a>
                    </div>
                </div>
                
                <?php $settings_active = in_array($current_page, ['settings', 'permissions', 'users', 'backup', 'system_update', 'facebook_pixel', 'google_analytics', 'sitemap']); ?>
                <div class="dropdown-wrapper">
                    <div class="nav-item has-dropdown <?= $settings_active ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i><span>Settings</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-content" <?= $settings_active ? 'style="display: block;"' : '' ?>>
                        <a href="<?= URLROOT ?>/admin/settings" class="<?= $current_page == 'settings' ? 'active-sub' : '' ?>">
                            <i class="fas fa-sliders-h"></i> Site Settings
                        </a>
                        <a href="<?= URLROOT ?>/admin/sitemap" class="<?= $current_page == 'sitemap' ? 'active-sub' : '' ?>">
                            <i class="fas fa-sitemap"></i> Site Map
                        </a>
                        <a href="<?= URLROOT ?>/admin/google_analytics" class="<?= $current_page == 'google_analytics' ? 'active-sub' : '' ?>">
                            <i class="fab fa-google"></i> Google Analytics
                        </a>
                        <a href="<?= URLROOT ?>/admin/facebook_pixel" class="<?= $current_page == 'facebook_pixel' ? 'active-sub' : '' ?>">
                            <i class="fab fa-facebook"></i> Facebook Pixel
                        </a>
                        <a href="<?= URLROOT ?>/admin/system_update" class="<?= $current_page == 'system_update' ? 'active-sub' : '' ?>">
                            <i class="fas fa-sync-alt"></i> System Update
                        </a>
                        <a href="<?= URLROOT ?>/admin/permissions" class="<?= $current_page == 'permissions' ? 'active-sub' : '' ?>">
                            <i class="fas fa-user-tag"></i> Roles & Permissions
                        </a>
                        <a href="<?= URLROOT ?>/admin/users" class="<?= $current_page == 'users' ? 'active-sub' : '' ?>">
                            <i class="fas fa-users"></i> Users & Staff
                        </a>
                        <a href="<?= URLROOT ?>/admin/backup" class="<?= $current_page == 'backup' ? 'active-sub' : '' ?>">
                            <i class="fas fa-database"></i> Database Backup
                        </a>
                    </div>
                </div>
            </div>

            <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid rgba(0,0,0,0.05); padding-bottom: 2rem;">
                <a href="<?= URLROOT ?>/admin/logout" class="nav-item" style="color: #ef4444;">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <!-- Reusable Media Picker Component -->
        <?php require APPROOT . '/Views/admin/inc/media_picker.php'; ?>

        <header class="top-navbar" style="display: none;">
        </header>
