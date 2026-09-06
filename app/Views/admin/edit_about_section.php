<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit About Section</h3>
        <a href="<?= URLROOT ?>/admin/about_sections" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_about_section/<?= $data['about']['id'] ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Subtitle (উপ-শিরোনাম)</label>
                <input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($data['about']['subtitle']) ?>" required>
            </div>
            <div class="form-group mb-4">
                <label>Title (প্রধান শিরোনাম)</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['about']['title']) ?>" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Highlight Title (হাইলাইট শিরোনাম - নীল)</label>
            <input type="text" name="highlight_title" class="form-control" value="<?= htmlspecialchars($data['about']['highlight_title']) ?>" required>
        </div>

        <div class="form-group mb-4">
            <label>Section Image (ছবি)</label>
            <div style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="width: 150px; height: 100px; border-radius: 12px; overflow: hidden; border: 2px dashed #ddd; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                    <img id="about_preview" src="<?=htmlspecialchars($data['about']['image'])?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="flex: 1;">
                    <input type="text" id="about_image_path" name="image" class="form-control" value="<?= htmlspecialchars($data['about']['image']) ?>" required readonly>
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
            <textarea name="description" class="form-control" rows="8" required><?= htmlspecialchars($data['about']['description']) ?></textarea>
        </div>

        <div class="form-group mb-5">
            <label>Display Order (Lower numbers show first)</label>
            <input type="number" name="order_index" value="<?= $data['about']['order_index'] ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Update Section</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
