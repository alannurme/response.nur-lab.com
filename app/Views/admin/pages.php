<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Static Pages</h1>
        <p>Manage site pages like About, Contact, and Privacy Policy</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_page" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New Page
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
        <?php
        if ($_GET['msg'] === 'created') echo 'Page created successfully!';
        if ($_GET['msg'] === 'updated') echo 'Page updated successfully!';
        if ($_GET['msg'] === 'deleted') echo 'Page deleted successfully!';
        ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Page Title</th>
                    <th>Slug</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['pages'] as $page): ?>
                <tr>
                    <td style="font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($page['title']) ?></td>
                    <td style="color: var(--text-muted);">/page/<?= htmlspecialchars($page['slug']) ?></td>
                    <td><?= date('M d, Y', strtotime($page['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/page/<?= $page['slug'] ?>" target="_blank" class="action-btn" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/edit_page/<?= $page['id'] ?>" class="action-btn" title="Edit" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_page/<?= $page['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this page?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['pages'])): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">No pages found. Create your first page!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
