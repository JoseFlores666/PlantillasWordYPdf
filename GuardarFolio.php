<?php
header("Access-Control-Allow-Origin: https://frontend-wheat-psi.vercel.app"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json");


// Archivos donde se almacenarán el folio y la descripción
$archivoFolio = 'folio.txt';
$archivoDescripcion = 'descripcion.txt';

// Obtener los datos JSON del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Obtener el folio y la descripción enviados desde el cliente
$folio = isset($data['folio']) ? trim($data['folio']) : '';
$descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : '';

// Validar que el folio no esté vacío
if (!empty($folio) && !empty($descripcion)) {
    // Reemplazar el contenido del archivo con el nuevo folio y descripción
    $guardarFolio = file_put_contents($archivoFolio, $folio . PHP_EOL);
    $guardarDescripcion = file_put_contents($archivoDescripcion, $descripcion . PHP_EOL);

    if ($guardarFolio !== false && $guardarDescripcion !== false) {
        echo json_encode(['success' => true, 'message' => 'Folio y descripción guardados correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el folio y/o la descripción']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Folio o descripción vacíos']);
}
?>
