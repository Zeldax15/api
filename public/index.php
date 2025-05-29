<?php
echo "<pre>";
print_r($_ENV);
exit;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$this->pdo = new PDO(
    "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);


$app = AppFactory::create();

// Middleware para errores
$app->addErrorMiddleware(true, true, true);

// Incluir las rutas
(require __DIR__ . '/../src/routes.php')($app);

$app->run();
