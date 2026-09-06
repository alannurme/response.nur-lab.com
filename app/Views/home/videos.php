<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Breadcrumbs/Header -->
<section style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 80px 0; color: white; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">সবগুলো ইউটিউব <span style="color: #ff0000;">ভিডিও</span></h1>
        <p style="font-size: 1.2rem; opacity: 0.8; max-width: 700px; margin: 0 auto;">আমাদের অফিশিয়াল চ্যানেলের সব ভিডিও ও আলোচনাগুলো এখান থেকেই দেখুন</p>
    </div>
</section>

<!-- Videos Grid -->
<section style="padding: 80px 0; background: #f8fafc;">
    <div class="container-fluid" style="max-width: 1300px; margin: 0 auto; padding: 0 15px; box-sizing: border-box; width: 100%;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
            <?php if (!empty($data['yt_videos'])): ?>
                <?php foreach ($data['yt_videos'] as $video): ?>
                <div class="yt-video-card-full" style="background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: 0.4s;">
                    <!-- Thumbnail with Play Button -->
                    <div style="position: relative; aspect-ratio: 16/9; overflow: hidden; background: #000;">
                        <img src="https://img.youtube.com/vi/<?=$video['video_id']?>/maxresdefault.jpg" loading="lazy" decoding="async" alt="<?= $video['title'] ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: 0.5s;">
                        <a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>" target="_blank" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <div class="play-btn-large" style="width: 70px; height: 70px; background: rgba(255,0,0,0.9); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; box-shadow: 0 10px 25px rgba(255,0,0,0.3); transition: 0.3s;">
                                <i class="fas fa-play"></i>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 25px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="background: #fff5f5; color: #ff0000; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;"><?= $video['category_name'] ?? 'ভিডিও' ?></span>
                            <span style="color: #94a3b8; font-size: 0.8rem;"><i class="far fa-calendar-alt"></i> <?= date('d M, Y', strtotime($video['created_at'])) ?></span>
                        </div>
                        <h3 style="font-size: 1.25rem; color: #1e293b; line-height: 1.5; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; margin-bottom: 15px; height: 3.7rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?= $video['title'] ?>
                        </h3>
                        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6; height: 3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0;">
                            <?= strip_tags($video['description'] ?? '') ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 100px; background: #fff; border-radius: 30px;">
                    <i class="fab fa-youtube fa-5x mb-4 text-muted"></i>
                    <h2 class="text-muted">কোনো ভিডিও খুঁজে পাওয়া যায়নি।</h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .yt-video-card-full:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.1) !important; border-color: #ff0000 !important; }
    .yt-video-card-full:hover img { transform: scale(1.1); opacity: 0.7; }
    .yt-video-card-full:hover .play-btn-large { transform: scale(1.2); background: #ff0000; }
</style>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
