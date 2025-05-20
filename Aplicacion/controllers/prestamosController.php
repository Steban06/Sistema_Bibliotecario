<?php
namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class prestamosController extends mainModel
{
    private string $tablaSQL = "prestamos";

    // Controlador para iniciar un Prestamo
    public function registrarPrestamoControlador()
    {
        $cedula = $this->limpiarCadena($_POST['prestamo_cedula']);
        $cota = $this->limpiarCadena($_POST['prestamo_cota']);
        $fechaEntrada = $this->limpiarCadena($_POST['prestamo_fecha_entrega']);

        if ($cedula == "" || $cota == "" || $fechaEntrada == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[0-9]{6,9}", $cedula)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La cedula no coincide con el formato solicitado, de 6 a 9 numeros",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Validando que hay un estudiante o docente con esa cedula y verificando que la persona este activa en el sistema
        $check_cedula_estudiante = $this->ejecutarConsulta("SELECT cedula,estado FROM estudiantes WHERE cedula='$cedula'");
        $check_cedula_docente = $this->ejecutarConsulta("SELECT cedula,estado FROM docentes WHERE cedula='$cedula'");
        if ($check_cedula_estudiante->rowCount() < 1 && $check_cedula_docente->rowCount() < 1) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No existe una persona con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            if ($check_cedula_estudiante->rowCount() > 0) {
                $datosPersona= $check_cedula_estudiante->fetch();
                if ($datosPersona['estado'] == "Inactivo") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Este estudiante no puede solicitar prestamos, esta inactivo en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } elseif ($check_cedula_docente->rowCount() > 0) {
                $datosPersona= $check_cedula_docente->fetch();
                if ($datosPersona['estado'] == "Inactivo") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Este docente no puede solicitar prestamos, esta inactivo en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
        }

        if ($this->verificarDatos("[a-zA-z0-9ñÑ]{5,10}", $cota)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La cota no coincide con el formato solicitado, de 5 a 10 caracteres",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Validando que esa cota pertenece a algun documento
        $check_libros = $this->ejecutarConsulta("SELECT `cota`,`estado` FROM `libros` WHERE `cota`='$cota'");
        $check_is_traInv = $this->ejecutarConsulta("SELECT `cota`,`estado` FROM trabajos_investigacion WHERE cota='$cota'");
        $check_pasantias = $this->ejecutarConsulta("SELECT `cota`,`estado` FROM pasantias WHERE cota='$cota'");
        $check_is_serCom = $this->ejecutarConsulta("SELECT `cota`,`estado` FROM servicios_comunitarios WHERE cota='$cota'");
        if ($check_libros->rowCount() < 1 && $check_is_traInv->rowCount() < 1 && $check_pasantias->rowCount() < 1 && $check_is_serCom->rowCount() < 1) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No existe un documento con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            if ($check_libros->rowCount() > 0) { // Verificando si el libro esta disponible
                $libro = $check_libros->fetch();
                if ($libro['estado'] == "No disponible") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Este libro no se puede prestar, esta deshabilitado en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
            if ($check_is_serCom->rowCount() > 0) { // Verificando si el servicio comunitario esta disponible
                $serComu = $check_is_serCom->fetch();
                if ($serComu['estado'] == "No disponible") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Este Servicio Comunitario no se puede prestar, esta deshabilitado en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
            if ($check_pasantias->rowCount() > 0) { // Verificando si la pasantia esta disponible
                $pasantia = $check_pasantias->fetch();
                if ($pasantia['estado'] == "No disponible") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Esta pasantia no se puede prestar, esta deshabilitada en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
            if ($check_is_traInv->rowCount() > 0) { // Verificando si el trabajo de investigacion esta disponible
                $trabajo = $check_is_traInv->fetch();
                if ($trabajo['estado'] == "No disponible") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Este Trabajo de Investigación no se puede prestar, esta deshabilitada en el sistema.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
        }

        if (strtotime(date("Y-m-d")) > strtotime($fechaEntrada)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No puedes devolver un documento un dia que ya paso",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $usuario_datos_reg = [
            [
                "campo_nombre" => "cedula_persona",
                "campo_marcador" => ":Ced",
                "campo_valor" => $cedula
            ],
            [
                "campo_nombre" => "cota_documento",
                "campo_marcador" => ":Cot",
                "campo_valor" => $cota
            ],
            [
                "campo_nombre" => "fecha_salida",
                "campo_marcador" => ":FeS",
                "campo_valor" => date("Y-m-d")
            ],
            [
                "campo_nombre" => "fecha_entrada",
                "campo_marcador" => ":FeE",
                "campo_valor" => $fechaEntrada
            ],
            [
                "campo_nombre" => "estado",
                "campo_marcador" => ":Est",
                "campo_valor" => "Prestado"
            ],
            [
                "campo_nombre" => "observaciones",
                "campo_marcador" => ":Edd",
                "campo_valor" => "No hay observaciones"
            ],
            [
                "campo_nombre" => "ususario_registro",
                "campo_marcador" => ":UsR",
                "campo_valor" => $_SESSION['id']
            ]
        ];

        if ($check_libros->rowCount() == 1) {
            $cantLibro = $this->ejecutarConsulta("SELECT `cota`,`ejemplares_dis` FROM `libros` WHERE `cota`='$cota'");
            $libro = $cantLibro->fetch();

            if ($libro['ejemplares_dis'] <= 1) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "El libro no tiene ejemplares disponibles para prestar, solo tiene ".$libro['ejemplares_dis']." ejemplar",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $this->ejecutarConsulta("UPDATE `libros` SET `ejemplares_dis`=(`ejemplares_dis`-1) WHERE `libros`.`cota`='$cota';");
            }
        }

        $registrar_prestamo = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_prestamo->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Prestamo iniciado",
                "texto" => "El prestamo ha sido registrado y iniciado con exito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo iniciar el prestamo, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar los prestamos
    public function listarPrestamosControlador()
    {
        $tabla_html = '';

        $consulta = "SELECT * FROM $this->tablaSQL";
        $consulta_total = "SELECT COUNT(ID) FROM $this->tablaSQL";

        $datos = $this->ejecutarConsulta($consulta);
        $datos = $datos->fetchAll();

        $total_registros = $this->ejecutarConsulta($consulta_total);
        $total_registros = (int) $total_registros->fetchColumn();

        if ($total_registros > 0) {
            foreach ($datos as $rows) {
                $tabla_html .= '<tr>
                    <td>' . $rows['ID'] . '</td>
                    <td>' . $rows['cedula_persona'] . '</td>
                    <td>' . $rows['cota_documento'] . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha_salida']) . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha_entrada']) . '</td>
                    <td>' . $rows['ususario_registro'] . '</td>';

                if ($rows['estado'] == "Prestado") {
                    $fecha_actual = strtotime(date("Y-m-d"));
                    $fecha_devolucion = strtotime($rows['fecha_entrada']);
                    if ($fecha_actual > $fecha_devolucion) {
                        $tabla_html .= '<td><span class="badgePrestamo registro-inactivo">No devuelto</span></td>';
                    } else {
                        $tabla_html .= '<td><span class="badgePrestamo registro-prestado">' . $rows['estado'] . '</span></td>';
                    }
                    $tabla_html .='
                    <td>
                        <button class="btn_actions_table btn_vermas" onclick="mostrarModalVerMas('.$rows['ID'].')"><span>Ver más</span><i class="fa-solid fa-circle-info"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off">

			                <input type="hidden" name="modulo_prestamos" value="devolver">
			                <input type="hidden" name="prestamo_id" value="' . $rows['ID'] . '">

			                <button type="submit" class="btn_actions_table btn_devolver"><span>Devolver</span><i class="fa-solid fa-reply"></i></button>
			            </form>
                    </td>
                </tr>';
                } else {
                    $tabla_html .= '<td><span class="badgePrestamo registro-activo">' . $rows['estado'] . '</span></td>';
                    $tabla_html .='
                    <td colspan="2">
                        <button class="btn_actions_table btn_vermas" onclick="mostrarModalVerMas('.$rows['ID'].')"><span>Ver más</span><i class="fa-solid fa-circle-info"></i></button>
                    </td>
                    <td hidden></td>
                </tr>';
                }
            }
        }

        return $tabla_html;
    }

    // Controlador para devolver el Prestamo
    public function devolverPrestamoControlador()
    {
        $idPrestamo = $this->limpiarCadena($_POST['prestamo_id']);
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE ID='$idPrestamo'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un prestamo con ese ID en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $consulta = $this->ejecutarConsulta("SELECT cota FROM libros WHERE cota='".$datos['cota_documento']."';");
        if ($consulta->rowCount() > 0) {
            $this->ejecutarConsulta("UPDATE `libros` SET `ejemplares_dis` = (`ejemplares_dis`+1) WHERE `libros`.`cota` = '".$datos['cota_documento']."';");
        }
        // $consulta = $this->ejecutarConsulta("SELECT cota FROM trabajos_investigacion WHERE cota='".$datos['cota_documento']."';");
        // if ($consulta->rowCount() > 0) {
        //     $this->ejecutarConsulta("UPDATE `trabajos_investigacion` SET `ejemplares_dis` = (`ejemplares_dis`+1) WHERE `libros`.`cota` = '".$datos['cota_documento']."';");
        // }
        // $consulta = $this->ejecutarConsulta("SELECT cota FROM pasantias WHERE cota='".$datos['cota_documento']."';");
        // if ($consulta->rowCount() > 0) {
        //     $this->ejecutarConsulta("UPDATE `pasantias` SET `ejemplares_dis` = (`ejemplares_dis`+1) WHERE `libros`.`cota` = '".$datos['cota_documento']."';");
        // }
        // $consulta = $this->ejecutarConsulta("SELECT cota FROM servicios_comunitarios WHERE cota='".$datos['cota_documento']."';");
        // if ($consulta->rowCount() > 0) {
        //     $this->ejecutarConsulta("UPDATE `servicios_comunitarios` SET `ejemplares_dis` = (`ejemplares_dis`+1) WHERE `libros`.`cota` = '".$datos['cota_documento']."';");
        // }

        $devolverPrestamo = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Devuelto", "ID", $idPrestamo);

        if ($devolverPrestamo->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Prestamo devuelto",
                "texto" => "El documento ha sido devuelto con exito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se puedo devolver el documento, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
