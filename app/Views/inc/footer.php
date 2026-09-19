<footer style="background: linear-gradient(180deg, #0b1329 0%, #060b18 100%); color: #e2e8f0; padding: 75px 0 35px; border-top: 1px solid rgba(255, 255, 255, 0.08); position: relative; overflow: hidden; margin-top: 80px;">
    <!-- Background Glow Accent -->
    <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 80%; height: 1px; background: linear-gradient(90deg, transparent 0%, #10b981 50%, transparent 100%); opacity: 0.6;"></div>

    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px; position: relative; z-index: 2;">
        <!-- About Section -->
        <div>
            <div class="footer-logo" style="margin-bottom: 20px;">
                <a href="<?= URLROOT ?>/" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
                    <?php if (!empty($data['settings']['site_logo'])): ?>
                        <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo" style="max-height: 52px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));">
                    <?php else: ?>
                        <i class="fas fa-kaaba" style="color: #10b981; font-size: 1.8rem;"></i>
                        <span style="color: #ffffff; font-weight: 800; font-size: 1.35rem; font-family: 'Hind Siliguri', sans-serif;">নূর<span style="color: #10b981;">ল্যাব</span></span>
                    <?php endif; ?>
                </a>
            </div>
            <h4 style="color: #ffffff; margin-bottom: 14px; font-size: 1.15rem; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; border-bottom: 2px solid #10b981; display: inline-block; padding-bottom: 4px;">আমাদের সম্পর্কে</h4>
            <p style="line-height: 1.85; margin-bottom: 25px; font-family: 'Hind Siliguri', sans-serif; color: #cbd5e1; font-size: 0.96rem; text-align: justify; max-width: 320px;">
                response with nur-lab একটি অলাভজনক অনলাইন প্ল্যাটফর্ম, যেখানে বিশ্বের বিভিন্ন প্রান্তের মুসলিম লেখকরা ইসলাম, দর্শন, বিজ্ঞান ও সমসাময়িক বিষয় নিয়ে আলোচনা ও গবেষণায় যুক্ত হন।
            </p>
            <div class="top-social" style="display: flex; gap: 12px;">
                <?php
                $db = \Config\Database::pdoConnect();
                $social_links_stmt = $db->query("SELECT * FROM social_links ORDER BY order_index ASC, id ASC");
                $social_links = $social_links_stmt->fetchAll();
                foreach ($social_links as $link): 
                    $hover_color = '#10b981';
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
                    <a href="<?= $link['url'] ?>" target="_blank" title="<?= htmlspecialchars($link['name']) ?>" style="width: 38px; height: 38px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #f8fafc; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='<?= $hover_color ?>'; this.style.borderColor='<?= $hover_color ?>'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.12)'; this.style.transform='none';">
                        <i class="<?= htmlspecialchars($link['icon']) ?>" style="font-size: 0.95rem;"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 style="color: #ffffff; margin-bottom: 22px; font-size: 1.15rem; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; border-bottom: 2px solid #10b981; display: inline-block; padding-bottom: 4px;">প্রয়োজনীয় লিংক</h4>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <?php
                $db = \Config\Database::pdoConnect();
                $menus_stmt = $db->query("SELECT * FROM sub_menus ORDER BY order_index ASC");
                $footer_menus = $menus_stmt->fetchAll();
                foreach ($footer_menus as $menu):
                    $t = trim($menu['title']);
                    if ($t === 'সপ' || strpos($menu['url'], 'shop') !== false || $t === 'আমাদের সাথে যুক্ত হোন' || strpos($menu['url'], 'join') !== false) continue;
                    $menu_url = (strpos($menu['url'], 'http') === 0) ? clean_localhost_url($menu['url']) : URLROOT . $menu['url'];
                ?>
                    <li style="margin-bottom: 12px; display: flex; align-items: center;">
                        <i class="fas fa-chevron-right" style="font-size: 0.75rem; color: #10b981; margin-right: 8px;"></i>
                        <a href="<?= $menu_url ?>" style="color: #cbd5e1; font-family: 'Hind Siliguri', sans-serif; font-size: 0.98rem; text-decoration: none; font-weight: 500; transition: all 0.3s;"><?= htmlspecialchars($menu['title']) ?></a>
                    </li>
                <?php endforeach; ?>
                <li style="margin-bottom: 12px; display: flex; align-items: center;">
                    <i class="fas fa-chevron-right" style="font-size: 0.75rem; color: #10b981; margin-right: 8px;"></i>
                    <a href="<?= URLROOT ?>/donate" style="color: #cbd5e1; font-family: 'Hind Siliguri', sans-serif; font-size: 0.98rem; text-decoration: none; font-weight: 500; transition: all 0.3s;">অনুদান দিন</a>
                </li>
            </ul>
        </div>

        <!-- Popular News Section -->
        <div>
            <h4 style="color: #ffffff; margin-bottom: 22px; font-size: 1.15rem; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; border-bottom: 2px solid #10b981; display: inline-block; padding-bottom: 4px;">জনপ্রিয় লেখা</h4>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <?php
                if (!function_exists('formatBengaliDate')) {
                    function formatBengaliDate($date_str) {
                        $timestamp = strtotime($date_str);
                        $en_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $bn_months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
                        
                        $en_num = ['0','1','2','3','4','5','6','7','8','9'];
                        $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                        
                        $day_num = str_replace($en_num, $bn_num, date('d', $timestamp));
                        $month_name = str_replace($en_months, $bn_months, date('F', $timestamp));
                        $year_num = str_replace($en_num, $bn_num, date('Y', $timestamp));
                        
                        return "$day_num $month_name, $year_num";
                    }
                }
                
                if (!function_exists('toBengaliNumber')) {
                    function toBengaliNumber($number) {
                        $en_num = ['0','1','2','3','4','5','6','7','8','9'];
                        $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                        return str_replace($en_num, $bn_num, $number);
                    }
                }

                $db = \Config\Database::pdoConnect();
                $popular_posts_stmt = $db->query("
                    SELECT p.*, c.name as category_name 
                    FROM posts p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.status = 'published' 
                    ORDER BY p.views DESC, p.created_at DESC 
                    LIMIT 3
                ");
                $popular_posts = $popular_posts_stmt->fetchAll();

                foreach ($popular_posts as $post):
                    $comments_stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ? AND status = 'approved'");
                    $comments_stmt->execute([$post['id']]);
                    $comments_count = $comments_stmt->fetchColumn();
                    
                    $post_link = URLROOT . '/' . $post['slug'];
                    $image_src = resolve_blog_image($post['featured_image']);
                ?>
                    <div style="display: flex; gap: 14px; align-items: center; background: rgba(255, 255, 255, 0.03); padding: 10px 12px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.06); transition: all 0.3s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.07)'; this.style.borderColor='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.borderColor='rgba(255, 255, 255, 0.06)';">
                        <div style="flex-shrink: 0; width: 75px; height: 55px; overflow: hidden; border-radius: 8px; background: rgba(0,0,0,0.2);">
                            <?php if (!empty($post['featured_image'])): ?>
                                <a href="<?= $post_link ?>" style="display: block; width: 100%; height: 100%;">
                                    <img src="<?= $image_src ?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                            <?php else: ?>
                                <a href="<?= $post_link ?>" style="display: flex; width: 100%; height: 100%; align-items: center; justify-content: center; text-decoration: none; color: #94a3b8;">
                                    <i class="fa-regular fa-image" style="font-size: 1.1rem;"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div style="flex-grow: 1; overflow: hidden;">
                            <h5 style="margin: 0 0 4px 0; font-size: 0.92rem; font-weight: 700; line-height: 1.35; font-family: 'Hind Siliguri', sans-serif;">
                                <a href="<?= $post_link ?>" style="color: #f8fafc; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: 0.2s;" onmouseover="this.style.color='#10b981';" onmouseout="this.style.color='#f8fafc';"><?= htmlspecialchars($post['title']) ?></a>
                            </h5>
                            <div style="display: flex; gap: 8px; align-items: center; font-size: 0.75rem; color: #94a3b8; font-family: 'Hind Siliguri', sans-serif;">
                                <span style="color: #10b981; font-weight: 700;"><?= htmlspecialchars($post['category_name'] ?? 'নিউজ') ?></span>
                                <span>•</span>
                                <span><?= formatBengaliDate($post['created_at']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Actions & Apps -->
        <?php 
        $app_url = $data['settings']['app_download_url'] ?? '';
        if (!empty($app_url)): 
        ?>
        <div>
            <h4 style="color: #ffffff; margin-bottom: 22px; font-size: 1.15rem; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; border-bottom: 2px solid #10b981; display: inline-block; padding-bottom: 4px;">মোবাইল অ্যাপস</h4>
            <div style="display: flex; flex-direction: column; gap: 15px; max-width: 250px;">
                <a href="<?= htmlspecialchars($app_url) ?>" target="_blank" class="btn-footer btn-footer-success" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 14px 22px; border-radius: 12px; font-weight: 800; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.3s; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); border: 1px solid rgba(255, 255, 255, 0.2);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 25px rgba(16, 185, 129, 0.45)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)';">
                    <i class="fab fa-android" style="font-size: 1.3rem;"></i> আমাদের অ্যাপস ডাউনলোড করুন
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <!-- Copyright -->
    <div class="container footer-copyright-wrapper">
        <div style="font-size: 0.92rem; color: #94a3b8; font-family: 'Hind Siliguri', sans-serif;">
            <?= $data['settings']['footer_copyright'] ?? '&copy; ' . date('Y') . ' NUR-LAB. All Rights Reserved.' ?>
        </div>
        <div style="font-size: 0.92rem; color: #94a3b8; font-family: 'Hind Siliguri', sans-serif;">
            Developed with ❤️ by <a href="https://nur-lab.com/" target="_blank" style="color: #10b981; font-weight: 700; text-decoration: none;">NUR-LAB AGENCY</a>
        </div>
    </div>
