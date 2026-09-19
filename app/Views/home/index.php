<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Islamic Hero & Recent Questions Split Section -->
<section class="islamic-hero-section" style="position: relative; background: #e6f4ea; padding: 50px 20px; overflow: hidden; border-bottom: 1px solid #bbf7d0;">
    <!-- Top Decorative Curved Wave Accent -->
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 85px; background: #0b7c4d; clip-path: ellipse(80% 100% at 50% 0%); z-index: 1;"></div>
    
    <div style="max-width: 1320px; margin: 0 auto; position: relative; z-index: 2; padding-top: 15px;">
        <div class="hero-split-grid" style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 30px; align-items: center;">
            
            <!-- LEFT COLUMN: Search & Quick Links -->
            <div style="text-align: left; padding: 10px 0;">
                <!-- Site Main Title -->
                <h1 style="font-size: 2.6rem; font-weight: 900; color: #0b7c4d; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 8px 0; letter-spacing: -0.5px;">
                    <?= htmlspecialchars($data['settings']['site_title'] ?? 'রেসপন্স উইথ নূর-ল্যাব') ?>
                </h1>
                
                <!-- Tagline / Subtitle -->
                <p style="font-size: 1.05rem; color: #475569; font-weight: 600; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 16px 0; line-height: 1.6; max-width: 620px;">
                    সবচেয়ে সমৃদ্ধ বাংলা ইসলামিক প্ল্যাটফর্ম — কুরআন, হাদীস, মাসায়েল ও আপনার সমস্ত ইসলামিক প্রশ্নের উত্তর
                </p>

                <!-- Date & Info Pill Badge -->
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(11, 124, 77, 0.08); border: 1px solid rgba(11, 124, 77, 0.2); padding: 5px 18px; border-radius: 30px; margin-bottom: 24px;">
                    <i class="far fa-calendar-alt" style="color: #0b7c4d; font-size: 0.9rem;"></i>
                    <span style="font-size: 0.88rem; font-weight: 700; color: #0b7c4d; font-family: 'Hind Siliguri', sans-serif;">
                        <?= function_exists('getBengaliDate') ? getBengaliDate() : date('l, d F Y') ?>
                    </span>
                </div>

                <!-- Search Bar Form -->
                <form action="<?= URLROOT ?>/search" method="GET" style="max-width: 580px; margin: 0 0 28px 0; position: relative;">
                    <div style="display: flex; align-items: center; background: #ffffff; border-radius: 50px; padding: 7px 10px 7px 22px; box-shadow: 0 14px 35px rgba(11, 124, 77, 0.12), 0 2px 8px rgba(0, 0, 0, 0.04); border: 2px solid #a7f3d0; transition: all 0.3s ease;">
                        <i class="fas fa-search" style="color: #10b981; font-size: 1.15rem; margin-right: 12px;"></i>
                        <input type="text" name="q" placeholder="কুরআন, হাদীস বা যেকোনো বিষয় খুঁজুন..." style="border: none; outline: none; width: 100%; font-size: 1.05rem; font-family: 'Hind Siliguri', sans-serif; background: transparent; color: #1e293b;" required>
                        <button type="submit" style="background: linear-gradient(135deg, #0b7c4d, #10b981); border: none; width: 44px; height: 44px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.2s ease; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.3); flex-shrink: 0;" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';">
                            <i class="fas fa-search" style="font-size: 0.95rem;"></i>
                        </button>
                    </div>
                </form>

                <!-- Quick Access Buttons Grid -->
                <div style="display: flex; flex-wrap: wrap; gap: 12px; max-width: 640px;">
                    <a href="<?= URLROOT ?>/category/quran" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #f0fdf4; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-quran"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">কুরআন</span>
                    </a>

                    <a href="<?= URLROOT ?>/category/hadith" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">হাদীস</span>
                    </a>

                    <a href="<?= URLROOT ?>/q&amp;a" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">মাসআলা</span>
                    </a>

                    <a href="<?= URLROOT ?>/ask" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-pen-nib"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">প্রশ্ন করুন</span>
                    </a>

                    <a href="<?= URLROOT ?>/q&amp;a" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #fce7f3; color: #db2777; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">প্রশ্নোত্তর</span>
                    </a>

                    <a href="<?= URLROOT ?>/shop" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 12px 16px; min-width: 85px; text-decoration: none; color: #1e293b; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 25px rgba(11, 124, 77, 0.15)';" onmouseout="this.style.transform='none'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 6px;">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <span style="font-size: 0.82rem; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">মুসলিম শপ</span>
                    </a>
                </div>
            </div>

            <!-- RIGHT COLUMN: Recent Questions Widget -->
            <div>
                <div class="bento-item prayer-widget" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 24px; padding: 24px 20px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 20px 50px rgba(11, 124, 77, 0.12), 0 4px 20px rgba(0, 0, 0, 0.04); border: 1.5px solid rgba(16, 185, 129, 0.2); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; min-height: 440px;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 30px 60px rgba(11, 124, 77, 0.2), 0 8px 30px rgba(0, 0, 0, 0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 20px 50px rgba(11, 124, 77, 0.12), 0 4px 20px rgba(0, 0, 0, 0.04)';">
                    
                    <style>
                    @media (max-width: 991px) {
                        .hero-split-grid {
                            grid-template-columns: 1fr !important;
                            text-align: center !important;
                        }
                        .hero-split-grid form {
                            margin: 0 auto 28px auto !important;
                        }
                        .hero-split-grid > div:first-child > div:last-child {
                            justify-content: center !important;
                            margin: 0 auto !important;
                        }
                    }
                    @keyframes pulseGreen {
                        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
                        70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
                    }
                    @keyframes floatBlob1 {
                        0% { transform: translate(0px, 0px) scale(1); }
                        50% { transform: translate(25px, -25px) scale(1.2); }
                        100% { transform: translate(0px, 0px) scale(1); }
                    }
                    @keyframes floatBlob2 {
                        0% { transform: translate(0px, 0px) scale(1); }
                        50% { transform: translate(-25px, 25px) scale(1.2); }
                        100% { transform: translate(0px, 0px) scale(1); }
                    }
                    .bg-blob-1 {
                        position: absolute; top: -60px; right: -60px; width: 190px; height: 190px; 
                        background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(11, 124, 77, 0.08) 60%, transparent 100%); 
                        border-radius: 50%; filter: blur(25px); z-index: 0; pointer-events: none;
                        animation: floatBlob1 12s infinite ease-in-out;
                    }
                    .bg-blob-2 {
                        position: absolute; bottom: -60px; left: -60px; width: 190px; height: 190px; 
                        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, rgba(6, 182, 212, 0.08) 60%, transparent 100%); 
                        border-radius: 50%; filter: blur(25px); z-index: 0; pointer-events: none;
                        animation: floatBlob2 12s infinite ease-in-out;
                    }
                    
                    /* Premium Question Card Item */
                    .prayer-row-3d-premium {
                        display: flex; justify-content: space-between; align-items: center; 
                        padding: 12px 16px; background: #f8fafc; 
                        border-radius: 16px; border: 1px solid #e2e8f0; 
                        text-decoration: none; color: #1e293b; 
                        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); 
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
                        width: 100%; box-sizing: border-box;
                        position: relative; overflow: hidden;
                    }
                    .prayer-row-3d-premium::before {
                        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
                        background: #0b7c4d; opacity: 0; transition: 0.3s;
                    }
                    .prayer-row-3d-premium:hover {
                        transform: translateX(4px);
                        box-shadow: 0 8px 25px rgba(11, 124, 77, 0.12);
                        border-color: #0b7c4d;
                        background: #ffffff;
                    }
                    .prayer-row-3d-premium:hover::before {
                        opacity: 1;
                    }
                    .prayer-row-3d-premium:hover .q-title {
                        color: #0b7c4d;
                    }

                    .prayer-row-3d-premium .btn-uttor-circle {
                        width: 28px; height: 28px; border-radius: 50%; 
                        background: rgba(11, 124, 77, 0.1); 
                        display: inline-flex; align-items: center; justify-content: center; 
                        color: #0b7c4d; transition: all 0.3s; flex-shrink: 0;
                    }
                    .prayer-row-3d-premium:hover .btn-uttor-circle {
                        background: #0b7c4d;
                        color: #ffffff;
                        transform: scale(1.1);
                    }
                    .prayer-row-3d-premium:hover .btn-uttor-circle i {
                        transform: translateX(1px);
                    }
                    
                    .question-dot-premium {
                        width: 10px; height: 6px; border-radius: 3px; 
                        background: rgba(11, 124, 77, 0.2); cursor: pointer; 
                        transition: all 0.3s ease;
                    }
                    .question-dot-premium.active {
                        background: #0b7c4d; width: 24px;
                    }
                    </style>

                    <div class="bg-blob-1"></div>
                    <div class="bg-blob-2"></div>
                    
                    <div style="position: relative; z-index: 2;">
                        <!-- Header Title inside Card -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #f1f5f9;">
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0b7c4d; font-family: 'Hind Siliguri', sans-serif; margin: 0; display: flex; align-items: center; gap: 8px;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); animation: pulseGreen 2s infinite;"></span>
                                <i class="fas fa-comments" style="color: #0b7c4d;"></i> সাম্প্রতিক প্রশ্নসমূহ
                            </h3>
                            <span style="font-size: 0.75rem; background: #e6f4ea; color: #0b7c4d; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-family: 'Hind Siliguri', sans-serif;">Q&amp;A</span>
                        </div>

                        <div class="questions-slider" style="position: relative; overflow: hidden; width: 100%; z-index: 2;">
                            <div class="questions-track" id="questions-track" style="display: flex; transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1); width: 100%;">
                                <?php 
                                $chunks = array_chunk($data['recent_questions'] ?? [], 5);
                                if (!empty($chunks)): 
                                    foreach ($chunks as $chunkIndex => $chunk):
                                ?>
                                    <div class="question-slide" style="width: 100%; flex-shrink: 0; display: flex; flex-direction: column; gap: 8px; padding: 2px; box-sizing: border-box;">
                                        <?php foreach ($chunk as $q): ?>
                                            <a href="<?= URLROOT ?>/question/<?= $q['id'] ?>" class="prayer-row-3d-premium">
                                                <span class="q-title" style="font-size: 0.88rem; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; font-family: 'Hind Siliguri', sans-serif; line-height: 1.35; color: #1e293b; transition: color 0.3s; max-width: 82%; text-align: left;"><?= htmlspecialchars($q['question']) ?></span>
                                                <span class="btn-uttor-circle">
                                                    <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                                                </span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php 
                                    endforeach; 
                                else:
                                ?>
                                    <div style="text-align: center; color: #64748b; padding: 35px 15px; width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;">
                                        <div style="width: 65px; height: 65px; border-radius: 50%; background: linear-gradient(135deg, #e6f4ea, #d1fae5); display: flex; align-items: center; justify-content: center; color: #0b7c4d; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(11, 124, 77, 0.15);">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #1e293b; margin: 0; font-family: 'Hind Siliguri', sans-serif;">কোনো প্রশ্ন পাওয়া যায়নি</h4>
                                        <p style="font-size: 0.85rem; color: #64748b; margin: 0; font-family: 'Hind Siliguri', sans-serif; line-height: 1.4; max-width: 240px;">আপনার যেকোনো ইসলামিক প্রশ্ন সরাসরি আমাদের মাসআলা টিমের কাছে পাঠাতে পারেন।</p>
                                        <a href="<?= URLROOT ?>/ask" style="margin-top: 6px; text-decoration: none; background: linear-gradient(135deg, #0b7c4d, #10b981); color: #fff; padding: 8px 22px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.3); transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(11, 124, 77, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(11, 124, 77, 0.3)';">
                                            <i class="fas fa-paper-plane" style="margin-right: 5px;"></i> প্রশ্ন পাঠান
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
         
                        <?php if (!empty($chunks) && count($chunks) > 1): ?>
                            <div class="question-dots-container" id="question-dots" style="display: flex; justify-content: center; gap: 8px; margin-top: 16px; z-index: 2; position: relative;">
                                <?php foreach ($chunks as $chunkIndex => $chunk): ?>
                                    <div class="question-dot-premium <?= $chunkIndex === 0 ? 'active' : '' ?>" onclick="goToQuestionSlide(<?= $chunkIndex ?>)"></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
         
                    <!-- Ask & View Buttons at the bottom side-by-side -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0; position: relative; z-index: 2; width: 100%; gap: 10px;">
                        <a href="<?= URLROOT ?>/q&amp;a" style="flex: 1; text-align: center; text-decoration: none; color: #0b7c4d; background: #e6f4ea; border: 1px solid rgba(11, 124, 77, 0.2); padding: 9px 12px; border-radius: 12px; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; font-size: 0.88rem; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.3s ease;" onmouseover="this.style.background='#0b7c4d'; this.style.color='#ffffff';" onmouseout="this.style.background='#e6f4ea'; this.style.color='#0b7c4d';">
                            <i class="fas fa-list-ul"></i> সব প্রশ্ন
                        </a>
                        <a href="<?= URLROOT ?>/ask" style="flex: 1; text-align: center; text-decoration: none; color: #ffffff; background: linear-gradient(135deg, #0b7c4d 0%, #10b981 100%); padding: 9px 12px; border-radius: 12px; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; font-size: 0.88rem; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(11, 124, 77, 0.25); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 18px rgba(11, 124, 77, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(11, 124, 77, 0.25)';">
                            <i class="fas fa-plus-circle"></i> প্রশ্ন করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Scopes Section -->
