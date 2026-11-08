<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.user-form-card {
    max-width: 650px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.user-form-title {
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
.user-form-field {
    margin-bottom: 22px;
}
.user-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.user-form-field input, .user-form-field select {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.user-form-field input:focus, .user-form-field select:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 650px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/users" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল ইউজার তালিকায় ফিরুন
    </a>
</div>

<div class="user-form-card">
    <div class="user-form-title">
        <div style="width: 44px; height: 44px; background: #ecfdf5; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-user-plus"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">নতুন স্টাফ ইউজার তৈরি করুন</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">ওয়েবসাইট পরিচালনার জন্য নতুন অ্যাডমিন বা এডিটর একাউন্ট তৈরি করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/add_user" method="POST">
        <?= csrf_field() ?>

        <div class="user-form-field">
            <label>ব্যবহারকারীর নাম (Username) <span style="color:#ef4444">*</span></label>
            <input type="text" name="username" class="form-control" placeholder="যেমন: alannur" required>
        </div>

        <div class="user-form-field">
            <label>ইমেইল এড্রেস <span style="color:#ef4444">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="user@example.com" required>
        </div>

        <div class="user-form-field">
            <label>পাসওয়ার্ড <span style="color:#ef4444">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="শক্তিশালী পাসওয়ার্ড দিন" required>
        </div>

        <div class="user-form-field">
            <label>ভূমিকা / রোল (Role) <span style="color:#ef4444">*</span></label>
            <select name="role" class="form-control" required>
                <option value="admin">Administrator (পূর্ণ নিয়ন্ত্রণ)</option>
                <option value="editor">Editor (পোস্ট ও কনটেন্ট সম্পাদক)</option>
                <option value="author">Author (শুধুমাত্র লেখক)</option>
            </select>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #0b7c4d; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-check-circle"></i> একাউন্ট তৈরি করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