</footer>

<style>
    .footer-copyright-wrapper {
        border-top: 1px solid rgba(255,255,255,0.05);
        margin-top: 60px;
        padding: 30px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    @media (max-width: 768px) {
        .footer-copyright-wrapper {
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
            gap: 10px !important;
        }
    }
    footer a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: 0.3s all ease;
    }
    footer a:hover {
        color: var(--primary) !important;
        padding-left: 5px;
    }
    footer a.btn-footer:hover {
        color: #fff !important;
        padding-left: 0 !important;
    }
    footer a.btn-footer-success:hover {
        color: #fff !important;
        padding-left: 0 !important;
    }
    .footer-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .footer-logo i {
        background: var(--primary);
        color: #fff;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.4rem;
        box-shadow: 0 5px 15px rgba(21,128,61,0.3);
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    // Centralized Scroll Reveal Animation Observer
    function initGlobalScrollReveal() {
        // Observe sections instead of the offset columns to prevent intersection failures
        var elements = document.querySelectorAll(
            '.bento-item-left, .bento-item-right, .about-section, .scope-card-animate, .post-card-animate, .video-card-animate, .team-card-animate, .faq-item-animate'
        );
        if (!elements.length) return;

        var observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    
                    // If it is the about-section container, activate animation on all its children
                    if (el.classList.contains('about-section')) {
                        var imgCol = el.querySelector('.about-img-col');
                        var contentCol = el.querySelector('.about-content-col');
                        
                        if (imgCol) {
                            imgCol.style.transform = 'translate3d(0, 0, 0)';
                            imgCol.classList.add('visible');
                        }
                        if (contentCol) {
                            contentCol.style.transform = 'translate3d(0, 0, 0)';
                            contentCol.classList.add('visible');
                            if (!contentCol.classList.contains('home-no-typewriter')) {
                                setTimeout(function() {
                                    triggerTypewriterEffect(contentCol);
                                }, 500);
                            }
                        }
                    } else {
                        el.classList.add('visible');
                    }
                    
                    observer.unobserve(el);
                }
            });
        }, {
            root: null,
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Prepare typewriter elements by saving original content and hiding them initially
        document.querySelectorAll('.about-content-col:not(.home-no-typewriter)').forEach(function(col) {
            // Apply translation offset via JS to avoid CSS layout gap
            col.style.transform = 'translate3d(80px, 0, 0)';
            var imgCol = col.parentElement ? col.parentElement.querySelector('.about-img-col') : null;
            if (imgCol) {
                imgCol.style.transform = 'translate3d(-80px, 0, 0)';
            }

            var children = col.querySelectorAll('span, h2, h3, p');
            children.forEach(function(child) {
                if (!child.hasAttribute('data-original-text')) {
                    child.setAttribute('data-original-text', child.innerHTML);
                    child.setAttribute('data-text-content', child.textContent.trim());
                    child.style.opacity = '0';
                    child.style.visibility = 'hidden';
                }
            });
        });

        elements.forEach(function(el) {
            observer.observe(el);
        });
    }

    // Typewriter effect function
    function triggerTypewriterEffect(container) {
        var children = Array.from(container.querySelectorAll('span, h2, h3, p'));
        if (!children.length) return;

        function typeNext(index) {
            if (index >= children.length) return;
            var child = children[index];
            var text = child.getAttribute('data-text-content') || '';
            child.textContent = '';
            child.style.opacity = '1';
            child.style.visibility = 'visible';
            
            var speed = child.tagName === 'P' ? 8 : 20; 
            var i = 0;
            
            function typeChar() {
                if (i < text.length) {
                    child.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeChar, speed);
                } else {
                    // Restore original HTML structure with styling, highlight tags, etc.
                    child.innerHTML = child.getAttribute('data-original-text');
                    typeNext(index + 1);
                }
            }
            typeChar();
        }
        typeNext(0);
    }

    // Execute animations once HTML is parsed and elements exist in DOM
    document.addEventListener('DOMContentLoaded', function() {
        
        // Premium entry animation for header wrapper
        if (typeof gsap !== 'undefined') {
            gsap.from(".header-wrapper", { duration: 1.2, y: -80, opacity: 0, ease: "power4.out" });
        }

        // Initialize scroll reveal animations
        initGlobalScrollReveal();

        // Failsafe Scroll Reveal trigger (extended to 8s as a backup only if IntersectionObserver fails to fire)
        setTimeout(function() {
            var elements = document.querySelectorAll(
                '.bento-item-left, .bento-item-right, .about-img-col, .about-content-col, .scope-card-animate, .post-card-animate, .video-card-animate, .team-card-animate, .faq-item-animate'
            );
            elements.forEach(function(el) {
                if (!el.classList.contains('visible')) {
                    el.classList.add('visible');
                    // If it is about content, restore original text to make it readable in case typewriter gets stuck
                    if (el.classList.contains('about-content-col')) {
                        var children = el.querySelectorAll('span, h2, h3, p');
                        children.forEach(function(child) {
                            if (child.hasAttribute('data-original-text')) {
                                child.innerHTML = child.getAttribute('data-original-text');
                            }
                            child.style.opacity = '1';
                            child.style.visibility = 'visible';
                        });
                    }
                }
            });
        }, 8000);
    });
