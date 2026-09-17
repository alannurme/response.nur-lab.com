<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="main-content">
    <div class="admin-header">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">
                <i class="fas fa-boxes-stacked" style="color: var(--primary); margin-right: 10px;"></i> Module Management (মডিউল)
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Create, edit, and organize topic modules displayed in the header mega menu.</p>
        </div>
        <a href="<?= URLROOT ?>/admin/add_module" class="btn-visit-site" style="background: var(--primary); color: white; border: none;">
            <i class="fas fa-plus-circle"></i> Add New Module
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; font-weight: 600;">
            <?php 
                if ($_GET['msg'] === 'added') echo 'New module added successfully!';
                elseif ($_GET['msg'] === 'updated') echo 'Module updated successfully!';
                elseif ($_GET['msg'] === 'deleted') echo 'Module deleted successfully!';
            ?>
        </div>
    <?php endif; ?>

    <div class="admin-card" style="background: white; border-radius: 16px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 12px 15px;">Order</th>
                        <th style="padding: 12px 15px;">Icon & Title</th>
                        <th style="padding: 12px 15px;">URL / Link</th>
                        <th style="padding: 12px 15px;">Status</th>
                        <th style="padding: 12px 15px;">Created At</th>
                        <th style="padding: 12px 15px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($modules)): ?>
                        <?php foreach ($modules as $mod): ?>
                            <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                                <td style="padding: 15px; font-weight: 700; color: var(--primary); width: 80px;">
                                    #<?= htmlspecialchars($mod['order_index']) ?>
                                </td>
                                <td style="padding: 15px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                            <i class="<?= htmlspecialchars($mod['icon'] ?: 'fas fa-cube') ?>"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-main); font-size: 1rem;"><?= htmlspecialchars($mod['title']) ?></div>
                                            <div style="font-size: 0.8rem; color: var(--text-muted); text-overflow: ellipsis; overflow: hidden; max-width: 250px; white-space: nowrap;">
                                                <?= htmlspecialchars(strip_tags($mod['content'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 15px; color: var(--text-muted); font-size: 0.9rem;">
                                    <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #475569; font-size: 0.82rem;"><?= htmlspecialchars($mod['url']) ?></code>
                                </td>
                                <td style="padding: 15px;">
                                    <?php if ($mod['status'] === 'active'): ?>
                                        <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #16a34a;"></span> Active
                                        </span>
                                    <?php else: ?>
                                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #94a3b8;"></span> Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 15px; color: var(--text-muted); font-size: 0.85rem;">
                                    <?= date('d M, Y', strtotime($mod['created_at'])) ?>
                                </td>
                                <td style="padding: 15px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_module/<?= $mod['id'] ?>" style="background: #eff6ff; color: var(--primary); width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" title="Edit Module">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= URLROOT ?>/admin/delete_module/<?= $mod['id'] ?>" onclick="return confirm('Are you sure you want to delete this module?');" style="background: #fef2f2; color: #ef4444; width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" title="Delete Module">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                <i class="fas fa-boxes-stacked" style="font-size: 2.5rem; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                                No modules created yet. Click "Add New Module" to create one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
