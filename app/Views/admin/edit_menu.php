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

$is_post_mega = ($data['menu']['menu_type'] ?? '') === 'post_mega';
?>

<div class="admin-card" style="max-width: 680px; margin: 0 auto; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; padding: 30px;">
    <div class="justify-content-between d-flex align-items-center mb-4">
        <div>
            <h3 class="m-0" style="color: #064e3b; font-weight: 800; font-size: 1.4rem;">Edit Menu: <?= htmlspecialchars($data['menu']['title']) ?></h3>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Update navigation title, URL, icon class, and display order</p>
        </div>
        <a href="<?= URLROOT ?>/admin/menus" class="btn btn-visit-site" style="text-decoration: none;">Back to Menus</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_menu/<?= $data['menu']['id'] ?>" method="POST">
        <input type="hidden" name="menu_type" value="<?= $is_post_mega ? 'post_mega' : 'custom' ?>">

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">Menu Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['menu']['title']) ?>" class="form-control" required style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
            <small style="color: #64748b; font-size: 13px;">Label displayed on the navbar button.</small>
        </div>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">Navigation URL</label>
            <input type="text" name="url" id="menu_url" value="<?= htmlspecialchars($data['menu']['url'] ?: '#') ?>" class="form-control" required style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
            <small style="color: #64748b; font-size: 13px;">Target URL when clicked directly (e.g. /blog or /admin/open_database_records).</small>
        </div>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">FontAwesome Icon Class</label>
            <div style="display: flex; align-items: center; gap: 12px;">
                <input type="text" name="icon" id="menu_icon_input" value="<?= htmlspecialchars($data['menu']['icon'] ?: 'fas fa-link') ?>" class="form-control" placeholder="fas fa-link" style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; border: 1.5px solid #a7f3d0; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #10b981; flex-shrink: 0;">
                    <i id="icon_preview" class="<?= htmlspecialchars($data['menu']['icon'] ?: 'fas fa-link') ?>"></i>
                </div>
            </div>
            <small style="color: #64748b; font-size: 13px;">Icon displayed before the menu title (e.g. <code>fas fa-database</code> or <code>fas fa-plus-circle</code>).</small>
        </div>

        <?php if (!$is_post_mega): ?>
        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">Parent Menu</label>
            <select name="parent_id" class="form-control" style="border-radius: 12px; padding: 12px 16px; font-weight: 600;">
                <option value="">None (Top Level Menu)</option>
                <?php if(!empty($data['menus'])): ?>
                    <?php 
                    $top_levels = array_filter($data['menus'], function($m) { return empty($m['parent_id']); });
                    foreach($top_levels as $top):
                        if ($top['id'] == $data['menu']['id']) continue; // Cannot be own parent
                    ?>
                        <option value="<?= $top['id'] ?>" <?= $data['menu']['parent_id'] == $top['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($top['title']) ?> (Top Level)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <small style="color: #64748b; font-size: 13px;">Select parent menu if this is a dropdown sub-item (e.g. Open Database).</small>
        </div>
        <?php else: ?>
        <input type="hidden" name="parent_id" value="">
        <?php endif; ?>

        <div class="form-group mb-4">
            <label style="font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">Display Order</label>
            <input type="number" name="order_index" value="<?= (int)$data['menu']['order_index'] ?>" class="form-control" style="border-radius: 12px; padding: 12px 16px; font-weight: 600; width: 120px;">
        </div>

        <?php if ($is_post_mega): ?>
        <?php 
        $selected_cats = json_decode($data['menu']['category_source'] ?? '[]', true);
        if (!is_array($selected_cats)) $selected_cats = [];
        ?>
        <div class="form-group mb-4">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="font-weight: 700; color: #1e293b; margin: 0;">Displayed Categories in Mega Menu</label>
                <div style="font-size: 13px; display: flex; gap: 10px;">
                    <a href="javascript:void(0)" onclick="selectAllCats(true)" style="color: var(--primary); font-weight: 600; text-decoration: none;">Select All</a>
                    <span style="color: #cbd5e1;">|</span>
                    <a href="javascript:void(0)" onclick="selectAllCats(false)" style="color: #64748b; font-weight: 600; text-decoration: none;">Deselect All</a>
                </div>
            </div>
            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 16px; padding: 18px; max-height: 280px; overflow-y: auto;">
                <?php if(!empty($data['post_categories'])): ?>
                    <?= renderCategoryCheckboxTree($data['post_categories'], $selected_cats) ?>
                <?php else: ?>
                    <p style="color: #64748b; font-style: italic; margin: 0;">No categories found.</p>
                <?php endif; ?>
            </div>
            <small style="color: #64748b; font-size: 13px; margin-top: 6px; display: block;">
                * If no categories are selected, all active top-level categories will automatically be displayed in the mega menu.
            </small>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary w-100" style="height: 52px; font-weight: 700; font-size: 1.05rem; border-radius: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('menu_icon_input');
    const iconPreview = document.getElementById('icon_preview');
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.className = this.value.trim() || 'fas fa-link';
        });
    }
});

function selectAllCats(check) {
    document.querySelectorAll('input[name="post_cats[]"]').forEach(cb => cb.checked = check);
}
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
