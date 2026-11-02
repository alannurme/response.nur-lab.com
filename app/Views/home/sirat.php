<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Seerah (সীরাতুন নবী ﷺ) Library with Google Drive PDF Reader -->
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
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;" id="pageSeerahTitle">সীরাতুন নবী ﷺ লাইব্রেরি (Seerah Books)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">বিশ্বখ্যাত সীরাত গ্রন্থসমূহ পড়ুন ও গুগল ড্রাইভ পিডিএফ অনলাইনে ব্রাউজ করুন</p>
                </div>
            </div>

            <div class="seerah-search-box-row" style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 280px; max-width: 100%;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                    <input type="text" id="pageSeerahSearchInput" oninput="filterSeerahBooks(this.value)" placeholder="সীরাত গ্রন্থ খুঁজুন..." style="width: 100%; padding: 9px 14px 9px 36px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; outline: none; font-family: 'Hind Siliguri', sans-serif; box-sizing: border-box;">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Layout Grid (Left Sidebar with Books + Right PDF Viewer) -->
    <div class="seerah-workspace-container" style="position: relative; z-index: 2; width: 100%; margin: 24px auto 0 auto; padding: 0 25px; box-sizing: border-box;">
        <div class="seerah-workspace-flex" style="display: flex; flex-wrap: wrap; gap: 24px; min-height: 75vh;">
            
            <!-- Left Sidebar: Seerah Books List (Exactly matching Hadith page sidebar) -->
            <div class="seerah-sidebar-box" style="width: 320px; flex-shrink: 0; background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; display: flex; flex-direction: column; overflow: hidden; height: calc(100vh - 120px); position: sticky; top: 100px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); z-index: 20;">
                
                <!-- Sidebar Top Label -->
                <div style="padding: 14px 16px; background: rgba(2, 44, 34, 0.95); border-bottom: 1px solid rgba(16, 185, 129, 0.2); display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-weight: 800; font-size: 0.95rem; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-book-journal-whills" style="color: #10b981;"></i>
                        <span>সীরাত গ্রন্থসমূহ</span>
                    </div>
                    <span style="font-size: 0.78rem; background: rgba(16, 185, 129, 0.25); color: #34d399; padding: 2px 8px; border-radius: 10px; font-weight: 700;" id="sidebarBookCountBadge">
                        <?= count($data['books'] ?? []) ?>টি বই
                    </span>
                </div>

                <!-- Sidebar Search Input -->
                <div style="padding: 10px 14px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); background: rgba(2, 44, 34, 0.85);">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6ee7b7; font-size: 0.85rem;"></i>
                        <input type="text" id="seerahSidebarSearch" oninput="filterSeerahBooks(this.value)" placeholder="বইয়ের নাম বা লেখক দিয়ে খুঁজুন..." style="width: 100%; padding: 9px 12px 9px 34px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 10px; color: #fff; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Scrollable Sidebar List Items -->
                <div style="flex: 1; overflow-y: auto; padding: 10px;" id="seerahSidebarList">
                    <!-- Dynamic Items via JS -->
                </div>
            </div>

            <!-- Right Main Area: Google Drive PDF Reader & Book Profile -->
            <div style="flex: 1; min-width: 300px; background: rgba(4, 47, 36, 0.75); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 26px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);" id="pageSeerahContentCard">
                <!-- PDF & Content via JS -->
            </div>

        </div>
    </div>
</div>

