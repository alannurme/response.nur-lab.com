<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="d-flex align-items-center mb-5">
        <div style="width: 50px; height: 50px; background: #ff0000; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 20px;">
            <i class="fab fa-youtube"></i>
        </div>
        <h3 class="m-0">YouTube Live & Video Notification</h3>
    </div>

    <?php if (isset($data['success'])): ?>
        <div class="alert alert-success mb-4"><?= $data['success'] ?></div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/admin/youtube" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Notification Status</label>
                <select name="settings[youtube_status]" class="form-control">
                    <option value="active" <?= ($data['settings']['youtube_status'] ?? '') == 'active' ? 'selected' : '' ?>>Active (Show Player)</option>
                    <option value="inactive" <?= ($data['settings']['youtube_status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive (Hide Player)</option>
                </select>
                <small style="color: #64748b;">এটি Active থাকলে হোমপেজে ভিডিও প্লেয়ারটি দেখা যাবে।</small>
            </div>

            <div class="form-group full-width">
                <label>Notification Title</label>
                <input type="text" name="settings[youtube_title]" value="<?= $data['settings']['youtube_title'] ?? 'আমরা এখন লাইভে আছি!' ?>" class="form-control" placeholder="যেমন: সরাসরি সম্প্রচার দেখুন">
            </div>

            <div class="form-group">
                <label>YouTube Video/Live ID</label>
                <input type="text" name="settings[youtube_video_id]" value="<?= $data['settings']['youtube_video_id'] ?? '' ?>" class="form-control" placeholder="e.g. jA1HDe03P-k">
                <small style="color: #64748b;">ভিডিওর URL থেকে আইডিটি কপি করে এখানে দিন।</small>
            </div>

            <div class="form-group">
                <label>YouTube Channel ID</label>
                <input type="text" name="settings[youtube_channel_id]" value="<?= $data['settings']['youtube_channel_id'] ?? '' ?>" class="form-control" placeholder="UCxxxxxxxxxxxxxx">
                <small style="color: #64748b; margin-top: 5px; display: block;">
                    আইডিটি পেতে: আপনার ইউটিউব চ্যানেলে যান &gt; Settings &gt; Advanced Settings-এ গিয়ে <strong>Channel ID</strong> (যা UC দিয়ে শুরু হয়) কপি করে এখানে দিন। অথবা <a href="https://www.youtube.com/account_advanced" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: none;">এখানে ক্লিক করে সরাসরি (YouTube Advanced Settings)</a> আইডিটি খুঁজে নিতে পারেন।
                </small>
            </div>

            <div class="form-group full-width">
                <label>YouTube Channel URL (For Buttons)</label>
                <input type="text" name="settings[youtube_channel_url]" value="<?= $data['settings']['youtube_channel_url'] ?? '' ?>" class="form-control" placeholder="https://www.youtube.com/@YourChannel">
                <small style="color: #64748b;">হোমপেজের "ইউটিউবে দেখুন" বাটনটি এই লিংকে যাবে।</small>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-top: 30px; border-left: 5px solid #ff0000;">
            <p style="margin: 0; font-size: 0.9rem; color: #1e293b;">
                <strong>কিভাবে কাজ করে?</strong><br>
                আপনি যখন লাইভ করবেন বা নতুন ভিডিও আপলোড করবেন, তখন ওই ভিডিওর <strong>ID</strong> টি এখানে দিয়ে সেভ করলেই হোমপেজে সেটি একটি ফ্লোটিং উইজেট হিসেবে প্রদর্শিত হবে।
            </p>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="margin-top: 30px; background: #ff0000; border: none;">Save YouTube Settings</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
