<?php require APPROOT . '/Views/inc/header.php'; ?>

<?php if (($data['settings']['show_hero_section'] ?? '1') == '1'): ?>
<!-- Islamic Hero & Recent Questions Split Section -->
<section class="islamic-hero-section" style="position: relative; background: radial-gradient(circle at 50% 30%, #065f46 0%, #044e39 45%, #022c22 100%); padding: 65px 20px 75px 20px; margin-top: -80px; overflow: hidden; border-bottom: 1px solid #059669;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Large Subtle Watermark Crescent & Star Accent -->
    <div style="position: absolute; top: -40px; right: -50px; opacity: 0.05; color: #f59e0b; font-size: 26rem; pointer-events: none; z-index: 1; transform: rotate(-15deg);">
        <i class="fas fa-star-and-crescent"></i>
    </div>
    <div style="position: absolute; bottom: -80px; left: -60px; opacity: 0.04; color: #10b981; font-size: 24rem; pointer-events: none; z-index: 1; transform: rotate(20deg);">
        <i class="fas fa-mosque"></i>
    </div>

    <!-- SVG Mosque Architectural Dome & Minarets Silhouette Layer at Bottom -->
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; pointer-events: none; z-index: 1; opacity: 0.18;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: 100%; height: 85px; fill: #ffffff;">
            <!-- Left Minaret -->
            <rect x="50" y="20" width="16" height="100" rx="2" />
            <path d="M46 20 L58 0 L70 20 Z" />
            <circle cx="58" cy="-5" r="3" />
            <!-- Small Domes -->
            <path d="M120 120 Q160 50 200 120 Z" />
            <path d="M220 120 Q280 30 340 120 Z" />
            <!-- Center Grand Mosque Dome -->
            <path d="M480 120 Q600 -15 720 120 Z" />
            <path d="M590 0 Q600 -25 610 0 Z" />
            <circle cx="600" cy="-30" r="4" fill="#f59e0b" />
            <!-- Right Domes & Minaret -->
            <path d="M860 120 Q920 30 980 120 Z" />
            <path d="M1000 120 Q1040 50 1080 120 Z" />
            <rect x="1120" y="20" width="16" height="100" rx="2" />
            <path d="M1116 20 L1128 0 L1140 20 Z" />
            <circle cx="1128" cy="-5" r="3" />
        </svg>
    </div>

    <!-- Ultra Dense Animated Cosmic Space / Star Particle Layer (70 Stars + Shooting Stars) -->
    <div class="space-particles-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; z-index: 1; overflow: hidden;">
        <?php for ($i = 1; $i <= 70; $i++): ?>
            <div class="star-particle star-gen-<?= $i ?>"></div>
        <?php endfor; ?>
        
        <!-- Shooting Stars / Meteors -->
        <div class="shooting-star meteor-1"></div>
        <div class="shooting-star meteor-2"></div>
        <div class="shooting-star meteor-3"></div>
    </div>

    <style>
    @keyframes twinkleFast {
        0%, 100% { opacity: 0.1; transform: scale(0.5); }
        50% { opacity: 1; transform: scale(1.8); filter: drop-shadow(0 0 10px rgba(254, 240, 138, 1)); }
    }
    @keyframes floatCosmicWide {
        0% { transform: translateY(0px) translateX(0px); opacity: 0.2; }
        50% { transform: translateY(-30px) translateX(25px); opacity: 0.9; }
        100% { transform: translateY(0px) translateX(0px); opacity: 0.2; }
    }
    @keyframes shootingStarAnim {
        0% { transform: translateX(0) translateY(0) rotate(-35deg); opacity: 0; width: 0px; }
        10% { opacity: 1; width: 120px; }
        30% { transform: translateX(-400px) translateY(280px) rotate(-35deg); opacity: 0; width: 0px; }
        100% { opacity: 0; }
    }
    .star-particle {
        position: absolute;
        border-radius: 50%;
        background: #ffffff;
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.9), 0 0 14px rgba(245, 158, 11, 0.6);
    }
    .shooting-star {
        position: absolute;
        height: 2px;
        background: linear-gradient(-45deg, rgba(255,255,255,1), rgba(245,158,11,0.8), transparent);
        filter: drop-shadow(0 0 6px rgba(255,255,255,0.8));
        border-radius: 999px;
    }
    .meteor-1 { top: 15%; right: 10%; animation: shootingStarAnim 7s infinite ease-in 1s; }
    .meteor-2 { top: 35%; right: 35%; animation: shootingStarAnim 9s infinite ease-in 4s; }
    .meteor-3 { top: 5%; right: 55%; animation: shootingStarAnim 11s infinite ease-in 2s; }

    <?php 
    // Generative CSS rules for 70 stars with varied coordinates, delays, sizes & colors
    for ($i = 1; $i <= 70; $i++) {
        $top = rand(1, 98);
        $left = rand(1, 98);
        $size = rand(2, 6);
        $delay = sprintf("%.2f", rand(0, 40) / 10);
        $duration = sprintf("%.2f", rand(20, 50) / 10);
        $bg = ($i % 3 == 0) ? '#fef08a' : (($i % 4 == 0) ? '#6ee7b7' : '#ffffff');
        $anim = ($i % 2 == 0) ? 'twinkleFast' : 'floatCosmicWide';
        echo ".star-gen-{$i} { top: {$top}%; left: {$left}%; width: {$size}px; height: {$size}px; background: {$bg}; animation: {$anim} {$duration}s infinite ease-in-out {$delay}s; }\n";
    }
    ?>
    </style>

    <!-- Extra Top Padding Space for Navbar -->
    <div class="hero-top-spacer" style="height: 80px;"></div>
    <!-- Modern Golden Glow Orbs & Ambient Glow -->
    <div style="position: absolute; top: -100px; left: 15%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(16, 185, 129, 0) 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 1;"></div>
    <div style="position: absolute; bottom: -120px; right: 10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(4, 78, 57, 0) 70%); border-radius: 50%; filter: blur(60px); pointer-events: none; z-index: 1;"></div>

    
    <div style="max-width: 1440px; margin: 0 auto; position: relative; z-index: 2; padding: 0 15px; box-sizing: border-box; width: 100%;">
        <div class="hero-split-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 30px; align-items: center;">
            
            <!-- LEFT COLUMN: Dynamic Clean Glassmorphism Area -->
            <div style="text-align: left; padding: 25px 0;">
                
                <?php if (($data['settings']['show_hero_date'] ?? '0') == '1'): ?>
                <!-- Date & Info Pill Badge -->
                <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.25); padding: 7px 20px; border-radius: 30px; margin-bottom: 22px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                    <i class="far fa-calendar-alt" style="color: #6ee7b7; font-size: 0.95rem;"></i>
                    <span style="font-size: 0.9rem; font-weight: 700; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; letter-spacing: 0.2px;">
                        <?= function_exists('getBengaliDate') ? getBengaliDate() : date('l, d F Y') ?>
                    </span>
                </div>
                <?php endif; ?>

                <!-- Site Main Title -->
                <h1 style="font-size: 2.8rem; font-weight: 900; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 12px 0; letter-spacing: -0.5px; line-height: 1.25; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);">
                    <?= htmlspecialchars(!empty($data['settings']['hero_title']) ? $data['settings']['hero_title'] : ($data['settings']['site_title'] ?? 'রেসপন্স উইথ নূর-ল্যাব')) ?>
                </h1>
                
                <?php if (!empty($data['settings']['hero_subtitle'])): ?>
                <!-- Tagline / Subtitle -->
                <p style="font-size: 1.1rem; color: #d1fae5; font-weight: 500; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 24px 0; line-height: 1.7; max-width: 650px;">
                    <?= htmlspecialchars($data['settings']['hero_subtitle']) ?>
                </p>
                <?php endif; ?>

                <?php if (($data['settings']['show_hero_search'] ?? '0') == '1'): ?>
                <!-- Search Bar Form -->
                <form action="<?= URLROOT ?>/search" method="GET" style="max-width: 580px; margin: 0 0 24px 0; position: relative;">
                    <div style="display: flex; align-items: center; background: rgba(255, 255, 255, 0.95); border-radius: 50px; padding: 7px 10px 7px 24px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); border: 2px solid rgba(255, 255, 255, 0.8); transition: all 0.3s ease;">
                        <i class="fas fa-search" style="color: #059669; font-size: 1.2rem; margin-right: 14px;"></i>
                        <input type="text" name="q" placeholder="কুরআন, হাদীস বা যেকোনো বিষয় খুঁজুন..." style="border: none; outline: none; width: 100%; font-size: 1.05rem; font-family: 'Hind Siliguri', sans-serif; background: transparent; color: #0f172a;" required>
                        <button type="submit" style="background: linear-gradient(135deg, #059669, #10b981); border: none; width: 46px; height: 46px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.2s ease; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4); flex-shrink: 0;" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';">
                            <i class="fas fa-search" style="font-size: 1rem;"></i>
                        </button>
                    </div>
                </form>
                <?php endif; ?>

                <?php if (!empty($data['settings']['hero_btn_text'])): ?>
                <!-- Action Button -->
                <div style="margin-top: 15px; margin-bottom: 25px;">
                    <a href="<?= !empty($data['settings']['hero_btn_link']) ? htmlspecialchars($data['settings']['hero_btn_link']) : URLROOT . '/ask' ?>" style="display: inline-flex; align-items: center; gap: 10px; background: #ffffff; color: #064e3b; padding: 14px 34px; border-radius: 50px; font-weight: 800; font-size: 1.05rem; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 18px 40px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 12px 30px rgba(0, 0, 0, 0.2)';">
                        <i class="fas fa-paper-plane" style="color: #059669;"></i>
                        <span><?= htmlspecialchars($data['settings']['hero_btn_text']) ?></span>
                    </a>
                </div>
                <?php endif; ?>

                <script>
// UNIVERSAL SAFE MODAL ENGINE (GUARANTEED POPUPS)
window.safeOpenModal = function(modalId) {
    try {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error("Modal not found: " + modalId);
            return false;
        }
        modal.style.display = "flex";
        modal.style.visibility = "visible";
        modal.style.pointerEvents = "auto";
        modal.style.zIndex = "999999";
        
        requestAnimationFrame(function() {
            modal.style.opacity = "1";
        });

        // Auto-initialize feature data directly without infinite recursion loops
        if (modalId === "alQuranModal") {
            if (typeof window.fetchSurahList === "function") {
                window.fetchSurahList();
            }
        } else if (modalId === "dailyHadithModal") {
            const sidebar = document.getElementById("hadithSidebarBookList");
            if (sidebar && (!sidebar.firstElementChild || sidebar.children.length === 0) && typeof window.renderHadithSidebar === "function") {
                window.renderHadithSidebar();
                if (typeof window.selectHadithBook === "function") window.selectHadithBook("bukhari", 1);
            }
        } else if (modalId === "prayerTimesModal") {
            if (typeof window.fetchPrayerTimesForCity === "function") {
                const el = document.getElementById("prayerDistrictSelect");
                const currentSelectedCity = (el && el.value) ? el.value : "Dhaka";
                window.fetchPrayerTimesForCity(currentSelectedCity);
            }
        } else if (modalId === "islamicCalendarModal") {
            if (typeof window.renderIslamicCalendar === "function") {
                const now = new Date();
                window.renderIslamicCalendar(now.getFullYear(), now.getMonth() + 1);
            }
        } else if (modalId === "asmaUlHusnaModal") {
            if (typeof window.renderAsmaGrid === "function") window.renderAsmaGrid();
        } else if (modalId === "dailyDuaModal") {
            if (typeof window.renderDuaList === "function") window.renderDuaList();
        }
        return true;
    } catch(err) {
        console.error("SafeModal Error:", err);
        return false;
    }
};

window.safeCloseModal = function(modalId) {
    try {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.style.opacity = "0";
        modal.style.pointerEvents = "none";
        modal.style.display = "none";
        modal.style.visibility = "hidden";
    } catch(e) {}
};

document.addEventListener("click", function(e) {
    const openBtn = e.target.closest("[data-open-modal]");
    if (openBtn) {
        const mId = openBtn.getAttribute("data-open-modal");
        if (mId) {
            window.safeOpenModal(mId);
        }
    }

    const closeBtn = e.target.closest("[data-close-modal]");
    if (closeBtn) {
        const mId = closeBtn.getAttribute("data-close-modal");
        if (mId) {
            window.safeCloseModal(mId);
        }
    }
});
</script>

