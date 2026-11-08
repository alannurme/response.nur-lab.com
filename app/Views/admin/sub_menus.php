<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.top-menu-wrap {
    font-family: 'Hind Siliguri', sans-serif;
}
.top-menu-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.03);
}
.menu-act-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.2s all;
    font-size: 0.9rem;
}
.menu-act-btn:hover {
    transform: translateY(-2px);
}
.menu-act-edit {
    background: #eff6ff;
    color: #2563eb;
}
.menu-act-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.menu-act-del {
    background: #fef2f2;
    color: #dc2626;
}
.menu-act-del:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<div class="top-menu-wrap">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-compass" style="color: #0b7c4d;"></i> টপ বার মেনু ম্যানেজার (Top Bar Menus)
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.95rem;">
                ওয়েবসাইটের একদম ওপরের সেকেন্ডারি টপবারে প্রদর্শিত মেনু আইটেমসমূহ পরিচালনা করুন
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-list"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">মোট টপ মেনু</div>
                    <div style="font-size: 1.2rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        <?= !empty($data['menus']) ? count($data['menus']) : 0 ?> টি
                    </div>
                </div>
            </div>
            <a href="<?= URLROOT ?>/admin/add_sub_menu" class="btn" style="background: #0b7c4d; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 0.92rem; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
                <i class="fas fa-plus-circle"></i> নতুন টপ মেনু যোগ করুন
            </a>
        </div>
    </div>

    <!-- Menus Table Card -->
    <div class="top-menu-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px;">
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-list-ul" style="color: #2563eb;"></i> সকল টপ বার মেনু তালিকা
            </h3>
            <div style="position: relative; width: 260px;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                <input type="text" id="topMenuSearchInput" onkeyup="filterTopMenus()" placeholder="মেনু নাম বা লিংক খুঁজুন..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        <th style="padding: 12px 18px; border-radius: 10px 0 0 10px;">মেনুর শিরোনাম</th>
                        <th style="padding: 12px 18px;">নেভিগেশন URL</th>
                        <th style="padding: 12px 18px; text-align: center; width: 120px;">ক্রম (Order)</th>
                        <th style="padding: 12px 18px; text-align: right; border-radius: 0 10px 10px 0; width: 120px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="topMenuTableBody">
                    <?php if(!empty($data['menus'])): ?>
                        <?php foreach ($data['menus'] as $menu): ?>
                        <tr class="top-menu-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                            <td style="padding: 12px 18px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 8px; height: 8px; background: #0b7c4d; border-radius: 50%;"></div>
                                    <span style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">
                                        <?= htmlspecialchars($menu['title']) ?>
                                    </span>
                                </div>
                            </td>
                            <td style="padding: 12px 18px;">
                                <code style="background: #f1f5f9; padding: 5px 12px; border-radius: 8px; color: #0b7c4d; font-weight: 600; font-size: 0.88rem;">
                                    <?= htmlspecialchars($menu['url']) ?>
                                </code>
                            </td>
                            <td style="padding: 12px 18px; text-align: center;">
                                <span style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 0.85rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: inline-block;">
                                    <?= htmlspecialchars($menu['order_index']) ?>
                                </span>
                            </td>
                            <td style="padding: 12px 18px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="<?= URLROOT ?>/admin/edit_sub_menu/<?= $menu['id'] ?>" class="menu-act-btn menu-act-edit" title="মেনু সম্পাদনা">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_sub_menu/<?= $menu['id'] ?>" class="menu-act-btn menu-act-del" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই টপ মেনু আইটেমটি মুছে ফেলতে চান?')" title="মেনু ডিলিট">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 50px 20px; font-size: 0.95rem;">
                                <i class="fas fa-compass" style="font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                কোনো টপ মেনু পাওয়া যায়নি। উপরে "নতুন টপ মেনু যোগ করুন" বাটনে ক্লিক করে যুক্ত করুন।
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterTopMenus() {
    const q = document.getElementById('topMenuSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.top-menu-row');
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
