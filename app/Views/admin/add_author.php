<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Author</h3>
        <a href="<?= URLROOT ?>/admin/authors" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_author" method="POST">
        <div class="form-group mb-4">
            <label class="form-label">Author Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Zakir Naik" required>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Author Email</label>
            <input type="email" name="email" class="form-control" placeholder="e.g. author@example.com">
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Profile Image</label>
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <img id="author_preview" src="" style="max-height: 100px; border-radius: 10px; display: none; border: 1px solid #ddd;" loading="lazy" decoding="async">
                <div style="flex: 1;">
                    <input type="text" id="author_image_path" name="image" class="form-control" readonly placeholder="Select image from media library">
                    <button type="button" class="btn btn-secondary w-100" style="margin-top: 10px;" onclick="openMediaPicker('author_image_path', 'author_preview')">
                        <i class="fas fa-image"></i> Select from Media Library
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Author</button>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
