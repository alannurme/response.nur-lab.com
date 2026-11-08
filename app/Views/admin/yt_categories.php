<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.yt-cat-layout {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 25px;
    align-items: start;
}
@media (max-width: 992px) {
    .yt-cat-layout {
        grid-template-columns: 1fr;
    }
}
.yt-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    overflow: hidden;
}
.yt-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}
.yt-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.yt-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.95rem;
}
.yt-table tr:hover td {
    background-color: #f8fafc;
}
.yt-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #dbeafe;
}
.yt-action-btn {
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
.yt-btn-edit {
    background: #eff6ff;
    color: #2563eb;
}
.yt-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
    transform: translateY(-2px);
}
.yt-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.yt-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
    transform: translateY(-2px);
}
</style>

<div class="admin-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fab fa-youtube text-danger me-2"></i> ভিডিও ক্যাটাগরি (Video Categories)
        </h1>
        <p class="text-muted" style="margin-top: 5px; margin-bottom: 0; font-size: 0.95rem;">
            ইউটিউব ভিডিওগুলোকে বিভিন্ন বিভাগে বিন্যস্ত ও পরিচালনা করুন
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= URLROOT ?>/admin/yt_videos" class="btn btn-outline-secondary" style="font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px;">
            <i class="fas fa-play-circle"></i> সব ভিডিও দেখুন
        </a>
        <a href="<?= URLROOT ?>/admin/add_yt_video" class="btn btn-primary" style="background: #dc2626; border-color: #dc2626; font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px; box-shadow: 0 4px 12px rgba(220,38,38,0.25);">
            <i class="fas fa-plus-circle"></i> নতুন ভিডিও যোগ
        </a>
    </div>
</div>

<!-- Alert Notifications -->
<?php if (isset($_GET['msg'])): ?>
    <div style="background: #dcfce7; border-left: 5px solid #16a34a; color: #15803d; padding: 14px 20px; border-radius: 10px; margin-bottom: 25px; font-weight: 600; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
        <span>
            <?php
            if ($_GET['msg'] === 'added') echo 'নতুন ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে!';
            if ($_GET['msg'] === 'updated') echo 'ক্যাটাগরির তথ্য সফলভাবে আপডেট করা হয়েছে!';
            if ($_GET['msg'] === 'deleted') echo 'ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে!';
            ?>
        </span>
    </div>
<?php endif; ?>

<div class="yt-cat-layout">
    <!-- Left Column: Add Category Form -->
    <div class="admin-card" style="padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fas fa-folder-plus"></i>
            </div>
            <div>
                <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.15rem;">নতুন ক্যাটাগরি</h4>
                <small class="text-muted" style="font-size: 0.8rem;">নতুন ভিডিও বিভাগ তৈরি করুন</small>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/yt_categories" method="POST">
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label style="font-weight: 700; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">
                    ক্যাটাগরির নাম <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" class="form-control" placeholder="যেমন: কুরআন তিলাওয়াত, তাফসির" required style="padding: 11px 14px; border-radius: 10px; font-size: 0.95rem;">
            </div>

            <div class="form-group mb-4">
                <label style="font-weight: 700; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">
                    স্লাগ (ঐচ্ছিক)
                </label>
                <input type="text" name="slug" class="form-control" placeholder="যেমন: quran-tilawat" style="padding: 11px 14px; border-radius: 10px; font-size: 0.95rem;">
                <small class="text-muted" style="font-size: 0.8rem; margin-top: 5px; display: block;">খালি রাখলে নাম থেকে স্বয়ংক্রিয়ভাবে স্লাগ তৈরি হবে।</small>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="padding: 12px; background: #dc2626; border-color: #dc2626; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 15px rgba(220,38,38,0.25); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-plus-circle"></i> ক্যাটাগরি সংরক্ষণ করুন
            </button>
        </form>
    </div>

    <!-- Right Column: Category List -->
    <div class="yt-table-card">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: gap: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.15rem;">বিদ্যমান ক্যাটাগরিসমূহ</h4>
                <span style="background: #f1f5f9; color: #475569; font-size: 0.8rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;">
                    <?= count($data['categories']) ?>টি
                </span>
            </div>

            <div>
                <input type="text" id="cat-search-input" placeholder="ক্যাটাগরি খুঁজুন..." style="padding: 7px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem; width: 180px; outline: none;" onkeyup="filterCategories()">
            </div>
        </div>

        <div class="table-responsive" style="margin: 0;">
            <table class="yt-table" id="categories-table">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">ID</th>
                        <th>ক্যাটাগরির নাম</th>
                        <th>স্লাগ (Slug)</th>
                        <th style="text-align: center;">ভিডিও সংখ্যা</th>
                        <th style="text-align: right; width: 110px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): ?>
                        <tr class="cat-row">
                            <td style="text-align: center; color: #94a3b8; font-weight: 700; font-size: 0.85rem;">
                                #<?= $cat['id'] ?>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="width: 30px; height: 30px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                                    <span class="cat-name-text" style="font-weight: 700; font-family: 'Hind Siliguri', sans-serif; font-size: 1.05rem; color: #1e293b;">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #475569; font-size: 0.82rem; border: 1px solid #e2e8f0;">
                                    <?= htmlspecialchars($cat['slug']) ?>
                                </code>
                            </td>
                            <td style="text-align: center;">
                                <span class="yt-count-badge">
                                    <i class="fas fa-video"></i>
                                    <?= (int)($cat['video_count'] ?? 0) ?>টি
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="<?= URLROOT ?>/admin/edit_yt_category/<?= $cat['id'] ?>" class="yt-action-btn yt-btn-edit" title="সম্পাদনা করুন">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_yt_category/<?= $cat['id'] ?>" class="yt-action-btn yt-btn-delete" title="মুছে ফেলুন" onclick="return confirm('এই ক্যাটাগরি মুছে ফেললে এর আওতাধীন ভিডিওগুলো আনক্যাটাগরি হিসেবে থাকবে। আপনি কি নিশ্চিত?')">
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
                                    <i class="fab fa-youtube fa-3x mb-3" style="color: #cbd5e1;"></i>
                                    <p style="font-size: 1.05rem; margin-bottom: 10px; font-weight: 600; color: #64748b;">এখনো কোনো ভিডিও ক্যাটাগরি তৈরি করা হয়নি</p>
                                    <small style="color: #94a3b8;">বাম পাশের ফর্ম থেকে আপনার প্রথম ক্যাটাগরি যোগ করুন</small>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterCategories() {
    const input = document.getElementById('cat-search-input');
    const filter = input.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#categories-table .cat-row');

    rows.forEach(row => {
        const text = row.querySelector('.cat-name-text').textContent.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
