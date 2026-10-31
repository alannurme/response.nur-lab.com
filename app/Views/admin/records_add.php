<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
    .odb-container {
        max-width: 100%;
        margin: 0 0 2rem 0;
        width: 100%;
        font-family: 'Tiro Bangla', 'Outfit', sans-serif;
    }

    .odb-btn-back { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        color: #64748b; 
        text-decoration: none; 
        font-weight: 700; 
        margin-bottom: 1.2rem; 
        font-size: 0.95rem; 
        transition: color 0.2s ease;
    }
    .odb-btn-back:hover { color: #2563eb; }

    .odb-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 2.2rem 2.4rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        color: #0f172a;
    }

    .odb-form-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.4rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .odb-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .odb-section-card-title {
        font-size: 1.02rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-bottom: 0.7rem;
        border-bottom: 1px dashed #cbd5e1;
    }
    .odb-section-card-title i {
        color: #2563eb;
    }

    .odb-btn-add-small {
        background: #eff6ff;
        border: 1.5px dashed #3b82f6;
        color: #2563eb;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .odb-btn-add-small:hover {
        background: #2563eb;
        color: #fff;
    }

    .odb-btn-remove-entry {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #ef4444;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .odb-btn-remove-entry:hover {
        background: #ef4444;
        color: #fff;
    }

    .odb-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 340px;
        gap: 1.2rem;
    }

    .odb-form-grid-bottom {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }
    .odb-form-grid-bottom .full-width {
        grid-column: 1 / -1;
    }

    .odb-form-group {
        margin-bottom: 1rem;
    }
    .odb-form-group.full-width {
        grid-column: 1 / -1;
    }

    .odb-form-group label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .odb-form-control {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a;
        padding: 0.65rem 0.9rem;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .odb-form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    select.odb-form-control option {
        background: #ffffff;
        color: #0f172a;
    }
    textarea.odb-form-control {
        resize: vertical;
        min-height: 85px;
    }

    /* Photo Upload Box */
    .odb-photo-upload-box {
        grid-column: 3;
        grid-row: 1 / span 5;
        display: flex;
        flex-direction: column;
        margin-bottom: 0;
    }

    .odb-photo-dropzone {
        position: relative;
        width: 100%;
        flex: 1;
        min-height: 250px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.2s ease;
        text-align: center;
        padding: 10px;
    }
    .odb-photo-dropzone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }
    .odb-photo-dropzone i.fa-cloud-arrow-up {
        font-size: 2rem;
        color: #2563eb;
    }
    .odb-photo-dropzone span.upload-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 700;
    }
    .odb-photo-file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5;
    }
    .odb-photo-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        z-index: 3;
        display: none;
    }
    .odb-photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 4;
        pointer-events: none;
    }
    .odb-photo-dropzone:hover .odb-photo-overlay {
        opacity: 1;
    }

    /* Category Pills */
    .odb-category-pills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 16px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        max-height: 220px;
        overflow-y: auto;
    }
    .odb-category-pill {
        cursor: pointer;
        user-select: none;
        display: inline-block;
        margin: 0;
    }
    .odb-category-pill input {
        display: none;
    }
    .odb-pill-content {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.55rem 1.15rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #475569;
        transition: all 0.25s ease;
    }
    .odb-category-pill:hover .odb-pill-content {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }
    .odb-category-pill input:checked + .odb-pill-content {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transform: translateY(-1px);
    }
    .odb-category-pill input:checked + .odb-pill-content .check-icon {
        display: inline-block !important;
    }
    .odb-category-pill input:not(:checked) + .odb-pill-content .check-icon {
        display: none !important;
    }

    /* Gallery Dropzone */
    .gallery-dropzone {
        border: 2px dashed #93c5fd !important;
        background: #ffffff !important;
        border-radius: 14px;
        padding: 2.2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .gallery-dropzone:hover {
        border-color: #2563eb !important;
        background: #eff6ff !important;
    }
    .gallery-dropzone i.fa-cloud-arrow-up {
        font-size: 2.4rem;
        color: #2563eb;
        margin-bottom: 8px;
    }
    .gallery-dropzone h4 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }
    .gallery-dropzone p {
        font-size: 0.88rem;
        color: #64748b;
        margin: 0;
    }

    /* Submit Button */
    .odb-btn-submit {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        border: none;
        padding: 0.95rem 2.4rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.05rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.25s ease;
    }
    .odb-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    }

    @media (max-width: 1100px) {
        .odb-form-grid { grid-template-columns: repeat(2, 1fr); }
        .odb-photo-upload-box { grid-column: 1 / -1; grid-row: auto; min-height: 200px; }
    }
    @media (max-width: 768px) { 
        .odb-form-grid { grid-template-columns: 1fr; }
        .odb-form-grid-bottom { grid-template-columns: 1fr; }
    }
