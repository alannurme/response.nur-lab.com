<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        মেনু আইটেম সফলভাবে তৈরি হয়েছে! ক্যাটাগরি থেকে নতুন মেনু যোগ করা হয়েছে।
    </div>
    <?php elseif ($_GET['msg'] === 'already_exists'): ?>
    <div style="background: #fefce8; border: 1px solid #fde047; color: #854d0e; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-exclamation-triangle" style="color: #ca8a04; font-size: 18px;"></i>
        এই ক্যাটাগরির মেনু ইতিমধ্যে বিদ্যমান আছে।
    </div>
    <?php elseif ($_GET['msg'] === 'settings_updated'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        ডন'ট মিস সেকশনের ক্যাটাগরি কনফিগারেশন সফলভাবে আপডেট করা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Menu Manager</h1>
        <p>Manage and organize your website's navigation structure</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_menu" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Menu Item
    </a>
</div>

<div class="admin-card" style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: none;">
    <div class="data-table-container" style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <table class="data-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 10px 20px; border-radius: 24px 0 0 0;">Menu Title</th>
                    <th style="padding: 10px 20px;">Navigation URL</th>
                    <th style="padding: 10px 20px; text-align: center;">Display Order</th>
                    <th style="padding: 10px 20px; text-align: right; border-radius: 0 24px 0 0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['menus'])): ?>
                    <?php 
                    $top_levels = array_filter($data['menus'], function($m) { return empty($m['parent_id']); });
                    
                    if (!function_exists('renderMenuRow')) {
                        function renderMenuRow($menu, $level, $all_menus) {
                            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                            $prefix = $level > 0 ? '↳ ' : '';
                            $color = $level == 0 ? 'var(--primary)' : ($level == 1 ? '#ff2a2a' : '#64748b');
                            $weight = $level == 0 ? '800' : ($level == 1 ? '700' : '600');
                            $size = $level == 0 ? '16px' : ($level == 1 ? '15px' : '14px');
                            
                            $icon_html = '';
                            if (!empty($menu['icon'])) {
                                $icon_html = '<i class="' . htmlspecialchars($menu['icon']) . '" style="color: ' . $color . '; margin-right: 5px; width: 18px; text-align: center;"></i> ';
                            }
                            ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s; font-size: 16px;" onmouseover="this.style.background='#eff6ff';" onmouseout="this.style.background='white';">
                                <td style="padding: 8px 20px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="font-family: monospace; color: #94a3b8;"><?= $indent ?><?= $prefix ?></span>
                                        <div style="width: 8px; height: 8px; background: <?= $color ?>; border-radius: 50%;"></div>
                                        <span style="font-weight: <?= $weight ?>; color: #1e293b; font-size: <?= $size ?>;"><?= $icon_html ?><?= htmlspecialchars($menu['title']) ?></span>
                                    </div>
                                </td>
                                <td style="padding: 8px 20px;">
                                    <?php if (($menu['menu_type'] ?? 'custom') === 'post_mega'): ?>
                                        <span style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #1d4ed8; padding: 5px 14px; border-radius: 50px; font-size: 13px; font-weight: 700; border: 1px solid #bfdbfe;">
                                            <i class="fas fa-layer-group" style="font-size: 12px;"></i> Mega Menu
                                        </span>
                                    <?php else: ?>
                                        <code style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; color: var(--primary); font-weight: 600; font-size: 15px;"><?= htmlspecialchars($menu['url']) ?></code>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 8px 20px; text-align: center;">
                                    <span style="background: var(--primary-light); color: var(--primary); padding: 3px 12px; border-radius: 50px; font-weight: 800; font-size: 16px;">
                                        <?= $menu['order_index'] ?>
                                    </span>
                                </td>
                                <td style="padding: 8px 20px; text-align: right;">
                                    <div class="action-buttons" style="justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_menu/<?= $menu['id'] ?>" class="action-btn" title="Edit Structure" style="background: #eff6ff; color: #2563eb;">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <a href="<?= URLROOT ?>/admin/delete_menu/<?= $menu['id'] ?>" class="action-btn delete" title="Delete Menu" onclick="return confirm('Are you sure you want to remove this menu item?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $children = array_filter($all_menus, function($m) use ($menu) { return $m['parent_id'] == $menu['id']; });
                            usort($children, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                            foreach ($children as $child) {
                                renderMenuRow($child, $level + 1, $all_menus);
                            }
                        }
                    }
                    
                    usort($top_levels, function($a, $b) { return $a['order_index'] <=> $b['order_index']; });
                    foreach ($top_levels as $menu) {
                        renderMenuRow($menu, 0, $data['menus']);
                    }
                    ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
                            No menus found. Click "Add New Menu Item" to get started.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
