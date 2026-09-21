<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header justify-content-between d-flex align-items-center mb-4">
    <div>
        <h1 class="text-premium-glow">Donation Logs</h1>
        <p>Manage and track all donations contributed by visitors</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success mb-4"><?= htmlspecialchars($data['success']) ?></div>
<?php endif; ?>

<?php
// Calculate simple stats on the fly
$total_amount = 0;
$completed_count = 0;
$pending_count = 0;
if (!empty($data['donations'])) {
    foreach ($data['donations'] as $donation) {
        if ($donation['status'] === 'completed') {
            $total_amount += $donation['amount'];
            $completed_count++;
        } elseif ($donation['status'] === 'pending') {
            $pending_count++;
        }
    }
}
?>

<!-- Donation Stats Summary Cards -->
<div class="dashboard-grid mb-5" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 20px;">
        <div style="width: 50px; height: 50px; background: rgba(22, 163, 74, 0.1); color: #16a34a; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-hand-holding-dollar"></i>
        </div>
        <div>
            <h4 style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; font-weight: 500;">Total Donations Received</h4>
            <h2 style="font-weight: 800; font-size: 1.8rem; margin: 0; color: var(--text-main);"><?= number_format($total_amount, 2) ?> BDT</h2>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 20px;">
        <div style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.1); color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <h4 style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; font-weight: 500;">Completed</h4>
            <h2 style="font-weight: 800; font-size: 1.8rem; margin: 0; color: var(--text-main);"><?= $completed_count ?></h2>
        </div>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 20px;">
        <div style="width: 50px; height: 50px; background: rgba(234, 179, 8, 0.1); color: #eab308; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <h4 style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; font-weight: 500;">Pending</h4>
            <h2 style="font-weight: 800; font-size: 1.8rem; margin: 0; color: var(--text-main);"><?= $pending_count ?></h2>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="data-table-container" style="overflow-x: auto; width: 100%;">
        <table class="data-table" style="width: 100%; min-width: 1100px !important; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 18%;">Donor</th>
                    <th style="width: 12%;">Amount</th>
                    <th style="width: 15%;">Purpose</th>
                    <th style="width: 15%;">Payment Method</th>
                    <th style="width: 15%;">Payment ID</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 13%; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['donations'])): ?>
                    <?php foreach ($data['donations'] as $donation): ?>
                    <tr>
                        <td>
                            <div style="color: var(--text-main); font-weight: 700;"><?= htmlspecialchars($donation['donor_name']) ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?= htmlspecialchars($donation['donor_email'] ?? 'No email') ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?= htmlspecialchars($donation['donor_phone']) ?></div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;"><?= date('M d, Y h:i A', strtotime($donation['created_at'])) ?></div>
                        </td>
                        <td style="font-weight: 700; color: #16a34a; font-size: 1.05rem;">
                            <?= number_format($donation['amount'], 2) ?> BDT
                        </td>
                        <td>
                            <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-weight: 600;">
                                <?= htmlspecialchars($donation['purpose'] ?? 'General') ?>
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--text-main); text-transform: uppercase;">
                                <?= htmlspecialchars($donation['payment_method']) ?>
                            </div>
                        </td>
                        <td>
                            <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; border: 1px solid #e2e8f0; color: #e11d48; word-break: break-all;">
                                <?= htmlspecialchars($donation['payment_id'] ?? 'N/A') ?>
                            </code>
                        </td>
                        <td>
                            <form action="<?= URLROOT ?>/admin/update_donation_status/<?= $donation['id'] ?>" method="POST" style="margin: 0; display: inline-flex; align-items: center; gap: 5px;">
                                <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 5px 10px; font-size: 0.85rem; border-radius: 8px; font-weight: 600; width: auto; cursor: pointer;
                                    <?php 
                                    if ($donation['status'] === 'completed') echo 'background: rgba(22, 163, 74, 0.1); color: #16a34a; border-color: rgba(22, 163, 74, 0.2);';
                                    elseif ($donation['status'] === 'pending') echo 'background: rgba(234, 179, 8, 0.1); color: #d97706; border-color: rgba(234, 179, 8, 0.2);';
                                    else echo 'background: rgba(239, 68, 68, 0.1); color: #dc2626; border-color: rgba(239, 68, 68, 0.2);';
                                    ?>">
                                    <option value="pending" <?= $donation['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="completed" <?= $donation['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="failed" <?= $donation['status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-buttons" style="justify-content: center; gap: 8px;">
                                <form action="<?= URLROOT ?>/admin/delete_donation/<?= $donation['id'] ?>" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Are you sure you want to delete this donation log?')">
                                    <button type="submit" class="action-btn delete" title="Delete Log" style="background: none; border: none; padding: 0; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <div style="font-size: 2.5rem; margin-bottom: 10px;"><i class="fas fa-receipt"></i></div>
                            <div>No donation logs found.</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
