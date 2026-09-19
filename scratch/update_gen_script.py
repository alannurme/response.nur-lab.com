import re

filepath = r"c:\xampp\htdocs\response.nur-lab.com\app\Views\modules\prophets_tree\index.php"
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. New Era Dividers & Levels HTML
new_html_levels = """                        <!-- ERA 1: ADAMIC ERA -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge"><i class="fa-solid fa-seedling"></i> ১ম ও ২য় প্রজন্ম: আদমী সূচনা</span>
                        </div>

                        <!-- LEVEL 1: Adam & Hawwa -->
                        <div class="tree-level-row">
                            <div class="node-card-item active-selected" id="node-adam" onclick="selectPersonNode('adam')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-crown"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">آدَم (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত আদম (আঃ)</div>
                                    <div class="meta-subtitle-text">মানবজাতির ১ম পিতা & ১ম নবী</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-hawwa" onclick="selectPersonNode('hawwa')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-venus"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">حَوَّاء</div>
                                    <div class="bengali-title-text">আম্মাজান হাওয়া (আঃ)</div>
                                    <div class="meta-subtitle-text">মানবজাতির প্রথম আদি মাতা</div>
                                </div>
                                <span class="status-tag-badge tag-blue">আদি মাতা</span>
                            </div>
                        </div>

                        <!-- LEVEL 2: Children of Adam -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-sheeth" onclick="selectPersonNode('sheeth')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-scroll"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">شِيث (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত শীস (আঃ)</div>
                                    <div class="meta-subtitle-text">৫০ আসমানী সহীফাপ্রাপ্ত ২য় নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">২য় প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-habil" onclick="selectPersonNode('habil')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-user-shield"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">هَابِيل</div>
                                    <div class="bengali-title-text">হাবিল (Abel)</div>
                                    <div class="meta-subtitle-text">আদম (আঃ)-এর পুণ্যবান শহীদ পুত্র</div>
                                </div>
                                <span class="status-tag-badge tag-purple">২য় প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-qabil" style="border-color: #ef4444;" onclick="selectPersonNode('qabil')">
                                <div class="card-halo-icon" style="background: #fee2e2; color: #dc2626;"><i class="fa-solid fa-user-xmark"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: #dc2626;">قَابِيل</div>
                                    <div class="bengali-title-text">কাবিল (Cain)</div>
                                    <div class="meta-subtitle-text">আদম (আঃ)-এর অবাধ্য ১ম পুত্র</div>
                                </div>
                                <span class="status-tag-badge" style="background: #fee2e2; color: #b91c1c; border-color: #fca5a5;">২য় প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- ERA 2: ANTE-DILUVIAN & NUH ERA -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge" style="border-color: var(--teal-main); color: var(--teal-main);"><i class="fa-solid fa-water"></i> ৩য় থেকে ৬ষ্ঠ প্রজন্ম: প্রাক-প্লাবন ও নূহ (আঃ)-এর বংশধারা</span>
                        </div>

                        <!-- LEVEL 3: Anush & Idris -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-anush" onclick="selectPersonNode('anush')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-route"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">أَنُوش ➔ يَارِد</div>
                                    <div class="bengali-title-text">আনূশ ➔ ইয়ারিদ</div>
                                    <div class="meta-subtitle-text">শীস (আঃ)-এর পরবর্তী পবিত্র বংশধারা</div>
                                </div>
                                <span class="status-tag-badge tag-blue">৩য় প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-idris" onclick="selectPersonNode('idris')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-pen-nib"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">إِدْرِيس (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইদ্রিস (আঃ)</div>
                                    <div class="meta-subtitle-text">প্রথম কলম ও পোশাক উদ্ভাবক নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">৪র্থ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 4: Nuh (Noah) -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-nuh" onclick="selectPersonNode('nuh')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-ship"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">نُوح (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত নূহ (আঃ)</div>
                                    <div class="meta-subtitle-text">মানবজাতির ২য় পিতা (কিশতী)</div>
                                </div>
                                <span class="status-tag-badge tag-gold">৫ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-hud" onclick="selectPersonNode('hud')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-wind"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">هُود (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত হূদ (আঃ)</div>
                                    <div class="meta-subtitle-text">আদ জাতির প্রতি প্রেরিত নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">প্রাক-ইব্রাহিমি</span>
                            </div>

                            <div class="node-card-item" id="node-saleh" onclick="selectPersonNode('saleh')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-mountain"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">صَالِح (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত সালেহ (আঃ)</div>
                                    <div class="meta-subtitle-text">সামূদ জাতি ও মুজিযার উটনী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">প্রাক-ইব্রাহিমি</span>
                            </div>
                        </div>

                        <!-- LEVEL 5: Sons of Nuh -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-shem" onclick="selectPersonNode('shem')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-crown"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">سَام (Shem)</div>
                                    <div class="bengali-title-text">সাম (Shem)</div>
                                    <div class="meta-subtitle-text">সামি জাতি ও সকল নবীদের পিতা</div>
                                </div>
                                <span class="status-tag-badge tag-blue">৬ষ্ঠ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-ham" onclick="selectPersonNode('ham')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-globe-africa"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">حَام (Ham)</div>
                                    <div class="bengali-title-text">হাম (Ham)</div>
                                    <div class="meta-subtitle-text">আফ্রিকা মহাদেশের আদি পুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-purple">৬ষ্ঠ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-yafith" onclick="selectPersonNode('yafith')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-globe-asia"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">يَافِث (Japheth)</div>
                                    <div class="bengali-title-text">ইয়াফিস (Japheth)</div>
                                    <div class="meta-subtitle-text">এশিয়া ও ইউরোপীয় মহাদেশের আদি পিতা</div>
                                </div>
                                <span class="status-tag-badge tag-teal">৬ষ্ঠ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 6: Tarih (Terah) -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-tarih" onclick="selectPersonNode('tarih')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-tree"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">تَارَح (আজোর)</div>
                                    <div class="bengali-title-text">তারেখ (আজোর / Terah)</div>
                                    <div class="meta-subtitle-text">ইব্রাহিম (আঃ)-এর পিতা & সামি পূর্বপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-blue">৭ম প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- ERA 3: IBRAHIMIC ERA -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge" style="border-color: var(--gold-main); color: var(--gold-main);"><i class="fa-solid fa-kaaba"></i> ৮ম ও ৯box প্রজন্ম: ইব্রাহিমি শাখা ও সন্তানগণ</span>
                        </div>

                        <!-- LEVEL 7: Ibrahim, Sarah, Hajar, Keturah, Lut -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-ibrahim" style="width: 350px; background: #fffdf5; border: 2.2px solid var(--gold-main);" onclick="selectPersonNode('ibrahim')">
                                <div class="card-halo-icon halo-gold" style="width: 52px; height: 52px; font-size: 1.5rem;"><i class="fa-solid fa-kaaba"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main); font-size: 1.45rem;">إِبْرَاهِيم (عليه السلام)</div>
                                    <div class="bengali-title-text" style="font-size: 1.15rem;">হযরত ইব্রাহিম (আঃ)</div>
                                    <div class="meta-subtitle-text">আবুল আম্বিয়া (নবীকুলের পিতা)</div>
                                </div>
                                <span class="status-tag-badge tag-gold">৮ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-sarah" onclick="selectPersonNode('sarah')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-gem"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">سَارَة (عليها السلام)</div>
                                    <div class="bengali-title-text">সাইয়্যেদা সারাহ (আঃ)</div>
                                    <div class="meta-subtitle-text">ইসহাক (আঃ)-এর সম্মানিত মাতা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">সম্মানিতা মাতা</span>
                            </div>

                            <div class="node-card-item" id="node-hajar" onclick="selectPersonNode('hajar')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-droplet"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">هَاجَر (عليها السلام)</div>
                                    <div class="bengali-title-text">আম্মাজান হাজেরা (আঃ)</div>
                                    <div class="meta-subtitle-text">ইসমাইল (আঃ)-এর মাতা & সাফা-মারওয়া প্রবর্তক</div>
                                </div>
                                <span class="status-tag-badge tag-teal">সম্মানিতা মাতা</span>
                            </div>

                            <div class="node-card-item" id="node-keturah" onclick="selectPersonNode('keturah')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-ring"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">قَطُورَة</div>
                                    <div class="bengali-title-text">ক্বাতূরা (Keturah)</div>
                                    <div class="meta-subtitle-text">ইব্রাহিম (আঃ)-এর স্ত্রী (মাদায়েন শাখা)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">সম্মানিতা স্ত্রী</span>
                            </div>

                            <div class="node-card-item" id="node-lut" onclick="selectPersonNode('lut')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-house-chimney-crack"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">لُوط (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত লূত (আঃ)</div>
                                    <div class="meta-subtitle-text">সদুম জাতির প্রতি প্রেরিত নবী (ভাতিজা)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">৮ম প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 8: Ismail, Ishaq, Madyan, Shuayb -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-ismail" onclick="selectPersonNode('ismail')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-star"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">إِسْمَاعِيل (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইসমাইল (আঃ)</div>
                                    <div class="meta-subtitle-text">যবীহুল্লাহ (আরব কুরাইশ শাখা)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">৯ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-ishaq" onclick="selectPersonNode('ishaq')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-sun"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">إِسْحَاق (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইসহাক (আঃ)</div>
                                    <div class="meta-subtitle-text">বনী ইসরাঈল আম্বিয়াদের মূল</div>
                                </div>
                                <span class="status-tag-badge tag-teal">৯ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-madyan" onclick="selectPersonNode('madyan')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-caravan"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">مَدْيَن</div>
                                    <div class="bengali-title-text">মাদায়েন (Midian)</div>
                                    <div class="meta-subtitle-text">ইব্রাহিম (আঃ) ও ক্বাতূরার পুত্র</div>
                                </div>
                                <span class="status-tag-badge tag-blue">৯ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-shuayb" onclick="selectPersonNode('shuayb')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-scale-balanced"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">شُعَيْب (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত শুআইব (আঃ)</div>
                                    <div class="meta-subtitle-text">খতীমুল আম্বিয়া (মাদায়েন)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১০ম প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- ERA 4: BANI ISRAEL & ADNAN ERA -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge" style="border-color: #7c3aed; color: #7c3aed;"><i class="fa-solid fa-scroll"></i> ১০ম থেকে ১৩শ প্রজন্ম: আদনানী শাখা ও ইয়াকুবের সন্তানগণ</span>
                        </div>

                        <!-- LEVEL 9: Adnan, Yaqub, Ayyub -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-adnan" onclick="selectPersonNode('adnan')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-crown"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">عَدْنَان</div>
                                    <div class="bengali-title-text">عدنان (আদনান)</div>
                                    <div class="meta-subtitle-text">আদনানী আরব ও পূর্বপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-blue">১০ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-yaqub" onclick="selectPersonNode('yaqub')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-users"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">يَعْقُوب (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইয়াকুব (আঃ)</div>
                                    <div class="meta-subtitle-text">ইসরাঈল (১২ গোত্রের সম্মানিত পিতা)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১০ম প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-ayyub" onclick="selectPersonNode('ayyub')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-heart-pulse"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">أَيُّوب (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত আইয়ুব (আঃ)</div>
                                    <div class="meta-subtitle-text">ধৈর্য ও সবরের কালজয়ী প্রতীক</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১০ম প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 10: Abdul Muttalib, Sons of Yaqub, Dhul-Kifl, Yunus -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-abdulmuttalib" onclick="selectPersonNode('abdulmuttalib')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-landmark"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">عَبْدُ المُطَّلِب</div>
                                    <div class="bengali-title-text">হযরত আব্দুল মুত্তালিব</div>
                                    <div class="meta-subtitle-text">কুরাইশদের সরদার & দাদা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-yusuf" onclick="selectPersonNode('yusuf')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-gem"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">يُوسُف (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইউসুফ (আঃ)</div>
                                    <div class="meta-subtitle-text">আহসানুল কাছাছ & আজিজে মিসর</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-binyamin" onclick="selectPersonNode('binyamin')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-user-check"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">بِنْيَامِين</div>
                                    <div class="bengali-title-text">বিনইয়ামিন (Benjamin)</div>
                                    <div class="meta-subtitle-text">ইউসুফ (আঃ)-এর সহোদর ছোট ভাই</div>
                                </div>
                                <span class="status-tag-badge tag-blue">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-lawi" onclick="selectPersonNode('lawi')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-book-bookmark"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">لاَوِي (Levi)</div>
                                    <div class="bengali-title-text">লাবী (Levi)</div>
                                    <div class="meta-subtitle-text">মূসা ও হারূনের পূর্বপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-yahuda" onclick="selectPersonNode('yahuda')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-shield-cat"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">يَهُوذَا (Judah)</div>
                                    <div class="bengali-title-text">ইয়াহূদা (Judah)</div>
                                    <div class="meta-subtitle-text">দাউদ (আঃ)-এর পূর্বপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-dhulkifl" onclick="selectPersonNode('dhulkifl')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-shield-halved"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">ذُو الكِفْل (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত যুল-কিফল (আঃ)</div>
                                    <div class="meta-subtitle-text">আইয়ুব (আঃ)-এর পুণ্যবান সন্তান</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১১শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-yunus" onclick="selectPersonNode('yunus')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-fish"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">يُونُس (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইউনুস (আঃ)</div>
                                    <div class="meta-subtitle-text">যাল-নূন (মাছের পেটের নবী)</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১১শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 11: Abdullah, Aminah, Zuleikha, Musa, Harun, Asiya, Safura, Khidr -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-abdullah" onclick="selectPersonNode('abdullah')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-feather-pointed"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">عَبْدُ الله</div>
                                    <div class="bengali-title-text">হযরত আব্দুল্লাহ</div>
                                    <div class="meta-subtitle-text">রাসুলুল্লাহ (সাঃ)-এর পিতা</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-aminah" onclick="selectPersonNode('aminah')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-flower"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">آمِنَة بِنْت وَهْب</div>
                                    <div class="bengali-title-text">আম্মাজান আমেনা (আঃ)</div>
                                    <div class="meta-subtitle-text">রাসুলুল্লাহ (সাঃ)-এর সম্মানিত মাতা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-zuleikha" onclick="selectPersonNode('zuleikha')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-heart"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">زُلَيْخَا</div>
                                    <div class="bengali-title-text">জুলাইখা (Zuleikha)</div>
                                    <div class="meta-subtitle-text">ইউসুফ (আঃ)-এর সহধর্মিণী</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-musa" onclick="selectPersonNode('musa')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-book-quran"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">مُوسَى (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত মূসা (আঃ)</div>
                                    <div class="meta-subtitle-text">কলীমুল্লাহ (তাওরাতপ্রাপ্ত রসূল)</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-harun" onclick="selectPersonNode('harun')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-handshake"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">هَارُون (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত হারূন (আঃ)</div>
                                    <div class="meta-subtitle-text">মূসা (আঃ)-এর সহোদর উযীর নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-asiya" onclick="selectPersonNode('asiya')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-person-shelter"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">آسِيَة (عليها السلام)</div>
                                    <div class="bengali-title-text">সাইয়্যেদা আছিয়া (আঃ)</div>
                                    <div class="meta-subtitle-text">মূসা (আঃ)-এর পালিকা মাতা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-safura" onclick="selectPersonNode('safura')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-hand-holding-heart"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">صَفُورَاء</div>
                                    <div class="bengali-title-text">সাইয়্যেদা সাফূরা (আঃ)</div>
                                    <div class="meta-subtitle-text">মূসা (আঃ)-এর সম্মানিত স্ত্রী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১২শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-khidr" onclick="selectPersonNode('khidr')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-compass"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">الخَضِر (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত খিজির (আঃ)</div>
                                    <div class="meta-subtitle-text">বাতিনী এলেমপ্রাপ্ত গায়বী শিক্ষক</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১২শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- ERA 5: FINAL PROPHET & ISRAELITE KINGS -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge" style="border-color: #059669; color: #059669;"><i class="fa-solid fa-star-and-crescent"></i> ১৩শ থেকে ১৮তম প্রজন্ম: বাদশাহ দাউদ, ঈসা ও রসূলুল্লাহ (সাঃ)</span>
                        </div>

                        <!-- LEVEL 12: Yusha, Shamwil, Talut, Dawud -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-yusha" onclick="selectPersonNode('yusha')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-sun-plant-wilt"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">يُوشَع بْن نُون (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইউশা বিন নূন (আঃ)</div>
                                    <div class="meta-subtitle-text">সূর্য থামিয়ে দেওয়ার মুজিযাপ্রাপ্ত নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৩শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-shamwil" onclick="selectPersonNode('shamwil')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-scroll"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">شَمْوِيل (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত শামউইল (আঃ)</div>
                                    <div class="meta-subtitle-text">তালুতকে রাজা মনোনীতকারী নবী</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১৩শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-talut" onclick="selectPersonNode('talut')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-shield"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">طَالُوت (Saul)</div>
                                    <div class="bengali-title-text">তালুত (বাদশাহ তালুত)</div>
                                    <div class="meta-subtitle-text">কুরআনে বর্ণিত বীর রাজা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৩শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-dawud" onclick="selectPersonNode('dawud')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-music"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">دَاوُد (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত দাউদ (আঃ)</div>
                                    <div class="meta-subtitle-text">যবুর কিতাবপ্রাপ্ত বাদশাহ নবী</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১৩শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 13: Sulaiman, Uzair, Luqman, Ilyas, Al-Yasa, Imran -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-sulaiman" onclick="selectPersonNode('sulaiman')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-chess-king"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">سُلَيْمَان (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত সুলাইমান (আঃ)</div>
                                    <div class="meta-subtitle-text">বায়তুল মুকাদ্দাস ও বিশ্ব বাদশা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৪শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-uzair" onclick="selectPersonNode('uzair')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-hourglass-half"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">عُزَيْر (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত উযায়ের (আঃ)</div>
                                    <div class="meta-subtitle-text">১০০ বছর পর জীবিত মহাপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৪শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-luqman" onclick="selectPersonNode('luqman')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-lightbulb"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">لُقْمَان الحَكِيم</div>
                                    <div class="bengali-title-text">লুকমান আল-হাকীম</div>
                                    <div class="meta-subtitle-text">কুরআনে বর্ণিত প্রজ্ঞাবান মহাপুরুষ</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১৪শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-ilyas" onclick="selectPersonNode('ilyas')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-fire-flame-curved"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">إِلْيَاس (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইলিয়াস (আঃ)</div>
                                    <div class="meta-subtitle-text">মূর্তিপূজার বিরোধী নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৪শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-alyasa" onclick="selectPersonNode('alyasa')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-hands-holding-child"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">الْيَسَع (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত আল-ইয়াসা (আঃ)</div>
                                    <div class="meta-subtitle-text">ইলিয়াস (আঃ)-এর উত্তরাধিকারী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৪শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-imran" onclick="selectPersonNode('imran')">
                                <div class="card-halo-icon halo-blue"><i class="fa-solid fa-mosque"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--blue-main);">عِمْرَان</div>
                                    <div class="bengali-title-text">ইমরান (আলে ইমরান)</div>
                                    <div class="meta-subtitle-text">মারইয়াম (আঃ)-এর পিতা & ইমাম</div>
                                </div>
                                <span class="status-tag-badge tag-blue">১৪শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 14: Hanna, Maryam, Zakariya, Elizabeth -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-hanna" onclick="selectPersonNode('hanna')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-hands-holding"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">حَنَّة (Hanna)</div>
                                    <div class="bengali-title-text">হাজরাত হান্নাহ (আঃ)</div>
                                    <div class="meta-subtitle-text">মারইয়াম (আঃ)-এর সম্মানিত মাতা</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৫শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-maryam" onclick="selectPersonNode('maryam')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-spa"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">مَرْيَم (عليها السلام)</div>
                                    <div class="bengali-title-text">সাইয়্যেদা মারইয়াম (আঃ)</div>
                                    <div class="meta-subtitle-text">সর্বশ্রেষ্ঠ পূত-পবিত্রা নারী</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৫শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-zakariya" onclick="selectPersonNode('zakariya')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-hands-praying"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">زَكَرِيَّا (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত যাকারিয়া (আঃ)</div>
                                    <div class="meta-subtitle-text">মারইয়াম (আঃ)-এর অভিভাবক নবী</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৫শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-elizabeth" onclick="selectPersonNode('elizabeth')">
                                <div class="card-halo-icon halo-purple"><i class="fa-solid fa-spa"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--purple-main);">إِلِيشَبَع</div>
                                    <div class="bengali-title-text">ইলীসাবাৎ (Elisheba)</div>
                                    <div class="meta-subtitle-text">যাকারিয়া (আঃ)-এর স্ত্রী</div>
                                </div>
                                <span class="status-tag-badge tag-purple">১৫শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- LEVEL 15: Yahya & Isa -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-yahya" onclick="selectPersonNode('yahya')">
                                <div class="card-halo-icon halo-teal"><i class="fa-solid fa-leaf"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text">يَحْيَى (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ইয়াহ্ইয়া (আঃ)</div>
                                    <div class="meta-subtitle-text">যাকারিয়া (আঃ)-এর নিষ্পাপ পুত্র</div>
                                </div>
                                <span class="status-tag-badge tag-teal">১৬শ প্রজন্ম</span>
                            </div>

                            <div class="node-card-item" id="node-isa" onclick="selectPersonNode('isa')">
                                <div class="card-halo-icon halo-gold"><i class="fa-solid fa-dove"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main);">عِيسَى (عليه السلام)</div>
                                    <div class="bengali-title-text">হযরত ঈসা (আঃ)</div>
                                    <div class="meta-subtitle-text">রূহুল্লাহ (ইঞ্জীলপ্রাপ্ত রসূল)</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৬শ প্রজন্ম</span>
                            </div>
                        </div>

                        <!-- ERA 6: THE SEAL OF THE PROPHETS -->
                        <div class="era-section-divider">
                            <span class="era-pill-badge" style="border-color: #d97706; color: #d97706; background: #fffdf5;"><i class="fa-solid fa-star-and-crescent"></i> ১৮তম প্রজন্ম: খাতামুন্নাবিয়্যীন সর্বশ্রেষ্ঠ রসূলুল্লাহ (সাঃ)</span>
                        </div>

                        <!-- LEVEL 16: Prophet Muhammad (SAW) -->
                        <div class="tree-level-row">
                            <div class="node-card-item" id="node-muhammad" style="width: 380px; background: #fffdf5; border: 2.8px solid var(--gold-main); box-shadow: 0 6px 20px rgba(217, 119, 6, 0.2);" onclick="selectPersonNode('muhammad')">
                                <div class="card-halo-icon halo-gold" style="width: 55px; height: 55px; font-size: 1.6rem;"><i class="fa-solid fa-star-and-crescent"></i></div>
                                <div class="card-info-content">
                                    <div class="arabic-title-text" style="color: var(--gold-main); font-size: 1.45rem;">مُحَمَّدٌ رَسُولُ اللهِ (ﷺ)</div>
                                    <div class="bengali-title-text" style="font-size: 1.2rem;">হযরত মুহাম্মদ (সাঃ)</div>
                                    <div class="meta-subtitle-text" style="color: var(--teal-main); font-weight: 700;">خَاتَمُ النَّبِيِّيْن (সর্বশেষ রসূল)</div>
                                </div>
                                <span class="status-tag-badge tag-gold">১৮তম প্রজন্ম</span>
                            </div>
                        </div>"""

start_marker = "<!-- ERA 1: ADAM -->"
end_marker = "<!-- GRID VIEW -->"

idx_start = content.find(start_marker)
idx_end = content.find(end_marker)

if idx_start != -1 and idx_end != -1:
    content_before = content[:idx_start]
    content_after = content[idx_end:]
    
    # We also need to extract everything inside tree-nodes-vertical-wrapper
    # Let's replace correctly:
    # First find <div class="tree-nodes-vertical-wrapper">
    wrapper_start = content_before.rfind('<div class="tree-nodes-vertical-wrapper">')
    if wrapper_start != -1:
        new_content = content_before[:wrapper_start] + '<div class="tree-nodes-vertical-wrapper">\n' + new_html_levels + '\n                    </div>\n            </div>\n            </div>\n\n            ' + content_after
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print("SUCCESSFULLY_UPDATED_GENERATIONS")
    else:
        print("FAILED_TO_FIND_WRAPPER")
else:
    print("FAILED_TO_FIND_MARKERS")
