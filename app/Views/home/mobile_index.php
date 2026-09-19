<?php require APPROOT . '/Views/inc/header.php'; ?>

<style>
/* =========================================
   MOBILE HOME PAGE — DEDICATED MOBILE DESIGN
   ========================================= */
* { box-sizing: border-box; }

body {
    background: #f1f5f9;
    overflow-x: hidden;
}

/* --- Hero Slider --- */
.m-slider-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #0f172a;
}
.m-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.8s ease;
}
.m-slide.active { opacity: 1; z-index: 1; }
.m-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.m-slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, transparent 60%);
    z-index: 2;
}
.m-slide-dots {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 10;
}
.m-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.45);
    transition: all 0.3s;
    cursor: pointer;
}
.m-dot.active {
    background: #ffffff;
    width: 18px;
    border-radius: 3px;
}

/* --- Breaking Ticker --- */
.m-ticker {
    display: flex;
    align-items: center;
    background: #1e293b;
    overflow: hidden;
    height: 36px;
}
.m-ticker-label {
    background: #2563eb;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 0 12px;
    height: 100%;
    display: flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
    letter-spacing: 0.05em;
    font-family: 'Hind Siliguri', sans-serif;
}
.m-ticker-track {
    display: flex;
    gap: 0;
    animation: tickerScroll 25s linear infinite;
    white-space: nowrap;
}
.m-ticker-item {
    color: #e2e8f0;
    font-size: 0.78rem;
    font-family: 'Hind Siliguri', sans-serif;
    padding: 0 24px;
    border-right: 1px solid rgba(255,255,255,0.1);
    line-height: 36px;
}
@keyframes tickerScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* --- Quick Action Buttons --- */
.m-quick-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    padding: 14px 14px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
}
.m-qa-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    color: #1e293b;
    font-size: 0.72rem;
    font-family: 'Hind Siliguri', sans-serif;
    font-weight: 700;
}
.m-qa-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: transform 0.2s;
}
.m-qa-btn:active .m-qa-icon {
    transform: scale(0.9);
}

/* --- Section Card Container --- */
.m-section {
    margin: 12px 12px 0;
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.m-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.m-section-title {
    font-size: 1rem;
    font-weight: 900;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
}
.m-section-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 18px;
    background: #0b7c4d;
    border-radius: 3px;
    flex-shrink: 0;
}
.m-see-all {
    font-size: 0.78rem;
    color: #0b7c4d;
    font-weight: 700;
    text-decoration: none;
    font-family: 'Hind Siliguri', sans-serif;
    display: flex;
    align-items: center;
    gap: 4px;
    background: #e6f4ea;
    padding: 5px 10px;
    border-radius: 20px;
}

/* --- Post Cards (2 column grid) --- */
.m-posts-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    padding: 12px;
}
.m-post-card {
    display: flex;
    flex-direction: column;
    background: #f8fafc;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    color: inherit;
    transition: transform 0.2s, box-shadow 0.2s;
}
.m-post-card:active {
    transform: scale(0.97);
}
.m-post-thumb {
    width: 100%;
    aspect-ratio: 16/10;
    object-fit: cover;
    display: block;
    background: #e2e8f0;
}
.m-post-thumb-placeholder {
    width: 100%;
    aspect-ratio: 16/10;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #93c5fd;
    font-size: 1.8rem;
}
.m-post-body {
    padding: 10px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}
.m-post-meta {
    font-size: 0.65rem;
    color: #94a3b8;
    font-family: 'Hind Siliguri', sans-serif;
    margin-bottom: 5px;
    display: flex;
    gap: 6px;
    align-items: center;
}
.m-post-title {
    font-size: 0.82rem;
    font-weight: 800;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
    flex-grow: 1;
}

/* --- Featured (wide) post card --- */
.m-post-card-wide {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0;
    background: #f8fafc;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    color: inherit;
    margin: 0 12px 10px;
    transition: transform 0.2s;
}
.m-post-card-wide:active { transform: scale(0.98); }
.m-post-wide-thumb {
    width: 110px;
    min-width: 110px;
    height: 88px;
    object-fit: cover;
}
.m-post-wide-thumb-placeholder {
    width: 110px;
    min-width: 110px;
    height: 88px;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #93c5fd;
    font-size: 1.5rem;
}
.m-post-wide-body {
    padding: 10px 12px;
    flex-grow: 1;
}
.m-post-wide-title {
    font-size: 0.88rem;
    font-weight: 800;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0 0 6px;
}
.m-post-wide-meta {
    font-size: 0.65rem;
    color: #94a3b8;
    font-family: 'Hind Siliguri', sans-serif;
    display: flex;
    gap: 6px;
    align-items: center;
}
.m-post-wide-views {
    background: #eff6ff;
    color: #2563eb;
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 0.62rem;
    font-weight: 700;
    font-family: 'Hind Siliguri', sans-serif;
}

