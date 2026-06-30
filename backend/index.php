<?php
// Persistence Layer: Database connection include karna
require 'db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// PDF Rule: Allow all 4 CRUD methods (GET, POST, PUT, DELETE)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$basePath = '/index.php';
// parse_url ensures query strings don't break our route mapping
$routePath = parse_url($requestUri, PHP_URL_PATH);
$route = str_replace($basePath, '', $routePath);
$route = rtrim($route, '/');

if ($route === '/users') {
    
    // 1. READ = HTTP GET = SQL SELECT
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT id, name, email FROM users");
        $users = $stmt->fetchAll();
        
        http_response_code(200);
        echo json_encode([
            "message" => "Data retrieval from persistence layer active",
            "data" => $users
        ]);
    } 
    
    // 2. CREATE = HTTP POST = SQL INSERT
    elseif ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Syntactic Validation Failed: Malformed JSON."]);
            exit;
        }

        if (!isset($data['name']) || trim($data['name']) === '' || !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "Semantic Validation Failed: Invalid name or email format."]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([trim($data['name']), filter_var($data['email'], FILTER_SANITIZE_EMAIL)]);

        http_response_code(201);
        echo json_encode([
            "message" => "Resource creation successful in database.",
            "user_id" => $pdo->lastInsertId()
        ]);
    } 
    
    // 3. UPDATE = HTTP PUT = SQL UPDATE
    elseif ($method === 'PUT') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        // Validation: Update karne ke liye 'id' ka hona zaroori hai
        if ($data === null || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "Validation Failed: Malformed JSON or User ID missing."]);
            exit;
        }

        if (!isset($data['name']) || trim($data['name']) === '' || !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "Semantic Validation Failed: Invalid name or email format."]);
            exit;
        }

        // The Shield: Parameterized Query for Update
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([trim($data['name']), filter_var($data['email'], FILTER_SANITIZE_EMAIL), $data['id']]);

        http_response_code(200);
        echo json_encode(["message" => "Resource successfully updated in database."]);
    }

    // 4. DELETE = HTTP DELETE = SQL DELETE
    elseif ($method === 'DELETE') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        // Validation: Delete karne ke liye sirf 'id' chahiye
        if ($data === null || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "Validation Failed: Malformed JSON or User ID missing."]);
            exit;
        }

        // The Shield: Parameterized Query for Delete
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$data['id']]);

        http_response_code(200);
        echo json_encode(["message" => "Resource successfully deleted from database."]);
    }
    
    else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid method mapping"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Resource not found within the organism"]);
}