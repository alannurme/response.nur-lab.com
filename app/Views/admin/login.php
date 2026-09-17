<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | <?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00b069;
            --primary-glow: rgba(0, 176, 105, 0.4);
            --primary-dark: #008853;
            --bg-main: #060911;
            --card-bg: rgba(15, 23, 42, 0.65);
            --card-border: rgba(255, 255, 255, 0.08);
            --input-bg: rgba(30, 41, 59, 0.5);
            --input-border: rgba(255, 255, 255, 0.1);
            --text-primary: #f8fafc;
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
            background-color: var(--bg-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-primary);
            overflow: hidden;
            position: relative;
        }

        /* Dynamic Animated Background Spheres */
        .bg-glow-1 {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 176, 105, 0.15) 0%, rgba(6, 9, 17, 0) 70%);
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            animation: pulseGlow 8s ease-in-out infinite alternate;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -15%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, rgba(6, 9, 17, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.5; transform: translateX(-50%) scale(0.9); }
            100% { opacity: 1; transform: translateX(-50%) scale(1.15); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 10;
            animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-box {
            background: rgba(255, 255, 255, 0.98);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2);
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .logo-box:hover {
            transform: translateY(-3px) scale(1.02);
        }

        .logo-box img {
            max-height: 48px;
            width: auto;
            object-fit: contain;
        }

        .logo-section h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.35rem;
        }

        .logo-section p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), inset 0 1px 1px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        /* Top Emerald Highlight Line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.8;
        }

        .error-container {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.9rem 1.1rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(8px);
        }

        .form-field {
            margin-bottom: 1.4rem;
        }

        .form-field label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
            letter-spacing: 0.2px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i.field-icon {
            position: absolute;
            left: 1.1rem;
            color: #64748b;
            font-size: 1rem;
            transition: color 0.25s ease;
            pointer-events: none;
        }

        .input-group input {
            width: 100%;
            background: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            color: #ffffff !important;
            padding: 0.9rem 2.8rem 0.9rem 3rem !important;
            border-radius: 14px !important;
            font-size: 0.95rem !important;
            font-family: inherit;
            transition: all 0.25s ease !important;
        }

        .input-group input::placeholder {
            color: #475569;
        }

        .input-group input:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px var(--primary-glow) !important;
            background: rgba(30, 41, 59, 0.85) !important;
            outline: none;
        }

        .input-group input:focus ~ i.field-icon {
            color: var(--primary);
        }

        .toggle-pwd {
            position: absolute;
            right: 1.1rem;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .toggle-pwd:hover {
            color: var(--text-primary);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 0.85rem;
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember-label input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 17px;
            height: 17px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 5px;
            background: rgba(30, 41, 59, 0.6);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .remember-label input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .remember-label input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 10px;
            color: #ffffff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-pass {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-pass:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            border: none;
            padding: 0.95rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px var(--primary-glow);
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.3px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 176, 105, 0.5);
            background: linear-gradient(135deg, #00c878 0%, var(--primary) 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        @keyframes slideUpFade {
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

    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="login-wrapper">
        <div class="logo-section">
            <?php if (!empty($data['settings']['site_logo'])): ?>
                <div class="logo-box">
                    <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo">
                </div>
            <?php else: ?>
                <h2 style="font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;"><?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></h2>
            <?php endif; ?>
            <h2>Administrative Access</h2>
            <p>Enter your credentials to enter the panel</p>
        </div>

        <div class="login-card">
            <?php if(isset($data['error'])): ?>
                <div class="error-container">
                    <i class="fas fa-circle-exclamation"></i>
                    <span><?= $data['error'] ?></span>
                </div>
            <?php endif; ?>
            
            <form action="<?= URLROOT ?>/admin/login" method="POST">
                <div class="form-field">
                    <label for="username">Username or Email</label>
                    <div class="input-group">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" name="username" id="username" required placeholder="Enter your username" autocomplete="username">
                    </div>
                </div>
                
                <div class="form-field">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="password" required placeholder="••••••••••••" autocomplete="current-password">
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    
                    <div class="options-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                        <a href="javascript:void(0)" onclick="showForgotModal()" class="forgot-pass">Forgot Password?</a>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <span>Sign In to Dashboard</span>
                    <i class="fas fa-arrow-right" style="font-size: 0.9rem;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" style="display: none; position: fixed; inset: 0; background: rgba(6, 9, 17, 0.85); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(12px);">
        <div style="background: rgba(15, 23, 42, 0.95); border: 1px solid rgba(255,255,255,0.1); padding: 2.5rem; border-radius: 28px; max-width: 420px; width: 90%; text-align: center; color: white; box-shadow: 0 25px 50px rgba(0,0,0,0.7);">
            <div style="width: 64px; height: 64px; background: rgba(0, 176, 105, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid rgba(0, 176, 105, 0.3);">
                <i class="fas fa-shield-halved fa-xl" style="color: var(--primary);"></i>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 1.3rem; font-weight: 700;">Password Recovery</h3>
            <p style="color: var(--text-muted); font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.75rem;">
                নিরাপত্তাজনিত কারণে অ্যাডমিন পাসওয়ার্ড রিসেট করতে অনুগ্রহ করে প্রধান সিস্টেমে যোগাযোগ করুন।
            </p>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['settings']['contact_phone'] ?? '') ?>?text=<?= urlencode('আসসালামু আলাইকুম, আমি অ্যাডমিন প্যানেলের পাসওয়ার্ড ভুলে গেছি। দয়া করে রিসেট করতে সাহায্য করুন।') ?>" target="_blank" style="background: #25D366; color: white; padding: 13px; border-radius: 14px; text-decoration: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);">
                    <i class="fab fa-whatsapp" style="font-size: 1.25rem;"></i> হোয়াটসঅ্যাপে যোগাযোগ
                </a>
                <button onclick="closeForgotModal()" style="background: transparent; border: 1.5px solid rgba(255,255,255,0.12); color: #cbd5e1; padding: 12px; border-radius: 14px; cursor: pointer; font-weight: 600; font-size: 0.95rem; transition: all 0.2s;" onmouseover="this.style.borderColor='rgba(255,255,255,0.25)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.12)'">বন্ধ করুন</button>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
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

