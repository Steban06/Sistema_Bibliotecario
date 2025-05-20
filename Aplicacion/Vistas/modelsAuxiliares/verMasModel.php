<?php
require_once "../../../autoload.php";

use Aplicacion\models\mainModel;

if (isset($_POST['id'])) {
    $campo = $_POST['id'];
}

$instancia = new mainModel();

$data = $instancia->seleccionarDatos("Unico","prestamos","ID",$campo);
$resultado_prestamo = $data->fetch(PDO::FETCH_ASSOC);

// Buscando informacion de la persona por la cedula

// $check_cedula = $instancia->ejecutarConsulta("SELECT nombres,apellidos,estado AS estado_persona FROM estudiantes WHERE cedula='".$resultado_prestamo['cedula_persona']."'");
// if ($check_cedula->rowCount() > 0) {
//     $resultado_personas = $check_cedula->fetch(PDO::FETCH_ASSOC);
//     $resultado_personas['tipo_p'] = "Estudiante";
// }
// $check_cedula = $instancia->ejecutarConsulta("SELECT nombres,apellidos,estado AS estado_persona FROM docentes WHERE cedula='".$resultado_prestamo['cedula_persona']."'");
// if ($check_cedula->rowCount() > 0) {
//     $resultado_personas = $check_cedula->fetch(PDO::FETCH_ASSOC);
//     $resultado_personas['tipo_p'] = "Docente";
// }

foreach ($instancia->array_personas as $t) {
    $check_persona = $instancia->ejecutarConsulta("SELECT nombres,apellidos,estado AS estado_persona FROM ".$t['tabla']." WHERE cedula='".$resultado_prestamo['cedula_persona']."'");
    if ($check_persona->rowCount() > 0) {
        $resultado_persona = $check_persona->fetch(PDO::FETCH_ASSOC);
        $resultado_persona['tipo_p'] = $t['nombre'];
        break;
    }
}

// Buscando informacion de documento por la cota
$check_cota = $instancia->ejecutarConsulta("SELECT cota, titulo, autor AS autor, estado AS estado_documento FROM libros WHERE cota='".$resultado_prestamo['cota_documento']."'");
if ($check_cota->rowCount() > 0) {
    $resultado_documento = $check_cota->fetch(PDO::FETCH_ASSOC);
    $resultado_documento['tipo_d'] = "Libro";
}
$check_cota = $instancia->ejecutarConsulta("SELECT cota, titulo, autor AS autor, estado AS estado_documento FROM pasantias WHERE cota='".$resultado_prestamo['cota_documento']."'");
if ($check_cota->rowCount() > 0) {
    $resultado_documento = $check_cota->fetch(PDO::FETCH_ASSOC);
    $resultado_documento['tipo_d'] = "Pasantia";
}
$check_cota = $instancia->ejecutarConsulta("SELECT cota, titulo, autores AS autor, estado AS estado_documento FROM servicios_comunitarios WHERE cota='".$resultado_prestamo['cota_documento']."'");
if ($check_cota->rowCount() > 0) {
    $resultado_documento = $check_cota->fetch(PDO::FETCH_ASSOC);
    $resultado_documento['tipo_d'] = "Servicio Comunitario";
}
$check_cota = $instancia->ejecutarConsulta("SELECT cota, titulo, autor AS autor, estado AS estado_documento FROM trabajos_investigacion WHERE cota='".$resultado_prestamo['cota_documento']."'");
if ($check_cota->rowCount() > 0) {
    $resultado_documento = $check_cota->fetch(PDO::FETCH_ASSOC);
    $resultado_documento['tipo_d'] = "Trabajo de Grado";
}

// Armando el arreglo con toda la información
$resultado = array_merge($resultado_prestamo, $resultado_persona, $resultado_documento);

echo json_encode($resultado, JSON_UNESCAPED_UNICODE);