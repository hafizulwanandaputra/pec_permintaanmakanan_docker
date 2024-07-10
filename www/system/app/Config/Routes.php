<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// AUTH
$routes->get('/', 'Auth::index');
$routes->post('/(?i)check-login', 'Auth::check_login');
$routes->get('/(?i)logout', 'Auth::logout');

// REST API
$routes->get('admin_api', "Admin_api::index");
$routes->post("login_api", "Login_api::index");
$routes->resource('petugas_api', ['filter' => 'authfilterapi']);
$routes->resource('menu_api', ['filter' => 'authfilterapi']);
$routes->resource('permintaan_api', ['filter' => 'authfilterapi']);

// HOME
$routes->get('/(?i)home', 'Home::index');

// PERMINTAAN
$routes->get('/(?i)permintaan', 'Permintaan::index');
$routes->post('/(?i)permintaan/(?i)permintaanlist', 'Permintaan::menulist');
$routes->get('/(?i)permintaan/(?i)add', 'Permintaan::add');
$routes->post('/(?i)permintaan/(?i)create', 'Permintaan::create');
$routes->get('/(?i)permintaan/(?i)edit/(:any)', 'Permintaan::edit/$1');
$routes->post('/(?i)permintaan/(?i)update/(:any)', 'Permintaan::update/$1');
$routes->get('/(?i)permintaan/(?i)export', 'Permintaan::export');
$routes->get('/(?i)permintaan/(?i)exportexcel', 'Permintaan::exportexcel');
$routes->get('/(?i)permintaan/(?i)eticketprint/(:any)', 'Permintaan::eticketprint/$1');
$routes->delete('/(?i)permintaan/(?i)delete/(:any)', 'Permintaan::delete/$1');

// MENU
$routes->get('/(?i)menu', 'Menu::index');
$routes->post('/(?i)menu/(?i)menulist', 'Menu::menulist');
$routes->get('/(?i)menu/(?i)add', 'Menu::add');
$routes->post('/(?i)menu/(?i)create', 'Menu::create');
$routes->get('/(?i)menu/(?i)details/(:any)', 'Menu::details/$1');
$routes->get('/(?i)menu/(?i)listpermintaanmenu/(:any)', 'Menu::listpermintaanmenu/$1');
$routes->post('/(?i)menu/(?i)listpermintaanmenu/(:any)', 'Menu::listpermintaanmenu/$1');
$routes->get('/(?i)menu/(?i)addpermintaan/(:any)', 'Menu::addpermintaan/$1');
$routes->post('/(?i)menu/(?i)createpermintaan/(:any)', 'Menu::createpermintaan/$1');
$routes->get('/(?i)menu/(?i)editpermintaan/(:any)', 'Menu::editpermintaan/$1');
$routes->post('/(?i)menu/(?i)updatepermintaan/(:any)', 'Menu::updatepermintaan/$1');
$routes->get('/(?i)menu/(?i)edit/(:any)', 'Menu::edit/$1');
$routes->post('/(?i)menu/(?i)update/(:any)', 'Menu::update/$1');
$routes->get('/(?i)menu/(?i)updatecount/(:any)', 'Menu::updatecount/$1');
$routes->delete('/(?i)menu/(?i)delete/(:any)', 'Menu::delete/$1');

// PETUGAS
$routes->get('/(?i)petugas', 'Petugas::index');
$routes->post('/(?i)petugas/(?i)petugaslist', 'Petugas::petugaslist');
$routes->get('/(?i)petugas/(?i)add', 'Petugas::add');
$routes->post('/(?i)petugas/(?i)create', 'Petugas::create');
$routes->get('/(?i)petugas/(?i)edit/(:any)', 'Petugas::edit/$1');
$routes->post('/(?i)petugas/(?i)update/(:any)', 'Petugas::update/$1');
$routes->delete('/(?i)petugas/(?i)delete/(:any)', 'Petugas::delete/$1');

// ADMIN
$routes->get('/(?i)admin', 'Admin::index');
$routes->post('/(?i)admin/(?i)adminlist', 'Admin::adminlist');
$routes->get('/(?i)admin/(?i)add', 'Admin::add');
$routes->post('/(?i)admin/(?i)create', 'Admin::create');
$routes->get('/(?i)admin/(?i)edit/(:any)', 'Admin::edit/$1');
$routes->post('/(?i)admin/(?i)update/(:any)', 'Admin::update/$1');
$routes->delete('/(?i)admin/(?i)delete/(:any)', 'Admin::delete/$1');

// SETTINGS
$routes->get('/(?i)settings', 'Settings::index');

// CHANGE USER INFORMATION
$routes->get('/(?i)settings/(?i)edit', 'Settings::edit');
$routes->post('/(?i)settings/(?i)update', 'Settings::update');

// CHANGE PASSWORD
$routes->get('/(?i)settings/(?i)changepassword', 'ChangePassword::index');
$routes->post('/(?i)settings/(?i)changepassword/(?i)update', 'ChangePassword::update');

// ACTIVITY HISTORY
$routes->get('/(?i)settings/(?i)activities', 'Settings::activities');
$routes->post('/(?i)settings/(?i)activitieslist', 'Settings::activitieslist');
$routes->post('/(?i)settings/(?i)clearactivities', 'Settings::clearactivities');

// ABOUT SYSTEM
$routes->get('/(?i)settings/(?i)about', 'Settings::about');
