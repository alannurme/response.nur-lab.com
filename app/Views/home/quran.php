<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Quran Dedicated Full Page Container (Islamic Emerald Green Theme) -->
<div style="position: relative; background: radial-gradient(circle at 50% 30%, #064e3b 0%, #043e2f 45%, #022c22 100%); min-height: 100vh; color: #e2e8f0; font-family: 'Hind Siliguri', sans-serif; padding-bottom: 60px;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Top Sub-Header Control Banner -->
    <div class="quran-top-sub-banner" style="position: sticky; top: 0; z-index: 100; background: rgba(4, 47, 36, 0.95); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 18px 24px; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
        <div style="width: 100%; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 0 10px; box-sizing: border-box;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="<?= URLROOT ?>" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                    <i class="fas fa-arrow-left"></i>
                    <span>হোম পেজ</span>
                </a>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(16, 185, 129, 0.2); border: 1.5px solid #10b981; color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fas fa-quran"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;" id="pageQuranTitle">পবিত্র আল-কুরআন (Quran.com)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;" id="pageQuranSub">১১৪টি সূরার আরবি পাঠ, বাংলা অনুবাদ ও অডিও আবৃত্তি</p>
                </div>
            </div>

            <!-- Reciter & Tafsir Selector Dropdown & Ayah Search Box & Font Zoom -->
            <div class="quran-controls-wrapper" style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">

                

                <!-- Font Size Zoom Control -->
                <div style="display: flex; align-items: center; gap: 6px; background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.4); padding: 5px 12px; border-radius: 10px;">
                    <span style="font-size: 0.85rem; color: #d1fae5; font-weight: 700;">ফন্ট জুম:</span>
                    <button onclick="adjustPageFontSize(-0.1)" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #ffffff; width: 26px; height: 26px; border-radius: 6px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;" title="ফন্ট ছোট করুন">-</button>
                    <span id="pageFontSizeLabel" style="font-size: 0.85rem; color: #fef08a; font-weight: 800; min-width: 42px; text-align: center;">১০০%</span>
                    <button onclick="adjustPageFontSize(0.1)" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #ffffff; width: 26px; height: 26px; border-radius: 6px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;" title="ফন্ট বড় করুন">+</button>
                    <button onclick="resetPageFontSize()" style="background: rgba(245, 158, 11, 0.25); border: 1px solid rgba(245, 158, 11, 0.5); color: #fef08a; padding: 3px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; cursor: pointer; margin-left: 2px;" title="ফন্ট সাইজ রিসেট করুন">রিসেট</button>
                </div>

                <!-- Ayah Search Box -->
                <div style="position: relative; min-width: 200px;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #34d399; font-size: 0.85rem;"></i>
                    <input type="text" id="pageAyahSearchInput" oninput="filterPageAyahs()" placeholder="আয়াত খুঁজুন (নম্বর/শব্দ)..." style="width: 100%; padding: 8px 12px 8px 34px; background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 10px; color: #ffffff; outline: none; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; box-sizing: border-box;" title="আয়াত নম্বর (যেমন: ২৫৫) বা আরবি/বাংলা/ইংরেজি শব্দ দিয়ে খুঁজুন">
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.88rem; color: #d1fae5; font-weight: 700;">ক্বারী:</span>
                    <select id="pageQuranReciterSelect" onchange="onPageReciterChange()" style="background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.4); color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; font-weight: 700; padding: 8px 14px; border-radius: 10px; outline: none; cursor: pointer;">
                        <option value="ar.alafasy">মিশারী রশীদ আল-আফাসী</option>
                        <option value="ar.abdulbasitmurattal">আব্দুল বাসিত আব্দুস সামাদ</option>
                        <option value="ar.sudais">আব্দুর রহমান আস-সুদাইস</option>
                        <option value="ar.shatri">আবু বকর আশ-শাত্রী</option>
                    </select>
                </div>

                <!-- Recitation Speed -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 0.85rem; color: #d1fae5; font-weight: 700;">গতি:</span>
                    <select id="pageAudioSpeedSelect" onchange="updateAudioSpeed()" style="background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.4); color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; font-weight: 700; padding: 7px 10px; border-radius: 10px; outline: none; cursor: pointer;">
                        <option value="0.75">০.৭৫x</option>
                        <option value="1.0" selected>১.০x</option>
                        <option value="1.25">১.২৫x</option>
                        <option value="1.5">১.৫x</option>
                    </select>
                </div>

                <!-- Recitation Repeat -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 0.85rem; color: #d1fae5; font-weight: 700;">রিপিট:</span>
                    <select id="pageAudioRepeatSelect" style="background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.4); color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.85rem; font-weight: 700; padding: 7px 10px; border-radius: 10px; outline: none; cursor: pointer;">
                        <option value="1" selected>১ বার</option>
                        <option value="2">২ বার</option>
                        <option value="3">৩ বার</option>
                    </select>
                </div>


            </div>
        </div>
    </div>

    <!-- Main Workspace Grid (Left Surah Navigation + Right Ayah Reader) -->
    <div class="quran-workspace-container" style="position: relative; z-index: 2; width: 100%; margin: 24px auto 0 auto; padding: 0 25px; box-sizing: border-box;">
        <div class="quran-workspace-flex" style="display: flex; flex-wrap: wrap; gap: 24px; min-height: 75vh;">
            
            <!-- Left Sidebar: Surah List Navigation -->
            <div class="quran-sidebar-box" style="width: 320px; flex-shrink: 0; background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; display: flex; flex-direction: column; overflow: hidden; height: calc(100vh - 120px); position: sticky; top: 100px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); z-index: 20;">
                <!-- Search Box -->
                <div style="padding: 14px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); background: rgba(2, 44, 34, 0.85);">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                        <input type="text" id="pageQuranSearchInput" oninput="filterPageSurahList()" placeholder="সূরা অনুসন্ধান করুন..." style="width: 100%; padding: 9px 12px 9px 34px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 8px; color: #ffffff; outline: none; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Surah List Container -->
                <div style="flex: 1; overflow-y: auto; padding: 10px;" id="pageQuranSidebarSurahs">
                    <!-- Surah list items injected via JS -->
                </div>
            </div>

            <!-- Right Main Ayah Reader Area -->
            <div style="flex: 1; min-width: 300px; background: rgba(4, 47, 36, 0.75); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 30px; display: flex; flex-direction: column; box-shadow: 0 15px 35px rgba(0,0,0,0.4);" id="pageQuranAyahBody">
                <!-- Ayah cards injected via JS -->
            </div>

        </div>
    </div>
</div>

<style>
    /* Hide top global navbar on dedicated Quran page */
    .header-wrapper {
        display: none !important;
    }

    @keyframes pulseGlow {
        0% { box-shadow: 0 0 12px rgba(16, 185, 129, 0.3); }
        50% { box-shadow: 0 0 25px rgba(16, 185, 129, 0.65); }
        100% { box-shadow: 0 0 12px rgba(16, 185, 129, 0.3); }
    }
    .page-ayah-card-item {
        scroll-margin-top: 140px;
    }
    .ayah-card-playing {
        border: 2px solid #10b981 !important;
        background: rgba(16, 185, 129, 0.18) !important;
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.35) !important;
        position: relative !important;
    }
    .ayah-card-playing::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: #10b981;
        border-top-left-radius: 13px;
        border-bottom-left-radius: 13px;
    }
    .tafsir-content-text p { margin-bottom: 12px; line-height: 1.8; }
    .tafsir-content-text b, .tafsir-content-text strong { color: #34d399; font-weight: 700; }
    .tafsir-content-text a { color: #60a5fa; text-decoration: underline; }

    /* Dedicated Quran Page Mobile Responsiveness */
    @media (max-width: 991px) {
        .quran-workspace-container {
            padding: 0 14px !important;
            margin-top: 14px !important;
        }
        .quran-workspace-flex {
            flex-direction: column !important;
            gap: 16px !important;
        }
        .quran-sidebar-box {
            width: 100% !important;
            height: auto !important;
            max-height: 320px !important;
            position: relative !important;
            top: 0 !important;
        }
        #pageQuranAyahBody {
            padding: 18px 14px !important;
            border-radius: 14px !important;
            min-width: 100% !important;
        }
        .quran-top-sub-banner {
            padding: 12px 16px !important;
        }
    }

    @media (max-width: 640px) {
        #pageQuranTitle {
            font-size: 1.15rem !important;
        }
        #pageQuranSub {
            font-size: 0.78rem !important;
        }
        .quran-controls-wrapper {
            width: 100% !important;
            gap: 10px !important;
            margin-top: 10px !important;
        }
        .quran-controls-wrapper > div,
        .quran-controls-wrapper select {
            width: 100% !important;
            max-width: 100% !important;
            flex: 1 1 100% !important;
        }
        .page-arabic-text {
            font-size: 1.35rem !important;
            line-height: 2.1 !important;
            padding: 14px 16px !important;
        }
        .ayah-card-box {
            padding: 16px !important;
            border-radius: 14px !important;
            margin-bottom: 16px !important;
        }
        .ayah-action-btn-group {
            flex-wrap: wrap !important;
            gap: 6px !important;
        }
    }
</style>

