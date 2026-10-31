<?php
if (!function_exists('getBengaliDate')) {
    function getBengaliDate() {
        $en_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $bn_days = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        
        $en_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bn_months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        
        $en_num = ['0','1','2','3','4','5','6','7','8','9'];
        $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        
        $day_name = str_replace($en_days, $bn_days, date('l'));
        $month_name = str_replace($en_months, $bn_months, date('F'));
        $day_num = str_replace($en_num, $bn_num, date('d'));
        $year_num = str_replace($en_num, $bn_num, date('Y'));
        
        return "$day_name, $day_num $month_name $year_num";
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // Determine SEO values
    $site_name = $data['settings']['site_title'] ?? 'RESPONSE WITH NUR-LAB';
    
    // Default fallback from global settings
    $meta_description = $data['settings']['meta_description'] ?? '';
    $meta_keywords = $data['settings']['meta_keywords'] ?? '';
    $meta_author = $data['settings']['site_title'] ?? 'RESPONSE WITH NUR-LAB';
    $og_title = $site_name;
    $og_description = $meta_description;
    $og_image = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : '';
    // Determine current request URL
    $request_path = ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '', '/');
    $script_base = trim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    if (!empty($script_base) && strpos($request_path, $script_base) === 0) {
        $request_path = ltrim(substr($request_path, strlen($script_base)), '/');
    }
    $og_url = URLROOT . (!empty($request_path) ? '/' . $request_path : '');
    
    // Check if we are viewing a single post
    if (isset($data['post']) && !empty($data['post'])) {
        $post = $data['post'];
        
        // Accurate post canonical & OG URL
        if (!empty($post['slug'])) {
            $og_url = URLROOT . '/' . rawurlencode($post['slug']);
        }
        
        // Post Title SEO
        if (!empty($post['seo_title'])) {
            $seo_title = $post['seo_title'];
        } else {
            $seo_title = $post['title'] . ' - ' . $site_name;
        }
        
        // Post Description SEO
        if (!empty($post['seo_description'])) {
            $meta_description = $post['seo_description'];
        } else {
            $meta_description = !empty($post['excerpt']) ? $post['excerpt'] : mb_substr(strip_tags($post['content']), 0, 160, 'UTF-8');
        }
        $meta_description = trim(preg_replace('/\s+/u', ' ', strip_tags($meta_description)));
        
        // Post Keywords SEO
        if (!empty($post['seo_keywords'])) {
            $meta_keywords = $post['seo_keywords'];
        }
        
        // Authors
        if (!empty($data['post_authors'])) {
            $author_names = array_column($data['post_authors'], 'name');
            $meta_author = implode(', ', $author_names);
        } else {
            $meta_author = $post['author'] ?? $site_name;
        }
        
        $og_title = $post['title'];
        $og_description = $meta_description;
        
        if (!empty($post['featured_image'])) {
            $og_image = resolve_blog_image($post['featured_image']);
        } else {
            // If post has no featured image, check if content has an image
            if (!empty($post['content']) && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post['content'], $img_match)) {
                $og_image = resolve_dynamic_url($img_match[1], '/public/img/');
            } else {
                // Use default post banner / placeholder image instead of site logo
                $og_image = resolve_blog_image('');
            }
        }
    } elseif (isset($data['question']) && !empty($data['question'])) {
        // Question detail view SEO
        $q = $data['question'];
        $clean_q = trim(preg_replace('/\s+/u', ' ', strip_tags($q['question'])));
        $seo_title = $clean_q . ' - ' . $site_name;
        $meta_description = !empty($q['details']) ? mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags($q['details']))), 0, 160, 'UTF-8') : mb_substr($clean_q, 0, 160, 'UTF-8');
        $og_title = $clean_q;
        $og_description = $meta_description;
        $meta_author = $q['name'] ?? $site_name;
    } else {
        // We are on general pages (Home, Category, list pages)
        $meta_description = trim(preg_replace('/\s+/u', ' ', strip_tags($meta_description)));
        if (empty($meta_description)) {
            $meta_description = 'RESPONSE WITH NUR-LAB - একটি নির্ভরযোগ্য ইসলামিক রিসার্চ, প্রশ্ন-উত্তর, কুরআন ও হাদিস প্ল্যাটফর্ম।';
        }
        if (isset($data['title']) && (strtolower($data['title']) === 'home' || empty($data['title']))) {
            $seo_title = $site_name . (!empty($data['settings']['site_tagline']) ? ' - ' . $data['settings']['site_tagline'] : ' - Islamic Research, Quran, Hadith & Q&A Hub');
        } else {
            $seo_title = (!empty($data['title']) ? $data['title'] . ' - ' : '') . $site_name;
        }
        $og_title = $seo_title;
        $og_description = $meta_description;
    }
    ?>
    <title><?= htmlspecialchars($seo_title) ?></title>
    <link rel="canonical" href="<?= htmlspecialchars($og_url) ?>">
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars(strip_tags($meta_keywords)) ?>">
    <meta name="author" content="<?= htmlspecialchars($meta_author) ?>">
    <?php 
    $pStatus = $data['post']['status'] ?? ($post['status'] ?? 'published');
    if (!empty($data['post']) && $pStatus !== 'published'): 
    ?>
    <meta name="robots" content="noindex, nofollow, noarchive">
    <?php else: ?>
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <?php endif; ?>
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= isset($data['post']) ? 'article' : 'website' ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site_name) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <?php if (!empty($og_image)): ?>
        <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
        <meta property="og:image:secure_url" content="<?= htmlspecialchars($og_image) ?>">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:type" content="image/jpeg">
        <link rel="image_src" href="<?= htmlspecialchars($og_image) ?>">
    <?php endif; ?>
    <meta property="og:description" content="<?= htmlspecialchars($og_description) ?>">
    <?php if (isset($data['post']) && !empty($data['post'])): ?>
    <meta property="article:published_time" content="<?= !empty($post['created_at']) ? date('c', strtotime($post['created_at'])) : date('c') ?>">
    <meta property="article:section" content="<?= htmlspecialchars($data['category_name'] ?? 'Islam') ?>">
    <?php endif; ?>
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= htmlspecialchars($og_url) ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars(strip_tags($og_description)) ?>">
    <?php if (!empty($og_image)): ?>
        <meta name="twitter:image" content="<?= htmlspecialchars($og_image) ?>">
    <?php endif; ?>
    
    <!-- Favicon -->
    <?php if (!empty($data['settings']['site_favicon'])): ?>
        <link rel="icon" type="image/png" href="<?= resolve_setting_image($data['settings']['site_favicon']) ?>">
    <?php else: ?>
        <link rel="icon" type="image/png" href="<?= URLROOT ?>/img/icon-192.png">
    <?php endif; ?>

    <?php
    $site_pwa_icon = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : (!empty($data['settings']['site_favicon']) ? resolve_setting_image($data['settings']['site_favicon']) : URLROOT . '/img/icon-192.png');
    ?>
    <!-- PWA Settings -->
    <link rel="manifest" href="<?= URLROOT ?>/public/manifest.php?v=3">
    <meta name="theme-color" content="#044e39">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= htmlspecialchars($data['settings']['site_title'] ?? 'NUR-LAB') ?>">
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($site_pwa_icon) ?>">

    <!-- PWA Service Worker & Install Handler -->
    <script>
        var deferredPwaPrompt = null;
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?= URLROOT ?>/public/sw.js?v=3', { scope: '/' }).then(function(registration) {
                    console.log('PWA ServiceWorker registered:', registration.scope);
                }).catch(function(err) {
                    console.log('PWA ServiceWorker registration error:', err);
                });
            });
        }

        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPwaPrompt = e;
        });

        function triggerPwaInstallation() {
            if (deferredPwaPrompt) {
                deferredPwaPrompt.prompt();
                deferredPwaPrompt.userChoice.then(function(choiceResult) {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted PWA installation');
                    }
                    deferredPwaPrompt = null;
                });
            }
        }
    </script>
    <!-- Google Fonts Preconnect & Font Awesome Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Noto+Sans+Bengali:wght@400;600;700&family=Noto+Serif+Bengali:wght@400;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Facebook Pixel Code -->
    <?php if (isset($data['settings']['facebook_pixel_status']) && $data['settings']['facebook_pixel_status'] === 'enabled' && !empty($data['settings']['facebook_pixel_code'])): ?>
        <?= $data['settings']['facebook_pixel_code'] ?>
    <?php endif; ?>
    
    <!-- Google Analytics (gtag.js) -->
    <?php if (isset($data['settings']['google_analytics_status']) && $data['settings']['google_analytics_status'] === 'enabled' && !empty($data['settings']['ga_id'])): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($data['settings']['ga_id']) ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?= htmlspecialchars($data['settings']['ga_id']) ?>');
        </script>
    <?php endif; ?>

    <!-- JSON-LD Structured SEO Schema -->
    <?php
    $schema_json = '';
    if (isset($data['post']) && !empty($data['post'])) {
        $post = $data['post'];
        $has_custom_schema = false;
        
        if (!empty($post['schema_data'])) {
            $schema_data = json_decode($post['schema_data'], true);
            if ($schema_data && !empty($schema_data['type'])) {
                $has_custom_schema = true;
                $type = $schema_data['type'];
                $fields = $schema_data['fields'] ?? [];
                
                if ($type === 'Custom') {
                    $schema_json = $fields['custom_json'] ?? '';
                } else {
                    $post['title'] = trim($post['title'] ?? '');
                    $post['excerpt'] = trim($post['excerpt'] ?? '');
                    $author_names = !empty($data['post_authors']) ? array_column($data['post_authors'], 'name') : [$post['author'] ?? 'Admin'];
                    $site_logo = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : URLROOT . '/public/img/logo.png';
                    
                    // Dynamic Social URLs from Database
                    $social_urls = [];
                    try {
                        $db = \Config\Database::pdoConnect();
                        $social_links_stmt = $db ? $db->query("SELECT url FROM social_links ORDER BY order_index ASC, id ASC") : null;
                        if ($social_links_stmt) {
                            $social_urls = $social_links_stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];
                        }
                    } catch (\Throwable $e) {
                        $social_urls = [];
                    }
                    
                    $fullUrl = URLROOT . '/' . ($post['slug'] ?? '');
                    
                    $orgEntity = [
                        "@type" => "Organization",
                        "@id" => URLROOT . "/#organization",
                        "name" => $site_name,
                        "url" => URLROOT . "/",
                        "logo" => [
                            "@type" => "ImageObject",
                            "url" => $site_logo
                        ]
                    ];
                    if (!empty($social_urls)) {
                        $orgEntity["sameAs"] = $social_urls;
                    }
                    
                    $websiteEntity = [
                        "@type" => "WebSite",
                        "@id" => URLROOT . "/#website",
                        "name" => $site_name,
                        "url" => URLROOT . "/",
                        "publisher" => [
                            "@id" => URLROOT . "/#organization"
                        ]
                    ];
                    
                    $webpageEntity = [
                        "@type" => "WebPage",
                        "@id" => $fullUrl . "#webpage",
                        "url" => $fullUrl,
                        "name" => $post['title'],
                        "isPartOf" => [
                            "@id" => URLROOT . "/#website"
                        ],
                        "inLanguage" => "bn-BD"
                    ];
                    
                    // Breadcrumb list
                    $catName = 'Blog';
                    if (!empty($post['category_id'])) {
                        $cat_stmt = $db->prepare("SELECT name FROM categories WHERE id = ? LIMIT 1");
                        $cat_stmt->execute([$post['category_id']]);
                        $cat_res = $cat_stmt->fetch(\PDO::FETCH_ASSOC);
                        if ($cat_res) {
                            $catName = $cat_res['name'];
                        }
                    }
                    $breadcrumbEntity = [
                        "@type" => "BreadcrumbList",
                        "@id" => $fullUrl . "#breadcrumb",
                        "itemListElement" => [
                            [
                                "@type" => "ListItem",
                                "position" => 1,
                                "name" => "Home",
                                "item" => URLROOT
                            ],
                            [
                                "@type" => "ListItem",
                                "position" => 2,
                                "name" => $catName,
                                "item" => URLROOT . "/blog"
                            ],
                            [
                                "@type" => "ListItem",
                                "position" => 3,
                                "name" => $post['title'],
                                "item" => $fullUrl
                            ]
                        ]
                    ];
                    
                    $graph = [$orgEntity, $websiteEntity, $webpageEntity, $breadcrumbEntity];
                    
                    // wordCount calculation
                    $clean_content = strip_tags($post['content'] ?? '');
                    $words = preg_split('/\s+/u', trim($clean_content));
                    $word_count = !empty($words[0]) ? count($words) : 0;
                    
                    switch ($type) {
                        case 'BlogPosting':
                        case 'Article':
                        case 'NewsArticle':
                            $articleEntity = [
                                "@type" => $type,
                                "@id" => $fullUrl . "#article",
                                "isPartOf" => [
                                    "@id" => $fullUrl . "#webpage"
                                ],
                                "headline" => $post['title'],
                                "description" => !empty($post['excerpt']) ? $post['excerpt'] : mb_substr($clean_content, 0, 160, 'UTF-8'),
                                "inLanguage" => "bn-BD",
                                "mainEntityOfPage" => [
                                    "@id" => $fullUrl . "#webpage"
                                ],
                                "url" => $fullUrl,
                                "wordCount" => $word_count,
                                "datePublished" => $post['created_at'],
                                "dateModified" => $post['created_at'],
                                "author" => array_map(function($name) {
                                    $clean = trim(explode('(', $name)[0]);
                                    $slug = str_replace([' ', '(', ')'], '-', mb_strtolower($clean, 'UTF-8'));
                                    $slug = preg_replace('/-+/', '-', $slug);
                                    $slug = trim($slug, '-');
                                    return [
                                        "@type" => "Person",
                                        "@id" => URLROOT . "/authors/" . $slug,
                                        "name" => $clean,
                                        "url" => URLROOT . "/authors/" . $slug
                                    ];
                                }, $author_names),
                                "publisher" => [
                                    "@id" => URLROOT . "/#organization"
                                ]
                            ];
                            
                            if (!empty($post['featured_image'])) {
                                $imgUrl = (strpos($post['featured_image'], 'http') === 0) ? $post['featured_image'] : URLROOT . '/public/img/' . basename($post['featured_image']);
                                $articleEntity["image"] = [
                                    "@type" => "ImageObject",
                                    "url" => $imgUrl,
                                    "width" => 1200,
                                    "height" => 630
                                ];
                            }
                            
                            if (!empty($fields['keywords'])) {
                                $articleEntity["keywords"] = array_map('trim', explode(',', $fields['keywords']));
                            }
                            if (!empty($fields['articleSection'])) {
                                $articleEntity["articleSection"] = $fields['articleSection'];
                            }
                            
                            $graph[] = $articleEntity;
                            
                            if (!empty($fields['enableFAQ']) && !empty($fields['faq_items'])) {
                                $faqEntity = [
                                    "@type" => "FAQPage",
                                    "@id" => $fullUrl . "#faq",
                                    "isPartOf" => [
                                        "@id" => $fullUrl . "#webpage"
                                    ],
                                    "mainEntity" => array_map(function($faq) {
                                        return [
                                            "@type" => "Question",
                                            "name" => $faq['question'],
                                            "acceptedAnswer" => [
                                                "@type" => "Answer",
                                                "text" => $faq['answer']
                                            ]
                                        ];
                                    }, $fields['faq_items'])
                                ];
                                $graph[] = $faqEntity;
                            }
                            
                            if (!empty($fields['enableVideo']) && !empty($fields['videoUrl'])) {
                                $videoEntity = [
                                    "@type" => "VideoObject",
                                    "@id" => $fullUrl . "#video",
                                    "isPartOf" => [
                                        "@id" => $fullUrl . "#webpage"
                                    ],
                                    "name" => $post['title'],
                                    "description" => $articleEntity["description"],
                                    "contentUrl" => $fields['videoUrl'],
                                    "thumbnailUrl" => !empty($fields['videoThumbnail']) ? $fields['videoThumbnail'] : $site_logo,
                                    "uploadDate" => $post['created_at']
                                ];
                                $graph[] = $videoEntity;
                            }
                            break;
                            
                        case 'FAQPage':
                            if (!empty($fields['faq_items'])) {
                                $faqEntity = [
                                    "@type" => "FAQPage",
                                    "@id" => $fullUrl . "#faq",
                                    "isPartOf" => [
                                        "@id" => $fullUrl . "#webpage"
                                    ],
                                    "mainEntity" => array_map(function($faq) {
                                        return [
                                            "@type" => "Question",
                                            "name" => $faq['question'],
                                            "acceptedAnswer" => [
                                                "@type" => "Answer",
                                                "text" => $faq['answer']
                                            ]
                                        ];
                                    }, $fields['faq_items'])
                                ];
                                $graph[] = $faqEntity;
                            }
                            break;
                            
                        case 'Product':
                            $productEntity = [
                                "@type" => "Product",
                                "@id" => $fullUrl . "#product",
                                "name" => !empty($fields['name']) ? $fields['name'] : $post['title'],
                                "brand" => [
                                    "@type" => "Brand",
                                    "name" => $fields['brand'] ?? ''
                                ],
                                "offers" => [
                                    "@type" => "Offer",
                                    "price" => $fields['price'] ?? '0.00',
                                    "priceCurrency" => $fields['priceCurrency'] ?? 'BDT',
                                    "availability" => "https://schema.org/" . ($fields['availability'] ?? 'InStock')
                                ]
                            ];
                            if (!empty($post['featured_image'])) {
                                $productEntity["image"] = (strpos($post['featured_image'], 'http') === 0) ? $post['featured_image'] : URLROOT . '/public/img/' . basename($post['featured_image']);
                            }
                            if (!empty($fields['sku'])) $productEntity["sku"] = $fields['sku'];
                            if (!empty($fields['ratingValue']) && !empty($fields['reviewCount'])) {
                                $productEntity["aggregateRating"] = [
                                    "@type" => "AggregateRating",
                                    "ratingValue" => $fields['ratingValue'],
                                    "reviewCount" => $fields['reviewCount'],
                                    "bestRating" => "5",
                                    "worstRating" => "0"
                                ];
                            }
                            $graph[] = $productEntity;
                            break;
                            
                        case 'Review':
                            $reviewEntity = [
                                "@type" => "Review",
                                "@id" => $fullUrl . "#review",
                                "itemReviewed" => [
                                    "@type" => "Thing",
                                    "name" => $fields['itemName'] ?? $post['title']
                                ],
                                "reviewRating" => [
                                    "@type" => "Rating",
                                    "ratingValue" => $fields['ratingValue'] ?? '5',
                                    "bestRating" => $fields['bestRating'] ?? '5',
                                    "worstRating" => $fields['worstRating'] ?? '1'
                                ],
                                "author" => [
                                    "@type" => "Person",
                                    "@id" => URLROOT . "/authors/" . trim(preg_replace('/-+/', '-', str_replace([' ', '(', ')'], '-', mb_strtolower($fields['author'] ?? $author_names[0], 'UTF-8'))), '-'),
                                    "name" => $fields['author'] ?? $author_names[0],
                                    "url" => URLROOT . "/authors/" . trim(preg_replace('/-+/', '-', str_replace([' ', '(', ')'], '-', mb_strtolower($fields['author'] ?? $author_names[0], 'UTF-8'))), '-')
                                ],
                                "publisher" => [
                                    "@id" => URLROOT . "/#organization"
                                ]
                            ];
                            $graph[] = $reviewEntity;
                            break;
                            
                        case 'VideoObject':
                            $videoEntity = [
                                "@type" => "VideoObject",
                                "@id" => $fullUrl . "#video",
                                "name" => $post['title'],
                                "description" => mb_substr($clean_content, 0, 160, 'UTF-8'),
                                "contentUrl" => $fields['contentUrl'] ?? '',
                                "thumbnailUrl" => $fields['thumbnailUrl'] ?? $site_logo,
                                "uploadDate" => $fields['uploadDate'] ?? $post['created_at']
                            ];
                            if (!empty($fields['duration'])) $videoEntity["duration"] = $fields['duration'];
                            $graph[] = $videoEntity;
                            break;
                            
                        case 'Event':
                            $eventEntity = [
                                "@type" => "Event",
                                "@id" => $fullUrl . "#event",
                                "name" => $fields['name'] ?? $post['title'],
                                "startDate" => $fields['startDate'] ?? $post['created_at'],
                                "endDate" => $fields['endDate'] ?? $post['created_at'],
                                "location" => !empty($fields['location']) ? ( (strpos($fields['location'], 'http') === 0) ? [
                                    "@type" => "VirtualLocation",
                                    "url" => $fields['location']
                                ] : [
                                    "@type" => "Place",
                                    "name" => $fields['location'],
                                    "address" => $fields['location']
                                ] ) : [ "@type" => "Place", "name" => "Online" ]
                            ];
                            if (!empty($fields['organizer'])) {
                                $eventEntity["organizer"] = [
                                    "@type" => "Organization",
                                    "name" => $fields['organizer']
                                ];
                            }
                            $graph[] = $eventEntity;
                            break;
                            
                        case 'Recipe':
                            $recipeEntity = [
                                "@type" => "Recipe",
                                "@id" => $fullUrl . "#recipe",
                                "name" => $post['title'],
                                "recipeCuisine" => $fields['recipeCuisine'] ?? ''
                            ];
                            if (!empty($post['featured_image'])) {
                                $recipeEntity["image"] = (strpos($post['featured_image'], 'http') === 0) ? $post['featured_image'] : URLROOT . '/public/img/' . basename($post['featured_image']);
                            }
                            if (!empty($fields['prepTime'])) $recipeEntity["prepTime"] = $fields['prepTime'];
                            if (!empty($fields['cookTime'])) $recipeEntity["cookTime"] = $fields['cookTime'];
                            if (!empty($fields['totalTime'])) $recipeEntity["totalTime"] = $fields['totalTime'];
                            if (!empty($fields['calories'])) {
                                $recipeEntity["nutrition"] = [
                                    "@type" => "NutritionInformation",
                                    "calories" => $fields['calories']
                                ];
                            }
                            if (!empty($fields['recipeIngredient'])) {
                                $recipeEntity["recipeIngredient"] = array_filter(array_map('trim', explode("\n", $fields['recipeIngredient'])));
                            }
                            if (!empty($fields['recipeInstructions'])) {
                                $recipeEntity["recipeInstructions"] = array_map(function($inst) {
                                    return ["@type" => "HowToStep", "text" => trim($inst)];
                                }, array_filter(array_map('trim', explode("\n", $fields['recipeInstructions']))));
                            }
                            $graph[] = $recipeEntity;
                            break;
                            
                        case 'Person':
                            $personEntity = [
                                "@type" => "Person",
                                "@id" => $fullUrl . "#person",
                                "name" => $fields['name'] ?? $author_names[0]
                            ];
                            if (!empty($fields['jobTitle'])) $personEntity["jobTitle"] = $fields['jobTitle'];
                            if (!empty($fields['image'])) $personEntity["image"] = $fields['image'];
                            if (!empty($fields['sameAs'])) {
                                $personEntity["sameAs"] = array_filter(array_map('trim', explode("\n", $fields['sameAs'])));
                            }
                            $graph[] = $personEntity;
                            break;
                            
                        case 'Organization':
                            $organizationEntity = [
                                "@type" => "Organization",
                                "@id" => $fullUrl . "#organization",
                                "name" => $fields['name'] ?? $site_name,
                                "logo" => $fields['logo'] ?? $site_logo,
                                "url" => $fields['url'] ?? URLROOT
                            ];
                            if (!empty($fields['sameAs'])) {
                                $organizationEntity["sameAs"] = array_filter(array_map('trim', explode("\n", $fields['sameAs'])));
                            }
                            $graph[] = $organizationEntity;
                            break;
                    }
                    
                    $wrapper = [
                        "@context" => "https://schema.org",
                        "@graph" => $graph
                    ];
                    
                    $schema_json = json_encode($wrapper, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            }
        }
        
        // Default / Fallback Schema if no custom schema configured
        if (!$has_custom_schema) {
            $author_names = !empty($data['post_authors']) ? array_column($data['post_authors'], 'name') : [$post['author'] ?? 'Admin'];
            $site_logo = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : URLROOT . '/public/img/logo.png';
            $fallback = [
                "@context" => "https://schema.org",
                "@type" => "BlogPosting",
                "headline" => $post['title'],
                "description" => !empty($post['excerpt']) ? $post['excerpt'] : mb_substr(strip_tags($post['content']), 0, 160, 'UTF-8'),
                "datePublished" => $post['created_at'],
                "dateModified" => $post['created_at'],
                "author" => array_map(function($name) {
                    return ["@type" => "Person", "name" => $name];
                }, $author_names),
                "publisher" => [
                    "@type" => "Organization",
                    "name" => $site_name,
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => $site_logo
                    ]
                ],
                "mainEntityOfPage" => [
                    "@type" => "WebPage",
                    "@id" => URLROOT . '/' . $post['slug']
                ]
            ];
            if (!empty($post['featured_image'])) {
                $fallback["image"] = (strpos($post['featured_image'], 'http') === 0) ? $post['featured_image'] : URLROOT . '/public/img/' . basename($post['featured_image']);
            }
            $schema_json = json_encode($fallback, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    } elseif (isset($data['question']) && !empty($data['question'])) {
        // QAPage Schema for Google Rich Results
        $q = $data['question'];
        $clean_question = trim(preg_replace('/\s+/u', ' ', strip_tags($q['question'])));
        $clean_details = !empty($q['details']) ? trim(preg_replace('/\s+/u', ' ', strip_tags($q['details']))) : $clean_question;
        
        $answers_schema = [];
        if (!empty($data['answers'])) {
            foreach ($data['answers'] as $idx => $ans) {
                $answerEntity = [
                    "@type" => "Answer",
                    "text" => trim(preg_replace('/\s+/u', ' ', strip_tags($ans['answer'] ?? ''))),
                    "dateCreated" => !empty($ans['created_at']) ? date('c', strtotime($ans['created_at'])) : date('c'),
                    "author" => [
                        "@type" => "Person",
                        "name" => !empty($ans['name']) ? $ans['name'] : $site_name
                    ]
                ];
                if ($idx === 0) {
                    $answerEntity["upvoteCount"] = 1;
                }
                $answers_schema[] = $answerEntity;
            }
        }
        
        $qaSchema = [
            "@context" => "https://schema.org",
            "@type" => "QAPage",
            "mainEntity" => [
                "@type" => "Question",
                "name" => $clean_question,
                "text" => $clean_details,
                "answerCount" => count($answers_schema),
                "dateCreated" => !empty($q['created_at']) ? date('c', strtotime($q['created_at'])) : date('c'),
                "author" => [
                    "@type" => "Person",
                    "name" => !empty($q['name']) ? $q['name'] : "Anonymous"
                ]
            ]
        ];
        if (!empty($answers_schema)) {
            $qaSchema["mainEntity"]["suggestedAnswer"] = $answers_schema;
        }
        $schema_json = json_encode($qaSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        // Global Website Schema with Organization for non-post pages
        $schema_json = json_encode([
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "WebSite",
                    "@id" => URLROOT . "/#website",
                    "name" => $site_name,
                    "url" => URLROOT . "/",
                    "description" => $meta_description,
                    "publisher" => [
                        "@id" => URLROOT . "/#organization"
                    ],
                    "potentialAction" => [
                        "@type" => "SearchAction",
                        "target" => [
                            "@type" => "EntryPoint",
                            "urlTemplate" => URLROOT . "/blog?search={search_term_string}"
                        ],
                        "query-input" => "required name=search_term_string"
                    ]
                ],
                [
                    "@type" => "Organization",
                    "@id" => URLROOT . "/#organization",
                    "name" => $site_name,
                    "url" => URLROOT . "/",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : URLROOT . '/public/img/logo.png'
                    ]
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    ?>

    <?php if (!empty($schema_json)): ?>
        <!-- SEO Schema Markup -->
        <script type="application/ld+json">
        <?= $schema_json ?>
        </script>
    <?php endif; ?>
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eff6ff;
            --primary-glow: rgba(37, 99, 235, 0.4);
            --gold: #FFC81E;
            --gold-glow: rgba(255, 200, 30, 0.3);
            --bg-dark: #020617;
            --bg-light: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Noto Sans Bengali', 'Hind Siliguri', 'Outfit', sans-serif;
        }

        .fa, .fas, .far, .fal, .fad, .fa-solid, .fa-regular {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
        }
        .fab, .fa-brands {
            font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands", "FontAwesome" !important;
        }

        html, body {
            overflow-x: clip;
            width: 100%;
            background-color: #ffffff !important;
            background-image: none !important;
            background: #ffffff !important;
        }

        body {
            background-color: #ffffff !important;
            color: var(--text-main);
            background-image: none !important;
            background: #ffffff !important;
        }
        #islamicCanvas, .crescent-orb-glow, .sky-aura {
            display: none !important;
        }

        
        body.islamic-page-bg {
            background-color: #022c22 !important;
            background: #022c22 !important;
        }
        body.islamic-page-bg .header-wrapper {
            background: #022c22;
            margin-top: 0;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        body.posts-page, body.blog-page, body.light-bg {
            background-color: #ffffff !important;
            background-image: none !important;
            background: #ffffff !important;
            color: #1e293b !important;
        }

        .container {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 15px;
            box-sizing: border-box;
        }

        .container-header {
            max-width: 1440px !important;
            padding: 0 15px !important;
        }

        /* Modern Navigation */
        .header-wrapper {
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin-top: 20px;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 8px 40px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1), 0 3px 10px rgba(11, 124, 77, 0.12);
            position: relative;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo i {
            background: var(--primary);
            color: white;
            width: 45px; height: 45px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            box-shadow: 0 8px 15px var(--primary-glow);
        }

        .nav-links {
            flex: 1;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 15px;
            list-style: none;
            margin-left: 30px;
        }

        .nav-links a {
            font-weight: 600;
            color: var(--text-main);
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
            position: relative;
            white-space: nowrap;
        }

        @media (max-width: 1400px) {
            .container-header {
                padding: 0 20px !important;
            }
            .glass-nav {
                padding: 8px 20px !important;
            }
            .nav-links {
                gap: 12px !important;
                margin-left: 25px !important;
            }
            .nav-links a {
                font-size: 15px !important;
            }
        }

        @media (max-width: 1200px) {
            .nav-links {
                gap: 8px !important;
                margin-left: 15px !important;
            }
            .nav-links a {
                font-size: 14px !important;
            }
        }

        .nav-links a::after {
            content: '';
            position: absolute; bottom: -5px; left: 0; width: 0; height: 2px;
            background: var(--primary); transition: 0.3s;
        }

        .nav-links a:hover::after { width: 100%; }

        /* Highlighted Button Style for All Categories (সবগুলো নিবন্ধ) */
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 0 40px;
            display: flex;
            justify-content: flex-start;
            align-items: stretch;
            min-height: 66px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1), 0 3px 10px rgba(11, 124, 77, 0.12);
            position: relative;
        }

        .nav-links {
            flex: 1;
            display: flex;
            justify-content: flex-start;
            align-items: stretch;
            gap: 15px;
            list-style: none;
            margin-left: 30px;
        }

        .nav-links > li {
            display: flex;
            align-items: center;
        }

        .nav-item-megamenu {
            display: flex;
            align-items: stretch;
        }
        .btn-nav-categories {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            padding: 0 24px !important;
            border-radius: 0 !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            height: 100% !important;
            min-height: 66px !important;
            margin: 0 !important;
            box-shadow: none !important;
            border-top: none !important;
            border-bottom: none !important;
            border-left: 1px solid #e2e8f0 !important;
            border-right: 1px solid #e2e8f0 !important;
            transition: all 0.25s ease !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
        }
        .btn-nav-categories::after {
            display: none !important;
        }
        .btn-nav-categories:hover,
        .nav-item-megamenu.open .btn-nav-categories {
            background: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
            color: #0b7c4d !important;
        }
        .btn-nav-categories i.btn-cat-icon {
            font-size: 14px;
            color: #0b7c4d;
        }
        .btn-nav-categories .megamenu-toggle-arrow,
        .btn-nav-categories i.fa-chevron-down {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            margin-left: 4px;
            color: #64748b;
            transition: transform 0.25s ease;
        }
        .btn-nav-categories .megamenu-toggle-arrow i {
            font-size: 11px;
            color: inherit;
            transition: transform 0.25s ease;
        }
        .nav-item-megamenu.open .btn-nav-categories i.fa-chevron-down,
        .nav-item-megamenu.open .btn-nav-categories .megamenu-toggle-arrow i {
            color: #0b7c4d;
            transform: rotate(180deg);
        }

        .btn-premium {
            background: var(--primary);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 20px var(--primary-glow);
            transition: 0.3s;
            font-size: 1rem;
        }

        .mobile-social-dropdown {
            display: none;
        }

        .mobile-topmenu-dropdown {
            display: none;
        }


        /* Top Menu Bar Styles */
        .top-menu-bar {
            background: #022c22;
            padding: 10px 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.25);
        }

        .top-menu-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 15px;
        }

        .top-date-time {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Hind Siliguri', sans-serif;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }

        .top-menu-links {
            display: flex;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
            white-space: nowrap;
        }

        .top-menu-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Hind Siliguri', sans-serif;
            transition: all 0.2s ease;
        }

        .top-menu-links a:hover {
            color: #ffffff;
            opacity: 0.85;
        }

        .top-menu-right {
            display: flex;
            gap: 18px;
            justify-content: flex-end;
            align-items: center;
            white-space: nowrap;
        }

        .topbar-ecommerce-links {
            display: flex;
            gap: 15px;
            align-items: center;
            white-space: nowrap;
        }

        @media (max-width: 1440px) and (min-width: 1201px) {
            .top-date-time {
                font-size: 0.85rem;
                gap: 8px;
            }
            .top-menu-links {
                gap: 12px;
            }
            .top-menu-links a {
                font-size: 0.85rem;
            }
            .top-menu-right {
                gap: 10px;
            }
            .topbar-social-links {
                gap: 10px !important;
            }
            .topbar-ecommerce-links {
                gap: 10px;
            }
            .topbar-ecommerce-links a {
                font-size: 0.85rem !important;
            }
        }

        /* Mega Menu Core Styles */

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-item-megamenu, .nav-item-dropdown {
            position: static; /* Let dropdown span relative to .glass-nav */
        }

        /* Services Megamenu Dropdown styling matching the dark emerald green theme */
        .megamenu-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #043e2f;
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            padding: 15px 24px 24px 24px; /* top padding bridges the gap */
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0s linear 0.25s;
        }

        /* Trigger megamenu on hover - controlled by JS */
        .nav-item-megamenu.open .megamenu-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0s linear 0s;
        }

        .megamenu-inner {
            display: flex;
            min-height: 400px;
        }

        /* Sidebar Tabs styling */
        .megamenu-sidebar-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 330px;
            min-width: 330px;
            border-right: 1px solid rgba(16, 185, 129, 0.15);
        }

        .megamenu-sidebar {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 15px 0 0;
            max-height: 450px;
            overflow-y: auto;
        }

        .megamenu-sidebar::after {
            content: '';
            display: block;
            height: 50px;
            min-height: 50px;
            flex-shrink: 0;
        }

        .megamenu-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .megamenu-sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .megamenu-sidebar::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 10px;
        }
        .megamenu-sidebar::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }

        .megamenu-scroll-indicator {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #10b981;
            color: #ffffff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 10;
            font-family: 'Hind Siliguri', sans-serif;
            animation: bounceIndicator 1.5s infinite;
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .megamenu-scroll-indicator.visible {
            opacity: 1;
        }

        @keyframes bounceIndicator {
            0%, 100% { transform: translate(-50%, 0); }
            50% { transform: translate(-50%, -4px); }
        }

        .mega-tab-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.2px;
            line-height: 1.4;
            font-family: 'Hind Siliguri', sans-serif;
            border-left: 3px solid transparent;
        }

        .mega-tab-btn-title {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mega-tab-btn i.mega-tab-icon {
            font-size: 14px;
            width: 18px;
            text-align: center;
            color: #34d399;
            flex-shrink: 0;
        }

        .mega-tab-btn:hover {
            color: #ffffff;
            background: rgba(16, 185, 129, 0.15);
        }

        .mega-tab-btn.active {
            color: #ffffff;
            border-left: 3px solid #10b981;
            background: rgba(16, 185, 129, 0.25);
        }

        .mega-tab-btn span.tab-text {
            border-bottom: 2px solid transparent;
            transition: border-color 0.2s ease;
            padding-bottom: 1px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mega-tab-btn:hover span.tab-text,
        .mega-tab-btn.active span.tab-text {
            border-bottom-color: #10b981;
        }

        .mega-cat-group {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .mega-cat-expander {
            margin-left: 6px;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            color: #94a3b8;
            background: transparent;
            font-size: 11px;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
            flex-shrink: 0;
        }
        .mega-cat-expander:hover {
            background: rgba(16, 185, 129, 0.25);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.3);
        }
        .mega-cat-group.expanded .mega-cat-expander {
            color: #34d399;
        }
        .mega-cat-group.expanded .mega-cat-expander i {
            transform: rotate(180deg);
        }
        .mega-subcat-list {
            display: none;
            flex-direction: column;
            gap: 2px;
            padding: 4px 0 6px 36px;
            border-left: 2px solid rgba(16, 185, 129, 0.2);
            margin: 2px 0 6px 16px;
            animation: fadeInSubcats 0.2s ease-in-out;
        }
        .mega-cat-group.expanded .mega-subcat-list {
            display: flex;
        }
        @keyframes fadeInSubcats {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .mega-subcat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 6px;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Hind Siliguri', sans-serif;
            transition: all 0.2s ease;
        }
        .mega-subcat-item:hover {
            color: #ffffff !important;
            background: rgba(16, 185, 129, 0.25);
            transform: translateX(3px);
        }
        .mega-subcat-item.active {
            color: #ffffff !important;
            background: rgba(16, 185, 129, 0.35) !important;
            font-weight: 700;
            border-left: 3px solid #34d399;
            transform: translateX(3px);
        }
        .mega-subcat-item i {
            font-size: 11px;
            color: #34d399;
        }

        /* Content pane styling */
        .megamenu-content {
            flex: 1;
            padding-left: 30px;
            max-height: 480px;
            overflow-y: auto;
        }

        .mega-tab-pane {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .mega-tab-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pane-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.3px;
            font-family: 'Hind Siliguri', sans-serif;
        }

        .pane-title i {
            font-size: 20px;
            color: #34d399;
        }

        /* Grid layout for service items */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }

        .service-card {
            background: rgba(2, 44, 34, 0.7);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 14px;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 14px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .service-card i {
            color: #34d399;
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .service-card span {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5;
            font-family: 'Hind Siliguri', sans-serif;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
            white-space: normal;
        }

        .service-card:hover {
            background: rgba(16, 185, 129, 0.25);
            border-color: #10b981;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }



        .service-card:hover i {
            transform: scale(1.15);
        }

        /* Standard Dropdown Styling */
        .nav-item-dropdown {
            position: relative; /* Scope standard dropdown locally */
        }

        .submenu-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(5px);
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            width: 220px;
            list-style: none;
            padding: 8px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0s linear 0.2s;
            z-index: 9999;
        }

        /* Submenu - controlled by JS */
        .nav-item-dropdown.open .submenu-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0s linear 0s;
        }

        .submenu-dropdown li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: var(--text-main);
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.2s;
            text-decoration: none;
        }

        .submenu-dropdown li a::after {
            display: none; /* Disable standard nav underline transition */
        }

        .submenu-dropdown li a:hover {
            background: rgba(0, 107, 67, 0.05);
            color: var(--primary);
            padding-left: 18px;
        }

        /* Mobile Toggle Styles */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
            z-index: 10001;
            transition: color 0.3s ease;
        }

        .mobile-nav-toggle:hover {
            color: var(--primary);
        }
        
        /* Mobile Menu Media Queries */
        @media (max-width: 1200px) {
            .top-menu-flex {
                display: flex !important;
                flex-direction: column !important;
                gap: 12px !important;
                align-items: center !important;
                text-align: center !important;
                padding: 10px 0 !important;
            }
            
            .top-menu-flex > div:first-child {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 8px !important;
                font-size: 0.8rem !important; /* Slightly smaller font to prevent wrap */
                white-space: nowrap !important;
            }
            
            .top-menu-flex > div.top-date-time {
                display: none !important;
            }
            
            .top-menu-flex > div:last-child {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 10px !important;
                width: 100% !important;
            }

            .top-menu-links {
                display: none !important; /* Hide secondary links on mobile */
            }
            
            .top-menu-bar {
                padding: 12px 0;
            }

            .topbar-social-links {
                display: none !important;
            }
            
            .mobile-social-dropdown {
                display: inline-block !important;
                position: relative;
            }
            
            .mobile-social-btn {
                background: rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 0.8);
                border: none;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: 0.2s;
            }
            
            .mobile-social-btn:hover, .mobile-social-dropdown.active .mobile-social-btn {
                background: #ffffff;
                color: var(--bg-dark);
            }
            
            .mobile-social-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: #043e2f;
                border: 1px solid rgba(16, 185, 129, 0.25);
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.4);
                padding: 8px;
                display: none;
                flex-direction: column;
                gap: 4px;
                z-index: 10002;
                min-width: 150px;
                margin-top: 8px;
            }
            
            .mobile-social-dropdown.active .mobile-social-menu {
                display: flex;
            }
            
            .mobile-social-menu a {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 8px 12px;
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                font-size: 0.85rem;
                font-weight: 600;
                border-radius: 6px;
                transition: 0.2s;
                white-space: nowrap;
            }
            
            .mobile-social-menu a:hover {
                background: rgba(255, 255, 255, 0.05);
            }

            .mobile-topmenu-dropdown {
                display: inline-block !important;
                position: relative;
            }
            .mobile-topmenu-btn {
                background: rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 0.8);
                border: none;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: 0.2s;
            }
            .mobile-topmenu-btn:hover, .mobile-topmenu-dropdown.active .mobile-topmenu-btn {
                background: #ffffff;
                color: var(--bg-dark);
            }
            .mobile-topmenu-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: #043e2f;
                border: 1px solid rgba(16, 185, 129, 0.25);
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.4);
                padding: 8px;
                display: none;
                flex-direction: column;
                gap: 4px;
                z-index: 10002;
                min-width: 160px;
                margin-top: 8px;
            }
            .mobile-topmenu-dropdown.active .mobile-topmenu-menu {
                display: flex;
            }
            .mobile-topmenu-menu a {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 8px 12px;
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                font-size: 0.85rem;
                font-weight: 600;
                border-radius: 6px;
                transition: 0.2s;
                white-space: nowrap;
            }
            .mobile-topmenu-menu a:hover {
                background: rgba(255, 255, 255, 0.05);
            }

            .header-wrapper {
                top: 0 !important;
                margin-top: 0 !important;
                width: 100% !important;
            }

            .header-wrapper > .container {
                padding: 0 !important;
                max-width: 100% !important;
            }

            .glass-nav {
                justify-content: space-between !important;
                padding: 12px 20px !important;
                border-radius: 0 !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-bottom: 1px solid #e2e8f0 !important;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12), 0 3px 10px rgba(11, 124, 77, 0.1) !important;
                margin-top: 0 !important;
                width: 100% !important;
            }

            .mobile-nav-toggle {
                display: block; /* Show hamburger button */
            }

            .mobile-search-trigger {
                display: none !important;
            }

            /* Move search bar to the top of mobile menu */
            .nav-search-item {
                order: -1 !important;
                margin-left: 0 !important;
                padding: 12px 16px !important;
                border-bottom: 1px solid #e2e8f0 !important;
                background: #f8fafc !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .nav-search-item form#header-search-form {
                width: 100% !important;
                height: 44px !important;
            }

            .nav-search-item #header-search-input {
                width: 100% !important;
                opacity: 1 !important;
                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 50px !important;
                padding: 10px 45px 10px 18px !important;
                font-size: 15px !important;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            }

            .nav-search-item #header-search-btn {
                position: absolute !important;
                right: 4px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 36px !important;
                height: 36px !important;
            }

            .nav-search-item #header-search-clear-btn {
                right: 44px !important;
            }

            /* Hide desktop search button inside nav-links on mobile */
            .nav-links #search-popup-trigger {
                display: none !important;
            }

            .nav-links {
                display: none; /* Hide default nav links */
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #ffffff;
                border-top: 1px solid #e2e8f0;
                border-bottom: 1px solid #e2e8f0;
                flex-direction: column;
                align-items: stretch;
                padding: 0;
                gap: 0;
                z-index: 9999;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
                max-height: calc(100vh - 80px);
                overflow-y: auto;
                margin-left: 0 !important;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-item-megamenu {
                display: block !important;
                width: 100% !important;
            }

            .nav-item-megamenu .btn-nav-categories {
                width: 100% !important;
                min-height: auto !important;
                height: auto !important;
                padding: 13px 20px !important;
                margin: 0 !important;
                border: none !important;
                border-bottom: 1px solid #f1f5f9 !important;
                border-radius: 0 !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                background: #f8fafc !important;
                color: #0f172a !important;
                font-size: 16px !important;
                font-weight: 700 !important;
                box-shadow: none !important;
                box-sizing: border-box !important;
            }

            .nav-item-megamenu .btn-nav-categories .btn-cat-main {
                display: inline-flex !important;
                align-items: center !important;
                gap: 8px !important;
                flex: 1 !important;
                min-width: 0 !important;
            }

            .nav-item-megamenu .btn-nav-categories i.btn-cat-icon {
                color: #0b7c4d !important;
                font-size: 16px !important;
                margin-right: 4px !important;
            }

            .nav-item-megamenu .megamenu-toggle-arrow,
            .nav-item-dropdown .megamenu-toggle-arrow {
                width: 32px !important;
                height: 32px !important;
                border-radius: 6px !important;
                background: rgba(11, 124, 77, 0.08) !important;
                color: #0b7c4d !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin-left: auto !important;
                cursor: pointer !important;
                flex-shrink: 0 !important;
            }

            .nav-item-megamenu .megamenu-toggle-arrow i,
            .nav-item-dropdown .megamenu-toggle-arrow i {
                margin: 0 !important;
                color: #0b7c4d !important;
                font-size: 12px !important;
                transition: transform 0.25s ease !important;
            }

            .nav-item-megamenu.open .megamenu-toggle-arrow i,
            .nav-item-dropdown.open .megamenu-toggle-arrow i {
                transform: rotate(180deg) !important;
            }

            .nav-item-megamenu .btn-nav-categories i.fa-chevron-down {
                margin-left: auto !important;
                color: #64748b !important;
            }

            .nav-links > li {
                border-bottom: 1px solid #f1f5f9;
                width: 100%;
                list-style: none;
                display: block !important;
            }

            .nav-links a, .nav-links .megamenu-trigger, .nav-links .dropdown-trigger {
                color: #0f172a !important;
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px 24px;
                font-size: 16px;
                font-weight: 700;
                text-decoration: none;
                transition: background 0.2s;
                cursor: pointer;
            }

            .nav-links a:hover, .nav-links .megamenu-trigger:hover, .nav-links .dropdown-trigger:hover {
                background: #f8fafc;
                color: var(--primary) !important;
            }

            .nav-links a::after, .nav-links .megamenu-trigger::after, .nav-links .dropdown-trigger::after {
                display: none !important;
            }

            /* Submenu details */
            .megamenu-dropdown, .submenu-dropdown {
                position: static !important;
                width: 100% !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                box-shadow: none !important;
                background: #f8fafc !important;
                border: none !important;
                border-top: 1px solid #f1f5f9 !important;
                border-radius: 0 !important;
                padding: 0 !important;
                margin-top: 0 !important;
                display: none; /* Toggle via active class */
            }

            .submenu-dropdown li {
                list-style: none;
                border-bottom: 1px solid #f1f5f9;
            }
            
            .submenu-dropdown li:last-child {
                border-bottom: none;
            }

            .submenu-dropdown li a {
                padding: 14px 24px 14px 40px !important;
                font-weight: 600 !important;
                color: #334155 !important;
                background: #f8fafc !important;
            }

            .submenu-dropdown li a:hover {
                background: #f1f5f9 !important;
                color: var(--primary) !important;
            }

            /* Mega Menu styles adaptation for accordion on mobile */
            .megamenu-inner {
                flex-direction: column !important;
                min-height: auto !important;
                gap: 0 !important;
            }

            .megamenu-sidebar-wrapper {
                width: 100% !important;
                border-right: none !important;
                border-bottom: none !important;
                padding-bottom: 0 !important;
            }

            .megamenu-sidebar {
                padding: 0 !important;
                max-height: none !important;
                gap: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                overflow: visible !important;
            }
            
            .megamenu-sidebar::after {
                display: none !important;
            }

            .megamenu-scroll-indicator {
                display: none !important;
            }

            .mega-cat-group {
                border-bottom: 1px solid #e2e8f0;
                width: 100%;
                background: #f8fafc;
            }

            .mega-tab-btn {
                border-bottom: none !important;
                border-left: none !important;
                padding: 13px 20px 13px 24px !important;
                color: #1e293b !important;
                font-weight: 600 !important;
                background: #f8fafc !important;
                justify-content: space-between !important;
                display: flex !important;
                align-items: center !important;
                border-radius: 0 !important;
                flex-shrink: 0 !important;
            }

            .mega-tab-btn .mega-tab-btn-title {
                color: #1e293b !important;
            }

            .mega-tab-btn .mega-tab-btn-title span {
                color: #1e293b !important;
                font-size: 15px !important;
            }

            .mega-tab-btn i.mega-tab-icon {
                color: #0b7c4d !important;
            }

            .mega-cat-expander {
                width: 32px !important;
                height: 32px !important;
                border-radius: 6px !important;
                background: rgba(11, 124, 77, 0.08) !important;
                color: #0b7c4d !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin-left: auto !important;
            }

            .mega-subcat-list {
                padding: 6px 16px 12px 28px !important;
                margin: 0 !important;
                border-left: 2px solid #0b7c4d !important;
                margin-left: 24px !important;
                margin-bottom: 8px !important;
                background: #f1f5f9 !important;
                border-radius: 0 8px 8px 0 !important;
                gap: 4px !important;
            }

            .mega-subcat-item {
                padding: 8px 12px !important;
                color: #1e293b !important;
                font-size: 14px !important;
                border-radius: 6px !important;
                border: none !important;
                background: transparent !important;
            }

            .mega-subcat-item:hover, .mega-subcat-item:active {
                background: rgba(11, 124, 77, 0.12) !important;
                color: #0b7c4d !important;
            }

            .mega-subcat-item i {
                color: #0b7c4d !important;
            }

            .mega-tab-btn::after {
                content: '\f078'; /* font-awesome chevron-down */
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                font-size: 12px;
                transition: transform 0.2s;
                color: var(--text-muted);
            }

            .mega-tab-btn[data-tab^="post-cat-"]::after {
                display: none !important;
            }

            .mega-tab-btn.active::after {
                transform: rotate(180deg);
            }

            .mega-tab-btn.active {
                background: #f1f5f9 !important;
                border-left: none !important;
                color: var(--primary) !important;
            }

            .mega-tab-pane[id^="pane-post-cat-"] {
                display: none !important;
            }

            .megamenu-content {
                padding-left: 0 !important;
            }

            .mega-tab-pane {
                background: #f1f5f9 !important;
                padding: 10px 24px 20px 48px !important;
            }
            
            .pane-title {
                display: none !important; /* Hide panel title on mobile inside accordion */
            }

            .services-grid {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .service-card {
                background: transparent !important;
                border: none !important;
                padding: 8px 0 !important;
                flex-direction: row !important;
                justify-content: flex-start !important;
                gap: 12px !important;
                text-align: left !important;
                box-shadow: none !important;
                transform: none !important;
                height: auto !important;
            }

            .service-card i {
                font-size: 16px !important;
            }

            .service-card span {
                color: #475569 !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                text-align: left !important;
            }

            .nav-item-megamenu.open .megamenu-dropdown,
            .nav-item-dropdown.open .submenu-dropdown {
                display: block !important;
            }

            .nav-item-megamenu.open > .megamenu-trigger > i,
            .nav-item-dropdown.open > .dropdown-trigger > i {
                transform: rotate(180deg);
            }
        }

        @media (max-width: 450px) {
            .top-menu-flex > div:last-child {
                flex-wrap: nowrap !important;
                justify-content: center !important;
                gap: 8px !important;
            }
            .topbar-account-label {
                display: none !important;
            }
            .topbar-divider {
                display: inline !important;
                margin: 0 4px !important;
                opacity: 0.25 !important;
            }
            .topbar-ecommerce-links {
                gap: 12px !important;
            }
            /* Increase topbar icons size on mobile */
            .topbar-ecommerce-links a i,
            .mobile-social-btn i {
                font-size: 1.15rem !important;
            }
            .top-menu-right a[href*="donate"] {
                padding: 4px 10px !important;
            }
            .top-menu-right a[href*="donate"] i {
                font-size: 1.05rem !important;
            }
        }

        /* Responsive Mobile Layout Fixes for Home, Hadith, & Quran Pages */
        @media (max-width: 991px) {
            /* Container padding adjustments */
            #pageQuranAyahBody, #pageHadithContentCard {
                padding: 16px !important;
                border-radius: 12px !important;
            }
            /* Quran & Hadith Top Controls Banner Responsiveness */
            #pageQuranTitle, #pageHadithTitle {
                font-size: 1.1rem !important;
            }
            /* Stack left sidebar and main reader area on mobile */
            div[style*="calc(100vh - 120px)"] {
                width: 100% !important;
                height: auto !important;
                max-height: 380px !important;
                position: relative !important;
                top: 0 !important;
                margin-bottom: 16px !important;
            }
        }

        @media (max-width: 640px) {
            /* Main workspace layout gaps */
            div[style*="padding: 0 25px"] {
                padding: 0 10px !important;
            }
            div[style*="gap: 24px"] {
                gap: 14px !important;
            }
            /* Top Header Bar Sticky controls on Quran/Hadith page */
            div[style*="position: sticky; top: 0"] {
                padding: 12px 14px !important;
            }
            /* Stack search, reciters, & font zoom controls cleanly */
            div[style*="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;"] {
                width: 100% !important;
                gap: 8px !important;
            }
            div[style*="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;"] > div,
            div[style*="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;"] select {
                flex: 1 1 100% !important;
                width: 100% !important;
            }
            /* Hadith & Quran Cards spacing */
            div[id^="hadith-card-"], div[id^="ayah-card-"] {
                padding: 16px !important;
                border-radius: 12px !important;
                margin-bottom: 14px !important;
            }
            /* Arabic text font sizing for smaller screens */
            div[style*="font-family: 'Amiri'"], div[style*="font-family: 'Traditional Arabic'"] {
                font-size: 1.25rem !important;
                line-height: 2.0 !important;
                padding: 14px !important;
            }
        }

        /* Premium Scroll Reveal Stylesheet - Clean, Smooth & Professional */
        .scope-card-animate {
            opacity: 0;
            transform: scale(0.75);
            transition: opacity 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform, opacity;
        }

        .scope-card-animate.visible {
            opacity: 1;
            transform: scale(1);
        }

        .post-card-animate {
            opacity: 0;
            transform: translateY(60px) scale(0.96) rotateX(4deg);
            transform-origin: top center;
            transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .post-card-animate.visible {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
        }

        .video-card-animate {
            opacity: 0;
            transform: translateY(40px) scale(0.92);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform, opacity;
        }

        .video-card-animate.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .team-card-animate,
        .faq-item-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .team-card-animate.visible,
        .faq-item-animate.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .about-img-col {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1.1s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .about-content-col {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1.1s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .about-img-col.visible {
            transform: translate3d(0, 0, 0) !important;
        }

        .about-content-col.visible {
            transform: translate3d(0, 0, 0) !important;
        }

        /* Bento grid item animations */
        .bento-item-left {
            opacity: 0;
            transform: translate3d(-100px, 0, 0);
            transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .bento-item-left.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }

        .bento-item-right {
            opacity: 0;
            transform: translate3d(100px, 0, 0);
            transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .bento-item-right.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }

        /* Staggered Delay for grid items to create a wave effect */
        .scope-card-animate.visible:nth-child(1), .post-card-animate.visible:nth-child(1), .video-card-animate.visible:nth-child(1) { transition-delay: 0.03s; }
        .scope-card-animate.visible:nth-child(2), .post-card-animate.visible:nth-child(2), .video-card-animate.visible:nth-child(2) { transition-delay: 0.08s; }
        .scope-card-animate.visible:nth-child(3), .post-card-animate.visible:nth-child(3), .video-card-animate.visible:nth-child(3) { transition-delay: 0.13s; }
        .scope-card-animate.visible:nth-child(4), .post-card-animate.visible:nth-child(4), .video-card-animate.visible:nth-child(4) { transition-delay: 0.18s; }
        .scope-card-animate.visible:nth-child(5), .post-card-animate.visible:nth-child(5) { transition-delay: 0.23s; }
        .scope-card-animate.visible:nth-child(6), .post-card-animate.visible:nth-child(6) { transition-delay: 0.28s; }

        .team-card-animate.visible:nth-child(1) { transition-delay: 0.05s; }
        .team-card-animate.visible:nth-child(2) { transition-delay: 0.10s; }
        .team-card-animate.visible:nth-child(3) { transition-delay: 0.15s; }
        .team-card-animate.visible:nth-child(4) { transition-delay: 0.20s; }
        .team-card-animate.visible:nth-child(5) { transition-delay: 0.25s; }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px !important;
            }
        }
    </style>
</head>
<?php 
$raw_req_uri = $_SERVER['REQUEST_URI'] ?? '';
$req_path = trim(parse_url($raw_req_uri, PHP_URL_PATH), '/');
$page_title_lower = strtolower($data['title'] ?? '');

$is_homepage = (empty($req_path) || $req_path === 'home' || $req_path === 'index' || $page_title_lower === 'home');

$is_islamic_page = (
    strpos($raw_req_uri, 'quran') !== false ||
    strpos($raw_req_uri, 'hadith') !== false ||
    strpos($raw_req_uri, 'prayer') !== false ||
    strpos($raw_req_uri, 'calendar') !== false ||
    strpos($raw_req_uri, 'zakat') !== false ||
    strpos($raw_req_uri, 'dua') !== false ||
    strpos($raw_req_uri, 'tasbih') !== false ||
    strpos($raw_req_uri, 'asmaul') !== false
);

$is_posts_page = (
    strpos($raw_req_uri, '/posts') !== false || 
    strpos($raw_req_uri, '/blog') !== false || 
    isset($data['post']) || 
    ($page_title_lower !== 'home' && !empty($data['posts']))
);
if ($is_posts_page) {
    $is_homepage = false;
}

if (!function_exists('format_menu_url')) {
    function format_menu_url($url) {
        $url = trim($url ?? '');
        if (empty($url) || $url === '#') {
            return '#';
        }
        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
            return $url;
        }
        if (strpos($url, '/') === 0) {
            return URLROOT . $url;
        }
        return URLROOT . '/' . $url;
    }
}
?>
<body class="<?= $is_homepage ? 'home-page' : ($is_posts_page ? 'posts-page light-bg' : ($is_islamic_page ? 'islamic-page-bg' : '')) ?>">




