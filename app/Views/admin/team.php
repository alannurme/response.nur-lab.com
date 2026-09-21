<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Team Management</h1>
        <p>Manage your portal's staff and contributors</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_team_member" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Team Member
    </a>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Member Info</th>
                    <th>Designation</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['members'])): ?>
                    <?php foreach ($data['members'] as $member): ?>
                    <tr>
                        <td style="font-weight: 700;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <img src="<?= resolve_setting_image($member['image']) ?>" loading="lazy" decoding="async" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary);">
                                <?= htmlspecialchars($member['name']) ?>
                            </div>
                        </td>
                        <td><span class="badge badge-blue"><?= htmlspecialchars($member['designation']) ?></span></td>
                        <td><?= $member['order_index'] ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= URLROOT ?>/admin/edit_team_member/<?= $member['id'] ?>" class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_team_member/<?= $member['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #64748b; font-style: italic;">
                            টিমের কোনো সদস্যের তথ্য পাওয়া যায়নি। নতুন সদস্য যোগ করতে উপরের "Add Team Member" বাটনে ক্লিক করুন।
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
