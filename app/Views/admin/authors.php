<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Authors</h1>
        <p>Manage authors for your blog articles</p>
    </div>
</div>

<div class="categories-grid">
    <!-- Add Author Form -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Add New Author</h3>
        <form action="<?= URLROOT ?>/admin/add_author" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Author Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Zakir Naik" required>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Author Email</label>
                <input type="email" name="email" class="form-control" placeholder="e.g. author@example.com">
            </div>



            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fas fa-plus"></i> Add Author
            </button>
        </form>
    </div>

    <!-- Author List -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Existing Authors</h3>
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['authors'])): ?>
                        <?php foreach ($data['authors'] as $author): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($author['name']) ?></td>
                                <td style="color: var(--text-muted);"><?= htmlspecialchars($author['email'] ?? 'N/A') ?></td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_author/<?= $author['id'] ?>" class="action-btn" title="Edit Author" style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php if ($author['name'] !== 'Admin'): ?>
                                        <a href="<?= URLROOT ?>/admin/delete_author/<?= $author['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this author?')" style="background: #fdf2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">No authors found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