<style>
    /* Dedicated Page Styling & Mobile Responsiveness */
    .header-wrapper {
        display: none !important;
    }

    .seerah-book-item {
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        background: transparent;
    }

    .seerah-book-item:hover {
        background: rgba(255, 255, 255, 0.06);
    }

    .seerah-book-item.active {
        background: rgba(16, 185, 129, 0.22) !important;
        border: 1px solid #10b981 !important;
    }

    .pdf-viewer-frame {
        width: 100%;
        height: 75vh;
        min-height: 580px;
        border: none;
        border-radius: 14px;
        background: #0f172a;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
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
            padding: 16px 12px !important;
            border-radius: 14px !important;
            min-width: 100% !important;
        }
        .seerah-top-sub-banner {
            padding: 12px 16px !important;
        }
        .pdf-viewer-frame {
            height: 60vh !important;
            min-height: 440px !important;
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

    // Books provided dynamically from Database via Controller
    const dbBooks = <?= json_encode($books ?? $data['books'] ?? []) ?>;
    // Related articles
    const siteSeerahArticles = <?= json_encode($posts ?? $data['posts'] ?? []) ?>;

    let currentSelectedBookId = dbBooks.length > 0 ? dbBooks[0].id : null;

    /**
     * Convert Google Drive or web link to an embeddable preview link
     */
    function formatDriveEmbedUrl(url) {
        if (!url) return '';
        const trimmed = url.trim();
        
        // Google Drive /file/d/FILE_ID/view
        const match1 = trimmed.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (match1) {
            return 'https://drive.google.com/file/d/' + match1[1] + '/preview';
        }
        
        // Google Drive ?id=FILE_ID
        const match2 = trimmed.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (match2) {
            return 'https://drive.google.com/file/d/' + match2[1] + '/preview';
        }

        return trimmed;
    }

    /**
     * Render the left sidebar books list
     */
    function renderSeerahSidebar(filterQuery = "") {
        const sidebar = document.getElementById("seerahSidebarList");
        if (!sidebar) return;

        const q = filterQuery.toLowerCase().trim();
        const filtered = dbBooks.filter(b => 
            (b.title && b.title.toLowerCase().includes(q)) ||
            (b.author && b.author.toLowerCase().includes(q)) ||
            (b.description && b.description.toLowerCase().includes(q))
        );

        const countBadge = document.getElementById("sidebarBookCountBadge");
        if (countBadge) {
            countBadge.innerText = toBnNum(filtered.length) + "টি বই";
        }

        if (filtered.length === 0) {
            sidebar.innerHTML = `
                <div style="text-align: center; padding: 40px 10px; color: #a7f3d0; font-size: 0.88rem;">
                    <i class="fas fa-book-bookmark" style="font-size: 1.8rem; color: #10b981; margin-bottom: 10px; display: block;"></i>
                    কোনো গ্রন্থ পাওয়া যায়নি
                </div>
            `;
            return;
        }

        sidebar.innerHTML = filtered.map(b => {
            const isActive = b.id == currentSelectedBookId;
            const hasDrive = b.drive_link && b.drive_link.trim() !== '';
            const initial = (b.title || '').substring(0, 1);
            const color = b.color || '#10b981';

            return `
                <div onclick="selectSeerahBook(${b.id})" class="seerah-book-item ${isActive ? 'active' : ''}">
                    ${b.cover_image ? `
                        <img src="${b.cover_image}" alt="Cover" style="width: 38px; height: 46px; border-radius: 8px; object-fit: cover; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15);">
                    ` : `
                        <div style="width: 38px; height: 46px; border-radius: 8px; background: ${color}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.15rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15);">
                            ${initial}
                        </div>
                    `}
                    <div style="overflow: hidden; flex: 1;">
                        <div style="font-weight: 800; font-size: 0.95rem; color: ${isActive ? '#34d399' : '#ffffff'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            ${b.title}
                        </div>
                        <div style="font-size: 0.78rem; color: #a7f3d0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px;">
                            ${b.author || 'সীরাতুন্নবী ﷺ'}
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                            ${hasDrive ? `
                                <span style="font-size: 0.72rem; color: #6ee7b7; background: rgba(16, 185, 129, 0.25); padding: 1px 7px; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fab fa-google-drive"></i> PDF সংযুক্ত
                                </span>
                            ` : `
                                <span style="font-size: 0.72rem; color: #fde047; background: rgba(245, 158, 11, 0.2); padding: 1px 7px; border-radius: 6px; font-weight: 700;">
                                    শীঘ্রই আসছে
                                </span>
                            `}
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterSeerahBooks(q) {
        renderSeerahSidebar(q);
    }

    function selectSeerahBook(bookId) {
        currentSelectedBookId = bookId;
        renderSeerahSidebar(document.getElementById("seerahSidebarSearch").value || "");
        renderBookReader(bookId);
    }

    /**
     * Render the Right Content Workspace: PDF Viewer, Actions, and Information
     */
    function renderBookReader(bookId) {
        const body = document.getElementById("pageSeerahContentCard");
        if (!body) return;

        const book = dbBooks.find(b => b.id == bookId) || dbBooks[0];
        if (!book) {
            body.innerHTML = `
                <div style="text-align: center; padding: 60px 20px; color: #a7f3d0;">
                    <i class="fas fa-book-open" style="font-size: 2.5rem; color: #10b981; margin-bottom: 16px; display: block;"></i>
                    <h3 style="color: #fff; margin-bottom: 8px;">কোনো গ্রন্থ এখনও যুক্ত করা হয়নি</h3>
                    <p style="margin: 0;">অ্যাডমিন প্যানেল থেকে সীরাত গ্রন্থ ও গুগল ড্রাইভ পিডিএফ লিংক যুক্ত করুন।</p>
                </div>
            `;
            return;
        }

        const hasDrive = book.drive_link && book.drive_link.trim() !== '';
        const embedUrl = hasDrive ? formatDriveEmbedUrl(book.drive_link) : '';
        const directDriveLink = book.drive_link || '#';

        body.innerHTML = `
            <!-- Book Top Detail Banner -->
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 22px 24px; border-radius: 18px; margin-bottom: 22px; box-shadow: 0 10px 25px rgba(0,0,0,0.35);">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    
                    <div style="display: flex; align-items: center; gap: 16px; flex: 1; min-width: 260px;">
                        ${book.cover_image ? `
                            <img src="${book.cover_image}" alt="Cover" style="width: 60px; height: 75px; border-radius: 10px; object-fit: cover; box-shadow: 0 4px 14px rgba(0,0,0,0.4); border: 1.5px solid rgba(255,255,255,0.2);">
                        ` : `
                            <div style="width: 60px; height: 75px; border-radius: 10px; background: ${book.color || '#10b981'}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.7rem; box-shadow: 0 4px 14px rgba(0,0,0,0.4); border: 1.5px solid rgba(255,255,255,0.2); flex-shrink: 0;">
                                <i class="fas fa-book"></i>
                            </div>
                        `}
                        <div>
                            <div style="font-size: 1.4rem; font-weight: 900; color: #ffffff; line-height: 1.35; margin-bottom: 4px;">
                                ${book.title}
                            </div>
                            <div style="font-size: 0.95rem; color: #fef08a; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-pen-nib" style="color: #10b981;"></i> ${book.author || 'সীরাতুন্নবী ﷺ'}
                            </div>
                            ${book.description ? `
                                <div style="font-size: 0.85rem; color: #d1fae5; margin-top: 6px; line-height: 1.6; max-width: 650px;">
                                    ${book.description}
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <!-- Quick Viewer Action Buttons -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
                        ${hasDrive ? `
                            <a href="${directDriveLink}" target="_blank" style="background: rgba(16, 185, 129, 0.22); border: 1px solid #10b981; color: #34d399; padding: 7px 16px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='#10b981'; this.style.color='#fff';" onmouseout="this.style.background='rgba(16, 185, 129, 0.22)'; this.style.color='#34d399';">
                                <i class="fab fa-google-drive"></i> ড্রাইভে খুলুন
                            </a>
                            <button onclick="togglePdfFullscreen()" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; padding: 7px 16px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.22)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.12)';">
                                <i class="fas fa-expand"></i> ফুলস্ক্রিন
                            </button>
                        ` : ''}
                        <button onclick="shareBookLink('${book.title.replace(/'/g, "\\'")}')" style="background: rgba(59, 130, 246, 0.2); border: 1px solid #3b82f6; color: #60a5fa; padding: 7px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-share-nodes"></i> শেয়ার
                        </button>
                    </div>

                </div>
            </div>

            <!-- PDF Viewer Interactive Box -->
            <div id="pdfViewerContainer" style="position: relative; background: #071f18; border: 1.5px solid rgba(16,185,129,0.35); border-radius: 18px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.5);">
                
                ${hasDrive ? `
                    <!-- PDF Viewer Header Bar -->
                    <div style="background: rgba(2, 44, 34, 0.95); border-bottom: 1px solid rgba(16, 185, 129, 0.25); padding: 10px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #a7f3d0; font-weight: 700;">
                            <i class="fab fa-google-drive" style="color: #10b981; font-size: 1.05rem;"></i>
                            <span>গুগল ড্রাইভ ইনবিল্ট পিডিএফ ভিউয়ার</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <a href="${directDriveLink}" target="_blank" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #34d399; padding: 4px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-external-link-alt"></i> নতুন ট্যাবে খুলুন
                            </a>
                            <button onclick="reloadSeerahIframe()" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer;" title="ভিউয়ার রিলোড করুন">
                                <i class="fas fa-rotate-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Loader Spinner with auto-dismiss -->
                    <div id="pdfFrameLoader" style="position: absolute; top: 45px; left: 0; right: 0; bottom: 0; background: rgba(4, 47, 36, 0.95); display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 5; color: #a7f3d0; transition: opacity 0.3s ease;">
                        <i class="fas fa-circle-notch fa-spin" style="font-size: 2.2rem; color: #10b981; margin-bottom: 12px;"></i>
                        <div style="font-size: 0.95rem; font-weight: 700;">গুগল ড্রাইভ পিডিএফ লোড হচ্ছে...</div>
                        <div style="font-size: 0.78rem; color: #6ee7b7; margin-top: 4px;">অনুগ্রহ করে কয়েক সেকেন্ড অপেক্ষা করুন</div>
                    </div>

                    <iframe id="seerahPdfIframe" class="pdf-viewer-frame" src="${embedUrl}" onload="hidePdfLoader();" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>
                ` : `
                    <div style="text-align: center; padding: 70px 20px; color: #a7f3d0;">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 16px auto;">
                            <i class="fab fa-google-drive"></i>
                        </div>
                        <h3 style="color: #ffffff; font-size: 1.3rem; font-weight: 800; margin-bottom: 8px;">
                            এই গ্রন্থটির গুগল ড্রাইভ পিডিএফ লিংক এখনও যুক্ত করা হয়নি
                        </h3>
                        <p style="font-size: 0.92rem; color: #cbd5e1; max-width: 520px; margin: 0 auto 20px auto; line-height: 1.6;">
                            অ্যাডমিন প্যানেলে গিয়ে এই গ্রন্থের "সম্পাদনা" অপশনে গুগল ড্রাইভ পিডিএফ শেয়ার লিংক পেস্ট করলেই এখানে সরাসরি ইনবিল্ট রিডারে বই পড়া যাবে।
                        </p>
                        <a href="<?= URLROOT ?>/admin/edit_seerah_book/${book.id}" target="_blank" style="background: #10b981; color: white; border: none; padding: 10px 22px; border-radius: 12px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-link"></i> অ্যাডমিন প্যানেল থেকে ড্রাইভ লিংক যোগ করুন
                        </a>
                    </div>
                `}
            </div>

            <!-- Related Articles from database -->
            ${renderRelatedArticlesSection()}
        `;

        // Safety timeout: automatically fade out loader after 2.5s even if onload is delayed
        setTimeout(() => {
            hidePdfLoader();
        }, 2500);
    }

    function hidePdfLoader() {
        const loader = document.getElementById('pdfFrameLoader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.display = 'none'; }, 300);
        }
    }

    function reloadSeerahIframe() {
        const iframe = document.getElementById('seerahPdfIframe');
        const loader = document.getElementById('pdfFrameLoader');
        if (iframe) {
            if (loader) {
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
            const currentSrc = iframe.src;
            iframe.src = '';
            setTimeout(() => { iframe.src = currentSrc; }, 100);
        }
    }

    function togglePdfFullscreen() {
        const container = document.getElementById('pdfViewerContainer');
        if (!container) return;

        if (!document.fullscreenElement) {
            if (container.requestFullscreen) {
                container.requestFullscreen();
            } else if (container.webkitRequestFullscreen) {
                container.webkitRequestFullscreen();
            } else if (container.msRequestFullscreen) {
                container.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    function shareBookLink(title) {
        const shareUrl = window.location.href;
        const text = `${title} - সীরাতুন নবী ﷺ লাইব্রেরি`;

        if (navigator.share) {
            navigator.share({
                title: text,
                text: text,
                url: shareUrl
            }).catch(err => console.log('Share canceled/failed', err));
        } else {
            navigator.clipboard.writeText(shareUrl).then(() => {
                alert('সীরাত লাইব্রেরির লিংক ক্লিপবোর্ডে কপি করা হয়েছে!');
            });
        }
    }

    function renderRelatedArticlesSection() {
        if (!siteSeerahArticles || siteSeerahArticles.length === 0) return '';

        return `
            <div style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(16,185,129,0.3); padding: 24px; border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,0.35); margin-top: 25px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 14px;">
                    <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #fef08a; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-newspaper" style="color: #10b981;"></i> রাসূলুল্লাহ ﷺ সম্পর্কিত গবেষণামূলক নিবন্ধ ও প্রবন্ধ (${toBnNum(siteSeerahArticles.length)}টি)
                    </h3>
                    <span style="font-size: 0.8rem; color: #a7f3d0; background: rgba(16,185,129,0.2); padding: 4px 12px; border-radius: 20px;">
                        সীরাত ও নবীর চরিত্র
                    </span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
                    ${siteSeerahArticles.slice(0, 6).map(art => `
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

    // Initialize on page load
    document.addEventListener("DOMContentLoaded", function() {
        renderSeerahSidebar();
        if (currentSelectedBookId) {
            renderBookReader(currentSelectedBookId);
        }
    });
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
