<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.yt-videos-card {
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
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.95rem;
}
.yt-table tr:hover td {
    background-color: #f8fafc;
}
.video-thumb-wrapper {
    position: relative;
    width: 110px;
    aspect-ratio: 16 / 9;
    border-radius: 10px;
    overflow: hidden;
    background: #0f172a;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: block;
}
.video-thumb-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.3s transform;
}
.video-thumb-wrapper:hover img {
    transform: scale(1.08);
}
.video-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.1rem;
    opacity: 0;
    transition: 0.3s opacity;
}
.video-thumb-wrapper:hover .video-thumb-overlay {
    opacity: 1;
}
.yt-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 600;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #dbeafe;
}
.yt-cat-badge.uncat {
    background: #f1f5f9;
    color: #64748b;
    border-color: #e2e8f0;
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
.yt-btn-view {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}
.yt-btn-view:hover {
    background: #ff0000;
    color: #ffffff;
    border-color: #ff0000;
    transform: translateY(-2px);
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
.video-title-text {
    font-weight: 600;
    color: #1e293b;
    text-decoration: none;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 0.88rem;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-width: 480px;
    transition: 0.2s color;
}
.video-title-text:hover {
    color: #ff0000;
}
</style>

<div class="admin-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fab fa-youtube text-danger me-2"></i> সব ইউটিউব ভিডিও (All YouTube Videos)
        </h1>
        <p class="text-muted" style="margin-top: 5px; margin-bottom: 0; font-size: 0.95rem;">
            হোমপেজে প্রদর্শিত সমস্ত ইউটিউব ভিডিও ও তাদের বিভাগ পরিচালনা করুন
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" id="btn-quick-sync" class="btn btn-outline-success" style="font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px;">
            <i class="fas fa-sync-alt"></i> চ্যানেল থেকে সিঙ্ক করুন
        </button>
        <a href="<?= URLROOT ?>/admin/yt_categories" class="btn btn-outline-secondary" style="font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px;">
            <i class="fas fa-folder"></i> ক্যাটাগরি তালিকা
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
            if ($_GET['msg'] === 'added') echo 'নতুন ভিডিও সফলভাবে সংরক্ষণ করা হয়েছে!';
            if ($_GET['msg'] === 'updated') echo 'ভিডিওর তথ্য সফলভাবে আপডেট করা হয়েছে!';
            if ($_GET['msg'] === 'deleted') echo 'ভিডিও সফলভাবে মুছে ফেলা হয়েছে!';
            ?>
        </span>
    </div>
<?php endif; ?>

<!-- Quick Sync Result Alert Box -->
<div id="sync-result-box" style="display: none; padding: 14px 20px; border-radius: 10px; margin-bottom: 25px; font-weight: 600;"></div>

<div class="yt-videos-card">
    <!-- Toolbar: Search & Category Filter -->
    <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; background: #ffffff;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.15rem;">ভিডিও তালিকা</h4>
            <span style="background: #fee2e2; color: #dc2626; font-size: 0.8rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;">
                মোট <?= count($data['videos']) ?>টি ভিডিও
            </span>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <!-- Category Filter -->
            <select id="video-cat-filter" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem; outline: none; font-weight: 600; color: #334155;" onchange="filterVideos()">
                <option value="">সব ক্যাটাগরি</option>
                <?php
                $catNames = [];
                foreach ($data['videos'] as $v) {
                    if (!empty($v['category_name']) && !in_array($v['category_name'], $catNames)) {
                        $catNames[] = $v['category_name'];
                    }
                }
                foreach ($catNames as $cn): ?>
                    <option value="<?= htmlspecialchars($cn) ?>"><?= htmlspecialchars($cn) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Search Box -->
            <div style="position: relative;">
                <input type="text" id="video-search-input" placeholder="ভিডিও বা আইডি খুঁজুন..." style="padding: 8px 14px 8px 32px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem; width: 220px; outline: none;" onkeyup="filterVideos()">
                <i class="fas fa-search" style="position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive" style="margin: 0;">
        <table class="yt-table" id="yt-videos-table">
            <thead>
                <tr>
                    <th style="width: 130px;">থাম্বনেইল</th>
                    <th>ভিডিও শিরোনাম</th>
                    <th>বিভাগ (Category)</th>
                    <th>ভিডিও আইডি</th>
                    <th>প্রকাশের তারিখ</th>
                    <th style="text-align: right; width: 130px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['videos'])): ?>
                    <?php foreach ($data['videos'] as $video): ?>
                    <tr class="video-row" data-category="<?= htmlspecialchars($video['category_name'] ?? '') ?>">
                        <td>
                            <a href="<?= $video['video_url'] ?>" target="_blank" class="video-thumb-wrapper" title="ইউটিউবে দেখুন">
                                <img src="https://img.youtube.com/vi/<?= $video['video_id'] ?>/mqdefault.jpg" loading="lazy" decoding="async" alt="Thumb">
                                <div class="video-thumb-overlay"><i class="fas fa-play"></i></div>
                            </a>
                        </td>
                        <td>
                            <a href="<?= $video['video_url'] ?>" target="_blank" class="video-title-text" title="<?= htmlspecialchars($video['title']) ?>">
                                <?= htmlspecialchars($video['title']) ?>
                            </a>
                        </td>
                        <td>
                            <?php if (!empty($video['category_name'])): ?>
                                <span class="yt-cat-badge">
                                    <i class="fas fa-folder"></i> <?= htmlspecialchars($video['category_name']) ?>
                                </span>
                            <?php else: ?>
                                <span class="yt-cat-badge uncat">আনক্যাটাগরি</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <code class="video-id-text" style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #475569; font-size: 0.85rem; border: 1px solid #e2e8f0;">
                                <?= htmlspecialchars($video['video_id']) ?>
                            </code>
                        </td>
                        <td style="color: #64748b; font-size: 0.88rem; white-space: nowrap;">
                            <i class="far fa-calendar-alt me-1 text-muted"></i>
                            <?= date('d M, Y', strtotime($video['created_at'])) ?>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <a href="<?= $video['video_url'] ?>" target="_blank" class="yt-action-btn yt-btn-view" title="ইউটিউবে চালান">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/edit_yt_video/<?= $video['id'] ?>" class="yt-action-btn yt-btn-edit" title="সম্পাদনা করুন">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_yt_video/<?= $video['id'] ?>" class="yt-action-btn yt-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই ভিডিওটি মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px;">
                            <div style="color: #94a3b8;">
                                <i class="fab fa-youtube fa-3x mb-3" style="color: #cbd5e1;"></i>
                                <p style="font-size: 1.1rem; margin-bottom: 8px; font-weight: 700; color: #475569;">কোনো ইউটিউব ভিডিও পাওয়া যায়নি</p>
                                <p style="font-size: 0.9rem; color: #94a3b8; margin-bottom: 20px;">আপনার চ্যানেলের ভিডিও সিঙ্ক করুন অথবা সরাসরি নতুন ভিডিও যোগ করুন</p>
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <a href="<?= URLROOT ?>/admin/add_yt_video" class="btn btn-primary" style="background: #dc2626; border-color: #dc2626; font-weight: 600; border-radius: 8px;">
                                        <i class="fas fa-plus-circle me-1"></i> Add Video
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterVideos() {
    const searchVal = document.getElementById('video-search-input').value.toLowerCase().trim();
    const catVal = document.getElementById('video-cat-filter').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#yt-videos-table .video-row');

    rows.forEach(row => {
        const title = row.querySelector('.video-title-text').textContent.toLowerCase();
        const vidId = row.querySelector('.video-id-text').textContent.toLowerCase();
        const cat = (row.getAttribute('data-category') || '').toLowerCase();

        const matchesSearch = !searchVal || title.includes(searchVal) || vidId.includes(searchVal);
        const matchesCat = !catVal || cat === catVal;

        if (matchesSearch && matchesCat) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Quick Sync Button Handler
document.addEventListener('DOMContentLoaded', function() {
    const syncBtn = document.getElementById('btn-quick-sync');
    const resultBox = document.getElementById('sync-result-box');

    if (syncBtn) {
        syncBtn.addEventListener('click', async function() {
            syncBtn.disabled = true;
            const origHtml = syncBtn.innerHTML;
            syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> সিঙ্ক হচ্ছে...';

            try {
                const res = await fetch('<?= URLROOT ?>/admin/sync_yt_videos_ajax', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Non-JSON server response:', text);
                    data = { success: false, error: 'সার্ভার থেকে সঠিক ফরম্যাটে রেসপন্স আসেনি। অনুগ্রহ করে পুনরায় চেষ্টা করুন।' };
                }

                syncBtn.disabled = false;
                syncBtn.innerHTML = origHtml;

                resultBox.style.display = 'block';
                if (data.success) {
                    resultBox.style.background = '#dcfce7';
                    resultBox.style.borderLeft = '5px solid #16a34a';
                    resultBox.style.color = '#15803d';
                    resultBox.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${data.message} <a href="<?= URLROOT ?>/admin/yt_videos" style="color: #15803d; text-decoration: underline; margin-left: 10px; font-weight: 700;">পেজ রিফ্রেশ করুন</a>`;
                } else {
                    resultBox.style.background = '#fef2f2';
                    resultBox.style.borderLeft = '5px solid #dc2626';
                    resultBox.style.color = '#991b1b';
                    resultBox.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i> ${data.error || 'সিঙ্ক ব্যর্থ হয়েছে। অনুগ্রহ করে YouTube Settings-এ API Key ও Channel ID চেক করুন।'}`;
                }
            } catch (err) {
                syncBtn.disabled = false;
                syncBtn.innerHTML = origHtml;
                resultBox.style.display = 'block';
                resultBox.style.background = '#fef2f2';
                resultBox.style.borderLeft = '5px solid #dc2626';
                resultBox.style.color = '#991b1b';
                resultBox.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i> রিকোয়েস্ট ত্রুটি: ${err.message}`;
            }
        });
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
