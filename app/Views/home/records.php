<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Page Hero Header -->
<section style="padding: 70px 0 40px 0; background: linear-gradient(180deg, rgba(4, 62, 47, 0.05) 0%, rgba(255, 255, 255, 0) 100%);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; text-align: center;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(11, 124, 77, 0.1); color: var(--primary); padding: 8px 18px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; margin-bottom: 20px;">
            <i class="fas fa-database"></i> উন্মুক্ত তথ্যভাণ্ডার
        </div>
        <h1 style="font-size: 2.8rem; font-weight: 900; color: #0f172a; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
            <span style="color: var(--primary);">Records</span>
        </h1>
        <p style="color: #64748b; font-size: 1.15rem; max-width: 650px; margin: 0 auto; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
            উন্মুক্ত ডাটাবেজ ও ভেরিফায়েড ইসলামিক নলেজবেইজ তথ্যভাণ্ডার।
        </p>
    </div>
</section>

<!-- Content Section -->
<section style="padding: 40px 0 100px 0;">
    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <div style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; padding: 60px 40px; text-align: center;">
            <div style="width: 80px; height: 80px; margin: 0 auto 25px auto; background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; color: #10b981;">
                <i class="fas fa-database"></i>
            </div>
            <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">
                Records সেকশনে স্বাগতম
            </h2>
            <p style="color: #64748b; font-size: 1.05rem; max-width: 580px; margin: 0 auto 30px auto; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
                এই সেকশনের তথ্যভাণ্ডার প্রস্তুত হচ্ছে। খুব শীঘ্রই এখানে উন্মুক্ত রেকর্ডসমূহ, ফিল্টারিং ও ভেরিফিকেশন ব্যবস্থা সরাসরি দেখা যাবে।
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= URLROOT ?>" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 12px; font-weight: 700; text-decoration: none; color: white;">
                    <i class="fas fa-home"></i> হোম পেইজে ফিরে যান
                </a>
                <a href="<?= URLROOT ?>/blog" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 12px; font-weight: 700; text-decoration: none; background: #f1f5f9; color: #334155; transition: 0.2s;">
                    <i class="fas fa-book-open"></i> সকল নিবন্ধ দেখুন
                </a>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/Views/inc/footer.php'; ?>

