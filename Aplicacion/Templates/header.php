<header class="cabezera">
    <section class="fondo">
        <div class="logos">
            <img src="<?php echo APP_URL?>Imagenes/FANB.png" alt="LogoUNEFA">
        </div>

        <div class="texto">
            <h1>Sistema bibliotecario</h1>
            <p>Sistema de gestión de libros y documentos de la Biblioteca
                Luis Beltrán UNEFA Estado Nueva Esparta</p>
        </div>

        <div class="logos">
            <img src="<?php echo APP_URL?>Imagenes/fondo.png" alt="LogoMPPD">
        </div>
    </section>
</header>

<nav class="menu">
    <a href="<?php echo APP_URL?>inicio/" class="logo">Sistema Bibliotecario</a>

    <ul class="menu-horizontal">
        <li>
            <a>Personas</a>
            <ul class="opciones-verticales">
                <li><a class="barra" href="<?php echo APP_URL?>estudiantes/">Estudiantes</a></li>
                <li><a href="<?php echo APP_URL?>docentes/">Docentes</a></li>
            </ul>
        </li>
        <li><a href="<?php echo APP_URL?>libros/">Libros</a></li>
        <li>
            <a>Documentos</a>
            <ul class="opciones-verticales">
                <li><a href="<?php echo APP_URL?>tInvestigacion/">Trabajos de investigación</a></li>
                <li><a href="<?php echo APP_URL?>pasantias/">Pasantías</a></li>
                <li><a href="<?php echo APP_URL?>servicioComunitario/">Servicios comunitarios</a></li>
            </ul>
        </li>
        <li><a href="<?php echo APP_URL?>prestamos/">Prestamos</a></li>
        <li>
            <a><i class="fa-solid fa-user-tie"></i><?php echo $_SESSION['nombres']?></a>
            <ul class="opciones-verticales">
                <li><a href="<?php echo APP_URL."perfilUsuario/".$_SESSION['id']."/"?>">Mi perfil</a></li>
                <li><a id="btn-exit" href="<?php echo APP_URL?>cerrarSesion/">Cerrar sesión</a></li>
                <!-- <li><a href="<?php echo APP_URL?>servicioComunitario/">Servicios comunitarios</a></li> -->
            </ul>
        </li>
    </ul>
</nav>