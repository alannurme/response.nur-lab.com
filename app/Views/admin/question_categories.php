<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.qc-container {
    max-width: 1400px;
    margin: 0 auto;
}
.qc-header-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 25px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}
.qc-grid {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 25px;
    align-items: flex-start;
}
@media (max-width: 992px) {
    .qc-grid {
        grid-template-columns: 1fr;
    }
}
.qc-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 26px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.qc-card-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Hind Siliguri', sans-serif;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 12px;
}
.qc-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.qc-table th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 2px solid #e2e8f0;
}
.qc-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.95rem;
}
.qc-table tr:hover td {
    background-color: #f8fafc;
}
.qc-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    background: #e6f4ea;
    color: #0b7c4d;
    border: 1px solid #bbf7d0;
}
.qc-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    text-decoration: none;
    transition: 0.2s all;
    border: none;
    cursor: pointer;
}
.qc-btn-edit {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #dbeafe;
}
.qc-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    transform: translateY(-2px);
}
.qc-btn-delete {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fee2e2;
}
.qc-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
    border-color: #dc2626;
    transform: translateY(-2px);
}
.qc-search-box {
    position: relative;
    max-width: 320px;
    width: 100%;
}
.qc-search-box input {
    width: 100%;
    padding: 9px 15px 9px 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.9rem;
    outline: none;
    transition: 0.2s border-color, 0.2s box-shadow;
}
.qc-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}
.qc-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
}
</style>

