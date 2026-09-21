<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Join Card</h3>
        <a href="<?= URLROOT ?>/admin/join_cards" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_join_card" method="POST">
        <div class="form-group mb-4">
            <label>Title (শিরোনাম)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. লেখালেখি & আলোচনা" required>
        </div>

        <div class="form-group mb-4">
            <label>Icon Class (ফন্টঅসাম আইকন)</label>
            <input type="text" name="icon" id="card_icon" class="form-control" placeholder="e.g. fas fa-pen-nib" required>
            <small style="color: var(--text-muted); display: block; margin-top: 5px;">
                You can use any FontAwesome 6 class. Popular choices: 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('card_icon').value='fas fa-pen-nib'">fas fa-pen-nib</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('card_icon').value='fas fa-desktop'">fas fa-desktop</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('card_icon').value='fas fa-photo-film'">fas fa-photo-film</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('card_icon').value='fas fa-laptop-code'">fas fa-laptop-code</span>
            </small>
        </div>

        <div class="form-group mb-4">
            <label>Description (বিবরণ)</label>
            <textarea name="description" class="form-control" rows="6" placeholder="Enter detailed description..." required></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group mb-4">
                <label>Button Text (ঐচ্ছিক বাটন টেক্সট)</label>
                <input type="text" name="button_text" class="form-control" placeholder="e.g. যুক্ত হন / যোগাযোগ করুন">
            </div>
            <div class="form-group mb-4">
                <label>Button URL (বাটন লিংক)</label>
                <input type="text" name="button_url" class="form-control" placeholder="e.g. /contact or https://forms.gle/...">
            </div>
        </div>

        <div class="form-group mb-5">
            <label>Display Order (Lower numbers show first)</label>
            <input type="number" name="order_index" value="0" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Card</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
