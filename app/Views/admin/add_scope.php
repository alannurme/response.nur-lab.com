<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Scope of Work</h3>
        <a href="<?= URLROOT ?>/admin/scopes" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_scope" method="POST">
        <div class="form-group mb-4">
            <label>Title (শিরোনাম)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. ইসলাম" required>
        </div>

        <div class="form-group mb-4">
            <label>Icon Class (ফন্টঅসাম আইকন)</label>
            <input type="text" name="icon" id="scope_icon" class="form-control" placeholder="e.g. fas fa-mosque" required>
            <small style="color: var(--text-muted); display: block; margin-top: 5px;">
                You can use any FontAwesome 6 class. Popular choices: 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('scope_icon').value='fas fa-mosque'">fas fa-mosque</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('scope_icon').value='fas fa-book-open'">fas fa-book-open</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('scope_icon').value='fas fa-graduation-cap'">fas fa-graduation-cap</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('scope_icon').value='fas fa-scale-balanced'">fas fa-scale-balanced</span>, 
                <span style="cursor: pointer; text-decoration: underline; color: var(--primary);" onclick="document.getElementById('scope_icon').value='fas fa-hands-praying'">fas fa-hands-praying</span>
            </small>
        </div>

        <div class="form-group mb-4">
            <label>Description (বিবরণ)</label>
            <textarea name="description" class="form-control" rows="6" placeholder="Enter detailed description..." required></textarea>
        </div>

        <div class="form-group mb-5">
            <label>Display Order (Lower numbers show first)</label>
            <input type="number" name="order_index" value="0" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Scope</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
