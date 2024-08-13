<?php
header("Access-Control-Allow-Origin: https://frontend-wheat-psi.vercel.app"); // Cambiado para aceptar solicitudes desde Vercel
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Añadir otros métodos si es necesario
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir los headers necesarios
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
