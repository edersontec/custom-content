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
$routes->get('/campanhas', 'CampanhasController::index');
