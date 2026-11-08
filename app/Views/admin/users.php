<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$usersList = $data['users'] ?? ($users ?? []);
$totalUsers = count($usersList);
?>

<style>
/* Stats Grid */
.usr-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.usr-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.usr-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.usr-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.usr-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.usr-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.usr-search-box {
    position: relative;
    width: 100%;
}
.usr-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.usr-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.usr-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.usr-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.usr-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.usr-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.usr-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.usr-table tr:hover td {
    background: #fbfcfe;
}
.usr-table tr:last-child td {
    border-bottom: none;
}

.usr-avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0b7c4d, #10b981);
    color: #ffffff;
    font-weight: 700;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.usr-btn-action {
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
.usr-btn-edit {
    background: #eff6ff;
    color: #2563eb;
}
.usr-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.usr-btn-settings {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #cbd5e1;
}
.usr-btn-settings:hover {
    background: #1e293b;
    color: #ffffff;
    border-color: #1e293b;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-users-shield" style="color: #0b7c4d;"></i> ব্যবহারকারী ও এডমিন (User Management)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">পোর্টালে দায়িত্বপ্রাপ্ত এডমিনিস্ট্রেটর ও স্টাফ সদস্যদের অ্যাকাউন্ট পরিচালনা করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/add_user" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-user-plus"></i> + নতুন ইউজার যোগ করুন
        </a>
    </div>
</div>

<!-- Summary Statistics Cards -->
<div class="usr-stats-grid">
    <div class="usr-stat-card">
        <div class="usr-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="usr-stat-info">
            <h4><?= $totalUsers ?></h4>
            <p>মোট এডমিন ও ইউজার (Total Users)</p>
        </div>
    </div>
</div>

<!-- Controls: Live Search -->
<div class="usr-control-card">
    <div class="usr-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="usrSearchInput" placeholder="ইউজারনেম বা পদবী লিখে খুঁজুন..." onkeyup="filterUsersTable()">
    </div>
</div>

<!-- Data Table -->
<div class="usr-table-card">
    <div style="overflow-x: auto;">
        <table class="usr-table" id="usrTable">
            <thead>
                <tr>
                    <th style="width: 35%;">ইউজারনেম (Username)</th>
                    <th style="width: 25%;">রোল / পদবী</th>
                    <th style="width: 20%;">যোগদানের তারিখ</th>
                    <th style="width: 10%; text-align: center;">স্ট্যাটাস</th>
                    <th style="width: 10%; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody id="usrTableBody">
                <?php if (!empty($usersList)): ?>
                    <?php foreach ($usersList as $user): ?>
                    <?php $userInit = strtoupper(substr($user['username'] ?? 'U', 0, 1)); ?>
                    <tr class="usr-row">
                        <!-- Username with Avatar -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="usr-avatar-circle">
                                    <?= htmlspecialchars($userInit) ?>
                                </div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">
                                    <?= htmlspecialchars($user['username']) ?>
                                </div>
                            </div>
                        </td>

                        <!-- Role -->
                        <td>
                            <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.84rem;">
                                <i class="fas fa-shield-alt" style="margin-right: 4px;"></i> <?= htmlspecialchars($user['role'] ?? 'Administrator') ?>
                            </span>
                        </td>

                        <!-- Joined Date -->
                        <td>
                            <div style="font-size: 0.85rem; color: #64748b;">
                                <i class="far fa-calendar-alt" style="margin-right: 4px;"></i> <?= !empty($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A' ?>
                            </div>
                        </td>

                        <!-- Status -->
                        <td style="text-align: center;">
                            <span style="background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 30px; font-size: 0.8rem; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> সক্রিয়
                            </span>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px;">
                                <a href="<?= URLROOT ?>/admin/edit_user/<?= $user['id'] ?>" class="usr-btn-action usr-btn-edit" title="ইউজার সম্পাদনা">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/user_settings/<?= $user['id'] ?>" class="usr-btn-action usr-btn-settings" title="সেটিংস">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="usrNoDataRow">
                        <td colspan="5" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো ইউজার পাওয়া যায়নি</h4>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterUsersTable() {
    const searchVal = document.getElementById('usrSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#usrTableBody .usr-row');

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

    let noMatchRow = document.getElementById('usrNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'usrNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো ইউজার মেলেনি।</td>';
            document.getElementById('usrTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
