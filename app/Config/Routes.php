<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas API Rest
$routes->group('api/v1', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    // SONGS
    $routes->post('auth/login', 'Auth::login');
    $routes->get('songs', 'SongController::index');
    $routes->get('songs/(:num)', 'SongController::show/$1');
    $routes->get('songs/edit/(:num)', 'SongController::edit/$1');
    $routes->put('songs/update/(:num)', 'SongController::update/$1', ['filter' => 'AuthFilter']);
    $routes->get('search/(:any)', 'SongController::search/$1');

    // USERS
    $routes->get('user/(:segment)', 'UserController::show/$1');
});


$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('new', 'SongController::new');
    $routes->get('settings', 'SettingController::index');
    $routes->get('test', 'Home::test');
});

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('signup', 'Auth::signup');
});
$routes->post('save', 'Auth::save');
$routes->post('check', 'Auth::check');
$routes->post('logout', 'Auth::logout');

$routes->get('search', 'SearchController::index');

$routes->post('roles/updatePermissions', 'RoleController::updatePermissions');

// Rutas para las canciones
$routes->get('songs', 'SongController::index');
$routes->get('songs/(:num)', 'SongController::show/$1');
$routes->post('songs', 'SongController::create');
$routes->put('updateLyrics/(:num)', 'SongController::updateLyrics/$1');
$routes->put('updateMetadata/(:num)', 'SongController::updateMetadata/$1');
$routes->delete('songs/(:num)', 'SongController::delete/$1');

// Rutas para comentarios
$routes->post('comments', 'CommentController::create');
$routes->delete('comments/(:num)', 'CommentController::delete/$1');

// Rutas para artistas
$routes->get('artists', 'ArtistController::index');
$routes->get('artists/(:num)', 'ArtistController::show/$1');
$routes->get('getartists', 'ArtistController::getArtists');

// Rutas para los usuarios
$routes->post('updaterole/(:num)', 'UserController::updateRole/$1');
$routes->post('moderate/(:num)', 'UserController::moderate/$1');
// $routes->get('users/(:num)', 'UserController::show/$1');
$routes->get('user/(:segment)', 'UserController::show/$1');
