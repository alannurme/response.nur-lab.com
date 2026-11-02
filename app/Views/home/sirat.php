<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Seerah (সীরাতুন নবী ﷺ) Full Page Container (Islamic Emerald Green Theme matching Hadith page) -->
<div style="position: relative; background: radial-gradient(circle at 50% 30%, #064e3b 0%, #043e2f 45%, #022c22 100%); min-height: 100vh; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; padding-bottom: 60px;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Top Sub-Header Control Banner -->
    <div class="seerah-top-sub-banner" style="position: sticky; top: 0; z-index: 100; background: rgba(4, 47, 36, 0.95); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 18px 24px; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
        <div style="width: 100%; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 0 10px; box-sizing: border-box;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="<?= URLROOT ?>" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                    <i class="fas fa-arrow-left"></i>
                    <span>হোম পেজ</span>
                </a>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 900; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-mosque"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;" id="pageSeerahTitle">সীরাতুন নবী ﷺ (Seerah Library)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">বিশ্বখ্যাত প্রামাণ্য সীরাত গ্রন্থাবলী ও রাসূলুল্লাহ ﷺ-এর পুণ্যময় জীবনচরিত</p>
                </div>
            </div>

            <div class="seerah-search-box-row" style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 280px; max-width: 100%;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                    <input type="text" id="pageSeerahSearchInput" oninput="filterSeerahContent(this.value)" placeholder="সীরাত বা অধ্যায় খুঁজুন..." style="width: 100%; padding: 9px 14px 9px 36px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif; box-sizing: border-box;">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Layout Grid (Left Books List Sidebar + Right Content Workspace) -->
    <div class="seerah-workspace-container" style="position: relative; z-index: 2; width: 100%; margin: 24px auto 0 auto; padding: 0 25px; box-sizing: border-box;">
        <div class="seerah-workspace-flex" style="display: flex; flex-wrap: wrap; gap: 24px; min-height: 75vh;">
            
            <!-- Left Sidebar: Seerah Books List & Chapters List (hadith page styled sidebar) -->
            <div class="seerah-sidebar-box" style="width: 320px; flex-shrink: 0; background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; display: flex; flex-direction: column; overflow: hidden; height: calc(100vh - 120px); position: sticky; top: 100px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); z-index: 20;">
                
                <!-- Book / Chapter Segment Switcher Tab -->
                <div style="padding: 12px 14px 6px 14px; background: rgba(2, 44, 34, 0.95); border-bottom: 1px solid rgba(16, 185, 129, 0.2);">
                    <div style="display: flex; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 3px;">
                        <button id="seerahTabBookBtn" onclick="switchSeerahSidebarTab('book')" style="flex: 1; padding: 7px 12px; border: none; border-radius: 9px; background: #10b981; color: #fff; font-weight: 800; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;">
                            <i class="fas fa-book" style="margin-right: 5px;"></i> সীরাত গ্রন্থ
                        </button>
                        <button id="seerahTabChapterBtn" onclick="switchSeerahSidebarTab('chapter')" style="flex: 1; padding: 7px 12px; border: none; border-radius: 9px; background: transparent; color: #a7f3d0; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; font-family: 'Hind Siliguri', sans-serif;">
                            <i class="fas fa-list-ol" style="margin-right: 5px;"></i> অধ্যায়সমূহ
                        </button>
                    </div>
                </div>

                <!-- Sidebar Search Input -->
                <div style="padding: 10px 14px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); background: rgba(2, 44, 34, 0.85);">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                        <input type="text" id="seerahSidebarSearch" oninput="filterSeerahSidebar()" placeholder="গ্রন্থ বা অধ্যায় ফিল্টার করুন..." style="width: 100%; padding: 9px 12px 9px 34px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Scrollable Sidebar List Items -->
                <div style="flex: 1; overflow-y: auto; padding: 10px;" id="seerahSidebarList">
                    <!-- Dynamic Items via JS -->
                </div>
            </div>

            <!-- Right Main Area: Content Reader Card (matching hadith page #pageHadithContentCard) -->
            <div style="flex: 1; min-width: 300px; background: rgba(4, 47, 36, 0.75); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);" id="pageSeerahContentCard">
                <!-- Seerah Content via JS -->
            </div>

        </div>
    </div>
</div>

<style>
    /* Dedicated Page Styling & Mobile Responsiveness */
    .header-wrapper {
        display: none !important;
    }

    @media (max-width: 991px) {
        .seerah-workspace-container {
            padding: 0 14px !important;
            margin-top: 14px !important;
        }
        .seerah-workspace-flex {
            flex-direction: column !important;
            gap: 16px !important;
        }
        .seerah-sidebar-box {
            width: 100% !important;
            height: auto !important;
            max-height: 340px !important;
            position: relative !important;
            top: 0 !important;
        }
        #pageSeerahContentCard {
            padding: 18px 14px !important;
            border-radius: 14px !important;
            min-width: 100% !important;
        }
        .seerah-top-sub-banner {
            padding: 12px 16px !important;
        }
    }

    @media (max-width: 640px) {
        #pageSeerahTitle {
            font-size: 1.15rem !important;
        }
        .seerah-search-box-row {
            width: 100% !important;
            margin-top: 10px !important;
            justify-content: flex-start !important;
        }
        .seerah-search-box-row input {
            flex: 1 !important;
            width: 100% !important;
        }
    }
</style>

