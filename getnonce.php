<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/seal/lib.php'); 
require_login();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');  // Permite solicitudes desde cualquier dominio (útil para CORS)
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');  // Permite los métodos POST, GET, y OPTIONS
header('Access-Control-Allow-Headers: Content-Type, Authorization');  // Permite los encabezados de Content-Type y Authorization

$userAddress = required_param('userAddress', PARAM_TEXT);

if (empty($userAddress)) {
    http_response_code(400);
    echo json_encode(['error' => 'User address is required']);
    exit;
}

try {
    $nonce = fetch_nonce_from_api($userAddress);
    echo json_encode(['nonce' => $nonce]);
} catch (Exception $e) {
    error_log("Error fetching nonce: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
exit;