<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Auth::login');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // Products
    $routes->get('products', 'Products::index');
    $routes->get('products/new', 'Products::add');
    $routes->post('products/create', 'Products::create');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->post('products/delete/(:num)', 'Products::delete/$1');

    // Customers
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::add');
    $routes->post('customers/create', 'Customers::create');
    $routes->get('customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('customers/update/(:num)', 'Customers::update/$1');
    $routes->post('customers/delete/(:num)', 'Customers::delete/$1');

    // Staff
    $routes->get('staff', 'Staff::index');
    $routes->get('staff/new', 'Staff::add');
    $routes->post('staff/create', 'Staff::create');
    $routes->get('staff/edit/(:num)', 'Staff::edit/$1');
    $routes->post('staff/update/(:num)', 'Staff::update/$1');
    $routes->post('staff/delete/(:num)', 'Staff::delete/$1');
<<<<<<< HEAD

    // Sales
    $routes->get('sales', 'Sales::index');
    $routes->get('sales/new', 'Sales::create');
    $routes->post('sales/store', 'Sales::store');
});
=======
});

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');
$routes->get('products', 'Products::index');
$routes->get('products/new', 'Products::add');
$routes->post('products/create', 'Products::create');
$routes->get('products/edit/(:num)', 'Products::edit/$1');
$routes->post('products/update/(:num)', 'Products::update/$1');
$routes->post('products/delete/(:num)', 'Products::delete/$1');

$routes->get('sales', 'Sales::index'); 
$routes->get('sales/new', 'Sales::create');
$routes->post('sales/store', 'Sales::store');  
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
