<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-book-journal-whills" style="color: #10b981;"></i> সীরাত গ্রন্থাবলী ব্যবস্থাপনা (Seerah Books)
        </h1>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.92rem;">
            সীরাত পেজে প্রদর্শনের জন্য গ্রন্থসমূহ ম্যানেজ করুন এবং গুগল ড্রাইভ পিডিএফ লিংক সংযুক্ত করুন
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?= URLROOT ?>/sirat" target="_blank" class="btn" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; border-radius: 10px; padding: 9px 18px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-external-link-alt"></i> সীরাত পেজ দেখুন
        </a>
        <a href="<?= URLROOT ?>/admin/add_seerah_book" class="btn btn-primary" style="background: #10b981; border: none; border-radius: 10px; padding: 9px 20px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
            <i class="fas fa-plus-circle"></i> নতুন গ্রন্থ যুক্ত করুন
        </a>
    </div>
</div>

<?php if (isset($_SESSION['seerah_error'])): ?>
    <div style="background: #fdf2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 1.1rem;"></i>
        <span><?= htmlspecialchars($_SESSION['seerah_error']) ?></span>
        <?php unset($_SESSION['seerah_error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['seerah_success'])): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle" style="font-size: 1.1rem;"></i>
        <span><?= htmlspecialchars($_SESSION['seerah_success']) ?></span>
        <?php unset($_SESSION['seerah_success']); ?>
    </div>
<?php endif; ?>

<!-- Quick Stat Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 25px;">
    <?php 
        $allBooks = $books ?? $data['books'] ?? [];
        $totalBooks = count($allBooks);
        $withDrive = count(array_filter($allBooks, function($b) { return !empty($b['drive_link']); }));
        $activeBooks = count(array_filter($allBooks, function($b) { return ($b['status'] ?? 'active') === 'active'; }));
    ?>
    <div style="background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 18px 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">মোট সীরাত গ্রন্থ</div>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a;"><?= $totalBooks ?> টি</div>
        </div>
    </div>

    <div style="background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 18px 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
            <i class="fab fa-google-drive"></i>
        </div>
        <div>
            <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">পিডিএফ লিংক সংযুক্ত</div>
            <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb;"><?= $withDrive ?> টি</div>
        </div>
    </div>

    <div style="background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 18px 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fefce8; color: #ca8a04; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
            <i class="fas fa-check-double"></i>
        </div>
        <div>
            <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">সক্রিয় (Active) গ্রন্থ</div>
            <div style="font-size: 1.4rem; font-weight: 800; color: #16a34a;"><?= $activeBooks ?> টি</div>
        </div>
    </div>
</div>

<!-- Books List Card -->
<div class="admin-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
        <h3 style="margin: 0; color: #0f172a; font-size: 1.15rem; font-weight: 800;">
            সকল সীরাত গ্রন্থের তালিকা
        </h3>
        <span style="font-size: 0.85rem; color: #64748b;">
            ড্রাইভ লিংকে শেয়ার করা PDF ফাইলের ভিউয়ার অটোমেটিক যুক্ত হবে
        </span>
    </div>

    <div class="data-table-container">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 60px;">ক্রম</th>
                    <th style="width: 60px;">কভার</th>
                    <th>গ্রন্থের নাম ও লেখক</th>
                    <th>গুগল ড্রাইভ পিডিএফ লিংক</th>
                    <th style="text-align: center; width: 100px;">স্ট্যাটাস</th>
                    <th style="text-align: right; width: 140px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($allBooks)): ?>
                    <?php foreach ($allBooks as $book): ?>
                        <?php 
                            $hasDrive = !empty($book['drive_link']); 
                            $drivePreviewUrl = '';
                            if ($hasDrive) {
                                $link = trim($book['drive_link']);
                                if (preg_match('#/d/([a-zA-Z0-9_-]+)#', $link, $m)) {
                                    $drivePreviewUrl = "https://drive.google.com/file/d/" . $m[1] . "/preview";
                                } elseif (preg_match('#[?&]id=([a-zA-Z0-9_-]+)#', $link, $m)) {
                                    $drivePreviewUrl = "https://drive.google.com/file/d/" . $m[1] . "/preview";
                                } else {
                                    $drivePreviewUrl = $link;
                                }
                            }
                        ?>
                        <tr>
                            <td style="font-weight: 700; color: #64748b;"><?= htmlspecialchars($book['sort_order'] ?? 0) ?></td>
                            <td>
                                <?php if (!empty($book['cover_image'])): ?>
                                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover" style="width: 42px; height: 50px; border-radius: 6px; object-fit: cover; border: 1px solid #e2e8f0;">
                                <?php else: ?>
                                    <div style="width: 42px; height: 50px; border-radius: 6px; background: <?= htmlspecialchars($book['color'] ?? '#10b981') ?>; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                                        <i class="fas fa-book"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 800; font-size: 0.98rem; color: #0f172a; margin-bottom: 3px;">
                                    <?= htmlspecialchars($book['title']) ?>
                                </div>
                                <div style="font-size: 0.84rem; color: #64748b;">
                                    <i class="fas fa-feather-pointed" style="color: #10b981; margin-right: 4px;"></i> <?= htmlspecialchars($book['author'] ?? 'অজ্ঞাত/সংকলিত') ?>
                                </div>
                                <?php if (!empty($book['description'])): ?>
                                    <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= htmlspecialchars($book['description']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($hasDrive): ?>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="background: #f0fdf4; color: #166534; border: 1px solid #86efac; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fab fa-google-drive" style="color: #10b981;"></i> পিডিএফ লিংক যুক্ত আছে
                                        </span>
                                        <button type="button" onclick="previewDrivePdf('<?= htmlspecialchars(addslashes($book['title'])) ?>', '<?= htmlspecialchars(addslashes($drivePreviewUrl)) ?>')" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; padding: 4px 9px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;" title="ড্রাইভ প্রিভিউ দেখুন">
                                            <i class="fas fa-eye"></i> প্রিভিউ
                                        </button>
                                    </div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px; word-break: break-all; max-width: 320px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                        <?= htmlspecialchars($book['drive_link']) ?>
                                    </div>
                                <?php else: ?>
                                    <span style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-triangle-exclamation"></i> লিংক নেই (যুক্ত করুন)
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if (($book['status'] ?? 'active') === 'active'): ?>
                                    <span style="background: #ecfdf5; color: #059669; font-weight: 700; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid #a7f3d0;">Active</span>
                                <?php else: ?>
                                    <span style="background: #f1f5f9; color: #64748b; font-weight: 700; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid #cbd5e1;">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="<?= URLROOT ?>/admin/edit_seerah_book/<?= $book['id'] ?>" class="action-btn" title="Edit Book" style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; text-decoration: none;">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_seerah_book/<?= $book['id'] ?>" class="action-btn delete" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই সীরাত গ্রন্থটি মুছে ফেলতে চান?')" title="Delete Book" style="background: #fdf2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; text-decoration: none;">
                                        <i class="fas fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                            কোনো সীরাত গ্রন্থ পাওয়া যায়নি। উপরের "নতুন গ্রন্থ যুক্ত করুন" বাটনে ক্লিক করে যুক্ত করুন।
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Drive PDF Preview in Admin -->
<div id="adminPdfPreviewModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 2000; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 16px; width: 100%; max-width: 900px; height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <div style="padding: 14px 20px; background: #0f172a; color: white; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.05rem;" id="modalPdfBookTitle">পিডিএফ প্রিভিউ</div>
            <button type="button" onclick="closeDrivePreviewModal()" style="background: rgba(255,255,255,0.15); border: none; color: white; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 1rem;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="flex: 1; position: relative; background: #f8fafc;">
            <iframe id="modalPdfFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>
</div>

<script>
    function previewDrivePdf(title, url) {
        document.getElementById('modalPdfBookTitle').innerText = title;
        document.getElementById('modalPdfFrame').src = url;
        document.getElementById('adminPdfPreviewModal').style.display = 'flex';
    }

    function closeDrivePreviewModal() {
        document.getElementById('adminPdfPreviewModal').style.display = 'none';
        document.getElementById('modalPdfFrame').src = '';
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('adminPdfPreviewModal');
        if (e.target === modal) {
            closeDrivePreviewModal();
        }
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