<?php if (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1'): ?>
<section class="scopes-section" style="padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-title" style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 2.8rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                আমাদের <span style="color: #0b7c4d;">কার্যপরিধি</span>
            </h2>
        </div>

        <div class="scopes-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; justify-content: center;">
            <?php if (!empty($data['scopes'])): ?>
                <?php foreach ($data['scopes'] as $scope): ?>
                <div class="scope-card scope-card-animate" style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; padding: 40px 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; flex-direction: column; align-items: flex-start;">
                    <!-- Icon Box with light emerald background -->
                    <div style="width: 55px; height: 55px; border-radius: 16px; background: #e6f4ea; color: #0b7c4d; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(11,124,77,0.12);">
                        <i class="<?= $scope['icon'] ?>"></i>
                    </div>
                    
                    <h3 style="font-size: 1.4rem; color: #1e293b; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 15px 0; line-height: 1.3;"><?= $scope['title'] ?></h3>
                    <p style="color: #1e293b; font-size: 1.05rem; line-height: 1.7; margin: 0; text-align: justify; font-family: 'Hind Siliguri', sans-serif; font-weight: 400;"><?= $scope['description'] ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
    .scope-card {
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s ease;
    }
    .scope-card:hover {
        transform: translateY(-8px);
        border-color: #2563eb !important;
        box-shadow: 0 20px 40px rgba(37,99,235,0.08) !important;
    }
    @media (max-width: 1024px) {
        .scopes-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 992px) {
        .about-flex-row {
            flex-direction: column !important;
            gap: 40px !important;
        }
        .about-flex-row > div {
            width: 100% !important;
        }
        .about-flex-row h2 {
            font-size: 2.2rem !important;
        }
        .about-flex-row h3 {
            font-size: 1.8rem !important;
        }
    }
    @media (max-width: 768px) {
        .scopes-grid {
            grid-template-columns: 1fr !important;
        }
        .scope-card {
            padding: 30px 20px !important;
        }
    }
</style>

<!-- Recent Posts Section -->
<section class="posts-section" style="padding: 100px 0; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px;">
            <div>
                <h2 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; font-family: 'Hind Siliguri', sans-serif; position: relative; display: inline-block;">
                    সাম্প্রতিক <span style="color: #0b7c4d;">লেখাসমূহ</span>
                    <div style="position: absolute; bottom: -15px; left: 0; width: 80px; height: 6px; background: #0b7c4d; border-radius: 10px;"></div>
                </h2>
                <p style="color: #64748b; margin-top: 25px; font-size: 1.1rem;">ইসলাম ও জীবনের সমসাময়িক বিষয়গুলো নিয়ে আমাদের আয়োজন</p>
            </div>
            <a href="<?= URLROOT ?>/blog" style="color: #0b7c4d; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; transition: 0.3s;" onmouseover="this.style.transform='translateX(5px)'; this.style.background='#0b7c4d'; this.style.color='#fff';" onmouseout="this.style.transform='translateX(0)'; this.style.background='#fff'; this.style.color='#0b7c4d';">
                সবগুলো দেখুন <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="recent-posts-grid">
            <?php if (!empty($data['posts'])): ?>
                <?php foreach (array_slice($data['posts'], 0, 12) as $post): ?>
                <div class="premium-post-card post-card-animate" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; border: 1px solid #f1f5f9; display: flex; flex-direction: column;">
                    <!-- Image Wrapper -->
                    <div style="height: 180px; overflow: hidden; position: relative; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                        <?php if (!empty($post['featured_image'])): ?>
                            <?php 
                            $index_img = resolve_blog_image($post['featured_image']);
                            ?>
                            <img src="<?= $index_img ?>" alt="<?= $post['title'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; transition: 0.8s transform;">
                        <?php else: ?>
                            <i class="fa-regular fa-image" style="font-size: 2.5rem; opacity: 0.4;"></i>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content Wrapper -->
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; color: #64748b; font-size: 0.78rem; font-weight: 500; line-height: 1; flex-wrap: wrap; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-right: 1px solid #e2e8f0; padding-right: 8px;">
                                    <i class="fas fa-calendar-alt" style="color: #0b7c4d;"></i>
                                    <?= date('d M', strtotime($post['created_at'])) ?>
                                </span>
                                <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-user" style="color: #0b7c4d;"></i>
                                    এডমিন
                                </span>
                            </div>
                            <span style="white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; color: #64748b;">
                                <i class="fas fa-eye" style="color: #0b7c4d;"></i>
                                <?= number_format($post['views']) ?> বার
                            </span>
                        </div>

                        <h3 style="font-size: 1.05rem; margin-bottom: 12px; color: #000000; line-height: 1.4; font-family: 'Hind Siliguri', sans-serif; font-weight: 800; height: 2.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; transition: 0.3s;">
                            <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" style="text-decoration: none; color: inherit;"><?= $post['title'] ?></a>
                        </h3>
 
                        <p style="font-size: 0.85rem; color: #334155; line-height: 1.5; margin-bottom: 15px; height: 2.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?= strip_tags(!empty($post['excerpt']) ? $post['excerpt'] : $post['content']) ?>
                        </p>
                        
                        <div style="margin-top: auto; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                            <a href="<?= URLROOT ?>/<?= $post['slug'] ?>" class="premium-read-btn" style="color: #0b7c4d; text-decoration: none; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s;">
                                বিস্তারিত পড়ুন 
                                <div style="width: 30px; height: 30px; background: #e6f4ea; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
                                    <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #ffffff; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fas fa-newspaper fa-3x mb-3 text-muted" style="color: #94a3b8;"></i>
                    <p style="color: #64748b; margin: 0; font-family: 'Hind Siliguri', sans-serif; font-size: 1.1rem;">এখনো কোনো লেখা প্রকাশ করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- YouTube Video Gallery Section -->
<section class="yt-videos-section" style="padding: 80px 0; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; border-top: 1px solid #334155; border-bottom: 1px solid #334155;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
            <div>
                <h2 style="font-size: 2.5rem; font-weight: 900; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; position: relative; display: inline-block;">
                    ইউটিউব <span style="color: #ff4d4d;">ভিডিওসমূহ</span>
                    <div style="position: absolute; bottom: -10px; left: 0; width: 60px; height: 5px; background: #ff4d4d; border-radius: 10px;"></div>
                </h2>
                <p style="color: #94a3b8; margin-top: 20px; font-size: 1.1rem;">আমাদের অফিশিয়াল ইউটিউব চ্যানেলের সর্বশেষ ভিডিওগুলো এখানে দেখুন</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="<?= URLROOT ?>/videos" style="color: #ffffff; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: rgba(255,255,255,0.08); border-radius: 12px; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(10px); transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.2)';" onmouseout="this.style.background='rgba(255,255,255,0.08)';">
                    সবগুলো ভিডিও <i class="fas fa-play-circle"></i>
                </a>
                <a href="<?= !empty($data['settings']['youtube_channel_url']) ? $data['settings']['youtube_channel_url'] : 'https://www.youtube.com' ?>" target="_blank" style="color: #ffffff; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #ff0000; border-radius: 12px; border: 1px solid #ff0000; box-shadow: 0 4px 15px rgba(255,0,0,0.3); transition: 0.3s;" onmouseover="this.style.background='#cc0000'; this.style.borderColor='#cc0000';" onmouseout="this.style.background='#ff0000'; this.style.borderColor='#ff0000';">
                    ইউটিউবে দেখুন <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if (!empty($data['yt_videos'])): ?>
                <?php foreach (array_slice($data['yt_videos'], 0, 8) as $video): ?>
                <div class="yt-video-card video-card-animate" style="position: relative; border-radius: 20px; overflow: hidden; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.1); aspect-ratio: 16/9; transition: 0.4s;">
                    <img src="https://img.youtube.com/vi/<?= $video['video_id'] ?>/maxresdefault.jpg" alt="<?= $video['title'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: 0.5s;">
                    
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%); display: flex; flex-direction: column; justify-content: flex-end; padding: 25px; transition: 0.3s;">
                        <span style="color: #ff0000; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;"><?= $video['category_name'] ?? 'ভিডিও' ?></span>
                        <h3 style="color: white; font-size: 1.1rem; line-height: 1.4; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; margin-bottom: 0;"><?= $video['title'] ?></h3>
                    </div>

                    <a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>" target="_blank" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; background: rgba(255,0,0,0.9); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.5rem; text-decoration: none; box-shadow: 0 0 0 0 rgba(255,0,0,0.4); animation: pulse 2s infinite; opacity: 0.9; transition: 0.3s;">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fab fa-youtube fa-4x mb-3 text-muted"></i>
                    <p class="text-muted">এখনো কোনো ইউটিউব ভিডিও যুক্ত করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .yt-video-card:hover { transform: scale(1.03); }
    .yt-video-card:hover img { transform: scale(1.1); opacity: 0.6; }
    .yt-video-card:hover a { transform: translate(-50%, -50%) scale(1.1); background: #ff0000; opacity: 1; }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); }
    }
