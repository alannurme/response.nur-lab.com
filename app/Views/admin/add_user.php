<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Create New Staff User</h3>
        <a href="<?= URLROOT ?>/admin/users" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_user" method="POST">
        <div class="form-group mb-4">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="form-group mb-4">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
        </div>

        <div class="form-group mb-4">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter secure password" required>
        </div>

        <div class="form-group mb-5">
            <label>Role / Designation</label>
            <select name="role" class="form-control" required>
                <option value="admin">Administrator</option>
                <option value="editor">Editor</option>
                <option value="author">Author</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 50px; font-weight: 700;">Create User Account</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
