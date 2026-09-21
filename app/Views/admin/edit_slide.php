<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit Slide</h3>
        <a href="<?= URLROOT ?>/admin/slides" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_slide/<?= $data['slide']['id'] ?>" method="POST">
        <input type="hidden" name="title" value="<?= $data['slide']['title'] ?>">
        <input type="hidden" name="subtitle" value="<?= $data['slide']['subtitle'] ?>">
        <input type="hidden" name="link" value="<?= $data['slide']['link'] ?>">
        <input type="hidden" name="btn_text" value="<?= $data['slide']['btn_text'] ?? '' ?>">

        <div class="form-group mb-4">
            <label>Slide Image <span style="font-weight: normal; font-size: 0.85rem; color: #a0aec0; margin-left: 5px;">(Recommended: 1200x550px or 16:9 ratio)</span></label>
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <img id="slide_preview" src="<?=$data['slide']['image']?>" loading="lazy" decoding="async" style="max-height: 120px; border-radius: 10px; border: 1px solid #ddd;">
                <div style="flex: 1;">
                    <input type="text" id="slide_image_path" name="image" value="<?= $data['slide']['image'] ?>" class="form-control" required readonly>
                    <button type="button" class="btn btn-secondary" style="margin-top: 10px;" onclick="openMediaPicker('slide_image_path', 'slide_preview')">
                        <i class="fas fa-image"></i> Change Image from Library
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group mb-5">
            <label>Order Index</label>
            <input type="number" name="order_index" value="<?= $data['slide']['order_index'] ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Slide</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
