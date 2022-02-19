<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// api function
function apiRouter(String $controller, array $option = []) {
	return [
		'controller' => $controller,
		'only' => $option ? $option : ['index', 'show', 'create', 'update', 'delete']
	];
}

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', function() {
	return view('index');
});

// RESTful API
$routes->resource('/api/user', apiRouter('\App\Controllers\Api\UserController'));
$routes->resource('/api/kamar', apiRouter('\App\Controllers\Api\KamarController'));
$routes->resource('/api/tipe-kamar', apiRouter('\App\Controllers\Api\TipeKamarController'));
$routes->resource('/api/pesanan', apiRouter('\App\Controllers\Api\PesananController'));
$routes->resource('/api/ulasan', apiRouter('\App\Controllers\Api\UlasanController', ['index', 'create']));
$routes->resource('/api/galeri', apiRouter('\App\Controllers\Api\GaleriController', ['index', 'create', 'delete']));

$routes->post('/api/login', '\App\Controllers\Api\UserController::login');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
