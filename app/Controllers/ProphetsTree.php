<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ModuleModel;
use App\Models\ProphetsTreeModel;
use App\Models\PostModel;
use App\Models\AdminModel;

class ProphetsTree extends Controller {

    public function index() {
        $moduleModel = new ModuleModel();
        $prophetsTreeModel = new ProphetsTreeModel();
        $postModel = new PostModel();
        $adminModel = new AdminModel();

        $module = $moduleModel->getModuleBySlug('prophets-tree');
        if (!$module) {
            $module = $moduleModel->getModuleById(3);
        }

        $data = [
            'title'            => $module['title'] ?? 'নবীদের পূর্ণাঙ্গ নসবনামা (Prophets Tree)',
            'module'           => $module,
            'tree_meta'        => $prophetsTreeModel->getTreeMetadata(),
            'prophetsDB'       => $prophetsTreeModel->getProphetsData(),
            'all_modules'      => $moduleModel->getActiveModules(),
            'popular_posts'    => $postModel->getPopularPosts(5),
            'breaking_news'    => $adminModel->getBreakingNews(),
            'settings'         => $adminModel->getSettings(),
            'menus'            => $adminModel->getMenus(),
            'sub_menus'        => $adminModel->getSubMenus(),
            'prayer_times'     => $adminModel->getPrayerTimes(),
            'sidebar_slides'   => $adminModel->getSidebarSlides(),
            'recent_questions' => $adminModel->getUserQuestions(5, 'answered'),
            'recent_posts'     => $postModel->getAllPosts(5)
        ];

        return $this->view('home/module_detail', $data);
    }
}
