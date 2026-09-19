<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow"><i class="fas fa-desktop"></i> Hero Section Settings</h1>
        <p>হোম পেজের হিরো সেকশন এবং এর উপাদানগুলো নিয়ন্ত্রণ করুন</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success" style="background: #dcfce7; color: #15803d; border: 1px solid #86efac; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
        <?= $data['success'] ?>
    </div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
        <?= $data['error'] ?>
    </div>
<?php endif; ?>

<div class="settings-container" style="background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    <form action="<?= URLROOT ?>/admin/hero_section" method="POST">
        <div class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            
            <div class="form-group full-width" style="grid-column: 1 / -1;">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">হিরো সেকশন স্ট্যাটাস (Show Hero Section)</label>
                <select name="settings[show_hero_section]" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
                    <option value="1" <?= ($data['settings']['show_hero_section'] ?? '1') == '1' ? 'selected' : '' ?>>সক্রিয় (Enabled)</option>
                    <option value="0" <?= ($data['settings']['show_hero_section'] ?? '1') == '0' ? 'selected' : '' ?>>নিষ্ক্রিয় (Disabled)</option>
                </select>
            </div>

            <div class="form-group full-width" style="grid-column: 1 / -1;">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">হিরো টাইটেল (Main Title)</label>
                <input type="text" name="settings[hero_title]" value="<?= htmlspecialchars($data['settings']['hero_title'] ?? ($data['settings']['site_title'] ?? 'রেসপন্স উইথ নূর-ল্যাব')) ?>" class="form-control" placeholder="যেমন: রেসপন্স উইথ নূর-ল্যাব" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
            </div>

            <div class="form-group full-width" style="grid-column: 1 / -1;">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">ট্যাগলাইন / সাবটাইটেল (Subtitle)</label>
                <textarea name="settings[hero_subtitle]" class="form-control" rows="3" placeholder="হিরো সেকশনের সাবটাইটেল লিখুন..." style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem; line-height: 1.6;"><?= htmlspecialchars($data['settings']['hero_subtitle'] ?? '') ?></textarea>
                <small style="color: #64748b; font-size: 0.85rem; margin-top: 4px; display: block;">ফাঁকা রাখলে সাবটাইটেল দেখাবে না।</small>
            </div>



            <!-- Feature Pills / Badges Settings -->
            <div class="form-group full-width" style="grid-column: 1 / -1; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 10px;">
                <h4 style="margin: 0 0 15px 0; color: #0b7c4d; font-weight: 800;"><i class="fas fa-tags"></i> কুইক ফিচার ব্যাজসমূহ (Hero Quick Feature Pills)</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">ফিচার ১ (যেমন: কুরআন ও হাদীস)</label>
                        <input type="text" name="settings[hero_pill_1]" value="<?= htmlspecialchars($data['settings']['hero_pill_1'] ?? 'কুরআন ও সুন্নাহ ভিত্তিক') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">ফিচার ২ (যেমন: বিশ্বস্ত ফতোয়া)</label>
                        <input type="text" name="settings[hero_pill_2]" value="<?= htmlspecialchars($data['settings']['hero_pill_2'] ?? 'বিশ্বস্ত ফতোয়া ও সমাধান') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">ফিচার ৩ (যেমন: দ্রুত উত্তর)</label>
                        <input type="text" name="settings[hero_pill_3]" value="<?= htmlspecialchars($data['settings']['hero_pill_3'] ?? 'সরাসরি প্রশ্ন পাঠানোর সুযোগ') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                </div>
            </div>

            <!-- Quran Ayah / Hadith Card Settings -->
            <div class="form-group full-width" style="grid-column: 1 / -1; background: #ecfdf5; padding: 20px; border-radius: 12px; border: 1px solid #a7f3d0; margin-top: 10px;">
                <h4 style="margin: 0 0 15px 0; color: #047857; font-weight: 800;"><i class="fas fa-quran"></i> ইসলামিক বাণী / আয়াত কালাম (Hero Quran Ayah / Quote)</h4>
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #064e3b;">আরবি আয়াত / হাদীস (Arabic Text)</label>
                        <input type="text" name="settings[hero_ayah_arabic]" value="<?= htmlspecialchars($data['settings']['hero_ayah_arabic'] ?? 'فَاسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ') ?>" class="form-control" placeholder="যেমন: فَاسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #a7f3d0; font-family: 'Amiri', 'Meaney', serif; font-size: 1.1rem; text-align: right;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #064e3b;">বাংলা অর্থ / অনুবাদ (Translation)</label>
                        <input type="text" name="settings[hero_ayah_bn]" value="<?= htmlspecialchars($data['settings']['hero_ayah_bn'] ?? 'অতএব জ্ঞানীদের জিজ্ঞেস করো, যদি তোমরা না জানো।') ?>" class="form-control" placeholder="যেমন: অতএব জ্ঞানীদের জিজ্ঞেস করো, যদি তোমরা না জানো।" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #a7f3d0;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #064e3b;">রেফারেন্স (Source Reference)</label>
                        <input type="text" name="settings[hero_ayah_ref]" value="<?= htmlspecialchars($data['settings']['hero_ayah_ref'] ?? 'সূরা আন-নহল: ৪৩') ?>" class="form-control" placeholder="যেমন: সূরা আন-নহল: ৪৩" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #a7f3d0;">
                    </div>
                </div>
            </div>

            <!-- Audio Player Settings -->
            <div class="form-group full-width" style="grid-column: 1 / -1; background: #f0fdf4; padding: 20px; border-radius: 12px; border: 1px solid #bbf7d0; margin-top: 10px;">
                <h4 style="margin: 0 0 15px 0; color: #166534; font-weight: 800;"><i class="fas fa-music"></i> ব্যাকগ্রাউন্ড অডিও প্লেয়ার (Hero Background Audio/Recitation Player)</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #166534;">ইউটিউব অডিও/ভিডিও লিংক (YouTube Link)</label>
                        <input type="text" name="settings[hero_audio_youtube_url]" value="<?= htmlspecialchars($data['settings']['hero_audio_youtube_url'] ?? '') ?>" class="form-control" placeholder="যেমন: https://www.youtube.com/watch?v=..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <small style="color: #64748b; font-size: 0.8rem; margin-top: 4px; display: block;">কুরআন তিলাওয়াত বা ইসলামিক অডিওর ইউটিউব লিংক দিন। ফাঁকা রাখলে প্লেয়ার দেখাবে না।</small>
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #166534;">প্লেয়ার টাইটেল / বিবরণ (Audio Label)</label>
                        <input type="text" name="settings[hero_audio_label]" value="<?= htmlspecialchars($data['settings']['hero_audio_label'] ?? 'কুরআন তিলাওয়াত (Surah Al-Kahf)') ?>" class="form-control" placeholder="যেমন: সূরা আর-রহমান তিলাওয়াত" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #166534;">অটো-প্লে সক্রিয় করবেন? (Auto Play)</label>
                        <select name="settings[hero_audio_autoplay]" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            <option value="1" <?= ($data['settings']['hero_audio_autoplay'] ?? '1') == '1' ? 'selected' : '' ?>>হ্যাঁ (Autoplay Enabled)</option>
                            <option value="0" <?= ($data['settings']['hero_audio_autoplay'] ?? '1') == '0' ? 'selected' : '' ?>>না (Manual Click)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats Counters Settings -->
            <div class="form-group full-width" style="grid-column: 1 / -1; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 10px;">
                <h4 style="margin: 0 0 15px 0; color: #0b7c4d; font-weight: 800;"><i class="fas fa-chart-line"></i> কুইক পরিসংখ্যান / স্ট্যাটস (Quick Islamic Statistics)</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">সংখ্যা ১ (যেমন: ১০০০+)</label>
                        <input type="text" name="settings[hero_stat_num_1]" value="<?= htmlspecialchars($data['settings']['hero_stat_num_1'] ?? '১,৫০০+') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <input type="text" name="settings[hero_stat_lbl_1]" value="<?= htmlspecialchars($data['settings']['hero_stat_lbl_1'] ?? 'ফতোয়া ও মাসআলা') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px;" placeholder="লেবেল">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">সংখ্যা ২ (যেমন: ৫০,০০০+)</label>
                        <input type="text" name="settings[hero_stat_num_2]" value="<?= htmlspecialchars($data['settings']['hero_stat_num_2'] ?? '৫০,০০০+') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <input type="text" name="settings[hero_stat_lbl_2]" value="<?= htmlspecialchars($data['settings']['hero_stat_lbl_2'] ?? 'নিয়মিত পাঠকমণ্ডলী') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px;" placeholder="লেবেল">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">সংখ্যা ৩ (যেমন: ১০০%)</label>
                        <input type="text" name="settings[hero_stat_num_3]" value="<?= htmlspecialchars($data['settings']['hero_stat_num_3'] ?? '১০০%') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <input type="text" name="settings[hero_stat_lbl_3]" value="<?= htmlspecialchars($data['settings']['hero_stat_lbl_3'] ?? 'সহিহ উৎস ও দলিল') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px;" placeholder="লেবেল">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.88rem; color: #334155;">সংখ্যা ৪ (যেমন: ২৪/৭)</label>
                        <input type="text" name="settings[hero_stat_num_4]" value="<?= htmlspecialchars($data['settings']['hero_stat_num_4'] ?? '২৪/৭') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <input type="text" name="settings[hero_stat_lbl_4]" value="<?= htmlspecialchars($data['settings']['hero_stat_lbl_4'] ?? 'অনলাইন সাপোর্ট') ?>" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 5px;" placeholder="লেবেল">
                    </div>
                </div>
            </div>

        </div>

        <div class="form-actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #0b7c4d, #10b981); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.3);">
                <i class="fas fa-save" style="margin-right: 8px;"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
