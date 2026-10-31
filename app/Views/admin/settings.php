<?php require APPROOT . '/Views/admin/header.php'; 
$logo_url = !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : '';
$favicon_url = !empty($data['settings']['site_favicon']) ? resolve_setting_image($data['settings']['site_favicon']) : '';
?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Site Settings</h1>
        <p>Configure your website's core information and SEO</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success"><?= $data['success'] ?></div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;"><?= $data['error'] ?></div>
<?php endif; ?>

<div class="settings-container">
    <form action="<?= URLROOT ?>/admin/settings" method="POST" enctype="multipart/form-data">
        <!-- Tabs Navigation -->
        <div class="settings-tabs">
            <button type="button" class="tab-btn active" data-tab="general"><i class="fas fa-info-circle"></i> General</button>
            <button type="button" class="tab-btn" data-tab="contact"><i class="fas fa-envelope"></i> Contact</button>
            <button type="button" class="tab-btn" data-tab="seo"><i class="fas fa-search"></i> SEO Settings</button>
            <button type="button" class="tab-btn" data-tab="email_server"><i class="fas fa-server"></i> Email Server</button>
            <button type="button" class="tab-btn" data-tab="system_info"><i class="fas fa-microchip"></i> System Info</button>
        </div>

        <!-- General Settings -->
        <div class="tab-content active" id="general">
            <div class="form-grid">
                <div class="form-group">
                    <label>Site Title</label>
                    <input type="text" name="settings[site_title]" value="<?= $data['settings']['site_title'] ?? '' ?>" class="form-control" placeholder="Enter Site Title">
                </div>
                <div class="form-group">
                    <label>Site Tagline</label>
                    <input type="text" name="settings[site_tagline]" value="<?= $data['settings']['site_tagline'] ?? '' ?>" class="form-control" placeholder="Enter Site Tagline">
                </div>

                <div class="form-group full-width">
                    <label>Site Description</label>
                    <textarea name="settings[site_description]" class="form-control" rows="3"><?= $data['settings']['site_description'] ?? '' ?></textarea>
                </div>
                <div class="form-group full-width">
                    <label>Footer Copyright Text</label>
                    <input type="text" name="settings[footer_copyright]" value="<?= $data['settings']['footer_copyright'] ?? '' ?>" class="form-control" placeholder="e.g. &copy; 2026 NUR-LAB. All Rights Reserved.">
                    <small style="color: #64748b;">This will appear on the left side of the footer.</small>
                </div>
                <div class="form-group full-width">
                    <label>Android App Download URL</label>
                    <input type="text" name="settings[app_download_url]" value="<?= $data['settings']['app_download_url'] ?? '' ?>" class="form-control" placeholder="e.g. https://play.google.com/store/apps/details?id=com.nurlab">
                    <small style="color: #64748b;">Link to download the android application.</small>
                </div>
                <div class="form-group">
                    <label>Site Logo</label>
                    <div class="preview-box logo-preview-container" style="display: <?= !empty($logo_url) ? 'block' : 'none' ?>;">
                        <img id="logo-preview-img" src="<?= $logo_url ?>" alt="Logo Preview" style="max-height: 80px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; gap: 10px;">
                            <button type="button" class="btn btn-secondary btn-select-media" data-target="site_logo_path" data-preview="logo-preview-img" data-container="logo-preview-container" style="background: #4b5563; color: white; border: none; padding: 10px 15px; border-radius: 10px; cursor: pointer; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.2s;">
                                <i class="fas fa-images"></i> Choose from Media
                            </button>
                            <span style="align-self: center; color: #64748b; font-size: 0.85rem; font-weight: 600;">Or Upload New</span>
                        </div>
                        <input type="file" name="site_logo" class="form-control">
                        <input type="hidden" name="settings[site_logo]" id="site_logo_path" value="<?= $logo_url ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Favicon</label>
                    <div class="preview-box favicon-preview-container" style="display: <?= !empty($favicon_url) ? 'block' : 'none' ?>;">
                        <img id="favicon-preview-img" src="<?= $favicon_url ?>" alt="Favicon Preview" style="max-height: 40px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ddd; padding: 5px;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; gap: 10px;">
                            <button type="button" class="btn btn-secondary btn-select-media" data-target="site_favicon_path" data-preview="favicon-preview-img" data-container="favicon-preview-container" style="background: #4b5563; color: white; border: none; padding: 10px 15px; border-radius: 10px; cursor: pointer; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.2s;">
                                <i class="fas fa-images"></i> Choose from Media
                            </button>
                            <span style="align-self: center; color: #64748b; font-size: 0.85rem; font-weight: 600;">Or Upload New</span>
                        </div>
                        <input type="file" name="site_favicon" class="form-control">
                        <input type="hidden" name="settings[site_favicon]" id="site_favicon_path" value="<?= $favicon_url ?>">
                    </div>
                </div>
                
            </div>
        </div>




        <!-- Contact Settings -->
        <div class="tab-content" id="contact">
            <div class="form-grid">
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="email" name="settings[contact_email]" value="<?= $data['settings']['contact_email'] ?? '' ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input type="text" name="settings[contact_phone]" value="<?= $data['settings']['contact_phone'] ?? '' ?>" class="form-control">
                </div>
                <div class="form-group full-width">
                    <label>Office Address</label>
                    <textarea name="settings[contact_address]" class="form-control" rows="2"><?= $data['settings']['contact_address'] ?? '' ?></textarea>
                </div>
            </div>
        </div>



        <!-- SEO Settings -->
        <div class="tab-content" id="seo">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Meta Keywords (Comma separated)</label>
                    <input type="text" name="settings[meta_keywords]" value="<?= $data['settings']['meta_keywords'] ?? '' ?>" class="form-control" placeholder="islamic, news, quran, hadith">
                </div>
                <div class="form-group full-width">
                    <label>Meta Description (For Google Search Results)</label>
                    <textarea name="settings[meta_description]" class="form-control" rows="4"><?= $data['settings']['meta_description'] ?? '' ?></textarea>
                </div>
                <div class="form-group">
                    <label>Google Analytics ID</label>
                    <input type="text" name="settings[ga_id]" value="<?= $data['settings']['ga_id'] ?? '' ?>" class="form-control" placeholder="UA-XXXXXXX-X">
                </div>
            </div>
        </div>

        <!-- Email Server Settings -->
        <div class="tab-content" id="email_server">

            <!-- Mail Method Selector -->
            <div class="form-group" style="margin-bottom: 28px;">
                <label style="font-weight: 700; font-size: 0.9rem; display: block; margin-bottom: 10px;">Mail Sending Method</label>
                <div style="display: flex; gap: 12px;">
                    <label style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; flex: 1; transition: 0.2s;" id="method-label-sendmail">
                        <input type="radio" name="settings[mail_method]" value="sendmail"
                            <?= ($data['settings']['mail_method'] ?? 'smtp') === 'sendmail' ? 'checked' : '' ?>
                            onchange="toggleMailMethod()" style="accent-color: var(--primary);">
                        <span>
                            <strong style="display:block;">Sendmail</strong>
                            <small style="color: var(--text-muted);">PHP mail() — SMTP ছাড়া সরাসরি</small>
                        </span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; flex: 1; transition: 0.2s;" id="method-label-smtp">
                        <input type="radio" name="settings[mail_method]" value="smtp"
                            <?= ($data['settings']['mail_method'] ?? 'smtp') === 'smtp' ? 'checked' : '' ?>
                            onchange="toggleMailMethod()" style="accent-color: var(--primary);">
                        <span>
                            <strong style="display:block;">SMTP</strong>
                            <small style="color: var(--text-muted);">Custom SMTP server দিয়ে পাঠান</small>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Sendmail fields (shown when sendmail selected) -->
            <div id="sendmail-fields" style="<?= ($data['settings']['mail_method'] ?? 'smtp') === 'sendmail' ? '' : 'display:none;' ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label>From Email</label>
                        <input type="email" name="settings[mail_from_email]" value="<?= $data['settings']['mail_from_email'] ?? '' ?>" class="form-control" placeholder="e.g. no-reply@example.com">
                        <small style="color: var(--text-muted); font-size: 0.78rem; margin-top: 4px; display: block;">ইমেইলে যে ঠিকানা থেকে পাঠানো হবে বলে দেখাবে।</small>
                    </div>
                    <div class="form-group">
                        <label>From Name</label>
                        <input type="text" name="settings[smtp_from_name]" value="<?= $data['settings']['smtp_from_name'] ?? '' ?>" class="form-control" placeholder="e.g. Islamic News Portal">
                    </div>
                </div>
                <div style="background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; font-size: 0.88rem; color: #92400e; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 6px;"></i>
                    <strong>Sendmail</strong> কাজ করতে হলে সার্ভারে <code>sendmail</code> বা <code>mail()</code> সক্রিয় থাকতে হবে। XAMPP local server-এ কাজ নাও করতে পারে — তবে live hosting-এ সাধারণত কাজ করে।
                </div>
            </div>

            <!-- SMTP fields (shown when smtp selected) -->
            <div id="smtp-fields" style="<?= ($data['settings']['mail_method'] ?? 'smtp') !== 'sendmail' ? '' : 'display:none;' ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label>SMTP Host</label>
                        <input type="text" name="settings[smtp_host]" value="<?= $data['settings']['smtp_host'] ?? '' ?>" class="form-control" placeholder="e.g. smtp.gmail.com">
                    </div>
                    <div class="form-group">
                        <label>SMTP Port</label>
                        <input type="text" name="settings[smtp_port]" value="<?= $data['settings']['smtp_port'] ?? '' ?>" class="form-control" placeholder="e.g. 587 or 465">
                    </div>
                    <div class="form-group">
                        <label>SMTP Username</label>
                        <input type="text" name="settings[smtp_user]" value="<?= $data['settings']['smtp_user'] ?? '' ?>" class="form-control" placeholder="Your email address">
                    </div>
                    <div class="form-group">
                        <label>SMTP Password</label>
                        <input type="password" name="settings[smtp_pass]" value="" class="form-control" placeholder="<?= !empty($data['settings']['smtp_pass']) ? '•••••••• (Leave blank to keep unchanged)' : 'Enter email password' ?>" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label>SMTP Encryption</label>
                        <select name="settings[smtp_encryption]" class="form-control">
                            <option value="tls" <?= ($data['settings']['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' ?>>TLS</option>
                            <option value="ssl" <?= ($data['settings']['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' ?>>SSL</option>
                            <option value="none" <?= ($data['settings']['smtp_encryption'] ?? '') == 'none' ? 'selected' : '' ?>>None</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>From Name</label>
                        <input type="text" name="settings[smtp_from_name]" value="<?= $data['settings']['smtp_from_name'] ?? '' ?>" class="form-control" placeholder="e.g. Islamic News Portal">
                    </div>
                </div>
            </div>

            <!-- Mail Test -->
            <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid rgba(0,0,0,0.08);">
                <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--text-main); font-weight: 700; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-paper-plane" style="color: var(--primary);"></i> Mail Connection Test (লাইভ টেস্ট)
                </h4>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                    আপনার কনফিগার করা মেইল সেটিং সঠিকভাবে কাজ করছে কি না তা যাচাই করতে নিচে একটি ইমেইল এড্রেস লিখে টেস্ট মেইল পাঠান।
                </p>

                <div id="smtp-test-result" style="display: none; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 0.9rem; font-family: 'Hind Siliguri', sans-serif;"></div>

                <div style="display: flex; gap: 10px; max-width: 550px; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 600; color: var(--text-main);">Receiver Email Address</label>
                        <input type="email" id="test_email" class="form-control" placeholder="Enter recipient email (e.g. test@example.com)" style="height: 42px;">
                    </div>
                    <button type="button" id="btn-send-test-email" onclick="runSmtpTest()" class="btn btn-primary" style="height: 42px; display: inline-flex; align-items: center; gap: 8px; background: var(--primary); color: white; border: none; padding: 0 20px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.2s;">
                        <i class="fas fa-paper-plane"></i> Send Test Email
                    </button>
                </div>
            <script>
            function toggleMailMethod() {
                const selected = document.querySelector('input[name="settings[mail_method]"]:checked').value;
                const smtpFields    = document.getElementById('smtp-fields');
                const sendmailFields = document.getElementById('sendmail-fields');
                const labelSMTP     = document.getElementById('method-label-smtp');
                const labelSendmail = document.getElementById('method-label-sendmail');

                if (selected === 'sendmail') {
                    smtpFields.style.display    = 'none';
                    sendmailFields.style.display = '';
                    labelSendmail.style.borderColor = 'var(--primary)';
                    labelSMTP.style.borderColor     = '#e2e8f0';
                } else {
                    smtpFields.style.display    = '';
                    sendmailFields.style.display = 'none';
                    labelSMTP.style.borderColor     = 'var(--primary)';
                    labelSendmail.style.borderColor = '#e2e8f0';
                }
            }
            // Highlight active label on load
            (function() { toggleMailMethod(); })();

            function runSmtpTest() {
                const emailInput = document.getElementById('test_email');
                const email = emailInput.value.trim();
                const resultDiv = document.getElementById('smtp-test-result');
                const testBtn   = document.getElementById('btn-send-test-email');

                if (!email) {
                    alert('অনুগ্রহ করে টেস্ট ইমেইল পাঠানোর ঠিকানাটি লিখুন।');
                    return;
                }

                const method      = document.querySelector('input[name="settings[mail_method]"]:checked').value;
                const host        = document.querySelector('input[name="settings[smtp_host]"]').value;
                const port        = document.querySelector('input[name="settings[smtp_port]"]').value;
                const user        = document.querySelector('input[name="settings[smtp_user]"]').value;
                const pass        = document.querySelector('input[name="settings[smtp_pass]"]').value;
                const encryption  = document.querySelector('select[name="settings[smtp_encryption]"]').value;
                const from_name   = document.querySelector('input[name="settings[smtp_from_name]"]').value;
                const from_email  = document.querySelector('input[name="settings[mail_from_email]"]') ? document.querySelector('input[name="settings[mail_from_email]"]').value : '';

                testBtn.disabled  = true;
                testBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                resultDiv.style.display = 'none';

                fetch('<?= URLROOT ?>/admin/send_test_email', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        test_email:      email,
                        mail_method:     method,
                        mail_from_email: from_email,
                        smtp_host:       host,
                        smtp_port:       port,
                        smtp_user:       user,
                        smtp_pass:       pass,
                        smtp_encryption: encryption,
                        smtp_from_name:  from_name
                    })
                })
                .then(response => response.json())
                .then(data => {
                    testBtn.disabled  = false;
                    testBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Test Email';
                    resultDiv.style.display = 'block';
                    if (data.success) {
                        resultDiv.style.background = '#d1e7dd';
                        resultDiv.style.color  = '#0f5132';
                        resultDiv.style.border = '1px solid #badbcc';
                        resultDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                    } else {
                        resultDiv.style.background = '#fee2e2';
                        resultDiv.style.color = '#ef4444';
                        resultDiv.style.border = '1px solid #fecaca';
                        resultDiv.innerHTML = '<i class="fas fa-times-circle"></i> ' + data.message;
                    }
                })
                .catch(error => {
                    testBtn.disabled = false;
                    testBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Test Email';
                    resultDiv.style.display = 'block';
                    resultDiv.style.background = '#fee2e2';
                    resultDiv.style.color = '#ef4444';
                    resultDiv.style.border = '1px solid #fecaca';
                    resultDiv.innerHTML = '<i class="fas fa-times-circle"></i> নেটওয়ার্ক কানেকশন ত্রুটি! আবার চেষ্টা করুন।';
                });
            }
            </script>
        </div>

        </div>

        <!-- System Info Tab Content -->
        <div class="tab-content" id="system_info">
            <?php
            $db_connected = false;
            $db_version = 'N/A';
            $total_tables = 0;
            try {
                $db_pdo = \Config\Database::pdoConnect();

                $db_connected = true;
                $db_version = $db_pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
                $tables_query = $db_pdo->query("SHOW TABLES");
                if ($tables_query) {
                    $total_tables = $tables_query->rowCount();
                }
            } catch (\Exception $e) {
                // Ignore and keep defaults
            }

            // Check HTTPS
            $is_https = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1) ||
                        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https';

            // Check mod_rewrite
            $htaccess_exists = file_exists(dirname(APPROOT) . '/.htaccess');
            ?>
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 25px; background: #fafafa;">
                <h4 style="margin-top: 0; margin-bottom: 20px; color: var(--text-main); font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-server" style="color: var(--primary); font-size: 1.2rem;"></i> Server & System Environment
                </h4>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <!-- Software Requirements -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-info-circle" style="color: #4299e1;"></i> Software Requirements
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">PHP Version</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700;">
                                    <?= PHP_VERSION ?> 
                                    <?php if (version_compare(PHP_VERSION, '7.4.0', '>=')): ?>
                                        <span style="color: #48bb78; margin-left: 5px;"><i class="fas fa-check-circle"></i> Compatible</span>
                                    <?php else: ?>
                                        <span style="color: #e53e3e; margin-left: 5px;"><i class="fas fa-times-circle"></i> Requires >= 7.4</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">Server Software</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">PHP Timezone</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= date_default_timezone_get() ?></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Database Engine & Status -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-database" style="color: #319795;"></i> Database Connection
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">Database Connection</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= $db_connected ? '#48bb78' : '#e53e3e' ?>;">
                                    <?= $db_connected ? '<i class="fas fa-check-circle"></i> Connected' : '<i class="fas fa-times-circle"></i> Connection Failed' ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">MySQL Server Version</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= htmlspecialchars($db_version) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">Total Active Tables</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= $total_tables ?> tables</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Required Extensions -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-puzzle-piece" style="color: #ed8936;"></i> Required Extensions
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <?php
                            $extensions = [
                                'pdo_mysql' => 'Database Connection',
                                'zip'       => 'System Updater (ZIP Extraction)',
                                'fileinfo'  => 'Secure File Upload Validation',
                                'gd'        => 'Image Cropping & Resize Helper',
                                'mbstring'  => 'Multibyte String Operations',
                                'curl'      => 'API/External Requests Support'
                            ];
                            foreach ($extensions as $ext => $desc):
                                $loaded = extension_loaded($ext);
                            ?>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;"><?= $ext ?> <span style="font-size: 0.75rem; color: #a0aec0; font-weight: normal;">(<?= $desc ?>)</span></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= $loaded ? '#48bb78' : '#e53e3e' ?>;">
                                    <?= $loaded ? '<i class="fas fa-check-circle"></i> Enabled' : '<i class="fas fa-times-circle"></i> Missing' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <!-- Upload & Memory Limits -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-sliders-h" style="color: #48bb78;"></i> Upload & Memory Limits
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">upload_max_filesize</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= ini_get('upload_max_filesize') ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">post_max_size</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= ini_get('post_max_size') ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">memory_limit</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= ini_get('memory_limit') ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">max_execution_time</td>
                                <td style="padding: 8px 0; text-align: right; color: #2d3748; font-weight: 600;"><?= ini_get('max_execution_time') ?>s</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Security & Routing -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-shield-alt" style="color: #ecc94b;"></i> Security & Routing
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">HTTPS Connection</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= $is_https ? '#48bb78' : '#ed8936' ?>;">
                                    <?= $is_https ? '<i class="fas fa-check-circle"></i> Active (Secure)' : '<i class="fas fa-exclamation-triangle"></i> Inactive (HTTP)' ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">Display Errors (INI)</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= ini_get('display_errors') ? '#ed8936' : '#48bb78' ?>;">
                                    <?= ini_get('display_errors') ? '<i class="fas fa-exclamation-triangle"></i> Enabled (Dev)' : '<i class="fas fa-check-circle"></i> Disabled (Prod)' ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;">URL Rewrite (.htaccess)</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= $htaccess_exists ? '#48bb78' : '#e53e3e' ?>;">
                                    <?= $htaccess_exists ? '<i class="fas fa-check-circle"></i> Setup' : '<i class="fas fa-times-circle"></i> Missing htaccess' ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Folder Permissions -->
                    <div style="background: white; border: 1px solid #edf2f7; border-radius: 8px; padding: 15px;">
                        <h5 style="margin-top: 0; margin-bottom: 15px; font-weight: 700; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-folder-open" style="color: #9f7aea;"></i> Write Access Permissions
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <?php
                            $dirs = [
                                'public/uploads/' => dirname(APPROOT) . '/public/uploads',
                                'public/img/'     => dirname(APPROOT) . '/public/img',
                                'app/Config/'     => APPROOT . '/Config',
                                'Project Root/'   => dirname(APPROOT),
                            ];
                            foreach ($dirs as $label => $path):
                                $writable = is_writable($path);
                            ?>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 8px 0; color: #718096; font-weight: 600;"><?= $label ?></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 700; color: <?= $writable ? '#48bb78' : '#e53e3e' ?>;">
                                    <?= $writable ? '<i class="fas fa-check-circle"></i> Writable' : '<i class="fas fa-times-circle"></i> Not Writable' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-save" id="settingsSubmitBtn"><i class="fas fa-save"></i> Save All Settings</button>
        </div>
    </form>
