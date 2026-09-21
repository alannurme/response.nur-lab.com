<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Social Media Manager</h1>
        <p>Manage and organize custom social media links for the top bar</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_social_link" class="btn btn-primary" style="background: var(--primary); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fas fa-plus"></i> Add New Social Media
    </a>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success" style="padding: 15px; background: #d1e7dd; color: #0f5132; border-radius: 8px; margin-bottom: 20px; font-weight: 500;"><?= $data['success'] ?></div>
<?php endif; ?>

<div class="admin-card" style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: none;">
    <div class="data-table-container" style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <table class="data-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 15px 20px; border-radius: 24px 0 0 0; text-align: left;">Icon</th>
                    <th style="padding: 15px 20px; text-align: left;">Name</th>
                    <th style="padding: 15px 20px; text-align: left;">Link URL</th>
                    <th style="padding: 15px 20px; text-align: center;">Display Order</th>
                    <th style="padding: 15px 20px; text-align: right; border-radius: 0 24px 0 0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['social_links'])): ?>
                    <?php foreach ($data['social_links'] as $link): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s; font-size: 16px;" onmouseover="this.style.background='#eff6ff';" onmouseout="this.style.background='white';">
                        <td style="padding: 15px 20px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                                <i class="<?= htmlspecialchars($link['icon']) ?>" style="font-size: 1.2rem; color: var(--primary);"></i>
                            </div>
                        </td>
                        <td style="padding: 15px 20px;">
                            <span style="font-weight: 700; color: #1e293b; font-size: 16px;"><?= htmlspecialchars($link['name']) ?></span>
                        </td>
                        <td style="padding: 15px 20px;">
                            <code style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; color: var(--primary); font-weight: 600; font-size: 14px; word-break: break-all;"><?= htmlspecialchars($link['url']) ?></code>
                        </td>
                        <td style="padding: 15px 20px; text-align: center;">
                            <span style="background: var(--primary-light); color: var(--primary); padding: 3px 12px; border-radius: 50px; font-weight: 800; font-size: 15px;">
                                <?= $link['order_index'] ?>
                            </span>
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <div class="action-buttons" style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="<?= URLROOT ?>/admin/edit_social_link/<?= $link['id'] ?>" class="action-btn" title="Edit Link" style="background: #eff6ff; color: #2563eb; padding: 8px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_social_link/<?= $link['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to remove this social media link?')" style="background: #fdf2f2; color: #de350b; padding: 8px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
                            No social media links found. Click "Add New Social Media" to get started.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
