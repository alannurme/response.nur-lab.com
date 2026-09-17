<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | <?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #38bdf8;
            --primary-glow: rgba(56, 189, 248, 0.35);
            --bg-dark: #040814;
            --card-bg: rgba(13, 22, 42, 0.65);
            --card-border: rgba(255, 255, 255, 0.12);
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.12);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            background: var(--bg-dark) url('<?= URLROOT ?>/public/img/dark_sky.jpg') no-repeat center center / cover;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            position: relative;
            overflow: hidden;
        }

        /* Ethereal Glowing Orbit Ring */
        .sky-aura {
            position: absolute;
            width: 720px;
            height: 720px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: 0 0 120px rgba(56, 189, 248, 0.08);
        }

        .sky-aura::after {
            content: '';
            position: absolute;
            inset: -40px;
            border-radius: 50%;
            border: 1px dashed rgba(255, 255, 255, 0.05);
        }

        /* Top Left Brand Logo */
        .top-brand {
            position: absolute;
            top: 2rem;
            left: 2.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            z-index: 20;
            text-decoration: none;
        }

        .top-brand-icon {
            width: 34px;
            height: 34px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            position: relative;
            z-index: 10;
            animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 36px;
            padding: 3rem 2.5rem;
            box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.6),
                        0 0 0 1px rgba(255, 255, 255, 0.05),
                        inset 0 1px 1px rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            text-align: center;
        }

        /* Top Icon Container */
        .icon-box {
            min-height: 64px;
            padding: 10px 24px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.2);
            color: #0f172a;
            font-size: 1.25rem;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-width: 90%;
        }

        .icon-box:hover {
            transform: translateY(-2px) scale(1.02);
        }

        .icon-box img {
            max-height: 46px;
            max-width: 240px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .login-card h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.4rem;
            letter-spacing: -0.3px;
        }

        .login-card p.subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .error-container {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.85rem 1.1rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
        }

        .form-field {
            margin-bottom: 1.1rem;
            text-align: left;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i.field-icon {
            position: absolute;
            left: 1.2rem;
            color: #64748b;
            font-size: 0.95rem;
            pointer-events: none;
            z-index: 2;
        }

        .input-group input {
            width: 100%;
            background: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            color: #ffffff !important;
            padding: 0.95rem 2.8rem 0.95rem 3rem !important;
            border-radius: 16px !important;
            font-size: 0.925rem !important;
            font-family: inherit;
            transition: all 0.25s ease !important;
        }

        .input-group input::placeholder {
            color: #64748b;
            font-weight: 400;
        }

        .input-group input:focus {
            border-color: rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            outline: none;
        }

        .toggle-pwd {
            position: absolute;
            right: 1.1rem;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            z-index: 2;
        }

        .toggle-pwd:hover {
            color: #ffffff;
        }

        .forgot-row {
            text-align: right;
            margin-top: 0.4rem;
            margin-bottom: 1.5rem;
        }

        .forgot-pass {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-pass:hover {
            color: #ffffff;
        }

        .btn-submit {
            width: 100%;
            background: #ffffff;
            color: #0f172a;
            border: none;
            padding: 1rem;
            font-size: 0.975rem;
            font-weight: 800;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.15);
            font-family: 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 14px 35px rgba(255, 255, 255, 0.25);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.75rem 0 1.5rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.12);
        }

        .divider span {
            font-size: 0.775rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .quick-actions {
            display: flex;
            justify-content: center;
            gap: 14px;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem;
            border-radius: 16px;
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.25s ease;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <!-- Top Left Brand Badge -->
    <a href="<?= URLROOT ?>" class="top-brand">
        <div class="top-brand-icon">
            <i class="fas fa-cubes"></i>
        </div>
        <span><?= $data['settings']['site_title'] ?? 'Response' ?></span>
    </a>

    <div class="sky-aura"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="icon-box">
                <?php if (!empty($data['settings']['site_logo'])): ?>
                    <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo">
                <?php else: ?>
                    <i class="fas fa-arrow-right-to-bracket"></i>
                <?php endif; ?>
            </div>

            <h2>Sign in with email</h2>
            <p class="subtitle">Access your administrative control panel and manage data smoothly.</p>

            <?php 
                $err = $error ?? ($data['error'] ?? null);
                if($err): 
            ?>
                <div class="error-container">
                    <i class="fas fa-circle-exclamation"></i>
                    <span><?= $err ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/login') ?>" method="POST">
                <div class="form-field">
                    <div class="input-group">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="text" name="username" id="username" required placeholder="Email or Username" autocomplete="username">
                    </div>
                </div>

                <div class="form-field">
                    <div class="input-group">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="password" required placeholder="Password" autocomplete="current-password">
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <i class="fas fa-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="forgot-row">
                    <a href="javascript:void(0)" onclick="showForgotModal()" class="forgot-pass">Forgot password?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Get Started
                </button>
            </form>

            <div class="divider">
                <span>Or sign in with</span>
            </div>

            <div class="quick-actions">
                <a href="<?= URLROOT ?>" class="action-btn" title="Main Site">
                    <i class="fas fa-globe" style="color: #38bdf8;"></i>
                </a>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['settings']['contact_phone'] ?? '') ?>" target="_blank" class="action-btn" title="Support">
                    <i class="fab fa-whatsapp" style="color: #4ade80;"></i>
                </a>
                <a href="javascript:void(0)" onclick="showForgotModal()" class="action-btn" title="Help">
                    <i class="fas fa-shield-halved" style="color: #94a3b8;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" style="display: none; position: fixed; inset: 0; background: rgba(4, 8, 20, 0.85); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(16px);">
        <div style="background: rgba(13, 22, 42, 0.95); border: 1.5px solid rgba(255,255,255,0.15); padding: 2.5rem 2.25rem; border-radius: 32px; max-width: 400px; width: 90%; text-align: center; color: #ffffff; box-shadow: 0 30px 60px rgba(0,0,0,0.7);">
            <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.08); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; color: #ffffff; font-size: 1.25rem; border: 1px solid rgba(255,255,255,0.15);">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h3 style="margin: 0 0 8px 0; font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 700; color: #ffffff;">Password Recovery</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.5rem;">
                নিরাপত্তাজনিত কারণে অ্যাডমিন পাসওয়ার্ড রিসেট করতে অনুগ্রহ করে প্রধান সিস্টেমে যোগাযোগ করুন।
            </p>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['settings']['contact_phone'] ?? '') ?>?text=<?= urlencode('আসসালামু আলাইকুম, আমি অ্যাডমিন প্যানেলের পাসওয়ার্ড ভুলে গেছি। দয়া করে রিসেট করতে সাহায্য করুন।') ?>" target="_blank" style="background: #ffffff; color: #0f172a; padding: 13px; border-radius: 16px; text-decoration: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.925rem; box-shadow: 0 6px 20px rgba(255, 255, 255, 0.15);">
                    <i class="fab fa-whatsapp" style="color: #22c55e; font-size: 1.1rem;"></i> হোয়াটসঅ্যাপে যোগাযোগ
                </a>
                <button onclick="closeForgotModal()" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.15); color: #ffffff; padding: 12px; border-radius: 16px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;">বন্ধ করুন</button>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

    function showForgotModal() {
        document.getElementById('forgotModal').style.display = 'flex';
    }
    
    function closeForgotModal() {
        document.getElementById('forgotModal').style.display = 'none';
    }
    </script>
</body>
</html>