<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
<?php if ($is_homepage): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('home-page');
});
<?php endif; ?>
</script>



<div class="top-menu-bar">
    <div class="container container-header" style="width: 100%; margin: 0 auto;">
        <div class="top-menu-flex">
            <!-- Left Side: Date & Time Display -->
            <div class="top-date-time">
                <span><i class="far fa-calendar-alt" style="color: #ffffff; margin-right: 5px;"></i> <?= getBengaliDate() ?></span>
                <span style="opacity: 0.35;">|</span>
                <span><i class="far fa-clock" style="color: #ffffff; margin-right: 5px;"></i> <span id="topbar-clock" style="font-family: 'Outfit', 'Hind Siliguri', sans-serif; font-weight: 700; letter-spacing: 1px; color: #ffffff;">--:--:--</span></span>
            </div>
            <!-- Center: Top Menu Links -->
            <ul class="top-menu-links">
                <?php if (!empty($data['sub_menus'])): ?>
                    <?php foreach ($data['sub_menus'] as $submenu): ?>
                        <li>
                            <a href="<?= format_menu_url($submenu['url']) ?>">
                                <?= htmlspecialchars($submenu['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <!-- Right Side: Social Icons & Donation & PWA App -->
            <div class="top-menu-right">
                <!-- Donation Button -->
                <a href="<?= URLROOT ?>/donate" style="background: #ffffff; color: var(--bg-dark); font-weight: 700; font-size: 0.85rem; padding: 4px 12px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: 0.2s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <i class="fas fa-hand-holding-heart" style="color: #16a34a; font-size: 0.85rem;"></i>
                    <span class="topbar-donation-label">ডোনেশন</span>
                </a>

                <!-- Admin Login / Dashboard Button -->
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="<?= URLROOT ?>/admin" title="অ্যাডমিন ড্যাশবোর্ড" style="background: rgba(255, 255, 255, 0.15); color: #ffffff; font-weight: 700; font-size: 0.82rem; padding: 4px 12px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(255, 255, 255, 0.35); transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='scale(1)';">
                        <i class="fas fa-gauge-high" style="color: #fef08a; font-size: 0.82rem;"></i>
                        <span>ড্যাশবোর্ড</span>
                    </a>
                <?php else: ?>
                    <a href="<?= URLROOT ?>/admin/login" title="অ্যাডমিন লগইন" style="background: rgba(255, 255, 255, 0.15); color: #ffffff; font-weight: 700; font-size: 0.82rem; padding: 4px 12px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(255, 255, 255, 0.35); transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='scale(1)';">
                        <i class="fas fa-user-shield" style="color: #fef08a; font-size: 0.82rem;"></i>
                        <span>লগইন</span>
                    </a>
                <?php endif; ?>
                
                <!-- Vertical Divider -->
                <span class="topbar-divider" style="opacity: 0.2; color: white;">|</span>

                <?php
                $social_links = [];
                try {
                    $db = \Config\Database::pdoConnect();
                    $social_links_stmt = $db ? $db->query("SELECT * FROM social_links ORDER BY order_index ASC, id ASC") : null;
                    if ($social_links_stmt) {
                        $social_links = $social_links_stmt->fetchAll() ?: [];
                    }
                } catch (\Throwable $e) {
                    $social_links = [];
                }
                ?>
                
                <!-- Desktop Social Links -->
                <div class="topbar-social-links" style="display: flex; gap: 15px; align-items: center;">
                    <?php foreach ($social_links as $link): 
                        $hover_color = '#ffffff';
                        $name_lower = strtolower($link['name']);
                        if (strpos($name_lower, 'facebook') !== false) $hover_color = '#1877F2';
                        elseif (strpos($name_lower, 'twitter') !== false || strpos($name_lower, 'x.com') !== false) $hover_color = '#1DA1F2';
                        elseif (strpos($name_lower, 'youtube') !== false) $hover_color = '#FF0000';
                        elseif (strpos($name_lower, 'instagram') !== false) $hover_color = '#E4405F';
                        elseif (strpos($name_lower, 'tiktok') !== false) $hover_color = '#010101';
                        elseif (strpos($name_lower, 'linkedin') !== false) $hover_color = '#0077B5';
                        elseif (strpos($name_lower, 'telegram') !== false) $hover_color = '#0088cc';
                        elseif (strpos($name_lower, 'whatsapp') !== false) $hover_color = '#25D366';
                        elseif (strpos($name_lower, 'pinterest') !== false) $hover_color = '#BD081C';
                    ?>
                        <a href="<?= $link['url'] ?>" target="_blank" title="<?= htmlspecialchars($link['name']) ?>" style="color: #ffffff; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.color='<?= $hover_color ?>'; this.style.transform='scale(1.2)';" onmouseout="this.style.color='#ffffff'; this.style.transform='scale(1)';">
                            <i class="<?= htmlspecialchars($link['icon']) ?>" style="font-size: 0.95rem;"></i>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile Social Dropdown -->
                <div class="mobile-social-dropdown">
                    <button class="mobile-social-btn" aria-label="Social Links">
                        <i class="fas fa-share-nodes"></i>
                    </button>
                    <div class="mobile-social-menu">
                        <?php foreach ($social_links as $link): 
                            $hover_color = '#ffffff';
                            $name_lower = strtolower($link['name']);
                            if (strpos($name_lower, 'facebook') !== false) $hover_color = '#1877F2';
                            elseif (strpos($name_lower, 'twitter') !== false || strpos($name_lower, 'x.com') !== false) $hover_color = '#1DA1F2';
                            elseif (strpos($name_lower, 'youtube') !== false) $hover_color = '#FF0000';
                            elseif (strpos($name_lower, 'instagram') !== false) $hover_color = '#E4405F';
                            elseif (strpos($name_lower, 'tiktok') !== false) $hover_color = '#010101';
                            elseif (strpos($name_lower, 'linkedin') !== false) $hover_color = '#0077B5';
                            elseif (strpos($name_lower, 'telegram') !== false) $hover_color = '#0088cc';
                            elseif (strpos($name_lower, 'whatsapp') !== false) $hover_color = '#25D366';
                            elseif (strpos($name_lower, 'pinterest') !== false) $hover_color = '#BD081C';
                        ?>
                            <a href="<?= $link['url'] ?>" target="_blank" title="<?= htmlspecialchars($link['name']) ?>" style="color: #ffffff;" onmouseover="this.style.color='<?= $hover_color ?>';" onmouseout="this.style.color='#ffffff';">
                                <i class="<?= htmlspecialchars($link['icon']) ?>" style="font-size: 0.95rem;"></i>
                                <span><?= htmlspecialchars($link['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Mobile Topbar Sub-Menus Dropdown -->
                <div class="mobile-topmenu-dropdown">
                    <button class="mobile-topmenu-btn" aria-label="Topbar Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="mobile-topmenu-menu">
                        <?php if (!empty($data['sub_menus'])): ?>
                            <?php foreach ($data['sub_menus'] as $submenu): ?>
                                <a href="<?= format_menu_url($submenu['url']) ?>" style="color: #ffffff;">
                                    <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: var(--primary);"></i>
                                    <span><?= htmlspecialchars($submenu['title']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</div>

<?php
$current_req_uri = strtolower($_SERVER['REQUEST_URI'] ?? '');
$is_islamic_dedicated_page = (
    strpos($current_req_uri, '/quran') !== false || 
    strpos($current_req_uri, '/hadith') !== false ||
    (isset($data['current_page']) && in_array($data['current_page'], ['quran', 'hadith']))
);
if (!$is_islamic_dedicated_page):
?>
<div class="header-wrapper">
    <div class="container container-header">
        <nav class="glass-nav">
            <a href="<?= URLROOT ?>/" class="logo">
                <?php if (!empty($data['settings']['site_logo'])): ?>
                    <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo" style="max-height: 50px;">
                <?php else: ?>
                    <i class="fas fa-kaaba"></i>
                    <span>নূর<span style="color: var(--gold);">ল্যাব</span></span>
                <?php endif; ?>
            </a>

            <!-- Mobile Actions Wrapper -->
            <div style="display: flex; align-items: center; gap: 15px; margin-left: auto;">
                <!-- Mobile Menu Toggle Button -->
                <button class="mobile-nav-toggle" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav-links">
                <?php 
                if(!empty($data['menus'])): 
                    $legacy_cat_names = ['ইসলাম', 'স্রষ্টা ও সৃষ্টি', 'ইতিহাস', 'বিজ্ঞান ও দর্শন', 'ধর্মতত্ব', 'ধর্মতত্ত্ব'];
                    $all_menus = $data['menus'];
                    $top_menus = array_filter($all_menus, function($m) use ($legacy_cat_names) { 
                        return empty($m['parent_id']) && !in_array(trim($m['title'] ?? ''), $legacy_cat_names); 
                    });
                    usort($top_menus, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                    
                    $db = \Config\Database::pdoConnect();
                    
                    foreach($top_menus as $menu):
                        $menu_type = $menu['menu_type'] ?? 'custom';
                        
                        if ($menu_type === 'post_mega'):
                            // Automatically fetch all active top-level categories dynamically so newly added categories appear instantly in সবগুলো নিবন্ধ
                            $stmt = $db->query("SELECT * FROM categories WHERE (parent_id IS NULL OR parent_id = 0) ORDER BY order_index ASC, name ASC");
                            $categories = $stmt->fetchAll();
                            if (!empty($categories)):
                                ?>
                                <li class="nav-item-megamenu">
                                    <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="megamenu-trigger btn-nav-categories">
                                        <span class="btn-cat-main">
                                            <i class="fa-solid fa-layer-group btn-cat-icon"></i>
                                            <span><?= htmlspecialchars($menu['title']) ?></span>
                                        </span>
                                        <span class="megamenu-toggle-arrow" title="খুলুন বা বন্ধ করুন">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </a>
                                    
                                    <div class="megamenu-dropdown">
                                        <div class="megamenu-inner">
                                            <!-- Left Sidebar Tabs -->
                                            <div class="megamenu-sidebar-wrapper">
                                                <div class="megamenu-sidebar">
                                                    <?php 
                                                    $is_first = true;
                                                    foreach($categories as $cat): 
                                                        $tab_slug = 'post-cat-' . $cat['id'];
                                                        // Fetch subcategories for this category
                                                        $stmt_sub = $db->prepare("SELECT id, name, slug FROM categories WHERE parent_id = ? ORDER BY order_index ASC, name ASC");
                                                        $stmt_sub->execute([$cat['id']]);
                                                        $subcats = $stmt_sub->fetchAll();
                                                        $has_subcats = !empty($subcats);
                                                    ?>
                                                        <div class="mega-cat-group" id="group-<?= $tab_slug ?>">
                                                            <div class="mega-tab-btn <?= $is_first ? 'active' : '' ?>" data-tab="<?= $tab_slug ?>" data-link="<?= URLROOT . '/' . $cat['slug'] ?>">
                                                                <div class="mega-tab-btn-title">
                                                                    <i class="fa-solid fa-layer-group mega-tab-icon"></i>
                                                                    <span class="tab-text"><?= htmlspecialchars($cat['name']) ?></span>
                                                                </div>
                                                                <?php if ($has_subcats): ?>
                                                                    <span class="mega-cat-expander" onclick="event.preventDefault(); event.stopPropagation(); this.closest('.mega-cat-group').classList.toggle('expanded');" title="সাব-ক্যাটাগরি দেখুন">
                                                                        <i class="fas fa-chevron-down"></i>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>

                                                            <?php if ($has_subcats): ?>
                                                                <div class="mega-subcat-list">
                                                                    <?php foreach ($subcats as $sub): 
                                                                        $sub_tab_slug = 'post-cat-' . $sub['id'];
                                                                    ?>
                                                                        <div class="mega-subcat-item mega-tab-btn" data-tab="<?= $sub_tab_slug ?>" data-link="<?= URLROOT ?>/<?= $sub['slug'] ?>">
                                                                            <i class="fas fa-turn-up fa-rotate-90"></i>
                                                                            <span><?= htmlspecialchars($sub['name']) ?></span>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php 
                                                        $is_first = false;
                                                    endforeach; 
                                                    ?>
                                                </div>
                                                <div class="megamenu-scroll-indicator"><i class="fas fa-chevron-down"></i> আরও দেখুন</div>
                                            </div>
                                            
                                            <!-- Right Content Section -->
                                            <div class="megamenu-content">
                                                <?php 
                                                $is_first = true;
                                                foreach($categories as $cat): 
                                                    $tab_slug = 'post-cat-' . $cat['id'];
                                                    $stmt_posts = $db->prepare("SELECT p.* FROM posts p 
                                                                                JOIN post_categories pc ON p.id = pc.post_id 
                                                                                WHERE p.status = 'published' AND pc.category_id = ? 
                                                                                ORDER BY p.created_at DESC LIMIT 6");
                                                    $stmt_posts->execute([$cat['id']]);
                                                    $posts = $stmt_posts->fetchAll();

                                                    // Also fetch subcategory panes
                                                    $stmt_sub_panes = $db->prepare("SELECT id, name, slug FROM categories WHERE parent_id = ? ORDER BY order_index ASC, name ASC");
                                                    $stmt_sub_panes->execute([$cat['id']]);
                                                    $subcats_for_panes = $stmt_sub_panes->fetchAll();
                                                ?>
                                                    <div class="mega-tab-pane <?= $is_first ? 'active' : '' ?>" id="pane-<?= $tab_slug ?>">
                                                        <h3 class="pane-title"><i class="fa-solid fa-layer-group"></i> <?= htmlspecialchars($cat['name']) ?></h3>
                                                        <div class="services-grid">
                                                            <?php foreach ($posts as $post): ?>
                                                                <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" style="text-decoration: none;">
                                                                    <div class="service-card">
                                                                        <i class="fa-solid fa-file-invoice"></i>
                                                                        <span><?= htmlspecialchars($post['title']) ?></span>
                                                                    </div>
                                                                </a>
                                                            <?php endforeach; ?>
                                                            <a href="<?= URLROOT ?>/<?= $cat['slug'] ?>" style="text-decoration: none;">
                                                                <div class="service-card" style="border-color: rgba(37, 99, 235, 0.4); background: rgba(37, 99, 235, 0.02);">
                                                                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: var(--primary) !important;"></i>
                                                                    <span style="color: #ffffff;">সকল নিবন্ধ দেখুন</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <?php foreach ($subcats_for_panes as $sub): 
                                                        $sub_tab_slug = 'post-cat-' . $sub['id'];
                                                        $stmt_sub_posts = $db->prepare("SELECT p.* FROM posts p 
                                                                                        JOIN post_categories pc ON p.id = pc.post_id 
                                                                                        WHERE p.status = 'published' AND pc.category_id = ? 
                                                                                        ORDER BY p.created_at DESC LIMIT 6");
                                                        $stmt_sub_posts->execute([$sub['id']]);
                                                        $sub_posts = $stmt_sub_posts->fetchAll();
                                                    ?>
                                                        <div class="mega-tab-pane" id="pane-<?= $sub_tab_slug ?>">
                                                            <h3 class="pane-title"><i class="fas fa-turn-up fa-rotate-90" style="color: #34d399; font-size: 16px;"></i> <?= htmlspecialchars($sub['name']) ?></h3>
                                                            <div class="services-grid">
                                                                <?php if (!empty($sub_posts)): ?>
                                                                    <?php foreach ($sub_posts as $post): ?>
                                                                        <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" style="text-decoration: none;">
                                                                            <div class="service-card">
                                                                                <i class="fa-solid fa-file-invoice"></i>
                                                                                <span><?= htmlspecialchars($post['title']) ?></span>
                                                                            </div>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <div style="grid-column: 1 / -1; padding: 30px; text-align: center; color: #94a3b8; font-size: 15px;">
                                                                        এই বিষয়ে কোনো নিবন্ধ পাওয়া যায়নি।
                                                                    </div>
                                                                <?php endif; ?>
                                                                <a href="<?= URLROOT ?>/<?= $sub['slug'] ?>" style="text-decoration: none;">
                                                                    <div class="service-card" style="border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.06);">
                                                                        <i class="fa-solid fa-arrow-right-to-bracket" style="color: var(--primary) !important;"></i>
                                                                        <span style="color: #ffffff;"><?= htmlspecialchars($sub['name']) ?>-এর সকল নিবন্ধ</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php 
                                                    $is_first = false;
                                                endforeach; 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            else:
                                ?>
                                <li><a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : URLROOT . $menu['url'] ?>"><?= htmlspecialchars($menu['title']) ?></a></li>
                                <?php
                            endif;
                            
                        elseif ($menu_type === 'product_mega'):
                            // E-commerce disabled
                            
                        else:
                            $tier2 = array_filter($all_menus, function($m) { return false; }); // Placeholder fallback below handles the local filter
                            $tier2 = array_filter($all_menus, function($m) use ($menu) { return $m['parent_id'] == $menu['id']; });
                            usort($tier2, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                            
                            if (empty($tier2)):
                                ?>
                                <li><a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : URLROOT . $menu['url'] ?>"><?= htmlspecialchars($menu['title']) ?></a></li>
                                <?php
                            else:
                                $has_tier3 = false;
                                foreach ($tier2 as $t2) {
                                    $t3 = array_filter($all_menus, function($m) use ($t2) { return $m['parent_id'] == $t2['id']; });
                                    if (!empty($t3)) {
                                        $has_tier3 = true;
                                        break;
                                    }
                                }
                                
                                if ($has_tier3):
                                    ?>
                                    <li class="nav-item-megamenu">
                                        <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="megamenu-trigger">
                                            <span><?= htmlspecialchars($menu['title']) ?></span>
                                            <span class="megamenu-toggle-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </a>
                                        
                                        <div class="megamenu-dropdown">
                                            <div class="megamenu-inner">
                                                <!-- Left Sidebar Tabs -->
                                                <div class="megamenu-sidebar-wrapper">
                                                    <div class="megamenu-sidebar">
                                                        <?php 
                                                        $is_first = true;
                                                        foreach($tier2 as $t2_menu): 
                                                            $tab_slug = 'menu-' . $t2_menu['id'];
                                                        ?>
                                                            <div class="mega-tab-btn <?= $is_first ? 'active' : '' ?>" data-tab="<?= $tab_slug ?>" data-link="<?= (strpos($t2_menu['url'], 'http') === 0) ? $t2_menu['url'] : URLROOT . $t2_menu['url'] ?>">
                                                                <i class="<?= htmlspecialchars($t2_menu['icon'] ?? 'fa-solid fa-layer-group') ?>"></i>
                                                                <span><?= htmlspecialchars($t2_menu['title']) ?></span>
                                                            </div>
                                                        <?php 
                                                            $is_first = false;
                                                        endforeach; 
                                                        ?>
                                                    </div>
                                                    <div class="megamenu-scroll-indicator"><i class="fas fa-chevron-down"></i> আরও দেখুন</div>
                                                </div>
                                                
                                                <!-- Right Content Section -->
                                                <div class="megamenu-content">
                                                    <?php 
                                                    $is_first = true;
                                                    foreach($tier2 as $t2_menu): 
                                                        $tab_slug = 'menu-' . $t2_menu['id'];
                                                        $tier3 = array_filter($all_menus, function($m) use ($t2_menu) { return $m['parent_id'] == $t2_menu['id']; });
                                                        usort($tier3, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                                                    ?>
                                                        <div class="mega-tab-pane <?= $is_first ? 'active' : '' ?>" id="pane-<?= $tab_slug ?>">
                                                            <h3 class="pane-title"><i class="<?= htmlspecialchars($t2_menu['icon'] ?? 'fa-solid fa-layer-group') ?>"></i> <?= htmlspecialchars($t2_menu['title']) ?></h3>
                                                            <div class="services-grid">
                                                                <?php foreach ($tier3 as $t3_menu): ?>
                                                                    <a href="<?= (strpos($t3_menu['url'], 'http') === 0) ? $t3_menu['url'] : (trim($t3_menu['url']) === '#' ? '#' : URLROOT . $t3_menu['url']) ?>" style="text-decoration: none;">
                                                                        <div class="service-card">
                                                                            <i class="<?= htmlspecialchars($t3_menu['icon'] ?? 'fa-solid fa-link') ?>"></i>
                                                                            <span><?= htmlspecialchars($t3_menu['title']) ?></span>
                                                                        </div>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php 
                                                        $is_first = false;
                                                    endforeach; 
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                else:
                                    ?>
                                    <li class="nav-item-dropdown">
                                        <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="dropdown-trigger">
                                            <span><?= htmlspecialchars($menu['title']) ?></span>
                                            <span class="megamenu-toggle-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </a>
                                        <ul class="submenu-dropdown">
                                            <?php foreach ($tier2 as $t2_menu): ?>
                                                <li>
                                                    <a href="<?= (strpos($t2_menu['url'], 'http') === 0) ? $t2_menu['url'] : (trim($t2_menu['url']) === '#' ? '#' : URLROOT . $t2_menu['url']) ?>">
                                                        <?php if (!empty($t2_menu['icon'])): ?>
                                                            <i class="<?= htmlspecialchars($t2_menu['icon']) ?>"></i>
                                                        <?php endif; ?>
                                                        <?= htmlspecialchars($t2_menu['title']) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <?php
                                endif;
                            endif;
                        endif;
                    endforeach;
                else: 
                ?>
                    <li><a href="<?= URLROOT ?>">হোম</a></li>
                <?php endif; ?>
                
                <!-- Header Expandable Search Bar with Live AJAX Dropdown -->
                <li class="nav-search-item" style="margin-left: auto; display: flex; align-items: center; list-style: none; padding-left: 15px; position: relative;">
                    <form action="<?= URLROOT ?>/blog" method="GET" id="header-search-form" style="position: relative; display: flex; align-items: center; height: 38px;">
                        <input type="text" name="search" id="header-search-input" placeholder="খুঁজুন (যেমন: রমজান, জাকাত)..." autocomplete="off" style="padding: 7px 40px 7px 14px; border-radius: 20px; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; outline: none; width: 0px; opacity: 0; border: none; background: transparent; transition: all 0.35s ease; box-sizing: border-box;">
                        <button type="button" id="header-search-clear-btn" style="display: none; position: absolute; right: 44px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; font-size: 16px; cursor: pointer; padding: 2px 6px; line-height: 1; border-radius: 50%;" title="মুছুন">&times;</button>
                        <button type="button" id="header-search-btn" style="background: linear-gradient(135deg, #0b7c4d 0%, #10b981 100%); border: none; color: #ffffff; cursor: pointer; font-size: 0.95rem; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; flex-shrink: 0; box-shadow: 0 4px 12px rgba(11, 124, 77, 0.3);" title="সার্চ করুন">
                            <i class="fas fa-search"></i>
                        </button>

                        <!-- Header Live Search Dropdown -->
                        <div id="header-search-dropdown" class="live-search-dropdown">
                            <div class="search-dropdown-header">
                                <div class="search-dropdown-tabs">
                                    <button type="button" class="search-tab-pill active" data-tab="all">সব (<span class="tab-count-all">0</span>)</button>
                                    <button type="button" class="search-tab-pill" data-tab="posts">পোস্ট (<span class="tab-count-posts">0</span>)</button>
                                    <button type="button" class="search-tab-pill" data-tab="questions">প্রশ্নোত্তর (<span class="tab-count-questions">0</span>)</button>
                                </div>
                                <div class="search-status-indicator" style="font-size: 11px; color: #64748b;"></div>
                            </div>
                            <div class="search-dropdown-body custom-scroll">
                                <!-- Results populated via AJAX -->
                            </div>
                            <div class="search-dropdown-footer">
                                <a href="#" class="search-view-all-link">
                                    <span>সকল ফলাফল দেখুন</span>
                                    <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </li>

            </ul>

        </nav>
    </div>
</div>
<?php endif; ?>

<!-- Search Popup Overlay Modal -->
<div id="search-popup-modal" style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); z-index: 99999; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.3s ease;">
    <div style="position: absolute; top: 30px; right: 30px; color: white; font-size: 2rem; cursor: pointer; transition: 0.2s; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: rgba(255,255,255,0.08);" id="search-popup-close" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='rotate(90deg)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.transform='rotate(0)';">
        <i class="fas fa-times"></i>
    </div>
    
    <div style="width: 100%; max-width: 720px; padding: 20px; text-align: center; transform: scale(0.9); transition: 0.3s ease;" id="search-popup-content">
        <h2 style="color: white; font-size: 2.2rem; font-weight: 800; margin-bottom: 25px; font-family: 'Hind Siliguri', sans-serif;">আপনি কি খুঁজছেন?</h2>
        <form action="<?= URLROOT ?>/blog" method="GET" id="search-popup-form" style="position: relative; background: white; border-radius: 50px; padding: 8px 10px; display: flex; align-items: center; box-shadow: 0 25px 50px rgba(0,0,0,0.3); border: 2px solid transparent; transition: 0.3s;" onfocusin="this.style.borderColor='var(--primary)';">
            <input type="text" name="search" id="search-popup-input" autocomplete="off" placeholder="এখানে লিখুন (যেমন: রমজান, জাকাত, সালাত)..." required style="width: 100%; padding: 15px 25px; border: none; outline: none; font-size: 1.25rem; font-weight: 600; font-family: 'Hind Siliguri', sans-serif; color: var(--text-main); border-radius: 50px;">
            <button type="button" id="modal-search-clear-btn" style="display: none; background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer; padding: 5px 12px;" title="মুছুন">&times;</button>
            <button type="submit" style="background: var(--primary); color: white; border: none; border-radius: 50%; width: 55px; height: 55px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; box-shadow: 0 10px 20px var(--primary-glow); flex-shrink: 0;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                <i class="fas fa-search" style="font-size: 1.3rem;"></i>
            </button>
        </form>

        <!-- Modal Live Search Results Dropdown -->
        <div id="modal-search-results" class="modal-search-results-box" style="display: none;">
            <div class="search-dropdown-header" style="border-radius: 18px 18px 0 0; background: #ffffff; padding: 12px 18px;">
                <div class="search-dropdown-tabs">
                    <button type="button" class="search-tab-pill active" data-tab="all">সব (<span class="tab-count-all">0</span>)</button>
                    <button type="button" class="search-tab-pill" data-tab="posts">পোস্ট (<span class="tab-count-posts">0</span>)</button>
                    <button type="button" class="search-tab-pill" data-tab="questions">প্রশ্নোত্তর (<span class="tab-count-questions">0</span>)</button>
                </div>
                <div class="search-status-indicator" style="font-size: 12px; color: #64748b; font-weight: 600;"></div>
            </div>
            <div class="search-dropdown-body custom-scroll" style="max-height: 420px; background: #ffffff;">
                <!-- Populated via AJAX -->
            </div>
            <div class="search-dropdown-footer" style="border-radius: 0 0 18px 18px; background: #f8fafc; padding: 12px 18px;">
                <a href="#" class="search-view-all-link">
                    <span>সকল ফলাফল বিস্তারিত দেখুন</span>
                    <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Live AJAX Search Styles */
mark.search-highlight {
    background-color: #fef08a !important;
    color: #854d0e !important;
    padding: 1px 4px !important;
    border-radius: 4px !important;
    font-weight: 700 !important;
}

.live-search-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 440px;
    max-width: calc(100vw - 30px);
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18), 0 4px 12px rgba(15, 23, 42, 0.08);
    border: 1px solid #e2e8f0;
    z-index: 999999;
    overflow: hidden;
    display: none;
    text-align: left;
    font-family: 'Hind Siliguri', sans-serif;
    animation: searchDropdownFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes searchDropdownFadeIn {
    from { opacity: 0; transform: translateY(-8px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.search-dropdown-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
}

.search-dropdown-tabs {
    display: flex;
    gap: 6px;
}

.search-tab-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
    font-family: inherit;
}

.search-tab-pill:hover {
    border-color: #cbd5e1;
    color: #1e293b;
}

.search-tab-pill.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
    box-shadow: 0 2px 6px rgba(11, 124, 77, 0.25);
}

.search-dropdown-body {
    max-height: 380px;
    overflow-y: auto;
    padding: 6px 0;
}

.search-dropdown-body::-webkit-scrollbar {
    width: 6px;
}
.search-dropdown-body::-webkit-scrollbar-track {
    background: #f8fafc;
}
.search-dropdown-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.search-dropdown-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.search-result-item {
    padding: 11px 16px;
    display: block;
    text-decoration: none;
    color: #1e293b;
    border-bottom: 1px solid #f8fafc;
    transition: all 0.18s ease;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-item:hover, .search-result-item.selected {
    background: #f0fdf4;
}

.search-result-badge-row {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 5px;
    flex-wrap: wrap;
}

.search-badge {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.search-badge-post {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.search-badge-qa {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.search-badge-category {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.search-result-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.42;
    margin-bottom: 4px;
}

.search-result-snippet {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.48;
}

.search-qa-box {
    background: #f8fafc;
    border-left: 3px solid #3b82f6;
    padding: 6px 10px;
    border-radius: 0 6px 6px 0;
    margin-top: 5px;
    font-size: 12px;
    color: #334155;
}

.search-qa-box .qa-label {
    font-weight: 700;
    color: #2563eb;
    margin-right: 4px;
}

.search-dropdown-footer {
    padding: 10px 14px;
    background: #f8fafc;
    border-top: 1px solid #edf2f7;
    text-align: center;
}

.search-dropdown-footer a {
    color: #0b7c4d;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.2s;
}

.search-dropdown-footer a:hover {
    color: #059669;
    transform: translateX(2px);
}

.search-loading-state, .search-empty-state {
    padding: 30px 16px;
    text-align: center;
    color: #64748b;
    font-size: 13.5px;
}

/* Modal Search Results Box */
.modal-search-results-box {
    margin-top: 18px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.45);
    border: 1px solid rgba(255,255,255,0.3);
    text-align: left;
    overflow: hidden;
    animation: searchDropdownFadeIn 0.22s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // -------------------------------------------------------------
    // Live Search Engine Core (Bangla, Banglish, English Support)
    // -------------------------------------------------------------
    const AJAX_SEARCH_URL = '<?= URLROOT ?>/ajax_search';
    const BLOG_URL = '<?= URLROOT ?>/blog';

    function initLiveSearch(options) {
        const input = options.input;
        const container = options.container;
        const form = options.form;
        const clearBtn = options.clearBtn;
        const isHeader = options.isHeader;

        if (!input || !container) return;

        let activeTab = 'all';
        let debounceTimer = null;
        let cachedData = null;
        let selectedIndex = -1;

        const body = container.querySelector('.search-dropdown-body');
        const countAll = container.querySelector('.tab-count-all');
        const countPosts = container.querySelector('.tab-count-posts');
        const countQuestions = container.querySelector('.tab-count-questions');
        const statusEl = container.querySelector('.search-status-indicator');
        const viewAllLink = container.querySelector('.search-view-all-link');
        const tabBtns = container.querySelectorAll('.search-tab-pill');

        function showLoading() {
            container.style.display = 'block';
            if (body) {
                body.innerHTML = `
                    <div class="search-loading-state">
                        <i class="fas fa-circle-notch fa-spin" style="font-size: 20px; color: #0b7c4d; margin-bottom: 8px; display: block;"></i>
                        <span>খোঁজা হচ্ছে...</span>
                    </div>`;
            }
            if (statusEl) statusEl.textContent = 'লোড হচ্ছে...';
        }

        function renderResults(data, query) {
            cachedData = data;
            const posts = data.posts || [];
            const questions = data.questions || [];
            const total = (posts.length + questions.length);

            if (countAll) countAll.textContent = total;
            if (countPosts) countPosts.textContent = posts.length;
            if (countQuestions) countQuestions.textContent = questions.length;
            if (statusEl) statusEl.textContent = `${total}টি ফলাফল`;

            if (viewAllLink) {
                viewAllLink.href = `${BLOG_URL}?search=${encodeURIComponent(query)}`;
                const span = viewAllLink.querySelector('span');
                if (span) span.textContent = `"${query}" এর সকল ফলাফল দেখুন (${total})`;
            }

            if (total === 0) {
                body.innerHTML = `
                    <div class="search-empty-state">
                        <i class="fas fa-search" style="font-size: 24px; color: #94a3b8; display: block; margin-bottom: 8px;"></i>
                        <p style="margin: 0 0 4px 0; font-weight: 700; color: #1e293b;">কোনো তথ্য পাওয়া যায়নি</p>
                        <p style="margin: 0; font-size: 12px; color: #64748b;">বাংলা বা ইংরেজিতে অন্য কোনো শব্দ দিয়ে চেষ্টা করুন।</p>
                    </div>`;
                container.style.display = 'block';
                return;
            }

            // Build list based on activeTab
            let itemsHTML = '';

            // Filter items based on activeTab
            let displayPosts = (activeTab === 'all' || activeTab === 'posts') ? posts : [];
            let displayQuestions = (activeTab === 'all' || activeTab === 'questions') ? questions : [];

            // Combine and sort by score DESC
            let combined = [];
            displayPosts.forEach(p => combined.push({ ...p, item_type: 'post' }));
            displayQuestions.forEach(q => combined.push({ ...q, item_type: 'question' }));
            combined.sort((a, b) => (b.score || 0) - (a.score || 0));

            combined.forEach((item, index) => {
                if (item.item_type === 'post') {
                    const title = item.highlighted_title || item.title;
                    const snippet = item.highlighted_snippet || item.snippet || '';
                    const catName = item.main_category || 'সাধারণ';
                    const date = item.created_at ? item.created_at.substring(0, 10) : '';

                    itemsHTML += `
                        <a href="${item.url}" class="search-result-item" data-index="${index}">
                            <div class="search-result-badge-row">
                                <span class="search-badge search-badge-post">
                                    <i class="far fa-file-alt"></i> পোস্ট
                                </span>
                                <span class="search-badge-category">
                                    <i class="fas fa-folder" style="font-size: 10px; color: #f59e0b;"></i> ${catName}
                                </span>
                                ${item.match_badge === 'Title Match' ? '<span style="font-size: 9.5px; background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 4px; font-weight: 700;"><i class="fas fa-star" style="font-size: 8px;"></i> শিরোনাম মিল</span>' : (item.match_badge === 'Keyword Match' ? '<span style="font-size: 9.5px; background: #f3e8ff; color: #6b21a8; padding: 1px 5px; border-radius: 4px; font-weight: 700;"><i class="fas fa-tag" style="font-size: 8px;"></i> ট্যাগ মিল</span>' : '<span style="font-size: 9.5px; background: #e0f2fe; color: #0369a1; padding: 1px 5px; border-radius: 4px; font-weight: 700;"><i class="fas fa-file-alt" style="font-size: 8px;"></i> মূল লেখায় মিল</span>')}
                            </div>
                            <div class="search-result-title">${title}</div>
                            ${snippet ? `<div class="search-result-snippet">${snippet}</div>` : ''}
                        </a>`;
                } else if (item.item_type === 'question') {
                    const questionText = item.highlighted_question || item.question;
                    const answerSnippet = item.highlighted_answer || item.answer_snippet || '';
                    const catName = item.category_name || 'প্রশ্নোত্তর';

                    itemsHTML += `
                        <a href="${item.url}" class="search-result-item" data-index="${index}">
                            <div class="search-result-badge-row">
                                <span class="search-badge search-badge-qa">
                                    <i class="fas fa-question-circle"></i> প্রশ্নোত্তর
                                </span>
                                <span class="search-badge-category">
                                    <i class="fas fa-tag" style="font-size: 10px; color: #3b82f6;"></i> ${catName}
                                </span>
                                ${item.match_badge === 'Question Match' ? '<span style="font-size: 9.5px; background: #eff6ff; color: #1e40af; padding: 1px 5px; border-radius: 4px; font-weight: 700;"><i class="fas fa-check" style="font-size: 8px;"></i> প্রশ্ন মিল</span>' : ''}
                            </div>
                            <div class="search-result-title">
                                <span style="color: #2563eb; font-weight: 800; margin-right: 4px;">প্রশ্ন:</span> ${questionText}
                            </div>
                            ${answerSnippet ? `
                                <div class="search-qa-box">
                                    <span class="qa-label"><i class="fas fa-reply"></i> উত্তর:</span> ${answerSnippet}
                                </div>` : ''}
                        </a>`;
                }
            });

            body.innerHTML = itemsHTML || `
                <div class="search-empty-state">
                    <p style="margin: 0; color: #64748b;">এই ট্যাবে কোনো ফলাফল পাওয়া যায়নি।</p>
                </div>`;
            container.style.display = 'block';
            selectedIndex = -1;
        }

        // Tab click handling
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeTab = this.getAttribute('data-tab');
                if (cachedData) {
                    renderResults(cachedData, input.value.trim());
                }
            });
        });

        // Trigger Search
        function performSearch(val) {
            const query = val.trim();
            if (clearBtn) {
                clearBtn.style.display = query.length > 0 ? 'block' : 'none';
            }

            if (query.length === 0) {
                container.style.display = 'none';
                cachedData = null;
                return;
            }

            showLoading();

            fetch(`${AJAX_SEARCH_URL}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    // Check if current input still matches query
                    if (input.value.trim() === query) {
                        renderResults(data, query);
                    }
                })
                .catch(err => {
                    console.error('AJAX Live Search Error:', err);
                    if (body) {
                        body.innerHTML = `
                            <div class="search-empty-state">
                                <p style="margin: 0; color: #ef4444;"><i class="fas fa-exclamation-triangle"></i> অনুসন্ধানে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।</p>
                            </div>`;
                    }
                });
        }

        // Input listener with debounce
        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                performSearch(this.value);
            }, 220);
        });

        // Focus listener to reopen if text exists
        input.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && cachedData) {
                renderResults(cachedData, this.value.trim());
            }
        });

        // Clear button
        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                input.value = '';
                this.style.display = 'none';
                container.style.display = 'none';
                input.focus();
            });
        }

        // Keyboard navigation (Arrow keys + Enter + Escape)
        input.addEventListener('keydown', function(e) {
            const items = body ? body.querySelectorAll('.search-result-item') : [];
            if (!items.length || container.style.display === 'none') return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = (selectedIndex + 1) % items.length;
                updateSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                updateSelection(items);
            } else if (e.key === 'Enter') {
                if (selectedIndex >= 0 && items[selectedIndex]) {
                    e.preventDefault();
                    items[selectedIndex].click();
                }
            } else if (e.key === 'Escape') {
                container.style.display = 'none';
            }
        });

        function updateSelection(items) {
            items.forEach((item, idx) => {
                if (idx === selectedIndex) {
                    item.classList.add('selected');
                    item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    item.classList.remove('selected');
                }
            });
        }

        // Document click to close on outside click
        document.addEventListener('click', function(e) {
            if (!form.contains(e.target) && !container.contains(e.target)) {
                container.style.display = 'none';
                if (isHeader && !input.value.trim()) {
                    input.style.width = '0px';
                    input.style.opacity = '0';
                    input.style.border = 'none';
                    input.style.background = 'transparent';
                }
            }
        });
    }

    // 1. Initialize Header Expandable Search Bar
    const headerInput = document.getElementById('header-search-input');
    const headerBtn = document.getElementById('header-search-btn');
    const headerForm = document.getElementById('header-search-form');
    const headerDropdown = document.getElementById('header-search-dropdown');
    const headerClearBtn = document.getElementById('header-search-clear-btn');

    if (headerInput && headerBtn) {
        headerBtn.addEventListener('click', function(e) {
            if (headerInput.style.width === '0px' || !headerInput.style.width || headerInput.style.width === '0') {
                headerInput.style.width = '240px';
                headerInput.style.opacity = '1';
                headerInput.style.border = '1px solid var(--primary)';
                headerInput.style.background = '#ffffff';
                headerInput.focus();
            } else {
                if (headerInput.value.trim()) {
                    headerForm.submit();
                } else {
                    headerInput.focus();
                }
            }
        });

        initLiveSearch({
            input: headerInput,
            container: headerDropdown,
            form: headerForm,
            clearBtn: headerClearBtn,
            isHeader: true
        });
    }

    // 2. Initialize Search Popup Overlay Modal
    const searchTrigger = document.getElementById('search-popup-trigger');
    const mobileSearchTrigger = document.getElementById('mobile-search-popup-trigger');
    const searchModal = document.getElementById('search-popup-modal');
    const searchClose = document.getElementById('search-popup-close');
    const searchContent = document.getElementById('search-popup-content');
    const modalInput = document.getElementById('search-popup-input');
    const modalForm = document.getElementById('search-popup-form');
    const modalResults = document.getElementById('modal-search-results');
    const modalClearBtn = document.getElementById('modal-search-clear-btn');

    if (searchModal && modalInput) {
        const openModal = function() {
            searchModal.style.opacity = '1';
            searchModal.style.visibility = 'visible';
            searchContent.style.transform = 'scale(1)';
            setTimeout(() => {
                modalInput.focus();
            }, 100);
        };

        if (searchTrigger) searchTrigger.addEventListener('click', openModal);
        if (mobileSearchTrigger) mobileSearchTrigger.addEventListener('click', openModal);

        const closeModal = () => {
            searchModal.style.opacity = '0';
            searchModal.style.visibility = 'hidden';
            searchContent.style.transform = 'scale(0.9)';
            if (modalResults) modalResults.style.display = 'none';
        };

        if (searchClose) searchClose.addEventListener('click', closeModal);
        
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchModal.style.visibility === 'visible') {
                closeModal();
            }
        });

        initLiveSearch({
            input: modalInput,
            container: modalResults,
            form: modalForm,
            clearBtn: modalClearBtn,
            isHeader: false
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.mega-tab-btn');
    const panes = document.querySelectorAll('.mega-tab-pane');

    tabs.forEach(tab => {
        const handleSwitch = (e) => {
            // Ignore if clicking or hovering directly on expander button
            if (e.target.closest('.mega-cat-expander')) {
                return;
            }

            const targetLink = tab.getAttribute('data-link');
            
            // On mobile, clicking category button should navigate directly into that category!
            if (window.innerWidth <= 1200) {
                if (e.type === 'click') {
                    if (targetLink && targetLink !== '#' && targetLink !== '') {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.href = targetLink;
                        return;
                    }
                }
                return;
            }

            // On Desktop: Clicking category/subcategory navigates directly to that category page
            if (e.type === 'click') {
                if (targetLink && targetLink !== '#' && targetLink !== '') {
                    window.location.href = targetLink;
                    return;
                }
            }

            // On Desktop Hover (mouseenter): Switch active tab and active right-side post pane
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            const tabId = tab.getAttribute('data-tab');
            const targetPane = document.getElementById('pane-' + tabId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        };

        // Switch post panel on hover (mouseenter) on desktop and handle click navigation
        tab.addEventListener('mouseenter', handleSwitch);
        tab.addEventListener('click', handleSwitch);
    });

    // Realtime digital clock update in Bengali
    function updateClock() {
        const clockEl = document.getElementById('topbar-clock');
        if (!clockEl) return;
        const now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'পিএম' : 'এএম';
        
        hours = hours % 12;
        hours = hours ? hours : 12;
        
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        hours = hours < 10 ? '0' + hours : hours;
        
        const enDigits = ['0','1','2','3','4','5','6','7','8','9'];
        const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        const convertToBn = (str) => {
            return str.toString().split('').map(char => {
                const idx = enDigits.indexOf(char);
                return idx !== -1 ? bnDigits[idx] : char;
            }).join('');
        };
        
        clockEl.textContent = `${convertToBn(hours)}:${convertToBn(minutes)}:${convertToBn(seconds)} ${ampm}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ── Hover Intent for Mega Menu & Submenu ──────────────────────────
    // Delay hiding so the mouse can cross any gap between nav & dropdown
    function hoverIntent(items, delay) {
        items.forEach(function(item) {
            var timer = null;

            item.addEventListener('mouseenter', function() {
                if (window.innerWidth <= 1200) return;
                clearTimeout(timer);
                // Close all siblings first
                items.forEach(function(other) {
                    if (other !== item) other.classList.remove('open');
                });
                item.classList.add('open');
            });

            item.addEventListener('mouseleave', function() {
                if (window.innerWidth <= 1200) return;
                timer = setTimeout(function() {
                    item.classList.remove('open');
                }, delay);
            });

            // If mouse enters the dropdown itself, cancel the hide timer
            var dropdown = item.querySelector('.megamenu-dropdown, .submenu-dropdown');
            if (dropdown) {
                dropdown.addEventListener('mouseenter', function() {
                    if (window.innerWidth <= 1200) return;
                    clearTimeout(timer);
                    item.classList.add('open');
                });
                dropdown.addEventListener('mouseleave', function() {
                    if (window.innerWidth <= 1200) return;
                    timer = setTimeout(function() {
                        item.classList.remove('open');
                    }, delay);
                });
            }
        });
    }

    hoverIntent(document.querySelectorAll('.nav-item-megamenu'), 200);
    hoverIntent(document.querySelectorAll('.nav-item-dropdown'), 150);

    // Scroll indicator helper
    const initScrollIndicators = () => {
        const sidebars = document.querySelectorAll('.megamenu-sidebar');
        sidebars.forEach(sidebar => {
            const wrapper = sidebar.closest('.megamenu-sidebar-wrapper');
            if (!wrapper) return;
            const indicator = wrapper.querySelector('.megamenu-scroll-indicator');
            if (!indicator) return;

            const checkScroll = () => {
                const isScrollable = sidebar.scrollHeight > sidebar.clientHeight;
                const isAtBottom = sidebar.scrollTop + sidebar.clientHeight >= sidebar.scrollHeight - 10;
                
                if (isScrollable && !isAtBottom) {
                    indicator.classList.add('visible');
                } else {
                    indicator.classList.remove('visible');
                }
            };

            sidebar.addEventListener('scroll', checkScroll);
            
            const parentMegamenu = sidebar.closest('.nav-item-megamenu');
            if (parentMegamenu) {
                parentMegamenu.addEventListener('mouseenter', () => {
                    setTimeout(checkScroll, 150);
                });
            }
            
            checkScroll();
        });
    };
    initScrollIndicators();

    // Mobile Menu Toggle
    const mobileToggle = document.querySelector('.mobile-nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                if (navLinks.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                } else {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !mobileToggle.contains(e.target)) {
                navLinks.classList.remove('active');
                const icon = mobileToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }
        });
    }

    // Toggle mobile social dropdown
    const socialDropdown = document.querySelector('.mobile-social-dropdown');
    const socialBtn = document.querySelector('.mobile-social-btn');
    
    // Toggle mobile top bar submenus dropdown
    const topmenuDropdown = document.querySelector('.mobile-topmenu-dropdown');
    const topmenuBtn = document.querySelector('.mobile-topmenu-btn');
    
    if (socialBtn && socialDropdown) {
        socialBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (topmenuDropdown) topmenuDropdown.classList.remove('active');
            socialDropdown.classList.toggle('active');
        });
        document.addEventListener('click', function(e) {
            if (!socialDropdown.contains(e.target)) {
                socialDropdown.classList.remove('active');
            }
        });
    }

    if (topmenuBtn && topmenuDropdown) {
        topmenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (socialDropdown) socialDropdown.classList.remove('active');
            topmenuDropdown.classList.toggle('active');
        });
        document.addEventListener('click', function(e) {
            if (!topmenuDropdown.contains(e.target)) {
                topmenuDropdown.classList.remove('active');
            }
        });
    }

    // Toggle mega/dropdown on click (primarily for mobile view)
    document.querySelectorAll('.megamenu-trigger, .dropdown-trigger').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 1200) {
                const isToggleBtn = e.target.closest('.megamenu-toggle-arrow') || e.target.closest('.fa-chevron-down') || e.target.closest('.fa-chevron-up');
                const targetUrl = link.getAttribute('href');
                const parent = link.closest('.nav-item-megamenu, .nav-item-dropdown');

                // If clicking the dedicated expand/collapse button
                if (isToggleBtn) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (parent) {
                        const isOpen = parent.classList.contains('open');
                        
                        if (isOpen) {
                            // Collapse on second click
                            parent.classList.remove('open');
                        } else {
                            // Close other submenus first
                            document.querySelectorAll('.nav-item-megamenu, .nav-item-dropdown').forEach(item => {
                                if (item !== parent) item.classList.remove('open');
                            });
                            
                            parent.classList.add('open');
                            // Trigger scroll check on newly opened mega menu sidebar
                            setTimeout(() => {
                                const sidebar = parent.querySelector('.megamenu-sidebar');
                                if (sidebar) {
                                    const wrapper = sidebar.closest('.megamenu-sidebar-wrapper');
                                    const indicator = wrapper ? wrapper.querySelector('.megamenu-scroll-indicator') : null;
                                    if (indicator) {
                                        const isScrollable = sidebar.scrollHeight > sidebar.clientHeight;
                                        const isAtBottom = sidebar.scrollTop + sidebar.clientHeight >= sidebar.scrollHeight - 10;
                                        if (isScrollable && !isAtBottom) {
                                            indicator.classList.add('visible');
                                        } else {
                                            indicator.classList.remove('visible');
                                        }
                                    }
                                }
                            }, 100);
                        }
                    }
                    return;
                }

                // If clicking anywhere else on "সবগুলো নিবন্ধ" or the menu link:
                // If it has a valid target link, navigate to that page/category!
                if (targetUrl && targetUrl !== '#' && targetUrl !== '') {
                    window.location.href = targetUrl;
                    return;
                } else {
                    // Fallback if URL is '#': toggle open/close
                    e.preventDefault();
                    e.stopPropagation();
                    if (parent) {
                        parent.classList.toggle('open');
                    }
                }
            } else {
                if (!link.getAttribute('href') || link.getAttribute('href') === '#') {
                    e.preventDefault();
                }
            }
        });
    });
});
</script>