/* --- Q&A List --- */
.m-qa-list { padding: 0 12px 12px; }
.m-qa-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none;
    color: inherit;
}
.m-qa-item:last-child { border-bottom: none; }
.m-qa-num {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    font-weight: 900;
    font-size: 0.78rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Outfit', sans-serif;
}
.m-qa-q {
    font-size: 0.85rem;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    font-weight: 600;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
}
.m-qa-arrow {
    color: #94a3b8;
    font-size: 0.8rem;
    flex-shrink: 0;
}

/* --- Scope cards (horizontal scroll) --- */
.m-scopes-scroll {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 12px;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
}
.m-scopes-scroll::-webkit-scrollbar { display: none; }
.m-scope-card {
    flex: 0 0 150px;
    scroll-snap-align: start;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-radius: 16px;
    padding: 18px 14px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
    border: 1px solid #bfdbfe;
    min-height: 130px;
}
.m-scope-icon {
    width: 40px;
    height: 40px;
    background: #2563eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
}
.m-scope-name {
    font-size: 0.82rem;
    font-weight: 800;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.3;
}

/* --- Ask Question Banner --- */
.m-ask-banner {
    margin: 12px 12px 0;
    background: linear-gradient(135deg, #0f172a, #1e3a5f);
    border-radius: 18px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    overflow: hidden;
    position: relative;
}
.m-ask-banner::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 120px;
    height: 120px;
    background: rgba(37,99,235,0.25);
    border-radius: 50%;
    filter: blur(30px);
}
.m-ask-text {
    font-size: 1rem;
    font-weight: 900;
    color: #ffffff;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.4;
}
.m-ask-text span {
    color: #60a5fa;
    display: block;
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 2px;
}
.m-ask-btn {
    background: #2563eb;
    color: #ffffff;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 800;
    font-family: 'Hind Siliguri', sans-serif;
    padding: 10px 18px;
    border-radius: 12px;
    white-space: nowrap;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(37,99,235,0.4);
    position: relative;
    z-index: 2;
}

/* --- YouTube videos (horizontal scroll) --- */
.m-yt-scroll {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 12px;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
}
.m-yt-scroll::-webkit-scrollbar { display: none; }
.m-yt-card {
    flex: 0 0 210px;
    scroll-snap-align: start;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 16/10;
    background: #000;
    display: block;
    text-decoration: none;
}
.m-yt-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.85;
    display: block;
}
.m-yt-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 55%);
    display: flex;
    align-items: flex-end;
    padding: 10px;
    z-index: 2;
}
.m-yt-play {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 36px;
    height: 36px;
    background: rgba(255,0,0,0.85);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.85rem;
    z-index: 3;
}
.m-yt-title {
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* --- Team horizontal scroll --- */
.m-team-scroll {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 12px;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
}
.m-team-scroll::-webkit-scrollbar { display: none; }
.m-team-card {
    flex: 0 0 110px;
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}
.m-team-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #2563eb;
}
.m-team-img-placeholder {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border: 2.5px solid #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    font-size: 1.5rem;
}
.m-team-name {
    font-size: 0.75rem;
    font-weight: 800;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    text-align: center;
    line-height: 1.3;
}
.m-team-role {
    font-size: 0.65rem;
    color: #64748b;
    font-family: 'Hind Siliguri', sans-serif;
    text-align: center;
    margin-top: -4px;
}

/* --- Reviews (horizontal scroll) --- */
.m-reviews-scroll {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 12px;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
}
.m-reviews-scroll::-webkit-scrollbar { display: none; }
.m-review-card {
    flex: 0 0 240px;
    scroll-snap-align: start;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.m-review-stars {
    display: flex;
    gap: 2px;
    color: #f59e0b;
    font-size: 0.8rem;
}
.m-review-text {
    font-size: 0.8rem;
    color: #334155;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.m-review-person {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: auto;
}
.m-review-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid #2563eb;
}
.m-review-name {
    font-size: 0.75rem;
    font-weight: 700;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
}
.m-review-desig {
    font-size: 0.65rem;
    color: #94a3b8;
    font-family: 'Hind Siliguri', sans-serif;
}

