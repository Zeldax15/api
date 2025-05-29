<?php

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

// Middleware para errores
$app->addErrorMiddleware(true, true, true);

// Incluir las rutas
(require __DIR__ . '/../src/routes.php')($app);

$app->run();
