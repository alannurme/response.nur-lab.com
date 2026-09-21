<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'settings_updated'): ?>
<div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
    <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
    ব্লগ সেকশনের ক্যাটাগরি কনফিগারেশন সফলভাবে আপডেট করা হয়েছে!
</div>
<?php endif; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Blog Manager</h1>
        <p>Configure settings and category selections for your website's main blog page</p>
    </div>
</div>

<form action="<?= URLROOT ?>/admin/blog_manager" method="POST">
    <input type="hidden" name="save_dont_miss_settings" value="1">
    
    <style>
        .config-card {
            background: white;
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            margin-bottom: 30px;
        }
        .config-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .config-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 700;
            color: #334155;
            font-size: 0.95rem;
        }
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }
        .form-select:focus {
            border-color: var(--primary);
        }
        .subcat-label:hover {
            border-color: #cbd5e1 !important;
            background: #f1f5f9 !important;
        }
        .subcat-label.is-checked:hover {
            background: #bae6fd !important;
            border-color: #7dd3fc !important;
        }
    </style>

    <?php 
    $blocks_count = intval($data['settings']['blog_blocks_count'] ?? 4);
    if ($blocks_count < 1) $blocks_count = 1;
    ?>
    <input type="hidden" name="settings[blog_blocks_count]" id="blog_blocks_count" value="<?= $blocks_count ?>">
    
    <div id="blocks-container">
        <?php for ($i = 0; $i < $blocks_count; $i++): 
            $num_word = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth'][$i] ?? 'Next';
            $num_bengali = ['প্রথম', 'দ্বিতীয়', 'তৃতীয়', 'চতুর্থ', 'পঞ্চম', 'ষষ্ঠ', 'সপ্তম', 'অষ্টম', 'নবম', 'দশম'][$i] ?? 'পরবর্তী';
        ?>
        <!-- Row <?= $i + 1 ?>: Dynamic Category Block -->
        <div class="config-card block-row-item" data-index="<?= $i ?>">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="config-title" style="margin-bottom: 0;">Row <span class="row-num-text"><?= $i + 1 ?></span>: <span class="row-word-text"><?= $num_word ?></span> Block (<span class="row-bn-text"><?= $num_bengali ?></span> সেকশন)</h2>
                <?php if ($i > 0): ?>
                    <button type="button" class="remove-block-btn" onclick="removeBlock(this)" style="background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; padding: 8px 16px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.2s;">
                        <i class="fas fa-trash-alt"></i> Delete Row
                    </button>
                <?php endif; ?>
            </div>
            <p class="config-desc">Select main category and quick-link sub-categories for Row <span class="row-num-text-desc"><?= $i + 1 ?></span></p>
            
            <div class="form-group">
                <label class="form-label">MAIN CATEGORY</label>
                <select name="settings[cat<?= $i ?>_category]" class="form-select cat-category-select">
                    <option value="">-- Select Category --</option>
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['slug']) ?>" <?= ($data['settings']["cat{$i}_category"] ?? '') == $cat['slug'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">HEADER SUB-CATEGORIES (MULTI-SELECT)</label>
                <?php 
                $selected_subs = !empty($data['settings']["cat{$i}_sub_categories"]) ? explode(',', $data['settings']["cat{$i}_sub_categories"]) : [];
                ?>
                <div class="checkbox-group-container" style="max-height: 180px; overflow-y: auto; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px; background: #f8fafc;">
                    <?php if (!empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $cat): 
                            $is_checked = in_array($cat['slug'], $selected_subs);
                        ?>
                            <label class="subcat-label <?= $is_checked ? 'is-checked' : '' ?>" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.2s; margin-bottom: 6px; background: <?= $is_checked ? '#e0f2fe' : 'white' ?>; border: 1px solid <?= $is_checked ? '#bae6fd' : '#e2e8f0' ?>; user-select: none;">
                                <input type="checkbox" name="settings[cat<?= $i ?>_sub_categories][]" value="<?= htmlspecialchars($cat['slug']) ?>" <?= $is_checked ? 'checked' : '' ?> onchange="this.parentElement.style.background = this.checked ? '#e0f2fe' : 'white'; this.parentElement.style.borderColor = this.checked ? '#bae6fd' : '#e2e8f0'; if(this.checked) { this.parentElement.classList.add('is-checked'); this.parentElement.querySelector('span').style.color = '#0369a1'; this.parentElement.querySelector('span').style.fontWeight = '600'; } else { this.parentElement.classList.remove('is-checked'); this.parentElement.querySelector('span').style.color = '#334155'; this.parentElement.querySelector('span').style.fontWeight = '500'; }" class="subcat-checkbox" style="width: 18px; height: 18px; accent-color: #0284c7; cursor: pointer;">
                                <span style="font-size: 0.95rem; font-weight: <?= $is_checked ? '600' : '500' ?>; color: <?= $is_checked ? '#0369a1' : '#334155' ?>; transition: all 0.2s;"><?= htmlspecialchars($cat['name']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <!-- Add Block Button -->
    <div style="margin-bottom: 35px; text-align: left;">
        <button type="button" id="add-block-btn" style="background: #10b981; color: white; border: none; padding: 14px 28px; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 8px 20px rgba(16,185,129,0.25); display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;">
            <i class="fas fa-plus-circle"></i> Add New Category Row (নতুন সেকশন যোগ করুন)
        </button>
    </div>

    <div style="margin-bottom: 50px;">
        <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-weight: 700; border-radius: 12px; font-size: 1.05rem; box-shadow: 0 8px 25px rgba(37,99,235,0.25);">
            <i class="fas fa-save"></i> Save Configuration
        </button>
    </div>
</form>

<script>
const availableCategories = <?= json_encode($data['categories'] ?? []) ?>;
const numWords = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth'];
const numBengali = ['প্রথম', 'দ্বিতীয়', 'তৃতীয়', 'চতুর্থ', 'পঞ্চম', 'ষষ্ঠ', 'সপ্তম', 'অষ্টম', 'নবম', 'দশম'];

document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-block-btn');
    const container = document.getElementById('blocks-container');
    
    if (addBtn && container) {
        addBtn.addEventListener('click', function() {
            const currentRows = container.querySelectorAll('.block-row-item');
            const newIndex = currentRows.length;
            
            const word = numWords[newIndex] || 'Next';
            const bn = numBengali[newIndex] || 'পরবর্তী';
            
            // Build Category Options HTML
            let catOptions = '<option value="">-- Select Category --</option>';
            availableCategories.forEach(cat => {
                catOptions += `<option value="${escapeHtml(cat.slug)}">${escapeHtml(cat.name)}</option>`;
            });
            
            // Build Subcategory Checkboxes HTML
            let subcatCheckboxes = '';
            availableCategories.forEach(cat => {
                subcatCheckboxes += `
                    <label class="subcat-label" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.2s; margin-bottom: 6px; background: white; border: 1px solid #e2e8f0; user-select: none;">
                        <input type="checkbox" name="settings[cat${newIndex}_sub_categories][]" value="${escapeHtml(cat.slug)}" onchange="this.parentElement.style.background = this.checked ? '#e0f2fe' : 'white'; this.parentElement.style.borderColor = this.checked ? '#bae6fd' : '#e2e8f0'; if(this.checked) { this.parentElement.classList.add('is-checked'); this.parentElement.querySelector('span').style.color = '#0369a1'; this.parentElement.querySelector('span').style.fontWeight = '600'; } else { this.parentElement.classList.remove('is-checked'); this.parentElement.querySelector('span').style.color = '#334155'; this.parentElement.querySelector('span').style.fontWeight = '500'; }" class="subcat-checkbox" style="width: 18px; height: 18px; accent-color: #0284c7; cursor: pointer;">
                        <span style="font-size: 0.95rem; font-weight: 500; color: #334155; transition: all 0.2s;">${escapeHtml(cat.name)}</span>
                    </label>
                `;
            });
            
            const blockHtml = `
            <div class="config-card block-row-item" data-index="${newIndex}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 class="config-title" style="margin-bottom: 0;">Row <span class="row-num-text">${newIndex + 1}</span>: <span class="row-word-text">${word}</span> Block (<span class="row-bn-text">${bn}</span> সেকশন)</h2>
                    <button type="button" class="remove-block-btn" onclick="removeBlock(this)" style="background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; padding: 8px 16px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.2s;">
                        <i class="fas fa-trash-alt"></i> Delete Row
                    </button>
                </div>
                <p class="config-desc">Select main category and quick-link sub-categories for Row <span class="row-num-text-desc">${newIndex + 1}</span></p>
                
                <div class="form-group">
                    <label class="form-label">MAIN CATEGORY</label>
                    <select name="settings[cat${newIndex}_category]" class="form-select cat-category-select">
                        ${catOptions}
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">HEADER SUB-CATEGORIES (MULTI-SELECT)</label>
                    <div class="checkbox-group-container" style="max-height: 180px; overflow-y: auto; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px; background: #f8fafc;">
                        ${subcatCheckboxes}
                    </div>
                </div>
            </div>
            `;
            
            const div = document.createElement('div');
            div.innerHTML = blockHtml;
            container.appendChild(div.firstElementChild);
            
            reindexBlocks();
        });
    }
});

