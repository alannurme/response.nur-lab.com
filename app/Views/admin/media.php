<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Media Management</h1>
        <p>Manage, upload, and delete your website assets</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="document.getElementById('uploadInput').click()">
            <i class="fas fa-upload"></i> Upload New Media
        </button>
        <form id="uploadForm" action="<?= URLROOT ?>/admin/media" method="POST" enctype="multipart/form-data" style="display: none;">
            <input type="file" name="media_file" id="uploadInput" onchange="document.getElementById('uploadForm').submit()">
        </form>
    </div>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success"><?= $data['success'] ?></div>
<?php endif; ?>

<div class="media-container">
    <div class="media-grid">
        <?php foreach ($data['files'] as $file): ?>
        <div class="media-card">
            <div class="media-preview">
                <img src="<?=$file['url']?>" loading="lazy" decoding="async" alt="<?= $file['name'] ?>">
                <div class="media-overlay">
                    <button class="btn-icon" onclick="copyPath('<?= $file['url'] ?>')" title="Copy Link"><i class="fas fa-link"></i></button>
                    <a href="<?= $file['url'] ?>" target="_blank" class="btn-icon" title="View Full"><i class="fas fa-eye"></i></a>
                    <form action="<?= URLROOT ?>/admin/delete_media" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this image?')">
                        <input type="hidden" name="file_path" value="<?= $file['path'] ?>">
                        <button type="submit" class="btn-icon delete" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <div class="media-details">
                <span class="file-name"><?= $file['name'] ?></span>
                <span class="file-size"><?= $file['size'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($data['total_pages'] > 1): ?>
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <?= count($data['files']) ?> of <?= $data['total_files'] ?> assets
        </div>
        <div class="pagination-links">
            <?php if ($data['page'] > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] - 1 ?>" class="pagination-btn"><i class="fas fa-chevron-left"></i> Previous</a>
            <?php endif; ?>

            <?php
            $start_page = max(1, $data['page'] - 2);
            $end_page = min($data['total_pages'], $data['page'] + 2);
            
            if ($start_page > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=1" class="pagination-btn <?= $data['page'] == 1 ? 'active' : '' ?>">1</a>
                <?php if ($start_page > 2): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $i ?>" class="pagination-btn <?= $data['page'] == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($end_page < $data['total_pages']): ?>
                <?php if ($end_page < $data['total_pages'] - 1): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['total_pages'] ?>" class="pagination-btn <?= $data['page'] == $data['total_pages'] ? 'active' : '' ?>"><?= $data['total_pages'] ?></a>
            <?php endif; ?>

            <?php if ($data['page'] < $data['total_pages']): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] + 1 ?>" class="pagination-btn">Next <i class="fas fa-chevron-right"></i></a>
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

    .btn-icon:hover { background: var(--gold); color: white; transform: scale(1.1); }
    .btn-icon.delete:hover { background: #ef4444; color: white; }

    .media-details { padding: 12px; display: flex; flex-direction: column; gap: 5px; }
    .file-name { font-size: 0.85rem; font-weight: 600; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .file-size { font-size: 0.75rem; color: #888; }

    .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    
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
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }

    /* Pagination Styles */
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
    .pagination-info {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }
    .pagination-links {
        display: flex;
        gap: 8px;
        align-items: center;
    }
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
    .pagination-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #f0fdf4;
    }
    .pagination-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .pagination-ellipsis {
        color: #94a3b8;
        padding: 0 4px;
    }

    @media (max-width: 576px) {
        .media-container { padding: 15px; }
        .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 10px;
        }
        .media-preview {
            height: 110px;
        }
        .media-overlay {
            gap: 8px;
        }
        .btn-icon {
            width: 30px;
            height: 30px;
        }
        .pagination-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .pagination-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
    }
</style>

<script>
function copyPath(path) {
    navigator.clipboard.writeText(path).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
