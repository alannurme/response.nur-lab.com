<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$persons = $data['persons'] ?? [];
$records = $data['records'] ?? [];
$search = $data['search'] ?? '';
$totalPersons = count($persons);
$totalRecords = count($records);
?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #0f172a; font-family: 'Tiro Bangla', sans-serif;">
            <i class="fa-solid fa-users-viewfinder" style="color: #2563eb; margin-right: 8px;"></i> ব্যক্তিভিত্তিক রেকর্ড তালিকা (Person-wise Records)
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 0.95rem;">ব্যক্তি কার্ডে ক্লিক করে তার সাথে সম্পর্কিত সকল রেকর্ড, গুগল ড্রাইভের ছবি ও ভিডিও দেখুন</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?= URLROOT ?>/admin/records_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; background: #2563eb; border: none; color: #fff; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
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

<!-- Search Bar & Statistics Overview -->
<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <form method="GET" action="<?= URLROOT ?>/admin/records" style="display: flex; gap: 10px; flex-grow: 1; max-width: 500px;">
        <div style="position: relative; flex-grow: 1;">
            <i class="fa-solid fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="নাম, উপনাম, NID বা ফোন দিয়ে খুঁজুন..." style="width: 100%; padding: 11px 16px 11px 40px; border-radius: 12px; border: 1.5px solid #cbd5e1; outline: none; font-size: 0.92rem; background: white; box-sizing: border-box;">
        </div>
        <button type="submit" style="background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; cursor: pointer;">
            সার্চ
        </button>
        <?php if (!empty($search)): ?>
            <a href="<?= URLROOT ?>/admin/records" style="background: #f1f5f9; color: #475569; padding: 10px 16px; border-radius: 12px; text-decoration: none; font-size: 0.9rem; display: flex; align-items: center;">
                রিসেট
            </a>
        <?php endif; ?>
    </form>

    <div style="display: flex; gap: 15px; font-size: 0.9rem; color: #64748b; font-weight: 600;">
        <span style="background: white; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 10px;">
            <i class="fa-solid fa-user-group" style="color: #2563eb;"></i> মোট ব্যক্তি: <strong style="color: #0f172a;"><?= $totalPersons ?></strong>
        </span>
        <span style="background: white; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 10px;">
            <i class="fa-solid fa-file-lines" style="color: #10b981;"></i> মোট রেকর্ড এন্ট্রি: <strong style="color: #0f172a;"><?= $totalRecords ?></strong>
        </span>
    </div>
</div>

<?php if (empty($persons)): ?>
    <div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); min-height: 380px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px;">
        <div style="max-width: 480px;">
            <div style="width: 76px; height: 76px; border-radius: 22px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 20px; border: 1.5px solid #bfdbfe;">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 style="color: #0f172a; font-size: 1.35rem; font-weight: 800; margin-bottom: 8px;">কোনো রেকর্ড বা ব্যক্তি পাওয়া যায়নি</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0 0 24px 0; line-height: 1.6;">নতুন রেকর্ড যোগ করতে উপরের 'নতুন রেকর্ড যোগ করুন' বাটনে ক্লিক করুন। ব্যক্তির ছবি, ভিডিও ও ফাইলগুলো স্বয়ংক্রিয়ভাবে গুগল ড্রাইভে সেভ হবে।</p>
            <a href="<?= URLROOT ?>/admin/records_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; background: #2563eb; color: #fff;">
                <i class="fa-solid fa-plus"></i> প্রথম রেকর্ড যোগ করুন
            </a>
        </div>
    </div>
