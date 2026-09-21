<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Media Management</h1>
        <p>Manage, upload, search, and delete your website assets</p>
    </div>
    <div class="header-actions" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <form action="<?= URLROOT ?>/admin/media" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" value="<?= htmlspecialchars($data['search'] ?? '') ?>" placeholder="Search files..." class="form-control" style="padding: 8px 14px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem;">
            <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; border-radius: 8px;"><i class="fas fa-search"></i> Search</button>
            <?php if (!empty($data['search'])): ?>
                <a href="<?= URLROOT ?>/admin/media" class="btn btn-light" style="padding: 8px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center;">Reset</a>
            <?php endif; ?>
        </form>
        <button class="btn btn-primary" onclick="toggleUploadZone()">
            <i class="fas fa-upload"></i> Upload Asset
        </button>
    </div>
</div>

<?php if (isset($_SESSION['media_error']) || !empty($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fdf2f2; color: #dc2626; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 500;">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['media_error'] ?? $data['error']) ?>
        <?php unset($_SESSION['media_error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['media_success']) || !empty($data['success'])): ?>
    <div class="alert alert-success" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 500;">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['media_success'] ?? $data['success']) ?>
        <?php unset($_SESSION['media_success']); ?>
    </div>
<?php endif; ?>

<!-- Drag & Drop Upload Zone (Hidden by default or toggled) -->
<div id="dropzoneContainer" style="display: none; background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-bottom: 25px; border: 2px dashed var(--primary, #0284c7);">
    <div style="text-align: center;">
        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: var(--primary, #0284c7); margin-bottom: 15px;"></i>
        <h4 style="margin: 0 0 10px 0; color: #1e293b;">Drag & Drop File Here to Upload</h4>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">Supports JPG, PNG, WEBP, GIF, SVG, PDF up to maximum server upload size.</p>
        
        <form id="uploadForm" action="<?= URLROOT ?>/admin/media" method="POST" enctype="multipart/form-data">
            <input type="file" name="media_file" id="uploadInput" style="display: none;" onchange="previewFile(this)">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('uploadInput').click()" style="padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-folder-open"></i> Browse File
            </button>
            
            <div id="uploadPreview" style="display: none; margin-top: 20px; align-items: center; justify-content: center; gap: 15px; flex-direction: column;">
                <img id="previewImg" src="" style="max-height: 120px; border-radius: 10px; border: 1px solid #e2e8f0; object-fit: contain;">
                <span id="previewName" style="font-weight: 600; color: #334155;"></span>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Confirm & Upload</button>
                    <button type="button" class="btn btn-light" onclick="cancelUpload()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="media-container">
    <div class="media-grid">
        <?php if (!empty($data['files'])): ?>
            <?php foreach ($data['files'] as $file): ?>
            <?php 
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']);
            ?>
            <div class="media-card">
                <div class="media-preview">
                    <?php if ($isImage): ?>
                        <img src="<?=$file['url']?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($file['name']) ?>">
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--primary); padding: 15px;">
                            <i class="fas fa-file-pdf" style="font-size: 40px;"></i>
                            <span style="font-size: 0.75rem; margin-top: 5px; font-weight: 600; text-transform: uppercase;"><?= $ext ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="media-overlay">
                        <button class="btn-icon" onclick="copyPath('<?= $file['url'] ?>')" title="Copy Link"><i class="fas fa-link"></i></button>
                        <a href="<?= $file['url'] ?>" target="_blank" class="btn-icon" title="View Full"><i class="fas fa-eye"></i></a>
                        <form action="<?= URLROOT ?>/admin/delete_media" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this media file?')">
                            <input type="hidden" name="file_path" value="<?= htmlspecialchars($file['path']) ?>">
                            <button type="submit" class="btn-icon delete" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="media-details">
                    <span class="file-name" title="<?= htmlspecialchars($file['name']) ?>"><?= htmlspecialchars($file['name']) ?></span>
                    <span class="file-size"><?= $file['size'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #94a3b8;">
                <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 15px;"></i>
                <p>No media files found matching your search criteria.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($data['total_pages'] > 1): ?>
    <?php $searchQuery = !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?>
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <?= count($data['files']) ?> of <?= $data['total_files'] ?> assets
        </div>
        <div class="pagination-links">
            <?php if ($data['page'] > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] - 1 ?><?= $searchQuery ?>" class="pagination-btn"><i class="fas fa-chevron-left"></i> Previous</a>
            <?php endif; ?>

            <?php
            $start_page = max(1, $data['page'] - 2);
            $end_page = min($data['total_pages'], $data['page'] + 2);
            
            if ($start_page > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=1<?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == 1 ? 'active' : '' ?>">1</a>
                <?php if ($start_page > 2): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $i ?><?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($end_page < $data['total_pages']): ?>
                <?php if ($end_page < $data['total_pages'] - 1): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['total_pages'] ?><?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == $data['total_pages'] ? 'active' : '' ?>"><?= $data['total_pages'] ?></a>
            <?php endif; ?>

            <?php if ($data['page'] < $data['total_pages']): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] + 1 ?><?= $searchQuery ?>" class="pagination-btn">Next <i class="fas fa-chevron-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .media-container { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .media-card {
        background: #fff;
        border: 1.5px solid #eee;
        border-radius: 15px;
        overflow: hidden;
        transition: 0.3s;
    }

    .media-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-color: var(--primary); }

    .media-preview {
        height: 160px;
        position: relative;
        overflow: hidden;
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .media-preview img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .media-card:hover .media-preview img { transform: scale(1.1); }

    .media-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 107, 67, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        opacity: 0;
        transition: 0.3s;
    }

    .media-card:hover .media-overlay { opacity: 1; }

    .btn-icon {
        background: white;
        color: var(--primary);
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-icon:hover { background: var(--gold, #f59e0b); color: white; transform: scale(1.1); }
    .btn-icon.delete:hover { background: #ef4444; color: white; }

    .media-details { padding: 12px; display: flex; flex-direction: column; gap: 5px; }
    .file-name { font-size: 0.85rem; font-weight: 600; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .file-size { font-size: 0.75rem; color: #888; }
    
    .btn-primary {
        background: var(--primary);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1.5px solid #eee;
        flex-wrap: wrap;
        gap: 15px;
    }
    .pagination-info { font-size: 0.9rem; color: #64748b; font-weight: 500; }
    .pagination-links { display: flex; gap: 8px; align-items: center; }
    .pagination-btn {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #334155;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .pagination-btn:hover { border-color: var(--primary); color: var(--primary); background: #f0fdf4; }
    .pagination-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    .pagination-ellipsis { color: #94a3b8; padding: 0 4px; }
</style>

<script>
function toggleUploadZone() {
    const zone = document.getElementById('dropzoneContainer');
    zone.style.display = (zone.style.display === 'none' || zone.style.display === '') ? 'block' : 'none';
}

function previewFile(input) {
    const file = input.files[0];
    if (file) {
        document.getElementById('previewName').innerText = file.name + ' (' + Math.round(file.size/1024) + ' KB)';
        document.getElementById('uploadPreview').style.display = 'flex';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('previewImg').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('previewImg').style.display = 'none';
        }
    }
}

function cancelUpload() {
    document.getElementById('uploadInput').value = '';
    document.getElementById('uploadPreview').style.display = 'none';
}

function copyPath(path) {
    navigator.clipboard.writeText(path).then(() => {
        alert('Asset URL copied to clipboard!');
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

