<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Comments</h1>
        <p>Manage and moderate comments on your blog posts</p>
    </div>
</div>

<form action="<?= URLROOT ?>/admin/bulk_comments" method="POST" id="bulk-comments-form">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; width: fit-content;">
        <select name="action" id="bulk-comments-select" class="form-control" style="width: auto; padding: 8px 15px; border-radius: 8px; border: 1.5px solid #eee; background: #fff; color: var(--text-main); font-weight: 600; outline: none; transition: 0.3s;">
            <option value="">Bulk Actions</option>
            <option value="approve">Approve Selected</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-check"></i> Apply
        </button>
    </div>

    <div class="admin-card">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-comments" style="transform: scale(1.2); cursor: pointer;"></th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Post</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['comments'] as $comment): ?>
                    <tr>
                        <td style="text-align: center;"><input type="checkbox" name="comment_ids[]" value="<?= $comment['id'] ?>" class="comment-checkbox" style="transform: scale(1.2); cursor: pointer;"></td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($comment['name']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($comment['email']) ?></div>
                        </td>
                        <td style="max-width: 300px; white-space: normal; color: var(--text-secondary);">
                            <?= htmlspecialchars($comment['comment']) ?>
                        </td>
                        <td>
                            <a href="<?= URLROOT ?>/<?= htmlspecialchars($comment['post_slug'] ?? '') ?>" target="_blank" style="color: var(--primary); text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                <?= htmlspecialchars($comment['post_title']) ?> <i class="fas fa-external-link-alt" style="font-size: 0.7rem; margin-left: 3px;"></i>
                            </a>
                        </td>
                        <td>
                            <?php if ($comment['status'] === 'pending'): ?>
                                <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">Pending</span>
                            <?php else: ?>
                                <span class="badge badge-green">Approved</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($comment['status'] === 'pending'): ?>
                                <a href="<?= URLROOT ?>/admin/approve_comment/<?= $comment['id'] ?>" class="action-btn" title="Approve" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="fas fa-check"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= URLROOT ?>/admin/delete_comment/<?= $comment['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data['comments'])): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">No comments found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
document.getElementById('select-all-comments').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.comment-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulk-comments-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-comments-select').value;
    if (!action) {
        alert('Please select an action.');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.comment-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one comment.');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `Are you sure you want to delete ${checkedCount} selected comment(s)?`;
    } else if (action === 'approve') {
        confirmMsg = `Are you sure you want to approve ${checkedCount} selected comment(s)?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
