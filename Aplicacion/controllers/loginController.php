<?php

namespace Aplicacion\controllers;
use Aplicacion\models\mainModel;

class loginController extends mainModel
{

    // Controlador iniciar secion
    public function iniciarSesionControlador()
    {
        // Almacenando datos del login
        $usuario = $this->limpiarCadena($_POST['login_usuario']);
        $clave = $this->limpiarCadena($_POST['login_contrasenia']);

        if ($usuario == "" || $clave == "") {
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrio un error inesperado',
                        text: 'No has llenado todos los campos que son obligatorios',
                        confirmButtonText: 'Aceptar'
                    });
                </script>
            ";
        } else {
            // Verificando la integridad de los datos
            if ($this->verificarDatos("[a-zA-Z0-9]{4,30}", $usuario)) {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error inesperado',
                            text: 'El USUARIO no coincide con el formato solicitado',
                            confirmButtonText: 'Aceptar'
                        });
                    </script>
                ";
            } else {
                if ($this->verificarDatos("[a-zA-Z0-9$@.-]{4,20}", $clave)) {
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrio un error inesperado',
                                text: 'La CLAVE no coincide con el formato solicitado',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                    ";
                } else {
                    // Verificando excistencia del usuario
                    $check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE user='$usuario'");

                    if ($check_usuario->rowCount() == 1) {

                        $check_usuario = $check_usuario->fetch();

                        if ($check_usuario['user'] == $usuario && $check_usuario['password'] == $clave) {

                            $_SESSION['id'] = $check_usuario['id'];
                            $_SESSION['cedula'] = $check_usuario['cedula'];
                            $_SESSION['nombres'] = $check_usuario['nombres'];
                            $_SESSION['apellidos'] = $check_usuario['apellidos'];
                            $_SESSION['cargo'] = $check_usuario['cargo'];
                            $_SESSION['user'] = $check_usuario['user'];
                            $_SESSION['password'] = $check_usuario['password'];

                            if (headers_sent()) {
                                echo "
                                <script>
                                window.location.href='" . APP_URL . "inicio/';
                                </script>
                                ";
                            } else {
                                header("Location: " . APP_URL . "inicio/");
                            }
                        } else {
                            echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ACCESO DENEGADO',
                                    text: 'USUARIO o CLAVE incorrectos',
                                    confirmButtonText: 'Aceptar'
                                });
                            </script>
                        ";
                        }
                    } else {
                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ACCESO DENEGADO',
                                    text: 'USUARIO o CLAVE incorrectos',
                                    confirmButtonText: 'Aceptar'
                                });
                            </script>
                        ";
                    }
                }
            }
        }
    }

    // Controlador para cerrar la secion
    public function cerrarSesionControlador()
    {
        session_destroy();

        if (headers_sent()) {
            echo "
            <script>
            window.location.href='" . APP_URL . "login/';
            </script>
            ";
        } else {
            header("Location: " . APP_URL . "login/");
        }
    }
}
