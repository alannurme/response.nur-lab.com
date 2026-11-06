<?php require APPROOT . '/Views/admin/header.php'; ?>

<?php $book = $book ?? $data['book'] ?? []; ?>

<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-pen-to-square" style="color: #2563eb;"></i> সীরাত গ্রন্থ সম্পাদনা (Edit Book)
        </h1>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.92rem;">
            "<?= htmlspecialchars($book['title'] ?? '') ?>" গ্রন্থের বিবরণ ও গুগল ড্রাইভ লিংক আপডেট করুন
        </p>
    </div>
    <div>
        <a href="<?= URLROOT ?>/admin/seerah_books" class="btn btn-secondary" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; padding: 9px 18px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> সকল গ্রন্থের তালিকা
        </a>
    </div>
</div>

<?php if (isset($_SESSION['seerah_error'])): ?>
    <div style="background: #fdf2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 1.1rem;"></i>
        <span><?= htmlspecialchars($_SESSION['seerah_error']) ?></span>
        <?php unset($_SESSION['seerah_error']); ?>
    </div>
<?php endif; ?>

<div class="admin-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 28px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); max-width: 900px;">
    <form action="<?= URLROOT ?>/admin/edit_seerah_book/<?= $book['id'] ?>" method="POST">
                        <?= csrf_field() ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
            
            <!-- Book Title -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    গ্রন্থের নাম (Book Title) <span style="color:red">*</span>
                </label>
                <input type="text" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" class="form-control" required style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box;">
            </div>

            <!-- Author Name -->
            <div class="form-group">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    লেখক / সংকলক (Author)
                </label>
                <input type="text" name="author" value="<?= htmlspecialchars($book['author'] ?? '') ?>" class="form-control" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box;">
            </div>

            <!-- Theme Color -->
            <div class="form-group">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    থিম রঙ (Theme Color)
                </label>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="color" id="book_color_picker" name="color" value="<?= htmlspecialchars($book['color'] ?? '#10b981') ?>" style="width: 48px; height: 42px; border: 1px solid #cbd5e1; border-radius: 8px; cursor: pointer; padding: 2px;">
                    <div style="display: flex; gap: 6px;">
                        <button type="button" onclick="document.getElementById('book_color_picker').value='#10b981'" style="width: 28px; height: 28px; border-radius: 50%; background: #10b981; border: none; cursor: pointer;" title="Emerald"></button>
                        <button type="button" onclick="document.getElementById('book_color_picker').value='#3b82f6'" style="width: 28px; height: 28px; border-radius: 50%; background: #3b82f6; border: none; cursor: pointer;" title="Blue"></button>
                        <button type="button" onclick="document.getElementById('book_color_picker').value='#f59e0b'" style="width: 28px; height: 28px; border-radius: 50%; background: #f59e0b; border: none; cursor: pointer;" title="Amber"></button>
                        <button type="button" onclick="document.getElementById('book_color_picker').value='#8b5cf6'" style="width: 28px; height: 28px; border-radius: 50%; background: #8b5cf6; border: none; cursor: pointer;" title="Purple"></button>
                        <button type="button" onclick="document.getElementById('book_color_picker').value='#ec4899'" style="width: 28px; height: 28px; border-radius: 50%; background: #ec4899; border: none; cursor: pointer;" title="Pink"></button>
                    </div>
                </div>
            </div>

            <!-- Google Drive PDF Link -->
            <div class="form-group" style="grid-column: 1 / -1; background: #f0fdf4; border: 1.5px dashed #86efac; border-radius: 12px; padding: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="form-label" style="font-weight: 800; color: #166534; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-google-drive" style="color: #10b981; font-size: 1.2rem;"></i> গুগল ড্রাইভ পিডিএফ লিংক (Google Drive PDF Share Link)
                    </label>
                    <button type="button" onclick="testLiveDrivePreview()" style="background: #10b981; color: white; border: none; border-radius: 8px; padding: 5px 12px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-play"></i> প্রিভিউ পরীক্ষা করুন
                    </button>
                </div>
                <input type="text" id="drive_link_input" name="drive_link" value="<?= htmlspecialchars($book['drive_link'] ?? '') ?>" class="form-control" placeholder="https://drive.google.com/file/d/1B7nK7K_XXXXX/view?usp=sharing" style="width: 100%; padding: 11px 14px; border: 1.5px solid #86efac; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box; background: white;">
                
                <div style="font-size: 0.84rem; color: #15803d; margin-top: 8px; line-height: 1.5;">
                    <i class="fas fa-info-circle"></i> <strong>কিভাবে লিংক পাবেন:</strong> গুগল ড্রাইভে পিডিএফ ফাইলটি আপলোড করে <em>Share &rarr; Anyone with the link can view</em> সিলেক্ট করে লিংকটি কপি করে এখানে পেস্ট করুন। সাইটে স্বয়ংক্রিয়ভাবে ইনবিল্ট পিডিএফ ভিউয়ারে এটি প্রদর্শিত হবে।
                </div>

                <!-- Live Embedded Preview Frame Container -->
                <div id="liveDrivePreviewBox" style="display: none; margin-top: 15px; border-radius: 10px; overflow: hidden; border: 1px solid #cbd5e1; height: 350px;">
                    <iframe id="liveDriveFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    গ্রন্থের পরিচিতি ও বিবরণ (Description / Summary)
                </label>
                <textarea name="description" rows="4" class="form-control" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box; font-family: inherit;"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
            </div>

            <!-- Cover Image -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    কভার ছবি (Cover Image - ঐচ্ছিক)
                </label>
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <?php $hasCover = !empty($book['cover_image']); ?>
                    <img id="cover_preview" src="<?= $hasCover ? htmlspecialchars($book['cover_image']) : '' ?>" style="width: 60px; height: 75px; object-fit: cover; border-radius: 8px; display: <?= $hasCover ? 'block' : 'none' ?>; border: 1px solid #ddd;">
                    <div style="flex: 1;">
                        <input type="text" id="cover_image_path" name="cover_image" value="<?= htmlspecialchars($book['cover_image'] ?? '') ?>" class="form-control" readonly placeholder="মিডিয়া লাইব্রেরি থেকে ছবি সিলেক্ট করুন" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box;">
                        <button type="button" class="btn btn-secondary" style="margin-top: 8px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 8px; padding: 7px 14px; font-size: 0.85rem; font-weight: 700; cursor: pointer;" onclick="openMediaPicker('cover_image_path', 'cover_preview')">
                            <i class="fas fa-image"></i> মিডিয়া লাইব্রেরি থেকে ছবি বাছাই করুন
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sort Order -->
            <div class="form-group">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    ক্রম / সিরিয়াল (Sort Order)
                </label>
                <input type="number" name="sort_order" class="form-control" value="<?= htmlspecialchars($book['sort_order'] ?? 0) ?>" min="0" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box;">
                <small style="color: #64748b; margin-top: 4px; display: block;">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন: 1, 2, 3...)</small>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                    স্ট্যাটাস (Status)
                </label>
                <select name="status" class="form-control" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; box-sizing: border-box;">
                    <option value="active" <?= ($book['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>সক্রিয় (Active)</option>
                    <option value="inactive" <?= ($book['status'] ?? 'active') === 'inactive' ? 'selected' : '' ?>>নিষ্ক্রিয় (Inactive)</option>
                </select>
            </div>

        </div>

        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= URLROOT ?>/admin/seerah_books" class="btn" style="background: #f1f5f9; color: #475569; border-radius: 10px; padding: 10px 20px; font-weight: 700; text-decoration: none;">
                বাতিল করুন
            </a>
            <button type="submit" class="btn btn-primary" style="background: #2563eb; border: none; border-radius: 10px; padding: 10px 26px; font-weight: 700; font-size: 1rem; color: white; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                <i class="fas fa-save"></i> পরিবর্তনসমূহ সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>

<script>
    function testLiveDrivePreview() {
        const val = document.getElementById('drive_link_input').value.trim();
        if (!val) {
            alert('অনুগ্রহ করে প্রথমে একটি গুগল ড্রাইভ লিংক প্রদান করুন।');
            return;
        }

        let previewUrl = val;
        const match1 = val.match(/\/d\/([a-zA-Z0-9_-]+)/);
        const match2 = val.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (match1) {
            previewUrl = 'https://drive.google.com/file/d/' + match1[1] + '/preview';
        } else if (match2) {
            previewUrl = 'https://drive.google.com/file/d/' + match2[1] + '/preview';
        }

        const box = document.getElementById('liveDrivePreviewBox');
        const frame = document.getElementById('liveDriveFrame');
        frame.src = previewUrl;
        box.style.display = 'block';
    }

    // Auto-preview on load if link exists
    document.addEventListener("DOMContentLoaded", function() {
        const val = document.getElementById('drive_link_input').value.trim();
        if (val) {
            testLiveDrivePreview();
        }
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

