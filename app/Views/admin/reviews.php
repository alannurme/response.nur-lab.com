<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$reviewsList = $data['reviews'] ?? ($reviews ?? []);
$totalReviews = count($reviewsList);
$fiveStarCount = 0;
$totalRating = 0;

foreach ($reviewsList as $r) {
    $rating = intval($r['rating'] ?? 5);
    $totalRating += $rating;
    if ($rating === 5) {
        $fiveStarCount++;
    }
}

$avgRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 5.0;
?>

<style>
/* Stats Grid */
.rev-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.rev-stat-card {
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
.rev-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.rev-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.rev-stat-info h4 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.rev-stat-info p {
    margin: 3px 0 0 0;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
}

/* Control Card */
.rev-control-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.rev-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.rev-filter-tab {
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
.rev-filter-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.rev-filter-tab.active {
    background: #0b7c4d;
    color: #ffffff;
    border-color: #0b7c4d;
}
.rev-filter-badge {
    background: rgba(0,0,0,0.08);
    font-size: 0.76rem;
    padding: 2px 7px;
    border-radius: 12px;
}
.rev-filter-tab.active .rev-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
}

.rev-search-box {
    position: relative;
    width: 100%;
}
.rev-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
}
.rev-search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    outline: none;
    transition: 0.2s;
    box-sizing: border-box;
}
.rev-search-box input:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
}

/* Table styling */
.rev-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}
.rev-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Hind Siliguri', sans-serif;
}
.rev-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e2e8f0;
}
.rev-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
    font-size: 0.94rem;
    transition: background 0.15s;
}
.rev-table tr:hover td {
    background: #fbfcfe;
}
.rev-table tr:last-child td {
    border-bottom: none;
}

