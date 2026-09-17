<?php require APPROOT . '/Views/inc/header.php'; ?>

<section style="padding: 80px 0; background: #f8fafc; min-height: 80vh;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Heading -->
        <div style="text-align: center; margin-bottom: 60px;">
            <h1 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                যোগাযোগ <span style="color: #2563eb;">করুন</span>
            </h1>
            <p style="color: #64748b; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                আপনার যে কোনো মতামত, জিজ্ঞাসা বা পরামর্শের জন্য আমাদের কাছে লিখুন। আমরা দ্রুত উত্তর দেওয়ার চেষ্টা করব।
            </p>
            <div style="width: 80px; height: 5px; background: #2563eb; border-radius: 10px; margin: 20px auto 0 auto;"></div>
        </div>

        <?php if (isset($_SESSION['contact_error'])): ?>
            <div style="padding: 15px 20px; background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; border-radius: 12px; margin-bottom: 30px; font-weight: 600; text-align: center;">
                <?= $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['contact_success'])): ?>
            <div style="padding: 25px 30px; background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; border-radius: 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 25px rgba(22,163,74,0.05);">
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px; color: #16a34a;"></i>
                <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 8px;">বার্তা সফলভাবে পাঠানো হয়েছে!</h3>
                <p style="margin: 0; color: #166534; font-size: 0.95rem; line-height: 1.5;"><?= $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Contact Content Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; align-items: start;">
            
            <!-- Left: Contact Details Card -->
            <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 30px;">
                
                <h3 style="font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                    যোগাযোগের তথ্য
                </h3>

                <!-- Info Item 1 -->
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.08); color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 5px;">ঠিকানা</h4>
                        <p style="color: #64748b; margin: 0; line-height: 1.5;"><?= htmlspecialchars($data['settings']['contact_address'] ?? 'ঢাকা, বাংলাদেশ') ?></p>
                    </div>
                </div>

                <!-- Info Item 2 -->
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.08); color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 5px;">ফোন করুন</h4>
                        <p style="color: #64748b; margin: 0; line-height: 1.5;"><?= htmlspecialchars($data['settings']['contact_phone'] ?? '+৮৮০ ১৭০০-০০০০০০') ?></p>
                    </div>
                </div>

                <!-- Info Item 3 -->
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.08); color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 5px;">ইমেইল ঠিকানা</h4>
                        <p style="color: #64748b; margin: 0; line-height: 1.5;"><?= htmlspecialchars($data['settings']['contact_email'] ?? 'info@nur-lab.com') ?></p>
                    </div>
                </div>

                <!-- Social Links -->
                <div style="border-top: 1px solid #f1f5f9; padding-top: 25px; margin-top: 10px;">
                    <h4 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 15px;">আমাদের সামাজিক মাধ্যমসমূহ:</h4>
                    <div style="display: flex; gap: 12px;">
                        <?php
                        $db = \Config\Database::pdoConnect();

                        $social_links_stmt = $db->query("SELECT * FROM social_links ORDER BY order_index ASC, id ASC");
                        $social_links = $social_links_stmt->fetchAll();
                        foreach ($social_links as $link):
                        ?>
                        <a href="<?= $link['url'] ?>" target="_blank" style="width: 42px; height: 42px; border-radius: 50%; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='#2563eb'; this.style.color='#white';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569';">
                            <i class="<?= htmlspecialchars($link['icon']) ?>"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Right: Contact Form Card -->
            <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;">
                
                <h3 style="font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0 0 25px 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">
                    বার্তা পাঠান
                </h3>

                <form action="<?= URLROOT ?>/submit_contact" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">আপনার নাম *</label>
                            <input type="text" name="name" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">ইমেইল ঠিকানা *</label>
                            <input type="email" name="email" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">বিষয় *</label>
                        <input type="text" name="subject" required class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">বার্তা *</label>
                        <textarea name="message" required rows="6" class="form-control" style="width: 100%; padding: 12px 15px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; resize: vertical;"></textarea>
                    </div>

                    <button type="submit" style="width: 100%; height: 50px; background: #2563eb; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.05rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);" onmouseover="this.style.background='#1d4ed8';" onmouseout="this.style.background='#2563eb';">
                        <i class="fas fa-paper-plane"></i> বার্তা পাঠান
                    </button>

                </form>

            </div>

        </div>

    </div>
</section>

<style>
    .form-control:focus {
        border-color: #2563eb !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    @media (max-width: 992px) {
        div[style*="grid-template-columns: 1fr 1.5fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
