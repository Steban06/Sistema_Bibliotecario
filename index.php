<?php
require_once "./Configuraciones/Conexion.php";
require_once "./autoload.php";
require_once "./Aplicacion/Templates/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Aqui se supone que se reciclen los parametros de la cabeza en un carpeta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="<?php echo APP_URL?>Componentes/CSS/style.css">
    <link rel="stylesheet" href="<?php echo APP_URL?>Componentes/CSS/modalStyle.css">
    <link rel="stylesheet" href="<?php echo APP_URL?>Componentes/CSS/stylesLogin.css">
    <!-- Estilos de las alertas -->
    <link rel="stylesheet" href="<?php echo APP_URL ?>Componentes/CSS/sweetalert2.min.css">
    <script src="<?php echo APP_URL?>Componentes/JavaScript/sweetalert2.all.min.js"></script>
    <title><?php echo APP_NOMBRE?></title>

    <!-- Vinculacion de DataTables en las carpetas -->
    <link href="<?php echo APP_URL?>Componentes/DataTables/datatables.min.css" rel="stylesheet">
    <script src="<?php echo APP_URL?>Componentes/DataTables/datatables.min.js"></script>

    <!-- Font Awesome para ICONOS -->
     <link rel="stylesheet" href="<?php echo APP_URL?>Componentes/IconsFontawesome/css/all.css">
</head>

<body>
    <input id="URL" type="hidden" value="<?php echo APP_URL?>" disabled>
    <?php

    use Aplicacion\controllers\viewsController;
    use Aplicacion\controllers\loginController;

    $insLogin = new loginController();

    $viewsController = new viewsController();
    $vista = $viewsController->obtenerVistaControlador($url[0]);

    if ($vista == "login" || $vista == "404") {
        echo $_GET['views'];
        require_once "./Aplicacion/Vistas/" . $vista . "-view.php";
    } else {
        // Validacion que cierra la sesion para evitar saltos en la URL
        if(!isset($_SESSION['id']) || !isset($_SESSION['cedula']) || !isset($_SESSION['nombres']) || !isset($_SESSION['apellidos']) ||
        $_SESSION['id'] == "" || $_SESSION['cedula'] == "" || $_SESSION['nombres'] == "" || $_SESSION['apellidos'] == ""){
            $insLogin->cerrarSesionControlador();
            exit();
        }

        // foreach ($url as $u) {
        //     echo $u.",";
        // }
        // echo $url[0];
        echo $_GET['views'];
        require_once "./Aplicacion/Templates/header.php";
        require_once $vista;
        require_once "./Aplicacion/Templates/footer.php";
    }
    ?>

    <!-- Aqui se supone que se reciclen los parametros de los scripts
    en un carpeta -->
    <!-- Vinculando arichos js que facilitan el ingreso de datos  -->
    <script src="<?php echo APP_URL?>Componentes/JavaScript/ajax.js"></script>
    <script src="<?php echo APP_URL?>Componentes/JavaScript/main.js"></script>
    <script src="<?php echo APP_URL?>Componentes/JavaScript/modalScript.js"></script>
    <script src="<?php echo APP_URL?>Componentes/JavaScript/script.js"></script>
</body>

</html>