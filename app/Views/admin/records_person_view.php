<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php $p = $data['person']; ?>
<?php $records = $data['records'] ?? []; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <div>
        <a href="<?= URLROOT ?>/admin/records_persons" style="color: #64748b; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
            <i class="fa-solid fa-arrow-left"></i> ব্যক্তি তালিকায় ফিরে যান
        </a>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #0f172a; font-family: 'Tiro Bangla', sans-serif;">
            <?= htmlspecialchars($p['name']) ?> &mdash; প্রোফাইল ও রেকর্ড বিবরণ
        </h1>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?= URLROOT ?>/admin/records_add?person_id=<?= $p['id'] ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; background: #2563eb; color: #fff;">
            <i class="fa-solid fa-plus-circle"></i> এঁর অধীনে নতুন রেকর্ড যোগ করুন
        </a>
    </div>
</div>

<!-- Person Profile Card -->
<div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 24px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
    <div style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
        <div style="position: relative; width: 90px; height: 90px; flex-shrink: 0;">
            <?php if (!empty($p['photo'])): ?>
                <img src="<?= htmlspecialchars($p['photo']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 90px; height: 90px; border-radius: 18px; object-fit: cover; border: 2.5px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <?php else: ?>
                <div style="width: 90px; height: 90px; border-radius: 18px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 34px;">
                    <i class="fa-solid fa-user"></i>
                </div>
            <?php endif; ?>
        </div>

        <div style="flex-grow: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 6px;">
                <h2 style="margin: 0; font-size: 1.45rem; font-weight: 800; color: #0f172a;"><?= htmlspecialchars($p['name']) ?></h2>
                <?php if (!empty($p['is_most_wanted'])): ?>
                    <span style="background: #fef3c7; color: #b45309; font-size: 0.78rem; padding: 3px 10px; border-radius: 8px; font-weight: 700; border: 1px solid #fde68a;">
                        ★ বিশেষ এন্ট্রি
                    </span>
                <?php endif; ?>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 18px; color: #64748b; font-size: 0.88rem; margin-top: 8px;">
                <?php if (!empty($p['alias'])): ?>
                    <div><strong style="color: #334155;">উপনাম:</strong> <?= htmlspecialchars($p['alias']) ?></div>
                <?php endif; ?>
                <?php if (!empty($p['nid_passport'])): ?>
                    <div><strong style="color: #334155;">NID/পাসপোর্ট:</strong> <?= htmlspecialchars($p['nid_passport']) ?></div>
                <?php endif; ?>
                <?php if (!empty($p['phone'])): ?>
                    <div><strong style="color: #334155;">ফোন:</strong> <?= htmlspecialchars($p['phone']) ?></div>
                <?php endif; ?>
                <?php if (!empty($p['gender'])): ?>
                    <div><strong style="color: #334155;">লিঙ্গ:</strong> <?= htmlspecialchars($p['gender']) ?></div>
                <?php endif; ?>
                <?php if (!empty($p['age'])): ?>
                    <div><strong style="color: #334155;">বয়স:</strong> <?= intval($p['age']) ?> বছর</div>
                <?php endif; ?>
                <?php if (!empty($p['address'])): ?>
                    <div style="width: 100%;"><strong style="color: #334155;">ঠিকানা:</strong> <?= htmlspecialchars($p['address']) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Linked Records List -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">
        <i class="fa-solid fa-folder-tree" style="color: #2563eb; margin-right: 6px;"></i> এঁর সাথে যুক্ত সকল রেকর্ড (<?= count($records) ?> টি)
    </h3>
</div>

<?php if (empty($records)): ?>
    <div class="admin-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 40px; text-align: center; color: #64748b;">
        <p style="margin: 0 0 15px 0;">এই ব্যক্তির অধীনে কোনো রেকর্ড পাওয়া যায়নি।</p>
        <a href="<?= URLROOT ?>/admin/records_add?person_id=<?= $p['id'] ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; background: #2563eb; color: #fff;">
            <i class="fa-solid fa-plus"></i> রেকর্ড যোগ করুন
        </a>
    </div>
<?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <?php foreach ($records as $r): 
            $gallery = !empty($r['gallery']) ? json_decode($r['gallery'], true) : [];
            $videos  = !empty($r['videos']) ? json_decode($r['videos'], true) : [];
            $docs    = !empty($r['documents']) ? json_decode($r['documents'], true) : [];
        ?>
            <div class="admin-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                            <span style="background: #eff6ff; color: #1d4ed8; font-weight: 700; padding: 4px 12px; border-radius: 8px; font-size: 0.82rem; border: 1px solid #dbeafe;">
                                <?= htmlspecialchars($r['crime_type'] ?: 'জেনারেল') ?>
                            </span>
                            <span style="color: #64748b; font-size: 0.82rem;">
                                তারিখ: <?= !empty($r['created_at']) ? date('d M, Y', strtotime($r['created_at'])) : '-' ?>
                            </span>
                        </div>
                    </div>
                    <a href="<?= URLROOT ?>/admin/records_delete/<?= $r['id'] ?>" onclick="return confirm('এই রেকর্ডটি কি মুছে ফেলতে চান?')" style="color: #ef4444; background: #fee2e2; border-radius: 8px; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="মুছে ফেলুন">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>

                <div style="color: #334155; font-size: 0.95rem; line-height: 1.6; margin-bottom: 14px; white-space: pre-wrap;">
                    <?= nl2br(htmlspecialchars($r['description'] ?? '')) ?>
                </div>

                <!-- Media Attachments -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 0.85rem;">
                    <?php if (!empty($gallery)): ?>
                        <div style="color: #0284c7; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-images"></i> গ্যালারি: <?= count($gallery) ?> টি ছবি
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($videos)): ?>
                        <div style="color: #dc2626; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-brands fa-google-drive"></i> ড্রাইভ ভিডিও: <?= count($videos) ?> টি
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($r['video_url'])): ?>
                        <div>
                            <a href="<?= htmlspecialchars($r['video_url']) ?>" target="_blank" style="color: #dc2626; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-video"></i> ভিডিও লিংক দেখুন
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($docs)): ?>
                        <div style="color: #4f46e5; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-file-shield"></i> ডকুমেন্টস: <?= count($docs) ?> টি
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

