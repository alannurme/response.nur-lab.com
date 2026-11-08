<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$subscribersList = $data['subscribers'] ?? ($subscribers ?? []);
$totalSubscribers = count($subscribersList);

// Count subscribers joined this month
$thisMonthCount = 0;
$currentMonth = date('Y-m');
foreach ($subscribersList as $s) {
    if (!empty($s['created_at']) && strpos($s['created_at'], $currentMonth) === 0) {
        $thisMonthCount++;
    }
}
?>

<style>
/* Stats Grid */
.sub-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.sub-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    transition: transform 0.2s, box-shadow 0.2s;
}
.sub-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.sub-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.sub-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.sub-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.sub-search-box {
    position: relative;
    flex: 1;
    min-width: 280px;
}
.sub-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.sub-search-box input {
    width: 100%;
    padding: 9px 14px 9px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
}
.sub-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.sub-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.sub-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.sub-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.sub-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.sub-table tr:hover td {
    background: #fbfcfe;
}
.sub-table tr:last-child td {
    border-bottom: none;
}

.sub-badge-active {
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
.sub-btn-delete {
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
    background: #fef2f2;
    color: #dc2626;
}
.sub-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-envelope-open-text" style="color: #0b7c4d;"></i> নিউজলেটার গ্রাহক (Subscribers)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ওয়েবসাইটের নিউজলেটার তালিকায় সংযুক্ত পাঠকদের ইমেইল ও সাবস্ক্রিপশন লগ পরিচালনা করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/export_subscribers" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 18px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-file-export"></i> CSV এক্সপোর্ট (Export CSV)
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        গ্রাহক সফলভাবে তালিকা থেকে মুছে ফেলা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        নির্বাচিত গ্রাহকসমূহ মুছে ফেলা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="sub-stats-grid">
    <div class="sub-stat-card">
        <div class="sub-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-users"></i>
        </div>
        <div class="sub-stat-info">
            <h4><?= $totalSubscribers ?></h4>
            <p>মোট সক্রিয় সাবস্ক্রাইবার (Total)</p>
        </div>
    </div>

    <div class="sub-stat-card">
        <div class="sub-stat-icon" style="background: #eff6ff; color: #2563eb;">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="sub-stat-info">
            <h4 style="color: #2563eb;"><?= $thisMonthCount ?></h4>
            <p>চলতি মাসে যুক্ত হয়েছেন (This Month)</p>
        </div>
    </div>
</div>

<!-- Controls: Live Search & Bulk Actions -->
<form action="<?= URLROOT ?>/admin/bulk_delete_subscribers" method="POST" id="bulk-subscribers-form">
    <?= csrf_field() ?>

    <div class="sub-control-card">
        <!-- Live Search -->
        <div class="sub-search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="subSearchInput" placeholder="ইমেইল ঠিকানা লিখে খুঁজুন..." onkeyup="filterSubscribersTable()">
        </div>

        <!-- Bulk Actions -->
        <div style="display: flex; gap: 8px; align-items: center;">
            <select name="action" id="bulk-subscribers-select" class="form-control" style="width: auto; border-radius: 10px; border: 1px solid #cbd5e1; padding: 9px 14px; font-size: 0.92rem; font-weight: 600;">
                <option value="">বাল্ক অ্যাকশন (Bulk)</option>
                <option value="delete">নির্বাচিতগুলো আনসাবস্ক্রাইব / মুছুন (Delete)</option>
            </select>
            <button type="submit" class="btn btn-secondary" style="background: #334155; color: white; border: none; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 0.9rem;">
                প্রয়োগ
            </button>
        </div>
    </div>

    <!-- Subscribers Data Table -->
    <div class="sub-table-card">
        <div style="overflow-x: auto;">
            <table class="sub-table" id="subTable">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-subscribers" style="transform: scale(1.15); cursor: pointer;" title="সবগুলো নির্বাচন করুন">
                        </th>
                        <th style="width: 45%;">ইমেইল ঠিকানা (Email Address)</th>
                        <th style="width: 25%;">যোগদানের তারিখ (Subscription Date)</th>
                        <th style="width: 15%; text-align: center;">স্ট্যাটাস</th>
                        <th style="width: 15%; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="subTableBody">
                    <?php if (!empty($subscribersList)): ?>
                        <?php foreach ($subscribersList as $s): ?>
                        <tr class="sub-row">
                            <!-- Checkbox -->
                            <td style="text-align: center;">
                                <input type="checkbox" name="subscriber_ids[]" value="<?= $s['id'] ?>" class="subscriber-checkbox" style="transform: scale(1.15); cursor: pointer;">
                            </td>

                            <!-- Email -->
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #e6f4ea; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <strong style="color: #1e293b; font-size: 0.95rem; font-family: monospace;"><?= htmlspecialchars($s['email']) ?></strong>
                                </div>
                            </td>

                            <!-- Date -->
                            <td>
                                <div style="font-size: 0.85rem; color: #64748b;">
                                    <i class="far fa-calendar-alt" style="margin-right: 4px;"></i> <?= date('d M Y, h:i A', strtotime($s['created_at'])) ?>
                                </div>
                            </td>

                            <!-- Status -->
                            <td style="text-align: center;">
                                <span class="sub-badge-active">
                                    <i class="fas fa-check-circle"></i> সাবস্ক্রাইবড
                                </span>
                            </td>

                            <!-- Actions -->
                            <td style="text-align: right;">
                                <a href="<?= URLROOT ?>/admin/delete_subscriber/<?= $s['id'] ?>" class="sub-btn-delete" title="আনসাবস্ক্রাইব করুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই গ্রাহককে মুছে ফেলতে চান?')">
                                    <i class="fas fa-user-minus"></i> মুছুন
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="subNoDataRow">
                            <td colspan="5" style="padding: 60px 20px; text-align: center; color: #64748b;">
                                <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো সাবস্ক্রাইবার নেই</h4>
                                <p style="margin: 0; font-size: 0.9rem;">পাঠকরা নিউজলেটারে সাবস্ক্রাইব করলে তাদের তালিকা এখানে দেখা যাবে।</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
// Select All Checkbox logic
document.getElementById('select-all-subscribers').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.subscriber-checkbox');
    checkboxes.forEach(cb => {
        const row = cb.closest('tr');
        if (row && row.style.display !== 'none') {
            cb.checked = this.checked;
        }
    });
});

// Bulk Form submit confirmation
document.getElementById('bulk-subscribers-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-subscribers-select').value;
    if (!action) {
        alert('অনুগ্রহ করে একটি বাল্ক অ্যাকশন নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.subscriber-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('অনুগ্রহ করে অন্তত একজন গ্রাহক নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    
    if (!confirm(`আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount} জন গ্রাহককে তালিকা থেকে মুছে ফেলতে চান?`)) {
        e.preventDefault();
    }
});

// Live Search Filter
function filterSubscribersTable() {
    const searchVal = document.getElementById('subSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#subTableBody .sub-row');

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

    let noMatchRow = document.getElementById('subNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'subNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো ইমেইল মেলেনি।</td>';
            document.getElementById('subTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
