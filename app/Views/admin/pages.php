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
                    <td style="font-weight: 700; color: var(--text-main);"><?= $page['title'] ?></td>
                    <td style="color: var(--text-muted);">/<?= $page['slug'] ?></td>
                    <td><?= date('M d, Y', strtotime($page['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/page/<?= $page['slug'] ?>" target="_blank" class="action-btn" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_page/<?= $page['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure?')">
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
