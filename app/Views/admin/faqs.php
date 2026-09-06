<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Frequently Asked Questions (সাধারণ জিজ্ঞাসা)</h1>
        <p>Manage FAQs shown on the homepage bottom section</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_faq" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add FAQ
    </a>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Order</th>
                    <th>Question (প্রশ্ন)</th>
                    <th>Answer (উত্তর)</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['faqs'])): ?>
                    <?php foreach ($data['faqs'] as $faq): ?>
                    <tr>
                        <td style="font-weight: 700;"><?= $faq['order_index'] ?></td>
                        <td style="font-weight: 700; max-width: 250px; white-space: normal !important;"><?= htmlspecialchars($faq['question']) ?></td>
                        <td style="max-width: 450px; white-space: normal !important;">
                            <div style="max-height: 80px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.5; color: var(--text-muted); font-size: 0.9rem;">
                                <?= strip_tags($faq['answer']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?= $faq['status'] === 'active' ? 'badge-blue' : 'badge-red' ?>">
                                <?= ucfirst(htmlspecialchars($faq['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= URLROOT ?>/admin/edit_faq/<?= $faq['id'] ?>" class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_faq/<?= $faq['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this FAQ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">No FAQs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
