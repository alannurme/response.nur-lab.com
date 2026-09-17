    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <a href="<?= URLROOT ?>/" class="brand" style="color: white; margin-bottom: 1rem;">
                        <i class="fa-solid fa-mosque"></i> Islamic Nur
                    </a>
                    <h3 style="margin-top: 1rem;">আমাদের সম্পর্কে</h3>
                    <p style="text-align: justify; max-width: 320px;">response with nur-lab একটি অলাভজনক অনলাইন প্ল্যাটফর্ম, যেখানে বিশ্বের বিভিন্ন প্রান্তের মুসলিম লেখকরা ইসলাম, দর্শন, বিজ্ঞান ও সমসাময়িক বিষয় নিয়ে আলোচনা ও গবেষণায় যুক্ত হন।</p>
                </div>
                <div class="footer-section">
                    <h3>প্রয়োজনীয় লিংক</h3>
                    <ul class="nav-links" style="flex-direction: column; gap: 0.5rem;">
                        <?php
                        $db = \Config\Database::pdoConnect();

                        $menus_stmt = $db->query("SELECT * FROM sub_menus ORDER BY order_index ASC");
                        $footer_menus = $menus_stmt->fetchAll();
                        foreach ($footer_menus as $menu):
                            $menu_url = (strpos($menu['url'], 'http') === 0) ? $menu['url'] : URLROOT . $menu['url'];
                        ?>
                            <li><a href="<?= $menu_url ?>" style="color: rgba(255,255,255,0.7)"><?= htmlspecialchars($menu['title']) ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="<?= URLROOT ?>/donate" style="color: rgba(255,255,255,0.7)">অনুদান দিন</a></li>
                        <?php if(isset($_SESSION['admin_id'])): ?>
                            <li><a href="<?= URLROOT ?>/admin" style="color: rgba(255,255,255,0.7)">ড্যাশবোর্ড</a></li>
                            <li><a href="<?= URLROOT ?>/admin/logout" style="color: rgba(255,255,255,0.7)">লগআউট</a></li>
                        <?php else: ?>
                            <li><a href="<?= URLROOT ?>/admin/login" style="color: rgba(255,255,255,0.7)">লগইন</a></li>
                            <li><a href="<?= URLROOT ?>/register" style="color: rgba(255,255,255,0.7)">রেজিস্ট্রেশন</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Subscribe</h3>
                    <p>Get latest updates directly to your inbox.</p>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                        <input type="email" placeholder="Email Address" style="padding: 0.8rem; border-radius: 50px; border: none; flex-grow: 1;">
                        <button class="btn" style="padding: 0.8rem 1.5rem;">Join</button>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); opacity: 0.6; font-size: 0.9rem;">
                &copy; <?= date('Y') ?> Islamic Nur Lab. All rights reserved.
            </div>
        </div>
    </footer>
    
    <a href="https://wa.me/yournumber" class="whatsapp-btn" target="_blank">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= URLROOT ?>/public/js/main.js"></script>
</body>
</html>