/* --- FAQ Accordion --- */
.m-faq-list { padding: 0 12px 12px; }
.m-faq-item {
    border-bottom: 1px solid #f1f5f9;
    overflow: hidden;
}
.m-faq-trigger {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    gap: 10px;
}
.m-faq-question {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.4;
    flex-grow: 1;
}
.m-faq-icon {
    color: #2563eb;
    font-size: 0.75rem;
    flex-shrink: 0;
    transition: transform 0.3s;
}
.m-faq-item.open .m-faq-icon { transform: rotate(180deg); }
.m-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.25s ease;
    font-size: 0.85rem;
    color: #334155;
    font-family: 'Hind Siliguri', sans-serif;
    line-height: 1.7;
    padding: 0 0 0;
}
.m-faq-item.open .m-faq-answer {
    max-height: 500px;
    padding-bottom: 14px;
}

/* Bottom spacer */
.m-bottom-pad { height: 24px; }
</style>

<!-- ===================== HERO SLIDER ===================== -->
<?php if (!empty($data['slides'])): ?>
<div class="m-slider-wrap" id="m-slider">
    <?php foreach ($data['slides'] as $idx => $slide):
        $simg = resolve_dynamic_url($slide['image'], '/public/img/');
    ?>
    <div class="m-slide <?= $idx === 0 ? 'active' : '' ?>">
        <?php if (!empty($slide['link'])): ?>
        <a href="<?= $slide['link'] ?>" style="display:block;width:100%;height:100%;">
        <?php endif; ?>
        <img src="<?= $simg ?>" alt="" fetchpriority="<?= $idx === 0 ? 'high' : 'low' ?>" decoding="async" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>">
        <?php if (!empty($slide['link'])): ?>
        </a>
        <?php endif; ?>
        <div class="m-slide-overlay"></div>
    </div>
    <?php endforeach; ?>
    <div class="m-slide-dots" id="m-slide-dots">
        <?php foreach ($data['slides'] as $idx => $slide): ?>
        <div class="m-dot <?= $idx === 0 ? 'active' : '' ?>" onclick="mGoSlide(<?= $idx ?>)"></div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>



<!-- ===================== QUICK ACTION BUTTONS ===================== -->
<div class="m-quick-actions">
    <a href="<?= URLROOT ?>/blog" class="m-qa-btn">
        <div class="m-qa-icon" style="background:#eff6ff;color:#2563eb;">
            <i class="fas fa-newspaper"></i>
        </div>
        <span>লেখাসমূহ</span>
    </a>
    <a href="<?= URLROOT ?>/q&a" class="m-qa-btn">
        <div class="m-qa-icon" style="background:#f0fdf4;color:#16a34a;">
            <i class="fas fa-question-circle"></i>
        </div>
        <span>প্রশ্নোত্তর</span>
    </a>
    <a href="<?= URLROOT ?>/ask" class="m-qa-btn">
        <div class="m-qa-icon" style="background:#fff7ed;color:#ea580c;">
            <i class="fas fa-pen-to-square"></i>
        </div>
        <span>প্রশ্ন করুন</span>
    </a>
    <a href="<?= URLROOT ?>/about" class="m-qa-btn">
        <div class="m-qa-icon" style="background:#fdf4ff;color:#9333ea;">
            <i class="fas fa-info-circle"></i>
        </div>
        <span>আমাদের</span>
    </a>
</div>

