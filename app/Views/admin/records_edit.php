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
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.8rem;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 1.2rem;
    }

    .odb-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.8rem;
        margin-bottom: 1.8rem;
        position: relative;
    }

    .odb-section-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1.5px solid #e2e8f0;
        padding-bottom: 0.8rem;
    }

    .odb-form-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem 2rem;
        align-items: stretch;
    }

    .odb-fields-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem 1.4rem;
    }

    .odb-form-grid-bottom {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem 1.5rem;
    }

    .odb-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .odb-form-group.full-width {
        grid-column: 1 / -1;
    }

    .odb-form-group label {
        font-size: 0.88rem;
        font-weight: 700;
        color: #334155;
    }

    .odb-form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        background-color: #ffffff;
        color: #0f172a;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .odb-form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background-color: #ffffff;
    }

    /* Photo Upload Box - Tall & matched height */
    .odb-photo-upload-box {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .odb-photo-dropzone {
        border: 2px dashed #94a3b8;
        border-radius: 14px;
        background: #ffffff;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        min-height: 380px;
        height: 100%;
        transition: all 0.2s ease;
        padding: 16px;
        text-align: center;
    }

    .odb-photo-dropzone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .odb-photo-dropzone i.fa-cloud-arrow-up {
        font-size: 3rem;
        color: #64748b;
        margin-bottom: 10px;
    }

    .odb-photo-dropzone span.upload-label {
        font-size: 0.88rem;
        font-weight: 700;
        color: #475569;
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
        object-position: center;
        display: none;
        z-index: 2;
    }

    .odb-photo-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(15, 23, 42, 0.82);
        color: white;
        padding: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
        z-index: 3;
        display: none;
        transition: all 0.2s;
    }

    .odb-category-pills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 12px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        min-height: 52px;
    }

    .odb-category-pill {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        margin: 0;
    }

    .odb-category-pill input {
        display: none;
    }

    .odb-pill-content {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #f1f5f9;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .odb-category-pill input:checked + .odb-pill-content {
        background: #2563eb;
        color: #ffffff;
        border-color: #1d4ed8;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .odb-btn-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 0.85rem 2.2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }
    .odb-btn-submit:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .picker-btn {
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s;
    }
    .picker-btn:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    @media (max-width: 900px) {
        .odb-form-grid { grid-template-columns: 1fr; }
        .odb-form-grid-bottom { grid-template-columns: 1fr; }
        .odb-photo-upload-box { grid-column: 1 / -1; grid-row: auto; min-height: 200px; }
    }
</style>

<?php 
    $r = $data['record'];
    $selectedCategories = !empty($r['crime_type']) ? array_map('trim', explode(',', $r['crime_type'])) : [];
    $existingGallery = !empty($r['gallery']) ? json_decode($r['gallery'], true) : [];
    if (!is_array($existingGallery)) $existingGallery = [];
    $existingVideos = !empty($r['videos']) ? json_decode($r['videos'], true) : [];
    if (!is_array($existingVideos)) $existingVideos = [];
    $existingDocs = !empty($r['documents']) ? json_decode($r['documents'], true) : [];
    if (!is_array($existingDocs)) $existingDocs = [];
?>

<div class="odb-container">
    <a href="<?= URLROOT ?>/admin/records" class="odb-btn-back">
        <i class="fa-solid fa-arrow-left"></i> রেকর্ড লিস্টে ফিরে যান
    </a>

    <div class="odb-form-card">
        <h1 class="odb-form-title">
            <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> রেকর্ড সম্পাদনা করুন (Edit Record #<?= $r['id'] ?>)
        </h1>

        <form action="<?= URLROOT ?>/admin/records_edit/<?= $r['id'] ?>" method="post" enctype="multipart/form-data">
            
            <!-- Person Mode Selector -->
            <?php 
                $selectedPersonId = $r['person_id'] ?? 0;
                $personsList = $data['persons'] ?? []; 
            ?>
            <div class="odb-section-card" style="background: #f0fdf4; border-color: #bbf7d0;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <strong style="color: #166534; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-user-check" style="font-size: 1.2rem;"></i> ব্যক্তি নির্বাচন (Person Selection)
                        </strong>
                        <p style="margin: 4px 0 0 0; font-size: 0.84rem; color: #15803d;">
                            এই রেকর্ডটির সাথে অন্য কোনো সংরক্ষিত ব্যক্তি লিংক করতে চাইলে নির্বাচন করুন।
                        </p>
                    </div>

                    <div style="min-width: 320px; flex-grow: 1; max-width: 480px; position: relative;" id="personDropdownWrapper">
                        <input type="hidden" name="person_id" id="personIdInput" value="<?= $selectedPersonId ?: '' ?>">
                        
                        <div style="position: relative;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #16a34a; font-size: 0.95rem;"></i>
                            <input type="text" id="personSearchInput" class="odb-form-control" autocomplete="off" placeholder="নাম, উপনাম বা ফোন দিয়ে ব্যক্তি খুঁজুন বা পরিবর্তন করুন..." style="padding-left: 38px; padding-right: 36px; border-color: #86efac; font-weight: 600; background: #fff;" onclick="togglePersonDropdown(true)" oninput="filterPersonDropdown()">
                            <button type="button" id="clearPersonBtn" onclick="clearSelectedPerson()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; font-size: 1rem; cursor: pointer; display: none;">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>

                        <div id="personDropdownList" style="display: none; position: absolute; top: calc(100% + 5px); left: 0; right: 0; max-height: 280px; overflow-y: auto; background: #ffffff; border: 1.5px solid #86efac; border-radius: 12px; box-shadow: 0 12px 28px rgba(0,0,0,0.12); z-index: 100;">
                            <div class="person-dropdown-item" onclick="selectPersonItem('', 'কোনো ব্যক্তির সাথে লিংক নেই', null)" style="padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px; transition: background 0.15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='white'">
                                <div style="width: 34px; height: 34px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-link-slash"></i>
                                </div>
                                <div>
                                    <strong style="font-size: 0.88rem; color: #0f172a; display: block;">-- কোনো ব্যক্তির সাথে লিংক নেই --</strong>
                                    <span style="font-size: 0.75rem; color: #64748b;">লিংক আনলিঙ্ক করুন</span>
                                </div>
                            </div>

                            <?php foreach ($personsList as $per): ?>
                                <div class="person-dropdown-item" 
                                    data-id="<?= $per['id'] ?>"
                                    data-name="<?= htmlspecialchars($per['name'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-search="<?= htmlspecialchars(strtolower($per['name'] . ' ' . ($per['alias'] ?? '') . ' ' . ($per['phone'] ?? '') . ' ' . ($per['nid_passport'] ?? '')), ENT_QUOTES, 'UTF-8') ?>"
                                    data-person='<?= htmlspecialchars(json_encode($per), ENT_QUOTES, 'UTF-8') ?>'
                                    onclick="selectPersonItem(<?= $per['id'] ?>, '<?= htmlspecialchars(addslashes($per['name']), ENT_QUOTES, 'UTF-8') ?>', this)"
                                    style="padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; transition: background 0.15s;" 
                                    onmouseover="this.style.background='#f0fdf4'" 
                                    onmouseout="this.style.background='white'">
                                    
                                    <div style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; background: #f1f5f9; flex-shrink: 0; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                        <?php if (!empty($per['photo'])): ?>
                                            <img src="<?= htmlspecialchars($per['photo']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fa-solid fa-user" style="color: #94a3b8; font-size: 0.85rem;"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div style="flex-grow: 1;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <strong style="font-size: 0.9rem; color: #0f172a;"><?= htmlspecialchars($per['name']) ?></strong>
                                            <?php if (!empty($per['alias'])): ?>
                                                <span style="font-size: 0.78rem; color: #64748b;">(<?= htmlspecialchars($per['alias']) ?>)</span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 2px;">
                                            <?= !empty($per['phone']) ? htmlspecialchars($per['phone']) : 'NID: ' . htmlspecialchars($per['nid_passport'] ?? 'N/A') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Person Information Block -->
            <div class="odb-section-card">
                <div class="odb-section-card-title">
                    <span><i class="fa-solid fa-id-card"></i> ব্যক্তির তথ্য ও ছবি (Person Profile)</span>
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <label style="display: inline-flex; align-items: center; gap: 6px; margin: 0; font-size: 0.85rem; color: #854d0e; font-weight: 700; cursor: pointer; background: #fefce8; padding: 5px 12px; border-radius: 20px; border: 1px solid #fde047;">
                            <input type="checkbox" id="isMostWantedCheckbox" name="is_most_wanted" value="1" <?= !empty($r['is_most_wanted']) ? 'checked' : '' ?> style="accent-color: #f59e0b; cursor: pointer;">
                            ★ বিশেষ এন্ট্রি
                        </label>
                    </div>
                </div>

                <div class="odb-form-grid">
                    <!-- Left: Form inputs column -->
                    <div class="odb-fields-column">
                        <!-- Row 1: Full Name, Alias -->
                        <div class="odb-form-group">
                            <label>পূর্ণ নাম *</label>
                            <input type="text" name="name" id="personName" value="<?= htmlspecialchars($r['name']) ?>" class="odb-form-control" placeholder="যেমন: কায়সার আহমেদ" required>
                        </div>

                        <div class="odb-form-group">
                            <label>উপনাম (Alias)</label>
                            <input type="text" name="alias" id="personAlias" value="<?= htmlspecialchars($r['alias'] ?? '') ?>" class="odb-form-control" placeholder="যেমন: কালা কায়সার">
                        </div>

                        <!-- Row 2: NID/Passport, Gender -->
                        <div class="odb-form-group">
                            <label>এনআইডি / পাসপোর্ট নম্বর</label>
                            <input type="text" name="nid_passport" id="personNid" value="<?= htmlspecialchars($r['nid_passport'] ?? '') ?>" class="odb-form-control" placeholder="1992269123450001">
                        </div>

                        <div class="odb-form-group">
                            <label>লিঙ্গ</label>
                            <select name="gender" id="personGender" class="odb-form-control">
                                <option value="Male" <?= ($r['gender'] == 'Male') ? 'selected' : '' ?>>পুরুষ</option>
                                <option value="Female" <?= ($r['gender'] == 'Female') ? 'selected' : '' ?>>নারী</option>
                                <option value="Other" <?= ($r['gender'] == 'Other') ? 'selected' : '' ?>>অন্যান্য</option>
                            </select>
                        </div>

                        <!-- Row 3: Age, Height -->
                        <div class="odb-form-group">
                            <label>বয়স</label>
                            <input type="number" name="age" id="personAge" value="<?= htmlspecialchars($r['age'] ?? '') ?>" class="odb-form-control" placeholder="34">
                        </div>

                        <div class="odb-form-group">
                            <label>উচ্চতা (সেমি)</label>
                            <input type="number" name="height_cm" id="personHeight" value="<?= htmlspecialchars($r['height_cm'] ?? '') ?>" class="odb-form-control" placeholder="175">
                        </div>

                        <!-- Row 4: Phone, Social Media Link -->
                        <div class="odb-form-group">
                            <label>ফোন / মোবাইল নম্বর</label>
                            <input type="text" name="phone" id="personPhone" value="<?= htmlspecialchars($r['phone'] ?? '') ?>" class="odb-form-control" placeholder="+880 1700-000000">
                        </div>

                        <div class="odb-form-group">
                            <label>সোশ্যাল মিডিয়া প্রোফাইল লিংক</label>
                            <input type="url" name="social_media" id="personSocial" value="<?= htmlspecialchars($r['social_media'] ?? '') ?>" class="odb-form-control" placeholder="https://facebook.com/username">
                        </div>

                        <!-- Row 5: Structured Location Selectors & Address -->
                        <div class="odb-form-group full-width">
                            <label>সম্পূর্ণ ঠিকানা</label>
                            <input type="text" name="address" id="personAddress" value="<?= htmlspecialchars($r['address'] ?? '') ?>" class="odb-form-control loc-full-address" placeholder="যেমন: বাড়ি #১২, রোড #৪, সাভার, ঢাকা">
                        </div>
                    </div>

                    <!-- Right: Large Image Upload Box matching entire section height -->
                    <div class="odb-photo-upload-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label style="margin: 0; font-size: 0.95rem; font-weight: 700;">প্রোফাইল ছবি</label>
                            <button type="button" class="picker-btn" onclick="openMediaModalForPhoto()" style="padding: 4px 10px; font-size: 0.78rem;">
                                <i class="fa-brands fa-google-drive"></i> ড্রাইভ থেকে নিন
                            </button>
                        </div>
                        <input type="hidden" name="selected_drive_photo" id="selectedDrivePhoto" value="<?= htmlspecialchars($r['photo'] ?? '') ?>">
                        
                        <div class="odb-photo-dropzone" id="photoDropzoneBox">
                            <i class="fa-solid fa-cloud-arrow-up" <?= !empty($r['photo']) ? 'style="display:none;"' : '' ?>></i>
                            <span class="upload-label" style="font-size: 0.95rem; <?= !empty($r['photo']) ? 'display:none;' : '' ?>">কম্পিউটার থেকে ছবি ড্রপ বা ব্রাউজ করুন</span>
                            
                            <input type="file" name="photo" id="photoFileInput" class="odb-photo-file-input" accept="image/*" onchange="previewPhoto(this)">
                            <img class="odb-photo-preview" id="photoPreviewImg" src="<?= htmlspecialchars($r['photo'] ?? '') ?>" alt="Preview" <?= !empty($r['photo']) ? 'style="display:block;"' : '' ?>>
                            <div class="odb-photo-overlay" id="photoOverlayText" <?= !empty($r['photo']) ? 'style="display:block;"' : '' ?>>
                                <i class="fa-solid fa-camera" style="margin-right: 5px;"></i> ছবি পরিবর্তন করুন
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Card 2: Interactive Media & Details Bento Grid -->
            <div style="margin-bottom: 25px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                    <i class="fa-solid fa-layer-group" style="color: #2563eb; font-size: 1.25rem;"></i>
                    <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a; font-family: 'Tiro Bangla', sans-serif;">ক্যাটাগরি, মিডিয়া ও রেকর্ডের বিবরণ</h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                    
                    <!-- Card 1: Category Selector Card -->
                    <div style="background: white; border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                                    <i class="fa-solid fa-tags"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.98rem; font-weight: 800; color: #0f172a;">ক্যাটাগরি নির্বাচন</h4>
                                    <span style="font-size: 0.78rem; color: #64748b;">প্রযোজ্য ট্যাগসমূহ বেছে নিন</span>
                                </div>
                            </div>
                            <a href="<?= URLROOT ?>/admin/records_categories" target="_blank" style="font-size: 0.8rem; color: #2563eb; text-decoration: none; font-weight: 700; background: #f0fdf4; padding: 4px 10px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                <i class="fa-solid fa-cog"></i> ম্যানেজ
                            </a>
                        </div>
                        
                        <div style="flex-grow: 1;">
                            <?php $categoriesList = $data['categories'] ?? []; ?>
                            <?php if (!empty($categoriesList)): ?>
                                <div class="odb-category-pills-container" style="max-height: 140px; overflow-y: auto; padding: 4px;">
                                    <?php foreach ($categoriesList as $cat): 
                                        $catName = htmlspecialchars($cat['name']);
                                        $checked = in_array($cat['name'], $selectedCategories);
                                    ?>
                                        <label class="odb-category-pill">
                                            <input type="checkbox" name="crime_type[]" value="<?= $catName ?>" <?= $checked ? 'checked' : '' ?>>
                                            <span class="odb-pill-content">
                                                <i class="fa-solid fa-check check-icon" style="<?= $checked ? '' : 'display: none;' ?> color: #fff;"></i>
                                                <span class="cat-name"><?= $catName ?></span>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <input type="text" name="crime_type" value="<?= htmlspecialchars($r['crime_type'] ?? '') ?>" class="odb-form-control" placeholder="যেমন: Financial, Cyber..." style="border-radius: 10px; padding: 10px 14px; border: 1.5px solid #cbd5e1; width: 100%; box-sizing: border-box;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Card 2: Video Files & Links Card -->
                    <div style="background: white; border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                                    <i class="fa-solid fa-video"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.98rem; font-weight: 800; color: #0f172a;">ভিডিও প্রমাণাদি</h4>
                                    <span style="font-size: 0.78rem; color: #64748b;">ড্রাইভ ক্লাউডে সংরক্ষণ</span>
                                </div>
                            </div>
                            <button type="button" class="picker-btn" onclick="openMediaModalForVideos()" style="padding: 5px 12px; font-size: 0.8rem; background: #f0fdf4; color: #166534; border: 1px solid #86efac; border-radius: 8px; font-weight: 700; cursor: pointer;">
                                <i class="fa-brands fa-google-drive"></i> ড্রাইভ ভিডিও
                            </button>
                        </div>

                        <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 10px;">
                            <label style="border: 2px dashed #fca5a5; border-radius: 12px; padding: 12px; background: #fff5f5; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: 0.2s;">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 1.5rem; color: #ef4444;"></i>
                                <div style="flex-grow: 1;">
                                    <div style="font-weight: 700; font-size: 0.85rem; color: #991b1b;">কম্পিউটার থেকে ভিডিও যোগ</div>
                                    <span style="font-size: 0.75rem; color: #b91c1c;">নতুন ফাইল ড্রপ বা ব্রাউজ করুন</span>
                                </div>
                                <input type="file" name="video_files[]" accept="video/*" multiple style="display: none;" onchange="this.parentElement.querySelector('span').textContent = this.files.length + ' টি ভিডিও সিলেক্ট হয়েছে'">
                            </label>

                            <div style="position: relative;">
                                <i class="fa-solid fa-link" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                                <input type="url" name="video_url" value="<?= htmlspecialchars($r['video_url'] ?? '') ?>" class="odb-form-control" style="padding-left: 36px; font-size: 0.85rem; border-radius: 10px; border: 1.5px solid #cbd5e1; width: 100%; box-sizing: border-box;" placeholder="অথবা YouTube / অনলাইন ভিডিও লিংক...">
                            </div>
                            <div id="selectedDriveVideosContainer" style="display: flex; flex-direction: column; gap: 6px;"></div>
                            <input type="hidden" name="selected_drive_videos" id="selectedDriveVideosInput" value="[]">
                        </div>
                    </div>

                    <!-- Card 3: Documents Card -->
                    <div style="background: white; border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #e0e7ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                                    <i class="fa-solid fa-file-shield"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.98rem; font-weight: 800; color: #0f172a;">নথি ও অন্যান্য ফাইল</h4>
                                    <span style="font-size: 0.78rem; color: #64748b;">PDF, Word, Zip, Audio</span>
                                </div>
                            </div>
                            <button type="button" class="picker-btn" onclick="openMediaModalForDocs()" style="padding: 5px 12px; font-size: 0.8rem; background: #f0fdf4; color: #166534; border: 1px solid #86efac; border-radius: 8px; font-weight: 700; cursor: pointer;">
                                <i class="fa-brands fa-google-drive"></i> ড্রাইভ ফাইল
                            </button>
                        </div>

                        <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 10px;">
                            <label style="border: 2px dashed #c7d2fe; border-radius: 12px; padding: 12px; background: #f5f7ff; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: 0.2s;">
                                <i class="fa-solid fa-file-arrow-up" style="font-size: 1.5rem; color: #4f46e5;"></i>
                                <div style="flex-grow: 1;">
                                    <div style="font-weight: 700; font-size: 0.85rem; color: #3730a3;">ডকুমেন্ট ও ফাইল আপলোড</div>
                                    <span style="font-size: 0.75rem; color: #4338ca;">PDF, Zip, Docx সিলেক্ট করুন</span>
                                </div>
                                <input type="file" name="document_files[]" accept=".pdf,.doc,.docx,.zip,.rar,.tar,.mp3,.wav,.ogg,.txt,.csv" multiple style="display: none;" onchange="this.parentElement.querySelector('span').textContent = this.files.length + ' টি ফাইল সিলেক্ট হয়েছে'">
                            </label>

                            <div id="selectedDriveDocsContainer" style="display: flex; flex-direction: column; gap: 6px;"></div>
                            <input type="hidden" name="selected_drive_documents" id="selectedDriveDocsInput" value="[]">
                        </div>
                    </div>
                </div>

                <!-- Card 4: Description & Remarks -->
                <div style="background: white; border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 22px; margin-top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; color: #334155; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                            <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 0.98rem; font-weight: 800; color: #0f172a;">রেকর্ডের বিবরণ ও পর্যবেক্ষণ</h4>
                            <span style="font-size: 0.78rem; color: #64748b;">ঘটনা বা অপরাধের প্রেক্ষাপট নোট</span>
                        </div>
                    </div>
                    <textarea name="description" class="odb-form-control" rows="3" placeholder="রেকর্ডের বিস্তারিত বিবরণ, ঘটনা বা নোট এখানে লিখুন..." style="border-radius: 12px; border: 1.5px solid #cbd5e1; width: 100%; padding: 12px 16px; font-size: 0.92rem; box-sizing: border-box; line-height: 1.5;"><?= htmlspecialchars($r['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Section Card 3: Additional Photos & Gallery -->
            <div class="odb-section-card">
                <div class="odb-section-card-title">
                    <span><i class="fa-solid fa-images"></i> গ্যালারি ও অতিরিক্ত ছবি (Photo Gallery)</span>
                    <button type="button" class="picker-btn" onclick="openMediaModalForGallery()">
                        <i class="fa-brands fa-google-drive"></i> গুগল ড্রাইভ থেকে ছবি যুক্ত করুন
                    </button>
                </div>
                <div class="odb-form-group full-width">
                    <div class="gallery-dropzone" onclick="document.getElementById('galleryFileInput').click()" style="border: 2px dashed #93c5fd; background: #ffffff; border-radius: 14px; padding: 1.8rem; text-align: center; cursor: pointer; transition: all 0.25s ease;">
                        <input type="file" id="galleryFileInput" name="additional_photos[]" multiple accept="image/*" style="display: none;" onchange="previewExtraPhotos(this)">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2.2rem; color: #2563eb; margin-bottom: 6px;"></i>
                        <h4 style="font-size: 0.98rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                            কম্পিউটার থেকে ছবি ড্রপ করুন বা ব্রাউজ করুন
                        </h4>
                    </div>
                    
                    <div id="extraPhotosPreviewContainer" style="display: flex; flex-wrap: wrap; gap: 14px; margin-top: 16px;"></div>
                    <input type="hidden" name="selected_drive_gallery" id="selectedDriveGalleryInput" value="[]">
                </div>
            </div>

            <div style="margin-top: 1.5rem; text-align: right;">
                <button type="submit" class="odb-btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> পরিবর্তন সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reusable Media / Google Drive Picker Modal -->
<div id="mediaModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 100%; max-width: 850px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <div style="padding: 16px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="fa-brands fa-google-drive"></i>
                </div>
                <div>
                    <h3 style="font-weight: 700; color: #1e293b; margin: 0; font-size: 1.05rem;" id="mediaModalTitle">
                        ফাইল নির্বাচন করুন (Google Drive / Media Library)
                    </h3>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <select id="modalStorageFilter" onchange="loadMediaLibrary()" style="padding: 6px 12px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 0.82rem; font-weight: 600;">
                    <option value="all">সকল ফাইল (ড্রাইভ + লোকাল)</option>
                    <option value="google_drive" selected>শুধু গুগল ড্রাইভ</option>
                    <option value="local">শুধু লোকাল স্টোরেজ</option>
                </select>
                <button type="button" onclick="closeMediaModal()" style="background: none; border: none; font-size: 1.4rem; color: #64748b; cursor: pointer; padding: 4px;"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div style="padding: 20px; overflow-y: auto; flex: 1; min-height: 320px;">
            <div id="mediaLoading" style="text-align: center; padding: 50px 0; color: #64748b;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2.2rem; color: #2563eb; margin-bottom: 12px;"></i>
                <p style="margin: 0; font-weight: 600;">ফাইল লোড হচ্ছে...</p>
            </div>
            <div id="mediaGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(135px, 1fr)); gap: 14px;"></div>
        </div>
    </div>
</div>

<script>
    // Searchable Person Dropdown Logic for Edit Page
    function togglePersonDropdown(show) {
        const list = document.getElementById('personDropdownList');
        if (show) {
            list.style.display = 'block';
            filterPersonDropdown();
        } else {
            setTimeout(() => { list.style.display = 'none'; }, 200);
        }
    }

    function filterPersonDropdown() {
        const term = document.getElementById('personSearchInput').value.toLowerCase().trim();
        const items = document.querySelectorAll('#personDropdownList .person-dropdown-item');
        const clearBtn = document.getElementById('clearPersonBtn');
        
        clearBtn.style.display = term ? 'block' : 'none';

        items.forEach(item => {
            const searchData = item.getAttribute('data-search') || '';
            if (!term || searchData.includes(term) || item.innerText.toLowerCase().includes(term)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        document.getElementById('personDropdownList').style.display = 'block';
    }

    function selectPersonItem(id, name, el) {
        document.getElementById('personIdInput').value = id || '';
        document.getElementById('personSearchInput').value = id ? name : '';
        document.getElementById('personDropdownList').style.display = 'none';
        document.getElementById('clearPersonBtn').style.display = id ? 'block' : 'none';

        if (!id || !el) return;

        const personData = el.getAttribute('data-person');
        if (personData) {
            try {
                const p = JSON.parse(personData);
                document.getElementById('personName').value = p.name || '';
                document.getElementById('personAlias').value = p.alias || '';
                document.getElementById('personNid').value = p.nid_passport || '';
                document.getElementById('personPhone').value = p.phone || '';
                document.getElementById('personAge').value = p.age || '';
                document.getElementById('personHeight').value = p.height_cm || '';
                document.getElementById('personSocial').value = p.social_media || '';
                document.getElementById('personAddress').value = p.address || '';
                if (p.gender) document.getElementById('personGender').value = p.gender;
                document.getElementById('isMostWantedCheckbox').checked = (p.is_most_wanted == 1);

                if (p.photo) {
                    document.getElementById('selectedDrivePhoto').value = p.photo;
                    const prev = document.getElementById('photoPreviewImg');
                    prev.src = p.photo;
                    prev.style.display = 'block';
                    document.getElementById('photoOverlayText').style.display = 'block';
                }
            } catch (e) {
                console.error(e);
            }
        }
    }

    function clearSelectedPerson() {
        document.getElementById('personIdInput').value = '';
        document.getElementById('personSearchInput').value = '';
        document.getElementById('clearPersonBtn').style.display = 'none';
        document.getElementById('personDropdownList').style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('personDropdownWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('personDropdownList').style.display = 'none';
        }
    });

    // Initial pre-loaded media
    let selectedDriveGallery = <?= json_encode($existingGallery) ?>;
    let selectedDriveVideos = <?= json_encode($existingVideos) ?>;
    let selectedDriveDocs = <?= json_encode($existingDocs) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        renderGalleryPreview();
        renderDriveVideosList();
        renderDriveDocsList();

        // Pre-populate person search text if assigned
        const preId = document.getElementById('personIdInput').value;
        if (preId) {
            const targetItem = document.querySelector(`.person-dropdown-item[data-id="${preId}"]`);
            if (targetItem) {
                const name = targetItem.getAttribute('data-name');
                document.getElementById('personSearchInput').value = name;
                document.getElementById('clearPersonBtn').style.display = 'block';
            }
        }
    });

    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const prev = document.getElementById('photoPreviewImg');
                prev.src = e.target.result;
                prev.style.display = 'block';
                document.getElementById('photoOverlayText').style.display = 'block';
                document.getElementById('selectedDrivePhoto').value = '';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewExtraPhotos(input) {
        renderGalleryPreview();
    }

    function renderGalleryPreview() {
        const container = document.getElementById('extraPhotosPreviewContainer');
        if (!container) return;
        container.innerHTML = '';

        selectedDriveGallery.forEach((url, idx) => {
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'position: relative; width: 90px; height: 90px; border-radius: 10px; overflow: hidden; border: 1.5px solid #2563eb; box-shadow: 0 4px 10px rgba(0,0,0,0.06); background: #f8fafc;';
            wrapper.innerHTML = `
                <img src="${url}" style="width:100%; height:100%; object-fit:cover;">
                <button type="button" onclick="removeDriveGalleryItem(${idx})" style="position: absolute; top: 4px; right: 4px; background: rgba(239,68,68,0.9); color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(wrapper);
        });

        const input = document.getElementById('galleryFileInput');
        if (input && input.files) {
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
        document.getElementById('selectedDriveGalleryInput').value = JSON.stringify(selectedDriveGallery);
    }

    function removeDriveGalleryItem(idx) {
        selectedDriveGallery.splice(idx, 1);
        renderGalleryPreview();
    }

    let modalTargetType = null;

    function openMediaModalForPhoto() {
        modalTargetType = 'photo';
        openMediaModal();
    }
    function openMediaModalForGallery() {
        modalTargetType = 'gallery';
        openMediaModal();
    }
    function openMediaModalForVideos() {
        modalTargetType = 'video';
        openMediaModal();
    }
    function openMediaModalForDocs() {
        modalTargetType = 'document';
        openMediaModal();
    }

    function openMediaModal() {
        document.getElementById('mediaModal').style.display = 'flex';
        loadMediaLibrary();
    }

    function closeMediaModal() {
        document.getElementById('mediaModal').style.display = 'none';
        modalTargetType = null;
    }

    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('mediaModal')) closeMediaModal();
    });

    function loadMediaLibrary() {
        const grid = document.getElementById('mediaGrid');
        const loading = document.getElementById('mediaLoading');
        const storage = document.getElementById('modalStorageFilter').value;

        grid.innerHTML = '';
        loading.style.display = 'block';

        fetch('<?= URLROOT ?>/admin/api_media?storage=' + encodeURIComponent(storage))
            .then(res => res.json())
            .then(data => {
                loading.style.display = 'none';
                if (!Array.isArray(data) || data.length === 0) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #64748b; padding: 40px 0;">কোনো ফাইল পাওয়া যায়নি।</p>';
                    return;
                }

                data.forEach(file => {
                    const card = document.createElement('div');
                    card.style.cssText = 'border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; cursor: pointer; transition: 0.2s; background: #ffffff; position: relative; display: flex; flex-direction: column;';
                    
                    const isGdrive = (file.storage === 'google_drive');
                    const badgeHtml = isGdrive 
                        ? `<span style="position: absolute; top: 6px; left: 6px; background: rgba(37,99,235,0.9); color: #fff; padding: 2px 6px; border-radius: 6px; font-size: 10px; font-weight: 700; z-index: 2;"><i class="fa-brands fa-google-drive"></i> GDrive</span>`
                        : `<span style="position: absolute; top: 6px; left: 6px; background: rgba(100,116,139,0.9); color: #fff; padding: 2px 6px; border-radius: 6px; font-size: 10px; font-weight: 700; z-index: 2;"><i class="fas fa-server"></i> Local</span>`;

                    let previewHtml = '';
                    const isImg = file.url.match(/\.(jpeg|jpg|gif|png|webp)($|\?)/i) || isGdrive;
                    if (isImg) {
                        previewHtml = `<img src="${file.url}" style="width: 100%; height: 95px; object-fit: cover;" loading="lazy">`;
                    } else {
                        previewHtml = `<div style="width: 100%; height: 95px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #64748b; font-size: 2rem;"><i class="fas fa-file"></i></div>`;
                    }

                    card.innerHTML = `
                        ${badgeHtml}
                        <div style="height: 95px; position: relative; background: #f8fafc; overflow: hidden;">${previewHtml}</div>
                        <div style="padding: 8px 10px; font-size: 0.76rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${file.name}">
                            ${file.name}
                        </div>
                    `;

                    card.addEventListener('click', () => {
                        handleFileSelection(file);
                        closeMediaModal();
                    });

                    grid.appendChild(card);
                });
            });
    }

    function handleFileSelection(file) {
        if (modalTargetType === 'photo') {
            document.getElementById('selectedDrivePhoto').value = file.url;
            const prev = document.getElementById('photoPreviewImg');
            prev.src = file.url;
            prev.style.display = 'block';
            document.getElementById('photoOverlayText').style.display = 'block';
        } else if (modalTargetType === 'gallery') {
            if (!selectedDriveGallery.includes(file.url)) {
                selectedDriveGallery.push(file.url);
                renderGalleryPreview();
            }
        } else if (modalTargetType === 'video') {
            selectedDriveVideos.push({ name: file.name, url: file.url });
            renderDriveVideosList();
        } else if (modalTargetType === 'document') {
            selectedDriveDocs.push({ name: file.name, url: file.url });
            renderDriveDocsList();
        }
    }

    function renderDriveVideosList() {
        const container = document.getElementById('selectedDriveVideosContainer');
        container.innerHTML = '';
        selectedDriveVideos.forEach((v, idx) => {
            const item = document.createElement('div');
            item.style.cssText = 'background: #fff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px 12px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;';
            item.innerHTML = `
                <div style="display: flex; align-items: center; gap: 8px; overflow: hidden;">
                    <i class="fa-brands fa-google-drive" style="color: #2563eb;"></i>
                    <span style="font-weight: 600; color: #0f172a; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">${v.name}</span>
                </div>
                <button type="button" onclick="removeDriveVideo(${idx})" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px;"><i class="fas fa-trash"></i></button>
            `;
            container.appendChild(item);
        });
        document.getElementById('selectedDriveVideosInput').value = JSON.stringify(selectedDriveVideos);
    }

    function removeDriveVideo(idx) {
        selectedDriveVideos.splice(idx, 1);
        renderDriveVideosList();
    }

    function renderDriveDocsList() {
        const container = document.getElementById('selectedDriveDocsContainer');
        container.innerHTML = '';
        selectedDriveDocs.forEach((d, idx) => {
            const item = document.createElement('div');
            item.style.cssText = 'background: #fff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px 12px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;';
            item.innerHTML = `
                <div style="display: flex; align-items: center; gap: 8px; overflow: hidden;">
                    <i class="fa-solid fa-file-shield" style="color: #4f46e5;"></i>
                    <span style="font-weight: 600; color: #0f172a; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">${d.name}</span>
                </div>
                <button type="button" onclick="removeDriveDoc(${idx})" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px;"><i class="fas fa-trash"></i></button>
            `;
            container.appendChild(item);
        });
        document.getElementById('selectedDriveDocsInput').value = JSON.stringify(selectedDriveDocs);
    }

    function removeDriveDoc(idx) {
        selectedDriveDocs.splice(idx, 1);
        renderDriveDocsList();
    }
</script>

</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>


</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