<!-- Islamic Quick Feature Buttons Row -->
                <div class="hero-quick-btns" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; position: relative; z-index: 10;">
                    <!-- 1. Al-Quran -->
                    <a href="<?= URLROOT ?>/quran" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-quran" style="color: #34d399; font-size: 1.05rem;"></i>
                        <span>আল-কুরআন</span>
                    </a>

                    <!-- 2. Hadith Shareef -->
                    <a href="<?= URLROOT ?>/hadith" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-book-open-reader" style="color: #60a5fa; font-size: 1.05rem;"></i>
                        <span>হাদীস শরীফ</span>
                    </a>

                    <!-- 3. Prayer Times -->
                    <a href="<?= URLROOT ?>/prayer_times" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-clock" style="color: #6ee7b7; font-size: 1.05rem;"></i>
                        <span>নামাজের সময়</span>
                    </a>

                    <!-- 4. Islamic Calendar -->
                    <a href="<?= URLROOT ?>/islamic_calendar" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-calendar-alt" style="color: #fde047; font-size: 1.05rem;"></i>
                        <span>ইসলামিক ক্যালেন্ডার</span>
                    </a>

                    <!-- 5. Zakat Calculator -->
                    <a href="<?= URLROOT ?>/zakat_calculator" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-calculator" style="color: #4ade80; font-size: 1.05rem;"></i>
                        <span>যাকাত ক্যালকুলেটর</span>
                    </a>

                    <!-- 6. Daily Masnoon Dua -->
                    <a href="<?= URLROOT ?>/daily_dua" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-hands-praying" style="color: #38bdf8; font-size: 1.05rem;"></i>
                        <span>মাসনুন দো'আ</span>
                    </a>

                    <!-- 7. Digital Tasbih -->
                    <a href="<?= URLROOT ?>/tasbih" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-beads" style="color: #f43f5e; font-size: 1.05rem;"></i>
                        <span>ডিজিটাল তাসবীহ</span>
                    </a>

                    <!-- 8. 99 Names of Allah -->
                    <a href="<?= URLROOT ?>/asmaul_husna" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); padding: 9px 20px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-size: 0.92rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.14)'; this.style.transform='none';">
                        <i class="fas fa-star-and-crescent" style="color: #c084fc; font-size: 1.05rem;"></i>
                        <span>আল্লাহ্‌র ৯৯টি নাম</span>
                    </a>


                </div>

                <!-- Islamic Quran Ayah Banner Card -->
                <?php if (!empty($data['settings']['hero_ayah_bn'] ?? 'অতএব জ্ঞানীদের জিজ্ঞেস করো, যদি তোমরা না জানো।')): ?>
                <div style="margin-top: 25px; padding: 24px 28px; background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.05) 100%); backdrop-filter: blur(16px); border-radius: 22px; border-left: 4px solid #f59e0b; border-top: 1px solid rgba(255, 255, 255, 0.25); border-right: 1px solid rgba(255, 255, 255, 0.25); border-bottom: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); position: relative; overflow: hidden;">
                    <div style="position: absolute; right: 10px; bottom: -10px; opacity: 0.1; color: #f59e0b; font-size: 5.5rem; pointer-events: none;">
                        <i class="fas fa-kaaba"></i>
                    </div>
                    <?php if (!empty($data['settings']['hero_ayah_arabic'] ?? 'فَاسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ')): ?>
                    <div style="font-size: 1.35rem; font-weight: 700; color: #fef08a; font-family: 'Amiri', 'Meaney', serif; margin-bottom: 10px; direction: rtl; text-align: right; line-height: 1.7; letter-spacing: 0.5px; text-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                        <?= htmlspecialchars($data['settings']['hero_ayah_arabic'] ?? 'فَاسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ') ?>
                    </div>
                    <?php endif; ?>
                    <div style="font-size: 1.02rem; font-weight: 600; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; line-height: 1.65;">
                        “<?= htmlspecialchars($data['settings']['hero_ayah_bn'] ?? 'অতএব জ্ঞানীদের জিজ্ঞেস করো, যদি তোমরা না জানো।') ?>”
                    </div>
                    <?php if (!empty($data['settings']['hero_ayah_ref'] ?? 'সূরা আন-নহল: ৪৩')): ?>
                    <div style="font-size: 0.85rem; font-weight: 800; color: #f59e0b; margin-top: 8px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-bookmark" style="font-size: 0.8rem;"></i>
                        <span><?= htmlspecialchars($data['settings']['hero_ayah_ref'] ?? 'সূরা আন-নহল: ৪৩') ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Quick Islamic Platform Statistics Counter Row -->
                <div class="hero-stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-top: 22px; padding-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.15);">
                    <div style="text-align: left; background: rgba(255, 255, 255, 0.08); padding: 12px 16px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div style="font-size: 1.5rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', 'Hind Siliguri', sans-serif; line-height: 1;">
                            <?= htmlspecialchars($data['settings']['hero_stat_num_1'] ?? '১,৫০০+') ?>
                        </div>
                        <div style="font-size: 0.8rem; font-weight: 600; color: #a7f3d0; font-family: 'Hind Siliguri', sans-serif; margin-top: 4px;">
                            <?= htmlspecialchars($data['settings']['hero_stat_lbl_1'] ?? 'ফতোয়া ও মাসআলা') ?>
                        </div>
                    </div>

                    <div style="text-align: left; background: rgba(255, 255, 255, 0.08); padding: 12px 16px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div style="font-size: 1.5rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', 'Hind Siliguri', sans-serif; line-height: 1;">
                            <?= htmlspecialchars($data['settings']['hero_stat_num_2'] ?? '৫০,০০০+') ?>
                        </div>
                        <div style="font-size: 0.8rem; font-weight: 600; color: #a7f3d0; font-family: 'Hind Siliguri', sans-serif; margin-top: 4px;">
                            <?= htmlspecialchars($data['settings']['hero_stat_lbl_2'] ?? 'নিয়মিত পাঠকমণ্ডলী') ?>
                        </div>
                    </div>

                    <div style="text-align: left; background: rgba(255, 255, 255, 0.08); padding: 12px 16px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div style="font-size: 1.5rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', 'Hind Siliguri', sans-serif; line-height: 1;">
                            <?= htmlspecialchars($data['settings']['hero_stat_num_3'] ?? '১০০%') ?>
                        </div>
                        <div style="font-size: 0.8rem; font-weight: 600; color: #a7f3d0; font-family: 'Hind Siliguri', sans-serif; margin-top: 4px;">
                            <?= htmlspecialchars($data['settings']['hero_stat_lbl_3'] ?? 'সহিহ উৎস ও দলিল') ?>
                        </div>
                    </div>

                    <div style="text-align: left; background: rgba(255, 255, 255, 0.08); padding: 12px 16px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                        <div style="font-size: 1.5rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', 'Hind Siliguri', sans-serif; line-height: 1;">
                            <?= htmlspecialchars($data['settings']['hero_stat_num_4'] ?? '২৪/৭') ?>
                        </div>
                        <div style="font-size: 0.8rem; font-weight: 600; color: #a7f3d0; font-family: 'Hind Siliguri', sans-serif; margin-top: 4px;">
                            <?= htmlspecialchars($data['settings']['hero_stat_lbl_4'] ?? 'অনলাইন সাপোর্ট') ?>
                        </div>
                    </div>
                </div>

                

            </div>

            <!-- RIGHT COLUMN: Slim Portrait Recent Questions Widget -->
            <div style="display: flex; justify-content: center; width: 100%;">
                <div class="bento-item prayer-widget" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 28px; padding: 32px 22px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25); border: 1.5px solid rgba(255, 255, 255, 0.4); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; width: 100%; min-height: 560px; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 28px 55px rgba(0, 0, 0, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 20px 45px rgba(0, 0, 0, 0.25)';">
                    
                    <style>
                    @media (max-width: 991px) {
                        .islamic-hero-section {
                            padding: 20px 15px 45px 15px !important;
                            margin-top: 0 !important;
                        }
                        .islamic-hero-section .hero-top-spacer {
                            height: 15px !important;
                        }
                        .islamic-hero-section h1 {
                            font-size: 1.75rem !important;
                            line-height: 1.35 !important;
                            margin-bottom: 12px !important;
                        }
                        .islamic-hero-section p {
                            font-size: 0.95rem !important;
                            line-height: 1.6 !important;
                        }
                        .hero-split-grid {
                            grid-template-columns: 1fr !important;
                            text-align: center !important;
                            gap: 24px !important;
                        }
                        .hero-split-grid form {
                            margin: 0 auto 20px auto !important;
                        }
                        .hero-split-grid > div:first-child {
                            padding: 5px 0 !important;
                            text-align: center !important;
                        }
                        .hero-stats-grid {
                            grid-template-columns: repeat(2, 1fr) !important;
                            gap: 10px !important;
                        }
                        .hero-quick-btns {
                            justify-content: center !important;
                            gap: 8px !important;
                        }
                        .hero-quick-btns a, .hero-quick-btns button {
                            padding: 7px 12px !important;
                            font-size: 0.8rem !important;
                            gap: 5px !important;
                        }
                    }
                    @media (max-width: 480px) {
                        .hero-quick-btns a, .hero-quick-btns button {
                            padding: 6px 10px !important;
                            font-size: 0.75rem !important;
                        }
                        .hero-quick-btns i {
                            font-size: 0.85rem !important;
                        }
                        .islamic-hero-section h1 {
                            font-size: 1.45rem !important;
                        }
                        .hero-stats-grid {
                            grid-template-columns: repeat(2, 1fr) !important;
                        }
                        .hero-stats-grid div {
                            padding: 10px 8px !important;
                        }
                    }
                    @keyframes pulseGreen {
                        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
                        70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
                    }
                    @keyframes floatBlob1 {
                        0% { transform: translate(0px, 0px) scale(1); }
                        50% { transform: translate(25px, -25px) scale(1.2); }
                        100% { transform: translate(0px, 0px) scale(1); }
                    }
                    @keyframes floatBlob2 {
                        0% { transform: translate(0px, 0px) scale(1); }
                        50% { transform: translate(-25px, 25px) scale(1.2); }
                        100% { transform: translate(0px, 0px) scale(1); }
                    }
                    .bg-blob-1 {
                        position: absolute; top: -60px; right: -60px; width: 190px; height: 190px; 
                        background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(11, 124, 77, 0.08) 60%, transparent 100%); 
                        border-radius: 50%; filter: blur(25px); z-index: 0; pointer-events: none;
                        animation: floatBlob1 12s infinite ease-in-out;
                    }
                    .bg-blob-2 {
                        position: absolute; bottom: -60px; left: -60px; width: 190px; height: 190px; 
                        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, rgba(6, 182, 212, 0.08) 60%, transparent 100%); 
                        border-radius: 50%; filter: blur(25px); z-index: 0; pointer-events: none;
                        animation: floatBlob2 12s infinite ease-in-out;
                    }
                    
                    /* Question Row Design matching reference image 2 */
                    .prayer-row-3d-premium {
                        display: flex; justify-content: space-between; align-items: center; 
                        padding: 10px 12px; background: #f8fafc; 
                        border-radius: 12px; border: 1px solid #e2e8f0; 
                        text-decoration: none; color: #1e293b; 
                        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); 
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
                        width: 100%; box-sizing: border-box;
                        position: relative; overflow: hidden;
                    }
                    .prayer-row-3d-premium::before {
                        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
                        background: #0b7c4d; opacity: 0; transition: 0.3s;
                    }
                    .prayer-row-3d-premium:hover {
                        transform: translateX(3px);
                        box-shadow: 0 6px 18px rgba(11, 124, 77, 0.12);
                        border-color: #0b7c4d;
                        background: #ffffff;
                    }
                    .prayer-row-3d-premium:hover::before {
                        opacity: 1;
                    }
                    .prayer-row-3d-premium:hover .q-title {
                        color: #0b7c4d;
                    }
                    
                    .question-dot-premium {
                        width: 10px; height: 6px; border-radius: 3px; 
                        background: rgba(11, 124, 77, 0.2); cursor: pointer; 
                        transition: all 0.3s ease;
                    }
                    .question-dot-premium.active {
                        background: #0b7c4d; width: 24px;
                    }
                    </style>

                    <div class="bg-blob-1"></div>
                    <div class="bg-blob-2"></div>
                    
                    <div style="position: relative; z-index: 2;">
                        <!-- Centered Pill Header matching Reference Image 2 -->
                        <div style="text-align: center; margin-bottom: 18px;">
                            <div style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: linear-gradient(135deg, #0b7c4d 0%, #10b981 100%); color: #ffffff; padding: 9px 24px; border-radius: 50px; font-weight: 800; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 6px 18px rgba(11, 124, 77, 0.25);">
                                <div style="width: 22px; height: 22px; border-radius: 50%; background: #ffffff; color: #0b7c4d; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 900;">?</div>
                                <span>প্রশ্নসমূহ</span>
                            </div>
                        </div>

                        <div class="questions-slider" style="position: relative; overflow: hidden; width: 100%; z-index: 2;">
                            <div class="questions-track" id="questions-track" style="display: flex; transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1); width: 100%;">
                                <?php 
                                $chunks = array_chunk($data['recent_questions'] ?? [], 5);
                                if (!empty($chunks)): 
                                    foreach ($chunks as $chunkIndex => $chunk):
                                ?>
                                    <div class="question-slide" style="width: 100%; flex-shrink: 0; display: flex; flex-direction: column; gap: 8px; padding: 2px; box-sizing: border-box;">
                                        <?php foreach ($chunk as $q): ?>
                                            <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="prayer-row-3d-premium">
                                                <span class="q-title" style="font-size: 0.84rem; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; font-family: 'Hind Siliguri', sans-serif; line-height: 1.35; color: #1e293b; transition: color 0.3s; max-width: 68%; text-align: left;"><?= htmlspecialchars($q['question']) ?></span>
                                                <span style="font-size: 0.78rem; font-weight: 800; color: #0b7c4d; font-family: 'Hind Siliguri', sans-serif; display: inline-flex; align-items: center; gap: 3px; flex-shrink: 0;">
                                                    উত্তর দেখুন &rarr;
                                                </span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php 
                                    endforeach; 
                                else:
                                ?>
                                    <div style="text-align: center; color: #64748b; padding: 30px 10px; width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;">
                                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e6f4ea, #d1fae5); display: flex; align-items: center; justify-content: center; color: #0b7c4d; font-size: 1.6rem; box-shadow: 0 8px 20px rgba(11, 124, 77, 0.15);">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <h4 style="font-size: 1.05rem; font-weight: 800; color: #1e293b; margin: 0; font-family: 'Hind Siliguri', sans-serif;">কোনো প্রশ্ন পাওয়া যায়নি</h4>
                                        <p style="font-size: 0.82rem; color: #64748b; margin: 0; font-family: 'Hind Siliguri', sans-serif; line-height: 1.4; max-width: 220px;">আপনার যেকোনো ইসলামিক প্রশ্ন সরাসরি আমাদের মাসআলা টিমের কাছে পাঠাতে পারেন।</p>
                                        <a href="<?= URLROOT ?>/ask" style="margin-top: 6px; text-decoration: none; background: linear-gradient(135deg, #0b7c4d, #10b981); color: #fff; padding: 8px 22px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.3); transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(11, 124, 77, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(11, 124, 77, 0.3)';">
                                            <i class="fas fa-paper-plane" style="margin-right: 5px;"></i> প্রশ্ন পাঠান
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
         
                        <?php if (!empty($chunks) && count($chunks) > 1): ?>
                            <div class="question-dots-container" id="question-dots" style="display: flex; justify-content: center; gap: 8px; margin-top: 14px; z-index: 2; position: relative;">
                                <?php foreach ($chunks as $chunkIndex => $chunk): ?>
                                    <div class="question-dot-premium <?= $chunkIndex === 0 ? 'active' : '' ?>" onclick="goToQuestionSlide(<?= $chunkIndex ?>)"></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
         
                    <!-- Full Width Bottom Button matching Reference Image 2 -->
                    <div style="margin-top: 15px; padding-top: 14px; border-top: 1px solid #f1f5f9; position: relative; z-index: 2; width: 100%;">
                        <a href="<?= URLROOT ?>/ask" style="display: block; width: 100%; text-align: center; text-decoration: none; color: #ffffff; background: linear-gradient(135deg, #0b7c4d 0%, #10b981 100%); padding: 12px 16px; border-radius: 16px; font-family: 'Hind Siliguri', sans-serif; font-weight: 800; font-size: 0.98rem; box-shadow: 0 6px 18px rgba(11, 124, 77, 0.28); transition: all 0.3s ease; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(11, 124, 77, 0.38)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 6px 18px rgba(11, 124, 77, 0.28)';">
                            <i class="fas fa-pen-nib" style="margin-right: 6px;"></i> প্রশ্ন করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>





<!-- Scopes Section -->
<?php if (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1'): ?>
<section class="scopes-section" style="padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-title" style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 2.8rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                আমাদের <span style="color: #0b7c4d;">কার্যপরিধি</span>
            </h2>
        </div>

        <div class="scopes-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; justify-content: center;">
            <?php if (!empty($data['scopes'])): ?>
                <?php foreach ($data['scopes'] as $scope): ?>
                <div class="scope-card scope-card-animate" style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; padding: 40px 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; flex-direction: column; align-items: flex-start;">
                    <!-- Icon Box with light emerald background -->
                    <div style="width: 55px; height: 55px; border-radius: 16px; background: #e6f4ea; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(11,124,77,0.12);">
                        <i class="<?= $scope['icon'] ?>"></i>
                    </div>
                    
                    <h3 style="font-size: 1.4rem; color: #1e293b; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 15px 0; line-height: 1.3;"><?= $scope['title'] ?></h3>
                    <p style="color: #1e293b; font-size: 1.05rem; line-height: 1.7; margin: 0; text-align: justify; font-family: 'Hind Siliguri', sans-serif; font-weight: 400;"><?= $scope['description'] ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
    .scope-card {
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s ease;
    }
    .scope-card:hover {
        transform: translateY(-8px);
        border-color: #2563eb !important;
        box-shadow: 0 20px 40px rgba(37,99,235,0.08) !important;
    }
    @media (max-width: 1024px) {
        .scopes-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 992px) {
        .about-flex-row {
            flex-direction: column !important;
            gap: 40px !important;
        }
        .about-flex-row > div {
            width: 100% !important;
        }
        .about-flex-row h2 {
            font-size: 2.2rem !important;
        }
        .about-flex-row h3 {
            font-size: 1.8rem !important;
        }
    }
    @media (max-width: 768px) {
        .scopes-grid {
            grid-template-columns: 1fr !important;
        }
        .scope-card {
            padding: 30px 20px !important;
        }
    }
</style>

<!-- Recent Posts Section -->
<section class="posts-section" style="padding: 100px 0; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px;">
            <div>
                <h2 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; font-family: 'Hind Siliguri', sans-serif; position: relative; display: inline-block;">
                    সাম্প্রতিক <span style="color: #0b7c4d;">লেখাসমূহ</span>
                    <div style="position: absolute; bottom: -15px; left: 0; width: 80px; height: 6px; background: #0b7c4d; border-radius: 10px;"></div>
                </h2>
                <p style="color: #64748b; margin-top: 25px; font-size: 1.1rem;">ইসলাম ও জীবনের সমসাময়িক বিষয়গুলো নিয়ে আমাদের আয়োজন</p>
            </div>
            <a href="<?= URLROOT ?>/blog" style="color: #0b7c4d; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; transition: 0.3s;" onmouseover="this.style.transform='translateX(5px)'; this.style.background='#0b7c4d'; this.style.color='#fff';" onmouseout="this.style.transform='translateX(0)'; this.style.background='#fff'; this.style.color='#0b7c4d';">
                সবগুলো দেখুন <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="recent-posts-grid">
            <?php if (!empty($data['posts'])): ?>
                <?php foreach (array_slice($data['posts'], 0, 12) as $post): ?>
                <div class="premium-post-card post-card-animate" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; border: 1px solid #f1f5f9; display: flex; flex-direction: column;">
                    <!-- Image Wrapper -->
                    <div style="height: 180px; overflow: hidden; position: relative; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                        <?php if (!empty($post['featured_image'])): ?>
                            <?php 
                            $index_img = resolve_blog_image($post['featured_image']);
                            ?>
                            <img src="<?= $index_img ?>" alt="<?= $post['title'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; transition: 0.8s transform;">
                        <?php else: ?>
                            <i class="fa-regular fa-image" style="font-size: 2.5rem; opacity: 0.4;"></i>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content Wrapper -->
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; color: #64748b; font-size: 0.78rem; font-weight: 500; line-height: 1; flex-wrap: wrap; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-right: 1px solid #e2e8f0; padding-right: 8px;">
                                    <i class="fas fa-calendar-alt" style="color: #0b7c4d;"></i>
                                    <?= date('d M', strtotime($post['created_at'])) ?>
                                </span>
                                <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-user" style="color: #0b7c4d;"></i>
                                    এডমিন
                                </span>
                            </div>
                            <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; color: #64748b;">
                                <i class="fas fa-eye" style="color: #0b7c4d;"></i>
                                <?= number_format($post['views']) ?> বার
                            </span>
                        </div>

                        <h3 style="font-size: 1.05rem; margin-bottom: 12px; color: #000000; line-height: 1.4; font-family: 'Hind Siliguri', sans-serif; font-weight: 800; height: 2.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; transition: 0.3s;">
                            <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" style="text-decoration: none; color: inherit;"><?= $post['title'] ?></a>
                        </h3>
 
                        <p style="font-size: 0.85rem; color: #334155; line-height: 1.5; margin-bottom: 15px; height: 2.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?= strip_tags(!empty($post['excerpt']) ? $post['excerpt'] : $post['content']) ?>
                        </p>
                        
                        <div style="margin-top: auto; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                            <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="premium-read-btn" style="color: #0b7c4d; text-decoration: none; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s;">
                                বিস্তারিত পড়ুন 
                                <div style="width: 30px; height: 30px; background: #e6f4ea; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
                                    <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #ffffff; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fas fa-newspaper fa-3x mb-3 text-muted" style="color: #94a3b8;"></i>
                    <p style="color: #64748b; margin: 0; font-family: 'Hind Siliguri', sans-serif; font-size: 1.1rem;">এখনো কোনো লেখা প্রকাশ করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- YouTube Video Gallery Section -->
<section class="yt-videos-section" style="padding: 80px 0; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; border-top: 1px solid #334155; border-bottom: 1px solid #334155;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
            <div>
                <h2 style="font-size: 2.5rem; font-weight: 900; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; position: relative; display: inline-block;">
                    ইউটিউব <span style="color: #ff4d4d;">ভিডিওসমূহ</span>
                    <div style="position: absolute; bottom: -10px; left: 0; width: 60px; height: 5px; background: #ff4d4d; border-radius: 10px;"></div>
                </h2>
                <p style="color: #94a3b8; margin-top: 20px; font-size: 1.1rem;">আমাদের অফিশিয়াল ইউটিউব চ্যানেলের সর্বশেষ ভিডিওগুলো এখানে দেখুন</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="<?= URLROOT ?>/videos" style="color: #ffffff; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: rgba(255,255,255,0.08); border-radius: 12px; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(10px); transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.2)';" onmouseout="this.style.background='rgba(255,255,255,0.08)';">
                    সবগুলো ভিডিও <i class="fas fa-play-circle"></i>
                </a>
                <a href="<?= !empty($data['settings']['youtube_channel_url']) ? $data['settings']['youtube_channel_url'] : 'https://www.youtube.com' ?>" target="_blank" style="color: #ffffff; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #ff0000; border-radius: 12px; border: 1px solid #ff0000; box-shadow: 0 4px 15px rgba(255,0,0,0.3); transition: 0.3s;" onmouseover="this.style.background='#cc0000'; this.style.borderColor='#cc0000';" onmouseout="this.style.background='#ff0000'; this.style.borderColor='#ff0000';">
                    ইউটিউবে দেখুন <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if (!empty($data['yt_videos'])): ?>
                <?php foreach (array_slice($data['yt_videos'], 0, 8) as $video): ?>
                <div class="yt-video-card video-card-animate" style="position: relative; border-radius: 20px; overflow: hidden; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.1); aspect-ratio: 16/9; transition: 0.4s;">
                    <img src="https://img.youtube.com/vi/<?= $video['video_id'] ?>/maxresdefault.jpg" alt="<?= $video['title'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: 0.5s;">
                    
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%); display: flex; flex-direction: column; justify-content: flex-end; padding: 25px; transition: 0.3s;">
                        <span style="color: #ff0000; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;"><?= $video['category_name'] ?? 'ভিডিও' ?></span>
                        <h3 style="color: white; font-size: 1.1rem; line-height: 1.4; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; margin-bottom: 0;"><?= $video['title'] ?></h3>
                    </div>

                    <a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>" target="_blank" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; background: rgba(255,0,0,0.9); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.5rem; text-decoration: none; box-shadow: 0 0 0 0 rgba(255,0,0,0.4); animation: pulse 2s infinite; opacity: 0.9; transition: 0.3s;">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fab fa-youtube fa-4x mb-3 text-muted"></i>
                    <p class="text-muted">এখনো কোনো ইউটিউব ভিডিও যুক্ত করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .yt-video-card:hover { transform: scale(1.03); }
    .yt-video-card:hover img { transform: scale(1.1); opacity: 0.6; }
    .yt-video-card:hover a { transform: translate(-50%, -50%) scale(1.1); background: #ff0000; opacity: 1; }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); }
    }
</style>

<style>
    .premium-post-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important; border-color: #2563eb !important; }
    .premium-post-card:hover img { transform: scale(1.1); }
    .premium-post-card:hover h3 a { color: #2563eb !important; }
    .premium-read-btn:hover div { background: #2563eb !important; color: #fff !important; transform: translateX(3px); }
</style>

<style>
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; border-color: #2563eb !important; }
    .product-card:hover img { transform: scale(1.1); }
    .shop-btn:hover { color: #1d4ed8 !important; }
</style>

<style>
    .section-padding { padding: 40px 0; width: 100%; }
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 25px;
        box-sizing: border-box;
    }
    .slide-text-card {
        transform: translate3d(0, 40px, 0) scale(0.95);
        opacity: 0;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease, box-shadow 0.4s ease;
    }
    .hero-slide.active { opacity: 1 !important; z-index: 5 !important; }
    .hero-slide.active .slide-text-card { transform: translate3d(0, 0, 0) scale(1) !important; opacity: 1 !important; border-color: rgba(37, 99, 235, 0.3) !important; box-shadow: 0 20px 45px rgba(37, 99, 235, 0.18) !important; }
    .hero-slide.active h1 { transform: translate3d(0, 0, 0) !important; opacity: 1 !important; }
    .hero-slide.active p { transform: translate3d(0, 0, 0) !important; opacity: 1 !important; }
    .hero-slide.active .hero-btn-group { transform: translate3d(0, 0, 0) scale(1) !important; opacity: 1 !important; }
    .dot.active { background: #2563eb !important; width: 30px !important; border-radius: 10px !important; }
    .btn-premium:hover { background: #fff !important; color: var(--primary) !important; transform: scale(1.05) !important; box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important; }

    .hero-btn-group {
        display: flex;
        gap: 60px;
        margin-top: 10px;
        transform: translate3d(0, 40px, 0) scale(0.95);
        opacity: 0;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.6s, opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.6s;
        backface-visibility: hidden;
        flex-wrap: nowrap;
        justify-content: center;
        width: 100%;
    }
    .btn-hero {
        background: #2563eb !important;
        color: white !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 200px !important;
        padding: 12px 35px !important;
        border-radius: 50px !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 1.2rem !important;
        transition: 0.3s !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4) !important;
        border: 1.5px solid #2563eb !important;
        white-space: nowrap !important;
    }
    .btn-hero:hover {
        background: white !important;
        color: #2563eb !important;
        border-color: #2563eb !important;
    }

    .recent-posts-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
    }
    @media (max-width: 1400px) { .recent-posts-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 1200px) { .recent-posts-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .recent-posts-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .recent-posts-grid { grid-template-columns: repeat(1, 1fr); } }

    .slide-blur-bg {
        display: none;
    }

    /* Home Page Responsive Tweaks */
    @media (max-width: 1024px) {
        .slide-blur-bg {
            display: none !important; /* Hide blur background */
        }
        .slide-main-img {
            object-fit: cover !important; /* Fully cover container aspect ratio */
            opacity: 0.8 !important;
        }
        .bento-grid {
            grid-template-columns: 1fr !important;
            padding: 0 20px !important;
            gap: 25px !important;
        }
        .bento-item.main-featured {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
            min-height: auto !important;
            aspect-ratio: 16/10 !important; /* Scaled aspect ratio matching landscape images */
            height: auto !important;
        }
        .bento-item.prayer-widget {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
            padding: 25px !important;
        }
        .slide-content {
            padding: 20px !important;
            padding-bottom: 30px !important;
        }
        .slide-text-card {
            padding: 10px 20px !important;
            max-width: 90% !important;
            border-radius: 15px !important;
        }
        .slide-text-card h1 {
            font-size: 1.8rem !important;
            margin-top: 0 !important;
            margin-bottom: 4px !important;
        }
        .slide-text-card p {
            font-size: 1rem !important;
            margin-top: 0 !important;
            margin-bottom: 6px !important;
        }
        .slide-text-card .btn-premium {
            padding: 6px 18px !important;
            font-size: 0.85rem !important;
        }
        .hero-btn-group {
            gap: 20px !important;
            flex-wrap: nowrap !important;
            transform: none !important;
        }
        .btn-hero {
            min-width: 130px !important;
            padding: 8px 18px !important;
            font-size: 0.95rem !important;
        }
        .slider-dots {
            bottom: 12px !important;
        }
        .dot {
            width: 8px !important;
            height: 8px !important;
        }
        .dot.active {
            width: 20px !important;
        }
        .container-fluid {
            padding: 0 20px !important;
        }
        section {
            padding: 50px 0 !important;
        }
    }

    @media (max-width: 768px) {
        .bento-item.main-featured {
            aspect-ratio: 16/11 !important; /* Slightly taller for smaller screens to fit text */
        }
        .slide-content {
            padding: 10px !important;
            padding-bottom: 20px !important;
        }
        .slide-text-card {
            padding: 6px 12px !important;
            max-width: 90% !important;
            border-radius: 12px !important;
        }
        .slide-text-card h1 {
            font-size: 1.3rem !important;
            margin-top: 0 !important;
            margin-bottom: 2px !important;
        }
        .slide-text-card p {
            font-size: 0.8rem !important;
            margin-top: 0 !important;
            margin-bottom: 4px !important;
            white-space: normal !important;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .slide-text-card .btn-premium {
            padding: 5px 12px !important;
            font-size: 0.75rem !important;
            margin-top: 2px !important;
        }
        .hero-btn-group {
            gap: 10px !important;
            flex-wrap: nowrap !important;
            margin-top: 5px !important;
            transform: none !important;
        }
        .btn-hero {
            min-width: 100px !important;
            padding: 6px 10px !important;
            font-size: 0.8rem !important;
        }
        .slider-arrow {
            display: none !important;
        }
        .section-header-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
            margin-bottom: 30px !important;
        }
        .section-header-flex a {
            align-self: flex-start;
        }
        .section-header-flex h2 {
            font-size: 2rem !important;
        }
    }

    /* Premium Mobile Layout Tweaks (max-width: 600px) */
    @media (max-width: 600px) {
        .slide-text-card p {
            display: none !important; /* Hide slide descriptions on small mobile screens */
        }

        /* Recent Posts: Premium 2-column Grid layout */
        .recent-posts-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            padding: 0 5px !important;
        }

        .premium-post-card {
            display: flex !important;
            flex-direction: column !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
            border: 1px solid #e2e8f0 !important;
            gap: 0 !important;
            transition: all 0.3s ease !important;
        }

        /* Target first child (image wrapper) */
        .premium-post-card > div:first-child {
            width: 100% !important;
            height: 110px !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        /* Target second child (content wrapper) */
        .premium-post-card > div:last-child {
            padding: 10px !important;
            flex-grow: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            min-height: auto !important;
        }

        .premium-post-card h3 {
            font-size: 0.85rem !important;
            font-weight: 800 !important;
            margin-bottom: 6px !important;
            line-height: 1.35 !important;
            height: 2.3rem !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .premium-post-card p {
            display: none !important; /* Hide excerpt on mobile grid view */
        }

        .premium-post-card > div:last-child > div:first-child {
            margin-bottom: 6px !important;
            font-size: 0.68rem !important;
            gap: 4px !important;
            justify-content: flex-start !important;
            flex-wrap: wrap !important;
        }

        .premium-post-card > div:last-child > div:first-child span {
            border-right: none !important;
            padding-right: 0 !important;
        }

        .premium-post-card > div:last-child > div:last-child {
            margin-top: auto !important;
            padding-top: 6px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        .premium-read-btn {
            font-size: 0.72rem !important;
            font-weight: 800 !important;
        }

        .premium-read-btn div {
            width: 20px !important;
            height: 20px !important;
        }

        /* YouTube Videos: 2-column compact grid */
        .yt-videos-section div[style*="display: grid"] {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }

        .yt-video-card {
            border-radius: 14px !important;
            aspect-ratio: 16/10 !important;
        }

        .yt-video-card h3 {
            font-size: 0.82rem !important;
            line-height: 1.3 !important;
        }

        .yt-video-card div[style*="position: absolute"] {
            padding: 12px !important;
        }

        .yt-video-card a[href*="youtube.com"] {
            width: 40px !important;
            height: 40px !important;
            font-size: 1rem !important;
        }

        /* Scopes: 2-column compact grid */
        .scopes-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }

        .scope-card {
            padding: 20px 15px !important;
            border-radius: 16px !important;
            align-items: center !important;
            text-align: center !important;
        }

        .scope-card div[style*="width: 55px"] {
            width: 45px !important;
            height: 45px !important;
            margin-bottom: 12px !important;
            font-size: 1.2rem !important;
            border-radius: 12px !important;
        }

        .scope-card h3 {
            font-size: 1.1rem !important;
            margin-bottom: 8px !important;
            text-align: center !important;
        }

        .scope-card p {
            font-size: 0.85rem !important;
            text-align: center !important;
            line-height: 1.5 !important;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Questions Widget Mobile Spacing */
        .bento-item.prayer-widget {
            padding: 24px !important;
            border-radius: 20px !important;
            min-height: auto !important;
            box-shadow: 0 10px 30px rgba(11, 124, 77, 0.15) !important;
        }
        .bento-item.prayer-widget .widget-header {
            margin-bottom: 20px !important;
        }
        .bento-item.prayer-widget .widget-header a {
            padding: 8px 20px !important;
            font-size: 1.1rem !important;
        }
        .prayer-row {
            padding-bottom: 10px !important;
        }
        .prayer-row span:first-child {
            font-size: 0.88rem !important;
            max-width: 65% !important;
        }
        .prayer-row .btn-uttor {
            font-size: 0.85rem !important;
        }

        /* Adjust section headers */
        .section-header-flex {
            padding: 0 !important;
            margin-bottom: 25px !important;
        }
        
        .section-header-flex h2 {
            font-size: 1.8rem !important;
        }

        .section-header-flex p {
            font-size: 0.95rem !important;
            margin-top: 10px !important;
        }
        
        .section-header-flex a {
            padding: 8px 18px !important;
            font-size: 0.9rem !important;
            margin-top: 10px !important;
        }
    }
</style>
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.dot');

function showSlide(n) {
    if (slides.length === 0) return;
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));
    
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    if (dots.length > 0 && dots[currentSlide]) {
        dots[currentSlide].classList.add('active');
    }
}

function goToSlide(n) {
    showSlide(n);
    resetTimer();
}

function nextSlide() {
    showSlide(currentSlide + 1);
}

function prevSlide() {
    showSlide(currentSlide - 1);
    resetTimer();
}

function clickNext() {
    nextSlide();
    resetTimer();
}

let timer = setInterval(nextSlide, 5000);

function resetTimer() {
    clearInterval(timer);
    timer = setInterval(nextSlide, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    showSlide(0);
});
</script>
<!-- YouTube Floating Notification Widget -->
<?php if (($data['settings']['youtube_status'] ?? '') == 'active' && !empty($data['settings']['youtube_video_id'])): ?>
<div id="youtube-notification" style="position: fixed; bottom: 30px; right: 30px; width: 320px; background: #fff; border-radius: 15px; box-shadow: 0 15px 50px rgba(0,0,0,0.2); z-index: 9999; overflow: hidden; animation: slideInUp 1s ease-out; border: 1px solid #eee;">
    <div style="background: #2563eb; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 700; font-size: 0.9rem;"><i class="fab fa-youtube"></i> <?= $data['settings']['youtube_title'] ?? 'আমরা এখন লাইভে আছি!' ?></span>
        <button onclick="document.getElementById('youtube-notification').style.display='none'" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
    </div>
    <div style="position: relative; padding-bottom: 56.25%; height: 0;">
        <iframe 
            src="https://www.youtube.com/embed/<?= $data['settings']['youtube_video_id'] ?>?autoplay=0&mute=0&rel=0" 
            loading="lazy"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>
    <div style="padding: 10px; text-align: center; background: #f8fafc;">
        <a href="https://www.youtube.com/channel/<?= $data['settings']['youtube_channel_id'] ?? '' ?>" target="_blank" style="color: #ff0000; text-decoration: none; font-weight: 700; font-size: 0.8rem;">চ্যানেল সাবস্ক্রাইব করুন <i class="fas fa-external-link-alt"></i></a>
    </div>
</div>

<style>
@keyframes slideInUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
<?php endif; ?>

    <!-- Team Members Section -->
    <?php if (!empty($data['team'])): ?>
    <section class="team-section animate-team-section" style="padding: 80px 0; background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
            <div class="section-title" style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; color: #1e293b; font-weight: 800; font-family: 'Hind Siliguri', sans-serif;">আমাদের <span style="color: #0b7c4d;">টিম</span></h2>
                <p style="color: #64748b; margin-top: 10px; font-family: 'Hind Siliguri', sans-serif;">আমাদের পোর্টালে নিরলসভাবে কাজ করে যাওয়া দক্ষ সদস্যবৃন্দ</p>
            </div>

            <div class="team-grid">
                <?php foreach($data['team'] as $member): ?>
                <div class="team-card team-card-animate team-card-slide-in" style="background: #ffffff; border-radius: 24px; overflow: hidden; text-align: center; border: 1px solid #e2e8f0; padding: 35px 25px; box-shadow: 0 10px 35px rgba(0,0,0,0.03);">
                    <div class="team-img-wrapper" style="width: 150px; height: 150px; margin: 0 auto 25px; border-radius: 50%; overflow: hidden; border: 3px solid #0b7c4d; box-shadow: 0 0 20px rgba(11, 124, 77, 0.15);">
                        <img src="<?= resolve_blog_image($member['image']) ?>" alt="<?= $member['name'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <h3 style="font-size: 1.3rem; color: #1e293b; margin: 0 0 8px 0; font-weight: 700; line-height: 1.2; letter-spacing: 0.5px; font-family: 'Hind Siliguri', sans-serif;"><?= $member['name'] ?></h3>
                    <p style="color: #0b7c4d; font-size: 0.95rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'Hind Siliguri', sans-serif;"><?= $member['designation'] ?></p>
                    
                    <div style="border-top: 1px solid #e2e8f0; width: 80%; margin: 20px auto;"></div>
                    
                    <div style="display: flex; justify-content: center; gap: 15px;">
                        <?php if(!empty($member['facebook_link'])): ?>
                        <a href="<?= $member['facebook_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1877f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($member['twitter_link'])): ?>
                        <a href="<?= $member['twitter_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1da1f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <style>
        .team-card-slide-in {
            opacity: 0;
            transform: translate3d(70px, 0, 0);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease, border-color 0.4s ease, box-shadow 0.4s ease;
            will-change: transform, opacity;
        }
        .team-card-slide-in.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
        .team-card-slide-in.visible:nth-child(1) { transition-delay: 0.06s; }
        .team-card-slide-in.visible:nth-child(2) { transition-delay: 0.12s; }
        .team-card-slide-in.visible:nth-child(3) { transition-delay: 0.18s; }
        .team-card-slide-in.visible:nth-child(4) { transition-delay: 0.24s; }
        .team-card-slide-in.visible:nth-child(5) { transition-delay: 0.30s; }
        .team-card-slide-in.visible:nth-child(6) { transition-delay: 0.36s; }
        .team-card-slide-in.visible:nth-child(7) { transition-delay: 0.42s; }
        .team-card-slide-in.visible:nth-child(8) { transition-delay: 0.48s; }
        .team-card-slide-in.visible:nth-child(9) { transition-delay: 0.54s; }
        .team-card-slide-in.visible:nth-child(10) { transition-delay: 0.60s; }
        .team-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            max-width: 1400px;
            margin: 0 auto;
        }
        .team-card {
            width: calc(20% - 16px);
            box-sizing: border-box;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease, box-shadow 0.4s ease;
        }
        .team-img-wrapper {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
        }
        .team-card:hover {
            transform: translateY(-8px) !important;
            border-color: #0b7c4d !important;
            box-shadow: 0 20px 40px rgba(11, 124, 77, 0.08) !important;
        }
        .team-card:hover .team-img-wrapper {
            transform: scale(1.05) !important;
            box-shadow: 0 0 25px rgba(11, 124, 77, 0.35) !important;
        }
        
        @media (max-width: 1400px) {
            .team-card {
                width: calc(25% - 15px);
            }
        }
        @media (max-width: 1024px) {
            .team-card {
                width: calc(33.333% - 14px);
            }
        }
        @media (max-width: 768px) {
            .team-card {
                width: calc(50% - 10px);
            }
        }
        @media (max-width: 480px) {
            .team-card {
                width: 100%;
            }
        }
    </style>

<!-- Reviews Section -->
<?php if (!empty($data['reviews'])): ?>
<section class="reviews-section" style="padding: 80px 0; background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-top: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; overflow: hidden; position: relative;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%; position: relative; z-index: 2;">
        <div class="section-title" style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                কমিউনিটির <span style="color: #0b7c4d;">মতামত</span>
            </h2>
            <p style="color: #64748b; margin-top: 10px; font-size: 1.1rem; font-family: 'Hind Siliguri', sans-serif;">আমাদের সম্পর্কে কমিউনিটির কিছু মূল্যবান মতামত</p>
        </div>
    </div>

    <!-- Review Slider Track Wrapper -->
    <div class="reviews-slider-wrapper" style="width: 100%; overflow: hidden; padding: 20px 0;">
        <div class="reviews-track" style="display: flex; gap: 20px; width: max-content; animation: scrollReviews 45s linear infinite;">
            <!-- Render original reviews -->
            <?php foreach (array_merge($data['reviews'], $data['reviews']) as $index => $review): ?>
            <div class="review-slide-card" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 30px 25px; width: 300px; flex-shrink: 0; box-shadow: 0 10px 25px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 15px; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#0b7c4d';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                <!-- Stars -->
                <div style="color: #fbbf24; display: flex; gap: 3px; font-size: 0.9rem;">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
                <!-- Review text -->
                <p style="color: #1e293b; font-size: 0.95rem; line-height: 1.6; margin: 0; font-family: 'Hind Siliguri', sans-serif; height: 90px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;"><?= htmlspecialchars($review['review_text']) ?></p>
                <!-- Profile -->
                <div style="display: flex; align-items: center; gap: 12px; margin-top: auto; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                    <img src="<?= !empty($review['image']) ? $review['image'] : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review['name']))) . '?d=mp&s=150' ?>" alt="<?= $review['name'] ?>" loading="lazy" decoding="async" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1.5px solid #0b7c4d;">
                    <div>
                        <h4 style="font-size: 0.95rem; color: #1e293b; font-weight: 700; margin: 0; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($review['name']) ?></h4>
                        <span style="font-size: 0.8rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($review['designation'] ?? 'নিয়মিত পাঠক') ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    @keyframes scrollReviews {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-320px * <?= count($data['reviews']) ?>)); }
    }
    .reviews-track:hover {
        animation-play-state: paused;
    }