</div>

<style>
    .settings-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .settings-tabs {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: 0.3s;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tab-btn.active {
        background: #eff6ff !important;
        color: #2563eb !important;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.1);
    }

    .tab-btn.active i {
        color: #2563eb !important;
    }

    .tab-btn:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    .tab-btn.active:hover {
        background: #eff6ff !important;
        color: #2563eb !important;
    }

    .tab-btn i { font-size: 1.1rem; }

    .tab-content { display: none; animation: fadeIn 0.5s; }
    .tab-content.active { display: block; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .full-width { grid-column: span 2; }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-main);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #eee;
        border-radius: 10px;
        transition: 0.3s;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px var(--primary-light);
    }

    .form-actions {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .btn-save {
        background: var(--primary);
        color: white;
        padding: 15px 40px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 20px var(--primary-glow);
        transition: 0.3s;
    }

    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 30px var(--primary-glow); }

    .alert {
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    @media (max-width: 768px) {
        .settings-container {
            padding: 15px;
        }
        .settings-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 8px;
            gap: 10px;
            scrollbar-width: none;
        }
        .settings-tabs::-webkit-scrollbar {
            display: none;
        }
        .tab-btn {
            padding: 8px 12px;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .btn-save {
            width: 100%;
        }
    }
</style>

<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Add active classes
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');

            // Change Submit Button text and style dynamically
            const submitBtn = document.getElementById('settingsSubmitBtn');
            if (btn.dataset.tab === 'system_info') {
                submitBtn.style.display = 'none'; // Hide submit button for info tab
            } else {
                submitBtn.style.display = 'inline-block';
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Save All Settings';
                submitBtn.style.background = 'var(--primary)';
                submitBtn.style.boxShadow = '0 10px 20px var(--primary-glow)';
            }
        });
    });
