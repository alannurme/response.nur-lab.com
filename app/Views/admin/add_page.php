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

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea[name="content"]',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor blockquote | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500,
        branding: false,
        promotion: false,
        contextmenu: false
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
