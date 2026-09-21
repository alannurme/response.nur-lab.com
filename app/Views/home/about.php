<?php require APPROOT . '/Views/inc/header.php'; ?>

<!-- Hero / Header Section -->
<section style="padding: 60px 0 30px 0; text-align: center; background: transparent;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
        <h1 style="font-size: 2.8rem; font-weight: 900; color: #1e293b; margin-bottom: 10px; font-family: 'Hind Siliguri', sans-serif;">
            আমাদের <span style="color: #2563eb;">সম্পর্কে</span>
        </h1>
        <p style="color: #475569; font-size: 1.1rem; max-width: 600px; margin: 0 auto 20px auto; line-height: 1.6;">
            response with nur-lab-এর উদ্দেশ্য, কার্যপরিধি, টিম এবং কার্যক্রম সম্পর্কে বিস্তারিত জানুন।
        </p>
        <div style="width: 80px; height: 5px; background: #2563eb; border-radius: 10px; margin: 0 auto;"></div>
    </div>
</section>

<!-- About Sections (আমাদের প্রত্যয় & আমাদের উদ্দেশ্য) -->
<?php if (!empty($data['about_sections'])): ?>
    <?php foreach ($data['about_sections'] as $index => $about): ?>
    <section class="about-section" style="padding: 60px 0; background: #ffffff; overflow: hidden; <?= $index > 0 ? 'border-top: 1px solid #f1f5f9;' : '' ?>">
        <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
            <div class="about-flex-row <?= $index % 2 === 0 ? 'about-animate-normal' : 'about-flex-row-reverse about-animate-reverse' ?>" style="display: flex; gap: 60px; align-items: center; flex-direction: <?= $index % 2 === 0 ? 'row' : 'row-reverse' ?>;">
                <!-- Image Column -->
                <div class="about-animate-col about-img-col <?= $index % 2 === 0 ? 'from-left' : 'from-right' ?>" style="flex: 1; min-width: 300px;">
                    <div style="border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); aspect-ratio: 16/11; background: #000;">
                        <img src="<?=$about['image']?>" loading="lazy" decoding="async" alt="<?= $about['title'] ?>" style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s;" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';">
                    </div>
                </div>
                <!-- Content Column -->
                <div class="about-animate-col about-content-col <?= $index % 2 === 0 ? 'from-right' : 'from-left' ?>" style="flex: 1.2; display: flex; flex-direction: column; align-items: flex-start;">
                    <span style="color: #f97316; font-size: 1rem; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 1px; font-family: 'Hind Siliguri', sans-serif;"><?= htmlspecialchars($about['subtitle']) ?></span>
                    <h2 style="font-size: 2.6rem; color: #1e293b; font-weight: 900; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 5px 0; line-height: 1.2;"><?= htmlspecialchars($about['title']) ?></h2>
                    <h3 style="font-size: 2.2rem; color: #2563eb; font-weight: 900; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 25px 0; line-height: 1.2;"><?= htmlspecialchars($about['highlight_title']) ?></h3>
                    <p style="color: #1e293b; font-size: 1.1rem; line-height: 1.85; margin: 0; text-align: justify; font-family: 'Hind Siliguri', sans-serif; font-weight: 400;"><?= nl2br(htmlspecialchars($about['description'])) ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Scopes Section (আমাদের কার্যপরিধি) -->