</style>

<div class="odb-container">
    <a href="<?= URLROOT ?>/admin/records" class="odb-btn-back">
        <i class="fa-solid fa-arrow-left"></i> রেকর্ড লিস্টে ফিরে যান
    </a>

    <div class="odb-form-card">
        <h1 class="odb-form-title">
            <i class="fa-solid fa-database" style="color: #3b82f6;"></i> নতুন ডাটা রেকর্ড যোগ করুন
        </h1>

        <form action="<?= URLROOT ?>/admin/records" method="post" enctype="multipart/form-data">
            
            <!-- Wrapper for Personal Info Cards ONLY -->
            <div id="personalCardsWrapper">
                <!-- Section Card 1: Personal Details & Photo -->
                <div class="odb-section-card personal-card-block">
                    <div class="odb-section-card-title">
                        <span><i class="fa-solid fa-id-card"></i> ব্যক্তিগত তথ্য ও ছবি</span>
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <label style="display: inline-flex; align-items: center; gap: 6px; margin: 0; font-size: 0.85rem; color: #854d0e; font-weight: 700; cursor: pointer; background: #fefce8; padding: 5px 12px; border-radius: 20px; border: 1px solid #fde047;">
                                <input type="checkbox" name="is_most_wanted_check[]" value="1" onchange="this.nextElementSibling.value = this.checked ? '1' : '0'" style="accent-color: #f59e0b; cursor: pointer;">
                                <input type="hidden" name="is_most_wanted[]" value="0">
                                ★ বিশেষ এন্ট্রি
                            </label>

                            <button type="button" id="btnAddPersonalCard" class="odb-btn-add-small">
                                <i class="fa-solid fa-user-plus"></i> + আরও একজন যোগ করুন
                            </button>
                        </div>
                    </div>

                    <div class="odb-form-grid">
                        <!-- Row 1: Full Name, Alias -->
                        <div class="odb-form-group">
                            <label>পূর্ণ নাম *</label>
                            <input type="text" name="name[]" class="odb-form-control" placeholder="যেমন: কায়সার আহমেদ" required>
                        </div>

                        <div class="odb-form-group">
                            <label>উপনাম (Alias)</label>
                            <input type="text" name="alias[]" class="odb-form-control" placeholder="যেমন: কালা কায়সার">
                        </div>

                        <!-- Photo Upload Dropzone -->
                        <div class="odb-form-group odb-photo-upload-box">
                            <label>ছবি নির্বাচন করুন *</label>
                            <div class="odb-photo-dropzone">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span class="upload-label">ছবি আপলোড</span>
                                
                                <input type="file" name="photo[]" class="odb-photo-file-input" accept="image/*" onchange="previewPhoto(this)">
                                <img class="odb-photo-preview" src="" alt="Preview">
                                <div class="odb-photo-overlay">
                                    <i class="fa-solid fa-camera" style="margin-right: 5px;"></i> ছবি পরিবর্তন করুন
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: NID/Passport, Gender -->
                        <div class="odb-form-group">
                            <label>এনআইডি / পাসপোর্ট নম্বর</label>
                            <input type="text" name="nid_passport[]" class="odb-form-control" placeholder="1992269123450001">
                        </div>

                        <div class="odb-form-group">
                            <label>লিঙ্গ</label>
                            <select name="gender[]" class="odb-form-control">
                                <option value="Male">পুরুষ</option>
                                <option value="Female">নারী</option>
                                <option value="Other">অন্যান্য</option>
                            </select>
                        </div>

                        <!-- Row 3: Age, Height -->
                        <div class="odb-form-group">
                            <label>বয়স</label>
                            <input type="number" name="age[]" class="odb-form-control" placeholder="34">
                        </div>

                        <div class="odb-form-group">
                            <label>উচ্চতা (সেমি)</label>
                            <input type="number" name="height_cm[]" class="odb-form-control" placeholder="175">
                        </div>

                        <!-- Row 4: Phone, Social Media Link -->
                        <div class="odb-form-group">
                            <label>ফোন / মোবাইল নম্বর</label>
                            <input type="text" name="phone[]" class="odb-form-control" placeholder="+880 1700-000000">
                        </div>

                        <div class="odb-form-group">
                            <label>সোশ্যাল মিডিয়া প্রোফাইল লিংক</label>
                            <input type="url" name="social_media[]" class="odb-form-control" placeholder="https://facebook.com/username">
                        </div>

                        <!-- Row 5: Structured Location Selectors & Address -->
                        <div class="odb-form-group" style="grid-column: 1 / span 2;">
                            <label>অবস্থান নির্বাচন করুন (বিভাগ / জেলা / থানা) *</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 8px;">
                                <select class="odb-form-control loc-division" onchange="filterDistricts(this)">
                                    <option value="">-- বিভাগ সিলেক্ট করুন --</option>
                                    <?php 
                                        $locationsList = $data['locations'] ?? [];
                                        $divisions = !empty($locationsList) ? array_unique(array_column($locationsList, 'division')) : ['Dhaka', 'Chattogram', 'Rajshahi', 'Khulna', 'Barishal', 'Sylhet', 'Rangpur', 'Mymensingh'];
                                        sort($divisions);
                                        foreach ($divisions as $div): 
                                    ?>
                                        <option value="<?= htmlspecialchars($div) ?>"><?= htmlspecialchars($div) ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <select class="odb-form-control loc-district" onchange="filterUpazilas(this)" disabled>
                                    <option value="">-- জেলা সিলেক্ট করুন --</option>
                                </select>

                                <select class="odb-form-control loc-upazila" onchange="updateFullAddress(this)" disabled>
                                    <option value="">-- থানা / উপজেলা সিলেক্ট করুন --</option>
                                </select>
                            </div>

                            <label style="font-size: 0.85rem; color: #64748b; font-weight: 700; margin-bottom: 5px; display: block;">সম্পূর্ণ বিবরণ বা অতিরিক্ত বিস্তারিত ঠিকানা *</label>
                            <input type="text" name="address[]" class="odb-form-control loc-full-address" placeholder="যেমন: বাড়ি #১২, রোড #৪, সাভার, ঢাকা" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Card 2: Category, Status & Remarks -->
            <div class="odb-section-card">
                <div class="odb-section-card-title">
                    <span><i class="fa-solid fa-folder-open"></i> ক্যাটাগরি, স্ট্যাটাস ও বিবরণ</span>
                </div>
                <div class="odb-form-grid-bottom">
                    <div class="odb-form-group full-width">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label style="margin: 0;">ক্যাটাগরি নির্বাচন করুন (একাধিক বেছে নেওয়া যাবে) *</label>
                            <a href="<?= URLROOT ?>/admin/records_categories" target="_blank" style="font-size: 0.82rem; color: #2563eb; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-tags"></i> ক্যাটাগরি ম্যানেজ করুন
                            </a>
                        </div>
                        <?php $categoriesList = $data['categories'] ?? []; ?>
                        <?php if (!empty($categoriesList)): ?>
                            <div class="odb-category-pills-container">
                                <?php foreach ($categoriesList as $cat): 
                                    $catName = htmlspecialchars($cat['name']);
                                ?>
                                    <label class="odb-category-pill">
                                        <input type="checkbox" name="crime_type[]" value="<?= $catName ?>">
                                        <span class="odb-pill-content">
                                            <i class="fa-solid fa-check check-icon" style="display: none; color: #fff;"></i>
                                            <span class="cat-name"><?= $catName ?></span>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <small style="color: #64748b; font-size: 0.82rem; display: block; margin-top: 6px; font-weight: 600;">
                                <i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> প্রযোজ্য ক্যাটাগরিগুলোতে ক্লিক করে সিলেক্ট বা আনসিলেক্ট করুন।
                            </small>
                        <?php else: ?>
                            <input type="text" name="crime_type" class="odb-form-control" placeholder="Financial, Cyber, Public (Comma separated)" required>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="status[]" value="Active">

                    <div class="odb-form-group full-width">
                        <label>ভিডিও লিংক (YouTube / Vimeo / Direct Video URL)</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-video" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #ef4444; font-size: 1rem;"></i>
                            <input type="url" name="video_url" class="odb-form-control" style="padding-left: 42px;" placeholder="যেমন: https://www.youtube.com/watch?v=XXXXXX">
                        </div>
                    </div>

                    <div class="odb-form-group full-width">
                        <label>বিস্তারিত বিবরণী ও মন্তব্য *</label>
                        <textarea name="description[]" class="odb-form-control" required placeholder="রেকর্ডের বিস্তারিত বিবরণ প্রদান করুন..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Section Card 3: Additional Multiple Photos & Gallery -->
            <div class="odb-section-card">
                <div class="odb-section-card-title">
                    <span><i class="fa-solid fa-images"></i> গ্যালারি ও অতিরিক্ত ছবি (Photo Gallery)</span>
                </div>
                <div class="odb-form-group full-width">
                    <div class="gallery-dropzone" onclick="document.getElementById('galleryFileInput').click()" style="border: 2px dashed #93c5fd; background: #ffffff; border-radius: 14px; padding: 2.2rem; text-align: center; cursor: pointer; transition: all 0.25s ease;">
                        <input type="file" id="galleryFileInput" name="additional_photos[]" multiple accept="image/*" style="display: none;" onchange="previewExtraPhotos(this)">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2.3rem; color: #2563eb; margin-bottom: 8px;"></i>
                        <h4 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                            এখানে গ্যালারির ছবি ড্রপ করুন অথবা ব্রাউজ করুন
                        </h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                            একাধিক ছবি ও ডকুমেন্টস একসাথে সিলেক্ট করতে পারবেন (PNG, JPG, WEBP)
                        </p>
                    </div>
                    
                    <div id="extraPhotosPreviewContainer" style="display: flex; flex-wrap: wrap; gap: 14px; margin-top: 20px;"></div>
                </div>
            </div>

            <div style="margin-top: 1.5rem; text-align: right;">
                <button type="submit" class="odb-btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> রেকর্ড সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(input) {
        const dropzone = input.closest('.odb-photo-dropzone');
        if (!dropzone) return;
        let preview = dropzone.querySelector('.odb-photo-preview');
        let icon = dropzone.querySelector('i.fa-cloud-arrow-up');
        let span = dropzone.querySelector('.upload-label');
        let overlay = dropzone.querySelector('.odb-photo-overlay');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                if (icon) icon.style.display = 'none';
                if (span) span.style.display = 'none';
                if (overlay) overlay.style.display = 'flex';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewExtraPhotos(input) {
        const container = document.getElementById('extraPhotosPreviewContainer');
        if (!container) return;
        container.innerHTML = '';

        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = 'position: relative; width: 90px; height: 90px; border-radius: 10px; overflow: hidden; border: 1.5px solid #bfdbfe; box-shadow: 0 4px 10px rgba(0,0,0,0.06); background: #f8fafc;';
                    wrapper.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                    container.appendChild(wrapper);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    const btnAddPersonalCard = document.getElementById('btnAddPersonalCard');
    if (btnAddPersonalCard) {
        let cardCount = 1;
        btnAddPersonalCard.addEventListener('click', function() {
            cardCount++;
            const wrapper = document.getElementById('personalCardsWrapper');
            const firstCard = wrapper.querySelector('.personal-card-block');
            const clone = firstCard.cloneNode(true);

            // Clear inputs inside clone
            clone.querySelectorAll('input[type="text"], input[type="number"], input[type="file"]').forEach(i => i.value = '');
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);

            // Reset photo preview in clone
            clone.querySelectorAll('.odb-photo-preview').forEach(p => { p.src = ''; p.style.display = 'none'; });
            clone.querySelectorAll('i.fa-cloud-arrow-up').forEach(i => i.style.display = 'block');
            clone.querySelectorAll('.upload-label').forEach(s => s.style.display = 'block');
            clone.querySelectorAll('.odb-photo-overlay').forEach(o => o.style.display = 'none');

            // Remove cloned add button if present and set remove button
            const cloneAddBtn = clone.querySelector('#btnAddPersonalCard');
            if (cloneAddBtn) cloneAddBtn.remove();

            const titleEl = clone.querySelector('.odb-section-card-title');
            if (titleEl) {
                titleEl.innerHTML = `
                    <span><i class="fa-solid fa-id-card"></i> ব্যক্তিগত তথ্য ও ছবি #${cardCount}</span>
                    <button type="button" class="odb-btn-remove-entry" onclick="this.closest('.personal-card-block').remove()">
                        <i class="fa-solid fa-trash"></i> মুছে ফেলুন
                    </button>
                `;
            }

            wrapper.appendChild(clone);
        });
    }

    // Location Cascade Logic
    const allLocations = <?= json_encode($data['locations'] ?? []) ?>;

    function filterDistricts(selectEl) {
        const division = selectEl.value;
        const formGroup = selectEl.closest('.odb-form-group');
        const districtSelect = formGroup.querySelector('.loc-district');
        const upazilaSelect = formGroup.querySelector('.loc-upazila');

        districtSelect.innerHTML = `<option value="">-- জেলা সিলেক্ট করুন --</option>`;
        upazilaSelect.innerHTML = `<option value="">-- থানা / উপজেলা সিলেক্ট করুন --</option>`;
        upazilaSelect.disabled = true;

        if (!division) {
            districtSelect.disabled = true;
            return;
        }

        const districts = [...new Set(allLocations.filter(l => l.division === division).map(l => l.district))].sort();
        districts.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d;
            opt.textContent = d;
            districtSelect.appendChild(opt);
        });
        districtSelect.disabled = false;
        updateFullAddress(selectEl);
    }

    function filterUpazilas(selectEl) {
        const formGroup = selectEl.closest('.odb-form-group');
        const division = formGroup.querySelector('.loc-division').value;
        const district = selectEl.value;
        const upazilaSelect = formGroup.querySelector('.loc-upazila');

        upazilaSelect.innerHTML = `<option value="">-- থানা / উপজেলা সিলেক্ট করুন --</option>`;

        if (!district) {
            upazilaSelect.disabled = true;
            return;
        }

        const upazilas = allLocations.filter(l => l.division === division && l.district === district).map(l => l.upazila).sort();
        upazilas.forEach(u => {
            const opt = document.createElement('option');
            opt.value = u;
            opt.textContent = u;
            upazilaSelect.appendChild(opt);
        });
        upazilaSelect.disabled = false;
        updateFullAddress(selectEl);
    }

    function updateFullAddress(selectEl) {
        const formGroup = selectEl.closest('.odb-form-group');
        const div = formGroup.querySelector('.loc-division').value;
        const dist = formGroup.querySelector('.loc-district').value;
        const upaz = formGroup.querySelector('.loc-upazila').value;
        const addressInput = formGroup.querySelector('.loc-full-address');

        const parts = [upaz, dist, div].filter(Boolean);
        if (parts.length > 0) {
            addressInput.value = parts.join(', ');
        }
    }
</script>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
