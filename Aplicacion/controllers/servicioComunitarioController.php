<?php

namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class servicioComunitarioController extends mainModel
{
    private string $tablaSQL = "servicios_comunitarios";

    // Controlador para registrar un Servicio Comunitario
    public function registrarServicioControlador()
    {
        #id #1
        $cota = ($this->limpiarCadena($_POST['sercomu_cota']));                        #2
        $titulo = $this->limpiarCadena($_POST['sercomu_titulo']);                      #3
        $autores = $this->limpiarCadena($_POST['sercomu_autores']);                    #4
        $tutorAcademico = $this->limpiarCadena($_POST['sercomu_tutor_academico']);     #5
        $tutorComunitario = $this->limpiarCadena($_POST['sercomu_tutor_comunitario']); #6
        $institucion = $this->limpiarCadena($_POST['sercomu_institucion']);            #7
        $fecha = $this->limpiarCadena($_POST['sercomu_fecha']);                        #8
        #estado #9

        // Verificando que los campos obligatorios tengan informacion
        if ($cota == "" || $titulo == "" || $autores == "" || $fecha == "") {
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
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ \r\n]{3,200}", $autores)) {
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
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutorAcademico)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Academico tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Tutor Comunitario
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutorComunitario)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Comunitario tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando institucion
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $institucion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La institucion del Servicio Comunitario tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha de presentacion
        if ($this->verificarDatos("[0-9 -]{7,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha del Servicio Comunitario no es valida, coloque una fecha adecuada (Mes-Año)",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($tutorAcademico == "") $tutorAcademico = "Desconocido";
        if ($tutorComunitario == "") $tutorComunitario = "Desconocido";
        if ($institucion == "") $institucion = "Desconocido";

        // Preparando datos para registrar
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
                "campo_nombre" => "autores",
                "campo_marcador" => ":Aut",
                "campo_valor" => ucwords($autores)
            ],
            [
                "campo_nombre" => "tutor_academico",
                "campo_marcador" => ":TutA",
                "campo_valor" => ucwords($tutorAcademico)
            ],
            [
                "campo_nombre" => "tutor_comunitario",
                "campo_marcador" => ":TutC",
                "campo_valor" => ucwords($tutorComunitario)
            ],
            [
                "campo_nombre" => "institucion",
                "campo_marcador" => ":Ins",
                "campo_valor" => ucwords($institucion)
            ],
            [
                "campo_nombre" => "fecha_presentacion",
                "campo_marcador" => ":Fec",
                "campo_valor" => $fecha
            ]
        ];

        // Realizando la insersion de los datos
        $registrar_sercomu = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_sercomu->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Servicio registrado",
                "texto" => "El Servicio Comunitario se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar el Servicio Comunitario, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar los Servicios Comunitarios
    public function listarServiciosControlador()
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
                    <td>' . $rows['autores'] . '</td>
                    <td>' . $rows['tutor_academico'] . '</td>
                    <td>' . $rows['tutor_comunitario'] . '</td>
                    <td>' . $rows['institucion'] . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha_presentacion']) . '</td>';

                    if ($rows['estado'] == "Disponible") {
                        $tabla_html .= '<td>
                        <span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarServicio('.$rows['id'].')"><span>Editar</span><i class="fa-solid fa-file-pen"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_sercomu" value="desabilitar">
			                <input type="hidden" name="sercomu_id" value="' . $rows['id'] . '">

			                <button type="submit" class="btn_actions_table btn_eliminar"><span>Deshabilitar</span><i class="fa-regular fa-circle-xmark"></i></button>
			            </form>
                    </td>
                </tr>';
                    } else {
                        $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_sercomu" value="habilitar">
			                <input type="hidden" name="sercomu_id" value="' . $rows['id'] . '">

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

    // Controlador para modificar datos del servicio comunitario
    public function actualizarServicioControlador()
    {
        $id = $this->limpiarCadena($_POST['sercomu_id']);

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

        #id #1
        $cota = $this->limpiarCadena($_POST['pasantia_cota_modificar']);               #2
        $titulo = $this->limpiarCadena($_POST['sercomu_titulo']);                      #3
        $autores = $this->limpiarCadena($_POST['sercomu_autores']);                    #4
        $tutorAcademico = $this->limpiarCadena($_POST['sercomu_tutor_academico']);     #5
        $tutorComunitario = $this->limpiarCadena($_POST['sercomu_tutor_comunitario']); #6
        $institucion = $this->limpiarCadena($_POST['sercomu_institucion']);            #7
        $fecha = $this->limpiarCadena($_POST['sercomu_fecha']);                        #8
        #estado #9

        // Verificando que los campos importantes esten llenos
        if ($cota == "" || $titulo == "" || $autores == "" || $fecha == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de la cota
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
                $check_cota = $this->ejecutarConsulta("SELECT cota FROM ".$tablita['tabla']." WHERE cota='$cota'");
                if ($check_cota->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Ya existe un/a ".$tablita['nombre']."  con esa cota en el sistema",
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
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ \r\n]{3,200}", $autores)) {
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
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutorAcademico)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Academico tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Tutor Comunitario
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutorComunitario)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del Tutor Comunitario tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando institucion
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $institucion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La institucion del servicio comunitario tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha de presentacion
        if ($this->verificarDatos("[0-9 -]{7,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha de la pasantia no es valida, coloque una fecha adecuada (Mes-Día)",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Estableciendo valores por defecto si estan vacios
        if ($tutorAcademico == "") $tutorAcademico = "Desconocido";
        if ($tutorComunitario == "") $tutorComunitario = "Desconocido";
        if ($institucion == "") $institucion = "Desconocido";

        $usuario_datos_act = [
            [
                "campo_nombre" => "cota",
                "campo_marcador" => ":Cot",
                "campo_valor" => $cota
            ],
            [
                "campo_nombre" => "titulo",
                "campo_marcador" => ":Tit",
                "campo_valor" => $titulo
            ],
            [
                "campo_nombre" => "autores",
                "campo_marcador" => ":Aut",
                "campo_valor" => $autores
            ],
            [
                "campo_nombre" => "tutor_academico",
                "campo_marcador" => ":TutA",
                "campo_valor" => $tutorAcademico
            ],
            [
                "campo_nombre" => "tutor_comunitario",
                "campo_marcador" => ":TutC",
                "campo_valor" => $tutorComunitario
            ],
            [
                "campo_nombre" => "institucion",
                "campo_marcador" => ":Ins",
                "campo_valor" => $institucion
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
                "titulo" => "Servicio modificado",
                "texto" => "El Servicio Comunitario se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar el Servicio Comunitario, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para Deshabilitar un Servicio Comunitario
    public function desabilitarServicioControlador()
    {
        $id = $this->limpiarCadena($_POST['sercomu_id']);

        # Verificando libro
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Servicio Comunitario con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else $datos = $datos->fetch();

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "No disponible","id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Libro desabilitado",
                "texto" => "El informe de Servicio Comunitario ya no se encuentra disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El informe de Servicio Comunitario sigue estando disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para Habilitar un Servicio Comunitario
    public function habilitarServicioControlador()
    {
        $id = $this->limpiarCadena($_POST['sercomu_id']);

        # Verificando Servicio Comunitario
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE id='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Servicio Comunitario con esa cota en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else $datos = $datos->fetch();

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Disponible","id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Servicio Comunitario Habilitado",
                "texto" => "El informe de Servicio Comunitario ahora esta disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El informe de Servicio Comunitario sigue estando no disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}