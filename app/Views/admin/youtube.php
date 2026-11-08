<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.yt-settings-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    border: 1px solid #e2e8f0;
    padding: 35px;
    max-width: 950px;
    margin: 0 auto;
}
.yt-icon-box {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
    color: white;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    box-shadow: 0 6px 18px rgba(255,0,0,0.25);
    flex-shrink: 0;
}
.yt-auto-banner {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}
.yt-auto-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #dcfce7;
    color: #15803d;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
}
.yt-step-card {
    background: #ffffff;
    padding: 18px;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    transition: transform 0.2s, box-shadow 0.2s;
}
.yt-step-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.yt-step-num {
    background: #fee2e2;
    color: #dc2626;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 800;
}
.yt-field-group {
    margin-bottom: 22px;
}
.yt-field-group label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
}
.yt-field-group input {
    height: 48px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
}
.yt-field-group input:focus {
    border-color: #ff0000;
    box-shadow: 0 0 0 3px rgba(255,0,0,0.12);
    outline: none;
}
.yt-field-group small {
    display: block;
    margin-top: 6px;
    color: #64748b;
    font-size: 0.83rem;
    line-height: 1.45;
}
@keyframes pulseRed {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
}
</style>

<div class="yt-settings-card">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="yt-icon-box">
                <i class="fab fa-youtube"></i>
            </div>
            <div>
                <h3 class="m-0" style="font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">YouTube অটোমেশন সেটিংস</h3>
                <p class="text-muted m-0" style="font-size: 0.88rem;">চ্যানেল ইনফো সেট করুন, স্বয়ংক্রিয় লাইভ সম্প্রচার ও নতুন ভিডিও সিঙ্ক সবসময় চালু থাকবে</p>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <button type="button" id="btn-test-live" class="btn btn-outline-danger" style="display: flex; align-items: center; gap: 8px; font-weight: 600; border-radius: 10px; padding: 10px 18px;">
                <i class="fas fa-satellite-dish"></i> লাইভ স্ট্যাটাস চেক
            </button>
            <button type="button" id="btn-sync-videos" class="btn btn-success" style="display: flex; align-items: center; gap: 8px; font-weight: 600; background: #0b7c4d; border-color: #0b7c4d; border-radius: 10px; padding: 10px 18px;">
                <i class="fas fa-sync-alt"></i> ভিডিও সিঙ্ক করুন
            </button>
        </div>
    </div>

    <!-- Live Status / Sync Result Alert Box -->
    <div id="action-result-box" style="display: none; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; transition: 0.3s;"></div>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success mb-4" style="border-radius: 12px; background: #dcfce7; border-color: #86efac; color: #15803d; font-weight: 600;">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-4" style="border-radius: 12px; background: #fef2f2; border-color: #fca5a5; color: #991b1b; font-weight: 600;">
            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- 100% Automation Status Banner -->
    <div class="yt-auto-banner">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 38px; height: 38px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                <i class="fas fa-robot"></i>
            </div>
            <div>
                <strong style="color: #14532d; font-size: 0.98rem; display: block;">১০০% স্বয়ংক্রিয় ইন্টিগ্রেশন (Fully Automated)</strong>
                <span style="color: #15803d; font-size: 0.85rem;">লাইভ শুরু হলে অটো হোমপেজে লাইভ প্লেয়ার ভেসে উঠবে এবং নতুন আপলোড করা ভিডিও অটো গ্যালারিতে সিঙ্ক হবে। কোনো ম্যানুয়াল সেটিংস প্রয়োজন নেই।</span>
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <span class="yt-auto-badge"><i class="fas fa-check"></i> অটো লাইভ ডিটেকশন</span>
            <span class="yt-auto-badge"><i class="fas fa-check"></i> অটো ভিডিও সিঙ্ক</span>
            <span style="font-size: 0.82rem; color: #475569; margin-left: 5px;">
                সর্বশেষ সিঙ্ক: <strong><?= !empty($settings['youtube_last_sync']) ? date('d M Y, h:i A', strtotime($settings['youtube_last_sync'])) : 'কখনো নয়' ?></strong>
            </span>
        </div>
    </div>

    <!-- Step by Step Setup Guide (উইথ ডিরেক্ট লিংক) -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%); border: 1px solid #dbeafe; border-radius: 16px; padding: 22px; margin-bottom: 25px;">
        <h5 style="color: #1e3a8a; font-weight: 800; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; font-size: 1rem;">
            <i class="fas fa-info-circle text-primary"></i> কীভাবে API Key এবং Channel ID সংগ্রহ করবেন? (সহজ ৩টি ধাপ)
        </h5>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
            <!-- Step 1 -->
            <div class="yt-step-card">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span class="yt-step-num">১</span>
                    <span>YouTube API সক্রিয় করুন</span>
                </div>
                <p style="font-size: 0.83rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    Google Cloud Console-এ গিয়ে ফ্রিতে <strong>YouTube Data API v3</strong> সক্রিয় করুন।
                </p>
                <a href="https://console.cloud.google.com/apis/library/youtube.googleapis.com" target="_blank" rel="noopener noreferrer" style="font-size: 0.83rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    সরাসরি API পেজে যান <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i>
                </a>
            </div>

            <!-- Step 2 -->
            <div class="yt-step-card">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span class="yt-step-num">২</span>
                    <span>API Key তৈরি করুন</span>
                </div>
                <p style="font-size: 0.83rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    <strong>Credentials</strong> পেজে গিয়ে <strong>+ Create Credentials > API Key</strong>-তে ক্লিক করে Key-টি কপি করুন।
                </p>
                <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener noreferrer" style="font-size: 0.83rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    Credentials পেজে যান <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i>
                </a>
            </div>

            <!-- Step 3 -->
            <div class="yt-step-card">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #ff0000; margin-bottom: 8px;">
                    <span class="yt-step-num">৩</span>
                    <span>Channel ID কপি করুন</span>
                </div>
                <p style="font-size: 0.83rem; color: #64748b; line-height: 1.5; margin-bottom: 10px;">
                    YouTube Advanced Settings-এ গিয়ে আপনার <strong>Channel ID</strong> (যা <code>UC...</code> দিয়ে শুরু) কপি করে নিন।
                </p>
                <a href="https://www.youtube.com/account_advanced" target="_blank" rel="noopener noreferrer" style="font-size: 0.83rem; font-weight: 700; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    Advanced Settings-এ যান <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Automated Settings Form (Only Essential Fields) -->
    <form action="<?= URLROOT ?>/admin/youtube" method="POST" id="yt-settings-form">
        <?= csrf_field() ?>
        
        <!-- Field 1: YouTube API Key -->
        <div class="yt-field-group">
            <label for="field_api_key">
                <i class="fas fa-key text-warning"></i> YouTube Data API v3 Key <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="field_api_key" name="settings[youtube_api_key]" value="<?= htmlspecialchars($settings['youtube_api_key'] ?? '') ?>" class="form-control" placeholder="যেমন: AIzaSyBgAbCdEf123456..." style="font-family: monospace; font-size: 0.95rem;" required>
            <small>গুগল ক্লাউড থেকে প্রাপ্ত ফ্রি API Key দিন। এটি অটোমেটিক লাইভ ডিটেকশন ও নিয়মিত ভিডিও সিঙ্ক করার জন্য প্রয়োজন।</small>
        </div>

        <!-- Field 2: Channel ID / Handle -->
        <div class="yt-field-group">
            <label for="field_channel_id">
                <i class="fab fa-youtube text-danger"></i> YouTube Channel ID অথবা Handle (@হ্যান্ডেল) <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="field_channel_id" name="settings[youtube_channel_id]" value="<?= htmlspecialchars($settings['youtube_channel_id'] ?? '') ?>" class="form-control" placeholder="যেমন: UCxxxxxxxxxxxxxxxxxxxxxx অথবা @YourChannelHandle" required>
            <small>আপনার চ্যানেলের আইডি (UC... দিয়ে শুরু) অথবা হ্যান্ডেল (@নাম) দিন।</small>
        </div>

        <!-- Field 3: Channel URL for Buttons -->
        <div class="yt-field-group">
            <label for="field_channel_url">
                <i class="fas fa-link text-primary"></i> YouTube Channel URL (চ্যানেল লিংক)
            </label>
            <input type="text" id="field_channel_url" name="settings[youtube_channel_url]" value="<?= htmlspecialchars($settings['youtube_channel_url'] ?? '') ?>" class="form-control" placeholder="যেমন: https://www.youtube.com/@YourChannel">
            <small>হোমপেজের ভিডিও সেকশনে "ইউটিউবে দেখুন" বাটনটি ভিজিটরদের এই লিংকে নিয়ে যাবে।</small>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="margin-top: 15px; height: 50px; background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border: none; font-size: 1.05rem; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(255,0,0,0.25);">
            <i class="fas fa-save me-2"></i> সেটিংস সংরক্ষণ করুন (Save YouTube Settings)
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnTestLive = document.getElementById('btn-test-live');
    const btnSyncVideos = document.getElementById('btn-sync-videos');
    const resultBox = document.getElementById('action-result-box');

    function showResult(html, isSuccess = true) {
        resultBox.style.display = 'block';
        if (isSuccess) {
            resultBox.style.background = '#dcfce7';
            resultBox.style.borderLeft = '5px solid #16a34a';
            resultBox.style.color = '#15803d';
        } else {
            resultBox.style.background = '#fef2f2';
            resultBox.style.borderLeft = '5px solid #dc2626';
            resultBox.style.color = '#991b1b';
        }
        resultBox.innerHTML = html;
        resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    async function parseSafeResponse(res) {
        const text = await res.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Non-JSON server response:', text);
            return {
                success: false,
                error: 'সার্ভার থেকে সঠিক ফরম্যাটে রেসপন্স আসেনি। অনুগ্রহ করে পুনরায় লগইন করে চেষ্টা করুন।'
            };
        }
    }

    // 1. AJAX Test Live Status
    if (btnTestLive) {
        btnTestLive.addEventListener('click', async function() {
            const apiKey = document.getElementById('field_api_key').value.trim();
            const channelId = document.getElementById('field_channel_id').value.trim();

            if (!apiKey || !channelId) {
                showResult('<strong>❌ তথ্য অনুপস্থিত:</strong> অনুগ্রহ করে আগে YouTube API Key এবং Channel ID ফিল্ড পূরণ করুন।', false);
                return;
            }

            btnTestLive.disabled = true;
            const originalHtml = btnTestLive.innerHTML;
            btnTestLive.innerHTML = '<i class="fas fa-spinner fa-spin"></i> লাইভ চেক করা হচ্ছে...';

            const formData = new FormData();
            formData.append('api_key', apiKey);
            formData.append('channel_id', channelId);

            try {
                const res = await fetch('<?= URLROOT ?>/admin/test_yt_live_ajax', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await parseSafeResponse(res);
                btnTestLive.disabled = false;
                btnTestLive.innerHTML = originalHtml;

                if (data.is_live) {
                    showResult(`
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <span style="display: inline-block; width: 14px; height: 14px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 10px #ef4444; animation: pulseRed 1.5s infinite;"></span>
                            <div>
                                <strong style="font-size: 1.05rem;">🔴 এই মুহূর্তে চ্যানেলটি লাইভে আছে!</strong><br>
                                <span>ভিডিও টাইটেল: <strong>${data.title || 'লাইভ স্ট্রিম'}</strong> (ID: <code>${data.video_id}</code>)</span><br>
                                <a href="https://www.youtube.com/watch?v=${data.video_id}" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: underline; margin-top: 5px; display: inline-block;">লাইভ স্ট্রিম ওপেন করুন <i class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                    `, true);
                } else if (data.success) {
                    showResult(`
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <i class="fas fa-video-slash" style="font-size: 1.5rem; color: #64748b;"></i>
                            <div>
                                <strong style="font-size: 1rem; color: #334155;">⚪ বর্তমানে চ্যানেলে কোনো লাইভ সম্প্রচার চলছে না।</strong><br>
                                <span style="font-size: 0.85rem; color: #64748b;">চ্যানেল ও API সংযোগ সম্পূর্ণ সঠিক রয়েছে। চ্যানেলে লাইভ শুরু হওয়া মাত্রই সিস্টেম স্বয়ংক্রিয়ভাবে ডিটেক্ট করবে।</span>
                            </div>
                        </div>
                    `, true);
                } else {
                    showResult(`<strong>❌ ত্রুটি:</strong> ${data.error || 'লাইভ চেক ব্যর্থ হয়েছে। API Key বা Channel ID সঠিক কি না যাচাই করুন।'}`, false);
                }
            } catch (err) {
                btnTestLive.disabled = false;
                btnTestLive.innerHTML = originalHtml;
                showResult('<strong>❌ সার্ভার কানেকশন ত্রুটি:</strong> ' + err.message, false);
            }
        });
    }

    // 2. AJAX Sync Videos
    if (btnSyncVideos) {
        btnSyncVideos.addEventListener('click', async function() {
            const apiKey = document.getElementById('field_api_key').value.trim();
            const channelId = document.getElementById('field_channel_id').value.trim();

            if (!apiKey || !channelId) {
                showResult('<strong>❌ তথ্য অনুপস্থিত:</strong> অনুগ্রহ করে আগে YouTube API Key এবং Channel ID ফিল্ড পূরণ করুন।', false);
                return;
            }

            btnSyncVideos.disabled = true;
            const originalHtml = btnSyncVideos.innerHTML;
            btnSyncVideos.innerHTML = '<i class="fas fa-spinner fa-spin"></i> সিঙ্ক হচ্ছে...';

            const formData = new FormData();
            formData.append('api_key', apiKey);
            formData.append('channel_id', channelId);

            try {
                const res = await fetch('<?= URLROOT ?>/admin/sync_yt_videos_ajax', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await parseSafeResponse(res);
                btnSyncVideos.disabled = false;
                btnSyncVideos.innerHTML = originalHtml;

                if (data.success) {
                    showResult(`
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <i class="fas fa-check-circle" style="font-size: 1.6rem; color: #059669;"></i>
                            <div>
                                <strong style="font-size: 1.05rem;">${data.message}</strong><br>
                                <span style="font-size: 0.88rem;">চ্যানেল থেকে লেটেস্ট মোট ${data.total || 0}টি ভিডিও প্রসেস করা হয়েছে। <a href="<?= URLROOT ?>/admin/yt_videos" style="color: #0b7c4d; font-weight: 700; text-decoration: underline;">"All YouTube Video"</a> পেজে এগুলো দেখতে পাবেন।</span>
                            </div>
                        </div>
                    `, true);
                } else {
                    showResult(`<strong>❌ সিঙ্ক ত্রুটি:</strong> ${data.error || 'ভিডিও সিঙ্ক ব্যর্থ হয়েছে। API Key বা Channel ID সঠিক কি না যাচাই করুন।'}`, false);
                }
            } catch (err) {
                btnSyncVideos.disabled = false;
                btnSyncVideos.innerHTML = originalHtml;
                showResult('<strong>❌ সার্ভার কানেকশন ত্রুটি:</strong> ' + err.message, false);
            }
        });
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
