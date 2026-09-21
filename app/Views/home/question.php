<?php require APPROOT . '/Views/inc/header.php'; ?>

<style>
    :root {
        --primary-green: #0b7c4d;
        --primary-hover: #075f3a;
        --bg-color: #f2f5f8;
        --card-bg: #ffffff;
        --text-main: #000000;
        --text-muted: #334155;
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

    .content-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 35px;
    }

    .content-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 15px;
    }

    .content-title i {
        color: var(--primary-green);
    }

    /* Answer Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #4f5e71;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 18px;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        font-size: 0.95rem;
        outline: none;
        transition: 0.3s;
        background: #f8fafc;
    }

    .form-control:focus {
        border-color: var(--primary-green);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.1);
    }

    .submit-btn {
        width: 100%;
        height: 50px;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 10px 20px rgba(11, 124, 77, 0.2);
    }

    .submit-btn:hover {
        background: var(--primary-hover);
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

    /* Q&A layout elements */
    .question-box {
        background: #f8fafc;
        border-left: 5px solid var(--primary-green);
        padding: 25px;
        border-radius: 0 20px 20px 0;
        margin-bottom: 30px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .qa-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 10px;
        display: flex;
        gap: 15px;
        font-weight: 600;
    }

    .qa-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .badge-q {
        background: rgba(11, 124, 77, 0.1);
        color: var(--primary-green);
    }

    .badge-a {
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
    }

    .badge-ga {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
    }

    .answer-box {
        background: #ffffff;
        border: 1px solid var(--border-color);
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.01);
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .answer-content,
    .answer-content * {
        text-align: justify;
        text-justify: inter-word;
    }

    .question-box a,
    .answer-box a {
        text-decoration: none;
    }

    .question-box a:hover,
    .answer-box a:hover {
        text-decoration: underline;
    }

    .guest-answers-header {
        font-size: 1.2rem;
        font-weight: 800;
        margin: 35px 0 20px 0;
        color: var(--text-main);
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .guest-answers-header i {
        color: #2563eb;
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

    .qa-search-form {
        display: flex;
        gap: 15px;
        width: 100%;
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
            position: static;
            align-self: auto;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
            width: 100%;
            box-sizing: border-box;
        }
        .content-card {
            padding: 20px;
            border-radius: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        .content-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .form-row {
            grid-template-columns: 1fr;
            gap: 10px;
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

    .answer-content, 
    .answer-content * {
        font-family: 'Noto Serif Bengali', serif !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        word-break: break-word !important;
    }
</style>

<div class="dashboard-container">
        <div class="layout-grid">
            
            <!-- Left Sidebar -->
            <aside class="left-sidebar">
                <!-- Navigation Menu -->
                <div class="sidebar-menu">
                    <a href="<?= URLROOT ?>/q&amp;a" class="menu-link active">
                        <i class="fas fa-file-alt"></i> নতুন প্রশ্নোত্তর
                    </a>
                    <a href="<?= URLROOT ?>/ask" class="menu-link">
                        <i class="fas fa-envelope"></i> প্রশ্ন পাঠান
                    </a>
                </div>
            </aside>

            <!-- Middle Content Area: Question Detail -->
            <main class="main-content">
                
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

                <a href="<?= URLROOT ?>/q&amp;a" style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary-green); text-decoration: none; font-weight: 700; margin-bottom: 10px; transition: 0.2s;">
                    <i class="fas fa-arrow-left"></i> সকল প্রশ্নোত্তর তালিকায় ফিরে যান
                </a>

                <?php if (isset($_SESSION['answer_error'])): ?>
                    <div style="padding: 15px 20px; background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; border-radius: 12px; font-weight: 600; text-align: center; margin-bottom: 15px;">
                        <?= $_SESSION['answer_error']; unset($_SESSION['answer_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['answer_success'])): ?>
                    <div style="padding: 20px 25px; background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; border-radius: 15px; text-align: center; box-shadow: 0 10px 25px rgba(22,163,74,0.05); margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px; color: #16a34a;"></i>
                        <p style="margin: 0; color: #166534; font-size: 0.95rem; font-weight: 700;"><?= $_SESSION['answer_success']; unset($_SESSION['answer_success']); ?></p>
                    </div>
                <?php endif; ?>

                <div class="content-card">
                    <!-- The Question -->
                    <div class="question-box">
                        <span class="qa-badge badge-q">
                            <i class="fas fa-question-circle"></i> প্রশ্ন
                        </span>
                        <div class="qa-meta">
                            <span><i class="fas fa-user"></i> <?= htmlspecialchars($data['question']['name']) ?></span>
                            <?php if (!empty($data['question']['category_name'])): ?>
                                <span><i class="fas fa-folder"></i> <?= htmlspecialchars($data['question']['category_name']) ?></span>
                            <?php endif; ?>
                            <span><i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($data['question']['created_at'])) ?></span>
                        </div>
                        <h2 style="font-size: 1.3rem; font-weight: 800; color: var(--text-main); line-height: 1.8; margin-top: 10px; font-family: 'Noto Serif Bengali', serif;">
                            <?= nl2br(htmlspecialchars($data['question']['question'])) ?>
                        </h2>

                        <!-- Share Bar -->
                        <?php
                            $shareUrl = URLROOT . '/question/' . $data['question']['id'];
                            $shareText = urlencode(mb_strimwidth($data['question']['question'], 0, 120, '...'));
                        ?>
                        <div class="share-bar" style="margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--border-color); display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; display: flex; align-items: center; gap: 5px;"><i class="fas fa-share-alt"></i> শেয়ার করুন:</span>

                            <!-- Copy Link -->
                            <button onclick="copyShareLink('<?= htmlspecialchars($shareUrl) ?>', this)"
                                title="লিংক কপি করুন"
                                style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; border:1.5px solid #cbd5e1; background:#f8fafc; color:#475569; cursor:pointer; transition:0.3s;"
                                onmouseover="this.style.borderColor='var(--primary-green)'; this.style.color='var(--primary-green)'; this.style.transform='scale(1.1)';"
                                onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#475569'; this.style.transform='scale(1)';">
                                <i class="fas fa-link" style="font-size: 1rem;"></i>
                            </button>

                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text=<?= $shareText ?>%0A<?= urlencode($shareUrl) ?>" target="_blank" rel="noopener"
                                title="WhatsApp-এ শেয়ার করুন"
                                style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#25d366; color:white; text-decoration:none; transition:0.3s;"
                                onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                <i class="fab fa-whatsapp" style="font-size:1.1rem;"></i>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareUrl) ?>" target="_blank" rel="noopener"
                                title="Facebook-এ শেয়ার করুন"
                                style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#1877f2; color:white; text-decoration:none; transition:0.3s;"
                                onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                <i class="fab fa-facebook-f" style="font-size:1rem;"></i>
                            </a>

                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url=<?= urlencode($shareUrl) ?>&text=<?= $shareText ?>" target="_blank" rel="noopener"
                                title="Telegram-এ শেয়ার করুন"
                                style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#0088cc; color:white; text-decoration:none; transition:0.3s;"
                                onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                <i class="fab fa-telegram-plane" style="font-size:1rem;"></i>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($shareUrl) ?>&title=<?= $shareText ?>" target="_blank" rel="noopener"
                                title="LinkedIn-এ শেয়ার করুন"
                                style="display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#0a66c2; color:white; text-decoration:none; transition:0.3s;"
                                onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                <i class="fab fa-linkedin-in" style="font-size:1rem;"></i>
                            </a>
                        </div>
                    </div>


                    <!-- The Official Admin Answer -->
                    <?php if (!empty($data['question']['answer'])): ?>
                        <div class="answer-box" style="border-left: 5px solid #16a34a;">
                            <span class="qa-badge badge-a">
                                <i class="fas fa-check-circle"></i> অফিসিয়াল উত্তর
                            </span>
                            <div class="qa-meta" style="margin-bottom: 15px;">
                                <span><i class="fas fa-user-shield"></i> গবেষক প্যানেল</span>
                                <span><i class="fas fa-calendar-check"></i> <?= date('d M Y', strtotime($data['question']['answered_at'])) ?></span>
                            </div>
                            <div class="answer-content" style="font-size: 1.25rem; color: #334155; line-height: 2; font-family: 'Noto Serif Bengali', serif !important;">
                                <?php 
                                    $ans = $data['question']['answer'];
                                    if ($ans === strip_tags($ans)) {
                                        echo nl2br(htmlspecialchars($ans));
                                    } else {
                                        echo htmlspecialchars_decode($ans);
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Guest Approved Answers -->
                    <?php if (!empty($data['answers'])): ?>
                        <h3 class="guest-answers-header">
                            <i class="fas fa-comments"></i> অন্যান্য উত্তরসমূহ (<?= count($data['answers']) ?>)
                        </h3>
                        <?php foreach ($data['answers'] as $ans): ?>
                            <div class="answer-box" style="border-left: 5px solid #2563eb; background: #f8fafc;">
                                <span class="qa-badge badge-ga">
                                    <i class="fas fa-comment-dots"></i> উত্তরদাতা: <?= htmlspecialchars($ans['name']) ?>
                                </span>
                                <div class="qa-meta">
                                    <span><i class="fas fa-clock"></i> <?= date('d M Y, h:i A', strtotime($ans['approved_at'] ?? $ans['created_at'])) ?></span>
                                </div>
                                <div class="answer-content" style="font-size: 1.25rem; color: #334155; line-height: 2; margin-top: 10px; font-family: 'Noto Serif Bengali', serif !important;">
                                    <?php 
                                        if ($ans['answer'] === strip_tags($ans['answer'])) {
                                            echo nl2br(htmlspecialchars($ans['answer']));
                                        } else {
                                            echo htmlspecialchars_decode($ans['answer']);
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Answer Submission Form -->
                    <div style="margin-top: 40px; border-top: 2px solid var(--border-color); padding-top: 30px;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-pen-fancy" style="color: var(--primary-green);"></i> আপনার উত্তর দিন
                        </h3>
                        <form action="<?= URLROOT ?>/submit_answer/<?= $data['question']['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                            <!-- Honeypot anti-spam field -->
                            <div style="display:none !important;" aria-hidden="true">
                                <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">আপনার নাম *</label>
                                    <input type="text" name="name" required class="form-control" placeholder="যেমন: আব্দুর রহমান">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ইমেইল ঠিকানা *</label>
                                    <input type="email" name="email" required class="form-control" placeholder="যেমন: rahman@email.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">আপনার উত্তর *</label>
                                <textarea name="answer" id="guest-answer-editor" rows="8" class="form-control" placeholder="আপনার উত্তরের সপক্ষে কুরআন ও হাদীসের দলিলসহ এখানে বিস্তারিত লিখুন..."></textarea>
                            </div>

                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane"></i> উত্তর জমা দিন
                            </button>
                        </form>
                    </div>

                </div>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#guest-answer-editor',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor blockquote | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 350,
        branding: false,
        promotion: false,
        content_style: "body { font-family: 'Noto Serif Bengali', serif; font-size: 1.1rem; }",
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

function copyShareLink(url, btn) {
    navigator.clipboard.writeText(url).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.borderColor = 'var(--primary-green)';
        btn.style.color = 'var(--primary-green)';
        btn.style.background = '#f0fdf4';
        setTimeout(function() {
            btn.innerHTML = original;
            btn.style.borderColor = '#cbd5e1';
            btn.style.color = '#475569';
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
