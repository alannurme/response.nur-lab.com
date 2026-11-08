<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
.add-q-container {
    max-width: 820px;
    margin: 20px auto 40px auto;
}
.add-q-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.add-q-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: 'Hind Siliguri', sans-serif;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 16px;
}
.add-q-field {
    margin-bottom: 22px;
}
.add-q-field label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
.add-q-field input, .add-q-field select, .add-q-field textarea {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    padding: 10px 16px;
    transition: 0.2s border-color, 0.2s box-shadow;
    width: 100%;
}
.add-q-field input:focus, .add-q-field select:focus, .add-q-field textarea:focus {
    border-color: #0b7c4d;
    box-shadow: 0 0 0 3px rgba(11, 124, 77, 0.12);
    outline: none;
}
.add-q-field small {
    display: block;
    margin-top: 6px;
    color: #64748b;
    font-size: 0.82rem;
}
</style>

<div class="add-q-container">
    <!-- Top Back Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <a href="<?= URLROOT ?>/admin/questions" class="btn btn-outline-secondary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
            <i class="fas fa-arrow-left"></i> প্রশ্নোত্তর তালিকায় ফিরুন
        </a>
        <a href="<?= URLROOT ?>/admin/question_categories" class="btn btn-outline-primary" style="font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 10px; padding: 10px 18px;">
            <i class="fas fa-tags"></i> ক্যাটাগরি পরিচালনা
        </a>
    </div>

    <!-- Main Card -->
    <div class="add-q-card">
        <div class="add-q-title">
            <div style="width: 44px; height: 44px; background: #e6f4ea; color: #0b7c4d; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #1e293b;">নতুন প্রশ্ন ও উত্তর যোগ করুন</h3>
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">এডমিন হিসেবে সরাসরি প্রশ্ন ও তার সমাধান অন্তর্ভুক্ত করুন</span>
            </div>
        </div>

        <form action="<?= URLROOT ?>/admin/add_question" method="POST">
            <?= csrf_field() ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Name -->
                <div class="add-q-field">
                    <label for="field_name">প্রশ্নকারীর নাম</label>
                    <input type="text" id="field_name" name="name" class="form-control" value="এডমিন" placeholder="যেমন: আব্দুল্লাহ" required>
                </div>

                <!-- Email -->
                <div class="add-q-field">
                    <label for="field_email">ইমেইল ঠিকানা</label>
                    <input type="email" id="field_email" name="email" class="form-control" value="<?= htmlspecialchars($settings['site_email'] ?? 'admin@nur-lab.com') ?>" placeholder="name@example.com">
                </div>
            </div>

            <!-- Category -->
            <div class="add-q-field">
                <label for="field_category">প্রশ্নোত্তর ক্যাটাগরি (বিষয়)</label>
                <select id="field_category" name="category_id" class="form-control" style="height: 48px;">
                    <option value="">-- সাধারণ / কোনো নির্দিষ্ট বিভাগ ছাড়া --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small>উপযুক্ত ক্যাটাগরি নির্বাচন করলে ব্যবহারকারীরা সহজে বিষয়টি খুঁজে পাবেন।</small>
            </div>

            <!-- Question -->
            <div class="add-q-field">
                <label for="field_question">
                    প্রশ্ন <span style="color: #ef4444;">*</span>
                </label>
                <textarea id="field_question" name="question" rows="4" class="form-control" placeholder="এখানে সম্পূর্ণ প্রশ্নটি বিস্তারিতভাবে লিখুন..." style="resize: vertical; font-family: 'Hind Siliguri', sans-serif;" required autofocus></textarea>
            </div>

            <!-- Answer -->
            <div class="add-q-field">
                <label for="field_answer">
                    উত্তর (ঐচ্ছিক)
                </label>
                <textarea id="field_answer" name="answer" rows="7" class="form-control" placeholder="যদি এখনই উত্তর প্রস্তুত থাকে তবে এখানে লিখুন, অন্যথায় খালি রাখতে পারেন..." style="resize: vertical; font-family: 'Hind Siliguri', sans-serif;"></textarea>
                <small>উত্তর পূরণ করলে স্ট্যাটাস স্বয়ংক্রিয়ভাবে "Answered" হিসেবে সেট হবে এবং হোমপেজ/পাবলিক প্রশ্নোত্তর সেকশনে প্রকাশিত হবে।</small>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex: 2; height: 50px; background: #0b7c4d; border-color: #0b7c4d; font-weight: 700; font-size: 1.05rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(11, 124, 77, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-check-circle"></i> প্রশ্ন সংরক্ষণ করুন (Save Question)
                </button>
                <a href="<?= URLROOT ?>/admin/questions" class="btn btn-outline-secondary" style="flex: 1; height: 50px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    বাতিল (Cancel)
                </a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
