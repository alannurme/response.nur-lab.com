<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Edit Guest Answer</h1>
        <p>Modify and save changes for the selected guest answer.</p>
    </div>
    <a href="<?= URLROOT ?>/admin/answer_question/<?= $data['answer']['question_id'] ?>" class="btn btn-secondary" style="background: #64748b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Question
    </a>
</div>

<div style="max-width: 800px; margin: 0 auto;">
    <div style="background: white; border-radius: 24px; padding: 35px; box-shadow: 0 15px 35px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;">
        
        <!-- Answer Details Card -->
        <div style="background: #f8fafc; border-left: 4px solid #2563eb; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
            <strong style="color: #1e293b; font-size: 1rem; display: block;">Submitted by: <?= htmlspecialchars($data['answer']['name']) ?> (<?= htmlspecialchars($data['answer']['email']) ?>)</strong>
            <span style="color: #64748b; font-size: 0.85rem;">Date: <?= date('d M Y, h:i A', strtotime($data['answer']['created_at'])) ?></span>
        </div>

        <form action="<?= URLROOT ?>/admin/edit_answer/<?= $data['answer']['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 10px; font-weight: 700; color: #1e293b; font-size: 1.1rem;">Answer Text</label>
                <textarea name="answer" rows="10" class="form-control" style="width: 100%; padding: 15px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 1rem; outline: none; line-height: 1.6; font-family: 'Noto Serif Bengali', serif; resize: vertical;"><?= htmlspecialchars($data['answer']['answer']) ?></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; height: 45px; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; border: none;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="<?= URLROOT ?>/admin/answer_question/<?= $data['answer']['question_id'] ?>" class="btn btn-secondary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 0 20px; background: #cbd5e1; color: #475569; border-radius: 8px; font-weight: 700;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea[name="answer"]',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor blockquote | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 400,
        branding: false,
        promotion: false,
        contextmenu: false,
        content_style: "body { font-family: 'Noto Serif Bengali', serif; font-size: 1.1rem; }",
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