function removeBlock(btn) {
    const block = btn.closest('.block-row-item');
    if (block) {
        block.remove();
        reindexBlocks();
    }
}

function reindexBlocks() {
    const container = document.getElementById('blocks-container');
    const rows = container.querySelectorAll('.block-row-item');
    
    rows.forEach((row, i) => {
        row.setAttribute('data-index', i);
        
        const word = numWords[i] || 'Next';
        const bn = numBengali[i] || 'পরবর্তী';
        
        // Update Title & Descriptions
        row.querySelector('.row-num-text').innerText = i + 1;
        row.querySelector('.row-word-text').innerText = word;
        row.querySelector('.row-bn-text').innerText = bn;
        row.querySelector('.row-num-text-desc').innerText = i + 1;
        
        // Update form select name
        const select = row.querySelector('.cat-category-select');
        if (select) {
            select.setAttribute('name', `settings[cat${i}_category]`);
        }
        
        // Update checkboxes names
        const checkboxes = row.querySelectorAll('.subcat-checkbox');
        checkboxes.forEach(cb => {
            cb.setAttribute('name', `settings[cat${i}_sub_categories][]`);
            
            // Make sure the inline onchange string has the correct template context index
            cb.setAttribute('onchange', `this.parentElement.style.background = this.checked ? '#e0f2fe' : 'white'; this.parentElement.style.borderColor = this.checked ? '#bae6fd' : '#e2e8f0'; if(this.checked) { this.parentElement.classList.add('is-checked'); this.parentElement.querySelector('span').style.color = '#0369a1'; this.parentElement.querySelector('span').style.fontWeight = '600'; } else { this.parentElement.classList.remove('is-checked'); this.parentElement.querySelector('span').style.color = '#334155'; this.parentElement.querySelector('span').style.fontWeight = '500'; }`);
        });
        
        // Update Delete button visibility
        let delBtn = row.querySelector('.remove-block-btn');
        if (i === 0) {
            if (delBtn) delBtn.remove();
        } else {
            if (!delBtn) {
                // Add Delete button
                const titleWrapper = row.firstElementChild;
                const newDelBtn = document.createElement('button');
                newDelBtn.type = 'button';
                newDelBtn.className = 'remove-block-btn';
                newDelBtn.setAttribute('onclick', 'removeBlock(this)');
                newDelBtn.style.cssText = "background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; padding: 8px 16px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.2s;";
                newDelBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Delete Row';
                titleWrapper.appendChild(newDelBtn);
            }
        }
    });
    
    // Update Hidden Input Value
    document.getElementById('blog_blocks_count').value = rows.length;
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
