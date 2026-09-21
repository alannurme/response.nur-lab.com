<?php 
require APPROOT . '/Views/inc/header.php'; 

if (!function_exists('get_qa_page_url')) {
    function get_qa_page_url($pageNum) {
        $params = $_GET;
        $params['page'] = $pageNum;
        return URLROOT . '/q&a?' . http_build_query($params);
    }
}
?>

<style>
    :root {
        --primary-green: #0b7c4d;
        --primary-hover: #075f3a;
        --bg-color: #f2f5f8;
        --card-bg: #ffffff;
        --text-main: #2c3e50;
        --text-muted: #7f8c8d;
        --border-color: #eaedf1;
    }

    .dashboard-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 40px 15px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Layout Grid */
    .layout-grid {
        display: grid;
        grid-template-columns: 260px 1fr 340px;
        gap: 30px;
        margin-top: 30px;
        padding-bottom: 50px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Left Sidebar */
    .left-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Sidebar Nav List */
    .sidebar-menu {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 15px 10px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        gap: 5px;
        position: sticky;
        top: 110px;
        z-index: 80;
    }

    .menu-link {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 20px;
        color: #4f5e71;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 15px;
        transition: 0.3s;
    }

    .menu-link i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .menu-link:hover, .menu-link.active {
        background: rgba(11, 124, 77, 0.05);
        color: var(--primary-green);
    }

    .menu-link.active i {
        color: var(--primary-green);
    }

    /* Middle Content Area */
    .main-content {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .qa-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .qa-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(11, 124, 77, 0.04);
        border-color: var(--primary-green);
    }

    .qa-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-weight: 600;
    }

    .qa-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .question-text {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.5;
    }

    .answer-snippet {
        font-size: 0.95rem;
        color: #4f5e71;
        line-height: 1.7;
    }

    .view-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        transition: 0.2s;
        margin-top: 5px;
    }

    .view-more-btn:hover {
        color: var(--primary-hover);
        gap: 12px;
    }

    /* Right Sidebar Column */
    .right-sidebar {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .right-sidebar .widget-card {
        position: sticky;
        top: 110px;
        z-index: 80;
    }

    .widget-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 25px;
    }

    .widget-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 20px;
        border-bottom: 1.5px solid var(--border-color);
        padding-bottom: 10px;
    }

    .widget-title i {
        color: var(--primary-green);
    }

    .category-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .category-item {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 15px;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: inherit;
        transition: 0.3s;
    }

    .category-item:hover {
        border-color: var(--primary-green);
        background: rgba(11, 124, 77, 0.02);
        color: var(--primary-green);
    }

    .category-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-main);
    }

    .qa-search-sticky {
        position: sticky;
        top: 110px;
        z-index: 90;
        margin-bottom: 25px;
        background: white;
        padding: 20px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        width: 100%;
        box-sizing: border-box;
    }
    @media (max-width: 1024px) {
        .qa-search-sticky {
            position: static !important;
            top: auto !important;
            padding: 15px;
            border-radius: 15px;
            width: 100%;
            box-sizing: border-box;
        }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .layout-grid {
            grid-template-columns: 220px 1fr;
        }
        .right-sidebar {
            grid-column: span 2;
            margin-top: 20px;
        }
        .right-sidebar .widget-card {
            position: static;
        }
    }

    @media (max-width: 992px) {
        .layout-grid {
            grid-template-columns: 1fr;
        }
        .left-sidebar {
            display: none;
        }
        .right-sidebar {
            grid-column: span 1;
            margin-top: 20px;
        }
        .search-container {
            display: none;
        }
    }

    /* Additional Mobile Specific Responsiveness */
    .qa-search-form {
        display: flex;
        gap: 15px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        .qa-card {
            padding: 20px;
            border-radius: 16px;
            gap: 12px;
        }
        .question-text {
            font-size: 1.05rem;
        }
        .qa-search-form {
            flex-direction: column;
            gap: 10px;
        }
        .qa-search-form > div {
            width: 100%;
        }
        .qa-search-form button, 
        .qa-search-form a {
            width: 100%;
            justify-content: center;
        }
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 25px 0;
        user-select: none;
    }
    .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #4f5e71;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .page-link:hover {
        background: var(--primary-green) !important;
        color: #fff !important;
        border-color: var(--primary-green) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(11, 124, 77, 0.15);
    }
    .page-link.active {
        background: var(--primary-green) !important;
        color: #fff !important;
        border-color: var(--primary-green) !important;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(11, 124, 77, 0.15);
        cursor: default;
        pointer-events: none;
    }
    .page-link.disabled {
        background: #f1f5f9 !important;
        color: #94a3b8 !important;
        border-color: #e2e8f0 !important;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<div class="dashboard-container">
        <div class="layout-grid">
            
            <!-- Left Sidebar -->
            <aside class="left-sidebar">
                <!-- Navigation Menu -->
                <div class="sidebar-menu">
                    <?php 
                    $isBookmarksPage = isset($_GET['bookmarks']) && $_GET['bookmarks'] == 1;
                    ?>
                    <a href="<?= URLROOT ?>/q&amp;a" class="menu-link <?= !$isBookmarksPage ? 'active' : '' ?>">
                        <i class="fas fa-file-alt"></i> নতুন প্রশ্নোত্তর
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?= URLROOT ?>/q&amp;a?bookmarks=1" class="menu-link <?= $isBookmarksPage ? 'active' : '' ?>">
                            <i class="fas fa-bookmark"></i> পছন্দের প্রশ্নসমূহ
                        </a>
                    <?php endif; ?>
                    <a href="<?= URLROOT ?>/ask" class="menu-link">
                        <i class="fas fa-envelope"></i> প্রশ্ন পাঠান
                    </a>
                </div>
            </aside>

            <!-- Middle Content Area: Questions List -->
            <main class="main-content">
                
                <div style="margin-bottom: 10px;">
                    <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--text-main);"><?= htmlspecialchars($data['title']) ?></h2>
                </div>

                <!-- Q&A Dedicated Search Bar -->
                <div class="qa-search-sticky">
                    <form action="<?= URLROOT ?>/q&amp;a" method="GET" class="qa-search-form">
                        <?php if(!empty($_GET['category'])): ?>
                            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category']) ?>">
                        <?php endif; ?>
                        <div style="position: relative; flex: 1;">
                            <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="প্রশ্নোত্তরের মধ্যে খুঁজুন..." style="width: 100%; height: 50px; padding: 10px 20px 10px 45px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 1rem; outline: none; background: #f8fafc; font-family: inherit; transition: 0.3s;" onfocus="this.style.borderColor='var(--primary-green)'; this.style.background='#fff';">
                            <i class="fas fa-search" style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.1rem;"></i>
                        </div>
                        <button type="submit" style="background: var(--primary-green); color: white; border: none; border-radius: 12px; padding: 0 25px; height: 50px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(11, 124, 77, 0.2);" onmouseover="this.style.background='var(--primary-hover)';" onmouseout="this.style.background='var(--primary-green)';">অনুসন্ধান</button>
                        <a href="<?= URLROOT ?>/ask" style="background: linear-gradient(135deg, #0b7c4d, #075f3a); color: white; text-decoration: none; border-radius: 12px; padding: 0 25px; height: 50px; font-weight: 700; font-size: 1rem; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: 0.3s; box-shadow: 0 10px 20px rgba(11, 124, 77, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"><i class="fas fa-question-circle"></i> প্রশ্ন করুন</a>
                    </form>
                </div>

                <!-- Top Pagination -->
                <?php if (isset($data['total_pages']) && $data['total_pages'] > 1): ?>
                    <div class="pagination-container" style="margin-top: 10px; margin-bottom: 25px;">
                        <!-- Previous Arrow -->
                        <?php if ($data['current_page'] > 1): ?>
                            <a href="<?= get_qa_page_url($data['current_page'] - 1) ?>" class="page-link" title="পূর্ববর্তী"><i class="fas fa-chevron-left"></i></a>
                        <?php else: ?>
                            <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $start = max(1, $data['current_page'] - 2);
                        $end = min($data['total_pages'], $data['current_page'] + 2);

                        if ($start > 1) {
                            echo '<a href="' . get_qa_page_url(1) . '" class="page-link">1</a>';
                            if ($start > 2) {
                                echo '<span class="page-link disabled">...</span>';
                            }
                        }

                        for ($i = $start; $i <= $end; $i++) {
                            if ($i == $data['current_page']) {
                                echo '<span class="page-link active">' . $i . '</span>';
                            } else {
                                echo '<a href="' . get_qa_page_url($i) . '" class="page-link">' . $i . '</a>';
                            }
                        }

                        if ($end < $data['total_pages']) {
                            if ($end < $data['total_pages'] - 1) {
                                echo '<span class="page-link disabled">...</span>';
                            }
                            echo '<a href="' . get_qa_page_url($data['total_pages']) . '" class="page-link">' . $data['total_pages'] . '</a>';
                        }
                        ?>

                        <!-- Next Arrow -->
                        <?php if ($data['current_page'] < $data['total_pages']): ?>
                            <a href="<?= get_qa_page_url($data['current_page'] + 1) ?>" class="page-link" title="পরবর্তী"><i class="fas fa-chevron-right"></i></a>
                        <?php else: ?>
                            <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['questions'])): ?>
                    <?php foreach ($data['questions'] as $q): ?>
                        <div class="qa-card">
                            <div class="qa-meta">
                                <span><i class="fas fa-user"></i> <?= htmlspecialchars($q['name']) ?></span>
                                <?php if (!empty($q['category_name'])): ?>
                                    <span><i class="fas fa-folder"></i> <?= htmlspecialchars($q['category_name']) ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($q['answered_at'] ?? $q['created_at'])) ?></span>
                            </div>
                            
                            <h3 class="question-text">
                                <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-green)';" onmouseout="this.style.color='inherit';">
                                    <?= htmlspecialchars(mb_strimwidth($q['question'], 0, 160, "...")) ?>
                                </a>
                            </h3>

                            <?php if (!empty($q['answer'])): ?>
                                <div class="answer-toggle-section" style="margin-top: 10px; margin-bottom: 5px;">
                                    <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="toggle-answer-btn" style="background: rgba(11, 124, 77, 0.05); color: var(--primary-green); border: none; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: 0.3s; font-family: inherit; text-decoration: none;">
                                        <i class="fas fa-chevron-down"></i> উত্তর দেখুন
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Share Row -->
                            <?php
                                $qShareUrl = URLROOT . '/question/' . $q['id'];
                                $qShareText = urlencode(mb_strimwidth($q['question'], 0, 100, '...'));
                            ?>
                            <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-color); display: flex; align-items: center; flex-wrap: wrap; gap: 8px;">
                                <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; display:flex; align-items:center; gap:4px;"><i class="fas fa-bookmark"></i> বুকমার্ক:</span>

                                <!-- Bookmark Button -->
                                <?php 
                                $isBookmarked = in_array($q['id'], $data['bookmarked_ids'] ?? []);
                                ?>
                                <button onclick="toggleBookmark(<?= $q['id'] ?>, this)"
                                    title="<?= $isBookmarked ? 'বুকমার্ক মুছুন' : 'বুকমার্ক করুন' ?>"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; border:1.5px solid <?= $isBookmarked ? 'var(--primary-green)' : '#cbd5e1' ?>; background:<?= $isBookmarked ? '#f0fdf4' : '#f8fafc' ?>; color:<?= $isBookmarked ? 'var(--primary-green)' : '#64748b' ?>; font-size:0.8rem; cursor:pointer; transition:0.2s;"
                                    data-bookmarked="<?= $isBookmarked ? 'true' : 'false' ?>">
                                    <i class="<?= $isBookmarked ? 'fa-solid' : 'fa-regular' ?> fa-bookmark"></i>
                                </button>

                                <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; display:flex; align-items:center; gap:4px; margin-left: 10px;"><i class="fas fa-share-alt"></i> শেয়ার:</span>

                                <!-- Copy Link -->
                                <button onclick="copyQaLink('<?= htmlspecialchars($qShareUrl) ?>', this)"
                                    title="লিংক কপি করুন"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; border:1.5px solid #cbd5e1; background:#f8fafc; color:#64748b; font-size:0.8rem; cursor:pointer; transition:0.2s;"
                                    onmouseover="this.style.borderColor='var(--primary-green)'; this.style.color='var(--primary-green)'; this.style.background='#f0fdf4';"
                                    onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#64748b'; this.style.background='#f8fafc';">
                                    <i class="fas fa-link"></i>
                                </button>

                                <!-- WhatsApp -->
                                <a href="https://api.whatsapp.com/send?text=<?= $qShareText ?>%0A<?= urlencode($qShareUrl) ?>" target="_blank" rel="noopener"
                                    title="WhatsApp-এ শেয়ার করুন"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; background:#25d366; color:white; font-size:0.88rem; text-decoration:none; transition:0.2s;"
                                    onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">
                                    <i class="fab fa-whatsapp"></i>
                                </a>

                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($qShareUrl) ?>" target="_blank" rel="noopener"
                                    title="Facebook-এ শেয়ার করুন"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; background:#1877f2; color:white; font-size:0.85rem; text-decoration:none; transition:0.2s;"
                                    onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">
                                    <i class="fab fa-facebook-f"></i>
                                </a>


                                <!-- Telegram -->
                                <a href="https://t.me/share/url?url=<?= urlencode($qShareUrl) ?>&text=<?= $qShareText ?>" target="_blank" rel="noopener"
                                    title="Telegram-এ শেয়ার করুন"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; background:#0088cc; color:white; font-size:0.85rem; text-decoration:none; transition:0.2s;"
                                    onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>


                            </div>

                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 50px; background: white; border-radius: 20px; border: 1px solid var(--border-color); color: var(--text-muted); font-style: italic;">
                        <i class="fas fa-question-circle" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <p>এখনো কোনো প্রশ্নোত্তর প্রকাশ করা হয়নি।</p>
                    </div>
                <?php endif; ?>

                <!-- Bottom Pagination -->
                <?php if (isset($data['total_pages']) && $data['total_pages'] > 1): ?>
                    <div class="pagination-container" style="margin-top: 30px; margin-bottom: 10px;">
                        <!-- Previous Arrow -->
                        <?php if ($data['current_page'] > 1): ?>
                            <a href="<?= get_qa_page_url($data['current_page'] - 1) ?>" class="page-link" title="পূর্ববর্তী"><i class="fas fa-chevron-left"></i></a>
                        <?php else: ?>
                            <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $start = max(1, $data['current_page'] - 2);
                        $end = min($data['total_pages'], $data['current_page'] + 2);

                        if ($start > 1) {
                            echo '<a href="' . get_qa_page_url(1) . '" class="page-link">1</a>';
                            if ($start > 2) {
                                echo '<span class="page-link disabled">...</span>';
                            }
                        }

                        for ($i = $start; $i <= $end; $i++) {
                            if ($i == $data['current_page']) {
                                echo '<span class="page-link active">' . $i . '</span>';
                            } else {
                                echo '<a href="' . get_qa_page_url($i) . '" class="page-link">' . $i . '</a>';
                            }
                        }

                        if ($end < $data['total_pages']) {
                            if ($end < $data['total_pages'] - 1) {
                                echo '<span class="page-link disabled">...</span>';
                            }
                            echo '<a href="' . get_qa_page_url($data['total_pages']) . '" class="page-link">' . $data['total_pages'] . '</a>';
                        }
                        ?>

                        <!-- Next Arrow -->
                        <?php if ($data['current_page'] < $data['total_pages']): ?>
                            <a href="<?= get_qa_page_url($data['current_page'] + 1) ?>" class="page-link" title="পরবর্তী"><i class="fas fa-chevron-right"></i></a>
                        <?php else: ?>
                            <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </main>

            <!-- Right Sidebar Column -->
            <aside class="right-sidebar">
                <!-- Categories Widget -->
                <div class="widget-card" id="categories-widget">
                    <h3 class="widget-title">
                        <i class="fas fa-th-large"></i> ক্যাটাগরি
                    </h3>
                    <div class="category-list">
                        <?php if (!empty($data['categories'])): ?>
                            <?php foreach ($data['categories'] as $cat): ?>
                                <a href="<?= URLROOT ?>/q&amp;a?category=<?= $cat['slug'] ?>" class="category-item">
                                    <span class="category-name"><?= htmlspecialchars($cat['name']) ?></span>
                                    <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: var(--text-muted);"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="font-size: 0.9rem; color: var(--text-muted); font-style: italic; text-align: center;">কোনো ক্যাটাগরি পাওয়া যায়নি।</div>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>