</style>

<style>
    .premium-post-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important; border-color: #2563eb !important; }
    .premium-post-card:hover img { transform: scale(1.1); }
    .premium-post-card:hover h3 a { color: #2563eb !important; }
    .premium-read-btn:hover div { background: #2563eb !important; color: #fff !important; transform: translateX(3px); }
</style>

<style>
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; border-color: #2563eb !important; }
    .product-card:hover img { transform: scale(1.1); }
    .shop-btn:hover { color: #1d4ed8 !important; }
</style>

<style>
    .section-padding { padding: 40px 0; width: 100%; }
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 25px;
        box-sizing: border-box;
    }
    .slide-text-card {
        transform: translate3d(0, 40px, 0) scale(0.95);
        opacity: 0;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease, box-shadow 0.4s ease;
    }
    .hero-slide.active { opacity: 1 !important; z-index: 5 !important; }
    .hero-slide.active .slide-text-card { transform: translate3d(0, 0, 0) scale(1) !important; opacity: 1 !important; border-color: rgba(37, 99, 235, 0.3) !important; box-shadow: 0 20px 45px rgba(37, 99, 235, 0.18) !important; }
    .hero-slide.active h1 { transform: translate3d(0, 0, 0) !important; opacity: 1 !important; }
    .hero-slide.active p { transform: translate3d(0, 0, 0) !important; opacity: 1 !important; }
    .hero-slide.active .hero-btn-group { transform: translate3d(0, 0, 0) scale(1) !important; opacity: 1 !important; }
    .dot.active { background: #2563eb !important; width: 30px !important; border-radius: 10px !important; }
    .btn-premium:hover { background: #fff !important; color: var(--primary) !important; transform: scale(1.05) !important; box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important; }

    .hero-btn-group {
        display: flex;
        gap: 60px;
        margin-top: 10px;
        transform: translate3d(0, 40px, 0) scale(0.95);
        opacity: 0;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.6s, opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.6s;
        backface-visibility: hidden;
        flex-wrap: nowrap;
        justify-content: center;
        width: 100%;
    }
    .btn-hero {
        background: #2563eb !important;
        color: white !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 200px !important;
        padding: 12px 35px !important;
        border-radius: 50px !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 1.2rem !important;
        transition: 0.3s !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4) !important;
        border: 1.5px solid #2563eb !important;
        white-space: nowrap !important;
    }
    .btn-hero:hover {
        background: white !important;
        color: #2563eb !important;
        border-color: #2563eb !important;
    }

    .recent-posts-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
    }
    @media (max-width: 1400px) { .recent-posts-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 1200px) { .recent-posts-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .recent-posts-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .recent-posts-grid { grid-template-columns: repeat(1, 1fr); } }

    .slide-blur-bg {
        display: none;
    }

    /* Home Page Responsive Tweaks */
    @media (max-width: 1024px) {
        .slide-blur-bg {
            display: none !important; /* Hide blur background */
        }
        .slide-main-img {
            object-fit: cover !important; /* Fully cover container aspect ratio */
            opacity: 0.8 !important;
        }
        .bento-grid {
            grid-template-columns: 1fr !important;
            padding: 0 20px !important;
            gap: 25px !important;
        }
        .bento-item.main-featured {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
            min-height: auto !important;
            aspect-ratio: 16/10 !important; /* Scaled aspect ratio matching landscape images */
            height: auto !important;
        }
        .bento-item.prayer-widget {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
            padding: 25px !important;
        }
        .slide-content {
            padding: 20px !important;
            padding-bottom: 30px !important;
        }
        .slide-text-card {
            padding: 10px 20px !important;
            max-width: 90% !important;
            border-radius: 15px !important;
        }
        .slide-text-card h1 {
            font-size: 1.8rem !important;
            margin-top: 0 !important;
            margin-bottom: 4px !important;
        }
        .slide-text-card p {
            font-size: 1rem !important;
            margin-top: 0 !important;
            margin-bottom: 6px !important;
        }
        .slide-text-card .btn-premium {
            padding: 6px 18px !important;
            font-size: 0.85rem !important;
        }
        .hero-btn-group {
            gap: 20px !important;
            flex-wrap: nowrap !important;
            transform: none !important;
        }
        .btn-hero {
            min-width: 130px !important;
            padding: 8px 18px !important;
            font-size: 0.95rem !important;
        }
        .slider-dots {
            bottom: 12px !important;
        }
        .dot {
            width: 8px !important;
            height: 8px !important;
        }
        .dot.active {
            width: 20px !important;
        }
        .container-fluid {
            padding: 0 20px !important;
        }
        section {
            padding: 50px 0 !important;
        }
    }

    @media (max-width: 768px) {
        .bento-item.main-featured {
            aspect-ratio: 16/11 !important; /* Slightly taller for smaller screens to fit text */
        }
        .slide-content {
            padding: 10px !important;
            padding-bottom: 20px !important;
        }
        .slide-text-card {
            padding: 6px 12px !important;
            max-width: 90% !important;
            border-radius: 12px !important;
        }
        .slide-text-card h1 {
            font-size: 1.3rem !important;
            margin-top: 0 !important;
            margin-bottom: 2px !important;
        }
        .slide-text-card p {
            font-size: 0.8rem !important;
            margin-top: 0 !important;
            margin-bottom: 4px !important;
            white-space: normal !important;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .slide-text-card .btn-premium {
            padding: 5px 12px !important;
            font-size: 0.75rem !important;
            margin-top: 2px !important;
        }
        .hero-btn-group {
            gap: 10px !important;
            flex-wrap: nowrap !important;
            margin-top: 5px !important;
            transform: none !important;
        }
        .btn-hero {
            min-width: 100px !important;
            padding: 6px 10px !important;
            font-size: 0.8rem !important;
        }
        .slider-arrow {
            display: none !important;
        }
        .section-header-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
            margin-bottom: 30px !important;
        }
        .section-header-flex a {
            align-self: flex-start;
        }
        .section-header-flex h2 {
            font-size: 2rem !important;
        }
    }

    /* Premium Mobile Layout Tweaks (max-width: 600px) */
    @media (max-width: 600px) {
        .slide-text-card p {
            display: none !important; /* Hide slide descriptions on small mobile screens */
        }

        /* Recent Posts: Premium 2-column Grid layout */
        .recent-posts-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            padding: 0 5px !important;
        }

        .premium-post-card {
            display: flex !important;
            flex-direction: column !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
            border: 1px solid #e2e8f0 !important;
            gap: 0 !important;
            transition: all 0.3s ease !important;
        }

        /* Target first child (image wrapper) */
        .premium-post-card > div:first-child {
            width: 100% !important;
            height: 110px !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        /* Target second child (content wrapper) */
        .premium-post-card > div:last-child {
            padding: 10px !important;
            flex-grow: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            min-height: auto !important;
        }

        .premium-post-card h3 {
            font-size: 0.85rem !important;
            font-weight: 800 !important;
            margin-bottom: 6px !important;
            line-height: 1.35 !important;
            height: 2.3rem !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .premium-post-card p {
            display: none !important; /* Hide excerpt on mobile grid view */
        }

        .premium-post-card > div:last-child > div:first-child {
            margin-bottom: 6px !important;
            font-size: 0.68rem !important;
            gap: 4px !important;
            justify-content: flex-start !important;
            flex-wrap: wrap !important;
        }

        .premium-post-card > div:last-child > div:first-child span {
            border-right: none !important;
            padding-right: 0 !important;
        }

        .premium-post-card > div:last-child > div:last-child {
            margin-top: auto !important;
            padding-top: 6px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        .premium-read-btn {
            font-size: 0.72rem !important;
            font-weight: 800 !important;
        }

        .premium-read-btn div {
            width: 20px !important;
            height: 20px !important;
        }

        /* YouTube Videos: 2-column compact grid */
        .yt-videos-section div[style*="display: grid"] {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }

        .yt-video-card {
            border-radius: 14px !important;
            aspect-ratio: 16/10 !important;
        }

        .yt-video-card h3 {
            font-size: 0.82rem !important;
            line-height: 1.3 !important;
        }

        .yt-video-card div[style*="position: absolute"] {
            padding: 12px !important;
        }

        .yt-video-card a[href*="youtube.com"] {
            width: 40px !important;
            height: 40px !important;
            font-size: 1rem !important;
        }

        /* Scopes: 2-column compact grid */
        .scopes-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }

        .scope-card {
            padding: 20px 15px !important;
            border-radius: 16px !important;
            align-items: center !important;
            text-align: center !important;
        }

        .scope-card div[style*="width: 55px"] {
            width: 45px !important;
            height: 45px !important;
            margin-bottom: 12px !important;
            font-size: 1.2rem !important;
            border-radius: 12px !important;
        }

        .scope-card h3 {
            font-size: 1.1rem !important;
            margin-bottom: 8px !important;
            text-align: center !important;
        }

        .scope-card p {
            font-size: 0.85rem !important;
            text-align: center !important;
            line-height: 1.5 !important;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Questions Widget Mobile Spacing */
        .bento-item.prayer-widget {
            padding: 24px !important;
            border-radius: 20px !important;
            min-height: auto !important;
            box-shadow: 0 10px 30px rgba(11, 124, 77, 0.15) !important;
        }
        .bento-item.prayer-widget .widget-header {
            margin-bottom: 20px !important;
        }
        .bento-item.prayer-widget .widget-header a {
            padding: 8px 20px !important;
            font-size: 1.1rem !important;
        }
        .prayer-row {
            padding-bottom: 10px !important;
        }
        .prayer-row span:first-child {
            font-size: 0.88rem !important;
            max-width: 65% !important;
        }
        .prayer-row .btn-uttor {
            font-size: 0.85rem !important;
        }

        /* Adjust section headers */
        .section-header-flex {
            padding: 0 !important;
            margin-bottom: 25px !important;
        }
        
        .section-header-flex h2 {
            font-size: 1.8rem !important;
        }

        .section-header-flex p {
            font-size: 0.95rem !important;
            margin-top: 10px !important;
        }
        
        .section-header-flex a {
            padding: 8px 18px !important;
            font-size: 0.9rem !important;
            margin-top: 10px !important;
        }
    }
</style>
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.dot');

function showSlide(n) {
    if (slides.length === 0) return;
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));
    
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    if (dots.length > 0 && dots[currentSlide]) {
        dots[currentSlide].classList.add('active');
    }
}

function goToSlide(n) {
    showSlide(n);
    resetTimer();
}

function nextSlide() {
    showSlide(currentSlide + 1);
}

function prevSlide() {
    showSlide(currentSlide - 1);
    resetTimer();
}

function clickNext() {
    nextSlide();
    resetTimer();
}

let timer = setInterval(nextSlide, 5000);

function resetTimer() {
    clearInterval(timer);
    timer = setInterval(nextSlide, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    showSlide(0);
});
</script>
<!-- YouTube Floating Notification Widget -->
<?php if (($data['settings']['youtube_status'] ?? '') == 'active' && !empty($data['settings']['youtube_video_id'])): ?>
<div id="youtube-notification" style="position: fixed; bottom: 30px; right: 30px; width: 320px; background: #fff; border-radius: 15px; box-shadow: 0 15px 50px rgba(0,0,0,0.2); z-index: 9999; overflow: hidden; animation: slideInUp 1s ease-out; border: 1px solid #eee;">
    <div style="background: #2563eb; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 700; font-size: 0.9rem;"><i class="fab fa-youtube"></i> <?= $data['settings']['youtube_title'] ?? 'আমরা এখন লাইভে আছি!' ?></span>
        <button onclick="document.getElementById('youtube-notification').style.display='none'" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
    </div>
    <div style="position: relative; padding-bottom: 56.25%; height: 0;">
        <iframe 
            src="https://www.youtube.com/embed/<?= $data['settings']['youtube_video_id'] ?>?autoplay=1&mute=1&rel=0" 
            loading="lazy"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>
    <div style="padding: 10px; text-align: center; background: #f8fafc;">
        <a href="https://www.youtube.com/channel/<?= $data['settings']['youtube_channel_id'] ?? '' ?>" target="_blank" style="color: #ff0000; text-decoration: none; font-weight: 700; font-size: 0.8rem;">চ্যানেল সাবস্ক্রাইব করুন <i class="fas fa-external-link-alt"></i></a>
    </div>
</div>

<style>
@keyframes slideInUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
<?php endif; ?>

    <!-- Team Members Section -->
    <?php if (!empty($data['team'])): ?>
    <section class="team-section animate-team-section" style="padding: 80px 0; background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
            <div class="section-title" style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; color: #1e293b; font-weight: 800; font-family: 'Hind Siliguri', sans-serif;">আমাদের <span style="color: #0b7c4d;">টিম</span></h2>
                <p style="color: #64748b; margin-top: 10px; font-family: 'Hind Siliguri', sans-serif;">আমাদের পোর্টালে নিরলসভাবে কাজ করে যাওয়া দক্ষ সদস্যবৃন্দ</p>
            </div>

            <div class="team-grid">
                <?php foreach($data['team'] as $member): ?>
                <div class="team-card team-card-animate team-card-slide-in" style="background: #ffffff; border-radius: 24px; overflow: hidden; text-align: center; border: 1px solid #e2e8f0; padding: 35px 25px; box-shadow: 0 10px 35px rgba(0,0,0,0.03);">
                    <div class="team-img-wrapper" style="width: 150px; height: 150px; margin: 0 auto 25px; border-radius: 50%; overflow: hidden; border: 3px solid #0b7c4d; box-shadow: 0 0 20px rgba(11, 124, 77, 0.15);">
                        <img src="<?= resolve_blog_image($member['image']) ?>" alt="<?= $member['name'] ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <h3 style="font-size: 1.3rem; color: #1e293b; margin: 0 0 8px 0; font-weight: 700; line-height: 1.2; letter-spacing: 0.5px; font-family: 'Hind Siliguri', sans-serif;"><?= $member['name'] ?></h3>
                    <p style="color: #0b7c4d; font-size: 0.95rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'Hind Siliguri', sans-serif;"><?= $member['designation'] ?></p>
                    
                    <div style="border-top: 1px solid #e2e8f0; width: 80%; margin: 20px auto;"></div>
                    
                    <div style="display: flex; justify-content: center; gap: 15px;">
                        <?php if(!empty($member['facebook_link'])): ?>
                        <a href="<?= $member['facebook_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1877f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($member['twitter_link'])): ?>
                        <a href="<?= $member['twitter_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1da1f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <style>
        .team-card-slide-in {
            opacity: 0;
            transform: translate3d(70px, 0, 0);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease, border-color 0.4s ease, box-shadow 0.4s ease;
            will-change: transform, opacity;
        }
        .team-card-slide-in.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
        .team-card-slide-in.visible:nth-child(1) { transition-delay: 0.06s; }
        .team-card-slide-in.visible:nth-child(2) { transition-delay: 0.12s; }
        .team-card-slide-in.visible:nth-child(3) { transition-delay: 0.18s; }
        .team-card-slide-in.visible:nth-child(4) { transition-delay: 0.24s; }
        .team-card-slide-in.visible:nth-child(5) { transition-delay: 0.30s; }
        .team-card-slide-in.visible:nth-child(6) { transition-delay: 0.36s; }
        .team-card-slide-in.visible:nth-child(7) { transition-delay: 0.42s; }
        .team-card-slide-in.visible:nth-child(8) { transition-delay: 0.48s; }
        .team-card-slide-in.visible:nth-child(9) { transition-delay: 0.54s; }
        .team-card-slide-in.visible:nth-child(10) { transition-delay: 0.60s; }
        .team-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            max-width: 1400px;
            margin: 0 auto;
        }
        .team-card {
            width: calc(20% - 16px);
            box-sizing: border-box;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease, box-shadow 0.4s ease;
        }
        .team-img-wrapper {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
        }
        .team-card:hover {
            transform: translateY(-8px) !important;
            border-color: #0b7c4d !important;
            box-shadow: 0 20px 40px rgba(11, 124, 77, 0.08) !important;
        }
        .team-card:hover .team-img-wrapper {
            transform: scale(1.05) !important;
            box-shadow: 0 0 25px rgba(11, 124, 77, 0.35) !important;
        }
        
        @media (max-width: 1400px) {
            .team-card {
                width: calc(25% - 15px);
            }
        }
        @media (max-width: 1024px) {
            .team-card {
                width: calc(33.333% - 14px);
            }
        }
        @media (max-width: 768px) {
            .team-card {
                width: calc(50% - 10px);
            }
        }
        @media (max-width: 480px) {
            .team-card {
                width: 100%;
            }
        }
    </style>

<!-- Reviews Section -->
<?php if (!empty($data['reviews'])): ?>
<section class="reviews-section" style="padding: 80px 0; background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-top: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; overflow: hidden; position: relative;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%; position: relative; z-index: 2;">
        <div class="section-title" style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                কমিউনিটির <span style="color: #0b7c4d;">মতামত</span>
            </h2>
            <p style="color: #64748b; margin-top: 10px; font-size: 1.1rem; font-family: 'Hind Siliguri', sans-serif;">আমাদের সম্পর্কে কমিউনিটির কিছু মূল্যবান মতামত</p>
        </div>
    </div>

    <!-- Review Slider Track Wrapper -->
    <div class="reviews-slider-wrapper" style="width: 100%; overflow: hidden; padding: 20px 0;">
        <div class="reviews-track" style="display: flex; gap: 20px; width: max-content; animation: scrollReviews 45s linear infinite;">
            <!-- Render original reviews -->
            <?php foreach (array_merge($data['reviews'], $data['reviews']) as $index => $review): ?>
            <div class="review-slide-card" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 30px 25px; width: 300px; flex-shrink: 0; box-shadow: 0 10px 25px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 15px; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#0b7c4d';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                <!-- Stars -->
                <div style="color: #fbbf24; display: flex; gap: 3px; font-size: 0.9rem;">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
                <!-- Review text -->
                <p style="color: #1e293b; font-size: 0.95rem; line-height: 1.6; margin: 0; font-family: 'Hind Siliguri', sans-serif; height: 90px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;"><?= htmlspecialchars($review['review_text']) ?></p>
                <!-- Profile -->
                <div style="display: flex; align-items: center; gap: 12px; margin-top: auto; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                    <img src="<?= !empty($review['image']) ? $review['image'] : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review['name']))) . '?d=mp&s=150' ?>" alt="<?= $review['name'] ?>" loading="lazy" decoding="async" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1.5px solid #0b7c4d;">
                    <div>
                        <h4 style="font-size: 0.95rem; color: #1e293b; font-weight: 700; margin: 0; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($review['name']) ?></h4>
                        <span style="font-size: 0.8rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($review['designation'] ?? 'নিয়মিত পাঠক') ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    @keyframes scrollReviews {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-320px * <?= count($data['reviews']) ?>)); }
    }
    .reviews-track:hover {
        animation-play-state: paused;
    }
