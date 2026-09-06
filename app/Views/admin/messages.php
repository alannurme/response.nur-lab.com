<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Contact Messages</h1>
        <p>Inquiries and feedback from your website visitors</p>
    </div>
</div>

<form action="<?= URLROOT ?>/admin/bulk_messages" method="POST" id="bulk-messages-form">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; width: fit-content;">
        <select name="action" id="bulk-messages-select" class="form-control" style="width: auto; padding: 8px 15px; border-radius: 8px; border: 1.5px solid #eee; background: #fff; color: var(--text-main); font-weight: 600; outline: none; transition: 0.3s;">
            <option value="">Bulk Actions</option>
            <option value="read">Mark as Read</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-check"></i> Apply
        </button>
    </div>

    <div class="admin-card">
        <div class="data-table-container" style="overflow-x: auto; width: 100%;">
            <table class="data-table" style="width: 100%; min-width: 950px !important; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-messages" style="transform: scale(1.2); cursor: pointer;"></th>
                        <th style="width: 20%; min-width: 180px;">From</th>
                        <th style="width: 20%; min-width: 150px;">Subject</th>
                        <th style="width: 35%; min-width: 280px;">Message</th>
                        <th style="width: 10%; min-width: 100px;">Status</th>
                        <th style="width: 10%; min-width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['messages'] as $msg): ?>
                    <tr style="<?= $msg['status'] === 'unread' ? 'background: rgba(0, 107, 67, 0.02); font-weight: 600;' : '' ?>">
                        <td style="text-align: center;"><input type="checkbox" name="message_ids[]" value="<?= $msg['id'] ?>" class="message-checkbox" style="transform: scale(1.2); cursor: pointer;"></td>
                        <td style="white-space: normal; word-break: break-word;">
                            <div style="color: var(--text-main); font-weight: 700; word-break: break-all;"><?= htmlspecialchars($msg['name']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 400; word-break: break-all;"><?= htmlspecialchars($msg['email']) ?></div>
                        </td>
                        <td style="white-space: normal; word-break: break-word;"><?= htmlspecialchars($msg['subject']) ?></td>
                        <td style="white-space: normal; word-break: break-word; font-size: 0.85rem; color: var(--text-secondary); font-weight: 400;">
                            <?= nl2br(htmlspecialchars($msg['message'])) ?>
                        </td>
                        <td>
                            <?php if ($msg['status'] === 'unread'): ?>
                                <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Unread</span>
                            <?php else: ?>
                                <span class="badge badge-green">Read</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-buttons" style="justify-content: center; gap: 8px;">
                                <?php if ($msg['status'] === 'unread'): ?>
                                <a href="<?= URLROOT ?>/admin/mark_read/<?= $msg['id'] ?>" class="action-btn" title="Mark as Read">
                                    <i class="fas fa-check"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= URLROOT ?>/admin/delete_message/<?= $msg['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data['messages'])): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">No messages found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
document.getElementById('select-all-messages').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.message-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulk-messages-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-messages-select').value;
    if (!action) {
        alert('Please select an action.');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.message-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one message.');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `Are you sure you want to delete ${checkedCount} selected message(s)?`;
    } else if (action === 'read') {
        confirmMsg = `Are you sure you want to mark ${checkedCount} selected message(s) as read?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
