<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.author-form-card {
    max-width: 650px;
    margin: 20px auto 40px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    font-family: 'Hind Siliguri', sans-serif;
}
.author-form-title {
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
.author-form-field {
    margin-bottom: 22px;
}
.author-form-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.author-form-field input {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.author-form-field input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
</style>

<div style="max-width: 650px; margin: 0 auto 20px auto;">
    <a href="<?= URLROOT ?>/admin/authors" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px; font-family: 'Hind Siliguri', sans-serif;">
        <i class="fas fa-arrow-left"></i> সকল লেখক তালিকায় ফিরুন
    </a>
</div>

<div class="author-form-card">
    <div class="author-form-title">
        <div style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
            <i class="fas fa-user-edit"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">লেখক তথ্য সম্পাদনা</h3>
            <p style="margin: 2px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 400;">লেখকের নাম, ইমেইল বা ছবি পরিবর্তন করুন</p>
        </div>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_author/<?= $data['author']['id'] ?>" method="POST">
        <?= csrf_field() ?>

        <div class="author-form-field">
            <label>লেখকের পুরো নাম <span style="color:#ef4444">*</span></label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['author']['name']) ?>" class="form-control" required>
        </div>

        <div class="author-form-field">
            <label>ইমেইল এড্রেস (ঐচ্ছিক)</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['author']['email'] ?? '') ?>" class="form-control" placeholder="author@example.com">
        </div>

        <div class="author-form-field">
            <label>প্রোফাইল ছবি</label>
            <div style="display: flex; gap: 15px; align-items: center;">
                <?php 
                    $hasImg = !empty($data['author']['image']);
                    $imgSrc = $hasImg ? htmlspecialchars($data['author']['image']) : '';
                ?>
                <img id="author_preview" src="<?= $imgSrc ?>" style="width: 65px; height: 65px; border-radius: 50%; display: <?= $hasImg ? 'block' : 'none' ?>; object-fit: cover; border: 2px solid #2563eb;" loading="lazy" decoding="async">
                <div style="flex: 1;">
                    <input type="text" id="author_image_path" name="image" value="<?= $imgSrc ?>" class="form-control" readonly placeholder="মিডিয়া লাইব্রেরি থেকে ছবি সিলেক্ট করুন" style="margin-bottom: 8px;">
                    <button type="button" class="btn btn-secondary w-100" style="border-radius: 10px; padding: 10px 14px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" onclick="openMediaPicker('author_image_path', 'author_preview')">
                        <i class="fas fa-image" style="color: #2563eb;"></i> ছবি পরিবর্তন করুন
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; background: #2563eb; color: white; border: none; padding: 13px 20px; border-radius: 12px; font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25); cursor: pointer; margin-top: 10px;">
            <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
        </button>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
