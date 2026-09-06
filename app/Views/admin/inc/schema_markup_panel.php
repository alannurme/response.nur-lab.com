<?php
$db = \App\Config\Database::connect();
$social_links_stmt = $db->query("SELECT url FROM social_links ORDER BY order_index ASC, id ASC");
$social_urls = $social_links_stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];
?>
<div class="admin-card mt-4" style="padding: 20px; border-radius: 12px; border-top: 4px solid #10b981; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
    <h4 style="margin-bottom: 1.2rem; font-weight: 700; display: flex; justify-content: space-between; align-items: center; cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#schemaMarkupCollapse" aria-expanded="true" aria-controls="schemaMarkupCollapse">
        <span>📋 Schema Markup</span>
        <i class="fas fa-chevron-down" style="font-size: 0.9rem; transition: transform 0.2s;" id="schemaCollapseIcon"></i>
    </h4>

    <div id="schemaMarkupCollapse" class="collapse show">
        <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
            <!-- Schema Score & Indicators -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #475569;">Schema Score:</span>
                    <span id="schema_score_badge" class="badge bg-warning text-dark" style="font-size: 0.85rem; font-weight: 800; padding: 5px 10px;">0/100</span>
                </div>
                <div class="progress" style="height: 6px; margin-bottom: 10px; border-radius: 3px;">
                    <div id="schema_score_bar" class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; font-weight: 600;">
                    <span style="color: #64748b;">Google Rich Results:</span>
                    <span id="google_rich_badge" class="badge bg-secondary" style="padding: 4px 8px;">Unknown</span>
                </div>
            </div>

            <!-- Schema Type Selector -->
            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Schema Type</label>
                <select id="schema_type_select" name="schema_type" class="form-control" style="border-radius: 8px;">
                    <option value="">None / Disable Custom Schema</option>
                    <option value="BlogPosting">BlogPosting</option>
                    <option value="Article">Article</option>
                    <option value="NewsArticle">NewsArticle</option>
                    <option value="FAQPage">FAQPage</option>
                    <option value="Product">Product</option>
                    <option value="Review">Review</option>
                    <option value="VideoObject">VideoObject</option>
                    <option value="Event">Event</option>
                    <option value="Recipe">Recipe</option>
                    <option value="Person">Person</option>
                    <option value="Organization">Organization</option>
                    <option value="Custom">Custom JSON-LD</option>
                </select>
            </div>

            <!-- Dynamic Schema Fields Container -->
            <div id="dynamic_schema_fields" style="display: none; background: #fafafa; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 15px;">
                <!-- Fields are generated here dynamically via JS -->
            </div>

            <!-- Schema Data Input Holder -->
            <input type="hidden" name="schema_data" id="schema_data_input" value="<?= htmlspecialchars($data['post']['schema_data'] ?? '') ?>">

            <!-- Actions Panel -->
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button type="button" class="btn btn-sm btn-outline-primary" id="btn_schema_copy" style="flex: 1; min-width: 100px;"><i class="fas fa-copy"></i> Copy</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_schema_import" style="flex: 1; min-width: 100px;"><i class="fas fa-file-import"></i> Import</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_schema_export" style="flex: 1; min-width: 100px;"><i class="fas fa-file-export"></i> Export</button>
                <button type="button" class="btn btn-sm btn-outline-danger" id="btn_schema_reset" style="flex: 1; min-width: 100px;"><i class="fas fa-undo"></i> Reset</button>
            </div>

            <!-- JSON-LD Preview Collapsible -->
            <div style="margin-top: 5px;">
                <button type="button" class="btn btn-sm btn-link text-decoration-none w-100 text-start p-0 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#jsonldPreviewCollapse" aria-expanded="false" aria-controls="jsonldPreviewCollapse" style="color: #64748b; font-weight: 700;">
                    <span>🔎 Live JSON-LD Preview</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                </button>
                <div id="jsonldPreviewCollapse" class="collapse mt-2">
                    <pre id="jsonld_preview_code" style="background: #ffffff; color: #0f172a; border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; font-size: 0.78rem; max-height: 250px; overflow-y: auto; font-family: 'Courier New', Courier, monospace; margin: 0; white-space: pre-wrap; word-break: break-all;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for JSON-LD Import -->