</script>

<!-- Back to Top Button -->
<button id="back-to-top" title="উপরে যান" style="position: fixed; bottom: 30px; right: 30px; width: 48px; height: 48px; border-radius: 50%; background: #2563eb; color: #ffffff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 12px rgba(37,99,235,0.3); opacity: 0; pointer-events: none; transform: translateY(15px); transition: all 0.3s ease; z-index: 99999;">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
                if (scrollTop > 300) {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.pointerEvents = 'auto';
                    backToTopBtn.style.transform = 'translateY(0)';
                } else {
                    backToTopBtn.style.opacity = '0';
                    backToTopBtn.style.pointerEvents = 'none';
                    backToTopBtn.style.transform = 'translateY(15px)';
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Hover effects
            backToTopBtn.addEventListener('mouseover', function() {
                backToTopBtn.style.background = '#1d4ed8';
                backToTopBtn.style.boxShadow = '0 6px 16px rgba(37,99,235,0.5)';
                backToTopBtn.style.transform = 'translateY(-3px)';
            });
            backToTopBtn.addEventListener('mouseout', function() {
                backToTopBtn.style.background = '#2563eb';
                backToTopBtn.style.boxShadow = '0 4px 12px rgba(37,99,235,0.3)';
                backToTopBtn.style.transform = 'translateY(0)';
            });
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function adjustZoom() {
        if (window.innerWidth > 992) {
            const ratio = window.devicePixelRatio;
            if (ratio === 1.25) {
                document.body.style.zoom = "80%";
            } else if (ratio === 1.5) {
                document.body.style.zoom = "67%";
            } else if (ratio === 1.75) {
                document.body.style.zoom = "57%";
            } else if (ratio === 2 && !(/Mobi|Android|iPhone/i.test(navigator.userAgent))) {
                document.body.style.zoom = "50%";
            } else {
                document.body.style.zoom = "100%";
            }
        } else {
            document.body.style.zoom = "100%";
        }
    }
    
    adjustZoom();
    window.addEventListener('resize', adjustZoom);
});
</script>
<script>
// Highly Optimized Lightweight Animated Islamic Geometric Canvas Background
(function() {
    const canvas = document.getElementById('islamicCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true });
    let width, height;
    let particles = [];
    let rotationAngle = 0;
    let animId = null;

    function resizeCanvas() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    // Reduced lightweight particles for smooth 60fps performance
    for (let i = 0; i < 25; i++) {
        particles.push({
            x: Math.random() * width,
            y: Math.random() * height,
            radius: Math.random() * 1.5 + 0.8,
            alpha: Math.random() * 0.7 + 0.3,
            speed: Math.random() * 0.3 + 0.1
        });
    }

    function drawEightPointStar(cx, cy, spikes, outerRadius, innerRadius) {
        let rot = Math.PI / 2 * 3;
        let x = cx;
        let y = cy;
        let step = Math.PI / spikes;

        ctx.beginPath();
        ctx.moveTo(cx, cy - outerRadius);
        for (let i = 0; i < spikes; i++) {
            x = cx + Math.cos(rot) * outerRadius;
            y = cy + Math.sin(rot) * outerRadius;
            ctx.lineTo(x, y);
            rot += step;

            x = cx + Math.cos(rot) * innerRadius;
            y = cy + Math.sin(rot) * innerRadius;
            ctx.lineTo(x, y);
            rot += step;
        }
        ctx.lineTo(cx, cy - outerRadius);
        ctx.closePath();
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Render Floating Particles with sharp contrast
        ctx.fillStyle = '#059669';
        particles.forEach(p => {
            p.y -= p.speed;
            if (p.y < 0) p.y = height;
            ctx.globalAlpha = p.alpha;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fill();
        });
        ctx.globalAlpha = 1.0;

        // Optimized Grid Patterns for viewport
        rotationAngle += 0.0008;
        const spacing = 160;
        const cols = Math.ceil(width / spacing) + 1;
        const rows = Math.ceil(height / spacing) + 1;

        ctx.lineWidth = 1.5;
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                const cx = c * spacing + (r % 2 === 0 ? 0 : spacing / 2);
                const cy = r * spacing * 0.866;

                ctx.save();
                ctx.translate(cx, cy);
                ctx.rotate((r + c) % 2 === 0 ? rotationAngle : -rotationAngle);

                // Emerald Star Line Pattern with high contrast
                ctx.strokeStyle = 'rgba(5, 150, 105, 0.45)';
                drawEightPointStar(0, 0, 8, 42, 21);
                ctx.stroke();

                // Inner White Geometric Line Accent
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.6)';
                drawEightPointStar(0, 0, 8, 24, 12);
                ctx.stroke();

                ctx.restore();
            }
        }

        animId = requestAnimationFrame(animate);
    }

    animate();
})();
</script>
</body>
</html>
