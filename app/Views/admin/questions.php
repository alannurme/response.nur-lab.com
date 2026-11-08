<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$questionsList = $data['questions'] ?? ($questions ?? []);
$categoriesList = $data['categories'] ?? ($categories ?? []);

// Calculate summary statistics
$totalCount = count($questionsList);
$answeredCount = 0;
$pendingCount = 0;
$guestPendingCount = 0;

foreach ($questionsList as $item) {
    if (($item['status'] ?? '') === 'answered') {
        $answeredCount++;
    } else {
        $pendingCount++;
    }
    if (!empty($item['pending_answers'])) {
        $guestPendingCount += count($item['pending_answers']);
    }
}
?>

<style>
.qa-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.qa-stat-card {
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
.qa-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.qa-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.qa-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.qa-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Bar */
.qa-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.qa-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.qa-filter-tab {
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
.qa-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.qa-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.qa-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.qa-filter-tab.active .qa-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

/* Search and Bulk row */
.qa-search-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.qa-search-box {
    position: relative;
    flex: 1;
    min-width: 260px;
}
.qa-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.qa-search-box input {
    width: 100%;
    padding: 9px 14px 9px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
}
.qa-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.qa-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.qa-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.qa-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.qa-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.qa-table tr:hover td {
    background: #fbfcfe;
}
.qa-table tr:last-child td {
    border-bottom: none;
}

/* User pill */
.qa-user-cell {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.qa-user-avatar {
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
.qa-user-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
    line-height: 1.3;
}
.qa-user-email {
    font-size: 0.82rem;
    color: #64748b;
    word-break: break-all;
    margin-top: 2px;
}
.qa-cat-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 0.74rem;
    font-weight: 700;
    background: #e2e8f0;
    color: #334155;
    margin-top: 4px;
}

/* Question text */
.qa-question-text {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.98rem;
    line-height: 1.5;
    margin-bottom: 6px;
}
.qa-answer-snippet {
    background: #f0fdf4;
    border-left: 3px solid #16a34a;
    border-radius: 6px;
    padding: 8px 12px;
    color: #166534;
    font-size: 0.88rem;
    line-height: 1.5;
    margin-top: 6px;
    word-break: break-word;
}
.qa-guest-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fffbeb;
    border: 1px solid #fef3c7;
    color: #b45309;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    margin-top: 6px;
}

/* Status badges */
.qa-badge-answered {
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
.qa-badge-pending {
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
.qa-action-btn {
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
.qa-btn-answer {
    background: #eff6ff;
    color: #2563eb;
}
.qa-btn-answer:hover {
    background: #2563eb;
    color: #ffffff;
}
.qa-btn-approve {
    background: #e6f4ea;
    color: #137333;
}
.qa-btn-approve:hover {
    background: #137333;
    color: #ffffff;
}
.qa-btn-view {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.qa-btn-view:hover {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.qa-btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.qa-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}

/* Quick Add Modal */
.qa-modal-backdrop {
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
.qa-modal-backdrop.show {
    display: flex;
}
.qa-modal {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 640px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: qaModalFade 0.25s ease-out;
}
@keyframes qaModalFade {
    from { opacity: 0; transform: translateY(-15px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.qa-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
}
.qa-modal-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.qa-modal-close {
    background: transparent;
    border: none;
    font-size: 1.3rem;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
    transition: 0.2s;
}
.qa-modal-close:hover {
    color: #dc2626;
}
.qa-modal-body {
    padding: 24px;
    max-height: 75vh;
    overflow-y: auto;
}
.qa-modal-body .form-group {
    margin-bottom: 18px;
}
.qa-modal-body label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    display: block;
    font-size: 0.9rem;
}
.qa-modal-body input, .qa-modal-body select, .qa-modal-body textarea {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    padding: 10px 14px;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
}
.qa-modal-body input:focus, .qa-modal-body select:focus, .qa-modal-body textarea:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-question-circle" style="color: #0b7c4d;"></i> প্রশ্নোত্তর ব্যবস্থাপনা (Q&A Management)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">ব্যবহারকারীদের প্রেরিত দ্বীনি ও সাধারণ জিজ্ঞাসা পর্যালোচনা, উত্তর প্রদান ও ক্যাটাগরি অনুসারে পরিচালনা করুন।</p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <!-- Add Question Button -->
        <button type="button" class="btn btn-primary" onclick="openAddQuestionModal()" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-plus-circle"></i> + নতুন প্রশ্ন যোগ করুন
        </button>
        <!-- Category Management Link -->
        <a href="<?= URLROOT ?>/admin/question_categories" class="btn btn-outline-secondary" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 10px 18px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
            <i class="fas fa-folder-open" style="color: #64748b;"></i> ক্যাটাগরি পরিচালনা
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'added'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        নতুন প্রশ্নটি সফলভাবে সিস্টেমে যুক্ত করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'answered'): ?>
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #2563eb; font-size: 18px;"></i>
        প্রশ্নের উত্তরটি সফলভাবে সংরক্ষিত হয়েছে এবং ব্যবহারকারীকে ইমেইলে জানানো হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        প্রশ্নটি সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'approved'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        গেস্ট উত্তরটি সফলভাবে অনুমোদন (Approve) করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_approved'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-check-double" style="color: #16a34a; font-size: 18px;"></i>
        নির্বাচিত প্রশ্নসমূহ সফলভাবে অনুমোদন করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'bulk_deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 700;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        নির্বাচিত প্রশ্নসমূহ সফলভাবে মুছে ফেলা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Summary Statistics Cards -->
<div class="qa-stats-grid">
    <div class="qa-stat-card" onclick="filterByStatus('all')">
        <div class="qa-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-comments"></i>
        </div>
        <div class="qa-stat-info">
            <h4><?= $totalCount ?></h4>
            <p>মোট প্রশ্ন (Total)</p>
        </div>
    </div>

    <div class="qa-stat-card" onclick="filterByStatus('pending')">
        <div class="qa-stat-icon" style="background: #fffbeb; color: #d97706;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="qa-stat-info">
            <h4 style="color: #d97706;"><?= $pendingCount ?></h4>
            <p>অপেক্ষমাণ প্রশ্ন (Pending)</p>
        </div>
    </div>

    <div class="qa-stat-card" onclick="filterByStatus('answered')">
        <div class="qa-stat-icon" style="background: #ecfdf5; color: #059669;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="qa-stat-info">
            <h4 style="color: #059669;"><?= $answeredCount ?></h4>
            <p>উত্তর সম্পন্ন (Answered)</p>
        </div>
    </div>

    <div class="qa-stat-card" onclick="filterByStatus('guest_pending')">
        <div class="qa-stat-icon" style="background: #eff6ff; color: #2563eb;">
            <i class="fas fa-user-edit"></i>
        </div>
        <div class="qa-stat-info">
            <h4 style="color: #2563eb;"><?= $guestPendingCount ?></h4>
            <p>গেস্ট উত্তর অপেক্ষমাণ</p>
        </div>
    </div>
</div>

<!-- Controls: Filter Tabs, Category Selector, Live Search & Bulk Actions -->
<form action="<?= URLROOT ?>/admin/bulk_questions" method="POST" id="bulk-questions-form">
    <?= csrf_field() ?>

    <div class="qa-control-card">
        <!-- Status Tabs -->
        <div class="qa-filter-tabs">
            <button type="button" class="qa-filter-tab active" data-filter="all" onclick="setFilterTab('all', this)">
                <i class="fas fa-list-ul"></i> সকল প্রশ্ন <span class="qa-filter-badge"><?= $totalCount ?></span>
            </button>
            <button type="button" class="qa-filter-tab" data-filter="pending" onclick="setFilterTab('pending', this)">
                <i class="fas fa-hourglass-half"></i> অপেক্ষমাণ <span class="qa-filter-badge"><?= $pendingCount ?></span>
            </button>
            <button type="button" class="qa-filter-tab" data-filter="answered" onclick="setFilterTab('answered', this)">
                <i class="fas fa-check"></i> উত্তর সম্পন্ন <span class="qa-filter-badge"><?= $answeredCount ?></span>
            </button>
            <?php if ($guestPendingCount > 0): ?>
            <button type="button" class="qa-filter-tab" data-filter="guest_pending" onclick="setFilterTab('guest_pending', this)" style="border-color: #fde68a;">
                <i class="fas fa-user-clock" style="color: #d97706;"></i> গেস্ট উত্তর রিভিউ <span class="qa-filter-badge" style="background: #fef3c7; color: #b45309;"><?= $guestPendingCount ?></span>
            </button>
            <?php endif; ?>
        </div>

        <!-- Search + Category + Bulk Row -->
        <div class="qa-search-row">
            <!-- Live Search -->
            <div class="qa-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="qaSearchInput" placeholder="প্রশ্ন, প্রশ্নকারীর নাম বা ইমেইল দিয়ে খুঁজুন..." onkeyup="filterQuestionsTable()">
            </div>

            <!-- Category Filter -->
            <div style="min-width: 200px;">
                <select id="qaCategoryFilter" class="form-control" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 9px 14px; font-size: 0.92rem; outline: none;" onchange="filterQuestionsTable()">
                    <option value="">সকল বিষয় / ক্যাটাগরি</option>
                    <?php if (!empty($categoriesList)): ?>
                        <?php foreach ($categoriesList as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Bulk Actions -->
            <div style="display: flex; gap: 8px; align-items: center;">
                <select name="action" id="bulk-questions-select" class="form-control" style="width: auto; border-radius: 10px; border: 1px solid #cbd5e1; padding: 9px 14px; font-size: 0.92rem; font-weight: 600;">
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

    <!-- Questions Data Table -->
    <div class="qa-table-card">
        <div style="overflow-x: auto;">
            <table class="qa-table" id="qaTable">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-questions" style="transform: scale(1.15); cursor: pointer;" title="সবগুলো নির্বাচন করুন">
                        </th>
                        <th style="width: 26%;">ব্যবহারকারী / প্রশ্নকারী</th>
                        <th style="width: 44%;">প্রশ্ন ও সমাধান</th>
                        <th style="width: 12%; text-align: center;">স্ট্যাটাস</th>
                        <th style="width: 18%; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="qaTableBody">
                    <?php if (!empty($questionsList)): ?>
                        <?php foreach ($questionsList as $q): ?>
                        <?php
                            $status = $q['status'] ?? 'pending';
                            $hasPendingAnswers = !empty($q['pending_answers']);
                            $catName = $q['category_name'] ?? '';
                            $userInitial = mb_substr(trim($q['name'] ?? 'U'), 0, 1, 'UTF-8');
                        ?>
                        <tr class="qa-row" 
                            data-status="<?= $status ?>" 
                            data-has-guest-pending="<?= $hasPendingAnswers ? 'yes' : 'no' ?>" 
                            data-category="<?= htmlspecialchars($catName) ?>">
                            
                            <!-- Checkbox -->
                            <td style="text-align: center; vertical-align: top;">
                                <input type="checkbox" name="question_ids[]" value="<?= $q['id'] ?>" class="question-checkbox" style="transform: scale(1.15); cursor: pointer;">
                            </td>

                            <!-- User Info -->
                            <td>
                                <div class="qa-user-cell">
                                    <div class="qa-user-avatar">
                                        <?= htmlspecialchars($userInitial) ?>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="qa-user-name"><?= htmlspecialchars($q['name']) ?></div>
                                        <div class="qa-user-email"><?= htmlspecialchars($q['email']) ?></div>
                                        
                                        <?php if (!empty($catName)): ?>
                                            <span class="qa-cat-badge">
                                                <i class="fas fa-tag" style="font-size: 0.65rem; margin-right: 3px;"></i><?= htmlspecialchars($catName) ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 6px;">
                                            <i class="far fa-calendar-alt"></i> <?= date('d M Y, h:i A', strtotime($q['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Question & Answer Preview -->
                            <td>
                                <div class="qa-question-text">
                                    <?= htmlspecialchars(mb_strimwidth($q['question'], 0, 180, "...")) ?>
                                </div>

                                <?php if ($status === 'answered' && !empty($q['answer'])): ?>
                                    <div class="qa-answer-snippet">
                                        <strong><i class="fas fa-reply" style="margin-right: 4px;"></i> উত্তর:</strong> 
                                        <?= htmlspecialchars(mb_strimwidth(strip_tags($q['answer']), 0, 140, "...")) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($hasPendingAnswers): ?>
                                    <a href="<?= URLROOT ?>/admin/answer_question/<?= $q['id'] ?>" class="qa-guest-pill" style="text-decoration: none;">
                                        <i class="fas fa-exclamation-circle"></i> গেস্ট উত্তর অপেক্ষমাণ (<?= count($q['pending_answers']) ?> টি)
                                    </a>
                                <?php endif; ?>
                            </td>

                            <!-- Status Badge -->
                            <td style="text-align: center;">
                                <?php if ($status === 'answered'): ?>
                                    <span class="qa-badge-answered">
                                        <i class="fas fa-check-circle"></i> উত্তর সম্পন্ন
                                    </span>
                                <?php else: ?>
                                    <span class="qa-badge-pending">
                                        <i class="fas fa-clock"></i> অপেক্ষমাণ
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px; flex-wrap: wrap;">
                                    <?php if ($status !== 'answered'): ?>
                                        <a href="<?= URLROOT ?>/admin/approve_question/<?= $q['id'] ?>" class="qa-action-btn qa-btn-approve" title="উত্তর ছাড়া অনুমোদন করুন">
                                            <i class="fas fa-check"></i> অনুমোদন
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= URLROOT ?>/admin/answer_question/<?= $q['id'] ?>" class="qa-action-btn qa-btn-answer" title="<?= $status === 'answered' ? 'উত্তর সম্পাদনা করুন' : 'উত্তর প্রদান করুন' ?>">
                                        <i class="fas fa-reply"></i> <?= $status === 'answered' ? 'সম্পাদনা' : 'উত্তর দিন' ?>
                                    </a>

                                    <?php if ($status === 'answered'): ?>
                                        <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" target="_blank" class="qa-action-btn qa-btn-view" title="পাবলিক ভিউ দেখুন">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= URLROOT ?>/admin/delete_question/<?= $q['id'] ?>" class="qa-action-btn qa-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই প্রশ্নটি স্থায়ীভাবে মুছে ফেলতে চান?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="qaNoDataRow">
                            <td colspan="5" style="padding: 60px 20px; text-align: center; color: #64748b;">
                                <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                    <i class="fas fa-question"></i>
                                </div>
                                <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">এখনো কোনো প্রশ্ন জমা পড়েনি</h4>
                                <p style="margin: 0 0 16px 0; font-size: 0.9rem;">এডমিন হিসেবে সরাসরি নতুন প্রশ্ন ও উত্তর যোগ করতে পারেন।</p>
                                <button type="button" class="btn btn-primary" onclick="openAddQuestionModal()" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; font-weight: 700;">
                                    <i class="fas fa-plus-circle"></i> + প্রথম প্রশ্ন যোগ করুন
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<!-- Quick Add Question Modal -->
<div class="qa-modal-backdrop" id="qaAddModalBackdrop" onclick="handleBackdropClick(event)">
    <div class="qa-modal" id="qaAddModal">
        <div class="qa-modal-header">
            <h3 class="qa-modal-title">
                <i class="fas fa-plus-circle" style="color: #0b7c4d;"></i> নতুন প্রশ্ন ও উত্তর যোগ করুন
            </h3>
            <button type="button" class="qa-modal-close" onclick="closeAddQuestionModal()">&times;</button>
        </div>
        
        <form action="<?= URLROOT ?>/admin/add_question" method="POST" id="quickAddQuestionForm">
            <?= csrf_field() ?>
            <div class="qa-modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <!-- Asker Name -->
                    <div class="form-group">
                        <label for="modal_name">প্রশ্নকারীর নাম</label>
                        <input type="text" id="modal_name" name="name" value="এডমিন" placeholder="যেমন: আব্দুল্লাহ" required>
                    </div>

                    <!-- Asker Email -->
                    <div class="form-group">
                        <label for="modal_email">ইমেইল ঠিকানা</label>
                        <input type="email" id="modal_email" name="email" value="<?= htmlspecialchars($settings['site_email'] ?? 'admin@nur-lab.com') ?>" placeholder="admin@nur-lab.com">
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="modal_category">বিষয় / ক্যাটাগরি</label>
                    <select id="modal_category" name="category_id">
                        <option value="">-- সাধারণ / কোনো নির্দিষ্ট বিভাগ ছাড়া --</option>
                        <?php if (!empty($categoriesList)): ?>
                            <?php foreach ($categoriesList as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Question -->
                <div class="form-group">
                    <label for="modal_question">প্রশ্ন <span style="color: #ef4444;">*</span></label>
                    <textarea id="modal_question" name="question" rows="3" placeholder="সম্পূর্ণ প্রশ্নটি বিস্তারিতভাবে লিখুন..." style="resize: vertical; font-family: 'Hind Siliguri', sans-serif;" required></textarea>
                </div>

                <!-- Answer -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="modal_answer">উত্তর (ঐচ্ছিক)</label>
                    <textarea id="modal_answer" name="answer" rows="4" placeholder="উত্তর প্রস্তুত থাকলে এখানে লিখুন (খালি রাখলে স্ট্যাটাস 'Pending' থাকবে)..." style="resize: vertical; font-family: 'Hind Siliguri', sans-serif;"></textarea>
                    <small style="display: block; margin-top: 5px; color: #64748b; font-size: 0.8rem;">
                        উত্তর প্রদান করলে স্ট্যাটাস সরাসরি "Answered" হবে এবং পাবলিক সাইটে প্রদর্শিত হবে।
                    </small>
                </div>
            </div>

            <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                <a href="<?= URLROOT ?>/admin/add_question" style="font-size: 0.85rem; color: #0b7c4d; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-expand-arrows-alt"></i> বিস্তারিত পেজে যান
                </a>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn btn-secondary" onclick="closeAddQuestionModal()" style="background: #e2e8f0; color: #475569; border: none; border-radius: 10px; padding: 9px 18px; font-weight: 600;">
                        বাতিল
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; padding: 9px 20px; font-weight: 700; box-shadow: 0 4px 12px rgba(11, 124, 77, 0.25);">
                        <i class="fas fa-check"></i> সংরক্ষণ করুন
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Select All Checkbox logic
document.getElementById('select-all-questions').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.question-checkbox');
    checkboxes.forEach(cb => {
        // Only select currently visible rows
        const row = cb.closest('tr');
        if (row && row.style.display !== 'none') {
            cb.checked = this.checked;
        }
    });
});

// Bulk Form submit confirmation
document.getElementById('bulk-questions-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-questions-select').value;
    if (!action) {
        alert('অনুগ্রহ করে একটি বাল্ক অ্যাকশন নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.question-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('অনুগ্রহ করে অন্তত একটি প্রশ্ন নির্বাচন করুন।');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি প্রশ্ন মুছে ফেলতে চান?`;
    } else if (action === 'approve') {
        confirmMsg = `আপনি কি নিশ্চিত যে নির্বাচিত ${checkedCount}টি প্রশ্ন অনুমোদন করতে চান?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});

// Current Filter State
let currentStatusFilter = 'all';

function setFilterTab(status, tabBtn) {
    currentStatusFilter = status;
    document.querySelectorAll('.qa-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterQuestionsTable();
}

function filterByStatus(status) {
    const btn = document.querySelector(`.qa-filter-tab[data-filter="${status}"]`);
    if (btn) {
        btn.click();
    } else {
        currentStatusFilter = status;
        filterQuestionsTable();
    }
}

function filterQuestionsTable() {
    const searchVal = document.getElementById('qaSearchInput').value.toLowerCase().trim();
    const catVal = document.getElementById('qaCategoryFilter').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#qaTableBody .qa-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status') || '';
        const hasGuestPending = row.getAttribute('data-has-guest-pending') === 'yes';
        const rowCategory = (row.getAttribute('data-category') || '').toLowerCase();
        const rowText = row.innerText.toLowerCase();

        // 1. Status Filter
        let matchesStatus = false;
        if (currentStatusFilter === 'all') {
            matchesStatus = true;
        } else if (currentStatusFilter === 'pending' && rowStatus === 'pending') {
            matchesStatus = true;
        } else if (currentStatusFilter === 'answered' && rowStatus === 'answered') {
            matchesStatus = true;
        } else if (currentStatusFilter === 'guest_pending' && hasGuestPending) {
            matchesStatus = true;
        }

        // 2. Category Filter
        let matchesCategory = true;
        if (catVal && !rowCategory.includes(catVal)) {
            matchesCategory = false;
        }

        // 3. Search Filter
        let matchesSearch = true;
        if (searchVal && !rowText.includes(searchVal)) {
            matchesSearch = false;
        }

        if (matchesStatus && matchesCategory && matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Check if zero rows match
    let noMatchRow = document.getElementById('qaNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'qaNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো প্রশ্ন মেলেনি।</td>';
            document.getElementById('qaTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}

// Modal handling
function openAddQuestionModal() {
    const backdrop = document.getElementById('qaAddModalBackdrop');
    backdrop.classList.add('show');
    document.getElementById('modal_question').focus();
}

function closeAddQuestionModal() {
    const backdrop = document.getElementById('qaAddModalBackdrop');
    backdrop.classList.remove('show');
}

function handleBackdropClick(event) {
    if (event.target === document.getElementById('qaAddModalBackdrop')) {
        closeAddQuestionModal();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAddQuestionModal();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