<script>

function toggleBookmark(questionId, btn) {
    fetch('<?= URLROOT ?>/toggle_bookmark/' + questionId, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error' && data.message === 'not_logged_in') {
            alert('বুকমার্ক করতে অনুগ্রহ করে আগে লগইন করুন।');
            window.location.href = data.login_url;
        } else if (data.status === 'success') {
            const icon = btn.querySelector('i');
            if (data.action === 'added') {
                btn.style.borderColor = 'var(--primary-green)';
                btn.style.color = 'var(--primary-green)';
                btn.style.background = '#f0fdf4';
                btn.title = 'বুকমার্ক মুছুন';
                icon.className = 'fa-solid fa-bookmark';
            } else {
                btn.style.borderColor = '#cbd5e1';
                btn.style.color = '#64748b';
                btn.style.background = '#f8fafc';
                btn.title = 'বুকমার্ক করুন';
                icon.className = 'fa-regular fa-bookmark';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function copyQaLink(url, btn) {
    navigator.clipboard.writeText(url).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.borderColor = 'var(--primary-green)';
        btn.style.color = 'var(--primary-green)';
        btn.style.background = '#f0fdf4';
        setTimeout(function() {
            btn.innerHTML = original;
            btn.style.borderColor = '#cbd5e1';
            btn.style.color = '#64748b';
            btn.style.background = '#f8fafc';
        }, 2000);
    }).catch(function() {
        var ta = document.createElement('textarea');
        ta.value = url;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        btn.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(function() { btn.innerHTML = '<i class="fas fa-link"></i>'; }, 2000);
    });
}
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