</style>
<?php endif; ?>

<!-- FAQ Section -->
<?php if (!empty($data['faqs'])): ?>
<section class="faq-section faqs-section" style="padding: 80px 0; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-title" style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                সাধারণ <span style="color: #2563eb;">জিজ্ঞাসা</span>
            </h2>
        </div>

        <div class="faq-accordion-container" style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($data['faqs'] as $index => $faq): ?>
            <div class="faq-item faq-item-animate" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s ease;">
                <button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 25px 30px; background: none; border: none; text-align: left; cursor: pointer; outline: none; font-family: 'Hind Siliguri', sans-serif; font-size: 1.25rem; font-weight: 700; color: #1e293b; transition: all 0.3s ease;">
                    <span style="padding-right: 20px; line-height: 1.4;"><?= htmlspecialchars($faq['question']) ?></span>
                    <i class="fas fa-chevron-down faq-icon" style="color: #2563eb; font-size: 1.1rem; transition: transform 0.3s ease;"></i>
                </button>
                <div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s cubic-bezier(0, 1, 0, 1); background: #ffffff;">
                    <div style="padding: 0 30px 25px 30px; color: #1e293b; font-size: 1.1rem; line-height: 1.8; font-family: 'Hind Siliguri', sans-serif; border-top: 1px solid #f1f5f9; text-align: justify; font-weight: 400;">
                        <?= $faq['answer'] ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .faq-item:hover {
        border-color: #2563eb !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.05) !important;
    }
    .faq-item.active {
        border-color: #2563eb !important;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08) !important;
    }
    .faq-item.active .faq-trigger {
        color: #2563eb !important;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }
    .faq-content.open {
        max-height: 1000px !important;
        transition: max-height 0.4s cubic-bezier(1, 0, 1, 0) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqTriggers = document.querySelectorAll('.faq-trigger');
    
    faqTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const faqContent = faqItem.querySelector('.faq-content');
            const isActive = faqItem.classList.contains('active');
            
            // Close all active items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
                item.querySelector('.faq-content').style.maxHeight = '0';
            });
            
            // Toggle clicked item
            if (!isActive) {
                faqItem.classList.add('active');
                // Use scrollHeight for dynamic open height
                faqContent.style.maxHeight = faqContent.scrollHeight + 'px';
            }
        });
    });
});
</script>
<?php endif; ?>

