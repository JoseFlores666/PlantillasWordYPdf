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

$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

$fecha = sanitizeInput($_POST['fecha']);
$suministro = sanitizeInput($_POST['suministro']);
$pc = sanitizeInput($_POST['pc']);
$proyecto = sanitizeInput($_POST['myProyecto']);
$actividad = sanitizeInput($_POST['myActividad']);
$justificacion = sanitizeInput($_POST['justificacion']);
$items = $_POST['items'] ?? [];
$solicitud = sanitizeInput($_POST['solicitud'] ?? '');
$jefeInmediato = sanitizeInput($_POST['JefeInmediato'] ?? '');
$validacion = sanitizeInput($_POST['Validacion'] ?? '');
$autorizo = sanitizeInput($_POST['Autorizo'] ?? '');

list($year, $mes, $dia) = explode('-', $fecha);

$template = 'PlantillaSolicitud.docx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

$TBS->MergeField('area.nombre', 'Administración y Finanzas Mantenimiento y Servicios Generales');
$TBS->MergeField('fecha.dia', $dia);
$TBS->MergeField('fecha.mes', $mes);
$TBS->MergeField('fecha.año', $year);
$TBS->MergeField('pro.proyecto', $proyecto);
$TBS->MergeField('Act.actividad', $actividad);
$TBS->MergeField('just.justificacion', $justificacion);

$TBS->MergeField('y', $suministro === 'Normal' ? '⬛' : '☐');
$TBS->MergeField('x', $suministro === 'Normal' ? '☐' : '⬛');

$TBS->MergeField('pce', $pc === 'Educativo' ? '⬛' : '☐');
$TBS->MergeField('pco', $pc === 'Educativo' ? '☐' : '⬛');

$max_items = 10;
for ($i = 0; $i < $max_items; $i++) {
    $item = $items[$i] ?? ['cantidad' => '', 'unidad' => '', 'descripcion' => ''];
    $TBS->MergeField("col." . ($i + 1), sanitizeInput($item['cantidad']));
    $TBS->MergeField("uni." . ($i + 1), sanitizeInput($item['unidad']));
    $TBS->MergeField("desc." . ($i + 1), sanitizeInput($item['descripcion']));
}

$TBS->MergeField('sol.nombre', $solicitud);
$TBS->MergeField('rev.nombre', $jefeInmediato);
$TBS->MergeField('val.nombre', $validacion);
$TBS->MergeField('aut.nombre', $autorizo);

$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

$output_file_name = 'SobrescritoSolicitud.docx';
$TBS->Show(OPENTBS_FILE, $output_file_name);

exec('node apiPDF.js SobrescritoSolicitud.docx ResultadoSoli.pdf', $output, $return_var);

if ($return_var !== 0) {
    error_log("Error converting DOCX to PDF: " . implode("\n", $output));
    echo "Error converting DOCX to PDF.";
    http_response_code(500);
    exit;
}
?>