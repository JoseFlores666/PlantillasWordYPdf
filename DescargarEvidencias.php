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

include_once 'tbs_class.php';
include_once 'plugins/tbs_plugin_opentbs.php';

$directorioRaiz = __DIR__; // Obtiene el directorio actual
$carpetaArchivos = $directorioRaiz; // Guardar en el directorio raíz

function guardarImagenes()
{
    global $carpetaArchivos;

    // Obtener el número total de imágenes esperadas desde el cliente
    $numeroDeImagenes = isset($_POST['numero_de_imagenes']) ? intval($_POST['numero_de_imagenes']) : 0;

    // Procesar y guardar las imágenes
    for ($i = 0; $i < $numeroDeImagenes; $i++) {
        if (isset($_FILES['imagenes']['tmp_name'][$i])) {
            $extension = pathinfo($_FILES['imagenes']['name'][$i], PATHINFO_EXTENSION);
            $nombreArchivo = 'imagen' . ($i + 1) . '.' . $extension;
            $rutaArchivo = $carpetaArchivos . '/' . $nombreArchivo;

            // Mover el archivo a la ruta deseada
            move_uploaded_file($_FILES['imagenes']['tmp_name'][$i], $rutaArchivo);
        }
    }
}

function procesarPlantilla()
{
    global $carpetaArchivos;

    // Inicializar el objeto TinyButStrong
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    // Leer el contenido del archivo folio.txt
    $archivoFolio = 'folio.txt';
    $folioDesdeArchivo = file_exists($archivoFolio) ? trim(file_get_contents($archivoFolio)) : '';

    // Leer el contenido del archivo descripcion.txt
    $archivoDescripcion = 'descripcion.txt';
    $descripcionDesdeArchivo = file_exists($archivoDescripcion) ? trim(file_get_contents($archivoDescripcion)) : '';

    // Cargar la plantilla
    $template = 'PlantillaEvidencias.docx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

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

    // Usar el valor leído del archivo para los campos 'folio' y 'descripcion'
    $TBS->MergeField('folio', $folioDesdeArchivo);
    $TBS->MergeField('desc', $descripcionDesdeArchivo);

    // Configurar imágenes en VarRef usando if
    for ($i = 1; $i <= 8; $i++) {
        $imagenKey = 'img' . $i;
        $TBS->VarRef[$imagenKey] = $imagenes[$i - 1];
    }

    // Procesar la plantilla
    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    // Generar el documento
    $save_as = (isset($_POST['save_as']) && !empty(trim($_POST['save_as'])) && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $template);

    if ($save_as === '') {
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit();
    } else {
        $TBS->Show(OPENTBS_FILE, $output_file_name);
        exit("File [$output_file_name] has been created.");
    }
}

// Guardar las imágenes
guardarImagenes();

// Procesar la plantilla
procesarPlantilla();
?>
