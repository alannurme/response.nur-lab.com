<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.soc-form-card {
    max-width: 650px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.soc-form-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 16px;
}
.soc-form-field {
    margin-bottom: 22px;
}
.soc-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.soc-form-field input {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.soc-form-field input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
.icon-picker-item {
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: 0.2s;
    background: #f8fafc;
}
.icon-picker-item:hover {
    transform: translateY(-2px);
    border-color: #0b7c4d;
}
</style>

<div style="max-width: 650px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/social_links" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল সোশ্যাল লিংক তালিকায় ফিরুন
    </a>
</div>

<div class="soc-form-card">
    <div class="soc-form-title">
        <div style="width: 44px; height: 44px; background: #ecfdf5; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-share-alt"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">নতুন সোশ্যাল মিডিয়া যোগ করুন</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">টপবার বা ফুটারে দেখানোর জন্য সোশ্যাল প্ল্যাটফর্মের তথ্য দিন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_social_link" method="POST">
        <?= csrf_field() ?>

        <div class="soc-form-field">
            <label>প্ল্যাটফর্মের নাম <span style="color:#ef4444">*</span></label>
            <input type="text" name="name" id="social-name-input" class="form-control" placeholder="যেমন: Facebook, YouTube, Telegram" required>
        </div>

        <div class="soc-form-field">
            <label>আইকন নির্বাচন করুন (Icon Picker)</label>
            <div class="icon-picker-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-bottom: 14px;">
                <?php
                $presets = [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'color' => '#1877F2'],
                    ['icon' => 'fab fa-twitter', 'name' => 'Twitter/X', 'color' => '#1DA1F2'],
                    ['icon' => 'fab fa-youtube', 'name' => 'YouTube', 'color' => '#FF0000'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'color' => '#E4405F'],
                    ['icon' => 'fab fa-tiktok', 'name' => 'TikTok', 'color' => '#010101'],
                    ['icon' => 'fab fa-whatsapp', 'name' => 'WhatsApp', 'color' => '#25D366'],
                    ['icon' => 'fab fa-telegram', 'name' => 'Telegram', 'color' => '#0088cc'],
                    ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'color' => '#0077B5'],
                    ['icon' => 'fab fa-pinterest', 'name' => 'Pinterest', 'color' => '#BD081C'],
                    ['icon' => 'fab fa-reddit-alien', 'name' => 'Reddit', 'color' => '#FF4500'],
                    ['icon' => 'fab fa-snapchat', 'name' => 'Snapchat', 'color' => '#FFFC00'],
                    ['icon' => 'fas fa-globe', 'name' => 'Website', 'color' => '#64748b']
                ];
                foreach ($presets as $p):
                    $icon_val = $p['icon'];
                ?>
                    <div class="icon-picker-item" data-icon="<?= $icon_val ?>" data-name="<?= $p['name'] ?>" title="<?= $p['name'] ?>">
                        <i class="<?= $icon_val ?>" style="font-size: 1.35rem; color: <?= $p['color'] ?>;"></i>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <label style="font-size: 0.88rem; color: #475569;">ফন্টঅসাম আইকন ক্লাস (Icon Class)</label>
            <input type="text" name="icon" id="icon-input" class="form-control" placeholder="যেমন: fab fa-facebook-f" required>
            <small style="color: #64748b; margin-top: 5px; display: block; font-size: 0.82rem;">উপরে ক্লিক করলে অটো-পূরণ হবে অথবা যেকোনো কাস্টম FontAwesome আইকন ক্লাস লিখুন।</small>
        </div>

        <div class="soc-form-field">
            <label>প্রোফাইল বা পেজ লিংক URL <span style="color:#ef4444">*</span></label>
            <input type="text" name="url" class="form-control" placeholder="https://facebook.com/yourpage" required>
        </div>

        <div class="soc-form-field">
            <label>প্রদর্শনের ক্রম (Order Index)</label>
            <input type="number" name="order_index" value="0" class="form-control">
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)</small>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #0b7c4d; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-check-circle"></i> সোশ্যাল লিংক সংরক্ষণ করুন
        </button>
    </form>
</div>

<script>
document.querySelectorAll('.icon-picker-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.icon-picker-item').forEach(i => {
            i.style.borderColor = '#cbd5e1';
            i.style.background = '#f8fafc';
            i.style.boxShadow = 'none';
        });
        
        this.style.borderColor = '#0b7c4d';
        this.style.background = '#ecfdf5';
        this.style.boxShadow = '0 0 0 3px rgba(11, 124, 77, 0.15)';
        
        const icon = this.getAttribute('data-icon');
        const name = this.getAttribute('data-name');
        
        document.getElementById('icon-input').value = icon;
        const nameInput = document.getElementById('social-name-input');
        if (!nameInput.value || nameInput.value === '') {
            nameInput.value = name;
        }
    });
});
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
