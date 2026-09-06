<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Top Bar Menu Manager</h1>
        <p>Manage and organize the menu items in the secondary top bar</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_sub_menu" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Top Menu Item
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
                    <?php foreach ($data['menus'] as $menu): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s; font-size: 16px;" onmouseover="this.style.background='#eff6ff';" onmouseout="this.style.background='white';">
                        <td style="padding: 8px 20px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%;"></div>
                                <span style="font-weight: 700; color: #1e293b; font-size: 16px;"><?= $menu['title'] ?></span>
                            </div>
                        </td>
                        <td style="padding: 8px 20px;">
                            <code style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; color: var(--primary); font-weight: 600; font-size: 15px;"><?= $menu['url'] ?></code>
                        </td>
                        <td style="padding: 8px 20px; text-align: center;">
                            <span style="background: var(--primary-light); color: var(--primary); padding: 3px 12px; border-radius: 50px; font-weight: 800; font-size: 16px;">
                                <?= $menu['order_index'] ?>
                            </span>
                        </td>
                        <td style="padding: 8px 20px; text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <a href="<?= URLROOT ?>/admin/edit_sub_menu/<?= $menu['id'] ?>" class="action-btn" title="Edit Structure" style="background: #eff6ff; color: #2563eb;">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_sub_menu/<?= $menu['id'] ?>" class="action-btn delete" title="Delete Menu" onclick="return confirm('Are you sure you want to remove this top bar menu item?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
                            No menus found. Click "Add New Top Menu Item" to get started.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
