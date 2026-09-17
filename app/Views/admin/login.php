<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | <?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d27a;
            --primary-glow: rgba(0, 210, 122, 0.45);
            --primary-dark: #009e5a;
            --primary-gradient: linear-gradient(135deg, #00e687 0%, #00a85d 100%);
            --bg-main: #040810;
            --card-bg: rgba(13, 20, 36, 0.65);
            --card-border: rgba(255, 255, 255, 0.12);
            --input-bg: rgba(255, 255, 255, 0.04);
            --input-border: rgba(255, 255, 255, 0.12);
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

        /* Ambient Animated Grid & Orbs */
        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            opacity: 0.7;
        }

        .bg-glow-1 {
            position: absolute;
            top: -15%;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(0, 210, 122, 0.18) 0%, rgba(4, 8, 16, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: pulseGlow 10s ease-in-out infinite alternate;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, rgba(4, 8, 16, 0) 70%);
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
        }

        .bg-glow-3 {
            position: absolute;
            top: 40%;
            left: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.08) 0%, rgba(4, 8, 16, 0) 70%);
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.6; transform: translateX(-50%) scale(0.95); }
            100% { opacity: 1; transform: translateX(-50%) scale(1.2); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem 1.75rem;
            position: relative;
            z-index: 10;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2.2rem;
        }

        .logo-box {
            background: rgba(255, 255, 255, 0.98);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 36px;
            border-radius: 22px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.3), 0 0 30px rgba(0, 210, 122, 0.25);
            margin-bottom: 1.6rem;
            backdrop-filter: blur(12px);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .logo-box:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.4), 0 0 40px rgba(0, 210, 122, 0.4);
        }

        .logo-box img {
            max-height: 52px;
            width: auto;
            object-fit: contain;
        }

        .logo-section h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .logo-section p {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            padding: 2.75rem 2.4rem;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.7), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.15),
                        0 0 40px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            position: relative;
            overflow: hidden;
        }

        /* Top Emerald Highlight Line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.9;
        }

        .error-container {
            background: rgba(239, 68, 68, 0.14);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 0.95rem 1.2rem;
            border-radius: 16px;
            margin-bottom: 1.6rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(10px);
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .form-field {
            margin-bottom: 1.5rem;
        }

        .form-field label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 0.6rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #94a3b8;
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
            font-size: 1.05rem;
            transition: color 0.3s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-group input {
            width: 100%;
            background: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            color: #ffffff !important;
            padding: 1rem 3rem 1rem 3.2rem !important;
            border-radius: 16px !important;
            font-size: 0.975rem !important;
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .input-group input::placeholder {
            color: #475569;
        }

        .input-group input:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px var(--primary-glow), inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            background: rgba(15, 23, 42, 0.8) !important;
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
            padding: 6px;
            font-size: 1.05rem;
            transition: color 0.25s ease;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-pwd:hover {
            color: #f8fafc;
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--text-muted);
            font-size: 0.875rem;
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember-label input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.25s ease;
        }

        .remember-label input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 0 10px var(--primary-glow);
        }

        .remember-label input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 11px;
            color: #040810;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-pass {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.25s ease;
        }

        .forgot-pass:hover {
            color: var(--primary);
            text-decoration: none;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary-gradient);
            color: #040810;
            border: none;
            padding: 1.05rem;
            font-size: 1.05rem;
            font-weight: 800;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 25px var(--primary-glow);
            margin-top: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.4px;
            font-family: 'Outfit', sans-serif;
        }

        .btn-submit:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 16px 35px rgba(0, 210, 122, 0.55);
            filter: brightness(1.05);
        }

        .btn-submit:active {
            transform: translateY(-1px) scale(0.99);
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="bg-grid"></div>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <div class="bg-glow-3"></div>

    <div class="login-wrapper">
        <div class="logo-section">
            <?php if (!empty($data['settings']['site_logo'])): ?>
                <div class="logo-box">
                    <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo">
                </div>
            <?php else: ?>
                <h2 style="font-size: 2rem; font-weight: 800; letter-spacing: -0.5px;"><?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></h2>
            <?php endif; ?>
            <h2>Administrative Access</h2>
            <p>Enter your authorized credentials to enter panel</p>
        </div>

        <div class="login-card">
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
                    <i class="fas fa-arrow-right" style="font-size: 0.95rem;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" style="display: none; position: fixed; inset: 0; background: rgba(4, 8, 16, 0.88); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(16px);">
        <div style="background: rgba(13, 20, 36, 0.95); border: 1px solid rgba(255,255,255,0.15); padding: 2.75rem 2.25rem; border-radius: 32px; max-width: 430px; width: 90%; text-align: center; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.8);">
            <div style="width: 68px; height: 68px; background: rgba(0, 210, 122, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid rgba(0, 210, 122, 0.35); box-shadow: 0 0 20px rgba(0, 210, 122, 0.2);">
                <i class="fas fa-shield-halved fa-xl" style="color: var(--primary);"></i>
            </div>
            <h3 style="margin: 0 0 10px 0; font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700;">Password Recovery</h3>
            <p style="color: var(--text-muted); font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.75rem;">
                নিরাপত্তাজনিত কারণে অ্যাডমিন পাসওয়ার্ড রিসেট করতে অনুগ্রহ করে প্রধান সিস্টেমে যোগাযোগ করুন।
            </p>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['settings']['contact_phone'] ?? '') ?>?text=<?= urlencode('আসসালামু আলাইকুম, আমি অ্যাডমিন প্যানেলের পাসওয়ার্ড ভুলে গেছি। দয়া করে রিসেট করতে সাহায্য করুন।') ?>" target="_blank" style="background: #25D366; color: white; padding: 14px; border-radius: 16px; text-decoration: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.975rem; box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);">
                    <i class="fab fa-whatsapp" style="font-size: 1.3rem;"></i> হোয়াটসঅ্যাপে যোগাযোগ
                </a>
                <button onclick="closeForgotModal()" style="background: transparent; border: 1.5px solid rgba(255,255,255,0.15); color: #cbd5e1; padding: 13px; border-radius: 16px; cursor: pointer; font-weight: 600; font-size: 0.95rem; transition: all 0.25s;" onmouseover="this.style.borderColor='rgba(255,255,255,0.3)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.15)'">বন্ধ করুন</button>
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
