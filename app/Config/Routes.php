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
$routes->get('posts', 'Home::redirectBlog');
$routes->get('posts/(:any)', 'Home::redirectBlog/$1');

$routes->get('home/module/(:any)', 'Home::module/$1');
$routes->get('module/(:any)', 'Home::module/$1');
$routes->get('prophets-tree', 'ProphetsTree::index');
$routes->get('profet-tree', 'ProphetsTree::index');

// Admin Routes
$routes->get('admin', 'Admin::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/posts', 'Admin::posts');
$routes->add('admin/(:any)', 'Admin::$1');
$routes->add('(:any)', 'Home::$1');

