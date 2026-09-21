<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Q&A Categories</h1>
        <p>Manage Q&A categories for public questions organization</p>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
        <?php
        if ($_GET['msg'] === 'added') echo 'Category added successfully!';
        if ($_GET['msg'] === 'updated') echo 'Category updated successfully!';
        if ($_GET['msg'] === 'deleted') echo 'Category deleted successfully!';
        ?>
    </div>
<?php endif; ?>

<div class="categories-grid">
    <!-- Add Category Form -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Add New Q&A Category</h3>
        <form action="<?= URLROOT ?>/admin/question_categories" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. আকীদা (Aqeedah)" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </form>
    </div>

    <!-- Category List -->
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Existing Q&A Categories</h3>
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): ?>
                            <tr>
                                <td style="font-weight: 700; color: var(--text-main);">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </td>
                                <td style="color: var(--text-muted);"><?= urldecode($cat['slug']) ?></td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="<?= URLROOT ?>/admin/edit_question_category/<?= $cat['id'] ?>" class="action-btn" title="Edit Category" style="background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <a href="<?= URLROOT ?>/admin/delete_question_category/<?= $cat['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this category?')" style="background: #fdf2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border-radius: 8px; text-decoration: none;">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
