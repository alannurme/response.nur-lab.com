<?php require APPROOT . '/Views/inc/header.php'; ?>

<?php
$videos = $data['yt_videos'] ?? [];
$categories = $data['yt_categories'] ?? [];
$channelUrl = !empty($data['settings']['youtube_channel_url']) ? $data['settings']['youtube_channel_url'] : 'https://www.youtube.com';
?>

<style>
/* Videos Page Styling */
.yt-gallery-hero {
    background: linear-gradient(135deg, #0b1120 0%, #1e293b 100%);
    padding: 70px 0 60px 0;
    color: #ffffff;
    text-align: center;
    position: relative;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.yt-gallery-title {
    font-size: 2.8rem;
    font-weight: 900;
    font-family: 'Hind Siliguri', sans-serif;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}
.yt-gallery-title span {
    color: #ff3b30;
    position: relative;
    display: inline-block;
}
.yt-gallery-subtitle {
    font-size: 1.15rem;
    color: #94a3b8;
    max-width: 680px;
    margin: 0 auto 30px auto;
    line-height: 1.6;
}

/* Search and Filters */
.yt-filter-wrapper {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 15px;
}
.yt-search-input-box {
    position: relative;
    margin-bottom: 20px;
}
.yt-search-input-box i {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1.1rem;
}
.yt-search-input-box input {
    width: 100%;
    padding: 14px 20px 14px 50px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    color: #ffffff;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s;
    box-sizing: border-box;
}
.yt-search-input-box input::placeholder {
    color: #94a3b8;
}
.yt-search-input-box input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #ff3b30;
    box-shadow: 0 0 0 4px rgba(255, 59, 48, 0.25);
}

.yt-cat-pills {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.yt-cat-pill {
    padding: 7px 18px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    background: rgba(255, 255, 255, 0.07);
    color: #cbd5e1;
    border: 1px solid rgba(255, 255, 255, 0.12);
    cursor: pointer;
    transition: 0.25s all;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.yt-cat-pill:hover {
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
    transform: translateY(-1px);
}
.yt-cat-pill.active {
    background: #ff3b30;
    color: #ffffff;
    border-color: #ff3b30;
    box-shadow: 0 4px 15px rgba(255, 59, 48, 0.35);
}

/* Video Grid Area */
.yt-grid-section {
    padding: 60px 0 90px 0;
    background: #f8fafc;
    min-height: 500px;
}
.yt-grid-container {
    max-width: 1350px;
    margin: 0 auto;
    padding: 0 20px;
    box-sizing: border-box;
}
.yt-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 28px;
}

/* Card */
.yt-full-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s;
    display: flex;
    flex-direction: column;
}
.yt-full-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}

/* Player Frame Container (16:9) */
.yt-player-frame {
    position: relative;
    aspect-ratio: 16/9;
    background: #000000;
    overflow: hidden;
}
.yt-player-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.92;
    transition: 0.4s transform, 0.4s opacity;
    display: block;
}
.yt-full-card:hover .yt-player-frame img {
    transform: scale(1.05);
    opacity: 0.85;
}

/* Play Overlay Button */
.yt-play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.25);
    cursor: pointer;
    border: none;
    outline: none;
    padding: 0;
    transition: 0.3s background;
    z-index: 2;
}
.yt-play-overlay:hover {
    background: rgba(0, 0, 0, 0.45);
}
.yt-play-disc {
    width: 66px;
    height: 66px;
    background: #ff0000;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5);
    transition: 0.3s transform, 0.3s background;
}
.yt-play-overlay:hover .yt-play-disc {
    transform: scale(1.15);
    background: #cc0000;
}
.yt-play-disc i {
    margin-left: 4px;
}

/* Badges on Thumbnail */
.yt-cat-tag {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(4px);
    color: #ffffff;
    font-size: 0.74rem;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 6px;
    z-index: 3;
    pointer-events: none;
}
.yt-theater-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    cursor: pointer;
    z-index: 3;
    transition: 0.2s all;
}
.yt-theater-btn:hover {
    background: #ff0000;
    border-color: #ff0000;
    transform: scale(1.1);
}

