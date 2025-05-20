<?php

namespace Aplicacion\models;
use \PDO;
use \PDOException;

if (file_exists(__DIR__ . "/../../Configuraciones/Conexion.php")) {
    require_once __DIR__ . "/../../Configuraciones/Conexion.php";
}

class mainModel
{
    private $server = DB_SERVIDOR;
    private $bd = DB_NOMBRE;
    private $usuario = DB_USUARIO;
    private $contrasenia = DB_CONTRA;

    public $array_tablas = [
        ["tabla" => "libros", "nombre" => "Libro"],
        ["tabla" => "pasantias", "nombre" => "Pasantía"],
        ["tabla" => "servicios_comunitarios", "nombre" => "Servicio comunitario"], 
        ["tabla" => "trabajos_investigacion", "nombre" => "Trabajo de investigación"]
    ];
    public $array_personas = [
        ["tabla" => "estudiantes", "nombre" => "Estudiante"],
        ["tabla" => "docentes", "nombre" => "Docente"]
    ];

    protected function conectar()
    {
        $conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->bd, $this->usuario, $this->contrasenia);
        $conexion->exec("SET CHARACTER SET utf8");

        // $pdo = "mysql:host=".$this->server.";dbname=".$this->bd.";.charset.";
        // try {
        //     $conexion = new PDO($pdo, $this->usuario, $this->contrasenia);
        //     $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // } catch (PDOException $e) {
        //     echo "Error en la conexion".$e->getMessage();
        // }

        return $conexion;
    }

    public function ejecutarConsulta($consulta){
        $sql = $this->conectar()->prepare($consulta);
        $sql->execute();

        return $sql;
    }
    
    // Funcion de filtro para limpiar y evitar la inyeccion SQL y demas comandos
    public function limpiarCadena($cadena){
        $palabras = ["<script>","</script>","<script src",
                    "<script type=", "SELECT * FROM", "DELETE FROM", "INSERT INTO",
                    "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES",
                    "SHOW DATABASES", "<?php", "?>","--","^","<",">","==","=",";","::"];

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        foreach($palabras as $palabra){
            $cadena = str_ireplace($palabra, "", $cadena);
        }

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        return $cadena;
    }

    // Funcion que valida la entrada de datos. Asefurando que los datos ingresados sean correctos
    protected function verificarDatos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/", $cadena)){
            return false;
        }else{
            return true;
        }
    }

    // Funcion para guardar datos en todas las tablas con una consulta dinamica
    protected function guardarDatos($tabla, $datos){
        $query = "INSERT INTO $tabla (";

        $c = 0;
        foreach($datos as $clave){
            if($c >= 1){ $query .= ",";}
            $query .= $clave["campo_nombre"];
            $c++;
        }

        $query .= ") VALUES(";

        $c = 0;
        foreach($datos as $clave){
            if($c >= 1){ $query .= ",";}
            $query .= $clave["campo_marcador"];
            $c++;
        }

        $query .= ")";

        $sql = $this->conectar()->prepare($query);

        foreach($datos as $clave){
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $sql->execute();

        return $sql;
    }

    // Funcion que selecciona los datos (Hay que modificar los parametros)
    public function seleccionarDatos($tipo, $tabla, $campo, $id){
        $tipo = $this->limpiarCadena($tipo);
        $tabla = $this->limpiarCadena($tabla);
        $campo = $this->limpiarCadena($campo);
        $id = $this->limpiarCadena($id);
        
        if($tipo=="Unico"){
            $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Normal"){
            $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
        }

        $sql->execute();

        return $sql;
    }

    // Funcion que permite actualizar datos
    protected function actualizarDatos($tabla, $datos, $condicion){
        $query="UPDATE $tabla SET ";

		$C=0;
		foreach ($datos as $clave){
			if($C>=1){ $query.=","; }
			$query.=$clave["campo_nombre"]."=".$clave["campo_marcador"];
			$C++;
		}

		$query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];

		$sql=$this->conectar()->prepare($query);

		foreach ($datos as $clave){
			$sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
		}

		$sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

		$sql->execute();

		return $sql;
    }

    // Funcion para eliminar datos
    protected function eliminarRegistro($tabla, $campo, $id){
        $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
        $sql->bindParam(":id", $id);

        $sql->execute();
        return $sql;
    }

    protected function desactivarRegistro($tabla, $campo_estado,$campo, $id){
        $sql = $this->conectar()->prepare("UPDATE $tabla SET $campo_estado='Inactivo' WHERE $campo=:id;");
        $sql->bindParam(":id", $id);

        $sql->execute();
        return $sql;
    }

    protected function reactivarRegistro($tabla, $campo_estado,$campo, $id){
        $sql = $this->conectar()->prepare("UPDATE $tabla SET $campo_estado='Activo' WHERE $campo=:id;");
        $sql->bindParam(":id", $id);

        $sql->execute();
        return $sql;
    }

    protected function cambiarEstadoRegistro($tabla, $campo_estado, $campo_valor,$campo, $id){
        $sql = $this->conectar()->prepare("UPDATE $tabla SET $campo_estado='$campo_valor' WHERE $campo=:id;");        
        $sql->bindParam(":id", $id);

        $sql->execute();
        return $sql;
    }

    // Funcion para la paginacion (ESTO VA SER OPCIONAAAAL)
    protected function paginadorTablas($pagina, $numPaginas, $url, $botones){

        $tabla = '<nav class="paginacion" role=navigation aria-label="pagination">';

        if($pagina<=1){
            $tabla.='
            <a class="pagination-previus is-disabled" disabled> Anterior</a>
            <ul class="pagination-list">
            ';
        }else{
            $tabla.='
            <a class="pagination-previus" href="'.$url.($pagina-1).'/"> Anterior</a>
            <ul class="pagination-list">
                <li><a class="pagination-link" href="'.$url.'1/">1</a></li>
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            ';
        }

        $ci = 0;
        for($i=$pagina ; $i <= $numPaginas ; $i++){

            if($ci > $botones){
                break;
            }

            if($pagina == $i){
                $tabla.='
                    <li><a class="pagination-link is-current" href="'.$url.$i.'/">'.$i.'</a></li>
                ';
            }else{
                $tabla.='
                    <li><a class="pagination-link" href="'.$url.$i.'/">'.$i.'</a></li>
                ';
            }

            $ci++;

            if($pagina == $numPaginas){
                $tabla.='
                </ul>
                <a class="pagination-next is-disabled" disabled>Siguiente</a>
                ';
            }else{
                $tabla.='
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    <li><a class="pagination-link" href="'.$url.$numPaginas.'/">'.$numPaginas.'</a></li>
                </ul>
                <a class="pagination-next" href="'.$url.($pagina+1).'">Siguiente</a>
                ';
            }

            $tabla.='</nav>';

            return $tabla;
        }
    }

    // Funcion para imprimir la fecha en espanol
    protected function fechasEspanol($fecha){
        $arrayFecha = explode("-", $fecha);

        if (strlen($fecha) == 10){
            return $arrayFecha[2]."-".$arrayFecha[1]."-".$arrayFecha[0];
        } else {
            return $arrayFecha[1]."-".$arrayFecha[0];
        }  
    }
}
