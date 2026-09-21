<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Review</h3>
        <a href="<?= URLROOT ?>/admin/reviews" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_review" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Reviewer Name (পাঠকের নাম)</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. আব্দুর রহমান" required>
            </div>
            <div class="form-group mb-4">
                <label>Designation (পদবী/পরিচয়)</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. নিয়মিত পাঠক" value="নিয়মিত পাঠক" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Rating (রেটিং)</label>
                <select name="rating" class="form-control" required>
                    <option value="5" selected>⭐⭐⭐⭐⭐ (5 Stars)</option>
                    <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                    <option value="3">⭐⭐⭐ (3 Stars)</option>
                    <option value="2">⭐⭐ (2 Stars)</option>
                    <option value="1">⭐ (1 Star)</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label>Display Order (Lower numbers show first)</label>
                <input type="number" name="order_index" value="0" class="form-control" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Profile Photo (ছবি)</label>
            <div style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 2px dashed #ddd; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                    <img id="review_preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;" loading="lazy" decoding="async">
                    <i id="preview_placeholder" class="fas fa-user-plus" style="font-size: 2rem; color: #cbd5e1;"></i>
                </div>
                <div style="flex: 1;">
                    <input type="text" id="review_image_path" name="image" class="form-control" readonly>
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <button type="button" class="btn btn-secondary w-100" onclick="openMediaPicker('review_image_path', 'review_preview')">
                            <i class="fas fa-photo-video"></i> Select Profile Photo
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Review Text (মতামত/রিভিউ বিবরণ)</label>
            <textarea name="review_text" class="form-control" rows="6" placeholder="Enter reader review here..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Review</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
