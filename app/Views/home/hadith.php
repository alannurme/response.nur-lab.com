<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Hadith Shareef Dedicated Full Page Container (Islamic Emerald Green Theme) -->
<div style="position: relative; background: radial-gradient(circle at 50% 30%, #064e3b 0%, #043e2f 45%, #022c22 100%); min-height: 100vh; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; padding-bottom: 60px;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Top Sub-Header Control Banner -->
    <div class="hadith-top-sub-banner" style="position: sticky; top: 0; z-index: 100; background: rgba(4, 47, 36, 0.95); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 18px 24px; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
        <div style="width: 100%; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 0 10px; box-sizing: border-box;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="<?= URLROOT ?>" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                    <i class="fas fa-arrow-left"></i>
                    <span>হোম পেজ</span>
                </a>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 900;">
                    <i class="fas fa-book-quran"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;" id="pageHadithTitle">আল হাদিস শরীফ (iHadis Style)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">সহীহ বুখারী, সহীহ মুসলিম সহ ৯টি হাদিস গ্রন্থের বাংলা ও আরবি সংকলন</p>
                </div>
            </div>

            <div class="hadith-search-box-row" style="display: flex; align-items: center; gap: 12px;">
                <input type="number" id="pageHadithNumberInput" placeholder="হাদিস নম্বর" min="1" style="width: 110px; padding: 8px 12px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; text-align: center; outline: none; font-family: 'Hind Siliguri', sans-serif;">
                <button onclick="fetchPageHadithByNumber()" style="background: #10b981; border: none; color: #fff; padding: 8px 18px; border-radius: 10px; font-size: 0.88rem; font-weight: 700; cursor: pointer;">খুঁজুন</button>
            </div>
        </div>
    </div>

    <!-- Main Workspace Layout Grid (Left Book List + Right Hadith Reader) -->
    <div class="hadith-workspace-container" style="position: relative; z-index: 2; width: 100%; margin: 24px auto 0 auto; padding: 0 25px; box-sizing: border-box;">
        <div class="hadith-workspace-flex" style="display: flex; flex-wrap: wrap; gap: 24px; min-height: 75vh;">
            
            <!-- Left Sidebar: Hadith Books List & Chapters List -->
            <div class="hadith-sidebar-box" style="width: 320px; flex-shrink: 0; background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; display: flex; flex-direction: column; overflow: hidden; height: calc(100vh - 120px); position: sticky; top: 100px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); z-index: 20;">
                
                <!-- Book / Chapter Segment Switcher -->
                <div style="padding: 12px 14px 6px 14px; background: rgba(2, 44, 34, 0.95); border-bottom: 1px solid rgba(16, 185, 129, 0.2);">
                    <div style="display: flex; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 3px;">
                        <button id="pageTabBookBtn" onclick="switchSidebarTab('book')" style="flex: 1; padding: 7px 12px; border: none; border-radius: 9px; background: #10b981; color: #fff; font-weight: 800; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;">
                            <i class="fas fa-book" style="margin-right: 5px;"></i> বই
                        </button>
                        <button id="pageTabChapterBtn" onclick="switchSidebarTab('chapter')" style="flex: 1; padding: 7px 12px; border: none; border-radius: 9px; background: transparent; color: #a7f3d0; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;">
                            <i class="fas fa-list-ol" style="margin-right: 5px;"></i> অধ্যায়
                        </button>
                    </div>
                </div>

                <!-- Search Input -->
                <div style="padding: 10px 14px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); background: rgba(2, 44, 34, 0.85);">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                        <input type="text" id="pageHadithBookSearch" oninput="filterPageHadithSidebar()" placeholder="হাদিস গ্রন্থসমূহ সার্চ করুন..." style="width: 100%; padding: 9px 12px 9px 34px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Scrollable Sidebar List Items -->
                <div style="flex: 1; overflow-y: auto; padding: 10px;" id="pageHadithSidebarBookList">
                    <!-- Dynamic Items via JS -->
                </div>
            </div>

            <!-- Right Main Area: Hadith Cards Container -->
            <div style="flex: 1; min-width: 300px; background: rgba(4, 47, 36, 0.75); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);" id="pageHadithContentCard">
                <!-- Hadith Content via JS -->
            </div>

        </div>
    </div>
</div>

<style>
    /* Dedicated Hadith Page Mobile Responsiveness */
    @media (max-width: 991px) {
        .hadith-workspace-container {
            padding: 0 14px !important;
            margin-top: 14px !important;
        }
        .hadith-workspace-flex {
            flex-direction: column !important;
            gap: 16px !important;
        }
        .hadith-sidebar-box {
            width: 100% !important;
            height: auto !important;
            max-height: 340px !important;
            position: relative !important;
            top: 0 !important;
        }
        #pageHadithContentCard {
            padding: 18px 14px !important;
            border-radius: 14px !important;
            min-width: 100% !important;
        }
        .hadith-top-sub-banner {
            padding: 12px 16px !important;
        }
    }

    @media (max-width: 640px) {
        #pageHadithTitle {
            font-size: 1.15rem !important;
        }
        .hadith-search-box-row {
            width: 100% !important;
            margin-top: 10px !important;
            justify-content: flex-start !important;
        }
        .hadith-search-box-row input {
            flex: 1 !important;
            width: 100% !important;
        }
        div[id^="hadith-card-"] {
            padding: 16px !important;
            border-radius: 14px !important;
            margin-bottom: 16px !important;
        }
        div[id^="hadith-card-"] div[style*="font-family: 'Amiri'"] {
            font-size: 1.25rem !important;
            line-height: 2.1 !important;
            padding: 14px 16px !important;
        }
    }
</style>

