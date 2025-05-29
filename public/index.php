<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Crear la app Slim
$app = AppFactory::create();

// Middleware de errores (útil para desarrollo y debugging)
$app->addErrorMiddleware(true, true, true);

// Incluir las rutas definidas en src/routes.php
(require __DIR__ . '/../src/routes.php')($app);

// Ejecutar la aplicación
$app->run();
