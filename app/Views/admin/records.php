<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #0f172a; font-family: 'Tiro Bangla', sans-serif;">
            <i class="fa-solid fa-database" style="color: #2563eb; margin-right: 8px;"></i> রেকর্ড তালিকা (Record List)
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 0.95rem;">সংরক্ষিত সকল রেকর্ড দেখুন ও পরিচালনা করুন (ছবি, ভিডিও এবং ফাইলসমূহ গুগল ড্রাইভে সংরক্ষিত)</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/records_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; background: #2563eb; border: none; color: #fff;">
            <i class="fa-solid fa-plus-circle"></i> নতুন রেকর্ড যোগ করুন
        </a>
    </div>
</div>

<?php if (!empty($data['flash_success'])): ?>
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10b981;"></i>
        <span><?= htmlspecialchars($data['flash_success']) ?></span>
    </div>
<?php endif; ?>

<?php if (!empty($data['flash_error'])): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.2rem; color: #ef4444;"></i>
        <span><?= htmlspecialchars($data['flash_error']) ?></span>
    </div>
<?php endif; ?>

<?php $records = $data['records'] ?? []; ?>

<?php if (empty($records)): ?>
    <div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); min-height: 380px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px;">
        <div style="max-width: 480px;">
            <div style="width: 76px; height: 76px; border-radius: 22px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 20px; border: 1.5px solid #bfdbfe;">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 style="color: #0f172a; font-size: 1.35rem; font-weight: 800; margin-bottom: 8px;">এখনও কোনো রেকর্ড যুক্ত করা হয়নি</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0 0 24px 0; line-height: 1.6;">নতুন রেকর্ড যোগ করতে উপরের 'নতুন রেকর্ড যোগ করুন' বাটনে ক্লিক করুন। সকল মিডিয়া ও ফাইল গুগল ড্রাইভে স্বয়ংক্রিয়ভাবে সংরক্ষিত হবে।</p>
            <a href="<?= URLROOT ?>/admin/records_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; background: #2563eb; color: #fff;">
                <i class="fa-solid fa-plus"></i> রেকর্ড যোগ করুন
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); overflow: hidden; padding: 0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 700;">
                        <th style="padding: 16px 20px;">ছবি</th>
                        <th style="padding: 16px 20px;">নাম ও পরিচয়</th>
                        <th style="padding: 16px 20px;">ক্যাটাগরি</th>
                        <th style="padding: 16px 20px;">ঠিকানা ও যোগাযোগ</th>
                        <th style="padding: 16px 20px;">মিডিয়া ও ড্রাইভ ফাইলসমূহ</th>
                        <th style="padding: 16px 20px;">তারিখ</th>
                        <th style="padding: 16px 20px; text-align: center;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid #f1f5f9;">
                    <?php foreach ($records as $r): 
                        $gallery = !empty($r['gallery']) ? json_decode($r['gallery'], true) : [];
                        $videos  = !empty($r['videos']) ? json_decode($r['videos'], true) : [];
                        $docs    = !empty($r['documents']) ? json_decode($r['documents'], true) : [];
                    ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <?php if (!empty($r['photo'])): ?>
                                    <div style="position: relative; width: 56px; height: 56px;">
                                        <img src="<?= htmlspecialchars($r['photo']) ?>" alt="<?= htmlspecialchars($r['name']) ?>" style="width: 56px; height: 56px; border-radius: 12px; object-fit: cover; border: 2px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                        <?php if (strpos($r['photo'], 'googleusercontent.com') !== false || strpos($r['photo'], 'drive.google.com') !== false): ?>
                                            <span title="Stored in Google Drive" style="position: absolute; bottom: -4px; right: -4px; width: 18px; height: 18px; border-radius: 50%; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; font-size: 10px; color: #2563eb;">
                                                <i class="fa-brands fa-google-drive"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div style="width: 56px; height: 56px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <strong style="color: #0f172a; font-size: 1rem;"><?= htmlspecialchars($r['name']) ?></strong>
                                    <?php if (!empty($r['is_most_wanted'])): ?>
                                        <span style="background: #fef3c7; color: #b45309; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; font-weight: 700; border: 1px solid #fde68a;">
                                            ★ বিশেষ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($r['alias'])): ?>
                                    <div style="color: #64748b; font-size: 0.82rem; margin-top: 3px;">
                                        <i class="fa-solid fa-tag" style="font-size: 0.75rem;"></i> <?= htmlspecialchars($r['alias']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($r['nid_passport'])): ?>
                                    <div style="color: #64748b; font-size: 0.8rem; margin-top: 2px;">
                                        NID: <?= htmlspecialchars($r['nid_passport']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <?php if (!empty($r['crime_type'])): ?>
                                    <span style="display: inline-block; background: #eff6ff; color: #1d4ed8; padding: 4px 10px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; border: 1px solid #dbeafe;">
                                        <?= htmlspecialchars($r['crime_type']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #94a3b8;">-</span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; max-width: 200px;">
                                <?php if (!empty($r['address'])): ?>
                                    <div style="color: #334155; font-size: 0.85rem; line-height: 1.4;"><?= htmlspecialchars($r['address']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($r['phone'])): ?>
                                    <div style="color: #64748b; font-size: 0.8rem; margin-top: 3px;">
                                        <i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> <?= htmlspecialchars($r['phone']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <div style="display: flex; flex-direction: column; gap: 4px; font-size: 0.82rem;">
                                    <?php if (!empty($gallery)): ?>
                                        <div style="color: #0284c7; display: flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-images"></i> গ্যালারি: <?= count($gallery) ?> ছবি
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($videos)): ?>
                                        <div style="color: #dc2626; display: flex; align-items: center; gap: 6px;">
                                            <i class="fa-brands fa-google-drive"></i> ভিডিও ফাইল: <?= count($videos) ?> টি (GDrive)
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($r['video_url'])): ?>
                                        <div>
                                            <a href="<?= htmlspecialchars($r['video_url']) ?>" target="_blank" style="color: #dc2626; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-video"></i> ভিডিও লিংক
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($docs)): ?>
                                        <div style="color: #4f46e5; display: flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-file-shield"></i> ডকুমেন্টস: <?= count($docs) ?> টি
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($gallery) && empty($videos) && empty($r['video_url']) && empty($docs)): ?>
                                        <span style="color: #94a3b8;">অতিরিক্ত ফাইল নেই</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; color: #64748b; font-size: 0.82rem; white-space: nowrap;">
                                <?= !empty($r['created_at']) ? date('M d, Y', strtotime($r['created_at'])) : '-' ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                    <a href="<?= URLROOT ?>/admin/records_edit/<?= $r['id'] ?>" style="color: #2563eb; background: #eff6ff; border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" title="এডিট করুন">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/records_delete/<?= $r['id'] ?>" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই রেকর্ডটি মুছে ফেলতে চান?')" style="color: #ef4444; background: #fee2e2; border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" title="মুছে ফেলুন">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
