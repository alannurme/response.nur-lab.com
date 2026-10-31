<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        Menu item created successfully!
    </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        Menu item updated successfully!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        Menu item removed successfully!
    </div>
    <?php elseif ($_GET['msg'] === 'protected'): ?>
    <div style="background: #fefce8; border: 1px solid #fde047; color: #854d0e; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-shield-alt" style="color: #ca8a04; font-size: 18px;"></i>
        The primary mega menu is protected and cannot be deleted.
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Main Header Menu Manager</h1>
        <p>Manage and customize the primary header navigation items and dropdowns</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_menu" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add New Menu Item
    </a>
</div>

<div class="admin-card" style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: none;">
    <div class="data-table-container" style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <table class="data-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 14px 24px; border-radius: 24px 0 0 0;">Menu Title</th>
                    <th style="padding: 14px 20px;">Navigation URL</th>
                    <th style="padding: 14px 20px; text-align: center;">Menu Type</th>
                    <th style="padding: 14px 20px; text-align: center;">Display Order</th>
                    <th style="padding: 14px 24px; text-align: right; border-radius: 0 24px 0 0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['menus'])): ?>
                    <?php 
                    $all_menus = $data['menus'];
                    $top_levels = array_filter($all_menus, function($m) { return empty($m['parent_id']); });
                    usort($top_levels, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });

                    if (!function_exists('renderAdminMenuTree')) {
                        function renderAdminMenuTree($menu, $level, $all_menus) {
                            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                            $prefix = $level > 0 ? '↳ ' : '';
                            $is_mega = ($menu['menu_type'] ?? '') === 'post_mega';
                            $has_children = false;
                            $children = array_filter($all_menus, function($m) use ($menu) { return $m['parent_id'] == $menu['id']; });
                            usort($children, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                            if (!empty($children)) $has_children = true;

                            $dot_color = $level === 0 ? ($is_mega ? '#10b981' : '#2563eb') : '#94a3b8';
                            $title_weight = $level === 0 ? '800' : '600';
                            $title_color = $level === 0 ? '#0f172a' : '#334155';
                            ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s; font-size: 15px;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                                <td style="padding: 14px 24px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-family: monospace; color: #94a3b8; font-weight: 700;"><?= $indent ?><?= $prefix ?></span>
                                        <div style="width: 8px; height: 8px; background: <?= $dot_color ?>; border-radius: 50%; flex-shrink: 0;"></div>
                                        <?php if (!empty($menu['icon'])): ?>
                                            <i class="<?= htmlspecialchars($menu['icon']) ?>" style="color: <?= $dot_color ?>; width: 20px; text-align: center; font-size: 14px;"></i>
                                        <?php endif; ?>
                                        <span style="font-weight: <?= $title_weight ?>; color: <?= $title_color ?>; font-size: <?= $level === 0 ? '15px' : '14px' ?>;">
                                            <?= htmlspecialchars($menu['title']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td style="padding: 14px 20px;">
                                    <code style="background: #f1f5f9; padding: 5px 12px; border-radius: 8px; color: #0f172a; font-weight: 600; font-size: 13px;">
                                        <?= htmlspecialchars($menu['url'] ?: '#') ?>
                                    </code>
                                </td>
                                <td style="padding: 14px 20px; text-align: center;">
                                    <?php if ($is_mega): ?>
                                        <span style="display: inline-flex; align-items: center; gap: 5px; background: #ecfdf5; color: #047857; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; border: 1px solid #a7f3d0;">
                                            <i class="fas fa-layer-group" style="font-size: 11px;"></i> Post Mega Menu
                                        </span>
                                    <?php elseif ($has_children): ?>
                                        <span style="display: inline-flex; align-items: center; gap: 5px; background: #eff6ff; color: #1d4ed8; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; border: 1px solid #bfdbfe;">
                                            <i class="fas fa-chevron-down" style="font-size: 10px;"></i> Dropdown Menu
                                        </span>
                                    <?php else: ?>
                                        <span style="display: inline-flex; align-items: center; gap: 5px; background: #f8fafc; color: #475569; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; border: 1px solid #e2e8f0;">
                                            <i class="fas fa-link" style="font-size: 10px;"></i> Standard Link
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 14px 20px; text-align: center;">
                                    <span style="background: var(--primary-light); color: var(--primary); padding: 4px 12px; border-radius: 50px; font-weight: 800; font-size: 14px;">
                                        <?= $menu['order_index'] ?>
                                    </span>
                                </td>
                                <td style="padding: 14px 24px; text-align: right;">
                                    <div class="action-buttons" style="justify-content: flex-end; gap: 8px;">
                                        <a href="<?= URLROOT ?>/admin/edit_menu/<?= $menu['id'] ?>" class="btn btn-primary" title="Edit Menu Item" style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                                            <i class="fas fa-pen-nib"></i> Edit
                                        </a>
                                        <?php if ($is_mega): ?>
                                            <span class="action-btn" title="Core menu is protected from deletion" style="background: #f1f5f9; color: #94a3b8; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px;">
                                                <i class="fas fa-shield-alt"></i>
                                            </span>
                                        <?php else: ?>
                                            <a href="<?= URLROOT ?>/admin/delete_menu/<?= $menu['id'] ?>" class="action-btn delete" title="Delete Menu Item" onclick="return confirm('Are you sure you want to delete this menu item?');" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #fef2f2; color: #ef4444; text-decoration: none;">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            foreach ($children as $child) {
                                renderAdminMenuTree($child, $level + 1, $all_menus);
                            }
                        }
                    }

                    foreach ($top_levels as $menu) {
                        renderAdminMenuTree($menu, 0, $all_menus);
                    }
                    ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
                            No menus found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