<div class="qc-container">
    <!-- Header Card -->
    <div class="qc-header-card">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 48px; height: 48px; background: #e6f4ea; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                    প্রশ্নোত্তর ক্যাটাগরি (Q&A Categories)
                    <span class="badge" style="background: #e6f4ea; color: #0b7c4d; font-size: 0.85rem; font-weight: 700; margin-left: 10px; padding: 5px 12px; border-radius: 20px;">
                        মোট <?= count($categories ?? []) ?>টি ক্যাটাগরি
                    </span>
                </h2>
                <p style="margin: 0; color: #64748b; font-size: 0.88rem;">প্রশ্নোত্তরের ক্যাটাগরি ও বিষয়ভিত্তিক বিভাগ পরিচালনা করুন</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= URLROOT ?>/admin/questions" class="btn btn-outline-secondary" style="font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
                <i class="fas fa-list-alt"></i> সকল প্রশ্নোত্তর তালিকা
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <div style="background: #dcfce7; border-left: 5px solid #16a34a; color: #15803d; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fas fa-check-circle me-2"></i>
                <?php
                if ($_GET['msg'] === 'added') echo 'ক্যাটাগরি সফলভাবে যোগ করা হয়েছে!';
                if ($_GET['msg'] === 'updated') echo 'ক্যাটাগরি সফলভাবে আপডেট করা হয়েছে!';
                if ($_GET['msg'] === 'deleted') echo 'ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে!';
                ?>
            </div>
            <button type="button" onclick="this.parentElement.style.display='none'" style="background: transparent; border: none; color: #15803d; font-size: 1.1rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- 2-Column Grid -->
    <div class="qc-grid">
        <!-- Left: Add Category Form -->
        <div class="qc-card">
            <div class="qc-card-title">
                <i class="fas fa-plus-circle" style="color: #0b7c4d;"></i>
                <span>নতুন ক্যাটাগরি যোগ করুন</span>
            </div>

            <form action="<?= URLROOT ?>/admin/question_categories" method="POST">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block; font-size: 0.92rem;">
                        ক্যাটাগরির নাম <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="cat-name-input" name="name" class="form-control" placeholder="যেমন: আকীদা ও ঈমান" style="height: 46px; border-radius: 10px;" required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; display: block; font-size: 0.92rem;">
                        স্লাগ (URL Slug)
                    </label>
                    <input type="text" id="cat-slug-input" name="slug" class="form-control" placeholder="যেমন: aqeedah" style="height: 46px; border-radius: 10px;">
                    <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 5px;">
                        খালি রাখলে নাম অনুযায়ী স্বয়ংক্রিয়ভাবে স্লাগ তৈরি হবে।
                    </small>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background: #0b7c4d; border-color: #0b7c4d; height: 48px; border-radius: 10px; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25);">
                    <i class="fas fa-plus"></i> ক্যাটাগরি সংরক্ষণ করুন
                </button>
            </form>
        </div>

        <!-- Right: Category List -->
        <div class="qc-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="qc-card-title mb-0" style="border: none; padding: 0;">
                    <i class="fas fa-folder-open" style="color: #0b7c4d;"></i>
                    <span>বিদ্যমান ক্যাটাগরি তালিকা</span>
                </div>

                <div class="qc-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="cat-search-input" placeholder="ক্যাটাগরি বা স্লাগ খুঁজুন..." onkeyup="filterCategories()">
                </div>
            </div>

            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                <table class="qc-table" id="categories-table">
                    <thead>
                        <tr>
                            <th style="width: 70px; text-align: center;">ID</th>
                            <th>ক্যাটাগরির নাম</th>
                            <th>স্লাগ (Slug)</th>
                            <th style="text-align: center;">প্রশ্নের সংখ্যা</th>
                            <th style="text-align: right; width: 110px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                            <tr class="cat-row">
                                <td style="text-align: center; color: #94a3b8; font-weight: 700; font-size: 0.85rem;">
                                    #<?= $cat['id'] ?>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 32px; height: 32px; border-radius: 8px; background: #e6f4ea; color: #0b7c4d; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <span class="cat-name-text" style="font-weight: 700; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; color: #1e293b;">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <code class="cat-slug-text" style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #475569; font-size: 0.82rem; border: 1px solid #e2e8f0;">
                                        <?= htmlspecialchars($cat['slug']) ?>
                                    </code>
                                </td>
                                <td style="text-align: center;">
                                    <span class="qc-count-badge">
                                        <i class="fas fa-question-circle"></i>
                                        <?= (int)($cat['question_count'] ?? 0) ?>টি
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_question_category/<?= $cat['id'] ?>" class="qc-action-btn qc-btn-edit" title="সম্পাদনা করুন">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= URLROOT ?>/admin/delete_question_category/<?= $cat['id'] ?>" class="qc-action-btn qc-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই ক্যাটাগরিটি মুছে ফেলতে চান?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 50px 20px;">
                                    <div style="color: #94a3b8;">
                                        <i class="fas fa-folder-open fa-3x mb-3" style="color: #cbd5e1;"></i>
                                        <p style="font-size: 1rem; margin-bottom: 6px; font-weight: 600; color: #64748b;">এখনো কোনো প্রশ্নোত্তর ক্যাটাগরি তৈরি করা হয়নি</p>
                                        <small style="color: #94a3b8;">বাম পাশের ফর্ম থেকে আপনার প্রথম ক্যাটাগরি তৈরি করুন</small>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug preview on name input
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('cat-name-input');
    const slugInput = document.getElementById('cat-slug-input');

    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.touched !== 'true') {
                const text = nameInput.value.trim().toLowerCase();
                // Replace special characters with hyphen
                const slug = text.replace(/[^\p{L}\p{N}\p{M}]+/gu, '-').replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            }
        });

        slugInput.addEventListener('input', function() {
            slugInput.dataset.touched = 'true';
        });
    }
});

// Live filter search for categories
function filterCategories() {
    const input = document.getElementById('cat-search-input');
    const filter = input.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#categories-table .cat-row');

    rows.forEach(row => {
        const nameText = row.querySelector('.cat-name-text')?.textContent.toLowerCase() || '';
        const slugText = row.querySelector('.cat-slug-text')?.textContent.toLowerCase() || '';
        if (nameText.includes(filter) || slugText.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
