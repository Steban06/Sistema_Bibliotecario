<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Informes de Servicios Comunitarios</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-file-circle-plus"></i>Registrar informe</button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFSC-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexsc-view.php');
        });
    </script>

    <div class="scroll">
        <table id="tabla" class="tablaprueba">
            <thead>
                <tr>
                    <th>ID</th>                   <!--1-->
                    <th>Cota</th>                 <!--2-->
                    <th>Título</th>               <!--3-->
                    <th>Autores</th>              <!--4-->
                    <th>Tutor Académico</th>      <!--5-->
                    <th>Tutor Comunitario</th>    <!--6-->
                    <th>Institución</th>          <!--7-->
                    <th>Fecha Presentación</th>   <!--8-->
                    <!-- <th>ejemplares_dis</th>       8 -->
                    <th>Estado</th>               <!--9-->
                    <th colspan="2">Acciones</th> <!--10 y 11-->
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\servicioComunitarioController;

                $insSerComu = new servicioComunitarioController();
                echo $insSerComu->listarServiciosControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">REGISTRAR SERVICIO</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hidden" type="hidden" name="modulo_sercomu" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cota<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="sercomu_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la cota del Servicio" required>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="sercomu_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el titulo del Servicio" required>
            </div>
        
            <div class="input big">
                <label>Autores<span class="asterisco_onbligatorio"> *</span></label>
                <!-- <input type="text" name="sercomu_autores" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,200}" maxlength="200" placeholder="Ingrese el autor de la pasantia" required> -->
                <textarea name="sercomu_autores" id="" placeholder="Ingrese los autores de del Servicio Comunitario"></textarea>
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input type="text" name="sercomu_tutor_academico" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del tutor Académico" required>
            </div>
            <div class="input">
                <label>Tutor Comunitario</label>
                <input type="text" name="sercomu_tutor_comunitario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del tutor Comunitario" required>
            </div>
            <div class="input">
                <label>Institución</label>
                <input type="text" name="sercomu_institucion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese Institución del Servicio">
            </div>
            <div class="input">
                <label>Fecha de Presentación<span class="asterisco_onbligatorio"> *</span></label>
                <input type="month" name="sercomu_fecha">
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
            <h2 id="title">Modificar Servicio</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST">

            <input id="modulo-hidden" type="hidden" name="modulo_sercomu" value="actualizar">
            <input id="input_oculto_cota" type="hidden" name="pasantia_cota_modificar" value="">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <input id="modificar_id" type="hidden" name="sercomu_id" value="">
            <div class="input">
                <label>Cota</label>
                <input id="modificar_cota" type="text" name="sercomu_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la cota del Servicio" disabled>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_titulo" type="text" name="sercomu_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el titulo del Servicio" required>
            </div>
            <div class="input big">
                <label>Autores<span class="asterisco_onbligatorio"> *</span></label>
                <textarea id="modificar_autores" name="sercomu_autores" placeholder="Ingrese los Autores de del servicio" required></textarea>
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input id="modificar_tutor_academico" type="text" name="sercomu_tutor_academico" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del Tutor Académico" required>
            </div>
            <div class="input">
                <label>Tutor Comunitario</label>
                <input id="modificar_tutor_comunitario" type="text" name="sercomu_tutor_comunitario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del Tutor Comunitario" required>
            </div>
            <div class="input">
                <label>Institución</label>
                <input id="modificar_institucion" type="text" name="sercomu_institucion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese Institución del Servicio">
            </div>
            <div class="input">
                <label>Fecha de Presentación<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_fecha" type="month" name="sercomu_fecha">
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Modificar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>
        </form>
    </div>
</article>