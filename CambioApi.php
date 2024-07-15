<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apiKey'])) {
    $apiKey = $_POST['apiKey'];
    
    $file = 'api_key.txt';
    file_put_contents($file, $apiKey);

    echo "API Key guardado correctamente en $file";
} else {
    echo "No se ha recibido el dato correctamente.";
}
?>
