<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// Admin Routes
$routes->group('admin', ['filter' => 'group:admin,superadmin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    // Photos
    $routes->get('heroes/(:num)/photos', 'Admin\HeroController::photos/$1');
    $routes->post('heroes/(:num)/photos', 'Admin\HeroController::uploadPhoto/$1');
    $routes->post('heroes/(:num)/photos/order', 'Admin\HeroController::updatePhotoOrder/$1');
    $routes->post('heroes/photos/(:num)/delete', 'Admin\HeroController::deletePhoto/$1');
    
    // CTA
    $routes->get('heroes/(:num)/cta', 'Admin\HeroController::cta/$1');
    $routes->post('heroes/(:num)/cta', 'Admin\HeroController::updateCta/$1');

    // Scheduling
    $routes->get('heroes/(:num)/schedule', 'Admin\ScheduleController::index/$1');
    $routes->post('heroes/(:num)/schedule', 'Admin\ScheduleController::store/$1');
    $routes->post('heroes/(:num)/schedule/bulk', 'Admin\ScheduleController::bulk/$1');
    $routes->post('schedules/(:num)/delete', 'Admin\ScheduleController::delete/$1');

    // Intentions
    $routes->get('intentions', 'Admin\IntentionController::index');
    $routes->post('intentions/(:num)/delete', 'Admin\IntentionController::delete/$1');

    // Hero CRUD
    $routes->resource('heroes', ['controller' => 'Admin\HeroController', 'websafe' => 1]);

    // Global Bookings
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->post('bookings/(:num)/delete', 'Admin\BookingController::delete/$1');
    // Packages
    $routes->resource('packages', ['controller' => 'Admin\PackageController', 'websafe' => 1]);

    // Client Projects
    $routes->resource('client-projects', ['controller' => 'Admin\ClientProjectController', 'websafe' => 1]);
    $routes->get('client-projects/(:num)/photos', 'Admin\ClientProjectController::photos/$1');
    $routes->post('client-projects/(:num)/sync-s3', 'Admin\ClientProjectController::syncS3/$1');
});

// Public Intentions
$routes->post('intentions/store', 'IntentionController::store');

// Public Scheduling
$routes->get('schedule/slots/(:num)', 'ScheduleController::getSlots/$1');
$routes->post('schedule/book', 'ScheduleController::book');

// Client Portal (Requires Auth, role: client/jogador in this project context - using default auth filter)
$routes->group('client', ['filter' => 'session'], static function ($routes) {
    $routes->get('galeria', 'Client\GaleriaController::index');
    $routes->get('galeria/(:num)', 'Client\GaleriaController::view/$1');
    $routes->post('galeria/(:num)/save', 'Client\GaleriaController::saveSelection/$1');
    $routes->get('galeria/(:num)/checkout', 'Client\GaleriaController::checkout/$1');
});

// Front-end hero page by slug (Must be last so it doesn't override admin or auth routes)
$routes->get('(:segment)', 'HeroPage::view/$1', ['priority' => 99]);
