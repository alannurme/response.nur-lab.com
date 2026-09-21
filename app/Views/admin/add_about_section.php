<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New About Section</h3>
        <a href="<?= URLROOT ?>/admin/about_sections" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_about_section" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Subtitle (উপ-শিরোনাম)</label>
                <input type="text" name="subtitle" class="form-control" placeholder="e.g. আমাদের সম্পর্কে" required>
            </div>
            <div class="form-group mb-4">
                <label>Title (প্রধান শিরোনাম)</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. আমাদের প্রত্যয়" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Highlight Title (হাইলাইট শিরোনাম - নীল)</label>
            <input type="text" name="highlight_title" class="form-control" placeholder="e.g. আমাদের উদ্দেশ্য" required>
        </div>

        <div class="form-group mb-4">
            <label>Section Image (ছবি)</label>
            <div style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="width: 150px; height: 100px; border-radius: 12px; overflow: hidden; border: 2px dashed #ddd; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                    <img id="about_preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;" loading="lazy" decoding="async">
                    <i id="preview_placeholder" class="fas fa-image" style="font-size: 2rem; color: #cbd5e1;"></i>
                </div>
                <div style="flex: 1;">
                    <input type="text" id="about_image_path" name="image" class="form-control" required readonly>
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <button type="button" class="btn btn-secondary w-100" onclick="openMediaPicker('about_image_path', 'about_preview')">
                            <i class="fas fa-photo-video"></i> Select Section Image
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Description (বিবরণ)</label>
            <textarea name="description" class="form-control" rows="8" placeholder="Enter description content..." required></textarea>
        </div>

        <div class="form-group mb-5">
            <label>Display Order (Lower numbers show first)</label>
            <input type="number" name="order_index" value="0" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Section</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
