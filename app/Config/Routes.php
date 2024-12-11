<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('',['filters'=>'AuthCheck'],function($routes){
    $routes->get('/UserTable', 'User::index');
    $routes->get('/UserTable/delete/(:num)' , 'User::deleteUser/$1');     
    $routes->match(['post','get'],'/AddUser','User::AddUser');
    $routes->get('/UserTable/Update/(:num)','user::UpdateUser/$1');
    $routes->post('/UserTable/Update/(:num)','user::UpdateUser/$1');
    $routes->post('/filter', 'user::filter');
    $routes->post('/UserTable','User::AddUser');
    $routes->post('/UserTable/DeleteSelected','User::deleteSelected');
    $routes->get('/logout','auth::logout');
    $routes->get('/download','user::download');
    $routes->match(['post','get'],'/Upload','user::Upload');
});

$routes->get('/test', 'user::test');
$routes->match(['post','get'],'/login','auth::login');
$routes->match(['post','get'],'/signup','auth::signup');

?>