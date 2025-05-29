<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EquipoController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    }

    public function index(Request $request, Response $response): Response
    {
        $stmt = $this->pdo->query("SELECT * FROM equipos");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

  public function store(Request $request, Response $response): Response
{
    // Obtener el body sin importar si es JSON o x-www-form-urlencoded
    $contentType = $request->getHeaderLine('Content-Type');
    
    if (str_contains($contentType, 'application/json')) {
        $params = json_decode($request->getBody()->getContents(), true);
    } else {
        $params = $request->getParsedBody();
    }

    // Verifica si llegaron los datos (opcional para debug)
    // var_dump($params); exit;

    $stmt = $this->pdo->prepare("INSERT INTO equipos (nombreEquipo, institucion, departamento, municipio, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $params['nombreEquipo'],
        $params['institucion'],
        $params['departamento'],
        $params['municipio'],
        $params['direccion'],
        $params['telefono']
    ]);

    $response->getBody()->write(json_encode(['message' => 'Equipo creado']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
}

}
