<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$teamList = $data['members'] ?? ($members ?? []);
$totalMembers = count($teamList);
?>

<style>
/* Stats Grid */
.team-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.team-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.team-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.team-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.team-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.team-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.team-search-box {
    position: relative;
    width: 100%;
}
.team-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.team-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.team-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.team-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.team-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.team-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.team-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.team-table tr:hover td {
    background: #fbfcfe;
}
.team-table tr:last-child td {
    border-bottom: none;
}

.team-btn-action {
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
.team-btn-edit {
    background: #eff6ff;
    color: #2563eb;
}
.team-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.team-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.team-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-users-cog" style="color: #0b7c4d;"></i> টিম ব্যবস্থাপনা (Team Management)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ওয়েবসাইটের টিম ও কন্ট্রিবিউটর সদস্যদের তথ্য পরিচালনা করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/add_team_member" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-user-plus"></i> + নতুন টিম মেম্বার যোগ করুন
        </a>
    </div>
</div>

<!-- Summary Statistics Cards -->
<div class="team-stats-grid">
    <div class="team-stat-card">
        <div class="team-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-users"></i>
        </div>
        <div class="team-stat-info">
            <h4><?= $totalMembers ?></h4>
            <p>মোট টিম সদস্য (Total Members)</p>
        </div>
    </div>
</div>

<!-- Controls: Live Search -->
<div class="team-control-card">
    <div class="team-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="teamSearchInput" placeholder="সদস্যের নাম বা পদবী লিখে খুঁজুন..." onkeyup="filterTeamTable()">
    </div>
</div>

<!-- Data Table -->
<div class="team-table-card">
    <div style="overflow-x: auto;">
        <table class="team-table" id="teamTable">
            <thead>
                <tr>
                    <th style="width: 45%;">সদস্যের তথ্য (Member Info)</th>
                    <th style="width: 25%;">পদবী / দায়িত্ব (Designation)</th>
                    <th style="width: 15%; text-align: center;">প্রদর্শনের ক্রম</th>
                    <th style="width: 15%; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody id="teamTableBody">
                <?php if (!empty($teamList)): ?>
                    <?php foreach ($teamList as $member): ?>
                    <tr class="team-row">
                        <!-- Member Info -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="<?= resolve_setting_image($member['image']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" loading="lazy" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; flex-shrink: 0;">
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 1rem;"><?= htmlspecialchars($member['name']) ?></div>
                                </div>
                            </div>
                        </td>

                        <!-- Designation -->
                        <td>
                            <span style="background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
                                <?= htmlspecialchars($member['designation']) ?>
                            </span>
                        </td>

                        <!-- Order -->
                        <td style="text-align: center;">
                            <span style="background: #f1f5f9; color: #475569; font-weight: 800; padding: 4px 10px; border-radius: 6px; font-size: 0.82rem;">
                                <?= $member['order_index'] ?>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px;">
                                <a href="<?= URLROOT ?>/admin/edit_team_member/<?= $member['id'] ?>" class="team-btn-action team-btn-edit" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_team_member/<?= $member['id'] ?>" class="team-btn-action team-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই সদস্যের তথ্য মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="teamNoDataRow">
                        <td colspan="4" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো টিম সদস্যের তথ্য নেই</h4>
                            <p style="margin: 0 0 16px 0; font-size: 0.9rem;">নতুন সদস্য যুক্ত করতে নিচের বাটনে চাপুন।</p>
                            <a href="<?= URLROOT ?>/admin/add_team_member" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-user-plus"></i> + প্রথম সদস্য যোগ করুন
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTeamTable() {
    const searchVal = document.getElementById('teamSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#teamTableBody .team-row');

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

    let noMatchRow = document.getElementById('teamNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'teamNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="4" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো সদস্য মেলেনি।</td>';
            document.getElementById('teamTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
