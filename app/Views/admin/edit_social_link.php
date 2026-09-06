<?php require_once APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    <div class="justify-content-between d-flex align-items-center mb-5" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 class="m-0" style="margin: 0; font-family: 'Outfit', sans-serif;">Edit Social Media: <?= htmlspecialchars($data['link']['name']) ?></h3>
        <a href="<?= URLROOT ?>/admin/social_links" class="btn btn-visit-site" style="padding: 8px 16px; border: 1.5px solid var(--primary); color: var(--primary); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">Back to List</a>
    </div>

    <form action="<?= URLROOT ?>/admin/edit_social_link/<?= $data['link']['id'] ?>" method="POST">
        <div class="form-group mb-4" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Social Media Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['link']['name']) ?>" class="form-control" placeholder="e.g. Facebook, Twitter, TikTok" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
        </div>

        <div class="form-group mb-4" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Choose Social Icon</label>
            <div class="icon-picker-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-bottom: 15px;">
                <?php
                $presets = [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'color' => '#1877F2'],
                    ['icon' => 'fab fa-twitter', 'name' => 'Twitter/X', 'color' => '#1DA1F2'],
                    ['icon' => 'fab fa-youtube', 'name' => 'YouTube', 'color' => '#FF0000'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'color' => '#E4405F'],
                    ['icon' => 'fab fa-tiktok', 'name' => 'TikTok', 'color' => '#010101'],
                    ['icon' => 'fab fa-whatsapp', 'name' => 'WhatsApp', 'color' => '#25D366'],
                    ['icon' => 'fab fa-telegram', 'name' => 'Telegram', 'color' => '#0088cc'],
                    ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'color' => '#0077B5'],
                    ['icon' => 'fab fa-pinterest', 'name' => 'Pinterest', 'color' => '#BD081C'],
                    ['icon' => 'fab fa-reddit-alien', 'name' => 'Reddit', 'color' => '#FF4500'],
                    ['icon' => 'fab fa-snapchat', 'name' => 'Snapchat', 'color' => '#FFFC00'],
                    ['fas fa-globe' => 'fas fa-globe', 'name' => 'Website', 'color' => '#64748b']
                ];
                foreach ($presets as $p):
                    $icon_val = isset($p['icon']) ? $p['icon'] : 'fas fa-globe';
                    $isActive = ($data['link']['icon'] === $icon_val);
                    $border = $isActive ? 'var(--primary)' : '#cbd5e1';
                    $bg = $isActive ? 'var(--primary-light)' : '#f8fafc';
                    $shadow = $isActive ? '0 0 0 3px rgba(0, 107, 67, 0.1)' : 'none';
                ?>
                    <div class="icon-picker-item" data-icon="<?= $icon_val ?>" data-name="<?= $p['name'] ?>" title="<?= $p['name'] ?>" style="border: 1px solid <?= $border ?>; border-radius: 12px; padding: 12px; text-align: center; cursor: pointer; transition: 0.2s; background: <?= $bg ?>; box-shadow: <?= $shadow ?>;">
                        <i class="<?= $icon_val ?>" style="font-size: 1.4rem; color: <?= $p['color'] ?>;"></i>
                    </div>
                <?php endforeach; ?>
            </div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">Icon Class (Auto-filled on click, or type custom)</label>
            <input type="text" name="icon" id="icon-input" value="<?= htmlspecialchars($data['link']['icon']) ?>" class="form-control" placeholder="e.g. fab fa-facebook-f" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
            <small style="color: #64748b; margin-top: 5px; display: block;">You can select one of the templates above or input any custom class name from <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" style="color: var(--primary); font-weight: 600;">FontAwesome</a>.</small>
        </div>

        <script>
            document.querySelectorAll('.icon-picker-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active styles from all
                    document.querySelectorAll('.icon-picker-item').forEach(i => {
                        i.style.borderColor = '#cbd5e1';
                        i.style.background = '#f8fafc';
                        i.style.boxShadow = 'none';
                    });
                    
                    // Set active style to clicked
                    this.style.borderColor = 'var(--primary)';
                    this.style.background = 'var(--primary-light)';
                    this.style.boxShadow = '0 0 0 3px rgba(0, 107, 67, 0.1)';
                    
                    // Update input value
                    const iconClass = this.getAttribute('data-icon');
                    document.getElementById('icon-input').value = iconClass;

                    // Update name input if it is empty
                    const nameInput = document.querySelector('input[name="name"]');
                    if (nameInput && nameInput.value.trim() === '') {
                        nameInput.value = this.getAttribute('data-name');
                    }
                });
            });
        </script>

        <div class="form-group mb-4" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Link URL</label>
            <input type="url" name="url" value="<?= htmlspecialchars($data['link']['url']) ?>" class="form-control" placeholder="e.g. https://facebook.com/page" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
        </div>

        <div class="form-group mb-5" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Order Index</label>
            <input type="number" name="order_index" value="<?= $data['link']['order_index'] ?>" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
        </div>

        <button type="submit" class="btn btn-primary w-100" style="width: 100%; height: 50px; background: var(--primary); color: white; border: none; font-weight: 700; font-size: 1.1rem; border-radius: 8px; cursor: pointer; transition: 0.2s;">Update Social Link</button>
    </form>
</div>

<style>
    .form-control:focus {
        border-color: var(--primary) !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 107, 67, 0.1);
    }
</style>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
