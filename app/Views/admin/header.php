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
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/admin.css?v=<?= time() ?>">
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
            width: 280px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid #e2e8f0;
        }
        .main-content {
            margin-left: 280px;
            padding: 3rem;
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
            left: 280px;
            width: calc(100% - 280px);
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
                width: 280px !important; 
                transform: translateX(-100%) !important; 
                transition: transform 0.3s !important; 
                overflow-y: auto !important;
                overflow-x: hidden !important;
            }
            .sidebar.mobile-active { transform: translateX(0) !important; }
            body.sidebar-collapsed .sidebar {
                width: 280px !important;
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
                padding: 24px 20px !important;
            }
            body.sidebar-collapsed .nav-item {
                justify-content: flex-start !important;
                padding: 10px 14px !important;
            }
            body.sidebar-collapsed .nav-item i:first-child {
                margin-right: 12px !important;
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
            /* Target only non-editor header panels to stack */
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
            /* Hide secondary columns on mobile dashboards to prevent squishing */
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
    <style>
        /* Modernized Sidebar Scrollbar & Shell */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
        }
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.08);
            border-radius: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 15px;
        }

        .sidebar-nav {
            padding: 0 15px 30px;
            display: flex;
            flex-direction: column;
        }

        /* Improved Sidebar Navigation Design */
        .nav-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.25rem;
        }

        .nav-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 700;
            padding: 10px 12px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: #475569 !important;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 2px;
            border-right: 3px solid transparent;
        }

        .nav-item i:first-child {
            width: 20px;
            margin-right: 12px;
            font-size: 1.05rem;
            color: #64748b;
            transition: all 0.25s;
        }

        .nav-item:hover {
            background: #f8fafc;
            color: #2563eb !important;
            transform: translateX(4px);
        }

        .nav-item:hover i:first-child {
            color: #2563eb;
        }

        .nav-item.active {
            background: #eff6ff !important;
            color: #2563eb !important;
            font-weight: 700;
            border-right-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.06);
        }

        .nav-item.active i:first-child {
            color: #2563eb !important;
        }

        /* Dropdown arrows and lists styling */
        .dropdown-arrow {
            margin-left: auto;
            font-size: 0.75rem;
            transition: transform 0.3s;
        }

        .dropdown-content {
            display: none;
            padding-left: 15px;
            border-left: 2px solid #eff6ff;
            margin: 2px 0 8px 22px;
            flex-direction: column;
            gap: 2px;
        }

        .dropdown-content a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: #64748b !important;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .dropdown-content a i {
            font-size: 0.85rem;
            color: #94a3b8;
            transition: all 0.2s;
        }

        .dropdown-content a:hover, 
        .dropdown-content a.active-sub {
            background: #eff6ff;
            color: #2563eb !important;
        }

        .dropdown-content a:hover i, 
        .dropdown-content a.active-sub i {
            color: #2563eb;
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
                    <h2 style="color: var(--text-main); margin: 0; font-size: 1.5rem; flex-shrink: 0;">NUR<span style="color: var(--primary);">LAB</span></h2>
                <?php endif; ?>
            </a>
            <button id="sidebar-collapse-btn" onclick="toggleSidebarCollapse(event)" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;">
                <i class="fas fa-angle-double-left" style="font-size: 1.25rem;"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= URLROOT ?>/admin" class="nav-item <?= $current_page == 'dashboard' || $current_page == '' ? 'active' : '' ?>">
                    <i class="fas fa-gauge-high"></i><span>Dashboard</span>
                </a>
                <a href="<?= URLROOT ?>/" target="_blank" class="nav-item">
                    <i class="fas fa-globe"></i><span>Visit Website</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Content Management</div>
                <a href="<?= URLROOT ?>/admin/posts" class="nav-item <?= $current_page == 'posts' ? 'active' : '' ?>">
                    <i class="fas fa-newspaper"></i><span>All Posts</span>
                </a>
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
