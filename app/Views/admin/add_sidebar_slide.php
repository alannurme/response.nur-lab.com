<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Sidebar Slide</h3>
        <a href="<?= URLROOT ?>/admin/sidebar_slides" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_sidebar_slide" method="POST">
        <div class="form-group mb-4">
            <label>Sidebar Image (1:1 Aspect Ratio Recommended)</label>
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <img id="slide_preview" src="" style="max-height: 120px; max-width: 120px; object-fit: cover; border-radius: 10px; display: none; border: 1px solid #ddd;" loading="lazy" decoding="async">
                <div style="flex: 1;">
                    <input type="text" id="slide_image_path" name="image" class="form-control" required readonly placeholder="Select image from library">
                    <button type="button" class="btn btn-secondary" style="margin-top: 10px;" onclick="openMediaPicker('slide_image_path', 'slide_preview')">
                        <i class="fas fa-image"></i> Select from Media Library
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Link URL (Optional)</label>
            <input type="text" name="link" class="form-control" placeholder="e.g. https://example.com">
        </div>

        <div class="form-group mb-5">
            <label>Order Index</label>
            <input type="number" name="order_index" value="0" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Sidebar Slide</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
