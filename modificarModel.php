<?php
require_once "./autoload.php";

use Aplicacion\models\mainModel;

if (isset($_POST['cedula'])) {
    $campo = $_POST['cedula'];
}
if (isset($_POST['id'])) {
    $campo = $_POST['id'];
}

$tablaBuscar = $_POST['tabla'];
$campoBuscar = $_POST['campo'];

$instancia = new mainModel();

$data = $instancia->seleccionarDatos("Unico",$tablaBuscar,$campoBuscar,$campo);
$resultado = $data->fetch(PDO::FETCH_ASSOC);

echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
?>