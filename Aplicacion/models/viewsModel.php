<?php

namespace Aplicacion\models;

class viewsModel {

    // Recibe un valor, que es el nombre o clase de la vista
    protected function obtenerVistasModelo ($vista){

        // Esta es una lista de palabras que se pueden usar en la URL
        // Las cuales son las vistas a las que se puede acceder
        $listaVistas=["inicio","estudiantes","docentes","libros","tInvestigacion","pasantias","servicioComunitario","prestamos", "perfilUsuario","cerrarSesion","generarPDF","generarPDFL","generarPDFP"];

        // Verifica que el nombre de la vista que se solicita abrir este en la lista
        if(in_array($vista, $listaVistas)){
            // Si la palabra esta, entonces comprueba que el archivo tenga el mismo nombre y la terminacion "-view.php"
            if(is_file("./Aplicacion/Vistas/".$vista."-view.php")){
                // Si lo tiene, entonces guarda esa ruta en la variable contenido
                $contenido = "./Aplicacion/Vistas/".$vista."-view.php";
            }else{
                // Si no, envia a la pestania de error 404
                $contenido = "404";
            }
        // Verifica que la palabra sea la del login o el cuerpo principal
        }elseif($vista=="login" || $vista=="index"){
            // Si es alguna de las dos, entonces retorna "login"
            $contenido = "login";
        }else{
            // Si no, retorna entonces error 404
            $contenido = "404";
        }

        //Retorna la ruta que se le asigno
        return $contenido;
    }
}
