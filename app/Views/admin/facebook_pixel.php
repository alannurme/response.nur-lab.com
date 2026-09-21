<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Facebook Pixel Configuration</h1>
        <p>Set up Facebook Pixel tracking code to track user events and behavior.</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success"><?= $data['success'] ?></div>
<?php endif; ?>

<div class="settings-container" style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
    <form action="<?= URLROOT ?>/admin/facebook_pixel" method="POST">
        <!-- Section: Pixel Configuration -->
        <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 25px; padding-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <i class="fab fa-facebook" style="color: #1877f2; font-size: 1.4rem;"></i>
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Pixel Integration Settings</h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-main); font-size: 0.95rem;">Pixel Status</label>
                <select name="settings[facebook_pixel_status]" class="form-control" style="background: #ffffff; border: 1.5px solid #eee; color: var(--text-main); border-radius: 10px; padding: 12px 15px; width: 100%; transition: 0.3s;">
                    <option value="disabled" <?= ($data['settings']['facebook_pixel_status'] ?? '') == 'disabled' ? 'selected' : '' ?>>Disabled</option>
                    <option value="enabled" <?= ($data['settings']['facebook_pixel_status'] ?? '') == 'enabled' ? 'selected' : '' ?>>Enabled</option>
                </select>
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-main); font-size: 0.95rem;">Facebook Pixel Script</label>
                <textarea name="settings[facebook_pixel_code]" class="form-control" rows="12" style="background: #f8fafc; border: 1.5px solid #eee; font-family: 'Courier New', monospace; color: var(--text-main); border-radius: 10px; padding: 15px; width: 100%; transition: 0.3s; font-size: 0.9rem;" placeholder="<!-- Paste Facebook Pixel Code here (starting with <script> and ending with </script>) -->"><?= htmlspecialchars($data['settings']['facebook_pixel_code'] ?? '') ?></textarea>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: right;">
            <button type="submit" class="btn btn-save" style="background: var(--primary); color: white; padding: 15px 40px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);">Save Configuration</button>
        </div>
    </form>
</div>

<!-- How to Get FB Pixel Code -->
<div style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; margin-top: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
    <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 20px; padding-bottom: 12px;">
        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main);">How to integrate Facebook Pixel?</h3>
    </div>
    <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 15px;">Facebook Pixel allows you to measure the effectiveness of your advertising by understanding the actions people take on your website.</p>
    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px;">Steps to get your code:</h4>
    <ul style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.8; padding-left: 20px; margin: 0 0 20px 0;">
        <li>Go to your <strong>Facebook Events Manager</strong>.</li>
        <li>Select or create a data source (Pixel).</li>
        <li>Choose <strong>Set up Pixel</strong> -> <strong>Install code manually</strong>.</li>
        <li>Copy the entire tracking code provided by Facebook and paste it in the textarea above.</li>
        <li>Change the status to <strong>Enabled</strong> and click save.</li>
    </ul>
    <div style="font-size: 0.9rem; color: #1e3a8a; border-top: 1px solid #f1f5f9; padding-top: 15px; font-weight: 600;">
        <i class="fas fa-info-circle" style="margin-right: 5px; color: #1d4ed8;"></i> 
        <strong>Note:</strong> The code will be dynamically injected in the `<head>` section of all visitor pages.
    </div>
</div>

<style>
    .alert {
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 600;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(37, 99, 235, 0.25) !important; }
    .form-control:focus {
        border-color: var(--primary) !important;
        outline: none;
        box-shadow: 0 0 0 4px var(--primary-light);
    }
    @media (max-width: 768px) {
        .settings-container, 
        .settings-container + div,
        div[style*="margin-top: 30px"] {
            padding: 15px !important;
            border-radius: 12px !important;
            margin-top: 20px !important;
        }
        .btn-save {
            width: 100% !important;
        }
        div[style*="text-align: right"] {
            text-align: left !important;
        }
    }
</style>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
