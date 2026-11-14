<?php
$pickerSettings = $data['settings'] ?? ($settings ?? []);
if (empty($pickerSettings)) {
    try {
        $pickerSettings = (new \App\Models\AdminModel())->getSettings();
    } catch (\Throwable $e) {
        $pickerSettings = [];
    }
}
$pickerDefaultStorage = $pickerSettings['storage_provider'] ?? 'local';
$pickerDrives = json_decode($pickerSettings['google_drives'] ?? '[]', true) ?: [];
?>
<!-- Media Picker Modal -->
<div id="mediaPickerModal" class="modal">
    <div class="modal-content media-picker-content">
        <div class="modal-header">
            <h3><i class="fas fa-images"></i> Select Media</h3>
            <button class="close-modal" onclick="closeMediaPicker()">&times;</button>
        </div>
        
        <div class="media-picker-tabs">
            <button class="picker-tab active" id="tab-btn-library" onclick="switchPickerTab('library')">
                <i class="fas fa-photo-video"></i> Media Library
            </button>
            <button class="picker-tab" id="tab-btn-upload" onclick="switchPickerTab('upload')">
                <i class="fas fa-cloud-upload-alt"></i> Upload New
            </button>
        </div>

        <div id="libraryTab" class="picker-content active">
            <!-- Filter Toolbar -->
            <div class="picker-filter-bar">
                <div class="picker-filter-group">
                    <button type="button" class="filter-pill active" onclick="setPickerStorageFilter('all', this)">
                        <i class="fas fa-th"></i> All (<span id="count-all">0</span>)
                    </button>
                    <button type="button" class="filter-pill" onclick="setPickerStorageFilter('google_drive', this)">
                        <i class="fab fa-google-drive" style="color: #0f9d58;"></i> Google Drive (<span id="count-gdrive">0</span>)
                    </button>
                    <button type="button" class="filter-pill" onclick="setPickerStorageFilter('local', this)">
                        <i class="fas fa-server" style="color: #2563eb;"></i> Local Server (<span id="count-local">0</span>)
                    </button>
                </div>
                <div class="picker-search-wrapper">
                    <i class="fas fa-search picker-search-icon"></i>
                    <input type="text" id="pickerSearchInput" placeholder="Search media..." oninput="filterPickerGrid()" class="picker-search-input">
                </div>
            </div>

            <div id="mediaPickerList" class="picker-grid">
                <!-- Media files will be loaded here via JS -->
                <p class="loading-text">Loading media...</p>
            </div>
        </div>

        <div id="uploadTab" class="picker-content">
            <!-- Storage Destination Choice -->
            <div class="picker-storage-select-card">
                <label class="picker-storage-title"><i class="fas fa-hdd"></i> আপলোড গন্তব্য (Upload Destination):</label>
                <div class="storage-option-group">
                    <label class="storage-option-label <?= ($pickerDefaultStorage === 'google_drive') ? 'active' : '' ?>" id="picker-label-gdrive">
                        <input type="radio" name="picker_storage_dest" value="google_drive" <?= ($pickerDefaultStorage === 'google_drive') ? 'checked' : '' ?> onchange="onPickerStorageChange(this.value)">
                        <div class="storage-option-box">
                            <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.4rem;"></i>
                            <div>
                                <span class="dest-name">Google Drive</span>
                                <span class="dest-desc">ক্লাউড স্টোরেজ (হোস্টিংয়ে কোনো জায়গা খাবে না)</span>
                            </div>
                        </div>
                    </label>
                    <label class="storage-option-label <?= ($pickerDefaultStorage !== 'google_drive') ? 'active' : '' ?>" id="picker-label-local">
                        <input type="radio" name="picker_storage_dest" value="local" <?= ($pickerDefaultStorage !== 'google_drive') ? 'checked' : '' ?> onchange="onPickerStorageChange(this.value)">
                        <div class="storage-option-box">
                            <i class="fas fa-server" style="color: #2563eb; font-size: 1.4rem;"></i>
                            <div>
                                <span class="dest-name">Local Server</span>
                                <span class="dest-desc">হোস্টিং স্টোরেজে সেভ হবে</span>
                            </div>
                        </div>
                    </label>
                </div>

                <?php if (!empty($pickerDrives)): ?>
                <div id="pickerDriveSelectorWrapper" style="margin-top: 12px; display: <?= ($pickerDefaultStorage === 'google_drive') ? 'flex' : 'none' ?>; align-items: center; gap: 8px;">
                    <label style="font-size: 12px; color: #475569; font-weight: 600;"><i class="fab fa-google-drive"></i> ড্রাইভ একাউন্ট:</label>
                    <select id="pickerTargetDriveId" style="padding: 6px 12px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 13px; font-weight: 500; background: white;">
                        <?php foreach ($pickerDrives as $pd): ?>
                            <option value="<?= htmlspecialchars($pd['id'] ?? '') ?>">
                                <?= htmlspecialchars($pd['name'] ?? 'Google Drive') ?> <?= !empty($pd['is_default']) ? '⭐ (Default)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </div>

            <div class="dropzone" id="pickerDropzone">
                <i class="fas fa-cloud-upload-alt"></i>
                <p style="font-size: 1.05rem; font-weight: 600; margin: 10px 0 5px;">Drag & Drop Image or Click to Upload</p>
                <p style="font-size: 0.85rem; color: #94a3b8; margin: 0 0 15px;">সরাসরি ইমেজ টেনে আনুন বা বাটন ক্লিক করুন</p>
                <input type="file" id="pickerFileInput" accept="image/*" style="display: none;" onchange="handlePickerUpload(this.files[0])">
                <button class="btn btn-primary" onclick="document.getElementById('pickerFileInput').click()">
                    <i class="fas fa-folder-open"></i> Choose Image File
                </button>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeMediaPicker()">Cancel</button>
            <button class="btn btn-primary" id="confirmPickerSelection" disabled onclick="confirmSelection()">Confirm Selection</button>
        </div>
    </div>