<script>
    // Recent Questions Widget Sliding Logic
    (function() {
        let currentQuestionSlide = 0;
        const track = document.getElementById('questions-track');
        const dots = document.querySelectorAll('#question-dots .question-dot');
        const slidesCount = document.querySelectorAll('.question-slide').length;
        
        if (!track || slidesCount <= 1) return;

        function showQuestionSlide(n) {
            currentQuestionSlide = (n + slidesCount) % slidesCount;
            track.style.transform = `translateX(-${currentQuestionSlide * 100}%)`;
            
            dots.forEach((dot, idx) => {
                if (idx === currentQuestionSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        window.goToQuestionSlide = function(n) {
            showQuestionSlide(n);
            resetQuestionTimer();
        };

        let timer = setInterval(function() {
            showQuestionSlide(currentQuestionSlide + 1);
        }, 6000);

        function resetQuestionTimer() {
            clearInterval(timer);
            timer = setInterval(function() {
                showQuestionSlide(currentQuestionSlide + 1);
            }, 6000);
        }
    })();
</script>

<!-- Islamic Prayer Times Modal Popup -->
<div id="prayerTimesModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 520px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.2); overflow: hidden; position: relative; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        
        <!-- Header Banner -->
        <div style="padding: 22px 28px 16px 28px; background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-mosque"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #ffffff; line-height: 1.2;">আজকের নামাজের সময়সূচী</h3>
                    <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                        <i class="fas fa-map-marker-alt" style="color: #6ee7b7; font-size: 0.85rem;"></i>
                        <span style="font-size: 0.85rem; color: #a7f3d0; font-weight: 600;" id="prayerModalLocation">ঢাকা, বাংলাদেশ</span>
                    </div>
                </div>
            </div>
            <button type="button" data-close-modal="prayerTimesModal" onclick="closePrayerModal(); return false;" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(239, 68, 68, 0.8)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Location Selector & Date Bar -->
        <div style="padding: 12px 24px; background: rgba(0, 0, 0, 0.15); border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px;">
            <!-- District Select Dropdown -->
            <div style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.12); padding: 5px 12px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.25);">
                <i class="fas fa-city" style="color: #f59e0b; font-size: 0.85rem;"></i>
                <select id="prayerDistrictSelect" onchange="changePrayerLocation(this.value)" style="background: transparent; border: none; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; font-weight: 700; outline: none; cursor: pointer; max-width: 200px;">
                    <!-- ঢাকা বিভাগ -->
                    <option value="Dhaka" style="background: #044e39; color: #ffffff;">ঢাকা (Dhaka)</option>
                    <option value="Gazipur" style="background: #044e39; color: #ffffff;">গাজীপুর (Gazipur)</option>
                    <option value="Kishoreganj" style="background: #044e39; color: #ffffff;">কিশোরগঞ্জ (Kishoreganj)</option>
                    <option value="Manikganj" style="background: #044e39; color: #ffffff;">মানিকগঞ্জ (Manikganj)</option>
                    <option value="Munshiganj" style="background: #044e39; color: #ffffff;">মুন্সিগঞ্জ (Munshiganj)</option>
                    <option value="Narayanganj" style="background: #044e39; color: #ffffff;">নারায়ণগঞ্জ (Narayanganj)</option>
                    <option value="Narsingdi" style="background: #044e39; color: #ffffff;">নরসিংদী (Narsingdi)</option>
                    <option value="Faridpur" style="background: #044e39; color: #ffffff;">ফরিদপুর (Faridpur)</option>
                    <option value="Gopalganj" style="background: #044e39; color: #ffffff;">গোপালগঞ্জ (Gopalganj)</option>
                    <option value="Madaripur" style="background: #044e39; color: #ffffff;">মাদারীপুর (Madaripur)</option>
                    <option value="Rajbari" style="background: #044e39; color: #ffffff;">রাজবাড়ী (Rajbari)</option>
                    <option value="Shariatpur" style="background: #044e39; color: #ffffff;">শরীয়তপুর (Shariatpur)</option>
                    <option value="Tangail" style="background: #044e39; color: #ffffff;">টাঙ্গাইল (Tangail)</option>
                    <!-- চট্টগ্রাম বিভাগ -->
                    <option value="Chittagong" style="background: #044e39; color: #ffffff;">চট্টগ্রাম (Chittagong)</option>
                    <option value="Cox's Bazar" style="background: #044e39; color: #ffffff;">কক্সবাজার (Cox's Bazar)</option>
                    <option value="Bandarban" style="background: #044e39; color: #ffffff;">বান্দরবান (Bandarban)</option>
                    <option value="Khagrachhari" style="background: #044e39; color: #ffffff;">খাগড়াছড়ি (Khagrachhari)</option>
                    <option value="Rangamati" style="background: #044e39; color: #ffffff;">রাঙ্গামাটি (Rangamati)</option>
                    <option value="Noakhali" style="background: #044e39; color: #ffffff;">নোয়াখালী (Noakhali)</option>
                    <option value="Feni" style="background: #044e39; color: #ffffff;">ফেনী (Feni)</option>
                    <option value="Lakshmipur" style="background: #044e39; color: #ffffff;">লক্ষ্মীপুর (Lakshmipur)</option>
                    <option value="Comilla" style="background: #044e39; color: #ffffff;">কুমিল্লা (Comilla)</option>
                    <option value="Brahmanbaria" style="background: #044e39; color: #ffffff;">ব্রাহ্মণবাড়িয়া (Brahmanbaria)</option>
                    <option value="Chandpur" style="background: #044e39; color: #ffffff;">চাঁদপুর (Chandpur)</option>
                    <!-- রাজশাহী বিভাগ -->
                    <option value="Rajshahi" style="background: #044e39; color: #ffffff;">রাজশাহী (Rajshahi)</option>
                    <option value="Natore" style="background: #044e39; color: #ffffff;">নাটোর (Natore)</option>
                    <option value="Naogaon" style="background: #044e39; color: #ffffff;">নওগাঁ (Naogaon)</option>
                    <option value="Chapai Nawabganj" style="background: #044e39; color: #ffffff;">চাপাইনবাবগঞ্জ (Chapai Nawabganj)</option>
                    <option value="Pabna" style="background: #044e39; color: #ffffff;">পাবনা (Pabna)</option>
                    <option value="Sirajganj" style="background: #044e39; color: #ffffff;">সিরাজগঞ্জ (Sirajganj)</option>
                    <option value="Bogra" style="background: #044e39; color: #ffffff;">বগুড়া (Bogra)</option>
                    <option value="Joypurhat" style="background: #044e39; color: #ffffff;">জয়পুরহাট (Joypurhat)</option>
                    <!-- খুলনা বিভাগ -->
                    <option value="Khulna" style="background: #044e39; color: #ffffff;">খুলনা (Khulna)</option>
                    <option value="Bagerhat" style="background: #044e39; color: #ffffff;">বাগেরহাট (Bagerhat)</option>
                    <option value="Satkhira" style="background: #044e39; color: #ffffff;">সাতক্ষীরা (Satkhira)</option>
                    <option value="Jashore" style="background: #044e39; color: #ffffff;">যশোর (Jashore)</option>
                    <option value="Magura" style="background: #044e39; color: #ffffff;">মাগুরা (Magura)</option>
                    <option value="Narail" style="background: #044e39; color: #ffffff;">নড়াইল (Narail)</option>
                    <option value="Jhenaidah" style="background: #044e39; color: #ffffff;">ঝিনাইদহ (Jhenaidah)</option>
                    <option value="Kushtia" style="background: #044e39; color: #ffffff;">কুষ্টিয়া (Kushtia)</option>
                    <option value="Meherpur" style="background: #044e39; color: #ffffff;">মেহেরপুর (Meherpur)</option>
                    <option value="Chuadanga" style="background: #044e39; color: #ffffff;">চুয়াডাঙ্গা (Chuadanga)</option>
                    <!-- বরিশাল বিভাগ -->
                    <option value="Barisal" style="background: #044e39; color: #ffffff;">বরিশাল (Barisal)</option>
                    <option value="Bhola" style="background: #044e39; color: #ffffff;">ভোলা (Bhola)</option>
                    <option value="Jhalokati" style="background: #044e39; color: #ffffff;">ঝালকাঠি (Jhalokati)</option>
                    <option value="Pirojpur" style="background: #044e39; color: #ffffff;">পিরোজপুর (Pirojpur)</option>
                    <option value="Barguna" style="background: #044e39; color: #ffffff;">বরগুনা (Barguna)</option>
                    <option value="Patuakhali" style="background: #044e39; color: #ffffff;">পটুয়াখালী (Patuakhali)</option>
                    <!-- সিলেট বিভাগ -->
                    <option value="Sylhet" style="background: #044e39; color: #ffffff;">সিলেট (Sylhet)</option>
                    <option value="Moulvibazar" style="background: #044e39; color: #ffffff;">মৌলভীবাজার (Moulvibazar)</option>
                    <option value="Sunamganj" style="background: #044e39; color: #ffffff;">সুনামগঞ্জ (Sunamganj)</option>
                    <option value="Habiganj" style="background: #044e39; color: #ffffff;">হবিগঞ্জ (Habiganj)</option>
                    <!-- রংপুর বিভাগ -->
                    <option value="Rangpur" style="background: #044e39; color: #ffffff;">রংপুর (Rangpur)</option>
                    <option value="Dinajpur" style="background: #044e39; color: #ffffff;">দিনাজপুর (Dinajpur)</option>
                    <option value="Gaibandha" style="background: #044e39; color: #ffffff;">গাইবান্ধা (Gaibandha)</option>
                    <option value="Kurigram" style="background: #044e39; color: #ffffff;">কুড়িগ্রাম (Kurigram)</option>
                    <option value="Lalmonirhat" style="background: #044e39; color: #ffffff;">লালমনিরহাট (Lalmonirhat)</option>
                    <option value="Nilphamari" style="background: #044e39; color: #ffffff;">নীলফামারী (Nilphamari)</option>
                    <option value="Panchagarh" style="background: #044e39; color: #ffffff;">পঞ্চগড় (Panchagarh)</option>
                    <option value="Thakurgaon" style="background: #044e39; color: #ffffff;">ঠাকুরগাঁও (Thakurgaon)</option>
                    <!-- ময়মনসিংহ বিভাগ -->
                    <option value="Mymensingh" style="background: #044e39; color: #ffffff;">ময়মনসিংহ (Mymensingh)</option>
                    <option value="Jamalpur" style="background: #044e39; color: #ffffff;">জামালপুর (Jamalpur)</option>
                    <option value="Netrokona" style="background: #044e39; color: #ffffff;">নেত্রকোণা (Netrokona)</option>
                    <option value="Sherpur" style="background: #044e39; color: #ffffff;">শেরপুর (Sherpur)</option>
                </select>
            </div>

            <!-- Hijri & English Date -->
            <div style="font-size: 0.85rem; font-weight: 600; color: #fef08a;">
                <span id="prayerModalHijri"><i class="fas fa-moon" style="margin-right: 4px; color: #6ee7b7;"></i> তারিখ লোড হচ্ছে...</span>
            </div>
        </div>

        <!-- Active Prayer Status & Next Prayer Countdown Banner -->
        <div id="activePrayerBanner" style="padding: 14px 24px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.22), rgba(16, 185, 129, 0.25)); border-bottom: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: space-between; font-family: 'Hind Siliguri', sans-serif;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #f59e0b; color: #044e39; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; box-shadow: 0 0 12px rgba(245, 158, 11, 0.5);">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <div style="font-size: 0.78rem; color: #a7f3d0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px;">বর্তমান ওয়াক্ত</div>
                    <div style="font-size: 1.15rem; font-weight: 900; color: #fef08a;" id="currentWaqtName">হিসাব করা হচ্ছে...</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.8rem; color: #e2e8f0; font-weight: 700;" id="nextWaqtLabel">পরবর্তী ওয়াক্ত: --</div>
                <div style="font-size: 0.98rem; font-weight: 800; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;" id="nextWaqtCountdown"><i class="fas fa-clock" style="color: #6ee7b7; margin-right: 4px;"></i> গণনা করা হচ্ছে...</div>
            </div>
        </div>

        <!-- Prayer Times Grid List -->
        <div style="padding: 18px 24px; display: grid; gap: 10px;" id="prayerTimesContainer">
            <!-- Fajr -->
            <div id="row-fajr" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-cloud-sun" style="color: #6ee7b7; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 700; font-size: 1rem;">ফজর (Fajr)</span>
                    <span id="badge-fajr" style="display: none; background: #f59e0b; color: #044e39; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; margin-left: 6px;">বর্তমান ওয়াক্ত</span>
                </div>
                <span id="timeFajr" style="font-weight: 800; font-size: 1.05rem; color: #fef08a; font-family: 'Outfit', sans-serif;">০৪:৩০ AM</span>
            </div>

            <!-- Sunrise -->
            <div id="row-sunrise" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.05); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.08); opacity: 0.85;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-sun" style="color: #fde047; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 600; font-size: 0.95rem;">সূর্যোদয় (Sunrise)</span>
                </div>
                <span id="timeSunrise" style="font-weight: 700; font-size: 1rem; color: #ffffff; font-family: 'Outfit', sans-serif;">০৫:৪৮ AM</span>
            </div>

            <!-- Dhuhr -->
            <div id="row-dhuhr" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-sun" style="color: #f59e0b; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 700; font-size: 1rem;">যোহর (Dhuhr)</span>
                    <span id="badge-dhuhr" style="display: none; background: #f59e0b; color: #044e39; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; margin-left: 6px;">বর্তমান ওয়াক্ত</span>
                </div>
                <span id="timeDhuhr" style="font-weight: 800; font-size: 1.05rem; color: #fef08a; font-family: 'Outfit', sans-serif;">১২:০৫ PM</span>
            </div>

            <!-- Asr -->
            <div id="row-asr" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-cloud-sun-rain" style="color: #fb923c; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 700; font-size: 1rem;">আসর (Asr)</span>
                    <span id="badge-asr" style="display: none; background: #f59e0b; color: #044e39; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; margin-left: 6px;">বর্তমান ওয়াক্ত</span>
                </div>
                <span id="timeAsr" style="font-weight: 800; font-size: 1.05rem; color: #fef08a; font-family: 'Outfit', sans-serif;">০৪:২৫ PM</span>
            </div>

            <!-- Maghrib -->
            <div id="row-maghrib" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-moon" style="color: #a7f3d0; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 700; font-size: 1rem;">মাগরিব (Maghrib)</span>
                    <span id="badge-maghrib" style="display: none; background: #f59e0b; color: #044e39; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; margin-left: 6px;">বর্তমান ওয়াক্ত</span>
                </div>
                <span id="timeMaghrib" style="font-weight: 800; font-size: 1.05rem; color: #fef08a; font-family: 'Outfit', sans-serif;">০৬:১০ PM</span>
            </div>

            <!-- Isha -->
            <div id="row-isha" class="prayer-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-star-and-crescent" style="color: #818cf8; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <span style="font-weight: 700; font-size: 1rem;">এশা (Isha)</span>
                    <span id="badge-isha" style="display: none; background: #f59e0b; color: #044e39; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; margin-left: 6px;">বর্তমান ওয়াক্ত</span>
                </div>
                <span id="timeIsha" style="font-weight: 800; font-size: 1.05rem; color: #fef08a; font-family: 'Outfit', sans-serif;">০৭:৩০ PM</span>
            </div>
        </div>
    </div>
</div>

<script>

    const districtNamesBn = {
        'Dhaka': 'ঢাকা', 'Gazipur': 'গাজীপুর', 'Kishoreganj': 'কিশোরগঞ্জ', 'Manikganj': 'মানিকগঞ্জ', 'Munshiganj': 'মুন্সীগঞ্জ', 'Narayanganj': 'নারায়ণগঞ্জ', 'Narsingdi': 'নরসিংদী', 'Faridpur': 'ফরিদপুর', 'Gopalganj': 'গোপালগঞ্জ', 'Madaripur': 'মাদারীপুর', 'Rajbari': 'রাজবাড়ী', 'Shariatpur': 'শরীয়তপুর', 'Tangail': 'টাঙ্গাইল',
        'Chittagong': 'চট্টগ্রাম', "Cox's Bazar": 'কক্সবাজার', 'Bandarban': 'বান্দরবান', 'Khagrachhari': 'খাগড়াছড়ি', 'Rangamati': 'রাঙ্গামাটি', 'Noakhali': 'নোয়াখালী', 'Feni': 'ফেনী', 'Lakshmipur': 'লক্ষ্মীপুর', 'Comilla': 'কুমিল্লা', 'Brahmanbaria': 'ব্রাহ্মণবাড়িয়া', 'Chandpur': 'চাঁদপুর',
        'Rajshahi': 'রাজশাহী', 'Natore': 'নাটোর', 'Naogaon': 'নওগাঁ', 'Chapai Nawabganj': 'চাঁপাইনবাবগঞ্জ', 'Pabna': 'পাবনা', 'Sirajganj': 'সিরাজগঞ্জ', 'Bogra': 'বগুড়া', 'Joypurhat': 'জয়পুরহাট',
        'Khulna': 'খুলনা', 'Bagerhat': 'বাগেরহাট', 'Satkhira': 'সাতক্ষীরা', 'Jashore': 'যশোর', 'Magura': 'মাগুরা', 'Narail': 'নড়াইল', 'Jhenaidah': 'ঝিনাইদহ', 'Kushtia': 'কুষ্টিয়া', 'Meherpur': 'মেহেরপুর', 'Chuadanga': 'চুয়াডাঙ্গা',
        'Barisal': 'বরিশাল', 'Bhola': 'ভোলা', 'Jhalokati': 'ঝালকাঠি', 'Pirojpur': 'পিরোজপুর', 'Barguna': 'বরগুনা', 'Patuakhali': 'পটুয়াখালী',
        'Sylhet': 'সিলেট', 'Moulvibazar': 'মৌলভীবাজার', 'Sunamganj': 'সুনামগঞ্জ', 'Habiganj': 'হবিগঞ্জ',
        'Rangpur': 'রংপুর', 'Dinajpur': 'দিনাজপুর', 'Gaibandha': 'গাইবান্ধা', 'Kurigram': 'কুড়িগ্রাম', 'Lalmonirhat': 'লালমনিরহাট', 'Nilphamari': 'নীলফামারী', 'Panchagarh': 'পঞ্চগড়', 'Thakurgaon': 'ঠাকুরগাঁও',
        'Mymensingh': 'ময়মনসিংহ', 'Jamalpur': 'জামালপুর', 'Netrokona': 'নেত্রকোণা', 'Sherpur': 'শেরপুর'
    };

    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function formatTime12h(time24) {
        if (!time24) return '';
        let [hours, minutes] = time24.split(':');
        hours = parseInt(hours, 10);
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        let strHrs = hours < 10 ? '0' + hours : hours;
        return toBnNum(strHrs + ':' + minutes) + ' ' + ampm;
    }

    function timeToMins(time24) {
        if (!time24) return 0;
        let parts = time24.split(':');
        return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
    }

    function calculateActiveAndNextPrayer(timings) {
        const fajr = timeToMins(timings.Fajr);
        const sunrise = timeToMins(timings.Sunrise);
        const dhuhr = timeToMins(timings.Dhuhr);
        const asr = timeToMins(timings.Asr);
        const maghrib = timeToMins(timings.Maghrib);
        const isha = timeToMins(timings.Isha);

        const now = new Date();
        const nowMins = now.getHours() * 60 + now.getMinutes();

        let currentWaqt = '';
        let currentKey = '';
        let nextWaqt = '';
        let nextMins = 0;

        if (nowMins < fajr) {
            currentWaqt = 'এশা (Isha)';
            currentKey = 'isha';
            nextWaqt = 'ফজর (Fajr)';
            nextMins = fajr;
        } else if (nowMins >= fajr && nowMins < sunrise) {
            currentWaqt = 'ফজর (Fajr)';
            currentKey = 'fajr';
            nextWaqt = 'সূর্যোদয় (Sunrise)';
            nextMins = sunrise;
        } else if (nowMins >= sunrise && nowMins < dhuhr) {
            currentWaqt = 'ইশরাক / চাশত';
            currentKey = '';
            nextWaqt = 'যোহর (Dhuhr)';
            nextMins = dhuhr;
        } else if (nowMins >= dhuhr && nowMins < asr) {
            currentWaqt = 'যোহর (Dhuhr)';
            currentKey = 'dhuhr';
            nextWaqt = 'আসর (Asr)';
            nextMins = asr;
        } else if (nowMins >= asr && nowMins < maghrib) {
            currentWaqt = 'আসর (Asr)';
            currentKey = 'asr';
            nextWaqt = 'মাগরিব (Maghrib)';
            nextMins = maghrib;
        } else if (nowMins >= maghrib && nowMins < isha) {
            currentWaqt = 'মাগরিব (Maghrib)';
            currentKey = 'maghrib';
            nextWaqt = 'এশা (Isha)';
            nextMins = isha;
        } else {
            currentWaqt = 'এশা (Isha)';
            currentKey = 'isha';
            nextWaqt = 'ফজর (Fajr)';
            nextMins = fajr + 1440; // Fajr tomorrow
        }

        let diff = nextMins - nowMins;
        if (diff < 0) diff += 1440;

        let hrs = Math.floor(diff / 60);
        let mins = diff % 60;
        let countdownStr = '';
        if (hrs > 0) {
            countdownStr += toBnNum(hrs) + ' ঘণ্টা ';
        }
        countdownStr += toBnNum(mins) + ' মিনিট বাকি';

        document.getElementById('currentWaqtName').innerText = currentWaqt;
        document.getElementById('nextWaqtLabel').innerText = 'পরবর্তী ওয়াক্ত: ' + nextWaqt;
        document.getElementById('nextWaqtCountdown').innerHTML = '<i class="fas fa-hourglass-half" style="color: #6ee7b7; margin-right: 4px;"></i> ' + countdownStr;

        // Reset all row highlights and badges
        ['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'].forEach(k => {
            const row = document.getElementById('row-' + k);
            const badge = document.getElementById('badge-' + k);
            if (row) {
                row.style.background = 'rgba(255, 255, 255, 0.08)';
                row.style.borderColor = 'rgba(255, 255, 255, 0.12)';
                row.style.boxShadow = 'none';
            }
            if (badge) badge.style.display = 'none';
        });

        // Highlight active row
        if (currentKey) {
            const activeRow = document.getElementById('row-' + currentKey);
            const activeBadge = document.getElementById('badge-' + currentKey);
            if (activeRow) {
                activeRow.style.background = 'rgba(245, 158, 11, 0.22)';
                activeRow.style.borderColor = '#f59e0b';
                activeRow.style.boxShadow = '0 0 16px rgba(245, 158, 11, 0.3)';
            }
            if (activeBadge) activeBadge.style.display = 'inline-block';
        }
    }

    function fetchPrayerTimesForCity(city) {
        const locLabel = (districtNamesBn[city] || city) + ', বাংলাদেশ';
        document.getElementById('prayerModalLocation').innerText = locLabel;

        fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=Bangladesh&method=1`)
            .then(res => res.json())
            .then(data => {
                if (data && data.data) {
                    const timings = data.data.timings;
                    const dateInfo = data.data.date;

                    if (timings.Fajr) document.getElementById('timeFajr').innerText = formatTime12h(timings.Fajr);
                    if (timings.Sunrise) document.getElementById('timeSunrise').innerText = formatTime12h(timings.Sunrise);
                    if (timings.Dhuhr) document.getElementById('timeDhuhr').innerText = formatTime12h(timings.Dhuhr);
                    if (timings.Asr) document.getElementById('timeAsr').innerText = formatTime12h(timings.Asr);
                    if (timings.Maghrib) document.getElementById('timeMaghrib').innerText = formatTime12h(timings.Maghrib);
                    if (timings.Isha) document.getElementById('timeIsha').innerText = formatTime12h(timings.Isha);

                    // Calculate active waqt and remaining countdown
                    calculateActiveAndNextPrayer(timings);

                    if (dateInfo && dateInfo.hijri) {
                        const hijri = dateInfo.hijri;
                        const hijriMonthBn = translateHijriMonthToBn(hijri.month.en || hijri.month.number || '');
                        document.getElementById('prayerModalHijri').innerHTML = '<i class="fas fa-moon" style="margin-right: 4px; color: #6ee7b7;"></i> ' + toBnNum(hijri.day) + ' ' + hijriMonthBn + ' ' + toBnNum(hijri.year) + ' হিজরী';
                    }
                }
            })
            .catch(err => {
                console.log('Prayer timings load fallback:', err);
            });
    }

    function changePrayerLocation(city) {
        fetchPrayerTimesForCity(city);
    }

    function openPrayerModal() {
        window.safeOpenModal("prayerTimesModal");
        try {
            const el = document.getElementById("prayerDistrictSelect");
            const currentSelectedCity = (el && el.value) ? el.value : "Dhaka";
            fetchPrayerTimesForCity(currentSelectedCity);
        } catch(e) { console.error(e); }
    }

    function closePrayerModal() { window.safeCloseModal('prayerTimesModal'); }
</script>

<!-- Islamic Calendar Modal Popup -->
<div id="islamicCalendarModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 580px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.2); overflow: hidden; position: relative; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        
        <!-- Header Banner -->
        <div style="padding: 22px 28px 16px 28px; background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #ffffff; line-height: 1.2;">ইসলামিক হিজরী ক্যালেন্ডার</h3>
                    <p style="margin: 3px 0 0 0; font-size: 0.85rem; color: #a7f3d0; font-weight: 500;" id="calendarModalSub">হিজরী ও ঈসায়ী বর্ষপঞ্জি</p>
                </div>
            </div>
            <button type="button" data-close-modal="islamicCalendarModal" onclick="closeCalendarModal(); return false;" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(239, 68, 68, 0.8)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Month Navigation Bar -->
        <div style="padding: 14px 24px; background: rgba(0, 0, 0, 0.18); border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between;">
            <button onclick="navCalMonth(-1)" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 6px 14px; border-radius: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; font-weight: 700;">
                <i class="fas fa-chevron-left" style="margin-right: 4px;"></i> পূর্ববর্তী
            </button>
            <div style="text-align: center;">
                <div style="font-size: 1.1rem; font-weight: 800; color: #fef08a;" id="calMonthTitle">সেপ্টেম্বর ২০২৬</div>
                <div style="font-size: 0.82rem; color: #6ee7b7; font-weight: 600;" id="calHijriMonthTitle">রবীউস সানী ১৪৪৮ হিজরী</div>
            </div>
            <button onclick="navCalMonth(1)" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 6px 14px; border-radius: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; font-weight: 700;">
                পরবর্তী <i class="fas fa-chevron-right" style="margin-left: 4px;"></i>
            </button>
        </div>

        <!-- Days of Week Header -->
        <div style="display: grid; grid-template-columns: repeat(7, 1fr); padding: 10px 20px 5px 20px; text-align: center; font-size: 0.85rem; font-weight: 800; color: #f59e0b; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <div>রবি</div>
            <div>সোম</div>
            <div>মঙ্গল</div>
            <div>বুধ</div>
            <div>বৃহঃ</div>
            <div style="color: #6ee7b7;">শুক্রবার</div>
            <div>শনি</div>
        </div>

        <!-- Calendar Days Grid Container -->
        <div style="padding: 12px 20px 20px 20px; display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px;" id="calendarDaysGrid">
            <!-- Rendered dynamically -->
        </div>

        <!-- Footer Info -->
        <div style="padding: 12px 24px; background: rgba(0, 0, 0, 0.25); text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.82rem; color: #9ca3af;">
            <i class="fas fa-star" style="color: #f59e0b; margin-right: 4px;"></i> চাঁদ দেখার উপর ভিত্তি করে হিজরী তারিখ ১ দিন কম-বেশি হতে পারে।
        </div>
    </div>
</div>

<script>
    let currentCalDate = new Date();
    const bnMonths = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];

    function openCalendarModal() {
        window.safeOpenModal("islamicCalendarModal");
        try {
            currentCalDate = new Date();
            renderIslamicCalendar(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1);
        } catch(e) { console.error(e); }
    }

    function closeCalendarModal() {
        const modal = document.getElementById('islamicCalendarModal');
        if (!modal) return;
        modal.style.opacity = '0';
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }

    function navCalMonth(offset) {
        currentCalDate.setMonth(currentCalDate.getMonth() + offset);
        renderIslamicCalendar(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1);
    }

    const hijriMonthNamesBn = {
        1: 'মুহররম', 2: 'সফর', 3: 'রবিউল আউয়াল', 4: 'রবিউস সানি',
        5: 'জমাদিউল আউয়াল', 6: 'জমাদিউস সানি', 7: 'রজব', 8: 'শাবান',
        9: 'রমজান', 10: 'শাওয়াল', 11: 'জিলকদ', 12: 'জিলহজ'
    };

    function translateHijriMonthToBn(mVal) {
        if (!mVal) return '';
        if (typeof mVal === 'number' || !isNaN(parseInt(mVal))) {
            const num = parseInt(mVal);
            if (hijriMonthNamesBn[num]) return hijriMonthNamesBn[num];
        }
        const str = String(mVal).toLowerCase();
        if (str.includes('muharram')) return 'মুহররম';
        if (str.includes('safar')) return 'সফর';
        if (str.includes('rabi') && (str.includes('awwal') || str.includes('i') || str.includes('1'))) return 'রবিউল আউয়াল';
        if (str.includes('rabi') && (str.includes('thani') || str.includes('ii') || str.includes('2'))) return 'রবিউস সানি';
        if (str.includes('jumad') && (str.includes('ula') || str.includes('i') || str.includes('1'))) return 'জমাদিউল আউয়াল';
        if (str.includes('jumad') && (str.includes('akhir') || str.includes('ii') || str.includes('2'))) return 'জমাদিউস সানি';
        if (str.includes('rajab')) return 'রজব';
        if (str.includes('sha')) return 'শাবান';
        if (str.includes('ramad')) return 'রমজান';
        if (str.includes('shawwal')) return 'শাওয়াল';
        if (str.includes('qi') || str.includes('qadah')) return 'জিলকদ';
        if (str.includes('hijjah')) return 'জিলহজ';
        return mVal;
    }

    function getHijriDetails(dateObj) {
        try {
            const formatter = new Intl.DateTimeFormat('en-US-u-ca-islamic-umalqura', { day: 'numeric', month: 'numeric', year: 'numeric' });
            const parts = formatter.formatToParts(dateObj);
            let day = 1, month = 1, year = 1448;
            parts.forEach(p => {
                if (p.type === 'day') day = parseInt(p.value, 10);
                if (p.type === 'month') month = parseInt(p.value, 10);
                if (p.type === 'year') year = parseInt(p.value, 10);
            });
            return { day, month, monthName: hijriMonthNamesBn[month] || '', year };
        } catch (e) {
            return getTabularHijriDate(dateObj);
        }
    }

    function getTabularHijriDate(date) {
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        let m = month, y = year;
        if (m < 3) { y -= 1; m += 12; }

        let a = Math.floor(y / 100);
        let b = 2 - a + Math.floor(a / 4);
        let jd = Math.floor(365.25 * (y + 4716)) + Math.floor(30.6001 * (m + 1)) + day + b - 1524.5;

        let l = Math.floor(jd) - 1948440 + 10632;
        let n = Math.floor((l - 1) / 10631);
        l = l - 10631 * n + 354;
        let j = (Math.floor((10985 - l) / 5316)) * (Math.floor((50 * l) / 17719)) + (Math.floor(l / 5670)) * (Math.floor((43 * l) / 15238));
        l = l - (Math.floor((30 - j) / 15)) * (Math.floor((17719 * j) / 50)) - (Math.floor(j / 16)) * (Math.floor((15238 * j) / 43)) + 29;
        let hMonth = Math.floor((24 * l) / 709);
        let hDay = l - Math.floor((709 * hMonth) / 24);
        let hYear = 30 * n + j - 30;

        return { day: hDay, month: hMonth, monthName: hijriMonthNamesBn[hMonth] || '', year: hYear };
    }

    function renderIslamicCalendar(year, month) {
        const monthTitle = bnMonths[month - 1] + ' ' + toBnNum(year);
        document.getElementById('calMonthTitle').innerText = monthTitle;
        document.getElementById('calHijriMonthTitle').innerText = 'হিজরী ক্যালেন্ডার লোড হচ্ছে...';
        
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 30px 0; color: #a7f3d0;"><i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 8px; display: block;"></i> ক্যালেন্ডার তথ্য সংগৃহীত হচ্ছে...</div>';

        let isHandled = false;
        const controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        const timeoutId = setTimeout(() => {
            if (!isHandled) {
                isHandled = true;
                if (controller) controller.abort();
                renderOfflineHijriCalendar(year, month);
            }
        }, 2500);

        const fetchOptions = controller ? { signal: controller.signal } : {};

        fetch(`https://api.aladhan.com/v1/gregorianCalendarByCity?city=Dhaka&country=Bangladesh&month=${month}&year=${year}&method=1`, fetchOptions)
            .then(res => {
                if (!res.ok) throw new Error('API Response Error');
                return res.json();
            })
            .then(data => {
                clearTimeout(timeoutId);
                if (isHandled) return;
                if (data && data.data && data.data.length > 0) {
                    isHandled = true;
                    renderCalendarFromDays(data.data, year, month);
                } else {
                    isHandled = true;
                    renderOfflineHijriCalendar(year, month);
                }
            })
            .catch(err => {
                clearTimeout(timeoutId);
                if (!isHandled) {
                    isHandled = true;
                    renderOfflineHijriCalendar(year, month);
                }
            });
    }

    function renderCalendarFromDays(monthDays, year, month) {
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '';

        const firstDayOfWeek = new Date(year, month - 1, 1).getDay();

        const midDay = monthDays[Math.floor(monthDays.length / 2)];
        if (midDay && midDay.date && midDay.date.hijri) {
            const rawHMonth = midDay.date.hijri.month.en || midDay.date.hijri.month.number || '';
            const hMonth = translateHijriMonthToBn(rawHMonth);
            const hYear = midDay.date.hijri.year || '';
            document.getElementById('calHijriMonthTitle').innerText = hMonth + ' ' + toBnNum(hYear) + ' হিজরী';
        }

        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyCell = document.createElement('div');
            grid.appendChild(emptyCell);
        }

        const today = new Date();
        const isCurrentMonth = today.getFullYear() === year && (today.getMonth() + 1) === month;
        const todayDate = today.getDate();

        monthDays.forEach(dayInfo => {
            const gDay = parseInt(dayInfo.date.gregorian.day, 10);
            const hDay = dayInfo.date.hijri.day;
            const isToday = isCurrentMonth && (gDay === todayDate);
            const isFriday = new Date(year, month - 1, gDay).getDay() === 5;

            const dayBox = document.createElement('div');
            dayBox.style.cssText = `
                padding: 8px 4px;
                text-align: center;
                border-radius: 12px;
                background: ${isToday ? 'rgba(245, 158, 11, 0.25)' : (isFriday ? 'rgba(16, 185, 129, 0.12)' : 'rgba(255, 255, 255, 0.06)')};
                border: ${isToday ? '1px solid #f59e0b' : '1px solid rgba(255, 255, 255, 0.08)'};
                box-shadow: ${isToday ? '0 0 12px rgba(245, 158, 11, 0.4)' : 'none'};
                transition: transform 0.15s ease;
            `;

            dayBox.innerHTML = `
                <div style="font-size: 0.95rem; font-weight: 800; color: ${isToday ? '#fef08a' : (isFriday ? '#6ee7b7' : '#ffffff')}; font-family: 'Outfit', sans-serif;">${toBnNum(gDay)}</div>
                <div style="font-size: 0.72rem; color: ${isToday ? '#fde047' : '#9ca3af'}; font-weight: 600; margin-top: 2px;">${toBnNum(hDay)} হিজরী</div>
            `;

            grid.appendChild(dayBox);
        });
    }

    function renderOfflineHijriCalendar(year, month) {
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '';

        const daysInMonth = new Date(year, month, 0).getDate();
        const firstDayOfWeek = new Date(year, month - 1, 1).getDay();

        const midDate = new Date(year, month - 1, Math.floor(daysInMonth / 2));
        const midHijri = getHijriDetails(midDate);
        document.getElementById('calHijriMonthTitle').innerText = midHijri.monthName + ' ' + toBnNum(midHijri.year) + ' হিজরী';

        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyCell = document.createElement('div');
            grid.appendChild(emptyCell);
        }

        const today = new Date();
        const isCurrentMonth = today.getFullYear() === year && (today.getMonth() + 1) === month;
        const todayDate = today.getDate();

        for (let gDay = 1; gDay <= daysInMonth; gDay++) {
            const curDate = new Date(year, month - 1, gDay);
            const hDetails = getHijriDetails(curDate);
            const isToday = isCurrentMonth && (gDay === todayDate);
            const isFriday = curDate.getDay() === 5;

            const dayBox = document.createElement('div');
            dayBox.style.cssText = `
                padding: 8px 4px;
                text-align: center;
                border-radius: 12px;
                background: ${isToday ? 'rgba(245, 158, 11, 0.25)' : (isFriday ? 'rgba(16, 185, 129, 0.12)' : 'rgba(255, 255, 255, 0.06)')};
                border: ${isToday ? '1px solid #f59e0b' : '1px solid rgba(255, 255, 255, 0.08)'};
                box-shadow: ${isToday ? '0 0 12px rgba(245, 158, 11, 0.4)' : 'none'};
                transition: transform 0.15s ease;
            `;

            dayBox.innerHTML = `
                <div style="font-size: 0.95rem; font-weight: 800; color: ${isToday ? '#fef08a' : (isFriday ? '#6ee7b7' : '#ffffff')}; font-family: 'Outfit', sans-serif;">${toBnNum(gDay)}</div>
                <div style="font-size: 0.72rem; color: ${isToday ? '#fde047' : '#9ca3af'}; font-weight: 600; margin-top: 2px;">${toBnNum(hDetails.day)} হিজরী</div>
            `;

            grid.appendChild(dayBox);
        }
    }
</script>

