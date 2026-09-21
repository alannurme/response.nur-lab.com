<?php 
require APPROOT . '/Views/inc/header.php'; 

if (!function_exists('resolve_blog_image')) {
    function resolve_blog_image($image_path) {
        if (empty($image_path)) {
            return URLROOT . '/public/img/earth.jpg'; // fallback image
        }
        if (strpos($image_path, 'http://') === 0 || strpos($image_path, 'https://') === 0) {
            return $image_path;
        }
        return URLROOT . '/public/img/' . basename($image_path);
    }
}

// Helper function to get posts for a specific category
if (!function_exists('get_posts_for_category')) {
    function get_posts_for_category($posts, $category_id, $limit = 6, $fallback_posts = []) {
        $filtered = [];
        foreach ($posts as $post) {
            if (isset($post['category_id']) && $post['category_id'] == $category_id) {
                $filtered[] = $post;
            }
            if (count($filtered) >= $limit) {
                break;
            }
        }
        
        // If not enough posts, fill with fallbacks
        if (count($filtered) < $limit) {
            foreach ($fallback_posts as $fp) {
                $exists = false;
                foreach ($filtered as $f) {
                    if ($f['id'] == $fp['id']) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $filtered[] = $fp;
                }
                if (count($filtered) >= $limit) {
                    break;
                }
            }
        }
        return $filtered;
    }
}

$categories = $data['categories'] ?? [];
$all_posts = $data['posts'] ?? [];
$settings = $data['settings'] ?? [];

// Helper to resolve category by slug
$resolve_cat = function($slug, $fallback_index, $fallback_name) use ($categories) {
    if (!empty($slug)) {
        foreach ($categories as $cat) {
            if ($cat['slug'] === $slug) {
                return $cat;
            }
        }
    }
    return isset($categories[$fallback_index]) ? $categories[$fallback_index] : ['id' => 0, 'name' => $fallback_name, 'slug' => $slug];
};

// Resolve 4 categories dynamically
$cat0 = $resolve_cat($settings['cat0_category'] ?? '', 0, 'ইসলাম');
$cat1 = $resolve_cat($settings['cat1_category'] ?? '', 1, 'বিজ্ঞান');
$cat2 = $resolve_cat($settings['cat2_category'] ?? '', 2, 'সমাজ ও সংস্কৃতি');
$cat3 = $resolve_cat($settings['cat3_category'] ?? '', 3, 'ইতিহাস ও ঐতিহ্য');
?>

