<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Database Backup & Restore</h1>
        <p>Keep your data safe by exporting backups and restoring when needed</p>
    </div>
</div>

<?php if (isset($_SESSION['restore_success'])): ?>
    <div style="background: rgba(16, 185, 129, 0.1); border-left: 5px solid #10b981; color: #10b981; padding: 1.2rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle" style="font-size: 1.3rem;"></i>
        <div><?= $_SESSION['restore_success']; unset($_SESSION['restore_success']); ?></div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['restore_error'])): ?>
    <div style="background: rgba(239, 68, 68, 0.1); border-left: 5px solid #ef4444; color: #ef4444; padding: 1.2rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 1.3rem;"></i>
        <div><?= $_SESSION['restore_error']; unset($_SESSION['restore_error']); ?></div>
    </div>
<?php endif; ?>

<div class="grid-two-equal">
    <!-- Export Card -->
    <div class="admin-card" style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <div style="font-size: 4rem; color: var(--primary); margin-bottom: 1.5rem;">
            <i class="fas fa-file-export"></i>
        </div>
        <h2 style="color: var(--text-main); margin-bottom: 1rem; font-size: 1.6rem;">Export Database</h2>
        <p style="color: var(--text-muted); max-width: 400px; margin-bottom: 2.5rem; line-height: 1.6;">
            Download a full <code>.sql</code> backup containing all posts, categories, questions, users, and configuration settings.
        </p>
        <a href="<?= URLROOT ?>/admin/export_db" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1rem; border-radius: 50px; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 10px 25px rgba(0, 107, 67, 0.25);">
            <i class="fas fa-download"></i> Generate & Download Backup
        </a>
    </div>

    <!-- Import / Restore Card -->
    <div class="admin-card" style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <div style="font-size: 4rem; color: #ef4444; margin-bottom: 1.5rem;">
            <i class="fas fa-file-import"></i>
        </div>
        <h2 style="color: var(--text-main); margin-bottom: 1rem; font-size: 1.6rem;">Restore Database</h2>
        <p style="color: var(--text-muted); max-width: 400px; margin-bottom: 1.5rem; line-height: 1.6;">
            Upload a previously exported <code>.sql</code> backup file to restore your database. 
            <strong style="color: #ef4444;">Warning: This will overwrite your current database.</strong>
        </p>
        
        <form action="<?= URLROOT ?>/admin/restore_db" method="POST" enctype="multipart/form-data" id="restoreForm" style="width: 100%; max-width: 400px;">
            <div style="margin-bottom: 1.5rem; position: relative;">
                <input type="file" name="backup_file" id="backup_file" accept=".sql" required style="display: none;" onchange="updateFileName(this)">
                <label for="backup_file" style="display: flex; align-items: center; justify-content: center; gap: 10px; border: 2px dashed #cbd5e1; padding: 1rem; border-radius: 12px; cursor: pointer; transition: 0.3s; color: var(--text-secondary); background: rgba(0,0,0,0.02);" id="fileLabel">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 1.5rem;"></i>
                    <span id="fileName">Select SQL File</span>
                </label>
            </div>
            
            <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 1rem 2.5rem; font-size: 1rem; border-radius: 50px; display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.25);" onclick="return confirmRestore(event)">
                <i class="fas fa-undo"></i> Restore Database
            </button>
        </form>
    </div>
</div>

<div class="grid-two-equal" style="margin-top: 2rem;">
    <div class="admin-card" style="background: rgba(0, 107, 67, 0.03); border: 1px solid rgba(0, 107, 67, 0.1);">
        <h4 style="color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-shield-alt"></i> Why Backup?</h4>
        <ul style="color: var(--text-secondary); line-height: 1.8; padding-left: 1.2rem; margin: 0;">
            <li>Protect against server failures or hosting issues</li>
            <li>Restore site after accidental changes or deletions</li>
            <li>Easy migration or replication to a staging server</li>
        </ul>
    </div>
    <div class="admin-card" style="background: rgba(239, 68, 68, 0.03); border: 1px solid rgba(239, 68, 68, 0.1);">
        <h4 style="color: #ef4444; margin-bottom: 1rem;"><i class="fas fa-exclamation-triangle"></i> Important Note</h4>
        <p style="color: var(--text-secondary); line-height: 1.6; margin: 0;">
            This backup contains <strong>only database records</strong> (SQL). It does NOT include uploaded images or media. Please back up the <code>public/img</code> folder manually.
        </p>
    </div>
</div>

<script>
function updateFileName(input) {
    const label = document.getElementById('fileLabel');
    const nameSpan = document.getElementById('fileName');
    if (input.files && input.files.length > 0) {
        nameSpan.textContent = input.files[0].name;
        label.style.borderColor = 'var(--primary)';
        label.style.background = 'rgba(0, 107, 67, 0.02)';
    } else {
        nameSpan.textContent = 'Select SQL File';
        label.style.borderColor = '#cbd5e1';
        label.style.background = 'rgba(0,0,0,0.02)';
    }
}

function confirmRestore(event) {
    const fileInput = document.getElementById('backup_file');
    if (!fileInput.files || fileInput.files.length === 0) {
        alert('Please select a SQL backup file first.');
        event.preventDefault();
        return false;
    }
    
    const doubleCheck = confirm("MANDATORY WARNING:\nAre you absolutely sure you want to restore the database?\n\nThis will completely overwrite the current database and all changes since the backup will be permanently lost.");
    if (!doubleCheck) {
        event.preventDefault();
        return false;
    }
    
    // Disable button to prevent double submissions
    const btn = event.currentTarget;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Restoring Database...';
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
    
    document.getElementById('restoreForm').submit();
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
