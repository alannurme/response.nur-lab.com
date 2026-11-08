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
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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
        <div style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-user-edit"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">ইউজার প্রোফাইল সম্পাদনা</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">ইউজারনেম, ইমেইল অথবা নতুন পাসওয়ার্ড সেট করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_user/<?= $data['user']['id'] ?>" method="POST">
        <?= csrf_field() ?>

        <div class="user-form-field">
            <label>ব্যবহারকারীর নাম (Username) <span style="color:#ef4444">*</span></label>
            <input type="text" name="username" value="<?= htmlspecialchars($data['user']['username']) ?>" class="form-control" required>
        </div>

        <div class="user-form-field">
            <label>ইমেইল এড্রেস</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['user']['email'] ?? '') ?>" class="form-control" placeholder="user@example.com">
        </div>

        <div class="user-form-field">
            <label>নতুন পাসওয়ার্ড (পরিবর্তন না করতে চাইলে ফাঁকা রাখুন)</label>
            <input type="password" name="password" class="form-control" placeholder="নতুন পাসওয়ার্ড লিখুন">
        </div>

        <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 14px 18px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; color: #1e40af; font-size: 0.88rem;">
            <i class="fas fa-info-circle" style="font-size: 1.1rem; color: #2563eb;"></i>
            <span>পাসওয়ার্ড পরিবর্তন করলে ইউজারকে পরবর্তীতে নতুন পাসওয়ার্ড দিয়ে পুনরায় লগইন করতে হবে।</span>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #2563eb; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-save"></i> প্রোফাইল সংরক্ষণ করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
