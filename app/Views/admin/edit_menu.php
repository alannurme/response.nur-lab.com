<?php require_once APPROOT . '/Views/admin/header.php'; 

if (!function_exists('renderCategoryCheckboxTree')) {
    function renderCategoryCheckboxTree($categories, $selected_cats = [], $parentId = null, $depth = 0) {
        $html = '';
        foreach ($categories as $cat) {
            $catParent = $cat['parent_id'] ? (int)$cat['parent_id'] : null;
            $filterParent = $parentId ? (int)$parentId : null;
            
            if ($catParent === $filterParent) {
                $prefix = $depth > 0 ? '↳ ' : '';
                $isChecked = in_array((int)$cat['id'], array_map('intval', $selected_cats)) ? 'checked' : '';
                
                $html .= '<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; padding-left: ' . ($depth * 20) . 'px;">';
                $html .= '<input type="checkbox" name="post_cats[]" value="' . $cat['id'] . '" id="post_cat_' . $cat['id'] . '" ' . $isChecked . ' style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary);">';
                $html .= '<label for="post_cat_' . $cat['id'] . '" style="cursor: pointer; font-size: 15px; color: #334155; font-weight: ' . ($depth === 0 ? '700' : '500') . '; margin: 0;">' . $prefix . htmlspecialchars($cat['name']) . '</label>';
                $html .= '</div>';
                
                $html .= renderCategoryCheckboxTree($categories, $selected_cats, $cat['id'], $depth + 1);
            }
        }
        return $html;
    }
}
?>

<div class="admin-card" style="max-width: 680px; margin: 0 auto; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; padding: 30px;">
    <div class="justify-content-between d-flex align-items-center mb-4">
        <div>
            <h3 class="m-0" style="color: #064e3b; font-weight: 800; font-size: 1.4rem;">হেডার মেনু এডিট: <?= htmlspecialchars($data['menu']['title']) ?></h3>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">মূল নেভিগেশন বারের 'সবগুলো নিবন্ধ' মেগামেনুর তথ্য আপডেট করুন</p>
        </div>
        <a href="<?= URLROOT ?>/admin/menus" class="btn btn-visit-site" style="text-decoration: none;">মেনু তালিকায় ফিরুন</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_menu/<?= $data['menu']['id'] ?>" method="POST">
        <input type="hidden" name="menu_type" value="post_mega">

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">মেনু টাইটেল (Menu Title)</label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['menu']['title']) ?>" class="form-control" required style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
            <small style="color: #64748b; font-size: 13px;">ন্যাভবারে বাটনে যে লেখাটি দেখাবে (যেমন: সবগুলো নিবন্ধ)।</small>
        </div>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">ন্যাভিগেশন URL (Link)</label>
            <input type="text" name="url" id="menu_url" value="<?= htmlspecialchars($data['menu']['url'] ?: '/blog') ?>" class="form-control" required style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
            <small style="color: #64748b; font-size: 13px;">বাটনে সরাসরি ক্লিক করলে যে লিংকে যাবে (ডিফল্ট: /blog)।</small>
        </div>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">আইকন ক্লাস (FontAwesome Icon Class)</label>
            <div style="display: flex; align-items: center; gap: 12px;">
                <input type="text" name="icon" id="menu_icon_input" value="<?= htmlspecialchars($data['menu']['icon'] ?: 'fa-solid fa-layer-group') ?>" class="form-control" placeholder="fa-solid fa-layer-group" style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; border: 1.5px solid #a7f3d0; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #10b981; flex-shrink: 0;">
                    <i id="icon_preview" class="<?= htmlspecialchars($data['menu']['icon'] ?: 'fa-solid fa-layer-group') ?>"></i>
                </div>
            </div>
            <small style="color: #64748b; font-size: 13px;">মেনু টাইটেলের বামে প্রদর্শিত আইকন (যেমন: <code>fa-solid fa-layer-group</code> বা <code>fas fa-book-open</code>)।</small>
        </div>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">ডিসপ্লে অর্ডার (Order Index)</label>
            <input type="number" name="order_index" value="<?= (int)$data['menu']['order_index'] ?>" class="form-control" style="border-radius: 12px; padding: 12px 16px; font-weight: 600; width: 120px;">
        </div>

        <?php 
        $selected_cats = json_decode($data['menu']['category_source'] ?? '[]', true);
        if (!is_array($selected_cats)) $selected_cats = [];
        ?>
        <div class="form-group mb-4">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="font-weight: 700; color: #1e293b; margin: 0;">মেগামেনুতে প্রদর্শিত ক্যাটাগরিসমূহ</label>
                <div style="font-size: 13px; display: flex; gap: 10px;">
                    <a href="javascript:void(0)" onclick="selectAllCats(true)" style="color: var(--primary); font-weight: 600; text-decoration: none;">সবগুলো নির্বাচন করুন</a>
                    <span style="color: #cbd5e1;">|</span>
                    <a href="javascript:void(0)" onclick="selectAllCats(false)" style="color: #64748b; font-weight: 600; text-decoration: none;">সব মুছুন</a>
                </div>
            </div>
            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 16px; padding: 18px; max-height: 280px; overflow-y: auto;">
                <?php if(!empty($data['post_categories'])): ?>
                    <?= renderCategoryCheckboxTree($data['post_categories'], $selected_cats) ?>
                <?php else: ?>
                    <p style="color: #64748b; font-style: italic; margin: 0;">কোনো ক্যাটাগরি পাওয়া যায়নি।</p>
                <?php endif; ?>
            </div>
            <small style="color: #64748b; font-size: 13px; margin-top: 6px; display: block;">
                * কোনো ক্যাটাগরি সিলেক্ট না থাকলে স্বয়ংক্রিয়ভাবে সক্রিয় সকল প্রধান ক্যাটাগরি মেগামেনুতে প্রদর্শিত হবে।
            </small>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 52px; font-weight: 700; font-size: 1.05rem; border-radius: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('menu_icon_input');
    const iconPreview = document.getElementById('icon_preview');
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.className = this.value.trim() || 'fa-solid fa-layer-group';
        });
    }
});

function selectAllCats(check) {
    document.querySelectorAll('input[name="post_cats[]"]').forEach(cb => cb.checked = check);
}
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>