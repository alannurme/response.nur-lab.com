<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php
$activeTab = $data['active_tab'] ?? 'local';
$googleDrives = $data['google_drives'] ?? [];
$selectedDriveId = $data['selected_drive_id'] ?? '';
$searchVal = $data['search'] ?? '';
$searchQuery = !empty($searchVal) ? '&search=' . urlencode($searchVal) : '';
$tabQuery = '&tab=' . urlencode($activeTab);
$driveQuery = ($activeTab === 'google_drive' && !empty($selectedDriveId)) ? '&drive_id=' . urlencode($selectedDriveId) : '';
?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="font-family: 'Hind Siliguri', sans-serif; font-size: 1.8rem; margin: 0 0 6px;">
            <i class="fas fa-photo-video" style="color: var(--primary);"></i> Media Management
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
            লোকাল সার্ভার ও গুগল ড্রাইভ ক্লাউড স্টোরেজের ছবি ও ফাইলসমূহ পরিচালনা করুন
        </p>
    </div>
    <div class="header-actions" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <form action="<?= URLROOT ?>/admin/media" method="GET" style="display: flex; gap: 8px;">
            <input type="hidden" name="tab" value="<?= htmlspecialchars($activeTab) ?>">
            <?php if ($activeTab === 'google_drive' && !empty($selectedDriveId)): ?>
                <input type="hidden" name="drive_id" value="<?= htmlspecialchars($selectedDriveId) ?>">
            <?php endif; ?>
            <input type="text" name="search" value="<?= htmlspecialchars($searchVal) ?>" placeholder="Search in <?= $activeTab === 'google_drive' ? 'Google Drive' : 'Local Host' ?>..." class="form-control" style="padding: 8px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; outline: none; font-size: 0.9rem; min-width: 200px;">
            <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; border-radius: 8px;"><i class="fas fa-search"></i> Search</button>
            <?php if (!empty($searchVal)): ?>
                <a href="<?= URLROOT ?>/admin/media?tab=<?= $activeTab ?><?= $driveQuery ?>" class="btn btn-light" style="padding: 8px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center;">Reset</a>
            <?php endif; ?>
        </form>
        <button class="btn btn-primary" onclick="toggleUploadZone()" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 10px; font-weight: 700;">
            <i class="fas fa-upload"></i> Upload Asset
        </button>
    </div>
</div>