<?php if (isset($data['settings']['show_scopes']) && $data['settings']['show_scopes'] == '1'): ?>
<section class="scopes-section" style="padding: 80px 0; background: #f0f9ff; border-top: 1px solid #e0f2fe; border-bottom: 1px solid #e0f2fe;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
        <div class="section-title" style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 2.8rem; font-weight: 800; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                আমাদের <span style="color: #2563eb;">কার্যপরিধি</span>
            </h2>
        </div>

        <div class="scopes-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; justify-content: center;">
            <?php if (!empty($data['scopes'])): ?>
                <?php foreach ($data['scopes'] as $scope): ?>
                <div class="scope-card scope-card-animate" style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; padding: 40px 30px; box-shadow: 0 10px 30px rgba(37,99,235,0.03); display: flex; flex-direction: column; align-items: flex-start;">
                    <!-- Icon Box with light blue background -->
                    <div style="width: 55px; height: 55px; border-radius: 16px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(37,99,235,0.15);">
                        <i class="<?= $scope['icon'] ?>"></i>
                    </div>
                    
                    <h3 style="font-size: 1.4rem; color: #1e293b; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; margin: 0 0 15px 0; line-height: 1.3;"><?= $scope['title'] ?></h3>
                    <p style="color: #1e293b; font-size: 1.05rem; line-height: 1.7; margin: 0; text-align: justify; font-family: 'Hind Siliguri', sans-serif; font-weight: 400;"><?= $scope['description'] ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Team Members Section (আমাদের টিম) -->
<section class="team-section animate-team-section" style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="section-title" style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.5rem; color: #1e293b; font-weight: 800;">আমাদের <span style="color: #2563eb;">টিম</span></h2>
            <p style="color: #475569; margin-top: 10px;">আমাদের পোর্টালে নিরলসভাবে কাজ করে যাওয়া দক্ষ সদস্যবৃন্দ</p>
        </div>

        <div class="team-grid">
            <?php if (!empty($data['team'])): ?>
                <?php foreach($data['team'] as $member): ?>
                <div class="team-card team-card-animate" style="background: #ffffff; border-radius: 24px; overflow: hidden; text-align: center; border: 1px solid #e2e8f0; padding: 35px 25px; box-shadow: 0 10px 35px rgba(0,0,0,0.03);">
                    <div class="team-img-wrapper" style="width: 150px; height: 150px; margin: 0 auto 25px; border-radius: 50%; overflow: hidden; border: 3px solid #2563eb; box-shadow: 0 0 20px rgba(37, 99, 235, 0.15); transition: all 0.4s ease;">
                        <img src="<?= resolve_blog_image($member['image']) ?>" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <h3 style="font-size: 1.3rem; color: #1e293b; margin: 0 0 8px 0; font-weight: 700; line-height: 1.2; letter-spacing: 0.5px;"><?= $member['name'] ?></h3>
                    <p style="color: #2563eb; font-size: 0.95rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2; text-transform: uppercase; letter-spacing: 0.5px;"><?= $member['designation'] ?></p>
                    
                    <div style="border-top: 1px solid #e2e8f0; width: 80%; margin: 20px auto;"></div>
                    
                    <div style="display: flex; justify-content: center; gap: 15px;">
                        <?php if(!empty($member['facebook_link'])): ?>
                        <a href="<?= $member['facebook_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1877f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($member['twitter_link'])): ?>
                        <a href="<?= $member['twitter_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#1da1f2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($member['linkedin_link'])): ?>
                        <a href="<?= $member['linkedin_link'] ?>" target="_blank" style="width: 40px; height: 40px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: 0.3s;" onmouseover="this.style.background='#0a66c2'; this.style.color='#fff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#475569'; this.style.transform='scale(1)';">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- YouTube Video Gallery Section (ইউটিউব ভিডিওসমূহ) -->