<!-- 1. Digital Tasbih Modal Popup -->
<div id="digitalTasbihModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 480px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.2); overflow: hidden; position: relative; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-beads" style="color: #fb923c; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">ডিজিটাল তাসবীহ গণক</h3>
            </div>
            <button onclick="closeTasbihModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 24px; text-align: center;">
            <select id="tasbihZikrSelect" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; color: #fff; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 20px; outline: none;">
                <option value="সুবহানাল্লাহ" style="background:#044e39;">سُبْحَانَ الله (সুবহানাল্লাহ)</option>
                <option value="আলহামদুলিল্লাহ" style="background:#044e39;">الْحَمْدُ لِلّٰهِ (আলহামদুলিল্লাহ)</option>
                <option value="আল্লাহু আকবার" style="background:#044e39;">اللهُ أَكْبَرُ (আল্লাহু আকবার)</option>
                <option value="লা ইলাহা ইল্লাল্লাহ" style="background:#044e39;">لَا إِلٰهَ إِلَّا اللهُ (লা ইলাহা ইল্লাল্লাহ)</option>
                <option value="আস্তাগফিরুল্লাহ" style="background:#044e39;">أَسْتَغْفِرُ اللهَ (আস্তাগফিরুল্লাহ)</option>
                <option value="সুবহানাল্লাহি ওয়াবিহামদিহি" style="background:#044e39;">سُبْحَانَ اللهِ وَبِحَمْدِهِ (সুবহানাল্লাহি ওয়াবিহামদিহি)</option>
            </select>
            <div style="width: 150px; height: 150px; margin: 0 auto 20px auto; border-radius: 50%; background: radial-gradient(circle, rgba(245,158,11,0.2) 0%, rgba(5,150,105,0.1) 100%); border: 3px solid #f59e0b; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(245,158,11,0.3);">
                <div style="font-size: 3.2rem; font-weight: 900; color: #fef08a; font-family: 'Outfit', sans-serif; line-height: 1;" id="tasbihCounter">০</div>
                <div style="font-size: 0.75rem; color: #a7f3d0; margin-top: 4px;">মোট গণনা</div>
            </div>
            <button onclick="countTasbih()" style="width: 100%; max-width: 260px; padding: 16px; border-radius: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: #ffffff; font-size: 1.2rem; font-weight: 900; cursor: pointer; box-shadow: 0 8px 20px rgba(245,158,11,0.4); transition: transform 0.1s ease;" onmousedown="this.style.transform='scale(0.96)';" onmouseup="this.style.transform='scale(1)';">
                <i class="fas fa-hand-pointer" style="margin-right: 8px;"></i> গণনা করুন (+১)
            </button>
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 15px;">
                <button onclick="resetTasbih()" style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; padding: 8px 18px; border-radius: 20px; font-size: 0.88rem; cursor: pointer; font-weight: 700;">
                    <i class="fas fa-redo" style="margin-right: 4px;"></i> রিসেট (Reset)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Daily Masnoon Dua Modal Popup -->
<div id="dailyDuaModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 620px; max-height: 85vh; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); overflow: hidden; display: flex; flex-direction: column; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-hands-praying" style="color: #38bdf8; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">প্রতিদিনের গুরুত্বপূর্ণ দো'আ ও যিকর</h3>
            </div>
            <button onclick="closeDuaModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; overflow-y: auto; display: grid; gap: 14px;" id="duaListContainer">
            <!-- Duas inserted via JS -->
        </div>
    </div>
</div>

<!-- 3. 99 Names of Allah Modal Popup -->
<div id="asmaUlHusnaModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 720px; height: 85vh; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); overflow: hidden; display: flex; flex-direction: column; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-star-and-crescent" style="color: #c084fc; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">আল্লাহ তা'আলার ৯৯টি গুণবাচক নাম (আসমাউল হুসনা)</h3>
            </div>
            <button onclick="closeAsmaModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; overflow-y: auto; flex: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 12px;" id="asmaGridContainer">
            <!-- 99 Names inserted via JS -->
        </div>
    </div>
</div>


<!-- 1. Digital Tasbih Modal Popup -->
<div id="digitalTasbihModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 480px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.2); overflow: hidden; position: relative; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-beads" style="color: #fb923c; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">ডিজিটাল তাসবীহ গণক</h3>
            </div>
            <button onclick="closeTasbihModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 24px; text-align: center;">
            <select id="tasbihZikrSelect" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; color: #fff; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 20px; outline: none;">
                <option value="সুবহানাল্লাহ" style="background:#044e39;">سُبْحَانَ الله (সুবহানাল্লাহ)</option>
                <option value="আলহামদুলিল্লাহ" style="background:#044e39;">الْحَمْدُ لِلّٰهِ (আলহামদুলিল্লাহ)</option>
                <option value="আল্লাহু আকবার" style="background:#044e39;">اللهُ أَكْبَرُ (আল্লাহু আকবার)</option>
                <option value="লা ইলাহা ইল্লাল্লাহ" style="background:#044e39;">لَا إِلٰهَ إِلَّا اللهُ (লা ইলাহা ইল্লাল্লাহ)</option>
                <option value="আস্তাগফিরুল্লাহ" style="background:#044e39;">أَسْتَغْفِرُ اللهَ (আস্তাগফিরুল্লাহ)</option>
                <option value="সুবহানাল্লাহি ওয়াবিহামদিহি" style="background:#044e39;">سُبْحَانَ اللهِ وَبِحَمْدِهِ (সুবহানাল্লাহি ওয়াবিহামদিহি)</option>
            </select>
            <div style="width: 150px; height: 150px; margin: 0 auto 20px auto; border-radius: 50%; background: radial-gradient(circle, rgba(245,158,11,0.2) 0%, rgba(5,150,105,0.1) 100%); border: 3px solid #f59e0b; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(245,158,11,0.3);">
                <div style="font-size: 3.2rem; font-weight: 900; color: #fef08a; font-family: 'Outfit', sans-serif; line-height: 1;" id="tasbihCounter">০</div>
                <div style="font-size: 0.75rem; color: #a7f3d0; margin-top: 4px;">মোট গণনা</div>
            </div>
            <button onclick="countTasbih()" style="width: 100%; max-width: 260px; padding: 16px; border-radius: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: #ffffff; font-size: 1.2rem; font-weight: 900; cursor: pointer; box-shadow: 0 8px 20px rgba(245,158,11,0.4); transition: transform 0.1s ease;" onmousedown="this.style.transform='scale(0.96)';" onmouseup="this.style.transform='scale(1)';">
                <i class="fas fa-hand-pointer" style="margin-right: 8px;"></i> গণনা করুন (+১)
            </button>
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 15px;">
                <button onclick="resetTasbih()" style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; padding: 8px 18px; border-radius: 20px; font-size: 0.88rem; cursor: pointer; font-weight: 700;">
                    <i class="fas fa-redo" style="margin-right: 4px;"></i> রিসেট (Reset)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Daily Masnoon Dua Modal Popup -->
<div id="dailyDuaModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 620px; max-height: 85vh; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); overflow: hidden; display: flex; flex-direction: column; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-hands-praying" style="color: #38bdf8; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">প্রতিদিনের গুরুত্বপূর্ণ দো'আ ও যিকর</h3>
            </div>
            <button onclick="closeDuaModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; overflow-y: auto; display: grid; gap: 14px;" id="duaListContainer">
            <!-- Duas inserted via JS -->
        </div>
    </div>
</div>

<!-- 3. 99 Names of Allah Modal Popup -->
<div id="asmaUlHusnaModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 720px; height: 85vh; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); overflow: hidden; display: flex; flex-direction: column; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-star-and-crescent" style="color: #c084fc; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800;">আল্লাহ তা'আলার ৯৯টি গুণবাচক নাম (আসমাউল হুসনা)</h3>
            </div>
            <button onclick="closeAsmaModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; overflow-y: auto; flex: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 12px;" id="asmaGridContainer">
            <!-- 99 Names inserted via JS -->
        </div>
    </div>
</div>

<!-- 4. Zakat Calculator Modal Popup -->
<div id="zakatCalculatorModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 44, 34, 0.85); backdrop-filter: blur(12px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: linear-gradient(145deg, #065f46 0%, #044e39 60%, #022c22 100%); border: 1px solid rgba(245, 158, 11, 0.3); width: 100%; max-width: 520px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.2); overflow: hidden; position: relative; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        <div style="padding: 20px 24px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-calculator" style="color: #f59e0b; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">যাকাত ক্যালকুলেটর</h3>
            </div>
            <button onclick="closeZakatModal()" style="background: rgba(255,255,255,0.12); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 24px;">
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #a7f3d0; margin-bottom: 6px;">নগদ টাকা ও ব্যাংক ব্যালেন্স (টাকা):</label>
                <input type="number" id="zakatCash" placeholder="০" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: #fff; font-size: 0.95rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #a7f3d0; margin-bottom: 6px;">সোনা ও রূপার বর্তমান বাজারমূল্য (টাকা):</label>
                <input type="number" id="zakatGold" placeholder="০" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: #fff; font-size: 0.95rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #a7f3d0; margin-bottom: 6px;">ব্যবসায়িক পণ্যের মূল্য (টাকা):</label>
                <input type="number" id="zakatBusiness" placeholder="০" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: #fff; font-size: 0.95rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>
            <button onclick="calcZakat()" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #10b981, #059669); border: none; color: #fff; font-size: 1.05rem; font-weight: 800; border-radius: 12px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 14px rgba(16,185,129,0.3);">
                <i class="fas fa-calculator" style="margin-right: 6px;"></i> যাকাত গণনা করুন (২.৫%)
            </button>
            <div style="margin-top: 20px; padding: 16px; background: rgba(0,0,0,0.25); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 14px; text-align: center;">
                <div style="font-size: 0.88rem; color: #a7f3d0; margin-bottom: 4px;">আপনার প্রদেয় যাকাতের পরিমাণ:</div>
                <div id="zakatResult" style="font-size: 1.6rem; font-weight: 900; color: #fef08a;">০ টাকা</div>
            </div>
        </div>
    </div>
</div>

<!-- Al-Quran Full Feature Interactive Modal Popup (Quran.com Exact UI) -->
<div id="alQuranModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #12181f; z-index: 999999; align-items: stretch; justify-content: stretch; padding: 0; margin: 0; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: #12181f; width: 100vw; height: 100vh; display: flex; flex-direction: column; color: #e2e8f0; font-family: 'Hind Siliguri', sans-serif; overflow: hidden;">
        
        <!-- Top Control Bar (Quran.com Style) -->
        <div style="height: 52px; background: #1a232e; border-bottom: 1px solid #2a3644; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; flex-shrink: 0; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="font-weight: 800; font-size: 1.1rem; color: #ffffff; display: flex; align-items: center; gap: 8px;" id="quranModalTitle">
                    <i class="fas fa-quran" style="color: #10b981;"></i> <span>১. Al-Fatihah</span>
                </div>
                <div style="font-size: 0.8rem; color: #94a3b8; border-left: 1px solid #2a3644; padding-left: 14px;" id="quranModalSub">
                    মাক্কী • ৭টি আয়াত
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">ক্বারী:</span>
                    <select id="quranReciterSelect" onchange="onReciterChange()" style="background: #202b38; border: 1px solid #334155; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.82rem; font-weight: 700; padding: 5px 10px; border-radius: 8px; outline: none; cursor: pointer;">
                        <option value="ar.alafasy">মিশারী রশীদ আল-আফাসী</option>
                        <option value="ar.abdulbasitmurattal">আব্দুল বাসিত আব্দুস সামাদ</option>
                        <option value="ar.sudais">আব্দুর রহমান আস-সুদাইস</option>
                        <option value="ar.shatri">আবু বকর আশ-শাত্রী</option>
                    </select>
                </div>
                <button type="button" data-close-modal="alQuranModal" onclick="closeQuranModal(); return false;" style="background: #2a3644; border: none; color: #94a3b8; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff';" onmouseout="this.style.background='#2a3644'; this.style.color='#94a3b8';"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <!-- Main Workspace (Left Sidebar + Right Content Reader) -->
        <div style="display: flex; flex: 1; overflow: hidden; position: relative;">
            
            <!-- Left Sidebar: Surah Navigation List -->
            <div style="width: 290px; background: #18222d; border-right: 1px solid #2a3644; display: flex; flex-direction: column; flex-shrink: 0;" id="quranSidebar">
                <!-- Search Box -->
                <div style="padding: 12px 14px; border-bottom: 1px solid #2a3644; background: #141c25;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.85rem;"></i>
                        <input type="text" id="quranSearchInput" oninput="filterSurahList()" placeholder="সূরা অনুসন্ধান করুন..." style="width: 100%; padding: 8px 12px 8px 34px; background: #202b38; border: 1px solid #334155; border-radius: 8px; color: #ffffff; outline: none; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Surah Vertical Menu List -->
                <div style="flex: 1; overflow-y: auto; padding: 8px 10px;" id="quranSidebarSurahList">
                </div>
            </div>

        <!-- Scrollable Main Content Body -->
        <div style="padding: 22px; overflow-y: auto; flex: 1; height: 100%; box-sizing: border-box;" id="quranModalBody">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 14px;">
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #a7f3d0;" id="quranSurahGrid">
    <i class="fas fa-spinner fa-spin fa-2x" style="margin-bottom: 12px; display: block;"></i>
    <span>সূরাসমূহ লোড করা হচ্ছে...</span>
