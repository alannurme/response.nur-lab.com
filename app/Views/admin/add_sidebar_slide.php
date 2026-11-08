<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.sslide-form-card {
    max-width: 700px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.sslide-form-title {
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
.sslide-form-field {
    margin-bottom: 22px;
}
.sslide-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.sslide-form-field input {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.sslide-form-field input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 700px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/sidebar_slides" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল সাইডবার স্লাইড তালিকায় ফিরুন
    </a>
</div>

<div class="sslide-form-card">
    <div class="sslide-form-title">
        <div style="width: 44px; height: 44px; background: #ecfdf5; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-columns"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">নতুন সাইডবার ব্যানার যোগ করুন</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">ব্লগ পোস্টের সাইডবারে প্রদর্শনের জন্য ১:১ স্কয়ার ছবি যুক্ত করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_sidebar_slide" method="POST">
        <?= csrf_field() ?>

        <div class="sslide-form-field">
            <label>
                সাইডবার ইমেজ (১:১ অনুপাত স্কয়ার) <span style="color:#ef4444">*</span>
                <span style="font-weight: normal; font-size: 0.82rem; color: #64748b; margin-left: 6px;">(প্রস্তাবিত: 600x600px)</span>
            </label>
            <div style="display: flex; gap: 16px; align-items: flex-start; flex-wrap: wrap;">
                <img id="slide_preview" src="" style="width: 120px; height: 120px; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; display: none; border: 2px solid #0b7c4d; box-shadow: 0 4px 10px rgba(0,0,0,0.08);" loading="lazy" decoding="async">
                <div style="flex: 1; min-width: 250px;">
                    <input type="text" id="slide_image_path" name="image" class="form-control" required readonly placeholder="মিডিয়া লাইব্রেরি থেকে ইমেজ সিলেক্ট করুন" style="margin-bottom: 8px;">
                    <button type="button" class="btn btn-secondary w-100" style="border-radius: 10px; padding: 10px 14px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" onclick="openMediaPicker('slide_image_path', 'slide_preview')">
                        <i class="fas fa-image" style="color: #0b7c4d;"></i> মিডিয়া লাইব্রেরি থেকে ইমেজ পছন্দ করুন
                    </button>
                </div>
            </div>
        </div>

        <div class="sslide-form-field">
            <label>ক্লিক লিংক (Link URL - ঐচ্ছিক)</label>
            <input type="text" name="link" class="form-control" placeholder="যেমন: https://response.nur-lab.com/post/example">
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ভিজিটর ব্যানারে ক্লিক করলে এই লিংকে চলে যাবে</small>
        </div>

        <div class="sslide-form-field">
            <label>প্রদর্শনের ক্রম (Order Index)</label>
            <input type="number" name="order_index" value="0" class="form-control">
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)</small>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #0b7c4d; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-check-circle"></i> সাইডবার স্লাইড তৈরি করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
