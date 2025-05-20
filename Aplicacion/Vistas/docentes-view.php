<?php
use Aplicacion\models\mainModel;
$consulta = new mainModel();
?>

<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Listado de Docentes</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-user-plus" title="HHHHH"></i></i>Registrar docente</button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel" value="funciona"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>           
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
         window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFDOC-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexdoc-view.php');
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
                    <th>Materia</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\docentesController;

                $insDocente = new docentesController();
                echo $insDocente->listarDocentesControlador();
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

            <input id="modulo-hidden" type="hidden" name="modulo_docentes" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cédula<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="docentes_cedula" minlength="6" maxlength="9" onkeydown="return soloNumeros(event)" placeholder="Ingrese la cedula" required>
            </div>
            <div class="input">
                <label>Nombres<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="docentes_nombres" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese los nombres" required>
            </div>
            <div class="input">
                <label>Apellidos<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="docentes_apellidos" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese los apellidos" required>
            </div>
            <div class="input">
                <label>Teléfono<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="docentes_telefono" minlength="11" maxlength="11" onkeydown="return soloNumeros(event)" placeholder="Ingrese el número de teléfono">
            </div>
            <div class="input">
                <label>Dirección</label>
                <input type="text" name="docentes_direccion" maxlength="50" placeholder="Ingrese la dirección">
            </div>
            <div class="input">
                <label>Correo electronico<span class="asterisco_onbligatorio"> *</span></label>
                <input type="email" name="docentes_email" maxlength="50" placeholder="Ingrese correo electronico" required>
            </div>
            <div class="input">
                <label>Materia del Docente</label>
                <input type="text" name="docentes_materia" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" minlength="3" maxlength="30" placeholder="Ingrese la materia del Docente">
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

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hiddenA" type="hidden" name="modulo_docentes" value="actualizar">
            <input id="input_oculto_cedula" type="hidden" name="docente_cedula_modificar" value="">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cédula</label>
                <input type="text" id="modificar_cedula" name="docente_cedula" minlength="6" maxlength="9" onkeydown="return soloNumeros(event)" placeholder="Ingrese la cedula" disabled>
            </div>
            <div class="input">
                <label>Nombres<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" id="modificar_nombre" name="docentes_nombres" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese los nombres" required>
            </div>
            <div class="input">
                <label>Apellidos<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" id="modificar_apellido" name="docentes_apellidos" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese los apellidos" required>
            </div>
            <div class="input">
                <label>Teléfono<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" id="modificar_telefono" name="docentes_telefono" minlength="11" maxlength="11" onkeydown="return soloNumeros(event)" placeholder="Ingrese el número teléfono" required>
            </div>
            <div class="input">
                <label>Dirección</label>
                <input type="text" id="modificar_direccion" name="docentes_direccion" maxlength="30" placeholder="Ingrese direccion">
            </div>
            <div class="input">
                <label>Correo electronico<span class="asterisco_onbligatorio"> *</span></label>
                <input type="email" id="modificar_email" name="docentes_email" maxlength="50" placeholder="Ingrese correo electronico" required>
            </div>
            <div class="input">
                <label>Materia del Docente</label>
                <input type="text" id="modificar_materia" name="docentes_materia" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" minlength="3" maxlength="30" placeholder="Ingrese la materia del Docente">
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Modificar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>

        </form>
    </div>
</article>