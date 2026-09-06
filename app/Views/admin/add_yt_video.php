<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-premium-glow">Add YouTube Video</h1>
            <p>Paste a YouTube URL to automatically extract video details</p>
        </div>
        <a href="<?= URLROOT ?>/admin/yt_videos" class="btn btn-visit-site">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="settings-container" style="max-width: 800px;">
    <form action="<?= URLROOT ?>/admin/add_yt_video" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Video Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter video title" required>
            </div>

            <div class="form-group">
                <label>Video Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($data['categories'] as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Manage categories in the <a href="<?= URLROOT ?>/admin/yt_categories">Category section</a></small>
            </div>

            <div class="form-group">
                <label>YouTube Video URL</label>
                <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                <small class="text-muted">Supports full URLs and short youtu.be links</small>
            </div>

            <div class="form-group full-width">
                <label>Description (Optional)</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Brief details about this video..."></textarea>
            </div>
            
            <div id="video-preview-container" class="form-group full-width" style="display: none;">
                <label>Live Preview</label>
                <div id="yt-preview" class="mt-2" style="border-radius: 15px; overflow: hidden; border: 1px solid #eee;">
                    <!-- Preview will appear here via JS -->
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-save w-100"><i class="fas fa-cloud-upload-alt"></i> Save YouTube Video</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('video_url').addEventListener('input', function(e) {
        const url = e.target.value;
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        
        const previewContainer = document.getElementById('video-preview-container');
        const previewDiv = document.getElementById('yt-preview');
        
        if (match && match[2].length === 11) {
            const videoId = match[2];
            previewContainer.style.display = 'block';
            previewDiv.innerHTML = `<iframe width="100%" height="400" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
