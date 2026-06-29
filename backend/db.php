<?php
$host = 'localhost';
$db   = 'decodelabs_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (\PDOException $e) {
    // Graceful Failure: Poora system crash nahi hoga, sirf message aayega
    http_response_code(503); // Service Unavailable
    echo json_encode(["error" => "System Resilience Protocol: Database connection failed."]);
    exit;
}
?>