<!-- ===================== RECENT POSTS — FEATURED (WIDE) ===================== -->
<?php if (!empty($data['posts'])): ?>
<div class="m-section" style="margin-top:14px;">
    <div class="m-section-header">
        <div class="m-section-title">সাম্প্রতিক লেখা</div>
        <a href="<?= URLROOT ?>/blog" class="m-see-all">সব দেখুন <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></a>
    </div>

    <!-- First post: featured wide -->
    <?php $firstPost = $data['posts'][0];
        $firstImg = !empty($firstPost['featured_image']) ? resolve_blog_image($firstPost['featured_image']) : null;
    ?>
    <a href="<?= URLROOT ?>/<?= $firstPost['slug'] ?>" class="m-post-card-wide">
        <?php if ($firstImg): ?>
        <img class="m-post-wide-thumb" src="<?= $firstImg ?>" alt="<?= htmlspecialchars($firstPost['title']) ?>" loading="eager">
        <?php else: ?>
        <div class="m-post-wide-thumb-placeholder"><i class="fas fa-image"></i></div>
        <?php endif; ?>
        <div class="m-post-wide-body">
            <div class="m-post-wide-meta">
                <i class="fas fa-calendar-alt" style="color:#2563eb;font-size:0.65rem;"></i>
                <?= date('d M Y', strtotime($firstPost['created_at'])) ?>
            </div>
            <p class="m-post-wide-title"><?= htmlspecialchars($firstPost['title']) ?></p>
            <div class="m-post-wide-meta">
                <span class="m-post-wide-views"><i class="fas fa-eye" style="margin-right:3px;"></i><?= number_format($firstPost['views']) ?></span>
            </div>
        </div>
    </a>

    <!-- Remaining posts: 2-column grid -->
    <div class="m-posts-grid">
        <?php foreach (array_slice($data['posts'], 1, 8) as $post):
            $pimg = !empty($post['featured_image']) ? resolve_blog_image($post['featured_image']) : null;
        ?>
        <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="m-post-card">
            <?php if ($pimg): ?>
            <img class="m-post-thumb" src="<?= $pimg ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
            <?php else: ?>
            <div class="m-post-thumb-placeholder"><i class="fas fa-image"></i></div>
            <?php endif; ?>
            <div class="m-post-body">
                <div class="m-post-meta">
                    <i class="fas fa-calendar-alt" style="color:#2563eb;"></i>
                    <?= date('d M', strtotime($post['created_at'])) ?>
                    <span style="margin-left:auto;display:flex;align-items:center;gap:3px;">
                        <i class="fas fa-eye" style="color:#2563eb;"></i>
                        <?= number_format($post['views']) ?>
                    </span>
                </div>
                <p class="m-post-title"><?= htmlspecialchars($post['title']) ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== ASK QUESTION BANNER ===================== -->
<div class="m-ask-banner">
    <div class="m-ask-text">
        কোনো প্রশ্ন আছে?
        <span>ইসলামিক প্রশ্ন জিজ্ঞাসা করুন এখনই</span>
    </div>
    <a href="<?= URLROOT ?>/ask" class="m-ask-btn">
        <i class="fas fa-pen-to-square"></i> প্রশ্ন করুন
    </a>
</div>

<!-- ===================== RECENT Q&A ===================== -->
<?php if (!empty($data['recent_questions'])): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title">সাম্প্রতিক প্রশ্নোত্তর</div>
        <a href="<?= URLROOT ?>/q&a" class="m-see-all">সব দেখুন <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i></a>
    </div>
    <div class="m-qa-list">
        <?php foreach (array_slice($data['recent_questions'], 0, 7) as $i => $q): ?>
        <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="m-qa-item">
            <div class="m-qa-num"><?= $i + 1 ?></div>
            <div class="m-qa-q"><?= htmlspecialchars($q['question']) ?></div>
            <i class="fas fa-chevron-right m-qa-arrow"></i>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== SCOPES ===================== -->