<script>
    function toBnNum(numStr) {
        if (numStr === null || numStr === undefined) return '';
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function toEnNum(numStr) {
        if (numStr === null || numStr === undefined) return '';
        const bnToEn = {'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};
        return String(numStr).replace(/[০-৯]/g, function(w){ return bnToEn[w] || w; });
    }

    const pageHadithBookList = [
        { id: "bukhari", name: "সহীহ বুখারী", en: "Sahih al-Bukhari", total: 7529, code: "B", color: "#3b82f6" },
        { id: "muslim", name: "সহীহ মুসলিম", en: "Sahih Muslim", total: 7360, code: "M", color: "#10b981" },
        { id: "nasai", name: "সুনানে আন-নাসায়ী", en: "Sunan an-Nasa'i", total: 5656, code: "N", color: "#f59e0b" },
        { id: "abudawud", name: "সুনানে আবু দাউদ", en: "Sunan Abu Dawud", total: 5270, code: "A", color: "#ec4899" },
        { id: "tirmidhi", name: "জামে' আত-তিরমিজী", en: "Jami at-Tirmidhi", total: 3895, code: "T", color: "#8b5cf6" },
        { id: "ibnmajah", name: "সুনানে ইবনে মাজাহ", en: "Sunan Ibn Majah", total: 4336, code: "I", color: "#10b981" },
        { id: "malik", name: "মুয়াত্তা ইমাম মালিক", en: "Muwatta Malik", total: 1749, code: "M", color: "#64748b" },
        { id: "nawawi", name: "৪০ হাদীস (নওয়াবী)", en: "Forty Hadith Nawawi", total: 42, code: "N", color: "#f97316" }
    ];

    let currentSidebarTab = "book"; // "book" or "chapter"
    let pageCurrentHadithBook = "bukhari";
    let pageCurrentHadithNum = 1;
    let pageCurrentHadithPage = 1;
    const itemsPerPage = 20;
    const hadithCache = {};

    function switchSidebarTab(tabName) {
        currentSidebarTab = tabName;
        const bookBtn = document.getElementById("pageTabBookBtn");
        const chapBtn = document.getElementById("pageTabChapterBtn");

        if (tabName === "book") {
            if (bookBtn) {
                bookBtn.style.background = "#10b981";
                bookBtn.style.color = "#fff";
                bookBtn.style.fontWeight = "800";
            }
            if (chapBtn) {
                chapBtn.style.background = "transparent";
                chapBtn.style.color = "#a7f3d0";
                chapBtn.style.fontWeight = "700";
            }
        } else {
            if (chapBtn) {
                chapBtn.style.background = "#10b981";
                chapBtn.style.color = "#fff";
                chapBtn.style.fontWeight = "800";
            }
            if (bookBtn) {
                bookBtn.style.background = "transparent";
                bookBtn.style.color = "#a7f3d0";
                bookBtn.style.fontWeight = "700";
            }
        }

        renderPageHadithSidebar();
    }

    // Pre-defined static chapter structure for initial named chapters
    const knownChapters = {
    "bukhari": [
        {
            "id": 1,
            "name": "ওহীর সূচনা অধ্যায়",
            "start": 1,
            "end": 7
        },
        {
            "id": 2,
            "name": "ঈমান অধ্যায়",
            "start": 8,
            "end": 58
        },
        {
            "id": 3,
            "name": "ইলম অধ্যায়",
            "start": 59,
            "end": 134
        },
        {
            "id": 4,
            "name": "ওযু অধ্যায়",
            "start": 135,
            "end": 247
        },
        {
            "id": 5,
            "name": "গোসল অধ্যায়",
            "start": 248,
            "end": 293
        },
        {
            "id": 6,
            "name": "হায়েজ অধ্যায়",
            "start": 294,
            "end": 333
        },
        {
            "id": 7,
            "name": "তায়াম্মুম অধ্যায়",
            "start": 334,
            "end": 348
        },
        {
            "id": 8,
            "name": "সালাত অধ্যায়",
            "start": 349,
            "end": 520
        },
        {
            "id": 9,
            "name": "সালাতের ওয়াক্তসমূহ অধ্যায়",
            "start": 521,
            "end": 602
        },
        {
            "id": 10,
            "name": "আজান অধ্যায়",
            "start": 603,
            "end": 875
        },
        {
            "id": 11,
            "name": "জুমা অধ্যায়",
            "start": 876,
            "end": 941
        },
        {
            "id": 12,
            "name": "খাওফ (ভয় ভীতির সালাত) অধ্যায়",
            "start": 942,
            "end": 947
        },
        {
            "id": 13,
            "name": "দুই ঈদ অধ্যায়",
            "start": 948,
            "end": 989
        },
        {
            "id": 14,
            "name": "বিতর অধ্যায়",
            "start": 990,
            "end": 1004
        },
        {
            "id": 15,
            "name": "বৃষ্টির জন্য দোয়া অধ্যায়",
            "start": 1005,
            "end": 1039
        },
        {
            "id": 16,
            "name": "সূর্যগ্রহণ অধ্যায়",
            "start": 1040,
            "end": 1066
        },
        {
            "id": 17,
            "name": "কুরআন তিলাওয়াতের সিজদা অধ্যায়",
            "start": 1067,
            "end": 1079
        },
        {
            "id": 18,
            "name": "সালাতে কসর করা অধ্যায়",
            "start": 1080,
            "end": 1119
        },
        {
            "id": 19,
            "name": "তাহাজ্জুদ অধ্যায়",
            "start": 1120,
            "end": 1187
        },
        {
            "id": 20,
            "name": "মক্কা ও মদীনার মসজিদে সালাতের মর্যাদা অধ্যায়",
            "start": 1188,
            "end": 1197
        },
        {
            "id": 21,
            "name": "সালাতের সাথে সংশ্লিষ্ট কাজ অধ্যায়",
            "start": 1198,
            "end": 1223
        },
        {
            "id": 22,
            "name": "সাহু অধ্যায়",
            "start": 1224,
            "end": 1236
        },
        {
            "id": 23,
            "name": "জানাজা অধ্যায়",
            "start": 1237,
            "end": 1394
        },
        {
            "id": 24,
            "name": "যাকাত অধ্যায়",
            "start": 1395,
            "end": 1512
        },
        {
            "id": 25,
            "name": "হজ্জ অধ্যায়",
            "start": 1513,
            "end": 1772
        },
        {
            "id": 26,
            "name": "উমরাহ অধ্যায়",
            "start": 1773,
            "end": 1805
        },
        {
            "id": 27,
            "name": "পথে আটকে পড়া ও ইহরাম অবস্থায় শিকারকারীর বিধান অধ্যায়",
            "start": 1806,
            "end": 1820
        },
        {
            "id": 28,
            "name": "ইহরাম অবস্থায় শিকার ও অনুরূপ কিছুর বদলা অধ্যায়",
            "start": 1821,
            "end": 1866
        },
        {
            "id": 29,
            "name": "মদীনার ফজিলত অধ্যায়",
            "start": 1867,
            "end": 1890
        },
        {
            "id": 30,
            "name": "সাওম অধ্যায়",
            "start": 1891,
            "end": 2007
        },
        {
            "id": 31,
            "name": "তারাবীহর সালাত অধ্যায়",
            "start": 2008,
            "end": 2013
        },
        {
            "id": 32,
            "name": "লাইলাতুল কদর এর ফজিলত অধ্যায়",
            "start": 2014,
            "end": 2024
        },
        {
            "id": 33,
            "name": "ইতিকাফ অধ্যায়",
            "start": 2025,
            "end": 2046
        },
        {
            "id": 34,
            "name": "ক্রয়-বিক্রয় অধ্যায়",
            "start": 2047,
            "end": 2238
        },
        {
            "id": 35,
            "name": "সলম (অগ্রিম ক্রয়-বিক্রয়) অধ্যায়",
            "start": 2239,
            "end": 2256
        },
        {
            "id": 36,
            "name": "শুফআ অধ্যায়",
            "start": 2257,
            "end": 2259
        },
        {
            "id": 37,
            "name": "ইজারা অধ্যায়",
            "start": 2260,
            "end": 2286
        },
        {
            "id": 38,
            "name": "হাওয়ালাত অধ্যায়",
            "start": 2287,
            "end": 2289
        },
        {
            "id": 39,
            "name": "যামিন হওয়া অধ্যায়",
            "start": 2290,
            "end": 2298
        },
        {
            "id": 40,
            "name": "ওয়াকালাহ (প্রতিনিধিত্ব) অধ্যায়",
            "start": 2299,
            "end": 2319
        },
        {
            "id": 41,
            "name": "চাষাবাদ অধ্যায়",
            "start": 2320,
            "end": 2350
        },
        {
            "id": 42,
            "name": "পানি সেচ অধ্যায়",
            "start": 2351,
            "end": 2384
        },
        {
            "id": 43,
            "name": "ঋণ গ্রহণ, ঋণ পরিশোধ, নিষেধাজ্ঞা আরোপ ও দেউলিয়া ঘোষণা অধ্যায়",
            "start": 2385,
            "end": 2409
        },
        {
            "id": 44,
            "name": "ঝগড়া-বিবাদ মীমাংসা অধ্যায়",
            "start": 2410,
            "end": 2425
        },
        {
            "id": 45,
            "name": "পড়ে থাকা বস্তু উঠানো অধ্যায়",
            "start": 2426,
            "end": 2439
        },
        {
            "id": 46,
            "name": "জুলুম ও কিসাস অধ্যায়",
            "start": 2440,
            "end": 2482
        },
        {
            "id": 47,
            "name": "অংশীদারিত্ব অধ্যায়",
            "start": 2483,
            "end": 2507
        },
        {
            "id": 48,
            "name": "বন্ধক অধ্যায়",
            "start": 2508,
            "end": 2516
        },
        {
            "id": 49,
            "name": "ক্রীতদাস আযাদ করা অধ্যায়",
            "start": 2517,
            "end": 2559
        },
        {
            "id": 50,
            "name": "মুকাতাব (চুক্তিবদ্ধ দাসের বর্ণনা) অধ্যায়",
            "start": 2560,
            "end": 2565
        },
        {
            "id": 51,
            "name": "হিবা ও তার ফজিলত এবং এর প্রতি উৎসাহ প্রদান অধ্যায়",
            "start": 2566,
            "end": 2636
        },
        {
            "id": 52,
            "name": "সাক্ষ্যদান অধ্যায়",
            "start": 2637,
            "end": 2689
        },
        {
            "id": 53,
            "name": "বিবাদ মীমাংসা অধ্যায়",
            "start": 2690,
            "end": 2710
        },
        {
            "id": 54,
            "name": "শর্তাবলী অধ্যায়",
            "start": 2711,
            "end": 2737
        },
        {
            "id": 55,
            "name": "ওসিয়াত অধ্যায়",
            "start": 2738,
            "end": 2781
        },
        {
            "id": 56,
            "name": "জিহাদ অধ্যায়",
            "start": 2782,
            "end": 3090
        },
        {
            "id": 57,
            "name": "খুমুস (এক পঞ্চমাংশ) অধ্যায়",
            "start": 3091,
            "end": 3155
        },
        {
            "id": 58,
            "name": "জিযিয়া কর ও সন্ধি স্থাপন অধ্যায়",
            "start": 3156,
            "end": 3189
        },
        {
            "id": 59,
            "name": "সৃষ্টির সূচনা অধ্যায়",
            "start": 3190,
            "end": 3325
        },
        {
            "id": 60,
            "name": "আম্বিয়া কিরাম (আঃ) অধ্যায়",
            "start": 3326,
            "end": 3488
        },
        {
            "id": 61,
            "name": "মর্যাদা ও বৈশিষ্ট্য অধ্যায়",
            "start": 3489,
            "end": 3648
        },
        {
            "id": 62,
            "name": "সাহাবীগণের মর্যাদা অধ্যায়",
            "start": 3649,
            "end": 3775
        },
        {
            "id": 63,
            "name": "আনসারগণের মর্যাদা অধ্যায়",
            "start": 3776,
            "end": 3948
        },
        {
            "id": 64,
            "name": "মাগাজি অধ্যায়",
            "start": 3949,
            "end": 4473
        },
        {
            "id": 65,
            "name": "তাফসীর অধ্যায়",
            "start": 4474,
            "end": 4977
        },
        {
            "id": 66,
            "name": "ফজায়িলুল কুরআন অধ্যায়",
            "start": 4978,
            "end": 5062
        },
        {
            "id": 67,
            "name": "বিয়ে-শাদি অধ্যায়",
            "start": 5063,
            "end": 5250
        },
        {
            "id": 68,
            "name": "তালাক অধ্যায়",
            "start": 5251,
            "end": 5350
        },
        {
            "id": 69,
            "name": "ভরণ-পোষণ অধ্যায়",
            "start": 5351,
            "end": 5372
        },
        {
            "id": 70,
            "name": "আহার সংক্রান্ত অধ্যায়",
            "start": 5373,
            "end": 5466
        },
        {
            "id": 71,
            "name": "আকীকা অধ্যায়",
            "start": 5467,
            "end": 5474
        },
        {
            "id": 72,
            "name": "যবেহ ও শিকার করা অধ্যায়",
            "start": 5475,
            "end": 5544
        },
        {
            "id": 73,
            "name": "কুরবানী অধ্যায়",
            "start": 5545,
            "end": 5574
        },
        {
            "id": 74,
            "name": "পানীয় দ্রব্যসমূহ অধ্যায়",
            "start": 5575,
            "end": 5639
        },
        {
            "id": 75,
            "name": "রোগীদের বর্ণনা অধ্যায়",
            "start": 5640,
            "end": 5677
        },
        {
            "id": 76,
            "name": "চিকিৎসা অধ্যায়",
            "start": 5678,
            "end": 5782
        },
        {
            "id": 77,
            "name": "পোশাক-পরিচ্ছদ অধ্যায়",
            "start": 5783,
            "end": 5969
        },
        {
            "id": 78,
            "name": "আচার-ব্যবহার অধ্যায়",
            "start": 5970,
            "end": 6226
        },
        {
            "id": 79,
            "name": "অনুমতি চাওয়া অধ্যায়",
            "start": 6227,
            "end": 6303
        },
        {
            "id": 80,
            "name": "দোয়া অধ্যায়",
            "start": 6304,
            "end": 6411
        },
        {
            "id": 81,
            "name": "কোমল হওয়া অধ্যায়",
            "start": 6412,
            "end": 6593
        },
        {
            "id": 82,
            "name": "তাকদীর অধ্যায়",
            "start": 6594,
            "end": 6620
        },
        {
            "id": 83,
            "name": "শপথ ও মানত অধ্যায়",
            "start": 6621,
            "end": 6707
        },
        {
            "id": 84,
            "name": "শপথের কাফফারা অধ্যায়",
            "start": 6708,
            "end": 6722
        },
        {
            "id": 85,
            "name": "উত্তরাধিকার অধ্যায়",
            "start": 6723,
            "end": 6771
        },
        {
            "id": 86,
            "name": "শরিয়তের শাস্তি অধ্যায়",
            "start": 6772,
            "end": 6860
        },
        {
            "id": 87,
            "name": "রক্তপণ অধ্যায়",
            "start": 6861,
            "end": 6917
        },
        {
            "id": 88,
            "name": "আল্লাহদ্রোহী ও ধর্মত্যাগীদেরকে তাওবার প্রতি আহ্বান ও তাদের সাথে যুদ্ধ অধ্যায়",
            "start": 6918,
            "end": 6939
        },
        {
            "id": 89,
            "name": "বলপ্রয়োগে বাধ্য করা অধ্যায়",
            "start": 6940,
            "end": 6952
        },
        {
            "id": 90,
            "name": "কূটকৌশল অধ্যায়",
            "start": 6953,
            "end": 6981
        },
        {
            "id": 91,
            "name": "স্বপ্নের ব্যাখ্যা প্রদান অধ্যায়",
            "start": 6982,
            "end": 7047
        },
        {
            "id": 92,
            "name": "ফিতনা অধ্যায়",
            "start": 7048,
            "end": 7136
        },
        {
            "id": 93,
            "name": "আহকাম অধ্যায়",
            "start": 7137,
            "end": 7225
        },
        {
            "id": 94,
            "name": "আকাঙ্ক্ষা অধ্যায়",
            "start": 7226,
            "end": 7245
        },
        {
            "id": 95,
            "name": "খবরে ওয়াহিদ অধ্যায়",
            "start": 7246,
            "end": 7267
        },
        {
            "id": 96,
            "name": "কুরআন ও সুন্নাহকে দৃঢ়ভাবে ধারণ করা অধ্যায়",
            "start": 7268,
            "end": 7370
        },
        {
            "id": 97,
            "name": "জাহমিয়াদের মতের খণ্ডন ও তাওহীদ প্রসঙ্গ অধ্যায়",
            "start": 7371,
            "end": 7563
        }
    ],
    "muslim": [
        {
            "id": 0,
            "name": "ভূমিকা অধ্যায়",
            "start": 1,
            "end": 94
        },
        {
            "id": 1,
            "name": "ঈমান অধ্যায়",
            "start": 1,
            "end": 421
        },
        {
            "id": 2,
            "name": "তাহারাত (পবিত্রতা) অধ্যায়",
            "start": 422,
            "end": 565
        },
        {
            "id": 3,
            "name": "হায়িয (ঋতুস্রাব) অধ্যায়",
            "start": 566,
            "end": 722
        },
        {
            "id": 4,
            "name": "সালাত অধ্যায়",
            "start": 723,
            "end": 1047
        },
        {
            "id": 5,
            "name": "মসজিদ ও সালাতের স্থানসমূহ অধ্যায়",
            "start": 1048,
            "end": 1454
        },
        {
            "id": 6,
            "name": "মুসাফিরদের সালাত ও তার কসর অধ্যায়",
            "start": 1455,
            "end": 1721
        },
        {
            "id": 7,
            "name": "কোরআনের মর্যাদাসমূহ ও এতদসংশ্লিষ্ট বিষয় অধ্যায়",
            "start": 1722,
            "end": 1835
        },
        {
            "id": 8,
            "name": "জুমু’আ অধ্যায়",
            "start": 1836,
            "end": 1928
        },
        {
            "id": 9,
            "name": "দুই ঈদের সালাত অধ্যায়",
            "start": 1929,
            "end": 1954
        },
        {
            "id": 10,
            "name": "ইস্‌তিস্‌ক্বার সলাত অধ্যায়",
            "start": 1955,
            "end": 1973
        },
        {
            "id": 11,
            "name": "সূর্যগ্রহণের বর্ণনা অধ্যায়",
            "start": 1974,
            "end": 2007
        },
        {
            "id": 12,
            "name": "জানাযা সম্পর্কিত অধ্যায়",
            "start": 2008,
            "end": 2152
        },
        {
            "id": 13,
            "name": "যাকাত অধ্যায়",
            "start": 2153,
            "end": 2384
        },
        {
            "id": 14,
            "name": "কিতাবুস্‌ সিয়াম (রোজা) অধ্যায়",
            "start": 2385,
            "end": 2669
        },
        {
            "id": 15,
            "name": "ই’তিকাফ অধ্যায়",
            "start": 2670,
            "end": 2680
        },
        {
            "id": 16,
            "name": "হজ্জ অধ্যায়",
            "start": 2681,
            "end": 3288
        },
        {
            "id": 17,
            "name": "বিবাহ অধ্যায়",
            "start": 3289,
            "end": 3459
        },
        {
            "id": 18,
            "name": "দুধপান অধ্যায়",
            "start": 3460,
            "end": 3543
        },
        {
            "id": 19,
            "name": "ত্বলাক্ব অধ্যায়",
            "start": 3544,
            "end": 3634
        },
        {
            "id": 20,
            "name": "লি’আন অধ্যায়",
            "start": 3635,
            "end": 3661
        },
        {
            "id": 21,
            "name": "দাসমুক্তি অধ্যায়",
            "start": 3662,
            "end": 3692
        },
        {
            "id": 22,
            "name": "ক্রয়-বিক্রয় অধ্যায়",
            "start": 3693,
            "end": 3853
        },
        {
            "id": 23,
            "name": "মুসাকাহ (পানি সেচের বিনিময়ে ফসলের একটি অংশ প্রদান) অধ্যায়",
            "start": 3854,
            "end": 4031
        },
        {
            "id": 24,
            "name": "ফারায়িয অধ্যায়",
            "start": 4032,
            "end": 4054
        },
        {
            "id": 25,
            "name": "হিবাত (দান) অধ্যায়",
            "start": 4055,
            "end": 4095
        },
        {
            "id": 26,
            "name": "ওয়াসিয়্যাত অধ্যায়",
            "start": 4096,
            "end": 4126
        },
        {
            "id": 27,
            "name": "মানত অধ্যায়",
            "start": 4127,
            "end": 4145
        },
        {
            "id": 28,
            "name": "কসম অধ্যায়",
            "start": 4146,
            "end": 4233
        },
        {
            "id": 29,
            "name": "‘কাসামাহ’ (খুনের ব্যপারে হলফ করা), ‘মুহারিবীন’ (শত্রু সৈন্য), ‘কিসাস” (খুনের বদলা) এবং ‘দিয়াত’ (খুনের শাস্তি স্বরূপ জরিমানা) অধ্যায়",
            "start": 4234,
            "end": 4289
        },
        {
            "id": 30,
            "name": "অপরাধের (নির্ধারিত) শাস্তি অধ্যায়",
            "start": 4290,
            "end": 4361
        },
        {
            "id": 31,
            "name": "বিচার বিধান অধ্যায়",
            "start": 4362,
            "end": 4389
        },
        {
            "id": 32,
            "name": "হারানো বস্তু প্রাপ্তি অধ্যায়",
            "start": 4390,
            "end": 4410
        },
        {
            "id": 33,
            "name": "জিহাদ ও এর নীতিমালা অধ্যায়",
            "start": 4411,
            "end": 4594
        },
        {
            "id": 34,
            "name": "প্রশাসন ও নেতৃত্ব অধ্যায়",
            "start": 4595,
            "end": 4865
        },
        {
            "id": 35,
            "name": "শিকার ও যবেহকৃত জন্তু এবং যেসব পশুর গোশত খাওয়া হালাল অধ্যায়",
            "start": 4866,
            "end": 4957
        },
        {
            "id": 36,
            "name": "কুরবানী অধ্যায়",
            "start": 4958,
            "end": 5020
        },
        {
            "id": 37,
            "name": "পানীয় বস্তু অধ্যায়",
            "start": 5021,
            "end": 5278
        },
        {
            "id": 38,
            "name": "পোশাক ও সাজসজ্জা অধ্যায়",
            "start": 5279,
            "end": 5478
        },
        {
            "id": 39,
            "name": "শিষ্টাচার অধ্যায়",
            "start": 5479,
            "end": 5538
        },
        {
            "id": 40,
            "name": "সালাম অধ্যায়",
            "start": 5539,
            "end": 5754
        },
        {
            "id": 41,
            "name": "শব্দচয়ন ও শব্দ প্রয়োগে শিষ্টাচার অধ্যায়",
            "start": 5755,
            "end": 5777
        },
        {
            "id": 42,
            "name": "কবিতা অধ্যায়",
            "start": 5778,
            "end": 5789
        },
        {
            "id": 43,
            "name": "স্বপ্ন অধ্যায়",
            "start": 5790,
            "end": 5831
        },
        {
            "id": 44,
            "name": "ফযীলত অধ্যায়",
            "start": 5832,
            "end": 6062
        },
        {
            "id": 45,
            "name": "সাহাবা (রাযিঃ)- গণের ফযীলত (মর্যাদা) অধ্যায়",
            "start": 6063,
            "end": 6393
        },
        {
            "id": 46,
            "name": "সদ্ব্যবহার, আত্মীয়তার সম্পর্ক রক্ষা ও শিষ্টাচার অধ্যায়",
            "start": 6394,
            "end": 6615
        },
        {
            "id": 47,
            "name": "তাকদীর অধ্যায়",
            "start": 6616,
            "end": 6667
        },
        {
            "id": 48,
            "name": "‘ইল্‌ম অধ্যায়",
            "start": 6668,
            "end": 6697
        },
        {
            "id": 49,
            "name": "যিক্‌র, দু’আ, তওবা ও ইস্‌তিগফার অধ্যায়",
            "start": 6698,
            "end": 6844
        },
        {
            "id": 50,
            "name": "তওবা অধ্যায়",
            "start": 6845,
            "end": 6916
        },
        {
            "id": 51,
            "name": "মুনাফিকদের আচরণ এবং তাদের সম্পর্কে বিধান অধ্যায়",
            "start": 6917,
            "end": 6937
        },
        {
            "id": 52,
            "name": "কিয়ামত, জান্নাত ও জাহান্নামের বর্ণনা অধ্যায়",
            "start": 6938,
            "end": 7021
        },
        {
            "id": 53,
            "name": "জান্নাত, জান্নাতের নি’আমাত ও জান্নাতবাসীদের বর্ণনা অধ্যায়",
            "start": 7022,
            "end": 7126
        },
        {
            "id": 54,
            "name": "ফিতনাসমুহ ও কিয়ামতের নিদর্শনাবলী অধ্যায়",
            "start": 7127,
            "end": 7306
        },
        {
            "id": 55,
            "name": "যুহ্‌দ ও দুনিয়ার ব্যপারে আকর্ষণহীনতা সম্পর্কিত বর্ণনা অধ্যায়",
            "start": 7307,
            "end": 7412
        },
        {
            "id": 56,
            "name": "তাফসীর অধ্যায়",
            "start": 7413,
            "end": 7453
        }
    ],
    "nasai": [
        {
            "id": 1,
            "name": "পবিত্রতা অধ্যায়",
            "start": 1,
            "end": 324
        },
        {
            "id": 2,
            "name": "পানির বিবরন অধ্যায়",
            "start": 325,
            "end": 347
        },
        {
            "id": 3,
            "name": "হায়েজ ও ইস্তিহাজা প্রসঙ্গে অধ্যায়",
            "start": 348,
            "end": 395
        },
        {
            "id": 4,
            "name": "গোসল ও তায়াম্মুম অধ্যায়",
            "start": 396,
            "end": 447
        },
        {
            "id": 5,
            "name": "নামাজ প্রসঙ্গে অধ্যায়",
            "start": 448,
            "end": 493
        },
        {
            "id": 6,
            "name": "নামাজের সময়সীমা অধ্যায়",
            "start": 494,
            "end": 625
        },
        {
            "id": 7,
            "name": "আযান অধ্যায়",
            "start": 626,
            "end": 687
        },
        {
            "id": 8,
            "name": "মসজিদ অধ্যায়",
            "start": 688,
            "end": 741
        },
        {
            "id": 9,
            "name": "কিবলা অধ্যায়",
            "start": 742,
            "end": 776
        },
        {
            "id": 10,
            "name": "ইমামত অধ্যায়",
            "start": 777,
            "end": 875
        },
        {
            "id": 11,
            "name": "নামাজ শুরু করা অধ্যায়",
            "start": 876,
            "end": 1028
        },
        {
            "id": 12,
            "name": "তাত্ববীক [রুকুতে দু'হাত হাঁটুদ্বয়ের মাঝে স্থাপন] করা অধ্যায়",
            "start": 1029,
            "end": 1178
        },
        {
            "id": 13,
            "name": "সাহু অধ্যায়",
            "start": 1179,
            "end": 1366
        },
        {
            "id": 14,
            "name": "জুমু'আ অধ্যায়",
            "start": 1367,
            "end": 1432
        },
        {
            "id": 15,
            "name": "সফরে নামাজ সংক্ষিপ্ত করা অধ্যায়",
            "start": 1433,
            "end": 1458
        },
        {
            "id": 16,
            "name": "গ্রহণ অধ্যায়",
            "start": 1459,
            "end": 1503
        },
        {
            "id": 17,
            "name": "ইস্তিস্কা [বৃষ্টির জন্য দুয়া করা] অধ্যায়",
            "start": 1504,
            "end": 1528
        },
        {
            "id": 18,
            "name": "ভয়কালীন নামাজ অধ্যায়",
            "start": 1529,
            "end": 1555
        },
        {
            "id": 19,
            "name": "উভয় ঈদের নামায অধ্যায়",
            "start": 1556,
            "end": 1597
        },
        {
            "id": 20,
            "name": "তাহাজ্জুদ ও দিনের নফল নামাজ অধ্যায়",
            "start": 1598,
            "end": 1817
        },
        {
            "id": 21,
            "name": "জানাজা অধ্যায়",
            "start": 1818,
            "end": 2089
        },
        {
            "id": 22,
            "name": "সাওম [রোযা] অধ্যায়",
            "start": 2090,
            "end": 2434
        },
        {
            "id": 23,
            "name": "যাকাত অধ্যায়",
            "start": 2435,
            "end": 2618
        },
        {
            "id": 24,
            "name": "হজ্জের নিয়ম পদ্ধতি অধ্যায়",
            "start": 2619,
            "end": 3084
        },
        {
            "id": 25,
            "name": "জিহাদ অধ্যায়",
            "start": 3085,
            "end": 3195
        },
        {
            "id": 26,
            "name": "নিকাহ অধ্যায়",
            "start": 3196,
            "end": 3388
        },
        {
            "id": 27,
            "name": "তালাক অধ্যায়",
            "start": 3389,
            "end": 3560
        },
        {
            "id": 28,
            "name": "ঘোড়া অধ্যায়",
            "start": 3561,
            "end": 3593
        },
        {
            "id": 29,
            "name": "ওয়াক্‌ফ অধ্যায়",
            "start": 3594,
            "end": 3610
        },
        {
            "id": 30,
            "name": "ওয়াসিয়াত অধ্যায়",
            "start": 3611,
            "end": 3671
        },
        {
            "id": 31,
            "name": "বিশেষ দান অধ্যায়",
            "start": 3672,
            "end": 3687
        },
        {
            "id": 32,
            "name": "হিবা অধ্যায়",
            "start": 3688,
            "end": 3705
        },
        {
            "id": 33,
            "name": "রুকবা অধ্যায়",
            "start": 3706,
            "end": 3719
        },
        {
            "id": 34,
            "name": "'উমরারূপে (আজীবনের জন্য) দান করা অধ্যায়",
            "start": 3720,
            "end": 3760
        },
        {
            "id": 35,
            "name": "মানত ও কসম অধ্যায়",
            "start": 3761,
            "end": 3856
        },
        {
            "id": 36,
            "name": "বর্গাচাষ অধ্যায়",
            "start": 3857,
            "end": 3938
        },
        {
            "id": 37,
            "name": "স্ত্রীর সাথে ব্যবহার অধ্যায়",
            "start": 3939,
            "end": 3965
        },
        {
            "id": 38,
            "name": "রক্তপাত হারাম হওয়া প্রসঙ্গে অধ্যায়",
            "start": 3966,
            "end": 4132
        },
        {
            "id": 39,
            "name": "যুদ্ধলব্ধ মাল বণ্টন অধ্যায়",
            "start": 4133,
            "end": 4148
        },
        {
            "id": 40,
            "name": "বায়'আত অধ্যায়",
            "start": 4149,
            "end": 4211
        },
        {
            "id": 41,
            "name": "আকীকা অধ্যায়",
            "start": 4212,
            "end": 4221
        },
        {
            "id": 42,
            "name": "ফারা এবং ‘আতীরা অধ্যায়",
            "start": 4222,
            "end": 4262
        },
        {
            "id": 43,
            "name": "শিকার ও যবেহকৃত জন্তু অধ্যায়",
            "start": 4263,
            "end": 4360
        },
        {
            "id": 44,
            "name": "কুরবানী অধ্যায়",
            "start": 4361,
            "end": 4448
        },
        {
            "id": 45,
            "name": "ক্রয়-বিক্রয় অধ্যায়",
            "start": 4449,
            "end": 4705
        },
        {
            "id": 46,
            "name": "কাসামাহ অধ্যায়",
            "start": 4706,
            "end": 4869
        },
        {
            "id": 47,
            "name": "চোরের হাত কাটা অধ্যায়",
            "start": 4870,
            "end": 4984
        },
        {
            "id": 48,
            "name": "ঈমান এবং এর বিধানাবলী অধ্যায়",
            "start": 4985,
            "end": 5039
        },
        {
            "id": 49,
            "name": "সাজসজ্জা অধ্যায়",
            "start": 5040,
            "end": 5378
        },
        {
            "id": 50,
            "name": "বিচারকের নীতিমালা অধ্যায়",
            "start": 5379,
            "end": 5427
        },
        {
            "id": 51,
            "name": "আল্লাহর আশ্রয় গ্রহণ করা অধ্যায়",
            "start": 5428,
            "end": 5539
        },
        {
            "id": 52,
            "name": "বিভিন্ন প্রকার পানীয় [ও তার বিধান] অধ্যায়",
            "start": 5540,
            "end": 5758
        }
    ],
    "abudawud": [
        {
            "id": 1,
            "name": "পবিত্রতা অর্জন অধ্যায়",
            "start": 1,
            "end": 390
        },
        {
            "id": 2,
            "name": "সালাত (নামাজ) অধ্যায়",
            "start": 391,
            "end": 1160
        },
        {
            "id": 3,
            "name": "সালাতুল ইস্তিসকা (বৃষ্টি প্রার্থনার সালাত) অধ্যায়",
            "start": 1161,
            "end": 1197
        },
        {
            "id": 4,
            "name": "সফরকালীন সালাত অধ্যায়",
            "start": 1198,
            "end": 1249
        },
        {
            "id": 5,
            "name": "নফল সালাত অধ্যায়",
            "start": 1250,
            "end": 1370
        },
        {
            "id": 6,
            "name": "রমজান মাস অধ্যায়",
            "start": 1371,
            "end": 1400
        },
        {
            "id": 7,
            "name": "কুরআন তিলাওয়াতের সিজদাসমূহ অধ্যায়",
            "start": 1401,
            "end": 1415
        },
        {
            "id": 8,
            "name": "বিতর সালাত অধ্যায়",
            "start": 1416,
            "end": 1555
        },
        {
            "id": 9,
            "name": "যাকাত অধ্যায়",
            "start": 1556,
            "end": 1700
        },
        {
            "id": 10,
            "name": "লুকতা (হারানো বস্তু প্রাপ্তি) অধ্যায়",
            "start": 1701,
            "end": 1720
        },
        {
            "id": 11,
            "name": "হজ্জ অধ্যায়",
            "start": 1721,
            "end": 2045
        },
        {
            "id": 12,
            "name": "বিবাহ অধ্যায়",
            "start": 2046,
            "end": 2174
        },
        {
            "id": 13,
            "name": "তালাক অধ্যায়",
            "start": 2175,
            "end": 2312
        },
        {
            "id": 14,
            "name": "সওম (রোজা) অধ্যায়",
            "start": 2313,
            "end": 2476
        },
        {
            "id": 15,
            "name": "জিহাদ অধ্যায়",
            "start": 2477,
            "end": 2787
        },
        {
            "id": 16,
            "name": "কুরবানির নিয়ম-কানুন অধ্যায়",
            "start": 2788,
            "end": 2843
        },
        {
            "id": 17,
            "name": "শিকার প্রসঙ্গে অধ্যায়",
            "start": 2844,
            "end": 2861
        },
        {
            "id": 18,
            "name": "ওসিয়াত প্রসঙ্গে অধ্যায়",
            "start": 2862,
            "end": 2884
        },
        {
            "id": 19,
            "name": "ফারায়েজ (ওয়ারিসী স্বত্ব) অধ্যায়",
            "start": 2885,
            "end": 2927
        },
        {
            "id": 20,
            "name": "কর, ফাই ও প্রশাসক অধ্যায়",
            "start": 2928,
            "end": 3088
        },
        {
            "id": 21,
            "name": "জানাযা অধ্যায়",
            "start": 3089,
            "end": 3241
        },
        {
            "id": 22,
            "name": "শপথ ও মানত অধ্যায়",
            "start": 3242,
            "end": 3325
        },
        {
            "id": 23,
            "name": "ব্যবসা-বাণিজ্য অধ্যায়",
            "start": 3326,
            "end": 3415
        },
        {
            "id": 24,
            "name": "ইজারা (ভাড়া ও শ্রম বিক্রয়) অধ্যায়",
            "start": 3416,
            "end": 3570
        },
        {
            "id": 25,
            "name": "বিচার ব্যবস্থা অধ্যায়",
            "start": 3571,
            "end": 3640
        },
        {
            "id": 26,
            "name": "জ্ঞান অধ্যায়",
            "start": 3641,
            "end": 3668
        },
        {
            "id": 27,
            "name": "পানীয় দ্রব্য প্রসঙ্গে অধ্যায়",
            "start": 3669,
            "end": 3735
        },
        {
            "id": 28,
            "name": "খাদ্যদ্রব্য অধ্যায়",
            "start": 3736,
            "end": 3854
        },
        {
            "id": 29,
            "name": "চিকিৎসা অধ্যায়",
            "start": 3855,
            "end": 3903
        },
        {
            "id": 30,
            "name": "ভবিষ্যৎ কথন ও কুলক্ষণ-সুলক্ষণ অধ্যায়",
            "start": 3904,
            "end": 3925
        },
        {
            "id": 31,
            "name": "দাসত্বমুক্তি অধ্যায়",
            "start": 3926,
            "end": 3968
        },
        {
            "id": 32,
            "name": "কুরআনের কিরাআত ও পাঠের নিয়ম অধ্যায়",
            "start": 3969,
            "end": 4008
        },
        {
            "id": 33,
            "name": "গণ-গোসলখানা অধ্যায়",
            "start": 4009,
            "end": 4019
        },
        {
            "id": 34,
            "name": "পোশাক-পরিচ্ছেদ অধ্যায়",
            "start": 4020,
            "end": 4158
        },
        {
            "id": 35,
            "name": "চুল আঁচড়ানো অধ্যায়",
            "start": 4159,
            "end": 4213
        },
        {
            "id": 36,
            "name": "আংটি অধ্যায়",
            "start": 4214,
            "end": 4239
        },
        {
            "id": 37,
            "name": "ফিতনা ও বিপর্যয় অধ্যায়",
            "start": 4240,
            "end": 4278
        },
        {
            "id": 38,
            "name": "ইমাম মাহদি প্রসঙ্গে অধ্যায়",
            "start": 4279,
            "end": 4290
        },
        {
            "id": 39,
            "name": "যুদ্ধ-সংঘর্ষ অধ্যায়",
            "start": 4291,
            "end": 4350
        },
        {
            "id": 40,
            "name": "অপরাধ ও তার শাস্তি অধ্যায়",
            "start": 4351,
            "end": 4493
        },
        {
            "id": 41,
            "name": "রক্তমূল্য অধ্যায়",
            "start": 4494,
            "end": 4595
        },
        {
            "id": 42,
            "name": "সুন্নাহ অধ্যায়",
            "start": 4596,
            "end": 4772
        },
        {
            "id": 43,
            "name": "শিষ্টাচার অধ্যায়",
            "start": 4773,
            "end": 5274
        }
    ],
    "tirmidhi": [
        {
            "id": 1,
            "name": "পবিত্রতা অধ্যায়",
            "start": 1,
            "end": 148
        },
        {
            "id": 2,
            "name": "সালাত (নামায) অধ্যায়",
            "start": 149,
            "end": 451
        },
        {
            "id": 3,
            "name": "কিতাবুল বিতর (বিতর নামায) অধ্যায়",
            "start": 452,
            "end": 487
        },
        {
            "id": 4,
            "name": "কিতাবুল জুমা (জুমার নামায) অধ্যায়",
            "start": 488,
            "end": 616
        },
        {
            "id": 5,
            "name": "যাকাত অধ্যায়",
            "start": 617,
            "end": 681
        },
        {
            "id": 6,
            "name": "কিতাবুল সিয়াম (রোযা) অধ্যায়",
            "start": 682,
            "end": 808
        },
        {
            "id": 7,
            "name": "হজ্জ অধ্যায়",
            "start": 809,
            "end": 964
        },
        {
            "id": 8,
            "name": "জানাযা অধ্যায়",
            "start": 965,
            "end": 1079
        },
        {
            "id": 9,
            "name": "বিবাহ অধ্যায়",
            "start": 1080,
            "end": 1145
        },
        {
            "id": 10,
            "name": "শিশুর দুধপান অধ্যায়",
            "start": 1146,
            "end": 1174
        },
        {
            "id": 11,
            "name": "তালাক ও লিআন অধ্যায়",
            "start": 1175,
            "end": 1204
        },
        {
            "id": 12,
            "name": "ক্রয়-বিক্রয় ও ব্যবসা-বাণিজ্য অধ্যায়",
            "start": 1205,
            "end": 1321
        },
        {
            "id": 13,
            "name": "বিচার কার্য অধ্যায়",
            "start": 1322,
            "end": 1385
        },
        {
            "id": 14,
            "name": "দিয়াত বা রক্তপণ অধ্যায়",
            "start": 1386,
            "end": 1422
        },
        {
            "id": 15,
            "name": "হাদ্দ বা দন্ডবিধি অধ্যায়",
            "start": 1423,
            "end": 1463
        },
        {
            "id": 16,
            "name": "শিকার অধ্যায়",
            "start": 1464,
            "end": 1492
        },
        {
            "id": 17,
            "name": "কুরবানী অধ্যায়",
            "start": 1493,
            "end": 1523
        },
        {
            "id": 18,
            "name": "মানত ও শপথ অধ্যায়",
            "start": 1524,
            "end": 1547
        },
        {
            "id": 19,
            "name": "যুদ্ধাভিযান অধ্যায়",
            "start": 1548,
            "end": 1618
        },
        {
            "id": 20,
            "name": "জিহাদের ফজিলত অধ্যায়",
            "start": 1619,
            "end": 1669
        },
        {
            "id": 21,
            "name": "জিহাদ অধ্যায়",
            "start": 1670,
            "end": 1719
        },
        {
            "id": 22,
            "name": "পোশাক-পরিচ্ছদ অধ্যায়",
            "start": 1720,
            "end": 1787
        },
        {
            "id": 23,
            "name": "আহার ও খাদ্যদ্রব্য অধ্যায়",
            "start": 1788,
            "end": 1860
        },
        {
            "id": 24,
            "name": "পানপাত্র ও পানীয় অধ্যায়",
            "start": 1861,
            "end": 1896
        },
        {
            "id": 25,
            "name": "সদ্ব্যবহার ও পারস্পরিক সম্পর্ক বজায় রাখা অধ্যায়",
            "start": 1897,
            "end": 2035
        },
        {
            "id": 26,
            "name": "চিকিৎসা অধ্যায়",
            "start": 2036,
            "end": 2089
        },
        {
            "id": 27,
            "name": "ফারায়েজ অধ্যায়",
            "start": 2090,
            "end": 2115
        },
        {
            "id": 28,
            "name": "ওয়াসিয়াত অধ্যায়",
            "start": 2116,
            "end": 2124
        },
        {
            "id": 29,
            "name": "ওয়ালাআ ও হিবা অধ্যায়",
            "start": 2125,
            "end": 2132
        },
        {
            "id": 30,
            "name": "তাকদীর অধ্যায়",
            "start": 2133,
            "end": 2157
        },
        {
            "id": 31,
            "name": "কলহ ও বিপর্যয় অধ্যায়",
            "start": 2158,
            "end": 2269
        },
        {
            "id": 32,
            "name": "স্বপ্ন ও তার তাৎপর্য অধ্যায়",
            "start": 2270,
            "end": 2294
        },
        {
            "id": 33,
            "name": "সাক্ষ্য প্রদান অধ্যায়",
            "start": 2295,
            "end": 2303
        },
        {
            "id": 34,
            "name": "দুনিয়াবী ভোগবিলাসের প্রতি অনাসক্তি অধ্যায়",
            "start": 2304,
            "end": 2414
        },
        {
            "id": 35,
            "name": "কেয়ামত ও মর্মস্পর্শী বিষয় অধ্যায়",
            "start": 2415,
            "end": 2522
        },
        {
            "id": 36,
            "name": "জান্নাতের বিবরণ অধ্যায়",
            "start": 2523,
            "end": 2572
        },
        {
            "id": 37,
            "name": "জাহান্নামের বিবরণ অধ্যায়",
            "start": 2573,
            "end": 2605
        },
        {
            "id": 38,
            "name": "ঈমান অধ্যায়",
            "start": 2606,
            "end": 2644
        },
        {
            "id": 39,
            "name": "জ্ঞান অধ্যায়",
            "start": 2645,
            "end": 2687
        },
        {
            "id": 40,
            "name": "অনুমতি প্রার্থনা অধ্যায়",
            "start": 2688,
            "end": 2735
        },
        {
            "id": 41,
            "name": "শিষ্টাচার অধ্যায়",
            "start": 2736,
            "end": 2874
        },
        {
            "id": 42,
            "name": "কুরআনের ফজিলত অধ্যায়",
            "start": 2875,
            "end": 2926
        },
        {
            "id": 43,
            "name": "কিরাআত অধ্যায়",
            "start": 2927,
            "end": 2949
        },
        {
            "id": 44,
            "name": "তাফসীরুল কুরআন অধ্যায়",
            "start": 2950,
            "end": 3369
        },
        {
            "id": 45,
            "name": "দোয়া সমূহ অধ্যায়",
            "start": 3370,
            "end": 3604
        },
        {
            "id": 46,
            "name": "রাসূলুল্লাহ (ﷺ) ও তাঁর সাহাবীদের মর্যাদা অধ্যায়",
            "start": 3605,
            "end": 3956
        }
    ],
    "ibnmajah": [
        {
            "id": 0,
            "name": "ভূমিকা অধ্যায়",
            "start": 1,
            "end": 266
        },
        {
            "id": 1,
            "name": "পবিত্রতা ও তার সুন্নাতসমূহ অধ্যায়",
            "start": 267,
            "end": 666
        },
        {
            "id": 2,
            "name": "সালাত (নামায) অধ্যায়",
            "start": 667,
            "end": 705
        },
        {
            "id": 3,
            "name": "আযান ও তার সুন্নাত অধ্যায়",
            "start": 706,
            "end": 734
        },
        {
            "id": 4,
            "name": "মসজিদ ও জামাআত অধ্যায়",
            "start": 735,
            "end": 802
        },
        {
            "id": 5,
            "name": "সালাত আদায় করা ও তার নিয়ম কানুন অধ্যায়",
            "start": 803,
            "end": 1432
        },
        {
            "id": 6,
            "name": "জানাযাহ অধ্যায়",
            "start": 1433,
            "end": 1637
        },
        {
            "id": 7,
            "name": "সিয়াম বা রোজা অধ্যায়",
            "start": 1638,
            "end": 1782
        },
        {
            "id": 8,
            "name": "যাকাত অধ্যায়",
            "start": 1783,
            "end": 1844
        },
        {
            "id": 9,
            "name": "বিবাহ অধ্যায়",
            "start": 1845,
            "end": 2015
        },
        {
            "id": 10,
            "name": "তালাক অধ্যায়",
            "start": 2016,
            "end": 2089
        },
        {
            "id": 11,
            "name": "কাফফারা সমূহ অধ্যায়",
            "start": 2090,
            "end": 2136
        },
        {
            "id": 12,
            "name": "ব্যবসা-বাণিজ্য অধ্যায়",
            "start": 2137,
            "end": 2307
        },
        {
            "id": 13,
            "name": "বিচার ও বিধান অধ্যায়",
            "start": 2308,
            "end": 2374
        },
        {
            "id": 14,
            "name": "হেবা অধ্যায়",
            "start": 2375,
            "end": 2389
        },
        {
            "id": 15,
            "name": "দান খয়রাত অধ্যায়",
            "start": 2390,
            "end": 2435
        },
        {
            "id": 16,
            "name": "বন্ধক অধ্যায়",
            "start": 2436,
            "end": 2491
        },
        {
            "id": 17,
            "name": "অগ্র-ক্রয়াধিকার অধ্যায়",
            "start": 2492,
            "end": 2501
        },
        {
            "id": 18,
            "name": "হারানো প্রাপ্তি অধ্যায়",
            "start": 2502,
            "end": 2511
        },
        {
            "id": 19,
            "name": "দাসমুক্তি অধ্যায়",
            "start": 2512,
            "end": 2532
        },
        {
            "id": 20,
            "name": "হদ্দ (দণ্ড) অধ্যায়",
            "start": 2533,
            "end": 2614
        },
        {
            "id": 21,
            "name": "রক্তপণ অধ্যায়",
            "start": 2615,
            "end": 2694
        },
        {
            "id": 22,
            "name": "ওসিয়ত অধ্যায়",
            "start": 2695,
            "end": 2718
        },
        {
            "id": 23,
            "name": "ওয়ারিসী স্বত্ব বণ্টন অধ্যায়",
            "start": 2719,
            "end": 2752
        },
        {
            "id": 24,
            "name": "জিহাদ অধ্যায়",
            "start": 2753,
            "end": 2881
        },
        {
            "id": 25,
            "name": "হজ্জ অধ্যায়",
            "start": 2882,
            "end": 3119
        },
        {
            "id": 26,
            "name": "কোরবানি অধ্যায়",
            "start": 3120,
            "end": 3161
        },
        {
            "id": 27,
            "name": "যবেহ করা অধ্যায়",
            "start": 3162,
            "end": 3199
        },
        {
            "id": 28,
            "name": "শিকার অধ্যায়",
            "start": 3200,
            "end": 3250
        },
        {
            "id": 29,
            "name": "আহার ও তার শিষ্টাচার অধ্যায়",
            "start": 3251,
            "end": 3370
        },
        {
            "id": 30,
            "name": "পানীয় ও পানপাত্র অধ্যায়",
            "start": 3371,
            "end": 3435
        },
        {
            "id": 31,
            "name": "চিকিৎসা অধ্যায়",
            "start": 3436,
            "end": 3549
        },
        {
            "id": 32,
            "name": "পোশাক-পরিচ্ছেদ অধ্যায়",
            "start": 3550,
            "end": 3656
        },
        {
            "id": 33,
            "name": "শিষ্টাচার অধ্যায়",
            "start": 3657,
            "end": 3826
        },
        {
            "id": 34,
            "name": "দুআ অধ্যায়",
            "start": 3827,
            "end": 3892
        },
        {
            "id": 35,
            "name": "স্বপ্নের ব্যাখ্যা অধ্যায়",
            "start": 3893,
            "end": 3926
        },
        {
            "id": 36,
            "name": "কলহ-বিপর্যয় অধ্যায়",
            "start": 3927,
            "end": 4099
        },
        {
            "id": 37,
            "name": "পার্থিব ভোগবিলাসের প্রতি অনাসক্তি অধ্যায়",
            "start": 4100,
            "end": 4341
        }
    ],
    "malik": [
        {
            "id": 1,
            "name": "নামাযের সময় অধ্যায়",
            "start": 1,
            "end": 30
        },
        {
            "id": 2,
            "name": "পবিত্রতা অর্জন অধ্যায়",
            "start": 31,
            "end": 145
        },
        {
            "id": 3,
            "name": "নামায অধ্যায়",
            "start": 146,
            "end": 215
        },
        {
            "id": 4,
            "name": "নামাযের ভুলভ্রান্তি অধ্যায়",
            "start": 216,
            "end": 218
        },
        {
            "id": 5,
            "name": "জুম’আ অধ্যায়",
            "start": 219,
            "end": 239
        },
        {
            "id": 6,
            "name": "রমাযানের নামায অধ্যায়",
            "start": 240,
            "end": 246
        },
        {
            "id": 7,
            "name": "রাত্রে নফল নামায অধ্যায়",
            "start": 247,
            "end": 279
        },
        {
            "id": 8,
            "name": "জামা’আতে নামায আদায় করা অধ্যায়",
            "start": 280,
            "end": 317
        },
        {
            "id": 9,
            "name": "সফরে নামায কসর আদায় করা অধ্যায়",
            "start": 318,
            "end": 412
        },
        {
            "id": 10,
            "name": "দুই ঈদ অধ্যায়",
            "start": 413,
            "end": 425
        },
        {
            "id": 11,
            "name": "সালাতুল-খাওফ অধ্যায়",
            "start": 426,
            "end": 429
        },
        {
            "id": 12,
            "name": "সালাতুল-কুসূফ অধ্যায়",
            "start": 430,
            "end": 433
        },
        {
            "id": 13,
            "name": "বৃষ্টি প্রার্থনা অধ্যায়",
            "start": 434,
            "end": 439
        },
        {
            "id": 14,
            "name": "কিবলা অধ্যায়",
            "start": 440,
            "end": 453
        },
        {
            "id": 15,
            "name": "কুরআন অধ্যায়",
            "start": 454,
            "end": 503
        },
        {
            "id": 16,
            "name": "জানাইয অধ্যায়",
            "start": 504,
            "end": 559
        },
        {
            "id": 17,
            "name": "যাকাত অধ্যায়",
            "start": 560,
            "end": 615
        },
        {
            "id": 18,
            "name": "রোযা অধ্যায়",
            "start": 616,
            "end": 675
        },
        {
            "id": 19,
            "name": "ই’তিকাফ অধ্যায়",
            "start": 676,
            "end": 691
        },
        {
            "id": 20,
            "name": "হজ্জ অধ্যায়",
            "start": 692,
            "end": 949
        },
        {
            "id": 21,
            "name": "জিহাদ সম্পর্কিত অধ্যায়",
            "start": 950,
            "end": 1000
        },
        {
            "id": 22,
            "name": "মানত ও কসম সম্পর্কিত অধ্যায়",
            "start": 1001,
            "end": 1017
        },
        {
            "id": 23,
            "name": "কুরবানী সম্পর্কিত অধ্যায়",
            "start": 1018,
            "end": 1030
        },
        {
            "id": 24,
            "name": "যবেহ সম্পর্কিত অধ্যায়",
            "start": 1031,
            "end": 1039
        },
        {
            "id": 25,
            "name": "শিকার সম্পর্কীত অধ্যায়",
            "start": 1040,
            "end": 1058
        },
        {
            "id": 26,
            "name": "আকীকা সম্পর্কিত অধ্যায়",
            "start": 1059,
            "end": 1065
        },
        {
            "id": 27,
            "name": "ফারায়েয অধ্যায়",
            "start": 1066,
            "end": 1081
        },
        {
            "id": 28,
            "name": "বিবাহ অধ্যায়",
            "start": 1082,
            "end": 1138
        },
        {
            "id": 29,
            "name": "তালাক অধ্যায়",
            "start": 1139,
            "end": 1247
        },
        {
            "id": 30,
            "name": "সন্তানের দুধ পান করানোর বিধান অধ্যায়",
            "start": 1248,
            "end": 1264
        },
        {
            "id": 31,
            "name": "ক্রয়-বিক্রয় সংক্রান্ত অধ্যায়",
            "start": 1265,
            "end": 1367
        },
        {
            "id": 32,
            "name": "শরীকী কারবার করা অধ্যায়",
            "start": 1368,
            "end": 1383
        },
        {
            "id": 33,
            "name": "শরীকানায় ফলের বাগানে উৎপাদন বিষয়ক অধ্যায়",
            "start": 1384,
            "end": 1386
        },
        {
            "id": 34,
            "name": "জমি (কেয়ারা) ভাড়া দেয়ার অধ্যায়",
            "start": 1387,
            "end": 1391
        },
        {
            "id": 35,
            "name": "শুফ্’আ অধ্যায়",
            "start": 1392,
            "end": 1395
        },
        {
            "id": 36,
            "name": "বিচার সম্পর্কিত অধ্যায়",
            "start": 1396,
            "end": 1449
        },
        {
            "id": 37,
            "name": "ওসীয়্যত সম্পর্কিত অধ্যায়",
            "start": 1450,
            "end": 1458
        },
        {
            "id": 38,
            "name": "গোলাম আযাদ করা এবং স্বত্বাধিকার অধ্যায়",
            "start": 1459,
            "end": 1483
        },
        {
            "id": 39,
            "name": "ক্রীতদাস আযাদীর জন্য অর্থ প্রদান করার চুক্তি করার অধ্যায়",
            "start": 1484,
            "end": 1498
        },
        {
            "id": 40,
            "name": "মুদাব্বার অধ্যায়",
            "start": 1499,
            "end": 1506
        },
        {
            "id": 41,
            "name": "হুদুদের অধ্যায়",
            "start": 1507,
            "end": 1540
        },
        {
            "id": 42,
            "name": "শরাবের বর্ণনা অধ্যায়",
            "start": 1541,
            "end": 1555
        },
        {
            "id": 43,
            "name": "দিয়াত অধ্যায়",
            "start": 1556,
            "end": 1571
        },
        {
            "id": 44,
            "name": "কাসামত বা কসম নেয়া অধ্যায়",
            "start": 1572,
            "end": 1573
        },
        {
            "id": 45,
            "name": "বিভিন্ন প্রকারের মাস‘আলা সম্বলিত অধ্যায়",
            "start": 1574,
            "end": 1599
        },
        {
            "id": 46,
            "name": "তকদীর অধ্যায়",
            "start": 1600,
            "end": 1609
        },
        {
            "id": 47,
            "name": "সৎস্বভাব বিষয়ক অধ্যায়",
            "start": 1610,
            "end": 1627
        },
        {
            "id": 48,
            "name": "পোশাক-পরিচ্ছদ অধ্যায়",
            "start": 1628,
            "end": 1646
        },
        {
            "id": 49,
            "name": "রসূলুল্লাহ্ সল্লাল্লাহু আলাইহি ওয়াসাল্লাম-এর দৈহিক গঠন সম্পর্কে অধ্যায়",
            "start": 1647,
            "end": 1685
        },
        {
            "id": 50,
            "name": "বদনজর সংক্রান্ত অধ্যায়",
            "start": 1686,
            "end": 1703
        },
        {
            "id": 51,
            "name": "চুল বিষয়ক অধ্যায়",
            "start": 1704,
            "end": 1720
        },
        {
            "id": 52,
            "name": "স্বপ্ন সম্পর্কিত অধ্যায়",
            "start": 1721,
            "end": 1727
        },
        {
            "id": 53,
            "name": "সালাম সম্পর্কিত অধ্যায়",
            "start": 1728,
            "end": 1735
        },
        {
            "id": 54,
            "name": "ঘরে প্রবেশ করার অনুমতি গ্রহণ বিষয়ক অধ্যায়",
            "start": 1736,
            "end": 1779
        },
        {
            "id": 55,
            "name": "বায়‘আত অধ্যায়",
            "start": 1780,
            "end": 1782
        },
        {
            "id": 56,
            "name": "কথাবার্তা সম্পর্কিত অধ্যায়",
            "start": 1783,
            "end": 1810
        },
        {
            "id": 57,
            "name": "জাহান্নাম অধ্যায়",
            "start": 1811,
            "end": 1812
        },
        {
            "id": 58,
            "name": "সাদাকাহ্ সম্পর্কিত অধ্যায়",
            "start": 1813,
            "end": 1827
        },
        {
            "id": 59,
            "name": "ইলম অধ্যায়",
            "start": 1828,
            "end": 1828
        },
        {
            "id": 60,
            "name": "মযলুমের বদ দু‘আ অধ্যায়",
            "start": 1829,
            "end": 1829
        },
        {
            "id": 61,
            "name": "নবী সাল্লাল্লাহু ‘আলাইহি ওয়া সাল্লাম-এর পবিত্র নামসমূহ অধ্যায়",
            "start": 1830,
            "end": 1830
        }
    ],
    "riyadussalihin": [
        {
            "id": 1,
            "name": "বিবিধ অধ্যায়",
            "start": 1,
            "end": 685
        },
        {
            "id": 2,
            "name": "শিষ্টাচার অধ্যায়",
            "start": 686,
            "end": 731
        },
        {
            "id": 3,
            "name": "পানাহারের আদব-কায়দা অধ্যায়",
            "start": 732,
            "end": 782
        },
        {
            "id": 4,
            "name": "পোষাক-পরিচছদ অধ্যায়",
            "start": 783,
            "end": 817
        },
        {
            "id": 5,
            "name": "নিদ্রার আদব অধ্যায়",
            "start": 818,
            "end": 848
        },
        {
            "id": 6,
            "name": "সালামের আদব অধ্যায়",
            "start": 849,
            "end": 898
        },
        {
            "id": 7,
            "name": "রোগীদর্শন ও জানাযায় অংশগ্রহণ অধ্যায়",
            "start": 899,
            "end": 962
        },
        {
            "id": 8,
            "name": "সফরের আদব-কায়দা অধ্যায়",
            "start": 963,
            "end": 997
        },
        {
            "id": 9,
            "name": "বিভিন্ন নেক আমলের ফযীলত প্রসঙ্গে অধ্যায়",
            "start": 998,
            "end": 1275
        },
        {
            "id": 10,
            "name": "ই‘তিকাফ অধ্যায়",
            "start": 1276,
            "end": 1278
        },
        {
            "id": 11,
            "name": "(কা‘বাগৃহের) হজ্জ পালন অধ্যায়",
            "start": 1279,
            "end": 1292
        },
        {
            "id": 12,
            "name": "(আল্লাহর পথে) জিহাদ অধ্যায়",
            "start": 1293,
            "end": 1383
        },
        {
            "id": 13,
            "name": "ইলম (জ্ঞান ও শিক্ষা) বিষয়ক অধ্যায়",
            "start": 1384,
            "end": 1400
        },
        {
            "id": 14,
            "name": "মহান আল্লাহর প্রশংসা ও তাঁর কৃতজ্ঞতা স্বীকার অধ্যায়",
            "start": 1401,
            "end": 1404
        },
        {
            "id": 15,
            "name": "রাসূলুল্লাহ ﷺ এর উপর দরূদ ও সালাম প্রসঙ্গে অধ্যায়",
            "start": 1405,
            "end": 1415
        },
        {
            "id": 16,
            "name": "যিকির-আযকার প্রসঙ্গে অধ্যায়",
            "start": 1416,
            "end": 1472
        },
        {
            "id": 17,
            "name": "(প্রার্থনামূলক) দো‘আসমূহ অধ্যায়",
            "start": 1473,
            "end": 1518
        },
        {
            "id": 18,
            "name": "নিষিদ্ধ বিষয়াবলী অধ্যায়",
            "start": 1519,
            "end": 1816
        },
        {
            "id": 19,
            "name": "বিবিধ চিত্তকর্ষী হাদিসসমূহ অধ্যায়",
            "start": 1817,
            "end": 1877
        },
        {
            "id": 20,
            "name": "ক্ষমাপ্রার্থনামূলক নির্দেশাবলী অধ্যায়",
            "start": 1878,
            "end": 1905
        }
    ],
    "bulughulmaram": [
        {
            "id": 1,
            "name": "পবিত্রতা অধ্যায়",
            "start": 1,
            "end": 150
        },
        {
            "id": 2,
            "name": "সালাত অধ্যায়",
            "start": 151,
            "end": 533
        },
        {
            "id": 3,
            "name": "জানাযা অধ্যায়",
            "start": 534,
            "end": 598
        },
        {
            "id": 4,
            "name": "যাকাত অধ্যায়",
            "start": 599,
            "end": 649
        },
        {
            "id": 5,
            "name": "সিয়াম অধ্যায়",
            "start": 650,
            "end": 707
        },
        {
            "id": 6,
            "name": "হাজ্জ অধ্যায়",
            "start": 708,
            "end": 781
        },
        {
            "id": 7,
            "name": "ক্ৰয়-বিক্রয়ের বিধান অধ্যায়",
            "start": 782,
            "end": 966
        },
        {
            "id": 8,
            "name": "বিবাহ অধ্যায়",
            "start": 967,
            "end": 1157
        },
        {
            "id": 9,
            "name": "অপরাধ প্রসঙ্গ অধ্যায়",
            "start": 1158,
            "end": 1204
        },
        {
            "id": 10,
            "name": "দণ্ড বিধি অধ্যায়",
            "start": 1205,
            "end": 1258
        },
        {
            "id": 11,
            "name": "জিহাদ অধ্যায়",
            "start": 1259,
            "end": 1318
        },
        {
            "id": 12,
            "name": "খাদ্য অধ্যায়",
            "start": 1319,
            "end": 1359
        },
        {
            "id": 13,
            "name": "কসম ও মান্নত প্রসঙ্গ অধ্যায়",
            "start": 1360,
            "end": 1382
        },
        {
            "id": 14,
            "name": "বিচার-ফায়সালা অধ্যায়",
            "start": 1383,
            "end": 1417
        },
        {
            "id": 15,
            "name": "দাস-দাসী মুক্ত করা অধ্যায়",
            "start": 1418,
            "end": 1436
        },
        {
            "id": 16,
            "name": "বিবিধ প্রসঙ্গ অধ্যায়",
            "start": 1437,
            "end": 1568
        }
    ],
    "luluwalmarjan": [
        {
            "id": 0,
            "name": "বিবিধ অধ্যায়",
            "start": 1,
            "end": 4
        },
        {
            "id": 1,
            "name": "ঈমান অধ্যায়",
            "start": 5,
            "end": 133
        },
        {
            "id": 2,
            "name": "পবিত্রতা অধ্যায়",
            "start": 134,
            "end": 167
        },
        {
            "id": 3,
            "name": "হায়িয অধ্যায়",
            "start": 168,
            "end": 212
        },
        {
            "id": 4,
            "name": "সালাত অধ্যায়",
            "start": 213,
            "end": 297
        },
        {
            "id": 5,
            "name": "মসজিদ ও সালাতের স্থানসমূহের বর্ণনা অধ্যায়",
            "start": 298,
            "end": 397
        },
        {
            "id": 6,
            "name": "মুসাফির ব্যক্তির সালাত ও তা কসর করার বর্ণনা অধ্যায়",
            "start": 398,
            "end": 484
        },
        {
            "id": 7,
            "name": "জুমার বর্ণনা অধ্যায়",
            "start": 485,
            "end": 504
        },
        {
            "id": 8,
            "name": "ঈদাইন বা দুই ঈদের সালাত অধ্যায়",
            "start": 505,
            "end": 514
        },
        {
            "id": 9,
            "name": "পানি প্রার্থনার সালাত অধ্যায়",
            "start": 515,
            "end": 519
        },
        {
            "id": 10,
            "name": "সূর্য গ্রহণের সালাত অধ্যায়",
            "start": 520,
            "end": 530
        },
        {
            "id": 11,
            "name": "জানাজা অধ্যায়",
            "start": 531,
            "end": 566
        },
        {
            "id": 12,
            "name": "যাকাত অধ্যায়",
            "start": 567,
            "end": 651
        },
        {
            "id": 13,
            "name": "সাওম (রোজা) অধ্যায়",
            "start": 652,
            "end": 726
        },
        {
            "id": 14,
            "name": "ইতিকাফ অধ্যায়",
            "start": 727,
            "end": 730
        },
        {
            "id": 15,
            "name": "হজ্জ অধ্যায়",
            "start": 731,
            "end": 883
        },
        {
            "id": 16,
            "name": "নিকাহ (বিবাহ) অধ্যায়",
            "start": 884,
            "end": 915
        },
        {
            "id": 17,
            "name": "দুগ্ধপান অধ্যায়",
            "start": 916,
            "end": 935
        },
        {
            "id": 18,
            "name": "তালাক অধ্যায়",
            "start": 936,
            "end": 951
        },
        {
            "id": 19,
            "name": "লিআন অধ্যায়",
            "start": 952,
            "end": 957
        },
        {
            "id": 20,
            "name": "ইতক (মুক্তি) অধ্যায়",
            "start": 958,
            "end": 964
        },
        {
            "id": 21,
            "name": "ক্রয়-বিক্রয় অধ্যায়",
            "start": 965,
            "end": 998
        },
        {
            "id": 22,
            "name": "পানি সিঞ্চন অধ্যায়",
            "start": 999,
            "end": 1040
        },
        {
            "id": 23,
            "name": "ফরায়েজ অধ্যায়",
            "start": 1041,
            "end": 1044
        },
        {
            "id": 24,
            "name": "হেবা অধ্যায়",
            "start": 1045,
            "end": 1051
        },
        {
            "id": 25,
            "name": "অসিয়াত অধ্যায়",
            "start": 1052,
            "end": 1060
        },
        {
            "id": 26,
            "name": "নাযর অধ্যায়",
            "start": 1061,
            "end": 1065
        },
        {
            "id": 27,
            "name": "কসম অধ্যায়",
            "start": 1066,
            "end": 1084
        },
        {
            "id": 28,
            "name": "কাসামাহ অধ্যায়",
            "start": 1085,
            "end": 1096
        },
        {
            "id": 29,
            "name": "হুদুদ অধ্যায়",
            "start": 1097,
            "end": 1112
        },
        {
            "id": 30,
            "name": "বিচার-ফায়সালা অধ্যায়",
            "start": 1113,
            "end": 1122
        },
        {
            "id": 31,
            "name": "কুড়িয়ে পাওয়া বস্তু অধ্যায়",
            "start": 1123,
            "end": 1128
        },
        {
            "id": 32,
            "name": "জিহাদ অধ্যায়",
            "start": 1129,
            "end": 1192
        },
        {
            "id": 33,
            "name": "ইমারাত বা নেতৃত্ব অধ্যায়",
            "start": 1193,
            "end": 1253
        },
        {
            "id": 34,
            "name": "শিকার, যবহ ও কোন প্রকার জন্তু খাওয়া যায় অধ্যায়",
            "start": 1254,
            "end": 1279
        },
        {
            "id": 35,
            "name": "কুরবানি অধ্যায়",
            "start": 1280,
            "end": 1291
        },
        {
            "id": 36,
            "name": "পানীয় অধ্যায়",
            "start": 1292,
            "end": 1336
        },
        {
            "id": 37,
            "name": "পোশাক ও অলঙ্কার অধ্যায়",
            "start": 1337,
            "end": 1379
        },
        {
            "id": 38,
            "name": "আচার-ব্যবহার অধ্যায়",
            "start": 1380,
            "end": 1395
        },
        {
            "id": 39,
            "name": "সালাম অধ্যায়",
            "start": 1396,
            "end": 1448
        },
        {
            "id": 40,
            "name": "সৌজন্যমূলক কথা বলা ইত্যাদি অধ্যায়",
            "start": 1449,
            "end": 1453
        },
        {
            "id": 41,
            "name": "কবিতা অধ্যায়",
            "start": 1454,
            "end": 1455
        },
        {
            "id": 42,
            "name": "স্বপ্ন অধ্যায়",
            "start": 1456,
            "end": 1467
        },
        {
            "id": 43,
            "name": "ফাযায়েল অধ্যায়",
            "start": 1468,
            "end": 1539
        },
        {
            "id": 44,
            "name": "সাহাবীদের মর্যাদা অধ্যায়",
            "start": 1540,
            "end": 1651
        },
        {
            "id": 45,
            "name": "সদাচরণ, আত্মীয়তার সম্পর্ক ও শিষ্টাচার অধ্যায়",
            "start": 1652,
            "end": 1694
        },
        {
            "id": 46,
            "name": "ক্বাদর বা ভাগ্য অধ্যায়",
            "start": 1695,
            "end": 1704
        },
        {
            "id": 47,
            "name": "ইলম (জ্ঞান ও শিক্ষা) বিষয়ক অধ্যায়",
            "start": 1705,
            "end": 1712
        },
        {
            "id": 48,
            "name": "যিকর আজকার, দোয়া, তাওবাহ এবং ক্ষমা প্রার্থনা অধ্যায়",
            "start": 1713,
            "end": 1745
        },
        {
            "id": 49,
            "name": "তাওবাহ অধ্যায়",
            "start": 1746,
            "end": 1764
        },
        {
            "id": 50,
            "name": "মুনাফিক ও তাদের হুকুম অধ্যায়",
            "start": 1765,
            "end": 1796
        },
        {
            "id": 51,
            "name": "জান্নাত, তার বিবরণ, আনন্দ-উপভোগ ও তার বাসিন্দা অধ্যায়",
            "start": 1797,
            "end": 1828
        },
        {
            "id": 52,
            "name": "ফিতনা এবং তার অশুভ আলামতসমূহ অধ্যায়",
            "start": 1829,
            "end": 1864
        },
        {
            "id": 53,
            "name": "সংসারের প্রতি অনাসক্তি ও অন্তরের কোমলতা অধ্যায়",
            "start": 1865,
            "end": 1892
        },
        {
            "id": 54,
            "name": "তাফসীর অধ্যায়",
            "start": 1893,
            "end": 1906
        }
    ]
};

    function getBookChapters(bookId) {
        const bookObj = pageHadithBookList.find(b => b.id === bookId) || { total: 1000 };
        const totalHadith = bookObj.total;
        const chapters = [];
        let currentEnd = 0;
        let chapId = 1;

        if (knownChapters[bookId]) {
            knownChapters[bookId].forEach(c => {
                chapters.push(c);
                currentEnd = c.end;
                chapId = c.id + 1;
            });
        }

        const step = 100;
        for (let s = currentEnd + 1; s <= totalHadith; s += step) {
            const e = Math.min(s + step - 1, totalHadith);
            chapters.push({
                id: chapId,
                name: `অধ্যায় ${toBnNum(chapId)} (হাদিস ${toBnNum(s)} - ${toBnNum(e)})`,
                start: s,
                end: e
            });
            chapId++;
        }

        return chapters;
    }

    function renderPageHadithSidebar(filterQuery = "") {
        const sidebar = document.getElementById("pageHadithSidebarBookList");
        if (!sidebar) return;

        if (currentSidebarTab === "book") {
            const filtered = pageHadithBookList.filter(b => 
                b.name.toLowerCase().includes(filterQuery.toLowerCase()) ||
                b.en.toLowerCase().includes(filterQuery.toLowerCase())
            );

            sidebar.innerHTML = filtered.map(b => {
                const isActive = b.id === pageCurrentHadithBook;
                return `
                    <div onclick="selectPageHadithBook('${b.id}')" style="padding: 12px 14px; border-radius: 12px; margin-bottom: 6px; cursor: pointer; display: flex; align-items: center; gap: 12px; background: ${isActive ? 'rgba(16, 185, 129, 0.22)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if('${b.id}' !== pageCurrentHadithBook) this.style.background='rgba(255,255,255,0.06)'" onmouseout="if('${b.id}' !== pageCurrentHadithBook) this.style.background='transparent'">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: ${b.color}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.95rem; flex-shrink: 0;">
                            ${b.code}
                        </div>
                        <div style="overflow: hidden;">
                            <div style="font-weight: 800; font-size: 0.95rem; color: ${isActive ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.name}</div>
                            <div style="font-size: 0.78rem; color: #a7f3d0;">মোট হাদিস ${toBnNum(b.total)}টি (অধ্যায় দেখুন &rarr;)</div>
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            const chapters = getBookChapters(pageCurrentHadithBook);
            const filteredChapters = chapters.filter(c => c.name.toLowerCase().includes(filterQuery.toLowerCase()));
            const activeBookObj = pageHadithBookList.find(b => b.id === pageCurrentHadithBook) || { name: "হাদিস গ্রন্থ" };

            let headerHtml = `
                <div style="padding: 10px 12px; background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-weight: 800; font-size: 0.9rem; color: #34d399;">${activeBookObj.name} (অধ্যায়সমূহ)</div>
                    <button onclick="switchSidebarTab('book')" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;" title="হাদিস গ্রন্থ পরিবর্তন করুন">বই বদলান</button>
                </div>
            `;

            if (filteredChapters.length === 0) {
                sidebar.innerHTML = headerHtml + `
                    <div style="text-align: center; padding: 40px 10px; color: #a7f3d0; font-size: 0.9rem;">
                        <i class="fas fa-list-check" style="font-size: 1.8rem; color: #10b981; margin-bottom: 10px; display: block;"></i>
                        কোনো অধ্যায় পাওয়া যায়নি
                    </div>
                `;
                return;
            }

            sidebar.innerHTML = headerHtml + filteredChapters.map(c => {
                const isCurrentRange = pageCurrentHadithNum >= c.start && pageCurrentHadithNum <= c.end;
                return `
                    <div onclick="selectHadithChapter(${c.start}, ${c.end}, '${c.name.replace(/'/g, "\\'")}')" style="padding: 12px 14px; border-radius: 12px; margin-bottom: 6px; cursor: pointer; display: flex; align-items: center; gap: 12px; background: ${isCurrentRange ? 'rgba(16, 185, 129, 0.22)' : 'transparent'}; border: ${isCurrentRange ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(!${isCurrentRange}) this.style.background='rgba(255,255,255,0.06)'" onmouseout="if(!${isCurrentRange}) this.style.background='transparent'">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(16, 185, 129, 0.25); color: #34d399; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0;">
                            ${toBnNum(c.id)}
                        </div>
                        <div style="overflow: hidden;">
                            <div style="font-weight: 800; font-size: 0.92rem; color: ${isCurrentRange ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${c.name}</div>
                            <div style="font-size: 0.78rem; color: #a7f3d0;">হাদিস ${toBnNum(c.start)} থেকে ${toBnNum(c.end)}</div>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    function selectHadithChapter(startNum, endNum, chapterName) {
        pageCurrentHadithNum = startNum;
        switchSidebarTab('chapter');

        const body = document.getElementById("pageHadithContentCard");
        const bookObj = pageHadithBookList.find(b => b.id === pageCurrentHadithBook) || { name: pageCurrentHadithBook, total: 100 };

        if (!body) return;

        body.innerHTML = `
            <div style="text-align: center; padding: 60px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #10b981;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">${chapterName || 'অধ্যায়ের'} (হাদিস ${toBnNum(startNum)} - ${toBnNum(endNum)}) লোড হচ্ছে...</div>
            </div>
        `;

        const count = endNum - startNum + 1;
        const dbKey = bookDbKeyMap[pageCurrentHadithBook] || ('ben-' + pageCurrentHadithBook);

        // Fetch strictly by Hadith number range (startNum to endNum)
        const dbUrl = `<?= URLROOT ?>/api/hadith/list?book=${encodeURIComponent(dbKey)}&start_num=${startNum}&end_num=${endNum}&limit=${Math.max(count, 1000)}`;

        fetch(dbUrl).then(async res => {
            if (!res.ok) throw new Error('DB fetch failed');
            const data = await res.json();
            
            if (data.success && data.hadiths && data.hadiths.length > 0) {
                const results = data.hadiths.map(h => ({
                    num: h.num,
                    ben: h.text_bn,
                    eng: null,
                    ara: h.text_ar || null
                }));
                renderPageHadithChapterList(results, bookObj, 0, chapterName || (`হাদিস ${toBnNum(startNum)} - ${toBnNum(endNum)}`));
                return;
            }
            renderPageFallbackHadithCard(bookObj.name, startNum);
        }).catch(() => {
            renderPageFallbackHadithCard(bookObj.name, startNum);
        });
    }

    function filterPageHadithSidebar() {
        const q = (document.getElementById("pageHadithBookSearch").value || "").trim();
        renderPageHadithSidebar(q);
    }

    function renderMainHadithChapters(bookId) {
        pageCurrentHadithBook = bookId;
        const body = document.getElementById("pageHadithContentCard");
        const bookObj = pageHadithBookList.find(b => b.id === bookId) || { name: "হাদিস গ্রন্থ", total: 0 };
        const chapters = getBookChapters(bookId);

        if (!body) return;

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 22px 26px; border-radius: 18px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 16px; margin-bottom: 18px;">
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 900; color: #ffffff; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-book-journal-whills" style="color: #10b981;"></i> ${bookObj.name}
                        </div>
                        <div style="font-size: 0.9rem; color: #a7f3d0; margin-top: 4px;">
                            মোট অধ্যায়: <strong style="color: #34d399;">${toBnNum(chapters.length)}টি</strong> | মোট হাদিস: <strong style="color: #34d399;">${toBnNum(bookObj.total)}টি</strong>
                        </div>
                    </div>
                    <div style="font-size: 0.85rem; background: rgba(16,185,129,0.18); color: #34d399; padding: 6px 14px; border-radius: 20px; border: 1px solid rgba(16,185,129,0.3); font-weight: 700;">
                        পছন্দের অধ্যায় নির্বাচন করুন
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px; margin-top: 10px;">
                    ${chapters.map(c => `
                        <div onclick="selectHadithChapter(${c.start}, ${c.end}, '${c.name.replace(/'/g, "\\'")}')" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(16,185,129,0.25); padding: 16px; border-radius: 14px; cursor: pointer; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(16,185,129,0.18)'; this.style.borderColor='#10b981'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(0,0,0,0.25)'; this.style.borderColor='rgba(16,185,129,0.25)'; this.style.transform='translateY(0)';">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(16,185,129,0.3);">
                                    ${toBnNum(c.id)}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 800; font-size: 0.98rem; color: #ffffff; margin-bottom: 4px; line-height: 1.4;">${c.name}</div>
                                    <div style="font-size: 0.8rem; color: #a7f3d0; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-list-ol" style="color: #10b981; font-size: 0.75rem;"></i> হাদিস ${toBnNum(c.start)} থেকে ${toBnNum(c.end)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    function renderMainHadithChaptersFromDB(bookId, dbChapters) {
        pageCurrentHadithBook = bookId;
        const body = document.getElementById("pageHadithContentCard");
        const bookObj = pageHadithBookList.find(b => b.id === bookId) || { name: "হাদিস গ্রন্থ", total: 0 };

        if (!body) return;

        const totalHadiths = dbChapters.reduce((s, c) => s + c.hadith_count, 0);

        // Map chapter names to Bangla if possible
        const bookKnown = knownChapters[bookId] || [];

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 22px 26px; border-radius: 18px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 16px; margin-bottom: 18px;">
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 900; color: #ffffff; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-book-journal-whills" style="color: #10b981;"></i> ${bookObj.name}
                            <span style="font-size: 0.75rem; background: rgba(16,185,129,0.3); color: #34d399; padding: 3px 10px; border-radius: 12px; font-weight: 700;">
                                <i class="fas fa-database" style="margin-right: 4px;"></i> ডেটাবেজ থেকে
                            </span>
                        </div>
                        <div style="font-size: 0.9rem; color: #a7f3d0; margin-top: 4px;">
                            মোট অধ্যায়: <strong style="color: #34d399;">${toBnNum(dbChapters.length)}টি</strong> | মোট হাদিস: <strong style="color: #34d399;">${toBnNum(totalHadiths)}টি</strong>
                        </div>
                    </div>
                    <div style="font-size: 0.85rem; background: rgba(16,185,129,0.18); color: #34d399; padding: 6px 14px; border-radius: 20px; border: 1px solid rgba(16,185,129,0.3); font-weight: 700;">
                        পছন্দের অধ্যায় নির্বাচন করুন
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px; margin-top: 10px;">
                    ${dbChapters.map((c, idx) => {
                        const matchedKnown = bookKnown.find(k => k.id === c.num);
                        let chapTitle = matchedKnown ? matchedKnown.name : c.name;
                        // If title is missing or pure English, generate clean Bangla fallback
                        if (!chapTitle || /^[A-Za-z0-9\s\-_'()]+$/.test(chapTitle)) {
                            chapTitle = 'অধ্যায় ' + toBnNum(c.num);
                        }
                        return `
                        <div onclick="selectHadithChapterFromDB('${bookId}', ${c.num})" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(16,185,129,0.25); padding: 16px; border-radius: 14px; cursor: pointer; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(16,185,129,0.18)'; this.style.borderColor='#10b981'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(0,0,0,0.25)'; this.style.borderColor='rgba(16,185,129,0.25)'; this.style.transform='translateY(0)';">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(16,185,129,0.3);">
                                    ${toBnNum(idx + 1)}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 800; font-size: 0.98rem; color: #ffffff; margin-bottom: 4px; line-height: 1.4;">${chapTitle}</div>
                                    <div style="font-size: 0.8rem; color: #a7f3d0; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-list-ol" style="color: #10b981; font-size: 0.75rem;"></i> ${toBnNum(c.hadith_count)}টি হাদিস
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;}).join('')}
                </div>
            </div>
        `;
    }

    function selectHadithChapterFromDB(bookId, chapterNum) {
        pageCurrentHadithBook = bookId;
        pageCurrentHadithPage = 1;
        switchSidebarTab('chapter');
        
        // Fetch hadiths for this DB chapter
        const dbKey = bookDbKeyMap ? (bookDbKeyMap[bookId] || ('ben-' + bookId)) : ('ben-' + bookId);
        const body = document.getElementById("pageHadithContentCard");
        const bookObj = pageHadithBookList.find(b => b.id === bookId) || { name: bookId, total: 100 };

        if (!body) return;

        body.innerHTML = `
            <div style="text-align: center; padding: 60px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #10b981;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">অধ্যায়ের হাদিস লোড হচ্ছে...</div>
            </div>
        `;

        fetch(`<?= URLROOT ?>/api/hadith/list?book=${encodeURIComponent(dbKey)}&chapter=${chapterNum}&limit=200`)
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(data => {
                if (data.success && data.hadiths && data.hadiths.length > 0) {
                    const results = data.hadiths.map(h => ({
                        num: h.num,
                        ben: h.text_bn,
                        eng: null,
                        ara: h.text_ar || null
                    }));
                    // Map chapter name to Bangla if available
                    const bookKnown = knownChapters[bookId] || [];
                    const matchedKnown = bookKnown.find(k => k.id === parseInt(chapterNum, 10));
                    let displayChapName = matchedKnown ? matchedKnown.name : (data.hadiths[0].chapter_name || '');
                    if (!displayChapName || /^[A-Za-z0-9\s\-_'()]+$/.test(displayChapName)) {
                        displayChapName = 'অধ্যায় ' + toBnNum(chapterNum);
                    }
                    renderPageHadithChapterList(results, bookObj, chapterNum, displayChapName);
                } else {
                    renderPageFallbackHadithCard(bookObj.name, 1);
                }
            })
            .catch(() => renderPageFallbackHadithCard(bookObj.name, 1));
    }

    function renderPageHadithChapterList(hadithList, bookObj, chapterNum, chapterName) {
        const body = document.getElementById("pageHadithContentCard");
        if (!body) return;

        let hadithsCardsHtml = hadithList.map(item => {
            const arHtml = item.ara ? `
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.35rem; color: #fef08a; direction: rtl; line-height: 2.2; margin-bottom: 20px; text-align: right; background: rgba(0,0,0,0.22); padding: 20px 24px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
                    <div style="font-size: 0.78rem; color: #f59e0b; font-weight: 800; text-align: left; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">আরবি পাঠ:</div>
                    ${item.ara}
                </div>
            ` : '';

            const rawBen = (item.ben && item.ben.trim() !== '') ? item.ben : null;
            const bnText = rawBen || "এই হাদিসটির বাংলা অনুবাদ উন্মুক্ত এপিআই ডাটাবেসে প্রক্রিয়াধীন রয়েছে।";

            return `
                <div id="hadith-card-${item.num}" style="background: rgba(2, 44, 34, 0.75); border: 1px solid rgba(16,185,129,0.25); padding: 26px; border-radius: 18px; text-align: left; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35); transition: all 0.3s;">
                    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 12px; margin-bottom: 18px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #10b981; color: #fff; width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.88rem;">${toBnNum(item.num)}</span>
                            <span style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">${bookObj.name} - হাদিস নম্বর ${toBnNum(item.num)}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button onclick="copySingleHadith('${bookObj.name.replace(/'/g, "\\'")}', ${item.num})" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #34d399; padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="হাদিস কপি করুন" onmouseover="this.style.background='#10b981'; this.style.color='#fff';" onmouseout="this.style.background='rgba(16, 185, 129, 0.2)'; this.style.color='#34d399';">
                                <i class="fas fa-copy"></i> কপি
                            </button>
                            <button onclick="shareSingleHadith('${bookObj.name.replace(/'/g, "\\'")}', ${item.num})" style="background: rgba(59, 130, 246, 0.2); border: 1px solid #3b82f6; color: #60a5fa; padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="হাদিস শেয়ার করুন" onmouseover="this.style.background='#3b82f6'; this.style.color='#fff';" onmouseout="this.style.background='rgba(59, 130, 246, 0.2)'; this.style.color='#60a5fa';">
                                <i class="fas fa-share-nodes"></i> শেয়ার
                            </button>
                        </div>
                    </div>

                    <!-- Arabic Text -->
                    ${arHtml}

                    <!-- Bengali Translation -->
                    <div style="font-size: 1.08rem; color: #d1fae5; font-weight: 600; line-height: 1.85; margin-top: 16px; text-align: left; background: rgba(16,185,129,0.06); padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(16,185,129,0.15);">
                        <div style="font-size: 0.82rem; color: #34d399; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="fas fa-language" style="margin-right: 5px;"></i> বাংলা অনুবাদ:</div>
                        ${bnText}
                    </div>
                </div>
            `;
        }).join('');

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 18px 24px; border-radius: 16px; margin-bottom: 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 1.25rem; font-weight: 800; color: #ffffff;">
                        <i class="fas fa-book-open" style="color: #10b981;"></i> ${bookObj.name}
                        <button onclick="selectPageHadithBook('${bookObj.id}')" style="background: rgba(16,185,129,0.22); border: 1px solid #10b981; color: #34d399; padding: 4px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; margin-left: 8px;" title="অধ্যায় তালিকায় ফিরে যান">
                            <i class="fas fa-th-large" style="margin-right: 4px;"></i> সকল অধ্যায়
                        </button>
                    </div>
                    <div style="font-size: 0.88rem; color: #a7f3d0; margin-top: 4px;">
                        ${chapterName ? '<strong style="color: #34d399;">' + chapterName + '</strong> | ' : ''}মোট <strong style="color: #34d399;">${toBnNum(hadithList.length)}টি</strong> হাদিস
                    </div>
                </div>
                <span style="font-size: 0.8rem; background: rgba(16,185,129,0.2); color: #34d399; padding: 4px 12px; border-radius: 12px; font-weight: 700;"><i class="fas fa-database" style="margin-right: 4px;"></i> ডেটাবেজ ক্যাশ</span>
            </div>
            ${hadithsCardsHtml}
        `;
    }

    function selectPageHadithBook(bookId) {
        pageCurrentHadithBook = bookId;
        currentSidebarTab = "book";
        renderPageHadithSidebar();
        renderMainHadithChapters(bookId);
    }

    // DB key mapping: page book id -> db book key
    const bookDbKeyMap = {
        'bukhari':         'ben-bukhari',
        'muslim':          'ben-muslim',
        'abudawud':        'ben-abudawud',
        'tirmidhi':        'ben-tirmidhi',
        'nasai':           'ben-nasai',
        'ibnmajah':        'ben-ibnmajah',
        'malik':           'ben-malik',
        'mishkat':         'ben-mishkat',
        'nawawi':          'ben-nawawi'
    };

    let isPageInited = false;
    function initHadithPage() {
        if (isPageInited) return;
        isPageInited = true;
        
        pageCurrentHadithBook = "bukhari";
        pageCurrentHadithNum = 1;
        pageCurrentHadithPage = 1;

        currentSidebarTab = "book";
        renderPageHadithSidebar();
        renderMainHadithChapters("bukhari");
    }

    // Trigger initialization immediately
    initHadithPage();
    document.addEventListener("DOMContentLoaded", initHadithPage);
    window.addEventListener("load", initHadithPage);

    function fetchPageHadithByNumber() {
        const input = document.getElementById("pageHadithNumberInput");
        const num = input ? parseInt(input.value, 10) : NaN;
        const bookObj = pageHadithBookList.find(b => b.id === pageCurrentHadithBook) || { total: 5000 };

        if (!num || isNaN(num) || num < 1 || num > bookObj.total) {
            alert(`অনুগ্রহ করে ১ থেকে ${toBnNum(bookObj.total)} এর মধ্যে সঠিক হাদিস নম্বর লিখুন!`);
            return;
        }

        pageCurrentHadithNum = num;
        pageCurrentHadithPage = Math.floor((num - 1) / itemsPerPage) + 1;
        fetchPageHadithBatchData(pageCurrentHadithBook, pageCurrentHadithPage, num);
    }

    function fetchPageRandomHadith() {
        const bookObj = pageHadithBookList.find(b => b.id === pageCurrentHadithBook) || { total: 200 };
        const randomNum = Math.floor(Math.random() * bookObj.total) + 1;
        
        pageCurrentHadithNum = randomNum;
        pageCurrentHadithPage = Math.floor((randomNum - 1) / itemsPerPage) + 1;
        fetchPageHadithBatchData(pageCurrentHadithBook, pageCurrentHadithPage, randomNum);
    }

    function changeHadithPage(newPage) {
        const bookObj = pageHadithBookList.find(b => b.id === pageCurrentHadithBook) || { total: 100 };
        const totalPages = Math.ceil(bookObj.total / itemsPerPage);

        if (newPage < 1 || newPage > totalPages) return;
        pageCurrentHadithPage = newPage;
        fetchPageHadithBatchData(pageCurrentHadithBook, pageCurrentHadithPage);
    }

    async function fetchHadithFromLocalDB(bookId, num) {
        const dbKey = bookDbKeyMap[bookId] || ('ben-' + bookId);
        try {
            const url = `<?= URLROOT ?>/api/hadith/list?book=${encodeURIComponent(dbKey)}&num=${num}`;
            const res = await fetch(url);
            if (res.ok) {
                const data = await res.json();
                if (data.success && data.hadith) {
                    return {
                        text_bn: data.hadith.text_bn || null,
                        text_ar: data.hadith.text_ar || null,
                        chapter_name: data.hadith.chapter_name || null
                    };
                }
            }
        } catch (e) { /* fall through to CDN */ }
        return null;
    }

    async function fetchHadithFromCDNs(edition, num) {
        const endpoints = [
            `https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/${edition}/${num}.json`,
            `https://fastly.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/${edition}/${num}.json`,
            `https://gcore.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/${edition}/${num}.json`,
            `https://raw.githubusercontent.com/fawazahmed0/hadith-api/1/editions/${edition}/${num}.json`
        ];

        for (const url of endpoints) {
            try {
                const res = await fetch(url, { cache: 'force-cache' });
                if (res.ok) {
                    const data = await res.json();
                    if (data && data.hadiths && data.hadiths[0]) {
                        return data.hadiths[0].text || null;
                    }
                }
            } catch (e) {
                // Ignore and try next mirror
            }
        }
        return null;
    }

    async function fetchSingleHadithFast(book, num) {
        const cacheKey = `${book}_${num}`;
        if (hadithCache[cacheKey]) {
            return hadithCache[cacheKey];
        }

        // Step 1: Try local DB API first
        const dbResult = await fetchHadithFromLocalDB(book, num);
        if (dbResult && dbResult.text_bn) {
            const res = {
                num: num,
                ben: dbResult.text_bn,
                eng: null,
                ara: dbResult.text_ar || null
            };
            hadithCache[cacheKey] = res;
            return res;
        }

        // Step 2: Fall back to CDN APIs
        const [benText, engText, araText] = await Promise.all([
            fetchHadithFromCDNs(`ben-${book}`, num),
            fetchHadithFromCDNs(`eng-${book}`, num),
            fetchHadithFromCDNs(`ara-${book}`, num)
        ]);

        const res = {
            num: num,
            ben: benText,
            eng: engText,
            ara: araText
        };

        hadithCache[cacheKey] = res;
        return res;
    }

    function fetchPageHadithBatchData(book, pageNum, highlightNum = null) {
        pageCurrentHadithBook = book;
        pageCurrentHadithPage = pageNum;

        const body = document.getElementById("pageHadithContentCard");
        const bookObj = pageHadithBookList.find(b => b.id === book) || { name: book, total: 100 };
        const startHadith = (pageNum - 1) * itemsPerPage + 1;
        const endHadith = Math.min(pageNum * itemsPerPage, bookObj.total);

        if (!body) return;

        body.innerHTML = `
            <div style="text-align: center; padding: 60px 0; color: #a7f3d0;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; margin-bottom: 14px; display: block; color: #10b981;"></i>
                <div style="font-size: 1.1rem; font-weight: 700;">${bookObj.name} (হাদিস ${toBnNum(startHadith)} - ${toBnNum(endHadith)}) লোড হচ্ছে...</div>
                <div style="font-size: 0.85rem; color: #6ee7b7; margin-top: 4px;">দ্রুত ডেটা প্রসেস করা হচ্ছে</div>
            </div>
        `;

        // Fetch strictly from DB in bulk using offset-based pagination
        const dbKey = bookDbKeyMap[book] || ('ben-' + book);
        const dbUrl = `<?= URLROOT ?>/api/hadith/list?book=${encodeURIComponent(dbKey)}&limit=${itemsPerPage}&offset=${startHadith - 1}`;

        fetch(dbUrl).then(async res => {
            if (!res.ok) throw new Error('DB fetch failed');
            const data = await res.json();
            
            if (data.success && data.hadiths && data.hadiths.length > 0) {
                // Build results in the expected format
                const results = data.hadiths.map(h => ({
                    num: h.num,
                    ben: h.text_bn,
                    eng: null,
                    ara: h.text_ar || null
                }));
                renderPageHadithBatchList(results, bookObj, pageNum, highlightNum);
                return;
            }
            renderPageFallbackHadithCard(bookObj.name, startHadith);
        }).catch(() => {
            renderPageFallbackHadithCard(bookObj.name, startHadith);
        });
    }

    async function fetchPageHadithBatchFromCDN(book, pageNum, highlightNum, bookObj, startHadith, endHadith) {
        const promises = [];
        for (let i = startHadith; i <= endHadith; i++) {
            promises.push(fetchSingleHadithFast(book, i));
        }
        try {
            const results = await Promise.all(promises);
            const validResults = results.filter(r => r !== null && (r.ben || r.eng || r.ara));
            if (validResults.length > 0) {
                renderPageHadithBatchList(validResults, bookObj, pageNum, highlightNum);
            } else {
                renderPageFallbackHadithCard(bookObj.name, startHadith);
            }
        } catch(e) {
            renderPageFallbackHadithCard(bookObj.name, startHadith);
        }
    }


    function renderPageHadithBatchList(hadithList, bookObj, pageNum, highlightNum) {
        const body = document.getElementById("pageHadithContentCard");
        if (!body) return;

        const totalPages = Math.ceil(bookObj.total / itemsPerPage);
        const startNum = (pageNum - 1) * itemsPerPage + 1;
        const endNum = Math.min(pageNum * itemsPerPage, bookObj.total);

        let hadithsCardsHtml = hadithList.map(item => {
            const isHighlighted = highlightNum === item.num;
            const arHtml = item.ara ? `
                <div style="font-family: 'Amiri', 'Traditional Arabic', serif; font-size: 1.35rem; color: #fef08a; direction: rtl; line-height: 2.2; margin-bottom: 20px; text-align: right; background: rgba(0,0,0,0.22); padding: 20px 24px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.08);">
                    <div style="font-size: 0.78rem; color: #f59e0b; font-weight: 800; text-align: left; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">আরবি পাঠ:</div>
                    ${item.ara}
                </div>
            ` : '';

            const rawBen = (item.ben && item.ben.trim() !== '') ? item.ben : null;
            const rawEng = (item.eng && item.eng.trim() !== '') ? item.eng : null;
            
            const bnText = rawBen || (rawEng ? `<em style="color:#fcd34d;">(বাংলা অনুবাদ না থাকায় ইংরেজি অনুবাদ প্রদর্শিত হচ্ছে):</em><br>${rawEng}` : "এই হাদিসটির বাংলা অনুবাদ উন্মুক্ত এপিআই ডাটাবেসে প্রক্রিয়াধীন রয়েছে।");
            const enText = rawEng;

            return `
                <div id="hadith-card-${item.num}" style="background: ${isHighlighted ? 'rgba(16, 185, 129, 0.28)' : 'rgba(2, 44, 34, 0.75)'}; border: ${isHighlighted ? '2px solid #10b981' : '1px solid rgba(16,185,129,0.25)'}; padding: 26px; border-radius: 18px; text-align: left; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35); transition: all 0.3s;">
                    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 12px; margin-bottom: 18px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #10b981; color: #fff; width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.88rem;">${toBnNum(item.num)}</span>
                            <span style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">${bookObj.name} - হাদিস নম্বর ${toBnNum(item.num)}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button onclick="copySingleHadith('${bookObj.name.replace(/'/g, "\\'")}', ${item.num})" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #34d399; padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="হাদিস কপি করুন" onmouseover="this.style.background='#10b981'; this.style.color='#fff';" onmouseout="this.style.background='rgba(16, 185, 129, 0.2)'; this.style.color='#34d399';">
                                <i class="fas fa-copy"></i> কপি
                            </button>
                            <button onclick="shareSingleHadith('${bookObj.name.replace(/'/g, "\\'")}', ${item.num})" style="background: rgba(59, 130, 246, 0.2); border: 1px solid #3b82f6; color: #60a5fa; padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="হাদিস শেয়ার করুন" onmouseover="this.style.background='#3b82f6'; this.style.color='#fff';" onmouseout="this.style.background='rgba(59, 130, 246, 0.2)'; this.style.color='#60a5fa';">
                                <i class="fas fa-share-nodes"></i> শেয়ার
                            </button>
                        </div>
                    </div>

                    <!-- Arabic Text -->
                    ${arHtml}
                    
                    <!-- Bengali Translation -->
                    <div style="font-size: 1.08rem; color: #d1fae5; font-weight: 600; line-height: 1.85; margin-top: 16px; text-align: left; background: rgba(16,185,129,0.06); padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(16,185,129,0.15);">
                        <div style="font-size: 0.82rem; color: #34d399; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="fas fa-language" style="margin-right: 5px;"></i> বাংলা অনুবাদ:</div>
                        ${bnText}
                    </div>

                    <!-- English Translation -->
                    ${enText ? `
                    <div style="font-size: 0.95rem; color: #94a3b8; font-weight: 500; line-height: 1.65; text-align: left; font-family: 'Outfit', sans-serif; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 12px; margin-top: 14px;">
                        <div style="font-size: 0.78rem; color: #60a5fa; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">English Translation:</div>
                        ${enText}
                    </div>
                    ` : ''}
                </div>
            `;
        }).join('');

        body.innerHTML = `
            <!-- Navigation Banner Top -->
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 18px 24px; border-radius: 16px; margin-bottom: 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 1.25rem; font-weight: 800; color: #ffffff;">
                        <i class="fas fa-book-open" style="color: #10b981;"></i> ${bookObj.name}
                        <button onclick="renderMainHadithChapters('${bookObj.id}')" style="background: rgba(16,185,129,0.22); border: 1px solid #10b981; color: #34d399; padding: 4px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; margin-left: 8px;" title="অধ্যায় তালিকায় ফিরে যান">
                            <i class="fas fa-th-large" style="margin-right: 4px;"></i> সকল অধ্যায়
                        </button>
                    </div>
                    <div style="font-size: 0.88rem; color: #a7f3d0; margin-top: 4px;">
                        প্রদর্শন করা হচ্ছে: <strong style="color: #34d399;">হাদিস ${toBnNum(startNum)} - ${toBnNum(endNum)}</strong> (মোট ${toBnNum(bookObj.total)}টি)
                    </div>
                </div>
            </div>

            <!-- List of Hadiths -->
            ${hadithsCardsHtml}
        `;

        if (highlightNum) {
            setTimeout(() => {
                const el = document.getElementById(`hadith-card-${highlightNum}`);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }
    }

    function renderPageFallbackHadithCard(bookName, hNum) {
        const body = document.getElementById("pageHadithContentCard");
        if (!body) return;

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.75); border: 1px solid rgba(16,185,129,0.25); padding: 40px; border-radius: 20px; text-align: center;">
                <i class="fas fa-database" style="font-size: 2.5rem; color: #f59e0b; margin-bottom: 16px; display: block;"></i>
                <div style="font-size: 1.25rem; font-weight: 800; color: #ffffff; margin-bottom: 8px;">${bookName} - লোকাল ডাটাবেজে হাদিস পাওয়া যায়নি</div>
                <div style="font-size: 0.95rem; color: #a7f3d0; margin-bottom: 24px;">দয়া করে এডমিন প্যানেল থেকে এই হাদিস গ্রন্থের ডাটা সিঙ্ক করে নিন।</div>
                <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <a href="<?= URLROOT ?>/admin/sync_islamic" style="background: #10b981; border: none; color: #fff; padding: 12px 24px; border-radius: 25px; font-size: 0.95rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-sync"></i> এডমিন ডাটা সিঙ্ক পেজ
                    </a>
                    <button onclick="location.reload()" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 12px 24px; border-radius: 25px; font-size: 0.95rem; font-weight: 700; cursor: pointer;">
                        <i class="fas fa-rotate-right" style="margin-right: 6px;"></i> রিফ্রেশ করুন
                    </button>
                </div>
            </div>
        `;
    }

    function copySingleHadith(bookName, hadithNum) {
        const card = document.getElementById(`hadith-card-${hadithNum}`);
        if (!card) return;
        
        let textToCopy = `${bookName} - হাদিস নম্বর: ${toBnNum(hadithNum)}\n-----------------------------\n`;
        const arEl = card.querySelector("div[style*='font-family: \'Amiri\'']");
        if (arEl) {
            const arText = arEl.innerText.replace("আরবি পাঠ:", "").trim();
            if (arText) textToCopy += `আরবি:\n${arText}\n\n`;
        }
        
        const bnEl = card.querySelector("div[style*='color: #d1fae5']");
        if (bnEl) {
            const bnText = bnEl.innerText.replace("বাংলা অনুবাদ:", "").trim();
            if (bnText) textToCopy += `বাংলা অনুবাদ:\n${bnText}\n`;
        }
        
        textToCopy += `\nউৎস: response.nur-lab.com/hadith`;

        navigator.clipboard.writeText(textToCopy).then(() => {
            alert(`হাদিস নম্বর ${toBnNum(hadithNum)} সফলভাবে কপি করা হয়েছে!`);
        }).catch(err => {
            console.error('Copy failed: ', err);
        });
    }

    function shareSingleHadith(bookName, hadithNum) {
        const card = document.getElementById(`hadith-card-${hadithNum}`);
        if (!card) return;

        let shareText = `${bookName} - হাদিস নম্বর: ${toBnNum(hadithNum)}\n`;
        const bnEl = card.querySelector("div[style*='color: #d1fae5']");
        if (bnEl) {
            const bnText = bnEl.innerText.replace("বাংলা অনুবাদ:", "").trim();
            if (bnText) shareText += `${bnText.substring(0, 150)}...\n`;
        }

        const shareUrl = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: `${bookName} - হাদিস ${toBnNum(hadithNum)}`,
                text: shareText,
                url: shareUrl
            }).catch(err => console.log('Share canceled/failed', err));
        } else {
            navigator.clipboard.writeText(`${shareText}\n${shareUrl}`).then(() => {
                alert('শেয়ার করার লিংক ও হাদিস ক্লিপবোর্ডে কপি করা হয়েছে!');
            });
        }
    }
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
