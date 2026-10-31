<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="display: flex; align-items: center; gap: 12px; font-size: 1.8rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
            <i class="fas fa-credit-card" style="color: #0b7c4d;"></i> লাইভ পেমেন্ট মেথড সেটিংস (PipraPay Gateway)
        </h1>
        <p style="color: #64748b; margin: 0; font-size: 0.95rem;">
            লাইভ সার্ভারে ওয়েবসাইটের অনলাইন অনুদান ও লেনদেনের জন্য PipraPay পেমেন্ট গেটওয়ে কনফিগারেশন, প্রোডাকশন গাইড ও ১০ টাকার টেস্ট অপশন।
        </p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 15px 20px; border-radius: 14px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="font-size: 1.2rem; color: #10b981;"></i>
        <span><?= $data['success'] ?></span>
    </div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 15px 20px; border-radius: 14px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-exclamation-triangle" style="font-size: 1.2rem; color: #ef4444;"></i>
        <span><?= $data['error'] ?></span>
    </div>
<?php endif; ?>

<div class="payment-settings-grid" style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 28px; align-items: start;">

    <!-- Left Column: Form & Live Test Payment -->
    <div style="display: flex; flex-direction: column; gap: 28px;">

        <!-- Card 1: PipraPay Configuration -->
        <div style="background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 18px; margin-bottom: 22px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0b7c4d; font-size: 1.3rem;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">লাইভ PipraPay গেটওয়ে কনফিগারেশন</h3>
                        <span style="font-size: 0.85rem; color: #64748b;">বিকাশ, নগদ, রকেট, উপায় ও ভিসা/মাস্টারকার্ড পেমেন্ট সমাধান</span>
                    </div>
                </div>
                <div>
                    <?php if (($data['settings']['piprapay_status'] ?? '') === 'enabled'): ?>
                        <span style="background: #dcfce7; color: #15803d; padding: 6px 14px; border-radius: 30px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #bbf7d0;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #16a34a; display: inline-block;"></span> লাইভ সক্রিয় (Enabled)
                        </span>
                    <?php else: ?>
                        <span style="background: #f1f5f9; color: #64748b; padding: 6px 14px; border-radius: 30px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #cbd5e1;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; display: inline-block;"></span> নিষ্ক্রিয় (Disabled)
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <form action="<?= URLROOT ?>/admin/payment_settings" method="POST">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <!-- Status -->
                    <div class="form-group">
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                            গেটওয়ে স্ট্যাটাস (Gateway Status)
                        </label>
                        <select name="settings[piprapay_status]" id="piprapay_status" class="form-control" style="width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 0.95rem; font-family: inherit; background: #fff;">
                            <option value="enabled" <?= ($data['settings']['piprapay_status'] ?? '') === 'enabled' ? 'selected' : '' ?>>সক্রিয় করুন (Enabled - লাইভে চালু)</option>
                            <option value="disabled" <?= ($data['settings']['piprapay_status'] ?? '') === 'disabled' ? 'selected' : '' ?>>নিষ্ক্রিয় রাখুন (Disabled - সাময়িক বন্ধ)</option>
                        </select>
                        <small style="color: #64748b; display: block; margin-top: 6px; font-size: 0.82rem;">সক্রিয় থাকলে অনুদান পাতায় (`/donate`) ভিজিটররা PipraPay গেটওয়ের মাধ্যমে অনলাইনে পেমেন্ট করতে পারবেন।</small>
                    </div>

                    <!-- Base URL -->
                    <div class="form-group">
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                            PipraPay Live Base URL <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="settings[piprapay_base_url]" id="piprapay_base_url" value="<?= htmlspecialchars($data['settings']['piprapay_base_url'] ?? 'https://pay.nur-lab.com') ?>" required class="form-control" style="width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 0.95rem; font-family: monospace; background: #fff;" placeholder="https://pay.nur-lab.com">
                        <div style="display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap;">
                            <button type="button" onclick="setBaseUrl('https://pay.nur-lab.com')" style="background: #ecfdf5; border: 1.5px solid #10b981; border-radius: 8px; padding: 6px 12px; font-size: 0.82rem; color: #065f46; font-weight: 700; cursor: pointer;">
                                <i class="fas fa-globe"></i> লাইভ সার্ভার: https://pay.nur-lab.com
                            </button>
                            <button type="button" onclick="setBaseUrl('http://localhost/pay.nur-lab.com')" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-size: 0.82rem; color: #64748b; cursor: pointer;">
                                <i class="fas fa-desktop"></i> লোকাল টেস্ট: http://localhost/pay.nur-lab.com
                            </button>
                        </div>
                        <small style="color: #64748b; display: block; margin-top: 6px; font-size: 0.82rem;">লাইভ সার্ভারে পেমেন্ট এপিআই এন্ডপয়েন্ট: <code>https://pay.nur-lab.com/api/checkout/redirect</code></small>
                    </div>

                    <!-- API Key -->
                    <div class="form-group">
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">
                            Live Merchant API Key <span style="color: #ef4444;">*</span>
                        </label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" name="settings[piprapay_api_key]" id="piprapay_api_key" value="<?= htmlspecialchars($data['settings']['piprapay_api_key'] ?? '') ?>" required class="form-control" style="width: 100%; padding: 12px 85px 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 0.92rem; font-family: monospace; background: #fff;" placeholder="লাইভ PipraPay মার্চেন্ট API Key পেস্ট করুন">
                            <div style="position: absolute; right: 10px; display: flex; gap: 5px;">
                                <button type="button" onclick="toggleKeyVisibility()" title="Toggle View" style="background: none; border: none; padding: 6px; color: #64748b; cursor: pointer; font-size: 0.95rem;">
                                    <i id="key_eye_icon" class="fas fa-eye"></i>
                                </button>
                                <button type="button" onclick="copyApiKey()" title="Copy Key" style="background: none; border: none; padding: 6px; color: #64748b; cursor: pointer; font-size: 0.95rem;">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <small style="color: #64748b; display: block; margin-top: 6px; font-size: 0.82rem;">আপনার লাইভ PipraPay ড্যাশবোর্ডের <strong>API Keys</strong> মেনু থেকে এই কী টি সংগ্রহ করুন।</small>
                    </div>

                    <!-- Currency & Mode Grid -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">কারেন্সি (Currency)</label>
                            <input type="text" name="settings[piprapay_currency]" value="<?= htmlspecialchars($data['settings']['piprapay_currency'] ?? 'BDT') ?>" readonly class="form-control" style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; background: #f8fafc; color: #64748b; font-weight: 700;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.92rem;">গেটওয়ে মোড (Gateway Mode)</label>
                            <select name="settings[piprapay_mode]" class="form-control" style="width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 0.95rem; background: #fff; font-weight: 600;">
                                <option value="live" <?= ($data['settings']['piprapay_mode'] ?? 'live') === 'live' ? 'selected' : '' ?>>Live / Production (বাস্তব লেনদেন)</option>
                                <option value="sandbox" <?= ($data['settings']['piprapay_mode'] ?? '') === 'sandbox' ? 'selected' : '' ?>>Sandbox / Test (পরীক্ষামূলক)</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-save" style="background: #0b7c4d; color: white; padding: 13px 32px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.25s; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25); display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-save"></i> লাইভ সেটিংস সংরক্ষণ করুন
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <!-- Card 2: 10 BDT Live Test Payment Box -->
        <div style="background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1.5px solid #bbf7d0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="width: 44px; height: 44px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 1.3rem;">
                    <i class="fas fa-vial"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">১০ টাকার লাইভ টেস্ট পেমেন্ট যাচাই</h3>
                    <span style="font-size: 0.85rem; color: #64748b;">লাইভ গেটওয়ের সংযোগ ও পেমেন্ট লিঙ্ক তৈরি পরীক্ষা করুন</span>
                </div>
            </div>

            <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                লাইভ সার্ভারে সেটিংস সেভ করার পর এই বাটনে ক্লিক করে <strong>১০ টাকার</strong> একটি রিয়েল-টাইম টেস্ট ট্রানজেকশন তৈরি করে নিশ্চিত হোন যে PipraPay গেটওয়ে সঠিকভাবে কাজ করছে।
            </p>

            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <button type="button" id="btnTestPayment" onclick="runTestPayment(10)" style="background: #10b981; color: white; padding: 13px 25px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.25s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem;">
                    <i class="fas fa-play-circle"></i> ১০ টাকার টেস্ট পেমেন্ট শুরু করুন
                </button>
                <span id="testLoading" style="display: none; color: #0b7c4d; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-spinner fa-spin"></i> লাইভ গেটওয়েতে সংযোগ করা হচ্ছে...
                </span>
            </div>

            <!-- Test Result Box -->
            <div id="testResultBox" style="display: none; margin-top: 20px; padding: 18px; border-radius: 14px; font-size: 0.92rem;">
            </div>

            <!-- Verify Section -->
            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed #cbd5e1;">
                <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.88rem;">
                    <i class="fas fa-search"></i> কোনো পেমেন্ট ID (pp_id) সরাসরি লাইভ ভেরিফাই করুন:
                </label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" id="verifyPpId" class="form-control" style="flex: 1; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-family: monospace;" placeholder="যেমন: 425392227987825798971749439">
                    <button type="button" onclick="verifyPaymentId()" style="background: #0f172a; color: white; padding: 10px 18px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; font-size: 0.9rem;">
                        ভেরিফাই করুন
                    </button>
                </div>
                <div id="verifyResultBox" style="display: none; margin-top: 12px; padding: 14px; border-radius: 10px; font-size: 0.88rem;"></div>
            </div>

        </div>

    </div>

    <!-- Right Column: Live Documentation & Guide -->
    <div style="display: flex; flex-direction: column; gap: 24px;">

        <!-- Doc Card 1: Live Production Setup Guide -->
        <div style="background: #ffffff; border-radius: 20px; padding: 26px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <i class="fas fa-server" style="color: #0b7c4d; font-size: 1.25rem;"></i>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">লাইভ সার্ভার সেটআপ নির্দেশিকা</h3>
            </div>

            <div style="font-size: 0.9rem; color: #475569; line-height: 1.7;">
                <p style="margin-bottom: 14px;">
                    ওয়েবসাইটটি যখন লাইভ প্রোডাকশনে (যেমন: <strong>https://response.nur-lab.com</strong>) থাকবে, তখন PipraPay পেমেন্ট সঠিকভাবে পরিচালনার জন্য নিচের ধাপগুলো অনুসরণ করুন:
                </p>

                <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 16px 0 8px 0; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-globe" style="color: #3b82f6;"></i> ১. লাইভ Base URL নির্ধারণ
                </h4>
                <p style="margin: 0 0 8px 0;">
                    লাইভ ওয়েবসাইটের জন্য আপনার PipraPay গেটওয়ের ডোমেইন URL দিন:<br>
                    <code style="background: #ecfdf5; color: #065f46; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.92rem; border: 1px solid #a7f3d0;">https://pay.nur-lab.com</code>
                </p>

                <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 16px 0 8px 0; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-key" style="color: #f59e0b;"></i> ২. লাইভ API Key সংগ্রহ
                </h4>
                <ol style="padding-left: 20px; margin: 0 0 12px 0;">
                    <li style="margin-bottom: 4px;">লাইভ PipraPay অ্যাডমিন বা মার্চেন্ট প্যানেলে প্রবেশ করুন (<code>https://pay.nur-lab.com/login</code>)।</li>
                    <li style="margin-bottom: 4px;">সাইডবার থেকে <strong>Developers / API Keys</strong> মেনুতে যান।</li>
                    <li style="margin-bottom: 4px;">আপনার ব্র্যান্ডের সক্রিয় (Active) API Key কপি করে <strong>Live Merchant API Key</strong> ফিল্ডে পেস্ট করুন।</li>
                </ol>

                <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 12px; padding: 14px; margin-top: 15px;">
                    <h5 style="margin: 0 0 6px 0; color: #065f46; font-weight: 800; font-size: 0.88rem; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-shield-alt"></i> ৩. লাইভ ডোমেইন হোয়াইটলিস্ট (Domain Whitelist)
                    </h5>
                    <p style="margin: 0; font-size: 0.84rem; color: #047857; line-height: 1.6;">
                        PipraPay-এর নিরাপত্তা নীতি অনুযায়ী লাইভ পেমেন্ট রিডাইরেক্ট সম্পন্ন হতে হলে আপনার ওয়েবসাইটের ডোমেইন (<code>response.nur-lab.com</code>) PipraPay-এর <strong>Domains</strong> তালিকায় <strong>Active</strong> থাকতে হবে।<br>
                        <strong>✓ বর্তমান স্ট্যাটাস:</strong> <code>response.nur-lab.com</code> এবং <code>localhost</code> উভয়ই হোয়াইটলিস্টে যুক্ত ও সক্রিয় রয়েছে।
                    </p>
                </div>
            </div>
        </div>

        <!-- Doc Card 2: Live Endpoints & Webhooks -->
        <div style="background: #ffffff; border-radius: 20px; padding: 26px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <i class="fas fa-network-wired" style="color: #6366f1; font-size: 1.25rem;"></i>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">লাইভ এন্ডপয়েন্ট ও ওয়েবহুক কনফিগারেশন</h3>
            </div>
            <div style="font-size: 0.88rem; color: #475569; line-height: 1.65;">
                <p style="margin-bottom: 10px;">
                    লাইভ ট্রানজেকশনে PipraPay সার্ভারের সাথে নিচের এন্ডপয়েন্টগুলো স্বয়ংক্রিয়ভাবে যোগাযোগ করবে:
                </p>
                <div style="background: #f8fafc; border-radius: 12px; padding: 14px; border: 1px solid #e2e8f0; font-family: monospace; font-size: 0.82rem; display: flex; flex-direction: column; gap: 8px;">
                    <div><span style="color: #64748b;">Checkout API:</span> <strong style="color: #0b7c4d;">https://pay.nur-lab.com/api/checkout/redirect</strong></div>
                    <div><span style="color: #64748b;">Verify API:</span> <strong style="color: #0b7c4d;">https://pay.nur-lab.com/api/verify-payment</strong></div>
                    <div><span style="color: #64748b;">Return URL:</span> <strong style="color: #2563eb;">https://response.nur-lab.com/donation_callback</strong></div>
                    <div><span style="color: #64748b;">Webhook URL:</span> <strong style="color: #2563eb;">https://response.nur-lab.com/donation_callback?status=webhook</strong></div>
                </div>

                <div style="margin-top: 15px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px; font-size: 0.82rem; color: #78350f;">
                    <strong><i class="fas fa-lightbulb"></i> Apache/Nginx হেডার টিপ:</strong> লাইভ সার্ভারে Apache ব্যবহার করলে <code>.htaccess</code> ফাইলে <code>CGIPassAuth On</code> এনাবল রাখবেন যাতে Authorization হেডার সঠিকভাবে PHP-তে পাস হয়।
                </div>
            </div>
        </div>

    </div>

</div>

<script>
function setBaseUrl(url) {
    document.getElementById('piprapay_base_url').value = url;
}

function toggleKeyVisibility() {
    const input = document.getElementById('piprapay_api_key');
    const icon = document.getElementById('key_eye_icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function copyApiKey() {
    const input = document.getElementById('piprapay_api_key');
    if (input.value) {
        navigator.clipboard.writeText(input.value).then(() => {
            alert('API Key সফলভাবে ক্লিপবোর্ডে কপি করা হয়েছে!');
        });
    } else {
        alert('কপি করার জন্য কোনো API Key নেই।');
    }
}

function runTestPayment(amt) {
    const baseUrl = document.getElementById('piprapay_base_url').value;
    const apiKey = document.getElementById('piprapay_api_key').value;
    const loading = document.getElementById('testLoading');
    const resultBox = document.getElementById('testResultBox');
    const btn = document.getElementById('btnTestPayment');

    if (!apiKey) {
        alert('দয়া করে প্রথমে Merchant API Key প্রদান করুন।');
        return;
    }

    btn.disabled = true;
    loading.style.display = 'inline-flex';
    resultBox.style.display = 'none';

    const formData = new FormData();
    formData.append('action', 'test_piprapay');
    formData.append('base_url', baseUrl);
    formData.append('api_key', apiKey);
    formData.append('amount', amt);

    fetch('<?= URLROOT ?>/admin/payment_settings', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        loading.style.display = 'none';
        resultBox.style.display = 'block';

        if (data.status === 'success') {
            resultBox.style.background = '#ecfdf5';
            resultBox.style.border = '1.5px solid #a7f3d0';
            resultBox.style.color = '#065f46';
            resultBox.innerHTML = `
                <div style="font-weight: 800; font-size: 1rem; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> ${data.message}
                </div>
                <div style="margin-bottom: 10px;"><strong>Payment ID (pp_id):</strong> <code>${data.pp_id}</code></div>
                <div style="display: flex; gap: 10px; align-items: center; margin-top: 12px; flex-wrap: wrap;">
                    <a href="${data.pp_url}" target="_blank" style="background: #0b7c4d; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(11,124,77,0.25);">
                        <i class="fas fa-external-link-alt"></i> PipraPay পেমেন্ট পেজে যান (১০ টাকা)
                    </a>
                    <button type="button" onclick="document.getElementById('verifyPpId').value = '${data.pp_id}'; verifyPaymentId();" style="background: #ffffff; border: 1.5px solid #0b7c4d; color: #0b7c4d; padding: 10px 16px; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        স্ট্যাটাস চেক করুন
                    </button>
                </div>
            `;
        } else {
            resultBox.style.background = '#fef2f2';
            resultBox.style.border = '1.5px solid #fecaca';
            resultBox.style.color = '#991b1b';
            resultBox.innerHTML = `
                <div style="font-weight: 800; font-size: 1rem; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-times-circle" style="color: #ef4444;"></i> টেস্ট পেমেন্ট ব্যর্থ হয়েছে
                </div>
                <div>${data.message}</div>
            `;
        }
    })
    .catch(err => {
        btn.disabled = false;
        loading.style.display = 'none';
        resultBox.style.display = 'block';
        resultBox.style.background = '#fef2f2';
        resultBox.style.border = '1.5px solid #fecaca';
        resultBox.style.color = '#991b1b';
        resultBox.innerHTML = `
            <div style="font-weight: 800; font-size: 1rem; margin-bottom: 6px;">রিকোয়েস্ট এরর</div>
            <div>কানেকশন সম্পন্ন করা যায়নি: ${err.message}</div>
        `;
    });
}

function verifyPaymentId() {
    const baseUrl = document.getElementById('piprapay_base_url').value;
    const apiKey = document.getElementById('piprapay_api_key').value;
    const ppId = document.getElementById('verifyPpId').value.trim();
    const resultBox = document.getElementById('verifyResultBox');

    if (!ppId) {
        alert('দয়া করে Payment ID (pp_id) প্রদান করুন।');
        return;
    }

    resultBox.style.display = 'block';
    resultBox.style.background = '#f8fafc';
    resultBox.style.border = '1px solid #cbd5e1';
    resultBox.style.color = '#334155';
    resultBox.innerHTML = '<i class="fas fa-spinner fa-spin"></i> লাইভ যাচাই করা হচ্ছে...';

    const formData = new FormData();
    formData.append('action', 'verify_test_piprapay');
    formData.append('base_url', baseUrl);
    formData.append('api_key', apiKey);
    formData.append('pp_id', ppId);

    fetch('<?= URLROOT ?>/admin/payment_settings', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success' && data.data) {
            const d = data.data;
            const statusColor = (d.status === 'completed' || d.status === 'success') ? '#16a34a' : '#ea580c';
            resultBox.style.background = '#f0fdf4';
            resultBox.style.border = '1px solid #bbf7d0';
            resultBox.innerHTML = `
                <div style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">ভেরিফিকেশন ফলাফল:</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div><strong>স্ট্যাটাস:</strong> <span style="color: ${statusColor}; font-weight: 800; text-transform: uppercase;">${d.status || 'N/A'}</span></div>
                    <div><strong>পরিমাণ:</strong> ${d.amount || '0.00'} ${d.currency || 'BDT'}</div>
                    <div><strong>গেটওয়ে:</strong> ${d.gateway || 'N/A'}</div>
                    <div><strong>ট্রানজেকশন ID:</strong> ${d.transaction_id || 'N/A'}</div>
                </div>
            `;
        } else {
            resultBox.style.background = '#fef2f2';
            resultBox.style.border = '1px solid #fecaca';
            resultBox.style.color = '#991b1b';
            resultBox.innerHTML = data.message || 'পেমেন্ট ভেরিফাই করা যায়নি।';
        }
    })
    .catch(err => {
        resultBox.style.background = '#fef2f2';
        resultBox.style.border = '1px solid #fecaca';
        resultBox.style.color = '#991b1b';
        resultBox.innerHTML = 'ভেরিফিকেশন এরর: ' + err.message;
    });
}
</script>