</div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Hadith Shareef Full Collection Modal Popup (iHadis Style) -->
<div id="dailyHadithModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10, 15, 20, 0.94); backdrop-filter: blur(16px); z-index: 999999; align-items: center; justify-content: center; padding: 15px; box-sizing: border-box; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.12); width: 100%; max-width: 1200px; height: 90vh; min-height: 620px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.9); overflow: hidden; display: flex; flex-direction: column; color: #ffffff; font-family: 'Hind Siliguri', sans-serif;">
        
        <!-- Hadith Top Header -->
        <div style="padding: 14px 24px; background: #1f2937; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #10b981; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.15rem; font-weight: 900;">
                    <i class="fas fa-book-quran"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #ffffff;" id="hadithModalTitle">আল হাদিস (iHadis Style)</h3>
                    <p style="margin: 1px 0 0 0; font-size: 0.78rem; color: #9ca3af;" id="hadithModalSub">সকল প্রধান হাদিস গ্রন্থ ও অধ্যায়সমূহ</p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px;">
                <button onclick="fetchRandomHadith()" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer;"><i class="fas fa-shuffle" style="margin-right: 4px;"></i> র্যান্ডম হাদিস</button>
                <button type="button" data-close-modal="dailyHadithModal" onclick="closeHadithModal(); return false;" style="background: rgba(255, 255, 255, 0.1); border: none; color: #ffffff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.8)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <!-- Main Body Layout Split (Left Sidebar + Right Hadith Reader) -->
        <div style="display: flex; flex: 1; height: calc(100% - 66px); overflow: hidden;">
            
            <!-- Left Sidebar: Hadith Books List -->
            <div style="width: 310px; background: #171e2e; border-right: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; flex-shrink: 0;">
                
                <!-- Search Book Input -->
                <div style="padding: 14px; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem;"></i>
                        <input type="text" id="hadithBookSearch" oninput="filterHadithBooks()" placeholder="হাদিস গ্রন্থসমূহ সার্চ করুন..." style="width: 100%; padding: 8px 12px 8px 34px; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 10px; color: #fff; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Scrollable Book List Items -->
                <div style="flex: 1; overflow-y: auto; padding: 10px;" id="hadithSidebarBookList">
                    <!-- Book Items via JS -->
                </div>
            </div>

            <!-- Right Main Area: Hadith Chapter Header & Hadith Cards -->
            <div style="flex: 1; background: #0b0f17; display: flex; flex-direction: column; overflow: hidden;">
                
                <!-- Top Hadith Reader Control Bar -->
                <div style="padding: 12px 20px; background: #131b2e; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;" id="hadithTopBar">
                    <div style="display: flex; align-items: center; gap: 8px; color: #a7f3d0; font-size: 0.85rem; font-weight: 700;" id="hadithBreadcrumb">
                        <i class="fas fa-house" style="color: #10b981;"></i> <span>হোম</span> <i class="fas fa-chevron-right" style="font-size: 0.7rem; color: #6b7280;"></i> <span id="hadithCurrentBookName">সহীহ বুখারী</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input type="number" id="hadithNumberInput" placeholder="হাদিস নম্বর" min="1" style="width: 100px; padding: 6px 10px; background: #1e293b; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #fff; font-size: 0.82rem; text-align: center; outline: none; font-family: 'Hind Siliguri', sans-serif;">
                        <button onclick="fetchHadithByNumber()" style="background: #10b981; border: none; color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer;">খুঁজুন</button>
                    </div>
                </div>

                <!-- Hadith Content Scroll Area -->
                <div style="flex: 1; overflow-y: auto; padding: 24px;" id="hadithContentCard">
                    <!-- Hadith Text Cards via JS -->
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ==========================================
    // QURAN.COM STYLE INTERACTIVE SCRIPT & API
    // ==========================================
    var defaultSurahListFallback = [
        {number:1, name:"سُورَةُ الفَاتِحَةِ", englishName:"Al-Faatiha", englishNameTranslation:"The Opening", numberOfAyahs:7, revelationType:"Meccan"},
        {number:2, name:"سُورَةُ البَقَرَةِ", englishName:"Al-Baqara", englishNameTranslation:"The Cow", numberOfAyahs:286, revelationType:"Medinan"},
        {number:3, name:"سُورَةُ آلِ عِمْرَانَ", englishName:"Aal-i-Imraan", englishNameTranslation:"The Family of Imraan", numberOfAyahs:200, revelationType:"Medinan"},
        {number:4, name:"سُورَةُ النِّسَاءِ", englishName:"An-Nisaa", englishNameTranslation:"The Women", numberOfAyahs:176, revelationType:"Medinan"},
        {number:5, name:"سُورَةُ المَائِدَةِ", englishName:"Al-Maaida", englishNameTranslation:"The Table", numberOfAyahs:120, revelationType:"Medinan"},
        {number:6, name:"سُورَةُ الأَنعَامِ", englishName:"Al-An'aam", englishNameTranslation:"The Cattle", numberOfAyahs:165, revelationType:"Meccan"},
        {number:7, name:"سُورَةُ الأَعرَافِ", englishName:"Al-A'raaf", englishNameTranslation:"The Heights", numberOfAyahs:206, revelationType:"Meccan"},
        {number:8, name:"سُورَةُ الأَنفَالِ", englishName:"Al-Anfaal", englishNameTranslation:"The Spoils of War", numberOfAyahs:75, revelationType:"Medinan"},
        {number:9, name:"سُورَةُ التَّوبَةِ", englishName:"At-Tawba", englishNameTranslation:"The Repentance", numberOfAyahs:129, revelationType:"Medinan"},
        {number:10, name:"سُورَةُ يُونُسَ", englishName:"Yunus", englishNameTranslation:"Jonas", numberOfAyahs:109, revelationType:"Meccan"},
        {number:11, name:"سُورَةُ هُودٍ", englishName:"Hud", englishNameTranslation:"Hud", numberOfAyahs:123, revelationType:"Meccan"},
        {number:12, name:"سُورَةُ يُوسُفَ", englishName:"Yusuf", englishNameTranslation:"Joseph", numberOfAyahs:111, revelationType:"Meccan"},
        {number:13, name:"سُورَةُ الرَّعدِ", englishName:"Ar-Ra'd", englishNameTranslation:"The Thunder", numberOfAyahs:43, revelationType:"Medinan"},
        {number:14, name:"سُورَةُ إِبرَاهِيمَ", englishName:"Ibrahim", englishNameTranslation:"Abraham", numberOfAyahs:52, revelationType:"Meccan"},
        {number:15, name:"سُورَةُ الحِجرِ", englishName:"Al-Hijr", englishNameTranslation:"The Rock", numberOfAyahs:99, revelationType:"Meccan"},
        {number:16, name:"سُورَةُ النَّحلِ", englishName:"An-Nahl", englishNameTranslation:"The Bee", numberOfAyahs:128, revelationType:"Meccan"},
        {number:17, name:"سُورَةُ الإِسرَاءِ", englishName:"Al-Israa", englishNameTranslation:"The Night Journey", numberOfAyahs:111, revelationType:"Meccan"},
        {number:18, name:"سُورَةُ الكَهفِ", englishName:"Al-Kahf", englishNameTranslation:"The Cave", numberOfAyahs:110, revelationType:"Meccan"},
        {number:19, name:"سُورَةُ مَريَمَ", englishName:"Maryam", englishNameTranslation:"Mary", numberOfAyahs:98, revelationType:"Meccan"},
        {number:20, name:"سُورَةُ طٰهٰ", englishName:"Taa-Haa", englishNameTranslation:"Taa-Haa", numberOfAyahs:135, revelationType:"Meccan"},
        {number:21, name:"سُورَةُ الأَنبِيَاءِ", englishName:"Al-Anbiyaa", englishNameTranslation:"The Prophets", numberOfAyahs:112, revelationType:"Meccan"},
        {number:22, name:"سُورَةُ الحَجِّ", englishName:"Al-Hajj", englishNameTranslation:"The Pilgrimage", numberOfAyahs:78, revelationType:"Medinan"},
        {number:23, name:"سُورَةُ المُؤمِنُونَ", englishName:"Al-Mu'minoon", englishNameTranslation:"The Believers", numberOfAyahs:118, revelationType:"Meccan"},
        {number:24, name:"سُورَةُ النُّورِ", englishName:"An-Noor", englishNameTranslation:"The Light", numberOfAyahs:64, revelationType:"Medinan"},
        {number:25, name:"سُورَةُ الفُرقَانِ", englishName:"Al-Furqaan", englishNameTranslation:"The Criterion", numberOfAyahs:77, revelationType:"Meccan"},
        {number:26, name:"سُورَةُ الشُّعَرَاءِ", englishName:"Ash-Shu'araa", englishNameTranslation:"The Poets", numberOfAyahs:227, revelationType:"Meccan"},
        {number:27, name:"سُورَةُ النَّملِ", englishName:"An-Naml", englishNameTranslation:"The Ant", numberOfAyahs:93, revelationType:"Meccan"},
        {number:28, name:"سُورَةُ القَصَصِ", englishName:"Al-Qasas", englishNameTranslation:"The Stories", numberOfAyahs:88, revelationType:"Meccan"},
        {number:29, name:"سُورَةُ العَنكَبُوتِ", englishName:"Al-Ankaboot", englishNameTranslation:"The Spider", numberOfAyahs:69, revelationType:"Meccan"},
        {number:30, name:"سُورَةُ الرُّومِ", englishName:"Ar-Room", englishNameTranslation:"The Romans", numberOfAyahs:60, revelationType:"Meccan"},
        {number:31, name:"سُورَةُ لُقمَانَ", englishName:"Luqman", englishNameTranslation:"Luqman", numberOfAyahs:34, revelationType:"Meccan"},
        {number:32, name:"سُورَةُ السَّجدَةِ", englishName:"As-Sajda", englishNameTranslation:"The Prostration", numberOfAyahs:30, revelationType:"Meccan"},
        {number:33, name:"سُورَةُ الأَحزَابِ", englishName:"Al-Ahzaab", englishNameTranslation:"The Clans", numberOfAyahs:73, revelationType:"Medinan"},
        {number:34, name:"سُورَةُ سَبَإٍ", englishName:"Saba", englishNameTranslation:"Sheba", numberOfAyahs:54, revelationType:"Meccan"},
        {number:35, name:"سُورَةُ فَاطِرٍ", englishName:"Faatir", englishNameTranslation:"The Originator", numberOfAyahs:45, revelationType:"Meccan"},
        {number:36, name:"سُورَةُ يٰسۤ", englishName:"Yaseen", englishNameTranslation:"Yaseen", numberOfAyahs:83, revelationType:"Meccan"},
        {number:37, name:"سُورَةُ الصَّافَّاتِ", englishName:"As-Saaffaat", englishNameTranslation:"Those drawn up in Ranks", numberOfAyahs:182, revelationType:"Meccan"},
        {number:38, name:"سُورَةُ صۤ", englishName:"Saad", englishNameTranslation:"Saad", numberOfAyahs:88, revelationType:"Meccan"},
        {number:39, name:"سُورَةُ الزُّمَرِ", englishName:"Az-Zumar", englishNameTranslation:"The Groups", numberOfAyahs:75, revelationType:"Meccan"},
        {number:40, name:"سُورَةُ غَافِرٍ", englishName:"Ghafir", englishNameTranslation:"The Forgiver", numberOfAyahs:85, revelationType:"Meccan"},
        {number:41, name:"سُورَةُ فُصِّلَتِ", englishName:"Fussilat", englishNameTranslation:"Explained in Detail", numberOfAyahs:54, revelationType:"Meccan"},
        {number:42, name:"سُورَةُ الشُّورَىٰ", englishName:"Ash-Shura", englishNameTranslation:"Consultation", numberOfAyahs:53, revelationType:"Meccan"},
        {number:43, name:"سُورَةُ الزُّخرُفِ", englishName:"Az-Zukhruf", englishNameTranslation:"Ornaments of Gold", numberOfAyahs:89, revelationType:"Meccan"},
        {number:44, name:"سُورَةُ الدُّخَانِ", englishName:"Ad-Dukhaan", englishNameTranslation:"The Smoke", numberOfAyahs:59, revelationType:"Meccan"},
        {number:45, name:"سُورَةُ الجَاثِيَةِ", englishName:"Al-Jaathiya", englishNameTranslation:"Crouching", numberOfAyahs:37, revelationType:"Meccan"},
        {number:46, name:"سُورَةُ الأَحقَافِ", englishName:"Al-Ahqaaf", englishNameTranslation:"The Dunes", numberOfAyahs:35, revelationType:"Meccan"},
        {number:47, name:"سُورَةُ مُحَمَّدٍ", englishName:"Muhammad", englishNameTranslation:"Muhammad", numberOfAyahs:38, revelationType:"Medinan"},
        {number:48, name:"سُورَةُ الفَتحِ", englishName:"Al-Fath", englishNameTranslation:"The Victory", numberOfAyahs:29, revelationType:"Medinan"},
        {number:49, name:"سُورَةُ الحُجُرَاتِ", englishName:"Al-Hujuraat", englishNameTranslation:"The Inner Apartments", numberOfAyahs:18, revelationType:"Medinan"},
        {number:50, name:"سُورَةُ قۤ", englishName:"Qaaf", englishNameTranslation:"Qaaf", numberOfAyahs:45, revelationType:"Meccan"},
        {number:51, name:"سُورَةُ الذَّارِيَاتِ", englishName:"Adh-Dhaariyat", englishNameTranslation:"The Winnowing Winds", numberOfAyahs:60, revelationType:"Meccan"},
        {number:52, name:"سُورَةُ الطُّورِ", englishName:"At-Toor", englishNameTranslation:"The Mount", numberOfAyahs:49, revelationType:"Meccan"},
        {number:53, name:"سُورَةُ النَّجمِ", englishName:"An-Najm", englishNameTranslation:"The Star", numberOfAyahs:62, revelationType:"Meccan"},
        {number:54, name:"سُورَةُ القَمَرِ", englishName:"Al-Qamar", englishNameTranslation:"The Moon", numberOfAyahs:55, revelationType:"Meccan"},
        {number:55, name:"سُورَةُ الرَّحمَٰنِ", englishName:"Ar-Rahmaan", englishNameTranslation:"The Beneficent", numberOfAyahs:78, revelationType:"Medinan"},
        {number:56, name:"سُورَةُ الوَاقِعَةِ", englishName:"Al-Waaqia", englishNameTranslation:"The Inevitable", numberOfAyahs:96, revelationType:"Meccan"},
        {number:57, name:"سُورَةُ الحَدِيدِ", englishName:"Al-Hadid", englishNameTranslation:"The Iron", numberOfAyahs:29, revelationType:"Medinan"},
        {number:58, name:"سُورَةُ المُجَادَلَةِ", englishName:"Al-Mujaadila", englishNameTranslation:"The Pleading Woman", numberOfAyahs:22, revelationType:"Medinan"},
        {number:59, name:"سُورَةُ الحَشرِ", englishName:"Al-Hashr", englishNameTranslation:"The Exile", numberOfAyahs:24, revelationType:"Medinan"},
        {number:60, name:"سُورَةُ المُمتَحَنَةِ", englishName:"Al-Mumtahana", englishNameTranslation:"She that is to be examined", numberOfAyahs:13, revelationType:"Medinan"},
        {number:61, name:"سُورَةُ الصَّفِّ", englishName:"As-Saff", englishNameTranslation:"The Ranks", numberOfAyahs:14, revelationType:"Medinan"},
        {number:62, name:"سُورَةُ الجُمُعَةِ", englishName:"Al-Jumu'a", englishNameTranslation:"Friday", numberOfAyahs:11, revelationType:"Medinan"},
        {number:63, name:"سُورَةُ المُنَافِقُونَ", englishName:"Al-Munaafiquon", englishNameTranslation:"The Hypocrites", numberOfAyahs:11, revelationType:"Medinan"},
        {number:64, name:"سُورَةُ التَّغَابُنِ", englishName:"At-Taghaabun", englishNameTranslation:"Mutual Disillusion", numberOfAyahs:18, revelationType:"Medinan"},
        {number:65, name:"سُورَةُ الطَّلاَقِ", englishName:"At-Talaaq", englishNameTranslation:"Divorce", numberOfAyahs:12, revelationType:"Medinan"},
        {number:66, name:"سُورَةُ التَّحرِيمِ", englishName:"At-Tahrim", englishNameTranslation:"The Prohibition", numberOfAyahs:12, revelationType:"Medinan"},
        {number:67, name:"سُورَةُ المُلكِ", englishName:"Al-Mulk", englishNameTranslation:"The Sovereignty", numberOfAyahs:30, revelationType:"Meccan"},
        {number:68, name:"سُورَةُ القَلَمِ", englishName:"Al-Qalam", englishNameTranslation:"The Pen", numberOfAyahs:52, revelationType:"Meccan"},
        {number:69, name:"سُورَةُ الحَاقَّةِ", englishName:"Al-Haaqqa", englishNameTranslation:"The Inevitable", numberOfAyahs:52, revelationType:"Meccan"},
        {number:70, name:"سُورَةُ المَعَارِجِ", englishName:"Al-Ma'aarij", englishNameTranslation:"The Ascending Stairways", numberOfAyahs:44, revelationType:"Meccan"},
        {number:71, name:"سُورَةُ نُوحٍ", englishName:"Nooh", englishNameTranslation:"Noah", numberOfAyahs:28, revelationType:"Meccan"},
        {number:72, name:"سُورَةُ الجِنِّ", englishName:"Al-Jinn", englishNameTranslation:"The Jinn", numberOfAyahs:28, revelationType:"Meccan"},
        {number:73, name:"سُورَةُ المُزَّمِّلِ", englishName:"Al-Muzzammil", englishNameTranslation:"The Enshrouded One", numberOfAyahs:20, revelationType:"Meccan"},
        {number:74, name:"سُورَةُ المُدَّثِّرِ", englishName:"Al-Muddaththir", englishNameTranslation:"The Cloaked One", numberOfAyahs:56, revelationType:"Meccan"},
        {number:75, name:"سُورَةُ القِيَامَةِ", englishName:"Al-Qiyaama", englishNameTranslation:"The Resurrection", numberOfAyahs:40, revelationType:"Meccan"},
        {number:76, name:"سُورَةُ الإِنسَانِ", englishName:"Al-Insaan", englishNameTranslation:"Man", numberOfAyahs:31, revelationType:"Medinan"},
        {number:77, name:"سُورَةُ المُرْسَلاَتِ", englishName:"Al-Mursalaat", englishNameTranslation:"The Emissaries", numberOfAyahs:50, revelationType:"Meccan"},
        {number:78, name:"سُورَةُ النَّبَإِ", englishName:"An-Naba", englishNameTranslation:"The Announcement", numberOfAyahs:40, revelationType:"Meccan"},
        {number:79, name:"سُورَةُ النَّازِعَاتِ", englishName:"An-Naazi'aat", englishNameTranslation:"Those who drag forth", numberOfAyahs:46, revelationType:"Meccan"},
        {number:80, name:"سُورَةُ عَبَسَ", englishName:"Abasa", englishNameTranslation:"He frowned", numberOfAyahs:42, revelationType:"Meccan"},
        {number:81, name:"سُورَةُ التَّكوِيرِ", englishName:"At-Takweer", englishNameTranslation:"The Overthrowing", numberOfAyahs:29, revelationType:"Meccan"},
        {number:82, name:"سُورَةُ الإِنفِطَارِ", englishName:"Al-Infitaar", englishNameTranslation:"The Cleaving", numberOfAyahs:19, revelationType:"Meccan"},
        {number:83, name:"سُورَةُ المُطَفِّفِينَ", englishName:"Al-Mutaffifeen", englishNameTranslation:"Defrauding", numberOfAyahs:36, revelationType:"Meccan"},
        {number:84, name:"سُورَةُ الإِنشِقَاقِ", englishName:"Al-InshiQaaq", englishNameTranslation:"The Splitting Open", numberOfAyahs:25, revelationType:"Meccan"},
        {number:85, name:"سُورَةُ البُرُوجِ", englishName:"Al-Burooj", englishNameTranslation:"The Constellations", numberOfAyahs:22, revelationType:"Meccan"},
        {number:86, name:"سُورَةُ الطَّارِقِ", englishName:"At-Taariq", englishNameTranslation:"The Morning Star", numberOfAyahs:17, revelationType:"Meccan"},
        {number:87, name:"سُورَةُ الأَعلَىٰ", englishName:"Al-A'laa", englishNameTranslation:"The Most High", numberOfAyahs:19, revelationType:"Meccan"},
        {number:88, name:"سُورَةُ الغَاشِيَةِ", englishName:"Al-Ghaashiya", englishNameTranslation:"The Overwhelming", numberOfAyahs:26, revelationType:"Meccan"},
        {number:89, name:"سُورَةُ الفَجرِ", englishName:"Al-Fajr", englishNameTranslation:"The Dawn", numberOfAyahs:30, revelationType:"Meccan"},
        {number:90, name:"سُورَةُ البَلَدِ", englishName:"Al-Balad", englishNameTranslation:"The City", numberOfAyahs:20, revelationType:"Meccan"},
        {number:91, name:"سُورَةُ الشَّمسِ", englishName:"Ash-Shams", englishNameTranslation:"The Sun", numberOfAyahs:15, revelationType:"Meccan"},
        {number:92, name:"سُورَةُ اللَّيلِ", englishName:"Al-Lail", englishNameTranslation:"The Night", numberOfAyahs:21, revelationType:"Meccan"},
        {number:93, name:"سُورَةُ الضُّحَىٰ", englishName:"Ad-Dhuhaa", englishNameTranslation:"The Morning Hours", numberOfAyahs:11, revelationType:"Meccan"},
        {number:94, name:"سُورَةُ الشَّرحِ", englishName:"Ash-Sharh", englishNameTranslation:"The Consolation", numberOfAyahs:8, revelationType:"Meccan"},
        {number:95, name:"سُورَةُ التِّينِ", englishName:"At-Tin", englishNameTranslation:"The Fig", numberOfAyahs:8, revelationType:"Meccan"},
        {number:96, name:"سُورَةُ العَلَقِ", englishName:"Al-Alaq", englishNameTranslation:"The Clot", numberOfAyahs:19, revelationType:"Meccan"},
        {number:97, name:"سُورَةُ القَدرِ", englishName:"Al-Qadr", englishNameTranslation:"The Power, Fate", numberOfAyahs:5, revelationType:"Meccan"},
        {number:98, name:"سُورَةُ البَيِّنَةِ", englishName:"Al-Bayyina", englishNameTranslation:"The Evidence", numberOfAyahs:8, revelationType:"Medinan"},
        {number:99, name:"سُورَةُ الزَّلزَلَةِ", englishName:"Az-Zalzala", englishNameTranslation:"The Earthquake", numberOfAyahs:8, revelationType:"Medinan"},
        {number:100, name:"سُورَةُ العَادِيَاتِ", englishName:"Al-Aadiyaat", englishNameTranslation:"The Chargers", numberOfAyahs:11, revelationType:"Meccan"},
        {number:101, name:"سُورَةُ القَارِعَةِ", englishName:"Al-Qaari'a", englishNameTranslation:"The Calamity", numberOfAyahs:11, revelationType:"Meccan"},
        {number:102, name:"سُورَةُ التَّكَاثُرِ", englishName:"At-Takaathur", englishNameTranslation:"Competition", numberOfAyahs:8, revelationType:"Meccan"},
        {number:103, name:"سُورَةُ العَصرِ", englishName:"Al-Asr", englishNameTranslation:"The Declining Day, Epoch", numberOfAyahs:3, revelationType:"Meccan"},
        {number:104, name:"سُورَةُ الهُمَزَةِ", englishName:"Al-Humaza", englishNameTranslation:"The Traducer", numberOfAyahs:9, revelationType:"Meccan"},
        {number:105, name:"سُورَةُ الفِيلِ", englishName:"Al-Feel", englishNameTranslation:"The Elephant", numberOfAyahs:5, revelationType:"Meccan"},
        {number:106, name:"سُورَةُ قُرَيشٍ", englishName:"Quraish", englishNameTranslation:"Quraysh", numberOfAyahs:4, revelationType:"Meccan"},
        {number:107, name:"سُورَةُ المَاعُونِ", englishName:"Al-Maa'un", englishNameTranslation:"Almsgiving", numberOfAyahs:7, revelationType:"Meccan"},
        {number:108, name:"سُورَةُ الكَوثَرِ", englishName:"Al-Kawthar", englishNameTranslation:"Abundance", numberOfAyahs:3, revelationType:"Meccan"},
        {number:109, name:"سُورَةُ الكَافِرُونَ", englishName:"Al-Kaafiroon", englishNameTranslation:"The Disbelievers", numberOfAyahs:6, revelationType:"Meccan"},
        {number:110, name:"سُورَةُ النَّصرِ", englishName:"An-Nasr", englishNameTranslation:"Divine Support", numberOfAyahs:3, revelationType:"Medinan"},
        {number:111, name:"سُورَةُ المَسَدِ", englishName:"Al-Masad", englishNameTranslation:"The Palm Fibre", numberOfAyahs:5, revelationType:"Meccan"},
        {number:112, name:"سُورَةُ الإِخلاَصِ", englishName:"Al-Ikhlaas", englishNameTranslation:"Sincerity", numberOfAyahs:4, revelationType:"Meccan"},
        {number:113, name:"سُورَةُ الفَلَقِ", englishName:"Al-Falaq", englishNameTranslation:"The Daybreak", numberOfAyahs:5, revelationType:"Meccan"},
        {number:114, name:"سُورَةُ النَّاسِ", englishName:"An-Naas", englishNameTranslation:"Mankind", numberOfAyahs:6, revelationType:"Meccan"}
    ];

    var cachedSurahs = defaultSurahListFallback;
    var currentSurahNum = 1;
    var currentPlayingAudio = null;

    function openQuranModal() {
        window.safeOpenModal("alQuranModal");
        fetchSurahList();
    }
    window.openQuranModal = openQuranModal;

    function closeQuranModal() {
        window.safeCloseModal("alQuranModal");
        if (currentPlayingAudio) {
            currentPlayingAudio.pause();
            currentPlayingAudio = null;
        }
    }
    window.closeQuranModal = closeQuranModal;

    function fetchSurahList() {
        const body = document.getElementById("quranModalBody");
        if (!body) return;

        // Render fallback dataset immediately so user is wowed without delay!
        if (typeof defaultSurahListFallback !== "undefined" && defaultSurahListFallback.length > 0) {
            cachedSurahs = defaultSurahListFallback;
            renderSurahGrid(cachedSurahs);
        }

        // Fetch fresh metadata from API in background if online
        fetch("https://api.alquran.cloud/v1/surah")
            .then(res => res.json())
            .then(data => {
                if (data && data.data) {
                    cachedSurahs = data.data;
                    renderSurahGrid(cachedSurahs);
                }
            })
            .catch(err => { console.log("API offline, using built-in Surah dataset."); });
    }

    // Pre-initialize Surah list grid on DOM load so modal is ready instantly
    document.addEventListener("DOMContentLoaded", function() {
        fetchSurahList();
    });

    function renderSurahGrid(surahs) {
        const sidebar = document.getElementById("quranSidebarSurahList");
        if (!sidebar) return;

        if (!surahs || surahs.length === 0) {
            sidebar.innerHTML = '<div style="text-align:center; padding: 20px; color:#fde047; font-size:0.85rem;">কোন সূরা পাওয়া যায়নি</div>';
            return;
        }

        sidebar.innerHTML = surahs.map(s => {
            const isActive = (s.number === currentSurahNum);
            return `
                <div onclick="loadSurahDetail(${s.number})" id="surah-item-${s.number}" class="quran-surah-item ${isActive ? 'active' : ''}" style="padding: 10px 12px; border-radius: 8px; margin-bottom: 4px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; background: ${isActive ? 'rgba(16, 185, 129, 0.15)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.05)'" onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div style="display: flex; align-items: center; gap: 10px; overflow: hidden;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: ${isActive ? '#34d399' : '#64748b'}; width: 22px; text-align: center; font-family: 'Outfit', sans-serif; flex-shrink: 0;">${s.number}</span>
                        <span style="font-weight: 700; font-size: 0.9rem; color: ${isActive ? '#ffffff' : '#cbd5e1'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${s.englishName}</span>
                    </div>
                    <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 500; flex-shrink: 0; margin-left: 6px;">${s.englishNameTranslation}</span>
                </div>
            `;
        }).join('');
    }

    window.fetchSurahList = fetchSurahList;
    window.renderSurahGrid = renderSurahGrid;

    function showSurahGrid() {
        renderSurahGrid(cachedSurahs);
    }
    window.showSurahGrid = showSurahGrid;

    function filterSurahList() {
        const query = (document.getElementById("quranSearchInput").value || "").toLowerCase().trim();
        if (!query) {
            renderSurahGrid(cachedSurahs);
            return;
        }

        const filtered = cachedSurahs.filter(s => 
            s.number.toString() === query ||
            s.name.toLowerCase().includes(query) ||
            s.englishName.toLowerCase().includes(query) ||
            s.englishNameTranslation.toLowerCase().includes(query)
        );
        renderSurahGrid(filtered);
    }
    window.filterSurahList = filterSurahList;

    function onReciterChange() {
        if (currentSurahNum) {
            loadSurahDetail(currentSurahNum);
        }
    }

    function playAyahAudio(audioUrl, btn) {
        if (currentPlayingAudio) {
            currentPlayingAudio.pause();
            currentPlayingAudio = null;
        }

        const audio = new Audio(audioUrl);
        currentPlayingAudio = audio;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> অডিও...';
        
        audio.play().then(() => {
            btn.innerHTML = '<i class="fas fa-pause"></i> থামান';
        }).catch(err => {
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> সমস্যা';
        });

        audio.onended = function() {
            btn.innerHTML = '<i class="fas fa-play"></i> শুনুন';
            currentPlayingAudio = null;
        };
    }

    function loadSurahDetail(surahNum) {
        currentSurahNum = surahNum;

        // Highlight active item in sidebar
        document.querySelectorAll('.quran-surah-item').forEach(el => {
            el.classList.remove('active');
            el.style.background = 'transparent';
            el.style.borderColor = 'transparent';
        });
        const activeItem = document.getElementById(`surah-item-${surahNum}`);
        if (activeItem) {
            activeItem.classList.add('active');
            activeItem.style.background = 'rgba(16, 185, 129, 0.15)';
            activeItem.style.borderColor = '#10b981';
        }

        const body = document.getElementById("quranModalBody");
        const title = document.getElementById("quranModalTitle");
        const sub = document.getElementById("quranModalSub");
        const reciterSelect = document.getElementById("quranReciterSelect");

        const selectedReciter = reciterSelect ? reciterSelect.value : "ar.alafasy";

        if (body) {
            body.innerHTML = `
                <div style="text-align: center; padding: 70px 0; color: #a7f3d0;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #34d399;"></i>
                    <div style="font-size: 1.1rem; font-weight: 700;">সূরা ${toBnNum(surahNum)}-এর আয়াতসমূহ লোড হচ্ছে...</div>
                    <div style="font-size: 0.85rem; color: #6ee7b7; margin-top: 6px;">আরবি পাঠ, বাংলা অনুবাদ ও অডিও তেলাওয়াত প্রস্তুত হচ্ছে</div>
                </div>
            `;
        }

        Promise.all([
            fetch(`https://api.alquran.cloud/v1/surah/${surahNum}/editions/quran-uthmani,bn.bengali,${selectedReciter}`).then(r => r.json())
        ])
            .then(([res]) => {
                if (res && res.data && res.data.length >= 2) {
                    const uthmani = res.data[0];
                    const bengali = res.data[1];
                    const audioRec = res.data[2] || null;

                    if (title) title.innerHTML = `<i class="fas fa-quran" style="color: #10b981;"></i> <span>${toBnNum(uthmani.number)}. ${uthmani.englishNameTranslation} (${uthmani.englishName})</span>`;
                    if (sub) sub.innerText = `${uthmani.revelationType === 'Meccan' ? 'মাক্কী' : 'মাদানী'} • ${toBnNum(uthmani.numberOfAyahs)}টি আয়াত`;

                    let surahHeaderHtml = `
                        <div style="background: #1a232e; border: 1px solid #2a3644; border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 30px; position: relative; width: 100%; max-width: 820px;">
                            <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 2.8rem; color: #10b981; margin-bottom: 8px;">${uthmani.name}</div>
                            <div style="font-size: 1.3rem; font-weight: 800; color: #ffffff;">${toBnNum(surahNum)}. সূরা ${uthmani.englishName} (${uthmani.englishNameTranslation})</div>
                            <div style="font-size: 0.88rem; color: #94a3b8; margin-top: 6px;">সূচী পাঠ ও শুনুন ${uthmani.englishName} অনুবাদ, তাফসীর, অডিও আবৃত্তি, শব্দে শব্দে অর্থ এবং প্রতিফলন সহ।</div>
                        </div>
                    `;

                    let bismillahHtml = "";
                    if (surahNum !== 9 && surahNum !== 1) {
                        bismillahHtml = `
                            <div style="text-align: center; padding: 20px; margin-bottom: 30px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid #2a3644; font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 2.2rem; color: #fef08a; width: 100%; max-width: 820px;">
                                بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                            </div>
                        `;
                    }

                    const ayahsHtml = uthmani.ayahs.map((a, idx) => {
                        const bnAyah = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text : "";
                        const audioUrl = (audioRec && audioRec.ayahs[idx]) ? audioRec.ayahs[idx].audio : "";

                        return `
                            <div style="background: #18222d; border: 1px solid #2a3644; border-radius: 14px; padding: 22px; width: 100%; max-width: 820px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#34d399'" onmouseout="this.style.borderColor='#2a3644'">
                                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #2a3644; padding-bottom: 10px; margin-bottom: 16px;">
                                    <span style="font-size: 0.85rem; font-weight: 800; color: #10b981; font-family: 'Outfit', sans-serif;">
                                        ${toBnNum(surahNum)}:${toBnNum(a.numberInSurah)}
                                    </span>

                                    ${audioUrl ? `
                                        <button onclick="playAyahAudio('${audioUrl}', this)" style="background: rgba(52, 211, 153, 0.15); border: 1px solid #34d399; color: #6ee7b7; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='rgba(52, 211, 153, 0.3)'" onmouseout="this.style.background='rgba(52, 211, 153, 0.15)'">
                                            <i class="fas fa-play"></i> অডিও
                                        </button>
                                    ` : ""}
                                </div>

                                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.45rem; color: #ffffff; direction: rtl; text-align: right; line-height: 2.2; margin-bottom: 14px; text-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                                    ${a.text} ۝${toBnNum(a.numberInSurah)}
                                </div>

                                <div style="font-size: 1.05rem; color: #cbd5e1; line-height: 1.7; text-align: left; font-weight: 500;">
                                    ${bnAyah}
                                </div>
                            </div>
                        `;
                    }).join('');

                    if (body) {
                        body.innerHTML = `<div style="width: 100%; max-width: 820px; display: flex; flex-direction: column; align-items: center; gap: 20px;">` + surahHeaderHtml + bismillahHtml + ayahsHtml + `</div>`;
                    }
                } else {
                    if (body) body.innerHTML = '<div style="text-align:center; padding: 50px; color:#f87171;">সূরার আয়াত লোড হয়নি।</div>';
                }
            })
            .catch(err => {
                if (body) body.innerHTML = '<div style="text-align:center; padding: 50px; color:#f87171;">সূরা লোড করতে ত্রুটি ঘটেছে।</div>';
            });
    }
    window.loadSurahDetail = loadSurahDetail;

    // HADITH COLLECTION API SCRIPT (9 BOOKS) - IHADIS STYLE
    // ==========================================================
    const hadithBookList = [
        { id: "bukhari", name: "সহীহ বুখারী", en: "Sahih al-Bukhari", count: "৭৫৬৩", code: "B", color: "#3b82f6" },
        { id: "muslim", name: "সহীহ মুসলিম", en: "Sahih Muslim", count: "৭৫০০", code: "M", color: "#10b981" },
        { id: "nasai", name: "সুনানে আন-নাসায়ী", en: "Sunan an-Nasa'i", count: "৫৭৫৮", code: "N", color: "#f59e0b" },
        { id: "abudawud", name: "সুনানে আবু দাউদ", en: "Sunan Abu Dawud", count: "৫২৭৪", code: "A", color: "#ec4899" },
        { id: "tirmidhi", name: "জামে' আত-তিরমিজী", en: "Jami at-Tirmidhi", count: "৩৯৫৬", code: "T", color: "#8b5cf6" },
        { id: "ibnmajah", name: "সুনানে ইবনে মাজাহ", en: "Sunan Ibn Majah", count: "৪৩৪১", code: "I", color: "#10b981" },
        { id: "malik", name: "মুয়াত্তা ইমাম মালিক", en: "Muwatta Malik", count: "১৮৫৮", code: "M", color: "#64748b" },
        { id: "riyadussalihin", name: "রিয়াদুস সালেহীন", en: "Riyad as-Salihin", count: "১৮৯۶", code: "R", color: "#06b6d4" },
        { id: "nawawi", name: "৪০ হাদীস (নওয়াবী)", en: "Forty Hadith Nawawi", count: "৪২", code: "N", color: "#f97316" }
    ];

    let currentHadithBook = "bukhari";
    let currentHadithNum = 1;

    function openHadithModal() {
        window.safeOpenModal("dailyHadithModal");
        setTimeout(function() {
            renderHadithSidebar();
            selectHadithBook("bukhari", 1);
        }, 50);
    }

    function closeHadithModal() {
        window.safeCloseModal("dailyHadithModal");
    }

    function renderHadithSidebar(filterQuery = "") {
        const sidebar = document.getElementById("hadithSidebarBookList");
        if (!sidebar) return;

        const filtered = hadithBookList.filter(b => 
            b.name.toLowerCase().includes(filterQuery.toLowerCase()) ||
            b.en.toLowerCase().includes(filterQuery.toLowerCase())
        );

        sidebar.innerHTML = filtered.map(b => {
            const isActive = b.id === currentHadithBook;
            return `
                <div onclick="selectHadithBook('${b.id}', 1)" style="padding: 12px 14px; border-radius: 12px; margin-bottom: 6px; cursor: pointer; display: flex; align-items: center; gap: 12px; background: ${isActive ? 'rgba(16, 185, 129, 0.15)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(!${isActive}) this.style.background='rgba(255,255,255,0.05)'" onmouseout="if(!${isActive}) this.style.background='transparent'">
                    <div style="width: 34px; height: 34px; border-radius: 50%; background: ${b.color}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0;">
                        ${b.code}
                    </div>
                    <div style="overflow: hidden;">
                        <div style="font-weight: 800; font-size: 0.92rem; color: ${isActive ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.name}</div>
                        <div style="font-size: 0.76rem; color: #9ca3af;">মোট হাদিস ${b.count}</div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterHadithBooks() {
        const q = (document.getElementById("hadithBookSearch").value || "").trim();
        renderHadithSidebar(q);
    }

    function selectHadithBook(bookId, hadithNum = 1) {
        currentHadithBook = bookId;
        renderHadithSidebar();

        const bookObj = hadithBookList.find(b => b.id === bookId) || { name: bookId };
        const breadcrumb = document.getElementById("hadithCurrentBookName");
        if (breadcrumb) breadcrumb.innerText = bookObj.name;

        fetchHadithData(bookId, hadithNum);
    }

    function fetchHadithByNumber() {
        const input = document.getElementById("hadithNumberInput");
        const num = input ? input.value : "";
        if (!num || parseInt(num, 10) < 1) {
            alert("অনুগ্রহ করে সঠিক হাদিস নম্বর লিখুন!");
            return;
        }
        fetchHadithData(currentHadithBook, parseInt(num, 10));
    }

    function fetchRandomHadith() {
        let max = 200;
        if (currentHadithBook === "bukhari") max = 500;
        if (currentHadithBook === "muslim") max = 400;
        if (currentHadithBook === "nawawi") max = 42;
        const randomNum = Math.floor(Math.random() * max) + 1;
        fetchHadithData(currentHadithBook, randomNum);
    }

    function fetchHadithData(book, hadithNum) {
        currentHadithBook = book;
        currentHadithNum = hadithNum;

        const body = document.getElementById("hadithContentCard");
        const bookObj = hadithBookList.find(b => b.id === book) || { name: book };

        if (!body) return;

        body.innerHTML = `
            <div style="text-align: center; padding: 70px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #10b981;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">${bookObj.name} - হাদিস নং ${toBnNum(hadithNum)} লোড হচ্ছে...</div>
                <div style="font-size: 0.85rem; color: #6ee7b7; margin-top: 6px;">iHadis API-এর সাথে সংযোগ করা হচ্ছে</div>
            </div>
        `;

        Promise.all([
            fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ben-${book}/${hadithNum}.json`).then(r => r.ok ? r.json() : null),
            fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-${book}/${hadithNum}.json`).then(r => r.ok ? r.json() : null)
        ]).then(([benData, araData]) => {
            if (benData && benData.hadiths && benData.hadiths.length > 0) {
                const benHadith = benData.hadiths[0];
                const araHadith = (araData && araData.hadiths && araData.hadiths.length > 0) ? araData.hadiths[0] : null;

                const arText = araHadith ? araHadith.text : "";
                const bnText = benHadith.text || "";
                const hNum = benHadith.hadithnumber || hadithNum;

                renderHadithDetailCard(arText, bnText, bookObj.name, hNum);
            } else {
                renderFallbackHadithCard(bookObj.name, hadithNum);
            }
        }).catch(err => {
            renderFallbackHadithCard(bookObj.name, hadithNum);
        });
    }

    function renderHadithDetailCard(arText, bnText, bookName, hNum) {
        const body = document.getElementById("hadithContentCard");
        if (!body) return;

        let arHtml = arText ? `
            <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.35rem; color: #fef08a; direction: rtl; line-height: 2.3; margin-bottom: 20px; text-align: right; text-shadow: 0 2px 8px rgba(0,0,0,0.4); background: #131b2e; padding: 22px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                ${arText}
            </div>
        ` : '';

        body.innerHTML = `
            <!-- Chapter Header Banner (iHadis Style) -->
            <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(255,255,255,0.1); padding: 20px 24px; border-radius: 16px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 1.2rem; font-weight: 800; color: #ffffff;">
                        <i class="fas fa-book-bookmark" style="color: #10b981;"></i> ${bookName}
                    </div>
                    <div style="font-size: 0.85rem; color: #9ca3af; margin-top: 4px;">হাদিস নম্বর: <strong style="color: #34d399;">${toBnNum(hNum)}</strong></div>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    ${hNum > 1 ? `<button onclick="fetchHadithData('${currentHadithBook}', ${hNum - 1})" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer;"><i class="fas fa-chevron-left"></i> পূর্ববর্তী</button>` : ''}
                    <button onclick="fetchHadithData('${currentHadithBook}', ${hNum + 1})" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer;">পরবর্তী <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- Main Hadith Card -->
            <div style="background: #111827; border: 1px solid rgba(255,255,255,0.12); padding: 28px; border-radius: 20px; text-align: left; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                ${arHtml}
                
                <div style="font-size: 1.1rem; color: #ffffff; font-weight: 500; line-height: 1.85; margin-top: 16px; text-align: left;">
                    <div style="font-size: 0.82rem; color: #34d399; font-weight: 800; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">বাংলা অনুবাদ:</div>
                    ${bnText}
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 18px; margin-top: 24px;">
                    <div style="font-size: 0.88rem; color: #10b981; font-weight: 800;">
                        <i class="fas fa-check-circle" style="margin-right: 6px;"></i> মানদণ্ড: সহীহ (Sahih Hadith)
                    </div>
                    <div style="font-size: 0.82rem; color: #9ca3af;">
                        সূত্র: ${bookName} (${toBnNum(hNum)})
                    </div>
                </div>
            </div>
        `;
    }

    function renderFallbackHadithCard(bookName, hNum) {
        const body = document.getElementById("hadithContentCard");
        if (!body) return;

        body.innerHTML = `
            <div style="background: #111827; border: 1px solid rgba(255,255,255,0.12); padding: 30px; border-radius: 20px; text-align: center;">
                <i class="fas fa-book-bookmark" style="font-size: 2.2rem; color: #f59e0b; margin-bottom: 14px; display: block;"></i>
                <div style="font-size: 1.2rem; font-weight: 800; color: #ffffff; margin-bottom: 8px;">${bookName} - হাদিস নং ${toBnNum(hNum)}</div>
                <div style="font-size: 0.92rem; color: #9ca3af; margin-bottom: 22px;">এই নির্দিষ্ট হাদিস নম্বরটির তথ্য পাওয়া যায়নি। অন্য নম্বর চেষ্টা করুন।</div>
                <button onclick="fetchRandomHadith()" style="background: #10b981; border: none; color: #fff; padding: 10px 24px; border-radius: 25px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">
                    <i class="fas fa-shuffle" style="margin-right: 6px;"></i> র্যান্ডম হাদিস দেখুন
                </button>
            </div>
        `;
    }
err => {
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> সমস্যা হয়েছে';
        });

        audio.onended = function() {
            btn.innerHTML = '<i class="fas fa-play"></i> তেলাওয়াত শুনুন';
            currentPlayingAudio = null;
        };
    }

    function loadSurahDetail(surahNum) {
        currentSurahNum = surahNum;
        const body = document.getElementById("quranModalBody");
        const filterBar = document.getElementById("quranFilterBar");
        const backBtn = document.getElementById("quranBackBtn");
        const title = document.getElementById("quranModalTitle");
        const sub = document.getElementById("quranModalSub");
        const reciterSelect = document.getElementById("quranReciterSelect");

        const selectedReciter = reciterSelect ? reciterSelect.value : "ar.alafasy";

        if (filterBar) filterBar.style.display = "none";
        if (backBtn) backBtn.style.display = "inline-flex";

        body.innerHTML = `
            <div style="text-align: center; padding: 70px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #34d399;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">সূরা নম্বর ${toBnNum(surahNum)}-এর আয়াতসমূহ লোড হচ্ছে...</div>
                <div style="font-size: 0.85rem; color: #6ee7b7; margin-top: 6px;">আরবি পাঠ, বাংলা অনুবাদ ও অডিও তেলাওয়াত প্রস্তুত হচ্ছে</div>
            </div>
        `;

        Promise.all([
            fetch(`https://api.alquran.cloud/v1/surah/${surahNum}/editions/quran-uthmani,bn.bengali,${selectedReciter}`).then(r => r.json())
        ])
            .then(([res]) => {
                if (res && res.data && res.data.length >= 2) {
                    const data = res;
                    const uthmani = data.data[0];
                    const bengali = data.data[1];
                    const audioRec = data.data[2] || null;

                    if (title) title.innerText = `সূরা ${uthmani.englishNameTranslation} (${uthmani.englishName})`;
                    if (sub) sub.innerText = `${uthmani.revelationType === 'Meccan' ? 'মাক্কী' : 'মাদানী'} • মোট আয়াত: ${toBnNum(uthmani.numberOfAyahs)}`;

                    let surahNavHtml = `
                        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; background: rgba(0,0,0,0.25); padding: 12px 18px; border-radius: 16px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.1);">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 0.88rem; color: #a7f3d0; font-weight: 700;">সূরা লাফান:</span>
                                <select onchange="loadSurahDetail(parseInt(this.value, 10))" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; font-weight: 700; padding: 6px 12px; border-radius: 10px; outline: none; cursor: pointer;">
                                    ${cachedSurahs.map(s => `<option value="${s.number}" ${s.number === surahNum ? 'selected' : ''} style="background:#043e2f;">${toBnNum(s.number)}. ${s.englishNameTranslation} (${s.englishName})</option>`).join('')}
                                </select>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 8px;">
                                ${surahNum > 1 ? `<button onclick="loadSurahDetail(${surahNum - 1})" style="background: rgba(255,255,255,0.12); border: none; color: #fff; padding: 6px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer;"><i class="fas fa-chevron-left"></i> পূর্ববর্তী</button>` : ''}
                                ${surahNum < 114 ? `<button onclick="loadSurahDetail(${surahNum + 1})" style="background: rgba(255,255,255,0.12); border: none; color: #fff; padding: 6px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer;">পরবর্তী <i class="fas fa-chevron-right"></i></button>` : ''}
                            </div>
                        </div>
                    `;

                    let bismillahHtml = "";
                    if (surahNum !== 9 && surahNum !== 1) {
                        bismillahHtml = `
                            <div style="text-align: center; padding: 22px; margin-bottom: 22px; background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%); border-radius: 18px; border: 1px solid rgba(245, 158, 11, 0.3); font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 2rem; color: #fef08a; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">
                                بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                            </div>
                        `;
                    }

                    const ayahsHtml = uthmani.ayahs.map((a, idx) => {
                        const bnAyah = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text : "";
                        const audioUrl = (audioRec && audioRec.ayahs[idx]) ? audioRec.ayahs[idx].audio : "";

                        return `
                            <div style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); padding: 22px; border-radius: 20px; margin-bottom: 18px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='rgba(52, 211, 153, 0.4)'" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.12)'">
                                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px; margin-bottom: 16px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 800; font-family: 'Outfit', sans-serif; box-shadow: 0 3px 10px rgba(16,185,129,0.3);">
                                            ${toBnNum(surahNum)}:${toBnNum(a.numberInSurah)}
                                        </span>
                                    </div>

                                    ${audioUrl ? `
                                        <button onclick="playAyahAudio('${audioUrl}', this)" style="background: rgba(52, 211, 153, 0.2); border: 1px solid #34d399; color: #6ee7b7; padding: 5px 16px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='rgba(52, 211, 153, 0.35)'" onmouseout="this.style.background='rgba(52, 211, 153, 0.2)'">
                                            <i class="fas fa-play"></i> তেলাওয়াত শুনুন
                                        </button>
                                    ` : ""}
                                </div>

                                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.45rem; color: #fef08a; direction: rtl; text-align: right; line-height: 2.3; margin-bottom: 14px; text-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                                    ${a.text}
                                </div>

                                <div style="font-size: 1.02rem; color: #ffffff; line-height: 1.8; text-align: left; font-weight: 500;">
                                    ${bnAyah}
                                </div>
                            </div>
                        `;
                    }).join('');

                    body.innerHTML = surahNavHtml + bismillahHtml + ayahsHtml;
                } else {
                    body.innerHTML = '<div style="text-align:center; padding: 50px; color:#f87171;">সূরার আয়াত লোড হয়নি।</div>';
                }
            })
            .catch(err => {
                body.innerHTML = '<div style="text-align:center; padding: 50px; color:#f87171;">সূরা লোড করতে ত্রুটি ঘটেছে।</div>';
            });
    }


    // HADITH COLLECTION API SCRIPT (9 BOOKS) - IHADIS STYLE
    // ==========================================================
    const hadithBookList = [
        { id: "bukhari", name: "সহীহ বুখারী", en: "Sahih al-Bukhari", count: "৭৫২৯", code: "B", color: "#3b82f6" },
        { id: "muslim", name: "সহীহ মুসলিম", en: "Sahih Muslim", count: "৭৩৬০", code: "M", color: "#10b981" },
        { id: "nasai", name: "সুনানে আন-নাসায়ী", en: "Sunan an-Nasa'i", count: "৫৬৫৬", code: "N", color: "#f59e0b" },
        { id: "abudawud", name: "সুনানে আবু দাউদ", en: "Sunan Abu Dawud", count: "৫২৭০", code: "A", color: "#ec4899" },
        { id: "tirmidhi", name: "জামে' আত-তিরমিজী", en: "Jami at-Tirmidhi", count: "৩৮৯৫", code: "T", color: "#8b5cf6" },
        { id: "ibnmajah", name: "সুনানে ইবনে মাজাহ", en: "Sunan Ibn Majah", count: "৪৩৩৬", code: "I", color: "#10b981" },
        { id: "malik", name: "মুয়াত্তা ইমাম মালিক", en: "Muwatta Malik", count: "১৭৪৯", code: "M", color: "#64748b" },
        { id: "nawawi", name: "৪০ হাদীস (নওয়াবী)", en: "Forty Hadith Nawawi", count: "৪২", code: "N", color: "#f97316" }
    ];

    let currentHadithBook = "bukhari";
    let currentHadithNum = 1;

    function openHadithModal() {
        window.safeOpenModal("dailyHadithModal");
        setTimeout(function() {
            renderHadithSidebar();
            selectHadithBook("bukhari", 1);
        }, 50);
    }

    function closeHadithModal() {
        window.safeCloseModal("dailyHadithModal");
    }

    function renderHadithSidebar(filterQuery = "") {
        const sidebar = document.getElementById("hadithSidebarBookList");
        if (!sidebar) return;

        const filtered = hadithBookList.filter(b => 
            b.name.toLowerCase().includes(filterQuery.toLowerCase()) ||
            b.en.toLowerCase().includes(filterQuery.toLowerCase())
        );

        sidebar.innerHTML = filtered.map(b => {
            const isActive = b.id === currentHadithBook;
            return `
                <div onclick="selectHadithBook('${b.id}', 1)" style="padding: 12px 14px; border-radius: 12px; margin-bottom: 6px; cursor: pointer; display: flex; align-items: center; gap: 12px; background: ${isActive ? 'rgba(16, 185, 129, 0.15)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(!${isActive}) this.style.background='rgba(255,255,255,0.05)'" onmouseout="if(!${isActive}) this.style.background='transparent'">
                    <div style="width: 34px; height: 34px; border-radius: 50%; background: ${b.color}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0;">
                        ${b.code}
                    </div>
                    <div style="overflow: hidden;">
                        <div style="font-weight: 800; font-size: 0.92rem; color: ${isActive ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.name}</div>
                        <div style="font-size: 0.76rem; color: #9ca3af;">মোট হাদিস ${b.count}</div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterHadithBooks() {
        const q = (document.getElementById("hadithBookSearch").value || "").trim();
        renderHadithSidebar(q);
    }

    function selectHadithBook(bookId, hadithNum = 1) {
        currentHadithBook = bookId;
        renderHadithSidebar();

        const bookObj = hadithBookList.find(b => b.id === bookId) || { name: bookId };
        const breadcrumb = document.getElementById("hadithCurrentBookName");
        if (breadcrumb) breadcrumb.innerText = bookObj.name;

        fetchHadithData(bookId, hadithNum);
    }

    function fetchHadithByNumber() {
        const input = document.getElementById("hadithNumberInput");
        const num = input ? input.value : "";
        if (!num || parseInt(num, 10) < 1) {
            alert("অনুগ্রহ করে সঠিক হাদিস নম্বর লিখুন!");
            return;
        }
        fetchHadithData(currentHadithBook, parseInt(num, 10));
    }

    function fetchRandomHadith() {
        let max = 200;
        if (currentHadithBook === "bukhari") max = 500;
        if (currentHadithBook === "muslim") max = 400;
        if (currentHadithBook === "nawawi") max = 42;
        const randomNum = Math.floor(Math.random() * max) + 1;
        fetchHadithData(currentHadithBook, randomNum);
    }

    function fetchHadithData(book, hadithNum) {
        currentHadithBook = book;
        currentHadithNum = hadithNum;

        const body = document.getElementById("hadithContentCard");
        const bookObj = hadithBookList.find(b => b.id === book) || { name: book };

        if (!body) return;

        body.innerHTML = `
            <div style="text-align: center; padding: 70px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #10b981;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">${bookObj.name} - হাদিস নং ${toBnNum(hadithNum)} লোড হচ্ছে...</div>
                <div style="font-size: 0.85rem; color: #6ee7b7; margin-top: 6px;">iHadis API-এর সাথে সংযোগ করা হচ্ছে</div>
            </div>
        `;

        Promise.all([
            fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ben-${book}/${hadithNum}.json`).then(r => r.ok ? r.json() : null),
            fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-${book}/${hadithNum}.json`).then(r => r.ok ? r.json() : null)
        ]).then(([benData, araData]) => {
            if (benData && benData.hadiths && benData.hadiths.length > 0) {
                const benHadith = benData.hadiths[0];
                const araHadith = (araData && araData.hadiths && araData.hadiths.length > 0) ? araData.hadiths[0] : null;

                const arText = araHadith ? araHadith.text : "";
                const bnText = benHadith.text || "";
                const hNum = benHadith.hadithnumber || hadithNum;

                renderHadithDetailCard(arText, bnText, bookObj.name, hNum);
            } else {
                renderFallbackHadithCard(bookObj.name, hadithNum);
            }
        }).catch(err => {
            renderFallbackHadithCard(bookObj.name, hadithNum);
        });
    }

    function renderHadithDetailCard(arText, bnText, bookName, hNum) {
        const body = document.getElementById("hadithContentCard");
        if (!body) return;

        let arHtml = arText ? `
            <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.35rem; color: #fef08a; direction: rtl; line-height: 2.3; margin-bottom: 20px; text-align: right; text-shadow: 0 2px 8px rgba(0,0,0,0.4); background: #131b2e; padding: 22px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                ${arText}
            </div>
        ` : '';

        body.innerHTML = `
            <!-- Chapter Header Banner (iHadis Style) -->
            <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(255,255,255,0.1); padding: 20px 24px; border-radius: 16px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 1.2rem; font-weight: 800; color: #ffffff;">
                        <i class="fas fa-book-bookmark" style="color: #10b981;"></i> ${bookName}
                    </div>
                    <div style="font-size: 0.85rem; color: #9ca3af; margin-top: 4px;">হাদিস নম্বর: <strong style="color: #34d399;">${toBnNum(hNum)}</strong></div>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    ${hNum > 1 ? `<button onclick="fetchHadithData('${currentHadithBook}', ${hNum - 1})" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer;"><i class="fas fa-chevron-left"></i> পূর্ববর্তী</button>` : ''}
                    <button onclick="fetchHadithData('${currentHadithBook}', ${hNum + 1})" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer;">পরবর্তী <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- Main Hadith Card -->
            <div style="background: #111827; border: 1px solid rgba(255,255,255,0.12); padding: 28px; border-radius: 20px; text-align: left; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                ${arHtml}
                
                <div style="font-size: 1.1rem; color: #ffffff; font-weight: 500; line-height: 1.85; margin-top: 16px; text-align: left;">
                    <div style="font-size: 0.82rem; color: #34d399; font-weight: 800; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">বাংলা অনুবাদ:</div>
                    ${bnText}
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 18px; margin-top: 24px;">
                    <div style="font-size: 0.88rem; color: #10b981; font-weight: 800;">
                        <i class="fas fa-check-circle" style="margin-right: 6px;"></i> মানদণ্ড: সহীহ (Sahih Hadith)
                    </div>
                    <div style="font-size: 0.82rem; color: #9ca3af;">
                        সূত্র: ${bookName} (${toBnNum(hNum)})
                    </div>
                </div>
            </div>
        `;
    }

    function renderFallbackHadithCard(bookName, hNum) {
        const body = document.getElementById("hadithContentCard");
        if (!body) return;

        body.innerHTML = `
            <div style="background: #111827; border: 1px solid rgba(255,255,255,0.12); padding: 30px; border-radius: 20px; text-align: center;">
                <i class="fas fa-book-bookmark" style="font-size: 2.2rem; color: #f59e0b; margin-bottom: 14px; display: block;"></i>
                <div style="font-size: 1.2rem; font-weight: 800; color: #ffffff; margin-bottom: 8px;">${bookName} - হাদিস নং ${toBnNum(hNum)}</div>
                <div style="font-size: 0.92rem; color: #9ca3af; margin-bottom: 22px;">এই নির্দিষ্ট হাদিস নম্বরটির তথ্য পাওয়া যায়নি। অন্য নম্বর চেষ্টা করুন।</div>
                <button onclick="fetchRandomHadith()" style="background: #10b981; border: none; color: #fff; padding: 10px 24px; border-radius: 25px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">
                    <i class="fas fa-shuffle" style="margin-right: 6px;"></i> র্যান্ডম হাদিস দেখুন
                </button>
            </div>
        `;
    }

    const dailyDuas = [
        { title: "ঘুম থেকে ওঠার দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَحْيَانَا بَعْدَ مَا أَمَاتَنَا وَإِلَيْهِ النُّشُورُ", bn: "আলহামদু লিল্লাহিল্লাজী আহইয়ানা বা’দা মা অমা তানা ওয়া ইলাইহিন নুশূর।", mean: "সকল প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে মারার (ঘুমের) পর জীবিত করলেন এবং তাঁর দিকেই সবার প্রত্যাবর্তন।" },
        { title: "ঘুমাতে যাওয়ার দো'আ", ar: "بِاسْمِكَ اللَّهُمَّ أَمُوتُ وَأَحْيَا", bn: "আল্লাহুম্মা বিসমিকা আমূতু ওয়া আহইয়া।", mean: "হে আল্লাহ! আপনার নামে আমি মৃত্যুবরণ (ঘুমাই) করছি এবং আপনার নামেই জীবিত (জাগ্রত) হচ্ছি।" },
        { title: "খাবারের শুরুর দো'আ", ar: "بِسْمِ اللَّهِ وَعَلَى بَرَكَةِ اللَّهِ", bn: "বিসমিল্লাহি ওয়া ‘আলা বারাকাতিল্লাহ।", mean: "আল্লাহর নামে এবং আল্লাহর বরকতের উপর (খেতে শুরু করলাম)।" },
        { title: "খাবার শেষের দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَطْعَمَنَا وَسَقَانَا وَجَعَلَنَا مِنَ الْمُسْلِمِينَ", bn: "আলহামদু লিল্লাহিল্লাজী আত’আমানা ওয়া সাকানা ওয়া জা’আলানা মিনাল মুসলিমীন।", mean: "সকল প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে খাওয়ালেন, পান করালেন এবং মুসলিম বানালেন।" },
        { title: "মসজিদে প্রবেশের দো'আ", ar: "اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ", bn: "আল্লাহুম্মাফতাহ লী আবওয়াবা রহমাতিক।", mean: "হে আল্লাহ! আমার জন্য আপনার রহমতের দরজাসমূহ খুলে দিন।" },
        { title: "মসজিদ থেকে বের হওয়ার দো'আ", ar: "اللَّهُمَّ إِنِّي أَسْأَلُكَ مِنْ فَضْلِكَ", bn: "আল্লাহুম্মা ইন্নি আসআলুকা মিন ফادলিক।", mean: "হে আল্লাহ! আমি আপনার নিকট আপনার অনুগ্রহ প্রার্থনা করছি।" }
    ];

    function openDuaModal() {
        window.safeOpenModal("dailyDuaModal");
        renderDuaList();
    }
    function closeDuaModal() { window.safeCloseModal("dailyDuaModal"); }
    function renderDuaList() {
        const container = document.getElementById("duaListContainer");
        if (!container) return;
        container.innerHTML = dailyDuas.map(d => `
            <div style="background: rgba(255, 255, 255, 0.07); border: 1px solid rgba(255, 255, 255, 0.12); padding: 18px; border-radius: 18px;">
                <div style="font-weight: 800; font-size: 1.05rem; color: #f59e0b; margin-bottom: 8px;"><i class="fas fa-hands-praying" style="margin-right: 6px;"></i> ${d.title}</div>
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.5rem; color: #fef08a; direction: rtl; text-align: right; line-height: 2; margin-bottom: 8px;">${d.ar}</div>
                <div style="font-size: 0.92rem; color: #6ee7b7; font-weight: 700; margin-bottom: 4px;">উচ্চারণ: ${d.bn}</div>
                <div style="font-size: 0.85rem; color: #ffffff;">অর্থ: ${d.mean}</div>
            </div>
        `).join('');
    }
    window.openDuaModal = openDuaModal;
    window.closeDuaModal = closeDuaModal;
    window.renderDuaList = renderDuaList;

    const asmaUlHusnaList = [
        { num: 1, ar: "الرَّحْمَٰنُ", bn: "আর-রহমান", mean: "পরম দয়ালু" },
        { num: 2, ar: "الرَّحِيمُ", bn: "আর-রহীম", mean: "অতি দাতা, পরম করুণাময়" },
        { num: 3, ar: "الْمَلِكُ", bn: "আল-মালিক", mean: "সর্বভৌম ক্ষমতার অধিকারী" },
        { num: 4, ar: "الْقُدُّوسُ", bn: "আল-কুদ্দূস", mean: "পবিত্র ও নিষ্পাপ" },
        { num: 5, ar: "السَّلَامُ", bn: "আস-সালাম", mean: "শান্তিদাতা" },
        { num: 6, ar: "الْمُؤْمِنُ", bn: "আল-মু'মিন", mean: "নিরাপত্তা ও ঈমানদাতা" },
        { num: 7, ar: "الْمُهَيْمِنُ", bn: "আল-মুহাইমিন", mean: "রক্ষণাবেক্ষণকারী" },
        { num: 8, ar: "الْعَزِيزُ", bn: "আল-আজীজ", mean: "পরাক্রমশালী, বিজয়ী" },
        { num: 9, ar: "الْجَبَّارُ", bn: "আল-জাব্বার", mean: "দুর্নিবার, বাধ্যকারী" },
        { num: 10, ar: "الْمُتَكَبِّرُ", bn: "আল-মুতাকাব্বির", mean: "মহিমান্বিত, সর্বশ্রেষ্ঠ" },
        { num: 11, ar: "الْخَالِقُ", bn: "আল-খালিক", mean: "সৃষ্টিকর্তা" },
        { num: 12, ar: "الْبَارِئُ", bn: "আল-বারী", mean: "সঠিক রূপদাতা" },
        { num: 13, ar: "الْمُصَوِّرُ", bn: "আল-মুসাব্বির", mean: "আকৃতিদানকারী" },
        { num: 14, ar: "الْغَفَّارُ", bn: "আল-গাফফার", mean: "পরম ক্ষমাশীল" },
        { num: 15, ar: "الْقَهَّارُ", bn: "আল-কাহহার", mean: "কঠোর দমনকারী" },
        { num: 16, ar: "الْوَهَّابُ", bn: "আল-ওয়াহহাব", mean: "সবকিছু দানকারী" },
        { num: 17, ar: "الرَّزَّاقُ", bn: "আর-রাজ্জাক", mean: "রিজিকদাতা" },
        { num: 18, ar: "الْفَتَّاحُ", bn: "আল-ফাত্তাহ", mean: "বিজয়দাতা ও উন্মুক্তকারী" },
        { num: 19, ar: "الْعَلِيمُ", bn: "আল-আলীম", mean: "সর্বজ্ঞাত" },
        { num: 20, ar: "الْقَابِضُ", bn: "আল-কাবিদ্ব", mean: "রিজিক সংকুচিতকারী" },
        { num: 21, ar: "الْبَاسِطُ", bn: "আল-বাসিত", mean: "রিজিক সম্প্রসারণকারী" },
        { num: 22, ar: "الْخَافِضُ", bn: "আল-খাফিদ", mean: "অবনতকারী" },
        { num: 23, ar: "الرَّافِعُ", bn: "আর-রাফি", mean: "উন্নতকারী" },
        { num: 24, ar: "الْمُعِزُّ", bn: "আল-মুইজ্জ", mean: "সম্মানদাতা" },
        { num: 25, ar: "الْمُذِلُّ", bn: "আল-মুজিল", mean: "অপমানকারী" },
        { num: 26, ar: "السَّمِيعُ", bn: "আস-সামী", mean: "সর্বশ্রোতা" },
        { num: 27, ar: "الْبَصِيرُ", bn: "আল-বাশীর", mean: "সর্বদ্রষ্টা" },
        { num: 28, ar: "الْحَكَمُ", bn: "আল-হাকাম", mean: "বিচারক" },
        { num: 29, ar: "الْعَدْلُ", bn: "আল-আদল", mean: "পরম ন্যায়বিচারক" },
        { num: 30, ar: "اللَّطِيفُ", bn: "আল-লতীফ", mean: "সূক্ষ্মদর্শী ও স্নেহশীল" },
        { num: 31, ar: "الْخَبِيرُ", bn: "আল-খাবীর", mean: "সর্বজ্ঞাত, খবররাখনেওয়ালা" },
        { num: 32, ar: "الْحَلِيمُ", bn: "আল-হালীম", mean: "ধৈর্যশীল ও সহনশীল" },
        { num: 33, ar: "الْعَظِيمُ", bn: "আল-আজীম", mean: "মহান ও মহিমান্বিত" },
        { num: 34, ar: "الْغَفُورُ", bn: "আল-গফূর", mean: "ক্ষমাকারী" },
        { num: 35, ar: "الشَّكُورُ", bn: "আশ-শাকূর", mean: "গুণগ্রাহী" },
        { num: 36, ar: "الْعَلِيُّ", bn: "আল-আলী", mean: "উচ্চ মর্যাদাশীল" },
        { num: 37, ar: "الْكَبِيرُ", bn: "আল-কাবীর", mean: "মহামহিম, সবচেয়ে বড়" },
        { num: 38, ar: "الْحَفِيظُ", bn: "আল-হাফীজ", mean: "রক্ষণাবেক্ষণকারী" },
        { num: 39, ar: "الْمُقِيتُ", bn: "আল-মুকীত", mean: "সবকিছুর জীবনোপকরণদাতা" },
        { num: 40, ar: "الْحَسِيبُ", bn: "আল-হাসীব", mean: "হিসাব গ্রহণকারী" },
        { num: 41, ar: "الْجَلِيلُ", bn: "আল-জালীল", mean: "মহীয়ান ও গরিমানুসারে শ্রেষ্ঠ" },
        { num: 42, ar: "الْكَرِيمُ", bn: "আল-কারীম", mean: "মহাদানশীল" },
        { num: 43, ar: "الرَّقِيبُ", bn: "আর-রকীব", mean: "তত্ত্বাবধায়ক" },
        { num: 44, ar: "الْمُجِيبُ", bn: "আল-মুজীব", mean: "দোয়া কবুলকারী" },
        { num: 45, ar: "الْوَاسِعُ", bn: "আল-ওয়াসি", mean: "সর্বব্যাপী, প্রশস্তময়" },
        { num: 46, ar: "الْحَكِيمُ", bn: "আল-হাকীম", mean: "মহাজ্ঞানী ও প্রজ্ঞাময়" },
        { num: 47, ar: "الْوَدُودُ", bn: "আল-ওয়াদূদ", mean: "প্রেমময় ও স্নেহশীল" },
        { num: 48, ar: "الْمَجِيدُ", bn: "আল-মাজীদ", mean: "মহামহিমান্বিত" },
        { num: 49, ar: "الْبَاعِثُ", bn: "আল-বায়িছ", mean: "পুনরুত্থানকারী" },
        { num: 50, ar: "الشَّهِيدُ", bn: "আশ-শাহীদ", mean: "সর্বক্ষনে উপস্থিত সাক্ষী" },
        { num: 51, ar: "الْحَقُّ", bn: "আল-হাক্ক", mean: "পরম সত্য" },
        { num: 52, ar: "الْوَكِيلُ", bn: "আল-ওয়াকীল", mean: "কর্মসম্পাদনকারী, নির্ভরযোগ্য অভিভাবক" },
        { num: 53, ar: "الْقَوِيُّ", bn: "আল-কউইয়্যি", mean: "পরম শক্তিশালী" },
        { num: 54, ar: "الْمَتِينُ", bn: "আল-মাতীন", mean: "সুদৃঢ়" },
        { num: 55, ar: "الْوَلِيُّ", bn: "আল-ওয়ালী", mean: "অভিভাবক ও বন্ধু" },
        { num: 56, ar: "الْحَمِيدُ", bn: "আল-হামীদ", mean: "প্রশংসিত" },
        { num: 57, ar: "الْمُحْصِي", bn: "আল-মুহসী", mean: "সবকিছুর গণনা ও হিসাবরক্ষক" },
        { num: 58, ar: "الْمُبْدِئُ", bn: "আল-মুবদি", mean: "প্রথমবার সৃষ্টিকর্তা" },
        { num: 59, ar: "الْمُعِيدُ", bn: "আল-মুঈদ", mean: "পুনরায় জীবনদানকারী" },
        { num: 60, ar: "الْمُحْيِي", bn: "আল-মহিয়্যি", mean: "জীবনদাতা" },
        { num: 61, ar: "الْمُمِيتُ", bn: "আল-মুমীত", mean: "মৃত্যুদাতা" },
        { num: 62, ar: "الْحَيُّ", bn: "আল-হাইয়্যি", mean: "চিরঞ্জীব" },
        { num: 63, ar: "الْقَيُّومُ", bn: "আল-কাইয়্যূম", mean: "চিরস্থায়ী, বিশ্বধারণকারী" },
        { num: 64, ar: "الْوَاجِدُ", bn: "আল-ওয়াজিদ", mean: "প্রচুুর্যের অধিকারী" },
        { num: 65, ar: "الْمَاجِدُ", bn: "আল-মাজিদ", mean: "মহামান্বিত" },
        { num: 66, ar: "الْوَاحِدُ", bn: "আল-ওয়াহিদ", mean: "এক ও অদ্বিতীয়" },
        { num: 67, ar: "الْأَحَدُ", bn: "আল-আহাদ", mean: "একক" },
        { num: 68, ar: "الصَّمَدُ", bn: "আস-সামাদ", mean: "অমুখাপেক্ষী" },
        { num: 69, ar: "الْقَادِرُ", bn: "আল-কাদির", mean: "সর্বশক্তিমান" },
        { num: 70, ar: "الْمُقْتَدِرُ", bn: "আল-মুক্তাদির", mean: "পূর্ণ ক্ষমতার অধিকারী" },
        { num: 71, ar: "الْمُقَدِّمُ", bn: "আল-মুকাদ্দিম", mean: "অগ্রগামীকারী" },
        { num: 72, ar: "الْمُؤَخِّرُ", bn: "আল-মুআখখির", mean: "পশ্চাৎগামীকারী" },
        { num: 73, ar: "الْأَوَّلُ", bn: "আল-আউয়াল", mean: "সর্বপ্রথম" },
        { num: 74, ar: "الْآخِرُ", bn: "আল-আখির", mean: "সর্বশেষ" },
        { num: 75, ar: "الظَّاهِرُ", bn: "আজ-জাহির", mean: "প্রকাশ্য" },
        { num: 76, ar: "الْبَاطِنُ", bn: "আল-বাতিন", mean: "গুপ্ত" },
        { num: 77, ar: "الْوَالِي", bn: "আল-ওয়ালী", mean: "শাসক ও অভিভাবক" },
        { num: 78, ar: "الْمُتَعَالِي", bn: "আল-মুতায়ালী", mean: "সর্বোচ্চ সুউচ্চ" },
        { num: 79, ar: "الْبَرُّ", bn: "আল-বার্র", mean: "পরম অনুগ্রাহক" },
        { num: 80, ar: "التَّوَّابُ", bn: "আত-তাওয়াব", mean: "তওবা কবুলকারী" },
        { num: 81, ar: "الْمُنْتَقِمُ", bn: "আল-মুনতাক্বিম", mean: "প্রতিশোধ গ্রহণকারী" },
        { num: 82, ar: "الْعَفُوُّ", bn: "আল-আফুউ", mean: "পরম মার্জনাকারী" },
        { num: 83, ar: "الرَّءُوفُ", bn: "আর-রউফ", mean: "পরম দয়ার্দ্র" },
        { num: 84, ar: "مَالِكُ الْمُلْكِ", bn: "মালিকুল মুলক", mean: "সকল সাম্রাজ্যের মালিক" },
        { num: 85, ar: "ذُو الْجَلَالِ وَالْإِكْرَامِ", bn: "জুল জালালি ওয়াল ইকরাম", mean: "মহিমাময় ও মহানুভবতার অধিকারী" },
        { num: 86, ar: "الْمُقْسِطُ", bn: "আল-মুকসিত", mean: "সুসংগত ও সুবিচারকারী" },
        { num: 87, ar: "الْجَامِعُ", bn: "আল-জামি", mean: "একত্রকারী" },
        { num: 88, ar: "الْغَنِيُّ", bn: "আল-গণিয়্যি", mean: "স্বয়ংসম্পূর্ণ, ধনী" },
        { num: 89, ar: "الْمُغْنِي", bn: "আল-মুগনী", mean: "ঐশ্বর্যদানকারী" },
        { num: 90, ar: "الْمَانِعُ", bn: "আল-মানি", mean: "প্রতিরোধকারী" },
        { num: 91, ar: "الضَّارُّ", bn: "অ্যাদ্ব-দ্বার্র", mean: "ক্ষতিসাধনকারী" },
        { num: 92, ar: "النَّافِعُ", bn: "আন-নাফি", mean: "উপকারকারী" },
        { num: 93, ar: "النُّورُ", bn: "আন-নূর", mean: "জ্যোতি, আলোর উৎস" },
        { num: 94, ar: "الْهَادِي", bn: "আল-হাদী", mean: "পথপ্রদর্শক" },
        { num: 95, ar: "الْبَدِيعُ", bn: "আল-বাদী", mean: "নজিরবিহীন অদ্ভুত স্রষ্টা" },
        { num: 96, ar: "الْبَاقِي", bn: "আল-বাকী", mean: "অবিনশ্বর, চিরস্থায়ী" },
        { num: 97, ar: "الْوَارِثُ", bn: "আল-ওয়ারিছ", mean: "সকল কিছুর চূড়ান্ত মালিক" },
        { num: 98, ar: "الرَّشِيدُ", bn: "আর-রশীদ", mean: "সঠিক পথের নির্দেশক" },
        { num: 99, ar: "الصَّبُورُ", bn: "আস-সবূর", mean: "অসীম ধৈর্যশীল" }
    ];

    function openAsmaModal() {
        window.safeOpenModal("asmaUlHusnaModal");
        renderAsmaGrid();
    }
    function closeAsmaModal() { window.safeCloseModal("asmaUlHusnaModal"); }
    function renderAsmaGrid() {
        const container = document.getElementById("asmaGridContainer");
        if (!container) return;
        container.innerHTML = asmaUlHusnaList.map(item => `
            <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); padding: 14px; border-radius: 16px; text-align: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='#f59e0b';" onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(255, 255, 255, 0.15)';">
                <div style="font-size: 0.75rem; color: #f59e0b; font-weight: 800; font-family: 'Outfit', sans-serif;">#${toBnNum(item.num)}</div>
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.6rem; color: #fef08a; margin: 4px 0;">${item.ar}</div>
                <div style="font-size: 0.95rem; font-weight: 800; color: #ffffff;">${item.bn}</div>
                <div style="font-size: 0.78rem; color: #a7f3d0; margin-top: 3px;">${item.mean}</div>
            </div>
        `).join('');
    }

    window.renderAsmaGrid = renderAsmaGrid;
    window.openAsmaModal = openAsmaModal;
    window.closeAsmaModal = closeAsmaModal;

    // Pre-render 99 Names immediately so popup is ready instantly
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderAsmaGrid);
    } else {
        renderAsmaGrid();
    }

    const dailyDuas = [
        { title: "ঘুম থেকে ওঠার দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَحْيَانَا بَعْدَ مَا أَمَاتَنَا وَإِلَيْهِ النُّشُورُ", bn: "আলহামদু লিল্লাহিল্লাজী আহইয়ানা বা’দা মা অমা তানা ওয়া ইলাইহিন নুশূর।", mean: "সকল প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে মারার (ঘুমের) পর জীবিত করলেন এবং তাঁর দিকেই সবার প্রত্যাবর্তন।" },
        { title: "ঘুমাতে যাওয়ার দো'আ", ar: "بِاسْمِكَ اللَّهُمَّ أَمُوتُ وَأَحْيَا", bn: "আল্লাহুম্মা বিসমিকা আমূতু ওয়া আহইয়া।", mean: "হে আল্লাহ! আপনার নামে আমি মৃত্যুবরণ (ঘুমাই) করছি এবং আপনার নামেই জীবিত (জাগ্রত) হচ্ছি।" },
        { title: "খাবারের শুরুর দো'আ", ar: "بِسْمِ اللَّهِ وَعَلَى بَرَكَةِ اللَّهِ", bn: "বিসমিল্লাহি ওয়া ‘আলা বারাকাতিল্লাহ।", mean: "আল্লাহর নামে এবং আল্লাহর বরকতের উপর (খেতে শুরু করলাম)।" },
        { title: "খাবার শেষের দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَطْعَمَنَا وَسَقَانَا وَجَعَلَنَا مِنَ الْمُسْلِمِينَ", bn: "আলহামদু লিল্লাহিল্লাজী আত’আমানা ওয়া সাকানা ওয়া জা’আলানা মিনাল মুসলিমীন।", mean: "সকল প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে খাওয়ালেন, পান করালেন এবং মুসলিম বানালেন।" },
        { title: "মসজিদে প্রবেশের দো'আ", ar: "اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ", bn: "আল্লাহুম্মাফতাহ লী আবওয়াবা রহমাতিক।", mean: "হে আল্লাহ! আমার জন্য আপনার রহমতের দরজাসমূহ খুলে দিন।" },
        { title: "মসজিদ থেকে বের হওয়ার দো'আ", ar: "اللَّهُمَّ إِنِّي أَسْأَلُكَ مِنْ فَضْلِكَ", bn: "আল্লাহুম্মা ইন্নি আসআলুকা মিন ফাদলিক।", mean: "হে আল্লাহ! আমি আপনার নিকট আপনার অনুগ্রহ প্রার্থনা করছি।" }
    ];

    function openDuaModal() {
        window.safeOpenModal("dailyDuaModal");
        renderDuaList();
    }
    function closeDuaModal() { window.safeCloseModal("dailyDuaModal"); }
    function renderDuaList() {
        const container = document.getElementById("duaListContainer");
        if (!container) return;
        container.innerHTML = dailyDuas.map(d => `
            <div style="background: rgba(255, 255, 255, 0.07); border: 1px solid rgba(255, 255, 255, 0.12); padding: 18px; border-radius: 18px;">
                <div style="font-weight: 800; font-size: 1.05rem; color: #f59e0b; margin-bottom: 8px;"><i class="fas fa-hands-praying" style="margin-right: 6px;"></i> ${d.title}</div>
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.5rem; color: #fef08a; direction: rtl; text-align: right; line-height: 2; margin-bottom: 8px;">${d.ar}</div>
                <div style="font-size: 0.92rem; color: #6ee7b7; font-weight: 700; margin-bottom: 4px;">উচ্চারণ: ${d.bn}</div>
                <div style="font-size: 0.85rem; color: #ffffff;">অর্থ: ${d.mean}</div>
            </div>
        `).join('');
    }
    window.openDuaModal = openDuaModal;
    window.closeDuaModal = closeDuaModal;

    let tasbihCount = 0;
    function openTasbihModal() { window.safeOpenModal("digitalTasbihModal"); }
    function closeTasbihModal() { window.safeCloseModal("digitalTasbihModal"); }
    function countTasbih() {
        tasbihCount++;
        const el = document.getElementById("tasbihCounter");
        if (el) el.innerText = toBnNum(tasbihCount);
    }
    function resetTasbih() {
        tasbihCount = 0;
        const el = document.getElementById("tasbihCounter");
        if (el) el.innerText = "০";
    }
    window.openTasbihModal = openTasbihModal;
    window.closeTasbihModal = closeTasbihModal;
    window.countTasbih = countTasbih;
    window.resetTasbih = resetTasbih;

    function openQiblaModal() { window.safeOpenModal("qiblaCompassModal"); }
    function closeQiblaModal() { window.safeCloseModal("qiblaCompassModal"); }
    window.openQiblaModal = openQiblaModal;
    window.closeQiblaModal = closeQiblaModal;

    function openZakatModal() { window.safeOpenModal("zakatCalculatorModal"); }
    function closeZakatModal() { window.safeCloseModal("zakatCalculatorModal"); }
    function calcZakat() {
        const cash = parseFloat(document.getElementById("zakatCash").value) || 0;
        const gold = parseFloat(document.getElementById("zakatGold").value) || 0;
        const business = parseFloat(document.getElementById("zakatBusiness").value) || 0;
        const total = cash + gold + business;
        const zakat = total * 0.025;
        const resultEl = document.getElementById("zakatResult");
        if (resultEl) {
            resultEl.innerText = toBnNum(Math.round(zakat)) + " টাকা";
        }
    }
    window.openZakatModal = openZakatModal;
    window.closeZakatModal = closeZakatModal;
    window.calcZakat = calcZakat;

    // Modal background click handler for all modals
    window.addEventListener('click', function(e) {
        ['alQuranModal', 'prayerTimesModal', 'islamicCalendarModal', 'digitalTasbihModal', 'dailyDuaModal', 'asmaUlHusnaModal', 'qiblaCompassModal', 'zakatCalculatorModal', 'dailyHadithModal'].forEach(id => {
            const m = document.getElementById(id);
            if (m && e.target === m) {
                window.safeCloseModal(id);
            }
        });
    });</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>