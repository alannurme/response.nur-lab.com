<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.faq-form-card {
    max-width: 800px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.faq-form-title {
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
.faq-form-field {
    margin-bottom: 22px;
}
.faq-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.faq-form-field input, .faq-form-field select, .faq-form-field textarea {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.faq-form-field input:focus, .faq-form-field select:focus, .faq-form-field textarea:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 800px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/faqs" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
        <i class="fas fa-arrow-left"></i> সকল এফএকিউ তালিকায় ফিরুন
    </a>
</div>

<div class="faq-form-card">
    <div class="faq-form-title">
        <div style="width: 44px; height: 44px; background: #e6f4ea; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #1e293b;">নতুন সাধারণ জিজ্ঞাসা যোগ করুন</h3>
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">হোমপেজের সচরাচর জিজ্ঞাসা সেকশনের জন্য নতুন প্রশ্ন তৈরি করুন</span>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_faq" method="POST">
        <?= csrf_field() ?>

        <div class="faq-form-field">
            <label>প্রশ্ন (Question) <span style="color: #ef4444;">*</span></label>
            <input type="text" name="question" placeholder="যেমন: আপনাদের ওয়েবসাইট বা কনটেন্ট সম্পর্কে জানতে চাই।" required autofocus>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="faq-form-field">
                <label>স্ট্যাটাস (Status)</label>
                <select name="status" style="height: 48px;">
                    <option value="active" selected>সক্রিয় (Active)</option>
                    <option value="inactive">নিষ্ক্রিয় (Inactive)</option>
                </select>
            </div>
            <div class="faq-form-field">
                <label>প্রদর্শনের ক্রম সংখ্যা (Display Order)</label>
                <input type="number" name="order_index" value="0" style="height: 48px;" required>
            </div>
        </div>

        <div class="faq-form-field">
            <label>উত্তর (Answer) <span style="color: #ef4444;">*</span></label>
            <textarea name="answer" rows="7" placeholder="এখানে বিস্তারিত উত্তরটি লিখুন (প্রয়োজনে লিংক বা টেক্সট ফরম্যাট ব্যবহার করতে পারেন)..." style="font-family: 'Hind Siliguri', sans-serif;" required></textarea>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="flex: 2; height: 50px; background: #0b7c4d; border-color: #0b7c4d; font-weight: 700; font-size: 1.05rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-check-circle"></i> এফএকিউ সংরক্ষণ করুন
            </button>
            <a href="<?= URLROOT ?>/admin/faqs" class="btn btn-outline-secondary" style="flex: 1; height: 50px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                বাতিল
            </a>
        </div>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
