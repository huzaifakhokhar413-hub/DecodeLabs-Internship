<?php
// Persistence Layer: Database connection include karna
require 'db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$basePath = '/index.php';
$route = str_replace($basePath, '', parse_url($requestUri, PHP_URL_PATH));
$route = rtrim($route, '/');

if ($route === '/users') {
    
    // GET: Database se real data fetch karna
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT id, name, email FROM users");
        $users = $stmt->fetchAll();
        
        http_response_code(200);
        echo json_encode([
            "message" => "Data retrieval from persistence layer active",
            "data" => $users
        ]);
    } 
    
    // POST: Database mein real data save karna
    elseif ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        // 1. Syntactic Validation
        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Syntactic Validation Failed: Malformed JSON."]);
            exit;
        }

        // 2. Semantic Validation
        if (!isset($data['name']) || trim($data['name']) === '' || !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "Semantic Validation Failed: Invalid name or email format."]);
            exit;
        }

        // Database Insertion (Persistence Layer)
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([trim($data['name']), filter_var($data['email'], FILTER_SANITIZE_EMAIL)]);

        http_response_code(201);
        echo json_encode([
            "message" => "Resource creation successful in database.",
            "user_id" => $pdo->lastInsertId()
        ]);
    } 
    
    else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid method mapping"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Resource not found within the organism"]);
}