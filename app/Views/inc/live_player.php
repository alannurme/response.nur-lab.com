<?php
/**
 * Universal YouTube Floating Live Mini Screen Widget
 * Automatically detects and displays live stream across all frontend pages.
 */
$ytSettings = $data['settings'] ?? [];
$isServerLive = (($ytSettings['youtube_status'] ?? '') === 'active') && !empty($ytSettings['youtube_video_id']);
$initVideoId = $isServerLive ? htmlspecialchars($ytSettings['youtube_video_id']) : '';
$initTitle = $isServerLive ? htmlspecialchars($ytSettings['youtube_title'] ?? 'আমরা এখন লাইভে আছি!') : 'আমরা এখন লাইভে আছি!';
$initChanUrl = !empty($ytSettings['youtube_channel_url']) 
    ? $ytSettings['youtube_channel_url'] 
    : (!empty($ytSettings['youtube_channel_id']) ? 'https://www.youtube.com/channel/' . $ytSettings['youtube_channel_id'] : 'https://www.youtube.com');
?>

<div id="yt-live-floating-widget" style="display: <?= $isServerLive ? 'block' : 'none' ?>; position: fixed; bottom: 25px; right: 25px; width: 330px; max-width: calc(100vw - 30px); background: #ffffff; border-radius: 16px; box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05); z-index: 99999; overflow: hidden; font-family: 'Hind Siliguri', sans-serif; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s; animation: slideInUpWidget 0.4s ease-out;">
    
    <!-- Header with Pulse Indicator and Close Button -->
    <div style="background: linear-gradient(135deg, #ff0000 0%, #b91c1c 100%); color: #ffffff; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; user-select: none;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span class="yt-live-pulsing-dot"></span>
            <span style="font-weight: 800; font-size: 0.88rem; letter-spacing: 0.5px; text-transform: uppercase;">
                <i class="fab fa-youtube" style="margin-right: 4px;"></i> লাইভ সম্প্রচার
            </span>
        </div>
        <button type="button" onclick="dismissLiveWidget()" title="বন্ধ করুন" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; cursor: pointer; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)';" onmouseout="this.style.background='rgba(255,255,255,0.2)';">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Title Bar -->
    <div style="padding: 8px 12px; background: #0f172a; color: #ffffff;">
        <h4 id="yt-live-widget-title" style="margin: 0; font-size: 0.85rem; font-weight: 600; line-height: 1.35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= $initTitle ?>">
            <?= $initTitle ?>
        </h4>
    </div>

    <!-- 16:9 Video Embed Player -->
    <div style="position: relative; padding-bottom: 56.25%; height: 0; background: #000000;">
        <iframe 
            id="yt-live-widget-iframe"
            src="<?= $isServerLive ? 'https://www.youtube.com/embed/' . $initVideoId . '?autoplay=1&mute=1&rel=0' : 'about:blank' ?>"
            loading="lazy"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen>
        </iframe>
    </div>

    <!-- Footer Controls -->
    <div style="padding: 10px 14px; text-align: center; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
        <a id="yt-live-watch-btn" href="<?= $isServerLive ? 'https://www.youtube.com/watch?v=' . $initVideoId : $initChanUrl ?>" target="_blank" rel="noopener noreferrer" style="color: #ff0000; font-weight: 700; text-decoration: none; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fab fa-youtube"></i> ইউটিউবে দেখুন
        </a>
        <a id="yt-live-channel-btn" href="<?= $initChanUrl ?>" target="_blank" rel="noopener noreferrer" style="background: #ff0000; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
            সাবস্ক্রাইব <i class="fas fa-bell"></i>
        </a>
    </div>
</div>

<style>
.yt-live-pulsing-dot {
    display: inline-block;
    width: 9px;
    height: 9px;
    background: #ffffff;
    border-radius: 50%;
    box-shadow: 0 0 0 rgba(255, 255, 255, 0.8);
    animation: livePulseGlow 1.4s infinite;
}
@keyframes livePulseGlow {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
    70% { transform: scale(1.15); box-shadow: 0 0 0 7px rgba(255, 255, 255, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
}
@keyframes slideInUpWidget {
    from { transform: translateY(120px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
@media (max-width: 600px) {
    #yt-live-floating-widget {
        bottom: 15px !important;
        right: 15px !important;
        width: 300px !important;
    }
}
</style>

<script>
(function() {
    let currentLiveVideoId = '<?= $initVideoId ?>';

    window.dismissLiveWidget = function() {
        const widget = document.getElementById('yt-live-floating-widget');
        if (!widget) return;
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        setTimeout(() => {
            widget.style.display = 'none';
            // Stop video playing by clearing iframe src
            const iframe = document.getElementById('yt-live-widget-iframe');
            if (iframe) iframe.src = 'about:blank';
        }, 300);
        
        // Remember dismissal for this video during current session
        if (currentLiveVideoId) {
            sessionStorage.setItem('dismissed_live_' + currentLiveVideoId, '1');
        }
    };

    function displayLiveWidget(videoId, title, channelUrl) {
        if (!videoId) return;
        
        // Check if user dismissed this specific video in this session
        if (sessionStorage.getItem('dismissed_live_' + videoId) === '1') {
            return;
        }

        currentLiveVideoId = videoId;
        const widget = document.getElementById('yt-live-floating-widget');
        const iframe = document.getElementById('yt-live-widget-iframe');
        const titleElem = document.getElementById('yt-live-widget-title');
        const watchBtn = document.getElementById('yt-live-watch-btn');
        const chanBtn = document.getElementById('yt-live-channel-btn');

        if (!widget || !iframe) return;

        if (title && titleElem) {
            titleElem.textContent = title;
            titleElem.title = title;
        }
        if (watchBtn) {
            watchBtn.href = 'https://www.youtube.com/watch?v=' + videoId;
        }
        if (channelUrl && chanBtn) {
            chanBtn.href = channelUrl;
        }

        const embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&mute=1&rel=0';
        if (iframe.src !== embedUrl) {
            iframe.src = embedUrl;
        }

        widget.style.display = 'block';
        widget.style.opacity = '1';
        widget.style.transform = 'translateY(0)';
    }

    // Auto-check live stream asynchronously on client-side
    async function checkLiveStatusClient() {
        try {
            const res = await fetch('<?= URLROOT ?>/home/check_yt_live_ajax', {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) return;
            const data = await res.json();
            
            if (data && data.is_live && data.video_id) {
                displayLiveWidget(data.video_id, data.title, data.channel_url);
            } else {
                // If offline and server-rendered widget was showing old video, hide it
                if (!data.is_live && !<?= $isServerLive ? 'true' : 'false' ?>) {
                    const widget = document.getElementById('yt-live-floating-widget');
                    if (widget) widget.style.display = 'none';
                }
            }
        } catch (err) {
            console.debug('Live check error:', err);
        }
    }

    // Run client check 1.5 seconds after page loads (non-blocking)
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(checkLiveStatusClient, 1500);
    });
})();
</script>

