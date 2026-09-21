<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Dedicated Zakat Calculator Full Page Container (Islamic Emerald Green Theme) -->
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
                    <i class="fas fa-calculator"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">ইসলামিক যাকাত ক্যালকুলেটর</h1>
                    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #a7f3d0;">সহজ উপায়ে যাকাতের হিসাব হিসাব করুন (২.৫%)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Container -->
    <div style="position: relative; z-index: 2; width: 100%; max-width: 650px; margin: 35px auto 0 auto; padding: 0 20px; box-sizing: border-box;">
        <div style="background: rgba(4, 47, 36, 0.85); backdrop-filter: blur(14px); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 24px; padding: 32px; box-shadow: 0 20px 45px rgba(0,0,0,0.4);">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.92rem; font-weight: 700; color: #a7f3d0; margin-bottom: 8px;">১. নগদ টাকা ও ব্যাংক ব্যালেন্স (টাকা):</label>
                <input type="number" id="pageZakatCash" placeholder="০" style="width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; color: #fff; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.92rem; font-weight: 700; color: #a7f3d0; margin-bottom: 8px;">২. সোনা ও রূপার বর্তমান বাজারমূল্য (টাকা):</label>
                <input type="number" id="pageZakatGold" placeholder="০" style="width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; color: #fff; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.92rem; font-weight: 700; color: #a7f3d0; margin-bottom: 8px;">৩. ব্যবসায়িক পণ্যের মূল্য (টাকা):</label>
                <input type="number" id="pageZakatBusiness" placeholder="০" style="width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; color: #fff; font-size: 1rem; font-family: 'Hind Siliguri', sans-serif; outline: none; box-sizing: border-box;">
            </div>

            <button onclick="calcPageZakat()" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #10b981, #059669); border: none; color: #fff; font-size: 1.1rem; font-weight: 800; border-radius: 14px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 18px rgba(16,185,129,0.35);">
                <i class="fas fa-calculator" style="margin-right: 6px;"></i> যাকাত গণনা করুন (২.৫%)
            </button>

            <div style="margin-top: 24px; padding: 20px; background: rgba(0,0,0,0.25); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 16px; text-align: center;">
                <div style="font-size: 0.9rem; color: #a7f3d0; margin-bottom: 6px;">আপনার প্রদেয় যাকাতের পরিমাণ:</div>
                <div id="pageZakatResult" style="font-size: 1.8rem; font-weight: 900; color: #fef08a;">০ টাকা</div>
            </div>

        </div>
    </div>
</div>

<script>
    function toBnNum(numStr) {
        const enToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(numStr).replace(/[0-9]/g, function(w){ return enToBn[w] || w; });
    }

    function calcPageZakat() {
        const cash = parseFloat(document.getElementById('pageZakatCash').value) || 0;
        const gold = parseFloat(document.getElementById('pageZakatGold').value) || 0;
        const biz = parseFloat(document.getElementById('pageZakatBusiness').value) || 0;
        
        const total = cash + gold + biz;
        const zakat = total * 0.025;
        
        document.getElementById('pageZakatResult').innerText = toBnNum(Math.round(zakat).toLocaleString('bn-BD')) + ' টাকা';
    }
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