<!-- Storage Switcher Tabs (Local Host vs Google Drive) -->
<div class="storage-tabs-bar" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px;">
    <div style="display: flex; gap: 10px; align-items: center;">
        <!-- Tab 1: Local Host -->
        <a href="<?= URLROOT ?>/admin/media?tab=local<?= $searchQuery ?>" class="storage-tab-btn <?= $activeTab === 'local' ? 'active' : '' ?>">
            <i class="fas fa-server"></i>
            <span>Local Host (লোকাল সার্ভার)</span>
            <?php if ($activeTab === 'local'): ?>
                <span class="tab-badge"><?= $data['total_files'] ?></span>
            <?php endif; ?>
        </a>

        <!-- Tab 2: Google Drive -->
        <a href="<?= URLROOT ?>/admin/media?tab=google_drive<?= $searchQuery ?>" class="storage-tab-btn <?= $activeTab === 'google_drive' ? 'active' : '' ?>">
            <i class="fab fa-google-drive" style="color: #0f9d58;"></i>
            <span>Google Drive (গুগল ড্রাইভ)</span>
            <?php if ($activeTab === 'google_drive'): ?>
                <span class="tab-badge" style="background: #0f9d58;"><?= $data['total_files'] ?></span>
            <?php endif; ?>
        </a>
    </div>

    <!-- Google Drive Account Selector (When Google Drive tab is active) -->
    <?php if ($activeTab === 'google_drive' && !empty($googleDrives)): ?>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 0.88rem; font-weight: 700; color: #475569; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-layer-group" style="color: #0f9d58;"></i> ড্রাইভ নির্বাচন:
            </span>
            <select onchange="location.href='<?= URLROOT ?>/admin/media?tab=google_drive&drive_id=' + encodeURIComponent(this.value) + '<?= $searchQuery ?>'" style="padding: 8px 14px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-weight: 600; color: #1e293b; background: white; outline: none; cursor: pointer;">
                <?php foreach ($googleDrives as $gd): ?>
                    <option value="<?= htmlspecialchars($gd['id'] ?? '') ?>" <?= ($gd['id'] ?? '') === $selectedDriveId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($gd['name'] ?? 'Google Drive') ?> <?= !empty($gd['is_default']) ? '⭐ (Default)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a href="<?= URLROOT ?>/admin/storage_settings" target="_blank" title="ড্রাইভ সেটিংস পরিচালনা করুন" style="color: #0f9d58; font-size: 1.1rem; text-decoration: none; padding: 4px 8px;">
                <i class="fas fa-cog"></i>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['media_error']) || !empty($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fdf2f2; color: #dc2626; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['media_error'] ?? $data['error']) ?>
        <?php unset($_SESSION['media_error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['media_success']) || !empty($data['success'])): ?>
    <div class="alert alert-success" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['media_success'] ?? $data['success']) ?>
        <?php unset($_SESSION['media_success']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($data['gdrive_error'])): ?>
    <div class="alert alert-warning" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div>
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($data['gdrive_error']) ?>
        </div>
        <a href="<?= URLROOT ?>/admin/storage_settings" class="btn" style="background: #f59e0b; color: white; padding: 6px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none;">
            <i class="fas fa-sliders-h"></i> গুগল ড্রাইভ সেটিংস খুলুন
        </a>
    </div>
<?php endif; ?>

<!-- Drag & Drop Upload Zone (Supports both Local and Google Drive upload) -->
<div id="dropzoneContainer" style="display: none; background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-bottom: 25px; border: 2px dashed <?= $activeTab === 'google_drive' ? '#0f9d58' : 'var(--primary, #0284c7)' ?>;">
    <div style="text-align: center;">
        <i class="<?= $activeTab === 'google_drive' ? 'fab fa-google-drive' : 'fas fa-cloud-upload-alt' ?>" style="font-size: 48px; color: <?= $activeTab === 'google_drive' ? '#0f9d58' : 'var(--primary, #0284c7)' ?>; margin-bottom: 15px;"></i>
        <h4 style="margin: 0 0 10px 0; color: #1e293b;">
            Drag & Drop File Here to Upload (<?= $activeTab === 'google_drive' ? 'Upload to Google Drive' : 'Upload to Local Host' ?>)
        </h4>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">Supports JPG, PNG, WEBP, GIF, SVG, PDF up to maximum upload size.</p>
        
        <form id="uploadForm" action="<?= URLROOT ?>/admin/media?tab=<?= $activeTab ?><?= $driveQuery ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="upload_destination" value="<?= $activeTab === 'google_drive' ? 'google_drive' : 'local' ?>">
            <?php if ($activeTab === 'google_drive' && !empty($selectedDriveId)): ?>
                <input type="hidden" name="target_drive_id" value="<?= htmlspecialchars($selectedDriveId) ?>">
            <?php endif; ?>

            <input type="file" name="media_file" id="uploadInput" style="display: none;" onchange="previewFile(this)">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('uploadInput').click()" style="padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-folder-open"></i> Browse File
            </button>
            
            <div id="uploadPreview" style="display: none; margin-top: 20px; align-items: center; justify-content: center; gap: 15px; flex-direction: column;">
                <img id="previewImg" src="" style="max-height: 120px; border-radius: 10px; border: 1px solid #e2e8f0; object-fit: contain;">
                <span id="previewName" style="font-weight: 600; color: #334155;"></span>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 24px; background: <?= $activeTab === 'google_drive' ? '#0f9d58' : 'var(--primary)' ?>;">
                        <i class="fas fa-cloud-upload-alt"></i> Confirm & Upload to <?= $activeTab === 'google_drive' ? 'Google Drive' : 'Local Host' ?>
                    </button>
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
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']) || (isset($file['mimeType']) && strpos($file['mimeType'], 'image/') === 0);
                $isGdrive = ($activeTab === 'google_drive') || (($file['storage'] ?? '') === 'google_drive');
            ?>
            <div class="media-card">
                <div class="media-preview">
                    <!-- Source Storage Badge -->
                    <span class="source-badge <?= $isGdrive ? 'badge-gdrive' : 'badge-local' ?>" title="<?= $isGdrive ? 'Google Drive Cloud Asset' : 'Local Server Asset' ?>">
                        <?php if ($isGdrive): ?>
                            <i class="fab fa-google-drive"></i> G-Drive
                        <?php else: ?>
                            <i class="fas fa-server"></i> Local
                        <?php endif; ?>
                    </span>

                    <?php if ($isImage): ?>
                        <img src="<?= htmlspecialchars($file['url']) ?>" loading="lazy" decoding="async" alt="<?= htmlspecialchars($file['name']) ?>" onerror="this.onerror=null; this.src='<?= htmlspecialchars($file['thumbnail'] ?? ($file['export_url'] ?? '')) ?>';">
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--primary); padding: 15px;">
                            <i class="<?= ($ext === 'pdf' || (isset($file['mimeType']) && strpos($file['mimeType'], 'pdf') !== false)) ? 'fas fa-file-pdf' : 'fas fa-file' ?>" style="font-size: 40px; color: <?= $isGdrive ? '#0f9d58' : 'var(--primary)' ?>;"></i>
                            <span style="font-size: 0.75rem; margin-top: 5px; font-weight: 700; text-transform: uppercase; color: #475569;"><?= $ext ?: 'FILE' ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="media-overlay">
                        <button type="button" class="btn-icon" onclick="copyPath('<?= htmlspecialchars($file['url']) ?>')" title="Copy Direct URL"><i class="fas fa-link"></i></button>
                        <a href="<?= htmlspecialchars($file['web_link'] ?? $file['url']) ?>" target="_blank" class="btn-icon" title="View Full"><i class="fas fa-eye"></i></a>
                        
                        <?php if ($isGdrive): ?>
                            <form action="<?= URLROOT ?>/admin/delete_media" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete this file from Google Drive?')">
                                <input type="hidden" name="storage" value="google_drive">
                                <input type="hidden" name="file_id" value="<?= htmlspecialchars($file['id'] ?? '') ?>">
                                <input type="hidden" name="drive_id" value="<?= htmlspecialchars($file['drive_id'] ?? $selectedDriveId) ?>">
                                <button type="submit" class="btn-icon delete" title="Delete from Google Drive"><i class="fas fa-trash"></i></button>
                            </form>
                        <?php else: ?>
                            <form action="<?= URLROOT ?>/admin/delete_media" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this media file from local server?')">
                                <input type="hidden" name="storage" value="local">
                                <input type="hidden" name="file_path" value="<?= htmlspecialchars($file['path'] ?? '') ?>">
                                <button type="submit" class="btn-icon delete" title="Delete from Local Server"><i class="fas fa-trash"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="media-details">
                    <span class="file-name" title="<?= htmlspecialchars($file['name']) ?>"><?= htmlspecialchars($file['name']) ?></span>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                        <span class="file-size"><?= htmlspecialchars($file['size'] ?? '') ?></span>
                        <?php if ($isGdrive && !empty($file['drive_name'])): ?>
                            <span style="font-size: 0.7rem; color: #0f9d58; font-weight: 700;" title="Drive Account">
                                <i class="fab fa-google-drive"></i> <?= htmlspecialchars(mb_substr($file['drive_name'], 0, 12)) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #94a3b8;">
                <i class="<?= $activeTab === 'google_drive' ? 'fab fa-google-drive' : 'fas fa-folder-open' ?>" style="font-size: 52px; margin-bottom: 15px; color: <?= $activeTab === 'google_drive' ? '#0f9d58' : '#94a3b8' ?>; opacity: 0.8;"></i>
                <h3 style="margin: 0 0 8px; color: #475569; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">
                    <?= $activeTab === 'google_drive' ? 'গুগল ড্রাইভে কোনো ফাইল পাওয়া যায়নি' : 'লোকাল সার্ভারে কোনো মিডিয়া ফাইল পাওয়া যায়নি' ?>
                </h3>
                <p style="margin: 0; font-size: 0.9rem;">
                    <?= !empty($searchVal) ? 'আপনার সার্চ করা শব্দের সাথে কোনো ফাইল মেলেনি।' : 'নতুন ফাইল আপলোড করতে উপরের "Upload Asset" বাটনে ক্লিক করুন।' ?>
                </p>
                <?php if ($activeTab === 'google_drive' && empty($googleDrives)): ?>
                    <a href="<?= URLROOT ?>/admin/storage_settings" class="btn btn-primary" style="margin-top: 15px; display: inline-flex; align-items: center; gap: 8px; background: #0f9d58;">
                        <i class="fab fa-google-drive"></i> গুগল ড্রাইভ যুক্ত করুন
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($data['total_pages'] > 1): ?>
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <?= count($data['files']) ?> of <?= $data['total_files'] ?> assets (Page <?= $data['page'] ?> of <?= $data['total_pages'] ?>)
        </div>
        <div class="pagination-links">
            <?php if ($data['page'] > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] - 1 ?><?= $tabQuery ?><?= $driveQuery ?><?= $searchQuery ?>" class="pagination-btn"><i class="fas fa-chevron-left"></i> Previous</a>
            <?php endif; ?>

            <?php
            $start_page = max(1, $data['page'] - 2);
            $end_page = min($data['total_pages'], $data['page'] + 2);
            
            if ($start_page > 1): ?>
                <a href="<?= URLROOT ?>/admin/media?page=1<?= $tabQuery ?><?= $driveQuery ?><?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == 1 ? 'active' : '' ?>">1</a>
                <?php if ($start_page > 2): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $i ?><?= $tabQuery ?><?= $driveQuery ?><?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($end_page < $data['total_pages']): ?>
                <?php if ($end_page < $data['total_pages'] - 1): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['total_pages'] ?><?= $tabQuery ?><?= $driveQuery ?><?= $searchQuery ?>" class="pagination-btn <?= $data['page'] == $data['total_pages'] ? 'active' : '' ?>"><?= $data['total_pages'] ?></a>
            <?php endif; ?>

            <?php if ($data['page'] < $data['total_pages']): ?>
                <a href="<?= URLROOT ?>/admin/media?page=<?= $data['page'] + 1 ?><?= $tabQuery ?><?= $driveQuery ?><?= $searchQuery ?>" class="pagination-btn">Next <i class="fas fa-chevron-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .storage-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        color: #64748b;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .storage-tab-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }
    .storage-tab-btn.active {
        background: white;
        color: #0f172a;
        border-color: var(--primary, #0284c7);
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
    .storage-tab-btn.active i.fa-server {
        color: var(--primary, #0284c7);
    }
    .tab-badge {
        font-size: 0.78rem;
        background: var(--primary, #0284c7);
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-weight: 800;
    }
    .source-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        backdrop-filter: blur(4px);
    }
    .badge-gdrive {
        background: rgba(15, 157, 88, 0.9);
        color: white;
        box-shadow: 0 2px 6px rgba(15, 157, 88, 0.3);
    }
    .badge-local {
        background: rgba(15, 23, 42, 0.75);
        color: white;
    }

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
        background: rgba(0, 107, 67, 0.82);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        opacity: 0;
        transition: 0.3s;
        z-index: 5;
    }

    .media-card:hover .media-overlay { opacity: 1; }

    .btn-icon {
        background: white;
        color: var(--primary);
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .btn-icon:hover { background: var(--gold, #f59e0b); color: white; transform: scale(1.12); }
    .btn-icon.delete:hover { background: #ef4444; color: white; }

    .media-details { padding: 12px; display: flex; flex-direction: column; gap: 4px; }
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
    if (zone.style.display === 'block') {
        zone.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
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
        alert('Asset URL copied to clipboard: ' + path);
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
