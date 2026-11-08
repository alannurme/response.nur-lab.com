<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$pagesList = $data['pages'] ?? ($pages ?? []);
$totalPages = count($pagesList);
?>

<style>
/* Stats Grid */
.page-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.page-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.page-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.page-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.page-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.page-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.page-search-box {
    position: relative;
    width: 100%;
}
.page-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.page-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.page-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.page-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.page-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.page-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.page-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.page-table tr:hover td {
    background: #fbfcfe;
}
.page-table tr:last-child td {
    border-bottom: none;
}

.page-btn-action {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.84rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: 0.2s all;
    border: none;
}
.page-btn-view {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #cbd5e1;
}
.page-btn-view:hover {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.page-btn-edit {
    background: #eff6ff;
    color: #2563eb;
}
.page-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.page-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.page-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-file-alt" style="color: #0b7c4d;"></i> স্ট্যাটিক পেজসমূহ (Pages)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">আমাদের সম্পর্কে, শর্তাবলী, গোপনীয়তা নীতি ইত্যাদি পেজ তৈরি ও পরিচালনা করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/add_page" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-plus-circle"></i> + নতুন পেজ তৈরি করুন
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> নতুন পেজটি সফলভাবে তৈরি করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #2563eb; margin-right: 6px;"></i> পেজের তথ্য সফলভাবে আপডেট করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; margin-right: 6px;"></i> পেজটি সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="page-stats-grid">
    <div class="page-stat-card">
        <div class="page-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div class="page-stat-info">
            <h4><?= $totalPages ?></h4>
            <p>মোট সক্রিয় পেজ (Total Pages)</p>
        </div>
    </div>
</div>

<!-- Controls: Live Search -->
<div class="page-control-card">
    <div class="page-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="pageSearchInput" placeholder="পেজের শিরোনাম বা স্লাগ লিখে খুঁজুন..." onkeyup="filterPagesTable()">
    </div>
</div>

<!-- Data Table -->
<div class="page-table-card">
    <div style="overflow-x: auto;">
        <table class="page-table" id="pageTable">
            <thead>
                <tr>
                    <th style="width: 40%;">পেজের শিরোনাম (Page Title)</th>
                    <th style="width: 30%;">লিংক / স্লাগ (Slug)</th>
                    <th style="width: 15%;">তৈরির তারিখ</th>
                    <th style="width: 15%; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody id="pageTableBody">
                <?php if (!empty($pagesList)): ?>
                    <?php foreach ($pagesList as $p): ?>
                    <tr class="page-row">
                        <!-- Title -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">
                                    <?= htmlspecialchars($p['title']) ?>
                                </div>
                            </div>
                        </td>

                        <!-- Slug -->
                        <td>
                            <code style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; color: #0b7c4d; font-weight: 600;">
                                /page/<?= htmlspecialchars($p['slug']) ?>
                            </code>
                        </td>

                        <!-- Created At -->
                        <td>
                            <div style="font-size: 0.85rem; color: #64748b;">
                                <i class="far fa-calendar-alt" style="margin-right: 4px;"></i> <?= date('d M Y', strtotime($p['created_at'])) ?>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px;">
                                <a href="<?= URLROOT ?>/page/<?= $p['slug'] ?>" target="_blank" class="page-btn-action page-btn-view" title="পাবলিক পেজ দেখুন">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/edit_page/<?= $p['id'] ?>" class="page-btn-action page-btn-edit" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_page/<?= $p['id'] ?>" class="page-btn-action page-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই পেজটি মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="pageNoDataRow">
                        <td colspan="4" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                <i class="fas fa-file"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো পেজ পাওয়া যায়নি</h4>
                            <p style="margin: 0 0 16px 0; font-size: 0.9rem;">নতুন কোনো স্ট্যাটিক পেজ তৈরি করতে নিচের বাটনে চাপুন।</p>
                            <a href="<?= URLROOT ?>/admin/add_page" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-plus-circle"></i> + প্রথম পেজ তৈরি করুন
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterPagesTable() {
    const searchVal = document.getElementById('pageSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#pageTableBody .page-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowText = row.innerText.toLowerCase();
        if (!searchVal || rowText.includes(searchVal)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    let noMatchRow = document.getElementById('pageNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'pageNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="4" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো পেজ মেলেনি।</td>';
            document.getElementById('pageTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
