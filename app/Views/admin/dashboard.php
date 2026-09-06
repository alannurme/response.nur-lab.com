<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
/* Dashboard Design */
.db-hero{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}
.db-hero-card{border-radius:18px;padding:1.5rem;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;text-decoration:none;display:block}
.db-hero-card:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,0,0,.15)}
.hc-icon{width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin-bottom:1.1rem;font-size:1.2rem;color:white}
.hc-val{font-size:2rem;font-weight:800;color:white;line-height:1;margin-bottom:4px}
.hc-label{font-size:.8rem;font-weight:600;color:rgba(255,255,255,.8);letter-spacing:.03em;text-transform:uppercase}
.hc-sub{font-size:.75rem;color:rgba(255,255,255,.65);margin-top:10px;display:flex;align-items:center;gap:5px}
.db-hero-card::after{content:'';position:absolute;top:-40px;right:-40px;width:120px;height:120px;background:rgba(255,255,255,.08);border-radius:50%}
.db-row{display:grid;gap:1.5rem;margin-bottom:1.5rem}
.db-row-3{grid-template-columns:2fr 1fr 1fr}
.db-row-2{grid-template-columns:1fr 1fr}
.db-card{background:var(--card-bg);border:1px solid var(--border-light);border-radius:18px;overflow:hidden}
.db-card-header{display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid var(--border-light)}
.db-card-title{display:flex;align-items:center;gap:10px;font-weight:700;font-size:.95rem;color:var(--text-main)}
.db-card-title .icon-box{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.8rem}
.db-card-body{padding:1.25rem 1.5rem}
.db-view-link{font-size:.75rem;font-weight:700;color:var(--primary);text-decoration:none;background:#eff6ff;padding:4px 12px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;transition:background .2s;white-space:nowrap}
.db-view-link:hover{background:#dbeafe}
.post-row{display:flex;align-items:center;gap:12px;padding:10px 1.5rem;border-bottom:1px solid #f8fafc;transition:background .15s;text-decoration:none}
.post-row:last-child{border-bottom:none}
.post-row:hover{background:#f8fafc}
.post-num{width:26px;height:26px;border-radius:7px;font-weight:800;font-size:.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.qa-item{padding:12px 1.5rem;border-bottom:1px solid #f8fafc}
.qa-item:last-child{border-bottom:none}
.health-bar-wrap{margin-bottom:1rem}
.health-bar-track{background:#e2e8f0;border-radius:20px;height:7px;overflow:hidden;margin-top:5px}
.health-bar-fill{height:100%;border-radius:20px;transition:width .6s ease}
.quick-link{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:12px;border:1px solid var(--border-light);text-decoration:none;transition:all .18s;margin-bottom:.6rem}
.quick-link:last-child{margin-bottom:0}
.quick-link:hover{border-color:#2563eb;background:#eff6ff;transform:translateX(3px)}
.quick-link .ql-icon{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0}
.sub-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:white;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;flex-shrink:0}
@media(max-width:1200px){.db-hero{grid-template-columns:repeat(2,1fr)}.db-row-3{grid-template-columns:1fr}.db-row-2{grid-template-columns:1fr}}
@media(max-width:600px){.db-hero{grid-template-columns:1fr}}
</style>

<!-- Page Header -->
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem;flex-wrap:wrap;gap:1rem">
    <div>
        <h1 style="margin:0 0 4px;font-size:1.6rem;font-weight:800;color:var(--text-main)">👋 Welcome back!</h1>
        <p style="margin:0;color:var(--text-muted);font-size:.9rem"><?= date('l, d F Y') ?> &nbsp;·&nbsp; Here's your site at a glance.</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
        <a href="<?= URLROOT ?>/admin/add_post" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:white;border-radius:12px;font-size:.85rem;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,.35)">
            <i class="fas fa-plus"></i> New Article
        </a>
    </div>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cache_cleared'): ?>
<div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:14px 18px;border-radius:12px;margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;font-weight:600;font-size:.9rem">
    <i class="fas fa-check-circle" style="color:#22c55e"></i> Cache cleared successfully!
</div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'seo_generated'): ?>
<div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:14px 18px;border-radius:12px;margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;font-weight:600;font-size:.9rem">
    <i class="fas fa-check-circle" style="color:#22c55e"></i> SEO metadata for <?= isset($_GET['count']) ? intval($_GET['count']) : 0 ?> articles has been automatically generated successfully!
</div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'seo_error'): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:14px 18px;border-radius:12px;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:8px;font-weight:600;font-size:.9rem">
    <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#ef4444"></i> Failed to auto-generate SEO metadata.
    </div>
    <?php if (file_exists(APPROOT . '/cache/seo_error.log')): ?>
        <div style="background:#fff;padding:8px 12px;border-radius:6px;border:1px solid #fecaca;font-family:monospace;font-size:.78rem;color:#dc2626;white-space:pre-wrap;margin-top:4px;">
            <?= htmlspecialchars(explode("\n", file_get_contents(APPROOT . '/cache/seo_error.log'))[0]) ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Hero Stats -->
<div class="db-hero">
    <a href="<?= URLROOT ?>/admin/posts" class="db-hero-card" style="background:linear-gradient(135deg,#2563eb,#1e40af)">
        <div class="hc-icon"><i class="fas fa-newspaper"></i></div>
        <div class="hc-val"><?= $data['stats']['total_posts'] ?></div>
        <div class="hc-label">Total Articles</div>
        <div class="hc-sub"><i class="fas fa-pencil-alt"></i> <?= $data['draft_posts_count'] ?> drafts</div>
    </a>
    <a href="<?= URLROOT ?>/admin/posts" class="db-hero-card" style="background:linear-gradient(135deg,#059669,#047857)">
        <div class="hc-icon"><i class="fas fa-eye"></i></div>
        <div class="hc-val"><?= number_format($data['stats']['total_views']) ?></div>
        <div class="hc-label">Total Views</div>
        <div class="hc-sub"><i class="fas fa-chart-line"></i> All time</div>
    </a>
    <a href="<?= URLROOT ?>/admin/subscribers" class="db-hero-card" style="background:linear-gradient(135deg,#7c3aed,#6d28d9)">
        <div class="hc-icon"><i class="fas fa-users"></i></div>
        <div class="hc-val"><?= $data['total_subscribers_count'] ?></div>
        <div class="hc-label">Subscribers</div>
        <div class="hc-sub"><i class="fas fa-envelope"></i> Newsletter</div>
    </a>
    <a href="<?= URLROOT ?>/admin/donations" class="db-hero-card" style="background:linear-gradient(135deg,#ec4899,#db2777)">
        <div class="hc-icon"><i class="fas fa-heart"></i></div>
        <div class="hc-val">৳<?= number_format($data['total_donations_amount'], 0) ?></div>
        <div class="hc-label">Donations</div>
        <div class="hc-sub"><i class="fas fa-spinner"></i> <?= $data['pending_donations_count'] ?> pending</div>
    </a>
</div>

<!-- Alert Pills -->
<?php $hasAlerts = $data['pending_questions_count']>0||$data['pending_guest_answers_count']>0||count($data['pending_comments'])>0||count($data['unread_messages'])>0; ?>
<?php if ($hasAlerts): ?>
<div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.75rem">
    <?php if ($data['pending_questions_count']>0): ?>
    <a href="<?= URLROOT ?>/admin/questions" style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;font-size:.82rem;font-weight:700;color:#ea580c;text-decoration:none">
        <i class="fas fa-question-circle"></i> <?= $data['pending_questions_count'] ?> Unanswered Questions
    </a>
    <?php endif; ?>
    <?php if ($data['pending_guest_answers_count']>0): ?>
    <a href="<?= URLROOT ?>/admin/questions" style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;font-size:.82rem;font-weight:700;color:#dc2626;text-decoration:none">
        <i class="fas fa-reply"></i> <?= $data['pending_guest_answers_count'] ?> Pending Answers
    </a>
    <?php endif; ?>
    <?php if (count($data['pending_comments'])>0): ?>
    <a href="<?= URLROOT ?>/admin/comments" style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:#fdf4ff;border:1.5px solid #e9d5ff;border-radius:12px;font-size:.82rem;font-weight:700;color:#7c3aed;text-decoration:none">
        <i class="fas fa-comments"></i> <?= count($data['pending_comments']) ?> Pending Comments
    </a>
    <?php endif; ?>
    <?php if (count($data['unread_messages'])>0): ?>
    <a href="<?= URLROOT ?>/admin/messages" style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:12px;font-size:.82rem;font-weight:700;color:#2563eb;text-decoration:none">
        <i class="fas fa-envelope"></i> <?= count($data['unread_messages']) ?> Unread Messages
    </a>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Charts Row -->
<div class="db-row db-row-2">
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#eff6ff;color:#2563eb"><i class="fas fa-chart-area"></i></div>Posts — Last 7 Days</div>
        </div>
        <div style="padding:1.25rem 1.5rem;height:240px"><canvas id="weekChart"></canvas></div>
    </div>
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#f0fdf4;color:#16a34a"><i class="fas fa-chart-bar"></i></div>Posts — Last 12 Months</div>
        </div>
        <div style="padding:1.25rem 1.5rem;height:240px"><canvas id="monthChart"></canvas></div>
    </div>
</div>

<!-- Main Row: Recent Posts + Quick Actions + Category -->
<?php
$pnBg = ['#eff6ff','#fdf4ff','#fff7ed','#f0fdf4','#fef2f2'];
$pnC  = ['#2563eb','#7c3aed','#ea580c','#16a34a','#dc2626'];
$dc   = ['#2563eb','#8b5cf6','#ec4899','#f97316','#22c55e','#06b6d4','#f59e0b','#ef4444'];
?>
<div class="db-row db-row-3">
    <!-- Recent Posts -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#eff6ff;color:#2563eb"><i class="fas fa-clock"></i></div>Recent Posts</div>
            <a href="<?= URLROOT ?>/admin/posts" class="db-view-link">View All <i class="fas fa-arrow-right" style="font-size:.6rem"></i></a>
        </div>
        <?php foreach ($data['posts'] as $i => $post): ?>
        <a href="<?= URLROOT ?>/admin/edit_post/<?= $post['id'] ?>" class="post-row">
            <div class="post-num" style="background:<?= $pnBg[$i%5] ?>;color:<?= $pnC[$i%5] ?>"><?= $i+1 ?></div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($post['title']) ?></div>
                <?php if (!empty($post['category_name'])): ?><div style="font-size:.7rem;color:#2563eb;font-weight:600;margin-top:2px"><?= htmlspecialchars($post['category_name']) ?></div><?php endif; ?>
            </div>
            <div style="text-align:right;flex-shrink:0">
                <div style="font-size:.8rem;font-weight:700;color:#334155"><i class="fas fa-eye" style="color:#94a3b8;font-size:.65rem;margin-right:3px"></i><?= number_format($post['views']) ?></div>
                <div style="font-size:.68rem;color:#94a3b8;margin-top:1px"><?= date('d M', strtotime($post['created_at'])) ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Quick Actions -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fdf4ff;color:#7c3aed"><i class="fas fa-bolt"></i></div>Quick Actions</div>
        </div>
        <div class="db-card-body">
            <a href="<?= URLROOT ?>/admin/add_post" style="display:flex;align-items:center;gap:10px;padding:13px 15px;background:linear-gradient(135deg,#2563eb,#1d4ed8);border-radius:12px;text-decoration:none;margin-bottom:.75rem">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-plus" style="color:white"></i></div>
                <div><div style="color:white;font-weight:700;font-size:.88rem">New Article</div><div style="color:rgba(255,255,255,.7);font-size:.72rem">Create a new post</div></div>
                <i class="fas fa-arrow-right" style="color:rgba(255,255,255,.5);margin-left:auto"></i>
            </a>
            <?php
            $qlinks=[
                ['url'=>'/admin/categories','icon'=>'fas fa-folder','bg'=>'#fdf4ff','color'=>'#7c3aed','title'=>'Categories','sub'=>'Manage categories'],
                ['url'=>'/admin/media','icon'=>'fas fa-photo-video','bg'=>'#fff7ed','color'=>'#ea580c','title'=>'Media Library','sub'=>'Upload & manage files'],
                ['url'=>'/admin/subscribers','icon'=>'fas fa-users','bg'=>'#f0fdf4','color'=>'#16a34a','title'=>'Subscribers','sub'=>$data['total_subscribers_count'].' total'],
                ['url'=>'/admin/settings','icon'=>'fas fa-cog','bg'=>'#eff6ff','color'=>'#2563eb','title'=>'Settings','sub'=>'Site configuration'],
                ['url'=>'/admin/donations','icon'=>'fas fa-heart','bg'=>'#fff0f9','color'=>'#db2777','title'=>'Donations','sub'=>$data['pending_donations_count'].' pending'],
            ];
            foreach($qlinks as $ql): ?>
            <a href="<?= URLROOT.$ql['url'] ?>" class="quick-link">
                <div class="ql-icon" style="background:<?= $ql['bg'] ?>;color:<?= $ql['color'] ?>"><i class="<?= $ql['icon'] ?>"></i></div>
                <div style="flex:1;min-width:0"><div style="font-size:.85rem;font-weight:600;color:#1e293b"><?= $ql['title'] ?></div><div style="font-size:.72rem;color:#94a3b8"><?= $ql['sub'] ?></div></div>
                <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:.7rem;flex-shrink:0"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Category Donut -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fdf4ff;color:#8b5cf6"><i class="fas fa-chart-pie"></i></div>By Category</div>
        </div>
        <div class="db-card-body">
            <div style="height:180px;margin-bottom:1rem"><canvas id="catDonut"></canvas></div>
            <div style="display:flex;flex-direction:column;gap:5px;max-height:160px;overflow-y:auto">
                <?php foreach ($data['category_distribution'] as $ci => $cat): $co=$dc[$ci%8]; ?>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:.78rem">
                    <div style="display:flex;align-items:center;gap:6px">
                        <div style="width:8px;height:8px;border-radius:50%;background:<?= $co ?>;flex-shrink:0"></div>
                        <span style="color:var(--text-main);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:110px"><?= htmlspecialchars($cat['name']) ?></span>
                    </div>
                    <strong style="color:#64748b"><?= $cat['post_count'] ?></strong>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Top Articles & Least Viewed Articles Row -->
<div class="db-row db-row-2">
    <!-- Top Articles -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fef2f2;color:#ef4444"><i class="fas fa-fire"></i></div>Top Articles</div>
            <a href="<?= URLROOT ?>/admin/posts" class="db-view-link">View All <i class="fas fa-arrow-right" style="font-size:.6rem"></i></a>
        </div>
        <?php foreach ($data['top_posts'] as $i => $post): ?>
        <a href="<?= URLROOT ?>/admin/edit_post/<?= $post['id'] ?>" class="post-row">
            <div class="post-num" style="background:<?= $dc[$i%8] ?>22;color:<?= $dc[$i%8] ?>"><?= $i+1 ?></div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($post['title']) ?></div>
                <?php if (!empty($post['category_names'])): ?><div style="font-size:.7rem;color:#94a3b8;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($post['category_names']) ?></div><?php endif; ?>
            </div>
            <div style="display:flex;align-items:center;gap:4px;color:#2563eb;font-weight:700;font-size:.82rem;flex-shrink:0">
                <i class="fas fa-eye" style="font-size:.65rem;color:#94a3b8"></i><?= number_format($post['views']) ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Least Viewed Articles -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#eff6ff;color:#3b82f6"><i class="fas fa-eye-slash"></i></div>Least Viewed Articles</div>
            <a href="<?= URLROOT ?>/admin/posts" class="db-view-link">View All <i class="fas fa-arrow-right" style="font-size:.6rem"></i></a>
        </div>
        <?php foreach ($data['least_viewed_posts'] as $i => $post): ?>
        <a href="<?= URLROOT ?>/admin/edit_post/<?= $post['id'] ?>" class="post-row">
            <div class="post-num" style="background:<?= $dc[$i%8] ?>22;color:<?= $dc[$i%8] ?>"><?= $i+1 ?></div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($post['title']) ?></div>
                <?php if (!empty($post['category_names'])): ?><div style="font-size:.7rem;color:#94a3b8;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($post['category_names']) ?></div><?php endif; ?>
            </div>
            <div style="display:flex;align-items:center;gap:4px;color:#ef4444;font-weight:700;font-size:.82rem;flex-shrink:0">
                <i class="fas fa-eye" style="font-size:.65rem;color:#94a3b8"></i><?= number_format($post['views']) ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Content Health & Site Overview Row -->
<div class="db-row db-row-2">
    <!-- Content Health -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fef2f2;color:#ef4444"><i class="fas fa-heartbeat"></i></div>Content Health</div>
        </div>
        <div class="db-card-body">
            <?php $h=$data['content_health']; $t=max($h['total'],1); ?>
            <div class="health-bar-wrap">
                <div style="display:flex;justify-content:space-between;font-size:.82rem"><span style="font-weight:600;color:var(--text-main)"><i class="fas fa-image" style="color:#f97316;margin-right:5px"></i>No Thumbnail</span><span style="font-weight:700;color:<?= $h['no_image']>0?'#ef4444':'#22c55e' ?>"><?= $h['no_image'] ?>/<?= $t ?></span></div>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= round($h['no_image']/$t*100) ?>%;background:<?= $h['no_image']>0?'#f97316':'#22c55e' ?>"></div></div>
            </div>
            <div class="health-bar-wrap">
                <div style="display:flex;justify-content:space-between;font-size:.82rem"><span style="font-weight:600;color:var(--text-main)"><i class="fas fa-eye-slash" style="color:#8b5cf6;margin-right:5px"></i>Zero Views</span><span style="font-weight:700;color:<?= $h['zero_views']>0?'#ef4444':'#22c55e' ?>"><?= $h['zero_views'] ?>/<?= $t ?></span></div>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= round($h['zero_views']/$t*100) ?>%;background:#8b5cf6"></div></div>
            </div>
            <div class="health-bar-wrap">
                <div style="display:flex;justify-content:space-between;font-size:.82rem"><span style="font-weight:600;color:var(--text-main)"><i class="fas fa-search" style="color:#2563eb;margin-right:5px"></i>No SEO Meta</span><span style="font-weight:700;color:<?= $h['no_seo']>0?'#ef4444':'#22c55e' ?>"><?= $h['no_seo'] ?>/<?= $t ?></span></div>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= round($h['no_seo']/$t*100) ?>%;background:#2563eb"></div></div>
            </div>
            <?php if ($h['no_image']==0&&$h['zero_views']==0&&$h['no_seo']==0): ?>
            <div style="margin-top:1rem;padding:10px 14px;background:#f0fdf4;border-radius:10px;font-size:.8rem;font-weight:600;color:#166534">
                <i class="fas fa-check-circle"></i> All content looks healthy! 🎉
            </div>
            <?php endif; ?>
            <?php if ($h['no_seo'] > 0): ?>
                <a href="<?= URLROOT ?>/admin/auto_generate_seo" onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Generating...'; this.style.pointerEvents='none';" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:10px;padding:9px 14px;background:linear-gradient(135deg, #2563eb, #1d4ed8);color:white;border-radius:10px;font-size:.8rem;font-weight:700;text-decoration:none;transition:all 0.2s ease;text-align:center;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(37,99,235,0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fas fa-magic"></i> Auto-Generate <?= $h['no_seo'] ?> SEO Meta
                </a>
                <?php if (!empty($h['broken_posts'])): ?>
                    <div style="margin-top: 15px; font-size: 0.78rem; border-top: 1px dashed var(--border-light); padding-top: 10px;">
                        <div style="font-weight: 700; color: #dc2626; margin-bottom: 8px; display:flex; align-items:center; gap:5px;">
                            <i class="fas fa-exclamation-triangle" style="color:#f59e0b"></i> Attention needed:
                        </div>
                        <div style="max-height: 120px; overflow-y: auto; display:flex; flex-direction:column; gap:6px;">
                            <?php foreach ($h['broken_posts'] as $bp): ?>
                                <div style="display:flex; justify-content:space-between; align-items:center; gap: 8px;">
                                    <a href="<?= URLROOT ?>/admin/edit_post/<?= $bp['id'] ?>" style="color: #2563eb; text-decoration:none; font-weight: 600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width: 140px;" title="<?= htmlspecialchars($bp['title']) ?>">
                                        #<?= $bp['id'] ?> - <?= htmlspecialchars($bp['title'] ?: '(No Title)') ?>
                                    </a>
                                    <span style="color: #ef4444; font-size: 0.7rem; flex-shrink: 0; background: #fee2e2; padding: 2px 6px; border-radius: 4px; font-weight: 500;">
                                        <?= htmlspecialchars($bp['reason']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Site Overview -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#f0fdf4;color:#16a34a"><i class="fas fa-chart-pie"></i></div>Site Overview</div>
        </div>
        <div class="db-card-body" style="display:flex;flex-direction:column;gap:.6rem">
            <?php
            $ov=[
                ['label'=>'Published','val'=>(int)$data['stats']['total_posts']-(int)$data['draft_posts_count'],'bg'=>'#eff6ff','c'=>'#1e40af','icon'=>'fas fa-check-circle'],
                ['label'=>'Drafts','val'=>$data['draft_posts_count'],'bg'=>'#fefce8','c'=>'#92400e','icon'=>'fas fa-pencil-alt'],
                ['label'=>'Total Views','val'=>number_format($data['stats']['total_views']),'bg'=>'#f0fdf4','c'=>'#166534','icon'=>'fas fa-eye'],
                ['label'=>'Categories','val'=>$data['stats']['total_categories'],'bg'=>'#fdf4ff','c'=>'#6b21a8','icon'=>'fas fa-folder'],
                ['label'=>'Subscribers','val'=>$data['total_subscribers_count'],'bg'=>'#fff7ed','c'=>'#92400e','icon'=>'fas fa-users'],
                ['label'=>'Media Files','val'=>$data['media_stats']['count'],'bg'=>'#fef2f2','c'=>'#9f1239','icon'=>'fas fa-photo-video'],
            ];
            foreach($ov as $item): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 13px;background:<?= $item['bg'] ?>;border-radius:10px">
                <span style="font-size:.82rem;font-weight:600;color:<?= $item['c'] ?>"><i class="<?= $item['icon'] ?>" style="margin-right:7px"></i><?= $item['label'] ?></span>
                <strong style="color:<?= $item['c'] ?>;font-size:.95rem"><?= $item['val'] ?></strong>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Activity Row -->
<div class="db-row db-row-3">
    <!-- Pending Comments -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fdf4ff;color:#7c3aed"><i class="fas fa-comments"></i></div>Pending Comments</div>
            <a href="<?= URLROOT ?>/admin/comments" class="db-view-link">View All</a>
        </div>
        <?php if (empty($data['pending_comments'])): ?>
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.85rem"><i class="fas fa-check-circle" style="font-size:1.5rem;color:#22c55e;display:block;margin-bottom:8px"></i>No pending comments</div>
        <?php else: ?>
        <?php foreach ($data['pending_comments'] as $c): ?>
        <div class="qa-item">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;margin-bottom:4px"><strong style="color:var(--text-main)"><?= htmlspecialchars($c['name']) ?></strong><span style="color:var(--text-muted)"><?= date('d M', strtotime($c['created_at'])) ?></span></div>
            <div style="font-size:.8rem;color:#475569;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:8px"><?= htmlspecialchars($c['comment']) ?></div>
            <div style="display:flex;gap:8px">
                <a href="<?= URLROOT ?>/admin/approve_comment/<?= $c['id'] ?>" style="font-size:.72rem;font-weight:700;padding:3px 10px;background:#dcfce7;color:#166534;border-radius:6px;text-decoration:none">✓ Approve</a>
                <a href="<?= URLROOT ?>/admin/delete_comment/<?= $c['id'] ?>" onclick="return confirm('Delete?')" style="font-size:.72rem;font-weight:700;padding:3px 10px;background:#fee2e2;color:#dc2626;border-radius:6px;text-decoration:none">✕ Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Q&A -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#fff7ed;color:#f59e0b"><i class="fas fa-question-circle"></i></div>Unanswered Q&amp;A</div>
            <a href="<?= URLROOT ?>/admin/questions" class="db-view-link">View All</a>
        </div>
        <?php if (empty($data['unanswered_questions'])): ?>
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.85rem"><i class="fas fa-check-circle" style="font-size:1.5rem;color:#22c55e;display:block;margin-bottom:8px"></i>All caught up!</div>
        <?php else: ?>
        <?php foreach ($data['unanswered_questions'] as $q): ?>
        <div class="qa-item">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;margin-bottom:4px"><strong style="color:var(--text-main)"><?= htmlspecialchars($q['name']) ?></strong><span style="color:var(--text-muted)"><?= date('d M', strtotime($q['created_at'])) ?></span></div>
            <div style="font-size:.8rem;color:#475569;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:8px"><?= htmlspecialchars($q['question']) ?></div>
            <a href="<?= URLROOT ?>/admin/answer_question/<?= $q['id'] ?>" style="font-size:.72rem;font-weight:700;padding:3px 10px;background:#eff6ff;color:#2563eb;border-radius:6px;text-decoration:none;display:inline-block">✍ Answer</a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Messages -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#eff6ff;color:#2563eb"><i class="fas fa-envelope"></i></div>Unread Messages</div>
            <a href="<?= URLROOT ?>/admin/messages" class="db-view-link">View All</a>
        </div>
        <?php if (empty($data['unread_messages'])): ?>
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.85rem"><i class="fas fa-check-circle" style="font-size:1.5rem;color:#22c55e;display:block;margin-bottom:8px"></i>No unread messages</div>
        <?php else: ?>
        <?php foreach ($data['unread_messages'] as $m): ?>
        <div class="qa-item">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;margin-bottom:3px"><strong style="color:var(--text-main)"><?= htmlspecialchars($m['name']) ?></strong><span style="color:var(--text-muted)"><?= date('d M', strtotime($m['created_at'])) ?></span></div>
            <div style="font-size:.78rem;font-weight:600;color:var(--text-main);margin-bottom:3px"><?= htmlspecialchars($m['subject'] ?? 'No Subject') ?></div>
            <div style="font-size:.78rem;color:#475569;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"><?= htmlspecialchars($m['message']) ?></div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Bottom Row: Subscribers + Server -->
<div class="db-row db-row-2">
    <!-- Recent Subscribers -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-user-plus"></i></div>Recent Subscribers</div>
            <a href="<?= URLROOT ?>/admin/subscribers" class="db-view-link">View All (<?= $data['total_subscribers_count'] ?>)</a>
        </div>
        <?php if (empty($data['recent_subscribers'])): ?>
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.85rem">No subscribers yet.</div>
        <?php else: ?>
        <div style="padding:.5rem 0">
            <?php foreach ($data['recent_subscribers'] as $sub): ?>
            <div style="display:flex;align-items:center;gap:12px;padding:10px 1.5rem;border-bottom:1px solid #f8fafc">
                <div class="sub-avatar"><?= strtoupper(mb_substr($sub['email'],0,1)) ?></div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:.85rem;font-weight:600;color:var(--text-main);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($sub['email']) ?></div>
                    <div style="font-size:.72rem;color:var(--text-muted)"><?= date('d M Y', strtotime($sub['created_at'])) ?></div>
                </div>
                <span style="background:#dcfce7;color:#166534;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px">NEW</span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Server & Storage -->
    <div class="db-card">
        <div class="db-card-header">
            <div class="db-card-title"><div class="icon-box" style="background:#f0f9ff;color:#06b6d4"><i class="fas fa-server"></i></div>Server &amp; Storage</div>
        </div>
        <div class="db-card-body">
            <?php
            $si=$data['server_info'];
            $dU=round(($si['disk_total']-$si['disk_free'])/1073741824,1);
            $dT=round($si['disk_total']/1073741824,1);
            $dP=$dT>0?round($dU/$dT*100):0;
            ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1rem">
                <div style="padding:12px;background:#f8fafc;border-radius:10px;text-align:center"><div style="font-size:1.1rem;font-weight:800;color:#1e293b"><?= $si['php_version'] ?></div><div style="font-size:.72rem;color:#94a3b8;margin-top:2px">PHP Version</div></div>
                <div style="padding:12px;background:#f8fafc;border-radius:10px;text-align:center"><div style="font-size:1.1rem;font-weight:800;color:#1e293b"><?= $si['memory_limit'] ?></div><div style="font-size:.72rem;color:#94a3b8;margin-top:2px">Memory Limit</div></div>
                <div style="padding:12px;background:#f8fafc;border-radius:10px;text-align:center"><div style="font-size:1.1rem;font-weight:800;color:#7c3aed"><?= $data['media_stats']['count'] ?></div><div style="font-size:.72rem;color:#94a3b8;margin-top:2px">Media Files</div></div>
                <div style="padding:12px;background:#f8fafc;border-radius:10px;text-align:center"><div style="font-size:1.1rem;font-weight:800;color:#7c3aed"><?= $data['media_stats']['size_mb'] ?> MB</div><div style="font-size:.72rem;color:#94a3b8;margin-top:2px">Storage Used</div></div>
            </div>
            <div>
                <div style="display:flex;justify-content:space-between;font-size:.82rem;margin-bottom:6px">
                    <span style="font-weight:600;color:var(--text-main)"><i class="fas fa-hdd" style="color:#22c55e;margin-right:5px"></i>Disk Usage</span>
                    <span style="font-weight:700;color:<?= $dP>80?'#ef4444':'var(--text-main)' ?>"><?= $dU ?> / <?= $dT ?> GB (<?= $dP ?>%)</span>
                </div>
                <div style="background:#e2e8f0;border-radius:20px;height:9px;overflow:hidden">
                    <div style="height:100%;width:<?= $dP ?>%;background:<?= $dP>80?'#ef4444':($dP>60?'#f59e0b':'#22c55e') ?>;border-radius:20px;transition:width .6s"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Donations -->
<div class="db-card" style="margin-bottom:1.5rem">
    <div class="db-card-header">
        <div class="db-card-title"><div class="icon-box" style="background:#fff0f9;color:#db2777"><i class="fas fa-heart"></i></div>Recent Donations</div>
        <a href="<?= URLROOT ?>/admin/donations" class="db-view-link">View All <i class="fas fa-arrow-right" style="font-size:.6rem"></i></a>
    </div>
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:.85rem">
            <thead><tr style="background:#f8fafc">
                <th style="padding:10px 1.5rem;text-align:left;font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em">Donor</th>
                <th style="padding:10px 1.5rem;text-align:left;font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Amount</th>
                <th style="padding:10px 1.5rem;text-align:left;font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Purpose</th>
                <th style="padding:10px 1.5rem;text-align:left;font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Status</th>
            </tr></thead>
            <tbody>
                <?php if (empty($data['recent_donations'])): ?>
                <tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--text-muted)">No donations found.</td></tr>
                <?php else: ?>
                <?php foreach ($data['recent_donations'] as $don):
                    $sb=['completed'=>['#dcfce7','#166534'],'pending'=>['#fef9c3','#92400e'],'failed'=>['#fee2e2','#991b1b']][$don['status']]??['#f1f5f9','#64748b'];
                ?>
                <tr style="border-top:1px solid #f1f5f9">
                    <td style="padding:12px 1.5rem"><div style="font-weight:700;color:#1e293b"><?= htmlspecialchars($don['donor_name']) ?></div><div style="font-size:.72rem;color:#94a3b8"><?= date('d M Y', strtotime($don['created_at'])) ?></div></td>
                    <td style="padding:12px 1.5rem;font-weight:800;color:#2563eb">৳<?= number_format($don['amount'],2) ?></td>
                    <td style="padding:12px 1.5rem;color:#475569;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($don['purpose']?:'সাধারণ দান') ?></td>
                    <td style="padding:12px 1.5rem"><span style="background:<?= $sb[0] ?>;color:<?= $sb[1] ?>;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:20px;text-transform:capitalize"><?= $don['status'] ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const cd={responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}}};
new Chart(document.getElementById('weekChart'),{type:'line',data:{labels:<?= json_encode($data['chartData']['labels']) ?>,datasets:[{data:<?= json_encode($data['chartData']['data']) ?>,borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,.08)',borderWidth:2.5,tension:.4,fill:true,pointBackgroundColor:'#2563eb',pointBorderColor:'#fff',pointRadius:4,pointHoverRadius:6}]},options:{...cd,scales:{y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'rgba(0,0,0,.04)'}},x:{grid:{display:false}}}}});
new Chart(document.getElementById('monthChart'),{type:'bar',data:{labels:<?= json_encode($data['monthly_chart']['labels']) ?>,datasets:[{data:<?= json_encode($data['monthly_chart']['data']) ?>,backgroundColor:'rgba(16,185,129,.75)',borderRadius:6,borderSkipped:false}]},options:{...cd,scales:{y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'rgba(0,0,0,.04)'}},x:{grid:{display:false},ticks:{font:{size:10}}}}}});
new Chart(document.getElementById('catDonut'),{type:'doughnut',data:{labels:<?= json_encode(array_column($data['category_distribution'],'name')) ?>,datasets:[{data:<?= json_encode(array_column($data['category_distribution'],'post_count')) ?>,backgroundColor:['#2563eb','#8b5cf6','#ec4899','#f97316','#22c55e','#06b6d4','#f59e0b','#ef4444'],borderWidth:2,borderColor:'#fff',hoverOffset:6}]},options:{...cd,cutout:'65%',plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>` ${c.label}: ${c.parsed} posts`}}}}});
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
