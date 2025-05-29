<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class JugadorController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    }

    public function store(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        $stmt = $this->pdo->prepare("INSERT INTO jugadores (nombres, apellidos, fechaNacimiento, genero, posicion, idEquipo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $params['nombres'],
            $params['apellidos'],
            $params['fechaNacimiento'],
            $params['genero'],
            $params['posicion'],
            $params['idEquipo']
        ]);

        $response->getBody()->write(json_encode(['message' => 'Jugador creado']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $stmt = $this->pdo->prepare("SELECT * FROM jugadores WHERE idJugador = ?");
        $stmt->execute([$id]);
        $jugador = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($jugador) {
            $response->getBody()->write(json_encode($jugador));
        } else {
            $response->getBody()->write(json_encode(['message' => 'Jugador no encontrado']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
