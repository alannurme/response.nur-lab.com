<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">Answer & Moderate Question</h1>
        <p>Review user question, write official answers, and moderate guest responses.</p>
    </div>
    <a href="<?= URLROOT ?>/admin/questions" class="btn btn-secondary" style="background: #64748b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
        <?php
        if ($_GET['msg'] === 'approved') echo 'Guest answer approved successfully and notification sent to asker!';
        if ($_GET['msg'] === 'updated') echo 'Guest answer updated successfully!';
        if ($_GET['msg'] === 'deleted') echo 'Guest answer deleted successfully!';
        ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px;">
    <!-- Left Column: Official Answer and Details -->
    <div>
        <div style="background: white; border-radius: 24px; padding: 35px; box-shadow: 0 15px 35px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; margin-bottom: 30px;">
            <!-- Question Details Card -->
            <div style="background: #f8fafc; border-left: 4px solid #2563eb; padding: 25px; border-radius: 12px; margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <div>
                        <strong style="color: #1e293b; font-size: 1.1rem; display: block;"><?= htmlspecialchars($data['question']['name']) ?></strong>
                        <span style="color: #64748b; font-size: 0.9rem;"><?= htmlspecialchars($data['question']['email']) ?></span>
                    </div>
                    <span style="color: #94a3b8; font-size: 0.85rem;"><?= date('d M Y, h:i A', strtotime($data['question']['created_at'])) ?></span>
                </div>
                <div style="color: #334155; font-size: 1.1rem; line-height: 1.6; font-weight: 600;">
                    <?= nl2br(htmlspecialchars($data['question']['question'])) ?>
                </div>
            </div>

            <!-- Answer Form -->
            <form action="<?= URLROOT ?>/admin/answer_question/<?= $data['question']['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 10px; font-weight: 700; color: #1e293b; font-size: 1.1rem;">Official Answer *</label>
                    <textarea name="answer" rows="12" class="form-control" placeholder="উত্তরটি বিস্তারিত লিখুন..." style="width: 100%; padding: 15px; border: 1.5px solid #cbd5e1; border-radius: 12px; font-size: 1rem; outline: none; line-height: 1.6; font-family: 'Noto Sans Bengali', sans-serif; resize: vertical;"><?= htmlspecialchars($data['question']['answer'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="height: 50px; border-radius: 12px; font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; border: none; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);">
                    <i class="fas fa-paper-plane"></i> Save Answer & Notify User
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Guest Answers Moderation -->
    <div>
        <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-users" style="color: #2563eb;"></i> Guest Answers Moderation
            </h3>

            <?php if (!empty($data['answers'])): ?>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php foreach ($data['answers'] as $ans): ?>
                        <div style="border: 1px solid #e2e8f0; border-radius: 15px; padding: 20px; background: #f8fafc; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                <div>
                                    <strong style="display: block; color: var(--text-main); font-size: 0.95rem;"><?= htmlspecialchars($ans['name']) ?></strong>
                                    <span style="color: var(--text-muted); font-size: 0.8rem;"><?= htmlspecialchars($ans['email']) ?></span>
                                </div>
                                <div>
                                    <?php if ($ans['status'] === 'approved'): ?>
                                        <span style="background: #dcfce7; color: #15803d; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 50px;">Approved</span>
                                    <?php else: ?>
                                        <span style="background: #fef3c7; color: #d97706; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 50px;">Pending</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div style="color: #475569; font-size: 0.95rem; line-height: 1.6; margin-bottom: 15px; font-family: 'Noto Serif Bengali', serif;">
                                <?php 
                                    if ($ans['answer'] === strip_tags($ans['answer'])) {
                                        echo nl2br(htmlspecialchars($ans['answer']));
                                    } else {
                                        echo htmlspecialchars_decode($ans['answer']);
                                    }
                                ?>
                            </div>

                            <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid #e2e8f0; padding-top: 12px;">
                                <?php if ($ans['status'] === 'pending'): ?>
                                    <a href="<?= URLROOT ?>/admin/approve_answer/<?= $ans['id'] ?>" class="btn btn-success" style="background: #16a34a; color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                <?php endif; ?>
                                <a href="<?= URLROOT ?>/admin/edit_answer/<?= $ans['id'] ?>" class="btn btn-primary" style="background: #2563eb; color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= URLROOT ?>/admin/delete_answer/<?= $ans['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this answer?')" style="background: #dc2626; color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; color: var(--text-muted); padding: 40px 10px; font-style: italic;">
                    No guest answers submitted yet.
                </div>
            <?php endif; ?>
        </div>
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
        contextmenu: false
    });
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
