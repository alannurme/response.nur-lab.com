<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Main Routes
$routes->get('/', 'Home::index');
$routes->get('sitemap.xml', 'Home::sitemap');
$routes->get('q&a', 'Home::qa');
$routes->get('p/(:num)', 'Home::redirectPostById/$1');
$routes->post('comment/(:num)', 'Home::comment/$1');
$routes->get('posts', 'Home::redirectBlog');
$routes->get('posts/(:any)', 'Home::redirectBlog/$1');

$routes->get('home/module/(:any)', 'Home::module/$1');
$routes->get('module/(:any)', 'Home::module/$1');
$routes->get('sirat', 'Home::sirat');
$routes->get('seerah', 'Home::sirat');
$routes->get('prophets-tree', 'ProphetsTree::index');
$routes->get('profet-tree', 'ProphetsTree::index');
$routes->get('records', 'Home::records');
$routes->get('open_database', 'Home::open_database');
$routes->get('open-database', 'Home::open_database');

// Islamic Data DB API Routes
$routes->get('api/quran/surah', 'Home::api_quran_surah');
$routes->get('api/quran/tafsir', 'Home::api_quran_tafsir');
$routes->get('api/hadith/books', 'Home::api_hadith_books');
$routes->get('api/hadith/chapters', 'Home::api_hadith_chapters');
$routes->get('api/hadith/list', 'Home::api_hadith_list');
$routes->get('home/check_yt_live_ajax', 'Home::check_yt_live_ajax');
$routes->get('api/check_yt_live', 'Home::check_yt_live_ajax');

// Admin Routes
$routes->get('admin', 'Admin::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/posts', 'Admin::posts');
$routes->match(['GET', 'POST'], 'admin/questions', 'Admin::questions');
$routes->match(['GET', 'POST'], 'admin/add_question', 'Admin::add_question');
// Seerah Books Routes
$routes->match(['GET', 'POST'], 'admin/seerah_books', 'Admin::seerah_books');
$routes->match(['GET', 'POST'], 'admin/add_seerah_book', 'Admin::add_seerah_book');
$routes->match(['GET', 'POST'], 'admin/edit_seerah_book/(:num)', 'Admin::edit_seerah_book/$1');
$routes->match(['GET', 'POST'], 'admin/delete_seerah_book/(:num)', 'Admin::delete_seerah_book/$1');

// Records Routes
$routes->match(['GET', 'POST'], 'admin/records', 'Admin::records');
$routes->get('admin/records_add', 'Admin::records_add');
$routes->match(['GET', 'POST'], 'admin/records_edit/(:num)', 'Admin::records_edit/$1');
$routes->match(['GET', 'POST'], 'admin/records_delete/(:num)', 'Admin::records_delete/$1');
$routes->match(['GET', 'POST'], 'admin/records_delete', 'Admin::records_delete');
$routes->get('admin/records_persons', 'Admin::records_persons');
$routes->get('admin/records_person_view/(:num)', 'Admin::records_person_view/$1');
$routes->match(['GET', 'POST'], 'admin/records_person_delete/(:num)', 'Admin::records_person_delete/$1');
$routes->get('admin/records_categories', 'Admin::records_categories');
$routes->post('admin/records_categories_save', 'Admin::records_categories_save');
$routes->get('admin/records_categories_delete/(:num)', 'Admin::records_categories_delete/$1');
$routes->post('admin/records_categories_delete/(:num)', 'Admin::records_categories_delete/$1');
$routes->post('admin/records_categories_delete', 'Admin::records_categories_delete');
$routes->get('admin/records_verification', 'Admin::records_verification');

// Legacy Open Database Routes (Redirect / Aliases)
$routes->get('admin/open_database', 'Admin::open_database');
$routes->get('admin/open_database_add', 'Admin::open_database_add');
$routes->get('admin/open_database_records', 'Admin::open_database_records');
$routes->get('admin/open_database_categories', 'Admin::open_database_categories');
$routes->post('admin/open_database_categories_save', 'Admin::open_database_categories_save');
$routes->get('admin/open_database_categories_delete/(:num)', 'Admin::open_database_categories_delete/$1');
$routes->post('admin/open_database_categories_delete/(:num)', 'Admin::open_database_categories_delete/$1');
$routes->post('admin/open_database_categories_delete', 'Admin::open_database_categories_delete');
$routes->get('admin/open_database_verification', 'Admin::open_database_verification');
$routes->get('admin/storage_settings', 'Admin::storage_settings');
$routes->post('admin/storage_settings', 'Admin::storage_settings');
$routes->get('admin/gdrive_oauth_init', 'Admin::gdrive_oauth_init');
$routes->get('admin/gdrive_oauth_callback', 'Admin::gdrive_oauth_callback');
$routes->post('admin/test_gdrive_connection', 'Admin::test_gdrive_connection');
// AJAX Live Search Routes
$routes->get('ajax_search', 'Home::ajax_search');
$routes->post('ajax_search', 'Home::ajax_search');
$routes->get('admin/ajax_search_posts', 'Admin::ajax_search_posts');
$routes->post('admin/ajax_search_posts', 'Admin::ajax_search_posts');
$routes->get('admin/ajax_all_posts_index', 'Admin::ajax_all_posts_index');
$routes->match(['GET', 'POST'], 'admin/create_category_ajax', 'Admin::create_category_ajax');

// Media Fallback & Proxy for Google Drive (preserves legacy links in posts)
$routes->get('img/(:any)', 'Home::mediaFallback/img/$1');
$routes->get('public/img/(:any)', 'Home::mediaFallback/public/img/$1');
$routes->get('uploads/(:any)', 'Home::mediaFallback/uploads/$1');
$routes->get('public/uploads/(:any)', 'Home::mediaFallback/public/uploads/$1');

// Admin Media Migration Routes
$routes->match(['GET', 'POST'], 'admin/api_migrate_to_gdrive', 'Admin::api_migrate_to_gdrive');
$routes->match(['GET', 'POST'], 'admin/api_migrate_from_gdrive', 'Admin::api_migrate_from_gdrive');

$routes->add('admin/(:segment)/(:segment)/(:any)', 'Admin::$1/$2/$3');
$routes->add('admin/(:segment)/(:any)', 'Admin::$1/$2');
$routes->add('admin/(:any)', 'Admin::$1');
$routes->add('(:any)', 'Home::$1');

