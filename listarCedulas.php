<?php
require_once "./autoload.php";

use Aplicacion\models\mainModel;
$insModel = new mainModel();

$cedula = $_POST['cedula'];

$html = "";

    foreach ($insModel->array_personas as $tablita) {

        $datos = $insModel->ejecutarConsulta("SELECT cedula FROM ".$tablita['tabla']." WHERE cedula LIKE '".$cedula."%' ORDER BY cedula ASC");

        while ($row = $datos->fetch(PDO::FETCH_ASSOC)) {

            $html .= "<li onclick=\"mostrarCedula('".$row['cedula']."')\">".$row['cedula']." - ".$tablita['nombre']."</li>";

        }
    }

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>