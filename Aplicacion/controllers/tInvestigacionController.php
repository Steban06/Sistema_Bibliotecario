<?php

namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class tInvestigacionController extends mainModel
{
    public string $tablaSQL = "trabajos_investigacion";

    // Controlador para registrar un nuevo trabajo de investigacion
    public function registrarTinvestigacionCrontrolador()
    {
        #id 1
        $cota = $this->limpiarCadena($_POST['tinestigacion_cota']);               #2
        $titulo = $this->limpiarCadena($_POST['tinestigacion_titulo']);           #3
        $autor = $this->limpiarCadena($_POST['tinestigacion_autor']);             #4
        $tutor = $this->limpiarCadena($_POST['tinestigacion_tutor']);             #5
        $tipo = $this->limpiarCadena($_POST['tinestigacion_tipo']);               #6
        $area = $this->limpiarCadena($_POST['tinestigacion_area']);               #7
        $mencion = $this->limpiarCadena($_POST['tinestigacion_mencion']);         #8
        $metodologia = $this->limpiarCadena($_POST['tinestigacion_metodologia']); #9
        $fecha = $this->limpiarCadena($_POST['tinestigacion_fecha']);             #10
        #estado 11

        // Verificando los campos obligatorios
        if ($cota == "" || $titulo == "" || $autor == "" || $tipo == "..." || $fecha == "" || $area == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de los datos de la cota
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

        // Verificando que la cota no se repita en la base de datos
        foreach ($this->array_tablas as $tablita) {
            $check_cota = $this->ejecutarConsulta("SELECT cota FROM " . $tablita['tabla'] . " WHERE cota='$cota'");
            if ($check_cota->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ya existe un(a) " . $tablita['nombre'] . "  con esa cota en el sistema",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        // Verificando Titulo
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}", $titulo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El titulo tiene caracteres no validos, solo caracteres de la A a la Z y numeros del 0 al 9",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Autores
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ \r\n]{3,200}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/Los nombre/s de el/los autor/es tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Tutor Academcio
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Academico tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Area
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,30}", $area)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "el Area del Trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Mencion
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $mencion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Mención del trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Metodologia
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $metodologia)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Metodología del Trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha de presentacion
        if ($this->verificarDatos("[0-9 -]{7,7}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha de la pasantia no es valida, coloque una fecha adecuada (año-mes-día)" . $fecha,
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Asignando valores por defecto
        if ($tutor == "") $tutor = "Desconocido";
        // if ($area == "") $area = "Desconocida";
        if ($mencion == "") $mencion = "Desconocida";
        if ($metodologia == "") $metodologia = "Desconocida";

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
                "campo_nombre" => "tutor",
                "campo_marcador" => ":Tut",
                "campo_valor" => ucwords($tutor)
            ],
            [
                "campo_nombre" => "tipo",
                "campo_marcador" => ":Tip",
                "campo_valor" => $tipo
            ],
            [
                "campo_nombre" => "area",
                "campo_marcador" => ":Are",
                "campo_valor" => ucwords($area)
            ],
            [
                "campo_nombre" => "mencion",
                "campo_marcador" => ":Men",
                "campo_valor" => ucwords($mencion)
            ],
            [
                "campo_nombre" => "metodologia",
                "campo_marcador" => ":Met",
                "campo_valor" => ucwords($metodologia)
            ],
            [
                "campo_nombre" => "fecha_presentacion",
                "campo_marcador" => ":Fec",
                "campo_valor" => $fecha
            ]
        ];

        $registrar_sercomu = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_sercomu->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Trabajo registrado",
                "texto" => "El Trabajo de Investigación se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar el Trabajo de Investigación, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar los trbajos de investigacion
    public function listarTinvestigacionControlador()
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
                    <td>' . $rows['tutor'] . '</td>
                    <td>' . $rows['tipo'] . '</td>
                    <td>' . $rows['area'] . '</td>
                    <td>' . $rows['mencion'] . '</td>
                    <td>' . $rows['metodologia'] . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha_presentacion']) . '</td>';

                if ($rows['estado'] == "Disponible") {
                    $tabla_html .= '<td>
                        <span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarTrabajoI(' . $rows['id'] . ')"><span>Editar</span><i class="fa-solid fa-file-pen"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_tinestigacion" value="desabilitar">
			                <input type="hidden" name="tinestigacion_id" value="' . $rows['id'] . '">

			                <button type="submit" class="btn_actions_table btn_eliminar"><span>Deshabilitar</span><i class="fa-regular fa-circle-xmark"></i></button>
			            </form>
                    </td>
                </tr>';
                } else {
                    $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_tinestigacion" value="habilitar">
			                <input type="hidden" name="tinestigacion_id" value="' . $rows['id'] . '">

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

    // Controlador para modificar un Trabajo de Investigacion
    public function actualizarTinvestigacionCrontrolador()
    {
        // Verificando la existencia del trabajo
        $id = $this->limpiarCadena($_POST['tinestigacion_id']);

        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro una pasantia con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        #id 1
        $cota = $this->limpiarCadena($_POST['trabajo_cota_modificar']);           #2
        $titulo = $this->limpiarCadena($_POST['tinestigacion_titulo']);           #3
        $autor = $this->limpiarCadena($_POST['tinestigacion_autor']);             #4
        $tutor = $this->limpiarCadena($_POST['tinestigacion_tutor']);             #5
        $tipo = $this->limpiarCadena($_POST['tinestigacion_tipo']);               #6
        $area = $this->limpiarCadena($_POST['tinestigacion_area']);               #7
        $mencion = $this->limpiarCadena($_POST['tinestigacion_mencion']);         #8
        $metodologia = $this->limpiarCadena($_POST['tinestigacion_metodologia']); #9
        $fecha = $this->limpiarCadena($_POST['tinestigacion_fecha']);             #10
        #estado 11

        // Verificando los campos obligatorios
        if ($cota == "" || $titulo == "" || $autor == "" || $tipo == "..." || $fecha == "" || $area == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de los datos de la cota
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

        // Verificando que la cota no se repita en la base de datos
        if ($datos['cota'] != $cota) {
            foreach ($this->array_tablas as $tablita) {
                $check_cota = $this->ejecutarConsulta("SELECT cota FROM " . $tablita['tabla'] . " WHERE cota='$cota'");
                if ($check_cota->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Ya existe un(a) " . $tablita['nombre'] . "  con esa cota en el sistema",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
        }

        // Verificando Titulo
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}", $titulo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El titulo tiene caracteres no validos, solo caracteres de la A a la Z y numeros del 0 al 9",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Autores
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ \r\n]{3,200}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/Los nombre/s de el/los autor/es tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Tutor Academcio
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Academico tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Area
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,30}", $area)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "el Area del Trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Mencion
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $mencion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Mención del trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Metodologia
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $metodologia)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Metodología del Trabajo de Investigación tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha de presentacion
        if ($this->verificarDatos("[0-9 -]{7,7}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha de la pasantia no es valida, coloque una fecha adecuada (año-mes-día)" . $fecha,
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Asignando valores por defecto
        if ($tutor == "") $tutor = "Desconocido";
        // if ($area == "") $area = "Desconocida";
        if ($mencion == "") $mencion = "Desconocida";
        if ($metodologia == "") $metodologia = "Desconocida";

        $usuario_datos_act = [
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
                "campo_nombre" => "tutor",
                "campo_marcador" => ":Tut",
                "campo_valor" => ucwords($tutor)
            ],
            [
                "campo_nombre" => "tipo",
                "campo_marcador" => ":Tip",
                "campo_valor" => $tipo
            ],
            [
                "campo_nombre" => "area",
                "campo_marcador" => ":Are",
                "campo_valor" => ucwords($area)
            ],
            [
                "campo_nombre" => "mencion",
                "campo_marcador" => ":Men",
                "campo_valor" => ucwords($mencion)
            ],
            [
                "campo_nombre" => "metodologia",
                "campo_marcador" => ":Met",
                "campo_valor" => ucwords($metodologia)
            ],
            [
                "campo_nombre" => "fecha_presentacion",
                "campo_marcador" => ":Fec",
                "campo_valor" => $fecha
            ]
        ];

        $condicion = [
            "condicion_campo" => "id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos($this->tablaSQL, $usuario_datos_act, $condicion)) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Trabajo modificada",
                "texto" => "El trabajo de Investigación se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar el Trabajo de investigación, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para Deshabilitar un Trabajo de Investigación
    public function deshabilitarTinvestigacionCrontrolador()
    {
        $id = $this->limpiarCadena($_POST['tinestigacion_id']);

        # Verificando Trabajo de Investigacion
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Trabajo de Investigación con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else $datos = $datos->fetch();

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "No disponible", "id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro desabilitado",
                "texto" => "El Trabajo de Investigación ya no se encuentra disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El Trabajo de Investigación sigue estando disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para Habilitar un Trabajo de Investigación
    public function habilitarTinvestigacionCrontrolador()
    {
        $id = $this->limpiarCadena($_POST['tinestigacion_id']);

        # Verificando Servicio Comunitario
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Trabajo de Investigación con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else $datos = $datos->fetch();

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Disponible", "id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Servicio Comunitario Habilitado",
                "texto" => "El Trabajo de Investigación ahora esta disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El Trabajo de Investigación sigue estando no disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