/* Card Content */
.yt-card-content {
    padding: 20px 22px 22px 22px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.yt-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.82rem;
    color: #94a3b8;
    margin-bottom: 12px;
}
.yt-card-title {
    font-size: 1.08rem;
    line-height: 1.5;
    font-weight: 700;
    color: #1e293b;
    font-family: 'Hind Siliguri', sans-serif;
    margin: 0 0 12px 0;
    height: 3.2rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    cursor: pointer;
    transition: 0.2s color;
}
.yt-card-title:hover {
    color: #ff0000;
}
.yt-card-desc {
    color: #64748b;
    font-size: 0.88rem;
    line-height: 1.6;
    margin: 0 0 18px 0;
    height: 2.8rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Card Action Buttons */
.yt-card-actions {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
}
.yt-btn-play-inline {
    background: #fff1f2;
    color: #e11d48;
    border: 1px solid #ffe4e6;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.84rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.2s all;
}
.yt-btn-play-inline:hover {
    background: #e11d48;
    color: #ffffff;
    border-color: #e11d48;
}

.yt-btn-theater {
    background: #f8fafc;
    color: #334155;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.84rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: 0.2s all;
}
.yt-btn-theater:hover {
    background: #1e293b;
    color: #ffffff;
    border-color: #1e293b;
}

.yt-link-external {
    color: #94a3b8;
    font-size: 0.82rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none;
    transition: 0.2s color;
}
.yt-link-external:hover {
    color: #ff0000;
}

/* Theater Lightbox Modal */
.yt-theater-modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 15, 29, 0.88);
    backdrop-filter: blur(8px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}
