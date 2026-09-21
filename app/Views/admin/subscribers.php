<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Newsletter Subscribers</h1>
        <p>Manage your email list and reach out to your audience</p>
    </div>
    <a href="<?= URLROOT ?>/admin/export_subscribers" class="btn btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fas fa-file-export"></i> Export CSV
    </a>
</div>

<form action="<?= URLROOT ?>/admin/bulk_delete_subscribers" method="POST" id="bulk-action-form">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; width: fit-content;">
        <select name="action" id="bulk-action-select" class="form-control" style="width: auto; padding: 8px 15px; border-radius: 8px; border: 1.5px solid #eee; background: #fff; color: var(--text-main); font-weight: 600; outline: none; transition: 0.3s;">
            <option value="">Bulk Actions</option>
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
                        <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-subscribers" style="transform: scale(1.2); cursor: pointer;"></th>
                        <th>Email Address</th>
                        <th>Subscription Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['subscribers'] as $sub): ?>
                    <tr>
                        <td style="text-align: center;"><input type="checkbox" name="subscriber_ids[]" value="<?= $sub['id'] ?>" class="subscriber-checkbox" style="transform: scale(1.2); cursor: pointer;"></td>
                        <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($sub['email']) ?></td>
                        <td><?= date('M d, Y', strtotime($sub['created_at'])) ?></td>
                        <td><span class="badge badge-green">Subscribed</span></td>
                        <td>
                            <a href="<?= URLROOT ?>/admin/delete_subscriber/<?= $sub['id'] ?>" class="action-btn delete" title="Unsubscribe" onclick="return confirm('Are you sure you want to delete this subscriber?')">
                                <i class="fas fa-user-minus"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data['subscribers'])): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">No subscribers yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>

document.getElementById('select-all-subscribers').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.subscriber-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulk-action-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-action-select').value;
    if (!action) {
        alert('Please select an action.');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.subscriber-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one subscriber.');
        e.preventDefault();
        return;
    }
    if (!confirm(`Are you sure you want to delete ${checkedCount} selected subscriber(s)?`)) {
        e.preventDefault();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
