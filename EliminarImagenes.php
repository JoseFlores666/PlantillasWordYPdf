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

// Carpeta para guardar las imágenes (directorio raíz del proyecto)
$directorioRaiz = __DIR__; // Obtiene el directorio actual
$carpetaArchivos = $directorioRaiz; // Guardar en el directorio raíz

function eliminarImagenes() {
    global $carpetaArchivos;

    // Definir imágenes
    $imagenes = [
        'imagen1.jpg',
        'imagen2.jpg',
        'imagen3.jpg',
        'imagen4.jpg',
        'imagen5.jpg',
        'imagen6.jpg',
        'imagen7.jpg',
        'imagen8.jpg'
    ];

    // Eliminar las imágenes
    foreach ($imagenes as $imagen) {
        $rutaArchivo = $carpetaArchivos . '/' . $imagen;
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
    }
}

// Llamar a la función para eliminar las imágenes
eliminarImagenes();

echo json_encode(['mensaje' => 'Imágenes eliminadas correctamente.']);
?>