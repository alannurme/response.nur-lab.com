<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Edit Video Category</h1>
        <p>Modify YouTube video category details</p>
    </div>
</div>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="admin-card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
            <div style="width: 44px; height: 44px; background: #fee2e2; color: #dc2626; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="fab fa-youtube"></i>
            </div>
            <div>
                <h3 style="margin: 0; color: var(--text-main); font-weight: 800;">Edit Category Details</h3>
                <small class="text-muted">ID: #<?= $data['category']['id'] ?></small>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/edit_yt_category/<?= $data['category']['id'] ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group mb-4">
                <label class="form-label" style="font-weight: 700;">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['category']['name']) ?>" placeholder="e.g. কুরআন তিলাওয়াত" required>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" style="font-weight: 700;">Category Slug</label>
                <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($data['category']['slug'] ?? '') ?>" placeholder="e.g. quran-tilawat">
                <small class="text-muted" style="font-size: 0.85rem; margin-top: 5px; display: block;">খালি রাখলে নাম অনুযায়ী স্বয়ংক্রিয়ভাবে স্লাগ তৈরি হবে।</small>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 12px; background: #dc2626; border-color: #dc2626; font-weight: 700; border-radius: 10px;">
                    <i class="fas fa-save me-1"></i> Save Changes
                </button>
                <a href="<?= URLROOT ?>/admin/yt_categories" class="btn btn-secondary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 0 25px; border-radius: 10px; font-weight: 600;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
