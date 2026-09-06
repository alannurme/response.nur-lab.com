<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <h1 class="text-premium-glow">Video Categories</h1>
    <p>Organize your YouTube videos into logical sections</p>
</div>

<div class="categories-grid">
    <!-- Add Category Form -->
    <div class="admin-card">
        <h4 class="mb-4">Add New Category</h4>
        <form action="<?= URLROOT ?>/admin/yt_categories" method="POST">
            <div class="form-group mb-4">
                <label>Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Quran Tilawat" required>
            </div>
            <button type="submit" class="btn btn-save w-100">Add Category</button>
        </form>
    </div>

    <!-- Category List -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['categories'] as $cat): ?>
                    <tr>
                        <td>#<?= $cat['id'] ?></td>
                        <td class="fw-bold"><?= $cat['name'] ?></td>
                        <td><code><?= $cat['slug'] ?></code></td>
                        <td class="text-end">
                            <a href="<?= URLROOT ?>/admin/delete_yt_category/<?= $cat['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Deleting this category will set all related videos to Uncategorized. Continue?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data['categories'])): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No categories created yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