<script>
    function toBnNum(numStr) {
        if (numStr === null || numStr === undefined) return '';
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    // Comprehensive list of authentic classical & contemporary Seerah books
    const seerahBooksList = [
        {
            id: "raheeq",
            name: "আর-রাহীকুল মাখতূম",
            author: "আল্লামা সফিউর রহমান মুবারকপুরী (রহ.)",
            en: "Ar-Raheeq Al-Makhtum (The Sealed Nectar)",
            chaptersCount: 16,
            code: "র",
            color: "#10b981",
            badge: "বিশ্বসেরা সীরাত গ্রন্থ",
            chapters: [
                { id: 1, name: "জাহেলী যুগের ভৌগোলিক ও সামাজিক প্রেক্ষাপট", period: "প্রাক-ইসলামী যুগ", summary: "আরব উপদ্বীপের ভৌগোলিক অবস্থান, বিভিন্ন জাতি-গোত্র, জাহেলী সমাজের নৈতিক অবক্ষয় এবং ধর্মীয় অবস্থা।" },
                { id: 2, name: "রাসূলুল্লাহ ﷺ-এর বংশমর্যাদা ও শুভ জন্ম", period: "৫৭০ খ্রিষ্টাব্দ", summary: "মুদার ও কুরাইশ বংশের মর্যাদা, বনু হাশিম, আমুল ফীল (হস্তী বর্ষ) এবং সোমবার ১২ই রবিউল আউয়াল শুভ আগমন।" },
                { id: 3, name: "শৈশব, দুধমাতা হালীমা ও বক্ষবিদারণের ঘটনা", period: "শৈশবকাল", summary: "সাদ গোত্রে শৈশব, বক্ষবিদারণ (শাক্কে সদর), মাতা আমেনা ও পিতামহ আব্দুল মুত্তালিবের ওফাত।" },
                { id: 4, name: "হিলফুল ফুযুল ও খাদিজা (রা.)-এর সাথে বিবাহ", period: "যৌবনকাল", summary: "শান্তি চুক্তি হিলফুল ফুযুল গঠন, ব্যবসায়িক সততা ও বিশ্বস্ততা, এবং ২৫ বছর বয়সে উম্মুল মুমিনীন খাদিজা (রা.)-এর সাথে বিবাহ।" },
                { id: 5, name: "হেরা গুহায় ধ্যান ও নবুওয়াত প্রাপ্তি", period: "৬১০ খ্রিষ্টাব্দ", summary: "হেরা গুহায় একাকী আত্মমগ্নতা, জিবরাঈল (আ.)-এর আগমন, সূরা আলাকের প্রথম ৫টি আয়াত নাজিল ও নবুওয়াত লাভ।" },
                { id: 6, name: "গোপন দাওয়াত ও নিকটাত্মীয়দের সতর্কীকরণ", period: "প্রথম ৩ বছর", summary: "দারুল আরকাম থেকে গোপনে তাওহীদের বাণী প্রচার, আবু বকর, আলী ও খাদিজা (রা.)-এর ইসলাম গ্রহণ।" },
                { id: 7, name: "প্রকাশ্য দাওয়াত ও কুরাইশদের নির্মম নির্যাতন", period: "মাক্কী যুগ", summary: "সাফা পর্বতের চূড়া থেকে উন্মুক্ত আহ্বান, মুশরিকদের অত্যাচার, বয়কট ও আবু তালিবের মাধ্যমে সুরক্ষার চেষ্টা।" },
                { id: 8, name: "হাবশায় প্রথম ও দ্বিতীয় হিজরত", period: "মাক্কী যুগ", summary: "মুসলিমদের উপর সীমাহীন নির্যাতন থেকে বাঁচতে ন্যায়পরায়ণ নাজ্জাশীর দেশ আবিসিনিয়ায় মুসলিমদের সফল হিজরত।" },
                { id: 9, name: "আমুল হুজন (শোকের বছর) ও তায়েফের রক্তক্ষয়ী সফর", period: "মাক্কী যুগ", summary: "খাদিজা (রা.) ও আবু তালিবের ইন্তেকাল, তায়েফে ইসলামের দাওয়াত ও বর্বর পাথর নিক্ষেপ এবং ক্ষমার অতুলনীয় আদর্শ।" },
                { id: 10, name: "পবিত্র ইসরা ও মি'রাজ (উর্ধ্বাকাশ ভ্রমণ)", period: "মাক্কী যুগ", summary: "মসজিদুল হারাম থেকে মসজিদুল আকসা এবং সিদরাতুল মুনতাহা হয়ে আল্লাহর দিদার ও পাঁচ ওয়াক্ত সালাত উপহার লাভ।" },
                { id: 11, name: "আকাবার শপথ ও ইয়াসরিবে ইসলামের বিস্তার", period: "হিজরত পূর্ব", summary: "মদিনার আউস ও খাজরাজ গোত্রের সাথে প্রথম ও দ্বিতীয় ঐতিহাসিক বাইআত এবং মুসআব ইবনে উমায়েরের দাওয়াত।" },
                { id: 12, name: "মক্কা থেকে মদীনায় ঐতিহাসিক হিজরত", period: "৬২২ খ্রিষ্টাব্দ", summary: "হত্যাকারীদের বেষ্টনী ভেদ করে সওর গুহা হয়ে আবু বকর (রা.) সহ নিরাপদে কুবা ও পবিত্র মদীনা মুনাওয়ারায় আগমন।" },
                { id: 13, name: "মদীনা সনদের প্রণয়ন ও ইসলামী রাষ্ট্রের প্রতিষ্ঠা", period: "১ম হিজরী", summary: "মসজিদে নববী নির্মাণ, মুহাজির ও আনসারদের ভ্রাতৃত্ব বন্ধন (মুআখাত) এবং বিশ্বের প্রথম লিখিত সংবিধান মদীনা সনদ প্রণয়ন।" },
                { id: 14, name: "ঐতিহাসিক বদর, ওহুদ ও খন্দকের যুদ্ধ", period: "২-৫ হিজরী", summary: "ইসলামের অস্তিত্ব রক্ষার মহাসংগ্রাম, বদরের অলৌকিক বিজয়, ওহুদের পরীক্ষা ও খন্দকে পরিখা খনন।" },
                { id: 15, name: "হুদাইবিয়ার সন্ধি ও ঐতিহাসিক মক্কা বিজয়", period: "৬-৮ হিজরী", summary: "হুদাইবিয়ার প্রকাশ্য বিজয়, বিশ্বের সম্রাটদের কাছে ইসলামের পত্র প্রেরণ এবং রক্তপাতহীন মক্কা বিজয় ও সাধারণ ক্ষমা।" },
                { id: 16, name: "বিদায় হজ্জের ঐতিহাসিক ভাষণ ও ওফাত", period: "১০-১১ হিজরী", summary: "আরাফাতের ময়দানে মানবজাতির মানবাধিকারের সনদ ঘোষণা, দ্বীনের পূর্ণতা ও পবিত্র রফীকে আলার সান্নিধ্যে প্রস্থান।" }
            ]
        },
        {
            id: "ibnhisham",
            name: "সীরাতে ইবনে হিশাম",
            author: "ইমাম ইবনে হিশাম (রহ.) / ইবনে ইসহাক",
            en: "Sirat Ibn Hisham",
            chaptersCount: 14,
            code: "ই",
            color: "#3b82f6",
            badge: "সর্বপ্রাচীন প্রামাণ্য গ্রন্থ",
            chapters: [
                { id: 1, name: "ইসমাঈল (আ.)-এর বংশধর ও কুরাইশ বংশপরম্পরা", period: "ইতিহাস ও বংশপরম্পরা", summary: "ইবরাহীম ও ইসমাঈল (আ.) থেকে কুরাইশ ও আদনানী আরবদের বংশলতিকা এবং কা'বা শরীফের তত্ত্ববধায়ক পরিবার।" },
                { id: 2, name: "কুরাইশদের মূর্তিপূজার সূচনা ও জাহেলী প্রথা", period: "প্রাক-ইসলাম", summary: "আমর ইবনে লুহাই কর্তৃক হুবালাদি মূর্তি স্থাপন এবং জাহেলিয়াতের কুসংস্কার।" },
                { id: 3, name: "রাসূলুল্লাহ ﷺ-এর শুভ জন্ম ও শৈশব অলৌকিকতা", period: "মক্কী পর্ব", summary: "হালিমাতুস সাদিয়ার ঘরে বরকত ও বাল্যকালের সত্যবাদী (আল-আমিন) উপাধি লাভ।" },
                { id: 4, name: "সিরিয়া সফর ও পাদ্রী বুহাইরার ভবিষ্যৎবাণী", period: "কৈশোর কাল", summary: "আবু তালিবের সাথে ব্যবসায়িক সফর এবং আসমানী কিতাবের আলোকে শেষ নবীর লক্ষণ সনাক্তকরণ।" },
                { id: 5, name: "নবুওয়াত লাভ ও প্রথম যুগের ঈমানদারগণ", period: "মাক্কী পর্ব", summary: "সর্বপ্রথম বিশ্বাস স্থাপনকারী সাহাবীগণের ত্যাগ ও অবিচল নিষ্ঠা।" },
                { id: 6, name: "কুরাইশদের কুৎসা ও অপপ্রচার", period: "মাক্কী পর্ব", summary: "কবি, জাদুকর ও উন্মাদ বলে অপপ্রচার চালানোর ব্যর্থ মুশরিক চক্রান্ত।" },
                { id: 7, name: "শি'আবে আবু তালিবে বন্দীদশা ও বয়কট", period: "মাক্কী পর্ব", summary: "তিন বছরব্যাপী চরম অর্থনৈতিক ও সামাজিক অবরোধ এবং মুসলিমদের অটল ধৈর্য।" },
                { id: 8, name: "মদীনার আনসারদের সাথে গোপন অঙ্গীকার", period: "আকাবার বাইয়াত", summary: "ইসলামের সুরক্ষায় ইয়াসরিববাসীর জীবন বাজি রাখার প্রতিশ্রুতি।" },
                { id: 9, name: "দারুন নদওয়ায় হত্যার নীলনকশা ও হিজরত", period: "৬২২ খ্রিষ্টাব্দ", summary: "ইবলিসের পরামর্শে যৌথ গোত্রীয় হত্যার ষড়যন্ত্র এবং অলৌকিক হিজরত।" },
                { id: 10, name: "বদর প্রান্তরে সত্য ও মিথ্যার চূড়ান্ত ফায়সালা", period: "২য় হিজরী", summary: "৩১৩ জনের অসম লড়াই এবং আবু জাহেল সহ শীর্ষ কাফের নেতাদের পতন।" },
                { id: 11, name: "ইহুদি চক্রান্ত ও বনু কাইনুকা ও নাদিরের নির্বাসন", period: "মাদানী পর্ব", summary: "মদীনা সনদের বিশ্বাসঘাতকতা এবং চুক্তিভঙ্গকারীদের পরিণতি।" },
                { id: 12, name: "খায়বার বিজয় ও মুতার যুদ্ধ", period: "৭-৮ হিজরী", summary: "ইহুদি দুর্গের পতন, আলী (রা.)-এর বীরত্ব এবং রোমান সাম্রাজ্যের সাথে প্রথম প্রত্যক্ষ সংঘাত।" },
                { id: 13, name: "তাবুক অভিযান ও মুনাফিকদের মুখোশ উন্মোচন", period: "৯ হিজরী", summary: "তীব্র গরমে রোমান বাহিনীর মোকাবেলায় মুমিনদের আত্মত্যাগ ও সূরা তাওবা নাজিল।" },
                { id: 14, name: "প্রভুর সান্নিধ্যে শুভ প্রস্থান ও জান্নাতুল বাক্বী", period: "১১ হিজরী", summary: "রাসূলুল্লাহ ﷺ-এর অন্তিম রোগশয্যা, সালাতের নির্দেশ ও উম্মতের প্রতি শেষ উপদেশ।" }
            ]
        },
        {
            id: "ibnkathir",
            name: "আল-বিদায়া ওয়ান নিহায়া (সীরাত খণ্ড)",
            author: "ইমাম হাফিজ ইবনে কাসীর (রহ.)",
            en: "Al-Bidayah wan-Nihayah (As-Sirah)",
            chaptersCount: 12,
            code: "ক",
            color: "#f59e0b",
            badge: "বিশ্বকোষীয় প্রামাণ্য ইতিহাস",
            chapters: [
                { id: 1, name: "মুহাম্মদ ﷺ-এর নবুওয়াতের প্রামাণ্য নিদর্শন (দাল্লায়েলুন নবুওয়াত)", period: "ঐশ্বরিক প্রমাণ", summary: "পূর্ববর্তী কিতাবসমূহে সুসংবাদ, জিন ও গণকদের স্তব্ধ হয়ে যাওয়া এবং বিশ্বব্রহ্মাণ্ডের পরিবর্তন।" },
                { id: 2, name: "মাক্কী জীবনের কঠিন পরীক্ষা ও ঈমানী দৃঢ়তা", period: "মাক্কী যুগ", summary: "খাব্বাব, বিলাল ও সুমাইয়া (রা.)-এর উপর পাশবিক নির্যাতন ও জান্নাতের সুসংবাদ।" },
                { id: 3, name: "চন্দ্র দ্বিখণ্ডিতকরণের ঐতিহাসিক মুজিযা", period: "মাক্কী যুগ", summary: "কুরাইশদের দাবির প্রেক্ষিতে চাঁদ দুই টুকরো হয়ে যাওয়ার অকাট্য মু'জিযা।" },
                { id: 4, name: "তায়েফের মর্মস্পর্শী অভিজ্ঞতা ও ক্ষমার আদর্শ", period: "মাক্কী যুগ", summary: "পাহাড়ের ফেরেশতার প্রস্তাব ফিরিয়ে দিয়ে হেদায়েতের আকুল প্রার্থনা।" },
                { id: 5, name: "হিজরতের পথ ও সুরাকার তাড়া করার ঘটনা", period: "৬২২ খ্রিষ্টাব্দ", summary: "সুরাকা ইবনে মালেকের ঘোড়ার পা মাটিতে দেবে যাওয়া ও কিসরার স্বর্ণের বালা পরানোর ভবিষ্যদ্বাণী।" },
                { id: 6, name: "মদীনাতুর রাসূলের আলো ও রাষ্ট্রের সাংগঠনিক রূপ", period: "মাদানী যুগ", summary: "আইন, বিচার, অর্থনীতি ও পররাষ্ট্রনীতির পূর্ণাঙ্গ ভিত্তি স্থাপন।" },
                { id: 7, name: "গাযওয়ায়ে ওহুদ ও তীরন্দাজদের শিক্ষা", period: "৩ হিজরী", summary: "রাসূলের নির্দেশের গুরুত্ব, হামযা (রা.)-এর শাহাদাত ও আত্মশুদ্ধির শিক্ষা।" },
                { id: 8, name: "উম্মুল মুমিনীন আয়েশা (রা.)-এর ইফকের অপবাদ ও পবিত্রতা", period: "৫ হিজরী", summary: "মুনাফিকদের অপবাদ এবং আকাশ থেকে সূরা নূরের দশটি আয়াত নাজিলের মাধ্যমে পবিত্রতা ঘোষণা।" },
                { id: 9, name: "হুনাইনের যুদ্ধ ও গনীমত বণ্টন", period: "৮ হিজরী", summary: "আনসারদের কান্না ও রাসূলের সান্ত্বনা: মানুষ উট-বকরি নিয়ে যাক, তোমরা রাসূলুল্লাহকে ঘরে নিয়ে যাচ্ছ।" },
                { id: 10, name: "আরবের বিভিন্ন গোত্রের প্রতিনিধি দলের আগমন (আমুল উফুদ)", period: "৯-১০ হিজরী", summary: "সমগ্র আরবে একযোগে ইসলামের বিজয় ও দলে দলে দ্বীনে প্রবেশ।" },
                { id: 11, name: "বিদায় হজ্জ: চিরন্তন মানবাধিকার ঘোষণা", period: "১০ হিজরী", summary: "বর্ণবাদ, সুদ ও নারীর অধিকার নিয়ে সর্বকালের শ্রেষ্ঠ সর্বজনীন মানবাধিকার ঘোষণা।" },
                { id: 12, name: "উম্মতের শোক ও খোলাফায়ে রাশেদীনের অঙ্গীকার", period: "১১ হিজরী", summary: "আবু বকর (রা.)-এর ঐতিহাসিক ঘোষণা: যারা মুহাম্মদের ইবাদত করত তারা জানুক তিনি ইন্তেকাল করেছেন, আর যারা আল্লাহর ইবাদত করে তারা জানুক আল্লাহ চিরঞ্জীব।" }
            ]
        },
        {
            id: "shamaail",
            name: "শামায়েলে তিরমিযী",
            author: "ইমাম আবু ঈসা মুহাম্মদ আত-তিরমিজী (রহ.)",
            en: "Ash-Shama'il al-Muhammadiyyah",
            chaptersCount: 10,
            code: "শ",
            color: "#8b5cf6",
            badge: "রাসূলের রূপ, বেশভূষা ও চরিত্র",
            chapters: [
                { id: 1, name: "রাসূলুল্লাহ ﷺ-এর শারীরিক অবয়ব ও রূপ-লাবণ্য", period: "শারীরিক গুণাবলী", summary: "চেহারার জ্যোতি, উন্নত কপাল, কালো চোখ, প্রশস্ত বক্ষ ও পূর্ণাঙ্গ সুন্দর অবয়ব।" },
                { id: 2, name: "মোহরে নবুওয়াত (নবুওয়াতের সীলমোহর)", period: "নবুওয়াতের প্রতীক", summary: "দুই কাঁধের মধ্যবর্তী অংশে নবুওয়াতের পবিত্র সীলমোহরের বিবরণ।" },
                { id: 3, name: "রাসূলুল্লাহ ﷺ-এর মাথার চুল ও দাড়ি মোবারক", period: "বেশভূষা", summary: "চুলের দৈর্ঘ্য, সিঁথি কাটা, চিরুনি করা এবং পবিত্র দাড়ির শোভা।" },
                { id: 4, name: "রাসূলুল্লাহ ﷺ-এর পোশাক ও জুতো মোবারক", period: "লেবাস ও শিষ্টাচার", summary: "সাদা চাদর, জুব্বা, পাগড়ী এবং চামড়ার জোড়া ফিতাযুক্ত জুতো পরিধান।" },
                { id: 5, name: "রাসূলুল্লাহ ﷺ-এর আহার ও পানীয় গ্রহণের সুন্নাহ", period: "দৈনন্দিন আমল", summary: "দস্তরখানে বসা, তিন আঙুলে খাওয়া, পাত্র চেঁছে নেওয়া ও হেলান দিয়ে না খাওয়ার আদব।" },
                { id: 6, name: "রাসূলুল্লাহ ﷺ-এর চলাফেরা, কথা ও হাসিমুখ", period: "আচরণ ও কথন", summary: "দৃঢ় পদক্ষেপে হাঁটা, স্পষ্ট থেমে থেমে কথা বলা এবং সর্বদা স্নিগ্ধ মুচকি হাসি।" },
                { id: 7, name: "রাসূলুল্লাহ ﷺ-এর নিদ্রা, ইবাদত ও তাহাজ্জুদ", period: "ইবাদতের মাহাত্ম্য", summary: "ডান কাত হয়ে শোয়া, দু'আ পাঠ এবং পা ফুলে যাওয়া পর্যন্ত রাতের দীর্ঘ সালাত।" },
                { id: 8, name: "রাসূলুল্লাহ ﷺ-এর নম্রতা, বদান্যতা ও দানশীলতা", period: "উচ্চ নৈতিকতা", summary: "প্রবাহিত বাতাসের চেয়েও অধিক দানশীলতা এবং কখনো কাউকে না না বলা।" },
                { id: 9, name: "রাসূলুল্লাহ ﷺ-এর লজ্জাশীলতা ও সাধারণ জীবনযাপন", period: "যুহদ ও বিনয়", summary: "কুঁড়েঘরের বিছানা, খড়ের চাটাইয়ের দাগ এবং ঘরে মাসের পর মাস চুলা না জ্বলার ত্যাগ।" },
                { id: 10, name: "স্বপ্নে রাসূলুল্লাহ ﷺ-কে দর্শন ও প্রেম", period: "প্রেম ও অনুসরণ", summary: "যে ব্যক্তি আমাকে স্বপ্নে দেখল সে নিশ্চয় আমাকেই দেখল, কারণ শয়তান আমার রূপ ধারণ করতে পারে না।" }
            ]
        },
        {
            id: "zad",
            name: "যাদুল মা'আদ (জীবনচরিতে দিকনির্দেশনা)",
            author: "আল্লামা ইবনুল কাইয়্যিম আল-জাওযিয়্যাহ (রহ.)",
            en: "Zad al-Ma'ad fi Hadyi Khayr al-Ibad",
            chaptersCount: 10,
            code: "য",
            color: "#ec4899",
            badge: "সুন্নাহ ও জীবনবিধানের বিশ্লেষণ",
            chapters: [
                { id: 1, name: "পবিত্রতা, ওযু ও সালাতে নববী আদর্শ", period: "ফিকহুস সীরাত", summary: "রাসূলুল্লাহ ﷺ যেভাবে ওযু করতেন এবং পূর্ণ মনোযোগ সহকারে সালাত আদায় করতেন।" },
                { id: 2, name: "সিয়াম, রমাদান ও ই'তিকাফের নববী পদ্ধতি", period: "ইবাদত পদ্ধতি", summary: "সেহরি, ইফতার, লাইলাতুল কদর অন্বেষণ ও ই'তিকাফের আত্মিক অনুশীলন।" },
                { id: 3, name: "হজ্জ ও উমরাহ পালনে নববী নির্দেশিকা", period: "হজ্জের সুন্নাহ", summary: "হজ্জে তামাত্তু, ইফরাদ ও ক্বিরানের পূর্ণাঙ্গ নিয়ম ও তালবিয়ার সুর।" },
                { id: 4, name: "জিহাদ, সামরিক নীতি ও শত্রু আচরণ বিধি", period: "যুদ্ধ ও কূটনীতি", summary: "নারী, শিশু, বৃদ্ধ ও সন্ন্যাসীদের হত্যা না করা এবং গাছপালা না কাটার মানবিক নিয়ম।" },
                { id: 5, name: "তিব্বে নববী (চিকিৎসা বিজ্ঞানে নববী পথ)", period: "সুস্থতা ও প্রতিষেধক", summary: "মধু, কালোজিরা, হিজামা ও রুকইয়াহর মাধ্যমে আত্মিক ও শারীরিক রোগ নিরাময়।" },
                { id: 6, name: "পারিবারিক জীবন, দাম্পত্য অধিকার ও সন্তান লালন-পালন", period: "পারিবারিক শিক্ষা", summary: "স্ত্রীদের সাথে ভালোবাসা, ঘরের কাজে সহযোগিতা ও সন্তানদের প্রতি স্নেহ।" },
                { id: 7, name: "ব্যবসা-বাণিজ্য, অর্থনীতি ও লেনদেনের নববী ধারা", period: "অর্থনৈতিক দর্শন", summary: "সততা, প্রতারণাহীন বেচাকেনা ও ওজনে সঠিক পরিমাপ রক্ষার আদেশ।" },
                { id: 8, name: "বিচার ও শাসনব্যবস্থায় নববী ইনসাফ", period: "রাষ্ট্রীয় ন্যায়বিচার", summary: "নিজের কন্যার ক্ষেত্রেও চুরির শাস্তির সমান নীতি ঘোষণা করে আইনের শাসন প্রতিষ্ঠা।" },
                { id: 9, name: "অমুসলিম ও সংখ্যালঘুদের সাথে নববী সদাচার", period: "মানবাধিকার ও চুক্তি", summary: "যিম্মীদের রক্ত ও সম্পদের নিরাপত্তা প্রদান এবং বিশ্বাসঘাতকতা থেকে কঠোর সতর্কতা।" },
                { id: 10, name: "নৈতিক অবক্ষয় রোধ ও সমাজ সংস্কারে নববী সংস্কার", period: "সামাজিক বিপ্লব", summary: "কুসংস্কার, বর্ণবাদ ও শ্রেণীভেদ বিলুপ্ত করে সাম্য ও ইনসাফের সমাজ নির্মাণ।" }
            ]
        }
    ];

    // Articles from database passed via PHP
    const siteSeerahArticles = <?= json_encode($posts ?? []) ?>;

    let currentSeerahSidebarTab = "book"; // "book" or "chapter"
    let currentActiveBookId = "raheeq";
    let currentActiveChapterId = 1;

    function switchSeerahSidebarTab(tabName) {
        currentSeerahSidebarTab = tabName;
        const bookBtn = document.getElementById("seerahTabBookBtn");
        const chapBtn = document.getElementById("seerahTabChapterBtn");

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
        renderSeerahSidebar();
    }

    function renderSeerahSidebar(filterQuery = "") {
        const sidebar = document.getElementById("seerahSidebarList");
        if (!sidebar) return;

        if (currentSeerahSidebarTab === "book") {
            const filtered = seerahBooksList.filter(b => 
                b.name.toLowerCase().includes(filterQuery.toLowerCase()) ||
                b.author.toLowerCase().includes(filterQuery.toLowerCase()) ||
                b.en.toLowerCase().includes(filterQuery.toLowerCase())
            );

            sidebar.innerHTML = filtered.map(b => {
                const isActive = b.id === currentActiveBookId;
                return `
                    <div onclick="selectSeerahBook('${b.id}')" style="padding: 12px 14px; border-radius: 12px; margin-bottom: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; background: ${isActive ? 'rgba(16, 185, 129, 0.22)' : 'transparent'}; border: ${isActive ? '1px solid #10b981' : '1px solid rgba(255,255,255,0.06)'}; transition: all 0.2s;" onmouseover="if('${b.id}' !== currentActiveBookId) this.style.background='rgba(255,255,255,0.06)'" onmouseout="if('${b.id}' !== currentActiveBookId) this.style.background='transparent'">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: ${b.color}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                            ${b.code}
                        </div>
                        <div style="overflow: hidden; flex: 1;">
                            <div style="font-weight: 800; font-size: 0.95rem; color: ${isActive ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.name}</div>
                            <div style="font-size: 0.78rem; color: #a7f3d0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.author}</div>
                            <div style="font-size: 0.73rem; color: #fde047; margin-top: 2px;">${toBnNum(b.chaptersCount)}টি অধ্যায় &bull; ${b.badge}</div>
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            const activeBook = seerahBooksList.find(b => b.id === currentActiveBookId) || seerahBooksList[0];
            const chapters = activeBook.chapters || [];
            const filteredChapters = chapters.filter(c => 
                c.name.toLowerCase().includes(filterQuery.toLowerCase()) ||
                c.summary.toLowerCase().includes(filterQuery.toLowerCase())
            );

            let headerHtml = `
                <div style="padding: 10px 12px; background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-weight: 800; font-size: 0.88rem; color: #34d399; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${activeBook.name}</div>
                    <button onclick="switchSeerahSidebarTab('book')" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;" title="সীরাত গ্রন্থ পরিবর্তন করুন">বই পরিবর্তন</button>
                </div>
            `;

            if (filteredChapters.length === 0) {
                sidebar.innerHTML = headerHtml + `
                    <div style="text-align: center; padding: 30px 10px; color: #a7f3d0; font-size: 0.88rem;">
                        কোনো অধ্যায় পাওয়া যায়নি
                    </div>
                `;
                return;
            }

            sidebar.innerHTML = headerHtml + filteredChapters.map(c => {
                const isCurrent = c.id === currentActiveChapterId;
                return `
                    <div onclick="selectSeerahChapter(${c.id})" style="padding: 11px 12px; border-radius: 12px; margin-bottom: 6px; cursor: pointer; display: flex; align-items: center; gap: 10px; background: ${isCurrent ? 'rgba(16, 185, 129, 0.22)' : 'transparent'}; border: ${isCurrent ? '1px solid #10b981' : '1px solid transparent'}; transition: all 0.2s;" onmouseover="if(!${isCurrent}) this.style.background='rgba(255,255,255,0.06)'" onmouseout="if(!${isCurrent}) this.style.background='transparent'">
                        <div style="width: 30px; height: 30px; border-radius: 8px; background: rgba(16, 185, 129, 0.25); color: #34d399; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.82rem; flex-shrink: 0;">
                            ${toBnNum(c.id)}
                        </div>
                        <div style="overflow: hidden; flex: 1;">
                            <div style="font-weight: 800; font-size: 0.88rem; color: ${isCurrent ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${c.name}</div>
                            <div style="font-size: 0.75rem; color: #a7f3d0;">${c.period}</div>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    function filterSeerahSidebar() {
        const q = (document.getElementById("seerahSidebarSearch").value || "").trim();
        renderSeerahSidebar(q);
    }

    function selectSeerahBook(bookId) {
        currentActiveBookId = bookId;
        currentActiveChapterId = 1;
        renderSeerahSidebar();
        renderSeerahBookMainView(bookId);
    }

    function selectSeerahChapter(chapterId) {
        currentActiveChapterId = chapterId;
        switchSeerahSidebarTab('chapter');
        renderSeerahChapterDetail(currentActiveBookId, chapterId);
    }

    // Render all chapters grid for a selected book
    function renderSeerahBookMainView(bookId) {
        const book = seerahBooksList.find(b => b.id === bookId) || seerahBooksList[0];
        const body = document.getElementById("pageSeerahContentCard");
        if (!body) return;

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 24px; border-radius: 18px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 18px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 1.45rem; font-weight: 900; color: #ffffff; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-book-open" style="color: #10b981;"></i> ${book.name}
                        </div>
                        <div style="font-size: 0.95rem; color: #a7f3d0; margin-top: 4px;">
                            লেখক: <strong style="color: #fef08a;">${book.author}</strong> &bull; <span style="color: #6ee7b7;">${book.en}</span>
                        </div>
                        <div style="font-size: 0.84rem; color: #fde047; margin-top: 4px;">
                            <i class="fas fa-certificate" style="margin-right: 5px;"></i> ${book.badge} | মোট অধ্যায়: <strong>${toBnNum(book.chapters.length)}টি</strong>
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <button onclick="switchSeerahSidebarTab('chapter')" style="background: rgba(16,185,129,0.22); border: 1px solid #10b981; color: #34d399; padding: 7px 16px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-list-ul"></i> অধ্যায় তালিকা
                        </button>
                    </div>
                </div>

                <h3 style="font-size: 1.1rem; font-weight: 800; color: #6ee7b7; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-book-bookmark" style="color: #f59e0b;"></i> পাঠ করার জন্য একটি অধ্যায় নির্বাচন করুন:
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
                    ${book.chapters.map(c => `
                        <div onclick="selectSeerahChapter(${c.id})" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(16,185,129,0.25); padding: 16px 18px; border-radius: 14px; cursor: pointer; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(16,185,129,0.18)'; this.style.borderColor='#10b981'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(0,0,0,0.25)'; this.style.borderColor='rgba(16,185,129,0.25)'; this.style.transform='translateY(0)';">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(16,185,129,0.3);">
                                    ${toBnNum(c.id)}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 800; font-size: 0.95rem; color: #ffffff; margin-bottom: 4px; line-height: 1.4;">${c.name}</div>
                                    <div style="font-size: 0.78rem; color: #fef08a; margin-bottom: 6px;"><i class="fas fa-clock" style="margin-right: 4px;"></i> ${c.period}</div>
                                    <p style="font-size: 0.8rem; color: #cbd5e1; margin: 0; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${c.summary}</p>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>

            <!-- Relevant Seerah Research Articles from Database -->
            ${renderRelatedArticlesSection()}
        `;
    }

    // Render chapter reading detail card
    function renderSeerahChapterDetail(bookId, chapterId) {
        const book = seerahBooksList.find(b => b.id === bookId) || seerahBooksList[0];
        const chapter = book.chapters.find(c => c.id === chapterId) || book.chapters[0];
        const body = document.getElementById("pageSeerahContentCard");
        if (!body) return;

        const prevChapter = book.chapters.find(c => c.id === chapterId - 1);
        const nextChapter = book.chapters.find(c => c.id === chapterId + 1);

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 24px; border-radius: 18px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                
                <!-- Chapter Header Navigation -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 16px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 0.88rem; color: #34d399; font-weight: 700; margin-bottom: 4px;">
                            ${book.name} &bull; অধ্যায় ${toBnNum(chapter.id)} / ${toBnNum(book.chapters.length)}
                        </div>
                        <h2 style="margin: 0; font-size: 1.45rem; font-weight: 900; color: #ffffff;">
                            ${chapter.name}
                        </h2>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <button onclick="renderSeerahBookMainView('${book.id}')" style="background: rgba(16,185,129,0.22); border: 1px solid #10b981; color: #34d399; padding: 6px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-th-large"></i> সকল অধ্যায়
                        </button>
                    </div>
                </div>

                <!-- Chapter Details & Summary Box -->
                <div style="background: rgba(6, 78, 59, 0.7); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="background: #f59e0b; color: #000; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px;">
                            ${chapter.period}
                        </span>
                        <span style="font-size: 0.85rem; color: #a7f3d0;">
                            ঐতিহাসিক সারসংক্ষেপ ও তথ্যমূলক আলোচনা
                        </span>
                    </div>

                    <p style="font-size: 1.05rem; line-height: 1.85; color: #f1f5f9; margin: 0; font-weight: 500;">
                        ${chapter.summary}
                    </p>
                </div>

                <!-- Comprehensive Islamic Educational Content Box -->
                <div style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 22px; line-height: 1.9; color: #e2e8f0; font-size: 1rem; margin-bottom: 24px;">
                    <h4 style="margin: 0 0 12px 0; color: #fef08a; font-size: 1.1rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-lightbulb" style="color: #fbbf24;"></i> এই অধ্যায়ের শিক্ষণীয় ও মূল শিক্ষা:
                    </h4>
                    <p style="margin: 0 0 12px 0;">
                        রাসূলুল্লাহ ﷺ-এর জীবনচরিত কেবল অতীতের ইতিহাস নয়, বরং তা কিয়ামত পর্যন্ত সমগ্র মানবজাতির ব্যক্তিগত, পারিবারিক, সামাজিক ও আন্তর্জাতিক জীবনের সর্বোত্তম বাস্তব আদর্শ। এই অধ্যায়ের ঐতিহাসিক ঘটনাপ্রবাহ পর্যালোচনা করলে দেখা যায় কীভাবে অটল বিশ্বাস, বিনম্র চরিত্র ও ধৈর্যশীল নেতৃত্বের মাধ্যমে অন্ধকারাচ্ছন্ন পৃথিবীকে সত্য ও ন্যায়ের আলোকে উদ্ভাসিত করা হয়েছিল।
                    </p>
                    <div style="background: rgba(16,185,129,0.12); border-left: 4px solid #10b981; padding: 12px 16px; border-radius: 0 10px 10px 0; font-size: 0.95rem; color: #a7f3d0; margin-top: 14px;">
                        <strong>কুরআনী ঘোষণা:</strong> “নিশ্চয়ই আল্লাহর রাসূলের মধ্যে তোমাদের জন্য রয়েছে উত্তম আদর্শ, তার জন্য যে আল্লাহ ও শেষ দিবসের প্রত্যাশা করে এবং আল্লাহকে অধিক স্মরণ করে।” <em>(সূরা আল-আহযাব: ২১)</em>
                    </div>
                </div>

                <!-- Next & Previous Chapter Navigation Footer -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-top: 1px solid rgba(16,185,129,0.2); padding-top: 18px;">
                    ${prevChapter ? `
                        <button onclick="selectSeerahChapter(${prevChapter.id})" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> পূর্ববর্তী অধ্যায়: ${prevChapter.name.substring(0, 24)}...
                        </button>
                    ` : `<div></div>`}

                    ${nextChapter ? `
                        <button onclick="selectSeerahChapter(${nextChapter.id})" style="background: #10b981; border: none; color: #fff; padding: 8px 20px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            পরবর্তী অধ্যায়: ${nextChapter.name.substring(0, 24)}... <i class="fas fa-arrow-right"></i>
                        </button>
                    ` : `<div></div>`}
                </div>

            </div>

            <!-- Related Articles -->
            ${renderRelatedArticlesSection()}
        `;
    }

    function renderRelatedArticlesSection() {
        if (!siteSeerahArticles || siteSeerahArticles.length === 0) return '';

        return `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 24px; border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 14px;">
                    <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #fef08a; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-newspaper" style="color: #10b981;"></i> রাসূলুল্লাহ ﷺ সম্পর্কিত নিবন্ধ ও প্রবন্ধসমূহ (${toBnNum(siteSeerahArticles.length)}টি)
                    </h3>
                    <span style="font-size: 0.8rem; color: #a7f3d0; background: rgba(16,185,129,0.2); padding: 4px 12px; border-radius: 20px;">
                        সাইটের গবেষণামূলক প্রশ্নোত্তর ও প্রবন্ধ
                    </span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
                    ${siteSeerahArticles.slice(0, 9).map(art => `
                        <div style="background: rgba(6, 78, 59, 0.6); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 14px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.borderColor='#10b981'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(16, 185, 129, 0.25)'; this.style.transform='none';">
                            <div>
                                <span style="display: inline-block; background: rgba(16, 185, 129, 0.25); color: #34d399; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; margin-bottom: 8px;">
                                    ${art.main_category || 'সীরাত ও নবীর চরিত্র'}
                                </span>
                                <a href="<?= URLROOT ?>/p/${art.id}" style="color: #ffffff; text-decoration: none; font-weight: 700; font-size: 0.95rem; line-height: 1.45; display: block; margin-bottom: 8px;" onmouseover="this.style.color='#34d399';" onmouseout="this.style.color='#ffffff';">
                                    ${art.title}
                                </a>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.78rem; color: #a7f3d0; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 10px; margin-top: 10px;">
                                <span><i class="fas fa-eye" style="margin-right: 4px;"></i> ${toBnNum(parseInt(art.views || 0) + parseInt(art.fake_views || 0))} পঠিত</span>
                                <a href="<?= URLROOT ?>/p/${art.id}" style="color: #fef08a; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    সম্পূর্ণ পড়ুন &rarr;
                                </a>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    function filterSeerahContent(query) {
        const q = (query || "").trim().toLowerCase();
        if (!q) {
            renderSeerahBookMainView(currentActiveBookId);
            return;
        }

        // Search across all books & chapters
        let matchedItems = [];
        seerahBooksList.forEach(book => {
            book.chapters.forEach(chap => {
                if (chap.name.toLowerCase().includes(q) || chap.summary.toLowerCase().includes(q) || book.name.toLowerCase().includes(q)) {
                    matchedItems.push({ book, chap });
                }
            });
        });

        const body = document.getElementById("pageSeerahContentCard");
        if (!body) return;

        body.innerHTML = `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 24px; border-radius: 18px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 14px; margin-bottom: 18px;">
                    <div style="font-size: 1.25rem; font-weight: 800; color: #ffffff;">
                        অনুসন্ধানের ফলাফল: "${query}" (মোট ${toBnNum(matchedItems.length)}টি ফলাফল)
                    </div>
                    <button onclick="renderSeerahBookMainView('${currentActiveBookId}')" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                        ফিল্টার মুছুন
                    </button>
                </div>

                ${matchedItems.length === 0 ? `
                    <div style="text-align: center; padding: 40px; color: #a7f3d0;">
                        <i class="fas fa-search" style="font-size: 2rem; color: #10b981; margin-bottom: 12px; display: block;"></i>
                        কোনো ফলাফল পাওয়া যায়নি। অন্য কোনো শব্দ দিয়ে অনুসন্ধান করুন।
                    </div>
                ` : `
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
                        ${matchedItems.map(({book, chap}) => `
                            <div onclick="currentActiveBookId='${book.id}'; selectSeerahChapter(${chap.id});" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(16,185,129,0.25); padding: 16px; border-radius: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(16,185,129,0.18)'; this.style.borderColor='#10b981';" onmouseout="this.style.background='rgba(0,0,0,0.25)'; this.style.borderColor='rgba(16,185,129,0.25)';">
                                <span style="font-size: 0.75rem; background: ${book.color}; color: #fff; padding: 2px 8px; border-radius: 6px; font-weight: 800; display: inline-block; margin-bottom: 6px;">
                                    ${book.name}
                                </span>
                                <h4 style="margin: 0 0 6px 0; font-size: 0.95rem; font-weight: 800; color: #fff;">${chap.name}</h4>
                                <p style="margin: 0; font-size: 0.8rem; color: #cbd5e1; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${chap.summary}</p>
                            </div>
                        `).join('')}
                    </div>
                `}
            </div>
        `;
    }

    // Initialize Seerah view on load
    document.addEventListener("DOMContentLoaded", function() {
        renderSeerahSidebar();
        renderSeerahBookMainView(currentActiveBookId);
    });
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
