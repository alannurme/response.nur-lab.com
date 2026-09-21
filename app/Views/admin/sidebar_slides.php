<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card">
    <div class="justify-content-between d-flex align-items-center mb-4">
        <h3 class="m-0">Manage Sidebar Slides (1:1 Ratio)</h3>
        <a href="<?= URLROOT ?>/admin/add_sidebar_slide" class="btn btn-primary">+ Add New Sidebar Slide</a>
    </div>

    <div class="data-table-container">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['slides'] as $slide): ?>
                    <tr>
                        <td>
                            <img src="<?=$slide['image']?>" loading="lazy" decoding="async" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                        </td>
                        <td>
                            <?php if (!empty($slide['link'])): ?>
                                <a href="<?= $slide['link'] ?>" target="_blank" style="color: #60a5fa; font-size: 0.85rem;"><?= $slide['link'] ?></a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-style: italic;">No Link</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge-lite badge-blue"><?= $slide['order_index'] ?></span></td>
                        <td style="display: flex; gap: 1rem; align-items: center; height: 80px;">
                            <a href="<?= URLROOT ?>/admin/edit_sidebar_slide/<?= $slide['id'] ?>" style="color: var(--primary);"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="<?= URLROOT ?>/admin/delete_sidebar_slide/<?= $slide['id'] ?>" onclick="return confirm('Are you sure?')" style="color: #ef4444;"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data['slides'])): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-muted);">No sidebar slides found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
