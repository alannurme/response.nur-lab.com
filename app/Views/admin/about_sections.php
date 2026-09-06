<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">About Sections (আমাদের প্রত্যয় ও উদ্দেশ্য)</h1>
        <p>Manage the intro sections displayed on the homepage</p>
    </div>
    <a href="<?= URLROOT ?>/admin/add_about_section" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Section
    </a>
</div>

<div class="admin-card">
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 150px;">Image</th>
                    <th>Subtitle</th>
                    <th>Title & Highlight</th>
                    <th>Description</th>
                    <th style="width: 100px;">Order</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['about_sections'] as $about): ?>
                <tr>
                    <td>
                        <img src="<?=$about['image']?>" loading="lazy" decoding="async" style="width: 120px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    </td>
                    <td><span class="badge badge-blue"><?= htmlspecialchars($about['subtitle']) ?></span></td>
                    <td>
                        <div style="font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($about['title']) ?></div>
                        <div style="font-size: 0.8rem; color: var(--primary); font-weight: 600; margin-top: 2px;"><?= htmlspecialchars($about['highlight_title']) ?></div>
                    </td>
                    <td style="max-width: 350px; white-space: normal !important;">
                        <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; color: var(--text-muted); font-size: 0.9rem; white-space: normal !important;">
                            <?= htmlspecialchars($about['description']) ?>
                        </div>
                    </td>
                    <td><?= $about['order_index'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= URLROOT ?>/admin/edit_about_section/<?= $about['id'] ?>" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= URLROOT ?>/admin/delete_about_section/<?= $about['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this section?')">
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
