<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<style>
.scope-form-card {
    max-width: 750px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.scope-form-title {
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
.scope-form-field {
    margin-bottom: 22px;
}
.scope-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.scope-form-field input, .scope-form-field textarea {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.scope-form-field input:focus, .scope-form-field textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    outline: none;
}
.popular-badge {
    cursor: pointer;
    background: #f1f5f9;
    color: #2563eb;
    padding: 3px 10px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.8rem;
    display: inline-block;
    margin-right: 6px;
    margin-top: 5px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}
.popular-badge:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
}
</style>

<div style="max-width: 750px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/scopes" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল কার্যপরিধি তালিকায় ফিরুন
    </a>
</div>

<div class="scope-form-card">
    <div class="scope-form-title">
        <div style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">কার্যপরিধি সম্পাদনা</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">কার্যপরিধির শিরোনাম, আইকন, বিবরণ অথবা প্রদর্শনের ক্রম পরিবর্তন করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_scope/<?= $data['scope']['id'] ?>" method="POST">
        <?= csrf_field() ?>

        <div class="scope-form-field">
            <label>কার্যপরিধি শিরোনাম <span style="color:#ef4444">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['scope']['title']) ?>" required>
        </div>

        <div class="scope-form-field">
            <label>ফন্টঅসাম আইকন ক্লাস (Icon Class) <span style="color:#ef4444">*</span></label>
            <input type="text" name="icon" id="scope_icon" class="form-control" value="<?= htmlspecialchars($data['scope']['icon']) ?>" required>
            <div style="margin-top: 8px;">
                <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">জনপ্রিয় আইকন:</span>
                <span class="popular-badge" onclick="document.getElementById('scope_icon').value='fas fa-mosque'"><i class="fas fa-mosque"></i> fas fa-mosque</span>
                <span class="popular-badge" onclick="document.getElementById('scope_icon').value='fas fa-book-open'"><i class="fas fa-book-open"></i> fas fa-book-open</span>
                <span class="popular-badge" onclick="document.getElementById('scope_icon').value='fas fa-graduation-cap'"><i class="fas fa-graduation-cap"></i> fas fa-graduation-cap</span>
                <span class="popular-badge" onclick="document.getElementById('scope_icon').value='fas fa-scale-balanced'"><i class="fas fa-scale-balanced"></i> fas fa-scale-balanced</span>
                <span class="popular-badge" onclick="document.getElementById('scope_icon').value='fas fa-hands-praying'"><i class="fas fa-hands-praying"></i> fas fa-hands-praying</span>
            </div>
        </div>

        <div class="scope-form-field">
            <label>বিস্তারিত বিবরণ (Description) <span style="color:#ef4444">*</span></label>
            <textarea name="description" class="form-control" rows="6" required><?= htmlspecialchars($data['scope']['description']) ?></textarea>
        </div>

        <div class="scope-form-field">
            <label>প্রদর্শনের ক্রম (Order Index)</label>
            <input type="number" name="order_index" value="<?= htmlspecialchars($data['scope']['order_index']) ?>" class="form-control" required>
            <small style="color: #64748b; font-size: 0.82rem; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)</small>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #2563eb; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
        </button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