</script>

<!-- Media Selector Modal -->
<div id="mediaModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(5px); padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 100%; max-width: 800px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <!-- Modal Header -->
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 style="font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                <i class="fas fa-images" style="color: var(--primary);"></i> Media Library থেকে ফাইল সিলেক্ট করুন
            </h3>
            <button type="button" id="closeMediaModal" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; transition: 0.2s;"><i class="fas fa-times"></i></button>
        </div>
        <!-- Modal Body -->
        <div style="padding: 20px; overflow-y: auto; flex: 1; min-height: 300px;">
            <div id="mediaLoading" style="text-align: center; padding: 40px 0; color: #64748b;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px;"></i>
                <p>মিডিয়া ফাইলগুলো লোড হচ্ছে...</p>
            </div>
            <div id="mediaGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px;"></div>
        </div>
    </div>
</div>

<script>
    let activeMediaTarget = null;
    let activeMediaPreview = null;
    let activeMediaContainer = null;

    document.querySelectorAll('.btn-select-media').forEach(btn => {
        btn.addEventListener('click', () => {
            activeMediaTarget = document.getElementById(btn.dataset.target);
            activeMediaPreview = document.getElementById(btn.dataset.preview);
            activeMediaContainer = document.querySelector('.' + btn.dataset.container);
            
            // Open modal
            document.getElementById('mediaModal').style.display = 'flex';
            loadMediaLibrary();
        });
    });

    document.getElementById('closeMediaModal').addEventListener('click', () => {
        document.getElementById('mediaModal').style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('mediaModal')) {
            document.getElementById('mediaModal').style.display = 'none';
        }
    });

    function loadMediaLibrary() {
        const grid = document.getElementById('mediaGrid');
        const loading = document.getElementById('mediaLoading');
        
        grid.innerHTML = '';
        loading.style.display = 'block';
        
        fetch('<?= URLROOT ?>/admin/api_media')
            .then(res => res.json())
            .then(data => {
                loading.style.display = 'none';
                if (data.length === 0) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #64748b; padding: 40px 0;">কোনো মিডিয়া ফাইল পাওয়া যায়নি। অনুগ্রহ করে Media Management সেকশন থেকে ফাইল আপলোড করুন।</p>';
                    return;
                }
                
                data.forEach(file => {
                    const card = document.createElement('div');
                    card.style.cssText = 'border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; cursor: pointer; transition: 0.2s; background: #f8fafc; position: relative;';
                    card.innerHTML = `
                        <div style="height: 100px; display: flex; align-items: center; justify-content: center; background: #e2e8f0; position: relative; overflow: hidden;">
                            <img src="${file.url}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                        </div>
                        <div style="padding: 8px; font-size: 0.75rem; font-weight: 600; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;" title="${file.name}">
                            ${file.name}
                        </div>
                    `;
                    
                    card.addEventListener('mouseover', () => {
                        card.style.borderColor = 'var(--primary)';
                        card.style.transform = 'translateY(-2px)';
                        card.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
                    });
                    card.addEventListener('mouseout', () => {
                        card.style.borderColor = '#e2e8f0';
                        card.style.transform = 'none';
                        card.style.boxShadow = 'none';
                    });
                    
                    card.addEventListener('click', () => {
                        if (activeMediaTarget) {
                            activeMediaTarget.value = file.url;
                        }
                        if (activeMediaPreview) {
                            activeMediaPreview.src = file.url;
                        }
                        if (activeMediaContainer) {
                            activeMediaContainer.style.display = 'block';
                        }
                        document.getElementById('mediaModal').style.display = 'none';
                    });
                    
                    grid.appendChild(card);
                });
            })
            .catch(err => {
                loading.style.display = 'none';
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #ef4444; padding: 40px 0;">মিডিয়া লোড করতে সমস্যা হয়েছে।</p>';
            });
    }
