<?php
namespace Aplicacion\controllers;

use Aplicacion\models\mainModel;
use PDO;

class bibliotecarioController extends mainModel
{

    protected string $tablaSQL = "usuarios";
    
    public function registrarBibliotecarioControlador()
    {
        $cedula = $this->limpiarCadena($_POST['cedula_bibliotecario']);       #1
        $nombres = $this->limpiarCadena($_POST['nombre_bibliotecario']);      #2
        $apellidos = $this->limpiarCadena($_POST['apellido_bibliotecario']);  #3
        $cargo = $this->limpiarCadena($_POST['cargo_bibliotecario']);         #4
        $usuario = $this->limpiarCadena($_POST['user_bibliotecario']);        #5
        $contrasenia = $this->limpiarCadena($_POST['pass_bibliotecario']);    #6

        $user = $this->limpiarCadena($_POST['user_usuario']);
        $pass = $this->limpiarCadena($_POST['pass_usuario']);

        // Verificando campos obligatorios
        if ($cedula == "" || $nombres == "" || $apellidos == "" || $cargo == "" || $usuario == "" || $contrasenia == "" || $user == "" || $pass == "") {
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

        $check_cedula = $this->ejecutarConsulta("SELECT cedula FROM $this->tablaSQL WHERE cedula='$cedula'");
        if ($check_cedula->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Ya existe un Bibliotecario con esa cedula en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        
        // Verificando integridad de los nombres
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,40}", $nombres)) {
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
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidos)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El apellido tienen caracteres invalidos ",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de los apellidos
        if ($this->verificarDatos("[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,20}", $cargo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El cargo tiene caracteres invalidos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando la integridad del usuario
        if ($this->verificarDatos("[a-zA-Z0-9]{4,30}", $usuario)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El usuario del bibliotecario tiene caracteres invalidos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        // Verificando que no haya otro usuario igual
        $check_usuario = $this->ejecutarConsulta("SELECT user FROM usuarios WHERE user = '$usuario'");
        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Ya existe un Bibliotecario con ese usuario, intente con otro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificando integridad de la clave
        if ($this->verificarDatos("[a-zA-Z0-9$@.-]{4,20}", $contrasenia)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Esta contraseña no tiene caracteres invalidos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($user != $_SESSION['user']) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Este usuario invalido, no pertecene al que esta activo en esa sesion",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            if ($pass != $_SESSION['password']) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrio un error inesperado",
                    "texto" => "Esta clave es invalida, no pertecene al usuario que esta activo en esa sesion",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

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
                "campo_nombre" => "cargo",
                "campo_marcador" => ":Car",
                "campo_valor" => $cargo
            ],
            [
                "campo_nombre" => "user",
                "campo_marcador" => ":Use",
                "campo_valor" => $usuario
            ],
            [
                "campo_nombre" => "password",
                "campo_marcador" => ":Pas",
                "campo_valor" => $contrasenia
            ]
        ];

        $registrar_usuario = $this->guardarDatos($this->tablaSQL, $usuario_datos_reg);

        if ($registrar_usuario->rowCount() == 1) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Bibliotecario registrado",
                "texto" => "El Bibliotecario se ha registrado correctamente en el sistema",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se puedo registrar al Bibliotecario, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}