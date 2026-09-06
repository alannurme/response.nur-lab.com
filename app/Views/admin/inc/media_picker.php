<!-- Media Picker Modal -->
<div id="mediaPickerModal" class="modal">
    <div class="modal-content media-picker-content">
        <div class="modal-header">
            <h3><i class="fas fa-images"></i> Select Media</h3>
            <button class="close-modal" onclick="closeMediaPicker()">&times;</button>
        </div>
        
        <div class="media-picker-tabs">
            <button class="picker-tab active" id="tab-btn-library" onclick="switchPickerTab('library')">Media Library</button>
            <button class="picker-tab" id="tab-btn-upload" onclick="switchPickerTab('upload')">Upload New</button>
        </div>

        <div id="libraryTab" class="picker-content active">
            <div id="mediaPickerList" class="picker-grid">
                <!-- Media files will be loaded here via JS -->
                <p class="loading-text">Loading media...</p>
            </div>
        </div>

        <div id="uploadTab" class="picker-content">
            <div class="dropzone" id="pickerDropzone">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Drag & Drop Image or Click to Upload</p>
                <input type="file" id="pickerFileInput" style="display: none;" onchange="handlePickerUpload(this.files[0])">
                <button class="btn btn-primary" onclick="document.getElementById('pickerFileInput').click()">Choose File</button>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeMediaPicker()">Cancel</button>
            <button class="btn btn-primary" id="confirmPickerSelection" disabled onclick="confirmSelection()">Confirm Selection</button>
        </div>
    </div>
</div>

<style>
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99999999 !important; align-items: center; justify-content: center; }
    .modal.active { display: flex; }
    
    .media-picker-content { width: 90%; max-width: 900px; background: white; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; max-height: 85vh; }
    
    .modal-header { padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
    .modal-header h3 { margin: 0; color: var(--primary); display: flex; align-items: center; gap: 10px; }
    
    .media-picker-tabs { display: flex; border-bottom: 1px solid #eee; padding: 0 20px; background: #fff; }
    .picker-tab { padding: 15px 25px; border: none; background: none; font-weight: 600; cursor: pointer; color: #666; border-bottom: 3px solid transparent; transition: 0.3s; }
    .picker-tab.active { color: var(--primary); border-bottom-color: var(--primary); }

    .picker-content { display: none; padding: 20px; overflow-y: auto; flex: 1; min-height: 400px; }
    .picker-content.active { display: block; }

    .picker-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 15px; }
    
    .picker-item { border: 2px solid #eee; border-radius: 12px; overflow: hidden; cursor: pointer; transition: 0.3s; position: relative; height: 120px; }
    .picker-item img { width: 100%; height: 100%; object-fit: cover; }
    .picker-item.selected { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-light); }
    .picker-item.selected::after { content: '\f058'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; top: 5px; right: 5px; color: var(--primary); font-size: 1.2rem; background: white; border-radius: 50%; }

    .dropzone { border: 2px dashed #ddd; border-radius: 15px; padding: 60px; text-align: center; color: #888; transition: 0.3s; cursor: pointer; }
    .dropzone:hover { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
    .dropzone i { font-size: 3rem; margin-bottom: 15px; }

    .modal-footer { padding: 15px 20px; border-top: 1px solid #eee; text-align: right; background: #f8fafc; }
    
    .loading-text { text-align: center; padding: 40px; color: #888; }
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

async function loadMediaLibrary() {
    const list = document.getElementById('mediaPickerList');
    list.innerHTML = '<p class="loading-text"><i class="fas fa-spinner fa-spin"></i> Loading media...</p>';
    
    try {
        const res = await fetch('<?= URLROOT ?>/admin/api_media');
        const data = await res.json();
        
        if (data.length === 0) {
            list.innerHTML = '<p class="loading-text">No media found.</p>';
            return;
        }

        list.innerHTML = '';
        data.forEach(file => {
            const div = document.createElement('div');
            div.className = 'picker-item';
            div.onclick = () => selectImage(file.url, div);
            div.innerHTML = `<img src="${file.url}" title="${file.name}" loading="lazy" decoding="async">`;
            list.appendChild(div);
        });
    } catch (err) {
        list.innerHTML = '<p class="loading-text text-danger">Error loading media.</p>';
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
    
    const formData = new FormData();
    formData.append('media_file', file);
    
    // Show loading
    const dropzone = document.getElementById('pickerDropzone');
    const originalHTML = dropzone.innerHTML;
    dropzone.innerHTML = '<p><i class="fas fa-spinner fa-spin"></i> Uploading...</p>';
    
    try {
        const res = await fetch('<?= URLROOT ?>/admin/media?ajax=1', {
            method: 'POST',
            body: formData
        });
        
        const result = await res.json();
        if (result.success) {
            // After upload, switch to library and reload
            switchPickerTab('library');
            loadMediaLibrary();
            dropzone.innerHTML = originalHTML;
        } else {
            throw new Error(result.error || 'Upload failed');
        }
    } catch (err) {
        alert(err.message || 'Upload failed');
        dropzone.innerHTML = originalHTML;
    }
}
</script>
