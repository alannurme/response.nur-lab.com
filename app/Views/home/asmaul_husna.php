<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated 99 Names of Allah Full Page Container (Islamic Emerald Green Theme) -->
<div style="position: relative; background: radial-gradient(circle at 50% 30%, #064e3b 0%, #043e2f 45%, #022c22 100%); min-height: 100vh; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; padding-bottom: 60px;">
    <!-- Authentic Islamic Geometric Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><path d=\'M40 0 L80 40 L40 80 L0 40 Z M40 10 L70 40 L40 70 L10 40 Z M40 20 L60 40 L40 60 L20 40 Z\' fill=\'none\' stroke=\'rgba(245, 158, 11, 0.07)\' stroke-width=\'1.2\'/></svg>'); background-repeat: repeat; opacity: 0.85; pointer-events: none; z-index: 1;"></div>
    
    <!-- Top Sub-Header Control Banner -->
    <div style="position: sticky; top: 0; z-index: 100; background: rgba(4, 47, 36, 0.95); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 18px 24px; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
        <div style="width: 100%; max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; box-sizing: border-box;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="<?= URLROOT ?>" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                    <i class="fas fa-arrow-left"></i>
                    <span>হোম পেজ</span>
                </a>
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #c084fc, #9333ea); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(192, 132, 252, 0.3);">
                    <i class="fas fa-star-and-crescent"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">আল্লাহ্‌র ৯৯টি গুণবাচক নাম (আসমাউল হুসনা)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">আরবি নাম, বাংলা উচ্চারণ ও অর্থসহ সংকলন</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area Grid -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 1100px; margin: 35px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;" id="asmaPageGridContainer">
            <!-- 99 Names rendered via JS -->
        </div>
    </div>
</div>

