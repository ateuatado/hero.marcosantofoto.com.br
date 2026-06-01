<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// ─── Admin Routes ─────────────────────────────────────────────────────────────
$routes->group('admin', ['filter' => 'group:admin,superadmin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    // Photos (heróis)
    $routes->get( 'heroes/(:num)/photos',              'Admin\HeroController::photos/$1');
    $routes->post('heroes/(:num)/photos',              'Admin\HeroController::uploadPhoto/$1');
    $routes->post('heroes/(:num)/photos/order',        'Admin\HeroController::updatePhotoOrder/$1');
    $routes->post('heroes/photos/(:num)/delete',       'Admin\HeroController::deletePhoto/$1');
    $routes->post('heroes/(:num)/photos/(:num)/cover', 'Admin\HeroController::setCover/$1/$2');

    // Publicação
    $routes->post('heroes/(:num)/publish',   'Admin\HeroController::publish/$1');
    $routes->post('heroes/(:num)/unpublish', 'Admin\HeroController::unpublish/$1');

    // CTA & Landing Page Blocks
    $routes->get( 'heroes/(:num)/cta',                      'Admin\HeroController::cta/$1');
    $routes->post('heroes/(:num)/cta',                      'Admin\HeroController::updateCta/$1');
    $routes->post('heroes/(:num)/cta/blocks',               'Admin\HeroController::ctaBlockCreate/$1');
    $routes->post('heroes/(:num)/cta/blocks/(:num)',         'Admin\HeroController::ctaBlockUpdate/$1/$2');
    $routes->post('heroes/(:num)/cta/blocks/(:num)/delete',  'Admin\HeroController::ctaBlockDelete/$1/$2');
    $routes->post('heroes/(:num)/cta/blocks/order',          'Admin\HeroController::ctaBlocksOrder/$1');

    // Agendamento (por herói)
    $routes->get( 'heroes/(:num)/schedule',       'Admin\ScheduleController::index/$1');
    $routes->post('heroes/(:num)/schedule',       'Admin\ScheduleController::store/$1');
    $routes->post('heroes/(:num)/schedule/bulk',  'Admin\ScheduleController::bulk/$1');
    $routes->post('schedules/(:num)/delete',      'Admin\ScheduleController::delete/$1');

    // Intenções
    $routes->get( 'intentions',              'Admin\IntentionController::index');
    $routes->post('intentions/(:num)/delete', 'Admin\IntentionController::delete/$1');

    // Bookings globais
    $routes->get( 'bookings',              'Admin\BookingController::index');
    $routes->post('bookings/(:num)/delete', 'Admin\BookingController::delete/$1');

    // Pacotes
    $routes->resource('packages', ['controller' => 'Admin\PackageController', 'websafe' => 1]);
    $routes->resource('categories', ['controller' => 'Admin\CategoryController', 'websafe' => 1]);

    // Projetos de clientes + sync S3
    $routes->resource('client-projects', ['controller' => 'Admin\ClientProjectController', 'websafe' => 1]);
    $routes->get( 'client-projects/(:num)/photos',   'Admin\ClientProjectController::photos/$1');
    $routes->get( 'client-projects/(:num)/poll',     'Admin\ClientProjectController::pollInteractions/$1');
    $routes->post('client-projects/(:num)/sync-s3',  'Admin\ClientProjectController::syncS3/$1');

    // Hero CRUD (resource por último para não sobrescrever rotas acima)
    $routes->resource('heroes', ['controller' => 'Admin\HeroController', 'websafe' => 1]);
});

// ─── Agenda Proxy (resolve CORS/SSL server-side) ──────────────────────────────
$routes->get( 'agenda-api/availability', 'AgendaProxy::availability');
$routes->post('agenda-api/book',         'AgendaProxy::book');

// ─── Intenções públicas ────────────────────────────────────────────────────────
$routes->post('intentions/store', 'IntentionController::store');

// ─── Agendamento público ───────────────────────────────────────────────────────
$routes->get( 'schedule/slots/(:num)', 'ScheduleController::getSlots/$1');
$routes->post('schedule/book',         'ScheduleController::book');

// ─── Portal do Cliente (autenticado) ──────────────────────────────────────────
$routes->group('client', ['filter' => 'session'], static function ($routes) {
    $routes->get( 'galeria',                       'Client\GaleriaController::index');
    $routes->get( 'galeria/(:num)',                'Client\GaleriaController::view/$1');
    $routes->get( 'galeria/(:num)/poll',           'Client\GaleriaController::pollPhotos/$1');
    $routes->post('galeria/(:num)/save',           'Client\GaleriaController::saveSelection/$1');
    $routes->post('galeria/(:num)/photo/(:num)/status', 'Client\GaleriaController::togglePhotoStatus/$1/$2');
    $routes->post('galeria/(:num)/photo/(:num)/love',   'Client\GaleriaController::togglePhotoLove/$1/$2');
    $routes->post('galeria/(:num)/photo/(:num)/rate',   'Client\GaleriaController::ratePhoto/$1/$2');
    $routes->get( 'galeria/(:num)/checkout',       'Client\GaleriaController::checkout/$1');
});

// ─── Landing page de copy — /{slug}/agendar ───────────────────────────────────
// Deve vir ANTES do catch-all de slug
$routes->get('(:segment)/agendar', 'LandingPage::view/$1');

// ─── Página pública do herói por slug (catch-all — deve ser a última) ─────────
$routes->get('(:segment)', 'HeroPage::view/$1', ['priority' => 99]);
