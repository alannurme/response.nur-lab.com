<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Theme Settings</h1>
        <p>Configure and preview your website's active visual theme style</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success"><?= $data['success'] ?></div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;"><?= $data['error'] ?></div>
<?php endif; ?>

<div class="theme-settings-layout" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    <!-- Left Column: Controls -->
    <div class="settings-container">
        <form action="<?= URLROOT ?>/admin/theme" method="POST">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px; color: var(--text-main);">Choose Home Page Theme</label>
                    <select id="themeSelector" name="settings[home_theme]" class="form-control" style="padding: 12px 18px; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 1.05rem;">
                        <option value="light" <?= ($data['settings']['home_theme'] ?? 'light') == 'light' ? 'selected' : '' ?>>সোনার আলো থিম (লাইট - Light Golden Theme)</option>
                        <option value="dark" <?= ($data['settings']['home_theme'] ?? '') == 'dark' ? 'selected' : '' ?>>রাজকীয় ডার্ক থিম (ডার্ক - Royal Premium Dark Theme)</option>
                        <option value="emerald" <?= ($data['settings']['home_theme'] ?? '') == 'emerald' ? 'selected' : '' ?>>মরু সবুজ ও সোনালী সুফি থিম (এমারেল্ড - Emerald Sufi Theme)</option>
                        <option value="minimal" <?= ($data['settings']['home_theme'] ?? '') == 'minimal' ? 'selected' : '' ?>>মিডনাইট মিনিমালিস্ট থিম (মিনিমাল - Midnight Minimalist Theme)</option>
                        <option value="velvet" <?= ($data['settings']['home_theme'] ?? '') == 'velvet' ? 'selected' : '' ?>>রয়্যাল মখমল থিম (ভেলভেট - Ruby Velvet Rose Gold Theme)</option>
                        <option value="oasis" <?= ($data['settings']['home_theme'] ?? '') == 'oasis' ? 'selected' : '' ?>>মরূদ্যান শান্তি থিম (মরূদ্যান - Teal Oasis Desert Peace Theme)</option>
                    </select>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 15px; line-height: 1.6; text-align: justify;">
                        Select the theme style to be applied to the public homepage. The "Golden Light" theme features elegant light backgrounds with golden borders and blue highlights. The "Royal Dark" theme features premium deep dark background gradients with yellow gold highlights. The "Emerald Sufi" theme features a beautiful deep spiritual emerald green background with warm amber-gold highlights. The "Midnight Minimalist" theme features clean, sleek typography, lots of whitespace, and thin dividers. The "Ruby Velvet" theme is a luxurious crimson velvet theme with warm rose-gold borders and soft highlights. The "Teal Oasis" theme features a calming deep teal and mint gradient background with sandy gold highlights representing tranquility and peace.
                    </p>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 30px; text-align: left; border-top: 1px solid #edf2f7; padding-top: 20px;">
                <button type="submit" class="btn-save" style="background: var(--primary); color: white; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 10px 20px var(--primary-glow); transition: 0.3s; font-size: 1rem;">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Save Theme Setting
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Live Interactive Preview -->
    <div class="preview-container" style="background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #edf2f7; display: flex; flex-direction: column; gap: 20px;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-eye" style="color: var(--primary);"></i> Live Theme Preview
        </h3>
        
        <!-- Interactive Preview Box mimicking homepage structure -->
        <div id="liveThemePreview" class="live-theme-preview-box">
            <!-- Mini Header/Nav -->
            <div class="mini-nav">
                <div class="mini-logo"><i class="fas fa-mosque"></i> NUR LAB</div>
                <div class="mini-menu">
                    <span>হোম</span>
                    <span>ব্লগ</span>
                    <span>প্রশ্নোত্তর</span>
                </div>
                <div class="mini-btn">যোগাযোগ</div>
            </div>

            <!-- Mini Hero Bento & Questions Bento Grid -->
            <div class="mini-bento-grid">
                <!-- Mini Hero -->
                <div class="mini-bento-item mini-hero">
                    <div class="mini-hero-overlay">
                        <span class="mini-tag">ইসলামিক প্রবন্ধ</span>
                        <h4>রমজানের গুরুত্ব ও ফজিলত</h4>
                        <div class="mini-hero-btn">পড়ুন</div>
                    </div>
                </div>
                <!-- Mini Questions -->
                <div class="mini-bento-item mini-questions">
                    <h5>? সাম্প্রতিক প্রশ্ন</h5>
                    <div class="mini-q-row">ইসলামে যাকাতের বিধান কি? <span>&rarr;</span></div>
                    <div class="mini-q-row">তাহাজ্জুদ নামাজের নিয়ম কি? <span>&rarr;</span></div>
                    <div class="mini-ask-btn"><i class="fas fa-question-circle"></i> প্রশ্ন করুন</div>
                </div>
            </div>

            <!-- Mini Blog Cards Row -->
            <div class="mini-cards-section">
                <p class="section-lbl">সাম্প্রতিক লেখাসমূহ</p>
                <div class="mini-cards-grid">
                    <div class="mini-card">
                        <div class="mini-card-img"></div>
                        <div class="mini-card-body">
                            <span class="card-tag">কুরআন ও হাদিস</span>
                            <h6>সূরা আল-ফাতিহার তাফসির</h6>
                            <p class="card-btn">বিস্তারিত পড়ুন &rarr;</p>
                        </div>
                    </div>
                    <div class="mini-card">
                        <div class="mini-card-img"></div>
                        <div class="mini-card-body">
                            <span class="card-tag">ইতিহাস</span>
                            <h6>ইসলামের সোনালী যুগ</h6>
                            <p class="card-btn">বিস্তারিত পড়ুন &rarr;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .settings-container {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
        height: fit-content;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-main);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #eee;
        border-radius: 10px;
        transition: 0.3s;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px var(--primary-light);
    }

    .btn-save:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 15px 30px var(--primary-glow); 
    }

    .alert {
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .alert-success { 
        background: #dcfce7; 
        color: #166534; 
        border: 1px solid #bbf7d0; 
    }

    /* Live Preview Core Styling */
    .live-theme-preview-box {
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 15px;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    /* MINI NAVIGATION BAR */
    .mini-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 15px;
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    .mini-logo {
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 800;
        font-size: 12px;
    }

    .mini-menu {
        display: flex;
        gap: 10px;
        color: inherit;
        font-size: 10px;
    }

    .mini-btn {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        color: white;
    }

    /* MINI BENTO GRID */
    .mini-bento-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 12px;
    }

    .mini-bento-item {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid transparent;
        transition: all 0.4s ease;
    }

    .mini-hero {
        background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.85)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?w=300');
        background-size: cover;
        background-position: center;
        color: white;
        height: 120px;
        display: flex;
        align-items: flex-end;
    }

    .mini-hero-overlay {
        padding: 12px;
        width: 100%;
    }

    .mini-hero-overlay h4 {
        font-size: 12px;
        margin: 4px 0;
        font-weight: 700;
    }

    .mini-tag {
        font-size: 8px;
        font-weight: 700;
        background: rgba(250, 204, 21, 0.2);
        color: #facc15;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }

    .mini-hero-btn {
        display: inline-block;
        font-size: 9px;
        background: #2563eb;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
        margin-top: 4px;
        text-align: center;
    }

    .mini-questions {
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .mini-questions h5 {
        font-size: 11px;
        margin: 0 0 8px 0;
        font-weight: 800;
    }

    .mini-q-row {
        font-size: 9px;
        display: flex;
        justify-content: space-between;
        padding-bottom: 5px;
        border-bottom: 1px solid transparent;
        margin-bottom: 6px;
    }

    .mini-ask-btn {
        font-size: 9px;
        padding: 5px;
        border-radius: 6px;
        text-align: center;
        font-weight: 700;
        color: white;
        cursor: pointer;
    }

    /* MINI BLOG CARDS */
    .mini-cards-section {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .section-lbl {
        font-size: 11px;
        font-weight: 800;
        margin: 0;
    }

    .mini-cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .mini-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid transparent;
        display: flex;
        flex-direction: column;
        transition: all 0.4s ease;
    }

    .mini-card-img {
        height: 60px;
        background: #e2e8f0;
    }

    .mini-card-body {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .card-tag {
        font-size: 7px;
        font-weight: 700;
        align-self: flex-start;
        padding: 1px 5px;
        border-radius: 3px;
    }

    .mini-card-body h6 {
        font-size: 9px;
        margin: 2px 0;
        font-weight: 700;
        line-height: 1.3;
    }

    .card-btn {
        font-size: 8px;
        font-weight: 700;
        margin: 4px 0 0 0;
    }

    /* ----------------------------------------------- */
    /* THEME LIVE COLORS CLASS DEFINITIONS */
    /* ----------------------------------------------- */

    /* 1. LIGHT GOLDEN STATE */
    .preview-light-theme {
        background-color: #f8fafc;
        color: #0f172a;
    }

    .preview-light-theme .mini-nav {
        background: rgba(255, 255, 255, 0.75);
        border-color: rgba(255,255,255,0.2);
        color: #0f172a;
    }

    .preview-light-theme .mini-logo {
        color: #2563eb;
    }

    .preview-light-theme .mini-btn {
        background: #2563eb;
    }

    .preview-light-theme .mini-hero-btn {
        background: #2563eb;
    }

    .preview-light-theme .mini-questions {
        background: #ffffff;
        border-color: #e2e8f0;
        color: #0f172a;
    }

    .preview-light-theme .mini-q-row {
        border-bottom-color: #e2e8f0;
        color: #0f172a;
    }

    .preview-light-theme .mini-q-row span {
        color: #2563eb;
    }

    .preview-light-theme .mini-ask-btn {
        background: #2563eb;
    }

    .preview-light-theme .section-lbl {
        color: #0f172a;
    }

    .preview-light-theme .mini-card {
        background: #ffffff;
        border-color: #e2e8f0;
        color: #0f172a;
    }

    .preview-light-theme .mini-card-img {
        background: #eff6ff;
    }

    .preview-light-theme .card-tag {
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
    }

    .preview-light-theme .card-btn {
        color: #2563eb;
    }

    /* 2. ROYAL DARK STATE */
    .preview-dark-theme {
        background-color: #060b18;
        color: #f0f4ff;
        background-image: radial-gradient(at 0% 0%, rgba(59,130,246,0.08) 0, transparent 50%);
    }

    .preview-dark-theme .mini-nav {
        background: rgba(10, 15, 30, 0.92);
        border-color: rgba(59, 130, 246, 0.15);
        color: #f0f4ff;
    }

    .preview-dark-theme .mini-logo {
        color: #3b82f6;
    }

    .preview-dark-theme .mini-btn {
        background: #3b82f6;
        color: #ffffff;
    }

    .preview-dark-theme .mini-hero-btn {
        background: #3b82f6;
        color: #ffffff;
    }

    .preview-dark-theme .mini-questions {
        background: #0d1526;
        border-color: rgba(59, 130, 246, 0.12);
        color: #f0f4ff;
    }

    .preview-dark-theme .mini-q-row {
        border-bottom-color: rgba(59, 130, 246, 0.12);
        color: #f0f4ff;
    }

    .preview-dark-theme .mini-q-row span {
        color: #60a5fa;
    }

    .preview-dark-theme .mini-ask-btn {
        background: #3b82f6;
        color: #ffffff;
    }

    .preview-dark-theme .section-lbl {
        color: #f0f4ff;
    }

    .preview-dark-theme .mini-card {
        background: #0d1526;
        border-color: rgba(59, 130, 246, 0.12);
        color: #f0f4ff;
    }

    .preview-dark-theme .mini-card-img {
        background: #0a0f1e;
    }

    .preview-dark-theme .card-tag {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .preview-dark-theme .card-btn {
        color: #60a5fa;
    }

    /* 3. EMERALD SUFI STATE */
    .preview-emerald-theme {
        background-color: #022c22;
        color: #f0fdf4;
        background-image: radial-gradient(at 0% 0%, rgba(245,158,11,0.04) 0, transparent 50%);
    }

    .preview-emerald-theme .mini-nav {
        background: rgba(6, 78, 59, 0.9);
        border-color: rgba(16, 185, 129, 0.12);
        color: #f0fdf4;
    }

    .preview-emerald-theme .mini-logo {
        color: #10b981;
    }

    .preview-emerald-theme .mini-btn {
        background: #10b981;
        color: #ffffff;
    }

    .preview-emerald-theme .mini-hero-btn {
        background: #10b981;
        color: #ffffff;
    }

    .preview-emerald-theme .mini-questions {
        background: #064e3b;
        border-color: rgba(16, 185, 129, 0.18);
        color: #f0fdf4;
    }

    .preview-emerald-theme .mini-q-row {
        border-bottom-color: rgba(16, 185, 129, 0.18);
        color: #f0fdf4;
    }

    .preview-emerald-theme .mini-q-row span {
        color: #10b981;
    }

    .preview-emerald-theme .mini-ask-btn {
        background: #10b981;
        color: #ffffff;
    }

    .preview-emerald-theme .section-lbl {
        color: #f0fdf4;
    }

    .preview-emerald-theme .mini-card {
        background: #064e3b;
        border-color: rgba(16, 185, 129, 0.18);
        color: #f0fdf4;
    }

    .preview-emerald-theme .mini-card-img {
        background: #022c22;
    }

    .preview-emerald-theme .card-tag {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.18);
    }

    .preview-emerald-theme .card-btn {
        color: #f59e0b;
    }

    /* 4. MIDNIGHT MINIMALIST STATE */
    .preview-minimal-theme {
        background-color: #ffffff;
        color: #0f172a;
    }

    .preview-minimal-theme .mini-nav {
        background: #ffffff;
        border-color: #e2e8f0;
        color: #0f172a;
    }

    .preview-minimal-theme .mini-logo {
        color: #0f172a;
        font-family: 'Outfit', sans-serif;
    }

    .preview-minimal-theme .mini-btn {
        background: #0f172a;
        color: #ffffff;
        border-radius: 0px;
    }

    .preview-minimal-theme .mini-hero-btn {
        background: #0f172a;
        color: #ffffff;
        border-radius: 0px;
    }

    .preview-minimal-theme .mini-questions {
        background: #ffffff;
        border-color: #e2e8f0;
        color: #0f172a;
        border-radius: 0px;
    }

    .preview-minimal-theme .mini-q-row {
        border-bottom-color: #e2e8f0;
        color: #0f172a;
    }

    .preview-minimal-theme .mini-q-row span {
        color: #0f172a;
    }

    .preview-minimal-theme .mini-ask-btn {
        background: #0f172a;
        color: #ffffff;
        border-radius: 0px;
    }

    .preview-minimal-theme .section-lbl {
        color: #0f172a;
    }

    .preview-minimal-theme .mini-card {
        background: #ffffff;
        border-color: #e2e8f0;
        color: #0f172a;
        border-radius: 0px;
    }

    .preview-minimal-theme .mini-card-img {
        background: #f1f5f9;
    }

    .preview-minimal-theme .card-tag {
        background: #f1f5f9;
        color: #475569;
        border-radius: 0px;
    }

    .preview-minimal-theme .card-btn {
        color: #0f172a;
        text-decoration: underline;
    }

    /* 5. RUBY VELVET STATE */
    .preview-velvet-theme {
        background-color: #1c050a;
        color: #ffe4e6;
        background-image: radial-gradient(at 0% 0%, rgba(244,63,94,0.05) 0, transparent 50%);
    }

    .preview-velvet-theme .mini-nav {
        background: rgba(46, 8, 19, 0.9);
        border-color: rgba(244, 63, 94, 0.15);
        color: #ffe4e6;
    }

    .preview-velvet-theme .mini-logo {
        color: #e11d48;
    }

    .preview-velvet-theme .mini-btn {
        background: #e11d48;
        color: #ffffff;
    }

    .preview-velvet-theme .mini-hero-btn {
        background: #e11d48;
        color: #ffffff;
    }

    .preview-velvet-theme .mini-questions {
        background: #2e0813;
        border-color: rgba(244, 63, 94, 0.2);
        color: #ffe4e6;
    }

    .preview-velvet-theme .mini-q-row {
        border-bottom-color: rgba(244, 63, 94, 0.2);
        color: #ffe4e6;
    }

    .preview-velvet-theme .mini-q-row span {
        color: #f43f5e;
    }

    .preview-velvet-theme .mini-ask-btn {
        background: #e11d48;
        color: #ffffff;
    }

    .preview-velvet-theme .section-lbl {
        color: #ffe4e6;
    }

    .preview-velvet-theme .mini-card {
        background: #2e0813;
        border-color: rgba(244, 63, 94, 0.2);
        color: #ffe4e6;
    }

    .preview-velvet-theme .mini-card-img {
        background: #1c050a;
    }

    .preview-velvet-theme .card-tag {
        background: rgba(244, 63, 94, 0.12);
        color: #f43f5e;
        border: 1px solid rgba(244, 63, 94, 0.2);
    }

    .preview-velvet-theme .card-btn {
        color: #f43f5e;
    }

    /* 6. TEAL OASIS STATE */
    .preview-oasis-theme {
        background-color: #032b26;
        color: #ccfbf1;
        background-image: radial-gradient(at 0% 0%, rgba(234,179,8,0.05) 0, transparent 50%);
    }

    .preview-oasis-theme .mini-nav {
        background: rgba(6, 78, 72, 0.9);
        border-color: rgba(20, 184, 166, 0.15);
        color: #ccfbf1;
    }

    .preview-oasis-theme .mini-logo {
        color: #0d9488;
    }

    .preview-oasis-theme .mini-btn {
        background: #0d9488;
        color: #ffffff;
    }

    .preview-oasis-theme .mini-hero-btn {
        background: #0d9488;
        color: #ffffff;
    }

    .preview-oasis-theme .mini-questions {
        background: #064e48;
        border-color: rgba(20, 184, 166, 0.2);
        color: #ccfbf1;
    }

    .preview-oasis-theme .mini-q-row {
        border-bottom-color: rgba(20, 184, 166, 0.2);
        color: #ccfbf1;
    }

    .preview-oasis-theme .mini-q-row span {
        color: #eab308;
    }

    .preview-oasis-theme .mini-ask-btn {
        background: #0d9488;
        color: #ffffff;
    }

    .preview-oasis-theme .section-lbl {
        color: #ccfbf1;
    }

    .preview-oasis-theme .mini-card {
        background: #064e48;
        border-color: rgba(20, 184, 166, 0.2);
        color: #ccfbf1;
    }

    .preview-oasis-theme .mini-card-img {
        background: #032b26;
    }

    .preview-oasis-theme .card-tag {
        background: rgba(20, 184, 166, 0.12);
        color: #5eead4;
        border: 1px solid rgba(20, 184, 166, 0.2);
    }

    .preview-oasis-theme .card-btn {
        color: #eab308;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selector = document.getElementById('themeSelector');
    const previewBox = document.getElementById('liveThemePreview');

    function updatePreview() {
        const theme = selector.value;
        previewBox.classList.remove('preview-light-theme', 'preview-dark-theme', 'preview-emerald-theme', 'preview-minimal-theme', 'preview-velvet-theme', 'preview-oasis-theme');
        if (theme === 'dark') {
            previewBox.classList.add('preview-dark-theme');
        } else if (theme === 'emerald') {
            previewBox.classList.add('preview-emerald-theme');
        } else if (theme === 'minimal') {
            previewBox.classList.add('preview-minimal-theme');
        } else if (theme === 'velvet') {
            previewBox.classList.add('preview-velvet-theme');
        } else if (theme === 'oasis') {
            previewBox.classList.add('preview-oasis-theme');
        } else {
            previewBox.classList.add('preview-light-theme');
        }
    }

    // Initialize and bind change listener
    updatePreview();
    selector.addEventListener('change', updatePreview);
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
