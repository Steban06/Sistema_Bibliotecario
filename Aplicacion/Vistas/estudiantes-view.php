<?php
use Aplicacion\models\mainModel;
$consulta = new mainModel();
?>

<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Listado de Estudiantes</h2>
    </div>

    <div class="contenedor-botones">

        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-user-plus"></i><span>Registrar estudiante</span></button>
        </div>
        
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel" value="funciona"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDF-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarex-view.php');
        });
    </script>

    <div class="scroll">
        <table id="tabla" class="tablaprueba">

            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php

                use Aplicacion\controllers\estudiantesController;

                $insEstuiante = new estudiantesController();
                echo $insEstuiante->listarEstudiantesControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">REGISTRAR</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hidden" type="hidden" name="modulo_estudiantes" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cédula<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="estudiante_cedula" minlength="6" maxlength="9" onkeydown="return soloNumeros(event)" placeholder="Ingrese cedula del estudiante" required>
            </div>
            <div class="input">
                <label>Nombres<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="estudiante_nombres" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese nombres del estudiante" required>
            </div>
            <div class="input">
                <label>Apellidos<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="estudiante_apellidos" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese apellidos del estudiante" required>
            </div>
            <div class="input">
                <label>Teléfono</label>
                <input type="text" name="estudiante_telefono" minlength="11" maxlength="11" onkeydown="return soloNumeros(event)" placeholder="Ingrese numero telefono">
            </div>
            <div class="input">
                <label>Dirección</label>
                <input type="text" name="estudiante_direccion" maxlength="50" placeholder="Ingrese direccion">
            </div>
            <div class="input">
                <label>Correo electronico<span class="asterisco_onbligatorio"> *</span></label>
                <input type="email" name="estudiante_email" maxlength="50" placeholder="Ingrese correo electronico" required>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Carrera<span class="asterisco_onbligatorio"> *</span></label>
                    <select name="estudiante_carrera" id="carera-estuiante" class="select">
                        <option value="...">...</option>

                        <!-- ACOMODAR ESTO EN LA CLASE mainModel -->
                        <?php
                        $carreras = $consulta->seleccionarDatos("Normal", "carreras", '*', "");
                        $listaCarreras = $carreras->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listaCarreras as $carrera) {
                            // $codigoCarrera = $carrera['codigo'];
                            $nombreCarrera = $carrera['descripcion'];
                            echo "<option value='".$carrera['codigo']."'>$nombreCarrera</option>";
                        }
                        ?>

                    </select>
                </div>
                <div class="input">
                    <label>Semestre<span class="asterisco_onbligatorio"> *</span></label>
                    <select name="estudiante_semestre" id="carera-estuiante" class="select">
                        <option value="...">...</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                    </select>
                </div>
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Registrar</button>
                <button type="reset" class="cerrar" id="cerrar-modal" onclick="cerrarModalRegistrar()">Regresar</button>
            </p>

        </form>

    </div>
</article>

<article id="modalActualizar" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2>Modificar Estudiante</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST">

            <input id="modulo-hiddenA" type="hidden" name="modulo_estudiantes" value="actualizar">
            <input id="input_oculto_cedula" type="hidden" name="estudiante_cedula_modificar" value="">

            <div class="input">
                <label>Cédula</label>
                <input id="modificar-cedula" type="text" name="estudiante_cedula" minlength="6" maxlength="9" placeholder="Ingrese cedula" disabled>
            </div>
            <div class="input">
                <label>Nombres<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar-nombres" type="text" name="estudiante_nombres" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese nombres" value="" required>
            </div>
            <div class="input">
                <label>Apellidos<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar-apellidos" type="text" name="estudiante_apellidos" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese apellidos" required>
            </div>
            <div class="input">
                <label>Teléfono</label>
                <input id="modificar-telefono" type="text" name="estudiante_telefono" minlength="11" maxlength="11" onkeydown="return soloNumeros(event)" placeholder="Ingrese numero telefono" required>
            </div>
            <div class="input">
                <label>Dirección</label>
                <input id="modificar-direccion" type="text" name="estudiante_direccion" placeholder="Ingrese direccion">
            </div>
            <div class="input">
                <label>Correo electronico<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar-email" type="email" name="estudiante_email" maxlength="50" placeholder="Ingrese correo electronico" required>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Carrera<span class="asterisco_onbligatorio"> *</span></label>
                    <select name="estudiante_carrera" id="modificar-carrera" class="select">
                        <option value="...">...</option>

                        <?php
                        $carreras = $consulta->seleccionarDatos("Normal", "carreras", '*', "");
                        $listaCarreras = $carreras->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listaCarreras as $carrera) {
                            $codigoCarrera = $carrera['codigo'];
                            $nombreCarrera = $carrera['descripcion'];
                            echo "<option value='$codigoCarrera'> $nombreCarrera</option>";
                        }
                        ?>

                    </select>
                </div>
                <div class="input">
                    <label>Semestre<span class="asterisco_onbligatorio"> *</span></label>
                    <select name="estudiante_semestre" id="modificar-semestre" class="select">
                        <option value="...">...</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                    </select>
                </div>
                
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Registrar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>

        </form>
    </div>
</article>