<?php
require_once "./autoload.php";

use Aplicacion\models\mainModel;
$insModel = new mainModel();

$cota = $_POST['cota'];

$html = "";

    foreach ($insModel->array_tablas as $tablita) {

        $datos = $insModel->ejecutarConsulta("SELECT cota FROM ".$tablita['tabla']." WHERE cota LIKE '".$cota."%' ORDER BY cota ASC");

        while ($row = $datos->fetch(PDO::FETCH_ASSOC)) {

            $html .= "<li onclick=\"mostrar('".$row['cota']."')\">".$row['cota']." - ".$tablita['nombre']."</li>";

        }
    }

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>