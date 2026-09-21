<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit FAQ</h3>
        <a href="<?= URLROOT ?>/admin/faqs" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_faq/<?= $data['faq']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label>Question (প্রশ্ন)</label>
            <input type="text" name="question" class="form-control" value="<?= htmlspecialchars($data['faq']['question']) ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Status (স্ট্যাটাস)</label>
                <select name="status" class="form-control" required>
                    <option value="active" <?= $data['faq']['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $data['faq']['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label>Display Order (ক্রম সংখ্যা)</label>
                <input type="number" name="order_index" value="<?= $data['faq']['order_index'] ?>" class="form-control" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Answer (উত্তর - HTML tags allowed for links)</label>
            <textarea name="answer" class="form-control" rows="8" required><?= htmlspecialchars($data['faq']['answer']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Update FAQ</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
