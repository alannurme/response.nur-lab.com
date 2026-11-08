<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$donationsList = $data['donations'] ?? ($donations ?? []);

$totalAmount = 0;
$completedCount = 0;
$pendingCount = 0;
$failedCount = 0;

if (!empty($donationsList)) {
    foreach ($donationsList as $d) {
        $st = $d['status'] ?? 'pending';
        if ($st === 'completed') {
            $totalAmount += floatval($d['amount'] ?? 0);
            $completedCount++;
        } elseif ($st === 'pending') {
            $pendingCount++;
        } else {
            $failedCount++;
        }
    }
}
?>

<style>
/* Stats Grid */
.don-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.don-stat-card {
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
.don-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.don-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.don-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.don-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.don-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.don-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.don-filter-tab {
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
.don-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.don-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.don-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.don-filter-tab.active .don-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

/* Search row */
.don-search-box {
    position: relative;
    width: 100%;
}
.don-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.don-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.don-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.don-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.don-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.don-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.don-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.don-table tr:hover td {
    background: #fbfcfe;
}
.don-table tr:last-child td {
    border-bottom: none;
}

.don-donor-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0b7c4d, #10b981);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-hand-holding-heart" style="color: #0b7c4d;"></i> অনুদান লগ (Donation Logs)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ওয়েবসাইটের শুভানুধ্যায়ীদের থেকে প্রাপ্ত অনুদান ও পেমেন্ট হিস্ট্রি পর্যবেক্ষণ করুন।</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> <?= htmlspecialchars($data['success']) ?>
    </div>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="don-stats-grid">
    <div class="don-stat-card" onclick="filterByStatus('all')">
        <div class="don-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-hand-holding-dollar"></i>
        </div>
        <div class="don-stat-info">
            <h4><?= number_format($totalAmount, 0) ?> ৳</h4>
            <p>মোট সংগৃহীত অনুদান (Total)</p>
        </div>
    </div>

    <div class="don-stat-card" onclick="filterByStatus('completed')">
        <div class="don-stat-icon" style="background: #ecfdf5; color: #059669;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="don-stat-info">
            <h4 style="color: #059669;"><?= $completedCount ?></h4>
            <p>সফল অনুদান (Completed)</p>
        </div>
    </div>

    <div class="don-stat-card" onclick="filterByStatus('pending')">
        <div class="don-stat-icon" style="background: #fffbeb; color: #d97706;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="don-stat-info">
            <h4 style="color: #d97706;"><?= $pendingCount ?></h4>
            <p>অপেক্ষমাণ অনুদান (Pending)</p>
        </div>
    </div>

    <?php if ($failedCount > 0): ?>
    <div class="don-stat-card" onclick="filterByStatus('failed')">
        <div class="don-stat-icon" style="background: #fef2f2; color: #dc2626;">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="don-stat-info">
            <h4 style="color: #dc2626;"><?= $failedCount ?></h4>
            <p>ব্যর্থ অনুদান (Failed)</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Controls: Filter Tabs & Live Search -->
<div class="don-control-card">
    <!-- Status Tabs -->
    <div class="don-filter-tabs">
        <button type="button" class="don-filter-tab active" data-filter="all" onclick="setFilterTab('all', this)">
            <i class="fas fa-list-ul"></i> সকল অনুদান <span class="don-filter-badge"><?= count($donationsList) ?></span>
        </button>
        <button type="button" class="don-filter-tab" data-filter="completed" onclick="setFilterTab('completed', this)">
            <i class="fas fa-check-circle"></i> সম্পন্ন (Completed) <span class="don-filter-badge"><?= $completedCount ?></span>
        </button>
        <button type="button" class="don-filter-tab" data-filter="pending" onclick="setFilterTab('pending', this)">
            <i class="fas fa-clock"></i> অপেক্ষমাণ (Pending) <span class="don-filter-badge"><?= $pendingCount ?></span>
        </button>
        <?php if ($failedCount > 0): ?>
        <button type="button" class="don-filter-tab" data-filter="failed" onclick="setFilterTab('failed', this)">
            <i class="fas fa-times"></i> ব্যর্থ (Failed) <span class="don-filter-badge"><?= $failedCount ?></span>
        </button>
        <?php endif; ?>
    </div>

    <!-- Live Search -->
    <div class="don-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="donSearchInput" placeholder="দাতা, ইমেইল, মোবাইল, পেমেন্ট আইডি বা মেথড দিয়ে খুঁজুন..." onkeyup="filterDonationsTable()">
    </div>
</div>

<!-- Data Table -->
<div class="don-table-card">
    <div style="overflow-x: auto;">
        <table class="don-table" id="donTable">
            <thead>
                <tr>
                    <th style="width: 25%;">দাতা (Donor)</th>
                    <th style="width: 15%;">পরিমাণ (Amount)</th>
                    <th style="width: 15%;">উদ্দেশ্য (Purpose)</th>
                    <th style="width: 15%;">পেমেন্ট মেথড</th>
                    <th style="width: 15%;">পেমেন্ট আইডি</th>
                    <th style="width: 15%; text-align: center;">স্ট্যাটাস</th>
                </tr>
            </thead>
            <tbody id="donTableBody">
                <?php if (!empty($donationsList)): ?>
                    <?php foreach ($donationsList as $d): ?>
                    <?php
                        $st = $d['status'] ?? 'pending';
                        $donorInitial = mb_substr(trim($d['donor_name'] ?? 'D'), 0, 1, 'UTF-8');
                    ?>
                    <tr class="don-row" data-status="<?= $st ?>">
                        <!-- Donor Info -->
                        <td>
                            <div style="display: flex; gap: 12px; align-items: flex-start;">
                                <div class="don-donor-avatar">
                                    <?= htmlspecialchars($donorInitial) ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($d['donor_name'] ?? 'বেনামী দাতা') ?></div>
                                    <div style="font-size: 0.82rem; color: #64748b;"><?= htmlspecialchars($d['donor_email'] ?? '') ?></div>
                                    <div style="font-size: 0.82rem; color: #64748b;"><?= htmlspecialchars($d['donor_phone'] ?? '') ?></div>
                                    <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">
                                        <i class="far fa-calendar-alt"></i> <?= !empty($d['created_at']) ? date('d M Y, h:i A', strtotime($d['created_at'])) : '' ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td>
                            <div style="font-weight: 800; color: #0b7c4d; font-size: 1.15rem;">
                                <?= number_format(floatval($d['amount'] ?? 0), 2) ?> ৳
                            </div>
                        </td>

                        <!-- Purpose -->
                        <td>
                            <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 0.82rem; font-weight: 600;">
                                <?= htmlspecialchars($d['purpose'] ?? 'সাধারণ অনুদান') ?>
                            </span>
                        </td>

                        <!-- Payment Method -->
                        <td>
                            <div style="font-weight: 700; color: #1e293b; text-transform: uppercase; font-size: 0.88rem;">
                                <?= htmlspecialchars($d['payment_method'] ?? 'N/A') ?>
                            </div>
                        </td>

                        <!-- Payment ID -->
                        <td>
                            <code style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 3px 8px; border-radius: 6px; font-size: 0.8rem; color: #e11d48; word-break: break-all;">
                                <?= htmlspecialchars($d['payment_id'] ?? 'N/A') ?>
                            </code>
                        </td>

                        <!-- Status Selector Form -->
                        <td style="text-align: center;">
                            <form action="<?= URLROOT ?>/admin/update_donation_status/<?= $d['id'] ?>" method="POST" style="margin: 0;">
                                <?= csrf_field() ?>
                                <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 8px; font-weight: 700; width: auto; display: inline-block; cursor: pointer;
                                    <?php 
                                    if ($st === 'completed') echo 'background: #dcfce7; color: #15803d; border-color: #86efac;';
                                    elseif ($st === 'pending') echo 'background: #fef3c7; color: #b45309; border-color: #fde68a;';
                                    else echo 'background: #fee2e2; color: #dc2626; border-color: #fca5a5;';
                                    ?>">
                                    <option value="pending" <?= $st === 'pending' ? 'selected' : '' ?>>অপেক্ষমাণ (Pending)</option>
                                    <option value="completed" <?= $st === 'completed' ? 'selected' : '' ?>>সম্পন্ন (Completed)</option>
                                    <option value="failed" <?= $st === 'failed' ? 'selected' : '' ?>>ব্যর্থ (Failed)</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="donNoDataRow">
                        <td colspan="6" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                <i class="fas fa-hand-holding-dollar"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো অনুদান লগ পাওয়া যায়নি</h4>
                            <p style="margin: 0; font-size: 0.9rem;">ভিজিটররা অনুদান পাঠালে তার সম্পূর্ণ হিসাব এখানে জমা হবে।</p>
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
    document.querySelectorAll('.don-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterDonationsTable();
}

function filterByStatus(status) {
    const btn = document.querySelector(`.don-filter-tab[data-filter="${status}"]`);
    if (btn) {
        btn.click();
    } else {
        currentStatusFilter = status;
        filterDonationsTable();
    }
}

function filterDonationsTable() {
    const searchVal = document.getElementById('donSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#donTableBody .don-row');

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

    let noMatchRow = document.getElementById('donNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'donNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো অনুদান তথ্য মেলেনি।</td>';
            document.getElementById('donTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
