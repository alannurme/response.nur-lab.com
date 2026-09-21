<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Digital Tasbih Full Page Container (Islamic Emerald Green Theme) -->
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
                    <i class="fas fa-beads"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">ডিজিটাল ডিজিটাল তাসবীহ গণক</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">যিকর ও তাসবীহ গণনার ডিজিটাল কাউন্টার</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Container -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 520px; margin: 40px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 24px; padding: 32px; text-align: center; box-shadow: 0 20px 45px rgba(0,0,0,0.4);">
            
            <select id="pageTasbihZikrSelect" style="width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 14px; color: #fff; font-family: 'Hind Siliguri', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 24px; outline: none; box-sizing: border-box;">
                <option value="সুবহানাল্লাহ" style="background:#044e39;">سُبْحَانَ الله (সুবহানাল্লাহ)</option>
                <option value="আলহামদুলিল্লাহ" style="background:#044e39;">الْحَمْدُ لِلّٰهِ (আলহামদুলিল্লাহ)</option>
                <option value="আল্লাহু আকবার" style="background:#044e39;">اللهُ أَكْبَرُ (আল্লাহু আকবার)</option>
                <option value="লা ইলাহা ইল্লাল্লাহ" style="background:#044e39;">لَا إِلٰهَ إِلَّا اللهُ (লা ইলাহা ইল্লাল্লাহ)</option>
                <option value="আস্তাগফিরুল্লাহ" style="background:#044e39;">أَسْتَغْفِرُ اللهَ (আস্তাগফিরুল্লাহ)</option>
                <option value="সুবহানাল্লাহি ওয়াবিহামদিহি" style="background:#044e39;">سُبْحَانَ اللهِ وَبِحَمْدِهِ (সুবহানাল্লাহি ওয়াবিহামদিহি)</option>
            </select>

            <div style="width: 180px; height: 180px; margin: 0 auto 24px auto; border-radius: 50%; background: radial-gradient(circle, rgba(245,158,11,0.22) 0%, rgba(5,150,105,0.1) 100%); border: 4px solid #f59e0b; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 0 30px rgba(245,158,11,0.35);">
                <div style="font-size: 3.8rem; font-weight: 900; color: #fef08a; font-family: 'Outfit', sans-serif; line-height: 1;" id="pageTasbihCounter">০</div>
                <div style="font-size: 0.85rem; color: #a7f3d0; margin-top: 6px; font-weight: 600;">মোট গণনা</div>
            </div>

            <button onclick="countPageTasbih()" style="width: 100%; max-width: 280px; padding: 18px; border-radius: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: #ffffff; font-size: 1.25rem; font-weight: 900; cursor: pointer; box-shadow: 0 10px 25px rgba(245,158,11,0.45); transition: transform 0.1s ease;" onmousedown="this.style.transform='scale(0.95)';" onmouseup="this.style.transform='scale(1)';">
                <i class="fas fa-hand-pointer" style="margin-right: 8px;"></i> গণনা করুন (+১)
            </button>

            <div style="margin-top: 24px;">
                <button onclick="resetPageTasbih()" style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; padding: 10px 22px; border-radius: 20px; font-size: 0.92rem; cursor: pointer; font-weight: 700;">
                    <i class="fas fa-redo" style="margin-right: 6px;"></i> রিসেট (Reset)
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    let tasbihCount = 0;
    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function countPageTasbih() {
        tasbihCount++;
        document.getElementById('pageTasbihCounter').innerText = toBnNum(tasbihCount);
    }

    function resetPageTasbih() {
        tasbihCount = 0;
        document.getElementById('pageTasbihCounter').innerText = toBnNum(tasbihCount);
    }
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
