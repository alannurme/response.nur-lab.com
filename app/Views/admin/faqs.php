<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$faqsList = $data['faqs'] ?? ($faqs ?? []);
$totalFaqs = count($faqsList);
$activeCount = 0;
$inactiveCount = 0;

foreach ($faqsList as $f) {
    if (($f['status'] ?? '') === 'active') {
        $activeCount++;
    } else {
        $inactiveCount++;
    }
}
?>

<style>
/* Stats Grid */
.faq-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.faq-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.faq-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.faq-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.faq-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.faq-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.faq-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.faq-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.faq-filter-tab {
    padding: 7px 16px;
    border-radius: 30px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid transparent;
    background: #f8fafc;
    color: #475569;
    transition: 0.2s all;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}
.faq-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.faq-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.faq-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.faq-filter-tab.active .faq-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

.faq-search-box {
    position: relative;
    width: 100%;
}
.faq-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.faq-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.faq-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.faq-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.faq-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.faq-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.faq-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.faq-table tr:hover td {
    background: #fbfcfe;
}
.faq-table tr:last-child td {
    border-bottom: none;
}

.faq-badge-active {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #dcfce7;
    color: #15803d;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}
.faq-badge-inactive {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fee2e2;
    color: #dc2626;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}
.faq-btn-edit {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.84rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: 0.2s all;
    background: #eff6ff;
    color: #2563eb;
}
.faq-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.faq-btn-delete {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.84rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: 0.2s all;
    background: #fef2f2;
    color: #dc2626;
}
.faq-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-question-circle" style="color: #0b7c4d;"></i> সাধারণ জিজ্ঞাসা (FAQ Management)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">হোমপেজের সচরাচর জিজ্ঞাসা সেকশনের প্রশ্নোত্তরসমূহ তৈরি, সম্পাদনা ও সাজান।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/add_faq" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-plus-circle"></i> + নতুন এফএকিউ যোগ করুন
        </a>
    </div>
</div>

<!-- Summary Statistics Cards -->
<div class="faq-stats-grid">
    <div class="faq-stat-card" onclick="filterByStatus('all')">
        <div class="faq-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-list-ul"></i>
        </div>
        <div class="faq-stat-info">
            <h4><?= $totalFaqs ?></h4>
            <p>মোট এফএকিউ (Total FAQs)</p>
        </div>
    </div>

    <div class="faq-stat-card" onclick="filterByStatus('active')">
        <div class="faq-stat-icon" style="background: #ecfdf5; color: #059669;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="faq-stat-info">
            <h4 style="color: #059669;"><?= $activeCount ?></h4>
            <p>সক্রিয় প্রশ্ন (Active)</p>
        </div>
    </div>

    <div class="faq-stat-card" onclick="filterByStatus('inactive')">
        <div class="faq-stat-icon" style="background: #fef2f2; color: #dc2626;">
            <i class="fas fa-eye-slash"></i>
        </div>
        <div class="faq-stat-info">
            <h4 style="color: #dc2626;"><?= $inactiveCount ?></h4>
            <p>নিষ্ক্রিয় প্রশ্ন (Inactive)</p>
        </div>
    </div>
</div>

<!-- Controls: Filter Tabs & Live Search -->
<div class="faq-control-card">
    <div class="faq-filter-tabs">
        <button type="button" class="faq-filter-tab active" data-filter="all" onclick="setFilterTab('all', this)">
            <i class="fas fa-list-ul"></i> সকল প্রশ্ন <span class="faq-filter-badge"><?= $totalFaqs ?></span>
        </button>
        <button type="button" class="faq-filter-tab" data-filter="active" onclick="setFilterTab('active', this)">
            <i class="fas fa-check"></i> সক্রিয় <span class="faq-filter-badge"><?= $activeCount ?></span>
        </button>
        <button type="button" class="faq-filter-tab" data-filter="inactive" onclick="setFilterTab('inactive', this)">
            <i class="fas fa-eye-slash"></i> নিষ্ক্রিয় <span class="faq-filter-badge"><?= $inactiveCount ?></span>
        </button>
    </div>

    <div class="faq-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="faqSearchInput" placeholder="প্রশ্ন বা উত্তরের শব্দ লিখে খুঁজুন..." onkeyup="filterFaqsTable()">
    </div>
</div>

<!-- Data Table -->
<div class="faq-table-card">
    <div style="overflow-x: auto;">
        <table class="faq-table" id="faqTable">
            <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">ক্রম</th>
                    <th style="width: 35%;">প্রশ্ন (Question)</th>
                    <th style="width: 40%;">উত্তর (Answer)</th>
                    <th style="width: 15%; text-align: center;">স্ট্যাটাস</th>
                    <th style="width: 10%; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody id="faqTableBody">
                <?php if (!empty($faqsList)): ?>
                    <?php foreach ($faqsList as $faq): ?>
                    <?php $status = $faq['status'] ?? 'active'; ?>
                    <tr class="faq-row" data-status="<?= $status ?>">
                        <!-- Order Index -->
                        <td style="text-align: center; vertical-align: top;">
                            <span style="background: #f1f5f9; color: #475569; font-weight: 800; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem;">
                                <?= $faq['order_index'] ?>
                            </span>
                        </td>

                        <!-- Question -->
                        <td style="vertical-align: top;">
                            <div style="font-weight: 700; color: #1e293b; font-size: 1rem; line-height: 1.5;">
                                <?= htmlspecialchars($faq['question']) ?>
                            </div>
                        </td>

                        <!-- Answer -->
                        <td style="vertical-align: top;">
                            <div style="color: #64748b; font-size: 0.9rem; line-height: 1.6; max-height: 70px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                <?= strip_tags($faq['answer']) ?>
                            </div>
                        </td>

                        <!-- Status -->
                        <td style="text-align: center; vertical-align: top;">
                            <?php if ($status === 'active'): ?>
                                <span class="faq-badge-active"><i class="fas fa-check-circle"></i> সক্রিয়</span>
                            <?php else: ?>
                                <span class="faq-badge-inactive"><i class="fas fa-times-circle"></i> নিষ্ক্রিয়</span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right; vertical-align: top;">
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px;">
                                <a href="<?= URLROOT ?>/admin/edit_faq/<?= $faq['id'] ?>" class="faq-btn-edit" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_faq/<?= $faq['id'] ?>" class="faq-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই এফএকিউটি মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="faqNoDataRow">
                        <td colspan="5" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                <i class="fas fa-question"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো এফএকিউ পাওয়া যায়নি</h4>
                            <p style="margin: 0 0 16px 0; font-size: 0.9rem;">হোমপেজের জন্য নতুন প্রশ্নোত্তর যোগ করতে নিচের বাটনে চাপুন।</p>
                            <a href="<?= URLROOT ?>/admin/add_faq" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-plus-circle"></i> + প্রথম এফএকিউ যোগ করুন
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let currentStatusFilter = 'all';

function setFilterTab(status, tabBtn) {
    currentStatusFilter = status;
    document.querySelectorAll('.faq-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterFaqsTable();
}

function filterByStatus(status) {
    const btn = document.querySelector(`.faq-filter-tab[data-filter="${status}"]`);
    if (btn) {
        btn.click();
    } else {
        currentStatusFilter = status;
        filterFaqsTable();
    }
}

function filterFaqsTable() {
    const searchVal = document.getElementById('faqSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#faqTableBody .faq-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status') || '';
        const rowText = row.innerText.toLowerCase();

        let matchesStatus = (currentStatusFilter === 'all' || rowStatus === currentStatusFilter);
        let matchesSearch = (!searchVal || rowText.includes(searchVal));

        if (matchesStatus && matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    let noMatchRow = document.getElementById('faqNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'faqNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো এফএকিউ মেলেনি।</td>';
            document.getElementById('faqTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
