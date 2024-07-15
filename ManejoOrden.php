<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once 'tbs_class.php';
include_once 'plugins/tbs_plugin_opentbs.php';

$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

// Capturando datos del formulario
$fecha = $_POST['fechaOrden'];
$folioEx = $_POST['folioExterno'];

$areasoli = $_POST['areasoli'];
$solicita = $_POST['solicita'];
$edificio = $_POST['edificio'];

$tipoMantenimiento = $_POST['tipoMantenimiento'];
$tipoTrabajo = $_POST['tipoTrabajo'];
$tipoSolicitud = $_POST['tipoSolicitud'];
$descripcion = $_POST['descripcion'];

// $fechaAtencion = $_POST['fechaAtencion'];

list($year, $mes, $dia) = explode('-', $fecha);
// list($yearA, $mesA, $diaA) = explode('-', $fechaAtencion);

// $observaciones = $_POST['obs'];

// Capturando cantidades y descripciones de insumos
// $items = $_POST['items'];

// Cargando template la plantilla 
$template = 'PlantillaOrden.docx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

// Escribir Nuevos campos
$TBS->MergeField('areasoli', $areasoli);
$TBS->MergeField('solicita', $solicita);
$TBS->MergeField('edificio', $edificio);
$TBS->MergeField('folio', $folioEx);

//parte de la fecha horario
$TBS->MergeField('fecha.dia', $dia);
$TBS->MergeField('fecha.mes', $mes);
$TBS->MergeField('fecha.año', $year);

// $TBS->MergeField('fechaA.dia', $diaA);
// $TBS->MergeField('fechaA.mes', $mesA);
// $TBS->MergeField('fechaA.año', $yearA);

$TBS->MergeField('desc.servicio', $descripcion);

//los tipos
$TBS->MergeField('m', $tipoMantenimiento === 'Mobiliario' ? 'X' : ' ');
$TBS->MergeField('i', $tipoMantenimiento === 'Mobiliario' ? ' ' : 'X');

$TBS->MergeField('p', $tipoTrabajo === 'Preventivo' ? 'X' : ' ');
$TBS->MergeField('c', $tipoTrabajo === 'Preventivo' ? ' ' : 'X');

$TBS->MergeField('n', $tipoSolicitud === 'Normal' ? 'X' : ' ');
$TBS->MergeField('u', $tipoSolicitud === 'Normal' ? ' ' : 'X');

// Procesar insumos
// $items_count = count($items);
// $max_items = 4;
// if ($items_count < $max_items) {
//     // Agregar elementos vacíos hasta llegar a 10
//     for ($i = $items_count; $i < $max_items; $i++) {
//         $items[] = array(
//             'cantidad' => '',
//             'descripcion' => ''
//         );
//     }
// }

// foreach ($items as $index => $item) {
//     $TBS->MergeField("cant." . ($index + 1), $item['cantidad']);
//     $TBS->MergeField("desc." . ($index + 1), $item['descripcion']);
// }

// $TBS->MergeField('observaciones', $observaciones);

$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

$output_file_name = 'SobrescritoOrden.docx';
$TBS->Show(OPENTBS_FILE, $output_file_name);

$output = [];
$return_var = 0;
exec('node apiPDF.js SobrescritoOrden.docx ResultadoOrden.pdf');
?>