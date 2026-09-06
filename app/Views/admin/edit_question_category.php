<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Edit Q&A Category</h1>
        <p>Modify category details</p>
    </div>
</div>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-main);">Edit Category Details</h3>
        <form action="<?= URLROOT ?>/admin/edit_question_category/<?= $data['category']['id'] ?>" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['category']['name']) ?>" required>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="<?= URLROOT ?>/admin/question_categories" class="btn btn-secondary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 0 20px;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
