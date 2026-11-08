<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.tmenu-form-card {
    max-width: 650px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.tmenu-form-title {
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
.tmenu-form-field {
    margin-bottom: 22px;
}
.tmenu-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.tmenu-form-field input {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.tmenu-form-field input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    outline: none;
}
</style>

<div style="max-width: 650px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/sub_menus" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল টপ মেনু তালিকায় ফিরুন
    </a>
</div>

<div class="tmenu-form-card">
    <div class="tmenu-form-title">
        <div style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">টপ বার মেনু সম্পাদনা: <?= htmlspecialchars($data['menu']['title']) ?></h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">টপবার মেনুর শিরোনাম, লিংক বা প্রদর্শনের ক্রম পরিবর্তন করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_sub_menu/<?= $data['menu']['id'] ?>" method="POST">
        <?= csrf_field() ?>

        <div class="tmenu-form-field">
            <label>মেনুর শিরোনাম <span style="color:#ef4444">*</span></label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['menu']['title']) ?>" class="form-control" required>
        </div>

        <div class="tmenu-form-field">
            <label>নেভিগেশন লিংক (URL) <span style="color:#ef4444">*</span></label>
            <input type="text" name="url" value="<?= htmlspecialchars($data['menu']['url']) ?>" class="form-control" required>
        </div>

        <div class="tmenu-form-field">
            <label>প্রদর্শনের ক্রম (Order Index)</label>
            <input type="number" name="order_index" value="<?= htmlspecialchars($data['menu']['order_index']) ?>" class="form-control">
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)</small>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #2563eb; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
