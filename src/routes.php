<?php

use Slim\App;
use App\Controllers\EquipoController;
use App\Controllers\JugadorController;

return function (App $app) {
    $app->post('/equipos', [EquipoController::class, 'store']);
    $app->get('/equipos', [EquipoController::class, 'index']);

    $app->post('/jugadores', [JugadorController::class, 'store']);
    $app->get('/jugadores/{id}', [JugadorController::class, 'show']);
};
