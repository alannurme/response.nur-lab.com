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
    $site_name = $data['settings']['site_title'] ?? 'Response with Nur-Lab';
    
    // Default fallback from global settings
    $meta_description = $data['settings']['meta_description'] ?? '';
    $meta_keywords = $data['settings']['meta_keywords'] ?? '';
    $meta_author = $data['settings']['site_title'] ?? 'Response with Nur-Lab';
    $og_title = $site_name;
    $og_description = $meta_description;
    $og_image = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : '';
    $og_url = URLROOT . '/' . ($_GET['url'] ?? '');
    
    // Check if we are viewing a single post
    if (isset($data['post']) && !empty($data['post'])) {
        $post = $data['post'];
        
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
        }
    } else {
        // We are on general pages (Home, Category, list pages)
        if (isset($data['title']) && strtolower($data['title']) === 'home') {
            $seo_title = $site_name . (!empty($data['settings']['site_tagline']) ? ' - ' . $data['settings']['site_tagline'] : '');
        } else {
            $seo_title = (!empty($data['title']) ? $data['title'] . ' - ' : '') . $site_name;
        }
    }
    ?>
    <title><?= htmlspecialchars($seo_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars(strip_tags($meta_description)) ?>">
    <meta name="keywords" content="<?= htmlspecialchars(strip_tags($meta_keywords)) ?>">
    <meta name="author" content="<?= htmlspecialchars($meta_author) ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= isset($data['post']) ? 'article' : 'website' ?>">
    <meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(strip_tags($og_description)) ?>">
    <?php if (!empty($og_image)): ?>
        <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
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
    <?php endif; ?>
    <!-- Google Fonts: Noto Sans Bengali for Bengali -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@300;400;500;600;700;800;900&family=Noto+Serif+Bengali:wght@400;500;600;700;800&family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                    $db = \Config\Database::pdoConnect();
                    $social_links_stmt = $db->query("SELECT url FROM social_links ORDER BY order_index ASC, id ASC");
                    $social_urls = $social_links_stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];
                    
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
            $schema_json = json_encode($fallback, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
    } else {
        // Global Website Schema for non-post pages
        $schema_json = json_encode([
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => $site_name,
            "url" => URLROOT . "/",
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => URLROOT . "/search?q={search_term_string}"
                ],
                "query-input" => "required name=search_term_string"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
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

        .fa, .fas, .far {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
        }
        .fab {
            font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
        }

        html, body {
            overflow-x: clip;
            width: 100%;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            background-image: radial-gradient(at 0% 0%, hsla(158,100%,94%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(158,100%,96%,1) 0, transparent 50%);
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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 8px 40px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
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
            background: var(--bg-dark);
            padding: 10px 0;
            border-bottom: 2px solid #ffffff;
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

        /* Services Megamenu Dropdown styling matching the dark premium style */
        .megamenu-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #111a2c;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
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
            width: 280px;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
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
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }
        .megamenu-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }
        .megamenu-sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        .megamenu-scroll-indicator {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
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
            gap: 12px;
            padding: 10px 20px;
            border-radius: 10px;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
            line-height: 1.5;
            font-family: 'Hind Siliguri', sans-serif;
            border-left: 3px solid transparent;
        }

        .mega-tab-btn i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: var(--primary);
        }

        .mega-tab-btn:hover {
            color: #ffffff;
        }

        .mega-tab-btn.active {
            color: #ffffff;
            border-left: 3px solid var(--primary);
        }

        .mega-tab-btn span {
            border-bottom: 2px solid transparent;
            transition: border-color 0.2s ease;
            padding-bottom: 2px;
        }

        .mega-tab-btn:hover span,
        .mega-tab-btn.active span {
            border-bottom-color: var(--primary);
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
        }

        /* Grid layout for service items */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }

        .service-card {
            background: #19253f;
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 12px;
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
            color: var(--primary);
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
            background: #202e4e;
            border-color: rgba(37, 99, 235, 0.3);
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
                background: #111a2c;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
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
                background: #111a2c;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
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
                margin-top: 0 !important;
                width: 100% !important;
            }

            .mobile-nav-toggle {
                display: block; /* Show hamburger button */
            }

            .mobile-search-trigger {
                display: inline-flex !important;
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

            /* Separators between main items */
            .nav-links > li {
                border-bottom: 1px solid #f1f5f9;
                width: 100%;
                list-style: none;
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

            .mega-tab-btn {
                border-bottom: 1px solid #f1f5f9 !important;
                border-left: none !important;
                padding: 14px 24px 14px 40px !important;
                color: #334155 !important;
                font-weight: 600 !important;
                background: #f8fafc !important;
                justify-content: space-between !important;
                display: flex !important;
                align-items: center !important;
                border-radius: 0 !important;
                flex-shrink: 0 !important;
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
                border-bottom: 1px solid #e2e8f0 !important;
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
<body>



<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
<?php 
$current_uri = $_GET['url'] ?? '';
$is_homepage = empty($current_uri) || $current_uri === '/' || $current_uri === 'home' || $current_uri === 'index';
if ($is_homepage): 
?>
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
                        <?php 
                            $t = trim($submenu['title']);
                            if ($t === 'সপ' || strpos($submenu['url'], 'shop') !== false || $t === 'আমাদের সাথে যুক্ত হোন' || strpos($submenu['url'], 'join') !== false) continue; 
                        ?>
                        <li>
                            <a href="<?= (strpos($submenu['url'], 'http') === 0) ? $submenu['url'] : URLROOT . $submenu['url'] ?>">
                                <?= $submenu['title'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <!-- Right Side: Social Icons & Donation -->
            <div class="top-menu-right">
                <!-- Donation Button -->
                <a href="<?= URLROOT ?>/donate" style="background: #ffffff; color: var(--bg-dark); font-weight: 700; font-size: 0.85rem; padding: 4px 12px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: 0.2s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <i class="fas fa-hand-holding-heart" style="color: #16a34a; font-size: 0.85rem;"></i>
                    <span class="topbar-donation-label">ডোনেশন</span>
                </a>
                
                <!-- Vertical Divider -->
                <span class="topbar-divider" style="opacity: 0.2; color: white;">|</span>

                <?php
                $db = \Config\Database::pdoConnect();
                $social_links_stmt = $db->query("SELECT * FROM social_links ORDER BY order_index ASC, id ASC");
                $social_links = $social_links_stmt->fetchAll();
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
                                <?php 
                                    $t = trim($submenu['title']);
                                    if ($t === 'সপ' || strpos($submenu['url'], 'shop') !== false || $t === 'আমাদের সাথে যুক্ত হোন' || strpos($submenu['url'], 'join') !== false) continue; 
                                ?>
                                <a href="<?= (strpos($submenu['url'], 'http') === 0) ? $submenu['url'] : URLROOT . $submenu['url'] ?>" style="color: #ffffff;">
                                    <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: var(--primary);"></i>
                                    <span><?= $submenu['title'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</div>

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
                <!-- Mobile Search Button -->
                <div class="mobile-search-trigger" id="mobile-search-popup-trigger" style="color: var(--primary); font-size: 1.15rem; cursor: pointer; transition: 0.3s; width: 40px; height: 40px; border-radius: 50%; background: rgba(0, 107, 67, 0.06); display: none; align-items: center; justify-content: center;">
                    <i class="fas fa-search"></i>
                </div>
                
                <!-- Mobile Menu Toggle Button -->
                <button class="mobile-nav-toggle" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav-links">
                <?php 
                if(!empty($data['menus'])): 
                    $all_menus = $data['menus'];
                    $top_menus = array_filter($all_menus, function($m) { return empty($m['parent_id']); });
                    usort($top_menus, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                    
                    $db = \Config\Database::pdoConnect();
                    
                    foreach($top_menus as $menu):
                        $menu_type = $menu['menu_type'] ?? 'custom';
                        
                        if ($menu_type === 'post_mega'):
                            $cat_ids = json_decode($menu['category_source'] ?? '[]', true);
                            if (!empty($cat_ids)):
                                $in_placeholder = implode(',', array_fill(0, count($cat_ids), '?'));
                                $stmt = $db->prepare("SELECT * FROM categories WHERE id IN ($in_placeholder) ORDER BY order_index ASC, name ASC");
                                $stmt->execute(array_values($cat_ids));
                                $categories = $stmt->fetchAll();
                                ?>
                                <li class="nav-item-megamenu">
                                    <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="megamenu-trigger"><?= htmlspecialchars($menu['title']) ?> <i class="fas fa-chevron-down" style="font-size: 11px; margin-left: 4px;"></i></a>
                                    
                                    <div class="megamenu-dropdown">
                                        <div class="megamenu-inner">
                                            <!-- Left Sidebar Tabs -->
                                            <div class="megamenu-sidebar-wrapper">
                                                <div class="megamenu-sidebar">
                                                    <?php 
                                                    $is_first = true;
                                                    foreach($categories as $cat): 
                                                        $tab_slug = 'post-cat-' . $cat['id'];
                                                    ?>
                                                        <div class="mega-tab-btn <?= $is_first ? 'active' : '' ?>" data-tab="<?= $tab_slug ?>" data-link="<?= URLROOT . '/' . $cat['slug'] ?>">
                                                            <i class="fa-solid fa-layer-group"></i>
                                                            <span><?= htmlspecialchars($cat['name']) ?></span>
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
                                        <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="megamenu-trigger"><?= htmlspecialchars($menu['title']) ?> <i class="fas fa-chevron-down" style="font-size: 11px; margin-left: 4px;"></i></a>
                                        
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
                                        <a href="<?= (strpos($menu['url'], 'http') === 0) ? $menu['url'] : (trim($menu['url']) === '#' ? '#' : URLROOT . $menu['url']) ?>" class="dropdown-trigger"><?= htmlspecialchars($menu['title']) ?> <i class="fas fa-chevron-down" style="font-size: 11px; margin-left: 4px;"></i></a>
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
                
                <!-- Header Expandable Search Bar -->
                <li style="margin-left: auto; display: flex; align-items: center; list-style: none; padding-left: 15px;">
                    <form action="<?= URLROOT ?>/blog" method="GET" id="header-search-form" style="position: relative; display: flex; align-items: center; height: 38px;">
                        <input type="text" name="search" id="header-search-input" placeholder="খুঁজুন (যেমন: রমজান, জাকাত)..." required style="padding: 7px 40px 7px 14px; border-radius: 20px; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; outline: none; width: 0px; opacity: 0; border: none; background: transparent; transition: all 0.35s ease; box-sizing: border-box;" onblur="if(!this.value.trim()){ this.style.width='0px'; this.style.opacity='0'; this.style.border='none'; this.style.background='transparent'; }">
                        <button type="button" id="header-search-btn" style="background: rgba(0, 107, 67, 0.06); border: none; color: var(--primary); cursor: pointer; font-size: 1rem; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s; flex-shrink: 0;" onclick="const input = document.getElementById('header-search-input'); if(input.style.width === '0px' || !input.style.width || input.style.width === '0'){ input.style.width='220px'; input.style.opacity='1'; input.style.border='1px solid var(--primary)'; input.style.background='#ffffff'; input.focus(); } else { if(input.value.trim()){ document.getElementById('header-search-form').submit(); } }">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </li>

            </ul>


        </nav>
    </div>
</div>

<!-- Search Popup Overlay Modal -->
<div id="search-popup-modal" style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); z-index: 99999; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: 0.3s ease;">
    <div style="position: absolute; top: 30px; right: 30px; color: white; font-size: 2rem; cursor: pointer; transition: 0.2s; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: rgba(255,255,255,0.08);" id="search-popup-close" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='rotate(90deg)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.transform='rotate(0)';">
        <i class="fas fa-times"></i>
    </div>
    
    <div style="width: 100%; max-width: 650px; padding: 20px; text-align: center; transform: scale(0.9); transition: 0.3s ease;" id="search-popup-content">
        <h2 style="color: white; font-size: 2.2rem; font-weight: 800; margin-bottom: 25px; font-family: 'Hind Siliguri', sans-serif;">আপনি কি খুঁজছেন?</h2>
        <form action="<?= URLROOT ?>/blog" method="GET" style="position: relative; background: white; border-radius: 50px; padding: 8px 10px; display: flex; align-items: center; box-shadow: 0 25px 50px rgba(0,0,0,0.3); border: 2px solid transparent; transition: 0.3s;" onfocusin="this.style.borderColor='var(--primary)';">
            <input type="text" name="search" id="search-popup-input" placeholder="এখানে লিখুন (যেমন: রমজান, জাকাত, সালাত)..." required style="width: 100%; padding: 15px 25px; border: none; outline: none; font-size: 1.25rem; font-weight: 600; font-family: 'Hind Siliguri', sans-serif; color: var(--text-main); border-radius: 50px;">
            <button type="submit" style="background: var(--primary); color: white; border: none; border-radius: 50%; width: 55px; height: 55px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; box-shadow: 0 10px 20px var(--primary-glow);" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                <i class="fas fa-search" style="font-size: 1.3rem;"></i>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchTrigger = document.getElementById('search-popup-trigger');
    const mobileSearchTrigger = document.getElementById('mobile-search-popup-trigger');
    const searchModal = document.getElementById('search-popup-modal');
    const searchClose = document.getElementById('search-popup-close');
    const searchContent = document.getElementById('search-popup-content');
    const searchInput = document.getElementById('search-popup-input');

    if (searchModal) {
        const openModal = function() {
            searchModal.style.opacity = '1';
            searchModal.style.visibility = 'visible';
            searchContent.style.transform = 'scale(1)';
            setTimeout(() => {
                searchInput.focus();
            }, 100);
        };

        if (searchTrigger) searchTrigger.addEventListener('click', openModal);
        if (mobileSearchTrigger) mobileSearchTrigger.addEventListener('click', openModal);

        const closeModal = () => {
            searchModal.style.opacity = '0';
            searchModal.style.visibility = 'hidden';
            searchContent.style.transform = 'scale(0.9)';
        };

        searchClose.addEventListener('click', closeModal);
        
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
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.mega-tab-btn');
    const panes = document.querySelectorAll('.mega-tab-pane');

    tabs.forEach(tab => {
        const handleSwitch = (e) => {
            const isAlreadyActive = tab.classList.contains('active');
            const targetLink = tab.getAttribute('data-link');
            
            // Prevent direct navigation on mobile viewports so user can expand/select tab
            if (window.innerWidth <= 1200) {
                const tabId = tab.getAttribute('data-tab');
                if (tabId && tabId.startsWith('post-cat-')) {
                    if (targetLink) {
                        window.location.href = targetLink;
                    }
                    return;
                }
                
                e.preventDefault();
                e.stopPropagation();
                
                if (e.type === 'mouseenter') return; // Bypass hover on mobile
                
                const targetPane = document.getElementById('pane-' + tabId);
                if (targetPane) {
                    const parentMenu = tab.closest('.megamenu-inner');
                    
                    if (isAlreadyActive) {
                        // Collapse it
                        tab.classList.remove('active');
                        targetPane.classList.remove('active');
                        // Move pane back to content container
                        const contentDiv = parentMenu.querySelector('.megamenu-content');
                        if (contentDiv) {
                            contentDiv.appendChild(targetPane);
                        }
                    } else {
                        // Close other tabs first
                        parentMenu.querySelectorAll('.mega-tab-btn').forEach(t => t.classList.remove('active'));
                        parentMenu.querySelectorAll('.mega-tab-pane').forEach(p => {
                            p.classList.remove('active');
                            const contentDiv = parentMenu.querySelector('.megamenu-content');
                            if (contentDiv && p.parentNode !== contentDiv) {
                                contentDiv.appendChild(p);
                            }
                        });
                        
                        // Open this tab
                        tab.classList.add('active');
                        targetPane.classList.add('active');
                        // Move pane to be directly after the tab button
                        tab.parentNode.insertBefore(targetPane, tab.nextSibling);
                    }
                }
                return;
            } else if (e.type === 'click' && isAlreadyActive && targetLink) {
                window.location.href = targetLink;
                return;
            }

            // If mouseenter triggers on mobile, bypass it
            if (e.type === 'mouseenter' && window.innerWidth <= 1200) {
                return;
            }

            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            const tabId = tab.getAttribute('data-tab');
            const targetPane = document.getElementById('pane-' + tabId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        };

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
                const parent = link.closest('.nav-item-megamenu, .nav-item-dropdown');
                if (parent) {
                    const isOpen = parent.classList.contains('open');
                    
                    if (isOpen) {
                        // If already open, let it navigate to the link (if valid)
                        const targetUrl = link.getAttribute('href');
                        if (targetUrl && targetUrl !== '#') {
                            window.location.href = targetUrl;
                            return;
                        }
                        parent.classList.remove('open');
                    } else {
                        e.preventDefault();
                        e.stopPropagation();
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
            } else {
                if (!link.getAttribute('href') || link.getAttribute('href') === '#') {
                    e.preventDefault();
                }
            }
        });
    });
});
</script>
