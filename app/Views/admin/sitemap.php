<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header">
    <div>
        <h1 style="font-family: 'Outfit', sans-serif !important; text-transform: none !important; letter-spacing: normal !important;">Sitemap XML Configuration</h1>
        <p style="font-family: 'Inter', sans-serif !important; text-transform: none !important; letter-spacing: normal !important;">Monitor, update, and manage your website's sitemap.xml file to help search engines crawl and index all your pages correctly.</p>
    </div>
</div>

<?php if (isset($data['success'])): ?>
    <div class="alert alert-success" style="font-family: 'Inter', sans-serif !important;"><i class="fas fa-check-circle"></i> <?= $data['success'] ?></div>
<?php endif; ?>

<?php if (isset($data['error'])): ?>
    <div class="alert alert-danger" style="font-family: 'Inter', sans-serif !important;"><i class="fas fa-exclamation-circle"></i> <?= $data['error'] ?></div>
<?php endif; ?>

<div class="dashboard-two-col" style="font-family: 'Inter', sans-serif !important;">
    <!-- Left Column: Settings and Action -->
    <div style="display : flex; flex-direction: column; gap: 30px;">
        <div class="settings-container" style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 25px; padding-bottom: 15px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-sitemap" style="color: var(--primary); font-size: 1.4rem;"></i>
                    <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main); text-transform: none !important; letter-spacing: normal !important;">Sitemap XML Status</h3>
                </div>
                <span style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #0369a1; display: inline-block;"></span> Dynamic Auto-Update Active
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                <div style="padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em;">Sitemap Status</span>
                    <span style="color: #10b981; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; text-transform: none !important;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: inline-block;"></span> Dynamic & Live
                    </span>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em;">Last Modified</span>
                    <span style="color: var(--text-main); font-weight: 700; font-size: 1.1rem; text-transform: none !important;">
                        <?php echo $data['sitemap_last_modified']; ?>
                    </span>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em;">File Size</span>
                    <span style="color: var(--text-main); font-weight: 700; font-size: 1.1rem; text-transform: none !important;">
                        <?php echo $data['sitemap_size']; ?>
                    </span>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em;">Sitemap URL</span>
                    <a href="<?php echo URLROOT; ?>/sitemap.xml" target="_blank" style="color: var(--primary); font-weight: 600; font-size: 0.95rem; text-decoration: none; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; display: block; text-transform: none !important;">
                        <?php echo URLROOT; ?>/sitemap.xml <i class="fas fa-external-link-alt" style="font-size: 0.75rem; margin-left: 2px;"></i>
                    </a>
                </div>
            </div>

            <form action="<?php echo URLROOT; ?>/admin/sitemap" method="POST" style="margin: 0;">
                <input type="hidden" name="generate" value="1">
                <button type="submit" class="btn btn-save" style="background: var(--primary); color: white; padding: 15px 40px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15); display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; font-family: 'Inter', sans-serif !important; text-transform: none !important;">
                    <i class="fas fa-sync-alt"></i> Regenerate sitemap.xml
                </button>
            </form>
        </div>

        <div style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 20px; padding-bottom: 12px;">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main); text-transform: none !important;">Why is a Sitemap important?</h3>
            </div>
            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 15px;">
                A Sitemap is an XML file that lists URLs for a site along with additional metadata about each URL (when it was last updated, how often it changes, and how important it is in relation to other URLs in the site) so that search engines can more intelligently crawl the site.
            </p>
            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px; text-transform: none !important;">Search Engines Submission:</h4>
            <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                Submit the sitemap URL (<strong><?php echo URLROOT; ?>/sitemap.xml</strong>) directly to Google Search Console and Bing Webmaster Tools to accelerate indexes of your newly created blog posts, categories, and products.
            </p>
        </div>
    </div>

    <!-- Right Column: Content Summary in Sitemap -->
    <div style="background: #ffffff; color: var(--text-main); border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <div style="border-bottom: 1px solid #f1f5f9; margin-bottom: 25px; padding-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chart-pie" style="color: var(--primary); font-size: 1.4rem;"></i>
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main); text-transform: none !important;">Included in Sitemap</h3>
        </div>

        <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 25px;">Here is a breakdown of content elements queried dynamically to compile the sitemap:</p>

        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-home" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 600;">Core Static Pages</span>
                </div>
                <span style="font-weight: 700; background: #eff6ff; color: var(--primary); padding: 4px 12px; border-radius: 8px; font-size: 0.85rem;">10 URLs</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-newspaper" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 600;">Published Posts</span>
                </div>
                <span style="font-weight: 700; background: #eff6ff; color: var(--primary); padding: 4px 12px; border-radius: 8px; font-size: 0.85rem;"><?php echo $data['count_posts']; ?> URLs</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-folder" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 600;">Post Categories</span>
                </div>
                <span style="font-weight: 700; background: #eff6ff; color: var(--primary); padding: 4px 12px; border-radius: 8px; font-size: 0.85rem;"><?php echo $data['count_categories']; ?> URLs</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-question-circle" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 600;">Answered Q&amp;A Questions</span>
                </div>
                <span style="font-weight: 700; background: #eff6ff; color: var(--primary); padding: 4px 12px; border-radius: 8px; font-size: 0.85rem;"><?php echo $data['count_questions']; ?> URLs</span>
            </div>
        </div>
    </div>
</div>

<style>
    .alert {
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(37, 99, 235, 0.25) !important; }
    
    @media (max-width: 992px) {
        .dashboard-two-col {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
    }
</style>

<?php require APPROOT . '/Views/admin/footer.php'; ?>