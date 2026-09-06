<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="justify-content-between d-flex align-items-center mb-5">
        <h3 class="m-0">Add New Top Menu Item</h3>
        <a href="<?= URLROOT ?>/admin/sub_menus" class="btn btn-visit-site">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/add_sub_menu" method="POST">
        <div class="form-group mb-4">
            <label>Menu Title (Bangla or English)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. যোগাযোগ / Contact" required>
        </div>

        <div class="form-group mb-4">
            <label>URL (Link)</label>
            <input type="text" name="url" class="form-control" placeholder="e.g. /contact or https://google.com" required>
            <small style="color: #64748b;">Use /about for about page, /contact for contact page etc.</small>
        </div>

        <div class="form-group mb-5">
            <label>Order Index (Smallest number shows first)</label>
            <input type="number" name="order_index" value="0" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 55px; font-weight: 700; font-size: 1.1rem;">Add Menu Item</button>
    </form>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
