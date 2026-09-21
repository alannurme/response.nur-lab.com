<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Edit Top Menu: <?= $data['menu']['title'] ?></h3>
        <a href="<?= URLROOT ?>/admin/sub_menus" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_sub_menu/<?= $data['menu']['id'] ?>" method="POST">
        <div class="form-group mb-4">
            <label>Menu Title</label>
            <input type="text" name="title" value="<?= $data['menu']['title'] ?>" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label>URL (Link)</label>
            <input type="text" name="url" value="<?= $data['menu']['url'] ?>" class="form-control" required>
        </div>

        <div class="form-group mb-5">
            <label>Order Index</label>
            <input type="number" name="order_index" value="<?= $data['menu']['order_index'] ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Update Menu Item</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
