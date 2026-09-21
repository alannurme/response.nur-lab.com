<?php require APPROOT . '/Views/inc/header.php'; ?>

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
        width: 100%;
        box-sizing: border-box;
    }

    .content-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 35px;
        width: 100%;
        box-sizing: border-box;
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

    /* Q&A Form Styles */
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
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .qa-search-form {
        display: flex;
        gap: 15px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        .content-card {
            padding: 20px;
            border-radius: 16px;
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
</style>

<div class="dashboard-container">
        <div class="layout-grid">
            
            <!-- Left Sidebar -->
            <aside class="left-sidebar">
                <!-- Navigation Menu (Cleaned Up) -->
                <div class="sidebar-menu">
                    <a href="<?= URLROOT ?>/q&amp;a" class="menu-link">
                        <i class="fas fa-file-alt"></i> নতুন প্রশ্নোত্তর
                    </a>
                    <a href="<?= URLROOT ?>/ask" class="menu-link active">
                        <i class="fas fa-envelope"></i> প্রশ্ন পাঠান
                    </a>
                </div>
            </aside>

            <!-- Middle Content Area: Question Form -->
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
                
                <?php if (isset($_SESSION['ask_error'])): ?>
                    <div style="padding: 15px 20px; background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; border-radius: 12px; font-weight: 600; text-align: center;">
                        <?= $_SESSION['ask_error']; unset($_SESSION['ask_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['ask_success'])): ?>
                    <div style="padding: 25px 30px; background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; border-radius: 20px; text-align: center; box-shadow: 0 10px 25px rgba(22,163,74,0.05);">
                        <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px; color: #16a34a;"></i>
                        <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 8px;">প্রশ্নটি সফলভাবে জমা দেওয়া হয়েছে!</h3>
                        <p style="margin: 0; color: #166534; font-size: 0.95rem; line-height: 1.5;"><?= $_SESSION['ask_success']; unset($_SESSION['ask_success']); ?></p>
                    </div>
                <?php endif; ?>

                <div class="content-card">
                    <h2 class="content-title">
                        <i class="fas fa-envelope-open-text"></i> প্রশ্ন পাঠান
                    </h2>
                    
                    <form action="<?= URLROOT ?>/ask" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                        <!-- Honeypot anti-spam field -->
                        <div style="display:none !important;" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">আপনার নাম *</label>
                                <input type="text" name="name" required class="form-control" placeholder="যেমন: আব্দুল্লাহ">
                            </div>
                            <div class="form-group">
                                <label class="form-label">ইমেইল ঠিকানা *</label>
                                <input type="email" name="email" required class="form-control" placeholder="যেমন: example@email.com">
                            </div>
                        </div>

                        <!-- Q&A Category Dropdown -->
                        <div class="form-group">
                            <label class="form-label">ক্যাটাগরি নির্বাচন করুন *</label>
                            <select name="category_id" required class="form-control" style="height: 50px;">
                                <option value="">একটি ক্যাটাগরি বেছে নিন</option>
                                <?php if (!empty($data['categories'])): ?>
                                    <?php foreach ($data['categories'] as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 25px;">
                            <label class="form-label">আপনার প্রশ্ন *</label>
                            <textarea name="question" required rows="8" class="form-control" placeholder="আপনার প্রশ্নটি এখানে বিস্তারিত লিখুন..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> প্রশ্ন পাঠান
                        </button>
                    </form>
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

<?php require APPROOT . '/Views/inc/footer.php'; ?>
