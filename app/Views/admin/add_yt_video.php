<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.8rem; font-weight: 800;">
            <i class="fab fa-youtube text-danger me-2"></i> নতুন ভিডিও যোগ করুন (Add Video)
        </h1>
        <p class="text-muted" style="margin-top: 5px; margin-bottom: 0; font-size: 0.95rem;">
            ইউটিউব লিংক পেস্ট করে ওয়েবসাইটে নতুন ভিডিও সংযুক্ত করুন
        </p>
    </div>
    <a href="<?= URLROOT ?>/admin/yt_videos" class="btn btn-outline-secondary" style="font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
        <i class="fas fa-arrow-left"></i> ভিডিও তালিকায় ফিরুন
    </a>
</div>

<div style="max-width: 850px; margin: 0 auto;">
    <div class="admin-card" style="padding: 35px; border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 25px rgba(0,0,0,0.03);">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 4px 12px rgba(220,38,38,0.15);">
                <i class="fab fa-youtube"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.25rem;">ভিডিওর তথ্য ও লিংক</h3>
                <small class="text-muted" style="font-size: 0.85rem;">ইউটিউব লিংক দিলে স্বয়ংক্রিয়ভাবে ভিডিওর প্রিভিউ ও শিরোনাম শনাক্ত হবে</small>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/add_yt_video" method="POST" id="add-yt-form">
            <?= csrf_field() ?>

            <!-- YouTube URL -->
            <div class="form-group mb-4">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-link text-danger"></i> YouTube Video URL <span class="text-danger">*</span>
                </label>
                <div style="position: relative;">
                    <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=... অথবা https://youtu.be/..." required style="padding: 13px 16px; border-radius: 12px; font-size: 0.95rem; border: 1px solid #cbd5e1;">
                    <span id="url-status-icon" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); display: none;">
                        <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                    </span>
                </div>
                <small class="text-muted" style="font-size: 0.82rem; margin-top: 6px; display: block;">
                    যেকোনো ব্রাউজারের অ্যাড্রেস বার বা শেয়ার বাটন থেকে ভিডিওর লিংকটি কপি করে পেস্ট করুন।
                </small>
            </div>

            <!-- Live Preview Container -->
            <div id="video-preview-container" class="form-group mb-4" style="display: none; background: #0f172a; padding: 15px; border-radius: 14px; border: 1px solid #334155;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; color: #ffffff;">
                    <span style="font-weight: 700; font-size: 0.88rem; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-play-circle text-danger"></i> লাইভ ভিডিও প্রিভিউ
                    </span>
                    <span id="detected-vid-badge" style="background: rgba(255,255,255,0.1); padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; color: #cbd5e1; font-family: monospace;"></span>
                </div>
                <div id="yt-preview" style="position: relative; width: 100%; aspect-ratio: 16 / 9; border-radius: 10px; overflow: hidden; background: #000;">
                    <!-- iFrame injected via JS -->
                </div>
            </div>

            <!-- Video Title -->
            <div class="form-group mb-4">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-weight: 700; color: #1e293b; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-heading text-primary"></i> ভিডিও শিরোনাম (Video Title) <span class="text-danger">*</span>
                    </label>
                    <span id="title-auto-badge" style="display: none; font-size: 0.78rem; background: #ecfdf5; color: #059669; padding: 2px 8px; border-radius: 6px; font-weight: 600;">
                        <i class="fas fa-magic me-1"></i> অটো-ডিটেক্টেড
                    </span>
                </div>
                <input type="text" name="title" id="video_title" class="form-control" placeholder="ভিডিওর শিরোনাম লিখুন" required style="padding: 13px 16px; border-radius: 12px; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; border: 1px solid #cbd5e1;">
            </div>

            <!-- Video Category -->
            <div class="form-group mb-4">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-weight: 700; color: #1e293b; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-folder text-warning"></i> ভিডিও ক্যাটাগরি (Category)
                    </label>
                    <a href="<?= URLROOT ?>/admin/yt_categories" target="_blank" style="font-size: 0.82rem; color: #2563eb; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-plus-circle"></i> নতুন ক্যাটাগরি তৈরি করুন
                    </a>
                </div>
                <select name="category_id" class="form-control" style="padding: 13px 16px; border-radius: 12px; font-size: 0.95rem; border: 1px solid #cbd5e1; font-weight: 600;">
                    <option value="">-- ক্যাটাগরি নির্বাচন করুন (ঐচ্ছিক) --</option>
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small class="text-muted" style="font-size: 0.82rem; margin-top: 6px; display: block;">ক্যাটাগরি সিলেক্ট করলে ভিডিওটি সেই বিভাগের অধীনে সাজানো থাকবে।</small>
            </div>

            <!-- Description -->
            <div class="form-group mb-4">
                <label style="font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-align-left text-muted"></i> সংক্ষিপ্ত বিবরণ (Description - ঐচ্ছিক)
                </label>
                <textarea name="description" class="form-control" rows="4" placeholder="ভিডিও সম্পর্কে কিছু তথ্য (প্রয়োজনে)..." style="padding: 13px 16px; border-radius: 12px; font-size: 0.95rem; border: 1px solid #cbd5e1; font-family: 'Hind Siliguri', sans-serif;"></textarea>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 35px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                <button type="submit" class="btn btn-primary w-100" style="padding: 14px; background: #dc2626; border-color: #dc2626; font-size: 1.05rem; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(220,38,38,0.3); display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 1.2rem;"></i> ভিডিও সংরক্ষণ করুন (Save YouTube Video)
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('video_url');
    const titleInput = document.getElementById('video_title');
    const previewContainer = document.getElementById('video-preview-container');
    const previewDiv = document.getElementById('yt-preview');
    const statusIcon = document.getElementById('url-status-icon');
    const vidBadge = document.getElementById('detected-vid-badge');
    const autoBadge = document.getElementById('title-auto-badge');

    function extractVideoId(url) {
        if (!url) return null;
        const regExp = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/;
        const match = url.match(regExp);
        return match ? match[1] : null;
    }

    urlInput.addEventListener('input', function() {
        const url = this.value.trim();
        const videoId = extractVideoId(url);

        if (videoId) {
            statusIcon.style.display = 'block';
            vidBadge.textContent = 'ID: ' + videoId;
            previewContainer.style.display = 'block';
            previewDiv.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?rel=0" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;

            // If title is empty, auto-fetch from YouTube oEmbed API (free, zero API key required)
            if (!titleInput.value.trim()) {
                fetch(`https://noembed.com/embed?url=https://www.youtube.com/watch?v=${videoId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.title && !titleInput.value.trim()) {
                            titleInput.value = data.title;
                            autoBadge.style.display = 'inline-block';
                        }
                    })
                    .catch(() => {});
            }
        } else {
            statusIcon.style.display = 'none';
            previewContainer.style.display = 'none';
            previewDiv.innerHTML = '';
        }
    });

    // Check if initial value already exists
    if (urlInput.value.trim()) {
        urlInput.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