</style>
<?php endif; ?>

<!-- FAQ Section -->
<?php if (!empty($data['faqs'])): ?>
<section class="faq-section faqs-section" style="padding: 80px 0; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; width: 100%;">
        <div class="section-title" style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                সাধারণ <span style="color: #2563eb;">জিজ্ঞাসা</span>
            </h2>
        </div>

        <div class="faq-accordion-container" style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($data['faqs'] as $index => $faq): ?>
            <div class="faq-item faq-item-animate" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s ease;">
                <button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 25px 30px; background: none; border: none; text-align: left; cursor: pointer; outline: none; font-family: 'Hind Siliguri', sans-serif; font-size: 1.25rem; font-weight: 700; color: #1e293b; transition: all 0.3s ease;">
                    <span style="padding-right: 20px; line-height: 1.4;"><?= htmlspecialchars($faq['question']) ?></span>
                    <i class="fas fa-chevron-down faq-icon" style="color: #2563eb; font-size: 1.1rem; transition: transform 0.3s ease;"></i>
                </button>
                <div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s cubic-bezier(0, 1, 0, 1); background: #ffffff;">
                    <div style="padding: 0 30px 25px 30px; color: #1e293b; font-size: 1.1rem; line-height: 1.8; font-family: 'Hind Siliguri', sans-serif; border-top: 1px solid #f1f5f9; text-align: justify; font-weight: 400;">
                        <?= $faq['answer'] ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .faq-item:hover {
        border-color: #2563eb !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.05) !important;
    }
    .faq-item.active {
        border-color: #2563eb !important;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08) !important;
    }
    .faq-item.active .faq-trigger {
        color: #2563eb !important;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }
    .faq-content.open {
        max-height: 1000px !important;
        transition: max-height 0.4s cubic-bezier(1, 0, 1, 0) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqTriggers = document.querySelectorAll('.faq-trigger');
    
    faqTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const faqContent = faqItem.querySelector('.faq-content');
            const isActive = faqItem.classList.contains('active');
            
            // Close all active items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
                item.querySelector('.faq-content').style.maxHeight = '0';
            });
            
            // Toggle clicked item
            if (!isActive) {
                faqItem.classList.add('active');
                // Use scrollHeight for dynamic open height
                faqContent.style.maxHeight = faqContent.scrollHeight + 'px';
            }
        });
    });
});
</script>
<?php endif; ?>

<script>
    // Recent Questions Widget Sliding Logic
    (function() {
        let currentQuestionSlide = 0;
        const track = document.getElementById('questions-track');
        const dots = document.querySelectorAll('#question-dots .question-dot');
        const slidesCount = document.querySelectorAll('.question-slide').length;
        
        if (!track || slidesCount <= 1) return;

        function showQuestionSlide(n) {
            currentQuestionSlide = (n + slidesCount) % slidesCount;
            track.style.transform = `translateX(-${currentQuestionSlide * 100}%)`;
            
            dots.forEach((dot, idx) => {
                if (idx === currentQuestionSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        window.goToQuestionSlide = function(n) {
            showQuestionSlide(n);
            resetQuestionTimer();
        };

        let timer = setInterval(function() {
            showQuestionSlide(currentQuestionSlide + 1);
        }, 6000);

        function resetQuestionTimer() {
            clearInterval(timer);
            timer = setInterval(function() {
                showQuestionSlide(currentQuestionSlide + 1);
            }, 6000);
        }
    })();
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
