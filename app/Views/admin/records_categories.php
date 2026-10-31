<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="font-family: 'Hind Siliguri', sans-serif; font-size: 1.8rem; margin: 0 0 6px;">
            <i class="fas fa-tags" style="color: var(--primary); font-size: 1.6rem; vertical-align: middle;"></i> রেকর্ড ক্যাটাগরি (Categories)
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
            রেকর্ডের ক্যাটাগরি সমূহ তৈরি, সম্পাদনা ও পরিচালনা করুন। এখানে যুক্ত ক্যাটাগরিগুলো স্বয়ংক্রিয়ভাবে <strong>Add Record</strong> ফর্মে চলে যাবে।
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <a href="<?= URLROOT ?>/admin/records_add" class="btn" style="background: white; color: #334155; border: 1.5px solid #cbd5e1; padding: 10px 18px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;">
            <i class="fas fa-plus-circle" style="color: #0f9d58;"></i> Add Record ফর্ম দেখুন
        </a>
        <button type="button" onclick="openAddCategoryModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 11px 22px; border-radius: 12px; font-weight: 700; cursor: pointer; border: none; box-shadow: 0 4px 14px var(--primary-glow);">
            <i class="fas fa-plus"></i> + নতুন ক্যাটাগরি যোগ করুন
        </button>
    </div>
</div>

<?php if (!empty($data['flash_success'])): ?>
    <div class="alert alert-success" style="background: #dcfce7; color: #166534; border: 1px solid #86efac; border-radius: 12px; padding: 14px 20px; margin-bottom: 20px; font-weight: 600;">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($data['flash_success']) ?>
    </div>
<?php endif; ?>

<?php if (!empty($data['flash_error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 12px; padding: 14px 20px; margin-bottom: 20px; font-weight: 600;">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($data['flash_error']) ?>
    </div>
<?php endif; ?>

<!-- Quick Stats Bar -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 25px;">
    <div style="background: white; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;">মোট ক্যাটাগরি সংখ্যা</div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1.2;">
                <?= count($data['categories'] ?? []) ?> টি
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div style="width: 52px; height: 52px; border-radius: 14px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
            <i class="fas fa-check-double"></i>
        </div>
        <div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;">স্বয়ংক্রিয় সিঙ্ক স্ট্যাটাস</div>
            <div style="font-size: 1rem; font-weight: 700; color: #166534; line-height: 1.2;">
                Active &amp; Live in Add Record Form
            </div>
        </div>
    </div>
</div>

<!-- Category List Table Card -->
<div class="admin-card" style="background: white; border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 20px 25px; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; background: #fafbfc;">
        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #1e293b; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-list-ul" style="color: var(--primary);"></i> ক্যাটাগরি তালিকা (Category List)
        </h3>
        <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">
            সর্বমোট: <?= count($data['categories'] ?? []) ?> টি ক্যাটাগরি
        </span>
    </div>

    <?php if (empty($data['categories'])): ?>
        <div style="text-align: center; padding: 60px 20px; color: #64748b;">
            <div style="width: 80px; height: 80px; border-radius: 24px; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; color: #94a3b8; margin-bottom: 15px;">
                <i class="fas fa-folder-open"></i>
            </div>
            <h4 style="margin: 0 0 8px; color: #1e293b; font-size: 1.2rem; font-weight: 700;">কোনো ক্যাটাগরি পাওয়া যায়নি</h4>
            <p style="margin: 0 0 20px; font-size: 0.9rem;">নতুন ক্যাটাগরি তৈরি করতে উপরের '+ নতুন ক্যাটাগরি যোগ করুন' বাটনে ক্লিক করুন।</p>
            <button type="button" onclick="openAddCategoryModal()" class="btn btn-primary" style="padding: 10px 22px; border-radius: 10px; font-weight: 700; cursor: pointer; border: none;">
                <i class="fas fa-plus"></i> প্রথম ক্যাটাগরি যোগ করুন
            </button>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 700; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 15px 20px; width: 60px;">#ID</th>
                        <th style="padding: 15px 20px; min-width: 220px;">ক্যাটাগরির নাম (Category Name)</th>
                        <th style="padding: 15px 20px; min-width: 260px;">বিবরণ (Description)</th>
                        <th style="padding: 15px 20px; min-width: 180px;">Add Record ফর্মে প্রদর্শন (Pill)</th>
                        <th style="padding: 15px 20px; width: 140px; text-align: right;">অ্যাকশন (Actions)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['categories'] as $cat): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                            <td style="padding: 16px 20px; color: #94a3b8; font-weight: 600; font-size: 0.85rem;">
                                #<?= htmlspecialchars($cat['id']) ?>
                            </td>
                            <td style="padding: 16px 20px;">
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.98rem; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary); display: inline-block;"></span>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </div>
                            </td>
                            <td style="padding: 16px 20px; color: #475569; line-height: 1.5; font-size: 0.88rem;">
                                <?= !empty($cat['description']) ? htmlspecialchars($cat['description']) : '<span style="color: #94a3b8; font-style: italic;">কোনো বিবরণ নেই</span>' ?>
                            </td>
                            <td style="padding: 16px 20px;">
                                <span style="display: inline-block; background: #f8fafc; border: 1.5px solid #e2e8f0; color: #334155; padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600;">
                                    <i class="fas fa-tag" style="font-size: 0.72rem; color: #64748b; margin-right: 4px;"></i> <?= htmlspecialchars($cat['name']) ?>
                                </span>
                            </td>
                            <td style="padding: 16px 20px; text-align: right;">
                                <div style="display: inline-flex; gap: 8px; align-items: center;">
                                    <button type="button" onclick='openEditCategoryModal(<?= json_encode($cat, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="btn" style="background: #f1f5f9; color: #2563eb; border: 1px solid #cbd5e1; padding: 7px 12px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s;" title="সম্পাদনা করুন">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" onclick="confirmDeleteCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')" class="btn" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 7px 12px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s;" title="মুছে ফেলুন">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Add / Edit Category Modal -->
