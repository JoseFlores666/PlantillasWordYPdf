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

$output_file_name = 'SobrescritoOrden.docx';

// Establecer cabeceras para descarga del archivo
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$output_file_name\"");
header("Content-Length: " . filesize($output_file_name));

// Leer y enviar el archivo
readfile($output_file_name);

exit();
?>