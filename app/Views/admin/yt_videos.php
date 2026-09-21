<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="text-premium-glow">All YouTube Videos</h1>
        <p>Manage your uploaded YouTube videos and their categories</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_yt_video" class="btn btn-save">
        <i class="fas fa-plus-circle"></i> Add New Video
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Video ID</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['videos'] as $video): ?>
                <tr>
                    <td>
                        <div class="video-thumb-container">
                            <img src="https://img.youtube.com/vi/<?=$video['video_id']?>/default.jpg" loading="lazy" decoding="async" alt="Thumb" class="video-thumb">
                            <a href="<?= $video['video_url'] ?>" target="_blank" class="play-overlay"><i class="fas fa-play"></i></a>
                        </div>
                    </td>
                    <td class="fw-bold"><?= $video['title'] ?></td>
                    <td><span class="badge bg-soft-success"><?= $video['category_name'] ?? 'Uncategorized' ?></span></td>
                    <td><code><?= $video['video_id'] ?></code></td>
                    <td class="text-muted small"><?= date('M d, Y', strtotime($video['created_at'])) ?></td>
                    <td class="text-end">
                        <div class="table-actions">
                            <a href="<?= URLROOT ?>/admin/delete_yt_video/<?= $video['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this video?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['videos'])): ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fab fa-youtube fa-3x mb-3 text-muted"></i>
                            <p class="text-muted">No YouTube videos found. Add your first video now!</p>
                            <a href="<?= URLROOT ?>/admin/add_yt_video" class="btn btn-primary mt-2">Add Video</a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .video-thumb-container {
        position: relative;
        width: 100px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .video-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .play-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: 0.3s;
    }
    .video-thumb-container:hover .play-overlay { opacity: 1; }
    
    .badge.bg-soft-success {
        background: #eff6ff;
        color: #2563eb;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
    }
</style>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
