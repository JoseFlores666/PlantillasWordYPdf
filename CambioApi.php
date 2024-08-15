<?php
$allowed_origins = [
    'http://localhost:5173',
    'https://frontend-wheat-psi.vercel.app'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apiKey'])) {
    $apiKey = $_POST['apiKey'];
    
    $file = 'api_key.txt';
    file_put_contents($file, $apiKey);

    echo "API Key guardado correctamente en $file";
} else {
    echo "No se ha recibido el dato correctamente.";
}
?>
