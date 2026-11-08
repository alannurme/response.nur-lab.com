<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.social-wrap {
    font-family: 'Hind Siliguri', sans-serif;
}
.social-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.03);
}
.social-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: transform 0.2s;
}
.social-icon-box:hover {
    transform: scale(1.1);
}
.soc-act-btn {
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
.soc-act-btn:hover {
    transform: translateY(-2px);
}
.soc-act-edit {
    background: #eff6ff;
    color: #2563eb;
}
.soc-act-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.soc-act-del {
    background: #fef2f2;
    color: #dc2626;
}
.soc-act-del:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<div class="social-wrap">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-share-alt" style="color: #0b7c4d;"></i> সোশ্যাল মিডিয়া লিংক (Social Media)
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.95rem;">
                ওয়েবসাইটের টপবার ও ফুটারে প্রদর্শিত সোশ্যাল মিডিয়া লিংকগুলো পরিচালনা করুন
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-globe"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">মোট সোশ্যাল লিংক</div>
                    <div style="font-size: 1.2rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        <?= !empty($data['social_links']) ? count($data['social_links']) : 0 ?> টি
                    </div>
                </div>
            </div>
            <a href="<?= URLROOT ?>/admin/add_social_link" class="btn" style="background: #0b7c4d; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 0.92rem; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
                <i class="fas fa-plus-circle"></i> নতুন সোশ্যাল মিডিয়া যোগ করুন
            </a>
        </div>
    </div>

    <?php if (isset($data['success'])): ?>
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="font-size: 1.15rem;"></i>
            <span><?= $data['success'] ?></span>
        </div>
    <?php endif; ?>

    <!-- Social Links Card -->
    <div class="social-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px;">
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-list-ul" style="color: #2563eb;"></i> সক্রিয় সোশ্যাল প্ল্যাটফর্মসমূহ
            </h3>
            <div style="position: relative; width: 260px;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                <input type="text" id="socialSearchInput" onkeyup="filterSocialLinks()" placeholder="প্ল্যাটফর্ম বা লিংক খুঁজুন..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        <th style="padding: 12px 18px; border-radius: 10px 0 0 10px; width: 80px;">আইকন</th>
                        <th style="padding: 12px 18px;">প্ল্যাটফর্মের নাম</th>
                        <th style="padding: 12px 18px;">প্রোফাইল / পেজ লিংক URL</th>
                        <th style="padding: 12px 18px; text-align: center; width: 120px;">ক্রম (Order)</th>
                        <th style="padding: 12px 18px; text-align: right; border-radius: 0 10px 10px 0; width: 120px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="socialTableBody">
                    <?php if(!empty($data['social_links'])): ?>
                        <?php foreach ($data['social_links'] as $link): ?>
                        <tr class="social-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                            <td style="padding: 12px 18px;">
                                <div class="social-icon-box">
                                    <i class="<?= htmlspecialchars($link['icon']) ?>" style="color: #0b7c4d;"></i>
                                </div>
                            </td>
                            <td style="padding: 12px 18px;">
                                <span style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">
                                    <?= htmlspecialchars($link['name']) ?>
                                </span>
                            </td>
                            <td style="padding: 12px 18px;">
                                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" style="color: #2563eb; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 600; max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <i class="fas fa-external-link-alt" style="font-size: 0.78rem;"></i>
                                    <?= htmlspecialchars($link['url']) ?>
                                </a>
                            </td>
                            <td style="padding: 12px 18px; text-align: center;">
                                <span style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 0.85rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: inline-block;">
                                    <?= htmlspecialchars($link['order_index']) ?>
                                </span>
                            </td>
                            <td style="padding: 12px 18px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="<?= URLROOT ?>/admin/edit_social_link/<?= $link['id'] ?>" class="soc-act-btn soc-act-edit" title="লিংক সম্পাদনা">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_social_link/<?= $link['id'] ?>" class="soc-act-btn soc-act-del" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই সোশ্যাল মিডিয়া লিংকটি মুছে ফেলতে চান?')" title="লিংক ডিলিট">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 50px 20px; font-size: 0.95rem;">
                                <i class="fas fa-share-alt" style="font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                কোনো সোশ্যাল মিডিয়া লিংক পাওয়া যায়নি। উপরে "নতুন সোশ্যাল মিডিয়া যোগ করুন" বাটনে ক্লিক করে যুক্ত করুন।
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterSocialLinks() {
    const q = document.getElementById('socialSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.social-row');
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
