<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<?php
$userPermissions = !empty($data['user']['permissions']) ? json_decode($data['user']['permissions'], true) : [];
?>

<div class="admin-card" style="max-width: 850px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <div>
            <h3 class="m-0">Access Control for: <span style="color: var(--primary);"><?= $data['user']['username'] ?></span></h3>
            <p class="text-muted m-0">Define what this user can see and do in the admin panel</p>
        </div>
        <a href="<?= URLROOT ?>/admin/permissions" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/permissions/<?= $data['user']['id'] ?>" method="POST">
        <!-- Hidden Username to keep it unchanged -->
        <input type="hidden" name="username" value="<?= $data['user']['username'] ?>">

        <div class="form-group mb-5">
            <label style="font-weight: 700;">Assign System Role</label>
            <select name="role" class="form-control" style="border-left: 5px solid var(--primary);">
                <option value="admin" <?= $data['user']['role'] == 'admin' ? 'selected' : '' ?>>Administrator (Full System Access)</option>
                <option value="editor" <?= $data['user']['role'] == 'editor' ? 'selected' : '' ?>>Editor (Content Management)</option>
                <option value="author" <?= $data['user']['role'] == 'author' ? 'selected' : '' ?>>Author (Personal Posts Only)</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="mb-3 d-block" style="font-weight: 700; color: #1e293b;">Specific Permissions (Fine-grained Control)</label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #fff; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                <?php 
                $availablePermissions = [
                    'manage_posts' => ['label' => 'Posts Management', 'icon' => 'fa-edit'],
                    'manage_categories' => ['label' => 'Categories Control', 'icon' => 'fa-tags'],
                    'manage_slides' => ['label' => 'Hero Slider Settings', 'icon' => 'fa-images'],
                    'manage_users' => ['label' => 'Staff & User Management', 'icon' => 'fa-users-cog'],
                    'manage_comments' => ['label' => 'Comment Moderation', 'icon' => 'fa-comments'],
                    'manage_settings' => ['label' => 'Global Site Settings', 'icon' => 'fa-cog'],
                    'manage_pages' => ['label' => 'Static Pages (About, etc)', 'icon' => 'fa-file-alt'],
                    'manage_media' => ['label' => 'Full Media Library Access', 'icon' => 'fa-photo-video']
                ];
                foreach ($availablePermissions as $key => $info): 
                ?>
                <label style="display: flex; align-items: center; gap: 15px; cursor: pointer; padding: 15px; border: 1px solid #f1f5f9; border-radius: 12px; transition: 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <input type="checkbox" name="permissions[]" value="<?= $key ?>" <?= in_array($key, $userPermissions) ? 'checked' : '' ?> style="width: 20px; height: 20px; accent-color: var(--primary);">
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; color: #334155;"><i class="fas <?= $info['icon'] ?> mr-2"></i> <?= $info['label'] ?></span>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 60px; font-size: 1.1rem; font-weight: 800; border-radius: 15px; box-shadow: 0 10px 25px rgba(21,128,61,0.2);">Update Access Rights Now</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
