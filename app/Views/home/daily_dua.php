<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Masnoon Dua Full Page Container (Islamic Emerald Green Theme) -->
<div style="position: relative; background: radial-gradient(circle at 50% 30%, #064e3b 0%, #043e2f 45%, #022c22 100%); min-height: 100vh; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; padding-bottom: 60px;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Top Sub-Header Control Banner -->
    <div style="position: sticky; top: 0; z-index: 100; background: rgba(4, 47, 36, 0.95); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 18px 24px; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
        <div style="width: 100%; max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; box-sizing: border-box;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="<?= URLROOT ?>" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                    <i class="fas fa-arrow-left"></i>
                    <span>হোম পেজ</span>
                </a>
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #38bdf8, #0284c7); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);">
                    <i class="fas fa-hands-praying"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">প্রতিদিনের গুরুত্বপূর্ণ মাসনুন দো'আ</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">নিত্যদিনের প্রয়োজনীয় দো'আ, আরবি পাঠ, উচ্চারণ ও অনুবাদ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 850px; margin: 35px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="display: grid; gap: 18px;" id="masnoonDuaPageContainer">
            <!-- Dynamic Duas -->
        </div>
    </div>
</div>

<script>
    const masnoonDuas = [
        { title: "ঘুম থেকে ওঠার দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَحْيَانَا بَعْدَ مَا أَمَاتَنَا وَإِلَيْهِ النُّشُورُ", bn: "আলহামদুলিল্লা-হিল্লাজী আহইয়া-না-বা'দা মা-অমা-তা-না-ওয়া ইলাইহিন নুশূর।", mean: "সমস্ত প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে মৃত্যুর (ঘুমের) পর জীবিত করলেন এবং তাঁর দিকেই সবার প্রত্যাবর্তন।" },
        { title: "ঘুমানোর সময় পড়ার দো'আ", ar: "بِاسْمِكَ اللَّهُمَّ أَمُوتُ وَأَحْيَا", bn: "বিসমিকা আল্লা-হুম্মা আমূতূ ওয়া আহইয়া।", mean: "হে আল্লাহ! আপনার নাম নিয়েই আমি মৃত্যুবরণ (ঘুম) করছি এবং আপনার নাম নিয়েই জীবিত (জাগ্রত) হচ্ছি।" },
        { title: "ঘর থেকে বের হওয়ার দো'আ", ar: "بِسْمِ اللَّهِ تَوَكَّلْتُ عَلَى اللَّهِ وَلَا حَوْلَ وَلَا قُوَّةَ إِلَّا بِاللَّهِ", bn: "বিসমিল্লা-হি তাওয়াক্কালতু 'আলাল্লা-হি ওয়া লা- হাওলা ওয়া লা- কুওয়াতা ইল্লা- বিল্লাহ।", mean: "আল্লাহর নামে বের হচ্ছি, আল্লাহর উপর ভরসা করলাম। আল্লাহর সাহায্য ছাড়া পাপ থেকে বাঁচার এবং সৎকাজ করার কোনো শক্তি নেই।" },
        { title: "ঘরে প্রবেশ করার দো'আ", ar: "بِسْمِ اللَّهِ وَلَجْنَا، وَبِسْمِ اللَّهِ خَرَجْنَا، وَعَلَى اللَّهِ رَبِّنَا تَوَكَّلْنَا", bn: "বিসমিল্লা-হি ওয়ালাজনা- ওয়া বিসমিল্লা-হি খরাজনা- ওয়া 'আলাল্লা-হি রব্বিনা- তাওয়াক্কালনা-।", mean: "আল্লাহর নামে প্রবেশ করলাম, আল্লাহর নামে বের হলাম এবং আমাদের প্রতিপালক আল্লাহর উপরই ভরসা করলাম।" },
        { title: "মসজিদে প্রবেশের দো'আ", ar: "اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ", bn: "আল্লাহুম্মাফতাহ্‌ লী আবওয়া-বা রহমাতিক।", mean: "হে আল্লাহ! আমার জন্য আপনার রহমতের দরজাগুলো উন্মুক্ত করে দিন।" },
        { title: "মসজিদ থেকে বের হওয়ার দো'আ", ar: "اللَّهُمَّ إِنِّي أَسْأَلُكَ مِنْ فَضْلِكَ", bn: "আল্লাহুম্মা ইন্নী আসআলুকা মিন ফাদলিক।", mean: "হে আল্লাহ! আমি আপনার কাছে আপনার অনুগ্রহ প্রার্থনা করছি।" },
        { title: "খাবারের শুরুর দো'আ", ar: "بِسْمِ اللَّهِ وَعَلَى بَرَكَةِ اللَّهِ", bn: "বিসমিল্লা-হি ওয়া 'আলা- বারাকাতিল্লাহ।", mean: "আল্লাহর নামে এবং আল্লাহর বরকতের উপর শুরু করছি।" },
        { title: "খাবার শেষের দো'আ", ar: "الْحَمْدُ لِلَّهِ الَّذِي أَطْعَمَنَا وَسَقَانَا وَجَعَلَنَا مِنَ الْمُسْلِمِينَ", bn: "আলহামদুলিল্লা-হিল্লাজী আত্ম'ামানা- ওয়া সকা-না- ওয়া জা'আলানা- মিনাল মুসলিমীন।", mean: "সমস্ত প্রশংসা আল্লাহর জন্য, যিনি আমাদেরকে আহার করালেন, পান করালেন এবং মুসলমানদের অন্তর্ভুক্ত করলেন।" }
    ];

    function renderMasnoonDuaPage() {
        const container = document.getElementById('masnoonDuaPageContainer');
        if (!container) return;
        
        container.innerHTML = masnoonDuas.map((item, idx) => `
            <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 20px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div style="font-size: 1.15rem; font-weight: 800; color: #fef08a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <span style="background: #10b981; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">${idx + 1}</span>
                    <span>${item.title}</span>
                </div>
                
                <div style="font-family: 'Amiri', serif; font-size: 1.4rem; color: #6ee7b7; direction: rtl; text-align: right; line-height: 2; margin-bottom: 12px; background: rgba(0,0,0,0.2); padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    ${item.ar}
                </div>

                <div style="font-size: 0.98rem; color: #ffffff; font-weight: 600; line-height: 1.7; margin-bottom: 6px;">
                    <strong style="color: #f59e0b;">উচ্চারণ:</strong> ${item.bn}
                </div>
                <div style="font-size: 0.95rem; color: #d1fae5; line-height: 1.6;">
                    <strong style="color: #38bdf8;">অর্থ:</strong> ${item.mean}
                </div>
            </div>
        `).join('');
    }

    renderMasnoonDuaPage();
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
