<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 950px; margin: 0 auto;">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div style="width: 50px; height: 50px; background: #ff0000; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 20px; box-shadow: 0 4px 15px rgba(255,0,0,0.3);">
                <i class="fab fa-youtube"></i>
            </div>
            <div>
                <h3 class="m-0" style="font-weight: 800;">YouTube Live & Auto Video Automation</h3>
                <p class="text-muted m-0" style="font-size: 0.9rem;">চ্যানেল ইনফো সেট করুন, স্বয়ংক্রিয় লাইভ ডিটেকশন ও ভিডিও সিঙ্ক চালু করুন</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="button" id="btn-test-live" class="btn btn-outline-danger" style="display: flex; align-items: center; gap: 8px; font-weight: 600;">
                <i class="fas fa-satellite-dish"></i> লাইভ স্ট্যাটাস চেক
            </button>
            <button type="button" id="btn-sync-videos" class="btn btn-success" style="display: flex; align-items: center; gap: 8px; font-weight: 600; background: #0b7c4d; border-color: #0b7c4d;">
                <i class="fas fa-sync-alt"></i> ভিডিও সিঙ্ক করুন
            </button>
        </div>
    </div>

    <!-- Live Status / Sync Result Alert Box -->
    <div id="action-result-box" style="display: none; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; transition: 0.3s;"></div>

    <?php if (isset($data['success'])): ?>
        <div class="alert alert-success mb-4" style="border-radius: 12px;"><i class="fas fa-check-circle me-2"></i><?= $data['success'] ?></div>
    <?php endif; ?>

    <!-- Step by Step Setup Guide (উইথ ডিরেক্ট লিংক) -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%); border: 1px solid #dbeafe; border-radius: 16px; padding: 25px; margin-bottom: 30px;">
        <h5 style="color: #1e3a8a; font-weight: 800; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-info-circle text-primary"></i> কীভাবে API Key এবং Channel ID সংগ্রহ করবেন? (সহজ গাইডলাইন)
        </h5>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 15px;">
            <!-- Step 1 -->
            <div style="background: #ffffff; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span style="background: #fee2e2; width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">১</span>
                    <span>YouTube API চালু করুন</span>
                </div>
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    Google Cloud Console-এ গিয়ে সম্পূর্ণ ফ্রিতে <strong>YouTube Data API v3</strong> সক্রিয় করুন।
                </p>
                <a href="https://console.cloud.google.com/apis/library/youtube.googleapis.com" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    সরাসরি API পেজে যান <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                </a>
            </div>

            <!-- Step 2 -->
            <div style="background: #ffffff; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span style="background: #fee2e2; width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">২</span>
                    <span>API Key তৈরি করুন</span>
                </div>
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    <strong>Credentials</strong> পেজে গিয়ে <strong>+ Create Credentials > API Key</strong>-তে ক্লিক করে Key-টি কপি করুন।
                </p>
                <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    Credentials পেজে যান <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                </a>
            </div>

            <!-- Step 3 -->
            <div style="background: #ffffff; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span style="background: #fee2e2; width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">৩</span>
                    <span>Channel ID কপি করুন</span>
                </div>
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    YouTube Advanced Settings-এ গিয়ে আপনার <strong>Channel ID</strong> (যা <code>UC...</code> দিয়ে শুরু) কপি করে নিন।
                </p>
                <a href="https://www.youtube.com/account_advanced" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    Advanced Settings-এ যান <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form action="<?= URLROOT ?>/admin/youtube" method="POST" id="yt-settings-form">
        <?= csrf_field() ?>
        
        <div class="form-grid">
            <!-- YouTube API Key -->
            <div class="form-group full-width">
                <label style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-key text-warning"></i> YouTube Data API v3 Key
                </label>
                <input type="text" id="field_api_key" name="settings[youtube_api_key]" value="<?= htmlspecialchars($data['settings']['youtube_api_key'] ?? '') ?>" class="form-control" placeholder="AIzaSy..." style="font-family: monospace; font-size: 0.95rem;">
                <small style="color: #64748b;">গুগল ক্লাউড থেকে পাওয়া ফ্রি API Key টি এখানে পেস্ট করুন। এটি অটো লাইভ ও অটো ভিডিও সিঙ্কের জন্য আবশ্যক।</small>
            </div>

            <!-- Channel ID / Handle -->
            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                    <i class="fab fa-youtube text-danger"></i> YouTube Channel ID অথবা Handle
                </label>
                <input type="text" id="field_channel_id" name="settings[youtube_channel_id]" value="<?= htmlspecialchars($data['settings']['youtube_channel_id'] ?? '') ?>" class="form-control" placeholder="UCxxxxxxxxxxxxxx অথবা @YourChannel">
                <small style="color: #64748b;">আপনার চ্যানেলের ID (UC...) অথবা হ্যান্ডেল (@নাম) দিন।</small>
            </div>

            <!-- Channel URL for Buttons -->
            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-link text-primary"></i> YouTube Channel URL
                </label>
                <input type="text" name="settings[youtube_channel_url]" value="<?= htmlspecialchars($data['settings']['youtube_channel_url'] ?? '') ?>" class="form-control" placeholder="https://www.youtube.com/@YourChannel">
                <small style="color: #64748b;">হোমপেজের "ইউটিউবে দেখুন" বাটনটি এই ঠিকানায় নিয়ে যাবে।</small>
            </div>

            <!-- Notification Status / Mode -->
            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b;">লাইভ নোটিফিকেশন মোড (Live Mode)</label>
                <select name="settings[youtube_status]" id="field_youtube_status" class="form-control" style="font-weight: 600;">
                    <option value="auto" <?= ($data['settings']['youtube_status'] ?? 'auto') == 'auto' ? 'selected' : '' ?>>🤖 Auto Live Mode (প্রস্তাবিত: লাইভ হলে অটো শো করবে)</option>
                    <option value="active" <?= ($data['settings']['youtube_status'] ?? '') == 'active' ? 'selected' : '' ?>>🟢 Always Active (ম্যানুয়াল ভিডিও সবসময় দেখাবে)</option>
                    <option value="inactive" <?= ($data['settings']['youtube_status'] ?? '') == 'inactive' ? 'selected' : '' ?>>⚪ Inactive (নোটিফিকেশন বন্ধ থাকবে)</option>
                </select>
                <small style="color: #64748b;"><strong>Auto Mode</strong> নির্বাচন করলে চ্যানেল লাইভে যাওয়া মাত্রই ওয়েবসাইট স্বয়ংক্রিয়ভাবে লাইভ শো করবে।</small>
            </div>

            <!-- Auto Video Sync Toggle -->
            <div class="form-group">
                <label style="font-weight: 700; color: #1e293b;">স্বয়ংক্রিয় ভিডিও সিঙ্ক (Auto Sync Videos)</label>
                <select name="settings[youtube_auto_sync]" class="form-control" style="font-weight: 600;">
                    <option value="yes" <?= ($data['settings']['youtube_auto_sync'] ?? 'yes') == 'yes' ? 'selected' : '' ?>>✅ চালু (নতুন ভিডিও আপলোড হলে অটো গ্যালারিতে যোগ হবে)</option>
                    <option value="no" <?= ($data['settings']['youtube_auto_sync'] ?? '') == 'no' ? 'selected' : '' ?>>❌ বন্ধ (শুধুমাত্র ম্যানুয়ালি সিঙ্ক করবেন)</option>
                </select>
                <small style="color: #64748b;">
                    সর্বশেষ সিঙ্ক: <strong><?= !empty($data['settings']['youtube_last_sync']) ? date('d M Y, h:i A', strtotime($data['settings']['youtube_last_sync'])) : 'কখনো নয়' ?></strong>
                </small>
            </div>

            <!-- Notification Title -->
            <div class="form-group full-width">
                <label style="font-weight: 700; color: #1e293b;">লাইভ নোটিফিকেশন টাইটেল</label>
                <input type="text" name="settings[youtube_title]" value="<?= htmlspecialchars($data['settings']['youtube_title'] ?? 'আমরা এখন লাইভে আছি!') ?>" class="form-control" placeholder="যেমন: সরাসরি সম্প্রচার দেখুন">
                <small style="color: #64748b;">হোমপেজের ফ্লোটিং উইজেটের উপরের ব্যানারে এই লেখাটি প্রদর্শিত হবে।</small>
            </div>

            <!-- Fallback / Manual Video ID -->
            <div class="form-group full-width">
                <label style="font-weight: 700; color: #1e293b;">ম্যানুয়াল ভিডিও/লাইভ আইডি (Fallback Video ID)</label>
                <input type="text" name="settings[youtube_video_id]" value="<?= htmlspecialchars($data['settings']['youtube_video_id'] ?? '') ?>" class="form-control" placeholder="e.g. jA1HDe03P-k">
                <small style="color: #64748b;">যদি মোড "Always Active" রাখা হয় অথবা অটো লাইভ না থাকা অবস্থায় কোনো বিশেষ ভিডিও দেখাতে চান, তবে তার আইডি এখানে দিতে পারেন।</small>
            </div>
        </div>

        <div style="background: #fff8f8; padding: 20px; border-radius: 12px; margin-top: 30px; border-left: 5px solid #ff0000; border: 1px solid #fee2e2;">
            <div style="font-size: 0.95rem; color: #1e293b; line-height: 1.6;">
                <strong>💡 কীভাবে লাইভ ও ভিডিও অটো কাজ করবে?</strong><br>
                ১. <strong>API Key</strong> এবং <strong>Channel ID</strong> দিয়ে নিচে সেভ করুন।<br>
                ২. <strong>Auto Live Mode</strong> সিলেক্ট করে রাখলে আপনার চ্যানেলে লাইভ স্ট্রিম শুরু হওয়া মাত্রই ওয়েবসাইটে ফ্লোটিং লাইভ উইজেট ওপেন হবে এবং লাইভ শেষ হলে নিজে নিজেই বন্ধ হয়ে যাবে।<br>
                ৩. উপরের <strong>"ভিডিও সিঙ্ক করুন"</strong> বাটনে ক্লিক করলে বা অটো-সিঙ্ক অন থাকলে চ্যানেলের ভিডিওগুলো স্বয়ংক্রিয়ভাবে হোমপেজের <strong>"ইউটিউব ভিডিওসমূহ"</strong> গ্যালারিতে যোগ হয়ে যাবে।
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="margin-top: 25px; padding: 14px; background: #ff0000; border: none; font-size: 1.1rem; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(255,0,0,0.3);">
            <i class="fas fa-save me-2"></i> Save YouTube Settings
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnTestLive = document.getElementById('btn-test-live');
    const btnSyncVideos = document.getElementById('btn-sync-videos');
    const resultBox = document.getElementById('action-result-box');

    function showResult(message, isSuccess) {
        resultBox.style.display = 'block';
        resultBox.style.background = isSuccess ? '#ecfdf5' : '#fef2f2';
        resultBox.style.border = isSuccess ? '1px solid #a7f3d0' : '1px solid #fecaca';
        resultBox.style.color = isSuccess ? '#065f46' : '#991b1b';
        resultBox.innerHTML = message;
        resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // 1. AJAX Test Live Status
    btnTestLive.addEventListener('click', function() {
        const apiKey = document.getElementById('field_api_key').value.trim();
        const channelId = document.getElementById('field_channel_id').value.trim();

        if (!apiKey || !channelId) {
            alert('অনুগ্রহ করে আগে YouTube API Key এবং Channel ID ফিল্ড পূরণ করুন।');
            return;
        }

        btnTestLive.disabled = true;
        const originalHtml = btnTestLive.innerHTML;
        btnTestLive.innerHTML = '<i class="fas fa-spinner fa-spin"></i> চেক করা হচ্ছে...';

        const formData = new FormData();
        formData.append('api_key', apiKey);
        formData.append('channel_id', channelId);

        fetch('<?= URLROOT ?>/admin/test_yt_live_ajax', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            btnTestLive.disabled = false;
            btnTestLive.innerHTML = originalHtml;

            if (data.is_live) {
                showResult(`
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="display: inline-block; width: 14px; height: 14px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 10px #ef4444; animation: pulse 1.5s infinite;"></span>
                        <div>
                            <strong style="font-size: 1.05rem;">🔴 এই মুহূর্তে চ্যানেলটি লাইভে আছে!</strong><br>
                            <span>ভিডিও টাইটেল: <strong>${data.title}</strong> (ID: <code>${data.video_id}</code>)</span><br>
                            <a href="https://www.youtube.com/watch?v=${data.video_id}" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: underline; margin-top: 5px; display: inline-block;">লাইভ স্ট্রিম ওপেন করুন <i class="fas fa-external-link-alt"></i></a>
                        </div>
                    </div>
                `, true);
            } else if (data.success) {
                showResult(`
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-video-slash" style="font-size: 1.5rem; color: #64748b;"></i>
                        <div>
                            <strong style="font-size: 1rem; color: #334155;">⚪ বর্তমানে চ্যানেলে কোনো লাইভ সম্প্রচার চলছে না।</strong><br>
                            <span style="font-size: 0.85rem; color: #64748b;">চ্যানেল স্ট্যাটাস স্বাভাবিক রয়েছে। লাইভ শুরু হলে সিস্টেম নিজে থেকেই ডিটেক্ট করবে।</span>
                        </div>
                    </div>
                `, true);
            } else {
                showResult(`<strong>❌ ত্রুটি:</strong> ${data.error || 'লাইভ চেক ব্যর্থ হয়েছে। API Key বা Channel ID সঠিক কি না যাচাই করুন।'}`, false);
            }
        })
        .catch(err => {
            btnTestLive.disabled = false;
            btnTestLive.innerHTML = originalHtml;
            showResult('<strong>❌ সার্ভার কানেকশন ত্রুটি:</strong> ' + err.message, false);
        });
    });

    // 2. AJAX Sync Videos
    btnSyncVideos.addEventListener('click', function() {
        const apiKey = document.getElementById('field_api_key').value.trim();
        const channelId = document.getElementById('field_channel_id').value.trim();

        if (!apiKey || !channelId) {
            alert('অনুগ্রহ করে আগে YouTube API Key এবং Channel ID ফিল্ড পূরণ করুন।');
            return;
        }

        btnSyncVideos.disabled = true;
        const originalHtml = btnSyncVideos.innerHTML;
        btnSyncVideos.innerHTML = '<i class="fas fa-spinner fa-spin"></i> সিঙ্ক হচ্ছে...';

        const formData = new FormData();
        formData.append('api_key', apiKey);
        formData.append('channel_id', channelId);

        fetch('<?= URLROOT ?>/admin/sync_yt_videos_ajax', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            btnSyncVideos.disabled = false;
            btnSyncVideos.innerHTML = originalHtml;

            if (data.success) {
                showResult(`
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-check-circle" style="font-size: 1.6rem; color: #059669;"></i>
                        <div>
                            <strong style="font-size: 1.05rem;">${data.message}</strong><br>
                            <span style="font-size: 0.88rem;">চ্যানেল থেকে লেটেস্ট মোট ${data.total || 0}টি ভিডিও প্রসেস করা হয়েছে। হোমপেজ বা "All YouTube Video" পেজে এগুলো দেখতে পাবেন।</span>
                        </div>
                    </div>
                `, true);
            } else {
                showResult(`<strong>❌ সিঙ্ক ত্রুটি:</strong> ${data.error || 'ভিডিও সিঙ্ক ব্যর্থ হয়েছে।'}`, false);
            }
        })
        .catch(err => {
            btnSyncVideos.disabled = false;
            btnSyncVideos.innerHTML = originalHtml;
            showResult('<strong>❌ সার্ভার কানেকশন ত্রুটি:</strong> ' + err.message, false);
        });
    });
});
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
