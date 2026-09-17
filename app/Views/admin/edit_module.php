<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="main-content">
    <div class="admin-header">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">
                <i class="fas fa-edit" style="color: var(--primary); margin-right: 10px;"></i> Edit Module (মডিউল এডিট করুন)
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Update details and content for this topic module.</p>
        </div>
        <a href="<?= URLROOT ?>/admin/modules" class="btn-visit-site">
            <i class="fas fa-arrow-left"></i> Back to Modules
        </a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_module/<?= $module['id'] ?>" method="POST">
        <div class="form-grid" style="grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column: Primary Data -->
            <div style="background: white; border-radius: 16px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                        Module Title (মডিউলের নাম) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($module['title']) ?>" placeholder="যেমন: ঈমান ও আকীদা / প্রশ্ন ও উত্তর" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-size: 1rem; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='#cbd5e1';">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                        URL / Link (লিংক)
                    </label>
                    <input type="text" name="url" value="<?= htmlspecialchars($module['url']) ?>" placeholder="যেমন: /category/aqeedah অথবা https://..." style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-size: 1rem; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='#cbd5e1';">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                        Topic Content / HTML Coding (টপিক কন্টেন্ট বা কোডিং)
                    </label>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 8px;">
                        এখানে আপনি প্লেইন টেক্সট, তালিকা বা কাস্টম HTML কোড লিখতে পারেন যা মেগা মেনুর সাব-কন্টেন্ট হিসেবে দেখাবে।
                    </p>
                    <textarea name="content" rows="12" placeholder="HTML or Plain Text Topics here..." style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-family: monospace, 'Hind Siliguri'; font-size: 0.95rem; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='#cbd5e1';"><?= htmlspecialchars($module['content']) ?></textarea>
                </div>
            </div>

            <!-- Right Column: Settings & Attributes -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; border-radius: 16px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        Publishing & Settings
                    </h3>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            FontAwesome Icon (আইকন Class)
                        </label>
                        <input type="text" name="icon" value="<?= htmlspecialchars($module['icon']) ?>" placeholder="fas fa-kaaba, fas fa-book..." style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 0.95rem;">
                        <span style="font-size: 0.78rem; color: var(--text-muted); display: block; margin-top: 4px;">Search icon classes on fontawesome.com</span>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Order Index (ক্রমিক নম্বর)
                        </label>
                        <input type="number" name="order_index" value="<?= htmlspecialchars($module['order_index']) ?>" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 0.95rem;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Status (অবস্থা)
                        </label>
                        <select name="status" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 0.95rem; background: white;">
                            <option value="active" <?= $module['status'] === 'active' ? 'selected' : '' ?>>Active (সক্রিয়)</option>
                            <option value="inactive" <?= $module['status'] === 'inactive' ? 'selected' : '' ?>>Inactive (নিষ্ক্রিয়)</option>
                        </select>
                    </div>

                    <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);" onmouseover="this.style.background='var(--primary-dark)';" onmouseout="this.style.background='var(--primary)';">
                        <i class="fas fa-save" style="margin-right: 8px;"></i> Update Module
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
