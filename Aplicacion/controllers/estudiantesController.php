<?php

namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class estudiantesController extends mainModel
{
    private string $tablaSQL = "estudiantes";

    // Controlador para registrar un estudiante
    public function registrarEstudianteControlador()
    {
        // Almacenando datos
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula']);       #1
        $nombres = $this->limpiarCadena($_POST['estudiante_nombres']);     #2
        $apellidos = $this->limpiarCadena($_POST['estudiante_apellidos']); #3
        $telefono = $this->limpiarCadena($_POST['estudiante_telefono']);   #4
        $direccion = $this->limpiarCadena($_POST['estudiante_direccion']); #5
        $email = $this->limpiarCadena($_POST['estudiante_email']);         #6
        $carrera = $this->limpiarCadena($_POST['estudiante_carrera']);     #7
        $semestre = $this->limpiarCadena($_POST['estudiante_semestre']);   #8
        // $estado = 1;

        // Verificando campos obligatorios
        if ($cedula == "" || $nombres == "" || $apellidos == "" || $email == "" || $carrera == "..." || $semestre == "...") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "tas pelando bolas",
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

        // Verificando integridad de los nombres
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

        // Verificando integridad de los apellidos
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
        if ($telefono != ""){
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

        if ($telefono == "") $telefono = "No posee";
        if ($direccion == "") $direccion = "Desconocida";

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
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "email",
                "campo_marcador" => ":Ema",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "carrera",
                "campo_marcador" => ":Car",
                "campo_valor" => $carrera
            ],
            [
                "campo_nombre" => "semestre",
                "campo_marcador" => ":Sem",
                "campo_valor" => $semestre
            ]
        ];

        $registrar_usuario = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_usuario->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Estudiante registrado",
                "texto" => "El estudiante se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar el estudiante, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar estudiantes
    public function listarEstudiantesControlador()
    {
        $tabla_html = '';

        $consulta = "SELECT `estudiantes`.*, `carreras`.`descripcion`
            FROM `estudiantes` 
            INNER JOIN `carreras` ON `estudiantes`.`carrera` = `carreras`.`codigo`;";

        $consulta_total = "SELECT COUNT(cedula) FROM $this->tablaSQL";

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
                    <td>' . $rows['descripcion'] . '</td>
                    <td>' . $rows['semestre'] . '</td>';
                    
                if ($rows['estado'] == "Activo") {
                    $tabla_html .= '<td><span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarEstudiante('.$rows['cedula'].')"><span class="button_text">Editar</span><i class="icon fa-solid fa-pen-to-square"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_estudiantes" value="desactivar">
			                <input type="hidden" name="estudiante_cedula" value="' . $rows['cedula'] . '">

                            <button class="btn_actions_table btn_eliminar"><span>Dar baja</span><i class="fa-solid fa-square-xmark"></i></button>
                        </form>
                    </td>
                </tr>';
                } else {
                    $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                    <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

                        <input type="hidden" name="modulo_estudiantes" value="reactivar">
                        <input type="hidden" name="estudiante_cedula" value="' . $rows['cedula'] . '">

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

    // Controlador para eliminar estudiante desde boton
    public function eliminarEstudianteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula']);

        # Verificando estudiante
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

    // Controlador actualizar estudiante
    public function actualizarEstudianteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula_modificar']);

        # Verificando estudiante
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

        $nombres = $this->limpiarCadena($_POST['estudiante_nombres']);     #1
        $apellidos = $this->limpiarCadena($_POST['estudiante_apellidos']); #2
        $telefono = $this->limpiarCadena($_POST['estudiante_telefono']);   #3
        $direccion = $this->limpiarCadena($_POST['estudiante_direccion']); #4
        $email = $this->limpiarCadena($_POST['estudiante_email']);         #5
        $carrera = $this->limpiarCadena($_POST['estudiante_carrera']);     #6
        $semestre = $this->limpiarCadena($_POST['estudiante_semestre']);   #7
        // $estado = $this->limpiarCadena($_POST['estudiante_estado']);       #8
        // $estado = 1;

        // Verificando campos obligatorios
        if ($nombres == "" || $apellidos == "" || $email == "" || $carrera == "..." || $semestre == "...") {
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

        // Verificar que un estudiante no se repita en la base de datos
        if ($datos['cedula'] != $cedula) {
            $check_cedula = $this->ejecutarConsulta("SELECT cedula FROM estudiantes WHERE cedula='$cedula'");
            if ($check_cedula->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Ya existe un estuidante con esa cedula en el sistema",
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
        if ($telefono != "" && $telefono != "No posee"){
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

        if ($telefono == "") $telefono = "No posee";
        if ($direccion == "") $direccion = "Desconocida";

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
                "campo_nombre" => "carrera",
                "campo_marcador" => ":Car",
                "campo_valor" => $carrera
            ],
            [
                "campo_nombre" => "semestre",
                "campo_marcador" => ":Sem",
                "campo_valor" => $semestre
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
                "titulo" => "Estudiante modificado",
                "texto" => "El estudiante se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar el estudiante, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para desactivar estudiante
    public function desactivarEstudianteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula']);

        # Verificando estudiante
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

        $reactivarEstudiante = $this->desactivarRegistro($this->tablaSQL, "estado","cedula", $cedula);

        if ($reactivarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Estudiante dado de baja",
                "texto" => "El estudiante ya no se encuentra activo en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Al estudiante no se le pudo dar de baja, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para activar estudiante
    public function reactivarEstudianteControlador()
    {
        $cedula = $this->limpiarCadena($_POST['estudiante_cedula']);

        # Verificando estudiante
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

        $reactivarEstudiante = $this->reactivarRegistro($this->tablaSQL, "estado","cedula", $cedula);

        if ($reactivarEstudiante->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Estudiante Reactivado",
                "texto" => "El estudiante vuleve a estar activo en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El estudiante no pudo reactivarse, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // public function editar($cedula){
    //     $data = $this->seleccionarDatos("Unico","estudiantes","cedula",$cedula);
    //     $resultado = $data->fetch(PDO::FETCH_ASSOC);
    //     echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    //     die();
    // }
}
