<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.page-form-wrap {
    font-family: 'Hind Siliguri', sans-serif;
}
.page-form-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.page-form-title {
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
</style>

<div class="page-form-wrap">
    <div style="margin-bottom: 20px;">
        <a href="<?= URLROOT ?>/admin/pages" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
            <i class="fas fa-arrow-left"></i> সকল পেজ তালিকায় ফিরুন
        </a>
    </div>

    <div class="page-form-card">
        <div class="page-form-title">
            <div style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">পেজ তথ্য সম্পাদনা: <?= htmlspecialchars($data['page']['title']) ?></h3>
                <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">স্ট্যাটিক পেজের শিরোনাম এবং ভেতরের কনটেন্ট পরিবর্তন করুন</p>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/edit_page/<?= $data['page']['id'] ?>" method="POST">
            <?= csrf_field() ?>
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.95rem;">পেজের শিরোনাম <span style="color:#ef4444">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($data['page']['title']) ?>" class="form-control" required style="border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.95rem; padding: 12px 16px; width: 100%;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.95rem;">পেজের কনটেন্ট ও বিস্তারিত বিবরণ <span style="color:#ef4444">*</span></label>
                <textarea name="content" class="form-control" rows="16" required><?= htmlspecialchars($data['page']['content']) ?></textarea>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <button type="submit" class="btn" style="background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25); cursor: pointer;">
                    <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
                </button>
                <a href="<?= URLROOT ?>/admin/pages" class="btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 20px; font-weight: 700; text-decoration: none;">
                    বাতিল
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea[name="content"]',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor blockquote | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500,
        branding: false,
        promotion: false,
        contextmenu: false
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
