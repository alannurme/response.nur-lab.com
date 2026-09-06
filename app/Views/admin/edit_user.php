<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit User Profile</h3>
        <a href="<?= URLROOT ?>/admin/users" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_user/<?= $data['user']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label>Username</label>
            <input type="text" name="username" value="<?= $data['user']['username'] ?>" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= $data['user']['email'] ?? '' ?>" class="form-control" placeholder="Enter your email address">
        </div>

        <div class="form-group mb-5">
            <label>New Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="form-control" placeholder="Enter new password if you want to change it">
        </div>

        <div style="background: #e9ecef; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
            <p style="margin: 0; font-size: 0.85rem; color: #495057;">
                <i class="fas fa-info-circle"></i> প্রোফাইল তথ্য পরিবর্তনের পর ইউজারকে নতুন পাসওয়ার্ড দিয়ে লগইন করতে হবে।
            </p>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Profile Info</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
