<?php require_once APPROOT . '/Views/admin/header.php'; ?>
<form action="<?= URLROOT ?>/admin/add_post" method="POST" onsubmit="return validateForm()">
<style>
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --primary-glow: rgba(37, 99, 235, 0.08);
        --border: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
    }

    /* Core Card Overrides */
    .admin-card {
        background: #ffffff !important;
        border: 1px solid var(--border) !important;
        border-radius: 12px !important;
        padding: 24px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 24px;
        transition: none !important;
    }
    
    .admin-card:hover {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        border-color: var(--border) !important;
    }

    /* Header Styling */
    h3.m-0 {
        font-weight: 700 !important;
        color: var(--text-main) !important;
        font-size: 1.6rem !important;
    }

    /* Input Fields */
    .form-control {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        color: var(--text-main) !important;
        background-color: #ffffff !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: var(--primary) !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
    }

    /* Select element improvements */
    select.form-control {
        cursor: pointer !important;
        padding-right: 30px !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
        background-position: right 12px center !important;
        background-repeat: no-repeat !important;
        background-size: 18px !important;
        appearance: none !important;
    }

    /* Categories checklist box */
    .categories-checklist {
        border: 1px solid var(--border) !important;
        border-radius: 8px !important;
        background: #ffffff !important;
        padding: 12px !important;
    }

    .category-tree-item-wrapper {
        border-radius: 6px !important;
        padding: 4px 8px !important;
        transition: background-color 0.15s ease !important;
    }

    .category-tree-item-wrapper:hover {
        background-color: #f1f5f9 !important;
    }
    
    .category-tree-item-wrapper label {
        font-weight: 500 !important;
        color: var(--text-main) !important;
    }

    /* Premium buttons */
    .btn-primary {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: #ffffff !important;
    }
    .btn-primary:hover {
        background: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }

    .btn-visit-site, .btn-primary, .btn-success, .btn-secondary {
        border-radius: 8px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        padding: 10px 18px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-visit-site:hover, .btn-primary:hover, .btn-success:hover, .btn-secondary:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Part card items styles */
    .part-item-card {
        border: 1px solid var(--border) !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        padding: 20px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
        transition: none !important;
    }
    .part-item-card:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
        transform: none !important;
    }
    
    /* Input titles for Parts */
    .part-title-input {
        font-weight: 600 !important;
        font-size: 1.05rem !important;
    }

    /* Responsive Styles for Top Header and Publish Options Bar */
    @media (max-width: 1200px) {
        .header-container {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 15px !important;
        }
        .header-actions {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            gap: 10px !important;
        }
        #post-form-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
        #toggle-sidebar-btn {
            display: none !important;
        }
        #back-to-list-top {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
        }
    }
    .categories-checklist ul {
        list-style: none !important;
        padding-left: 16px !important;
        margin: 4px 0 !important;
        border-left: 1px dashed #cbd5e1;
    }
    .categories-checklist > ul {
        padding-left: 0 !important;
        border-left: none !important;
    }
    .category-tree-item-wrapper label {
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #475569 !important;
        cursor: pointer !important;
        user-select: none;
        margin-bottom: 0 !important;
        line-height: 1.3;
    }
    .category-tree-item-wrapper input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        min-width: 16px !important;
        min-height: 16px !important;
        margin: 0 !important;
        cursor: pointer;
        flex-shrink: 0 !important;
    }
    /* Modern Author Select Field Style */
    #author_select {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        color: #334155;
        font-weight: 500;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 18px;
        padding-right: 36px;
    }
    #author_select:focus {
        border-color: var(--primary);
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    /* Modal Styling for Add Post Page */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.show {
        display: flex !important;
    }
    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: modalScale 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalScale {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .modal-close:hover {
        color: #0f172a;
        background: #f1f5f9;
    }
    .modal-body {
        padding: 20px 24px;
    }
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<div class="justify-content-between d-flex align-items-center mb-4 header-container" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
    <h3 class="m-0"><i class="fas fa-edit" style="color: var(--primary); margin-right: 8px;"></i>Create New Article</h3>
    <div class="header-actions" style="display: flex; gap: 10px; align-items: center;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 22px; font-weight: 700; border-radius: 30px; background: #2563eb; color: #ffffff; border: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); font-size: 15px; cursor: pointer;">
            🚀 Publish Article
        </button>
        <button type="button" class="btn btn-secondary" onclick="handleDirectPasteOnAddPage()" style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border-color: #86efac; color: #166534; font-weight: 600; cursor: pointer;" title="Paste copied post data">
            <i class="fas fa-paste" style="color: #16a34a;"></i> Paste Post
        </button>
        <button type="button" id="toggle-sidebar-btn" class="btn btn-secondary" onclick="toggleRightSidebar()">
            <i class="fas fa-indent"></i> Hide Sidebar
        </button>
        <?php 
        $backUrl = URLROOT . '/admin/posts';
        if (isset($_GET['category_id']) && $_GET['category_id'] !== '') {
            $backUrl .= '?category_id=' . intval($_GET['category_id']);
        }
        ?>
        <a href="<?= $backUrl ?>" id="back-to-list-top" class="btn btn-secondary">&larr; Back to list</a>
    </div>
</div>

<div id="pasted-post-banner-container"></div>

<!-- Modal: Paste Post Data on Add Post Page -->
<div class="modal-overlay" id="addPagePasteModal">
    <div class="modal-content" style="max-width: 620px; width: 95%;">
        <div class="modal-header">
            <h3 class="modal-title" style="display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-paste" style="color: #16a34a;"></i> Paste Copied Post
            </h3>
            <button type="button" class="modal-close" onclick="closeAddPagePasteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label for="addPagePasteTextarea" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 0;">Post JSON Data</label>
                    <button type="button" class="btn btn-secondary" onclick="readClipboardIntoAddPageModal()" style="padding: 4px 10px; font-size: 12px; height: auto; gap: 4px;">
                        <i class="fas fa-clipboard"></i> Read from Clipboard
                    </button>
                </div>
                <textarea id="addPagePasteTextarea" class="form-control" rows="8" placeholder='{"_type": "nur_post_export", ...}' style="font-family: monospace; font-size: 12px; line-height: 1.4; resize: vertical; width: 100%; box-sizing: border-box;"></textarea>
                <div id="addPagePasteError" style="display: none; color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px;"></div>
            </div>
        </div>
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
            <button type="button" class="btn btn-secondary" onclick="closeAddPagePasteModal()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="submitAddPagePasteModal()" style="background: #16a34a; border-color: #16a34a; font-weight: 600;">
                <i class="fas fa-check"></i> Apply Post Data
            </button>
        </div>
    </div>
</div>
    <div id="post-form-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 30px; transition: all 0.3s ease;">
        <!-- Left Column: Content and SEO Settings -->
        <div>
            <!-- Main Form Section -->
            <div class="admin-card">
                <div class="form-group mb-4">
                    <label class="form-label-premium"><i class="fas fa-heading"></i> Article Title (বাংলায়)</label>
                    <input type="text" name="title" class="form-control" required placeholder="Enter catchy title here...">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-premium"><i class="fas fa-link"></i> Post Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="e.g. post-url-slug">
                    <small style="color: var(--text-muted); margin-top: 5px; display: block; font-size: 12px;">Leave blank to auto-generate from title.</small>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label class="form-label-premium" style="margin-bottom: 0;"><i class="fas fa-file-alt"></i> Detailed Content</label>
                    </div>
                    <textarea name="content" class="form-control" placeholder="Start your story..." style="display: none;"></textarea>

                    <!-- Parts Builder Interface -->
                    <div id="parts-builder-container" style="border: 1px solid var(--border); border-radius: 16px; padding: 25px; background: #f8fafc; margin-top: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="margin: 0; font-weight: 800; color: var(--text-main); font-family: sans-serif; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-cubes" style="color: var(--primary);"></i>পোস্ট অনুচ্ছেদ/পর্বসমূহ (Article Parts)
                            </h4>
                        </div>
                        
                        <div id="parts-list" style="display: flex; flex-direction: column; gap: 20px;">
                            <!-- Dynamic parts go here -->
                        </div>

                        <div style="margin-top: 20px; text-align: right;">
                            <button type="button" class="btn btn-primary" onclick="addNewPart()" style="padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.85rem;">
                                <i class="fas fa-plus"></i> Add Another Part
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar Section -->
        <div id="post-form-sidebar" style="display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- Publish Settings Card -->
            <div class="admin-card">
                <h4 style="margin-bottom: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 8px; color: var(--text-main); font-size: 1rem !important; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                    <i class="fas fa-paper-plane" style="color: var(--primary);"></i> Publish Settings
                </h4>
                
                <div class="form-group mb-3">
                    <label class="form-label-premium" style="font-size: 11px !important;"><i class="fas fa-toggle-on"></i> Status</label>
                    <select name="status" class="form-control" style="width: 100%;">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label-premium" style="font-size: 11px !important;"><i class="fas fa-calendar-alt"></i> Publish Date & Time</label>
                    <input type="datetime-local" name="created_at" value="<?= date('Y-m-d\TH:i') ?>" class="form-control" style="width: 100%;">
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label-premium" style="font-size: 11px !important;"><i class="fas fa-eye"></i> Simulated Views</label>
                    <input type="number" name="views" value="0" min="0" class="form-control" style="width: 100%;">
                </div>
            </div>

            <div class="admin-card">
                <div class="form-group">
                    <label class="form-label-premium"><i class="fas fa-folder-open"></i> Publication Categories</label>
                    <div class="categories-checklist" style="max-height: 250px; overflow-y: auto;">
                        <?php 
                        if (!function_exists('renderCheckboxTree')) {
                            function renderCheckboxTree($categories, $parentId = null, $selectedIds = [], $mainCatId = null, $level = 0) {
                                $branch = [];
                                foreach ($categories as $cat) {
                                    $catParent = $cat['parent_id'] ? (int)$cat['parent_id'] : null;
                                    $filterParent = $parentId ? (int)$parentId : null;
                                    if ($catParent === $filterParent) {
                                        $branch[] = $cat;
                                    }
                                }
                                
                                if (empty($branch)) return '';
                                
                                $html = '<ul>';
                                foreach ($branch as $cat) {
                                    $isChecked = in_array((int)$cat['id'], $selectedIds) ? 'checked' : '';
                                    
                                    $html .= '<li>';
                                    $html .= '<div class="category-tree-item-wrapper" style="display: flex; align-items: center; gap: 8px; width: 100%;">';
                                    $html .= '<input type="checkbox" name="category_ids[]" value="' . $cat['id'] . '" id="cat_' . $cat['id'] . '" ' . $isChecked . ' onchange="handleCategoryCheckboxChange(this)">';
                                    $html .= '<i class="fas fa-folder" style="color: #f59e0b; font-size: 13px; flex-shrink: 0;"></i>';
                                    $html .= '<label for="cat_' . $cat['id'] . '" style="margin: 0; cursor: pointer; flex-grow: 1;">' . htmlspecialchars($cat['name']) . '</label>';
                                    
                                    $showRadio = $isChecked ? 'inline-flex' : 'none';
                                    $isRadioChecked = ($mainCatId !== null && (int)$cat['id'] === (int)$mainCatId) || ($mainCatId === null && $isChecked && $level === 0) ? 'checked' : '';
                                    $html .= '<span class="main-cat-badge-container" style="display: ' . $showRadio . '; align-items: center; gap: 4px; margin-left: auto; flex-shrink: 0; padding-left: 8px;">';
                                    $html .= '<input type="radio" name="main_category_id" value="' . $cat['id'] . '" id="main_cat_' . $cat['id'] . '" style="margin: 0 !important; width: 13px !important; height: 13px !important;" ' . $isRadioChecked . '>';
                                    $html .= '<label for="main_cat_' . $cat['id'] . '" style="font-size: 11px !important; color: #3b82f6 !important; font-weight: 600 !important; margin: 0 !important; cursor: pointer; user-select: none;">Main</label>';
                                    $html .= '</span>';
                                    
                                    $html .= '</div>';
                                    $html .= renderCheckboxTree($categories, $cat['id'], $selectedIds, $mainCatId, $level + 1);
                                    $html .= '</li>';
                                }
                                $html .= '</ul>';
                                return $html;
                            }
                        }

                        $targetCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
                        $selectedIds = $targetCategoryId !== null ? [$targetCategoryId] : [];
                        echo renderCheckboxTree($data['categories'], null, $selectedIds, $targetCategoryId);
                        ?>
                    </div>
                    <small style="color: var(--text-muted); margin-top: 5px; display: block; font-size: 12px;">Select one or more categories for this article.</small>
                </div>
            </div>

            <div class="admin-card">
                <h4 style="margin-bottom: 1rem; font-weight: 700; display: flex; justify-content: space-between; align-items: center;">
                    <span class="form-label-premium" style="margin-bottom: 0;"><i class="fas fa-users"></i> Authors</span>
                    <a href="<?= URLROOT ?>/admin/add_author" target="_blank" style="font-size: 0.8rem; text-decoration: none; color: var(--primary); font-weight: 700;"><i class="fas fa-plus"></i> Add New</a>
                </h4>
                
                <div class="form-group mb-3">
                    <select id="author_select" class="form-control">
                        <option value="">Search or select an author...</option>
                        <?php foreach ($data['authors'] as $author): ?>
                            <option value="<?= $author['id'] ?>" data-name="<?= htmlspecialchars($author['name']) ?>" data-email="<?= htmlspecialchars($author['email'] ?? '') ?>">
                                <?= htmlspecialchars($author['name']) ?> (<?= htmlspecialchars($author['email'] ?? 'No Email') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="author_tags_container" style="display: flex; flex-direction: column; gap: 8px; margin-top: 15px;">
                    <!-- Selected authors will appear here as rows -->
                </div>
                
                <div id="author_inputs_container"></div>
            </div>

            <div class="admin-card">
                <label class="form-label-premium"><i class="fas fa-image"></i> Featured Image</label>
                
                <input type="hidden" id="post_image_path" name="featured_image" value="">
                
                <div id="image_upload_dropzone" onclick="openMediaPicker('post_image_path', 'post_preview')" style="border: 2px dashed var(--border); border-radius: 12px; padding: 30px 15px; text-align: center; cursor: pointer; transition: all 0.2s ease; background: #f8fafc; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border)'; this.style.background='#f8fafc';">
                    <div style="width: 48px; height: 48px; background: var(--primary-glow); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <span style="display: block; font-weight: 700; font-size: 13px; color: var(--text-main);">Choose from Media Library</span>
                        <span style="display: block; font-size: 11px; color: var(--text-muted); margin-top: 2px;">Click to select featured image</span>
                    </div>
                </div>
                
                <div id="image_preview_container" style="display: none; position: relative; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--border); background: #fff;">
                    <img id="post_preview" src="" style="width: 100%; display: block; object-fit: cover; max-height: 200px;" loading="lazy" decoding="async">
                    <div style="display: flex; gap: 8px; padding: 10px; background: #fff; border-top: 1.5px solid var(--border);">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('post_image_path', 'post_preview')" style="flex: 1; font-size: 12px; display: flex; align-items: center; justify-content: center; gap: 4px; padding: 8px; border-radius: 6px;">
                            <i class="fas fa-sync-alt"></i> Change
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="remove_post_image_path" onclick="clearSelectedImage('post_image_path', 'post_preview', 'remove_post_image_path'); updateFeaturedImageUI();" style="flex: 1; font-size: 12px; display: flex; align-items: center; justify-content: center; gap: 4px; padding: 8px; border-radius: 6px; background: #dc2626; border-color: #dc2626; color: white;">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <h5 style="margin-bottom: 1.5rem; font-weight: 800; border-bottom: 2px solid var(--border); padding-bottom: 10px; font-size: 14px; display: flex; align-items: center; gap: 8px; color: var(--text-main);">
                    <i class="fas fa-search" style="color: var(--primary);"></i> SEO Settings (সার্চ ইঞ্জিন অপ্টিমাইজেশন)
                </h5>
                <div class="form-group mb-3">
                    <label class="form-label-premium" style="font-size: 12px !important;"><i class="fas fa-font"></i> SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" placeholder="সার্চ ইঞ্জিনে দেখানোর শিরোনাম...">
                    <small style="color: var(--text-muted); margin-top: 6px; display: block; font-size: 11px; line-height: 1.4;">বাকি রাখলে মূল টাইটেল ব্যবহার করা হবে (সর্বোচ্চ ৬০ অক্ষর)</small>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label-premium" style="font-size: 12px !important;"><i class="fas fa-align-left"></i> SEO Description</label>
                    <textarea name="seo_description" class="form-control" rows="3" placeholder="সার্চ ইঞ্জিনের জন্য বর্ণনা..."></textarea>
                    <small style="color: var(--text-muted); margin-top: 6px; display: block; font-size: 11px; line-height: 1.4;">বাকি রাখলে অটো-জেনারেট করা হবে (সর্বোচ্চ ১৬০ অক্ষর)</small>
                </div>
                <div class="form-group">
                    <label class="form-label-premium" style="font-size: 12px !important;"><i class="fas fa-tags"></i> SEO Keywords</label>
                    <input type="text" name="seo_keywords" class="form-control" placeholder="যেমন: ইসলাম, বিজ্ঞান, কুরআন">
                    <small style="color: var(--text-muted); margin-top: 6px; display: block; font-size: 11px; line-height: 1.4;">কমা দিয়ে আলাদা করুন</small>
            </div>

            <?php require APPROOT . '/Views/admin/inc/schema_markup_panel.php'; ?>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 16px !important;">🚀 Publish Article</button>
        </div>
    </div>
</form>

<script>
    function updateFeaturedImageUI() {
        const pathInput = document.getElementById('post_image_path');
        const path = pathInput ? pathInput.value : '';
        const dropzone = document.getElementById('image_upload_dropzone');
        const container = document.getElementById('image_preview_container');
        const preview = document.getElementById('post_preview');
        
        if (path && path.trim() !== '') {
            if (dropzone) dropzone.style.display = 'none';
            if (container) container.style.display = 'block';
            if (preview) {
                preview.src = (path.indexOf('http://') === 0 || path.indexOf('https://') === 0 || path.indexOf('<?= URLROOT ?>') === 0) ? path : '<?= URLROOT ?>/public/img/' + path;
                preview.style.display = 'block';
            }
        } else {
            if (dropzone) dropzone.style.display = 'flex';
            if (container) container.style.display = 'none';
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const pathInput = document.getElementById('post_image_path');
        if (pathInput) {
            pathInput.addEventListener('change', updateFeaturedImageUI);
            pathInput.addEventListener('input', updateFeaturedImageUI);
            setInterval(updateFeaturedImageUI, 500);
        }
        updateFeaturedImageUI();
    });

    function handleCategoryCheckboxChange(checkbox) {
        const wrapper = checkbox.closest('.category-tree-item-wrapper');
        const badgeContainer = wrapper.querySelector('.main-cat-badge-container');
        const radio = wrapper.querySelector('input[name="main_category_id"]');
        
        if (checkbox.checked) {
            badgeContainer.style.display = 'inline-flex';
            const checkedRadio = document.querySelector('input[name="main_category_id"]:checked');
            if (!checkedRadio) {
                radio.checked = true;
            }
        } else {
            badgeContainer.style.display = 'none';
            if (radio.checked) {
                radio.checked = false;
                const firstCheckedCheckbox = document.querySelector('input[name="category_ids[]"]:checked');
                if (firstCheckedCheckbox) {
                    const firstCheckedWrapper = firstCheckedCheckbox.closest('.category-tree-item-wrapper');
                    const firstRadio = firstCheckedWrapper.querySelector('input[name="main_category_id"]');
                    if (firstRadio) firstRadio.checked = true;
                }
            }
        }
    }

    function validateForm() {
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
        const content = document.querySelector('textarea[name="content"]').value;
        if (content.trim() === '') {
            alert('অনুগ্রহ করে আর্টিকেলের বিস্তারিত তথ্য লিখুন।');
            return false;
        }

        const checkboxes = document.querySelectorAll('input[name="category_ids[]"]');
        let checked = false;
        checkboxes.forEach(cb => {
            if (cb.checked) checked = true;
        });
        if (!checked) {
            alert('অনুগ্রহ করে অন্তত একটি ক্যাটাগরি সিলেক্ট করুন।');
            return false;
        }

        const mainRadio = document.querySelector('input[name="main_category_id"]:checked');
        if (!mainRadio) {
            alert('অনুগ্রহ করে একটি প্রধান ক্যাটাগরি (Main Folder) সিলেক্ট করুন।');
            return false;
        }

        const authorInputs = document.querySelectorAll('input[name="author_ids[]"]');
        if (authorInputs.length === 0) {
            alert('অনুগ্রহ করে অন্তত একজন লেখক সিলেক্ট করুন।');
            return false;
        }

        // Restructure category_ids array so the main category is first (only after all validations pass)
        const mainVal = mainRadio.value;
        const checkedVals = Array.from(document.querySelectorAll('input[name="category_ids[]"]:checked'))
                                 .map(cb => cb.value)
                                 .filter(val => val !== mainVal);
        
        // Remove any previously appended temp inputs if form submission was somehow halted
        document.querySelectorAll('input.temp-category-ids').forEach(el => el.remove());

        const originalCheckboxes = document.querySelectorAll('input[name="category_ids[]"]');
        originalCheckboxes.forEach(cb => {
            cb.removeAttribute('name');
        });

        const form = document.querySelector('form[action*="add_post"]');
        
        const mainHidden = document.createElement('input');
        mainHidden.type = 'hidden';
        mainHidden.className = 'temp-category-ids';
        mainHidden.name = 'category_ids[]';
        mainHidden.value = mainVal;
        form.appendChild(mainHidden);

        checkedVals.forEach(val => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.className = 'temp-category-ids';
            hidden.name = 'category_ids[]';
            hidden.value = val;
            form.appendChild(hidden);
        });

        // Restore name attribute on next tick so subsequent validations / background saves work
        setTimeout(() => {
            originalCheckboxes.forEach(cb => {
                cb.setAttribute('name', 'category_ids[]');
            });
            document.querySelectorAll('input.temp-category-ids').forEach(el => el.remove());
        }, 100);

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-select parent categories when subcategory is checked
        const checklist = document.querySelector('.categories-checklist');
        if (checklist) {
            checklist.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'category_ids[]' && e.target.checked) {
                    let currentLi = e.target.closest('li');
                    if (currentLi) {
                        // Find parents upwards in the list hierarchy
                        let parentLi = currentLi.parentElement.closest('li');
                        while (parentLi) {
                            const parentCheckbox = parentLi.querySelector(':scope > .category-tree-item-wrapper input[type="checkbox"]');
                            if (parentCheckbox && !parentCheckbox.checked) {
                                parentCheckbox.checked = true;
                            }
                            parentLi = parentLi.parentElement.closest('li');
                        }
                    }
                }
            });
        }

        const authorSelect = document.getElementById('author_select');
        const tagsContainer = document.getElementById('author_tags_container');
        const inputsContainer = document.getElementById('author_inputs_container');
        const selectedAuthors = new Set();

        function addAuthor(id, name, email) {
            if (selectedAuthors.has(id)) return;
            selectedAuthors.add(id);

            const row = document.createElement('div');
            row.id = `author_tag_${id}`;
            row.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; color: #1e293b;';
            
            row.innerHTML = `
                <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-user-circle" style="color: #64748b; font-size: 14px;"></i> ${name} ${email ? `<span style="color: #64748b; font-size: 11px; font-weight: normal;">(${email})</span>` : ''}</span>
                <span class="remove-author-btn" data-id="${id}" style="cursor: pointer; color: #94a3b8; font-weight: bold; font-size: 1.1rem; padding: 0 4px; display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'; this.style.background='#fee2e2';" onmouseout="this.style.color='#94a3b8'; this.style.background='transparent';">&times;</span>
            `;
            tagsContainer.appendChild(row);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'author_ids[]';
            input.value = id;
            input.id = `author_input_${id}`;
            inputsContainer.appendChild(input);

            const option = authorSelect.querySelector(`option[value="${id}"]`);
            if (option) option.style.display = 'none';

            row.querySelector('.remove-author-btn').addEventListener('click', function() {
                removeAuthor(id);
            });
        }

        function removeAuthor(id) {
            selectedAuthors.delete(id);
            
            const row = document.getElementById(`author_tag_${id}`);
            if (row) row.remove();
            
            const input = document.getElementById(`author_input_${id}`);
            if (input) input.remove();

            const option = authorSelect.querySelector(`option[value="${id}"]`);
            if (option) option.style.display = 'block';
        }

        window.addAuthor = addAuthor;
        window.clearAllAuthors = function() {
            selectedAuthors.forEach(id => {
                const option = authorSelect.querySelector(`option[value="${id}"]`);
                if (option) option.style.display = 'block';
            });
            selectedAuthors.clear();
            tagsContainer.innerHTML = '';
            inputsContainer.innerHTML = '';
        };

        authorSelect.addEventListener('change', function() {
            const id = this.value;
            if (!id) return;
            
            const option = this.options[this.selectedIndex];
            const name = option.getAttribute('data-name');
            const email = option.getAttribute('data-email');
            
            addAuthor(id, name, email);
            this.value = '';
        });

        // Auto-select "Admin" on load
        const adminOption = Array.from(authorSelect.options).find(opt => opt.text.trim().startsWith('Admin'));
        if (adminOption && adminOption.value) {
            addAuthor(adminOption.value, adminOption.getAttribute('data-name'), adminOption.getAttribute('data-email'));
        }

        // Auto Slug Generation from Title
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');
        let isSlugEdited = false;
        window.setIsSlugEdited = function(val) {
            isSlugEdited = val;
        };

        if (titleInput && slugInput) {
            slugInput.addEventListener('input', function() {
                isSlugEdited = this.value.trim() !== '';
            });

            titleInput.addEventListener('input', function() {
                if (!isSlugEdited) {
                    slugInput.value = slugify(this.value);
                }
            });
        }

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           
                .replace(/[^\u0980-\u09FFa-zA-Z0-9\-]/g, '-') 
                .replace(/\-\-+/g, '-')         
                .replace(/^-+/, '')             
                .replace(/-+$/, '');            
        }
    });
