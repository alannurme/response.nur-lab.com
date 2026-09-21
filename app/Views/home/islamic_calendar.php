<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Islamic Calendar Full Page Container (Islamic Emerald Green Theme) -->
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
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">ইসলামিক হিজরী ক্যালেন্ডার</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">হিজরী ও ঈসায়ী বর্ষপঞ্জি</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Container -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 780px; margin: 35px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 24px; padding: 28px; box-shadow: 0 20px 45px rgba(0,0,0,0.4);">
            
            <!-- Month Navigation Bar -->
            <div style="padding: 14px 20px; background: rgba(0, 0, 0, 0.18); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <button onclick="navCalMonth(-1)" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 7px 16px; border-radius: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; font-weight: 700;">
                    <i class="fas fa-chevron-left" style="margin-right: 4px;"></i> পূর্ববর্তী
                </button>
                <div style="text-align: center;">
                    <div style="font-size: 1.15rem; font-weight: 800; color: #fef08a;" id="calMonthTitle">সেপ্টেম্বর ২০২৬</div>
                    <div style="font-size: 0.85rem; color: #6ee7b7; font-weight: 600;" id="calHijriMonthTitle">রবীউস সানী ১৪৪৮ হিজরী</div>
                </div>
                <button onclick="navCalMonth(1)" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 7px 16px; border-radius: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; font-size: 0.88rem; font-weight: 700;">
                    পরবর্তী <i class="fas fa-chevron-right" style="margin-left: 4px;"></i>
                </button>
            </div>

            <!-- Days of Week Header -->
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); padding: 10px 10px 5px 10px; text-align: center; font-size: 0.9rem; font-weight: 800; color: #f59e0b; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div>রবি</div>
                <div>সোম</div>
                <div>মঙ্গল</div>
                <div>বুধ</div>
                <div>বৃহঃ</div>
                <div style="color: #6ee7b7;">শুক্রবার</div>
                <div>শনি</div>
            </div>

            <!-- Calendar Days Grid Container -->
            <div style="padding: 14px 0 20px 0; display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;" id="calendarDaysGrid">
                <!-- Rendered dynamically -->
            </div>

            <!-- Footer Info -->
            <div style="padding: 14px 20px; background: rgba(0, 0, 0, 0.25); text-align: center; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.85rem; color: #a7f3d0;">
                <i class="fas fa-star" style="color: #f59e0b; margin-right: 4px;"></i> চাঁদ দেখার উপর ভিত্তি করে হিজরী তারিখ ১ দিন কম-বেশি হতে পারে।
            </div>
        </div>
    </div>
</div>