</script>

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
                <input type="text" id="modal_drive_name" class="form-control" placeholder="যেমন: Primary Drive, Backup 15GB, Media Storage..." style="border-radius: 10px;">
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

                <textarea id="modal_sa_json" rows="6" class="form-control" placeholder='{\n  "type": "service_account",\n  "project_id": "...",\n  "private_key_id": "...",\n  "private_key": "-----BEGIN PRIVATE KEY-----\\n...",\n  "client_email": "..."\n}' style="font-family: monospace; font-size: 0.82rem; line-height: 1.4; border-radius: 8px; background: white;" oninput="validateSaJsonInput()"></textarea>

                <div id="modal_sa_detected_badge" style="display: none; margin-top: 10px; padding: 8px 12px; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; font-size: 0.82rem; color: #166534; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> ক্লায়েন্ট ইমেইল শনাক্ত হয়েছে: <span id="modal_sa_detected_email" style="font-family: monospace;"></span>
                </div>
            </div>

            <!-- OAuth 2.0 Fields -->
            <div id="modal_section_oauth" style="display: none; margin-bottom: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Client ID</label>
                    <input type="text" id="modal_oauth_client_id" class="form-control" placeholder="Google OAuth Client ID" style="border-radius: 8px;">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Client Secret</label>
                    <input type="password" id="modal_oauth_client_secret" class="form-control" placeholder="Google OAuth Client Secret" style="border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 6px; font-size: 0.85rem;">Refresh Token</label>
                    <input type="text" id="modal_oauth_refresh_token" class="form-control" placeholder="Google OAuth Refresh Token" style="border-radius: 8px;">
                </div>
            </div>

            <!-- Target Folder ID -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                    গুগল ড্রাইভ ফোল্ডার আইডি (Target Folder ID) <span style="color: #64748b; font-weight: normal; font-size: 0.82rem;">(ঐচ্ছিক কিন্তু বাঞ্ছনীয়)</span>
                </label>
                <input type="text" id="modal_drive_folder_id" class="form-control" placeholder="যেমন: 1BxiMVs0XRA5nFMdKvBHKubT9tPn..." style="border-radius: 10px;">
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
            // If it's the only drive, make it default
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
