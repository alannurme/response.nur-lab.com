<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="font-family: 'Hind Siliguri', sans-serif; font-size: 1.8rem; margin: 0 0 6px;">
            <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.8rem; vertical-align: middle;"></i> Google Drive ক্লাউড স্টোরেজ
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
            ওয়েবসাইটের সকল ফাইল, ছবি ও মিডিয়া গুগল ড্রাইভে সংরক্ষণ করুন এবং ১-ক্লিকে অটো-কানেক্ট পরিচালনা করুন।
        </p>
    </div>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success" style="background: #dcfce7; color: #166534; border: 1px solid #86efac; border-radius: 12px; padding: 14px 20px; margin-bottom: 25px; font-weight: 600;">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($data['success']) ?>
    </div>
<?php endif; ?>

<?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 12px; padding: 14px 20px; margin-bottom: 25px; font-weight: 600;">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($data['error']) ?>
    </div>
<?php endif; ?>

<form action="<?= URLROOT ?>/admin/storage_settings" method="POST" id="storageSettingsForm">
                        <?= csrf_field() ?>

    <!-- 1-Click Auto Connect Banner Card -->
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #e8f5e9 100%); border: 2px solid #86efac; border-radius: 18px; padding: 28px; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(15, 157, 88, 0.08);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="max-width: 680px;">
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #0f9d58; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                    <i class="fas fa-bolt"></i> ১-ক্লিক অটো কানেকশন (OAuth 2.0)
                </div>
                <h3 style="margin: 0 0 10px; color: #064e3b; font-size: 1.4rem; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 10px;">
                    <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.7rem;"></i> ১-ক্লিকে গুগল ড্রাইভ কানেক্ট করুন
                </h3>
                <p style="margin: 0; color: #166534; font-size: 0.95rem; line-height: 1.55;">
                    কোনো কোডিং বা ফোল্ডার খোঁজাখুঁজির প্রয়োজন নেই। শুধু নিচের বাটনে ক্লিক করে আপনার গুগল অ্যাকাউন্টটি সিলেক্ট করুন। ব্যাকগ্রাউন্ডে স্বয়ংক্রিয়ভাবে <strong style="color: #064e3b;">"Response Records Storage"</strong> ফোল্ডার তৈরি হবে এবং আপলোড একটিভ হয়ে যাবে।
                </p>
            </div>
            <div>
                <?php if (!empty($data['settings']['gdrive_oauth_client_id']) && !empty($data['settings']['gdrive_oauth_client_secret'])): ?>
                    <a href="<?= URLROOT ?>/admin/gdrive_oauth_init" class="btn" style="background: #0f9d58; color: white; padding: 15px 32px; border-radius: 14px; font-weight: 800; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 12px; text-decoration: none; box-shadow: 0 6px 20px rgba(15, 157, 88, 0.35); transition: 0.25s;">
                        <i class="fab fa-google" style="font-size: 1.25rem;"></i> Connect Google Drive (১-ক্লিক)
                    </a>
                <?php else: ?>
                    <button type="button" onclick="document.getElementById('oauth_setup_section').scrollIntoView({behavior: 'smooth'})" class="btn" style="background: #047857; color: white; padding: 14px 28px; border-radius: 14px; font-weight: 800; font-size: 1rem; display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(4, 120, 87, 0.25);">
                        <i class="fas fa-key"></i> ক্রেডেনশিয়াল সেট করুন
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Google OAuth Credentials Setup -->
        <div id="oauth_setup_section" style="margin-top: 24px; padding-top: 20px; border-top: 1.5px dashed #86efac;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 14px;">
                <div style="font-size: 0.92rem; font-weight: 700; color: #064e3b; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-key" style="color: #0f9d58;"></i> Google API OAuth Credentials (একবারের কনফিগারেশন)
                </div>
                <div style="font-size: 0.82rem; color: #166534;">
                    Authorized Redirect URI: 
                    <code style="background: white; padding: 3px 8px; border-radius: 6px; border: 1px solid #86efac; font-weight: 700; color: #064e3b;"><?= URLROOT ?>/admin/gdrive_oauth_callback</code>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #166534; margin-bottom: 6px;">
                        Google Client ID <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="settings[gdrive_oauth_client_id]" value="<?= htmlspecialchars($data['settings']['gdrive_oauth_client_id'] ?? '') ?>" placeholder="xxxx.apps.googleusercontent.com" style="width: 100%; padding: 11px 14px; border: 1.5px solid #a7f3d0; border-radius: 10px; font-size: 0.9rem; background: white; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #166534; margin-bottom: 6px;">
                        Google Client Secret <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="password" name="settings[gdrive_oauth_client_secret]" value="<?= htmlspecialchars($data['settings']['gdrive_oauth_client_secret'] ?? '') ?>" placeholder="GOCSPX-xxxx" style="width: 100%; padding: 11px 14px; border: 1.5px solid #a7f3d0; border-radius: 10px; font-size: 0.9rem; background: white; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <small style="color: #15803d; font-size: 0.82rem;">
                    <i class="fas fa-info-circle"></i> <a href="https://console.cloud.google.com/apis/credentials" target="_blank" style="color: #047857; text-decoration: underline; font-weight: 700;">Google Cloud Console</a> থেকে Web Client ID তৈরি করে উপরের Redirect URI টি পেস্ট করে দিন।
                </small>
                <button type="submit" class="btn" style="background: #10b981; color: white; border: none; padding: 10px 22px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <i class="fas fa-save"></i> ক্রেডেনশিয়াল সেভ করুন
                </button>
            </div>
        </div>
    </div>

    <!-- Storage Provider & Settings Card -->
    <div style="background: white; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <h3 style="margin-top: 0; margin-bottom: 8px; color: #0f172a; font-weight: 700; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
            <i class="fas fa-database" style="color: var(--primary);"></i> স্টোরেজ মোড নির্বাচন
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            ওয়েবসাইটে আপলোড করা ফাইলগুলো কোথায় সরাসরি সেভ হবে তা সিলেক্ট করুন।
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <!-- Google Drive Option -->
            <label class="storage-provider-card <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'google_drive') ? 'active-provider' : '' ?>" id="provider-card-gdrive" style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; border: 2px solid <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'google_drive') ? '#0f9d58' : '#e2e8f0' ?>; border-radius: 14px; background: <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'google_drive') ? '#f0fdf4' : 'white' ?>; cursor: pointer; transition: 0.25s;">
                <input type="radio" name="settings[storage_provider]" value="google_drive" <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'google_drive') ? 'checked' : '' ?> onchange="updateStorageProviderCard()" style="margin-top: 4px; accent-color: #0f9d58; transform: scale(1.2);">
                <div>
                    <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.2rem;"></i> গুগল ড্রাইভ ক্লাউড (Google Drive - রিকমেন্ডেড)
                    </div>
                    <p style="margin: 6px 0 0; color: #64748b; font-size: 0.85rem; line-height: 1.4;">
                        গুগল ড্রাইভে ফাইলগুলো স্বয়ংক্রিয়ভাবে আপলোড হবে এবং দ্রুততম গুগল CDN এর মাধ্যমে ওয়েবসাইটে প্রদর্শিত হবে।
                    </p>
                </div>
            </label>

            <!-- Local Storage Option -->
            <label class="storage-provider-card <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'local') ? 'active-provider' : '' ?>" id="provider-card-local" style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; border: 2px solid <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'local') ? 'var(--primary)' : '#e2e8f0' ?>; border-radius: 14px; background: <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'local') ? '#f8fafc' : 'white' ?>; cursor: pointer; transition: 0.25s;">
                <input type="radio" name="settings[storage_provider]" value="local" <?= (($data['settings']['storage_provider'] ?? 'google_drive') === 'local') ? 'checked' : '' ?> onchange="updateStorageProviderCard()" style="margin-top: 4px; accent-color: var(--primary); transform: scale(1.2);">
                <div>
                    <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-server" style="color: #64748b;"></i> লোকাল সার্ভার স্টোরেজ (Local Server)
                    </div>
                    <p style="margin: 6px 0 0; color: #64748b; font-size: 0.85rem; line-height: 1.4;">
                        নিজস্ব ওয়েব হোস্টিং ডিস্কে সরাসরি আপলোড হবে (<code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">/public/img/</code>)।
                    </p>
                </div>
            </label>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 20px; padding-top: 18px; border-top: 1px dashed #cbd5e1;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem; color: #334155; font-weight: 600;">
                <input type="checkbox" name="settings[gdrive_auto_fallback]" value="1" <?= (($data['settings']['gdrive_auto_fallback'] ?? '1') === '1') ? 'checked' : '' ?> style="accent-color: var(--primary); transform: scale(1.15);">
                <span>একাধিক ড্রাইভ অটো-ফেলওভার (একটি ফুল বা এরর হলে স্বয়ংক্রিয় পরবর্তী সক্রিয় ড্রাইভে আপলোড)</span>
            </label>
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem; color: #334155; font-weight: 600;">
                <input type="checkbox" name="settings[gdrive_sync_local]" value="1" <?= (($data['settings']['gdrive_sync_local'] ?? '1') === '1') ? 'checked' : '' ?> style="accent-color: var(--primary); transform: scale(1.15);">
                <span>লোকাল ব্যাকআপ কপি রাখুন (ড্রাইভে আপলোডের পাশাপাশি নিজস্ব হোস্টিং সার্ভারেও ব্যাকআপ সংরক্ষণ)</span>
            </label>
        </div>
    </div>

    <!-- Connected Google Drives List -->
    <div style="background: white; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 5px; color: #0f172a; font-weight: 700; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                <i class="fab fa-google-drive" style="color: #0f9d58;"></i> কানেক্টেড গুগল ড্রাইভসমূহ (Connected Accounts)
            </h3>
            <p style="margin: 0; color: #64748b; font-size: 0.88rem;">
                ১-ক্লিকে যুক্ত হওয়া সক্রিয় গুগল ড্রাইভ একাউন্টসমূহ।
            </p>
        </div>

        <input type="hidden" name="settings[google_drives]" id="google_drives_json" value="<?= htmlspecialchars($data['settings']['google_drives'] ?? '[]', ENT_QUOTES, 'UTF-8') ?>">
        <div id="drives-list-container"></div>
    </div>

    <!-- Submit Action Button -->
    <div style="text-align: right; padding-top: 10px; margin-bottom: 40px;">
        <button type="submit" class="btn btn-save" style="background: var(--primary); color: white; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 10px 20px var(--primary-glow); font-size: 1rem; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </div>
</form>

<script>
    let googleDrives = [];
    try {
        googleDrives = JSON.parse(document.getElementById('google_drives_json').value || '[]');
    } catch(e) {
        googleDrives = [];
    }

    function syncDrivesJson() {
        document.getElementById('google_drives_json').value = JSON.stringify(googleDrives);
    }

    function updateStorageProviderCard() {
        const selected = document.querySelector('input[name="settings[storage_provider]"]:checked').value;
        const localCard = document.getElementById('provider-card-local');
        const gdriveCard = document.getElementById('provider-card-gdrive');

        if (selected === 'local') {
            localCard.style.borderColor = 'var(--primary)';
            localCard.style.background = '#f8fafc';
            gdriveCard.style.borderColor = '#e2e8f0';
            gdriveCard.style.background = 'white';
        } else {
            gdriveCard.style.borderColor = '#0f9d58';
            gdriveCard.style.background = '#f0fdf4';
            localCard.style.borderColor = '#e2e8f0';
            localCard.style.background = 'white';
        }
    }

    function renderDrivesList() {
        const container = document.getElementById('drives-list-container');
        if (!container) return;

        if (googleDrives.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 45px 20px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 14px;">
                    <i class="fab fa-google-drive" style="font-size: 3.5rem; color: #94a3b8; margin-bottom: 15px; display: inline-block;"></i>
                    <h4 style="margin: 0 0 6px; color: #1e293b; font-weight: 700; font-size: 1.15rem; font-family: 'Hind Siliguri', sans-serif;">কোনো গুগল ড্রাইভ অ্যাকাউন্ট যুক্ত করা হয়নি</h4>
                    <p style="margin: 0 0 20px; color: #64748b; font-size: 0.9rem; max-width: 480px; margin-left: auto; margin-right: auto; line-height: 1.5;">
                        উপরের ১-ক্লিক <strong>"Connect Google Drive"</strong> বাটনে ক্লিক করে সহজেই যেকোনো গুগল অ্যাকাউন্ট যুক্ত করুন।
                    </p>
                </div>
            `;
            return;
        }

        let html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
        googleDrives.forEach((drive, idx) => {
            const isDefault = drive.is_default ? true : false;
            const isActive = (!drive.status || drive.status === 'active');
            const authBadge = (drive.auth_type === 'oauth2') ? 
                '<span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; font-weight: 600;"><i class="fas fa-bolt"></i> 1-Click OAuth</span>' :
                '<span style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; font-weight: 600;"><i class="fas fa-key"></i> Service Account</span>';

            html += `
                <div class="gdrive-item-card" style="border: 1.5px solid ${isDefault ? '#86efac' : '#e2e8f0'}; background: ${isDefault ? '#f0fdf4' : 'white'}; border-radius: 12px; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: 0.2s;">
                    <div style="flex: 1; min-width: 250px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                            <span style="font-weight: 700; color: #0f172a; font-size: 1.05rem;">${escapeHtml(drive.name || 'Google Drive ' + (idx + 1))}</span>
                            ${authBadge}
                            ${isDefault ? '<span style="background: #fef08a; color: #854d0e; border: 1px solid #fde047; font-size: 0.75rem; padding: 2px 8px; border-radius: 6px; font-weight: 700;"><i class="fas fa-star"></i> Primary Default</span>' : ''}
                            ${isActive ? '<span style="background: #dcfce7; color: #166534; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; font-weight: 600;">Active</span>' : '<span style="background: #f1f5f9; color: #64748b; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; font-weight: 600;">Inactive</span>'}
                        </div>
                        <div style="font-size: 0.85rem; color: #64748b; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                            <span><i class="fas fa-folder" style="color: #f59e0b;"></i> Target Folder: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a;">${escapeHtml(drive.folder_id || '(Auto Records Storage)')}</code></span>
                        </div>
                        <div id="drive_test_status_${idx}" style="display: none; margin-top: 8px; font-size: 0.85rem; font-weight: 600;"></div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button type="button" id="btn_test_${idx}" onclick="testDriveAtIndex(${idx})" class="btn" style="background: white; color: #2563eb; border: 1.5px solid #bfdbfe; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;">
                            <i class="fas fa-plug"></i> Test Connection
                        </button>
                        <button type="button" onclick="deleteDriveAtIndex(${idx})" class="btn" style="background: white; color: #ef4444; border: 1.5px solid #fecaca; padding: 7px 12px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s;" title="Delete Drive">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function deleteDriveAtIndex(idx) {
        if (!confirm('আপনি কি নিশ্চিত যে এই গুগল ড্রাইভ অ্যাকাউন্টটি মুছে ফেলতে চান?')) return;
        googleDrives.splice(idx, 1);
        if (googleDrives.length > 0 && !googleDrives.some(d => d.is_default)) {
            googleDrives[0].is_default = 1;
        }
        syncDrivesJson();
        renderDrivesList();
    }

    function testDriveAtIndex(idx) {
        const drive = googleDrives[idx];
        if (!drive) return;

        const btn = document.getElementById(`btn_test_${idx}`);
        const statusDiv = document.getElementById(`drive_test_status_${idx}`);

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
        statusDiv.style.display = 'none';

        fetch('<?= URLROOT ?>/admin/test_gdrive_connection', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(drive)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Connection';
            statusDiv.style.display = 'block';

            if (data.success) {
                statusDiv.style.color = '#16a34a';
                statusDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + escapeHtml(data.message);
            } else {
                statusDiv.style.color = '#dc2626';
                statusDiv.innerHTML = '<i class="fas fa-times-circle"></i> ' + escapeHtml(data.message || 'কানেকশন ত্রুটি!');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Connection';
            statusDiv.style.display = 'block';
            statusDiv.style.color = '#dc2626';
            statusDiv.innerHTML = '<i class="fas fa-times-circle"></i> নেটওয়ার্ক সমস্যা!';
        });
    }

    (function() {
        renderDrivesList();
    })();
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
