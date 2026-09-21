<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New FAQ</h3>
        <a href="<?= URLROOT ?>/admin/faqs" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_faq" method="POST">
        <div class="form-group mb-4">
            <label>Question (প্রশ্ন)</label>
            <input type="text" name="question" class="form-control" placeholder="e.g. আপনাদের সম্পর্কে জানতে চাই।" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div class="form-group mb-4">
                <label>Status (স্ট্যাটাস)</label>
                <select name="status" class="form-control" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label>Display Order (ক্রম সংখ্যা)</label>
                <input type="number" name="order_index" value="0" class="form-control" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label>Answer (উত্তর - HTML tags allowed for links)</label>
            <textarea name="answer" class="form-control" rows="8" placeholder="Enter answer details here..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add FAQ</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
