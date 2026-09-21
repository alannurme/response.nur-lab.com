<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Team Member</h3>
        <a href="<?= URLROOT ?>/admin/team" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_team_member" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
            </div>
            <div class="form-group mb-4">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. Chief Editor" required>
            </div>
        </div>



        <div class="form-group mb-4">
            <label>Profile Image</label>
            <div style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="width: 120px; height: 120px; border-radius: 15px; overflow: hidden; border: 2px dashed #ddd; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                    <img id="member_preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;" loading="lazy" decoding="async">
                    <i id="preview_placeholder" class="fas fa-user-plus" style="font-size: 2rem; color: #cbd5e1;"></i>
                </div>
                <div style="flex: 1;">
                    <input type="text" id="member_image_path" name="image" class="form-control" required readonly>
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <button type="button" class="btn btn-secondary w-100" onclick="openMediaPicker('member_image_path', 'member_preview')">
                            <i class="fas fa-image"></i> Select Profile Photo
                        </button>
                        <button type="button" id="crop_btn" class="btn btn-warning w-100" onclick="startCropper()" style="background: #eab308; color: #fff; border: none; font-weight: 600; display: none;">
                            <i class="fas fa-crop-simple"></i> Crop & Adjust
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group mb-4">
                <label><i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook URL</label>
                <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/...">
            </div>
            <div class="form-group mb-4">
                <label><i class="fab fa-twitter" style="color: #1da1f2;"></i> Twitter / X URL</label>
                <input type="url" name="twitter_link" class="form-control" placeholder="https://twitter.com/...">
            </div>
            <div class="form-group mb-4">
                <label><i class="fab fa-linkedin" style="color: #0a66c2;"></i> LinkedIn URL</label>
                <input type="url" name="linkedin_link" class="form-control" placeholder="https://linkedin.com/in/...">
            </div>
        </div>

        <div class="form-group mb-5">
            <label>Display Order (Lower numbers show first)</label>
            <input type="number" name="order_index" value="0" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Member to Team</button>
    </form>
</div>

<!-- Image Cropping Modal -->
<div id="cropperModal" class="modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 20000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="modal-content" style="width: 90%; max-width: 600px; background: white; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; max-height: 85vh; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <div class="modal-header" style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 style="margin: 0; color: var(--primary); display: flex; align-items: center; gap: 10px;"><i class="fas fa-crop"></i> Adjust & Crop Profile Image</h3>
            <button type="button" class="close-modal" onclick="closeCropper()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #888;">&times;</button>
        </div>
        <div style="padding: 20px; flex: 1; display: flex; align-items: center; justify-content: center; background: #111; min-height: 300px; max-height: 50vh;">
            <img id="cropperImageSrc" src="" style="max-width: 100%; max-height: 100%; display: block;" loading="lazy" decoding="async">
        </div>
        <div class="modal-footer" style="padding: 15px 20px; border-top: 1px solid #eee; text-align: right; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="cropper.rotate(-90)" style="padding: 8px 12px; border-radius: 8px;"><i class="fas fa-rotate-left"></i> Left</button>
                <button type="button" class="btn btn-secondary" onclick="cropper.rotate(90)" style="padding: 8px 12px; border-radius: 8px;"><i class="fas fa-rotate-right"></i> Right</button>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeCropper()">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveCroppedImage" onclick="saveCroppedImage()">Apply Crop</button>
            </div>
        </div>
    </div>
</div>

<script>
let cropper = null;

function startCropper() {
    const imgPathInput = document.getElementById('member_image_path');
    if (!imgPathInput || !imgPathInput.value) return;
    
    const imageSrc = imgPathInput.value;
    const cropperImage = document.getElementById('cropperImageSrc');
    
    // Set src
    cropperImage.src = imageSrc;
    
    // Show modal
    document.getElementById('cropperModal').style.display = 'flex';
    
    // Destroy previous instance if any
    if (cropper) {
        cropper.destroy();
    }
    
    // Initialize Cropper
    setTimeout(() => {
        cropper = new Cropper(cropperImage, {
            aspectRatio: 1, // square ratio
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false
        });
    }, 150);
}

function closeCropper() {
    document.getElementById('cropperModal').style.display = 'none';
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
}

async function saveCroppedImage() {
    if (!cropper) return;
    
    const saveBtn = document.getElementById('saveCroppedImage');
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    try {
        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500
        });
        
        // Convert to blob
        canvas.toBlob(async (blob) => {
            if (!blob) {
                alert('Crop failed.');
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
                return;
            }
            
            const formData = new FormData();
            formData.append('media_file', blob, 'cropped_profile_' + Date.now() + '.jpg');
            
            // Upload to server using the media handler
            const response = await fetch('<?= URLROOT ?>/admin/media?ajax=1', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Update input field and preview
                const pathInput = document.getElementById('member_image_path');
                const previewImg = document.getElementById('member_preview');
                const placeholder = document.getElementById('preview_placeholder');
                
                pathInput.value = result.url;
                if (previewImg) {
                    previewImg.src = result.url;
                    previewImg.style.display = 'block';
                }
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                
                // Close modal
                closeCropper();
            } else {
                alert('Failed to save cropped image.');
            }
            
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
        }, 'image/jpeg', 0.85);
    } catch (err) {
        console.error(err);
        alert('An error occurred during cropping.');
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    }
}

// Auto show/hide crop button based on input value
function updateCropBtnVisibility() {
    const pathInput = document.getElementById('member_image_path');
    const cropBtn = document.getElementById('crop_btn');
    if (pathInput && cropBtn) {
        cropBtn.style.display = pathInput.value ? 'inline-block' : 'none';
    }
}

document.getElementById('member_image_path').addEventListener('change', updateCropBtnVisibility);
document.getElementById('member_image_path').addEventListener('input', updateCropBtnVisibility);
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
