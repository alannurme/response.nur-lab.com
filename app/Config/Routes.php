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
$routes->get('prophets-tree', 'ProphetsTree::index');
$routes->get('profet-tree', 'ProphetsTree::index');
$routes->get('open_database', 'Home::open_database');
$routes->get('open-database', 'Home::open_database');

// Islamic Data DB API Routes
$routes->get('api/quran/surah', 'Home::api_quran_surah');
$routes->get('api/quran/tafsir', 'Home::api_quran_tafsir');
$routes->get('api/hadith/books', 'Home::api_hadith_books');
$routes->get('api/hadith/chapters', 'Home::api_hadith_chapters');
$routes->get('api/hadith/list', 'Home::api_hadith_list');

// Admin Routes
$routes->get('admin', 'Admin::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/posts', 'Admin::posts');
$routes->get('admin/open_database', 'Admin::open_database');
$routes->get('admin/open_database_add', 'Admin::open_database_add');
$routes->get('admin/open_database_records', 'Admin::open_database_records');
$routes->get('admin/open_database_verification', 'Admin::open_database_verification');
// AJAX Live Search Routes
$routes->get('ajax_search', 'Home::ajax_search');
$routes->post('ajax_search', 'Home::ajax_search');
$routes->get('admin/ajax_search_posts', 'Admin::ajax_search_posts');
$routes->post('admin/ajax_search_posts', 'Admin::ajax_search_posts');

$routes->add('admin/(:any)', 'Admin::$1');
$routes->add('(:any)', 'Home::$1');

