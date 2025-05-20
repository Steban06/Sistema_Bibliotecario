<section class="contenedor_perfil">
    <article class="tituloWelcome">
        <h2>
            <i class="fa-regular fa-circle-user"></i>
            <br>
            <span>¡Bienvenido <?php echo $_SESSION['nombres']?>!</span>
        </h2>
    </article>

    <article class="contenedor_fila">
        <div class="fila">
            <div class="inf_datos">
                <label class="label">Código:</label>
                <br>
                <label><?php echo $_SESSION['id']?></label>
            </div> 
            <div class="inf_datos">
                <label class="label">Nombres:</label>
                <br>
                <label><?php echo $_SESSION['nombres']?></label>
            </div> 
            <div class="inf_datos">
                <label class="label">Apellidos:</label>
                <br>
                <label><?php echo $_SESSION['apellidos']?></label>
            </div>
            <div class="inf_datos">
                <label class="label">Cédula:</label>
                <br>
                <label><?php echo $_SESSION['cedula']?></label>
            </div>
            <div class="inf_datos">
                <label class="label">Cargo:</label>
                <br>
                <label><?php echo $_SESSION['cargo']?></label>
            </div>
        </div>
        
    </article>

</section>

<section class="contenedor_perfil">
    <div class="distribucion_botones">
        <button class="boton_tabla btn_nuevo" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-person-circle-plus"></i>Registrar nuevo usuario</button>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">Registrar datos del nuevo bibliotecario</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off">

            <input id="modulo-hidden" type="hidden" name="modulo_bibliotecario" value="registrar">

            <div class="input">
                <label>Cédula bibliotecario<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="cedula_bibliotecario" minlength="6" maxlength="9" onkeydown="return soloNumeros(event)" placeholder="Ingrese cédula del Bibliotecario" required>
            </div>
            <div class="input">
                <label>Nombres bibliotecario<span class="asterisco_onbligatorio"> *</span></label> 
                <input type="text" name="nombre_bibliotecario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" placeholder="Ingrese nombres del Bibliotecario" required>
            </div>
            <div class="input">
                <label>Apellidos bibliotecario<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="apellido_bibliotecario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" placeholder="Ingrese apellidos del Bibliotecario" required>
            </div>
            <div class="input">
                <label>Cargo bibliotecario<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="cargo_bibliotecario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,20}" maxlength="20" placeholder="Ingrese el cargo del Bibliotecario" required>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Usuario bibliotecario<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="text" name="user_bibliotecario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30" placeholder="Usuario del Bibliotecario" required>
                </div>
                <div class="input">
                    <label>Clave bibliotecario<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="password" name="pass_bibliotecario" pattern="[a-zA-Z0-9$@.-]{4,20}" maxlength="20" placeholder="Clave del Bibliotecario" required>
                </div>
            </div>

            <p class="separe">Para completar el ingreso del nuevo bibliotecario se necesita su Usuario y Clave para confirmar</p>

            <div class="columna">
                <div class="input">
                    <label>Usuario<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="text" name="user_usuario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30" placeholder="Usuario" required>
                </div>
                <div class="input">
                    <label>Clave<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="password" name="pass_usuario" pattern="[a-zA-Z0-9$@.-]{4,20}" maxlength="20" placeholder="Clave" required>
                </div>
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Registrar</button>
                <button type="reset" class="cerrar" id="cerrar-modal" onclick="cerrarModalRegistrar()">Regresar</button>
            </p>
        </form>
    </div>
</article>