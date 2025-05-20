<?php
namespace Aplicacion\controllers;
use Aplicacion\models\viewsModel;

class viewsController extends viewsModel{

    public function obtenerVistaControlador($vista){
        if($vista!=""){
            $respuesta = $this->obtenerVistasModelo($vista);
        }else{
            $respuesta = "login";
        }
        return $respuesta;
    }
}