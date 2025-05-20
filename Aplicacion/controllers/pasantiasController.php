<?php

namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class pasantiasController extends mainModel
{
    private string $tablaSQL = "pasantias";

    // Controlador para registrar una pasantia
    public function registrarPasantiasControlador()
    {
        #id #1
        $cota = ($this->limpiarCadena($_POST['pasantia_cota']));             #2
        $titulo = $this->limpiarCadena($_POST['pasantia_titulo']);           #3
        $autor = $this->limpiarCadena($_POST['pasantia_autor']);             #4
        $tutor = $this->limpiarCadena($_POST['pasantia_tutor']);             #5
        $institucion = $this->limpiarCadena($_POST['pasantia_institucion']); #6
        $fecha = $this->limpiarCadena($_POST['pasantia_fecha']);             #7
        #estado #8

        // Verificando que los campos importantes esten llenos
        if ($cota == "" || $titulo == "" || $autor == "" || $fecha == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando cota
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

        // Verificando autor
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del autor tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando tutor
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del tutor tienen caracteres no validos, solo letras de la A a la Z.",
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
                "texto" => "La institucion de la pasantia tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha
        if ($this->verificarDatos("[0-9 -]{7,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha de la pasantia no es valida, coloque una fecha adecuada (año-mes-día)",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($tutor == "") $tutor = "Desconocido";
        if ($institucion == "") $institucion = "Desconocida";

        // Preparando los datos para registrar en la base de datos
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

        // Haciendo el registro
        $registrar_pasantia = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_pasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Pasantia registrada",
                "texto" => "La pasantia se ha registrado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar la pasantia, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador para listar las pasantias
    public function listarPasantiasControlador()
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
                    <td>' . $rows['institucion'] . '</td>
                    <td>' . $this->fechasEspanol($rows['fecha_presentacion']) . '</td>';

                    if ($rows['estado'] == "Disponible") {
                        $tabla_html .= '<td>
                        <span class="badge registro-activo">' . $rows['estado'] . '</span></td>
                    <td>
                        <button class="btn_actions_table btn_editar" onclick="btnEditarPasantia('.$rows['id'].')"><span>Editar</span><i class="fa-solid fa-file-pen"></i></button>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_pasantias" value="desabilitar">
			                <input type="hidden" name="pasantia_id" value="' . $rows['id'] . '">

			                <button type="submit" class="btn_actions_table btn_eliminar"><span>Deshabilitar</span><i class="fa-regular fa-circle-xmark"></i></button>
			            </form>
                    </td>
                </tr>';
                    } else {
                        $tabla_html .= '<td><span class="badge registro-inactivo">' . $rows['estado'] . '</span></td>
                    <td colspan="2">
                        <form class="FormularioAjax" action="' . APP_URL . 'Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off" >

			                <input type="hidden" name="modulo_pasantias" value="habilitar">
			                <input type="hidden" name="pasantia_id" value="' . $rows['id'] . '">

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

    // Controlador para modificar una pasantia
    public function actualizarPasantiasControlador()
    {
        // Verificando la existencia de la pasantia
        $id = $this->limpiarCadena($_POST['pasantia_id']);

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

        // Recibiendo los parametros del formulario
        #id 1
        $cota = $this->limpiarCadena($_POST['pasantia_cota_modificar']);             #2
        $titulo = $this->limpiarCadena($_POST['pasantia_titulo']);           #3
        $autor = $this->limpiarCadena($_POST['pasantia_autor']);             #4
        $tutor = $this->limpiarCadena($_POST['pasantia_tutor']);             #5
        $institucion = $this->limpiarCadena($_POST['pasantia_institucion']); #6
        $fecha = $this->limpiarCadena($_POST['pasantia_fecha']);             #7
        #estado 8

        // Verificando que los campos importantes esten llenos
        if ($cota == "" || $titulo == "" || $autor == "" || $fecha == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando cota
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

        // Verificar que la cota no se repite en la base de datos
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

        // // Verificando autor
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $autor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del autor tienen caracteres no validos, solo letras de la A a la Z.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // // Verificando tutor
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}", $tutor)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El nombre del autor tienen caracteres no validos, solo letras de la A a la Z.",
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
                "texto" => "La institucion del libro tiene caracteres no validos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Veridficando fecha
        if ($this->verificarDatos("[0-9 -]{7,10}", $fecha)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "La fecha de la pasantia no es valida, coloque una fecha adecuada (año-mes-día)",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Asignando valores Predeterminados
        if ($tutor == "") $tutor = "Desconocido";
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

        $condicion = [
            "condicion_campo" => "id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos($this->tablaSQL, $usuario_datos_act, $condicion)) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Pasantia modificada",
                "texto" => "La pasantia se ha modificado correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo modificar la pasantia, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador desactivar pasantia
    public function desabilitarPasantiaControlador()
    {
        $id = $this->limpiarCadena($_POST['pasantia_id']);

        # Verificando libro
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

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "No disponible","id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Pasantia desabilitada",
                "texto" => "La pasantia ya no se encuentra disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La pasantia sigue estando disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    // Controlador activar pasantia
    public function habilitarPasantiaControlador()
    {
        $id = $this->limpiarCadena($_POST['pasantia_id']);

        # Verificando libro
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

        $reactivarPasantia = $this->cambiarEstadoRegistro($this->tablaSQL, "estado", "Disponible","id", $id);

        if ($reactivarPasantia->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Pasantia Habilitada",
                "texto" => "La pasantia esta disponible en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La pasantia sigue estando no disponible, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}