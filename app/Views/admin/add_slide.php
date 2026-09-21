<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Slide</h3>
        <a href="<?= URLROOT ?>/admin/slides" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_slide" method="POST">
        <input type="hidden" name="title" value="Slide">
        <input type="hidden" name="subtitle" value="">
        <input type="hidden" name="link" value="">
        <input type="hidden" name="btn_text" value="">

        <div class="form-group mb-4">
            <label>Slide Image <span style="font-weight: normal; font-size: 0.85rem; color: #a0aec0; margin-left: 5px;">(Recommended: 1200x550px or 16:9 ratio)</span></label>
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <img id="slide_preview" src="" style="max-height: 100px; border-radius: 10px; display: none; border: 1px solid #ddd;" loading="lazy" decoding="async">
                <div style="flex: 1;">
                    <input type="text" id="slide_image_path" name="image" class="form-control" required readonly placeholder="Select image from library">
                    <button type="button" class="btn btn-secondary" style="margin-top: 10px;" onclick="openMediaPicker('slide_image_path', 'slide_preview')">
                        <i class="fas fa-image"></i> Select from Media Library
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group mb-5">
            <label>Order Index</label>
            <input type="number" name="order_index" value="0" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Slide</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
