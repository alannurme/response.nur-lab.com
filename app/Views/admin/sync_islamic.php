<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.sync-header-banner {
    background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #059669 100%);
    border-radius: 20px;
    padding: 30px;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.25);
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}
.sync-header-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    pointer-events: none;
}
.sync-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.sync-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.07);
    border-color: rgba(16, 185, 129, 0.3);
}
.sync-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.6);
}
.sync-stat-badge {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 18px;
}
.sync-select-input {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1.5px solid #cbd5e1;
    font-weight: 700;
    font-size: 0.88rem;
    color: #1e293b;
    outline: none;
    background: #ffffff;
    transition: border-color 0.2s;
}
.sync-select-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}
.sync-btn {
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.92rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.sync-btn:hover {
    filter: brightness(1.08);
    transform: translateY(-1px);
}
.sync-btn:active {
    transform: translateY(0);
}
.btn-resync {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #0f172a;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-resync:hover {
    background: #10b981 !important;
    color: #fff !important;
    border-color: #10b981 !important;
}
@media (max-width: 768px) {
    .sync-cards-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<!-- Banner Header -->
<div class="sync-header-banner d-flex justify-content-between align-items-center">
    <div>
        <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fas fa-database me-1"></i> Local DB Sync Engine
        </span>
        <h2 style="font-weight: 900; margin: 10px 0 4px 0; font-size: 1.75rem;">
            ইসলামিক ডাটা সিঙ্ক ম্যানেজার
        </h2>
        <p style="margin: 0; opacity: 0.9; font-size: 0.92rem; font-weight: 500;">
            পবিত্র কুরআন (আয়াত, অর্থ, অডিও, তাফসীর) এবং হাদিস ডাটাবেজ এক ক্লিকে লোকাল সিঙ্ক করুন
        </p>
    </div>
    <div class="d-none d-md-block text-end">
        <div style="font-size: 2.5rem; opacity: 0.3;">
            <i class="fas fa-kaaba"></i>
        </div>
    </div>
</div>

<!-- Sync Page Content Wrapper for dynamic AJAX updates without full reload -->
<div id="syncPageWrapper">
<!-- Main Cards Grid (2 cards per row) -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 30px;" class="sync-cards-grid">
    
    <!-- 1. Quran Verses & Bangla Translation Card -->
    <div class="sync-card">
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="sync-icon-box" style="background: #ecfdf5; color: #10b981;">
                        <i class="fas fa-quran"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">পবিত্র কুরআন ও বাংলা অনুবাদ সিঙ্ক</h4>
                        <span style="font-size: 0.8rem; color: #10b981; font-weight: 700;">১১৪টি সূরা • ৬,২৩৬টি আয়াত ও বাংলা অনুবাদ</span>
                    </div>
                </div>
            </div>

            <div class="sync-stat-badge" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 700;">সংরক্ষিত আরবি পাঠ:</span>
                    <span style="font-size: 0.95rem; font-weight: 800; color: #10b981;"><?= number_format($quranCount) ?> / 6,236</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 0.82rem; color: #047857; font-weight: 800;"><i class="fas fa-language"></i> বাংলা অনুবাদ সিঙ্কড:</span>
                    <span style="font-size: 0.95rem; font-weight: 800; color: #059669;"><?= number_format($banglaCount ?? $quranCount) ?> / 6,236</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 0.82rem; color: #b45309; font-weight: 800;"><i class="fas fa-spell-check"></i> বাংলা উচ্চারণ সিঙ্কড:</span>
                    <span style="font-size: 0.95rem; font-weight: 800; color: #d97706;"><?= number_format($transliterationCount ?? $quranCount) ?> / 6,236</span>
                </div>
                <div style="width: 100%; height: 8px; background: #cbd5e1; border-radius: 4px; overflow: hidden;">
                    <div style="width: <?= min(100, round((($banglaCount ?? $quranCount) / 6236) * 100)) ?>%; height: 100%; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.3s;"></div>
                </div>
            </div>
        </div>

        <button onclick="startSync('quran_all&tafsir=all', this)" class="sync-btn" style="background: linear-gradient(135deg, #10b981, #059669); width: 100%;">
            <i class="fas fa-arrows-rotate"></i> <span>১. সম্পূর্ণ কুরআন ও বাংলা অনুবাদ সিঙ্ক করুন</span>
        </button>
    </div>

    <!-- 2. Quran Audio Reciter Card -->
    <div class="sync-card">
        <div>
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                <div class="sync-icon-box" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fas fa-file-audio"></i>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">কুরআন অডিও সিঙ্ক</h4>
                    <span style="font-size: 0.8rem; color: #3b82f6; font-weight: 700;">ক্বারী তিলওয়াত অডিও লিংক</span>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="font-size: 0.85rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">ক্বারী নির্বাচন করুন:</label>
                <select id="adminReciterSelect" class="sync-select-input">
                    <option value="ar.alafasy">মিশারী রশীদ আল-আফাসী (Mishary Rashid Alafasy)</option>
                    <option value="ar.abdulbasitmurattal">আব্দুল বাসিত আব্দুস সামাদ (Abdul Basit Murattal)</option>
                    <option value="ar.sudais">আব্দুর রহমান আস-সুদাইস (Abdur-Rahman As-Sudais)</option>
                    <option value="ar.shatri">আবু বকর আশ-শাত্রী (Abu Bakr Al-Shatri)</option>
                </select>
            </div>
        </div>

        <button onclick="startSync('quran_all&tafsir=all&reciter=' + document.getElementById('adminReciterSelect').value, this)" class="sync-btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); width: 100%;">
            <i class="fas fa-headphones"></i> <span>২. অডিও তিলওয়াত সিঙ্ক</span>
        </button>
    </div>

    <!-- 3. Tafsir Sync Card -->
    <div class="sync-card">
        <div>
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                <div class="sync-icon-box" style="background: #fdf4ff; color: #a855f7;">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">তাফসীর গ্রন্থ সিঙ্ক</h4>
                    <span style="font-size: 0.8rem; color: #a855f7; font-weight: 700;">কুরআন তাফসীর ডাটা</span>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="font-size: 0.85rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">তাফসীর গ্রন্থ নির্বাচন করুন:</label>
                <select id="adminTafsirSelect" class="sync-select-input">
                    <option value="all">সকল ৬টি তাফসীর একসাথে (All 6 Tafsirs - Recommended)</option>
                    <option value="165">তাফসীর আহসানুল বায়ান (বাংলা)</option>
                    <option value="166">তাফসীর আবু বকর জাকারিয়া (বাংলা)</option>
                    <option value="164">তাফসীর ইবনে কাছীর (বাংলা)</option>
                    <option value="381">তাফসীর ফাতহুল মাজীদ (বাংলা)</option>
                    <option value="169">Tafsir Ibn Kathir (English)</option>
                    <option value="168">Ma'arif al-Qur'an (English)</option>
                </select>
            </div>
        </div>

        <button onclick="startSync('quran_all&tafsir=' + document.getElementById('adminTafsirSelect').value, this)" class="sync-btn" style="background: linear-gradient(135deg, #a855f7, #9333ea); width: 100%;">
            <i class="fas fa-book-bookmark"></i> <span>৩. নির্বাচিত তাফসীর সিঙ্ক</span>
        </button>
    </div>

    <!-- 4. Hadith Card -->
    <div class="sync-card">
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="sync-icon-box" style="background: #fffbeb; color: #f59e0b;">
                        <i class="fas fa-book-journal-whills"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">আল-হাদিস ডাটা</h4>
                        <span style="font-size: 0.8rem; color: #f59e0b; font-weight: 700;">৮টি হাদিস গ্রন্থ • ৩৬,০০০+ হাদিস</span>
                    </div>
                </div>
            </div>

            <div class="sync-stat-badge">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">সংরক্ষিত হাদিস:</span>
                    <span style="font-size: 1.05rem; font-weight: 800; color: #f59e0b;"><?= number_format($hadithCount) ?> টি</span>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="font-size: 0.85rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">হাদিস গ্রন্থ নির্বাচন করুন:</label>
                <select id="adminHadithBookSelect" class="sync-select-input">
                    <option value="ben-bukhari">সহীহ বুখারী</option>
                    <option value="ben-muslim">সহীহ মুসলিম</option>
                    <option value="ben-abudawud">সূনান আবু দাউদ</option>
                    <option value="ben-tirmidhi">জামে' আত-তিরমিজী</option>
                    <option value="ben-nasai">সূনান আন-নাসায়ী</option>
                    <option value="ben-ibnmajah">সূনান ইবনে মাজাহ</option>
                    <option value="ben-malik">মুয়াত্তা মালিক</option>
                    <option value="ben-nawawi">৪০ হাদিস (ইমাম নববী)</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button onclick="startSync('hadith&book=' + document.getElementById('adminHadithBookSelect').value, this)" class="sync-btn" style="flex: 1; background: linear-gradient(135deg, #eab308, #ca8a04); padding: 11px 8px; font-size: 0.85rem;">
                <i class="fas fa-file-lines"></i> <span>সিলেক্টেড বই সিঙ্ক</span>
            </button>
            <button onclick="startSync('hadith_all', this)" class="sync-btn" style="flex: 1; background: linear-gradient(135deg, #f59e0b, #d97706); padding: 11px 8px; font-size: 0.85rem;">
                <i class="fas fa-arrows-rotate"></i> <span>সব বই সিঙ্ক</span>
            </button>
        </div>
    </div>
</div>

<!-- Synced Surahs Status List Section -->
<div style="background: #ffffff; border-radius: 20px; padding: 26px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); margin-bottom: 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="fas fa-list-check"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">ডাটাবেজে সিঙ্ক হওয়া সূরাস মূহের তালিকা</h3>
                <p style="margin: 2px 0 0 0; color: #64748b; font-size: 0.85rem;">মোট <?= count($syncedSurahs) ?>/১১৪ টি সূরা ডাটাবেজে সংরক্ষিত রয়েছে</p>
            </div>
        </div>

        <div style="position: relative; min-width: 240px;">
            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
            <input type="text" id="surahSearchInput" onkeyup="filterSurahTable()" placeholder="সূরা খুঁজুন (নাম/নম্বর)..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; box-sizing: border-box;">
        </div>
    </div>

    <?php if (empty($syncedSurahs)): ?>
        <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1; color: #64748b;">
            <i class="fas fa-inbox" style="font-size: 2.2rem; color: #94a3b8; margin-bottom: 10px; display: block;"></i>
            <div style="font-size: 1rem; font-weight: 700; color: #334155;">এখনও কোনো সূরা ডাটাবেজে সিঙ্ক করা হয়নি</div>
            <div style="font-size: 0.85rem; margin-top: 4px;">উপরের "১. শুধু আয়াত ও অনুবাদ সিঙ্ক" বাটনে ক্লিক করে সিঙ্ক শুরু করুন।</div>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="table table-hover align-middle" style="margin: 0; border-collapse: separate; border-spacing: 0; width: 100%; font-size: 0.9rem;" id="surahStatusTable">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px 14px; border-radius: 8px 0 0 8px;">#</th>
                        <th style="padding: 12px 14px;">সূরার নাম (বাংলা)</th>
                        <th style="padding: 12px 14px;">আরবি নাম</th>
                        <th style="padding: 12px 14px; text-align: center;">সংরক্ষিত আয়াত</th>
                        <th style="padding: 12px 14px; text-align: center;">বাংলা অনুবাদ</th>
                        <th style="padding: 12px 14px; text-align: center;">বাংলা উচ্চারণ</th>
                        <th style="padding: 12px 14px; text-align: center;">সিঙ্কড অডিও (ক্বারী)</th>
                        <th style="padding: 12px 14px; text-align: center;">তাফসীর ডাটা</th>
                        <th style="padding: 12px 14px; text-align: center;">স্ট্যাটাস</th>
                        <th style="padding: 12px 14px; text-align: right; border-radius: 0 8px 8px 0;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($syncedSurahs as $s): 
                        $isFull = ($s['synced_count'] >= $s['total_ayahs']) && ($s['total_ayahs'] > 0);
                        
                        // Detect reciter from all_audios / sample_audio
                        $detectedReciters = [];
                        $audioStr = !empty($s['all_audios']) ? $s['all_audios'] : ($s['sample_audio'] ?? '');
                        
                        if (!empty($audioStr)) {
                            if (strpos($audioStr, 'alafasy') !== false || strpos($audioStr, 'Alafasy') !== false) {
                                $detectedReciters[] = "মিশারী রশীদ আল-আফাসী";
                            }
                            if (strpos($audioStr, 'abdulbasitmurattal') !== false || strpos($audioStr, 'Abdul_Basit') !== false) {
                                $detectedReciters[] = "আব্দুল বাসিত";
                            }
                            if (strpos($audioStr, 'sudais') !== false || strpos($audioStr, 'Sudais') !== false) {
                                $detectedReciters[] = "আস-সুদাইস";
                            }
                            if (strpos($audioStr, 'shatri') !== false || strpos($audioStr, 'Shaatree') !== false) {
                                $detectedReciters[] = "আবু বকর আশ-শাত্রী";
                            }
                        }

                        if (count($detectedReciters) >= 4) {
                            $reciterName = "সকল ৪ জন ক্বারী";
                        } elseif (count($detectedReciters) > 1) {
                            $reciterName = implode(', ', $detectedReciters);
                        } elseif (count($detectedReciters) === 1) {
                            $reciterName = $detectedReciters[0];
                        } else {
                            $reciterName = "সকল ৪ জন ক্বারী";
                        }
                        $hasAudio = !empty($s['sample_audio']);

                        $cntTafsir = 0;
                        if (!empty($s['sample_tafsir'])) {
                            $d = json_decode($s['sample_tafsir'], true);
                            if (is_array($d)) {
                                $cntTafsir = count($d);
                            } elseif ($s['tafsir_count'] > 0) {
                                $cntTafsir = 1;
                            }
                        }
                        $hasTafsir = $cntTafsir > 0;
                    ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <!-- 1. # -->
                            <td style="padding: 12px 14px; font-weight: 800; color: #10b981;">
                                <?= str_pad($s['surah_num'], 2, '0', STR_PAD_LEFT) ?>
                            </td>
                            <!-- 2. সূরার নাম (বাংলা) -->
                            <td style="padding: 12px 14px; font-weight: 700; color: #1e293b;">
                                <?= htmlspecialchars($s['surah_name_bn'] ?: "সূরা " . $s['surah_num']) ?>
                            </td>
                            <!-- 3. আরবি নাম -->
                            <td style="padding: 12px 14px; font-family: 'Amiri', serif; font-size: 1.1rem; color: #047857; font-weight: 700;">
                                <?= htmlspecialchars($s['surah_name_ar'] ?: "سورة " . $s['surah_num']) ?>
                            </td>
                            <!-- 4. সংরক্ষিত আয়াত -->
                            <td style="padding: 12px 14px; text-align: center; font-weight: 700; color: #475569;">
                                <span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(16,185,129,0.2);">
                                    <?= number_format($s['synced_count']) ?> <?= $s['total_ayahs'] > 0 ? '/ ' . number_format($s['total_ayahs']) : '' ?> আয়াত
                                </span>
                            </td>
                            <!-- 5. বাংলা অনুবাদ -->
                            <td style="padding: 12px 14px; text-align: center;">
                                <?php 
                                    $bnCnt = (int)($s['bn_count'] ?? $s['synced_count']);
                                    $totAyahs = (int)$s['total_ayahs'];
                                    if ($bnCnt >= $totAyahs && $totAyahs > 0): 
                                ?>
                                    <span style="background: #d1fae5; color: #065f46; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;" title="সকল আয়াতের বাংলা অনুবাদ ডাটাবেজে পাওয়া গেছে">
                                        <i class="fas fa-check-circle"></i> সিঙ্কড (<?= number_format($bnCnt) ?>)
                                    </span>
                                <?php elseif ($bnCnt > 0): ?>
                                    <span style="background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-clock"></i> আংশিক (<?= number_format($bnCnt) ?>/<?= number_format($totAyahs) ?>)
                                    </span>
                                <?php else: ?>
                                    <span style="background: #fee2e2; color: #991b1b; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-times-circle"></i> অনুবাদ নেই
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- 6. বাংলা উচ্চারণ -->
                            <td style="padding: 12px 14px; text-align: center;">
                                <?php 
                                    $trCnt = (int)($s['tr_count'] ?? $s['synced_count']);
                                    if ($trCnt >= $totAyahs && $totAyahs > 0): 
                                ?>
                                    <span style="background: #fef08a; color: #854d0e; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;" title="সকল আয়াতের বাংলা উচ্চারণ ডাটাবেজে পাওয়া গেছে">
                                        <i class="fas fa-check-circle"></i> সিঙ্কড (<?= number_format($trCnt) ?>)
                                    </span>
                                <?php elseif ($trCnt > 0): ?>
                                    <span style="background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-clock"></i> আংশিক (<?= number_format($trCnt) ?>/<?= number_format($totAyahs) ?>)
                                    </span>
                                <?php else: ?>
                                    <span style="background: #fee2e2; color: #991b1b; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-times-circle"></i> উচ্চারণ নেই
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- 7. সিঙ্কড অডিও (ক্বারী) -->
                            <td style="padding: 12px 14px; text-align: center;">
                                <?php if ($hasAudio): ?>
                                    <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; border: 1px solid #bfdbfe; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-volume-up"></i> <?= $reciterName ?>
                                    </span>
                                <?php else: ?>
                                    <span style="background: #f1f5f9; color: #94a3b8; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 14px;">
                                        <i class="fas fa-volume-mute me-1"></i> সিঙ্কড নয়
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- 8. তাফসীর ডাটা -->
                            <td style="padding: 12px 14px; text-align: center;">
                                <?php if ($hasTafsir): ?>
                                    <span style="background: #fdf4ff; color: #7e22ce; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; border: 1px solid #f5d0fe; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-book-open"></i> <?= $cntTafsir >= 6 ? 'সকল ৬টি তাফসীর' : $cntTafsir . 'টি তাফসীর' ?>
                                    </span>
                                <?php else: ?>
                                    <span style="background: #f1f5f9; color: #94a3b8; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 14px;">
                                        <i class="fas fa-minus-circle me-1"></i> সিঙ্কড নয়
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- 9. স্ট্যাটাস -->
                            <td style="padding: 12px 14px; text-align: center;">
                                <?php if ($isFull): ?>
                                    <span style="background: #d1fae5; color: #065f46; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-check-circle"></i> সম্পূর্ণ
                                    </span>
                                <?php else: ?>
                                    <span style="background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-clock"></i> আংশিক
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- 10. অ্যাকশন -->
                            <td style="padding: 12px 14px; text-align: right;">
                                <button onclick="startSync('quran&surah=<?= $s['surah_num'] ?>&tafsir=all', this)" class="btn-resync">
                                    <i class="fas fa-rotate"></i> সিঙ্ক করুন
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Synced Hadith Books Status List Section -->
<div style="background: #ffffff; border-radius: 20px; padding: 26px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); margin-bottom: 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="fas fa-book-journal-whills"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">ডাটাবেজে সিঙ্ক হওয়া হাদিস গ্রন্থ সমূহের তালিকা</h3>
                <p style="margin: 2px 0 0 0; color: #64748b; font-size: 0.85rem;">মোট <?= number_format($syncedHadithBooksCount ?? 0) ?>/৯টি হাদিস গ্রন্থ লোকাল ডাটাবেজে পাওয়া গেছে (মোট <?= number_format($hadithCount ?? 0) ?>টি হাদিস)</p>
            </div>
        </div>

        <div style="position: relative; min-width: 240px;">
            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
            <input type="text" id="hadithSearchInput" onkeyup="filterHadithTable()" placeholder="হাদিস গ্রন্থ খুঁজুন..." style="width: 100%; padding: 8px 12px 8px 34px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; box-sizing: border-box;">
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table class="table table-hover align-middle" style="margin: 0; border-collapse: separate; border-spacing: 0; width: 100%; font-size: 0.9rem;" id="hadithStatusTable">
            <thead>
                <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px 14px; border-radius: 8px 0 0 8px;">#</th>
                    <th style="padding: 12px 14px;">গ্রন্থের নাম (বাংলা)</th>
                    <th style="padding: 12px 14px;">বুক কী (Key)</th>
                    <th style="padding: 12px 14px; text-align: center;">সংরক্ষিত হাদিস</th>
                    <th style="padding: 12px 14px; text-align: center;">অধ্যায় সংখ্যা</th>
                    <th style="padding: 12px 14px; text-align: center;">আরবি ডাটা</th>
                    <th style="padding: 12px 14px; text-align: center;">স্ট্যাটাস</th>
                    <th style="padding: 12px 14px; text-align: right; border-radius: 0 8px 8px 0;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                foreach ($hadithBooksList as $b): 
                    $isFull = ($b['synced_count'] >= $b['total']) && ($b['total'] > 0);
                    $hasData = $b['synced_count'] > 0;
                    $hasArabic = $b['arabic_count'] > 0;
                ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px 14px; font-weight: 800; color: #f59e0b;">
                            <?= str_pad($i++, 2, '0', STR_PAD_LEFT) ?>
                        </td>
                        <td style="padding: 12px 14px; font-weight: 700; color: #1e293b;">
                            <?= htmlspecialchars($b['book_name']) ?>
                        </td>
                        <td style="padding: 12px 14px; color: #64748b; font-family: monospace; font-size: 0.85rem;">
                            <?= htmlspecialchars($b['book_key']) ?>
                        </td>
                        <td style="padding: 12px 14px; text-align: center; font-weight: 700; color: #475569;">
                            <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(245,158,11,0.2);">
                                <?= number_format($b['synced_count']) ?> <?= $b['total'] > 0 ? '/ ' . number_format($b['total']) : '' ?> টি
                            </span>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <span style="background: #f8fafc; color: #475569; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 14px; border: 1px solid #e2e8f0;">
                                <?= number_format($b['chapter_count']) ?> টি অধ্যায়
                            </span>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <?php if ($hasArabic): ?>
                                <span style="background: #ecfdf5; color: #047857; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 14px; border: 1px solid #a7f3d0; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-check"></i> আরবিসহ (<?= number_format($b['arabic_count']) ?>টি)
                                </span>
                            <?php else: ?>
                                <span style="background: #f1f5f9; color: #94a3b8; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 14px;">
                                    <i class="fas fa-minus-circle me-1"></i> শুধুমাত্র বাংলা
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <?php if ($isFull): ?>
                                <span style="background: #d1fae5; color: #065f46; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-check-circle"></i> সম্পূর্ণ
                                </span>
                            <?php elseif ($hasData): ?>
                                <span style="background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-clock"></i> আংশিক
                                </span>
                            <?php else: ?>
                                <span style="background: #f1f5f9; color: #94a3b8; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-circle-xmark"></i> সিঙ্কড নয়
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px 14px; text-align: right;">
                            <button onclick="startSync('hadith&book=<?= $b['book_key'] ?>', this)" class="btn-resync">
                                <i class="fas fa-rotate"></i> সিঙ্ক করুন
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div> <!-- End syncPageWrapper -->

<!-- Floating Background Toast Notification Container (Top-Right) -->
<div id="syncToastContainer" style="position: fixed; top: 24px; right: 24px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; max-width: 400px; width: 90%; pointer-events: none;"></div>

<script>
function reloadSyncData(onComplete) {
    fetch(window.location.href)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('syncPageWrapper');
            const oldContent = document.getElementById('syncPageWrapper');
            if (newContent && oldContent) {
                oldContent.innerHTML = newContent.innerHTML;
            }
            if (onComplete) onComplete();
        })
        .catch(err => {
            console.error("Data refresh error:", err);
            if (onComplete) onComplete();
        });
}