<script>
    let currentCalDate = new Date();
    const bnMonths = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    const hijriMonthNamesBn = {
        1: 'মুহররম', 2: 'সফর', 3: 'রবিউল আউয়াল', 4: 'রবিউস সানি',
        5: 'জমাদিউল আউয়াল', 6: 'জমাদিউস সানি', 7: 'রজব', 8: 'শাবান',
        9: 'রমজান', 10: 'শাওয়াল', 11: 'জিলকদ', 12: 'জিলহজ'
    };

    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function navCalMonth(offset) {
        currentCalDate.setMonth(currentCalDate.getMonth() + offset);
        renderIslamicCalendar(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1);
    }

    function renderIslamicCalendar(year, month) {
        const monthTitle = bnMonths[month - 1] + ' ' + toBnNum(year);
        document.getElementById('calMonthTitle').innerText = monthTitle;
        document.getElementById('calHijriMonthTitle').innerText = 'হিজরী বর্ষপঞ্জি';
        
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 30px 0; color: #a7f3d0;"><i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 8px; display: block;"></i> ক্যালেন্ডার তথ্য লোড হচ্ছে...</div>';

        // Primary API Call to Aladhan API with fallback to Gregorian to Hijri algorithm
        fetch(`https://api.aladhan.com/v1/gregorianCalendar/${month}/${year}?latitude=23.8103&longitude=90.4125&method=1`)
            .then(res => res.json())
            .then(data => {
                if (data && data.data && data.data.length > 0) {
                    const firstHijriMonth = data.data[0].date.hijri.month.number;
                    const firstHijriYear = data.data[0].date.hijri.year;
                    const lastHijriMonth = data.data[data.data.length - 1].date.hijri.month.number;
                    const lastHijriYear = data.data[data.data.length - 1].date.hijri.year;
                    
                    let hTitle = (hijriMonthNamesBn[firstHijriMonth] || '') + ' ' + toBnNum(firstHijriYear);
                    if (firstHijriMonth !== lastHijriMonth) {
                        hTitle += ' - ' + (hijriMonthNamesBn[lastHijriMonth] || '') + ' ' + toBnNum(lastHijriYear);
                    }
                    document.getElementById('calHijriMonthTitle').innerText = hTitle + ' হিজরী';
                    renderCalendarFromDays(data.data, year, month);
                } else {
                    renderFallbackCalendar(year, month);
                }
            })
            .catch(err => {
                console.warn('Aladhan API failed, rendering offline fallback calendar:', err);
                renderFallbackCalendar(year, month);
            });
    }

    // Accurate offline Kuwaiti Algorithm Fallback for Hijri Calendar
    function g2h(d, m, y) {
        let day = d, month = m, year = y;
        if (month < 3) {
            year -= 1;
            month += 12;
        }
        let a = Math.floor(year / 100);
        let b = 2 - a + Math.floor(a / 4);
        let jd = Math.floor(365.25 * (year + 4716)) + Math.floor(30.6001 * (month + 1)) + day + b - 1524.5;
        let z = Math.floor(jd + 0.5);
        let i = Math.floor((z - 1867216.25) / 36524.25);
        let aa = z + 1 + i - Math.floor(i / 4);
        let bb = aa + 1524;
        let cc = Math.floor((bb - 122.1) / 365.25);
        let dd = Math.floor(365.25 * cc);
        let ee = Math.floor((bb - dd) / 30.6001);
        let dayG = bb - dd - Math.floor(30.6001 * ee);
        let monthG = (ee < 14) ? ee - 1 : ee - 13;
        let yearG = (monthG > 2) ? cc - 4716 : cc - 4715;

        let l = Math.floor(jd) - 1948440 + 10632;
        let n = Math.floor((l - 1) / 10631);
        l = l - 10631 * n + 354;
        let j = (Math.floor((10985 - l) / 5316)) * (Math.floor((50 * l) / 17719)) + (Math.floor(l / 5670)) * (Math.floor((43 * l) / 15238));
        l = l - (Math.floor((30 - j) / 15)) * (Math.floor((17719 * j) / 50)) - (Math.floor(j / 16)) * (Math.floor((15238 * j) / 43)) + 29;
        let monthH = Math.floor((24 * l) / 709);
        let dayH = l - Math.floor((709 * monthH) / 24);
        let yearH = 30 * n + j - 30;
        return { day: dayH, month: monthH, year: yearH };
    }

    function renderFallbackCalendar(year, month) {
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '';

        const daysInMonth = new Date(year, month, 0).getDate();
        const firstDayOfWeek = new Date(year, month - 1, 1).getDay();

        // Calculate Hijri Range for Header
        const firstH = g2h(1, month, year);
        const lastH = g2h(daysInMonth, month, year);
        let hTitle = (hijriMonthNamesBn[firstH.month] || '') + ' ' + toBnNum(firstH.year);
        if (firstH.month !== lastH.month) {
            hTitle += ' - ' + (hijriMonthNamesBn[lastH.month] || '') + ' ' + toBnNum(lastH.year);
        }
        document.getElementById('calHijriMonthTitle').innerText = hTitle + ' হিজরী';

        for (let i = 0; i < firstDayOfWeek; i++) {
            grid.appendChild(document.createElement('div'));
        }

        const today = new Date();
        const isCurrentMonth = today.getFullYear() === year && (today.getMonth() + 1) === month;

        for (let dayNum = 1; dayNum <= daysInMonth; dayNum++) {
            const isToday = isCurrentMonth && today.getDate() === dayNum;
            const hRes = g2h(dayNum, month, year);

            const card = document.createElement('div');
            card.style.cssText = `
                background: ${isToday ? 'rgba(245, 158, 11, 0.28)' : 'rgba(255, 255, 255, 0.08)'};
                border: ${isToday ? '2px solid #f59e0b' : '1px solid rgba(255, 255, 255, 0.12)'};
                border-radius: 12px;
                padding: 10px 4px;
                text-align: center;
                transition: all 0.2s ease;
            `;

            card.innerHTML = `
                <div style="font-size: 1.15rem; font-weight: 800; color: ${isToday ? '#fef08a' : '#ffffff'}; font-family: 'Outfit', sans-serif;">${toBnNum(dayNum)}</div>
                <div style="font-size: 0.75rem; font-weight: 700; color: #34d399; margin-top: 2px;">${toBnNum(hRes.day)}</div>
            `;
            grid.appendChild(card);
        }
    }

    function renderCalendarFromDays(monthDays, year, month) {
        const grid = document.getElementById('calendarDaysGrid');
        grid.innerHTML = '';
        if (!monthDays || monthDays.length === 0) return;

        const firstDay = monthDays[0];
        const dayOfWeekEn = firstDay.date.gregorian.weekday.en;
        const weekMap = { 'Sunday': 0, 'Monday': 1, 'Tuesday': 2, 'Wednesday': 3, 'Thursday': 4, 'Friday': 5, 'Saturday': 6 };
        const startPad = weekMap[dayOfWeekEn] || 0;

        for (let i = 0; i < startPad; i++) {
            const emptyDiv = document.createElement('div');
            grid.appendChild(emptyDiv);
        }

        const today = new Date();
        const isCurrentMonth = today.getFullYear() === year && (today.getMonth() + 1) === month;

        monthDays.forEach(item => {
            const dayNum = parseInt(item.date.gregorian.day, 10);
            const isToday = isCurrentMonth && today.getDate() === dayNum;
            const hijriDay = item.date.hijri.day;

            const card = document.createElement('div');
            card.style.cssText = `
                background: ${isToday ? 'rgba(245, 158, 11, 0.28)' : 'rgba(255, 255, 255, 0.08)'};
                border: ${isToday ? '2px solid #f59e0b' : '1px solid rgba(255, 255, 255, 0.12)'};
                border-radius: 12px;
                padding: 10px 4px;
                text-align: center;
                transition: all 0.2s ease;
            `;

            card.innerHTML = `
                <div style="font-size: 1.15rem; font-weight: 800; color: ${isToday ? '#fef08a' : '#ffffff'}; font-family: 'Outfit', sans-serif;">${toBnNum(dayNum)}</div>
                <div style="font-size: 0.75rem; font-weight: 700; color: #34d399; margin-top: 2px;">${toBnNum(hijriDay)}</div>
            `;
            grid.appendChild(card);
        });
    }

    renderIslamicCalendar(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1);
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
