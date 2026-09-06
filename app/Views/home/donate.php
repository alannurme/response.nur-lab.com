<?php require APPROOT . '/Views/inc/header.php'; ?>

<section style="padding: 60px 0; background: #f8fafc; min-height: 80vh;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Heading -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 class="donate-title" style="font-size: 2.5rem; font-weight: 900; color: #1e293b; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                response with nur-lab <span style="color: #2563eb;">ডোনেশন</span>
            </h1>
            <p style="color: #64748b; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                আপনার অনুদান আমাদের কার্যক্রমে সহায়তা করবে। নিচে আপনার তথ্য দিয়ে অনুদানের পরিমাণ নির্বাচন করুন।
            </p>
            <div style="width: 80px; height: 5px; background: #2563eb; border-radius: 10px; margin: 20px auto 0 auto;"></div>
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
                
                <!-- Donor Info -->
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 0 0 25px 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fas fa-user-circle" style="color: #2563eb;"></i> দাতার সাধারণ তথ্য
                </h3>

                <div class="donor-info-grid">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">আপনার নাম *</label>
                        <input type="text" name="donor_name" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Hind Siliguri', sans-serif;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">মোবাইল নম্বর *</label>
                        <input type="text" name="donor_phone" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Outfit', sans-serif;">
                    </div>
                    <div class="form-group email-field">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">ইমেইল ঠিকানা (ঐচ্ছিক)</label>
                        <input type="email" name="donor_email" class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-family: 'Outfit', sans-serif;">
                    </div>
                </div>

                <!-- Predefined Amounts -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 12px; font-weight: 600; color: #475569; font-family: 'Hind Siliguri', sans-serif;">অনুদানের পরিমাণ নির্বাচন করুন *</label>
                    <div class="amount-grid">
                        <div class="amount-btn" onclick="selectAmount(500)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 15px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.1rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳৫০০</div>
                        <div class="amount-btn" onclick="selectAmount(1000)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 15px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.1rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳১,০০০</div>
                        <div class="amount-btn" onclick="selectAmount(2000)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 15px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.1rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳২,০০০</div>
                        <div class="amount-btn" onclick="selectAmount(5000)" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 15px; text-align: center; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1.1rem; color: #475569; font-family: 'Hind Siliguri', sans-serif;">৳৫,০০০</div>
                    </div>
                    
                    <div style="position: relative;">
                        <span style="position: absolute; left: 15px; top: 12px; font-weight: 700; color: #64748b; font-size: 1.1rem; font-family: 'Hind Siliguri', sans-serif;">৳</span>
                        <input type="number" id="custom_amount" name="amount" required min="10" class="form-control" style="width: 100%; padding: 12px 15px 12px 30px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 1.1rem; font-weight: 700; font-family: 'Outfit', sans-serif;" placeholder="অন্যান্য পরিমাণ লিখুন (যেমন: ৫০০)">
                    </div>
                </div>

                <!-- Payment Methods -->
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 40px 0 25px 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 10px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="fas fa-credit-card" style="color: #2563eb;"></i> পেমেন্ট পদ্ধতি
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px;">
                    <?php if (($data['settings']['piprapay_status'] ?? '') === 'enabled'): ?>
                    <input type="hidden" name="payment_method" value="PipraPay">
                    <div class="payment-option-label" style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1.5px solid var(--primary); border-radius: 12px; background: var(--primary-light); font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i>
                        <span>অনলাইন পেমেন্ট (বিকাশ, রকেট, নগদ, কার্ড - PipraPay)</span>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="payment_method" value="Offline">
                    <div class="payment-option-label" style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1.5px solid var(--primary); border-radius: 12px; background: var(--primary-light); font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i>
                        <span>অফলাইন ব্যাংক বা ক্যাশ ট্রান্সফার</span>
                    </div>
                    <?php endif; ?>
                </div>

                <button type="submit" style="width: 100%; height: 55px; background: #2563eb; color: white; border: none; border-radius: 14px; font-weight: 700; font-size: 1.15rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 25px rgba(37,99,235,0.2); font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#1d4ed8';" onmouseout="this.style.background='#2563eb';">
                    <i class="fas fa-heart"></i> অনুদান নিশ্চিত করুন
                </button>

            </form>
        </div>

    </div>
</section>

<script>
function selectAmount(amt) {
    document.getElementById('custom_amount').value = amt;
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.style.borderColor = '#cbd5e1';
        btn.style.background = 'transparent';
        btn.style.color = '#475569';
    });
    // highlight selected
    event.target.style.borderColor = '#2563eb';
    event.target.style.background = '#eff6ff';
    event.target.style.color = '#2563eb';
}

document.getElementById('custom_amount').addEventListener('input', function() {
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.style.borderColor = '#cbd5e1';
        btn.style.background = 'transparent';
        btn.style.color = '#475569';
    });
});

function togglePaymentSelection(radio) {
    document.querySelectorAll('.payment-option-label').forEach(label => {
        label.style.border = '1.5px solid #cbd5e1';
        label.style.background = 'transparent';
    });
    const label = radio.closest('label');
    label.style.border = '1.5px solid var(--primary)';
    label.style.background = 'var(--primary-light)';
}
</script>

<style>
    .form-control:focus {
        border-color: var(--primary) !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .donate-card {
        background: white; 
        border-radius: 32px; 
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
        grid-template-columns: repeat(4, 1fr); 
        gap: 12px; 
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .donate-title {
            font-size: 2rem !important;
        }
        .donate-card {
            padding: 30px 20px;
            border-radius: 24px;
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
