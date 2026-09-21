<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Authors</h1>
        <p>Manage authors for your blog articles</p>
    </div>
</div>

<?php if (isset($_SESSION['author_error'])): ?>
    <div style="background: #fdf2f2; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        <?= htmlspecialchars($_SESSION['author_error']) ?>
        <?php unset($_SESSION['author_error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['author_success'])): ?>
    <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        <?= htmlspecialchars($_SESSION['author_success']) ?>
        <?php unset($_SESSION['author_success']); ?>
    </div>
<?php endif; ?>

<div class="categories-grid">
    <!-- Add Author Form -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Add New Author</h3>
        <form action="<?= URLROOT ?>/admin/add_author" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Author Name <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Zakir Naik" required>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Author Email</label>
                <input type="email" name="email" class="form-control" placeholder="e.g. author@example.com">
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Profile Image</label>
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <img id="author_preview" src="" style="max-height: 80px; border-radius: 50%; display: none; border: 1px solid #ddd;" loading="lazy" decoding="async">
                    <div style="flex: 1;">
                        <input type="text" id="author_image_path" name="image" class="form-control" readonly placeholder="Select image from media library">
                        <button type="button" class="btn btn-secondary w-100" style="margin-top: 10px;" onclick="openMediaPicker('author_image_path', 'author_preview')">
                            <i class="fas fa-image"></i> Select from Media Library
                        </button>
                    </div>
                </div>
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
                        <th style="width: 60px;">Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['authors'])): ?>
                        <?php foreach ($data['authors'] as $author): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($author['image'])): ?>
                                        <img src="<?= htmlspecialchars($author['image']) ?>" alt="<?= htmlspecialchars($author['name']) ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bg-hover, #e5e7eb); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 600;">
                                            <?= strtoupper(substr($author['name'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($author['name']) ?></td>
                                <td style="color: var(--text-muted);"><?= htmlspecialchars($author['email'] ?? 'N/A') ?></td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_author/<?= $author['id'] ?>" class="action-btn" title="Edit Author" style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php if ($author['name'] !== 'Admin'): ?>
                                        <a href="<?= URLROOT ?>/admin/delete_author/<?= $author['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this author? Linked posts will be preserved and reassigned to Admin.')" style="background: #fdf2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
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