</div>

<style>
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 99999999 !important; align-items: center; justify-content: center; backdrop-filter: blur(3px); }
    .modal.active { display: flex; }
    
    .media-picker-content { width: 92%; max-width: 960px; background: white; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; max-height: 88vh; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    
    .modal-header { padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
    .modal-header h3 { margin: 0; color: #0f172a; font-size: 1.15rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
    
    .media-picker-tabs { display: flex; border-bottom: 1px solid #e2e8f0; padding: 0 24px; background: #fff; gap: 8px; }
    .picker-tab { padding: 14px 20px; border: none; background: none; font-weight: 600; cursor: pointer; color: #64748b; border-bottom: 3px solid transparent; transition: 0.2s; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; }
    .picker-tab.active { color: var(--primary, #059669); border-bottom-color: var(--primary, #059669); }

    .picker-content { display: none; padding: 20px 24px; overflow-y: auto; flex: 1; min-height: 420px; }
    .picker-content.active { display: block; }

    /* Filter Bar */
    .picker-filter-bar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; }
    .picker-filter-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-pill { padding: 6px 14px; border-radius: 20px; border: 1.5px solid #e2e8f0; background: #fff; font-size: 0.85rem; font-weight: 600; color: #475569; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .filter-pill:hover { border-color: #cbd5e1; background: #f8fafc; }
    .filter-pill.active { background: #0f172a; color: #fff; border-color: #0f172a; }

    .picker-search-wrapper { position: relative; min-width: 200px; }
    .picker-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; }
    .picker-search-input { padding: 7px 12px 7px 34px; border-radius: 20px; border: 1.5px solid #e2e8f0; font-size: 0.85rem; width: 100%; outline: none; transition: border 0.2s; }
    .picker-search-input:focus { border-color: var(--primary, #059669); }

    /* Grid */
    .picker-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 14px; }
    
    .picker-item { border: 2px solid #e2e8f0; border-radius: 12px; overflow: hidden; cursor: pointer; transition: 0.2s; position: relative; height: 125px; background: #f8fafc; }
    .picker-item:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-color: #cbd5e1; }
    .picker-item img { width: 100%; height: 100%; object-fit: cover; }
    .picker-item.selected { border-color: var(--primary, #059669); box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.2); }
    .picker-item.selected::after { content: '\f058'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; top: 6px; right: 6px; color: var(--primary, #059669); font-size: 1.3rem; background: white; border-radius: 50%; line-height: 1; }
    
    .picker-badge { position: absolute; bottom: 6px; left: 6px; font-size: 0.7rem; font-weight: 700; padding: 2px 7px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; pointer-events: none; z-index: 2; }
    .badge-gdrive-item { background: rgba(15, 157, 88, 0.92); color: white; }
    .badge-local-item { background: rgba(30, 41, 59, 0.85); color: white; }

    /* Upload destination select card */
    .picker-storage-select-card { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px 20px; margin-bottom: 20px; }
    .picker-storage-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 12px; display: block; }
    .storage-option-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .storage-option-label { cursor: pointer; margin: 0; }
    .storage-option-label input[type="radio"] { display: none; }
    .storage-option-box { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; background: white; transition: all 0.2s; }
    .storage-option-label:hover .storage-option-box { border-color: #cbd5e1; }
    .storage-option-label.active .storage-option-box { border-color: var(--primary, #059669); background: #f0fdf4; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.1); }
    .storage-option-label#picker-label-local.active .storage-option-box { border-color: #2563eb; background: #eff6ff; }
    .dest-name { display: block; font-weight: 700; font-size: 0.9rem; color: #0f172a; }
    .dest-desc { display: block; font-size: 0.75rem; color: #64748b; margin-top: 2px; }

    .dropzone { border: 2px dashed #cbd5e1; border-radius: 16px; padding: 45px 20px; text-align: center; color: #64748b; transition: 0.2s; cursor: pointer; background: #fafafa; }
    .dropzone:hover { border-color: var(--primary, #059669); background: #f0fdf4; color: var(--primary, #059669); }
    .dropzone i { font-size: 3rem; margin-bottom: 10px; color: var(--primary, #059669); opacity: 0.85; }

    .modal-footer { padding: 16px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px; }
    
    .loading-text { text-align: center; padding: 50px 20px; color: #64748b; font-size: 0.95rem; grid-column: 1 / -1; }
</style>

<script>
if (typeof currentTargetInput === 'undefined') {
    var currentTargetInput = null;
}
if (typeof currentPreviewImg === 'undefined') {
    var currentPreviewImg = null;
}
if (typeof selectedImageUrl === 'undefined') {
    var selectedImageUrl = null;
}
if (typeof allPickerMedia === 'undefined') {
    var allPickerMedia = [];
}
if (typeof activePickerStorageFilter === 'undefined') {
    var activePickerStorageFilter = 'all';
}

function openMediaPicker(targetInputId, previewImgId) {
    currentTargetInput = document.getElementById(targetInputId);
    currentPreviewImg = document.getElementById(previewImgId);
    document.getElementById('mediaPickerModal').classList.add('active');
    
    // Hide TinyMCE Dialog if active
    const tinyAux = document.querySelector('.tox-tinymce-aux');
    if (tinyAux) {
        tinyAux.style.opacity = '0';
        tinyAux.style.pointerEvents = 'none';
    }
    
    loadMediaLibrary();
}

function closeMediaPicker() {
    document.getElementById('mediaPickerModal').classList.remove('active');
    
    // Restore TinyMCE Dialog
    const tinyAux = document.querySelector('.tox-tinymce-aux');
    if (tinyAux) {
        tinyAux.style.opacity = '1';
        tinyAux.style.pointerEvents = 'auto';
    }
}

function switchPickerTab(tab) {
    document.querySelectorAll('.picker-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.picker-content').forEach(c => c.classList.remove('active'));
    
    const activeBtn = document.getElementById('tab-btn-' + tab);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
    document.getElementById(tab + 'Tab').classList.add('active');
}

function onPickerStorageChange(val) {
    document.getElementById('picker-label-gdrive').classList.toggle('active', val === 'google_drive');
    document.getElementById('picker-label-local').classList.toggle('active', val === 'local');
    const driveSelector = document.getElementById('pickerDriveSelectorWrapper');
    if (driveSelector) {
        driveSelector.style.display = (val === 'google_drive') ? 'flex' : 'none';
    }
}

function setPickerStorageFilter(filter, btn) {
    activePickerStorageFilter = filter;
    document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    filterPickerGrid();
}

function filterPickerGrid() {
    const searchVal = (document.getElementById('pickerSearchInput')?.value || '').toLowerCase().trim();
    const list = document.getElementById('mediaPickerList');
    
    let filtered = allPickerMedia.filter(file => {
        const matchesStorage = (activePickerStorageFilter === 'all') || (file.storage === activePickerStorageFilter);
        const matchesSearch = !searchVal || (file.name && file.name.toLowerCase().includes(searchVal));
        return matchesStorage && matchesSearch;
    });

    if (filtered.length === 0) {
        list.innerHTML = '<p class="loading-text"><i class="fas fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.5;"></i> কোনো মিডিয়া ফাইল পাওয়া যায়নি।</p>';
        return;
    }

    list.innerHTML = '';
    filtered.forEach(file => {
        const div = document.createElement('div');
        div.className = 'picker-item' + (selectedImageUrl === file.url ? ' selected' : '');
        div.onclick = () => selectImage(file.url, div);
        
        const isGdrive = (file.storage === 'google_drive');
        const badgeHtml = isGdrive 
            ? `<span class="picker-badge badge-gdrive-item"><i class="fab fa-google-drive"></i> Drive</span>`
            : `<span class="picker-badge badge-local-item"><i class="fas fa-server"></i> Local</span>`;
            
        div.innerHTML = `
            <img src="${file.url}" title="${file.name}" loading="lazy" decoding="async">
            ${badgeHtml}
        `;
        list.appendChild(div);
    });
}

async function loadMediaLibrary() {
    const list = document.getElementById('mediaPickerList');
    list.innerHTML = '<p class="loading-text"><i class="fas fa-spinner fa-spin"></i> মিডিয়া ফাইল লোড হচ্ছে...</p>';
    
    try {
        const res = await fetch('<?= URLROOT ?>/admin/api_media?storage=all');
        const data = await res.json();
        
        allPickerMedia = Array.isArray(data) ? data : [];
        
        // Update counts
        const gdriveCount = allPickerMedia.filter(f => f.storage === 'google_drive').length;
        const localCount = allPickerMedia.filter(f => f.storage === 'local').length;
        
        const countAll = document.getElementById('count-all');
        const countGdrive = document.getElementById('count-gdrive');
        const countLocal = document.getElementById('count-local');
        if (countAll) countAll.textContent = allPickerMedia.length;
        if (countGdrive) countGdrive.textContent = gdriveCount;
        if (countLocal) countLocal.textContent = localCount;

        filterPickerGrid();
    } catch (err) {
        list.innerHTML = '<p class="loading-text text-danger"><i class="fas fa-exclamation-triangle"></i> মিডিয়া লোড করতে ত্রুটি হয়েছে।</p>';
    }
}

function selectImage(url, element) {
    document.querySelectorAll('.picker-item').forEach(i => i.classList.remove('selected'));
    element.classList.add('selected');
    selectedImageUrl = url;
    document.getElementById('confirmPickerSelection').disabled = false;
}

function confirmSelection() {
    if (selectedImageUrl && currentTargetInput) {
        currentTargetInput.value = selectedImageUrl;
        currentTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
        currentTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
        
        // Custom callback dispatch for TinyMCE
        if (currentTargetInput.id === 'tinymce_media_target') {
            currentTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
        }

        if (currentPreviewImg) {
            currentPreviewImg.src = selectedImageUrl;
            currentPreviewImg.style.display = 'block';
        }
        // Auto-show remove button if it exists
        const removeBtn = document.getElementById('remove_' + currentTargetInput.id);
        if (removeBtn) {
            removeBtn.style.display = 'inline-block';
        }
        closeMediaPicker();
    }
}

function clearSelectedImage(inputId, previewId, removeBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(removeBtnId);
    if (input) input.value = '';
    if (preview) {
        preview.src = '';
        preview.style.display = 'none';
    }
    if (removeBtn) removeBtn.style.display = 'none';
}

async function handlePickerUpload(file) {
    if (!file) return;
    
    // Read chosen storage destination
    const destRadio = document.querySelector('input[name="picker_storage_dest"]:checked');
    const selectedDest = destRadio ? destRadio.value : '<?= $pickerDefaultStorage ?>';
    const driveSelect = document.getElementById('pickerTargetDriveId');
    const targetDriveId = (selectedDest === 'google_drive' && driveSelect) ? driveSelect.value : '';

    const formData = new FormData();
    formData.append('media_file', file);
    formData.append('upload_destination', selectedDest);
    if (targetDriveId) {
        formData.append('target_drive_id', targetDriveId);
    }

    const tokenName = '<?= csrf_token() ?>';
    const tokenHash = '<?= csrf_hash() ?>';
    if (tokenName && tokenHash) {
        formData.append(tokenName, tokenHash);
    }
    
    // Show loading
    const dropzone = document.getElementById('pickerDropzone');
    const originalHTML = dropzone.innerHTML;
    const destName = (selectedDest === 'google_drive') ? 'Google Drive' : 'Local Server';
    dropzone.innerHTML = `<p style="padding: 30px;"><i class="fas fa-spinner fa-spin" style="font-size: 2.5rem; color: var(--primary);"></i><br><br><strong>${destName}-এ আপলোড হচ্ছে...</strong></p>`;
    
    try {
        const res = await fetch('<?= URLROOT ?>/admin/media?ajax=1', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                '<?= config('Security')->headerName ?>': tokenHash
            },
            body: formData
        });
        
        let result = null;
        const text = await res.text();
        try {
            result = JSON.parse(text);
        } catch (_) {
            if (!res.ok) {
                throw new Error('Upload failed with status ' + res.status);
            }
            throw new Error('Server returned an unexpected non-JSON response.');
        }

        if (result && result.success) {
            // If url returned, pre-select it
            if (result.url) {
                selectedImageUrl = result.url;
            }
            // Switch to library tab and reload
            switchPickerTab('library');
            await loadMediaLibrary();
            dropzone.innerHTML = originalHTML;
        } else {
            throw new Error((result && result.error) ? result.error : 'Upload failed');
        }
    } catch (err) {
        alert(err.message || 'Upload failed');
        dropzone.innerHTML = originalHTML;
    }
}
</script>
