<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #0f172a; font-family: 'Tiro Bangla', sans-serif;">
            <i class="fa-solid fa-users" style="color: #2563eb; margin-right: 8px;"></i> ব্যক্তি তালিকা (Person List)
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 0.95rem;">সকল ব্যক্তির প্রোফাইল ও তাদের অধীনে সংরক্ষিত একাধিক রেকর্ডসমূহ দেখুন</p>
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

<!-- Search Bar -->
<div style="background: white; border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
    <form method="get" action="<?= URLROOT ?>/admin/records_persons" style="display: flex; gap: 10px; flex-grow: 1; max-width: 500px;">
        <div style="position: relative; flex-grow: 1;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
            <input type="text" name="q" value="<?= htmlspecialchars($data['search'] ?? '') ?>" placeholder="নাম, উপনাম, NID বা ফোন দিয়ে খুঁজুন..." style="width: 100%; padding: 10px 14px 10px 38px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; outline: none;">
        </div>
        <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer;">
            সার্চ
        </button>
        <?php if (!empty($data['search'])): ?>
            <a href="<?= URLROOT ?>/admin/records_persons" style="background: #f1f5f9; color: #475569; padding: 10px 14px; border-radius: 10px; text-decoration: none; font-size: 0.85rem; display: flex; align-items: center;">রিসেট</a>
        <?php endif; ?>
    </form>
    <div style="color: #64748b; font-size: 0.88rem; font-weight: 600;">
        মোট ব্যক্তি: <?= count($data['persons'] ?? []) ?> জন
    </div>
</div>

<?php $persons = $data['persons'] ?? []; ?>

<?php if (empty($persons)): ?>
    <div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); min-height: 340px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px;">
        <div style="max-width: 460px;">
            <div style="width: 72px; height: 72px; border-radius: 20px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; margin-bottom: 18px;">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <h3 style="color: #0f172a; font-size: 1.3rem; font-weight: 800; margin-bottom: 8px;">কোনো ব্যক্তি পাওয়া যায়নি</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0 0 20px 0; line-height: 1.6;">নতুন রেকর্ড যোগ করার সময় ব্যক্তি স্বয়ংক্রিয়ভাবে তালিকায় অন্তর্ভুক্ত হবে অথবা একাধিক রেকর্ড একই ব্যক্তির সাথে যুক্ত করতে পারবেন।</p>
            <a href="<?= URLROOT ?>/admin/records_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; background: #2563eb; color: #fff;">
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
                        <th style="padding: 16px 20px;">নাম ও উপনাম</th>
                        <th style="padding: 16px 20px;">এনআইডি / ফোন</th>
                        <th style="padding: 16px 20px;">ঠিকানা</th>
                        <th style="padding: 16px 20px; text-align: center;">সংযুক্ত মোট রেকর্ড</th>
                        <th style="padding: 16px 20px; text-align: center;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid #f1f5f9;">
                    <?php foreach ($persons as $p): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <?php if (!empty($p['photo'])): ?>
                                    <div style="position: relative; width: 50px; height: 50px;">
                                        <img src="<?= htmlspecialchars($p['photo']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover; border: 2px solid #e2e8f0;">
                                    </div>
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <a href="<?= URLROOT ?>/admin/records_person_view/<?= $p['id'] ?>" style="color: #0f172a; font-size: 0.98rem; font-weight: 700; text-decoration: none;">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </a>
                                    <?php if (!empty($p['is_most_wanted'])): ?>
                                        <span style="background: #fef3c7; color: #b45309; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; font-weight: 700; border: 1px solid #fde68a;">
                                            ★ বিশেষ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($p['alias'])): ?>
                                    <div style="color: #64748b; font-size: 0.82rem; margin-top: 3px;">
                                        উর্বনাম: <?= htmlspecialchars($p['alias']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <?php if (!empty($p['nid_passport'])): ?>
                                    <div style="font-weight: 600; color: #334155;">NID: <?= htmlspecialchars($p['nid_passport']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($p['phone'])): ?>
                                    <div style="color: #64748b; font-size: 0.82rem; margin-top: 2px;">
                                        <i class="fa-solid fa-phone" style="font-size: 0.72rem;"></i> <?= htmlspecialchars($p['phone']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (empty($p['nid_passport']) && empty($p['phone'])): ?>
                                    <span style="color: #94a3b8;">-</span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; max-width: 240px;">
                                <?php if (!empty($p['address'])): ?>
                                    <div style="color: #475569; font-size: 0.84rem; line-height: 1.4;"><?= htmlspecialchars($p['address']) ?></div>
                                <?php else: ?>
                                    <span style="color: #94a3b8;">-</span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; text-align: center;">
                                <a href="<?= URLROOT ?>/admin/records_person_view/<?= $p['id'] ?>" style="background: #eff6ff; color: #2563eb; font-weight: 700; padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #bfdbfe;">
                                    <i class="fa-solid fa-folder-open"></i> <?= intval($p['total_records']) ?> টি রেকর্ড
                                </a>
                            </td>

                            <td style="padding: 16px 20px; vertical-align: middle; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="<?= URLROOT ?>/admin/records_person_view/<?= $p['id'] ?>" class="btn-sm" style="color: #2563eb; background: #eff6ff; border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="প্রোফাইল ও রেকর্ডসমূহ">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/records_add?person_id=<?= $p['id'] ?>" class="btn-sm" style="color: #10b981; background: #ecfdf5; border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="নতুন রেকর্ড যোগ করুন">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/records_person_delete/<?= $p['id'] ?>" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই ব্যক্তিকে মুছে ফেলতে চান?')" style="color: #ef4444; background: #fee2e2; border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="মুছে ফেলুন">
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

