<?php
namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class docentesController extends mainModel
{
    private $tablaSQL = "docentes";

    // Controlador para ingresar un nuevo docente en el sistema
    public function registrarDocentesControlador()
    {
        // Almacenando datos
        $cedula = $this->limpiarCadena($_POST['docentes_cedula']);       #1
        $nombres = $this->limpiarCadena($_POST['docentes_nombres']);     #2
        $apellidos = $this->limpiarCadena($_POST['docentes_apellidos']); #3
        $telefono = $this->limpiarCadena($_POST['docentes_telefono']);   #4
        $direccion = $this->limpiarCadena($_POST['docentes_direccion']); #5
        $email = $this->limpiarCadena($_POST['docentes_email']);         #6
        $materia = $this->limpiarCadena($_POST['docentes_materia']);     #7
        // $estado = 1;

        // Verificando campos obligatorios
        if ($cedula == "" || $nombres == "" || $apellidos == "" || $telefono == "" || $email == "") {
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

        // Verificando que la cedula sea un numero coherente
        if (intval($cedula) < 100000) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Ingrese una cedula valida",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificar que un estudiante no se repita en la base de datos
        foreach ($this->array_personas as $tablita) {
            $check_cota = $this->ejecutarConsulta("SELECT cedula FROM ".$tablita['tabla']." WHERE cedula='$cedula'");
            if ($check_cota->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ya existe un ".$tablita['nombre']."  con esa cedula en el sistema",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $nombres)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $apellidos)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/los apellido/s tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9]{11,11}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El numero de telefono no corresponde con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Email
        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email_estudiante = $this->ejecutarConsulta("SELECT email FROM estudiantes WHERE email='$email'");
                $check_email_docente = $this->ejecutarConsulta("SELECT email FROM docentes WHERE email='$email'");

                if ($check_email_estudiante->rowCount() > 0 || $check_email_docente->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "El Email ya existe en el sistema",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ha ingresado un Email no valido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $materia)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Materia tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($direccion == "") $direccion = "Desconocida";
        if ($materia == "") $materia = "Se desconoce";

        $usuario_datos_reg = [
            [
                "campo_nombre" => "cedula",
                "campo_marcador" => ":Ced",
                "campo_valor" => $cedula
            ],
            [
                "campo_nombre" => "nombres",
                "campo_marcador" => ":Nom",
                "campo_valor" => ucwords($nombres)
            ],
            [
                "campo_nombre" => "apellidos",
                "campo_marcador" => ":Ape",
                "campo_valor" => ucwords($apellidos)
            ],
            [
                "campo_nombre" => "telefono",
                "campo_marcador" => ":Tel",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "direccion",
                "campo_marcador" => ":Dir",
                "campo_valor" => ucwords($direccion)
            ],
            [
                "campo_nombre" => "email",
                "campo_marcador" => ":Ema",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "materia",
                "campo_marcador" => ":Mat",
                "campo_valor" => ucwords($materia)
            ]
        ];

        $registrar_docente = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_docente->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Docente registrado",
                "texto" => "El Docente se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar al Docente, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar los docentes
    public function listarDocentesControlador()
    {
        $tabla_html = '';

        $consulta = "SELECT * FROM docentes";
        $consulta_total = "SELECT COUNT(cedula) FROM docentes";

        $datos = $this->ejecutarConsulta($consulta);
        $datos = $datos->fetchAll();

        $total_registros = $this->ejecutarConsulta($consulta_total);
        $total_registros = (int) $total_registros->fetchColumn();

        if ($total_registros > 0) {
            foreach ($datos as $rows) {
                $tabla_html .= '<tr>
                    <td>' . $rows['cedula'] . '</td>
                    <td>' . $rows['nombres'] . ' ' . $rows['apellidos'] . '</td>
                    <td>' . $rows['telefono'] . '</td>
                    <td>' . $rows['direccion'] . '</td>
                    <td>' . $rows['email'] . '</td>
                    <td>' . $rows['materia'] . '</td>';

                if ($rows['estado'] == "Activo") {
                    $tabla_html .= '<td><span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarDocente('.$rows['cedula'].')"><span class="button_text">Editar</span><i class="icon fa-solid fa-pen-to-square"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_docentes" value="desactivar">
			                <input type="hidden" name="docente_cedula" value="' . $rows['cedula'] . '">

                            <button class="btn_actions_table btn_eliminar"><span>Dar baja</span><i class="fa-solid fa-square-xmark"></i></button>
                        </form>
                    </td>
                </tr>';
                } else {
                    $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                    <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

                        <input type="hidden" name="modulo_docentes" value="reactivar">
                        <input type="hidden" name="docente_cedula" value="' . $rows['cedula'] . '">

                        <button type="submit" class="btn_actions_table btn_reactivar"><span>Reingresar</span><i class="fa-solid fa-square-check"></i></button>
                    </form>
                </td>
                <td hidden></td>
            </tr>';
                }
            }
        }

        return $tabla_html;
    }

    // Controlador actualizar estudiante
    public function actualizarDocenteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['docente_cedula_modificar']);

        # Verificando estudiante
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE cedula='$cedula'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Docente con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        // $cedula = $this->limpiarCadena($_POST['docente_cedula']);       #1
        $nombres = $this->limpiarCadena($_POST['docentes_nombres']);     #2
        $apellidos = $this->limpiarCadena($_POST['docentes_apellidos']); #3
        $telefono = $this->limpiarCadena($_POST['docentes_telefono']);   #4
        $direccion = $this->limpiarCadena($_POST['docentes_direccion']); #5
        $email = $this->limpiarCadena($_POST['docentes_email']);         #6
        $materia = $this->limpiarCadena($_POST['docentes_materia']);     #7
        // $estado = 1;

        // Verificando campos obligatorios
        if ($nombres == "" || $apellidos == "" || $telefono == "" || $email == "") {
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

        // Verificar que un docente no se repita en la base de datos y que la cedula a modificar tampoco se repita
        if ($datos['cedula'] != $cedula) {
            foreach ($this->array_personas as $tablita) {
                $check_cota = $this->ejecutarConsulta("SELECT cedula FROM ".$tablita['tabla']." WHERE cedula='$cedula'");
                if ($check_cota->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "Ya existe un ".$tablita['nombre']."  con esa cedula en el sistema",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $nombres)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $apellidos)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El/los apellido/s tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9]{11,11}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El numero de telefono no corresponde con el formatos solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando Email
        if ($email != "" && $datos['email'] != $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email_estudiante = $this->ejecutarConsulta("SELECT email FROM estudiantes WHERE email='$email'");
                $check_email_docente = $this->ejecutarConsulta("SELECT email FROM docentes WHERE email='$email'");

                if ($check_email_estudiante->rowCount() > 0 || $check_email_docente->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrio un error inesperado",
                        "texto" => "El Email ya existe en el sistema",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ha ingresado un Email no valido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}", $materia)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La Materia tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($direccion == "") $direccion = "Desconocida";
        if ($materia == "") $materia = "Se desconoce";

        $usuario_datos_act = [
            [
                "campo_nombre" => "nombres",
                "campo_marcador" => ":Nom",
                "campo_valor" => ucwords($nombres)
            ],
            [
                "campo_nombre" => "apellidos",
                "campo_marcador" => ":Ape",
                "campo_valor" => ucwords($apellidos)
            ],
            [
                "campo_nombre" => "telefono",
                "campo_marcador" => ":Tel",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "direccion",
                "campo_marcador" => ":Dir",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "email",
                "campo_marcador" => ":Ema",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "materia",
                "campo_marcador" => ":Mat",
                "campo_valor" => ucwords($materia)
            ]
        ];

        $condicion = [
            "condicion_campo" => "cedula",
            "condicion_marcador" => ":Ced",
            "condicion_valor" => $cedula
        ];

        // $registrar_usuario = $this->guardarDatos("estudiantes", $usuario_datos_reg);

        if ($this->actualizarDatos($this->tablaSQL, $usuario_datos_act, $condicion)) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Docente modificado",
                "texto" => "El Docente se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar el Docente, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }


    // Controlador para desactivar docente
    public function desactivarDocenteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['docente_cedula']);

        # Verificando docente
        $datos = $this->ejecutarConsulta("SELECT * FROM docentes WHERE cedula='$cedula'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Docente con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $reactivarEstudiante = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Inactivo", "cedula", $cedula);

        if ($reactivarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Docente dado de baja",
                "texto" => "El Docente ya no se encuentra activo en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Al Docente no se le pudo dar de baja, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para activar docente
    public function reactivarDocenteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['docente_cedula']);

        # Verificando estudiante
        $datos = $this->ejecutarConsulta("SELECT * FROM $this->tablaSQL WHERE cedula='$cedula'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se encontro un Docente con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $reactivarEstudiante = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Activo", "cedula", $cedula);

        if ($reactivarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Docente Reactivado",
                "texto" => "El Docente vuleve a estar activo en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El Docente no pudo reactivarse, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}