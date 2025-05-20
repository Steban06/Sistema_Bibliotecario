<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Informes de Pasantías</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-file-circle-plus"></i>Registrar pasantía</button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFPA-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexp-view.php');
        });
    </script>

    <div class="scroll">
        <table id="tabla" class="tablaprueba">
            <thead>
                <tr>
                    <th>ID</th>                   <!--1-->
                    <th>Cota</th>                 <!--2-->
                    <th>Título</th>               <!--3-->
                    <th>Autor</th>                <!--4-->
                    <th>Tutor Académico</th>      <!--5-->
                    <th>Institución</th>          <!--6-->
                    <th>Fecha Presentación</th>   <!--7-->
                    <!-- <th>ejemplares_dis</th>       8 -->
                    <th>Estado</th>               <!--9-->
                    <th colspan="2">Acciones</th> <!--10 y 11-->
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\pasantiasController;

                $insPasantias = new pasantiasController();
                echo $insPasantias->listarPasantiasControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">Registrar Pasantía</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hidden" type="hidden" name="modulo_pasantias" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cota<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="pasantia_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la cota de pasantía" required>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="pasantia_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el Título de pasantía" required>
            </div>
            <div class="input">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="pasantia_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el Autor de la Pasantía" required>
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input type="text" name="pasantia_tutor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del tutor de la pasantia" required>
            </div>
            <div class="input">
                <label>Institución</label>
                <input type="text" name="pasantia_institucion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese Institución de la Pasantía">
            </div>
            <div class="input">
                <label>Fecha<span class="asterisco_onbligatorio"> *</span></label>
                <input type="month" name="pasantia_fecha">
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
            <h2 id="title">Modificar Pasantía</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST">

            <input id="modulo-hidden" type="hidden" name="modulo_pasantias" value="actualizar">
            <input id="input_oculto_cota" type="hidden" name="pasantia_cota_modificar" value="">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <input id="modificar_id" type="hidden" name="pasantia_id" value="">
            <div class="input">
                <label>Cota</label>
                <input id="modificar_cota" type="text" name="pasantia_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la Cota de Pasantía" required disabled>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_titulo" type="text" name="pasantia_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el Título de Pasantía" required>
            </div>
            <div class="input">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_autor" type="text" name="pasantia_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el Autor de la Pasantía" required>
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input id="modificar_tutor" type="text" name="pasantia_tutor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del Tutor de la Pasantía" required>
            </div>
            <div class="input">
                <label>Institución</label>
                <input id="modificar_institucion" type="text" name="pasantia_institucion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese Institución de la Pasantía">
            </div>
            <div class="input">
                <label>Fecha<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_fecha" type="month" name="pasantia_fecha">
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Modificar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>
        </form>
    </div>
</article>