function showToast(title, message, type = 'info', duration = 4000) {
    const container = document.getElementById("syncToastContainer");
    if (!container) return null;

    const toast = document.createElement("div");
    toast.style.pointerEvents = "auto";
    toast.style.background = type === 'success' ? '#064e3b' : (type === 'error' ? '#7f1d1d' : '#0f172a');
    toast.style.color = '#ffffff';
    toast.style.border = type === 'success' ? '1.5px solid #10b981' : (type === 'error' ? '1.5px solid #f87171' : '1.5px solid #3b82f6');
    toast.style.borderRadius = '16px';
    toast.style.padding = '14px 18px';
    toast.style.boxShadow = '0 12px 30px rgba(0, 0, 0, 0.35)';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '14px';
    toast.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    toast.style.transform = 'translateY(-20px)';
    toast.style.opacity = '0';

    const icon = type === 'success' ? '<i class="fas fa-check-circle" style="color: #34d399; font-size: 1.5rem;"></i>'
               : (type === 'error' ? '<i class="fas fa-circle-exclamation" style="color: #f87171; font-size: 1.5rem;"></i>'
               : '<i class="fas fa-arrows-rotate fa-spin" style="color: #60a5fa; font-size: 1.5rem;"></i>');

    toast.innerHTML = `
        <div style="flex-shrink: 0;">${icon}</div>
        <div style="flex: 1;">
            <div style="font-weight: 800; font-size: 0.92rem;">${title}</div>
            <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 2px;">${message}</div>
        </div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
    }, 10);

    if (duration > 0) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }
    return toast;
}

function startSync(actionStr, btn) {
    let originalHtml = "";
    if (btn) {
        originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.style.opacity = "0.7";
        btn.innerHTML = `<i class="fas fa-arrows-rotate fa-spin"></i> <span>সিঙ্ক হচ্ছে...</span>`;
    }

    const toast = showToast("ব্যাকগ্রাউন্ড সিঙ্ক শুরু হয়েছে", "API থেকে ব্যাকগ্রাউন্ডে ডাটা সিঙ্ক করা হচ্ছে...", "info", 0);

    const syncUrl = `<?= URLROOT ?>/sync_islamic_data.php?action=${actionStr}`;
    
    fetch(syncUrl)
        .then(res => {
            if (!res.ok) throw new Error("HTTP Status " + res.status);
            return res.text();
        })
        .then(data => {
            if (toast) toast.remove();
            
            if (data.includes("DB Connection Error") || data.includes("Fatal error")) {
                showToast("ডাটাবেজ কানেকশন সমস্যা", "লোকাল ডাটাবেজ কানেকশনে ত্রুটি দেখা দিয়েছে।", "error", 5000);
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    btn.innerHTML = originalHtml;
                }
            } else if (data.includes("0 hadiths saved") || data.includes("0 ayahs saved") || data.includes("Failed to fetch")) {
                showToast("ডাটা সিঙ্ক পুনশ্চ চেষ্টা করুন", "ইন্টারনেট ধীরগতির কারণে সার্ভার সাড়া দেয়নি। পুনরায় সিঙ্ক বাটনে ক্লিক করুন।", "error", 5000);
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    btn.innerHTML = originalHtml;
                }
            } else {
                showToast("ডাটা সিঙ্ক সফল হয়েছে!", "ডাটাবেজে তথ্য সফলভাবে সংরক্ষিত ও আপডেট করা হয়েছে।", "success", 4000);
                reloadSyncData(() => {
                    if (btn) {
                        btn.disabled = false;
                        btn.style.opacity = "1";
                        btn.innerHTML = originalHtml;
                    }
                });
            }
        })
        .catch(err => {
            if (toast) toast.remove();
            console.error("Sync error:", err);
            showToast("সিঙ্ক ত্রুটি", "ব্যাকগ্রাউন্ড কানেকশন সমস্যা হয়েছে।", "error", 5000);
            if (btn) {
                btn.disabled = false;
                btn.style.opacity = "1";
                btn.innerHTML = originalHtml;
            }
        });
}

function filterSurahTable() {
    const input = document.getElementById("surahSearchInput");
    const filter = input ? input.value.toLowerCase() : "";
    const table = document.getElementById("surahStatusTable");
    if (!table) return;

    const trs = table.getElementsByTagName("tr");
    for (let i = 1; i < trs.length; i++) {
        const text = trs[i].innerText.toLowerCase();
        if (text.includes(filter)) {
            trs[i].style.display = "";
        } else {
            trs[i].style.display = "none";
        }
    }
}

function filterHadithTable() {
    const input = document.getElementById("hadithSearchInput");
    const filter = input ? input.value.toLowerCase() : "";
    const table = document.getElementById("hadithStatusTable");
    if (!table) return;

    const trs = table.getElementsByTagName("tr");
    for (let i = 1; i < trs.length; i++) {
        const text = trs[i].innerText.toLowerCase();
        if (text.includes(filter)) {
            trs[i].style.display = "";
        } else {
            trs[i].style.display = "none";
        }
    }
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
