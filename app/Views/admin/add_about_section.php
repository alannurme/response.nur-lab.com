<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.ab-form-card {
    max-width: 800px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.ab-form-title {
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
.ab-form-field {
    margin-bottom: 22px;
}
.ab-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.ab-form-field input, .ab-form-field textarea {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.ab-form-field input:focus, .ab-form-field textarea:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 800px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/about_sections" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল সেকশন তালিকায় ফিরুন
    </a>
</div>

<div class="ab-form-card">
    <div class="ab-form-title">
        <div style="width: 44px; height: 44px; background: #ecfdf5; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">নতুন প্রত্যয় ও উদ্দেশ্য সেকশন</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">হোমপেজে দেখানোর জন্য উপ-শিরোনাম, শিরোনাম ও বিবরণ দিন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_about_section" method="POST">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="ab-form-field">
                <label>উপ-শিরোনাম (Subtitle) <span style="color:#ef4444">*</span></label>
                <input type="text" name="subtitle" class="form-control" placeholder="যেমন: আমাদের প্রত্যয়" required>
            </div>
            <div class="ab-form-field">
                <label>প্রধান শিরোনাম (Title) <span style="color:#ef4444">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="যেমন: সত্য ও ন্যায়ের বার্তা" required>
            </div>
        </div>

        <div class="ab-form-field">
            <label>হাইলাইট শিরোনাম (Highlight Title - সবুজ/রঙিন) <span style="color:#ef4444">*</span></label>
            <input type="text" name="highlight_title" class="form-control" placeholder="যেমন: আমাদের লক্ষ্য ও উদ্দেশ্য" required>
        </div>

        <div class="ab-form-field">
            <label>সেকশন ব্যানার ছবি <span style="color:#ef4444">*</span></label>
            <div style="display: flex; gap: 16px; align-items: flex-start; flex-wrap: wrap;">
                <img id="about_preview" src="" style="width: 160px; height: 95px; object-fit: cover; border-radius: 10px; display: none; border: 2px solid #0b7c4d; box-shadow: 0 4px 10px rgba(0,0,0,0.08);" loading="lazy" decoding="async">
                <div style="flex: 1; min-width: 250px;">
                    <input type="text" id="about_image_path" name="image" class="form-control" required readonly placeholder="মিডিয়া লাইব্রেরি থেকে ইমেজ সিলেক্ট করুন" style="margin-bottom: 8px;">
                    <button type="button" class="btn btn-secondary w-100" style="border-radius: 10px; padding: 10px 14px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" onclick="openMediaPicker('about_image_path', 'about_preview')">
                        <i class="fas fa-image" style="color: #0b7c4d;"></i> মিডিয়া লাইব্রেরি থেকে ছবি পছন্দ করুন
                    </button>
                </div>
            </div>
        </div>

        <div class="ab-form-field">
            <label>বিস্তারিত বিবরণ (Description) <span style="color:#ef4444">*</span></label>
            <textarea name="description" class="form-control" rows="6" placeholder="সেকশনের বিস্তারিত বিবরণী লিখুন..." required></textarea>
        </div>

        <div class="ab-form-field">
            <label>প্রদর্শনের ক্রম (Order Index)</label>
            <input type="number" name="order_index" value="0" class="form-control" required>
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)</small>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #0b7c4d; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-check-circle"></i> সেকশন সংরক্ষণ করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