<div id="categoryModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 10001; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 20px;">
    <div style="background: white; border-radius: 18px; width: 100%; max-width: 540px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35); animation: fadeIn 0.25s ease;">
        <!-- Modal Header -->
        <div style="padding: 20px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 id="categoryModalTitle" style="font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif; font-size: 1.2rem;">
                <i class="fas fa-tag" style="color: var(--primary);"></i> নতুন ক্যাটাগরি তৈরি করুন
            </h3>
            <button type="button" onclick="closeCategoryModal()" style="background: none; border: none; font-size: 1.4rem; color: #64748b; cursor: pointer; transition: 0.2s; line-height: 1;"><i class="fas fa-times"></i></button>
        </div>

        <!-- Form -->
        <form action="<?= URLROOT ?>/admin/records_categories_save" method="POST" id="categoryForm">
            <input type="hidden" name="id" id="cat_id" value="">

            <div style="padding: 25px;">
                <!-- Category Name -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                        ক্যাটাগরির নাম (Category Name) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="name" id="cat_name" required class="form-control" placeholder="যেমন: দুর্নীতি ও অর্থপাচার, সাইবার ক্রাইম..." style="border-radius: 10px; font-size: 0.95rem; padding: 12px 15px; border: 1.5px solid #e2e8f0; width: 100%;" oninput="updatePillPreview()">
                </div>

                <!-- Description -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                        বিবরণ (Description) <span style="color: #64748b; font-weight: normal; font-size: 0.82rem;">(ঐচ্ছিক)</span>
                    </label>
                    <textarea name="description" id="cat_description" rows="3" class="form-control" placeholder="এই ক্যাটাগরির আওতায় কি ধরণের রেকর্ড বা বিবরণ থাকবে..." style="border-radius: 10px; font-size: 0.9rem; padding: 12px 15px; border: 1.5px solid #e2e8f0; width: 100%; line-height: 1.4;"></textarea>
                </div>

                <!-- Live Preview Pill -->
                <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 15px;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">
                        Add Record ফর্মে পিল প্রিভিউ (Pill Preview):
                    </div>
                    <div>
                        <span id="preview_pill" style="display: inline-block; background: white; border: 2px solid var(--primary); color: #0f172a; padding: 8px 18px; border-radius: 20px; font-size: 0.9rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            ক্যাটাগরির নাম লিখুন...
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div style="padding: 18px 25px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc;">
                <button type="button" onclick="closeCategoryModal()" class="btn" style="background: #e2e8f0; color: #475569; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">
                    বাতিল
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; border: none; box-shadow: 0 4px 12px var(--primary-glow);">
                    <i class="fas fa-check"></i> সংরক্ষণ করুন (Save)
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteCategoryForm" action="<?= URLROOT ?>/admin/records_categories_delete" method="POST" style="display: none;">
    <input type="hidden" name="id" id="delete_cat_id" value="">
</form>

<script>
    function openAddCategoryModal() {
        document.getElementById('categoryModalTitle').innerHTML = '<i class="fas fa-plus-circle" style="color: var(--primary);"></i> নতুন ক্যাটাগরি তৈরি করুন';
        document.getElementById('cat_id').value = '';
        document.getElementById('cat_name').value = '';
        document.getElementById('cat_description').value = '';
        updatePillPreview();
        document.getElementById('categoryModal').style.display = 'flex';
        setTimeout(() => document.getElementById('cat_name').focus(), 100);
    }

    function openEditCategoryModal(cat) {
        document.getElementById('categoryModalTitle').innerHTML = '<i class="fas fa-edit" style="color: #2563eb;"></i> ক্যাটাগরি সম্পাদনা করুন';
        document.getElementById('cat_id').value = cat.id;
        document.getElementById('cat_name').value = cat.name || '';
        document.getElementById('cat_description').value = cat.description || '';
        updatePillPreview();
        document.getElementById('categoryModal').style.display = 'flex';
        setTimeout(() => document.getElementById('cat_name').focus(), 100);
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').style.display = 'none';
    }

    function updatePillPreview() {
        const name = document.getElementById('cat_name').value.trim();
        const pill = document.getElementById('preview_pill');
        if (name) {
            pill.textContent = name;
            pill.style.color = '#0f172a';
        } else {
            pill.textContent = 'ক্যাটাগরির নাম লিখুন...';
            pill.style.color = '#94a3b8';
        }
    }

    function confirmDeleteCategory(id, name) {
        if (confirm(`আপনি কি নিশ্চিতভাবে "${name}" ক্যাটাগরি মুছে ফেলতে চান?`)) {
            document.getElementById('delete_cat_id').value = id;
            document.getElementById('deleteCategoryForm').action = '<?= URLROOT ?>/admin/records_categories_delete/' + id;
            document.getElementById('deleteCategoryForm').submit();
        }
    }

    // Close on outside click
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('categoryModal')) {
            closeCategoryModal();
        }
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
