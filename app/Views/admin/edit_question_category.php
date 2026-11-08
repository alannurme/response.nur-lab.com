<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.qc-edit-container {
    max-width: 650px;
    margin: 20px auto 40px auto;
}
.qc-edit-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.qc-edit-title {
    font-size: 1.3rem;
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
.qc-field-group {
    margin-bottom: 22px;
}
.qc-field-group label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.qc-field-group input {
    height: 48px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
}
.qc-field-group input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
.qc-field-group small {
    display: block;
    margin-top: 6px;
    color: #64748b;
    font-size: 0.82rem;
}
</style>

<div class="qc-edit-container">
    <!-- Back Navigation -->
    <div class="mb-4">
        <a href="<?= URLROOT ?>/admin/question_categories" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
            <i class="fas fa-arrow-left"></i> ক্যাটাগরি তালিকায় ফিরুন
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="qc-edit-card">
        <div class="qc-edit-title">
            <div style="width: 42px; height: 42px; background: #e6f4ea; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.3rem; font-weight: 800; color: #1e293b;">ক্যাটাগরি সম্পাদনা করুন</h3>
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">ID: #<?= (int)$category['id'] ?></span>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/edit_question_category/<?= (int)$category['id'] ?>" method="POST">
            <?= csrf_field() ?>

            <!-- Category Name -->
            <div class="qc-field-group">
                <label for="edit_name">
                    ক্যাটাগরির নাম <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="edit_name" name="name" class="form-control" value="<?= htmlspecialchars($category['name'] ?? '') ?>" placeholder="যেমন: আকীদা ও ঈমান" required autofocus>
            </div>

            <!-- Slug -->
            <div class="qc-field-group">
                <label for="edit_slug">
                    স্লাগ (URL Slug)
                </label>
                <input type="text" id="edit_slug" name="slug" class="form-control" value="<?= htmlspecialchars($category['slug'] ?? '') ?>" placeholder="যেমন: aqeedah">
                <small>খালি রাখলে নাম অনুযায়ী নতুন স্লাগ স্বয়ংক্রিয়ভাবে তৈরি হবে।</small>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex: 2; height: 48px; background: #0b7c4d; border-color: #0b7c4d; font-weight: 700; font-size: 1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
                </button>
                <a href="<?= URLROOT ?>/admin/question_categories" class="btn btn-outline-secondary" style="flex: 1; height: 48px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    বাতিল (Cancel)
                </a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
