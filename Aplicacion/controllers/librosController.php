<?php

namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class librosController extends mainModel
{
    private string $tablaSQL = "libros";

    // Controlador para registrar un libro
    public function registrarLibrosControlador()
    {
        // Almacenando datos
        $cota = ($this->limpiarCadena($_POST['libro_cota']));          #1
        $titulo = $this->limpiarCadena($_POST['libro_titulo']);        #2
        $autor = $this->limpiarCadena($_POST['libro_autor']);          #3
        $area = $this->limpiarCadena($_POST['libro_area']);            #4
        $editorial = $this->limpiarCadena($_POST['libro_editorial']);  #5
        $edicion = $this->limpiarCadena($_POST['libro_edicion']);      #6
        $tomo = $this->limpiarCadena($_POST['libro_tomo']);            #7
        $ejemplares = $this->limpiarCadena($_POST['libro_ejemplares']);#8
        $fecha = $this->limpiarCadena($_POST['libro_fecha']);          #9

        // Verificando campos obligatorios
        if ($cota == "" || $titulo == "" || $autor == "" || $area == "" || $ejemplares == "" || $fecha == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de los datos
        if ($this->verificarDatos("[a-zA-zñÑ0-9]{4,15}", $cota)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La cota no coincide con el formato solicitado, de 4 a 15 caracteres",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificar que una cota nose repita en la base de datos (metodo experimental hasta los momentos funcional)
        foreach ($this->array_tablas as $tablita) {
            $check_cota = $this->ejecutarConsulta("SELECT cota FROM ".$tablita['tabla']." WHERE cota='$cota'");
            if ($check_cota->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ya existe un(a) ".$tablita['nombre']."  con esa cota en el sistema",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,100}", $titulo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El titulo tiene caracteres no validos, solo caracteres de la A a la Z",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/los nombre/s autor/es tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $area)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El area del libro no corresponde con el formatos solicitado, solo letras",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{0,50}", $editorial)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La editorial contiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9a-zA-záéíóúÁÉÍÓÚñÑ ]{0,10}", $tomo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El tomo no es valido, solo valores numericos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{0,10}", $edicion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La edicion no es valida",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9]{1,3}", $ejemplares)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El numero de ejemplares tiene que estar expresado en numeros",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (intval($ejemplares) <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Tiene que exister al menos un ejemplar del libro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (intval($ejemplares) >= 100) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Esta introduciendo una cantidad execiva de libros, disminuya la cantidad",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9 -]{10,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha del libro no es valida, coloque una fecha adecuada dia/mes/año",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($editorial == "") $editorial = "No posee";
        if ($tomo == "") {$tomo = "No posee";}
        if ($edicion == "") {$edicion = "No posee";}

        $usuario_datos_reg = [
            [
                "campo_nombre" => "cota",
                "campo_marcador" => ":Cot",
                "campo_valor" => $cota
            ],
            [
                "campo_nombre" => "titulo",
                "campo_marcador" => ":Tit",
                "campo_valor" => ucwords($titulo)
            ],
            [
                "campo_nombre" => "autor",
                "campo_marcador" => ":Aut",
                "campo_valor" => ucwords($autor)
            ],
            [
                "campo_nombre" => "area",
                "campo_marcador" => ":Are",
                "campo_valor" => ucwords($area)
            ],
            [
                "campo_nombre" => "editorial",
                "campo_marcador" => ":Edi",
                "campo_valor" => ucwords($editorial)
            ],
            [
                "campo_nombre" => "edicion",
                "campo_marcador" => ":Edd",
                "campo_valor" => $edicion
            ],
            [
                "campo_nombre" => "tomos",
                "campo_marcador" => ":Tom",
                "campo_valor" => $tomo
            ],
            [
                "campo_nombre" => "ejemplares_tot",
                "campo_marcador" => ":Ejt",
                "campo_valor" => intval($ejemplares)
            ],
            [
                "campo_nombre" => "ejemplares_dis",
                "campo_marcador" => ":Ejd",
                "campo_valor" => intval($ejemplares)
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":Fec",
                "campo_valor" => $fecha
            ]
        ];

        $registrar_libro = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_libro->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro registrado",
                "texto" => "El libro se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se pudo registrar el libro, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador listar libros
    public function listarLibrosControlador()
    {
        $tabla_html = '';

        $consulta = "SELECT * FROM $this->tablaSQL";
        $consulta_total = "SELECT COUNT(id) FROM $this->tablaSQL";

        $datos = $this->ejecutarConsulta($consulta);
        $datos = $datos->fetchAll();

        $total_registros = $this->ejecutarConsulta($consulta_total);
        $total_registros = (int) $total_registros->fetchColumn();

        if ($total_registros > 0) {
            foreach ($datos as $rows) {
                $tabla_html .= '<tr>
                    <td>' . $rows['id'] . '</td>
                    <td>' . $rows['cota'] . '</td>
                    <td>' . $rows['titulo'] . '</td>
                    <td>' . $rows['autor'] . '</td>
                    <td>' . $rows['area'] . '</td>
                    <td>' . $rows['editorial'] . '</td>
                    <td>' . $rows['edicion'] . '</td>
                    <td>' . $rows['tomos'] . '</td>
                    <td>' . $rows['ejemplares_tot'] . '</td>
                    <td>' . $rows['ejemplares_dis'] . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha']) . '</td>';

                    if ($rows['estado'] == "Disponible") {
                        $tabla_html .= '<td>
                        <span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarLibro('.$rows['id'].')"><span>Editar</span><i class="fa-solid fa-file-pen"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_libros" value="desabilitar">
			                <input type="hidden" name="libro_id" value="' . $rows['id'] . '">

			                <button type="submit" class="btn_actions_table btn_eliminar"><span>Deshabilitar</span><i class="fa-regular fa-circle-xmark"></i></button>
			            </form>
                    </td>
                </tr>';
                    } else {
                        $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_libros" value="habilitar">
			                <input type="hidden" name="libro_id" value="' . $rows['id'] . '">

			                <button type="submit" class="btn_actions_table btn_reactivar"><span>Habilitar</span><i class="fa-regular fa-circle-check"></i></button>
			            </form>
                    </td>
                    <td hidden></td>
                </tr>';
                }
                    
            }
        }

        return $tabla_html;
    }

    // Controlador eliminar libro desde boton
    public function eliminarLibroControlador()
    {
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula']);

        # Verificando usuario
        $datos = $this->ejecutarConsulta("SELECT * FROM estudiantes WHERE cedula='$cedula'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un estudiante con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $eliminarEstudiante = $this->eliminarRegistro("estudiantes", "cedula", $cedula);

        if ($eliminarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Estudiante eliminado",
                "texto" => "El estudiante se ha eliminado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se puedo eliminar el estudiante, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador actualizar libro
    public function actualizarLibroControlador()
    {
        $id = $this->limpiarCadena($_POST['libro_id']);

        # Verificando estudiante
        $datos = $this->ejecutarConsulta("SELECT * FROM libros WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un libro con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $cota = $this->limpiarCadena($_POST['libro_cota_modificar']);  #1
        $titulo = $this->limpiarCadena($_POST['libro_titulo']);        #2
        $autor = $this->limpiarCadena($_POST['libro_autor']);          #3
        $area = $this->limpiarCadena($_POST['libro_area']);            #4
        $editorial = $this->limpiarCadena($_POST['libro_editorial']);  #5
        $edicion = $this->limpiarCadena($_POST['libro_edicion']);      #6
        $tomo = $this->limpiarCadena($_POST['libro_tomo']);            #7
        $ejemplares = $this->limpiarCadena($_POST['libro_ejemplares']);#8
        $fecha = $this->limpiarCadena($_POST['libro_fecha']);          #9
        // $estado = 1;

        // Verificando campos obligatorios
        if ($cota == "" || $titulo == "" || $autor == "" || $area == "" || $ejemplares == "" || $fecha == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de los datos
        if ($this->verificarDatos("[a-zA-zñÑ0-9]{4,15}", $cota)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La cota no coincide con el formato solicitado, de 4 a 15 caracteres",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificar que la cota no se repite
        if ($datos['cota'] != $cota) {
            foreach ($this->array_tablas as $tablita) {
                $check_cota = $this->ejecutarConsulta("SELECT cota FROM ".$tablita['tabla']." WHERE cota='$cota'");
                if ($check_cota->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Ya existe un(a) ".$tablita['nombre']."  con esa cota en el sistema",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,100}", $titulo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El titulo tiene caracteres no validos, solo caracteres de la A a la Z",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/los nombre/s autor/es tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $area)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El area del libro no corresponde con el formatos solicitado, solo letras",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $editorial)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La editorial contiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($tomo != "" && $tomo != "No posee") {
            if ($this->verificarDatos("[0-9a-zA-záéíóúÁÉÍÓÚñÑ ]{0,10}", $tomo)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "El tomo no es valido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }
        if ($edicion != "" && $edicion != "No posee") {
            if ($this->verificarDatos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{0,10}", $edicion)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "La edicion no es valida",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }
        if ($this->verificarDatos("[0-9]{1,3}", $ejemplares)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El numero de ejemplares tiene que estar expresado en numeros",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (intval($ejemplares) <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Tiene que exister al menos un ejemplar del libro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (intval($ejemplares) >= 100) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Esta introduciendo una cantidad execiva de libros, disminuya la cantidad",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9 -]{10,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha del libro no es valida, coloque una fecha adecuada dia/mes/año". $fecha. ".",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Variables por defecto que no son obligatorias
        if ($editorial == "") $editorial = "No posee";
        if ($tomo == "") {$tomo = "No posee";}
        if ($edicion == "") {$edicion = "No posee";}

        // Paramttros a modificar
        $usuario_datos_act = [
            [
                "campo_nombre" => "cota",
                "campo_marcador" => ":Cpt",
                "campo_valor" => $cota
            ],
            [
                "campo_nombre" => "titulo",
                "campo_marcador" => ":Tit",
                "campo_valor" => ucwords($titulo)
            ],
            [
                "campo_nombre" => "autor",
                "campo_marcador" => ":Aut",
                "campo_valor" => ucwords($autor)
            ],
            [
                "campo_nombre" => "area",
                "campo_marcador" => ":Are",
                "campo_valor" => ucwords($area)
            ],
            [
                "campo_nombre" => "editorial",
                "campo_marcador" => ":Edi",
                "campo_valor" => ucwords($editorial)
            ],
            [
                "campo_nombre" => "edicion",
                "campo_marcador" => ":Edd",
                "campo_valor" => $edicion
            ],
            [
                "campo_nombre" => "tomos",
                "campo_marcador" => ":Tom",
                "campo_valor" => $tomo
            ],
            [
                "campo_nombre" => "ejemplares_tot",
                "campo_marcador" => ":Ejt",
                "campo_valor" => intval($ejemplares)
            ],
            [
                "campo_nombre" => "ejemplares_dis",
                "campo_marcador" => ":Ejd",
                "campo_valor" => intval($ejemplares)
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":Fec",
                "campo_valor" => $fecha
            ]
        ];

        // Condicion que indica donde se van a realizar los cambios
        $condicion = [
            "condicion_campo" => "id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        // Comporbando que el libro se haya actualizado con la consulta
        if ($this->actualizarDatos($this->tablaSQL, $usuario_datos_act, $condicion)) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro modificado",
                "texto" => "El libro se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar el libro, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador desactivar libro
    public function desabilitarLibroControlador()
    {
        $id = $this->limpiarCadena($_POST['libro_id']);

        # Verificando libro
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un libro con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $reactivarLibro= $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "No disponible","id", $id);

        if ($reactivarLibro->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro desabilitado",
                "texto" => "El libro ya no se encuentra disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El libro sigue estando disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador activar libro
    public function habilitarLibroControlador()
    {
        $id = $this->limpiarCadena($_POST['libro_id']);

        # Verificando libro
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un libro con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $reactivarEstudiante = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Disponible","id", $id);

        if ($reactivarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro Habilitado",
                "texto" => "El libro esta disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El libro sigue estando no disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    public function editar($cedula){
        $data = $this->seleccionarDatos("Unico","estudiantes","cedula",$cedula);
        $resultado = $data->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        die();
    }
}
