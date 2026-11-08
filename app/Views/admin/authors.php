<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.authors-wrap {
    font-family: 'Hind Siliguri', sans-serif;
}
.author-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.author-avatar-placeholder {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0b7c4d, #10b981);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 2px 6px rgba(11, 124, 77, 0.2);
}
.authors-grid-layout {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 25px;
    align-items: flex-start;
}
@media (max-width: 991px) {
    .authors-grid-layout {
        grid-template-columns: 1fr;
    }
}
.authors-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 26px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.03);
}
.author-act-btn {
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
.author-act-btn:hover {
    transform: translateY(-2px);
}
.author-act-edit {
    background: #eff6ff;
    color: #2563eb;
}
.author-act-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.author-act-del {
    background: #fef2f2;
    color: #dc2626;
}
.author-act-del:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<div class="authors-wrap">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-feather-alt" style="color: #0b7c4d;"></i> লেখক ব্যবস্থাপনা (Authors)
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.95rem;">
                ব্লগ আর্টিকেল এবং পোস্টের জন্য লেখক প্রোফাইল যোগ ও পরিচালনা করুন
            </p>
        </div>
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 12px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">মোট নিবন্ধিত লেখক</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                    <?= !empty($data['authors']) ? count($data['authors']) : 0 ?> জন
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['author_error'])): ?>
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-circle" style="font-size: 1.15rem;"></i>
            <span><?= htmlspecialchars($_SESSION['author_error']) ?></span>
            <?php unset($_SESSION['author_error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['author_success'])): ?>
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="font-size: 1.15rem;"></i>
            <span><?= htmlspecialchars($_SESSION['author_success']) ?></span>
            <?php unset($_SESSION['author_success']); ?>
        </div>
    <?php endif; ?>

    <div class="authors-grid-layout">
        <!-- Add Author Card Form -->
        <div class="authors-card">
            <h3 style="margin: 0 0 18px 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 12px;">
                <i class="fas fa-user-plus" style="color: #0b7c4d;"></i> নতুন লেখক যোগ করুন
            </h3>
            <form action="<?= URLROOT ?>/admin/add_author" method="POST">
                <?= csrf_field() ?>
                
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-size: 0.92rem;">
                        লেখকের নাম <span style="color:#ef4444">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="যেমন: ড. জাকির নায়েক" required style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 14px; font-size: 0.92rem; width: 100%;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-size: 0.92rem;">
                        ইমেইল এড্রেস (ঐচ্ছিক)
                    </label>
                    <input type="email" name="email" class="form-control" placeholder="author@example.com" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 14px; font-size: 0.92rem; width: 100%;">
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-size: 0.92rem;">
                        প্রোফাইল ছবি
                    </label>
                    <div style="display: flex; gap: 14px; align-items: center;">
                        <img id="author_preview" src="" style="width: 55px; height: 55px; border-radius: 50%; display: none; object-fit: cover; border: 2px solid #0b7c4d;" loading="lazy" decoding="async">
                        <div style="flex: 1;">
                            <input type="text" id="author_image_path" name="image" class="form-control" readonly placeholder="মিডিয়া লাইব্রেরি থেকে ছবি সিলেক্ট করুন" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 8px 12px; font-size: 0.85rem; width: 100%; margin-bottom: 8px;">
                            <button type="button" class="btn btn-secondary w-100" style="border-radius: 10px; padding: 8px 14px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 6px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" onclick="openMediaPicker('author_image_path', 'author_preview')">
                                <i class="fas fa-image" style="color: #0b7c4d;"></i> মিডিয়া লাইব্রেরি খুলুন
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn" style="width: 100%; background: #0b7c4d; color: white; border: none; padding: 11px 20px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(11, 124, 77, 0.25); cursor: pointer;">
                    <i class="fas fa-plus-circle"></i> লেখক সংরক্ষণ করুন
                </button>
            </form>
        </div>

        <!-- Authors List Card -->
        <div class="authors-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 18px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px;">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-list-ul" style="color: #2563eb;"></i> সকল লেখকদের তালিকা
                </h3>
                <div style="position: relative; width: 240px;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                    <input type="text" id="authorSearchInput" onkeyup="filterAuthors()" placeholder="নাম বা ইমেইল খুঁজুন..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif;">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                            <th style="padding: 12px 16px; border-radius: 10px 0 0 10px; width: 70px;">ছবি</th>
                            <th style="padding: 12px 16px;">লেখকের নাম</th>
                            <th style="padding: 12px 16px;">ইমেইল এড্রেস</th>
                            <th style="padding: 12px 16px; text-align: right; border-radius: 0 10px 10px 0;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody id="authorsTableBody">
                        <?php if (!empty($data['authors'])): ?>
                            <?php foreach ($data['authors'] as $author): ?>
                                <tr class="author-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                                    <td style="padding: 12px 16px;">
                                        <?php if (!empty($author['image'])): ?>
                                            <img src="<?= htmlspecialchars($author['image']) ?>" alt="<?= htmlspecialchars($author['name']) ?>" class="author-avatar" loading="lazy" decoding="async">
                                        <?php else: ?>
                                            <div class="author-avatar-placeholder">
                                                <?= strtoupper(substr($author['name'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">
                                            <?= htmlspecialchars($author['name']) ?>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <?php if (!empty($author['email'])): ?>
                                            <a href="mailto:<?= htmlspecialchars($author['email']) ?>" style="color: #64748b; text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="far fa-envelope" style="font-size: 0.8rem; color: #94a3b8;"></i>
                                                <?= htmlspecialchars($author['email']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-size: 0.85rem; font-style: italic;">উপলব্ধ নয়</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right;">
                                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                            <a href="<?= URLROOT ?>/admin/edit_author/<?= $author['id'] ?>" class="author-act-btn author-act-edit" title="লেখক সম্পাদনা">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($author['name'] !== 'Admin'): ?>
                                            <a href="<?= URLROOT ?>/admin/delete_author/<?= $author['id'] ?>" class="author-act-btn author-act-del" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই লেখককে মুছে ফেলতে চান? যুক্ত থাকা পোস্টগুলো মুছে যাবে না এবং অ্যাডমিনের নামে পুনর্নির্ধারণ করা হবে।')" title="লেখক ডিলিট">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="emptyAuthorsRow">
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 40px 20px; font-size: 0.95rem;">
                                    <i class="fas fa-feather-alt" style="font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    এখনো কোনো লেখক যোগ করা হয়নি। বামপাশের ফর্ম ব্যবহার করে নতুন লেখক যুক্ত করুন।
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function filterAuthors() {
    const q = document.getElementById('authorSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.author-row');
    let visibleCount = 0;
    
    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        if (text.includes(q)) {
            r.style.display = '';
            visibleCount++;
        } else {
            r.style.display = 'none';
        }
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
