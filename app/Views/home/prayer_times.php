<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Prayer Times Full Page Container (Islamic Emerald Green Theme) -->
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
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-mosque"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">আজকের নামাজের সময়সূচী</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;" id="prayerPageLocation">ঢাকা, বাংলাদেশ</p>
                </div>
            </div>

            <!-- District Select Dropdown -->
            <div style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.12); padding: 7px 16px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.25);">
                <i class="fas fa-city" style="color: #f59e0b; font-size: 0.95rem;"></i>
                <select id="prayerPageDistrictSelect" onchange="changePrayerPageLocation(this.value)" style="background: transparent; border: none; color: #ffffff; font-family: 'Hind Siliguri', sans-serif; font-size: 0.92rem; font-weight: 700; outline: none; cursor: pointer; max-width: 220px;">
                    <option value="Dhaka" style="background: #044e39; color: #ffffff;">ঢাকা (Dhaka)</option>
                    <option value="Gazipur" style="background: #044e39; color: #ffffff;">গাজীপুর (Gazipur)</option>
                    <option value="Kishoreganj" style="background: #044e39; color: #ffffff;">কিশোরগঞ্জ (Kishoreganj)</option>
                    <option value="Manikganj" style="background: #044e39; color: #ffffff;">মানিকগঞ্জ (Manikganj)</option>
                    <option value="Munshiganj" style="background: #044e39; color: #ffffff;">মুন্সিগঞ্জ (Munshiganj)</option>
                    <option value="Narayanganj" style="background: #044e39; color: #ffffff;">নারায়ণগঞ্জ (Narayanganj)</option>
                    <option value="Narsingdi" style="background: #044e39; color: #ffffff;">নরসিংদী (Narsingdi)</option>
                    <option value="Faridpur" style="background: #044e39; color: #ffffff;">ফরিদপুর (Faridpur)</option>
                    <option value="Gopalganj" style="background: #044e39; color: #ffffff;">গোপালগঞ্জ (Gopalganj)</option>
                    <option value="Madaripur" style="background: #044e39; color: #ffffff;">মাদারীপুর (Madaripur)</option>
                    <option value="Rajbari" style="background: #044e39; color: #ffffff;">রাজবাড়ী (Rajbari)</option>
                    <option value="Shariatpur" style="background: #044e39; color: #ffffff;">শরীয়তপুর (Shariatpur)</option>
                    <option value="Tangail" style="background: #044e39; color: #ffffff;">টাঙ্গাইল (Tangail)</option>
                    <option value="Chittagong" style="background: #044e39; color: #ffffff;">চট্টগ্রাম (Chittagong)</option>
                    <option value="Cox's Bazar" style="background: #044e39; color: #ffffff;">কক্সবাজার (Cox's Bazar)</option>
                    <option value="Bandarban" style="background: #044e39; color: #ffffff;">বান্দরবান (Bandarban)</option>
                    <option value="Khagrachhari" style="background: #044e39; color: #ffffff;">খাগড়াছড়ি (Khagrachhari)</option>
                    <option value="Rangamati" style="background: #044e39; color: #ffffff;">রাঙ্গামাটি (Rangamati)</option>
                    <option value="Noakhali" style="background: #044e39; color: #ffffff;">নোয়াখালী (Noakhali)</option>
                    <option value="Feni" style="background: #044e39; color: #ffffff;">ফেনী (Feni)</option>
                    <option value="Lakshmipur" style="background: #044e39; color: #ffffff;">লক্ষ্মীপুর (Lakshmipur)</option>
                    <option value="Comilla" style="background: #044e39; color: #ffffff;">কুমিল্লা (Comilla)</option>
                    <option value="Brahmanbaria" style="background: #044e39; color: #ffffff;">ব্রাহ্মণবাড়িয়া (Brahmanbaria)</option>
                    <option value="Chandpur" style="background: #044e39; color: #ffffff;">চাঁদপুর (Chandpur)</option>
                    <option value="Rajshahi" style="background: #044e39; color: #ffffff;">রাজশাহী (Rajshahi)</option>
                    <option value="Natore" style="background: #044e39; color: #ffffff;">নাটোর (Natore)</option>
                    <option value="Naogaon" style="background: #044e39; color: #ffffff;">নওগাঁ (Naogaon)</option>
                    <option value="Chapai Nawabganj" style="background: #044e39; color: #ffffff;">চাপাইনবাবগঞ্জ (Chapai Nawabganj)</option>
                    <option value="Pabna" style="background: #044e39; color: #ffffff;">পাবনা (Pabna)</option>
                    <option value="Sirajganj" style="background: #044e39; color: #ffffff;">সিরাজগঞ্জ (Sirajganj)</option>
                    <option value="Bogra" style="background: #044e39; color: #ffffff;">বগুড়া (Bogra)</option>
                    <option value="Joypurhat" style="background: #044e39; color: #ffffff;">জয়পুরহাট (Joypurhat)</option>
                    <option value="Khulna" style="background: #044e39; color: #ffffff;">খুলনা (Khulna)</option>
                    <option value="Barisal" style="background: #044e39; color: #ffffff;">বরিশাল (Barisal)</option>
                    <option value="Sylhet" style="background: #044e39; color: #ffffff;">সিলেট (Sylhet)</option>
                    <option value="Rangpur" style="background: #044e39; color: #ffffff;">রংপুর (Rangpur)</option>
                    <option value="Mymensingh" style="background: #044e39; color: #ffffff;">ময়মনসিংহ (Mymensingh)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 750px; margin: 35px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 24px; padding: 32px; box-shadow: 0 20px 45px rgba(0,0,0,0.4);">
            
            <!-- Current Active Waqt Banner -->
            <div style="padding: 18px 24px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 16px; margin-bottom: 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;">
                <div>
                    <div style="font-size: 0.85rem; color: #fde047; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">বর্তমান ওয়াক্ত</div>
                    <div style="font-size: 1.4rem; font-weight: 900; color: #ffffff;" id="prayerPageCurrentWaqt">ফজর (Fajr)</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.85rem; color: #a7f3d0; font-weight: 700;" id="prayerPageNextLabel">পরবর্তী ওয়াক্ত: সূর্যোদয়</div>
                    <div style="font-size: 1rem; font-weight: 800; color: #fef08a; margin-top: 2px;" id="prayerPageCountdown">
                        <i class="fas fa-hourglass-half" style="color: #6ee7b7; margin-right: 4px;"></i> গণনা হচ্ছে...
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px; font-size: 0.9rem; color: #a7f3d0; text-align: center; font-weight: 600;" id="prayerPageHijriDate">
                <i class="fas fa-moon" style="margin-right: 4px; color: #6ee7b7;"></i> হিজরী তারিখ লোড হচ্ছে...
            </div>

            <!-- Prayer Rows -->
            <div style="display: grid; gap: 12px;" id="prayerPageRowsContainer">
                <div id="page-row-fajr" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-cloud-moon" style="color: #60a5fa; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">ফজর (Fajr)</span>
                    </div>
                    <span id="pageTimeFajr" style="font-weight: 800; font-size: 1.1rem; color: #fef08a; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>

                <div id="page-row-sunrise" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.05); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.08); opacity: 0.85;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-sun" style="color: #fde047; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">সূর্যোদয় (Sunrise)</span>
                    </div>
                    <span id="pageTimeSunrise" style="font-weight: 700; font-size: 1.05rem; color: #ffffff; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>

                <div id="page-row-dhuhr" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-sun" style="color: #f59e0b; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">যোহর (Dhuhr)</span>
                    </div>
                    <span id="pageTimeDhuhr" style="font-weight: 800; font-size: 1.1rem; color: #fef08a; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>

                <div id="page-row-asr" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-cloud-sun-rain" style="color: #fb923c; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">আসর (Asr)</span>
                    </div>
                    <span id="pageTimeAsr" style="font-weight: 800; font-size: 1.1rem; color: #fef08a; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>

                <div id="page-row-maghrib" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-moon" style="color: #a7f3d0; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">মাগরিব (Maghrib)</span>
                    </div>
                    <span id="pageTimeMaghrib" style="font-weight: 800; font-size: 1.1rem; color: #fef08a; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>

                <div id="page-row-isha" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: rgba(255, 255, 255, 0.08); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-star-and-crescent" style="color: #818cf8; font-size: 1.2rem; width: 24px; text-align: center;"></i>
                        <span style="font-weight: 700; font-size: 1.05rem;">এশা (Isha)</span>
                    </div>
                    <span id="pageTimeIsha" style="font-weight: 800; font-size: 1.1rem; color: #fef08a; font-family: 'Outfit', sans-serif;">--:--</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const districtNamesBn = {
        'Dhaka': 'ঢাকা', 'Gazipur': 'গাজীপুর', 'Kishoreganj': 'কিশোরগঞ্জ', 'Manikganj': 'মানিকগঞ্জ', 'Munshiganj': 'মুন্সীগঞ্জ', 'Narayanganj': 'নারায়ণগঞ্জ', 'Narsingdi': 'নরসিংদী', 'Faridpur': 'ফরিদপুর', 'Gopalganj': 'গোপালগঞ্জ', 'Madaripur': 'মাদারীপুর', 'Rajbari': 'রাজবাড়ী', 'Shariatpur': 'শরীয়তপুর', 'Tangail': 'টাঙ্গাইল',
        'Chittagong': 'চট্টগ্রাম', "Cox's Bazar": 'কক্সবাজার', 'Bandarban': 'বান্দরবান', 'Khagrachhari': 'খাগড়াছড়ি', 'Rangamati': 'রাঙ্গামাটি', 'Noakhali': 'নোয়াখালী', 'Feni': 'ফেনী', 'Lakshmipur': 'লক্ষ্মীপুর', 'Comilla': 'কুমিল্লা', 'Brahmanbaria': 'ব্রাহ্মণবাড়িয়া', 'Chandpur': 'চাঁদপুর',
        'Rajshahi': 'রাজশাহী', 'Natore': 'নাটোর', 'Naogaon': 'নওগাঁ', 'Chapai Nawabganj': 'চাঁপাইনবাবগঞ্জ', 'Pabna': 'পাবনা', 'Sirajganj': 'সিরাজগঞ্জ', 'Bogra': 'বগুড়া', 'Joypurhat': 'জয়পুরহাট',
        'Khulna': 'খুলনা', 'Bagerhat': 'বাগেরহাট', 'Satkhira': 'সাতক্ষীরা', 'Jashore': 'যশোর', 'Magura': 'মাগুরা', 'Narail': 'নড়াইল', 'Jhenaidah': 'ঝিনাইদহ', 'Kushtia': 'কুষ্টিয়া', 'Meherpur': 'মেহেরপুর', 'Chuadanga': 'চুয়াডাঙ্গা',
        'Barisal': 'বরিশাল', 'Bhola': 'ভোলা', 'Jhalokati': 'ঝালকাঠি', 'Pirojpur': 'পিরোজপুর', 'Barguna': 'বরগুনা', 'Patuakhali': 'পটুয়াখালী',
        'Sylhet': 'সিলেট', 'Moulvibazar': 'মৌলভীবাজার', 'Sunamganj': 'সুনামগঞ্জ', 'Habiganj': 'হবিগঞ্জ',
        'Rangpur': 'রংপুর', 'Dinajpur': 'দিনাজপুর', 'Gaibandha': 'গাইবান্ধা', 'Kurigram': 'কুড়িগ্রাম', 'Lalmonirhat': 'লালমনিরহাট', 'Nilphamari': 'নীলফামারী', 'Panchagarh': 'পঞ্চগড়', 'Thakurgaon': 'ঠাকুরগাঁও',
        'Mymensingh': 'ময়মনসিংহ', 'Jamalpur': 'জামালপুর', 'Netrokona': 'নেত্রকোণা', 'Sherpur': 'শেরপুর'
    };

    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function formatTime12h(time24) {
        if (!time24) return '';
        let [hours, minutes] = time24.split(':');
        hours = parseInt(hours, 10);
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        let strHrs = hours < 10 ? '0' + hours : hours;
        return toBnNum(strHrs + ':' + minutes) + ' ' + ampm;
    }

    let cachedTimings = null;

    function timeToMins(tStr) {
        if (!tStr) return 0;
        const [h, m] = tStr.split(':').map(Number);
        return h * 60 + m;
    }

    function updatePageWaqtAndCountdown() {
        if (!cachedTimings) return;
        const fajr = timeToMins(cachedTimings.Fajr);
        const sunrise = timeToMins(cachedTimings.Sunrise);
        const dhuhr = timeToMins(cachedTimings.Dhuhr);
        const asr = timeToMins(cachedTimings.Asr);
        const maghrib = timeToMins(cachedTimings.Maghrib);
        const isha = timeToMins(cachedTimings.Isha);

        const now = new Date();
        const nowMins = now.getHours() * 60 + now.getMinutes();

        let currentWaqt = '';
        let currentKey = '';
        let nextWaqt = '';
        let nextMins = 0;

        if (nowMins < fajr) {
            currentWaqt = 'এশা (Isha)';
            currentKey = 'isha';
            nextWaqt = 'ফজর (Fajr)';
            nextMins = fajr;
        } else if (nowMins >= fajr && nowMins < sunrise) {
            currentWaqt = 'ফজর (Fajr)';
            currentKey = 'fajr';
            nextWaqt = 'সূর্যোদয় (Sunrise)';
            nextMins = sunrise;
        } else if (nowMins >= sunrise && nowMins < dhuhr) {
            currentWaqt = 'ইশরাক / চাশত';
            currentKey = '';
            nextWaqt = 'যোহর (Dhuhr)';
            nextMins = dhuhr;
        } else if (nowMins >= dhuhr && nowMins < asr) {
            currentWaqt = 'যোহর (Dhuhr)';
            currentKey = 'dhuhr';
            nextWaqt = 'আসর (Asr)';
            nextMins = asr;
        } else if (nowMins >= asr && nowMins < maghrib) {
            currentWaqt = 'আসর (Asr)';
            currentKey = 'asr';
            nextWaqt = 'মাগরিব (Maghrib)';
            nextMins = maghrib;
        } else if (nowMins >= maghrib && nowMins < isha) {
            currentWaqt = 'মাগরিব (Maghrib)';
            currentKey = 'maghrib';
            nextWaqt = 'এশা (Isha)';
            nextMins = isha;
        } else {
            currentWaqt = 'এশা (Isha)';
            currentKey = 'isha';
            nextWaqt = 'ফজর (Fajr)';
            nextMins = fajr + 1440;
        }

        let diff = nextMins - nowMins;
        if (diff < 0) diff += 1440;

        let hrs = Math.floor(diff / 60);
        let mins = diff % 60;
        let countdownStr = '';
        if (hrs > 0) {
            countdownStr += toBnNum(hrs) + ' ঘণ্টা ';
        }
        countdownStr += toBnNum(mins) + ' মিনিট বাকি';

        document.getElementById('prayerPageCurrentWaqt').innerText = currentWaqt;
        document.getElementById('prayerPageNextLabel').innerText = 'পরবর্তী ওয়াক্ত: ' + nextWaqt;
        document.getElementById('prayerPageCountdown').innerHTML = '<i class="fas fa-hourglass-half" style="color: #6ee7b7; margin-right: 4px;"></i> ' + countdownStr;

        // Highlight active row
        ['fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'isha'].forEach(k => {
            const row = document.getElementById('page-row-' + k);
            if (row) {
                if (k === currentKey) {
                    row.style.background = 'rgba(245, 158, 11, 0.22)';
                    row.style.border = '2px solid #f59e0b';
                } else {
                    row.style.background = (k === 'sunrise') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.08)';
                    row.style.border = (k === 'sunrise') ? '1px solid rgba(255, 255, 255, 0.08)' : '1px solid rgba(255, 255, 255, 0.12)';
                }
            }
        });
    }

    function fetchPrayerTimesPage(city) {
        const locLabel = (districtNamesBn[city] || city) + ', বাংলাদেশ';
        document.getElementById('prayerPageLocation').innerText = locLabel;

        fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=Bangladesh&method=1`)
            .then(res => res.json())
            .then(data => {
                if (data && data.data) {
                    cachedTimings = data.data.timings;
                    const timings = cachedTimings;
                    if (timings.Fajr) document.getElementById('pageTimeFajr').innerText = formatTime12h(timings.Fajr);
                    if (timings.Sunrise) document.getElementById('pageTimeSunrise').innerText = formatTime12h(timings.Sunrise);
                    if (timings.Dhuhr) document.getElementById('pageTimeDhuhr').innerText = formatTime12h(timings.Dhuhr);
                    if (timings.Asr) document.getElementById('pageTimeAsr').innerText = formatTime12h(timings.Asr);
                    if (timings.Maghrib) document.getElementById('pageTimeMaghrib').innerText = formatTime12h(timings.Maghrib);
                    if (timings.Isha) document.getElementById('pageTimeIsha').innerText = formatTime12h(timings.Isha);

                    if (data.data.date && data.data.date.hijri) {
                        const h = data.data.date.hijri;
                        document.getElementById('prayerPageHijriDate').innerHTML = `<i class="fas fa-moon" style="margin-right: 4px; color: #6ee7b7;"></i> ${toBnNum(h.day)} ${h.month.en} ${toBnNum(h.year)} হিজরী`;
                    }

                    updatePageWaqtAndCountdown();
                }
            });
    }

    function changePrayerPageLocation(city) {
        fetchPrayerTimesPage(city);
    }

    // Auto-init & interval update
    fetchPrayerTimesPage('Dhaka');
    setInterval(updatePageWaqtAndCountdown, 30000);
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
