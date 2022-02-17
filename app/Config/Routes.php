<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->group('blog', function ($routes) {
    $routes->get('blog', 'BlogController::index');
    $routes->post('create', 'BlogController::create');
    $routes->add('show/(:any)', 'BlogController::show/$1');
    $routes->add('update/(:any)', 'BlogController::update/$1');
    $routes->delete('delete/(:any)', 'BlogController::delete/$1');
});

$routes->group('auth', function ($routes) {
    $routes->post('register', 'UserController::register');
    $routes->post('login', 'UserController::login');
    $routes->get('profile', 'UserController::detail');
});



if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
