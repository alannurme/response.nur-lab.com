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

            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">বাংলা তারিখ দেখাবেন? (Show Bengali Date Badge)</label>
                <select name="settings[show_hero_date]" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
                    <option value="1" <?= ($data['settings']['show_hero_date'] ?? '0') == '1' ? 'selected' : '' ?>>হ্যাঁ (Show)</option>
                    <option value="0" <?= ($data['settings']['show_hero_date'] ?? '0') == '0' ? 'selected' : '' ?>>না (Hide)</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">সার্চ বার দেখাবেন? (Show Search Bar)</label>
                <select name="settings[show_hero_search]" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
                    <option value="1" <?= ($data['settings']['show_hero_search'] ?? '0') == '1' ? 'selected' : '' ?>>হ্যাঁ (Show)</option>
                    <option value="0" <?= ($data['settings']['show_hero_search'] ?? '0') == '0' ? 'selected' : '' ?>>না (Hide)</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">কাস্টম বাটন পাঠ্য (Button Text)</label>
                <input type="text" name="settings[hero_btn_text]" value="<?= htmlspecialchars($data['settings']['hero_btn_text'] ?? '') ?>" class="form-control" placeholder="যেমন: প্রশ্ন করুন" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
                <small style="color: #64748b; font-size: 0.85rem; margin-top: 4px; display: block;">ফাঁকা রাখলে কাস্টম বাটন দেখাবে না।</small>
            </div>

            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block;">কাস্টম বাটন লিংক (Button Link)</label>
                <input type="text" name="settings[hero_btn_link]" value="<?= htmlspecialchars($data['settings']['hero_btn_link'] ?? '') ?>" class="form-control" placeholder="যেমন: /ask বা https://..." style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem;">
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
