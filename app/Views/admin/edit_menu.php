<?php require_once APPROOT . '/Views/admin/header.php'; 

if (!function_exists('renderCategoryCheckboxTree')) {
    function renderCategoryCheckboxTree($categories, $selected_cats = [], $parentId = null, $depth = 0) {
        $html = '';
        foreach ($categories as $cat) {
            $catParent = $cat['parent_id'] ? (int)$cat['parent_id'] : null;
            $filterParent = $parentId ? (int)$parentId : null;
            
            if ($catParent === $filterParent) {
                $prefix = $depth > 0 ? '↳ ' : '';
                $isChecked = in_array($cat['id'], $selected_cats) ? 'checked' : '';
                
                $html .= '<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; padding-left: ' . ($depth * 20) . 'px;">';
                $html .= '<input type="checkbox" name="post_cats[]" value="' . $cat['id'] . '" id="post_cat_' . $cat['id'] . '" ' . $isChecked . ' style="width: 18px; height: 18px;">';
                $html .= '<label for="post_cat_' . $cat['id'] . '" style="cursor: pointer; font-size: 15px; color: #334155; font-weight: ' . ($depth === 0 ? '700' : '500') . '; margin: 0;">' . $prefix . htmlspecialchars($cat['name']) . '</label>';
                $html .= '</div>';
                
                $html .= renderCategoryCheckboxTree($categories, $selected_cats, $cat['id'], $depth + 1);
            }
        }
        return $html;
    }
}
?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit Menu: <?= $data['menu']['title'] ?></h3>
        <a href="<?= URLROOT ?>/admin/menus" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_menu/<?= $data['menu']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label>Menu Title</label>
            <input type="text" name="title" value="<?= $data['menu']['title'] ?>" class="form-control" required>
        </div>

        <div class="form-group mb-4" id="url_section">
            <label>URL (Link)</label>
            <input type="text" name="url" id="menu_url" value="<?= $data['menu']['url'] ?>" class="form-control" required>
        </div>

        <?php 
        $selected_cats = json_decode($data['menu']['category_source'] ?? '[]', true);
        if (!is_array($selected_cats)) $selected_cats = [];
        ?>
        <div class="form-group mb-4">
            <label>Menu Type</label>
            <select name="menu_type" id="menu_type" class="form-control">
                <option value="custom" <?= ($data['menu']['menu_type'] ?? 'custom') === 'custom' ? 'selected' : '' ?>>Custom Link / Static Nested Hierarchy</option>
                <option value="post_mega" <?= ($data['menu']['menu_type'] ?? 'custom') === 'post_mega' ? 'selected' : '' ?>>Post Categories (Mega Menu)</option>
            </select>
        </div>

        <div class="form-group mb-4" id="post_categories_section" style="display: none;">
            <label style="font-weight: 700; color: #1e293b;">Select Post Categories to Display as Mega Menu Tabs</label>
            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 15px; max-height: 250px; overflow-y: auto;">
                <?php if(!empty($data['post_categories'])): ?>
                    <?= renderCategoryCheckboxTree($data['post_categories'], $selected_cats) ?>
                <?php else: ?>
                    <p style="color: #64748b; font-style: italic;">No post categories found.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Parent Menu</label>
            <select name="parent_id" class="form-control">
                <option value="">None (Top Level Menu)</option>
                <?php if(!empty($data['menus'])): ?>
                    <?php 
                    $top_levels = array_filter($data['menus'], function($m) { return empty($m['parent_id']); });
                    foreach($top_levels as $top):
                        if ($top['id'] == $data['menu']['id']) continue; // Cannot be own parent
                    ?>
                        <option value="<?= $top['id'] ?>" <?= $data['menu']['parent_id'] == $top['id'] ? 'selected' : '' ?>><?= htmlspecialchars($top['title']) ?> (Top Level)</option>
                        <?php 
                        $sub_levels = array_filter($data['menus'], function($m) use ($top) { return $m['parent_id'] == $top['id']; });
                        foreach($sub_levels as $sub):
                            if ($sub['id'] == $data['menu']['id']) continue; // Cannot be own parent
                        ?>
                            <option value="<?= $sub['id'] ?>" <?= $data['menu']['parent_id'] == $sub['id'] ? 'selected' : '' ?>>&nbsp;&nbsp;&nbsp;&nbsp;↳ <?= htmlspecialchars($sub['title']) ?> (Sub Level)</option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <small style="color: #64748b;">Select parent menu if this is a tab category or a card item.</small>
        </div>

        <div class="form-group mb-4">
            <label>Icon Class (FontAwesome)</label>
            <input type="text" name="icon" value="<?= htmlspecialchars($data['menu']['icon'] ?? '') ?>" class="form-control" placeholder="e.g. fas fa-cloud or fa-solid fa-code">
            <small style="color: #64748b;">Optional. Used for icons in mega menu dropdowns.</small>
        </div>

        <div class="form-group mb-5">
            <label>Order Index</label>
            <input type="number" name="order_index" value="<?= $data['menu']['order_index'] ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Update Menu Item</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuTypeSelect = document.getElementById('menu_type');
    const postSec = document.getElementById('post_categories_section');
    const urlSec = document.getElementById('url_section');
    const urlInput = document.getElementById('menu_url');

    function toggleSections() {
        const val = menuTypeSelect.value;
        if (val === 'post_mega') {
            postSec.style.display = 'block';
            urlSec.style.display = 'none';
            urlInput.removeAttribute('required');
            if (!urlInput.value || urlInput.value === '') {
                urlInput.value = '#';
            }
        } else {
            postSec.style.display = 'none';
            urlSec.style.display = 'block';
            urlInput.setAttribute('required', 'required');
            if (urlInput.value === '#') {
                urlInput.value = '';
            }
        }
    }

    menuTypeSelect.addEventListener('change', toggleSections);
    toggleSections();
});
</script>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
