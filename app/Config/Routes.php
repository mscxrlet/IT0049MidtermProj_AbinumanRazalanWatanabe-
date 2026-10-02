<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('products', 'Products::index');
$routes->get('products/new', 'Products::add');
$routes->post('products/create', 'Products::create');
$routes->get('products/edit/(:num)', 'Products::edit/$1');
$routes->post('products/update/(:num)', 'Products::update/$1');
$routes->post('products/delete/(:num)', 'Products::delete/$1');
