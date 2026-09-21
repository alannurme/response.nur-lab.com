<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Scopes of Work (আমাদের কার্যপরিধি)</h1>
        <p>Manage the dynamic scope cards displayed on the home page</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_scope" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Scope
    </a>
</div>

<div class="admin-card" style="margin-bottom: 24px; padding: 20px; display: flex; align-items: center; justify-content: space-between; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="width: 50px; height: 50px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-eye"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">Section Status on Website</h3>
            <p style="margin: 3px 0 0 0; font-size: 0.9rem; color: #64748b;">Turn this section visible or hidden on the About page</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 12px;">
        <span id="scope-status-badge" class="badge <?= (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1') ? 'badge-success' : 'badge-danger' ?>" style="font-size: 0.85rem; padding: 6px 12px; border-radius: 20px; font-weight: 700; display: inline-block;">
            <?= (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1') ? 'ACTIVE (VISIBLE)' : 'HIDDEN (OFF)' ?>
        </span>
        <button type="button" onclick="toggleScopesSectionVisibility()" class="btn" style="background: #475569; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
            <i class="fas fa-toggle-on"></i> Toggle Visibility
        </button>
    </div>
</div>

<script>
function toggleScopesSectionVisibility() {
    const badge = document.getElementById('scope-status-badge');
    const isCurrentlyActive = badge.classList.contains('badge-success');
    const newValue = isCurrentlyActive ? '0' : '1';
    
    // Create form data to submit to the settings endpoint via AJAX
    const formData = new FormData();
    formData.append('settings[show_scopes]', newValue);
    
    fetch('<?= URLROOT ?>/admin/settings', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        // Toggle the visual badge status dynamically without page reload
        if (newValue === '1') {
            badge.className = 'badge badge-success';
            badge.textContent = 'ACTIVE (VISIBLE)';
            badge.style.background = '#22c55e';
            badge.style.color = '#fff';
        } else {
            badge.className = 'badge badge-danger';
            badge.textContent = 'HIDDEN (OFF)';
            badge.style.background = '#ef4444';
            badge.style.color = '#fff';
        }
    })
    .catch(err => {
        alert('Failed to update visibility status.');
        console.error(err);
    });
}
</script>

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
                <?php foreach ($data['scopes'] as $scope): ?>
                <tr>
                    <td>
                        <div style="width: 45px; height: 45px; border-radius: 12px; background: rgba(239, 68, 68, 0.1); color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                            <i class="<?= $scope['icon'] ?>"></i>
                        </div>
                    </td>
                    <td style="font-weight: 700;"><?= $scope['title'] ?></td>
                    <td style="max-width: 450px; white-space: normal !important;"><div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; color: var(--text-muted); font-size: 0.9rem; white-space: normal !important;"><?= htmlspecialchars($scope['description']) ?></div></td>
                    <td><?= $scope['order_index'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/admin/edit_scope/<?= $scope['id'] ?>" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_scope/<?= $scope['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this scope?')">
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
