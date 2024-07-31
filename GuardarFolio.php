<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Archivo donde se almacenará el folio
$archivoFolio = 'folio.txt';

// Obtener los datos JSON del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Obtener el folio enviado desde el cliente
$folio = isset($data['folio']) ? trim($data['folio']) : '';

// Validar que el folio no esté vacío
if (!empty($folio)) {
    // Reemplazar el contenido del archivo con el nuevo folio
    if (file_put_contents($archivoFolio, $folio . PHP_EOL) !== false) {
        echo json_encode(['success' => true, 'message' => 'Folio guardado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el folio']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Folio vacío']);
}
?>