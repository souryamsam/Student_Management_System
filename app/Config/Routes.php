<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::login_from');
$routes->post('login', 'Home::hit_login');
$routes->get('logout', 'Home::logout');
$routes->get('/view', 'Home::view_user');
$routes->get('/add', 'Home::add_user');
$routes->post('/add', 'Home::add_user');//for single data post
$routes->post('/save_user', 'Home::save_user');
$routes->post('country_id', 'Home::fatch_state_data');
$routes->post('state_id', 'Home::fatch_city_data');
$routes->post('status', 'Home::update_status');
$routes->post('duplicate_check', 'Home::duplicate_checking');
$routes->get('upload', 'Home::from');
$routes->post('upload-from', 'Home::upload');