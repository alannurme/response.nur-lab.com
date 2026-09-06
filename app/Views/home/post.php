<?php 
require APPROOT . '/Views/inc/header.php'; 

if (!function_exists('resolve_blog_image')) {
    function resolve_blog_image($image_path) {
        if (empty($image_path)) {
            return URLROOT . '/public/img/earth.jpg'; // fallback image
        }
        if (strpos($image_path, 'http://') === 0 || strpos($image_path, 'https://') === 0) {
            return $image_path;
        }
        return URLROOT . '/public/img/' . basename($image_path);
    }
}
?>

<style>
    /* Dynamic Table of Contents (TOC) Styles */
    .post-toc-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        font-family: 'Hind Siliguri', sans-serif !important;
        line-height: 1.4 !important;
    }

    .post-toc-box *:not(.fa):not(.fas):not(.far):not(.fab) {
        font-family: 'Hind Siliguri', sans-serif !important;
        line-height: 1.4 !important;
    }

    .toc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 10px;
    }

    .toc-header span {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1e293b;
    }

    .toc-header i {
        color: var(--primary) !important;
        background: rgba(0, 107, 67, 0.08);
        padding: 8px;
        border-radius: 6px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .toc-header i:hover {
        background: rgba(0, 107, 67, 0.15);
    }

    .toc-list {
        list-style: none !important;
        padding-left: 0 !important;
        display: flex;
        flex-direction: column;
        gap: 0 !important;
        margin: 0 !important;
    }

    .post-toc-box ol,
    .post-toc-box ul {
        list-style: none !important;
        padding-left: 0 !important;
        margin: 0 !important;
    }

    .post-toc-box li {
        margin: 0 0 8px 0 !important;
        list-style: none !important;
        padding-left: 0 !important;
    }

    .post-toc-box li:last-child {
        margin-bottom: 0 !important;
    }

    .toc-item {
        display: block;
    }

    .post-toc-box .toc-item a {
        text-decoration: none;
        color: #000000 !important;
        font-size: 1.05rem;
        font-weight: 600;
        display: inline-flex;
        align-items: flex-start;
        gap: 8px;
        transition: color 0.2s ease;
        line-height: 1.4 !important;
    }

    .post-toc-box .toc-item a:hover {
        color: var(--primary) !important;
    }

    .post-toc-box .toc-number {
        color: #000000 !important;
        font-weight: 700;
    }

    .toc-sub-list {
        display: none;
        padding-left: 20px !important;
        margin-top: 6px !important;
        border-left: 1.5px dashed #cbd5e1;
        margin-left: 8px !important;
    }
    .toc-sub-sub-list {
        display: none;
        padding-left: 20px !important;
        margin-top: 6px !important;
        border-left: 1.5px dashed #cbd5e1;
        margin-left: 8px !important;
    }
    .toc-item-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: 100%;
    }
    .toc-toggle-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 4px;
        cursor: pointer;
        color: #64748b;
        background: #f1f5f9;
        font-size: 8px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .toc-toggle-btn:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
    .toc-toggle-btn.expanded i {
        transform: rotate(90deg);
    }
    .toc-toggle-btn i {
        transition: transform 0.2s ease;
    }

    /* Styles for nested items */
    .post-toc-box .toc-h3 a {
        font-size: 0.96rem;
        font-weight: 500;
    }
    .post-toc-box .toc-h4 a {
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Heading Highlight on scroll click */
    .highlight-heading {
        animation: highlightAnimation 2s ease;
    }

    @keyframes highlightAnimation {
        0%, 100% { background: transparent; }
        30% { background: rgba(0, 107, 67, 0.1); border-radius: 4px; padding: 2px 5px; }
    }

    /* Footnote Highlight Styles */
    .post-footnotes-box li:target {
        animation: highlightFootnote 2s ease;
    }
    @keyframes highlightFootnote {
        0%, 100% { background: transparent; }
        30% { background: rgba(0, 107, 67, 0.1); border-radius: 4px; padding: 2px 5px; }
    }
    .footnote-ref-link:hover {
        background: rgba(0, 107, 67, 0.1);
        border-radius: 3px;
    }

    .post-body a,
    .post-footnotes-box a {
        color: var(--primary) !important;
        text-decoration: none !important;
        font-weight: 600;
        transition: 0.2s all ease;
    }
    .post-body a:hover,
    .post-footnotes-box a:hover {
        color: var(--primary-dark) !important;
        text-decoration: none !important;
    }

    .container-post {
        max-width: 1440px !important;
    }

    .post-container {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 25px;
        margin-top: 40px;
    }

    .post-main {
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    .post-header-card,
    .post-part-card,
    .post-share-card,
    .post-comments-card,
    .post-comment-form-card,
    .post-footnotes-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .post-header-card,
        .post-part-card,
        .post-share-card,
        .post-comments-card,
        .post-comment-form-card,
        .post-footnotes-box {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
    }

    .post-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .post-meta-left {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
    }
    .post-meta-share {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .post-meta-share .share-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        padding: 0;
        justify-content: center;
        font-size: 0.85rem;
    }


    .post-meta span i { color: var(--primary); margin-right: 5px; }

    .post-content-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 25px;
        color: var(--text-main);
        font-family: 'Noto Serif Bengali', serif !important;
    }

    .post-featured-img {
        display: block;
        width: 100%;
        max-width: 1280px;
        height: auto;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        margin: 0 auto 30px auto;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .post-body {
        font-size: 18px;
        line-height: 1.75;
        color: #000000;
        text-align: justify;
        text-justify: inter-word;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
    }

    .post-body, .post-body *:not(.fa):not(.fas):not(.far):not(.fab) {
        font-family: 'Noto Serif Bengali', serif !important;
    }

    .post-body h2 {
        position: relative;
        padding-bottom: 12px;
        margin-top: 45px;
        margin-bottom: 25px;
        color: #1e293b;
        font-size: 1.8rem;
        font-weight: 800;
    }
    .post-body h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background: #e2e8f0;
        border-radius: 2px;
    }
    .post-body h2::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 80px;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
        z-index: 1;
    }

    .post-body h3 {
        position: relative;
        padding-bottom: 10px;
        margin-top: 35px;
        margin-bottom: 20px;
        color: #334155;
        font-size: 1.45rem;
        font-weight: 700;
    }
    .post-body h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 120px;
        height: 2px;
        background: repeating-linear-gradient(to right, var(--primary), var(--primary) 6px, transparent 6px, transparent 12px);
    }

    .post-body h4 {
        position: relative;
        padding-left: 12px;
        margin-top: 30px;
        margin-bottom: 15px;
        color: #475569;
        font-size: 1.2rem;
        font-weight: 700;
        border-left: 3px solid #cbd5e1;
    }

    .post-body p { 
        margin-bottom: 20px; 
        text-align: justify;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .post-body blockquote {
        position: relative;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 6px solid #2563eb;
        border-radius: 14px;
        padding: 24px 30px 24px 44px;
        margin: 30px 0;
        font-style: normal;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .post-body blockquote::before {
        content: "\f10d";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 15px;
        top: 22px;
        font-size: 20px;
        color: rgba(37, 99, 235, 0.15);
        transition: color 0.3s ease;
    }

    .post-body blockquote:hover {
        border-left-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.08), 0 5px 15px rgba(0, 0, 0, 0.02);
    }

    .post-body blockquote:hover::before {
        color: rgba(37, 99, 235, 0.35);
    }

    .post-body blockquote p {
        margin-bottom: 12px;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .post-body blockquote p:last-child {
        margin-bottom: 0;
    }

    .post-body ul, 
    .post-body ol {
        margin-bottom: 20px;
        padding-left: 25px !important;
        list-style-position: outside !important;
    }

    .post-body li {
        margin-bottom: 8px;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .post-body img, 
    .post-body iframe, 
    .post-body video, 
    .post-body embed, 
    .post-body object {
        max-width: 100% !important;
        height: auto !important;
    }

    .post-body table {
        display: block;
        width: 100% !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 20px;
    }

    .post-body pre, 
    .post-body code {
        white-space: pre-wrap !important;
        word-break: break-all !important;
    }

    /* Share Buttons */
    .share-box {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .share-btn {
        padding: 8px 18px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-size: 0.95rem;
        font-weight: 700;
        transition: all 0.3s ease;
        text-decoration: none !important;
        font-family: 'Hind Siliguri', sans-serif !important;
        border: none;
        cursor: pointer;
    }

    .share-btn.fb { background: #1877f2; color: #ffffff !important; }
    .share-btn.wa { background: #25d366; color: #ffffff !important; }
    .share-btn.tg { background: #0088cc; color: #ffffff !important; }
    .share-btn.li { background: #0a66c2; color: #ffffff !important; }
    .share-btn.copy { background: #ffffff; border: 1px solid #cbd5e1; color: #334155 !important; }
    .share-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); opacity: 0.95; }
    .share-btn.copy:hover { border-color: #94a3b8; background: #f8fafc; }

    /* Sidebar Styles */
    .post-sidebar {
        position: sticky;
        top: 110px;
        align-self: start;
        height: fit-content;
    }

    /* Sidebar Widgets */
    .sidebar-widget {
        background: var(--white);
        padding: 25px;
        border-radius: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary);
        display: inline-block;
    }

    .related-post {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        text-decoration: none;
        color: var(--text-main);
        transition: color 0.2s ease;
    }
    .related-post:hover {
        color: var(--primary);
    }

    .related-post img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .related-title {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
    }

    /* Prayer Widget - reusing styles from index */
    .prayer-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Single Post Responsiveness */
    @media (max-width: 1024px) {
        .post-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .post-main {
            padding: 25px;
        }
        .post-content-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        body {
            background: #ffffff !important;
        }
        .container {
            padding: 0 15px !important;
        }
        .post-main {
            padding: 15px 0;
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        .post-content-title {
            font-size: 1.6rem;
            margin-bottom: 15px;
        }
        .post-body {
            font-size: 18px !important;
            line-height: 1.9 !important;
        }
        .post-meta {
            flex-wrap: wrap;
            gap: 10px;
            font-size: 0.8rem;
        }
        /* Comment form inputs stack on mobile */
        .post-main form div {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }
        /* Make bottom share buttons round icons on mobile */
        .share-box {
            justify-content: flex-start !important;
            gap: 10px !important;
        }
        .share-box .share-btn-text {
            display: none !important;
        }
        .share-box .share-btn {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            padding: 0 !important;
            justify-content: center !important;
            align-items: center !important;
            font-size: 1.1rem !important;
            gap: 0 !important;
            display: inline-flex !important;
        }
    }

    .footnote-tooltip a {
        text-decoration: none !important;
        color: inherit !important;
    }

    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        .top-menu-bar,
        .header-wrapper,
        .post-sidebar,
        .share-box,
        footer,
        .post-main form,
        .post-main div[style*="margin-top: 50px"],
        .post-main div[style*="margin-top: 60px"] {
            display: none !important;
        }
        .post-container {
            display: block !important;
            margin-top: 0 !important;
        }
        .post-main {
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
        }
        .post-content-title {
            font-size: 2.2rem !important;
            margin-top: 0 !important;
        }
    }
</style>

<div class="container container-post">
    <div class="post-container">
        <!-- Main Post Content -->
        <main class="post-main">
            <div class="post-header-card">
                <?php if (!empty($data['post']['featured_image'])): ?>
                <img src="<?=resolve_blog_image($data['post']['featured_image'])?>" loading="lazy" decoding="async" class="post-featured-img" alt="<?= $data['post']['title'] ?>">
                <?php endif; ?>

                <h1 class="post-content-title"><?= $data['post']['title'] ?></h1>

                <div class="post-meta" style="margin-bottom: 0;">
                    <div class="post-meta-left">
                        <span><i class="fas fa-user"></i> 
                            <?php
                            $auths = [];
                            foreach ($data['post_authors'] as $auth) {
                                $auths[] = htmlspecialchars($auth['name']);
                            }
                            echo implode(', ', $auths);
                            ?>
                        </span>
                        <span><i class="fas fa-calendar-alt"></i> <?= date('d M, Y', strtotime($data['post']['created_at'])) ?></span>

                        <span><i class="fas fa-eye"></i> <?= number_format($data['post']['views']) ?> বার পঠিত</span>
                    </div>
                    <div class="post-meta-share">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif;"><i class="fas fa-share-alt"></i> শেয়ার:</span>
                        <button onclick="copyPostLink('<?= URLROOT ?>/p/<?= $data['post']['id'] ?>', this);" class="share-btn copy" title="লিংক কপি করুন">
                            <i class="fas fa-link"></i>
                        </button>
                        <a href="https://api.whatsapp.com/send?text=<?= $data['post']['title'] ?>%20<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn wa" title="হোয়াটসঅ্যাপে শেয়ার">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn fb" title="ফেসবুকে শেয়ার">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://t.me/share/url?url=<?= URLROOT ?>/<?= $data['post']['slug'] ?>&text=<?= $data['post']['title'] ?>" target="_blank" class="share-btn tg" title="টেলিগ্রামে শেয়ার">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn li" title="লিংকডইনে শেয়ার">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <button onclick="window.print();" class="share-btn print" style="background: #64748b; color: #ffffff !important;" title="প্রিন্ট করুন">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="post-body">
                <?= $data['post']['content'] ?>
            </div>

            <div class="post-share-card">
                <div class="share-box" style="margin-top: 0; border: none; padding: 0; background: transparent; box-shadow: none;">
                    <span style="font-weight: 700; color: #475569; display: flex; align-items: center; gap: 6px; font-family: 'Hind Siliguri', sans-serif;">
                        <i class="fas fa-share-alt"></i> শেয়ার করুন:
                    </span>
                    <button onclick="copyPostLink('<?= URLROOT ?>/p/<?= $data['post']['id'] ?>', this);" class="share-btn copy" title="লিংক কপি করুন">
                        <i class="fas fa-link"></i> <span class="share-btn-text">লিংক কপি</span>
                    </button>
                    <a href="https://api.whatsapp.com/send?text=<?= $data['post']['title'] ?>%20<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn wa" title="হোয়াটসঅ্যাপে শেয়ার">
                        <i class="fab fa-whatsapp"></i> <span class="share-btn-text">WhatsApp</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn fb" title="ফেসবুকে শেয়ার">
                        <i class="fab fa-facebook-f"></i> <span class="share-btn-text">Facebook</span>
                    </a>
                    <a href="https://t.me/share/url?url=<?= URLROOT ?>/<?= $data['post']['slug'] ?>&text=<?= $data['post']['title'] ?>" target="_blank" class="share-btn tg" title="টেলিগ্রামে শেয়ার">
                        <i class="fab fa-telegram-plane"></i> <span class="share-btn-text">Telegram</span>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= URLROOT ?>/<?= $data['post']['slug'] ?>" target="_blank" class="share-btn li" title="লিংকডইনে শেয়ার">
                        <i class="fab fa-linkedin-in"></i> <span class="share-btn-text">LinkedIn</span>
                    </a>
                </div>
            </div>

            <!-- Comments List -->
            <?php if (!empty($data['comments'])): ?>
            <div class="post-comments-card">
                <h3 style="font-weight: 800; margin-bottom: 25px;">Comments (<?= count($data['comments']) ?>)</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php foreach ($data['comments'] as $comment): ?>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <strong style="color: var(--text-main); font-size: 1.05rem;"><?= htmlspecialchars($comment['name']) ?></strong>
                                <span style="font-size: 0.8rem; color: var(--text-muted);"><?= date('M d, Y h:i A', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <p style="margin: 0; color: #475569; line-height: 1.6;"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Comment Section Placeholder -->
            <div class="post-comment-form-card">
                <h3 style="font-weight: 800; margin-bottom: 25px;">Leave a Comment</h3>
                
                <?php if (isset($_SESSION['comment_success'])): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                        <?= $_SESSION['comment_success']; unset($_SESSION['comment_success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['comment_error'])): ?>
                    <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                        <?= $_SESSION['comment_error']; unset($_SESSION['comment_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= URLROOT ?>/comment/<?= $data['post']['id'] ?>" method="POST" style="display: grid; gap: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <input type="text" name="name" placeholder="Your Name *" style="padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" required>
                        <input type="email" name="email" placeholder="Your Email (Optional)" style="padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
                    </div>
                    <textarea name="comment" rows="5" placeholder="Write your comment here..." style="padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;" required></textarea>
                    <button type="submit" class="btn-subscribe" style="border: none; cursor: pointer; width: fit-content; padding: 15px 40px;">Post Comment</button>
                </form>
            </div>


        </main>

        <!-- Sidebar -->
        <aside class="post-sidebar">
            <!-- Recent Questions Widget -->
            <div class="sidebar-widget">
                <a href="<?= URLROOT ?>/q&amp;a" style="text-decoration: none; display: flex; align-items: center; justify-content: space-between; background: var(--primary); color: #ffffff; padding: 10px 15px; border-radius: 12px; font-weight: 800; font-size: 1rem; margin-bottom: 20px; transition: 0.3s; border: 1.5px solid var(--primary); font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='transparent'; this.style.color='var(--primary)';" onmouseout="this.style.background='var(--primary)'; this.style.color='#ffffff';">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span style="background: #ffffff; color: var(--primary); width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; line-height: 1; flex-shrink: 0;">?</span>প্রশ্নসমূহ
                    </span>
                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                </a>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php foreach ($data['recent_questions'] as $q): ?>
                    <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="related-post" style="align-items: flex-start; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 0;">
                        <div style="width: 32px; height: 32px; background: var(--primary); color: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; margin-top: 2px;">
                            ?
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.95rem; font-weight: 700; line-height: 1.4;"><?= htmlspecialchars(mb_strimwidth($q['question'], 0, 75, '...')) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">
                                <i class="far fa-clock"></i> <?= date('d M, Y', strtotime($q['created_at'])) ?>
                                <?php if (!empty($q['category_name'])): ?>
                                    <span style="margin-left: 8px; font-weight: 700; color: var(--primary);"><i class="far fa-folder"></i> <?= htmlspecialchars($q['category_name']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Related Posts Widget -->
            <div class="sidebar-widget">
                <h4 class="widget-title">সম্পর্কিত লেখাসমূহ</h4>
                <?php foreach ($data['related_posts'] as $related): ?>
                <a href="<?= URLROOT ?>/<?= $related['slug'] ?>" class="related-post">
                    <div class="related-img-container" style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                        <?php if (!empty($related['featured_image'])): 
                            $related_img = resolve_blog_image($related['featured_image']);
                        ?>
                            <img src="<?=$related_img?>" loading="lazy" decoding="async" alt="<?= $related['title'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="fa-regular fa-image" style="font-size: 1.2rem; opacity: 0.5;"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="related-title"><?= $related['title'] ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;"><?= date('M d, Y', strtotime($related['created_at'])) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Recent Posts Widget -->
            <div class="sidebar-widget">
                <h4 class="widget-title">সাম্প্রতিক লেখাসমূহ</h4>
                <?php foreach ($data['recent_posts'] as $recent): ?>
                <a href="<?= URLROOT ?>/<?= $recent['slug'] ?>" class="related-post">
                    <div class="related-img-container" style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                        <?php if (!empty($recent['featured_image'])): 
                            $recent_img = resolve_blog_image($recent['featured_image']);
                        ?>
                            <img src="<?=$recent_img?>" loading="lazy" decoding="async" alt="<?= $recent['title'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="fa-regular fa-image" style="font-size: 1.2rem; opacity: 0.5;"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="related-title"><?= $recent['title'] ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;"><?= date('M d, Y', strtotime($recent['created_at'])) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Sidebar Image Slider (1:1 Size) -->
            <?php if (!empty($data['sidebar_slides'])): ?>
            <div class="sidebar-widget">
                <h4 class="widget-title">আমাদের বইসমূহ</h4>
                <div class="sidebar-carousel-container" style="position: relative; overflow: hidden; width: 100%; border-radius: 12px; aspect-ratio: 1/1;">
                    <div class="sidebar-carousel-slides" style="display: flex; transition: transform 0.5s ease-in-out; height: 100%;">
                        <?php foreach ($data['sidebar_slides'] as $index => $side_slide): ?>
                            <div class="sidebar-carousel-slide" style="min-width: 100%; height: 100%; position: relative;">
                                <?php if (!empty($side_slide['link'])): ?>
                                    <a href="<?= htmlspecialchars($side_slide['link']) ?>" target="_blank" style="display: block; width: 100%; height: 100%;">
                                <?php endif; ?>
                                <img src="<?=htmlspecialchars($side_slide['image'])?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; display: block;" alt="Sidebar Image">
                                <?php if (!empty($side_slide['link'])): ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Carousel Controls -->
                    <?php if (count($data['sidebar_slides']) > 1): ?>
                        <button class="sidebar-carousel-prev" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 5;"><i class="fas fa-chevron-left" style="font-size: 0.8rem;"></i></button>
                        <button class="sidebar-carousel-next" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 5;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></button>
                        
                        <div class="sidebar-carousel-dots" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 5;">
                            <?php foreach ($data['sidebar_slides'] as $index => $side_slide): ?>
                                <span class="sidebar-carousel-dot" data-index="<?= $index ?>" style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: 0.3s; <?= $index === 0 ? 'background: #ffffff; transform: scale(1.2);' : '' ?>"></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Popular Posts Widget -->
            <div class="sidebar-widget">
                <h4 class="widget-title">জনপ্রিয় লেখাসমূহ</h4>
                <?php foreach ($data['popular_posts'] as $popular): ?>
                <a href="<?= URLROOT ?>/<?= $popular['slug'] ?>" class="related-post">
                    <div class="related-img-container" style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                        <?php if (!empty($popular['featured_image'])): 
                            $popular_img = resolve_blog_image($popular['featured_image']);
                        ?>
                            <img src="<?=$popular_img?>" loading="lazy" decoding="async" alt="<?= $popular['title'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="fa-regular fa-image" style="font-size: 1.2rem; opacity: 0.5;"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="related-title"><?= $popular['title'] ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;"><?= date('M d, Y', strtotime($popular['created_at'])) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const postBody = document.querySelector('.post-body');
    // Remove any existing static footnotes box (e.g. saved in the database content)
    const existingBox = postBody.querySelector('.post-footnotes-box');
    if (existingBox) {
        existingBox.remove();
    }

    // 1. Footnotes / References Parsing
    let html = postBody.innerHTML;
    // Decode HTML entities for parentheses that WYSIWYG editors might generate
    html = html.replace(/&#40;/g, '(').replace(/&#41;/g, ')').replace(/&lpar;/g, '(').replace(/&rpar;/g, ')');
    // Clean up any HTML tags that are split between the double opening/closing parentheses (e.g. (<span>( to (())
    html = html.replace(/\((?:<[^>]*>)+\(/g, '((').replace(/\)(?:<[^>]*>)+\)/g, '))');
    const regex = /\(\((.*?)\)\)/g;
    const footnotes = [];
    let count = 1;
    
    html = html.replace(regex, function(fullMatch, refText) {
        footnotes.push(refText);
        const refId = `footnote-ref-${count}`;
        const noteId = `footnote-note-${count}`;
        const currentCount = count;
        count++;
        // Escape double quotes and single quotes for safe inclusion inside the HTML attribute
        const escapedText = refText.replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        return ` ${refText} <sup class="footnote-ref-sup" style="scroll-margin-top: 45vh; display: inline-block;"><a href="#${noteId}" id="${refId}" class="footnote-ref-link" data-footnote="${escapedText}" style="text-decoration: none; font-weight: 700; color: var(--primary); padding: 0 2px;">[${currentCount}]</a></sup>`;
    });
    
    postBody.innerHTML = html;

    function wrapPartsIntoCards(containerEl) {
        const children = Array.from(containerEl.childNodes);
        containerEl.innerHTML = '';
        
        let currentCard = null;
        
        children.forEach(child => {
            if (child.nodeType === 1 && child.tagName.toLowerCase() === 'h2') {
                currentCard = document.createElement('div');
                currentCard.className = 'post-part-card';
                containerEl.appendChild(currentCard);
            }
            
            if (!currentCard) {
                if (child.nodeType === 3 && child.textContent.trim() === '') {
                    return;
                }
                currentCard = document.createElement('div');
                currentCard.className = 'post-part-card';
                containerEl.appendChild(currentCard);
            }
            
            currentCard.appendChild(child);
        });
    }

    wrapPartsIntoCards(postBody);

    // 2. TOC Generation (only for headings inside the article body, before adding the footnotes box)
    const headings = postBody.querySelectorAll('h2, h3, h4');
    if (headings.length >= 1) {
        const tocContainer = document.createElement('div');
        tocContainer.className = 'post-toc-box';
        
        const tocHeader = document.createElement('div');
        tocHeader.className = 'toc-header';
        tocHeader.innerHTML = '<span>সূচিপত্র</span><i class="fas fa-list-ol"></i>';
        tocContainer.appendChild(tocHeader);

        const tocList = document.createElement('ol');
        tocList.className = 'toc-list';
        
        // Toggle TOC visibility on icon click
        const toggleIcon = tocHeader.querySelector('i');
        toggleIcon.addEventListener('click', function() {
            if (tocList.style.display === 'none') {
                tocList.style.display = 'flex';
                toggleIcon.style.transform = 'none';
                tocHeader.style.borderBottom = '1px solid #e2e8f0';
                tocHeader.style.marginBottom = '15px';
                tocHeader.style.paddingBottom = '10px';
            } else {
                tocList.style.display = 'none';
                toggleIcon.style.transform = 'rotate(180deg)';
                tocHeader.style.borderBottom = 'none';
                tocHeader.style.marginBottom = '0';
                tocHeader.style.paddingBottom = '0';
            }
        });
        
        const toBangla = (num) => {
            const banglaDigits = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
            return num.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
        };

        let h2Count = 0;
        let h3Count = 0;
        let h4Count = 0;

        let currentH2Li = null;
        let currentH2Ul = null;
        let currentH3Li = null;
        let currentH3Ul = null;

        function addToggleBtn(parentWrapper, subListEl) {
            const toggle = document.createElement('span');
            toggle.className = 'toc-toggle-btn';
            toggle.innerHTML = '<i class="fas fa-chevron-right"></i>';
            
            const firstLink = parentWrapper.querySelector('a');
            if (firstLink) {
                parentWrapper.insertBefore(toggle, firstLink);
            } else {
                parentWrapper.appendChild(toggle);
            }

            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                if (subListEl.style.display === 'none' || subListEl.style.display === '') {
                    subListEl.style.display = 'block';
                    toggle.classList.add('expanded');
                } else {
                    subListEl.style.display = 'none';
                    toggle.classList.remove('expanded');
                }
            });
        }

        headings.forEach((heading, index) => {
            const id = 'heading-sec-' + index;
            heading.id = id;
            heading.style.scrollMarginTop = '120px'; // To prevent header overlap

            const level = heading.tagName.toLowerCase();
            let numberPrefix = '';

            if (level === 'h2') {
                h2Count++;
                h3Count = 0;
                h4Count = 0;
                numberPrefix = toBangla(h2Count) + '. ';
            } else if (level === 'h3') {
                h3Count++;
                h4Count = 0;
                numberPrefix = toBangla(h2Count) + '.' + toBangla(h3Count) + '. ';
            } else if (level === 'h4') {
                h4Count++;
                numberPrefix = toBangla(h2Count) + '.' + toBangla(h3Count) + '.' + toBangla(h4Count) + '. ';
            }

            const listItem = document.createElement('li');
            listItem.className = 'toc-item toc-' + level;
            
            const itemWrapper = document.createElement('div');
            itemWrapper.className = 'toc-item-wrapper';
            listItem.appendChild(itemWrapper);

            const link = document.createElement('a');
            link.href = '#' + id;
            link.innerHTML = '<span class="toc-number">' + numberPrefix + '</span>' + heading.textContent;
            itemWrapper.appendChild(link);
            
            // Prepend the prefix to the actual heading on the page if not already present
            if (!heading.innerHTML.includes('toc-heading-prefix')) {
                heading.innerHTML = '<span class="toc-heading-prefix">' + numberPrefix + '</span>' + heading.innerHTML;
            }

            link.addEventListener('click', function(e) {
                e.preventDefault();
                heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
                heading.classList.add('highlight-heading');
                setTimeout(() => heading.classList.remove('highlight-heading'), 2000);
            });

            if (level === 'h2') {
                tocList.appendChild(listItem);
                currentH2Li = listItem;
                currentH2Ul = null;
                currentH3Li = null;
                currentH3Ul = null;
            } else if (level === 'h3') {
                if (currentH2Li) {
                    if (!currentH2Ul) {
                        currentH2Ul = document.createElement('ol');
                        currentH2Ul.className = 'toc-sub-list';
                        currentH2Li.appendChild(currentH2Ul);
                        
                        // Add toggle to the wrapper of H2
                        const h2Wrapper = currentH2Li.querySelector('.toc-item-wrapper');
                        if (h2Wrapper) addToggleBtn(h2Wrapper, currentH2Ul);
                    }
                    currentH2Ul.appendChild(listItem);
                    currentH3Li = listItem;
                    currentH3Ul = null;
                } else {
                    tocList.appendChild(listItem);
                }
            } else if (level === 'h4') {
                if (currentH3Li) {
                    if (!currentH3Ul) {
                        currentH3Ul = document.createElement('ol');
                        currentH3Ul.className = 'toc-sub-sub-list';
                        currentH3Li.appendChild(currentH3Ul);
                        
                        // Add toggle to the wrapper of H3
                        const h3Wrapper = currentH3Li.querySelector('.toc-item-wrapper');
                        if (h3Wrapper) addToggleBtn(h3Wrapper, currentH3Ul);
                    }
                    currentH3Ul.appendChild(listItem);
                } else if (currentH2Ul) {
                    currentH2Ul.appendChild(listItem);
                } else {
                    tocList.appendChild(listItem);
                }
            }
        });

        tocContainer.appendChild(tocList);
        
        postBody.insertBefore(tocContainer, postBody.firstChild);
    }

    // 3. Append Footnotes box at the very end
    if (footnotes.length > 0) {
        const footnotesBox = document.createElement('div');
        footnotesBox.className = 'post-footnotes-box';
        footnotesBox.style.cssText = 'margin-top: 50px; padding-top: 30px; border-top: 2px solid #e2e8f0; font-family: "Hind Siliguri", sans-serif;';
        
        let title = document.createElement('h3');
        title.style.cssText = 'font-weight: 800; margin-bottom: 20px; color: #1e293b; font-size: 1.3rem;';
        title.innerText = 'তথ্যসূত্র ও টীকা (References)';
        footnotesBox.appendChild(title);
        
        let ol = document.createElement('ol');
        ol.style.cssText = 'padding-left: 20px; color: #475569; line-height: 1.8;';
        
        footnotes.forEach((refText, index) => {
            const countNum = index + 1;
            const refId = `footnote-ref-${countNum}`;
            const noteId = `footnote-note-${countNum}`;
            
            let li = document.createElement('li');
            li.id = noteId;
            li.style.cssText = 'margin-bottom: 10px; scroll-margin-top: 120px;'; // prevent header overlap
            li.innerHTML = `${refText} <a href="#${refId}" class="footnote-back-link" style="text-decoration: none; color: var(--primary); font-weight: bold; margin-left: 5px;">&#8617;</a>`;
            ol.appendChild(li);
        });
        
        footnotesBox.appendChild(ol);
        postBody.appendChild(footnotesBox);
    }

    // 4. Footnotes custom smooth scrolling to prevent header overlap
    document.addEventListener('click', function(e) {
        const backLink = e.target.closest('.footnote-back-link');
        if (backLink) {
            e.preventDefault();
            const targetId = backLink.getAttribute('href');
            const targetEl = document.querySelector(targetId);
            if (targetEl) {
                const headerOffset = 250; // scrolls the element 250px below the viewport top (clear of sticky header)
                const elementPosition = targetEl.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                targetEl.classList.add('highlight-heading');
                setTimeout(() => targetEl.classList.remove('highlight-heading'), 2000);
            }
        }

        const refLink = e.target.closest('.footnote-ref-link');
        if (refLink) {
            e.preventDefault();
            const targetId = refLink.getAttribute('href');
            const targetEl = document.querySelector(targetId);
            if (targetEl) {
                const headerOffset = 180;
                const elementPosition = targetEl.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Trigger browser :target styles or manual highlight class
                targetEl.classList.add('highlight-heading');
                setTimeout(() => targetEl.classList.remove('highlight-heading'), 2000);
            }
        }
    });

    // 5. Sidebar Carousel Slider
    const carouselSlides = document.querySelector('.sidebar-carousel-slides');
    if (carouselSlides) {
        const slides = document.querySelectorAll('.sidebar-carousel-slide');
        const dots = document.querySelectorAll('.sidebar-carousel-dot');
        const prevBtn = document.querySelector('.sidebar-carousel-prev');
        const nextBtn = document.querySelector('.sidebar-carousel-next');
        let currentIndex = 0;
        const totalSlides = slides.length;
        let slideInterval;

        function updateSlider() {
            carouselSlides.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.style.background = '#ffffff';
                    dot.style.transform = 'scale(1.2)';
                } else {
                    dot.style.background = 'rgba(255,255,255,0.5)';
                    dot.style.transform = 'scale(1)';
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoplay();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoplay();
            });
        }

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                currentIndex = parseInt(e.target.getAttribute('data-index'));
                updateSlider();
                resetAutoplay();
            });
        });

        function startAutoplay() {
            slideInterval = setInterval(nextSlide, 4000);
        }

        function resetAutoplay() {
            clearInterval(slideInterval);
            startAutoplay();
        }

        startAutoplay();
    }

    // 6. Footnote Tooltip on Hover
    let activeTooltip = null;

    document.addEventListener('mouseover', function(e) {
        const link = e.target.closest('.footnote-ref-link');
        if (!link) return;

        const text = link.getAttribute('data-footnote');
        if (!text) return;

        if (activeTooltip) activeTooltip.remove();

        const tooltip = document.createElement('div');
        tooltip.className = 'footnote-tooltip';
        tooltip.style.cssText = `
            position: absolute;
            background: #ffffff;
            color: #2563eb;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.88rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 10000;
            pointer-events: none;
            max-width: 320px;
            word-wrap: break-word;
            font-weight: 500;
            line-height: 1.4;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0;
            transform: translateY(5px);
            transition: opacity 0.2s, transform 0.2s;
        `;
        
        tooltip.innerHTML = `<span>${text}</span> <i class="fas fa-external-link-alt" style="font-size: 0.75rem; color: #94a3b8; flex-shrink: 0;"></i>`;
        document.body.appendChild(tooltip);
        
        const rect = link.getBoundingClientRect();
        let left = rect.left + window.scrollX + rect.width / 2 - tooltip.offsetWidth / 2;
        let top = rect.top + window.scrollY - tooltip.offsetHeight - 8;
        
        if (left < 10) left = 10;
        if (left + tooltip.offsetWidth > window.innerWidth - 10) {
            left = window.innerWidth - tooltip.offsetWidth - 10;
        }
        
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
        
        requestAnimationFrame(() => {
            tooltip.style.opacity = '1';
            tooltip.style.transform = 'translateY(0)';
        });
        
        activeTooltip = tooltip;
    });

    document.addEventListener('mouseout', function(e) {
        const link = e.target.closest('.footnote-ref-link');
        if (!link) return;
        
        if (activeTooltip) {
            const tooltipToRm = activeTooltip;
            tooltipToRm.style.opacity = '0';
            tooltipToRm.style.transform = 'translateY(5px)';
            setTimeout(() => tooltipToRm.remove(), 200);
            activeTooltip = null;
        }
    });
    // Parsing double-bracket references and moving them to footnotes
    const postBodyEl = document.querySelector('.post-body');
    if (postBodyEl) {
        let contentHtml = postBodyEl.innerHTML;
        // Regex to match (( text )) or (( text | link ))
        const regex = /\(\(\s*([^)]+?)\s*\)\)/g;
        let match;
        const footnotes = [];
        let index = 1;
        
        while ((match = regex.exec(contentHtml)) !== null) {
            const rawRef = match[1];
            let displayText = rawRef;
            let linkText = '';
            
            if (rawRef.includes('|')) {
                const parts = rawRef.split('|');
                displayText = parts[0].trim();
                linkText = parts[1].trim();
            }
            
            footnotes.push({
                index: index,
                displayText: displayText,
                linkText: linkText
            });
            
            // Replace in HTML content with superscript anchor link
            const replacement = `<sup><a href="#ref-note-${index}" id="ref-link-${index}" class="footnote-ref-link" style="color: #2563eb; font-weight: 700; text-decoration: none; padding: 0 2px;">[${index}]</a></sup>`;
            contentHtml = contentHtml.replace(match[0], replacement);
            // Reset regex index to account for replaced string length difference
            regex.lastIndex -= match[0].length - replacement.length;
            index++;
        }
        
        if (footnotes.length > 0) {
            postBodyEl.innerHTML = contentHtml;
            
            // Build the footnote box container
            const footnoteContainer = document.createElement('div');
            footnoteContainer.className = 'post-footnotes-box';
            footnoteContainer.style.marginTop = '40px';
            footnoteContainer.style.padding = '24px';
            footnoteContainer.style.background = '#f8fafc';
            footnoteContainer.style.border = '1px solid #e2e8f0';
            footnoteContainer.style.borderRadius = '16px';
            footnoteContainer.style.fontFamily = "'Hind Siliguri', sans-serif";
            
            let footnoteHtml = `<h4 style="margin: 0 0 16px 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; border-bottom: 2px solid #cbd5e1; padding-bottom: 8px;"><i class="fas fa-bookmark" style="color: #2563eb; margin-right: 8px;"></i>তথ্যসূত্র ও নোট (References)</h4>`;
            footnoteHtml += `<ol style="margin: 0; padding-left: 20px; font-size: 0.95rem; line-height: 1.8; color: #475569;">`;
            
            footnotes.forEach(fn => {
                let text = fn.displayText;
                // If there's a link, let's wrap it in an anchor tag
                if (fn.linkText) {
                    text = `<a href="${fn.linkText}" target="_blank" style="color: #2563eb; text-decoration: underline;">${fn.displayText}</a>`;
                }
                footnoteHtml += `<li id="ref-note-${fn.index}" style="margin-bottom: 8px; padding-left: 4px;">
                    ${text} 
                    <a href="#ref-link-${fn.index}" style="color: #2563eb; text-decoration: none; margin-left: 6px; font-weight: bold;" title="Back to text">↵</a>
                </li>`;
            });
            
            footnoteHtml += `</ol>`;
            footnoteContainer.innerHTML = footnoteHtml;
            
            // Append at the end of post body
            postBodyEl.appendChild(footnoteContainer);
        }
    }
});
function copyPostLink(url, btn) {
    navigator.clipboard.writeText(url).then(function() {
        const originalHtml = btn.innerHTML;
        const isMetaShare = btn.closest('.post-meta-share') !== null;
        if (isMetaShare) {
            btn.innerHTML = '<i class="fas fa-check" style="color: #25d366;"></i>';
        } else {
            btn.innerHTML = '<i class="fas fa-check" style="color: #25d366;"></i> কপি হয়েছে!';
        }
        setTimeout(function() {
            btn.innerHTML = originalHtml;
        }, 2000);
    }).catch(function(err) {
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        const originalHtml = btn.innerHTML;
        const isMetaShare = btn.closest('.post-meta-share') !== null;
        if (isMetaShare) {
            btn.innerHTML = '<i class="fas fa-check" style="color: #25d366;"></i>';
        } else {
            btn.innerHTML = '<i class="fas fa-check" style="color: #25d366;"></i> কপি হয়েছে!';
        }
        setTimeout(function() {
            btn.innerHTML = originalHtml;
        }, 2000);
    });
}</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