<?php else: ?>
    <!-- Person-Wise Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr)); gap: 24px;">
        <?php foreach ($persons as $p): ?>
            <div class="person-card-item" style="background: white; border-radius: 20px; border: 1.5px solid #e2e8f0; box-shadow: 0 8px 24px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.25s ease; display: flex; flex-direction: column;">
                <!-- Card Header with Photo & Basic Info -->
                <a href="<?= URLROOT ?>/admin/records_person_view/<?= $p['id'] ?>" style="text-decoration: none; color: inherit; padding: 22px; display: flex; gap: 18px; align-items: center; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                    <div style="position: relative; width: 72px; height: 72px; flex-shrink: 0;">
                        <?php if (!empty($p['photo'])): ?>
                            <img src="<?= htmlspecialchars($p['photo']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 72px; height: 72px; border-radius: 16px; object-fit: cover; border: 2px solid #e2e8f0; box-shadow: 0 3px 8px rgba(0,0,0,0.06);">
                            <?php if (strpos($p['photo'], 'googleusercontent.com') !== false || strpos($p['photo'], 'drive.google.com') !== false): ?>
                                <span title="Google Drive Synced" style="position: absolute; bottom: -3px; right: -3px; width: 20px; height: 20px; border-radius: 50%; background: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; font-size: 11px; color: #0f9d58;">
                                    <i class="fa-brands fa-google-drive"></i>
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <div style="width: 72px; height: 72px; border-radius: 16px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 28px; border: 1.5px solid #bfdbfe;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="flex-grow: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= htmlspecialchars($p['name']) ?>
                            </h3>
                            <?php if (!empty($p['is_most_wanted'])): ?>
                                <span style="background: #fef3c7; color: #b45309; font-size: 0.7rem; padding: 2px 7px; border-radius: 6px; font-weight: 800; border: 1px solid #fde68a; flex-shrink: 0;">
                                    ★ বিশেষ
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($p['alias'])): ?>
                            <div style="color: #64748b; font-size: 0.84rem; margin-bottom: 3px;">
                                <i class="fa-solid fa-tag" style="font-size: 0.75rem; color: #94a3b8;"></i> ডাকনাম: <strong><?= htmlspecialchars($p['alias']) ?></strong>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($p['nid_passport'])): ?>
                            <div style="color: #64748b; font-size: 0.8rem;">
                                NID: <?= htmlspecialchars($p['nid_passport']) ?>
                            </div>
                        <?php elseif (!empty($p['phone'])): ?>
                            <div style="color: #64748b; font-size: 0.8rem;">
                                <i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> <?= htmlspecialchars($p['phone']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>

                <!-- Card Body / Media Counter Badges (Google Drive Files) -->
                <div style="padding: 16px 20px; flex-grow: 1; background: #fafafa;">
                    <div style="font-size: 0.82rem; font-weight: 700; color: #475569; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-brands fa-google-drive" style="color: #0f9d58;"></i> ড্রাইভে সংযুক্ত ফাইলসমূহ:</span>
                        <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 12px; font-weight: 800; font-size: 0.78rem;">
                            <?= intval($p['total_records']) ?> টি রেকর্ড
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; text-align: center;">
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px 4px;">
                            <div style="color: #0284c7; font-size: 1.1rem; font-weight: 800;"><?= intval($p['total_gallery']) ?></div>
                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;"><i class="fa-solid fa-images"></i> ছবি</div>
                        </div>
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px 4px;">
                            <div style="color: #dc2626; font-size: 1.1rem; font-weight: 800;"><?= intval($p['total_videos']) ?></div>
                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;"><i class="fa-solid fa-video"></i> ভিডিও</div>
                        </div>
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px 4px;">
                            <div style="color: #4f46e5; font-size: 1.1rem; font-weight: 800;"><?= intval($p['total_docs']) ?></div>
                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;"><i class="fa-solid fa-file"></i> ফাইল</div>
                        </div>
                    </div>

                    <?php if (!empty($p['address'])): ?>
                        <div style="margin-top: 12px; font-size: 0.8rem; color: #64748b; line-height: 1.4; display: flex; align-items: flex-start; gap: 6px;">
                            <i class="fa-solid fa-location-dot" style="color: #ef4444; margin-top: 2px; flex-shrink: 0;"></i>
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($p['address']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Card Footer / Actions -->
                <div style="padding: 12px 20px; background: white; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= URLROOT ?>/admin/records_person_view/<?= $p['id'] ?>" class="btn" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.85rem; font-weight: 700; padding: 6px 14px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-folder-open"></i> রেকর্ডসমূহ দেখুন
                    </a>

                    <div style="display: flex; gap: 6px;">
                        <a href="<?= URLROOT ?>/admin/records_add?person_id=<?= $p['id'] ?>" title="এঁর অধীনে নতুন রেকর্ড যোগ করুন" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 8px; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        <a href="<?= URLROOT ?>/admin/records_person_delete/<?= $p['id'] ?>" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই ব্যক্তি এবং এঁর সকল রেকর্ড মুছে ফেলতে চান?')" title="মুছে ফেলুন" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 8px; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                            <i class="fa-solid fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.person-card-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(0,0,0,0.08) !important;
    border-color: #93c5fd !important;
}
</style>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