<script>
    var pageCachedSurahs = [];
    var pageCurrentSurahNum = 1;
    var pageCurrentPlayingAudio = null;
    var pageCurrentPlayingAyahNum = null;
    var isAutoPlayNext = true;
    var pageActiveBtn = null;
    var tafsirCache = {};
    var pageLoadedAyahsData = null;
    var pageFontScale = parseFloat(localStorage.getItem('quran_font_scale')) || 1.0;
    var selectedTafsirIdGlobal = "165";

    var showWordByWord = false;
    var showBengaliTransliteration = false;
    var currentRepeatRemaining = 1;
    var audioCurrentRepeatCount = 1;

    // Feature 7 Topic Ayah Mappings
    const topicAyahMap = {
        iman: [ {surah: 1, ayah: 1}, {surah: 1, ayah: 2}, {surah: 1, ayah: 5}, {surah: 2, ayah: 255}, {surah: 112, ayah: 1}, {surah: 112, ayah: 2}, {surah: 112, ayah: 3}, {surah: 112, ayah: 4} ],
        salat: [ {surah: 1, ayah: 5}, {surah: 2, ayah: 43}, {surah: 2, ayah: 153}, {surah: 20, ayah: 14}, {surah: 29, ayah: 45} ],
        patience: [ {surah: 2, ayah: 153}, {surah: 2, ayah: 155}, {surah: 2, ayah: 156}, {surah: 3, ayah: 200}, {surah: 103, ayah: 3} ],
        dua: [ {surah: 1, ayah: 6}, {surah: 2, ayah: 201}, {surah: 3, ayah: 8}, {surah: 25, ayah: 74}, {surah: 40, ayah: 60} ],
        family: [ {surah: 4, ayah: 1}, {surah: 17, ayah: 23}, {surah: 17, ayah: 24}, {surah: 25, ayah: 74}, {surah: 31, ayah: 14} ],
        jannah: [ {surah: 2, ayah: 25}, {surah: 3, ayah: 133}, {surah: 55, ayah: 46}, {surah: 56, ayah: 12}, {surah: 88, ayah: 10} ]
    };

    function toggleWordByWordView() {
        showWordByWord = !showWordByWord;
        const btn = document.getElementById("btnToggleWordByWord");
        if (btn) {
            if (showWordByWord) {
                btn.innerHTML = '<i class="fas fa-layer-group"></i> <span>শব্দে শব্দে: অন</span>';
                btn.style.background = 'rgba(245, 158, 11, 0.3)';
                btn.style.borderColor = '#f59e0b';
                btn.style.color = '#fef08a';
            } else {
                btn.innerHTML = '<i class="fas fa-layer-group"></i> <span>শব্দে শব্দে: অফ</span>';
                btn.style.background = 'rgba(16, 185, 129, 0.18)';
                btn.style.borderColor = '#10b981';
                btn.style.color = '#34d399';
            }
        }
        if (pageLoadedAyahsData) {
            filterPageAyahs();
        }
    }

    function toggleBengaliTranslitView() {
        showBengaliTransliteration = !showBengaliTransliteration;
        const btn = document.getElementById("btnToggleTranslit");
        if (btn) {
            if (showBengaliTransliteration) {
                btn.innerHTML = '<i class="fas fa-language"></i> <span>বাংলা উচ্চারণ: অন</span>';
                btn.style.background = 'rgba(245, 158, 11, 0.3)';
                btn.style.borderColor = '#f59e0b';
                btn.style.color = '#fef08a';
            } else {
                btn.innerHTML = '<i class="fas fa-language"></i> <span>বাংলা উচ্চারণ: অফ</span>';
                btn.style.background = 'rgba(16, 185, 129, 0.18)';
                btn.style.borderColor = '#10b981';
                btn.style.color = '#34d399';
            }
        }
        if (pageLoadedAyahsData) {
            filterPageAyahs();
        }
    }

    function updateAudioSpeed() {
        const speedSel = document.getElementById("pageAudioSpeedSelect");
        if (pageCurrentPlayingAudio && speedSel) {
            pageCurrentPlayingAudio.playbackRate = parseFloat(speedSel.value);
        }
    }

    function filterAyahsByTopic() {
        const topicSel = document.getElementById("pageQuranTopicSelect");
        if (!topicSel || !pageLoadedAyahsData) return;
        filterPageAyahs();
    }


    function adjustPageFontSize(delta) {
        pageFontScale = Math.min(1.8, Math.max(0.7, pageFontScale + delta));
        localStorage.setItem('quran_font_scale', pageFontScale);
        applyPageFontSize();
    }

    function resetPageFontSize() {
        pageFontScale = 1.0;
        localStorage.setItem('quran_font_scale', pageFontScale);
        applyPageFontSize();
    }

    function applyPageFontSize() {
        const pct = Math.round(pageFontScale * 100);
        const lbl = document.getElementById("pageFontSizeLabel");
        if (lbl) lbl.innerText = toBnNum(pct) + "%";

        document.querySelectorAll(".page-arabic-text").forEach(el => {
            el.style.fontSize = (1.45 * pageFontScale) + "rem";
        });
        document.querySelectorAll(".page-bengali-text").forEach(el => {
            el.style.fontSize = (1.05 * pageFontScale) + "rem";
        });
        document.querySelectorAll(".page-english-text").forEach(el => {
            el.style.fontSize = (0.98 * pageFontScale) + "rem";
        });
        document.querySelectorAll(".tafsir-content-text").forEach(el => {
            el.style.fontSize = (1.02 * pageFontScale) + "rem";
        });
    }

    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function toEnNum(numStr) {
        const bnToEn = {'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};
        return String(numStr).replace(/[০-৯]/g, function(w){ return bnToEn[w] || w; });
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetchPageSurahList();
    });

    function fetchPageSurahList() {
        const surahs = [];
        for (let i = 1; i <= 114; i++) {
            surahs.push({
                number: i,
                name: `سورة ${i}`,
                englishName: bnSurahNames[i] || `Surah ${i}`,
                englishNameTranslation: "",
                numberOfAyahs: 0
            });
        }
        pageCachedSurahs = surahs;
        renderPageSurahSidebar(pageCachedSurahs);
        loadPageSurahDetail(1);
    }

    const bnSurahNames = {
        1: "ফাতিহা", 2: "বাকারা", 3: "আলে ইমরান", 4: "নিসা", 5: "মায়িদা", 6: "আনআম", 7: "আরাফ", 8: "আনফাল", 9: "তাওবা", 10: "ইউনুস",
        11: "হূদ", 12: "ইউসুফ", 13: "রাদ", 14: "ইব্রাহীম", 15: "হিজর", 16: "নহল", 17: "বনী ইসরাঈল", 18: "কাহফ", 19: "মারইয়াম", 20: "ত্বা-হা",
        21: "আনবিয়া", 22: "হাজ্জ", 23: "মুমিনূন", 24: "নূর", 25: "ফুরকান", 26: "শুয়ারা", 27: "নামল", 28: "কাসাস", 29: "আনকাবূত", 30: "রূম",
        31: "লুকমান", 32: "সাজদা", 33: "আহযাব", 34: "সাবা", 35: "ফাত্বির", 36: "ইয়াসীন", 37: "ছফফাত", 38: "ছাদ", 39: "যুমার", 40: "মু'মিন",
        41: "হা-মীম সাজদা", 42: "শূরা", 43: "যুখরুফ", 44: "দুখান", 45: "জাসিয়া", 46: "আহকাফ", 47: "মুহাম্মদ", 48: "ফাতহ", 49: "হুজুরাত", 50: "ক্বাফ",
        51: "যারিয়াত", 52: "তূর", 53: "নাজম", 54: "ক্বামার", 55: "আর-রাহমান", 56: "ওয়াক্বিয়া", 57: "হাদীদ", 58: "মুজাদালাহ", 59: "হাশর", 60: "মুমতাহিনাহ",
        61: "ছফ", 62: "জুমুআহ", 63: "মুনাফিকূন", 64: "তাগাবুন", 65: "ত্বলাক্ব", 66: "তাহরীম", 67: "মুলক", 68: "ক্বলম", 69: "হাক্কাহ", 70: "মাআরিজ",
        71: "নূহ", 72: "জীন", 73: "মুযযাম্মিল", 74: "মুদ্দাস্সির", 75: "ক্বিয়ামাহ", 76: "ইনসান", 77: "মুরসালাত", 78: "নাবা", 79: "নাযিআত", 80: "আবাসা",
        81: "তাকবীর", 82: "ইনফিতার", 83: "মুত্বাফফিফীন", 84: "ইনশিক্বাক্ব", 85: "বুরূজ", 86: "তারিক্ব", 87: "আলা", 88: "গাশিয়াহ", 89: "ফজর", 90: "বালাদ",
        91: "শামস", 92: "লাইল", 93: "দুহা", 94: "ইনশিরাহ", 95: "তীন", 96: "আলাক্ব", 97: "ক্বদর", 98: "বাইয়িনাহ", 99: "যিলযাল", 100: "আদিয়াত",
        101: "ক্বারিয়াহ", 102: "তাকাছুর", 103: "আসর", 104: "হুমাযাহ", 105: "ফীল", 106: "কুরাইশ", 107: "মাউন", 108: "কাওছার", 109: "কাফিরূন", 110: "নছর",
        111: "লাহাব", 112: "ইখলাস", 113: "ফালাক্ব", 114: "নাস"
    };

    function renderPageSurahSidebar(surahs) {
        const sidebar = document.getElementById("pageQuranSidebarSurahs");
        if (!sidebar) return;

        if (!surahs || surahs.length === 0) {
            sidebar.innerHTML = '<div style="text-align:center; padding: 20px; color:#fde047; font-size:0.85rem;">কোন সূরা পাওয়া যায়নি</div>';
            return;
        }

        sidebar.innerHTML = surahs.map(s => {
            const isActive = (s.number === pageCurrentSurahNum);
            const bnName = bnSurahNames[s.number] ? `সূরা ${bnSurahNames[s.number]}` : s.englishName;
            return `
                <div onclick="loadPageSurahDetail(${s.number})" id="page-surah-item-${s.number}" class="page-surah-item ${isActive ? 'active' : ''}" style="padding: 10px 12px; border-radius: 8px; margin-bottom: 4px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; background: ${isActive ? 'rgba(16, 185, 129, 0.22)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(${s.number} !== pageCurrentSurahNum) this.style.background='rgba(255,255,255,0.06)'" onmouseout="if(${s.number} !== pageCurrentSurahNum) this.style.background='transparent'">
                    <div style="display: flex; align-items: center; gap: 10px; overflow: hidden;">
                        <span style="font-size: 0.85rem; font-weight: 800; color: ${isActive ? '#34d399' : '#a7f3d0'}; width: 24px; text-align: center; font-family: 'Hind Siliguri', sans-serif; flex-shrink: 0;">${toBnNum(s.number)}</span>
                        <span style="font-weight: 700; font-size: 0.95rem; color: ${isActive ? '#ffffff' : '#e2e8f0'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Hind Siliguri', sans-serif;">${bnName}</span>
                    </div>
                    <span style="font-size: 0.78rem; color: #a7f3d0; font-weight: 500; flex-shrink: 0; margin-left: 6px;">${s.englishName}</span>
                </div>
            `;
        }).join('');
    }

    function filterPageSurahList() {
        const query = (document.getElementById("pageQuranSearchInput").value || "").toLowerCase().trim();
        if (!query) {
            renderPageSurahSidebar(pageCachedSurahs);
            return;
        }

        const filtered = pageCachedSurahs.filter(s => {
            const bnN = (bnSurahNames[s.number] || "").toLowerCase();
            return s.number.toString() === query ||
                bnN.includes(query) ||
                s.name.toLowerCase().includes(query) ||
                s.englishName.toLowerCase().includes(query) ||
                s.englishNameTranslation.toLowerCase().includes(query);
        });
        renderPageSurahSidebar(filtered);
    }

    function onPageReciterChange() {
        stopAllAyahAudio();
        if (pageCurrentSurahNum) {
            loadPageSurahDetail(pageCurrentSurahNum);
        }
    }

    function updateAudioSpeed() {
        const speedSel = document.getElementById("pageAudioSpeedSelect");
        if (pageCurrentPlayingAudio && speedSel) {
            pageCurrentPlayingAudio.playbackRate = parseFloat(speedSel.value) || 1.0;
        }
    }

    function highlightAyah(ayahNum) {
        document.querySelectorAll('.page-ayah-card-item').forEach(card => {
            card.classList.remove('ayah-card-playing');
            card.style.background = 'rgba(2, 44, 34, 0.75)';
            card.style.border = '1px solid rgba(16, 185, 129, 0.25)';
            card.style.boxShadow = 'none';
        });

        document.querySelectorAll('.ayah-playing-badge-container').forEach(el => {
            el.innerHTML = '';
        });

        const card = document.getElementById(`page-ayah-card-${ayahNum}`);
        if (card) {
            card.classList.add('ayah-card-playing');
            card.style.background = 'rgba(16, 185, 129, 0.18)';
            card.style.border = '2px solid #10b981';
            card.style.boxShadow = '0 0 25px rgba(16, 185, 129, 0.35)';

            const badgeSlot = document.getElementById(`ayah-playing-badge-slot-${ayahNum}`);
            if (badgeSlot) {
                badgeSlot.innerHTML = `
                    <span class="ayah-playing-badge" style="background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 10px rgba(16,185,129,0.4); animation: pulseGlow 1.8s infinite;">
                        <i class="fas fa-volume-up fa-beat"></i> তিলওয়াত চলছে
                    </span>
                `;
            }

            try {
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } catch(e) {
                card.scrollIntoView();
            }
        }
    }

    function unhighlightAyah(ayahNum) {
        const card = document.getElementById(`page-ayah-card-${ayahNum}`);
        if (card) {
            card.classList.remove('ayah-card-playing');
            card.style.background = 'rgba(2, 44, 34, 0.75)';
            card.style.border = '1px solid rgba(16, 185, 129, 0.25)';
            card.style.boxShadow = 'none';
        }
        const badgeSlot = document.getElementById(`ayah-playing-badge-slot-${ayahNum}`);
        if (badgeSlot) badgeSlot.innerHTML = '';
    }

    function stopAllAyahAudio() {
        if (pageCurrentPlayingAudio) {
            pageCurrentPlayingAudio.pause();
            pageCurrentPlayingAudio = null;
        }
        if (pageCurrentPlayingAyahNum) {
            unhighlightAyah(pageCurrentPlayingAyahNum);
            const btn = document.getElementById(`ayah-audio-btn-${pageCurrentPlayingAyahNum}`);
            if (btn) {
                btn.innerHTML = '<i class="fas fa-play"></i> অডিও';
                btn.style.background = 'rgba(52, 211, 153, 0.2)';
                btn.style.borderColor = '#34d399';
                btn.style.color = '#6ee7b7';
            }
            pageCurrentPlayingAyahNum = null;
        }
        updateTopSurahPlayButton(false);
    }

    function togglePlayPageAyah(surahNum, ayahNum) {
        if (pageCurrentPlayingAyahNum === ayahNum && pageCurrentPlayingAudio) {
            const btn = document.getElementById(`ayah-audio-btn-${ayahNum}`);
            if (!pageCurrentPlayingAudio.paused) {
                pageCurrentPlayingAudio.pause();
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-play"></i> চালু করুন';
                    btn.style.background = 'rgba(245, 158, 11, 0.25)';
                    btn.style.borderColor = '#f59e0b';
                    btn.style.color = '#fef08a';
                }
                const badgeSlot = document.getElementById(`ayah-playing-badge-slot-${ayahNum}`);
                if (badgeSlot) {
                    badgeSlot.innerHTML = `
                        <span style="background: rgba(245, 158, 11, 0.3); color: #fef08a; border: 1px solid #f59e0b; font-size: 0.75rem; padding: 2px 10px; border-radius: 20px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-pause"></i> বিরতি
                        </span>
                    `;
                }
                updateTopSurahPlayButton(false);
                return;
            } else {
                pageCurrentPlayingAudio.play().then(() => {
                    if (btn) {
                        btn.innerHTML = '<i class="fas fa-pause"></i> থামান';
                        btn.style.background = 'rgba(239, 68, 68, 0.35)';
                        btn.style.borderColor = '#ef4444';
                        btn.style.color = '#fca5a5';
                    }
                    const badgeSlot = document.getElementById(`ayah-playing-badge-slot-${ayahNum}`);
                    if (badgeSlot) {
                        badgeSlot.innerHTML = `
                            <span class="ayah-playing-badge" style="background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 10px rgba(16,185,129,0.4); animation: pulseGlow 1.8s infinite;">
                                <i class="fas fa-volume-up fa-beat"></i> তিলওয়াত চলছে
                            </span>
                        `;
                    }
                    updateTopSurahPlayButton(true);
                }).catch(e => {
                    console.error("Resume failed:", e);
                });
                return;
            }
        }

        startPlayingAyah(surahNum, ayahNum);
    }

    function startPlayingAyah(surahNum, ayahNum) {
        stopAllAyahAudio();

        if (!pageLoadedAyahsData) return;
        const totalAyahs = (pageLoadedAyahsData.uthmani && pageLoadedAyahsData.uthmani.ayahs) ? pageLoadedAyahsData.uthmani.ayahs.length : 0;
        if (ayahNum < 1 || ayahNum > totalAyahs) return;

        const idx = ayahNum - 1;
        const audioData = (pageLoadedAyahsData.audioRec && pageLoadedAyahsData.audioRec.ayahs) ? pageLoadedAyahsData.audioRec.ayahs[idx] : null;

        const sPad = String(surahNum).padStart(3, '0');
        const aPad = String(ayahNum).padStart(3, '0');
        const fallbackPrimary = `https://everyayah.com/data/Alafasy_128kbps/${sPad}${aPad}.mp3`;
        const primaryUrl = (audioData && audioData.audio) ? audioData.audio : fallbackPrimary;
        const secondaryUrl = (audioData && audioData.secondaryAudio) ? audioData.secondaryAudio : `https://cdn.islamic.network/quran/audio/128/ar.alafasy/${ayahNum}.mp3`;

        pageCurrentPlayingAyahNum = ayahNum;
        highlightAyah(ayahNum);

        const btn = document.getElementById(`ayah-audio-btn-${ayahNum}`);
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>...';
            btn.style.background = 'rgba(239, 68, 68, 0.35)';
            btn.style.borderColor = '#ef4444';
            btn.style.color = '#fca5a5';
        }
        updateTopSurahPlayButton(true);

        const speedSel = document.getElementById("pageAudioSpeedSelect");
        const speedVal = speedSel ? parseFloat(speedSel.value) || 1.0 : 1.0;

        const repeatSel = document.getElementById("pageAudioRepeatSelect");
        audioCurrentRepeatCount = repeatSel ? parseInt(repeatSel.value) : 1;
        currentRepeatRemaining = audioCurrentRepeatCount;

        const audio = new Audio(primaryUrl);
        audio.playbackRate = speedVal;
        pageCurrentPlayingAudio = audio;

        function attachEvents(audioObj) {
            audioObj.playbackRate = speedVal;
            audioObj.onended = function() {
                if (currentRepeatRemaining > 1) {
                    currentRepeatRemaining--;
                    audioObj.currentTime = 0;
                    audioObj.play();
                    if (btn) btn.innerHTML = `<i class="fas fa-redo fa-spin"></i> ${currentRepeatRemaining}x`;
                    return;
                }

                // Reset repeat counter
                const rSel = document.getElementById("pageAudioRepeatSelect");
                currentRepeatRemaining = rSel ? parseInt(rSel.value) : 1;

                // Auto-Play Next Ayah
                if (isAutoPlayNext) {
                    const nextAyah = ayahNum + 1;
                    if (nextAyah <= totalAyahs) {
                        startPlayingAyah(surahNum, nextAyah);
                        return;
                    }
                }

                // Finished surah or auto-play off
                stopAllAyahAudio();
            };
        }

        attachEvents(audio);

        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(() => {
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-pause"></i> থামান';
                    btn.style.background = 'rgba(239, 68, 68, 0.35)';
                    btn.style.borderColor = '#ef4444';
                    btn.style.color = '#fca5a5';
                }
            }).catch(err => {
                console.warn("Primary audio play failed, trying secondary URL:", err);
                if (secondaryUrl) {
                    const fallbackAudio = new Audio(secondaryUrl);
                    pageCurrentPlayingAudio = fallbackAudio;
                    attachEvents(fallbackAudio);
                    fallbackAudio.play().then(() => {
                        if (btn) {
                            btn.innerHTML = '<i class="fas fa-pause"></i> থামান';
                            btn.style.background = 'rgba(239, 68, 68, 0.35)';
                            btn.style.borderColor = '#ef4444';
                            btn.style.color = '#fca5a5';
                        }
                    }).catch(err2 => {
                        console.error("Secondary audio play failed:", err2);
                        stopAllAyahAudio();
                    });
                } else {
                    stopAllAyahAudio();
                }
            });
        }
    }

    function toggleAutoPlaySetting() {
        isAutoPlayNext = !isAutoPlayNext;
        const btn = document.getElementById("toggleAutoPlayBtn");
        if (btn) {
            if (isAutoPlayNext) {
                btn.innerHTML = '<i class="fas fa-forward-step" style="color: #34d399;"></i> <span>অটো-প্লে: <strong style="color: #6ee7b7;">চালু</strong></span>';
                btn.style.background = 'rgba(16, 185, 129, 0.2)';
                btn.style.borderColor = '#10b981';
            } else {
                btn.innerHTML = '<i class="fas fa-pause" style="color: #f87171;"></i> <span>অটো-প্লে: <strong style="color: #fca5a5;">বন্ধ</strong></span>';
                btn.style.background = 'rgba(239, 68, 68, 0.15)';
                btn.style.borderColor = '#ef4444';
            }
        }
    }

    function togglePlayFullSurah() {
        if (pageCurrentPlayingAudio && !pageCurrentPlayingAudio.paused) {
            stopAllAyahAudio();
            return;
        }
        const startAyah = pageCurrentPlayingAyahNum || 1;
        startPlayingAyah(pageCurrentSurahNum, startAyah);
    }

    function updateTopSurahPlayButton(isPlaying) {
        const topBtn = document.getElementById("topSurahPlayAllBtn");
        if (topBtn) {
            if (isPlaying) {
                topBtn.innerHTML = '<i class="fas fa-stop"></i> তিলওয়াত থামান';
                topBtn.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                topBtn.style.boxShadow = '0 4px 15px rgba(239, 68, 68, 0.4)';
            } else {
                topBtn.innerHTML = '<i class="fas fa-play"></i> সম্পূর্ণ সূরা শুনুন';
                topBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                topBtn.style.boxShadow = '0 4px 15px rgba(16, 185, 129, 0.4)';
            }
        }
    }

    function playPageAyahAudio(audioUrl, btn, secondaryUrl) {
        const card = btn ? btn.closest('.page-ayah-card-item') : null;
        if (card && card.dataset.ayah) {
            togglePlayPageAyah(pageCurrentSurahNum, parseInt(card.dataset.ayah));
        } else if (pageCurrentSurahNum) {
            togglePlayPageAyah(pageCurrentSurahNum, 1);
        }
    }

    function toggleAyahTafsir(surahNum, ayahNum) {
        const box = document.getElementById(`tafsir-box-${surahNum}-${ayahNum}`);
        const btn = document.getElementById(`tafsir-btn-${surahNum}-${ayahNum}`);
        if (!box) return;

        if (box.style.display === "block") {
            box.style.display = "none";
            btn.innerHTML = '<i class="fas fa-book-open"></i> তাফসীর পড়ুন';
            btn.style.background = 'rgba(16, 185, 129, 0.18)';
            return;
        }

        box.style.display = "block";
        btn.innerHTML = '<i class="fas fa-chevron-up"></i> তাফসীর লুকান';
        btn.style.background = 'rgba(245, 158, 11, 0.3)';

        loadTafsirContent(surahNum, ayahNum);
    }

    function loadTafsirContent(surahNum, ayahNum, overrideTafsirId) {
        const box = document.getElementById(`tafsir-box-${surahNum}-${ayahNum}`);
        if (!box) return;

        const tafsirId = overrideTafsirId || selectedTafsirIdGlobal;
        selectedTafsirIdGlobal = tafsirId;
        const cacheKey = `${tafsirId}_${surahNum}_${ayahNum}`;

        if (tafsirCache[cacheKey]) {
            renderTafsirBox(box, tafsirCache[cacheKey], surahNum, ayahNum, tafsirId);
            return;
        }

        box.innerHTML = `
            <div style="text-align: center; padding: 20px; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; color: #34d399; margin-bottom: 8px;"></i>
                <div style="font-size: 0.9rem; font-weight: 700;">তাফসীর লোড হচ্ছে...</div>
            </div>
        `;

        const dbTafsirUrl = `<?= URLROOT ?>/api/quran/tafsir?surah=${surahNum}&ayah=${ayahNum}&tafsir=${tafsirId}`;

        fetch(dbTafsirUrl)
            .then(res => res.json())
            .then(data => {
                if (data && data.success && data.tafsir) {
                    tafsirCache[cacheKey] = data.tafsir;
                    renderTafsirBox(box, data.tafsir, surahNum, ayahNum, tafsirId);
                } else {
                    renderTafsirBox(box, { resource_name: "তাফসীর", text: '<div style="color: #f87171; text-align: center; font-size: 0.9rem; padding: 10px;">এই আয়াতের তাফসীর পাওয়া যায়নি।</div>' }, surahNum, ayahNum, tafsirId);
                }
            })
            .catch(err => {
                console.error("Local DB Tafsir load error:", err);
                renderTafsirBox(box, { resource_name: "তাফসীর", text: '<div style="color: #f87171; text-align: center; font-size: 0.9rem; padding: 10px;">তাফসীর লোড করতে সমস্যা হয়েছে।</div>' }, surahNum, ayahNum, tafsirId);
            });
    }

    function renderTafsirBox(box, tafsirData, surahNum, ayahNum, currentTafsirId) {
        const tafsirName = tafsirData.resource_name || "তাফসীর";
        const activeTafsir = currentTafsirId || selectedTafsirIdGlobal;

        box.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(16, 185, 129, 0.3); padding-bottom: 10px; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-book-reader" style="color: #f59e0b; font-size: 1.1rem;"></i>
                    <span style="font-size: 0.95rem; font-weight: 800; color: #fef08a;">${tafsirName} (${toBnNum(surahNum)}:${toBnNum(ayahNum)})</span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 0.82rem; color: #d1fae5; font-weight: 700;">তাফসীর গ্রন্থ:</span>
                    <select onchange="changeAyahTafsir(${surahNum}, ${ayahNum}, this.value)" style="background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.5); color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.82rem; font-weight: 700; padding: 4px 10px; border-radius: 8px; outline: none; cursor: pointer;">
                        <option value="165" ${activeTafsir == '165' ? 'selected' : ''}>তাফসীর আহসানুল বায়ান (বাংলা)</option>
                        <option value="166" ${activeTafsir == '166' ? 'selected' : ''}>তাফসীর আবু বকর জাকারিয়া (বাংলা)</option>
                        <option value="164" ${activeTafsir == '164' ? 'selected' : ''}>তাফসীর ইবনে কাছীর (বাংলা)</option>
                        <option value="381" ${activeTafsir == '381' ? 'selected' : ''}>তাফসীর ফাতহুল মাজীদ (বাংলা)</option>
                        <option value="169" ${activeTafsir == '169' ? 'selected' : ''}>Tafsir Ibn Kathir (English)</option>
                        <option value="168" ${activeTafsir == '168' ? 'selected' : ''}>Ma'arif al-Qur'an (English)</option>
                    </select>
                </div>
            </div>
            <div class="tafsir-content-text" style="font-size: 1.02rem; color: #e2e8f0; line-height: 1.8; text-align: justify; font-family: 'Hind Siliguri', sans-serif;">
                ${tafsirData.text}
            </div>
        `;
        applyPageFontSize();
    }

    function changeAyahTafsir(surahNum, ayahNum, selectedTafsirId) {
        selectedTafsirIdGlobal = selectedTafsirId;
        loadTafsirContent(surahNum, ayahNum, selectedTafsirId);
    }

    function onPageTafsirChange() {
        document.querySelectorAll('[id^="tafsir-box-"]').forEach(box => {
            if (box.style.display === "block") {
                const parts = box.id.split('-');
                const surahNum = parts[2];
                const ayahNum = parts[3];
                loadTafsirContent(surahNum, ayahNum);
            }
        });
    }

    function filterPageAyahs() {
        if (!pageLoadedAyahsData) return;

        const rawQuery = (document.getElementById("pageAyahSearchInput")?.value || "").trim().toLowerCase();
        const normQuery = toEnNum(rawQuery);
        const { uthmani, bengali, english, audioRec, surahNum, bnName } = pageLoadedAyahsData;
        const container = document.getElementById("pageAyahsContainer");
        if (!container) return;

        if (!rawQuery) {
            renderAyahCardsList(uthmani.ayahs, uthmani, bengali, english, audioRec, surahNum, bnName);
            return;
        }

        const filteredAyahs = uthmani.ayahs.filter((a, idx) => {
            const ayahNumStr = a.numberInSurah.toString();
            const bnAyah = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text.toLowerCase() : "";
            const enAyah = (english.ayahs[idx] && english.ayahs[idx].text) ? english.ayahs[idx].text.toLowerCase() : "";
            const arAyah = a.text ? a.text.toLowerCase() : "";

            return ayahNumStr === normQuery ||
                bnAyah.includes(rawQuery) ||
                enAyah.includes(rawQuery) ||
                arAyah.includes(rawQuery);
        });

        if (filteredAyahs.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px; background: rgba(0,0,0,0.2); border-radius: 12px; border: 1px dashed rgba(239, 68, 68, 0.4); color: #f87171;">
                    <i class="fas fa-search-minus" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                    <div style="font-size: 1.05rem; font-weight: 700;">'${rawQuery}' সংক্রান্ত কোনো আয়াত পাওয়া যায়নি</div>
                    <div style="font-size: 0.85rem; color: #a7f3d0; margin-top: 6px;">দয়া করে সঠিক আয়াত নম্বর বা অন্য শব্দ লিখে পুনরায় চেষ্টা করুন।</div>
                </div>
            `;
            return;
        }

        renderAyahCardsList(filteredAyahs, uthmani, bengali, english, audioRec, surahNum, bnName);
        if (pageCurrentPlayingAyahNum) {
            highlightAyah(pageCurrentPlayingAyahNum);
        }
    }

    function getAyahFormattedText(surahNum, ayahNum) {
        if (!pageLoadedAyahsData) return "";
        const { uthmani, bengali, english, bnName } = pageLoadedAyahsData;
        const idx = ayahNum - 1;
        const arText = (uthmani.ayahs[idx] && uthmani.ayahs[idx].text) ? uthmani.ayahs[idx].text : "";
        const bnText = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text : "";
        const enText = (english && english.ayahs && english.ayahs[idx] && english.ayahs[idx].text) ? english.ayahs[idx].text : "";
        const rawTr = (bengali.ayahs[idx] && bengali.ayahs[idx].transliteration) ? bengali.ayahs[idx].transliteration : "";
        const bnTr = transliterateQuranToBengali(rawTr);

        let text = `[${bnName}, আয়াত ${toBnNum(ayahNum)}]

${arText}`;
        if (bnTr) {
            text += `

বাংলা উচ্চারণ:
${bnTr}${rawTr && rawTr !== bnTr ? ` (${rawTr})` : ''}`;
        }
        if (bnText) {
            text += `

বাংলা অনুবাদ:
${bnText}`;
        }
        if (enText) {
            text += `

English Translation:
${enText}`;
        }
        text += `

সংগৃহীত: Response with Nur-Lab`;
        return text;
    }

    function copyPageAyahText(surahNum, ayahNum, btn) {
        const textToCopy = getAyahFormattedText(surahNum, ayahNum);
        if (!textToCopy) return;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showCopySuccess(btn);
            }).catch(err => {
                fallbackCopyText(textToCopy, btn);
            });
        } else {
            fallbackCopyText(textToCopy, btn);
        }
    }

    function fallbackCopyText(text, btn) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-9999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showCopySuccess(btn);
        } catch (err) {
            console.error('Fallback copy error', err);
        }
        document.body.removeChild(textArea);
    }

    function showCopySuccess(btn) {
        const origHtml = btn.innerHTML;
        const origBg = btn.style.background;
        btn.innerHTML = '<i class="fas fa-check"></i> কপি হয়েছে!';
        btn.style.background = 'rgba(16, 185, 129, 0.4)';
        setTimeout(() => {
            btn.innerHTML = origHtml;
            btn.style.background = origBg;
        }, 2000);
    }

    function sharePageAyahText(surahNum, ayahNum, btn) {
        const textToShare = getAyahFormattedText(surahNum, ayahNum);
        const bnName = pageLoadedAyahsData ? pageLoadedAyahsData.bnName : `সূরা ${surahNum}`;
        const shareTitle = `${bnName} - আয়াত ${toBnNum(ayahNum)}`;

        if (navigator.share) {
            navigator.share({
                title: shareTitle,
                text: textToShare,
                url: window.location.href
            }).catch(err => {
                console.log("Share dismissed/cancelled", err);
            });
        } else {
            copyPageAyahText(surahNum, ayahNum, btn);
            alert("আয়াতের বিবরণ কপি করা হয়েছে। আপনি বার্তা বা সোশ্যাল মিডিয়ায় পেস্ট করে শেয়ার করতে পারেন।");
        }
    }

    
    var currentCardAyahData = null;

    function openAyahCardModal(surahNum, ayahNum) {
        if (!pageLoadedAyahsData) return;
        const { uthmani, bengali, bnName } = pageLoadedAyahsData;
        const idx = ayahNum - 1;
        const arText = (uthmani.ayahs[idx] && uthmani.ayahs[idx].text) ? uthmani.ayahs[idx].text : "";
        const bnText = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text : "";

        currentCardAyahData = {
            surahNum: surahNum,
            ayahNum: ayahNum,
            surahName: bnName,
            arabic: arText,
            bengali: bnText
        };

        const modal = document.getElementById("quranImageCardModal");
        if (modal) {
            modal.style.display = "flex";
            renderAyahCardCanvas();
        }
    }

    function closeAyahCardModal() {
        const modal = document.getElementById("quranImageCardModal");
        if (modal) modal.style.display = "none";
    }

    function renderAyahCardCanvas() {
        if (!currentCardAyahData) return;
        const canvas = document.getElementById("ayahCardCanvas");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        const w = canvas.width;
        const h = canvas.height;

        // Background Gradient
        const grad = ctx.createRadialGradient(w/2, h/2, 50, w/2, h/2, w/2);
        grad.addColorStop(0, "#064e3b");
        grad.addColorStop(0.6, "#043e2f");
        grad.addColorStop(1, "#022c22");
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, w, h);

        // Outer Gold Border & Corners
        ctx.strokeStyle = "#f59e0b";
        ctx.lineWidth = 8;
        ctx.strokeRect(24, 24, w - 48, h - 48);

        ctx.strokeStyle = "rgba(16, 185, 129, 0.5)";
        ctx.lineWidth = 3;
        ctx.strokeRect(36, 36, w - 72, h - 72);

        // Header Title
        ctx.fillStyle = "#fef08a";
        ctx.font = "bold 32px 'Hind Siliguri', sans-serif";
        ctx.textAlign = "center";
        ctx.fillText(`— ${currentCardAyahData.surahName} : আয়াত ${toBnNum(currentCardAyahData.ayahNum)} —`, w / 2, 95);

        // Bismillah
        ctx.fillStyle = "#34d399";
        ctx.font = "28px 'Amiri', serif";
        ctx.fillText("بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ", w / 2, 145);

        // Arabic Text Box Wrapping
        ctx.fillStyle = "#ffffff";
        ctx.font = "32px 'Amiri', serif";
        const arLines = wrapCanvasText(ctx, currentCardAyahData.arabic, w - 120);
        let startY = 220;
        arLines.slice(0, 5).forEach(line => {
            ctx.fillText(line, w / 2, startY);
            startY += 48;
        });

        // Divider
        ctx.strokeStyle = "rgba(245, 158, 11, 0.4)";
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(120, startY + 10);
        ctx.lineTo(w - 120, startY + 10);
        ctx.stroke();

        // Bengali Text
        ctx.fillStyle = "#d1fae5";
        ctx.font = "bold 24px 'Hind Siliguri', sans-serif";
        const bnLines = wrapCanvasText(ctx, currentCardAyahData.bengali, w - 140);
        let bnY = startY + 55;
        bnLines.slice(0, 6).forEach(line => {
            ctx.fillText(line, w / 2, bnY);
            bnY += 36;
        });

        // Footer Branding
        ctx.fillStyle = "#9ca3af";
        ctx.font = "italic 20px 'Hind Siliguri', sans-serif";
        ctx.fillText("Response with Nur-Lab • Islamic Hub", w / 2, h - 55);
    }

    function wrapCanvasText(ctx, text, maxWidth) {
        const words = text.split(" ");
        const lines = [];
        let currentLine = words[0] || "";

        for (let i = 1; i < words.length; i++) {
            const word = words[i];
            const width = ctx.measureText(currentLine + " " + word).width;
            if (width < maxWidth) {
                currentLine += " " + word;
            } else {
                lines.push(currentLine);
                currentLine = word;
            }
        }
        if (currentLine) lines.push(currentLine);
        return lines;
    }

    function downloadAyahCardImage() {
        const canvas = document.getElementById("ayahCardCanvas");
        if (!canvas || !currentCardAyahData) return;
        const link = document.createElement("a");
        link.download = `Quran_${currentCardAyahData.surahName}_Ayah_${currentCardAyahData.ayahNum}.png`;
        link.href = canvas.toDataURL("image/png");
        link.click();
    }

        // Quranic Roman-to-Bengali Transliteration Engine
    const commonQuranWords = {
        "bismillaahir": "বিসমিল্লাহির",
        "bismillaahi": "বিসমিল্লাহি",
        "bismillah": "বিসমিল্লাহ",
        "rahmaanir": "রাহমানির",
        "rahmaani": "রাহমানি",
        "rahmaan": "রাহমান",
        "raheem": "রাহীম",
        "alhamdu": "আলহামদু",
        "lillaahi": "লিল্লাহি",
        "lillaah": "লিল্লাহ",
        "rabbil": "রাব্বিল",
        "rabbi": "রাব্বি",
        "aalameen": "আলামীন",
        "'aalameen": "আলামীন",
        "maaliki": "মালিকি",
        "yawmid": "ইয়াওমিদ",
        "deen": "দ্বীন",
        "iyyaaka": "ইয়্যাকা",
        "na'budu": "না'বুদু",
        "nabudu": "না'বুদু",
        "wa": "ওয়া",
        "nasta'een": "নাসতাঈন",
        "nastaeen": "নাসতাঈন",
        "ihdinas": "ইহদিনাস",
        "siraatal": "সিরাতাল",
        "siraata": "সিরাতা",
        "mustaqeem": "মুস্তাক্বীম",
        "lazeena": "লাযীনা",
        "allazeena": "আল্লাযীনা",
        "an'amta": "আন'আমতা",
        "anamta": "আন'আমতা",
        "alaihim": "আলাইহিম",
        "'alaihim": "আলাইহিম",
        "ghayril": "গাইরিল",
        "maghdoobi": "মাগদূবি",
        "lad": "লাদ",
        "daaaalleen": "দা-ল্লীন",
        "daaalleen": "দা-ল্লীন",
        "qul": "কুল",
        "huwal": "হুওয়াল",
        "huwa": "হুওয়া",
        "laahu": "ল্লাহু",
        "laaha": "ল্লাহা",
        "ahad": "আহাদ",
        "samad": "সামাদ",
        "lam": "লাম",
        "yalid": "ইয়ালিদ",
        "yoolad": "ইউলাদ",
        "yakul": "ইয়াকুল",
        "lahoo": "লাহু",
        "kufuwan": "কুফুওয়ান",
        "a'oozu": "আ'ঊযু",
        "aoozu": "আ'ঊযু",
        "rabbin": "রাব্বিন",
        "naas": "নাস",
        "malikin": "মালিকিন",
        "ilaahin": "ইলাহিন",
        "min": "মিন",
        "sharril": "শাররিল",
        "waswaasil": "ওয়াসওয়াসিল",
        "khannaas": "খান্নাস",
        "allazee": "আল্লাযী",
        "yuwaswisu": "ইউওয়াসউইসু",
        "fee": "ফী",
        "sudoorin": "সুদূরিন",
        "minal": "মিনাল",
        "jinnati": "জিন্নাতি",
        "wan": "ওয়ান",
        "falaq": "ফালাক্ব",
        "khalaq": "খালাক্ব",
        "ghasiqin": "গাসিক্বিন",
        "waqab": "ওয়াক্বাব",
        "naffaasaati": "নাফ্ফাছাতি",
        "uqad": "উক্বদ",
        "haasidin": "হাদিদিন",
        "hasad": "হাসাদ",
        "kaafiroon": "কাফিরূন",
        "a'budu": "আ'বুদু",
        "ta'budoon": "তা'বুদূন",
        "antum": "আনতুম",
        "aabidoona": "আবিদূনা",
        "aabidum": "আবিদুম",
        "abadttum": "আবাদতুম",
        "lakum": "লাকুম",
        "deenukum": "দীনুকুম",
        "waliya": "ওয়ালিয়া"
    };

    function transliterateWordToBengali(w) {
        if (!w) return '';
        const clean = w.replace(/^[^\w']+|[^\w']+$/g, '');
        const prefix = w.slice(0, w.indexOf(clean));
        const suffix = w.slice(w.indexOf(clean) + clean.length);

        const lower = clean.toLowerCase();
        if (commonQuranWords[lower]) {
            return prefix + commonQuranWords[lower] + suffix;
        }

        let res = '';
        let i = 0;
        const s = lower;

        const cons = {
            'sh': 'শ', 'kh': 'খ', 'gh': 'গ', 'th': 'ছ', 'dh': 'য', 'ph': 'ফ', 'ch': 'চ',
            'll': 'ল্ল', 'bb': 'ব্ব', 'tt': 'ত্ত', 'dd': 'দ্দ', 'mm': 'ম্ম', 'nn': 'ন্ন',
            'rr': 'রর', 'ss': 'সস', 'yy': 'ইয়্য', 'ww': 'উও', 'zz': 'যয', 'ff': 'ফফ',
            'b': 'ব', 't': 'ত', 'j': 'জ', 'h': 'হ', 'd': 'দ', 'r': 'র', 'z': 'য',
            's': 'স', 'f': 'ফ', 'q': 'ক', 'k': 'ক', 'l': 'ল', 'm': 'ম', 'n': 'ন',
            'w': 'ওয়', 'y': 'ইয়', 'v': 'ভ', 'p': 'প', 'c': 'ক', 'x': 'ক্স'
        };

        const indepVowels = {
            'aa': 'আ', 'a': 'আ', 'ee': 'ঈ', 'e': 'এ', 'oo': 'ঊ', 'u': 'উ',
            'ai': 'আই', 'ay': 'আই', 'au': 'আউ', 'aw': 'আও', 'i': 'ই', 'o': 'ও'
        };

        const depKaar = {
            'aa': 'া', 'a': 'া', 'ee': 'ী', 'e': 'ে', 'oo': 'ূ', 'u': 'ু',
            'ai': 'াই', 'ay': 'াই', 'au': 'াউ', 'aw': 'াও', 'i': 'ি', 'o': 'ো'
        };

        let lastWasCons = false;

        while (i < s.length) {
            if (s[i] === "'") {
                res += "'";
                lastWasCons = false;
                i++;
                continue;
            }

            const two = s.substr(i, 2);
            if (cons[two]) {
                res += cons[two];
                lastWasCons = true;
                i += 2;
                continue;
            }

            if (depKaar[two]) {
                if (lastWasCons) {
                    res += depKaar[two];
                } else {
                    res += indepVowels[two];
                }
                lastWasCons = false;
                i += 2;
                continue;
            }

            const one = s[i];
            if (cons[one]) {
                res += cons[one];
                lastWasCons = true;
                i += 1;
                continue;
            }

            if (depKaar[one]) {
                if (lastWasCons) {
                    res += depKaar[one];
                } else {
                    res += indepVowels[one];
                }
                lastWasCons = false;
                i += 1;
                continue;
            }

            res += one;
            lastWasCons = false;
            i++;
        }

        return prefix + res + suffix;
    }

    function transliterateQuranToBengali(text) {
        if (!text) return '';
        if (/[\u0980-\u09FF]/.test(text)) {
            return text;
        }
        const tokens = text.split(/(\s+|[-–—])/);
        return tokens.map(t => {
            if (/^\s+|[-–—]$/.test(t)) return t;
            return transliterateWordToBengali(t);
        }).join('');
    }

    function renderAyahCardsList(ayahsList, uthmani, bengali, english, audioRec, surahNum, bnName) {
        const container = document.getElementById("pageAyahsContainer");
        if (!container) return;

        const html = ayahsList.map((a) => {
            const idx = a.numberInSurah - 1;
            const bnAyah = (bengali.ayahs[idx] && bengali.ayahs[idx].text) ? bengali.ayahs[idx].text : "";
            const enAyah = (english.ayahs[idx] && english.ayahs[idx].text) ? english.ayahs[idx].text : "";
            const audioUrl = (audioRec && audioRec.ayahs[idx]) ? audioRec.ayahs[idx].audio : "";
            const secondaryAudioUrl = (audioRec && audioRec.ayahs[idx] && audioRec.ayahs[idx].secondaryAudio) ? audioRec.ayahs[idx].secondaryAudio : "";
            const isPlayingThis = (pageCurrentPlayingAyahNum === a.numberInSurah);

            const cardStyle = isPlayingThis 
                ? "background: rgba(16, 185, 129, 0.18); border: 2px solid #10b981; box-shadow: 0 0 25px rgba(16, 185, 129, 0.35); border-radius: 14px; padding: 26px; width: 100%; margin-bottom: 18px; box-sizing: border-box; transition: all 0.3s ease; position: relative;"
                : "background: rgba(2, 44, 34, 0.75); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 14px; padding: 26px; width: 100%; margin-bottom: 18px; box-sizing: border-box; transition: all 0.3s ease; position: relative;";

            const cardClass = isPlayingThis ? "page-ayah-card-item ayah-card-playing" : "page-ayah-card-item";

            const btnText = isPlayingThis && pageCurrentPlayingAudio && !pageCurrentPlayingAudio.paused 
                ? '<i class="fas fa-pause"></i> থামান' 
                : '<i class="fas fa-play"></i> অডিও';
            const btnStyle = isPlayingThis && pageCurrentPlayingAudio && !pageCurrentPlayingAudio.paused
                ? 'background: rgba(239, 68, 68, 0.35); border: 1px solid #ef4444; color: #fca5a5;'
                : 'background: rgba(52, 211, 153, 0.2); border: 1px solid #34d399; color: #6ee7b7;';

            return `
                <div id="page-ayah-card-${a.numberInSurah}" class="${cardClass}" data-ayah="${a.numberInSurah}" style="${cardStyle}" onmouseover="if(!this.classList.contains('ayah-card-playing')) this.style.borderColor='#34d399'" onmouseout="if(!this.classList.contains('ayah-card-playing')) this.style.borderColor='rgba(16, 185, 129, 0.25)'">
                    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(16, 185, 129, 0.2); padding-bottom: 10px; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 0.85rem; font-weight: 800; color: #10b981; font-family: 'Outfit', sans-serif; background: rgba(16, 185, 129, 0.15); padding: 3px 10px; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.3);">
                                ${toBnNum(surahNum)}:${toBnNum(a.numberInSurah)}
                            </span>
                            <div id="ayah-playing-badge-slot-${a.numberInSurah}" class="ayah-playing-badge-container">
                                ${isPlayingThis ? `
                                    <span class="ayah-playing-badge" style="background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 10px rgba(16,185,129,0.4); animation: pulseGlow 1.8s infinite;">
                                        <i class="fas fa-volume-up fa-beat"></i> তিলওয়াত চলছে
                                    </span>
                                ` : ''}
                            </div>
                        </div>

                        <div class="ayah-action-btn-group" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <button onclick="toggleAyahTafsir(${surahNum}, ${a.numberInSurah})" id="tafsir-btn-${surahNum}-${a.numberInSurah}" style="background: rgba(16, 185, 129, 0.18); border: 1px solid #10b981; color: #34d399; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.35)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.18)'">
                                <i class="fas fa-book-open"></i> তাফসীর
                            </button>

                            <button id="ayah-audio-btn-${a.numberInSurah}" onclick="togglePlayPageAyah(${surahNum}, ${a.numberInSurah})" style="${btnStyle} padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                ${btnText}
                            </button>

                            <button onclick="copyPageAyahText(${surahNum}, ${a.numberInSurah}, this)" style="background: rgba(59, 130, 246, 0.2); border: 1px solid #60a5fa; color: #93c5fd; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.background='rgba(59, 130, 246, 0.35)'" onmouseout="this.style.background='rgba(59, 130, 246, 0.2)'" title="আয়াত ও অনুবাদ কপি করুন">
                                <i class="fas fa-copy"></i> কপি
                            </button>

                            <button onclick="sharePageAyahText(${surahNum}, ${a.numberInSurah}, this)" style="background: rgba(168, 85, 247, 0.2); border: 1px solid #c084fc; color: #e9d5ff; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.background='rgba(168, 85, 247, 0.35)'" onmouseout="this.style.background='rgba(168, 85, 247, 0.2)'" title="আয়াত শেয়ার করুন">
                                <i class="fas fa-share-alt"></i> শেয়ার
                            </button>
                        </div>
                    </div>

                    <div class="page-arabic-text" style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.35rem; color: #ffffff; direction: rtl; text-align: right; line-height: 2.0; margin-bottom: 16px; text-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                        ${a.text} ۝${toBnNum(a.numberInSurah)}
                    </div>

                    <!-- Bengali Pronunciation / Transliteration -->
                    ${(() => {
                        const rawTr = (bengali.ayahs[idx] && bengali.ayahs[idx].transliteration) ? bengali.ayahs[idx].transliteration : "";
                        const bnTr = transliterateQuranToBengali(rawTr);
                        if (!bnTr && !rawTr) return "";
                        return `
                            <div class="page-translit-text" style="font-size: 1.05rem; color: #fef08a; line-height: 1.6; margin-bottom: 14px; background: rgba(245, 158, 11, 0.12); padding: 12px 16px; border-radius: 10px; border-left: 4px solid #f59e0b;">
                                <div style="color: #f59e0b; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 4px; display: flex; align-items: center; justify-content: space-between;">
                                    <span><i class="fas fa-language"></i> বাংলা উচ্চারণ:</span>
                                </div>
                                <div style="font-size: 1.08rem; font-weight: 700; color: #fef08a; letter-spacing: 0.2px;">
                                    ${bnTr}
                                </div>
                                ${rawTr && rawTr !== bnTr ? `
                                    <div style="font-size: 0.82rem; color: #cbd5e1; font-style: italic; margin-top: 4px; opacity: 0.85;">
                                        ${rawTr}
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    })()}

                    <!-- Bengali Translation -->
                    <div class="page-bengali-text" style="font-size: 1.05rem; color: #d1fae5; line-height: 1.7; text-align: left; font-weight: 600; margin-bottom: 8px;">
                        <span style="color: #34d399; font-size: 0.82rem; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 3px;">বাংলা অনুবাদ:</span>
                        ${bnAyah}
                    </div>



                    <!-- Tafsir Expandable Box -->
                    <div id="tafsir-box-${surahNum}-${a.numberInSurah}" style="display: none; margin-top: 16px; background: rgba(1, 30, 24, 0.85); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; padding: 20px; box-sizing: border-box; transition: all 0.3s ease;">
                    </div>
                </div>
            `;
        }).join('');

        container.innerHTML = html;
        applyPageFontSize();
    }

    async function loadPageSurahDetail(surahNum) {
        stopAllAyahAudio();
        pageCurrentSurahNum = surahNum;
        renderPageSurahSidebar(pageCachedSurahs);

        const ayahSearchInput = document.getElementById("pageAyahSearchInput");
        if (ayahSearchInput) ayahSearchInput.value = "";

        const body = document.getElementById("pageQuranAyahBody");
        const title = document.getElementById("pageQuranTitle");
        const sub = document.getElementById("pageQuranSub");

        if (body) {
            body.innerHTML = `
                <div style="text-align: center; padding: 70px 0; color: #a7f3d0;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #34d399;"></i>
                    <div style="font-size: 1.1rem; font-weight: 700;">সূরা ${toBnNum(surahNum)}-এর আয়াতসমূহ লোড হচ্ছে...</div>
                </div>
            `;
        }

        const reciterSelect = document.getElementById("pageQuranReciterSelect");
        const selectedReciter = reciterSelect ? reciterSelect.value : "ar.alafasy";
        const qCacheKey = "quran_surah_v2_" + surahNum + "_" + selectedReciter;

        // 1. Instant Cache Check (sessionStorage)
        try {
            const cachedStr = sessionStorage.getItem(qCacheKey);
            if (cachedStr) {
                const parsed = JSON.parse(cachedStr);
                if (parsed && parsed.uthmani && parsed.bengali && parsed.uthmani.ayahs && parsed.uthmani.ayahs.length > 0) {
                    pageLoadedAyahsData = parsed;
                    renderPageQuranAyahs(pageLoadedAyahsData);
                    return;
                }
            }
        } catch(e) {}

        let uthmani = null, bengali = null, english = null, audioRec = null;

        // 2. Fetch from Local Database API (with fast 2.5s timeout)
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 2500);
            const dbRes = await fetch(`<?= URLROOT ?>/api/quran/surah?num=${surahNum}`, { signal: controller.signal });
            clearTimeout(timeoutId);
            if (dbRes.ok) {
                const dbJson = await dbRes.json();
                if (dbJson && dbJson.success && dbJson.ayahs && dbJson.ayahs.length > 0) {
                    const ayahsList = dbJson.ayahs.map(a => ({
                        numberInSurah: parseInt(a.num || a.ayah_num),
                        text: a.arabic || ""
                    }));
                    const bnAyahsList = dbJson.ayahs.map(a => ({
                        numberInSurah: parseInt(a.num || a.ayah_num),
                        text: a.bangla || "",
                        transliteration: a.transliteration || ""
                    }));

                    const reciterSelect = document.getElementById("pageQuranReciterSelect");
                    const selectedReciter = reciterSelect ? reciterSelect.value : "ar.alafasy";

                    const audioAyahsList = dbJson.ayahs.map(a => {
                        const ayahNum = parseInt(a.num || a.ayah_num);
                        let mainAudio = "";
                        let secAudio = "";

                        if (typeof a.audio === "object" && a.audio !== null) {
                            mainAudio = a.audio[selectedReciter] || a.audio["ar.alafasy"] || Object.values(a.audio)[0] || "";
                        } else if (typeof a.audio === "string") {
                            mainAudio = a.audio;
                        }

                        if (!mainAudio) {
                            mainAudio = `https://cdn.islamic.network/quran/audio/128/${selectedReciter}/${ayahNum}.mp3`;
                        }

                        const sPad = String(surahNum).padStart(3, '0');
                        const aPad = String(ayahNum).padStart(3, '0');
                        secAudio = `https://everyayah.com/data/Alafasy_128kbps/${sPad}${aPad}.mp3`;

                        return {
                            numberInSurah: ayahNum,
                            audio: mainAudio,
                            secondaryAudio: secAudio
                        };
                    });

                    uthmani = {
                        number: surahNum,
                        name: dbJson.surah_name_ar || `سورة ${surahNum}`,
                        englishName: dbJson.surah_name_bn || bnSurahNames[surahNum] || `Surah ${surahNum}`,
                        englishNameTranslation: "",
                        revelationType: "Meccan",
                        numberOfAyahs: parseInt(dbJson.total_ayahs || ayahsList.length),
                        ayahs: ayahsList
                    };
                    bengali = { ayahs: bnAyahsList };
                    english = { ayahs: [] };
                    audioRec = { ayahs: audioAyahsList };
                }
            }
        } catch (dbErr) {
            console.log("Local DB API pass-through for Surah", surahNum);
        }

        // 3. Fallback to Ultra-Fast AlQuran Cloud Public API
        if (!uthmani) {
            try {
                const apiRes = await fetch(`https://api.alquran.cloud/v1/surah/${surahNum}/editions/quran-uthmani,bn.bengali,en.transliteration`);
                if (apiRes.ok) {
                    const apiJson = await apiRes.json();
                    if (apiJson && apiJson.code === 200 && apiJson.data && apiJson.data.length >= 2) {
                        const uthEdition = apiJson.data[0];
                        const bnEdition = apiJson.data[1];
                        const trEdition = apiJson.data[2] || null;

                        const ayahsList = uthEdition.ayahs.map(a => ({
                            numberInSurah: a.numberInSurah,
                            text: a.text || ""
                        }));
                        const bnAyahsList = bnEdition.ayahs.map((a, idx) => ({
                            numberInSurah: a.numberInSurah,
                            text: a.text || "",
                            transliteration: (trEdition && trEdition.ayahs && trEdition.ayahs[idx]) ? trEdition.ayahs[idx].text : ""
                        }));

                        const reciterSelect = document.getElementById("pageQuranReciterSelect");
                        const selectedReciter = reciterSelect ? reciterSelect.value : "ar.alafasy";

                        const audioAyahsList = uthEdition.ayahs.map(a => {
                            const ayahNum = a.numberInSurah;
                            const sPad = String(surahNum).padStart(3, '0');
                            const aPad = String(ayahNum).padStart(3, '0');
                            return {
                                numberInSurah: ayahNum,
                                audio: `https://everyayah.com/data/Alafasy_128kbps/${sPad}${aPad}.mp3`,
                                secondaryAudio: `https://cdn.islamic.network/quran/audio/128/${selectedReciter}/${a.number}.mp3`
                            };
                        });

                        uthmani = {
                            number: surahNum,
                            name: uthEdition.name || `سورة ${surahNum}`,
                            englishName: bnSurahNames[surahNum] || uthEdition.englishName || `Surah ${surahNum}`,
                            englishNameTranslation: uthEdition.englishNameTranslation || "",
                            revelationType: uthEdition.revelationType || "Meccan",
                            numberOfAyahs: uthEdition.numberOfAyahs || ayahsList.length,
                            ayahs: ayahsList
                        };
                        bengali = { ayahs: bnAyahsList };
                        english = { ayahs: [] };
                        audioRec = { ayahs: audioAyahsList };
                    }
                }
            } catch (cloudErr) {
                console.warn("AlQuran Cloud API error:", cloudErr);
            }
        }

        // 4. Fallback to Fawaz Ahmed Quran API on jsDelivr CDN
        if (!uthmani) {
            try {
                const [arRes, bnRes] = await Promise.all([
                    fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/ara-quranindopak/${surahNum}.json`),
                    fetch(`https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/ben-muhiuddinkhan/${surahNum}.json`)
                ]);
                if (arRes.ok && bnRes.ok) {
                    const arJson = await arRes.json();
                    const bnJson = await bnRes.json();
                    const arAyahs = arJson.chapter || [];
                    const bnAyahs = bnJson.chapter || [];

                    const ayahsList = arAyahs.map(a => ({
                        numberInSurah: a.verse,
                        text: a.text
                    }));
                    const bnAyahsList = bnAyahs.map(a => ({
                        numberInSurah: a.verse,
                        text: a.text,
                        transliteration: ""
                    }));

                    const audioAyahsList = arAyahs.map(a => {
                        const sPad = String(surahNum).padStart(3, '0');
                        const aPad = String(a.verse).padStart(3, '0');
                        return {
                            numberInSurah: a.verse,
                            audio: `https://everyayah.com/data/Alafasy_128kbps/${sPad}${aPad}.mp3`,
                            secondaryAudio: ""
                        };
                    });

                    uthmani = {
                        number: surahNum,
                        name: `سورة ${surahNum}`,
                        englishName: bnSurahNames[surahNum] || `Surah ${surahNum}`,
                        englishNameTranslation: "",
                        revelationType: "Meccan",
                        numberOfAyahs: ayahsList.length,
                        ayahs: ayahsList
                    };
                    bengali = { ayahs: bnAyahsList };
                    english = { ayahs: [] };
                    audioRec = { ayahs: audioAyahsList };
                }
            } catch(cdnErr) {
                console.error("Quran CDN fallback error:", cdnErr);
            }
        }

        if (!uthmani) {
            if (body) {
                body.innerHTML = `
                    <div style="text-align: center; padding: 60px 20px; background: rgba(0,0,0,0.2); border-radius: 16px; border: 1px dashed rgba(239,68,68,0.4); color: #f87171;">
                        <i class="fas fa-wifi" style="font-size: 2.5rem; margin-bottom: 14px; display: block; color: #f59e0b;"></i>
                        <div style="font-size: 1.2rem; font-weight: 800; color: #ffffff; margin-bottom: 6px;">সূরা ${toBnNum(surahNum)} লোড হতে সমস্যা হয়েছে</div>
                        <div style="font-size: 0.88rem; color: #a7f3d0; margin-bottom: 20px;">আপনার ইন্টারনেট সংযোগ পরীক্ষা করে পুনরায় চেষ্টা করুন।</div>
                        <button onclick="loadPageSurahDetail(${surahNum})" style="background: #10b981; border: none; color: #ffffff; padding: 10px 24px; border-radius: 20px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-rotate-right"></i> পুনরায় চেষ্টা করুন
                        </button>
                    </div>
                `;
            }
            return;
        }

        const bnName = bnSurahNames[surahNum] ? `সূরা ${bnSurahNames[surahNum]}` : `সূরা ${uthmani.englishName}`;
        pageLoadedAyahsData = { uthmani, bengali, english, audioRec, surahNum, bnName };

        // Save in sessionStorage for instant reuse
        try {
            sessionStorage.setItem(qCacheKey, JSON.stringify(pageLoadedAyahsData));
        } catch(e) {}

        renderPageQuranAyahs(pageLoadedAyahsData);
    }

    function renderPageQuranAyahs(data) {
        if (!data) return;
        const { uthmani, bengali, english, audioRec, surahNum, bnName } = data;
        const body = document.getElementById("pageQuranAyahBody");
        const title = document.getElementById("pageQuranTitle");
        const sub = document.getElementById("pageQuranSub");

        if (title) title.innerHTML = `${toBnNum(uthmani.number)}. ${bnName}`;
        if (sub) sub.innerText = `পবিত্র কুরআন • ${toBnNum(uthmani.numberOfAyahs)}টি আয়াত`;

        let surahHeaderHtml = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 22px; text-align: center; margin-bottom: 24px; position: relative; width: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.3); box-sizing: border-box;">
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 2.3rem; color: #10b981; margin-bottom: 6px;">${uthmani.name}</div>
                <div style="font-size: 1.3rem; font-weight: 800; color: #ffffff;">${toBnNum(surahNum)}. ${bnName}</div>
                <div style="font-size: 0.88rem; color: #a7f3d0; margin-top: 6px;">${bnName}-এর পূর্ণাঙ্গ আরবি পাঠ, বাংলা উচ্চারণ, অনুবাদ ও তিলাওয়াত।</div>

                <!-- Surah Audio Control Bar -->
                <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 16px; flex-wrap: wrap;">
                    <button id="topSurahPlayAllBtn" onclick="togglePlayFullSurah()" style="background: linear-gradient(135deg, #10b981, #059669); border: none; color: #ffffff; padding: 8px 22px; border-radius: 20px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(16,185,129,0.4); transition: all 0.2s;">
                        <i class="fas fa-play"></i> সম্পূর্ণ সূরা শুনুন
                    </button>
                    <button id="toggleAutoPlayBtn" onclick="toggleAutoPlaySetting()" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" title="একটি আয়াত শেষ হলে স্বয়ংক্রিয়ভাবে পরবর্তী আয়াত বাজবে">
                        <i class="fas fa-forward-step" style="color: #34d399;"></i> <span>অটো-প্লে: <strong style="color: #6ee7b7;">চালু</strong></span>
                    </button>
                </div>
            </div>
        `;

        let bismillahHtml = "";
        if (surahNum !== 9 && surahNum !== 1) {
            bismillahHtml = `
                <div style="text-align: center; padding: 14px; margin-bottom: 24px; background: rgba(0,0,0,0.2); border-radius: 12px; border: 1px solid rgba(245, 158, 11, 0.3); font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.6rem; color: #fef08a; width: 100%; box-sizing: border-box;">
                    بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                </div>
            `;
        }

        if (body) {
            body.innerHTML = `
                <div style="width: 100%; display: flex; flex-direction: column;">
                    ${surahHeaderHtml}
                    ${bismillahHtml}
                    <div id="pageAyahsContainer"></div>
                </div>
            `;
        }

        renderAyahCardsList(uthmani.ayahs, uthmani, bengali, english, audioRec, surahNum, bnName);
    }
</script>


<!-- Ayah Image Card Modal Generator (Feature 4) -->
<div id="quranImageCardModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #042f24; border: 1.5px solid #10b981; border-radius: 20px; max-width: 650px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.6); position: relative; color: #ffffff;">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(16,185,129,0.3); padding-bottom: 14px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-image" style="color: #f59e0b; font-size: 1.3rem;"></i>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #ffffff;">আয়াত ইমেজ কার্ড মেকার</h3>
            </div>
            <button onclick="closeAyahCardModal()" style="background: rgba(239,68,68,0.2); border: 1px solid #ef4444; color: #f87171; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-weight: 800; display: flex; align-items: center; justify-content: center;">✕</button>
        </div>

        <div style="text-align: center; margin-bottom: 16px;">
            <canvas id="ayahCardCanvas" width="800" height="800" style="width: 100%; max-width: 480px; height: auto; border-radius: 16px; border: 1px solid rgba(16,185,129,0.4); box-shadow: 0 10px 30px rgba(0,0,0,0.5);"></canvas>
        </div>

        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <button onclick="downloadAyahCardImage()" style="background: linear-gradient(135deg, #10b981, #059669); border: none; color: #ffffff; padding: 10px 24px; border-radius: 25px; font-weight: 800; font-size: 0.92rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(16,185,129,0.4);">
                <i class="fas fa-download"></i> ইমেজ ডাউনলোড করুন (PNG)
            </button>
            <button onclick="closeAyahCardModal()" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #e2e8f0; padding: 10px 20px; border-radius: 25px; font-weight: 700; font-size: 0.9rem; cursor: pointer;">
                বন্ধ করুন
            </button>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>


