<div class="contenedorLogin">


    <div class="backgroundLogin">


    </div>

    <div class="containerLogin">
        <div class="contentLogin">
            <div class="text-sci">
                <h2 class="h2Login">Sistema de Gestión de libros y documentos </h2>
                <h2 class="h2Login">Biblioteca Luis Beltran</h2>
                <h2 class="h2Login"> UNEFA Estado Nueva Esparta</h2>
            </div>
        </div>

        <div class="logreg-box">
            <div class="form-box login">
                <form class="formLogin" action="#" method="post" autocomplete="off">
                    <h2 class="h2Login">Iniciar Sesión</h2>

                    <div class="input-box">
                        <span class="icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input class="inputLogin" type="user" name="login_usuario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30" required>
                        <label class="desc">Usuario</label>
                    </div>

                    <div class="input-box">
                        <span class="icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input class="inputLogin" type="password" name="login_contrasenia" pattern="[a-zA-Z0-9$@.-]{4,20}" maxlength="20" required>
                        <label class="desc">Contraseña</label>
                    </div>

                    <button type="submit" class="btn">Ingresar</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['login_usuario']) && $_POST['login_contrasenia']) {
    $insLogin->iniciarSesionControlador();
}
?>