<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$messagesList = $data['messages'] ?? ($messages ?? []);

$totalMessages = count($messagesList);
$unreadCount = 0;
$readCount = 0;

foreach ($messagesList as $m) {
    if (($m['status'] ?? '') === 'unread') {
        $unreadCount++;
    } else {
        $readCount++;
    }
}
?>

<style>
/* Stats Grid */
.msg-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.msg-stat-card {
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
.msg-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.msg-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.msg-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.msg-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.msg-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.msg-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.msg-filter-tab {
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
.msg-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.msg-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.msg-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.msg-filter-tab.active .msg-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

/* Search and Bulk row */
.msg-search-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.msg-search-box {
    position: relative;
    flex: 1;
    min-width: 280px;
}
.msg-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.msg-search-box input {
    width: 100%;
    padding: 9px 14px 9px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
}
.msg-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.msg-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.msg-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.msg-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.msg-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.msg-table tr:hover td {
    background: #fbfcfe;
}
.msg-table tr.unread-row td {
    background: #f0fdf4;
}
.msg-table tr.unread-row:hover td {
    background: #e6f7ec;
}
.msg-table tr:last-child td {
    border-bottom: none;
}

/* User avatar */
.msg-user-cell {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.msg-user-avatar {
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
    box-shadow: 0 2px 6px rgba(11, 124, 77, 0.2);
}
.msg-user-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
    line-height: 1.3;
}
.msg-user-email {
    font-size: 0.82rem;
    color: #64748b;
    word-break: break-all;
    margin-top: 2px;
}
.msg-date-pill {
    font-size: 0.78rem;
    color: #94a3b8;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Subject & Text */
.msg-subject-text {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.96rem;
    margin-bottom: 4px;
}
.msg-body-preview {
    color: #64748b;
    font-size: 0.88rem;
    line-height: 1.5;
    word-break: break-word;
}

/* Status Badges */
.msg-badge-unread {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef2f2;
    color: #dc2626;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}
.msg-badge-read {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f1f5f9;
    color: #64748b;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* Action Buttons */
.msg-action-btn {
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
.msg-btn-view {
    background: #eff6ff;
    color: #2563eb;
}
.msg-btn-view:hover {
    background: #2563eb;
    color: #ffffff;
}
.msg-btn-reply {
    background: #e6f4ea;
    color: #137333;
}
.msg-btn-reply:hover {
    background: #137333;
    color: #ffffff;
}
.msg-btn-check {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #cbd5e1;
}
.msg-btn-check:hover {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.msg-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.msg-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}

/* Reader Modal */
.msg-modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.msg-modal-backdrop.show {
    display: flex;
}
.msg-modal {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 620px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: msgModalFade 0.25s ease-out;
}
@keyframes msgModalFade {
    from { opacity: 0; transform: translateY(-15px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.msg-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
}
.msg-modal-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.msg-modal-close {
    background: transparent;
    border: none;
    font-size: 1.3rem;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
    transition: 0.2s;
}
.msg-modal-close:hover {
    color: #dc2626;
}
.msg-modal-body {
    padding: 24px;
    max-height: 70vh;
    overflow-y: auto;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-inbox" style="color: #0b7c4d;"></i> ইনবক্স মেসেজ (Contact Messages)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ওয়েবসাইটের যোগাযোগ ফর্ম (Contact Form) থেকে প্রেরিত বার্তা ও মতামত পরিচালনা করুন।</p>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'read'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        বার্তাটি পঠিত (Read) হিসেবে চিহ্নিত করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        বার্তাটি সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_read'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-double" style="color: #16a34a; font-size: 18px;"></i>
        নির্বাচিত বার্তাগুলো পঠিত হিসেবে চিহ্নিত করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        নির্বাচিত বার্তাগুলো মুছে ফেলা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="msg-stats-grid">
    <div class="msg-stat-card" onclick="filterByStatus('all')">
        <div class="msg-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="msg-stat-info">
            <h4><?= $totalMessages ?></h4>
            <p>মোট বার্তা (Total)</p>
        </div>
    </div>

    <div class="msg-stat-card" onclick="filterByStatus('unread')">
        <div class="msg-stat-icon" style="background: #fef2f2; color: #dc2626;">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <div class="msg-stat-info">
            <h4 style="color: #dc2626;"><?= $unreadCount ?></h4>
            <p>অপঠিত বার্তা (Unread)</p>
        </div>
    </div>

    <div class="msg-stat-card" onclick="filterByStatus('read')">
        <div class="msg-stat-icon" style="background: #f1f5f9; color: #64748b;">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="msg-stat-info">
            <h4 style="color: #64748b;"><?= $readCount ?></h4>
            <p>পঠিত বার্তা (Read)</p>
        </div>
    </div>
</div>

<!-- Controls: Filter Tabs, Live Search & Bulk Actions -->
<form action="<?= URLROOT ?>/admin/bulk_messages" method="POST" id="bulk-messages-form">
    <?= csrf_field() ?>

    <div class="msg-control-card">
        <!-- Status Tabs -->
        <div class="msg-filter-tabs">
            <button type="button" class="msg-filter-tab active" data-filter="all" onclick="setFilterTab('all', this)">
                <i class="fas fa-list-ul"></i> সকল বার্তা <span class="msg-filter-badge"><?= $totalMessages ?></span>
            </button>
            <button type="button" class="msg-filter-tab" data-filter="unread" onclick="setFilterTab('unread', this)">
                <i class="fas fa-envelope"></i> অপঠিত বার্তা <span class="msg-filter-badge" style="background: #fee2e2; color: #dc2626;"><?= $unreadCount ?></span>
            </button>
            <button type="button" class="msg-filter-tab" data-filter="read" onclick="setFilterTab('read', this)">
                <i class="fas fa-check"></i> পঠিত বার্তা <span class="msg-filter-badge"><?= $readCount ?></span>
            </button>
        </div>

        <!-- Search + Bulk Row -->
        <div class="msg-search-row">
            <!-- Live Search -->
            <div class="msg-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="msgSearchInput" placeholder="প্রেরকের নাম, ইমেইল, বিষয় বা বার্তার অংশ লিখে খুঁজুন..." onkeyup="filterMessagesTable()">
            </div>

            <!-- Bulk Actions -->
            <div style="display: flex; gap: 8px; align-items: center;">
                <select name="action" id="bulk-messages-select" class="form-control" style="width: auto; border-radius: 10px; border: 1px solid #cbd5e1; padding: 9px 14px; font-size: 0.92rem; font-weight: 600;">
                    <option value="">বাল্ক অ্যাকশন (Bulk)</option>
                    <option value="read">পঠিত চিহ্নিত করুন (Mark Read)</option>
                    <option value="delete">মুছে ফেলুন (Delete Selected)</option>
                </select>
                <button type="submit" class="btn btn-secondary" style="background: #334155; color: white; border: none; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 0.9rem;">
                    প্রয়োগ
                </button>
            </div>
        </div>
    </div>

    <!-- Messages Data Table -->
    <div class="msg-table-card">
        <div style="overflow-x: auto;">
            <table class="msg-table" id="msgTable">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-messages" style="transform: scale(1.15); cursor: pointer;" title="সবগুলো নির্বাচন করুন">
                        </th>
                        <th style="width: 26%;">প্রেরক (Sender)</th>
                        <th style="width: 22%;">বিষয় (Subject)</th>
                        <th style="width: 32%;">বার্তা (Message)</th>
                        <th style="width: 10%; text-align: center;">স্ট্যাটাস</th>
                        <th style="width: 10%; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="msgTableBody">
                    <?php if (!empty($messagesList)): ?>
                        <?php foreach ($messagesList as $m): ?>
                        <?php
                            $status = $m['status'] ?? 'read';
                            $userInitial = mb_substr(trim($m['name'] ?? 'M'), 0, 1, 'UTF-8');
                            $msgDate = !empty($m['created_at']) ? date('d M Y, h:i A', strtotime($m['created_at'])) : '';
                        ?>
                        <tr class="msg-row <?= $status === 'unread' ? 'unread-row' : '' ?>" data-status="<?= $status ?>">
                            <!-- Checkbox -->
                            <td style="text-align: center; vertical-align: top;">
                                <input type="checkbox" name="message_ids[]" value="<?= $m['id'] ?>" class="message-checkbox" style="transform: scale(1.15); cursor: pointer;">
                            </td>

                            <!-- Sender Info -->
                            <td>
                                <div class="msg-user-cell">
                                    <div class="msg-user-avatar" style="<?= $status === 'unread' ? 'background: linear-gradient(135deg, #dc2626, #ef4444);' : '' ?>">
                                        <?= htmlspecialchars($userInitial) ?>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="msg-user-name"><?= htmlspecialchars($m['name']) ?></div>
                                        <div class="msg-user-email"><?= htmlspecialchars($m['email']) ?></div>
                                        <?php if (!empty($msgDate)): ?>
                                            <div class="msg-date-pill">
                                                <i class="far fa-calendar-alt"></i> <?= $msgDate ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <!-- Subject -->
                            <td>
                                <div class="msg-subject-text">
                                    <?= htmlspecialchars($m['subject']) ?>
                                </div>
                            </td>

                            <!-- Message Content -->
                            <td>
                                <div class="msg-body-preview">
                                    <?= htmlspecialchars(mb_strimwidth(strip_tags($m['message']), 0, 140, "...")) ?>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td style="text-align: center;">
                                <?php if ($status === 'unread'): ?>
                                    <span class="msg-badge-unread">
                                        <i class="fas fa-envelope"></i> অপঠিত
                                    </span>
                                <?php else: ?>
                                    <span class="msg-badge-read">
                                        <i class="fas fa-check"></i> পঠিত
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px; flex-wrap: wrap;">
                                    <!-- View Modal -->
                                    <button type="button" class="msg-action-btn msg-btn-view" title="সম্পূর্ণ বার্তা পড়ুন" onclick="openMessageModal(<?= htmlspecialchars(json_encode([
                                        'id' => $m['id'],
                                        'name' => $m['name'],
                                        'email' => $m['email'],
                                        'subject' => $m['subject'],
                                        'message' => $m['message'],
                                        'status' => $status,
                                        'date' => $msgDate
                                    ])) ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Reply via Email -->
                                    <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re: <?= urlencode($m['subject']) ?>" class="msg-action-btn msg-btn-reply" title="ইমেইলে উত্তর দিন">
                                        <i class="fas fa-reply"></i>
                                    </a>

                                    <!-- Mark Read -->
                                    <?php if ($status === 'unread'): ?>
                                        <a href="<?= URLROOT ?>/admin/mark_read/<?= $m['id'] ?>" class="msg-action-btn msg-btn-check" title="পঠিত হিসেবে চিহ্নিত করুন">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Delete -->
                                    <a href="<?= URLROOT ?>/admin/delete_message/<?= $m['id'] ?>" class="msg-action-btn msg-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই বার্তাটি মুছে ফেলতে চান?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="msgNoDataRow">
                            <td colspan="6" style="padding: 60px 20px; text-align: center; color: #64748b;">
                                <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">ইনবক্স খালি</h4>
                                <p style="margin: 0; font-size: 0.9rem;">ভিজিটররা যোগাযোগ ফর্ম থেকে বার্তা পাঠালে তা এখানে জমা হবে।</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<!-- Message Reader Modal -->
<div class="msg-modal-backdrop" id="msgModalBackdrop" onclick="handleModalBackdropClick(event)">
    <div class="msg-modal" id="msgModal">
        <div class="msg-modal-header">
            <h3 class="msg-modal-title">
                <i class="fas fa-envelope-open" style="color: #0b7c4d;"></i> বার্তার বিবরণ
            </h3>
            <button type="button" class="msg-modal-close" onclick="closeMessageModal()">&times;</button>
        </div>
        <div class="msg-modal-body">
            <!-- Sender Card -->
            <div style="background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 18px; border: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap;">
                    <div>
                        <h4 id="modalSenderName" style="margin: 0; color: #1e293b; font-weight: 700; font-size: 1.05rem;"></h4>
                        <div id="modalSenderEmail" style="color: #64748b; font-size: 0.88rem; margin-top: 3px;"></div>
                    </div>
                    <div id="modalStatusBadge"></div>
                </div>
                <div style="margin-top: 10px; font-size: 0.8rem; color: #94a3b8; display: flex; align-items: center; gap: 5px;">
                    <i class="far fa-calendar-alt"></i> <span id="modalDate"></span>
                </div>
            </div>

            <!-- Subject -->
            <div style="margin-bottom: 16px;">
                <label style="font-weight: 700; color: #1e293b; font-size: 0.88rem; margin-bottom: 4px; display: block;">বিষয় (Subject):</label>
                <div id="modalSubject" style="font-weight: 700; color: #0f172a; font-size: 1rem; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px;"></div>
            </div>

            <!-- Message Content -->
            <div>
                <label style="font-weight: 700; color: #1e293b; font-size: 0.88rem; margin-bottom: 4px; display: block;">বার্তা (Message):</label>
                <div id="modalMessageBody" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0b7c4d; border-radius: 10px; padding: 14px 16px; color: #1e293b; font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap; font-family: 'Hind Siliguri', sans-serif;"></div>
            </div>
        </div>
        <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <div id="modalActionButtons" style="display: flex; gap: 8px;"></div>
            <button type="button" class="btn btn-secondary" onclick="closeMessageModal()" style="background: #e2e8f0; color: #475569; border: none; border-radius: 10px; padding: 8px 18px; font-weight: 600;">
                বন্ধ করুন
            </button>
        </div>
    </div>
</div>

<script>
// Select All Checkbox logic
document.getElementById('select-all-messages').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.message-checkbox');
    checkboxes.forEach(cb => {
        const row = cb.closest('tr');
        if (row && row.style.display !== 'none') {
            cb.checked = this.checked;
        }
    });
});

// Bulk Form submit confirmation
document.getElementById('bulk-messages-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-messages-select').value;
    if (!action) {
        alert('অনুগ্রহ করে একটি বাল্ক অ্যাকশন নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.message-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('অনুগ্রহ করে অন্তত একটি বার্তা নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি বার্তা মুছে ফেলতে চান?`;
    } else if (action === 'read') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি বার্তা পঠিত হিসেবে চিহ্নিত করতে চান?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});

// Current Filter State
let currentStatusFilter = 'all';

function setFilterTab(status, tabBtn) {
    currentStatusFilter = status;
    document.querySelectorAll('.msg-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterMessagesTable();
}

function filterByStatus(status) {
    const btn = document.querySelector(`.msg-filter-tab[data-filter="${status}"]`);
    if (btn) {
        btn.click();
    } else {
        currentStatusFilter = status;
        filterMessagesTable();
    }
}

function filterMessagesTable() {
    const searchVal = document.getElementById('msgSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#msgTableBody .msg-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status') || '';
        const rowText = row.innerText.toLowerCase();

        // 1. Status Filter
        let matchesStatus = false;
        if (currentStatusFilter === 'all') {
            matchesStatus = true;
        } else if (currentStatusFilter === rowStatus) {
            matchesStatus = true;
        }

        // 2. Search Filter
        let matchesSearch = true;
        if (searchVal && !rowText.includes(searchVal)) {
            matchesSearch = false;
        }

        if (matchesStatus && matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Handle No Matching Search
    let noMatchRow = document.getElementById('msgNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'msgNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো বার্তা মেলেনি।</td>';
            document.getElementById('msgTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}

// Modal handling
function openMessageModal(data) {
    document.getElementById('modalSenderName').innerText = data.name || 'Anonymous';
    document.getElementById('modalSenderEmail').innerText = data.email || '';
    document.getElementById('modalDate').innerText = data.date || '';
    document.getElementById('modalSubject').innerText = data.subject || 'No subject';
    document.getElementById('modalMessageBody').innerText = data.message || '';

    // Status Badge
    const statusBadge = document.getElementById('modalStatusBadge');
    if (data.status === 'unread') {
        statusBadge.innerHTML = '<span class="msg-badge-unread"><i class="fas fa-envelope"></i> অপঠিত</span>';
    } else {
        statusBadge.innerHTML = '<span class="msg-badge-read"><i class="fas fa-check"></i> পঠিত</span>';
    }

    // Modal Action Buttons
    const actionContainer = document.getElementById('modalActionButtons');
    let actionHtml = `
        <a href="mailto:${encodeURIComponent(data.email)}?subject=Re: ${encodeURIComponent(data.subject)}" class="btn btn-success" style="background: #16a34a; border-color: #16a34a; color: white; border-radius: 10px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-reply"></i> ইমেইলে উত্তর দিন
        </a>
    `;

    if (data.status === 'unread') {
        actionHtml += `
            <a href="<?= URLROOT ?>/admin/mark_read/${data.id}" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; color: white; border-radius: 10px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-check"></i> পঠিত চিহ্নিত করুন
            </a>
        `;
    }

    actionHtml += `
        <a href="<?= URLROOT ?>/admin/delete_message/${data.id}" class="btn btn-danger" onclick="return confirm('আপনি কি নিশ্চিত যে এই বার্তাটি মুছে ফেলতে চান?')" style="background: #dc2626; border-color: #dc2626; color: white; border-radius: 10px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-trash-alt"></i> মুছে ফেলুন
        </a>
    `;

    actionContainer.innerHTML = actionHtml;

    const backdrop = document.getElementById('msgModalBackdrop');
    backdrop.classList.add('show');
}

function closeMessageModal() {
    const backdrop = document.getElementById('msgModalBackdrop');
    backdrop.classList.remove('show');
}

function handleModalBackdropClick(event) {
    if (event.target === document.getElementById('msgModalBackdrop')) {
        closeMessageModal();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMessageModal();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
