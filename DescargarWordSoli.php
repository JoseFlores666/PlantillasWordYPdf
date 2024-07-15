<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$output_file_name = 'SobrescritoSolicitud.docx';

// Establecer cabeceras para descarga del archivo
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$output_file_name\"");
header("Content-Length: " . filesize($output_file_name));

// Leer y enviar el archivo
readfile($output_file_name);

exit();
?>