<?php if (!empty($data['scopes']) && isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1'): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title">আমাদের কার্যপরিধি</div>
    </div>
    <div class="m-scopes-scroll">
        <?php foreach ($data['scopes'] as $scope): ?>
        <div class="m-scope-card">
            <div class="m-scope-icon"><i class="<?= $scope['icon'] ?>"></i></div>
            <div class="m-scope-name"><?= htmlspecialchars($scope['title']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== YOUTUBE VIDEOS ===================== -->
<?php if (!empty($data['yt_videos'])): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title"><i class="fab fa-youtube" style="color:#ff0000;font-size:0.9rem;margin-right:2px;"></i> ভিডিও</div>
    </div>
    <div class="m-yt-scroll">
        <?php foreach ($data['yt_videos'] as $vid):
            $vtid = $vid['video_id'] ?? '';
            $vthumb = "https://img.youtube.com/vi/{$vtid}/mqdefault.jpg";
        ?>
        <a href="https://www.youtube.com/watch?v=<?= htmlspecialchars($vtid) ?>" target="_blank" class="m-yt-card">
            <img class="m-yt-thumb" src="<?= $vthumb ?>" alt="<?= htmlspecialchars($vid['title'] ?? '') ?>" loading="lazy">
            <div class="m-yt-play"><i class="fas fa-play" style="margin-left:2px;"></i></div>
            <div class="m-yt-overlay">
                <div class="m-yt-title"><?= htmlspecialchars($vid['title'] ?? '') ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== TEAM MEMBERS ===================== -->
<?php if (!empty($data['team'])): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title">আমাদের টিম</div>
    </div>
    <div class="m-team-scroll">
        <?php foreach ($data['team'] as $member): ?>
        <div class="m-team-card">
            <?php if (!empty($member['image'])): ?>
            <img class="m-team-img" src="<?= resolve_dynamic_url($member['image'], '/public/img/') ?>" alt="<?= htmlspecialchars($member['name']) ?>" loading="lazy">
            <?php else: ?>
            <div class="m-team-img-placeholder"><i class="fas fa-user"></i></div>
            <?php endif; ?>
            <div class="m-team-name"><?= htmlspecialchars($member['name']) ?></div>
            <?php if (!empty($member['designation'])): ?>
            <div class="m-team-role"><?= htmlspecialchars($member['designation']) ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== REVIEWS ===================== -->
<?php if (!empty($data['reviews'])): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title">মতামত</div>
    </div>
    <div class="m-reviews-scroll">
        <?php foreach ($data['reviews'] as $rev): ?>
        <div class="m-review-card">
            <div class="m-review-stars">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                <i class="<?= $s <= $rev['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                <?php endfor; ?>
            </div>
            <p class="m-review-text"><?= htmlspecialchars($rev['review_text']) ?></p>
            <div class="m-review-person">
                <img class="m-review-avatar"
                    src="<?= !empty($rev['image']) ? $rev['image'] : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($rev['name']))) . '?d=mp&s=80' ?>"
                    alt="<?= htmlspecialchars($rev['name']) ?>" loading="lazy">
                <div>
                    <div class="m-review-name"><?= htmlspecialchars($rev['name']) ?></div>
                    <div class="m-review-desig"><?= htmlspecialchars($rev['designation'] ?? 'নিয়মিত পাঠক') ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== FAQ ===================== -->
<?php if (!empty($data['faqs'])): ?>
<div class="m-section" style="margin-top:12px;">
    <div class="m-section-header">
        <div class="m-section-title">সাধারণ জিজ্ঞাসা</div>
    </div>
    <div class="m-faq-list">
        <?php foreach ($data['faqs'] as $fi => $faq): ?>
        <div class="m-faq-item" id="mfaq-<?= $fi ?>">
            <button class="m-faq-trigger" onclick="mToggleFaq(<?= $fi ?>)">
                <span class="m-faq-question"><?= htmlspecialchars($faq['question']) ?></span>
                <i class="fas fa-chevron-down m-faq-icon"></i>
            </button>
            <div class="m-faq-answer"><?= $faq['answer'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="m-bottom-pad"></div>

<!-- ===================== SCRIPTS ===================== -->
<script>
// --- Mobile Slider ---
(function() {
    var slides = document.querySelectorAll('#m-slider .m-slide');
    var dots = document.querySelectorAll('#m-slide-dots .m-dot');
    var cur = 0;
    if (!slides.length) return;

    window.mGoSlide = function(n) {
        slides[cur].classList.remove('active');
        dots[cur] && dots[cur].classList.remove('active');
        cur = (n + slides.length) % slides.length;
        slides[cur].classList.add('active');
        dots[cur] && dots[cur].classList.add('active');
        resetT();
    };

    var t = setInterval(function() { mGoSlide(cur + 1); }, 5000);
    function resetT() { clearInterval(t); t = setInterval(function() { mGoSlide(cur + 1); }, 5000); }

    // Touch swipe support
    var slider = document.getElementById('m-slider');
    var sx = 0;
    slider.addEventListener('touchstart', function(e) { sx = e.touches[0].clientX; }, {passive: true});
    slider.addEventListener('touchend', function(e) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 40) mGoSlide(cur + (dx < 0 ? 1 : -1));
    }, {passive: true});
})();

// --- Mobile FAQ ---
function mToggleFaq(i) {
    var item = document.getElementById('mfaq-' + i);
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.m-faq-item.open').forEach(function(el) { el.classList.remove('open'); });
    if (!isOpen) item.classList.add('open');
}
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
