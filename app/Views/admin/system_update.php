<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">System Update</h1>
        <p>Update the core application files and database schema using a ZIP update package.</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success" style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: 500;">
        <i class="fas fa-check-circle"></i> <?= $data['success'] ?>
    </div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: 500;">
        <i class="fas fa-times-circle"></i> <?= $data['error'] ?>
    </div>
<?php endif; ?>

<div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
    <form id="systemUpdateForm" action="<?= URLROOT ?>/admin/system_update" method="POST" enctype="multipart/form-data">
        <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 25px; background: #fafafa;">
            <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--text-main); font-weight: 700; display: flex; align-items: center; gap: 10px; font-size: 1.15rem;">
                <i class="fas fa-cloud-upload-alt" style="color: var(--primary); font-size: 1.3rem;"></i> Upload Update ZIP File
            </h4>
            <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                Upload a system update ZIP file to update the application core files. The database configuration file (<code>app/Config/Database.php</code>) and all uploaded images/files inside <code>public/img/</code> and <code>public/uploads/</code> will not be deleted or overwritten.
            </p>
            <div class="form-group" style="max-width: 500px; margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">Select System Update ZIP File</label>
                <input type="file" name="update_zip" class="form-control" accept=".zip" required style="width: 100%; padding: 10px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
            </div>
            <div class="alert alert-info" style="margin-bottom: 0; padding: 15px; border-radius: 8px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; font-size: 0.9rem; font-weight: 500; display: flex; align-items: flex-start; gap: 10px;">
                <i class="fas fa-exclamation-triangle" style="margin-top: 2px;"></i>
                <span><strong>Important Note:</strong> Make sure you have backed up your database and current files before applying the update. Applying updates may overwrite existing theme and logic files.</span>
            </div>
        </div>

        <button type="submit" class="btn-save" id="systemUpdateBtn" style="background: #dc2626; color: white; border: none; padding: 14px 28px; border-radius: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; font-size: 1rem; transition: 0.3s; box-shadow: 0 10px 20px rgba(220, 38, 38, 0.25);">
            <i class="fas fa-sync-alt"></i> Apply System Update
        </button>
        <!-- Upload Progress Bar Container -->
        <div id="progressContainer" style="display: none; margin-top: 25px; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc;">
            <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 0.95rem; margin-bottom: 10px;">
                <span id="progressStatus" style="color: var(--text-main); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-spinner fa-spin text-primary"></i> Uploading file...
                </span>
                <span id="progressPercentage" style="color: var(--primary); font-weight: 800; font-size: 1.1rem; text-shadow: 0 0 10px rgba(37, 99, 235, 0.1);">0%</span>
            </div>
            <div style="background: #e2e8f0; border-radius: 50px; height: 14px; overflow: hidden; width: 100%; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
                <div id="progressBar" style="background: linear-gradient(90deg, var(--primary) 0%, #3b82f6 100%); height: 100%; width: 0%; transition: width 0.1s ease; border-radius: 50px; box-shadow: 0 0 8px rgba(37, 99, 235, 0.4);"></div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('systemUpdateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const fileInput = form.querySelector('input[type="file"]');
        if (!fileInput.files.length) return;

        const btn = document.getElementById('systemUpdateBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing...';
        btn.style.opacity = '0.7';

        const formData = new FormData();
        formData.append('update_zip', fileInput.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);

        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');
        const progressStatus = document.getElementById('progressStatus');

        progressContainer.style.display = 'block';

        // Track upload progress
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressPercentage.textContent = percent + '%';
                if (percent === 100) {
                    progressStatus.innerHTML = '<i class="fas fa-spinner fa-spin text-success"></i> Upload complete. Extracting & applying update...';
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Applying Update...';
                } else {
                    progressStatus.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i> Uploading: ' + percent + '%';
                }
            }
        };

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Re-render page dynamically with session alert feedback
                document.open();
                document.write(xhr.responseText);
                document.close();
            } else {
                progressStatus.textContent = 'An error occurred during update.';
                progressStatus.style.color = '#dc2626';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt"></i> Apply System Update';
                btn.style.opacity = '1';
            }
        };

        xhr.onerror = function() {
            progressStatus.textContent = 'Network connection failed.';
            progressStatus.style.color = '#dc2626';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt"></i> Apply System Update';
            btn.style.opacity = '1';
        };

        xhr.send(formData);
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