.rev-btn-edit {
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
.rev-btn-edit:hover {
    background: #2563eb;
    color: #ffffff;
}
.rev-btn-delete {
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
.rev-btn-delete:hover {
    background: #dc2626;
    color: #ffffff;
}
</style>

<!-- Page Header -->
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 10px; margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fas fa-star" style="color: #eab308;"></i> পাঠকদের রিভিউ (Reader Reviews)
        </h1>
        <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">হোমপেজের পাঠক প্রশংসাপত্র ও রেটিং ক্যারোসেল পরিচালনা করুন।</p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/add_review" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(11, 124, 77, 0.25);">
            <i class="fas fa-plus-circle"></i> + নতুন রিভিউ যোগ করুন
        </a>
    </div>
</div>

<!-- Summary Statistics Cards -->
<div class="rev-stats-grid">
    <div class="rev-stat-card" onclick="filterByRating('all')">
        <div class="rev-stat-icon" style="background: #e6f4ea; color: #0b7c4d;">
            <i class="fas fa-comments"></i>
        </div>
        <div class="rev-stat-info">
            <h4><?= $totalReviews ?></h4>
            <p>মোট রিভিউ (Total Reviews)</p>
        </div>
    </div>

    <div class="rev-stat-card" onclick="filterByRating('5')">
        <div class="rev-stat-icon" style="background: #fef9c3; color: #ca8a04;">
            <i class="fas fa-star"></i>
        </div>
        <div class="rev-stat-info">
            <h4 style="color: #ca8a04;"><?= $fiveStarCount ?></h4>
            <p>৫-স্টার রিভিউ (5 Stars)</p>
        </div>
    </div>

    <div class="rev-stat-card" onclick="filterByRating('all')">
        <div class="rev-stat-icon" style="background: #eff6ff; color: #2563eb;">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="rev-stat-info">
            <h4 style="color: #2563eb;"><?= $avgRating ?> / 5.0</h4>
            <p>গড় রেটিং (Average Rating)</p>
        </div>
    </div>
</div>

<!-- Controls: Filter Tabs & Live Search -->
<div class="rev-control-card">
    <div class="rev-filter-tabs">
        <button type="button" class="rev-filter-tab active" data-rating="all" onclick="setFilterTab('all', this)">
            <i class="fas fa-list-ul"></i> সকল রিভিউ <span class="rev-filter-badge"><?= $totalReviews ?></span>
        </button>
        <button type="button" class="rev-filter-tab" data-rating="5" onclick="setFilterTab('5', this)">
            <i class="fas fa-star" style="color: #eab308;"></i> ৫-স্টার <span class="rev-filter-badge"><?= $fiveStarCount ?></span>
        </button>
        <button type="button" class="rev-filter-tab" data-rating="4" onclick="setFilterTab('4', this)">
            <i class="fas fa-star" style="color: #eab308;"></i> ৪-স্টার
        </button>
    </div>

    <div class="rev-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="revSearchInput" placeholder="পাঠকের নাম, পদবী বা রিভিউয়ের অংশ লিখে খুঁজুন..." onkeyup="filterReviewsTable()">
    </div>
</div>

<!-- Data Table -->
<div class="rev-table-card">
    <div style="overflow-x: auto;">
        <table class="rev-table" id="revTable">
            <thead>
                <tr>
                    <th style="width: 25%;">পাঠক (Reader)</th>
                    <th style="width: 15%;">পদবী / পরিচয়</th>
                    <th style="width: 15%;">রেটিং (Rating)</th>
                    <th style="width: 30%;">মতামত (Review)</th>
                    <th style="width: 5%; text-align: center;">ক্রম</th>
                    <th style="width: 10%; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody id="revTableBody">
                <?php if (!empty($reviewsList)): ?>
                    <?php foreach ($reviewsList as $rev): ?>
                    <?php 
                        $rating = intval($rev['rating'] ?? 5);
                        $photoUrl = !empty($rev['image']) ? $rev['image'] : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($rev['name'] ?? 'user'))) . '?d=mp&s=150';
                    ?>
                    <tr class="rev-row" data-rating="<?= $rating ?>">
                        <!-- Reader -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars($rev['name']) ?>" loading="lazy" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; flex-shrink: 0;">
                                <div style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($rev['name']) ?></div>
                            </div>
                        </td>

                        <!-- Designation -->
                        <td>
                            <span style="background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.84rem;">
                                <?= htmlspecialchars($rev['designation'] ?? 'নিয়মিত পাঠক') ?>
                            </span>
                        </td>

                        <!-- Rating -->
                        <td>
                            <div style="color: #eab308; display: flex; gap: 3px; font-size: 0.95rem;">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $rating ? 'fas' : 'far' ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                        </td>

                        <!-- Review text -->
                        <td>
                            <div style="color: #64748b; font-size: 0.9rem; line-height: 1.5; max-height: 55px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                <?= htmlspecialchars($rev['review_text']) ?>
                            </div>
                        </td>

                        <!-- Order -->
                        <td style="text-align: center;">
                            <span style="background: #f1f5f9; color: #475569; font-weight: 800; padding: 3px 8px; border-radius: 6px; font-size: 0.8rem;">
                                <?= $rev['order_index'] ?>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px;">
                                <a href="<?= URLROOT ?>/admin/edit_review/<?= $rev['id'] ?>" class="rev-btn-edit" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_review/<?= $rev['id'] ?>" class="rev-btn-delete" title="মুছে ফেলুন" onclick="return confirm('আপনি কি নিশ্চিত যে এই রিভিউটি মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="revNoDataRow">
                        <td colspan="6" style="padding: 60px 20px; text-align: center; color: #64748b;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 2rem; color: #94a3b8;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; color: #1e293b; font-weight: 700;">কোনো রিভিউ যুক্ত করা হয়নি</h4>
                            <p style="margin: 0 0 16px 0; font-size: 0.9rem;">হোমপেজের ক্যারোসেলের জন্য পাঠকদের রিভিউ যুক্ত করুন।</p>
                            <a href="<?= URLROOT ?>/admin/add_review" class="btn btn-primary" style="background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-plus-circle"></i> + প্রথম রিভিউ যোগ করুন
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let currentRatingFilter = 'all';

function setFilterTab(rating, tabBtn) {
    currentRatingFilter = rating;
    document.querySelectorAll('.rev-filter-tab').forEach(b => b.classList.remove('active'));
    if (tabBtn) {
        tabBtn.classList.add('active');
    }
    filterReviewsTable();
}

function filterByRating(rating) {
    const btn = document.querySelector(`.rev-filter-tab[data-rating="${rating}"]`);
    if (btn) {
        btn.click();
    } else {
        currentRatingFilter = rating;
        filterReviewsTable();
    }
}

function filterReviewsTable() {
    const searchVal = document.getElementById('revSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#revTableBody .rev-row');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowRating = row.getAttribute('data-rating') || '';
        const rowText = row.innerText.toLowerCase();

        let matchesRating = (currentRatingFilter === 'all' || rowRating === currentRatingFilter);
        let matchesSearch = (!searchVal || rowText.includes(searchVal));

        if (matchesRating && matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    let noMatchRow = document.getElementById('revNoMatchRow');
    if (visibleCount === 0 && rows.length > 0) {
        if (!noMatchRow) {
            noMatchRow = document.createElement('tr');
            noMatchRow.id = 'revNoMatchRow';
            noMatchRow.innerHTML = '<td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;"><i class="fas fa-search" style="margin-right: 8px;"></i> আপনার অনুসন্ধানের সাথে কোনো রিভিউ মেলেনি।</td>';
            document.getElementById('revTableBody').appendChild(noMatchRow);
        } else {
            noMatchRow.style.display = '';
        }
    } else if (noMatchRow) {
        noMatchRow.style.display = 'none';
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
