<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Seerah (সীরাতুন নবী ﷺ) Full Page Container (Islamic Emerald Green Theme) -->
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
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-mosque"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">সীরাতুন নবী ﷺ (Prophetic Biography)</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">রাসূলুল্লাহ ﷺ-এর পুণ্যময় জীবনচরিত, ঐতিহাসিক অধ্যায় ও গবেষণামূলক আলোচনা</p>
                </div>
            </div>

            <!-- Search box -->
            <div style="position: relative; width: 280px; max-width: 100%;">
                <input type="text" id="seerahSearchInput" placeholder="সীরাতের অধ্যায় বা বিষয় খুঁজুন..." oninput="filterSeerahCards(this.value)" style="width: 100%; padding: 10px 14px 10px 38px; background: rgba(6, 78, 59, 0.8); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; color: #fff; font-size: 0.9rem; outline: none; font-family: 'Hind Siliguri', sans-serif; box-sizing: border-box;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #a7f3d0; font-size: 0.85rem;"></i>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 1200px; margin: 30px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        
        <!-- Quick Timeline Milestones Banner -->
        <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 20px; padding: 22px 25px; margin-bottom: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.35);">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #fef08a; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-history" style="color: #f59e0b;"></i> সীরাতের সংক্ষিপ্ত ঐতিহাসিক পরিক্রমা
                </h3>
                <span style="font-size: 0.82rem; color: #a7f3d0; background: rgba(255,255,255,0.08); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.15);">
                    ৫৭০ খ্রিষ্টাব্দ - ৬৩২ খ্রিষ্টাব্দ (৬৩ বছর)
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div style="background: rgba(6, 78, 59, 0.7); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 12px 14px;">
                    <strong style="color: #6ee7b7; font-size: 0.85rem; display: block;">১. মাক্কী যুগ (১ম পর্ব)</strong>
                    <span style="font-size: 0.78rem; color: #e2e8f0;">শুভ জন্ম, শৈশব, হিলফুল ফুযুল ও নবুওয়াত পূর্ব জীবন</span>
                </div>
                <div style="background: rgba(6, 78, 59, 0.7); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 12px 14px;">
                    <strong style="color: #6ee7b7; font-size: 0.85rem; display: block;">২. ওহী ও নবুওয়াত</strong>
                    <span style="font-size: 0.78rem; color: #e2e8f0;">হেরা গুহায় ওহী অবতরণ ও দাওয়াতের শুভ সূচনা</span>
                </div>
                <div style="background: rgba(6, 78, 59, 0.7); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 12px 14px;">
                    <strong style="color: #6ee7b7; font-size: 0.85rem; display: block;">৩. মি'রাজ ও হিজরত</strong>
                    <span style="font-size: 0.78rem; color: #e2e8f0;">ইসরা ও মি'রাজ, তাইফ সফর এবং পবিত্র মদীনায় হিজরত</span>
                </div>
                <div style="background: rgba(6, 78, 59, 0.7); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 12px 14px;">
                    <strong style="color: #6ee7b7; font-size: 0.85rem; display: block;">৪. মাদানী রাষ্ট্র ও বিজয়</strong>
                    <span style="font-size: 0.78rem; color: #e2e8f0;">মদীনা সনদ, বদর-উহুদ, মক্কা বিজয় ও বিদায় হজ</span>
                </div>
            </div>
        </div>

        <!-- Seerah Topics and Articles Grid -->
        <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-feather-pointed" style="color: #10b981;"></i> রাসূলুল্লাহ ﷺ সম্পর্কিত গুরুত্বপূর্ণ নিবন্ধসমূহ
            </h2>
            <span style="font-size: 0.85rem; color: #a7f3d0;" id="seerahArticlesCount">
                <?= count($data['posts'] ?? []) ?>টি আলোচনা
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;" id="seerahGridContainer">
            <?php if (!empty($data['posts'])): ?>
                <?php foreach ($data['posts'] as $post): ?>
                    <div class="seerah-post-card" data-title="<?= htmlspecialchars(mb_strtolower($post['title'], 'UTF-8')) ?>" style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 16px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease; box-shadow: 0 10px 25px rgba(0,0,0,0.25);" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#10b981';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(16, 185, 129, 0.25)';">
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <span style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;">
                                    <?= htmlspecialchars($post['main_category'] ?? 'সীরাত ও নবীর চরিত্র') ?>
                                </span>
                                <span style="font-size: 0.78rem; color: #94a3b8;">
                                    <i class="far fa-clock"></i> <?= !empty($post['created_at']) ? date('d M, Y', strtotime($post['created_at'])) : '' ?>
                                </span>
                            </div>

                            <a href="<?= URLROOT ?>/<?= htmlspecialchars($post['slug']) ?>" style="text-decoration: none; color: #ffffff;">
                                <h3 style="margin: 0 0 10px 0; font-size: 1.15rem; font-weight: 800; line-height: 1.45; font-family: 'Hind Siliguri', sans-serif;">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h3>
                            </a>

                            <?php if (!empty($post['excerpt'])): ?>
                                <p style="margin: 0; font-size: 0.88rem; color: #cbd5e1; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars(strip_tags($post['excerpt'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.8rem; color: #94a3b8;">
                                <i class="far fa-eye"></i> <?= number_format((int)($post['views'] ?? 0) + (int)($post['fake_views'] ?? 0)) ?> বার পড়া হয়েছে
                            </span>
                            <a href="<?= URLROOT ?>/<?= htmlspecialchars($post['slug']) ?>" style="background: #10b981; color: #ffffff; text-decoration: none; padding: 6px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.background='#059669';" onmouseout="this.style.background='#10b981';">
                                <span>সম্পূর্ণ পড়ুন</span>
                                <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: rgba(4, 47, 36, 0.6); border-radius: 16px;">
                    <i class="fas fa-book-open" style="font-size: 3rem; color: #10b981; opacity: 0.5; margin-bottom: 14px;"></i>
                    <p style="font-size: 1.1rem; color: #e2e8f0; margin: 0;">সীরাত বিষয়ক নিবন্ধসমূহ শীঘ্রই আসছে।</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="noSeerahMatches" style="display: none; text-align: center; padding: 50px 20px; background: rgba(4, 47, 36, 0.6); border-radius: 16px; margin-top: 20px;">
            <i class="fas fa-search" style="font-size: 2.5rem; color: #f59e0b; opacity: 0.6; margin-bottom: 12px;"></i>
            <p style="font-size: 1rem; color: #e2e8f0; margin: 0;">কোনো নিবন্ধ পাওয়া যায়নি। অন্য শব্দ দিয়ে খুঁজুন।</p>
        </div>

    </div>
</div>

<script>
    function filterSeerahCards(query) {
        const q = (query || '').trim().toLowerCase();
        const cards = document.querySelectorAll('.seerah-post-card');
        let count = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const text = card.textContent.toLowerCase();
            if (!q || title.includes(q) || text.includes(q)) {
                card.style.display = 'flex';
                count++;
            } else {
                card.style.display = 'none';
            }
        });

        const noMatch = document.getElementById('noSeerahMatches');
        if (noMatch) {
            noMatch.style.display = (count === 0 && cards.length > 0) ? 'block' : 'none';
        }

        const countEl = document.getElementById('seerahArticlesCount');
        if (countEl) {
            countEl.textContent = count + 'টি আলোচনা';
        }
    }
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
