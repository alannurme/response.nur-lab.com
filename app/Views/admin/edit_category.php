<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit Category: <?= htmlspecialchars($data['category']['name']) ?></h3>
        <a href="<?= URLROOT ?>/admin/categories" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_category/<?= $data['category']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['category']['name']) ?>" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Category Slug</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($data['category']['slug']) ?>" class="form-control">
            <small style="color: #64748b; margin-top: 5px; display: block;">Leave blank to auto-generate from name.</small>
        </div>

        <div class="form-group mb-5">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">None (Top Level Category)</option>
                <?php 
                if (!empty($data['categories'])):
                    // Filter parent categories (only root ones, and make sure we cannot select ourselves as parent)
                    $parents = array_filter($data['categories'], function($c) use ($data) { 
                        return empty($c['parent_id']) && $c['id'] != $data['category']['id']; 
                    });
                    foreach ($parents as $p): 
                    ?>
                        <option value="<?= $p['id'] ?>" <?= $data['category']['parent_id'] == $p['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['name']) ?></option>
                    <?php 
                    endforeach; 
                endif;
                ?>
            </select>
            <small style="color: #64748b; margin-top: 5px; display: block;">Optional. Select parent category to make this a subcategory.</small>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Update Category</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
