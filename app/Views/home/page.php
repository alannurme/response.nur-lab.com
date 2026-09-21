<?php require APPROOT . '/Views/inc/header.php'; ?>

<section style="padding: 50px 0; background: #f8fafc; min-height: 75vh;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1e293b; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                <?= htmlspecialchars($data['page']['title']) ?>
            </h1>
            
            <div class="page-content" style="color: #334155; font-size: 1.05rem; line-height: 1.8; font-family: 'Hind Siliguri', 'Noto Serif Bengali', serif;">
                <?= $data['page']['content'] ?>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