.yt-theater-modal-backdrop.show {
    display: flex;
}
.yt-theater-dialog {
    width: 100%;
    max-width: 960px;
    background: #0f172a;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.1);
    animation: ytModalIn 0.25s ease-out;
}
@keyframes ytModalIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.yt-theater-header {
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #1e293b;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.yt-theater-title {
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 700;
    font-family: 'Hind Siliguri', sans-serif;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 80%;
}
.yt-theater-close {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #ffffff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s all;
}
.yt-theater-close:hover {
    background: #ff0000;
    transform: rotate(90deg);
}
.yt-theater-video-wrap {
    position: relative;
    aspect-ratio: 16/9;
    width: 100%;
    background: #000000;
}
.yt-theater-video-wrap iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}
.yt-theater-footer {
    padding: 14px 22px;
    background: #1e293b;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
</style>

<!-- Hero Section -->
<section class="yt-gallery-hero">
    <div class="container">
        <h1 class="yt-gallery-title">
            সবগুলো ইউটিউব <span>ভিডিও ও আলোচনা</span>
        </h1>
        <p class="yt-gallery-subtitle">
            আমাদের অফিশিয়াল ইউটিউব চ্যানেলের সকল ভিডিও, লেকচার ও উন্মুক্ত বিতর্ক সরাসরি আমাদের ওয়েবসাইট থেকেই উপভোগ করুন।
        </p>

        <!-- Search & Filter Controls -->
        <div class="yt-filter-wrapper">
            <!-- Search Box -->
            <div class="yt-search-input-box">
                <i class="fas fa-search"></i>
                <input type="text" id="ytSearchInput" placeholder="ভিডিওর শিরোনাম বা বিষয় দিয়ে খুঁজুন..." onkeyup="filterVideos()">
            </div>

            <!-- Category Pills -->
            <div class="yt-cat-pills">
                <button type="button" class="yt-cat-pill active" data-category="all" onclick="selectVideoCategory('all', this)">
                    <i class="fas fa-play-circle"></i> সকল ভিডিও (<?= count($videos) ?>)
                </button>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <button type="button" class="yt-cat-pill" data-category="<?= htmlspecialchars($cat['name']) ?>" onclick="selectVideoCategory('<?= htmlspecialchars($cat['name']) ?>', this)">
                            <?= htmlspecialchars($cat['name']) ?> (<?= $cat['video_count'] ?? 0 ?>)
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Videos Grid Section -->
<section class="yt-grid-section">
    <div class="yt-grid-container">
        <?php if (!empty($videos)): ?>
            <div class="yt-cards-grid" id="ytVideosGrid">
                <?php foreach ($videos as $video): ?>
                <?php
                    $vidId = htmlspecialchars($video['video_id']);
                    $vidTitle = htmlspecialchars($video['title']);
                    $catName = htmlspecialchars($video['category_name'] ?? 'ভিডিও');
                    $dbId = $video['id'];
                ?>
                <div class="yt-full-card yt-card-item" data-category="<?= $catName ?>" id="card-<?= $dbId ?>">
                    <!-- 16:9 Video Player Frame -->
                    <div class="yt-player-frame" id="player-frame-<?= $dbId ?>">
                        <!-- Thumbnail Image -->
                        <img src="https://img.youtube.com/vi/<?= $vidId ?>/hqdefault.jpg" alt="<?= $vidTitle ?>" loading="lazy" decoding="async">
                        
                        <!-- Category Tag -->
                        <span class="yt-cat-tag"><?= $catName ?></span>

                        <!-- Theater Mode Button (Top Right) -->
                        <button type="button" class="yt-theater-btn" title="বড় পর্দায় চালান (Theater Mode)" onclick="openTheaterPlayer('<?= $vidId ?>', '<?= addslashes($vidTitle) ?>', '<?= addslashes($catName) ?>')">
                            <i class="fas fa-expand"></i>
                        </button>

                        <!-- Main Play Button Overlay (Clicking starts playback IN-PLACE immediately) -->
                        <button type="button" class="yt-play-overlay" title="এখানেই চালান" onclick="playVideoInline('<?= $dbId ?>', '<?= $vidId ?>', '<?= addslashes($vidTitle) ?>')">
                            <div class="yt-play-disc">
                                <i class="fas fa-play"></i>
                            </div>
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="yt-card-content">
                        <!-- Meta Info -->
                        <div class="yt-meta-row">
                            <span><i class="fas fa-tag" style="color: #ff3b30; margin-right: 4px;"></i> <?= $catName ?></span>
                            <span><i class="far fa-calendar-alt" style="margin-right: 4px;"></i> <?= !empty($video['created_at']) ? date('d M, Y', strtotime($video['created_at'])) : 'Recent' ?></span>
                        </div>

                        <!-- Title -->
                        <h3 class="yt-card-title" title="<?= $vidTitle ?>" onclick="playVideoInline('<?= $dbId ?>', '<?= $vidId ?>', '<?= addslashes($vidTitle) ?>')">
                            <?= $vidTitle ?>
                        </h3>

                        <!-- Description -->
                        <?php if (!empty($video['description'])): ?>
                            <p class="yt-card-desc"><?= htmlspecialchars(strip_tags($video['description'])) ?></p>
                        <?php else: ?>
                            <p class="yt-card-desc" style="font-style: italic; opacity: 0.6;">আমাদের চ্যানেলের নিয়মিত আলোচনা ও প্রশ্নোত্তরের ভিডিও।</p>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="yt-card-actions">
                            <button type="button" class="yt-btn-play-inline" onclick="playVideoInline('<?= $dbId ?>', '<?= $vidId ?>', '<?= addslashes($vidTitle) ?>')">
                                <i class="fas fa-play"></i> এখানেই চালান
                            </button>
                            <button type="button" class="yt-btn-theater" onclick="openTheaterPlayer('<?= $vidId ?>', '<?= addslashes($vidTitle) ?>', '<?= addslashes($catName) ?>')">
                                <i class="fas fa-expand"></i> বড় পর্দায়
                            </button>
                            <a href="https://www.youtube.com/watch?v=<?= $vidId ?>" target="_blank" rel="noopener noreferrer" class="yt-link-external" title="ইউটিউব অ্যাপে দেখুন">
                                <i class="fab fa-youtube" style="color: #ff0000; font-size: 1rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Zero Match State -->
            <div id="ytNoMatch" style="display: none; text-align: center; padding: 70px 20px; background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; margin-top: 20px;">
                <i class="fas fa-search fa-3x text-muted" style="color: #94a3b8; margin-bottom: 16px;"></i>
                <h3 style="color: #1e293b; font-weight: 700;">কোনো ভিডিও মেলেনি</h3>
                <p style="color: #64748b; margin: 0;">আপনার অনুসন্ধানের সাথে মিল রেখে কোনো ভিডিও পাওয়া যায়নি। অন্য কোনো বিষয় লিখে চেষ্টা করুন।</p>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 90px 20px; background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0;">
                <i class="fab fa-youtube fa-5x" style="color: #ff0000; opacity: 0.3; margin-bottom: 20px;"></i>
                <h2 style="color: #1e293b; font-weight: 800;">এখনো কোনো ভিডিও যুক্ত করা হয়নি</h2>
                <p style="color: #64748b; font-size: 1.1rem;">আমাদের অফিশিয়াল চ্যানেলে নতুন ভিডিও যুক্ত হলে তা স্বয়ংক্রিয়ভাবে এখানে প্রদর্শিত হবে।</p>
                <a href="<?= $channelUrl ?>" target="_blank" class="btn btn-primary" style="background: #ff0000; border-color: #ff0000; padding: 12px 30px; border-radius: 50px; font-weight: 700; margin-top: 15px; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fab fa-youtube"></i> ইউটিউব চ্যানেলে যান
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Theater Mode Lightbox Modal -->
<div class="yt-theater-modal-backdrop" id="ytTheaterModal" onclick="handleTheaterBackdrop(event)">
    <div class="yt-theater-dialog">
        <div class="yt-theater-header">
            <h4 class="yt-theater-title" id="theaterTitle">ভিডিও প্লেয়ার</h4>
            <button type="button" class="yt-theater-close" onclick="closeTheaterPlayer()" title="বন্ধ করুন">&times;</button>
        </div>
        <div class="yt-theater-video-wrap">
            <div id="theaterIframeContainer" style="width: 100%; height: 100%;"></div>
        </div>
        <div class="yt-theater-footer">
            <span id="theaterCategory" style="color: #ff4d4d; font-weight: 700; font-size: 0.88rem;"></span>
            <a id="theaterYtLink" href="#" target="_blank" rel="noopener noreferrer" style="color: #cbd5e1; font-size: 0.88rem; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <span>ইউটিউবে খুলুন</span> <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
            </a>
        </div>
    </div>
</div>

<script>
// State for currently playing inline player
let activeInlineId = null;
let savedOriginalHtml = {};

// 1. Play Video Directly In-Place (Inline Playback)
function playVideoInline(dbId, videoId, title) {
    const frame = document.getElementById('player-frame-' + dbId);
    if (!frame) return;

    // If another card is already playing inline, restore that card's original thumbnail
    if (activeInlineId && activeInlineId !== dbId && savedOriginalHtml[activeInlineId]) {
        const prevFrame = document.getElementById('player-frame-' + activeInlineId);
        if (prevFrame) {
            prevFrame.innerHTML = savedOriginalHtml[activeInlineId];
        }
    }

    // Save original frame contents if not saved
    if (!savedOriginalHtml[dbId]) {
        savedOriginalHtml[dbId] = frame.innerHTML;
    }

    activeInlineId = dbId;

    // Inject YouTube Iframe with autoplay=1
    frame.innerHTML = `
        <iframe 
            src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&playsinline=1" 
            title="${title}" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen 
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;">
        </iframe>
    `;
}

// 2. Play Video in Theater Mode Lightbox Modal
function openTheaterPlayer(videoId, title, category) {
    // Stop any inline video that might be playing
    if (activeInlineId && savedOriginalHtml[activeInlineId]) {
        const prevFrame = document.getElementById('player-frame-' + activeInlineId);
        if (prevFrame) {
            prevFrame.innerHTML = savedOriginalHtml[activeInlineId];
            activeInlineId = null;
        }
    }

    document.getElementById('theaterTitle').innerText = title;
    document.getElementById('theaterCategory').innerText = category ? 'বিভাগ: ' + category : '';
    document.getElementById('theaterYtLink').href = 'https://www.youtube.com/watch?v=' + videoId;

    const container = document.getElementById('theaterIframeContainer');
    container.innerHTML = `
        <iframe 
            src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&playsinline=1" 
            title="${title}" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen 
            style="width: 100%; height: 100%; border: none;">
        </iframe>
    `;

    document.getElementById('ytTheaterModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeTheaterPlayer() {
    const modal = document.getElementById('ytTheaterModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
    // Clear iframe to immediately stop audio/video
    document.getElementById('theaterIframeContainer').innerHTML = '';
}

function handleTheaterBackdrop(e) {
    if (e.target === document.getElementById('ytTheaterModal')) {
        closeTheaterPlayer();
    }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTheaterPlayer();
    }
});

// 3. Category Filter
let currentCategory = 'all';

function selectVideoCategory(category, pillBtn) {
    currentCategory = category;
    document.querySelectorAll('.yt-cat-pill').forEach(btn => btn.classList.remove('active'));
    if (pillBtn) {
        pillBtn.classList.add('active');
    }
    filterVideos();
}

// 4. Live Search & Filter
function filterVideos() {
    const searchVal = document.getElementById('ytSearchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.yt-card-item');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardCat = card.getAttribute('data-category') || '';
        const cardText = card.innerText.toLowerCase();

        // Check category match
        let matchesCat = (currentCategory === 'all' || cardCat === currentCategory);

        // Check search match
        let matchesSearch = (!searchVal || cardText.includes(searchVal));

        if (matchesCat && matchesSearch) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noMatch = document.getElementById('ytNoMatch');
    if (noMatch) {
        noMatch.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
    }
}
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
