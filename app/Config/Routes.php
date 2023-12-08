<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('new', 'SongController::new');
});

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('signup', 'Auth::signup');
});
$routes->post('save', 'Auth::save');
$routes->post('check', 'Auth::check');
$routes->post('logout', 'Auth::logout');

$routes->get('search', 'SearchController::index');

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

// Rutas API Rest Songs
$routes->post('api/v1/auth/login', ['controller' => 'Api\AuthController::login']);
$routes->resource('api/v1/songs', ['controller' => 'Api\SongController']);

// Rutas para artistas
$routes->get('artists', 'ArtistController::index');
$routes->get('artists/(:num)', 'ArtistController::show/$1');
$routes->get('getartists', 'ArtistController::getArtists');

// Rutas para los usuarios
$routes->post('promote', 'UserController::promote');
// $routes->get('users/(:num)', 'UserController::show/$1');
$routes->get('user/(:segment)', 'UserController::show/$1');
