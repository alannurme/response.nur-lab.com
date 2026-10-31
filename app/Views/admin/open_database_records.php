<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Record List</h1>
        <p>Open Database &mdash; View and manage all database records</p>
    </div>
    <a href="<?= URLROOT ?>/admin/open_database_add" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
        <i class="fas fa-plus-circle"></i> Add New Record
    </a>
</div>

<div class="admin-card" style="background: white; border-radius: 20px; border: 1px solid #f1f5f9; box-shadow: 0 10px 30px rgba(0,0,0,0.03); min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px;">
    <div style="max-width: 460px;">
        <div style="width: 70px; height: 70px; border-radius: 20px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px; border: 1.5px solid #bfdbfe;">
            <i class="fas fa-list-ul"></i>
        </div>
        <h3 style="color: #0f172a; font-size: 1.3rem; font-weight: 800; margin-bottom: 8px;">Record List</h3>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0; line-height: 1.6;">This section is currently ready for records table and filter tools.</p>
    </div>
</div>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

