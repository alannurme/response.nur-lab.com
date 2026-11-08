<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.rev-form-card {
    max-width: 800px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.rev-form-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: 'Hind Siliguri', sans-serif;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 16px;
}
.rev-form-field {
    margin-bottom: 22px;
}
.rev-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.rev-form-field input, .rev-form-field select, .rev-form-field textarea {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.rev-form-field input:focus, .rev-form-field select:focus, .rev-form-field textarea:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 800px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/reviews" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
        <i class="fas fa-arrow-left"></i> সকল রিভিউ তালিকায় ফিরুন
    </a>
</div>

<div class="rev-form-card">
    <div class="rev-form-title">
        <div style="width: 44px; height: 44px; background: #fef9c3; color: #ca8a04; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #1e293b;">নতুন রিভিউ যোগ করুন</h3>
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">হোমপেজ প্রশংসাপত্র ক্যারোসেলের জন্য পাঠকদের মন্তব্য যোগ করুন</span>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_review" method="POST">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="rev-form-field">
                <label>পাঠকের নাম (Reviewer Name) <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" placeholder="যেমন: আব্দুল্লাহ আল মামুন" required autofocus>
            </div>
            <div class="rev-form-field">
                <label>পদবী বা পরিচয় (Designation)</label>
                <input type="text" name="designation" placeholder="যেমন: নিয়মিত পাঠক / শিক্ষক" value="নিয়মিত পাঠক" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="rev-form-field">
                <label>স্টার রেটিং (Rating)</label>
                <select name="rating" style="height: 48px;" required>
                    <option value="5" selected>⭐⭐⭐⭐⭐ (৫ স্টার)</option>
                    <option value="4">⭐⭐⭐⭐ (৪ স্টার)</option>
                    <option value="3">⭐⭐⭐ (৩ স্টার)</option>
                    <option value="2">⭐⭐ (২ স্টার)</option>
                    <option value="1">⭐ (১ স্টার)</option>
                </select>
            </div>
            <div class="rev-form-field">
                <label>প্রদর্শনের ক্রম (Display Order)</label>
                <input type="number" name="order_index" value="0" style="height: 48px;" required>
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="rev-form-field">
            <label>প্রোফাইল ছবি (Profile Photo)</label>
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 2px dashed #cbd5e1; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img id="review_preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;" loading="lazy">
                    <i id="preview_placeholder" class="fas fa-user" style="font-size: 1.8rem; color: #94a3b8;"></i>
                </div>
                <div style="flex: 1;">
                    <input type="text" id="review_image_path" name="image" placeholder="ছবির ইউআরএল অথবা মিডিয়া লাইব্রেরি থেকে নির্বাচন করুন" readonly>
                    <div style="margin-top: 8px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="openMediaPicker('review_image_path', 'review_preview')" style="border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 7px 16px;">
                            <i class="fas fa-image" style="margin-right: 5px;"></i> মিডিয়া লাইব্রেরি থেকে ছবি বাছুন
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="rev-form-field">
            <label>মতামত বা রিভিউ বিবরণ (Review Text) <span style="color: #ef4444;">*</span></label>
            <textarea name="review_text" rows="5" placeholder="পাঠকের সম্পূর্ণ মতামতটি এখানে লিখুন..." style="font-family: 'Hind Siliguri', sans-serif;" required></textarea>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="flex: 2; height: 50px; background: #0b7c4d; border-color: #0b7c4d; font-weight: 700; font-size: 1.05rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-check-circle"></i> রিভিউ সংরক্ষণ করুন
            </button>
            <a href="<?= URLROOT ?>/admin/reviews" class="btn btn-outline-secondary" style="flex: 1; height: 50px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                বাতিল
            </a>
        </div>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
