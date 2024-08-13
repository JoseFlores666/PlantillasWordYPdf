<?php
header("Access-Control-Allow-Origin: https://frontend-wheat-psi.vercel.app"); // Cambiado para aceptar solicitudes desde Vercel
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Añadir otros métodos si es necesario
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir los headers necesarios
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