<div class="modal fade" id="schemaImportModal" tabindex="-1" aria-labelledby="schemaImportModalLabel" aria-hidden="true" style="z-index: 10500;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title" id="schemaImportModalLabel" style="font-weight: 700; color: #334155;"><i class="fas fa-file-import" style="color: var(--primary);"></i> Import Schema JSON-LD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 12px;">Paste valid JSON-LD code below to import schema properties.</p>
                <textarea id="import_schema_json" class="form-control" rows="8" style="font-family: monospace; font-size: 0.85rem; border-radius: 8px;" placeholder='{ "@context": "https://schema.org", ... }'></textarea>
                <div id="import_error_msg" style="display: none; color: #ef4444; font-size: 0.8rem; font-weight: 600; margin-top: 8px;"></div>
            </div>
            <div class="modal-body footer" style="border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 8px; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_submit_import" class="btn btn-primary btn-sm" style="background: var(--primary);">Import Now</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('schema_type_select');
    const fieldsContainer = document.getElementById('dynamic_schema_fields');
    const dataInput = document.getElementById('schema_data_input');
    const scoreBar = document.getElementById('schema_score_bar');
    const scoreBadge = document.getElementById('schema_score_badge');
    const richBadge = document.getElementById('google_rich_badge');
    const previewPre = document.getElementById('jsonld_preview_code');
    const importTextarea = document.getElementById('import_schema_json');
    const importError = document.getElementById('import_error_msg');
    
    let schemaData = {};
    
    // Initialize saved data if present
    if (dataInput.value) {
        try {
            schemaData = JSON.parse(dataInput.value);
            if (schemaData.type) {
                typeSelect.value = schemaData.type;
            }
        } catch (e) {
            console.error('Failed to parse saved schema data', e);
        }
    }

    // Toggle arrow icon on collapse
    const collapseEl = document.getElementById('schemaMarkupCollapse');
    const collapseIcon = document.getElementById('schemaCollapseIcon');
    collapseEl.addEventListener('hidden.bs.collapse', function () {
        collapseIcon.style.transform = 'rotate(180deg)';
    });
    collapseEl.addEventListener('shown.bs.collapse', function () {
        collapseIcon.style.transform = 'rotate(0deg)';
    });

    // Handle Type Selection Changes
    typeSelect.addEventListener('change', function() {
        const type = this.value;
        if (!type) {
            fieldsContainer.style.display = 'none';
            fieldsContainer.innerHTML = '';
            schemaData = {};
            updatePreviewAndScore();
            return;
        }

        // Initialize state for new type
        if (schemaData.type !== type) {
            schemaData = { type: type, fields: {} };
        }
        
        renderFields(type);
        updatePreviewAndScore();
    });

    // Populate fields on load if type selected
    if (typeSelect.value) {
        renderFields(typeSelect.value);
        updatePreviewAndScore();
    } else {
        updatePreviewAndScore();
    }

    function renderFields(type) {
        fieldsContainer.style.display = 'block';
        fieldsContainer.innerHTML = '';
        const savedFields = schemaData.fields || {};

        if (type === 'Custom') {
            fieldsContainer.innerHTML = `
                <div class="form-group mb-2">
                    <label style="font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Custom JSON-LD Code</label>
                    <textarea id="custom_jsonld_editor" class="form-control" rows="10" style="font-family: monospace; font-size: 0.8rem; border-radius: 8px; background: #1e293b; color: #f8fafc; line-height: 1.5;" placeholder='{\n  "@context": "https://schema.org",\n  "@type": "BlogPosting",\n  ...\n}'></textarea>
                    <div id="json_syntax_error" style="display: none; color: #f87171; font-size: 0.78rem; font-weight: 600; margin-top: 5px;"></div>
                </div>
            `;
            const editor = document.getElementById('custom_jsonld_editor');
            editor.value = savedFields.custom_json || '';
            editor.addEventListener('input', function() {
                savedFields.custom_json = this.value;
                schemaData.fields = savedFields;
                
                // Real-time JSON validation
                const errorBox = document.getElementById('json_syntax_error');
                if (this.value.trim() === '') {
                    errorBox.style.display = 'none';
                } else {
                    try {
                        JSON.parse(this.value);
                        errorBox.style.display = 'none';
                    } catch (err) {
                        errorBox.innerText = `⚠️ Syntax Error: ${err.message}`;
                        errorBox.style.display = 'block';
                    }
                }
                updatePreviewAndScore();
            });
            return;
        }

        let fieldsHTML = '';
        
        // Define fields based on Schema Type
        switch (type) {
            case 'BlogPosting':
            case 'Article':
            case 'NewsArticle':
                fieldsHTML = `
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">SEO Keywords (Comma Separated)</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="keywords" placeholder="e.g. Islam, Philosophy, Science">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Article Section / Category</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="articleSection" placeholder="e.g. Research, History">
                    </div>
                    <div class="form-check form-switch mb-2" style="display: flex; align-items: center; gap: 10px;">
                        <input class="form-check-input schema-field-checkbox" type="checkbox" id="schema_enable_faq" data-key="enableFAQ" style="cursor: pointer;">
                        <label class="form-check-label" for="schema_enable_faq" style="font-size: 0.85rem; font-weight: 600; cursor: pointer; margin-bottom: 0;">Enable FAQ Schema</label>
                    </div>
                    <div class="form-check form-switch mb-2" style="display: flex; align-items: center; gap: 10px;">
                        <input class="form-check-input schema-field-checkbox" type="checkbox" id="schema_enable_video" data-key="enableVideo" style="cursor: pointer;">
                        <label class="form-check-label" for="schema_enable_video" style="font-size: 0.85rem; font-weight: 600; cursor: pointer; margin-bottom: 0;">Enable Video Schema</label>
                    </div>
                    <div id="nested_faq_container" style="display: none; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #cbd5e1;"></div>
                    <div id="nested_video_container" style="display: none; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #cbd5e1;"></div>
                `;
                break;

            case 'FAQPage':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label style="font-weight: 700; font-size: 0.88rem; display: block; margin-bottom: 8px;"><i class="fas fa-question-circle" style="color: var(--primary);"></i> FAQ Questions & Answers</label>
                        <div id="faq_builder_list" style="display: flex; flex-direction: column; gap: 10px;"></div>
                        <button type="button" class="btn btn-sm btn-primary w-100 mt-2" id="btn_add_faq_item" style="background: var(--primary);"><i class="fas fa-plus"></i> Add Question</button>
                    </div>
                `;
                break;

            case 'Product':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Product Name *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Brand *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="brand" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">SKU (Optional)</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="sku">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Price *</label>
                            <input type="number" step="0.01" class="form-control form-control-sm schema-field" data-key="price" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Currency *</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="priceCurrency" placeholder="BDT" value="BDT" required>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Availability *</label>
                        <select class="form-control form-control-sm schema-field" data-key="availability" required>
                            <option value="InStock">In Stock</option>
                            <option value="OutOfStock">Out of Stock</option>
                            <option value="PreOrder">Pre-Order</option>
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Rating (0-5)</label>
                            <input type="number" step="0.1" min="0" max="5" class="form-control form-control-sm schema-field" data-key="ratingValue">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Review Count</label>
                            <input type="number" class="form-control form-control-sm schema-field" data-key="reviewCount">
                        </div>
                    </div>
                `;
                break;

            case 'Review':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Item Reviewed *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="itemName" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Review Author *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="author" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Rating *</label>
                            <input type="number" step="0.1" class="form-control form-control-sm schema-field" data-key="ratingValue" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Best *</label>
                            <input type="number" class="form-control form-control-sm schema-field" data-key="bestRating" value="5" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Worst</label>
                            <input type="number" class="form-control form-control-sm schema-field" data-key="worstRating" value="1">
                        </div>
                    </div>
                `;
                break;

            case 'VideoObject':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Video URL *</label>
                        <input type="url" class="form-control form-control-sm schema-field" data-key="contentUrl" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Thumbnail URL *</label>
                        <input type="url" class="form-control form-control-sm schema-field" data-key="thumbnailUrl" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Duration (e.g. PT1M33S)</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="duration" placeholder="PT1M33S">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Upload Date</label>
                            <input type="date" class="form-control form-control-sm schema-field" data-key="uploadDate">
                        </div>
                    </div>
                `;
                break;

            case 'Event':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Event Name *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="name" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Start Date *</label>
                            <input type="datetime-local" class="form-control form-control-sm schema-field" data-key="startDate" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">End Date *</label>
                            <input type="datetime-local" class="form-control form-control-sm schema-field" data-key="endDate" required>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Location *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="location" placeholder="Address or Virtual URL" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Organizer</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="organizer">
                    </div>
                `;
                break;

            case 'Recipe':
                fieldsHTML = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Prep Time</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="prepTime" placeholder="e.g. PT15M">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Cook Time</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="cookTime" placeholder="e.g. PT30M">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" class="mb-2">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Total Time</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="totalTime" placeholder="e.g. PT45M">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Calories</label>
                            <input type="text" class="form-control form-control-sm schema-field" data-key="calories" placeholder="e.g. 250 kcal">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Cuisine *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="recipeCuisine" placeholder="e.g. Bengali, Indian" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Ingredients (1 per line) *</label>
                        <textarea class="form-control form-control-sm schema-field" data-key="recipeIngredient" rows="4" placeholder="1 cup Rice&#10;2 tbsp Oil" required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Instructions (1 per line) *</label>
                        <textarea class="form-control form-control-sm schema-field" data-key="recipeInstructions" rows="4" placeholder="Wash rice&#10;Boil water" required></textarea>
                    </div>
                `;
                break;

            case 'Person':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Name *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Job Title</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="jobTitle">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Image URL</label>
                        <input type="url" class="form-control form-control-sm schema-field" data-key="image">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Social Profiles (1 per line)</label>
                        <textarea class="form-control form-control-sm schema-field" data-key="sameAs" rows="3" placeholder="https://facebook.com/username&#10;https://twitter.com/username"></textarea>
                    </div>
                `;
                break;

            case 'Organization':
                fieldsHTML = `
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Organization Name *</label>
                        <input type="text" class="form-control form-control-sm schema-field" data-key="name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Logo URL</label>
                        <input type="url" class="form-control form-control-sm schema-field" data-key="logo">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Website URL</label>
                        <input type="url" class="form-control form-control-sm schema-field" data-key="url">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.85rem; margin-bottom: 2px;">Social Links (1 per line)</label>
                        <textarea class="form-control form-control-sm schema-field" data-key="sameAs" rows="3" placeholder="https://facebook.com/brand&#10;https://youtube.com/brand"></textarea>
                    </div>
                `;
                break;
        }

        fieldsContainer.innerHTML = fieldsHTML;

        // Populate values into fields
        fieldsContainer.querySelectorAll('.schema-field').forEach(input => {
            const key = input.getAttribute('data-key');
            
            // Auto fill logic for Article / BlogPosting
            if (key === 'keywords' && (!savedFields[key] || savedFields[key].trim() === '')) {
                const seoKeywordsInput = document.querySelector('input[name="seo_keywords"]');
                if (seoKeywordsInput && seoKeywordsInput.value.trim() !== '') {
                    savedFields[key] = seoKeywordsInput.value.trim();
                }
            }
            if (key === 'articleSection' && (!savedFields[key] || savedFields[key].trim() === '')) {
                const activeCatCheckbox = document.querySelector('input[name="category_ids[]"]:checked');
                if (activeCatCheckbox) {
                    const label = activeCatCheckbox.nextElementSibling || activeCatCheckbox.parentElement;
                    if (label) {
                        savedFields[key] = label.textContent.trim();
                    }
                }
            }

            if (savedFields[key] !== undefined) {
                input.value = savedFields[key];
            }
            
            // Sync changes to schemaData
            input.addEventListener('input', function() {
                savedFields[key] = this.value;
                schemaData.fields = savedFields;
                updatePreviewAndScore();
            });
        });

        // Initialize and bind Checkboxes (BlogPosting sub-schemas)
        fieldsContainer.querySelectorAll('.schema-field-checkbox').forEach(chk => {
            const key = chk.getAttribute('data-key');
            if (savedFields[key] !== undefined) {
                chk.checked = savedFields[key];
            }

            // Display sub-schema builders initially if checked
            toggleSubSchemaBuilders(key, chk.checked, savedFields);

            chk.addEventListener('change', function() {
                savedFields[key] = this.checked;
                schemaData.fields = savedFields;
                toggleSubSchemaBuilders(key, this.checked, savedFields);
                updatePreviewAndScore();
            });
        });

        // Handle FAQ Builder specifically if active type is FAQPage
        if (type === 'FAQPage') {
            initFaqBuilder(document.getElementById('faq_builder_list'), document.getElementById('btn_add_faq_item'), savedFields);
        }
    }

    function toggleSubSchemaBuilders(key, isChecked, savedFields) {
        if (key === 'enableFAQ') {
            const faqContainer = document.getElementById('nested_faq_container');
            if (isChecked) {
                faqContainer.style.display = 'block';
                faqContainer.innerHTML = `
                    <label style="font-weight: 700; font-size: 0.85rem; display: block; margin-bottom: 8px;"><i class="fas fa-question-circle" style="color: var(--primary);"></i> Nested FAQ Schema</label>
                    <div id="nested_faq_list" style="display: flex; flex-direction: column; gap: 8px;"></div>
                    <button type="button" class="btn btn-xs btn-outline-primary w-100 mt-2" id="btn_add_nested_faq"><i class="fas fa-plus"></i> Add Question</button>
                `;
                initFaqBuilder(document.getElementById('nested_faq_list'), document.getElementById('btn_add_nested_faq'), savedFields);
            } else {
                faqContainer.style.display = 'none';
                faqContainer.innerHTML = '';
                delete savedFields.faq_items;
            }
        } else if (key === 'enableVideo') {
            const videoContainer = document.getElementById('nested_video_container');
            if (isChecked) {
                videoContainer.style.display = 'block';
                videoContainer.innerHTML = `
                    <label style="font-weight: 700; font-size: 0.85rem; display: block; margin-bottom: 8px;"><i class="fas fa-video" style="color: var(--primary);"></i> Nested Video Schema</label>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.8rem; margin-bottom: 2px;">Video URL *</label>
                        <input type="url" class="form-control form-control-sm nested-video-field" data-key="videoUrl" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" style="font-weight: 600; font-size: 0.8rem; margin-bottom: 2px;">Thumbnail URL (Optional)</label>
                        <input type="url" class="form-control form-control-sm nested-video-field" data-key="videoThumbnail">
                    </div>
                `;
                
                // Populate nested video values
                videoContainer.querySelectorAll('.nested-video-field').forEach(input => {
                    const k = input.getAttribute('data-key');
                    if (savedFields[k] !== undefined) {
                        input.value = savedFields[k];
                    }
                    input.addEventListener('input', function() {
                        savedFields[k] = this.value;
                        schemaData.fields = savedFields;
                        updatePreviewAndScore();
                    });
                });
            } else {
                videoContainer.style.display = 'none';
                videoContainer.innerHTML = '';
                delete savedFields.videoUrl;
                delete savedFields.videoThumbnail;
            }
        }
    }

    function initFaqBuilder(listContainer, addBtn, savedFields) {
        let items = savedFields.faq_items || [];
        
        function renderFaqItem(questionText, answerText, index) {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'faq-builder-item';
            itemDiv.style.cssText = 'border: 1px solid #cbd5e1; background: #fff; border-radius: 8px; padding: 10px; position: relative;';
            itemDiv.innerHTML = `
                <div style="position: absolute; right: 8px; top: 8px; cursor: pointer; color: #ef4444; font-weight: bold; font-size: 1rem;" class="btn-remove-faq" title="Remove">&times;</div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm faq-q" value="${questionText}" placeholder="Question" style="font-size: 0.8rem;" required>
                </div>
                <div>
                    <textarea class="form-control form-control-sm faq-a" placeholder="Answer" rows="2" style="font-size: 0.8rem;" required>${answerText}</textarea>
                </div>
            `;
            listContainer.appendChild(itemDiv);
            
            // Listeners
            const qInput = itemDiv.querySelector('.faq-q');
            const aInput = itemDiv.querySelector('.faq-a');
            
            function syncFaqs() {
                const faqs = [];
                listContainer.querySelectorAll('.faq-builder-item').forEach(el => {
                    const q = el.querySelector('.faq-q').value;
                    const a = el.querySelector('.faq-a').value;
                    if (q.trim() || a.trim()) {
                        faqs.push({ question: q, answer: a });
                    }
                });
                savedFields.faq_items = faqs;
                schemaData.fields = savedFields;
                updatePreviewAndScore();
            }

            qInput.addEventListener('input', syncFaqs);
            aInput.addEventListener('input', syncFaqs);
            
            itemDiv.querySelector('.btn-remove-faq').addEventListener('click', function() {
                itemDiv.remove();
                syncFaqs();
            });
        }

        // Render saved ones
        items.forEach(item => {
            renderFaqItem(item.question || '', item.answer || '', listContainer.children.length);
        });

        addBtn.addEventListener('click', function() {
            renderFaqItem('', '', listContainer.children.length);
            updatePreviewAndScore();
        });
    }

    // Auto-generates clean structured JSON-LD code in real-time
    function generateJSONLD() {
        const type = typeSelect.value;
        if (!type) return '';

        // Auto fields pulled from form
        const titleVal = (document.querySelector('input[name="title"]')?.value || 'Untitled Post').trim();
        const excVal = (document.querySelector('textarea[name="excerpt"]')?.value || 'No excerpt available.').trim();
        const imgVal = document.getElementById('post_image_path')?.value || '';
        const dateVal = document.querySelector('input[name="created_at"]')?.value || new Date().toISOString();
        const slugVal = document.querySelector('input[name="slug"]')?.value || '';
        
        const fullUrl = `<?= URLROOT ?>/${slugVal}`;
        const siteTitle = `<?= $data['settings']['site_title'] ?? 'Insight Zone' ?>`;
        const siteLogo = `<?= !empty($data['settings']['site_logo']) ? resolve_setting_image($data['settings']['site_logo']) : URLROOT . '/public/img/logo.png' ?>`;

        // Authors parser - FIX: select only first child span containing the name
        let authorNames = [];
        document.querySelectorAll('#author_tags_container div[id^="author_tag_"] > span:first-child').forEach(span => {
            let name = span.textContent.split('(')[0].trim();
            if (name) authorNames.push(name);
        });
        if (authorNames.length === 0) {
            authorNames.push('Admin');
        }

        const fields = schemaData.fields || {};

        if (type === 'Custom') {
            return fields.custom_json || '';
        }

        // Calculate dynamic wordCount
        let wordCountVal = 0;
        if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
            const text = tinymce.get('content').getContent({ format: 'text' });
            wordCountVal = text.trim().split(/\s+/).filter(w => w.length > 0).length;
        } else {
            const contentText = document.querySelector('textarea[name="content"]')?.value || '';
            wordCountVal = contentText.replace(/<[^>]*>/g, '').trim().split(/\s+/).filter(w => w.length > 0).length;
        }

        // Get Category Name for Breadcrumb
        const activeCatCheckbox = document.querySelector('input[name="category_ids[]"]:checked');
        let catName = 'Blog';
        if (activeCatCheckbox) {
            catName = activeCatCheckbox.parentElement.textContent.trim();
        }

        // Dynamic Social URLs from Database
        const socialUrls = <?= json_encode($social_urls ?? []) ?>;

        // Base entities that always exist in Graph
        const orgEntity = {
            "@type": "Organization",
            "@id": `<?= URLROOT ?>/#organization`,
            "name": siteTitle,
            "url": `<?= URLROOT ?>/`,
            "logo": {
                "@type": "ImageObject",
                "url": siteLogo
            }
        };
        if (socialUrls && socialUrls.length > 0) {
            orgEntity["sameAs"] = socialUrls;
        }

        const websiteEntity = {
            "@type": "WebSite",
            "@id": `<?= URLROOT ?>/#website`,
            "name": siteTitle,
            "url": `<?= URLROOT ?>/`,
            "publisher": {
                "@id": `<?= URLROOT ?>/#organization`
            }
        };

        const webpageEntity = {
            "@type": "WebPage",
            "@id": `${fullUrl}#webpage`,
            "url": fullUrl,
            "name": titleVal,
            "isPartOf": {
                "@id": `<?= URLROOT ?>/#website`
            },
            "inLanguage": "bn-BD"
        };

        const breadcrumbEntity = {
            "@type": "BreadcrumbList",
            "@id": `${fullUrl}#breadcrumb`,
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": `<?= URLROOT ?>`
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": catName,
                    "item": `<?= URLROOT ?>/blog`
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": titleVal,
                    "item": fullUrl
                }
            ]
        };

        let graph = [orgEntity, websiteEntity, webpageEntity, breadcrumbEntity];

        switch (type) {
            case 'BlogPosting':
            case 'Article':
            case 'NewsArticle':
                const articleType = type;
                
                let articleEntity = {
                    "@type": articleType,
                    "@id": `${fullUrl}#article`,
                    "isPartOf": {
                        "@id": `${fullUrl}#webpage`
                    },
                    "headline": titleVal,
                    "description": excVal,
                    "inLanguage": "bn-BD",
                    "mainEntityOfPage": {
                        "@id": `${fullUrl}#webpage`
                    },
                    "url": fullUrl,
                    "wordCount": wordCountVal,
                    "datePublished": dateVal,
                    "dateModified": dateVal,
                    "author": authorNames.map(name => {
                        const cleanName = name.split('(')[0].trim();
                        const slug = cleanName.toLowerCase().replace(/[\s\(\)]+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '');
                        return {
                            "@type": "Person",
                            "@id": `<?= URLROOT ?>/authors/${slug}`,
                            "name": cleanName,
                            "url": `<?= URLROOT ?>/authors/${slug}`
                        };
                    }),
                    "publisher": {
                        "@id": `<?= URLROOT ?>/#organization`
                    }
                };

                if (imgVal) {
                    const imgUrl = imgVal.startsWith('http') ? imgVal : `<?= URLROOT ?>/public/img/${imgVal.split('/').pop()}`;
                    articleEntity["image"] = {
                        "@type": "ImageObject",
                        "url": imgUrl,
                        "width": 1200,
                        "height": 630
                    };
                }

                if (fields.keywords) {
                    articleEntity["keywords"] = fields.keywords.split(',').map(k => k.trim());
                }
                if (fields.articleSection) {
                    articleEntity["articleSection"] = fields.articleSection;
                }

                graph.push(articleEntity);

                // If FAQPage is enabled inside Article, append it as a separate Entity in the graph
                if (fields.enableFAQ && fields.faq_items && fields.faq_items.length > 0) {
                    const faqEntity = {
                        "@type": "FAQPage",
                        "@id": `${fullUrl}#faq`,
                        "isPartOf": {
                            "@id": `${fullUrl}#webpage`
                        },
                        "mainEntity": fields.faq_items.map(faq => ({
                            "@type": "Question",
                            "name": faq.question,
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": faq.answer
                            }
                        }))
                    };
                    graph.push(faqEntity);
                }

                // If VideoObject is enabled inside Article, append it as a separate Entity in the graph
                if (fields.enableVideo && fields.videoUrl) {
                    const videoEntity = {
                        "@type": "VideoObject",
                        "@id": `${fullUrl}#video`,
                        "isPartOf": {
                            "@id": `${fullUrl}#webpage`
                        },
                        "name": titleVal,
                        "description": excVal,
                        "contentUrl": fields.videoUrl,
                        "thumbnailUrl": fields.videoThumbnail || siteLogo,
                        "uploadDate": dateVal
                    };
                    graph.push(videoEntity);
                }
                break;

            case 'FAQPage':
                if (fields.faq_items && fields.faq_items.length > 0) {
                    const faqEntity = {
                        "@type": "FAQPage",
                        "@id": `${fullUrl}#faq`,
                        "isPartOf": {
                            "@id": `${fullUrl}#webpage`
                        },
                        "mainEntity": fields.faq_items.map(faq => ({
                            "@type": "Question",
                            "name": faq.question,
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": faq.answer
                            }
                        }))
                    };
                    graph.push(faqEntity);
                }
                break;

            case 'Product':
                let productEntity = {
                    "@type": "Product",
                    "@id": `${fullUrl}#product`,
                    "name": fields.name || titleVal,
                    "brand": {
                        "@type": "Brand",
                        "name": fields.brand || ''
                    },
                    "offers": {
                        "@type": "Offer",
                        "price": fields.price || '0.00',
                        "priceCurrency": fields.priceCurrency || 'BDT',
                        "availability": `https://schema.org/${fields.availability || 'InStock'}`
                    }
                };
                if (imgVal) {
                    const imgUrl = imgVal.startsWith('http') ? imgVal : `<?= URLROOT ?>/public/img/${imgVal.split('/').pop()}`;
                    productEntity["image"] = imgUrl;
                }
                if (fields.sku) productEntity["sku"] = fields.sku;
                if (fields.ratingValue && fields.reviewCount) {
                    productEntity["aggregateRating"] = {
                        "@type": "AggregateRating",
                        "ratingValue": fields.ratingValue,
                        "reviewCount": fields.reviewCount,
                        "bestRating": "5",
                        "worstRating": "0"
                    };
                }
                graph.push(productEntity);
                break;

            case 'Review':
                let reviewEntity = {
                    "@type": "Review",
                    "@id": `${fullUrl}#review`,
                    "itemReviewed": {
                        "@type": "Thing",
                        "name": fields.itemName || titleVal
                    },
                    "reviewRating": {
                        "@type": "Rating",
                        "ratingValue": fields.ratingValue || '5',
                        "bestRating": fields.bestRating || '5',
                        "worstRating": fields.worstRating || '1'
                    },
                    "author": {
                        "@type": "Person",
                        "@id": `<?= URLROOT ?>/authors/${(fields.author || authorNames[0]).toLowerCase().replace(/[\s\(\)]+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '')}`,
                        "name": fields.author || authorNames[0],
                        "url": `<?= URLROOT ?>/authors/${(fields.author || authorNames[0]).toLowerCase().replace(/[\s\(\)]+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '')}`
                    },
                    "publisher": {
                        "@id": `<?= URLROOT ?>/#organization`
                    }
                };
                graph.push(reviewEntity);
                break;

            case 'VideoObject':
                let videoEntity = {
                    "@type": "VideoObject",
                    "@id": `${fullUrl}#video`,
                    "name": titleVal,
                    "description": excVal,
                    "contentUrl": fields.contentUrl || '',
                    "thumbnailUrl": fields.thumbnailUrl || siteLogo,
                    "uploadDate": fields.uploadDate || dateVal
                };
                if (fields.duration) videoEntity["duration"] = fields.duration;
                graph.push(videoEntity);
                break;

            case 'Event':
                let eventEntity = {
                    "@type": "Event",
                    "@id": `${fullUrl}#event`,
                    "name": fields.name || titleVal,
                    "startDate": fields.startDate || dateVal,
                    "endDate": fields.endDate || dateVal,
                    "location": fields.location ? (fields.location.startsWith('http') ? {
                        "@type": "VirtualLocation",
                        "url": fields.location
                    } : {
                        "@type": "Place",
                        "name": fields.location,
                        "address": fields.location
                    }) : { "@type": "Place", "name": "Online" }
                };
                if (fields.organizer) {
                    eventEntity["organizer"] = {
                        "@type": "Organization",
                        "name": fields.organizer
                    };
                }
                graph.push(eventEntity);
                break;

            case 'Recipe':
                let recipeEntity = {
                    "@type": "Recipe",
                    "@id": `${fullUrl}#recipe`,
                    "name": titleVal,
                    "recipeCuisine": fields.recipeCuisine || ''
                };
                if (imgVal) {
                    const imgUrl = imgVal.startsWith('http') ? imgVal : `<?= URLROOT ?>/public/img/${imgVal.split('/').pop()}`;
                    recipeEntity["image"] = imgUrl;
                }
                if (fields.prepTime) recipeEntity["prepTime"] = fields.prepTime;
                if (fields.cookTime) recipeEntity["cookTime"] = fields.cookTime;
                if (fields.totalTime) recipeEntity["totalTime"] = fields.totalTime;
                if (fields.calories) {
                    recipeEntity["nutrition"] = {
                        "@type": "NutritionInformation",
                        "calories": fields.calories
                    };
                }
                if (fields.recipeIngredient) {
                    recipeEntity["recipeIngredient"] = fields.recipeIngredient.split('\n').map(i => i.trim()).filter(i => i);
                }
                if (fields.recipeInstructions) {
                    recipeEntity["recipeInstructions"] = fields.recipeInstructions.split('\n').map(i => i.trim()).filter(i => i).map(inst => ({
                        "@type": "HowToStep",
                        "text": inst
                    }));
                }
                graph.push(recipeEntity);
                break;

            case 'Person':
                let personEntity = {
                    "@type": "Person",
                    "@id": `${fullUrl}#person`,
                    "name": fields.name || authorNames[0]
                };
                if (fields.jobTitle) personEntity["jobTitle"] = fields.jobTitle;
                if (fields.image) personEntity["image"] = fields.image;
                if (fields.sameAs) {
                    personEntity["sameAs"] = fields.sameAs.split('\n').map(l => l.trim()).filter(l => l);
                }
                graph.push(personEntity);
                break;

            case 'Organization':
                let organizationEntity = {
                    "@type": "Organization",
                    "@id": `${fullUrl}#organization`,
                    "name": fields.name || siteTitle,
                    "logo": fields.logo || siteLogo,
                    "url": fields.url || `<?= URLROOT ?>`
                };
                if (fields.sameAs) {
                    organizationEntity["sameAs"] = fields.sameAs.split('\n').map(l => l.trim()).filter(l => l);
                }
                graph.push(organizationEntity);
                break;
        }

        const schemaWrapper = {
            "@context": "https://schema.org",
            "@graph": graph
        };

        return JSON.stringify(schemaWrapper, null, 2);
    }

    function updatePreviewAndScore() {
        const type = typeSelect.value;
        if (!type) {
            dataInput.value = '';
            previewPre.textContent = '// No Schema Active';
            scoreBadge.textContent = '0/100';
            scoreBadge.className = 'badge bg-secondary';
            scoreBar.style.width = '0%';
            scoreBar.className = 'progress-bar bg-secondary';
            richBadge.textContent = 'Disabled';
            richBadge.className = 'badge bg-secondary';
            return;
        }

        const jsonString = generateJSONLD();
        previewPre.textContent = jsonString || '// Incomplete configuration';

        // Update hidden field to be submitted with form
        dataInput.value = JSON.stringify(schemaData);

        // Score & Validation Engine
        let score = 0;
        let errors = [];
        let warnings = [];

        if (type) score += 30; // Type chosen

        const fields = schemaData.fields || {};

        if (type === 'Custom') {
            if (fields.custom_json) {
                try {
                    JSON.parse(fields.custom_json);
                    score += 70;
                } catch (e) {
                    errors.push('Invalid JSON syntax');
                }
            } else {
                errors.push('JSON is empty');
            }
        } else {
            // General rules check
            const titleVal = document.querySelector('input[name="title"]')?.value;
            const imgVal = document.getElementById('post_image_path')?.value;
            const excVal = document.querySelector('textarea[name="excerpt"]')?.value;

            if (titleVal && titleVal.trim() !== '') score += 30;
            else errors.push('Post title is empty');

            if (imgVal && imgVal.trim() !== '') score += 20;
            else {
                warnings.push('No featured image selected');
                score += 10; // Give partial score
            }

            if (excVal && excVal.trim() !== '') score += 10;
            else {
                warnings.push('Post excerpt is empty');
                score += 5; // Give partial score
            }

            // Type-specific field validations
            switch (type) {
                case 'BlogPosting':
                case 'Article':
                case 'NewsArticle':
                    if (fields.keywords) score += 15;
                    else warnings.push('Keywords missing');

                    if (fields.articleSection) score += 15;
                    else warnings.push('Article section missing');
                    
                    if (fields.enableFAQ) {
                        if (fields.faq_items && fields.faq_items.length > 0) score += 10;
                        else errors.push('FAQ is enabled but empty');
                    } else {
                        score += 10;
                    }
                    break;

                case 'FAQPage':
                    if (fields.faq_items && fields.faq_items.length > 0) {
                        score += 50;
                    } else {
                        errors.push('No questions added to FAQ');
                    }
                    break;

                case 'Product':
                    if (fields.name) score += 10; else errors.push('Product name is required');
                    if (fields.brand) score += 10; else errors.push('Brand is required');
                    if (fields.price) score += 15; else errors.push('Price is required');
                    if (fields.priceCurrency) score += 5; else errors.push('Price currency is required');
                    if (fields.availability) score += 10; else errors.push('Availability status is required');
                    break;

                case 'Review':
                    if (fields.itemName) score += 15; else errors.push('Item name is required');
                    if (fields.author) score += 10; else errors.push('Review author is required');
                    if (fields.ratingValue) score += 15; else errors.push('Rating value is required');
                    if (fields.bestRating) score += 10; else errors.push('Best rating boundary is required');
                    break;

                case 'VideoObject':
                    if (fields.contentUrl) score += 25; else errors.push('Video source URL is required');
                    if (fields.thumbnailUrl) score += 25; else errors.push('Thumbnail URL is required');
                    break;

                case 'Event':
                    if (fields.name) score += 10; else errors.push('Event name is required');
                    if (fields.startDate) score += 15; else errors.push('Start Date is required');
                    if (fields.endDate) score += 15; else errors.push('End Date is required');
                    if (fields.location) score += 10; else errors.push('Location details are required');
                    break;

                case 'Recipe':
                    if (fields.recipeCuisine) score += 10; else errors.push('Cuisine is required');
                    if (fields.recipeIngredient) score += 20; else errors.push('Ingredients list is required');
                    if (fields.recipeInstructions) score += 20; else errors.push('Instructions list is required');
                    break;

                case 'Person':
                    if (fields.name) score += 25; else errors.push('Person name is required');
                    if (fields.jobTitle) score += 15; else warnings.push('Job title missing');
                    if (fields.image) score += 10; else warnings.push('Image missing');
                    break;

                case 'Organization':
                    if (fields.name) score += 25; else errors.push('Organization name is required');
                    if (fields.logo) score += 15; else warnings.push('Logo missing');
                    if (fields.url) score += 10; else errors.push('URL is required');
                    break;
            }
        }

        // Display Score & Progress Bar
        score = Math.min(score, 100);
        scoreBadge.textContent = `${score}/100`;
        scoreBar.style.width = `${score}%`;

        if (score >= 80) {
            scoreBadge.className = 'badge bg-success';
            scoreBar.className = 'progress-bar bg-success';
        } else if (score >= 50) {
            scoreBadge.className = 'badge bg-warning text-dark';
            scoreBar.className = 'progress-bar bg-warning';
        } else {
            scoreBadge.className = 'badge bg-danger';
            scoreBar.className = 'progress-bar bg-danger';
        }

        // Rich Results compatibility indicator
        if (errors.length > 0) {
            richBadge.textContent = 'Errors Detected';
            richBadge.className = 'badge bg-danger';
            richBadge.title = errors.join(', ');
        } else if (warnings.length > 0) {
            richBadge.textContent = 'Valid with Warnings';
            richBadge.className = 'badge bg-warning text-dark';
            richBadge.title = warnings.join(', ');
        } else {
            richBadge.textContent = 'Fully Compatible';
            richBadge.className = 'badge bg-success';
            richBadge.removeAttribute('title');
        }
    }

    // Actions Listeners
    // Copy
    document.getElementById('btn_schema_copy').addEventListener('click', function() {
        const json = generateJSONLD();
        if (!json) {
            alert('No active schema to copy.');
            return;
        }
        navigator.clipboard.writeText(json).then(() => {
            const origText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Copied!';
            setTimeout(() => this.innerHTML = origText, 1500);
        }).catch(err => {
            alert('Failed to copy JSON-LD code.');
        });
    });

    // Reset
    document.getElementById('btn_schema_reset').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear all customized schema configurations?')) {
            typeSelect.value = '';
            schemaData = {};
            fieldsContainer.innerHTML = '';
            fieldsContainer.style.display = 'none';
            updatePreviewAndScore();
        }
    });

    // Export
    document.getElementById('btn_schema_export').addEventListener('click', function() {
        const json = generateJSONLD();
        if (!json) {
            alert('No schema data available to export.');
            return;
        }
        const blob = new Blob([json], { type: 'application/ld+json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${typeSelect.value || 'schema'}-markup.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    // Custom Modal helper (avoids ReferenceError: bootstrap is not defined)
    const modalEl = document.getElementById('schemaImportModal');
    function showModal() {
        modalEl.style.display = 'block';
        modalEl.classList.add('show');
        document.body.classList.add('modal-open');
        if (!document.getElementById('schema-modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'schema-modal-backdrop';
            document.body.appendChild(backdrop);
        }
    }
    function hideModal() {
        modalEl.style.display = 'none';
        modalEl.classList.remove('show');
        document.body.classList.remove('modal-open');
        const backdrop = document.getElementById('schema-modal-backdrop');
        if (backdrop) backdrop.remove();
    }
    modalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
        btn.addEventListener('click', hideModal);
    });

    // Import Trigger
    document.getElementById('btn_schema_import').addEventListener('click', function() {
        importTextarea.value = '';
        importError.style.display = 'none';
        showModal();
    });

    document.getElementById('btn_submit_import').addEventListener('click', function() {
        const val = importTextarea.value.trim();
        if (!val) {
            importError.innerText = 'Please paste some JSON-LD code first.';
            importError.style.display = 'block';
            return;
        }

        try {
            const parsed = JSON.parse(val);
            const type = parsed['@type'] || parsed['type'];
            if (!type) {
                importError.innerText = 'Missing "@type" key in imported JSON-LD.';
                importError.style.display = 'block';
                return;
            }

            // Successfully parsed. Let's populate schemaData
            typeSelect.value = type;
            schemaData = {
                type: type,
                fields: {}
            };

            // Map standard keys
            const ignoredKeys = ['@context', '@type', 'publisher', 'author', 'mainEntityOfPage', 'headline', 'description', 'image', 'datePublished', 'dateModified'];
            for (let key in parsed) {
                if (!ignoredKeys.includes(key)) {
                    if (key === 'mainEntity' && Array.isArray(parsed[key])) {
                        // FAQ mapping
                        schemaData.fields.faq_items = parsed[key].map(item => ({
                            question: item.name || '',
                            answer: item.acceptedAnswer?.text || ''
                        }));
                    } else if (key === 'offers' && typeof parsed[key] === 'object') {
                        schemaData.fields.price = parsed[key].price || '';
                        schemaData.fields.priceCurrency = parsed[key].priceCurrency || 'BDT';
                        if (parsed[key].availability) {
                            schemaData.fields.availability = parsed[key].availability.split('/').pop();
                        }
                    } else if (key === 'aggregateRating' && typeof parsed[key] === 'object') {
                        schemaData.fields.ratingValue = parsed[key].ratingValue || '';
                        schemaData.fields.reviewCount = parsed[key].reviewCount || '';
                    } else if (key === 'brand' && typeof parsed[key] === 'object') {
                        schemaData.fields.brand = parsed[key].name || '';
                    } else if (key === 'reviewRating' && typeof parsed[key] === 'object') {
                        schemaData.fields.ratingValue = parsed[key].ratingValue || '';
                        schemaData.fields.bestRating = parsed[key].bestRating || '';
                        schemaData.fields.worstRating = parsed[key].worstRating || '';
                    } else {
                        schemaData.fields[key] = Array.isArray(parsed[key]) ? parsed[key].join('\n') : parsed[key];
                    }
                }
            }

            // Close modal
            hideModal();
            
            // Re-render and preview
            renderFields(type);
            updatePreviewAndScore();

        } catch (err) {
            importError.innerText = `Invalid JSON: ${err.message}`;
            importError.style.display = 'block';
        }
    });

    // Listen to changes on main form to refresh dynamic previews
    document.querySelector('input[name="title"]')?.addEventListener('input', updatePreviewAndScore);
    document.querySelector('textarea[name="excerpt"]')?.addEventListener('input', updatePreviewAndScore);
    
    // Auto sync keywords from main SEO keywords input
    document.querySelector('input[name="seo_keywords"]')?.addEventListener('input', function() {
        const keywordsInput = fieldsContainer.querySelector('input[data-key="keywords"]');
        const savedFields = schemaData.fields || {};
        if (keywordsInput && (!savedFields.keywords || savedFields.keywords.trim() === '')) {
            keywordsInput.value = this.value;
            updatePreviewAndScore();
        }
    });

    // Auto sync category selection
    document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => {
        cb.addEventListener('change', function() {
            const sectionInput = fieldsContainer.querySelector('input[data-key="articleSection"]');
            const savedFields = schemaData.fields || {};
            if (sectionInput && (!savedFields.articleSection || savedFields.articleSection.trim() === '')) {
                const activeCatCheckbox = document.querySelector('input[name="category_ids[]"]:checked');
                if (activeCatCheckbox) {
                    const label = activeCatCheckbox.nextElementSibling || activeCatCheckbox.parentElement;
                    if (label) {
                        sectionInput.value = label.textContent.trim();
                        updatePreviewAndScore();
                    }
                }
            }
        });
    });
});
</script>
