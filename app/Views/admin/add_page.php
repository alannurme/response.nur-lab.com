<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Create New Page</h1>
        <p>Add a new static page to your website</p>
    </div>
</div>

<div class="admin-card">
    <form action="<?= URLROOT ?>/admin/add_page" method="POST">
        <div class="form-group">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. About Us" required>
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label class="form-label">Page Content</label>
            <textarea name="content" class="form-control" rows="15" placeholder="Enter page content here..." required></textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Page
            </button>
            <a href="<?= URLROOT ?>/admin/pages" class="btn" style="background: #e2e8f0; color: #475569;">Cancel</a>
        </div>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