<section class="yt-videos-section" style="padding: 80px 0; background: #f8fafc; border-top: 1px solid #e2e8f0;">
    <div class="container-fluid" style="max-width: 1300px; margin: 0 auto; padding: 0 15px; box-sizing: border-box; width: 100%;">
        <div class="section-header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
            <div>
                <h2 style="font-size: 2.5rem; font-weight: 900; color: #1e293b; font-family: 'Hind Siliguri', sans-serif; position: relative; display: inline-block;">
                    ইউটিউব <span style="color: #ff0000;">ভিডিওসমূহ</span>
                    <div style="position: absolute; bottom: -10px; left: 0; width: 60px; height: 5px; background: #ff0000; border-radius: 10px;"></div>
                </h2>
                <p style="color: #475569; margin-top: 20px; font-size: 1.1rem;">আমাদের অফিশিয়াল ইউটিউব চ্যানেলের সর্বশেষ ভিডিওগুলো এখানে দেখুন</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="<?= URLROOT ?>/videos" style="color: #1e293b; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #fff; border-radius: 12px; border: 2px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: 0.3s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='#fff';">
                    সবগুলো ভিডিও <i class="fas fa-play-circle"></i>
                </a>
                <a href="<?= !empty($data['settings']['youtube_channel_url']) ? $data['settings']['youtube_channel_url'] : 'https://www.youtube.com' ?>" target="_blank" style="color: #ff0000; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; padding: 12px 25px; background: #fff; border-radius: 12px; border: 2px solid #fff5f5; box-shadow: 0 4px 15px rgba(255,0,0,0.05); transition: 0.3s;" onmouseover="this.style.background='#ff0000'; this.style.color='#fff';" onmouseout="this.style.background='#fff'; this.style.color='#ff0000';">
                    ইউটিউবে দেখুন <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if (!empty($data['yt_videos'])): ?>
                <?php foreach (array_slice($data['yt_videos'], 0, 8) as $video): ?>
                <div class="yt-video-card video-card-animate" style="position: relative; border-radius: 20px; overflow: hidden; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.1); aspect-ratio: 16/9;">
                    <img src="https://img.youtube.com/vi/<?=$video['video_id']?>/maxresdefault.jpg" loading="lazy" decoding="async" alt="<?= $video['title'] ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: 0.5s;">
                    
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%); display: flex; flex-direction: column; justify-content: flex-end; padding: 25px; transition: 0.3s;">
                        <span style="color: #ff0000; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;"><?= $video['category_name'] ?? 'ভিডিও' ?></span>
                        <h3 style="color: white; font-size: 1.1rem; line-height: 1.4; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; margin-bottom: 0;"><?= $video['title'] ?></h3>
                    </div>

                    <a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>" target="_blank" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; background: rgba(255,0,0,0.9); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.5rem; text-decoration: none; box-shadow: 0 0 0 0 rgba(255,0,0,0.4); animation: pulse 2s infinite; opacity: 0.9; transition: 0.3s;">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #fff; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fab fa-youtube fa-4x mb-3 text-muted"></i>
                    <p class="text-muted">এখনো কোনো ইউটিউব ভিডিও যুক্ত করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .scope-card {
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s ease;
    }
    .scope-card:hover {
        transform: translateY(-8px);
        border-color: #2563eb !important;
        box-shadow: 0 20px 40px rgba(37,99,235,0.08) !important;
    }
    
    .team-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; max-width: 1400px; margin: 0 auto; }
    .team-card { width: calc(20% - 16px); box-sizing: border-box; }
    .team-card:hover { transform: translateY(-8px); border-color: #2563eb !important; box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08) !important; }
    .team-card:hover .team-img-wrapper { transform: scale(1.05); box-shadow: 0 0 25px rgba(37, 99, 235, 0.35) !important; }
    .yt-video-card:hover { transform: scale(1.03); }
    .yt-video-card:hover img { transform: scale(1.1); opacity: 0.6; }
    .yt-video-card:hover a { transform: translate(-50%, -50%) scale(1.1); background: #ff0000; opacity: 1; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); } 70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); } 100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); } }
    @media (max-width: 1400px) { .team-card { width: calc(25% - 15px); } }
    @media (max-width: 1024px) { .team-card { width: calc(33.333% - 14px); } .scopes-grid { grid-template-columns: repeat(2, 1fr) !important; } .about-flex-row { flex-direction: column !important; gap: 40px !important; } .about-flex-row > div { width: 100% !important; } }
    @media (max-width: 768px) { .team-card { width: calc(50% - 10px); } .scopes-grid { grid-template-columns: 1fr !important; } .scope-card { padding: 30px 20px !important; } .section-header-flex { flex-direction: column; align-items: flex-start !important; gap: 15px; margin-bottom: 30px !important; } .section-header-flex a { align-self: flex-start; } }
    @media (max-width: 480px) { .team-card { width: 100%; } }
</style>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