<script>
    const asmaNames = [
        { id: 1, ar: "الرَّحْمَٰنُ", bn: "আর-রহমান", mean: "পরম দয়ালু" },
        { id: 2, ar: "الرَّحِيمُ", bn: "আর-রহীম", mean: "অতি দাতা, পরম করুণাময়" },
        { id: 3, ar: "الْمَلِكُ", bn: "আল-মালিক", mean: "সর্বভৌম ক্ষমতার অধিকারী" },
        { id: 4, ar: "الْقُدُّوسُ", bn: "আল-কুদ্দূস", mean: "পবিত্র ও নিষ্পাপ" },
        { id: 5, ar: "السَّلَامُ", bn: "আস-সালাম", mean: "শান্তিদাতা" },
        { id: 6, ar: "الْمُؤْمِنُ", bn: "আল-মু'মিন", mean: "নিরাপত্তা ও ঈমানদাতা" },
        { id: 7, ar: "الْمُهَيْمِنُ", bn: "আল-মুহাইমিন", mean: "রক্ষণাবেক্ষণকারী" },
        { id: 8, ar: "الْعَزِيزُ", bn: "আল-আজীজ", mean: "পরাক্রমশালী, বিজয়ী" },
        { id: 9, ar: "الْجَبَّارُ", bn: "আল-জাব্বার", mean: "দুর্নিবার, বাধ্যকারী" },
        { id: 10, ar: "الْمُتَكَبِّرُ", bn: "আল-মুতাকাব্বির", mean: "মহিমান্বিত, সর্বশ্রেষ্ঠ" },
        { id: 11, ar: "الْخَالِقُ", bn: "আল-খালিক", mean: "সৃষ্টিকর্তা" },
        { id: 12, ar: "الْبَارِئُ", bn: "আল-বারী", mean: "সঠিক রূপদাতা" },
        { id: 13, ar: "الْمُصَوِّرُ", bn: "আল-মুসাব্বির", mean: "আকৃতিদানকারী" },
        { id: 14, ar: "الْغَفَّارُ", bn: "আল-গাফফার", mean: "পরম ক্ষমাশীল" },
        { id: 15, ar: "الْقَهَّارُ", bn: "আল-কাহহার", mean: "কঠোর দমনকারী" },
        { id: 16, ar: "الْوَهَّابُ", bn: "আল-ওয়াহহাব", mean: "সবকিছু দানকারী" },
        { id: 17, ar: "الرَّزَّاقُ", bn: "আর-রাজ্জাক", mean: "রিজিকদাতা" },
        { id: 18, ar: "الْفَتَّاحُ", bn: "আল-ফাত্তাহ", mean: "বিজয়দাতা ও উন্মুক্তকারী" },
        { id: 19, ar: "الْعَلِيمُ", bn: "আল-আলীম", mean: "সর্বজ্ঞাত" },
        { id: 20, ar: "الْقَابِضُ", bn: "আল-কাবিদ্ব", mean: "রিজিক সংকুচিতকারী" },
        { id: 21, ar: "الْبَاسِطُ", bn: "আল-বাসিত", mean: "রিজিক সম্প্রসারণকারী" },
        { id: 22, ar: "الْخَافِضُ", bn: "আল-খাফিদ", mean: "অবনতকারী" },
        { id: 23, ar: "الرَّافِعُ", bn: "আর-রাফি", mean: "উন্নতকারী" },
        { id: 24, ar: "الْمُعِزُّ", bn: "আল-মুইজ্জ", mean: "সম্মানদাতা" },
        { id: 25, ar: "الْمُذِلُّ", bn: "আল-মুজিল", mean: "অপমানকারী" },
        { id: 26, ar: "السَّمِيعُ", bn: "আস-সামী", mean: "সর্বশ্রোতা" },
        { id: 27, ar: "الْبَصِيرُ", bn: "আল-বাশীর", mean: "সর্বদ্রষ্টা" },
        { id: 28, ar: "الْحَكَمُ", bn: "আল-হাকাম", mean: "বিচারক" },
        { id: 29, ar: "الْعَدْلُ", bn: "আল-আদল", mean: "পরম ন্যায়বিচারক" },
        { id: 30, ar: "اللَّطِيفُ", bn: "আল-লতীফ", mean: "সূক্ষ্মদর্শী ও স্নেহশীল" },
        { id: 31, ar: "الْخَبِيرُ", bn: "আল-খাবীর", mean: "সর্বজ্ঞাত, খবররাখনেওয়ালা" },
        { id: 32, ar: "الْحَلِيمُ", bn: "আল-হালীম", mean: "ধৈর্যশীল ও সহনশীল" },
        { id: 33, ar: "الْعَظِيمُ", bn: "আল-আজীম", mean: "মহান ও মহিমান্বিত" },
        { id: 34, ar: "الْغَفُورُ", bn: "আল-গফূর", mean: "ক্ষমাকারী" },
        { id: 35, ar: "الشَّكُورُ", bn: "আশ-শাকূর", mean: "গুণগ্রাহী" },
        { id: 36, ar: "الْعَلِيُّ", bn: "আল-আলী", mean: "উচ্চ মর্যাদাশীল" },
        { id: 37, ar: "الْكَبِيرُ", bn: "আল-কাবীর", mean: "মহামহিম, সবচেয়ে বড়" },
        { id: 38, ar: "الْحَفِيظُ", bn: "আল-হাফীজ", mean: "রক্ষণাবেক্ষণকারী" },
        { id: 39, ar: "الْمُقِيتُ", bn: "আল-মুকীত", mean: "সবকিছুর জীবনোপকরণদাতা" },
        { id: 40, ar: "الْحَسِيبُ", bn: "আল-হাসীব", mean: "হিসাব গ্রহণকারী" },
        { id: 41, ar: "الْجَلِيلُ", bn: "আল-জালীল", mean: "মহীয়ান ও গরিমানুসারে শ্রেষ্ঠ" },
        { id: 42, ar: "الْكَرِيمُ", bn: "আল-কারীম", mean: "মহাদানশীল" },
        { id: 43, ar: "الرَّقِيبُ", bn: "আর-রকীব", mean: "তত্ত্বাবধায়ক" },
        { id: 44, ar: "الْمُجِيبُ", bn: "আল-মুজীব", mean: "দোয়া কবুলকারী" },
        { id: 45, ar: "الْوَاسِعُ", bn: "আল-ওয়াসি", mean: "সর্বব্যাপী, প্রশস্তময়" },
        { id: 46, ar: "الْحَكِيمُ", bn: "আল-হাকীম", mean: "মহাজ্ঞানী ও প্রজ্ঞাময়" },
        { id: 47, ar: "الْوَدُودُ", bn: "আল-ওয়াদূদ", mean: "প্রেমময় ও স্নেহশীল" },
        { id: 48, ar: "الْمَجِيدُ", bn: "আল-মাজীদ", mean: "মহামহিমান্বিত" },
        { id: 49, ar: "الْبَاعِثُ", bn: "আল-বায়িছ", mean: "পুনরুত্থানকারী" },
        { id: 50, ar: "الشَّهِيدُ", bn: "আশ-শাহীদ", mean: "সর্বক্ষনে উপস্থিত সাক্ষী" },
        { id: 51, ar: "الْحَقُّ", bn: "আল-হাক্ক", mean: "পরম সত্য" },
        { id: 52, ar: "الْوَكِيلُ", bn: "আল-ওয়াকীল", mean: "কর্মসম্পাদনকারী, নির্ভরযোগ্য অভিভাবক" },
        { id: 53, ar: "الْقَوِيُّ", bn: "আল-কউইয়্যি", mean: "পরম শক্তিশালী" },
        { id: 54, ar: "الْمَتِينُ", bn: "আল-মাতীন", mean: "সুদৃঢ়" },
        { id: 55, ar: "الْوَلِيُّ", bn: "আল-ওয়ালী", mean: "অভিভাবক ও বন্ধু" },
        { id: 56, ar: "الْحَمِيدُ", bn: "আল-হামীদ", mean: "প্রশংসিত" },
        { id: 57, ar: "الْمُحْصِي", bn: "আল-মুহসী", mean: "সবকিছুর গণনা ও হিসাবরক্ষক" },
        { id: 58, ar: "الْمُبْدِئُ", bn: "আল-মুবদি", mean: "প্রথমবার সৃষ্টিকর্তা" },
        { id: 59, ar: "الْمُعِيدُ", bn: "আল-মুঈদ", mean: "পুনরায় জীবনদানকারী" },
        { id: 60, ar: "الْمُحْيِي", bn: "আল-মহিয়্যি", mean: "জীবনদাতা" },
        { id: 61, ar: "الْمُمِيتُ", bn: "আল-মুমীত", mean: "মৃত্যুদাতা" },
        { id: 62, ar: "الْحَيُّ", bn: "আল-হাইয়্যি", mean: "চিরঞ্জীব" },
        { id: 63, ar: "الْقَيُّومُ", bn: "আল-কাইয়্যূম", mean: "চিরস্থায়ী, বিশ্বধারণকারী" },
        { id: 64, ar: "الْوَاجِدُ", bn: "আল-ওয়াজিদ", mean: "প্রচুুর্যের অধিকারী" },
        { id: 65, ar: "الْمَاجِدُ", bn: "আল-মাজিদ", mean: "মহামান্বিত" },
        { id: 66, ar: "الْوَاحِدُ", bn: "আল-ওয়াহিদ", mean: "এক ও অদ্বিতীয়" },
        { id: 67, ar: "الْأَحَدُ", bn: "আল-আহাদ", mean: "একক" },
        { id: 68, ar: "الصَّمَدُ", bn: "আস-সামাদ", mean: "অমুখাপেক্ষী" },
        { id: 69, ar: "الْقَادِرُ", bn: "আল-কাদির", mean: "সর্বশক্তিমান" },
        { id: 70, ar: "الْمُقْتَدِرُ", bn: "আল-মুক্তাদির", mean: "পূর্ণ ক্ষমতার অধিকারী" },
        { id: 71, ar: "الْمُقَدِّمُ", bn: "আল-মুকাদ্দিম", mean: "অগ্রগামীকারী" },
        { id: 72, ar: "الْمُؤَخِّرُ", bn: "আল-মুআখখির", mean: "পশ্চাৎগামীকারী" },
        { id: 73, ar: "الْأَوَّلُ", bn: "আল-আউয়াল", mean: "সর্বপ্রথম" },
        { id: 74, ar: "الْآخِرُ", bn: "আল-আখির", mean: "সর্বশেষ" },
        { id: 75, ar: "الظَّاهِرُ", bn: "আজ-জাহির", mean: "প্রকাশ্য" },
        { id: 76, ar: "الْبَاطِنُ", bn: "আল-বাতিন", mean: "গুপ্ত" },
        { id: 77, ar: "الْوَالِي", bn: "আল-ওয়ালী", mean: "শাসক ও অভিভাবক" },
        { id: 78, ar: "الْمُتَعَالِي", bn: "আল-মুতায়ালী", mean: "সর্বোচ্চ সুউচ্চ" },
        { id: 79, ar: "الْبَرُّ", bn: "আল-বার্র", mean: "পরম অনুগ্রাহক" },
        { id: 80, ar: "التَّوَّابُ", bn: "আত-তাওয়াব", mean: "তওবা কবুলকারী" },
        { id: 81, ar: "الْمُنْتَقِمُ", bn: "আল-মুনতাক্বিম", mean: "প্রতিশোধ গ্রহণকারী" },
        { id: 82, ar: "الْعَفُوُّ", bn: "আল-আফুউ", mean: "পরম মার্জনাকারী" },
        { id: 83, ar: "الرَّءُوفُ", bn: "আর-রউফ", mean: "পরম দয়ার্দ্র" },
        { id: 84, ar: "مَالِكُ الْمُلْكِ", bn: "মালিকুল মুলক", mean: "সকল সাম্রাজ্যের মালিক" },
        { id: 85, ar: "ذُو الْجَلَالِ وَالْإِكْرَامِ", bn: "জুল জালালি ওয়াল ইকরাম", mean: "মহিমাময় ও মহানুভবতার অধিকারী" },
        { id: 86, ar: "الْمُقْسِطُ", bn: "আল-মুকসিত", mean: "সুসংগত ও সুবিচারকারী" },
        { id: 87, ar: "الْجَامِعُ", bn: "আল-জামি", mean: "একত্রকারী" },
        { id: 88, ar: "الْغَنِيُّ", bn: "আল-গণিয়্যি", mean: "স্বয়ংসম্পূর্ণ, ধনী" },
        { id: 89, ar: "الْمُغْنِي", bn: "আল-মুগনী", mean: "ঐশ্বর্যদানকারী" },
        { id: 90, ar: "الْمَانِعُ", bn: "আল-মানি", mean: "প্রতিরোধকারী" },
        { id: 91, ar: "الضَّارُّ", bn: "অ্যাদ্ব-দ্বার্র", mean: "ক্ষতিসাধনকারী" },
        { id: 92, ar: "النَّافِعُ", bn: "আন-নাফি", mean: "উপকারকারী" },
        { id: 93, ar: "النُّورُ", bn: "আন-নূর", mean: "জ্যোতি, আলোর উৎস" },
        { id: 94, ar: "الْهَادِي", bn: "আল-হাদী", mean: "পথপ্রদর্শক" },
        { id: 95, ar: "الْبَدِيعُ", bn: "আল-বাদী", mean: "নজিরবিহীন অদ্ভুত স্রষ্টা" },
        { id: 96, ar: "الْبَاقِي", bn: "আল-বাকী", mean: "অবিনশ্বর, চিরস্থায়ী" },
        { id: 97, ar: "الْوَارِثُ", bn: "আল-ওয়ারিছ", mean: "সকল কিছুর চূড়ান্ত মালিক" },
        { id: 98, ar: "الرَّشِيدُ", bn: "আর-রশীদ", mean: "সঠিক পথের নির্দেশক" },
        { id: 99, ar: "الصَّبُورُ", bn: "আস-সবূর", mean: "অসীম ধৈর্যশীল" }
    ];

    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function renderAsmaPage() {
        const grid = document.getElementById('asmaPageGridContainer');
        if (!grid) return;
        
        grid.innerHTML = asmaNames.map(item => `
            <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 18px; padding: 20px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                <div style="font-size: 0.8rem; font-weight: 800; color: #f59e0b; margin-bottom: 6px;">#${toBnNum(item.id)}</div>
                <div style="font-family: 'Amiri', serif; font-size: 1.6rem; color: #fef08a; margin-bottom: 8px;">${item.ar}</div>
                <div style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 4px;">${item.bn}</div>
                <div style="font-size: 0.85rem; color: #a7f3d0; font-weight: 500;">${item.mean}</div>
            </div>
        `).join('');
    }

    renderAsmaPage();
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
