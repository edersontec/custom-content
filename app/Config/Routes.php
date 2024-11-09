<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/contatos', 'ContatosController::index');
$routes->get('/contatos/novo', 'ContatosController::novo');
$routes->get('/contatos/editar/(:num)', 'ContatosController::editar/$1');
$routes->get('/contatos/excluir/(:num)', 'ContatosController::excluir/$1');
$routes->post('/contatos/salvar', 'ContatosController::salvar');

$routes->get('/templates', 'TemplatesController::index');
$routes->get('/templates/novo', 'TemplatesController::novo');
$routes->get('/templates/editar/(:num)', 'TemplatesController::editar/$1');
$routes->get('/templates/excluir/(:num)', 'TemplatesController::excluir/$1');
$routes->post('/templates/salvar', 'TemplatesController::salvar');

$routes->get('/campanhas', 'CampanhasController::index');
$routes->get('/campanhas/novo', 'CampanhasController::novo');
$routes->get('/campanhas/editar/(:num)', 'CampanhasController::editar/$1');
$routes->get('/campanhas/excluir/(:num)', 'CampanhasController::excluir/$1');
$routes->post('/campanhas/salvar', 'CampanhasController::salvar');


