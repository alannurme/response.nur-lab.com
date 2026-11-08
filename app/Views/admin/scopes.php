<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.scopes-wrap {
    font-family: 'Hind Siliguri', sans-serif;
}
.scope-card-wrap {
    background: #ffffff;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.03);
}
.scope-icon-box {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: #ecfdf5;
    color: #0b7c4d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    border: 1px solid #a7f3d0;
}
.scope-act-btn {
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
.scope-act-btn:hover {
    transform: translateY(-2px);
}
.scope-act-edit {
    background: #eff6ff;
    color: #2563eb;
}
.scope-act-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.scope-act-del {
    background: #fef2f2;
    color: #dc2626;
}
.scope-act-del:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<div class="scopes-wrap">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-briefcase" style="color: #0b7c4d;"></i> আমাদের কার্যপরিধি (Scopes of Work)
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.95rem;">
                ওয়েবসাইটের হোমপেজে প্রদর্শিত ডায়নামিক কার্যপরিধি কার্ড ও বিবরণী ম্যানেজ করুন
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-cubes"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">মোট কার্যপরিধি</div>
                    <div style="font-size: 1.2rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        <?= !empty($data['scopes']) ? count($data['scopes']) : 0 ?> টি
                    </div>
                </div>
            </div>
            <a href="<?= URLROOT ?>/admin/add_scope" class="btn" style="background: #0b7c4d; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 0.92rem; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
                <i class="fas fa-plus-circle"></i> নতুন কার্যপরিধি যোগ করুন
            </a>
        </div>
    </div>

    <!-- Section Visibility Control Card -->
    <div style="margin-bottom: 25px; padding: 22px 26px; display: flex; align-items: center; justify-content: space-between; background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(0,0,0,0.03); flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
                <i class="fas fa-eye"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">হোমপেজে কার্যপরিধি সেকশনের ভিজিবিলিটি</h3>
                <p style="margin: 3px 0 0 0; font-size: 0.9rem; color: #64748b;">ওয়েবসাইটে এই সেকশনটি চালু (Visible) বা বন্ধ (Hidden) রাখুন</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 14px;">
            <?php $isActive = (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1'); ?>
            <span id="scope-status-badge" style="font-size: 0.88rem; padding: 6px 14px; border-radius: 20px; font-weight: 800; display: inline-block; background: <?= $isActive ? '#ecfdf5' : '#fef2f2' ?>; color: <?= $isActive ? '#047857' : '#dc2626' ?>; border: 1px solid <?= $isActive ? '#a7f3d0' : '#fecaca' ?>;">
                <?= $isActive ? 'সক্রিয় (চালু আছে)' : 'বন্ধ (লুকানো আছে)' ?>
            </span>
            <button type="button" onclick="toggleScopesSectionVisibility()" class="btn" style="background: #0f172a; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <i class="fas fa-toggle-on"></i> স্ট্যাটাস পরিবর্তন
            </button>
        </div>
    </div>

    <!-- Scopes List Card -->
    <div class="scope-card-wrap">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px;">
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-list-ul" style="color: #2563eb;"></i> সকল কার্যপরিধি তালিকা
            </h3>
            <div style="position: relative; width: 260px;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                <input type="text" id="scopeSearchInput" onkeyup="filterScopes()" placeholder="শিরোনাম বা বিবরণ খুঁজুন..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        <th style="padding: 12px 18px; border-radius: 10px 0 0 10px; width: 80px;">আইকন</th>
                        <th style="padding: 12px 18px; width: 200px;">কার্যপরিধি শিরোনাম</th>
                        <th style="padding: 12px 18px;">বিবরণ (Description)</th>
                        <th style="padding: 12px 18px; text-align: center; width: 100px;">ক্রম</th>
                        <th style="padding: 12px 18px; text-align: right; border-radius: 0 10px 10px 0; width: 120px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="scopeTableBody">
                    <?php if (!empty($data['scopes'])): ?>
                        <?php foreach ($data['scopes'] as $scope): ?>
                        <tr class="scope-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                            <td style="padding: 12px 18px;">
                                <div class="scope-icon-box">
                                    <i class="<?= htmlspecialchars($scope['icon']) ?>"></i>
                                </div>
                            </td>
                            <td style="padding: 12px 18px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">
                                    <?= htmlspecialchars($scope['title']) ?>
                                </div>
                            </td>
                            <td style="padding: 12px 18px; max-width: 380px;">
                                <div style="max-height: 55px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.45; color: #64748b; font-size: 0.88rem;">
                                    <?= htmlspecialchars($scope['description']) ?>
                                </div>
                            </td>
                            <td style="padding: 12px 18px; text-align: center;">
                                <span style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 0.85rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: inline-block;">
                                    <?= htmlspecialchars($scope['order_index']) ?>
                                </span>
                            </td>
                            <td style="padding: 12px 18px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="<?= URLROOT ?>/admin/edit_scope/<?= $scope['id'] ?>" class="scope-act-btn scope-act-edit" title="কার্যপরিধি সম্পাদনা">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_scope/<?= $scope['id'] ?>" class="scope-act-btn scope-act-del" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই কার্যপরিধিটি মুছে ফেলতে চান?')" title="কার্যপরিধি ডিলিট">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 50px 20px; font-size: 0.95rem;">
                                <i class="fas fa-briefcase" style="font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                কোনো কার্যপরিধি পাওয়া যায়নি। উপরে "নতুন কার্যপরিধি যোগ করুন" বাটনে ক্লিক করে যুক্ত করুন।
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterScopes() {
    const q = document.getElementById('scopeSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.scope-row');
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}

function toggleScopesSectionVisibility() {
    const badge = document.getElementById('scope-status-badge');
    const isCurrentlyActive = badge.textContent.includes('সক্রিয়');
    const newValue = isCurrentlyActive ? '0' : '1';
    
    const formData = new FormData();
    formData.append('settings[show_scopes]', newValue);
    
    fetch('<?= URLROOT ?>/admin/settings', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        if (newValue === '1') {
            badge.textContent = 'সক্রিয় (চালু আছে)';
            badge.style.background = '#ecfdf5';
            badge.style.color = '#047857';
            badge.style.borderColor = '#a7f3d0';
        } else {
            badge.textContent = 'বন্ধ (লুকানো আছে)';
            badge.style.background = '#fef2f2';
            badge.style.color = '#dc2626';
            badge.style.borderColor = '#fecaca';
        }
    })
    .catch(err => {
        alert('ভিজিবিলিটি আপডেট ব্যর্থ হয়েছে।');
        console.error(err);
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
