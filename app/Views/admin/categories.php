<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Categories</h1>
        <p>Manage post categories for better organization</p>
    </div>
</div>

<div class="categories-grid">
    <!-- Add Category Form -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Add New Category</h3>
        <form action="<?= URLROOT ?>/admin/categories" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Islamic History" required>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Category Slug (Optional)</label>
                <input type="text" name="slug" class="form-control" placeholder="e.g. custom-slug">
                <small style="color: #64748b; margin-top: 5px; display: block;">Leave blank to auto-generate from name.</small>
            </div>
            
            <div class="form-group mb-4">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">None (Top Level Category)</option>
                    <?php 
                    if (!empty($data['categories'])):
                        $parents = array_filter($data['categories'], function($c) { return empty($c['parent_id']); });
                        foreach ($parents as $p): 
                        ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                        <?php 
                        endforeach; 
                    endif;
                    ?>
                </select>
                <small style="color: #64748b; margin-top: 5px; display: block;">Optional. Select parent category to make this a subcategory.</small>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </form>
    </div>

    <!-- Category List -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Existing Categories</h3>
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;"></th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="draggable-categories-body">
                    <?php 
                    if (!empty($data['categories'])):
                        $all_cats = $data['categories'];
                        $top_cats = array_filter($all_cats, function($c) { return empty($c['parent_id']); });
                        
                        if (!function_exists('renderCategoryRow')) {
                            function renderCategoryRow($cat, $level, $all_cats) {
                                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                $prefix = $level > 0 ? '↳ ' : '';
                                $weight = $level == 0 ? '700' : '500';
                                $color = $level == 0 ? 'var(--text-main)' : 'var(--text-muted)';
                                ?>
                                <tr class="draggable-row" draggable="true" data-id="<?= $cat['id'] ?>" style="cursor: move; transition: border-top 0.2s;" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondrop="drop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                                    <td style="text-align: center; color: #cbd5e1; cursor: move; vertical-align: middle;"><i class="fas fa-grip-lines"></i></td>
                                    <td style="font-weight: <?= $weight ?>; color: <?= $color ?>; vertical-align: middle;">
                                        <span style="font-family: monospace; color: #94a3b8;"><?= $indent ?><?= $prefix ?></span>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </td>
                                    <td style="color: var(--text-muted); vertical-align: middle;"><?= urldecode($cat['slug']) ?></td>
                                    <td style="text-align: right; vertical-align: middle;">
                                        <div style="display: flex; gap: 8px; justify-content: flex-end; flex-wrap: wrap;">
                                            <?php if (empty($cat['parent_id'])): // Only for top-level categories ?>
                                            <a href="<?= URLROOT ?>/admin/create_menu_from_category/<?= $cat['id'] ?>" 
                                               class="action-btn" 
                                               title="Create Menu Item from this Category"
                                               onclick="return confirm('এই ক্যাটাগরি থেকে মেনু আইটেম তৈরি করবেন?\n\nTitle: <?= htmlspecialchars($cat['name']) ?>\nURL: /<?= $cat['slug'] ?>')"
                                               style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; gap: 5px; height: 35px; padding: 0 10px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; white-space: nowrap;">
                                                <i class="fas fa-bars"></i> মেনু তৈরি
                                            </a>
                                            <?php endif; ?>
                                            <a href="<?= URLROOT ?>/admin/edit_category/<?= $cat['id'] ?>" class="action-btn" title="Edit Category" style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                                <i class="fas fa-pen-nib"></i>
                                            </a>
                                            <a href="<?= URLROOT ?>/admin/delete_category/<?= $cat['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this category?')" style="background: #fdf2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $children = array_filter($all_cats, function($c) use ($cat) { return $c['parent_id'] == $cat['id']; });
                                foreach ($children as $child) {
                                    renderCategoryRow($child, $level + 1, $all_cats);
                                }
                            }
                        }
                        
                        foreach ($top_cats as $cat) {
                            renderCategoryRow($cat, 0, $all_cats);
                        }
                    else:
                    ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let dragRow;

function dragStart(e) {
    dragRow = e.target.closest('tr');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', dragRow.innerHTML);
    dragRow.style.opacity = '0.5';
}

function dragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function dragEnter(e) {
    const row = e.target.closest('tr');
    if (row && row !== dragRow) {
        row.style.borderTop = '2px solid var(--primary)';
    }
}

function dragLeave(e) {
    const row = e.target.closest('tr');
    if (row) {
        row.style.borderTop = '';
    }
}

function drop(e) {
    e.preventDefault();
    const targetRow = e.target.closest('tr');
    if (targetRow && targetRow !== dragRow) {
        targetRow.style.borderTop = '';
        
        // Determine whether to insert before or after
        const rect = targetRow.getBoundingClientRect();
        const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
        
        dragRow.style.opacity = '1';
        targetRow.parentNode.insertBefore(dragRow, next ? targetRow.nextSibling : targetRow);
        
        saveOrder();
    }
}

function saveOrder() {
    const rows = document.querySelectorAll('.draggable-row');
    const ids = Array.from(rows).map(row => row.getAttribute('data-id'));
    
    fetch('<?= URLROOT ?>/admin/reorder_categories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Order updated:', data);
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
