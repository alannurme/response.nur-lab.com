<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Reader Reviews (পাঠকদের রিভিউ)</h1>
        <p>Manage review testimonials shown on the homepage carousel</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_review" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Review
    </a>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Photo</th>
                    <th>Reader Name</th>
                    <th>Designation</th>
                    <th style="width: 100px;">Rating</th>
                    <th>Review Content</th>
                    <th style="width: 80px;">Order</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['reviews'] as $review): ?>
                <tr>
                    <td>
                        <img src="<?=!empty($review['image']) ? $review['image'] : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review['name']))) . '?d=mp&s=150'?>" loading="lazy" decoding="async" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid var(--primary);">
                    </td>
                    <td style="font-weight: 700;"><?= htmlspecialchars($review['name']) ?></td>
                    <td><span class="badge badge-blue"><?= htmlspecialchars($review['designation'] ?? 'নিয়মিত পাঠক') ?></span></td>
                    <td>
                        <div style="color: #eab308; display: flex; gap: 2px;">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                    </td>
                    <td style="max-width: 350px; white-space: normal !important;">
                        <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; color: var(--text-muted); font-size: 0.9rem; white-space: normal !important;">
                            <?= htmlspecialchars($review['review_text']) ?>
                        </div>
                    </td>
                    <td><?= $review['order_index'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/admin/edit_review/<?= $review['id'] ?>" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_review/<?= $review['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this review?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
