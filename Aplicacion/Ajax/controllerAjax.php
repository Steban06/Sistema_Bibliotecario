<?php
require_once "../../Configuraciones/Conexion.php";
require_once "../Templates/session_start.php";
require_once "../../autoload.php";

use Aplicacion\controllers\bibliotecarioController;
use Aplicacion\controllers\docentesController;
use Aplicacion\controllers\estudiantesController;
use Aplicacion\controllers\librosController;
use Aplicacion\controllers\pasantiasController;
use Aplicacion\controllers\prestamosController;
use Aplicacion\controllers\servicioComunitarioController;
use Aplicacion\controllers\tInvestigacionController;

if (isset($_POST['modulo_estudiantes'])) { // MODULO ESTUDIANTES
    $insEstudiante = new estudiantesController();

    if ($_POST['modulo_estudiantes'] == "registrar") { 

        echo $insEstudiante->registrarEstudianteControlador();
    }
    if ($_POST['modulo_estudiantes'] == "eliminar") {

        echo $insEstudiante->eliminarEstudianteControlador();
    }
    if ($_POST['modulo_estudiantes'] == "actualizar") {
        echo $insEstudiante->actualizarEstudianteControlador();
    }
    if ($_POST['modulo_estudiantes'] == "desactivar") {

        echo $insEstudiante->desactivarEstudianteControlador();
    }
    if ($_POST['modulo_estudiantes'] == "reactivar") {

        echo $insEstudiante->reactivarEstudianteControlador();

    }
} elseif (isset($_POST['modulo_docentes'])) { // MODULO DOCENTES
        $insDocente = new docentesController();
    
        if ($_POST['modulo_docentes'] == "registrar") { 
            echo $insDocente->registrarDocentesControlador();
        }
        if ($_POST['modulo_docentes'] == "eliminar") {
            // echo $insDocente->eliminarEstudianteControlador();
        }
        if ($_POST['modulo_docentes'] == "actualizar") {
            echo $insDocente->actualizarDocenteControlador();
        }
        if ($_POST['modulo_docentes'] == "desactivar") {
            echo $insDocente->desactivarDocenteControlador();
        }
        if ($_POST['modulo_docentes'] == "reactivar") {
            echo $insDocente->reactivarDocenteControlador();
        }
} elseif(isset($_POST['modulo_libros'])) { // MODULO LIBROS
    $insLibro = new librosController();

    if ($_POST['modulo_libros'] == "registrar") {  

        echo $insLibro->registrarLibrosControlador();
    }
    if ($_POST['modulo_libros'] == "actualizar") {  

        echo $insLibro->actualizarLibroControlador();
    }
    if ($_POST['modulo_libros'] == "desabilitar") {

        echo $insLibro->desabilitarLibroControlador();
    }
    if ($_POST['modulo_libros'] == "habilitar") {

        echo $insLibro->habilitarLibroControlador();
    }
}elseif (isset($_POST['modulo_sercomu'])) { // MODULO PARA SERVICIOS COMUNITARIOS
    $insSerComu = new servicioComunitarioController();

    if ($_POST['modulo_sercomu'] == "registrar") {
        echo $insSerComu->registrarServicioControlador();
    }
    if ($_POST['modulo_sercomu'] == "actualizar") {
        echo $insSerComu->actualizarServicioControlador();
    }
    if ($_POST['modulo_sercomu'] == "desabilitar") {
        echo $insSerComu->desabilitarServicioControlador();
    }
    if ($_POST['modulo_sercomu'] == "habilitar") {
        echo $insSerComu->habilitarServicioControlador();
    }

}elseif (isset($_POST['modulo_pasantias'])) { // MODULO PASANTIAS
    $insPasantias = new pasantiasController();

    if ($_POST['modulo_pasantias'] == "registrar") {
        echo $insPasantias->registrarPasantiasControlador();
    }
    if ($_POST['modulo_pasantias'] == "actualizar") {
        echo $insPasantias->actualizarPasantiasControlador();
    }
    if ($_POST['modulo_pasantias'] == "desabilitar") {
        echo $insPasantias->desabilitarPasantiaControlador();
    }
    if ($_POST['modulo_pasantias'] == "habilitar") {

        echo $insPasantias->habilitarPasantiaControlador();
    }

}elseif (isset($_POST['modulo_tinestigacion'])) { // MODULO TRABJAOS DE INVESTIGACION
    $insTivestigacion = new tInvestigacionController();

    if ($_POST['modulo_tinestigacion'] == "registrar") {
        echo $insTivestigacion->registrarTinvestigacionCrontrolador();
    }
    if ($_POST['modulo_tinestigacion'] == "actualizar") {
        echo $insTivestigacion->actualizarTinvestigacionCrontrolador();
    }
    if ($_POST['modulo_tinestigacion'] == "desabilitar") {
        echo $insTivestigacion->deshabilitarTinvestigacionCrontrolador();
    }
    if ($_POST['modulo_tinestigacion'] == "habilitar") {
        echo $insTivestigacion->habilitarTinvestigacionCrontrolador();
    }

} elseif(isset($_POST['modulo_prestamos'])) { // MODULO PRESTAMOS
    $insPrestamo = new prestamosController();

    if ($_POST['modulo_prestamos'] == "registrar") {  

        echo $insPrestamo->registrarPrestamoControlador();
    }
    if ($_POST['modulo_prestamos'] == "devolver") {  

        echo $insPrestamo->devolverPrestamoControlador();
    }
} elseif(isset($_POST['modulo_bibliotecario'])) { // MODULO USUARIO
    $insbliotecario = new bibliotecarioController();

    if ($_POST['modulo_bibliotecario'] == "registrar") {  

        echo $insbliotecario->registrarBibliotecarioControlador();
    }
    // if ($_POST['modulo_prestamos'] == "devolver") {  

    //     echo $insPrestamo->devolverPrestamoControlador();
    // }
} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
