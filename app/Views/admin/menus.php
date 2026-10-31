<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'updated'): ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        Main header menu updated successfully!
    </div>
    <?php elseif ($_GET['msg'] === 'protected'): ?>
    <div style="background: #fefce8; border: 1px solid #fde047; color: #854d0e; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-shield-alt" style="color: #ca8a04; font-size: 18px;"></i>
        The main mega menu is protected and cannot be deleted.
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Main Header Menu Manager</h1>
        <p>Manage and customize the primary header mega menu and category navigation</p>
    </div>
</div>

<!-- Info Alert -->
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px solid #a7f3d0; border-radius: 16px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
    <div style="display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div>
            <div style="font-weight: 700; color: #064e3b; font-size: 16px;">Primary Header Mega Menu</div>
            <div style="color: #047857; font-size: 14px; margin-top: 2px;">The website navbar exclusively features this mega menu. You can configure its title, icon, URL destination, and displayed categories here.</div>
        </div>
    </div>
    <div>
        <?php $menu_item = !empty($data['menus']) ? $data['menus'][0] : ($data['menu'] ?? null); ?>
        <?php if ($menu_item): ?>
            <a href="<?= URLROOT ?>/admin/edit_menu/<?= $menu_item['id'] ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; padding: 10px 20px; border-radius: 12px; text-decoration: none;">
                <i class="fas fa-pen-nib"></i> Edit Menu
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="admin-card" style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: none;">
    <div class="data-table-container" style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <table class="data-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 14px 24px; border-radius: 24px 0 0 0;">Menu Title & Preview</th>
                    <th style="padding: 14px 20px;">Navigation URL</th>
                    <th style="padding: 14px 20px; text-align: center;">Menu Type</th>
                    <th style="padding: 14px 20px; text-align: center;">Display Order</th>
                    <th style="padding: 14px 20px; text-align: center;">Status</th>
                    <th style="padding: 14px 24px; text-align: right; border-radius: 0 24px 0 0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['menus'])): ?>
                    <?php foreach ($data['menus'] as $menu): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s; font-size: 15px;" onmouseover="this.style.background='#f0fdf4';" onmouseout="this.style.background='white';">
                        <td style="padding: 16px 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; border: 1.5px solid #10b981; padding: 6px 16px; border-radius: 50px; box-shadow: 0 2px 8px rgba(16,185,129,0.15);">
                                    <i class="<?= !empty($menu['icon']) ? htmlspecialchars($menu['icon']) : 'fa-solid fa-layer-group' ?>" style="color: #10b981; font-size: 15px;"></i>
                                    <span style="font-weight: 800; color: #064e3b; font-size: 15px;"><?= htmlspecialchars($menu['title']) ?></span>
                                    <i class="fas fa-chevron-down" style="font-size: 11px; color: #10b981;"></i>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px 20px;">
                            <code style="background: #f1f5f9; padding: 6px 12px; border-radius: 8px; color: #065f46; font-weight: 700; font-size: 14px;"><?= htmlspecialchars($menu['url'] ?: '/blog') ?></code>
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; background: #ecfdf5; color: #047857; padding: 6px 14px; border-radius: 50px; font-size: 13px; font-weight: 700; border: 1px solid #a7f3d0;">
                                <i class="fas fa-layer-group" style="font-size: 12px;"></i> Post Mega Menu
                            </span>
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            <span style="background: var(--primary-light); color: var(--primary); padding: 4px 14px; border-radius: 50px; font-weight: 800; font-size: 15px;">
                                <?= $menu['order_index'] ?>
                            </span>
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            <span style="display: inline-flex; align-items: center; gap: 5px; background: #f0fdf4; color: #16a34a; font-weight: 700; font-size: 13px; padding: 5px 12px; border-radius: 50px; border: 1px solid #bbf7d0;">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        </td>
                        <td style="padding: 16px 24px; text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end; gap: 8px;">
                                <a href="<?= URLROOT ?>/admin/edit_menu/<?= $menu['id'] ?>" class="btn btn-primary" title="Edit and configure menu" style="padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                                    <i class="fas fa-pen-nib"></i> Edit Menu
                                </a>
                                <span class="action-btn" title="Core menu is protected from deletion" style="background: #f1f5f9; color: #94a3b8; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px;">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
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
