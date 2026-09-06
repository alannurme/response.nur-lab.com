<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/admin.css">
    <style>
        :root {
            --primary-color: #008853;
            --primary-hover: #006b43;
            --bg-color: #090d16;
            --card-bg: #111827;
            --card-border: rgba(255, 255, 255, 0.05);
            --input-bg: #1f2937;
            --input-border: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
        }

        body { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at center, rgba(0, 136, 83, 0.08) 0%, transparent 70%);
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-primary);
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            box-sizing: border-box;
            animation: fadeIn 0.6s ease-out;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-box {
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-box img {
            max-height: 44px;
            width: auto;
            object-fit: contain;
        }

        .logo-section h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }

        .logo-section p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0.25rem 0 0;
        }

        .login-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        /* Subtle glowing top line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .error-container {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #ef4444;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-field {
            margin-bottom: 1.5rem;
        }

        .form-field label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 0.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group i.field-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .input-group input {
            width: 100%;
            background-color: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            color: var(--text-primary) !important;
            padding: 0.875rem 1rem 0.875rem 2.75rem !important;
            border-radius: 12px !important;
            font-size: 0.95rem !important;
            transition: all 0.2s ease !important;
            box-sizing: border-box;
        }

        .input-group input::placeholder {
            color: #6b7280;
        }

        .input-group input:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(0, 136, 83, 0.25) !important;
            outline: none;
        }

        .input-group input:focus ~ i.field-icon {
            color: var(--primary-color);
        }

        .toggle-pwd {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
        }

        .toggle-pwd:hover {
            color: var(--text-primary);
        }

        .forgot-pass {
            display: inline-block;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-pass:hover {
            color: var(--primary-color);
        }

        .btn-submit {
            width: 100%;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.875rem;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 4px 12px rgba(0, 136, 83, 0.2);
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.985);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="logo-section">
            <?php if (!empty($data['settings']['site_logo'])): ?>
                <div class="logo-box">
                    <img src="<?= resolve_setting_image($data['settings']['site_logo']) ?>" alt="Logo">
                </div>
            <?php else: ?>
                <h2 style="font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;"><?= $data['settings']['site_title'] ?? 'Response with Nur-Lab' ?></h2>
            <?php endif; ?>
            <h2>Administrative Login</h2>
            <p>Authorized personnel access only</p>
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
                    <label for="username">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" required placeholder="Enter username" autocomplete="username">
                        <i class="fas fa-user field-icon"></i>
                    </div>
                </div>
                
                <div class="form-field" style="margin-bottom: 2rem;">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" required placeholder="Enter password" autocomplete="current-password">
                        <i class="fas fa-lock field-icon"></i>
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 6px; color: var(--text-secondary); font-size: 0.85rem; cursor: pointer; user-select: none; font-weight: 500;">
                            <input type="checkbox" name="remember" style="accent-color: var(--primary-color); width: 15px; height: 15px; cursor: pointer; margin: 0;">
                            Remember me
                        </label>
                        <a href="javascript:void(0)" onclick="showForgotModal()" class="forgot-pass" style="margin: 0; font-size: 0.85rem;">Forgot Password?</a>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Sign In</button>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" style="display: none; position: fixed; inset: 0; background: rgba(9, 13, 22, 0.85); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: #111827; border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 24px; max-width: 400px; width: 90%; text-align: center; color: white; box-shadow: 0 25px 50px rgba(0,0,0,0.5);">
            <div style="width: 60px; height: 60px; background: rgba(0, 136, 83, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i class="fas fa-key fa-lg" style="color: var(--primary-color);"></i>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 1.25rem; font-weight: 700;">Reset Password</h3>
            <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.75rem;">
                নিরাপত্তাজনিত কারণে অ্যাডমিন পাসওয়ার্ড রিসেট করতে অনুগ্রহ করে সিস্টেম অ্যাডমিনিস্ট্রেটরের সাথে সরাসরি যোগাযোগ করুন।
            </p>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['settings']['contact_phone'] ?? '') ?>?text=<?= urlencode('আসসালামু আলাইকুম, আমি অ্যাডমিন প্যানেলের পাসওয়ার্ড ভুলে গেছি। দয়া করে রিসেট করতে সাহায্য করুন।') ?>" target="_blank" style="background: #25D366; color: white; padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);">
                    <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i> হোয়াটসঅ্যাপে যোগাযোগ
                </a>
                <button onclick="closeForgotModal()" style="background: transparent; border: 1.5px solid rgba(255,255,255,0.1); color: #cbd5e1; padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 0.95rem; transition: border-color 0.2s;" onmouseover="this.style.borderColor='rgba(255,255,255,0.2)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">বন্ধ করুন</button>
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
