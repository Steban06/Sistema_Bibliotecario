<?php
    // Este archivo carga de forma automatica las clases utilizadas
    spl_autoload_register(function($clase){
        /* Obteniendo el directorio actual y concatenando para tener 
        toda la ruta del codigo de la clase que se va a utilizar */
        $archivoo = __DIR__."/".$clase.".php";
        $archivo = str_replace("\\","/",$archivoo);

        // echo $archivo;

        // Trayendo la clase que necesitara automaticamente
        if(is_file($archivo))
        {
            // echo "entro";
            require_once $archivo;
        }
    });