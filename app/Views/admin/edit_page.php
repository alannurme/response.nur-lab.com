<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Edit Page</h1>
        <p>Modify static page content and details</p>
    </div>
    <a href="<?= URLROOT ?>/admin/pages" class="btn" style="background: #e2e8f0; color: #475569;">
        <i class="fas fa-arrow-left"></i> Back to Pages
    </a>
</div>

<div class="admin-card">
    <form action="<?= URLROOT ?>/admin/edit_page/<?= $data['page']['id'] ?>" method="POST">
        <div class="form-group">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['page']['title']) ?>" class="form-control" required>
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label class="form-label">Page Content</label>
            <textarea name="content" class="form-control" rows="15" required><?= htmlspecialchars($data['page']['content']) ?></textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Page
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
