<?php require APPROOT . '/Views/admin/header.php'; ?>

    <div class="justify-content-between d-flex align-items-center mb-4">
        <div>
            <h1 class="text-premium-glow">User Management</h1>
            <p>Manage administrators and staff members</p>
        </div>
        <a href="<?= URLROOT ?>/admin/add_user" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user): ?>
                <tr>
                    <td style="font-weight: 700; color: var(--text-main);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="avatar"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                            <?= $user['username'] ?>
                        </div>
                    </td>
                    <td><span class="badge badge-green">Administrator</span></td>
                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                    <td><span class="badge badge-blue">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/admin/edit_user/<?= $user['id'] ?>" class="action-btn" title="Edit User">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/user_settings/<?= $user['id'] ?>" class="action-btn" title="Account Settings">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