</script>


<!-- Quill.js Editor Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<style>
    .ql-container {
        font-family: 'Hind Siliguri', 'Inter', sans-serif !important;
        font-size: 15px !important;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        background: #ffffff;
    }
    .ql-toolbar {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        background: #f8fafc;
        border-color: #cbd5e1 !important;
    }
    .ql-editor {
        min-height: 250px;
        line-height: 1.8;
    }
</style>

<script>
    let partCounter = 0;
    const quillInstances = {};

    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function createPartCardHTML(id, title = '', content = '') {
        return `
        <div class="part-item-card" id="part-card-${id}" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 15px; position: relative; margin-bottom: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <strong style="color: #1e293b;" class="part-index-label">পর্ব</strong>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-sm" onclick="movePartUp(${id})" style="background: #f1f5f9; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;"><i class="fas fa-arrow-up"></i></button>
                    <button type="button" class="btn btn-sm" onclick="movePartDown(${id})" style="background: #f1f5f9; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;"><i class="fas fa-arrow-down"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removePart(${id})" style="background: #ef4444; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;"><i class="fas fa-trash"></i> Remove</button>
                </div>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 6px;">Part Title / Heading (H2)</label>
                <input type="text" class="form-control part-title-input" value="${escapeHTML(title)}" placeholder="অনুচ্ছেদের শিরোনাম লিখুন (যেমন: মুজিযা বলতে কী বোঝায়?)" style="width: 100%; box-sizing: border-box; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 6px;">Content</label>
                <div id="quill-editor-${id}">${content}</div>
                <textarea id="part-content-${id}" class="part-content-textarea" style="display: none;">${escapeHTML(content)}</textarea>
            </div>
        </div>
        `;
    }

    function initQuillEditor(id, initialContent = '') {
        if (typeof Quill === 'undefined') {
            setTimeout(() => initQuillEditor(id, initialContent), 50);
            return;
        }

        const editorContainer = document.getElementById(`quill-editor-${id}`);
        if (!editorContainer) return;

        const quill = new Quill(`#quill-editor-${id}`, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        if (initialContent) {
            quill.clipboard.dangerouslyPasteHTML(initialContent);
        }

        quillInstances[id] = quill;
    }

    function addNewPart(title = '', content = '') {
        partCounter++;
        const id = partCounter;
        const list = document.getElementById('parts-list');
        
        const wrapper = document.createElement('div');
        wrapper.innerHTML = createPartCardHTML(id, title, content);
        const cardNode = wrapper.firstElementChild;
        list.appendChild(cardNode);
        
        initQuillEditor(id, content);
        updatePartIndexes();
    }

    function getEditorContent(id) {
        if (quillInstances[id]) {
            return quillInstances[id].root.innerHTML;
        }
        const textarea = document.getElementById(`part-content-${id}`);
        return textarea ? textarea.value : '';
    }

    function removePart(id) {
        if (confirm('Are you sure you want to remove this part? All content inside this part will be lost.')) {
            const card = document.getElementById(`part-card-${id}`);
            if (card) {
                card.remove();
            }
            delete quillInstances[id];
            updatePartIndexes();
        }
    }

    function updatePartIndexes() {
        const banglaDigits = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        const toBangla = (num) => num.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
        
        const cards = document.querySelectorAll('.part-item-card');
        cards.forEach((card, idx) => {
            const label = card.querySelector('.part-index-label');
            if (label) {
                label.textContent = toBangla(idx + 1);
            }
        });
    }

    function movePartUp(id) {
        const card = document.getElementById(`part-card-${id}`);
        const previous = card.previousElementSibling;
        if (previous) {
            const currentContent = getEditorContent(id);
            const prevId = previous.id.replace('part-card-', '');
            const prevContent = getEditorContent(prevId);
            
            card.parentNode.insertBefore(card, previous);
            
            initQuillEditor(id, currentContent);
            initQuillEditor(prevId, prevContent);
            
            updatePartIndexes();
        }
    }

    function movePartDown(id) {
        const card = document.getElementById(`part-card-${id}`);
        const next = card.nextElementSibling;
        if (next) {
            const currentContent = getEditorContent(id);
            const nextId = next.id.replace('part-card-', '');
            const nextContent = getEditorContent(nextId);
            
            card.parentNode.insertBefore(next, card);
            
            initQuillEditor(id, currentContent);
            initQuillEditor(nextId, nextContent);
            
            updatePartIndexes();
        }
    }

    function compileContent() {
        let finalHtml = '';
        const cards = document.querySelectorAll('.part-item-card');
        cards.forEach(card => {
            const titleInput = card.querySelector('.part-title-input');
            const titleText = titleInput.value.trim();
            const editorId = card.querySelector('.part-content-textarea').id.replace('part-content-', '');
            const editorContent = getEditorContent(editorId);
            
            if (titleText !== '') {
                finalHtml += '<h2>' + titleText + '</h2>\n';
            }
            finalHtml += editorContent + '\n';
        });
        
        const mainTextarea = document.querySelector('textarea[name="content"]');
        if (mainTextarea) {
            mainTextarea.value = finalHtml;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const pendingData = sessionStorage.getItem('pending_paste_post');
        if (pendingData) {
            sessionStorage.removeItem('pending_paste_post');
            try {
                const parsed = JSON.parse(pendingData);
                const post = parsed.post || parsed;
                waitForQuillAndPopulate(post);
                return;
            } catch(e) {
                console.error('Error applying pending pasted post:', e);
            }
        }
        addNewPart('', '');
    });

    function waitForQuillAndPopulate(post) {
        if (typeof Quill === 'undefined' || typeof window.addAuthor === 'undefined') {
            setTimeout(() => waitForQuillAndPopulate(post), 50);
            return;
        }
        populateFormWithPostData(post);
    }

    function populateFormWithPostData(post) {
        if (!post) return;

        // 1. Title
        const titleInput = document.querySelector('input[name="title"]');
        if (titleInput && post.title) {
            titleInput.value = post.title;
        }

        // 2. Slug
        const slugInput = document.querySelector('input[name="slug"]');
        if (slugInput && post.slug) {
            slugInput.value = post.slug;
            if (typeof window.setIsSlugEdited === 'function') {
                window.setIsSlugEdited(true);
            }
        }

        // 3. Status
        const statusSelect = document.querySelector('select[name="status"]');
        if (statusSelect && post.status) {
            statusSelect.value = post.status;
        }

        // 4. Created at / Publish date
        const createdAtInput = document.querySelector('input[name="created_at"]');
        if (createdAtInput && post.created_at) {
            try {
                const d = new Date(post.created_at);
                if (!isNaN(d.getTime())) {
                    const pad = (n) => String(n).padStart(2, '0');
                    createdAtInput.value = `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
                }
            } catch(e) {}
        }

        // 5. Views
        const viewsInput = document.querySelector('input[name="views"]');
        if (viewsInput) {
            viewsInput.value = post.views || post.fake_views || 0;
        }

        // 6. Featured Image
        const imgInput = document.getElementById('post_image_path');
        if (imgInput && post.featured_image) {
            imgInput.value = post.featured_image;
            if (typeof updateFeaturedImageUI === 'function') {
                updateFeaturedImageUI();
            }
        }

        // 7. SEO Fields
        const seoTitleInput = document.querySelector('input[name="seo_title"]');
        if (seoTitleInput && post.seo_title) seoTitleInput.value = post.seo_title;

        const seoDescInput = document.querySelector('textarea[name="seo_description"]');
        if (seoDescInput && post.seo_description) seoDescInput.value = post.seo_description;

        const seoKwInput = document.querySelector('input[name="seo_keywords"]');
        if (seoKwInput && post.seo_keywords) seoKwInput.value = post.seo_keywords;

        // 8. Schema Data
        const schemaInput = document.getElementById('schema_data_input');
        if (schemaInput && post.schema_data) {
            schemaInput.value = typeof post.schema_data === 'string' ? post.schema_data : JSON.stringify(post.schema_data);
            try {
                const schemaObj = (typeof post.schema_data === 'string') ? JSON.parse(post.schema_data) : post.schema_data;
                const typeSelect = document.getElementById('schema_type_select');
                if (typeSelect && schemaObj && schemaObj.type) {
                    typeSelect.value = schemaObj.type;
                    if (typeof renderFields === 'function') {
                        renderFields(schemaObj.type);
                    }
                    if (typeof updatePreviewAndScore === 'function') {
                        updatePreviewAndScore();
                    }
                }
            } catch(e) {}
        }

        // 9. Categories matching
        // Uncheck all categories first
        document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => {
            cb.checked = false;
            const wrapper = cb.closest('.category-tree-item-wrapper');
            if (wrapper) {
                const badgeContainer = wrapper.querySelector('.main-cat-badge-container');
                if (badgeContainer) badgeContainer.style.display = 'none';
                const radio = wrapper.querySelector('input[name="main_category_id"]');
                if (radio) radio.checked = false;
            }
        });

        const targetCategoryNames = Array.isArray(post.category_names) ? post.category_names.map(n => n.toLowerCase().trim()) : [];
        const targetCategoryIds = Array.isArray(post.category_ids) ? post.category_ids.map(id => String(id)) : [];
        const mainCatName = (post.main_category_name || '').toLowerCase().trim();
        const mainCatId = post.main_category_id ? String(post.main_category_id) : '';

        let matchedAnyCat = false;
        let mainMatched = false;

        document.querySelectorAll('.category-tree-item-wrapper').forEach(wrapper => {
            const cb = wrapper.querySelector('input[name="category_ids[]"]');
            const label = wrapper.querySelector('label');
            const radio = wrapper.querySelector('input[name="main_category_id"]');
            if (!cb || !label) return;

            const catName = label.textContent.toLowerCase().trim();
            const catId = String(cb.value);

            const isMatched = (targetCategoryNames.length > 0 && targetCategoryNames.includes(catName)) ||
                              (targetCategoryIds.length > 0 && targetCategoryIds.includes(catId));

            if (isMatched) {
                cb.checked = true;
                matchedAnyCat = true;
                const badge = wrapper.querySelector('.main-cat-badge-container');
                if (badge) badge.style.display = 'inline-flex';

                if ((mainCatName && catName === mainCatName) || (mainCatId && catId === mainCatId)) {
                    if (radio) {
                        radio.checked = true;
                        mainMatched = true;
                    }
                }
            }
        });

        if (matchedAnyCat && !mainMatched) {
            const firstCheckedRadio = document.querySelector('input[name="category_ids[]"]:checked')?.closest('.category-tree-item-wrapper')?.querySelector('input[name="main_category_id"]');
            if (firstCheckedRadio) {
                firstCheckedRadio.checked = true;
            }
        }
        if (!matchedAnyCat) {
            const firstCb = document.querySelector('input[name="category_ids[]"]');
            if (firstCb) {
                firstCb.checked = true;
                const wrapper = firstCb.closest('.category-tree-item-wrapper');
                if (wrapper) {
                    const badge = wrapper.querySelector('.main-cat-badge-container');
                    if (badge) badge.style.display = 'inline-flex';
                    const radio = wrapper.querySelector('input[name="main_category_id"]');
                    if (radio) radio.checked = true;
                }
            }
        }

        // 10. Authors matching
        const authorSelect = document.getElementById('author_select');
        if (typeof window.clearAllAuthors === 'function') {
            window.clearAllAuthors();
        }
        if (authorSelect && typeof window.addAuthor === 'function') {
            const targetAuthorNames = Array.isArray(post.author_names) ? post.author_names.map(n => n.toLowerCase().trim()) : [];
            const targetAuthorIds = Array.isArray(post.author_ids) ? post.author_ids.map(id => String(id)) : [];
            let matchedAnyAuthor = false;

            Array.from(authorSelect.options).forEach(opt => {
                if (!opt.value) return;
                const optName = (opt.getAttribute('data-name') || opt.textContent).toLowerCase().trim();
                const optId = String(opt.value);

                const isMatched = (targetAuthorNames.length > 0 && targetAuthorNames.some(tan => optName.includes(tan) || tan.includes(optName))) ||
                                  (targetAuthorIds.length > 0 && targetAuthorIds.includes(optId));

                if (isMatched) {
                    window.addAuthor(opt.value, opt.getAttribute('data-name') || opt.textContent.trim(), opt.getAttribute('data-email') || '');
                    matchedAnyAuthor = true;
                }
            });

            if (!matchedAnyAuthor) {
                const adminOption = Array.from(authorSelect.options).find(opt => opt.text.trim().toLowerCase().startsWith('admin'));
                if (adminOption && adminOption.value) {
                    window.addAuthor(adminOption.value, adminOption.getAttribute('data-name'), adminOption.getAttribute('data-email'));
                } else if (authorSelect.options.length > 1) {
                    const firstOpt = authorSelect.options[1];
                    window.addAuthor(firstOpt.value, firstOpt.getAttribute('data-name'), firstOpt.getAttribute('data-email'));
                }
            }
        }

        // 11. Content & Parts
        const rawContent = post.content || '';
        const mainTextarea = document.querySelector('textarea[name="content"]');
        if (mainTextarea) {
            mainTextarea.value = rawContent;
        }

        const partsList = document.getElementById('parts-list');
        if (partsList) {
            partsList.innerHTML = '';
        }
        partCounter = 0;
        if (typeof quillInstances !== 'undefined') {
            for (let key in quillInstances) {
                delete quillInstances[key];
            }
        }

        if (!rawContent || rawContent.trim() === '') {
            addNewPart('', '');
        } else {
            const container = document.createElement('div');
            container.innerHTML = rawContent;
            const headingElements = Array.from(container.querySelectorAll('h2'));
            
            if (headingElements.length === 0) {
                addNewPart('', rawContent);
            } else {
                let firstHeading = headingElements[0];
                let currNode = container.firstChild;
                let prependedHtml = '';
                while (currNode && currNode !== firstHeading) {
                    if (currNode.nodeType === Node.ELEMENT_NODE) {
                        prependedHtml += currNode.outerHTML;
                    } else if (currNode.nodeType === Node.TEXT_NODE) {
                        prependedHtml += currNode.textContent;
                    }
                    currNode = currNode.nextSibling;
                }

                if (prependedHtml.trim() !== '') {
                    addNewPart('', prependedHtml);
                }

                headingElements.forEach((heading, idx) => {
                    const title = heading.textContent ? heading.textContent.trim() : '';
                    let contentHtml = '';
                    let nextNode = heading.nextSibling;
                    const nextHeading = headingElements[idx + 1];

                    while (nextNode && nextNode !== nextHeading) {
                        if (nextNode.nodeType === Node.ELEMENT_NODE) {
                            contentHtml += nextNode.outerHTML;
                        } else if (nextNode.nodeType === Node.TEXT_NODE) {
                            contentHtml += nextNode.textContent;
                        }
                        nextNode = nextNode.nextSibling;
                    }

                    addNewPart(title, contentHtml);
                });
            }
        }

        if (typeof compileContent === 'function') {
            compileContent();
        }

        showPastedBanner(post.title);
    }

    function showPastedBanner(postTitle) {
        const container = document.getElementById('pasted-post-banner-container');
        if (!container) return;

        container.innerHTML = `
            <div id="pasted-post-banner" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border: 1.5px solid #86efac; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 15px; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.12);">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #16a34a; color: white; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #166534; font-size: 14.5px;">পোস্টের সকল ডাটা সফলভাবে পেস্ট করা হয়েছে!</div>
                        <div style="color: #15803d; font-size: 12.5px; margin-top: 2px;">
                            "${escapeHTML(postTitle || 'পোস্ট')}" — শিরোনাম, অনুচ্ছেদ/পর্বসমূহ, ক্যাটাগরি, লেখক ও SEO সেটিংস সেম টু সেম লোড হয়েছে। এখন আপনি প্রয়োজনমতো দেখে নিয়ে 'Publish Article' বাটনে ক্লিক করতে পারবেন।
                        </div>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('pasted-post-banner').remove()" style="background: none; border: none; color: #166534; font-size: 20px; cursor: pointer; padding: 4px; line-height: 1;">&times;</button>
            </div>
        `;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handleDirectPasteOnAddPage() {
        if (navigator.clipboard && navigator.clipboard.readText) {
            navigator.clipboard.readText()
                .then(text => {
                    const cleaned = (text || '').trim();
                    if (cleaned && (cleaned.startsWith('{') || cleaned.startsWith('['))) {
                        try {
                            const parsed = JSON.parse(cleaned);
                            if (parsed && (parsed._type === 'nur_post_export' || parsed.post || parsed.title)) {
                                const post = parsed.post || parsed;
                                waitForQuillAndPopulate(post);
                                return;
                            }
                        } catch(e) {}
                    }
                    openAddPagePasteModal(cleaned);
                })
                .catch(err => {
                    console.warn('Clipboard read error/denied:', err);
                    openAddPagePasteModal();
                });
        } else {
            openAddPagePasteModal();
        }
    }

    function openAddPagePasteModal(initialValue = '') {
        const modal = document.getElementById('addPagePasteModal');
        const textarea = document.getElementById('addPagePasteTextarea');
        const errorEl = document.getElementById('addPagePasteError');
        if (errorEl) errorEl.style.display = 'none';
        if (textarea) textarea.value = initialValue || '';
        if (modal) {
            modal.classList.add('show');
            if (textarea) textarea.focus();
        }
    }

    function closeAddPagePasteModal() {
        const modal = document.getElementById('addPagePasteModal');
        if (modal) modal.classList.remove('show');
    }

    function readClipboardIntoAddPageModal() {
        if (navigator.clipboard && navigator.clipboard.readText) {
            navigator.clipboard.readText()
                .then(text => {
                    const textarea = document.getElementById('addPagePasteTextarea');
                    if (textarea) {
                        textarea.value = text;
                        textarea.focus();
                    }
                })
                .catch(err => {
                    alert('ক্লিপবোর্ড রিড করার পারমিশন পাওয়া যায়নি। কিবোর্ড থেকে Ctrl + V দিয়ে পেস্ট করুন।');
                });
        } else {
            alert('আপনার ব্রাউজারে অটো-রিড সাপোর্ট নেই। সরাসরি বক্সে Ctrl + V দিয়ে পেস্ট করুন।');
        }
    }

    function submitAddPagePasteModal() {
        const textarea = document.getElementById('addPagePasteTextarea');
        const errorEl = document.getElementById('addPagePasteError');
        const raw = textarea ? textarea.value.trim() : '';

        if (!raw) {
            if (errorEl) {
                errorEl.textContent = 'অনুগ্রহ করে কপি করা পোস্টের ডাটা পেস্ট করুন।';
                errorEl.style.display = 'block';
            }
            return;
        }

        try {
            const parsed = JSON.parse(raw);
            if (!parsed || (!parsed._type && !parsed.post && !parsed.title)) {
                throw new Error('পেস্ট করা ডাটা সঠিক পোস্ট ফরম্যাট নয়।');
            }
            const post = parsed.post || parsed;
            closeAddPagePasteModal();
            waitForQuillAndPopulate(post);
        } catch(e) {
            if (errorEl) {
                errorEl.textContent = 'ভুল ডাটা: ' + e.message;
                errorEl.style.display = 'block';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                compileContent();
            });
        }
    });

    function toggleFullscreen() {
        // Fullscreen command now handled on individual editors
    }

    function toggleRightSidebar() {
        const grid = document.getElementById('post-form-grid');
        const sidebar = document.getElementById('post-form-sidebar');
        const toggleBtn = document.getElementById('toggle-sidebar-btn');
        
        if (sidebar.style.display === 'none') {
            sidebar.style.display = 'flex';
            grid.style.gridTemplateColumns = '1fr 320px';
            toggleBtn.innerHTML = '<i class="fas fa-indent"></i> Hide Sidebar';
        } else {
            sidebar.style.display = 'none';
            grid.style.gridTemplateColumns = '1fr';
            toggleBtn.innerHTML = '<i class="fas fa-outdent"></i> Show Sidebar';
        }
    }

    function saveBackground() {
        compileContent();
        
        if (typeof validateForm === 'function' && !validateForm()) {
            return;
        }
        
        const saveBtn = document.getElementById('bg-save-btn');
        const originalHTML = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        const form = document.querySelector('form');
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                showToast('Article created successfully! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '<?= URLROOT ?>/admin/posts';
                }, 1000);
            } else {
                showToast('Failed to save article.', 'error');
            }
        })
        .catch(error => {
            console.error('Error saving:', error);
            showToast('An error occurred while saving.', 'error');
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalHTML;
        });
    }

    function showToast(message, type = 'success') {
        let toast = document.getElementById('bg-save-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'bg-save-toast';
            document.body.appendChild(toast);
        }
        
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 24px;
            background: \${type === 'success' ? '#22c55e' : '#ef4444'};
            color: white;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 100000;
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(100px);
            opacity: 0;
        `;
        
        toast.offsetHeight; // force reflow
        
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
        
        setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
        }, 3000);
    }
</script>

<style>
    /* Prevent sidebar and other admin elements from overlapping TinyMCE when in fullscreen */
    .tox-tinymce-aux {
        z-index: 9990 !important;
    }
    .tox.tox-tinymce.tox-fullscreen {
        z-index: 9980 !important;
    }
    body.editor-fullscreen-active .sidebar {
        display: none !important;
    }
    body.editor-fullscreen-active .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    
    @media (max-width: 992px) {
        #post-form-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
        .justify-content-between.d-flex.align-items-center {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }
        .justify-content-between.d-flex.align-items-center h3 {
            font-size: 1.5rem !important;
        }
        .justify-content-between.d-flex.align-items-center div {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
        }
        .btn-visit-site {
            padding: 8px 12px !important;
            font-size: 13px !important;
            justify-content: center !important;
            margin: 0 !important;
            width: 100% !important;
        }
        .admin-card {
            border: none !important;
            box-shadow: none !important;
            padding: 12px 0px !important;
            background: transparent !important;
            margin: 0 !important;
        }
    }
</style>

<?php require_once APPROOT . '/Views/admin/footer.php'; ?>
