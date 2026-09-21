<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 class="text-premium-glow">User Questions</h1>
        <p>Manage, answer, and moderate religious and general questions submitted by users.</p>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'answered'): ?>
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #2563eb; font-size: 18px;"></i>
        প্রশ্নের উত্তরটি সফলভাবে সংরক্ষিত হয়েছে এবং ব্যবহারকারীকে ইমেইলে জানানো হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        প্রশ্নটি সফলভাবে ডিলিট করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'approved'): ?>
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #16a34a; font-size: 18px;"></i>
        গেস্ট উত্তরটি সফলভাবে অ্যাপ্রুভ করা হয়েছে এবং ব্যবহারকারীকে ইমেইলে জানানো হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="color: #2563eb; font-size: 18px;"></i>
        গেস্ট উত্তরটি সফলভাবে আপডেট করা হয়েছে!
    </div>
    <?php elseif ($_GET['msg'] === 'ans_deleted'): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 18px;"></i>
        গেস্ট উত্তরটি সফলভাবে ডিলিট করা হয়েছে!
    </div>
    <?php endif; ?>
<?php endif; ?>

<form action="<?= URLROOT ?>/admin/bulk_questions" method="POST" id="bulk-questions-form">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; width: fit-content;">
        <select name="action" id="bulk-questions-select" class="form-control" style="width: auto; padding: 8px 15px; border-radius: 8px; border: 1.5px solid #eee; background: #fff; color: var(--text-main); font-weight: 600; outline: none; transition: 0.3s;">
            <option value="">Bulk Actions</option>
            <option value="approve">Approve Selected</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-check"></i> Apply
        </button>
    </div>

    <div class="admin-card" style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: none; width: 100%;">
        <div class="data-table-container" style="background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; overflow-x: auto; width: 100%;">
            <table class="data-table" style="width: 100%; border-collapse: separate; border-spacing: 0; table-layout: fixed;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 15px 20px; border-radius: 24px 0 0 0; width: 50px; text-align: center;"><input type="checkbox" id="select-all-questions" style="transform: scale(1.2); cursor: pointer;"></th>
                        <th style="padding: 15px 20px; text-align: left; width: 23%; white-space: normal;">User Details</th>
                        <th style="padding: 15px 20px; text-align: left; width: 44%; white-space: normal;">Question</th>
                        <th style="padding: 15px 20px; text-align: center; width: 12%; white-space: normal;">Status</th>
                        <th style="padding: 15px 20px; text-align: right; border-radius: 0 24px 0 0; width: 18%; white-space: normal;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data['questions'])): ?>
                        <?php foreach ($data['questions'] as $q): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s;" onmouseover="this.style.background='#eff6ff';" onmouseout="this.style.background='white';">
                            <td style="text-align: center; vertical-align: top; padding: 15px 20px;"><input type="checkbox" name="question_ids[]" value="<?= $q['id'] ?>" class="question-checkbox" style="transform: scale(1.2); cursor: pointer;"></td>
                            <td style="padding: 15px 20px; color: #1e293b; vertical-align: top; white-space: normal !important; word-break: break-word;">
                                <div style="font-weight: 700;"><?= htmlspecialchars($q['name']) ?></div>
                                <div style="font-size: 0.85rem; color: #64748b; word-break: break-all;"><?= htmlspecialchars($q['email']) ?></div>
                                <?php if (!empty($q['category_name'])): ?>
                                    <span style="background: #e2e8f0; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px;"><?= htmlspecialchars($q['category_name']) ?></span>
                                <?php endif; ?>
                                <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 5px;"><?= date('d M Y h:i A', strtotime($q['created_at'])) ?></div>
                            </td>
                            <td style="padding: 15px 20px; color: #334155; vertical-align: top; line-height: 1.5; white-space: normal !important; word-break: break-word;">
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">
                                    <?= htmlspecialchars(mb_strimwidth($q['question'], 0, 150, "...")) ?>
                                </div>
                                <?php if ($q['status'] === 'answered'): ?>
                                    <div style="font-size: 0.85rem; background: #f0fdf4; border-left: 3px solid #16a34a; padding: 6px 12px; border-radius: 4px; color: #166534; margin-top: 8px; word-break: break-word;">
                                        <strong>উত্তর:</strong> <?= htmlspecialchars(mb_strimwidth(strip_tags($q['answer']), 0, 100, "...")) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px 20px; text-align: center; vertical-align: top; white-space: normal !important;">
                                <?php if ($q['status'] === 'answered'): ?>
                                    <span style="background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 50px; font-weight: 700; font-size: 0.8rem;">Answered</span>
                                <?php else: ?>
                                    <span style="background: #fef3c7; color: #d97706; padding: 5px 12px; border-radius: 50px; font-weight: 700; font-size: 0.8rem;">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px 20px; text-align: right; vertical-align: top;">
                                <div class="action-buttons" style="display: flex; justify-content: flex-end; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <?php if (!empty($q['pending_answers'])): ?>
                                        <span style="background: #fffbeb; border: 1px solid #fef3c7; color: #d97706; padding: 8px 15px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                            <i class="fas fa-exclamation-circle" style="color: #d97706;"></i> Pending Answer Request (<?= count($q['pending_answers']) ?>)
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($q['status'] !== 'answered'): ?>
                                        <a href="<?= URLROOT ?>/admin/approve_question/<?= $q['id'] ?>" class="action-btn" title="Approve Without Answer" style="background: #e6f4ea; color: #137333; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; width: auto;">
                                            <i class="fas fa-check"></i> Approve
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= URLROOT ?>/admin/answer_question/<?= $q['id'] ?>" class="action-btn" title="Answer Question" style="background: #eff6ff; color: #2563eb; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; width: auto;">
                                        <i class="fas fa-reply"></i> <?= $q['status'] === 'answered' ? 'Edit Answer' : 'Answer' ?>
                                    </a>
                                    <a href="<?= URLROOT ?>/admin/delete_question/<?= $q['id'] ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this question?')" style="background: #fdf2f2; color: #de350b; padding: 8px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="padding: 50px; text-align: center; color: #64748b; font-style: italic;">
                                No questions submitted by users yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
document.getElementById('select-all-questions').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.question-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulk-questions-form').addEventListener('submit', function(e) {
    const action = document.getElementById('bulk-questions-select').value;
    if (!action) {
        alert('Please select an action.');
        e.preventDefault();
        return;
    }
    const checkedCount = document.querySelectorAll('.question-checkbox:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one question.');
        e.preventDefault();
        return;
    }
    
    let confirmMsg = '';
    if (action === 'delete') {
        confirmMsg = `Are you sure you want to delete ${checkedCount} selected question(s)?`;
    } else if (action === 'approve') {
        confirmMsg = `Are you sure you want to approve ${checkedCount} selected question(s)?`;
    }
    
    if (!confirm(confirmMsg)) {
        e.preventDefault();
    }
});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
