<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Google Analytics Configuration</h1>
        <p>Set up Google Analytics to track page views, user engagement, and traffic sources.</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success"><?= $data['success'] ?></div>
<?php endif; ?>

<div class="settings-container" style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
    <form action="<?= URLROOT ?>/admin/google_analytics" method="POST">
        <!-- Section: Analytics Configuration -->
        <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 25px; padding-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <i class="fab fa-google" style="color: #4285f4; font-size: 1.4rem;"></i>
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Google Analytics Integration</h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-main); font-size: 0.95rem;">Analytics Status</label>
                <select name="settings[google_analytics_status]" class="form-control" style="background: #ffffff; border: 1.5px solid #eee; color: var(--text-main); border-radius: 10px; padding: 12px 15px; width: 100%; transition: 0.3s;">
                    <option value="disabled" <?= ($data['settings']['google_analytics_status'] ?? '') == 'disabled' ? 'selected' : '' ?>>Disabled</option>
                    <option value="enabled" <?= ($data['settings']['google_analytics_status'] ?? '') == 'enabled' ? 'selected' : '' ?>>Enabled</option>
                </select>
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-main); font-size: 0.95rem;">Google Analytics Measurement ID / Tracking ID</label>
                <input type="text" name="settings[ga_id]" value="<?= htmlspecialchars($data['settings']['ga_id'] ?? '') ?>" class="form-control" style="background: #ffffff; border: 1.5px solid #eee; color: var(--text-main); border-radius: 10px; padding: 12px 15px; width: 100%; transition: 0.3s;" placeholder="e.g. G-XXXXXXXXXX or UA-XXXXXXX-X">
                <small style="color: var(--text-muted); display: block; margin-top: 8px;">
                    This will automatically generate and inject the standard Google Analytics gtag.js script onto all public pages.
                </small>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: right;">
            <button type="submit" class="btn btn-save" style="background: var(--primary); color: white; padding: 15px 40px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);">Save Configuration</button>
        </div>
    </form>
</div>

<!-- How to Get GA Measurement ID -->
<div style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; margin-top: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
    <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 20px; padding-bottom: 12px;">
        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main);">How to find your Google Analytics Measurement ID?</h3>
    </div>
    <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 15px;">Google Analytics 4 (GA4) uses a Measurement ID starting with `G-` to send data to your web stream.</p>
    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px;">Steps:</h4>
    <ul style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.8; padding-left: 20px; margin: 0 0 20px 0;">
        <li>Go to your <strong>Google Analytics account</strong>.</li>
        <li>Navigate to <strong>Admin</strong>.</li>
        <li>Under <i>Property</i>, select <strong>Data Streams</strong> and click on your Web stream.</li>
        <li>Copy the <strong>MEASUREMENT ID</strong> (formatted as `G-XXXXXXXXXX`) from the top right corner.</li>
        <li>Paste it in the field above, choose <strong>Enabled</strong>, and save.</li>
    </ul>
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
