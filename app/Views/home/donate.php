<?php require APPROOT . '/Views/inc/header.php'; 
$current_settings = $settings ?? ($data['settings'] ?? []);
$is_piprapay_enabled = (($current_settings['piprapay_status'] ?? '') === 'enabled');
?>

<section style="padding: 60px 0; background: #f8fafc; min-height: 80vh;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Heading -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 class="donate-title" style="font-size: 2.5rem; font-weight: 900; color: #1e293b; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                response with nur-lab <span style="color: #0b7c4d;">অনলাইন অনুদান</span>
            </h1>
            <p style="color: #64748b; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                দ্বীনি শিক্ষা ও দাওয়াহ কার্যক্রমে আপনার অনুদান সাদাকায়ে জারিয়া হিসেবে গণ্য হবে। নিচে আপনার তথ্য দিয়ে অনুদানের পরিমাণ নির্বাচন করুন।
            </p>
            <div style="width: 80px; height: 5px; background: #0b7c4d; border-radius: 10px; margin: 20px auto 0 auto;"></div>
        </div>

        <?php if (isset($_SESSION['donation_error'])): ?>
            <div style="padding: 15px 20px; background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; border-radius: 12px; margin-bottom: 30px; font-weight: 600; text-align: center; font-family: 'Hind Siliguri', sans-serif;">
                <?= $_SESSION['donation_error']; unset($_SESSION['donation_error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['donation_success'])): ?>
            <div style="padding: 25px 30px; background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; border-radius: 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 25px rgba(22,163,74,0.05); font-family: 'Hind Siliguri', sans-serif;">
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px; color: #16a34a;"></i>
                <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 8px;">অনুদান সফল হয়েছে!</h3>
                <p style="margin: 0; color: #166534; font-size: 0.95rem; line-height: 1.5;"><?= $_SESSION['donation_success']; unset($_SESSION['donation_success']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Donation Form Box -->
        <div class="donate-card">
            <form action="<?= URLROOT ?>/submit_donation" method="POST">
                <!-- Honeypot anti-spam field -->
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                </div>
                
                <!-- Donor Info -->
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 0 0 25px 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fas fa-user-circle" style="color: #0b7c4d;"></i> দাতার সাধারণ তথ্য
                </h3>

                <div class="donor-info-grid">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">আপনার নাম *</label>
                        <input type="text" name="donor_name" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Hind Siliguri', sans-serif;" placeholder="আপনার পুরো নাম">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">মোবাইল নম্বর *</label>
                        <input type="text" name="donor_phone" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Outfit', sans-serif;" placeholder="01XXXXXXXXX">
                    </div>
                    <div class="form-group email-field">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">ইমেইল ঠিকানা (ঐচ্ছিক)</label>
                        <input type="email" name="donor_email" class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Outfit', sans-serif;" placeholder="name@example.com">
                    </div>
                </div>

                <!-- Predefined Amounts -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 12px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">অনুদানের পরিমাণ নির্বাচন করুন *</label>
                    <div class="amount-grid">
                        <div class="amount-btn active" onclick="selectAmount(10, this)" style="border: 2px solid #10b981; border-radius: 12px; padding: 12px 10px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.05rem; color: #047857; background: #ecfdf5; font-family: 'Hind Siliguri', sans-serif;">
                            ৳১০ <span style="font-size: 0.72rem; display: block; font-weight: 600; color: #059669;">(টেস্ট পেমেন্ট)</span>
                        </div>
                        <div class="amount-btn" onclick="selectAmount(500, this)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 10px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.05rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳৫০০</div>
                        <div class="amount-btn" onclick="selectAmount(1000, this)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 10px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.05rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳১,০০০</div>
                        <div class="amount-btn" onclick="selectAmount(2000, this)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 10px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.05rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳২,০০০</div>
                        <div class="amount-btn" onclick="selectAmount(5000, this)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px 10px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.05rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳৫,০০০</div>
                    </div>
                    
                    <div style="position: relative; margin-top: 12px;">
                        <span style="position: absolute; left: 15px; top: 12px; font-weight: 700; color: #64748b; font-size: 1.1rem; font-family: 'Hind Siliguri', sans-serif;">৳</span>
                        <input type="number" id="custom_amount" name="amount" value="10" required min="10" class="form-control" style="width: 100%; padding: 12px 15px 12px 30px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 1.1rem; font-weight: 700; font-family: 'Outfit', sans-serif;" placeholder="অন্যান্য পরিমাণ লিখুন (যেমন: ৫০০)">
                    </div>
                </div>

                <!-- Payment Methods -->
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 40px 0 20px 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fas fa-credit-card" style="color: #0b7c4d;"></i> পেমেন্ট পদ্ধতি নির্বাচন করুন
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 35px;">
                    <?php if ($is_piprapay_enabled): ?>
                    <label class="payment-method-card active" onclick="highlightPaymentCard(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border: 2px solid #0b7c4d; border-radius: 14px; background: #f0fdf4; cursor: pointer; transition: 0.2s;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="PipraPay" checked style="accent-color: #0b7c4d; width: 18px; height: 18px;">
                            <div>
                                <strong style="color: #0f172a; font-size: 1rem; display: block; font-family: 'Hind Siliguri', sans-serif;">অনলাইন পেমেন্ট (PipraPay Gateway)</strong>
                                <span style="color: #64748b; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif;">বিকাশ, নগদ, রকেট, উপায় এবং কার্ডের মাধ্যমে সরাসরি পেমেন্ট</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                            <span style="background: #e11471; color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px;">bKash</span>
                            <span style="background: #f7941d; color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px;">Nagad</span>
                            <span style="background: #8c3494; color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px;">Rocket</span>
                        </div>
                    </label>

                    <label class="payment-method-card" onclick="highlightPaymentCard(this)" style="display: flex; align-items: center; padding: 14px 20px; border: 1.5px solid #cbd5e1; border-radius: 14px; background: #ffffff; cursor: pointer; transition: 0.2s;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <input type="radio" name="payment_method" value="Offline" style="accent-color: #0b7c4d; width: 18px; height: 18px;">
                            <div>
                                <strong style="color: #334155; font-size: 0.95rem; display: block; font-family: 'Hind Siliguri', sans-serif;">অফলাইন ব্যাংক বা সরাসরি ট্রান্সফার</strong>
                                <span style="color: #64748b; font-size: 0.82rem; font-family: 'Hind Siliguri', sans-serif;">সরাসরি ব্যাংক অ্যাকাউন্ট বা পার্সোনাল বিকাশ/নগদে পাঠিয়ে রিকোয়েস্ট জমা দিন</span>
                            </div>
                        </div>
                    </label>
                    <?php else: ?>
                    <label class="payment-method-card active" style="display: flex; align-items: center; padding: 16px 20px; border: 2px solid #0b7c4d; border-radius: 14px; background: #f0fdf4; cursor: pointer;">
                        <input type="radio" name="payment_method" value="Offline" checked style="accent-color: #0b7c4d; width: 18px; height: 18px; margin-right: 12px;">
                        <div>
                            <strong style="color: #0f172a; font-size: 1rem; display: block; font-family: 'Hind Siliguri', sans-serif;">অফলাইন ব্যাংক বা ক্যাশ ট্রান্সফার</strong>
                            <span style="color: #64748b; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif;">আমাদের ব্যাংক অ্যাকাউন্ট অথবা বিকাশ/নগদে অনুদান প্রদান করুন</span>
                        </div>
                    </label>
                    <?php endif; ?>
                </div>

                <button type="submit" style="width: 100%; height: 55px; background: #0b7c4d; color: white; border: none; border-radius: 14px; font-weight: 700; font-size: 1.15rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 25px rgba(11,124,77,0.25); font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#085f3b';" onmouseout="this.style.background='#0b7c4d';">
                    <i class="fas fa-heart"></i> অনুদান নিশ্চিত করুন
                </button>

            </form>
        </div>

    </div>
</section>

<script>
function selectAmount(amt, el) {
    document.getElementById('custom_amount').value = amt;
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.borderColor = '#cbd5e1';
        btn.style.background = '#ffffff';
        btn.style.color = '#475569';
    });
    if (el) {
        el.classList.add('active');
        if (amt === 10) {
            el.style.borderColor = '#10b981';
            el.style.background = '#ecfdf5';
            el.style.color = '#047857';
        } else {
            el.style.borderColor = '#0b7c4d';
            el.style.background = '#f0fdf4';
            el.style.color = '#0b7c4d';
        }
    }
}

document.getElementById('custom_amount').addEventListener('input', function() {
    const val = parseInt(this.value);
    document.querySelectorAll('.amount-grid .amount-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.borderColor = '#cbd5e1';
        btn.style.background = '#ffffff';
        btn.style.color = '#475569';
    });
});

function highlightPaymentCard(label) {
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('active');
        card.style.border = '1.5px solid #cbd5e1';
        card.style.background = '#ffffff';
    });
    label.classList.add('active');
    label.style.border = '2px solid #0b7c4d';
    label.style.background = '#f0fdf4';
    const radio = label.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}
</script>

<style>
    .form-control:focus {
        border-color: #0b7c4d !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.15);
    }

    .donate-card {
        background: white; 
        border-radius: 28px; 
        padding: 45px; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.04); 
        border: 1px solid #f1f5f9;
    }

    .donor-info-grid {
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 20px; 
        margin-bottom: 30px;
    }

    .email-field {
        grid-column: span 2;
    }

    .amount-grid {
        display: grid; 
        grid-template-columns: repeat(5, 1fr); 
        gap: 10px; 
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .donate-title {
            font-size: 2rem !important;
        }
        .donate-card {
            padding: 26px 18px;
            border-radius: 22px;
        }
        .donor-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .email-field {
            grid-column: span 1;
        }
        .amount-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }
</style>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
