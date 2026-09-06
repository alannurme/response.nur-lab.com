<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit Author</h3>
        <a href="<?= URLROOT ?>/admin/authors" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_author/<?= $data['author']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label class="form-label">Author Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['author']['name']) ?>" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Author Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['author']['email'] ?? '') ?>" class="form-control">
        </div>



        <button type="submit" class="btn btn-primary w-100">Update Author</button>
    </form>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
