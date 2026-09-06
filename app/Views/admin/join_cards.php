<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Join Us Cards (আমাদের সাথে যুক্ত হোন)</h1>
        <p>Manage the dynamic contribution cards displayed on the Join Us page</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_join_card" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Card
    </a>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Icon</th>
                    <th>Title</th>
                    <th style="max-width: 400px;">Description</th>
                    <th style="width: 100px;">Order</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cards'] as $card): ?>
                <tr>
                    <td>
                        <div style="width: 45px; height: 45px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                            <i class="<?= $card['icon'] ?>"></i>
                        </div>
                    </td>
                    <td style="font-weight: 700;"><?= htmlspecialchars($card['title']) ?></td>
                    <td style="max-width: 450px; white-space: normal !important;"><div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; color: var(--text-muted); font-size: 0.9rem; white-space: normal !important;"><?= htmlspecialchars($card['description']) ?></div></td>
                    <td><?= $card['order_index'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/admin/edit_join_card/<?= $card['id'] ?>" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_join_card/<?= $card['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this card?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['cards'])): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">No join cards found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
