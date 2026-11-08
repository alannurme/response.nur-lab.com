<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$commentsList = $data['comments'] ?? ($comments ?? []);

// Calculate comment statistics
$totalComments = count($commentsList);
$approvedCount = 0;
$pendingCount = 0;

foreach ($commentsList as $item) {
    if (($item['status'] ?? '') === 'approved') {
        $approvedCount++;
    } else {
        $pendingCount++;
    }
}
?>

<style>
/* Stats Grid */
.comm-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.comm-stat-card {
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
.comm-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.comm-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.comm-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.comm-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.comm-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.comm-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.comm-filter-tab {
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
.comm-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.comm-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.comm-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.comm-filter-tab.active .comm-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

/* Search and Bulk row */
.comm-search-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.comm-search-box {
    position: relative;
    flex: 1;
    min-width: 280px;
}
.comm-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.comm-search-box input {
    width: 100%;
    padding: 9px 14px 9px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
}
.comm-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.comm-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.comm-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.comm-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.comm-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.comm-table tr:hover td {
    background: #fbfcfe;
}
.comm-table tr:last-child td {
    border-bottom: none;
}

/* User Pill */
.comm-user-cell {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.comm-user-avatar {
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
.comm-user-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
    line-height: 1.3;
}
.comm-user-email {
    font-size: 0.82rem;
    color: #64748b;
    word-break: break-all;
    margin-top: 2px;
}
.comm-date-pill {
    font-size: 0.78rem;
    color: #94a3b8;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Comment text */
.comm-body-box {
    background: #f8fafc;
    border-left: 3px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    color: #1e293b;
    font-size: 0.92rem;
    line-height: 1.6;
    word-break: break-word;
}
.comm-read-more-btn {
    display: inline-block;
    margin-top: 6px;
    color: #0b7c4d;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}
.comm-read-more-btn:hover {
    text-decoration: underline;
}

/* Post Badge */
.comm-post-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #2563eb;
    font-weight: 700;
    font-size: 0.88rem;
    line-height: 1.4;
    text-decoration: none;
    word-break: break-word;
    transition: color 0.15s;
}
.comm-post-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

/* Status badges */
.comm-badge-approved {
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
.comm-badge-pending {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef3c7;
    color: #b45309;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* Action buttons */
.comm-action-btn {
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
.comm-btn-approve {
    background: #e6f4ea;
    color: #137333;
}
.comm-btn-approve:hover {
    background: #137333;
    color: #ffffff;
}
.comm-btn-view {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.comm-btn-view:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
}
.comm-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.comm-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}

/* Detail Modal */
.comm-modal-backdrop {
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
.comm-modal-backdrop.show {
    display: flex;
}
.comm-modal {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: commModalFade 0.25s ease-out;
}
@keyframes commModalFade {
    from { opacity: 0; transform: translateY(-15px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.comm-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
}
.comm-modal-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.comm-modal-close {
    background: transparent;
    border: none;
    font-size: 1.3rem;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
    transition: 0.2s;
}
.comm-modal-close:hover {
    color: #dc2626;
}
.comm-modal-body {
    padding: 24px;
    max-height: 70vh;
    overflow-y: auto;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-comments" style="color: #0b7c4d;"></i> মন্তব্য ব্যবস্থাপনা (Comments Management)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ব্লগ পোস্ট ও আর্টিকেলে পাঠকদের প্রেরিত মতামত ও মন্তব্য পর্যালোচনা, অনুমোদন এবং পরিমিতকরণ করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/posts" class="btn btn-outline-secondary" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 10px 18px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
            <i class="fas fa-newspaper" style="color: #64748b;"></i> সকল পোস্ট দেখুন
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'approved'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        মন্তব্যটি সফলভাবে অনুমোদন (Approve) করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        মন্তব্যটি সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_approved'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-double" style="color: #16a34a; font-size: 18px;"></i>
        নির্বাচিত মন্তব্যসমূহ সফলভাবে অনুমোদন করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        নির্বাচিত মন্তব্যসমূহ সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="comm-stats-grid">
    <div class="comm-stat-card" onclick="filterByStatus('all')">
        <div class="comm-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-comments"></i>
        </div>
        <div class="comm-stat-info">
            <h4><?= $totalComments ?></h4>
            <p>মোট মন্তব্য (Total)</p>
        </div>
    </div>

    <div class="comm-stat-card" onclick="filterByStatus('pending')">
        <div class="comm-stat-icon" style="background: #fffbeb; color: #d97706;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="comm-stat-info">
            <h4 style="color: #d97706;"><?= $pendingCount ?></h4>
            <p>অপেক্ষমাণ মন্তব্য (Pending Review)</p>
        </div>
    </div>

    <div class="comm-stat-card" onclick="filterByStatus('approved')">
        <div class="comm-stat-icon" style="background: #ecfdf5; color: #059669;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="comm-stat-info">
            <h4 style="color: #059669;"><?= $approvedCount ?></h4>
            <p>অনুমোদিত মন্তব্য (Approved)</p>
        </div>
    </div>
</div>

<!-- Controls: Filter Tabs, Live Search & Bulk Actions -->
<form action="<?= URLROOT ?>/admin/bulk_comments" method="POST" id="bulk-comments-form">
    <?= csrf_field() ?>

    <div class="comm-control-card">
        <!-- Status Tabs -->
        <div class="comm-filter-tabs">
            <button type="button" class="comm-filter-tab active" data-filter="all" onclick="setFilterTab('all', this)">
                <i class="fas fa-list-ul"></i> সকল মন্তব্য <span class="comm-filter-badge"><?= $totalComments ?></span>
            </button>
            <button type="button" class="comm-filter-tab" data-filter="pending" onclick="setFilterTab('pending', this)">
                <i class="fas fa-hourglass-half"></i> অপেক্ষমাণ <span class="comm-filter-badge"><?= $pendingCount ?></span>
            </button>
            <button type="button" class="comm-filter-tab" data-filter="approved" onclick="setFilterTab('approved', this)">
                <i class="fas fa-check"></i> অনুমোদিত <span class="comm-filter-badge"><?= $approvedCount ?></span>
            </button>
        </div>

        <!-- Search + Bulk Row -->
        <div class="comm-search-row">
            <!-- Live Search -->
            <div class="comm-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="commSearchInput" placeholder="মন্তব্য, ব্যবহারকারীর নাম, ইমেইল বা পোস্টের শিরোনাম দিয়ে খুঁজুন..." onkeyup="filterCommentsTable()">
            </div>

            <!-- Bulk Actions -->
            <div style="display: flex; gap: 8px; align-items: center;">
                <select name="action" id="bulk-comments-select" class="form-control" style="width: auto; border-radius: 10px; border: 1px solid #cbd5e1; padding: 9px 14px; font-size: 0.92rem; font-weight: 600;">
                    <option value="">বাল্ক অ্যাকশন (Bulk)</option>
                    <option value="approve">নির্বাচিতগুলো অনুমোদন (Approve)</option>
                    <option value="delete">নির্বাচিতগুলো মুছে ফেলুন (Delete)</option>
                </select>
                <button type="submit" class="btn btn-secondary" style="background: #334155; color: white; border: none; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 0.9rem;">
                    প্রয়োগ
                </button>
            </div>
        </div>
    </div>

    <!-- Comments Data Table -->
    <div class="comm-table-card">
        <div style="overflow-x: auto;">
            <table class="comm-table" id="commTable">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-comments" style="transform: scale(1.15); cursor: pointer;" title="সবগুলো নির্বাচন করুন">
                        </th>
                        <th style="width: 25%;">মন্তব্যকারী (User)</th>
                        <th style="width: 35%;">মন্তব্য (Comment)</th>
                        <th style="width: 20%;">সংশ্লিষ্ট পোস্ট (Article)</th>
                        <th style="width: 10%; text-align: center;">স্ট্যাটাস</th>
                        <th style="width: 10%; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="commTableBody">
                    <?php if (!empty($commentsList)): ?>
                        <?php foreach ($commentsList as $c): ?>
                        <?php
                            $status = $c['status'] ?? 'pending';
                            $userInitial = mb_substr(trim($c['name'] ?? 'U'), 0, 1, 'UTF-8');
                            $commentText = $c['comment'] ?? '';
                            $isLong = mb_strlen($commentText) > 130;
                            $postTitle = $c['post_title'] ?? 'পোস্টের শিরোনাম পাওয়া যায়নি';
                            $postSlug = $c['post_slug'] ?? '';
                        ?>
                        <tr class="comm-row" data-status="<?= $status ?>">
                            <!-- Checkbox -->
                            <td style="text-align: center; vertical-align: top;">
                                <input type="checkbox" name="comment_ids[]" value="<?= $c['id'] ?>" class="comment-checkbox" style="transform: scale(1.15); cursor: pointer;">
                            </td>

                            <!-- User Info -->
                            <td>
                                <div class="comm-user-cell">
                                    <div class="comm-user-avatar">
                                        <?= htmlspecialchars($userInitial) ?>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="comm-user-name"><?= htmlspecialchars($c['name']) ?></div>
                                        <div class="comm-user-email"><?= htmlspecialchars($c['email']) ?></div>
                                        <div class="comm-date-pill">
                                            <i class="far fa-calendar-alt"></i> <?= date('d M Y, h:i A', strtotime($c['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Comment Text -->
                            <td>
                                <div class="comm-body-box" style="<?= $status === 'approved' ? 'border-left-color: #10b981;' : 'border-left-color: #f59e0b;' ?>">
                                    <?php if ($isLong): ?>
                                        <?= htmlspecialchars(mb_substr($commentText, 0, 130, 'UTF-8')) ?>...
                                        <button type="button" class="comm-read-more-btn" onclick="openCommentModal(<?= htmlspecialchars(json_encode([
                                            'id' => $c['id'],
                                            'name' => $c['name'],
                                            'email' => $c['email'],
                                            'comment' => $c['comment'],
                                            'post_title' => $postTitle,
                                            'post_slug' => $postSlug,
                                            'status' => $status,
                                            'created_at' => date('d M Y, h:i A', strtotime($c['created_at']))
                                        ])) ?>)">
                                            + সম্পূর্ণ পড়ুন (Read More)
                                        </button>
                                    <?php else: ?>
                                        <?= htmlspecialchars($commentText) ?>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Associated Post -->
                            <td>
                                <?php if (!empty($postSlug)): ?>
                                    <a href="<?= URLROOT ?>/<?= htmlspecialchars($postSlug) ?>" target="_blank" class="comm-post-link" title="আর্টিকেলটি ওপেন করুন">
                                        <i class="fas fa-external-link-alt" style="font-size: 0.75rem; flex-shrink: 0;"></i>
                                        <span><?= htmlspecialchars(mb_strimwidth($postTitle, 0, 65, "...")) ?></span>
                                    </a>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-style: italic; font-size: 0.85rem;">
                                        <?= htmlspecialchars($postTitle) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Status Badge -->
                            <td style="text-align: center;">
                                <?php if ($status === 'approved'): ?>
                                    <span class="comm-badge-approved">
                                        <i class="fas fa-check-circle"></i> অনুমোদিত
                                    </span>
                                <?php else: ?>
                                    <span class="comm-badge-pending">
                                        <i class="fas fa-clock"></i> অপেক্ষমাণ
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px; flex-wrap: wrap;">
                                    <?php if ($status === 'pending'): ?>
                                        <a href="<?= URLROOT ?>/admin/approve_comment/<?= $c['id'] ?>" class="comm-action-btn comm-btn-approve" title="অনুমোদন করুন">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>

                                    <button type="button" class="comm-action-btn comm-btn-view" title="মন্তব্যের বিস্তারিত বিবরণ" onclick="openCommentModal(<?= htmlspecialchars(json_encode([
                                        'id' => $c['id'],
                                        'name' => $c['name'],
                                        'email' => $c['email'],
                                        'comment' => $c['comment'],
                                        'post_title' => $postTitle,
                                        'post_slug' => $postSlug,
                                        'status' => $status,
                                        'created_at' => date('d M Y, h:i A', strtotime($c['created_at']))
                                    ])) ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <a href="<?= URLROOT ?>/admin/delete_comment/<?= $c['id'] ?>" class="comm-action-btn comm-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই মন্তব্যটি মুছে ফেলতে চান?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="commNoDataRow">
                            <td colspan="6" style="padding: 60px 20px; text-align: center; color: #64748b;">
                                <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">এখনো কোনো মন্তব্য জমা পড়েনি</h4>
                                <p style="margin: 0; font-size: 0.9rem;">ব্যবহারকারীরা ব্লগ পোস্টে মন্তব্য পাঠালে তা এখানে প্রদর্শিত হবে।</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<!-- Comment Detail Modal -->
<div class="comm-modal-backdrop" id="commModalBackdrop" onclick="handleModalBackdropClick(event)">
    <div class="comm-modal" id="commModal">
        <div class="comm-modal-header">
            <h3 class="comm-modal-title">
                <i class="fas fa-comment-dots" style="color: #0b7c4d;"></i> মন্তব্যের বিস্তারিত বিবরণ
            </h3>
            <button type="button" class="comm-modal-close" onclick="closeCommentModal()">&times;</button>
        </div>
        <div class="comm-modal-body">
            <!-- Author Card -->
            <div style="background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 18px; border: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap;">
                    <div>
                        <h4 id="modalAuthorName" style="margin: 0; color: #1e293b; font-weight: 700; font-size: 1.05rem;"></h4>
                        <div id="modalAuthorEmail" style="color: #64748b; font-size: 0.88rem; margin-top: 3px;"></div>
                    </div>
                    <div id="modalStatusBadge"></div>
                </div>
                <div style="margin-top: 10px; font-size: 0.8rem; color: #94a3b8; display: flex; align-items: center; gap: 5px;">
                    <i class="far fa-calendar-alt"></i> <span id="modalDate"></span>
                </div>
            </div>

            <!-- Associated Post Card -->
            <div style="margin-bottom: 18px;">
                <label style="font-weight: 700; color: #1e293b; font-size: 0.88rem; margin-bottom: 6px; display: block;">সংশ্লিষ্ট আর্টিকেল / পোস্ট:</label>
                <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 14px;">
                    <a id="modalPostLink" href="#" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-newspaper" style="color: #64748b;"></i>
                        <span id="modalPostTitle"></span>
                        <i class="fas fa-external-link-alt" style="font-size: 0.75rem; margin-left: auto;"></i>
                    </a>
                </div>
            </div>

            <!-- Comment Content -->
            <div>
                <label style="font-weight: 700; color: #1e293b; font-size: 0.88rem; margin-bottom: 6px; display: block;">মন্তব্য:</label>
                <div id="modalCommentText" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0b7c4d; border-radius: 10px; padding: 14px 16px; color: #1e293b; font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap; font-family: 'Hind Siliguri', sans-serif;"></div>
            </div>
        </div>
        <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
            <div id="modalActionButtons" style="display: flex; gap: 8px;"></div>
            <button type="button" class="btn btn-secondary" onclick="closeCommentModal()" style="background: #e2e8f0; color: #475569; border: none; border-radius: 10px; padding: 8px 18px; font-weight: 600;">
                বন্ধ করুন
            </button>
        </div>
    </div>
</div>

<script>
// Select All Checkbox logic
document.getElementById('select-all-comments').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.comment-checkbox');
    checkboxes.forEach(cb => {
        const row = cb.closest('tr');
        if (row && row.style.display !== 'none') {
            cb.checked = this.checked;
        }
    });
});

// Bulk Form submit confirmation
document.getElementById('bulk-comments-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-comments-select').value;
    if (!action) {
        alert('অনুগ্রহ করে একটি বাল্ক অ্যাকশন নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.comment-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('অনুগ্রহ করে অন্তত একটি মন্তব্য নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি মন্তব্য মুছে ফেলতে চান?`;
    } else if (action === 'approve') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি মন্তব্য অনুমোদন করতে চান?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});

// Current Filter State
let currentStatusFilter = 'all';

function setFilterTab(status, tabBtn) {
    currentStatusFilter = status;
    document.querySelectorAll('.comm-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterCommentsTable();
}

function filterByStatus(status) {
    const btn = document.querySelector(`.comm-filter-tab[data-filter="${status}"]`);
    if (btn) {
        btn.click();
    } else {
        currentStatusFilter = status;
        filterCommentsTable();
    }
}

function filterCommentsTable() {
    const searchVal = document.getElementById('commSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#commTableBody .comm-row');

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
    let noMatchRow = document.getElementById('commNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'commNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো মন্তব্য মেলেনি।</td>';
            document.getElementById('commTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}

// Modal handling
function openCommentModal(data) {
    document.getElementById('modalAuthorName').innerText = data.name || 'Anonymous';
    document.getElementById('modalAuthorEmail').innerText = data.email || 'No email';
    document.getElementById('modalDate').innerText = data.created_at || '';
    document.getElementById('modalCommentText').innerText = data.comment || '';
    document.getElementById('modalPostTitle').innerText = data.post_title || 'Post';

    const postLink = document.getElementById('modalPostLink');
    if (data.post_slug) {
        postLink.href = '<?= URLROOT ?>/' + data.post_slug;
        postLink.style.display = 'flex';
    } else {
        postLink.style.display = 'none';
    }

    // Status Badge
    const statusBadge = document.getElementById('modalStatusBadge');
    if (data.status === 'approved') {
        statusBadge.innerHTML = '<span class="comm-badge-approved"><i class="fas fa-check-circle"></i> অনুমোদিত</span>';
    } else {
        statusBadge.innerHTML = '<span class="comm-badge-pending"><i class="fas fa-clock"></i> অপেক্ষমাণ</span>';
    }

    // Modal Actions
    const actionContainer = document.getElementById('modalActionButtons');
    let actionHtml = '';

    if (data.status === 'pending') {
        actionHtml += `<a href="<?= URLROOT ?>/admin/approve_comment/${data.id}" class="btn btn-success" style="background: #16a34a; border-color: #16a34a; color: white; border-radius: 10px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-check"></i> অনুমোদন করুন</a>`;
    }

    actionHtml += `<a href="<?= URLROOT ?>/admin/delete_comment/${data.id}" class="btn btn-danger" onclick="return confirm('আপনি কি নিশ্চিত যে এই মন্তব্যটি মুছে ফেলতে চান?')" style="background: #dc2626; border-color: #dc2626; color: white; border-radius: 10px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-trash-alt"></i> মুছে ফেলুন</a>`;

    actionContainer.innerHTML = actionHtml;

    const backdrop = document.getElementById('commModalBackdrop');
    backdrop.classList.add('show');
}

function closeCommentModal() {
    const backdrop = document.getElementById('commModalBackdrop');
    backdrop.classList.remove('show');
}

function handleModalBackdropClick(event) {
    if (event.target === document.getElementById('commModalBackdrop')) {
        closeCommentModal();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCommentModal();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