<!-- Custom Styles for Newspaper Pro Design -->
<style>
    html, body {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
    }
    #islamicCanvas, #islamicPatternCanvas, .crescent-orb-glow, .sky-aura {
        display: none !important;
    }
    :root {
        --newspaper-dark: #111111;
        --newspaper-border: #e2e8f0;
        --newspaper-accent: #2563eb;
        --newspaper-gray-bg: #f8fafc;
        --newspaper-text-main: #000000;
        --newspaper-text-muted: #1e293b;
        --lifestyle-color: #4b8543;
        --stay-connected-color: #111111;
        --modern-color: #111111;
        --house-design-color: #3b5998;
        --performance-color: #111111;
        --recipes-color: #a855f7;
    }

    .np-container {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .np-breadcrumbs {
        padding: 15px 0;
        font-size: 0.85rem;
        color: var(--newspaper-text-muted);
        border-bottom: 1px solid var(--newspaper-border);
        margin-bottom: 25px;
    }
    .np-breadcrumbs a {
        color: var(--newspaper-text-muted);
        text-decoration: none;
    }
    .np-breadcrumbs a:hover {
        color: var(--newspaper-accent);
    }
    .np-breadcrumbs span {
        margin: 0 8px;
    }

    /* Big Grid (Hero Section) */
    .np-big-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-template-rows: 250px 250px;
        gap: 6px;
        margin-bottom: 40px;
        overflow: hidden;
        border-radius: 4px;
    }

    .np-grid-item {
        position: relative;
        overflow: hidden;
        background: #000;
        color: #fff;
        height: 100%;
        display: block;
        text-decoration: none;
    }

    .np-grid-image-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
        transition: transform 0.6s ease;
    }

    .np-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.75;
        transition: transform 0.6s ease, opacity 0.3s;
    }

    .np-grid-item:hover img {
        transform: scale(1.05);
        opacity: 0.65;
    }

    .np-grid-meta-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 25px 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 60%, rgba(0,0,0,0) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        pointer-events: none;
    }

    .np-grid-badge {
        background: var(--newspaper-accent);
        color: #fff;
        padding: 3px 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        align-self: flex-start;
        margin-bottom: 10px;
        border-radius: 2px;
    }

    .np-grid-title {
        font-family: 'Noto Serif Bengali', serif;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 8px;
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    .np-grid-large .np-grid-title { font-size: 1.7rem; }
    .np-grid-small .np-grid-title { font-size: 1.1rem; }

    .np-grid-meta {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.85);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .np-grid-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .np-grid-large { grid-column: 1 / 2; grid-row: 1 / 3; }
    .np-grid-small-1 { grid-column: 2 / 3; grid-row: 1 / 2; }
    .np-grid-small-2 { grid-column: 2 / 3; grid-row: 2 / 3; }

    .np-big-grid.grid-2 {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 350px;
    }
    .np-big-grid.grid-2 .np-grid-large { grid-column: span 1; grid-row: span 1; }
    .np-big-grid.grid-1 {
        grid-template-columns: 1fr;
        grid-template-rows: 400px;
    }

    /* Newspaper Block Titles */
    .np-block-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--lifestyle-color);
        margin-bottom: 20px;
        position: relative;
        height: 38px;
    }

    .np-block-title-inner {
        color: #fff;
        padding: 0 15px;
        line-height: 38px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: var(--lifestyle-color);
        font-family: 'Outfit', sans-serif;
        white-space: nowrap;
    }

    /* Categories Menu on Header Right */
    .np-header-cats {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        font-weight: 700;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
        align-items: center;
        height: 100%;
    }
    .np-header-cats::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    .np-header-cats a {
        color: var(--newspaper-text-muted);
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
    }
    .np-header-cats a:hover, .np-header-cats a.active {
        color: var(--newspaper-accent);
    }
    .np-header-cats a.active {
        border-bottom: 2px solid var(--newspaper-accent);
        padding-bottom: 3px;
    }

    /* Layout Sections */
    .np-layout-row {
        display: flex;
        gap: 25px;
        margin-bottom: 45px;
    }
    .np-col-70 { flex: 0 0 calc(75% - 12.5px); max-width: calc(75% - 12.5px); }
    .np-col-30 { flex: 0 0 calc(25% - 12.5px); max-width: calc(25% - 12.5px); }

    /* Post Card Styles */
    .np-post-card {
        margin-bottom: 20px;
    }
    .np-post-image {
        position: relative;
        overflow: hidden;
        border-radius: 2px;
        background: #f1f5f9;
        margin-bottom: 12px;
    }
    .np-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .np-post-card:hover .np-post-image img {
        transform: scale(1.05);
    }
    .np-post-cat-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0,0,0,0.8);
        color: #fff;
        padding: 2px 6px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .np-post-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 6px;
        word-wrap: break-word;
        word-break: break-word;
    }
    .np-post-title a {
        color: var(--newspaper-text-main);
        text-decoration: none;
        transition: color 0.2s;
    }
    .np-post-title a:hover {
        color: var(--newspaper-accent);
    }
    .np-post-meta {
        font-size: 0.72rem;
        color: var(--newspaper-text-muted);
        font-weight: 500;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .np-post-excerpt {
        font-size: 0.88rem;
        color: var(--newspaper-text-muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-wrap: break-word;
        word-break: break-word;
    }

    /* Small Horizontal List Item */
    .np-list-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
        padding-top: 15px;
        border-top: 1px solid var(--newspaper-border);
        margin-top: 15px;
        width: 100%;
        box-sizing: border-box;
    }
    .np-list-item > div:not(.np-list-thumb) {
        flex: 1;
        min-width: 0;
        word-wrap: break-word;
        word-break: break-word;
    }
    .np-list-thumb {
        flex: 0 0 100px;
        height: 70px;
        overflow: hidden;
        border-radius: 2px;
        background: #f1f5f9;
    }
    .np-list-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .np-list-item:hover .np-list-thumb img {
        transform: scale(1.05);
    }
    .np-list-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.35;
        margin-bottom: 4px;
        word-wrap: break-word;
        word-break: break-word;
    }
    .np-list-title a {
        color: var(--newspaper-text-main);
        text-decoration: none;
    }
    .np-list-title a:hover {
        color: var(--newspaper-accent);
    }
    .np-list-meta {
        font-size: 0.7rem;
        color: var(--newspaper-text-muted);
    }

    /* Stay Connected Widget */
    .stay-connected-widget {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .sc-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 15px;
        color: #fff;
        text-decoration: none;
        border-radius: 2px;
        font-size: 0.85rem;
        font-weight: 700;
        transition: opacity 0.2s;
    }
    .sc-item:hover { opacity: 0.9; }
    .sc-item.fb { background: #3b5998; }
    .sc-item.tw { background: #0084ff; }
    .sc-item.yt { background: #cc181e; }
    .sc-item.ig { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .sc-item.other { background: #111111; }
    .sc-left { display: flex; align-items: center; gap: 12px; }
    .sc-left i { font-size: 1.2rem; }
    .sc-count { font-weight: 800; }
    .sc-action { text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.9; }

    /* Make It Modern Grid */
    .modern-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    .modern-card {
        display: flex;
        flex-direction: column;
    }
    .modern-card .np-post-title { font-size: 0.95rem; line-height: 1.3; }

    /* Popular Posts List */
    .np-popular-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .np-popular-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .np-popular-number {
        flex: 0 0 32px;
        height: 32px;
        border: 2px solid var(--newspaper-border);
        color: var(--newspaper-text-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 2px;
        transition: all 0.2s;
    }
    .np-popular-item:hover .np-popular-number {
        background: var(--newspaper-accent);
        border-color: var(--newspaper-accent);
        color: #fff;
    }
    .np-popular-details {
        flex: 1;
    }
    .np-popular-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 4px;
    }
    .np-popular-title a {
        color: var(--newspaper-text-main);
        text-decoration: none;
    }
    .np-popular-title a:hover {
        color: var(--newspaper-accent);
    }
    .np-popular-meta {
        font-size: 0.7rem;
        color: var(--newspaper-text-muted);
    }

    /* Categories List */
    .np-cat-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-left: 0;
    }
    .np-cat-item a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: var(--newspaper-gray-bg);
        border: 1px solid var(--newspaper-border);
        border-radius: 3px;
        color: var(--newspaper-text-main);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .np-cat-item a:hover {
        border-color: var(--newspaper-accent);
        color: var(--newspaper-accent);
        background: #fff;
    }

    /* Ad box */
    .np-ad-box {
        background: #f1f5f9;
        border: 1px dashed var(--newspaper-border);
        height: 250px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--newspaper-text-muted);
        text-align: center;
        padding: 20px;
    }
    .np-ad-title {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }
    .np-ad-placeholder {
        font-weight: 700;
        font-size: 1.1rem;
        color: #94a3b8;
    }

    @media (max-width: 992px) {
        .np-layout-row { flex-direction: column; width: 100% !important; box-sizing: border-box !important; }
        .np-col-70, .np-col-30 { flex: 0 0 100%; max-width: 100%; width: 100% !important; box-sizing: border-box !important; }
        .modern-grid { grid-template-columns: 1fr 1fr; width: 100% !important; box-sizing: border-box !important; }
    }
    @media (max-width: 768px) {
        .np-container {
            padding: 0 15px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .np-big-grid {
            grid-template-columns: 1fr;
            grid-template-rows: 250px 180px 180px;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .np-big-grid.grid-1 {
            grid-template-rows: 250px !important;
            width: 100% !important;
        }
        .np-big-grid.grid-2 {
            grid-template-columns: 1fr !important;
            grid-template-rows: 220px 220px !important;
            width: 100% !important;
        }
        .np-grid-large { grid-column: span 1; grid-row: span 1; }
        .np-grid-small-1 { grid-column: span 1; grid-row: span 1; }
        .np-grid-small-2 { grid-column: span 1; grid-row: span 1; }
        .modern-grid { grid-template-columns: 1fr; }
        .np-row-posts-container {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    }
    @media (max-width: 576px) {
        .np-block-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            height: auto !important;
            border-bottom: none !important;
            gap: 10px !important;
            margin-bottom: 25px !important;
        }
        .np-block-title-inner {
            width: 100% !important;
            border-radius: 4px !important;
            text-align: center !important;
        }
        .np-header-cats {
            width: 100% !important;
            padding: 5px 0 !important;
            border-bottom: 2px solid var(--lifestyle-color) !important;
        }
        .clean-grid {
            grid-template-columns: 1fr !important;
        }
    }

    .clean-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    @media (max-width: 1400px) {
        .clean-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 992px) {
        .clean-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .clean-grid { grid-template-columns: 1fr; }
    }

    .clean-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.3s ease;
    }

    .clean-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(37, 99, 235, 0.06);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .clean-card-image {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f1f5f9;
    }

    .clean-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .clean-card:hover .clean-card-image img {
        transform: scale(1.05);
    }

    .clean-card-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 10px;
    }

    .clean-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    .clean-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .clean-card-meta i {
        color: #3b82f6;
    }

    .clean-card-title {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1.4;
        margin: 0;
    }

    .clean-card-title a {
        font-family: 'Noto Serif Bengali', serif !important;
        color: #1e293b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .clean-card-title a:hover {
        color: #2563eb;
    }

    .clean-card-excerpt {
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    .clean-card-footer {
        padding: 12px 20px 20px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .clean-card-link {
        font-weight: 700;
        font-size: 0.88rem;
        color: #2563eb;
        text-decoration: none;
        transition: color 0.2s;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    .clean-card-link:hover {
        color: #1d4ed8;
    }

    .clean-card-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .clean-card:hover .clean-card-btn {
        background: #2563eb;
        color: #ffffff;
        transform: translateX(3px);
    }

    /* Sidebar Styles (matching post.php) */
    .post-sidebar {
        position: sticky;
        top: 110px;
        align-self: start;
        height: fit-content;
    }

    .sidebar-widget {
        background: var(--white);
        padding: 25px;
        border-radius: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        box-sizing: border-box;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary);
        display: inline-block;
    }

    .related-post {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        text-decoration: none;
        color: var(--text-main);
        transition: color 0.2s ease;
        align-items: flex-start;
        text-align: left;
    }
    .related-post:hover {
        color: var(--primary);
    }

    .related-post img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .related-title {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
        color: var(--text-main);
    }
    .related-post:hover .related-title {
        color: var(--primary);
    }
    .sidebar-carousel-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        cursor: pointer;
        transition: 0.3s;
    }

    /* Fallback styles for posts without images */
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .no-image-placeholder span {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: #166534;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-wrap: break-word;
        word-break: break-word;
        transition: transform 0.3s ease;
    }
    .clean-card:hover .no-image-placeholder {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%) !important;
    }
    .clean-card:hover .no-image-placeholder span {
        transform: scale(1.03);
    }
</style>

<!-- Main Blog Page -->
<div class="np-container" style="margin-top: 30px;">
    
    <!-- Breadcrumbs -->
    <div class="np-breadcrumbs">
        <a href="<?= URLROOT ?>"><i class="fas fa-home"></i> হোম</a>
        <span>/</span>
        <a href="<?= URLROOT ?>/blog">নিবন্ধসমূহ</a>
        <?php if ($data['title'] !== 'সবগুলো নিবন্ধ' && $data['title'] !== 'নিবন্ধসমূহ'): ?>
            <span>/</span>
            <span style="color: var(--newspaper-accent); font-weight: 600;"><?= htmlspecialchars($data['title']) ?></span>
        <?php endif; ?>
    </div>

    <!-- Newspaper Pro Big Grid (Hero Area - Disabled to match category page design) -->
    <?php if (false): ?>
        <?php 
            $grid_posts = array_slice($all_posts, 0, 3);
            $grid_count = count($grid_posts);
            $grid_class = '';
            if ($grid_count === 2) {
                $grid_class = 'grid-2';
            } elseif ($grid_count === 1) {
                $grid_class = 'grid-1';
            }
        ?>
        <div class="np-big-grid <?= $grid_class ?>">
            <!-- Large Main Grid Item -->
            <?php if (isset($grid_posts[0])): ?>
                <?php 
                    $post = $grid_posts[0];
                    $blog_img = resolve_blog_image($post['featured_image']);
                ?>
                <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="np-grid-item np-grid-large">
                    <div class="np-grid-image-wrapper">
                        <img src="<?=$blog_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="np-grid-meta-overlay">
                        <h2 class="np-grid-title"><?= htmlspecialchars($post['title']) ?></h2>
                        <div class="np-grid-meta">
                            <span><i class="far fa-user"></i> এডমিন</span>
                            <span><i class="far fa-calendar-alt"></i> <?= date('d M, Y', strtotime($post['created_at'])) ?></span>
                            <span><i class="far fa-eye"></i> <?= number_format($post['views']) ?> বার</span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>

            <!-- Second Grid Item -->
            <?php if (isset($grid_posts[1])): ?>
                <?php 
                    $post = $grid_posts[1];
                    $blog_img = resolve_blog_image($post['featured_image']);
                ?>
                <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="np-grid-item np-grid-small np-grid-small-1">
                    <div class="np-grid-image-wrapper">
                        <img src="<?=$blog_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="np-grid-meta-overlay">
                        <h3 class="np-grid-title"><?= htmlspecialchars($post['title']) ?></h3>
                        <div class="np-grid-meta">
                            <span><i class="far fa-calendar-alt"></i> <?= date('d M, Y', strtotime($post['created_at'])) ?></span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>

            <!-- Third Grid Item -->
            <?php if (isset($grid_posts[2])): ?>
                <?php 
                    $post = $grid_posts[2];
                    $blog_img = resolve_blog_image($post['featured_image']);
                ?>
                <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="np-grid-item np-grid-small np-grid-small-2">
                    <div class="np-grid-image-wrapper">
                        <img src="<?=$blog_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="np-grid-meta-overlay">
                        <h3 class="np-grid-title"><?= htmlspecialchars($post['title']) ?></h3>
                        <div class="np-grid-meta">
                            <span><i class="far fa-calendar-alt"></i> <?= date('d M, Y', strtotime($post['created_at'])) ?></span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>



    <!-- RENDER DYNAMIC CATEGORY ROWS -->
    <?php 
    $blocks_count = intval($settings['blog_blocks_count'] ?? 4);
    if ($blocks_count < 1) $blocks_count = 1;
    
    $row_categories = [];
    for ($idx = 0; $idx < $blocks_count; $idx++) {
        $row_categories[$idx] = $resolve_cat($settings["cat{$idx}_category"] ?? '', $idx, 'ক্যাটাগরি');
    }
    ?>
    <div class="np-layout-row">
        <!-- Left Column -->
        <div class="np-col-70">
            <?php if (true): // Always show category style design (clean grid cards) ?>
                <!-- Clean Modern Card Grid for Category & Search Pages -->
                <div style="margin-bottom: 25px;">
                    <h2 style="font-family: 'Noto Serif Bengali', serif; font-size: 1.8rem; font-weight: 800; color: var(--newspaper-text-main); margin-bottom: 5px;"><?= htmlspecialchars($data['title']) ?></h2>
                    <div style="width: 50px; height: 3px; background: var(--newspaper-accent); border-radius: 2px; margin-bottom: 20px;"></div>
                </div>
                
                <?php if (!empty($all_posts)): ?>
                    <div class="clean-grid">
                        <?php foreach ($all_posts as $post): 
                            $blog_img = resolve_blog_image($post['featured_image']);
                            $excerpt = strip_tags(!empty($post['excerpt']) ? $post['excerpt'] : $post['content']);
                            if (mb_strlen($excerpt) > 120) {
                                $excerpt = mb_substr($excerpt, 0, 120) . '...';
                            }
                        ?>
                            <div class="clean-card">
                                <div class="clean-card-image">
                                    <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;">
                                        <?php if (!empty($post['featured_image'])): ?>
                                            <img src="<?=$blog_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($post['title']) ?>">
                                        <?php else: ?>
                                            <div class="no-image-placeholder">
                                                <span><?= htmlspecialchars($post['title']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="clean-card-content">
                                    <div class="clean-card-meta">
                                        <span><i class="far fa-calendar-alt"></i> <?= date('d M', strtotime($post['created_at'])) ?></span>
                                        <span><i class="far fa-user"></i> এডমিন</span>
                                        <span><i class="far fa-eye"></i> <?= number_format($post['views'] ?? 0) ?> বার</span>
                                    </div>
                                    <h3 class="clean-card-title">
                                        <a href="<?= URLROOT ?>/<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                                    </h3>
                                    <p class="clean-card-excerpt"><?= $excerpt ?></p>
                                </div>
                                <div class="clean-card-footer">
                                    <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="clean-card-link">বিস্তারিত পড়ুন</a>
                                    <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="clean-card-btn">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if (isset($data['total_pages']) && $data['total_pages'] > 1): ?>
                        <div class="pagination-wrapper" style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; margin-bottom: 20px;">
                            <?php 
                            $curr_page = $data['current_page'];
                            $tot_pages = $data['total_pages'];
                            
                            // Helper to build page url
                            $get_page_url = function($p) use ($data) {
                                $query = $_GET;
                                $query['page'] = $p;
                                $slug = $data['category_slug'] ?? '';
                                if (!empty($slug)) {
                                    return URLROOT . '/' . $slug . '?' . http_build_query($query);
                                } else {
                                    return URLROOT . '/blog?' . http_build_query($query);
                                }
                            };
                            
                            if (!function_exists('toBengaliNumberLocal')) {
                                function toBengaliNumberLocal($number) {
                                    $en_num = ['0','1','2','3','4','5','6','7','8','9'];
                                    $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                                    return str_replace($en_num, $bn_num, $number);
                                }
                            }
                            ?>
                            
                            <?php if ($curr_page > 1): ?>
                                <a href="<?= $get_page_url($curr_page - 1) ?>" class="blog-page-link" style="padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #475569; font-weight: 600; font-size: 0.9rem; background: #fff; transition: all 0.2s;"><i class="fas fa-chevron-left"></i> পূর্ববর্তী</a>
                            <?php endif; ?>
                            
                            <?php 
                            $start = max(1, $curr_page - 2);
                            $end = min($tot_pages, $curr_page + 2);
                            
                            if ($start > 1) {
                                echo '<a href="' . $get_page_url(1) . '" class="blog-page-link" style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #475569; font-weight: 600; font-size: 0.9rem; background: #fff; transition: all 0.2s;">১</a>';
                                if ($start > 2) {
                                    echo '<span style="color: #94a3b8; padding: 0 4px;">...</span>';
                                }
                            }
                            
                            for ($i = $start; $i <= $end; $i++) {
                                $active_style = ($i == $curr_page) 
                                    ? 'background: var(--primary) !important; color: #fff !important; border-color: var(--primary) !important;' 
                                    : 'background: #fff; color: #475569; border-color: #e2e8f0;';
                                echo '<a href="' . $get_page_url($i) . '" class="blog-page-link" style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; ' . $active_style . '">' . toBengaliNumberLocal($i) . '</a>';
                            }
                            
                            if ($end < $tot_pages) {
                                if ($end < $tot_pages - 1) {
                                    echo '<span style="color: #94a3b8; padding: 0 4px;">...</span>';
                                }
                                echo '<a href="' . $get_page_url($tot_pages) . '" class="blog-page-link" style="padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #475569; font-weight: 600; font-size: 0.9rem; background: #fff; transition: all 0.2s;">' . toBengaliNumberLocal($tot_pages) . '</a>';
                            }
                            ?>
                            
                            <?php if ($curr_page < $tot_pages): ?>
                                <a href="<?= $get_page_url($curr_page + 1) ?>" class="blog-page-link" style="padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #475569; font-weight: 600; font-size: 0.9rem; background: #fff; transition: all 0.2s;">পরবর্তী <i class="fas fa-chevron-right"></i></a>
                            <?php endif; ?>
                        </div>
                        
                        <style>
                            .blog-page-link:hover {
                                border-color: var(--primary) !important;
                                color: var(--primary) !important;
                                background: #f8fafc !important;
                            }
                        </style>
                    <?php endif; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 50px; background: #fff; border: 1px solid var(--newspaper-border); border-radius: 4px; color: var(--newspaper-text-muted); font-style: italic;">
                        কোনো নিবন্ধ পাওয়া যায়নি।
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Default Newspaper Layout -->
                <?php 
                for ($idx = 0; $idx < $blocks_count; $idx++):
                    $cur_cat = $row_categories[$idx];
                    $cur_cat_name = $cur_cat['name'];
                    $cur_cat_id = $cur_cat['id'];
                    
                    // Slice different fallbacks for different sections to avoid duplication where possible
                    $fallback_posts = array_slice($all_posts, 3 + ($idx * 6), 6);
                    $posts_list = get_posts_for_category($all_posts, $cur_cat_id, 6, $fallback_posts);
                ?>
                <div class="np-category-block" style="margin-bottom: 45px;">
                    <div class="np-block-header">
                        <a href="<?= URLROOT ?>/<?= $cur_cat['slug'] ?>" class="np-block-title-inner np-subcat-tab active" data-slug="<?= $cur_cat['slug'] ?>" data-row="<?= $idx ?>" style="color: #fff; text-decoration: none; display: inline-block;"><?= htmlspecialchars($cur_cat_name) ?></a>
                        <div class="np-header-cats">
                            <?php 
                                $sub_slugs_key = "cat{$idx}_sub_categories";
                                $sub_slugs = !empty($settings[$sub_slugs_key]) ? explode(',', $settings[$sub_slugs_key]) : [];
                                if (!empty($sub_slugs) && !empty($categories)) {
                                    foreach ($categories as $cat) {
                                        if (in_array($cat['slug'], $sub_slugs)) {
                                            ?>
                                            <a href="<?= URLROOT ?>/<?= $cat['slug'] ?>" class="np-subcat-tab" data-slug="<?= $cat['slug'] ?>" data-row="<?= $idx ?>"><?= htmlspecialchars($cat['name']) ?></a>
                                            <?php
                                        }
                                    }
                                } else {
                                    foreach(array_slice($categories, 1 + ($idx * 2), 4) as $c) {
                                        ?>
                                        <a href="<?= URLROOT ?>/<?= $c['slug'] ?>" class="np-subcat-tab" data-slug="<?= $c['slug'] ?>" data-row="<?= $idx ?>"><?= htmlspecialchars($c['name']) ?></a>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <div class="np-row-posts-container" id="row-posts-<?= $idx ?>" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; transition: opacity 0.25s ease;">
                        <!-- Column 1 (Left Half) -->
                        <div>
                            <?php if (isset($posts_list[0])): 
                                $p = $posts_list[0];
                                $img = resolve_blog_image($p['featured_image']);
                            ?>
                                <div class="np-post-card">
                                    <div class="np-post-image" style="height: 180px;">
                                        <img src="<?=$img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($p['title']) ?>">
                                    </div>
                                    <h3 class="np-post-title"><a href="<?= URLROOT ?>/<?= $p['slug'] ?>"><?= htmlspecialchars($p['title']) ?></a></h3>
                                    <div class="np-post-meta">
                                        <span>Admin</span>
                                        <span>-</span>
                                        <span><?= date('M d, Y', strtotime($p['created_at'])) ?></span>
                                    </div>
                                    <p class="np-post-excerpt"><?= strip_tags(!empty($p['excerpt']) ? $p['excerpt'] : $p['content']) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php for($i = 2; $i <= 3; $i++): 
                                if (isset($posts_list[$i])):
                                    $p = $posts_list[$i];
                                    $img = resolve_blog_image($p['featured_image']);
                            ?>
                                <div class="np-list-item">
                                    <div class="np-list-thumb">
                                        <img src="<?=$img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($p['title']) ?>">
                                    </div>
                                    <div>
                                        <h4 class="np-list-title"><a href="<?= URLROOT ?>/<?= $p['slug'] ?>"><?= htmlspecialchars($p['title']) ?></a></h4>
                                        <div class="np-list-meta"><?= date('M d, Y', strtotime($p['created_at'])) ?></div>
                                    </div>
                                </div>
                            <?php endif; endfor; ?>
                        </div>

                        <!-- Column 2 (Right Half) -->
                        <div>
                            <?php if (isset($posts_list[1])): 
                                $p = $posts_list[1];
                                $img = resolve_blog_image($p['featured_image']);
                            ?>
                                <div class="np-post-card">
                                    <div class="np-post-image" style="height: 180px;">
                                        <img src="<?=$img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($p['title']) ?>">
                                    </div>
                                    <h3 class="np-post-title"><a href="<?= URLROOT ?>/<?= $p['slug'] ?>"><?= htmlspecialchars($p['title']) ?></a></h3>
                                    <div class="np-post-meta">
                                        <span>Admin</span>
                                        <span>-</span>
                                        <span><?= date('M d, Y', strtotime($p['created_at'])) ?></span>
                                    </div>
                                    <p class="np-post-excerpt"><?= strip_tags(!empty($p['excerpt']) ? $p['excerpt'] : $p['content']) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php for($i = 4; $i <= 5; $i++): 
                                if (isset($posts_list[$i])):
                                    $p = $posts_list[$i];
                                    $img = resolve_blog_image($p['featured_image']);
                            ?>
                                <div class="np-list-item">
                                    <div class="np-list-thumb">
                                        <img src="<?=$img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($p['title']) ?>">
                                    </div>
                                    <div>
                                        <h4 class="np-list-title"><a href="<?= URLROOT ?>/<?= $p['slug'] ?>"><?= htmlspecialchars($p['title']) ?></a></h4>
                                        <div class="np-list-meta"><?= date('M d, Y', strtotime($p['created_at'])) ?></div>
                                    </div>
                                </div>
                            <?php endif; endfor; ?>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <!-- Right Column: Sidebar Widgets -->
        <div class="np-col-30">
            <aside class="post-sidebar">
                <!-- Recent Questions Widget -->
                <?php if (!empty($data['recent_questions'])): ?>
                <div class="sidebar-widget">
                    <a href="<?= URLROOT ?>/q&amp;a" style="text-decoration: none; display: flex; align-items: center; justify-content: space-between; background: var(--primary); color: #ffffff; padding: 10px 15px; border-radius: 12px; font-weight: 800; font-size: 1rem; margin-bottom: 20px; transition: 0.3s; border: 1.5px solid var(--primary); font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='transparent'; this.style.color='var(--primary)';" onmouseout="this.style.background='var(--primary)'; this.style.color='#ffffff';">
                        <span style="display: inline-flex; align-items: center; gap: 8px;">
                            <span style="background: #ffffff; color: var(--primary); width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; line-height: 1; flex-shrink: 0;">?</span>প্রশ্নসমূহ
                        </span>
                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                    </a>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach ($data['recent_questions'] as $q): ?>
                        <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="related-post" style="align-items: flex-start; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 0;">
                            <div style="width: 32px; height: 32px; background: var(--primary); color: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; margin-top: 2px;">
                                ?
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.95rem; font-weight: 700; line-height: 1.4;"><?= htmlspecialchars(mb_strimwidth($q['question'], 0, 75, '...')) ?></div>
                                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">
                                    <i class="far fa-clock"></i> <?= date('d M, Y', strtotime($q['created_at'])) ?>
                                    <?php if (!empty($q['category_name'])): ?>
                                        <span style="margin-left: 8px; font-weight: 700; color: var(--primary);"><i class="far fa-folder"></i> <?= htmlspecialchars($q['category_name']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Posts Widget -->
                <?php if (!empty($data['recent_posts'])): ?>
                <div class="sidebar-widget">
                    <h4 class="widget-title">সাম্প্রতিক লেখাসমূহ</h4>
                    <?php foreach ($data['recent_posts'] as $recent): ?>
                    <a href="<?= URLROOT ?>/<?= $recent['slug'] ?>" class="related-post">
                        <div class="related-img-container" style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                            <?php if (!empty($recent['featured_image'])): 
                                $recent_img = resolve_blog_image($recent['featured_image']);
                            ?>
                                <img src="<?=$recent_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($recent['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fa-regular fa-image" style="font-size: 1.2rem; opacity: 0.5;"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="related-title"><?= htmlspecialchars($recent['title']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;"><?= date('M d, Y', strtotime($recent['created_at'])) ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Sidebar Image Slider (1:1 Size) -->
                <?php if (!empty($data['sidebar_slides'])): ?>
                <div class="sidebar-widget">
                    <h4 class="widget-title">আমাদের বইসমূহ</h4>
                    <div class="sidebar-carousel-container" style="position: relative; overflow: hidden; width: 100%; border-radius: 12px; aspect-ratio: 1/1;">
                        <div class="sidebar-carousel-slides" style="display: flex; transition: transform 0.5s ease-in-out; height: 100%;">
                            <?php foreach ($data['sidebar_slides'] as $index => $side_slide): ?>
                                <div class="sidebar-carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                                    <?php if (!empty($side_slide['link'])): ?>
                                        <a href="<?= htmlspecialchars($side_slide['link']) ?>" target="_blank" style="display: block; width: 100%; height: 100%;">
                                    <?php endif; ?>
                                    <img src="<?=htmlspecialchars($side_slide['image'])?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; display: block;" alt="Sidebar Image">
                                    <?php if (!empty($side_slide['link'])): ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Carousel Controls -->
                        <?php if (count($data['sidebar_slides']) > 1): ?>
                            <button class="sidebar-carousel-prev" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 5;"><i class="fas fa-chevron-left" style="font-size: 0.8rem;"></i></button>
                            <button class="sidebar-carousel-next" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 5;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></button>
                            
                            <div class="sidebar-carousel-dots" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 5;">
                                <?php foreach ($data['sidebar_slides'] as $index => $side_slide): ?>
                                    <span class="sidebar-carousel-dot" data-index="<?= $index ?>" style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: 0.3s; <?= $index === 0 ? 'background: #ffffff; transform: scale(1.2);' : '' ?>"></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Popular Posts Widget -->
                <?php if (!empty($data['popular_posts'])): ?>
                <div class="sidebar-widget">
                    <h4 class="widget-title">জনপ্রিয় লেখাসমূহ</h4>
                    <?php foreach ($data['popular_posts'] as $popular): ?>
                    <a href="<?= URLROOT ?>/<?= $popular['slug'] ?>" class="related-post">
                        <div class="related-img-container" style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                            <?php if (!empty($popular['featured_image'])): 
                                $popular_img = resolve_blog_image($popular['featured_image']);
                            ?>
                                <img src="<?=$popular_img?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($popular['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fa-regular fa-image" style="font-size: 1.2rem; opacity: 0.5;"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="related-title"><?= htmlspecialchars($popular['title']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;"><?= date('M d, Y', strtotime($popular['created_at'])) ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.np-subcat-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            const slug = this.getAttribute('data-slug');
            const rowIdx = this.getAttribute('data-row');
            const targetContainer = document.getElementById('row-posts-' + rowIdx);
            
            if (!targetContainer || !slug) return;
            
            // Remove active class from sibling tabs
            const parentHeader = this.closest('.np-block-header');
            if (parentHeader) {
                const siblingTabs = parentHeader.querySelectorAll('.np-subcat-tab');
                siblingTabs.forEach(sibling => {
                    sibling.classList.remove('active');
                });
            }
            this.classList.add('active');
            
            // Smooth fade transition
            targetContainer.style.opacity = '0.3';
            
            // Fetch category posts via AJAX
            fetch('<?= URLROOT ?>/category_posts_ajax?category=' + encodeURIComponent(slug))
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    targetContainer.innerHTML = html;
                    targetContainer.style.opacity = '1';
                })
                .catch(err => {
                    console.error('Error loading posts:', err);
                    targetContainer.style.opacity = '1';
                });
        });
    });

    // Sidebar Carousel Slider (matching post.php)
    const carouselSlides = document.querySelector('.sidebar-carousel-slides');
    if (carouselSlides) {
        const slides = document.querySelectorAll('.sidebar-carousel-slide');
        const dots = document.querySelectorAll('.sidebar-carousel-dot');
        const prevBtn = document.querySelector('.sidebar-carousel-prev');
        const nextBtn = document.querySelector('.sidebar-carousel-next');
        let currentIndex = 0;
        const totalSlides = slides.length;
        let slideInterval;

        function updateSlider() {
            carouselSlides.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.style.background = '#ffffff';
                    dot.style.transform = 'scale(1.2)';
                } else {
                    dot.style.background = 'rgba(255,255,255,0.5)';
                    dot.style.transform = 'scale(1)';
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoplay();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoplay();
            });
        }

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                currentIndex = parseInt(e.target.getAttribute('data-index'));
                updateSlider();
                resetAutoplay();
            });
        });

        function startAutoplay() {
            slideInterval = setInterval(nextSlide, 4000);
        }

        function resetAutoplay() {
            clearInterval(slideInterval);
            startAutoplay();
        }

        startAutoplay();
    }
});
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
