<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Roles & Permissions Management</h1>
        <p>Assign roles and specific access rights to your staff members</p>
    </div>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Current Role</th>
                    <th>Active Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user): ?>
                <tr>
                    <td style="font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="avatar"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                            <?= $user['username'] ?>
                        </div>
                    </td>
                    <td>
                        <?php 
                        $roleClass = 'badge-blue';
                        if(($user['role'] ?? '') == 'admin') $roleClass = 'badge-green';
                        if(($user['role'] ?? '') == 'editor') $roleClass = 'badge-blue';
                        ?>
                        <span class="badge <?= $roleClass ?>"><?= ucfirst($user['role'] ?? 'Staff') ?></span>
                    </td>
                    <td>
                        <?php 
                        $perms = !empty($user['permissions']) ? json_decode($user['permissions'], true) : [];
                        if(!empty($perms)) {
                            echo count($perms) . ' permissions active';
                        } else {
                            echo '<span style="color: #94a3b8;">No specific permissions set</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/permissions/<?= $user['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-lock"></i> Manage Permissions
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
