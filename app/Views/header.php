<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $site_name = $data['settings']['site_title'] ?? 'Islamic Nur';
    $meta_description = $data['settings']['meta_description'] ?? '';
    $meta_keywords = $data['settings']['meta_keywords'] ?? '';
    $meta_author = $data['settings']['site_title'] ?? 'Islamic Nur';
    $og_title = $site_name;
    $og_description = $meta_description;
    $og_image = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : '';
    $og_url = URLROOT . '/' . ($_GET['url'] ?? '');

    if (isset($data['post']) && !empty($data['post'])) {
        $post = $data['post'];
        if (!empty($post['seo_title'])) {
            $seo_title = $post['seo_title'];
        } else {
            $seo_title = $post['title'] . ' - ' . $site_name;
        }
        if (!empty($post['seo_description'])) {
            $meta_description = $post['seo_description'];
        } else {
            $meta_description = !empty($post['excerpt']) ? $post['excerpt'] : mb_substr(strip_tags($post['content']), 0, 160, 'UTF-8');
        }
        if (!empty($post['seo_keywords'])) {
            $meta_keywords = $post['seo_keywords'];
        }
        $og_title = $post['title'];
        $og_description = $meta_description;
        if (!empty($post['featured_image'])) {
            if (strpos($post['featured_image'], 'http://') === 0 || strpos($post['featured_image'], 'https://') === 0 || strpos($post['featured_image'], URLROOT) === 0) {
                $og_image = $post['featured_image'];
            } else {
                $og_image = URLROOT . '/public/img/' . $post['featured_image'];
            }
        }
    } else {
        $seo_title = (!empty($data['title']) ? $data['title'] . ' - ' : '') . $site_name;
    }
    ?>
    <title><?= htmlspecialchars($seo_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars(strip_tags($meta_description)) ?>">
    <meta name="keywords" content="<?= htmlspecialchars(strip_tags($meta_keywords)) ?>">
    <meta name="author" content="<?= htmlspecialchars($meta_author) ?>">
    <!-- Open Graph -->
    <meta property="og:type" content="<?= isset($data['post']) ? 'article' : 'website' ?>">
    <meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(strip_tags($og_description)) ?>">
    <?php if (!empty($og_image)): ?>
        <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
    <?php endif; ?>
    <!-- JSON-LD Structured SEO Schema -->
    <?php if (isset($data['post']) && !empty($data['post'])): ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "NewsArticle",
          "headline": "<?= htmlspecialchars($data['post']['title']) ?>",
          "image": [
            "<?= htmlspecialchars($og_image) ?>"
          ],
          "datePublished": "<?= date('c', strtotime($data['post']['created_at'])) ?>",
          "dateModified": "<?= isset($data['post']['updated_at']) ? date('c', strtotime($data['post']['updated_at'])) : date('c', strtotime($data['post']['created_at'])) ?>",
          "author": {
            "@type": "Person",
            "name": "<?= htmlspecialchars($meta_author) ?>"
          },
          "publisher": {
            "@type": "Organization",
            "name": "<?= htmlspecialchars($site_name) ?>",
            "logo": {
              "@type": "ImageObject",
              "url": "<?= !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : '' ?>"
            }
          },
          "description": "<?= htmlspecialchars(strip_tags($meta_description)) ?>"
        }
        </script>
    <?php else: ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebSite",
          "name": "<?= htmlspecialchars($site_name) ?>",
          "url": "<?= URLROOT ?>/",
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "<?= URLROOT ?>/search?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        }
        </script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <a href="<?= URLROOT ?>/" class="brand">
                        <i class="fa-solid fa-mosque"></i> Islamic Nur
                    </a>
                    <ul class="nav-links">
                        <li><a href="<?= URLROOT ?>/" class="active">হোম</a></li>
                        <li><a href="<?= URLROOT ?>/news">খবর</a></li>
                        <li><a href="<?= URLROOT ?>/blogs">প্রবন্ধ</a></li>
                        <li><a href="<?= URLROOT ?>/quran">কুরআন</a></li>
                    </ul>
                </div>
                
                <div class="header-actions">
                    <div class="search-container">
                        <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                        <input type="text" placeholder="সার্চ করুন...">
                    </div>
                    
                    <div class="user-menu-container">
                        <div class="user-icon" id="userMenuBtn">
                            <i class="fa-regular fa-circle-user"></i>
                        </div>
                        <div class="user-dropdown" id="userDropdown">
                            <?php if(isset($_SESSION['admin_id'])): ?>
                                <a href="<?= URLROOT ?>/admin"><i class="fa-solid fa-gauge"></i> ড্যাশবোর্ড</a>
                                <a href="<?= URLROOT ?>/admin/logout"><i class="fa-solid fa-sign-out-alt"></i> লগআউট</a>
                            <?php else: ?>
                                <a href="<?= URLROOT ?>/admin/login"><i class="fa-solid fa-sign-in-alt"></i> লগইন</a>
                                <a href="<?= URLROOT ?>/register"><i class="fa-solid fa-user-plus"></i> রেজিস্ট্রেশন</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <a href="#" class="btn-download">অ্যাপ ডাউনলোড</a>
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Sidebar Drawer -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <a href="<?= URLROOT ?>/" class="brand">
                <i class="fa-solid fa-mosque"></i> Islamic Nur
            </a>
            <button class="close-sidebar" id="closeSidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-links">
                <li><a href="<?= URLROOT ?>/" class="active"><i class="fa-solid fa-house"></i> হোম</a></li>
                <li><a href="<?= URLROOT ?>/news"><i class="fa-solid fa-newspaper"></i> খবর</a></li>
                <li><a href="<?= URLROOT ?>/blogs"><i class="fa-solid fa-book-open"></i> প্রবন্ধ</a></li>
                <li><a href="<?= URLROOT ?>/quran"><i class="fa-solid fa-quran"></i> কুরআন</a></li>
            </ul>
            <div class="sidebar-actions">
                <div class="sidebar-search" style="margin-bottom: 1rem;">
                    <div class="search-container" style="display: flex; width: 100%;">
                        <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                        <input type="text" placeholder="সার্চ করুন...">
                    </div>
                </div>
                <a href="#" class="btn-download-mobile">
                    <i class="fa-solid fa-download"></i> অ্যাপ ডাউনলোড
                </a>
            </div>
        </div>
    </div>

