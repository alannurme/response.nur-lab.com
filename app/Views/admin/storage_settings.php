<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="font-family: 'Hind Siliguri', sans-serif; font-size: 1.8rem; margin: 0 0 6px;">
            <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.8rem; vertical-align: middle;"></i> Google Drive ও ক্লাউড স্টোরেজ সেটিংস
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
            ওয়েবসাইটের ফাইল ও মিডিয়া গুগল ড্রাইভ ক্লাউডে স্টোর করুন এবং একাধিক ড্রাইভের অটো-ফেলওভার ব্যাকআপ পরিচালনা করুন।
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="openAddDriveModal()" class="btn" style="background: #0f9d58; color: white; border: none; padding: 11px 22px; border-radius: 12px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(15, 157, 88, 0.25); transition: 0.2s;">
            <i class="fas fa-plus"></i> + নতুন গুগল ড্রাইভ যুক্ত করুন
        </button>
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
    <!-- Storage Mode Selection -->
    <div style="background: white; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <h3 style="margin-top: 0; margin-bottom: 8px; color: #0f172a; font-weight: 700; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
            <i class="fas fa-database" style="color: var(--primary);"></i> প্রাইমারি স্টোরেজ প্রোভাইডার নির্বাচন (Primary Storage)
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            ওয়েবসাইটে আপলোড করা ছবি ও মিডিয়া ফাইলগুলো কোথায় সংরক্ষিত হবে তা বেছে নিন।
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px;">
            <!-- Local Storage Option -->
            <label class="storage-provider-card <?= (($data['settings']['storage_provider'] ?? 'local') === 'local') ? 'active-provider' : '' ?>" id="provider-card-local" style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; border: 2px solid <?= (($data['settings']['storage_provider'] ?? 'local') === 'local') ? 'var(--primary)' : '#e2e8f0' ?>; border-radius: 14px; background: <?= (($data['settings']['storage_provider'] ?? 'local') === 'local') ? '#f8fafc' : 'white' ?>; cursor: pointer; transition: 0.25s;">
                <input type="radio" name="settings[storage_provider]" value="local" <?= (($data['settings']['storage_provider'] ?? 'local') === 'local') ? 'checked' : '' ?> onchange="updateStorageProviderCard()" style="margin-top: 4px; accent-color: var(--primary); transform: scale(1.2);">
                <div>
                    <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-server" style="color: #64748b;"></i> লোকাল সার্ভার স্টোরেজ (Local Server)
                    </div>
                    <p style="margin: 6px 0 0; color: #64748b; font-size: 0.85rem; line-height: 1.4;">
                        নিজস্ব ওয়েব হোস্টিং / সার্ভার ডিস্কে সরাসরি আপলোড হবে (<code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">/public/img/</code>)।
                    </p>
                </div>
            </label>

            <!-- Google Drive Option -->
            <label class="storage-provider-card <?= (($data['settings']['storage_provider'] ?? 'local') === 'google_drive') ? 'active-provider' : '' ?>" id="provider-card-gdrive" style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; border: 2px solid <?= (($data['settings']['storage_provider'] ?? 'local') === 'google_drive') ? '#0f9d58' : '#e2e8f0' ?>; border-radius: 14px; background: <?= (($data['settings']['storage_provider'] ?? 'local') === 'google_drive') ? '#f0fdf4' : 'white' ?>; cursor: pointer; transition: 0.25s;">
                <input type="radio" name="settings[storage_provider]" value="google_drive" <?= (($data['settings']['storage_provider'] ?? 'local') === 'google_drive') ? 'checked' : '' ?> onchange="updateStorageProviderCard()" style="margin-top: 4px; accent-color: #0f9d58; transform: scale(1.2);">
                <div>
                    <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.2rem;"></i> গুগল ড্রাইভ ক্লাউড (Google Drive)
                    </div>
                    <p style="margin: 6px 0 0; color: #64748b; font-size: 0.85rem; line-height: 1.4;">
                        গুগল ড্রাইভ ক্লাউডে স্বয়ংক্রিয়ভাবে আপলোড হবে এবং দ্রুততম গুগল CDN লিংকের মাধ্যমে ওয়েবসাইটে লোড হবে।
                    </p>
                </div>
            </label>
        </div>

        <!-- Auxiliary Switches -->
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

    <!-- Connected Drives Management Section -->
    <div style="background: white; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0 0 5px; color: #0f172a; font-weight: 700; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fab fa-google-drive" style="color: #0f9d58;"></i> কানেক্টেড গুগল ড্রাইভ অ্যাকাউন্টসমূহ (Google Drive Accounts)
                </h3>
                <p style="margin: 0; color: #64748b; font-size: 0.88rem;">
                    আপনি একাধিক গুগল ড্রাইভ অ্যাকাউন্ট যুক্ত করতে পারেন। কোনো ড্রাইভ ফুল হলে অটোমেটিক অন্য সক্রিয় ড্রাইভে শিফট হবে।
                </p>
            </div>
            <button type="button" onclick="openAddDriveModal()" class="btn" style="background: #0f9d58; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(15, 157, 88, 0.25); transition: 0.2s;">
                <i class="fas fa-plus"></i> + নতুন গুগল ড্রাইভ যুক্ত করুন
            </button>
        </div>

        <!-- Hidden Input holding serialized drives JSON -->
        <input type="hidden" name="settings[google_drives]" id="google_drives_json" value="<?= htmlspecialchars($data['settings']['google_drives'] ?? '[]', ENT_QUOTES, 'UTF-8') ?>">

        <!-- Container where drives cards/table are rendered -->
        <div id="drives-list-container"></div>
    </div>

    <!-- Step-by-Step Setup Guide Box -->
    <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 18px; padding: 25px; margin-bottom: 30px;">
        <h4 style="margin-top: 0; margin-bottom: 12px; color: #166534; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; font-family: 'Hind Siliguri', sans-serif;">
            <i class="fas fa-lightbulb" style="color: #16a34a;"></i> গুগল ড্রাইভ সার্ভিস অ্যাকাউন্ট সেটআপ নির্দেশিকা (Setup Guide)
        </h4>
        <p style="color: #15803d; font-size: 0.88rem; line-height: 1.5; margin-bottom: 15px;">
            গুগল ড্রাইভকে স্টোরেজ হিসেবে ব্যবহারের জন্য সার্ভিস অ্যাকাউন্ট (Service Account) হলো সবচেয়ে দ্রুত ও নিরাপদ উপায়, যা কোনো লগইন মেয়াদ শেষ হওয়া ছাড়াই আজীবন কাজ করে।
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 15px; font-size: 0.85rem; color: #14532d;">
            <div style="background: white; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px;">
                <div style="font-weight: 700; margin-bottom: 5px; color: #166534; display: flex; align-items: center; gap: 6px;">
                    <span style="background: #22c55e; color: white; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">১</span> প্রজেক্ট তৈরি ও API চালু
                </div>
                <a href="https://console.cloud.google.com" target="_blank" style="color: #059669; text-decoration: underline; font-weight: 600;">Google Cloud Console</a>-এ যান। একটি প্রজেক্ট তৈরি করে <strong>Google Drive API</strong> সার্চ করে 'Enable' করুন।
            </div>
            <div style="background: white; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px;">
                <div style="font-weight: 700; margin-bottom: 5px; color: #166534; display: flex; align-items: center; gap: 6px;">
                    <span style="background: #22c55e; color: white; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">২</span> সার্ভিস অ্যাকাউন্ট তৈরি
                </div>
                <strong>APIs & Services &gt; Credentials</strong>-এ গিয়ে <strong>Create Credentials &gt; Service Account</strong> সিলেক্ট করে যে কোনো নাম দিয়ে অ্যাকাউন্ট তৈরি করুন।
            </div>
            <div style="background: white; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px;">
                <div style="font-weight: 700; margin-bottom: 5px; color: #166534; display: flex; align-items: center; gap: 6px;">
                    <span style="background: #22c55e; color: white; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">৩</span> JSON Key ডাউনলোড
                </div>
                তৈরি করা সার্ভিস অ্যাকাউন্টের <strong>Keys</strong> ট্যাবে গিয়ে <strong>Add Key &gt; Create new key (JSON)</strong> ক্লিক করে কী ফাইলটি ডাউনলোড করুন।
            </div>
            <div style="background: white; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px;">
                <div style="font-weight: 700; margin-bottom: 5px; color: #166534; display: flex; align-items: center; gap: 6px;">
                    <span style="background: #22c55e; color: white; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">৪</span> ড্রাইভ ফোল্ডার শেয়ার
                </div>
                গুগল ড্রাইভে একটি ফোল্ডার তৈরি করুন। ফোল্ডারের Share অপশনে সার্ভিস অ্যাকাউন্টের ইমেইল (<code style="background: #f1f5f9; padding: 1px 4px; border-radius: 3px;">...@....iam.gserviceaccount.com</code>) টি <strong>Editor</strong> হিসেবে দিয়ে শেয়ার করুন।
            </div>
        </div>
    </div>

    <!-- Submit Action Button -->
    <div style="text-align: right; padding-top: 10px; margin-bottom: 40px;">
        <button type="submit" class="btn btn-save" style="background: var(--primary); color: white; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 10px 20px var(--primary-glow); font-size: 1rem; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-save"></i> Save Storage Settings
        </button>
    </div>
</form>

<!-- Google Drive Add / Edit Modal -->
<div id="gdriveModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 10001; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 20px;">
    <div style="background: white; border-radius: 18px; width: 100%; max-width: 650px; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35); animation: fadeIn 0.25s ease;">
        <!-- Modal Header -->
        <div style="padding: 20px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 id="gdriveModalTitle" style="font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif; font-size: 1.2rem;">
                <i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.3rem;"></i> গুগল ড্রাইভ অ্যাকাউন্ট কনফিগারেশন
            </h3>
            <button type="button" onclick="closeDriveModal()" style="background: none; border: none; font-size: 1.4rem; color: #64748b; cursor: pointer; transition: 0.2s; line-height: 1;"><i class="fas fa-times"></i></button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 25px; overflow-y: auto; flex: 1;">
            <input type="hidden" id="modal_drive_index" value="-1">

            <!-- Drive Name -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                    ড্রাইভের নাম / লেবেল (Drive Name) <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="modal_drive_name" class="form-control" placeholder="যেমন: Primary Drive, Backup 15GB, Media Storage..." style="border-radius: 10px; width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; box-sizing: border-box;">
            </div>

            <!-- Authentication Method Selection -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                    অথেনটিকেশন পদ্ধতি (Authentication Method) <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label id="auth_type_label_sa" style="display: flex; align-items: center; gap: 10px; padding: 12px 15px; border: 2px solid #0f9d58; border-radius: 10px; background: #f0fdf4; cursor: pointer; font-weight: 600; font-size: 0.88rem; color: #166534;">
                        <input type="radio" name="modal_auth_type" value="service_account" checked onchange="toggleModalAuthFields()" style="accent-color: #0f9d58;">
                        <span><i class="fas fa-key"></i> Service Account JSON (রিকমেন্ডেড)</span>
                    </label>
                    <label id="auth_type_label_oauth" style="display: flex; align-items: center; gap: 10px; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; background: white; cursor: pointer; font-weight: 600; font-size: 0.88rem; color: #475569;">
                        <input type="radio" name="modal_auth_type" value="oauth2" onchange="toggleModalAuthFields()" style="accent-color: #2563eb;">
                        <span><i class="fas fa-lock"></i> OAuth 2.0 Credentials</span>
                    </label>
                </div>
            </div>

            <!-- Service Account Fields -->
            <div id="modal_section_sa" style="margin-bottom: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
                <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                    Service Account JSON কী (Key) <span style="color: #ef4444;">*</span>
                </label>
                
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <label class="btn" style="background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-file-upload"></i> .json কী ফাইল আপলোড করুন
                        <input type="file" id="modal_sa_file" accept=".json,application/json" onchange="handleSaFileUpload(event)" style="display: none;">
                    </label>
                    <span style="font-size: 0.8rem; color: #64748b;">অথবা নিচে সরাসরি JSON পেস্ট করুন:</span>
                </div>

                <textarea id="modal_sa_json" rows="6" class="form-control" placeholder='{\n  "type": "service_account",\n  "project_id": "...",\n  "private_key_id": "...",\n  "private_key": "-----BEGIN PRIVATE KEY-----\\n...",\n  "client_email": "..."\n}' style="font-family: monospace; font-size: 0.82rem; line-height: 1.4; border-radius: 8px; background: white; width: 100%; padding: 10px; border: 1.5px solid #cbd5e1; box-sizing: border-box;" oninput="validateSaJsonInput()"></textarea>

                <div id="modal_sa_detected_badge" style="display: none; margin-top: 10px; padding: 8px 12px; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; font-size: 0.82rem; color: #166534; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> ক্লায়েন্ট ইমেইল শনাক্ত হয়েছে: <span id="modal_sa_detected_email" style="font-family: monospace;"></span>
                </div>
            </div>

            <!-- OAuth 2.0 Fields -->
            <div id="modal_section_oauth" style="display: none; margin-bottom: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Client ID</label>
                    <input type="text" id="modal_oauth_client_id" class="form-control" placeholder="Google OAuth Client ID" style="border-radius: 8px; width: 100%; padding: 10px; border: 1.5px solid #cbd5e1; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Client Secret</label>
                    <input type="password" id="modal_oauth_client_secret" class="form-control" placeholder="Google OAuth Client Secret" style="border-radius: 8px; width: 100%; padding: 10px; border: 1.5px solid #cbd5e1; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Refresh Token</label>
                    <input type="text" id="modal_oauth_refresh_token" class="form-control" placeholder="Google OAuth Refresh Token" style="border-radius: 8px; width: 100%; padding: 10px; border: 1.5px solid #cbd5e1; box-sizing: border-box;">
                </div>
            </div>

            <!-- Target Folder ID -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                    গুগল ড্রাইভ ফোল্ডার আইডি (Target Folder ID) <span style="color: #64748b; font-weight: normal; font-size: 0.82rem;">(ঐচ্ছিক কিন্তু বাঞ্ছনীয়)</span>
                </label>
                <input type="text" id="modal_drive_folder_id" class="form-control" placeholder="যেমন: 1BxiMVs0XRA5nFMdKvBHKubT9tPn..." style="border-radius: 10px; width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; box-sizing: border-box;">
                <small style="color: #64748b; font-size: 0.82rem; margin-top: 6px; display: block; line-height: 1.4;">
                    <i class="fas fa-info-circle" style="color: #3b82f6;"></i> ড্রাইভের ফোল্ডারের URL-এর শেষের আইডিটি কপি করুন। ফোল্ডারটি অবশ্যই সার্ভিস অ্যাকাউন্টের ইমেইলে <strong>'Editor'</strong> হিসেবে শেয়ার করতে হবে।
                </small>
            </div>

            <!-- Checkboxes (Default, Active) -->
            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 10px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 600; color: #1e293b;">
                    <input type="checkbox" id="modal_drive_is_default" style="accent-color: #0f9d58; transform: scale(1.15);">
                    <span><i class="fas fa-star" style="color: #eab308;"></i> ডিফল্ট ড্রাইভ করুন (Primary Drive)</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 600; color: #1e293b;">
                    <input type="checkbox" id="modal_drive_is_active" checked style="accent-color: #0f9d58; transform: scale(1.15);">
                    <span>সক্রিয় রাখুন (Active)</span>
                </label>
            </div>

            <!-- Live Test Alert Box in Modal -->
            <div id="modal_test_result" style="display: none; padding: 12px 16px; border-radius: 10px; margin-bottom: 15px; font-size: 0.88rem; font-weight: 600; line-height: 1.4;"></div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 18px 25px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <button type="button" id="modal_btn_test" onclick="testModalDriveConnection()" class="btn" style="background: #3b82f6; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;">
                <i class="fas fa-plug"></i> Test Connection
            </button>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeDriveModal()" class="btn" style="background: #e2e8f0; color: #475569; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">
                    বাতিল
                </button>
                <button type="button" onclick="saveDriveModal()" class="btn" style="background: #0f9d58; color: white; border: none; padding: 10px 22px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(15, 157, 88, 0.25);">
                    <i class="fas fa-check"></i> ড্রাইভে সংরক্ষণ করুন
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Storage Provider UI Highlighting
    function updateStorageProviderCard() {
        const selected = document.querySelector('input[name="settings[storage_provider]"]:checked').value;
        const localCard = document.getElementById('provider-card-local');
        const gdriveCard = document.getElementById('provider-card-gdrive');

        if (selected === 'google_drive') {
            gdriveCard.style.borderColor = '#0f9d58';
            gdriveCard.style.background = '#f0fdf4';
            localCard.style.borderColor = '#e2e8f0';
            localCard.style.background = 'white';
        } else {
            localCard.style.borderColor = 'var(--primary)';
            localCard.style.background = '#f8fafc';
            gdriveCard.style.borderColor = '#e2e8f0';
            gdriveCard.style.background = 'white';
        }
    }

    // Google Drives Data Store
    let googleDrives = [];
    try {
        const jsonVal = document.getElementById('google_drives_json').value;
        googleDrives = jsonVal ? JSON.parse(jsonVal) : [];
        if (!Array.isArray(googleDrives)) googleDrives = [];
    } catch(e) {
        googleDrives = [];
    }

    function syncDrivesJson() {
        document.getElementById('google_drives_json').value = JSON.stringify(googleDrives);
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
                        গুগল ড্রাইভকে ক্লাউড স্টোরেজ হিসেবে ব্যবহার করতে এবং একাধিক ড্রাইভের অটো-ব্যাকআপ সুবিধা পেতে একটি অ্যাকাউন্ট যুক্ত করুন।
                    </p>
                    <button type="button" onclick="openAddDriveModal()" class="btn" style="background: #0f9d58; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(15, 157, 88, 0.25);">
                        <i class="fas fa-plus"></i> + প্রথম গুগল ড্রাইভ যুক্ত করুন
                    </button>
                </div>
            `;
            return;
        }

        let html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
        googleDrives.forEach((drive, idx) => {
            const isDefault = drive.is_default ? true : false;
            const isActive = (!drive.status || drive.status === 'active');
            const authBadge = (drive.auth_type === 'oauth2') ? 
                '<span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; font-weight: 600;"><i class="fas fa-lock"></i> OAuth 2.0</span>' :
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
                            <span><i class="fas fa-folder" style="color: #f59e0b;"></i> Folder ID: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a;">${escapeHtml(drive.folder_id || '(Root Folder)')}</code></span>
                            ${drive.client_email ? `<span style="font-size: 0.8rem; color: #475569;"><i class="fas fa-envelope"></i> ${escapeHtml(drive.client_email)}</span>` : ''}
                        </div>
                        <div id="drive_test_status_${idx}" style="display: none; margin-top: 8px; font-size: 0.85rem; font-weight: 600;"></div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button type="button" id="btn_test_${idx}" onclick="testDriveAtIndex(${idx})" class="btn" style="background: white; color: #2563eb; border: 1.5px solid #bfdbfe; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;">
                            <i class="fas fa-plug"></i> Test Connection
                        </button>
                        <button type="button" onclick="openAddDriveModal(${idx})" class="btn" style="background: white; color: #475569; border: 1.5px solid #cbd5e1; padding: 7px 12px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s;" title="Edit Drive">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" onclick="deleteDriveAtIndex(${idx})" class="btn" style="background: white; color: #ef4444; border: 1.5px solid #fecaca; padding: 7px 12px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s;" title="Delete Drive">
                            <i class="fas fa-trash-alt"></i>
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

    // Modal Control
    function toggleModalAuthFields() {
        const type = document.querySelector('input[name="modal_auth_type"]:checked').value;
        const saSec = document.getElementById('modal_section_sa');
        const oauthSec = document.getElementById('modal_section_oauth');
        const saLabel = document.getElementById('auth_type_label_sa');
        const oauthLabel = document.getElementById('auth_type_label_oauth');

        if (type === 'service_account') {
            saSec.style.display = 'block';
            oauthSec.style.display = 'none';
            saLabel.style.borderColor = '#0f9d58';
            saLabel.style.background = '#f0fdf4';
            oauthLabel.style.borderColor = '#e2e8f0';
            oauthLabel.style.background = 'white';
        } else {
            saSec.style.display = 'none';
            oauthSec.style.display = 'block';
            oauthLabel.style.borderColor = '#2563eb';
            oauthLabel.style.background = '#eff6ff';
            saLabel.style.borderColor = '#e2e8f0';
            saLabel.style.background = 'white';
        }
    }

    function openAddDriveModal(index = -1) {
        const modal = document.getElementById('gdriveModal');
        const title = document.getElementById('gdriveModalTitle');
        document.getElementById('modal_drive_index').value = index;
        document.getElementById('modal_test_result').style.display = 'none';

        if (index >= 0 && googleDrives[index]) {
            const drive = googleDrives[index];
            title.innerHTML = '<i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.3rem;"></i> গুগল ড্রাইভ সম্পাদন করুন (Edit Drive)';
            document.getElementById('modal_drive_name').value = drive.name || '';
            const authType = drive.auth_type || 'service_account';
            const authRadio = document.querySelector(`input[name="modal_auth_type"][value="${authType}"]`);
            if (authRadio) authRadio.checked = true;

            document.getElementById('modal_sa_json').value = drive.service_account_json || '';
            document.getElementById('modal_oauth_client_id').value = drive.client_id || '';
            document.getElementById('modal_oauth_client_secret').value = drive.client_secret || '';
            document.getElementById('modal_oauth_refresh_token').value = drive.refresh_token || '';
            document.getElementById('modal_drive_folder_id').value = drive.folder_id || '';
            document.getElementById('modal_drive_is_default').checked = drive.is_default ? true : false;
            document.getElementById('modal_drive_is_active').checked = (!drive.status || drive.status === 'active');
            validateSaJsonInput();
        } else {
            title.innerHTML = '<i class="fab fa-google-drive" style="color: #0f9d58; font-size: 1.3rem;"></i> নতুন গুগল ড্রাইভ যুক্ত করুন (Add Drive)';
            document.getElementById('modal_drive_name').value = 'Google Drive ' + (googleDrives.length + 1);
            document.querySelector('input[name="modal_auth_type"][value="service_account"]').checked = true;
            document.getElementById('modal_sa_json').value = '';
            document.getElementById('modal_oauth_client_id').value = '';
            document.getElementById('modal_oauth_client_secret').value = '';
            document.getElementById('modal_oauth_refresh_token').value = '';
            document.getElementById('modal_drive_folder_id').value = '';
            document.getElementById('modal_drive_is_default').checked = (googleDrives.length === 0);
            document.getElementById('modal_drive_is_active').checked = true;
            document.getElementById('modal_sa_detected_badge').style.display = 'none';
        }

        toggleModalAuthFields();
        modal.style.display = 'flex';
    }

    function closeDriveModal() {
        document.getElementById('gdriveModal').style.display = 'none';
    }

    // Read uploaded .json file
    function handleSaFileUpload(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(evt) {
            document.getElementById('modal_sa_json').value = evt.target.result;
            validateSaJsonInput();
        };
        reader.readAsText(file);
    }

    function validateSaJsonInput() {
        const val = document.getElementById('modal_sa_json').value.trim();
        const badge = document.getElementById('modal_sa_detected_badge');
        const emailSpan = document.getElementById('modal_sa_detected_email');

        try {
            const parsed = JSON.parse(val);
            if (parsed.client_email) {
                badge.style.display = 'block';
                emailSpan.textContent = parsed.client_email;
                return parsed.client_email;
            }
        } catch(err) {}
        badge.style.display = 'none';
        return null;
    }

    // Modal Save
    function saveDriveModal() {
        const name = document.getElementById('modal_drive_name').value.trim();
        const authType = document.querySelector('input[name="modal_auth_type"]:checked').value;
        const folderId = document.getElementById('modal_drive_folder_id').value.trim();
        const isDefault = document.getElementById('modal_drive_is_default').checked ? 1 : 0;
        const isActive = document.getElementById('modal_drive_is_active').checked ? 'active' : 'inactive';
        const index = parseInt(document.getElementById('modal_drive_index').value, 10);

        if (!name) {
            alert('অনুগ্রহ করে ড্রাইভের একটি নাম লিখুন।');
            return;
        }

        let driveObj = {
            id: (index >= 0 && googleDrives[index] && googleDrives[index].id) ? googleDrives[index].id : 'gdrive_' + Date.now(),
            name: name,
            auth_type: authType,
            folder_id: folderId,
            is_default: isDefault,
            status: isActive
        };

        if (authType === 'service_account') {
            const saJson = document.getElementById('modal_sa_json').value.trim();
            if (!saJson) {
                alert('অনুগ্রহ করে Service Account JSON কী প্রদান করুন।');
                return;
            }
            try {
                const parsed = JSON.parse(saJson);
                if (!parsed.client_email || !parsed.private_key) {
                    alert('প্রদত্ত JSON ফাইলটি সঠিক নয় (client_email অথবা private_key অনুপস্থিত)।');
                    return;
                }
                driveObj.client_email = parsed.client_email;
            } catch(e) {
                alert('JSON কোডটি সঠিক ফরম্যাটে নেই। অনুগ্রহ করে ফাইল চেক করুন।');
                return;
            }
            driveObj.service_account_json = saJson;
        } else {
            const clientId = document.getElementById('modal_oauth_client_id').value.trim();
            const clientSecret = document.getElementById('modal_oauth_client_secret').value.trim();
            const refreshToken = document.getElementById('modal_oauth_refresh_token').value.trim();
            if (!clientId || !clientSecret || !refreshToken) {
                alert('OAuth Client ID, Secret এবং Refresh Token সবগুলো পূরণ করুন।');
                return;
            }
            driveObj.client_id = clientId;
            driveObj.client_secret = clientSecret;
            driveObj.refresh_token = refreshToken;
        }

        // If this drive is marked default, unset default on other drives
        if (isDefault) {
            googleDrives.forEach(d => d.is_default = 0);
        }

        if (index >= 0) {
            googleDrives[index] = driveObj;
        } else {
            if (googleDrives.length === 0) {
                driveObj.is_default = 1;
            }
            googleDrives.push(driveObj);
        }

        syncDrivesJson();
        renderDrivesList();
        closeDriveModal();
    }

    function deleteDriveAtIndex(idx) {
        if (confirm('আপনি কি নিশ্চিতভাবে এই গুগল ড্রাইভ অ্যাকাউন্টটি মুছে ফেলতে চান?')) {
            googleDrives.splice(idx, 1);
            if (googleDrives.length > 0 && !googleDrives.some(d => d.is_default)) {
                googleDrives[0].is_default = 1;
            }
            syncDrivesJson();
            renderDrivesList();
        }
    }

    // Live Test inside Modal
    function testModalDriveConnection() {
        const btn = document.getElementById('modal_btn_test');
        const resDiv = document.getElementById('modal_test_result');
        const authType = document.querySelector('input[name="modal_auth_type"]:checked').value;
        const folderId = document.getElementById('modal_drive_folder_id').value.trim();

        let driveData = {
            auth_type: authType,
            folder_id: folderId
        };

        if (authType === 'service_account') {
            const saJson = document.getElementById('modal_sa_json').value.trim();
            if (!saJson) {
                alert('টেস্ট করার পূর্বে Service Account JSON প্রদান করুন।');
                return;
            }
            driveData.service_account_json = saJson;
        } else {
            driveData.client_id = document.getElementById('modal_oauth_client_id').value.trim();
            driveData.client_secret = document.getElementById('modal_oauth_client_secret').value.trim();
            driveData.refresh_token = document.getElementById('modal_oauth_refresh_token').value.trim();
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connecting...';
        resDiv.style.display = 'none';

        fetch('<?= URLROOT ?>/admin/test_gdrive_connection', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(driveData)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Connection';
            resDiv.style.display = 'block';

            if (data.success) {
                resDiv.style.background = '#dcfce7';
                resDiv.style.color = '#166534';
                resDiv.style.border = '1px solid #86efac';
                resDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + escapeHtml(data.message);
            } else {
                resDiv.style.background = '#fee2e2';
                resDiv.style.color = '#991b1b';
                resDiv.style.border = '1px solid #fca5a5';
                resDiv.innerHTML = '<i class="fas fa-times-circle"></i> ' + escapeHtml(data.message || 'কানেকশন ব্যর্থ হয়েছে।');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Connection';
            resDiv.style.display = 'block';
            resDiv.style.background = '#fee2e2';
            resDiv.style.color = '#991b1b';
            resDiv.style.border = '1px solid #fca5a5';
            resDiv.innerHTML = '<i class="fas fa-times-circle"></i> নেটওয়ার্ক সমস্যা! অনুগ্রহ করে পুনরায় চেষ্টা করুন।';
        });
    }

    // Live Test on list item
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

    // Initial render on page load
    (function() {
        renderDrivesList();
    })();
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

