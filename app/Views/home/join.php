<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Top Header Section -->
<section style="padding: 60px 0 40px 0; text-align: center; background: transparent;">
    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <h1 style="font-size: 2.6rem; font-weight: 900; color: #006bdd; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
            আপনার দক্ষতা সম্পর্কে আমাদের জানান
        </h1>
        <p style="color: #334155; font-size: 1.15rem; max-width: 900px; margin: 0 auto; line-height: 1.8; font-family: 'Hind Siliguri', sans-serif; font-weight: 500;">
            আপনি যদি আমাদের এই দাওয়াহ ও জ্ঞানচর্চার কাজে অংশ নিতে চান, তাহলে আপনাকে স্বাগতম। আমাদের সাথে যুক্ত হতে চাইলে প্রথমে আপনার দক্ষতার ক্ষেত্রগুলো আমাদের জানাতে হবে। আপনি কোনভাবে অবদান রাখতে চান, সেটি স্পষ্টভাবে উল্লেখ করুন।
        </p>
    </div>
</section>

<!-- Contribution Cards Section -->
<section style="padding: 20px 0 60px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            <?php if (!empty($data['join_cards'])): ?>
                <?php foreach ($data['join_cards'] as $card): ?>
                <div style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 40px 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); display: flex; flex-direction: column; align-items: flex-start; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#006bdd';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 25px;">
                        <i class="<?= htmlspecialchars($card['icon']) ?>"></i>
                    </div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #1e293b; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($card['title']) ?></h3>
                    <p style="color: #475569; font-size: 1.05rem; line-height: 1.7; margin: 0; text-align: justify; font-family: 'Hind Siliguri', sans-serif;">
                        <?= nl2br(htmlspecialchars($card['description'])) ?>
                    </p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Financial Support Section -->
<section style="padding: 60px 0; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px; text-align: center;">
        <h2 style="font-size: 2.3rem; font-weight: 900; color: #006bdd; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
            ফাইন্যান্সিয়াল সাপোর্ট
        </h2>
        <p style="color: #334155; font-size: 1.2rem; line-height: 1.8; margin-bottom: 25px; font-family: 'Hind Siliguri', sans-serif;">
            response with nur-lab-এর কার্যক্রম চালিয়ে যেতে আর্থিক সহযোগিতাও গুরুত্বপূর্ণ। আপনি চাইলে এককালীন বা নিয়মিত ডোনেশন দিতে পারেন নির্দিষ্ট কোনো প্রজেক্ট (যেমন বই প্রকাশ, ভিডিও সিরিজ ইত্যাদি) স্পন্সর করতে পারেন।
        </p>
        <div style="margin-bottom: 30px;">
            <a href="<?= URLROOT ?>/donate" style="display: inline-flex; align-items: center; gap: 10px; background: #006bdd; color: white; padding: 14px 35px; border-radius: 50px; font-size: 1.15rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(0, 107, 221, 0.2); transition: all 0.3s ease; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#0055b3'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 107, 221, 0.3)';" onmouseout="this.style.background='#006bdd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 107, 221, 0.2)';">
                <i class="fas fa-hand-holding-heart"></i> ডোনেট করুন
            </a>
        </div>
        <div style="display: inline-flex; align-items: center; gap: 8px; background: white; padding: 12px 25px; border-radius: 50px; border: 1px dashed #cbd5e1; font-weight: 700; color: #475569; font-size: 1.05rem; margin-bottom: 15px;">
            📌 ফাইন্যান্সিয়াল সাপোর্ট করলেও আপনি আমাদের কমিউনিটির অংশ হিসেবে যুক্ত থাকতে পারবেন।
        </div>
    </div>
</section>


<style>
    @media (max-width: 992px) {
        div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        h1 {
            font-size: 2rem !important;
        }
        h2 {
            font-size: 1.8rem !important;
        }
    }
</style>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
