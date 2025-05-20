<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Trabajos de Investigación</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-file-circle-plus"></i>Registrar trabajo</button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFTI-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexti-view.php');
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
                    <th>Tipo Trabajo</th>         <!--6-->
                    <th>Area</th>                 <!--7-->
                    <th>Mención</th>              <!--8-->
                    <th>Metodología</th>          <!--9-->   
                    <th>Fecha Presentación</th>   <!--10-->
                    <!-- <th>ejemplares_dis</th>        -->
                    <th>Estado</th>               <!--11-->
                    <th colspan="2">Acciones</th> <!--12 y 13-->
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\tInvestigacionController;

                $insTivestigacion = new tInvestigacionController();
                echo $insTivestigacion->listarTinvestigacionControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">Registrar Trabajo</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hidden" type="hidden" name="modulo_tinestigacion" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cota<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="tinestigacion_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la cota del Trabajo" required>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="tinestigacion_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el titulo de Trabajo" required>
            </div>
        
            <div class="input big">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="tinestigacion_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el autor del Trabajo" required>
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input type="text" name="tinestigacion_tutor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del tutor del Trabajo">
            </div>
            <div class="columna">
                <div class="input">
                    <label>Tipo trabajo<span class="asterisco_onbligatorio"> *</span></label>
                    <select name="tinestigacion_tipo" class="select" required>
                        <option value="...">...</option>
                        <option value="Pregrado">Pregrado</option>
                        <option value="Postgrado">Postgrado</option>
                    </select>
                </div>
                <div class="input">
                    <label>Area del Trabajo<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="text" name="tinestigacion_area" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese area del Trabajo">
                </div>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Mención del Trabajo</label>
                    <input type="text" name="tinestigacion_mencion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese la Mención">
                </div>
                <div class="input">
                    <label>Metodología</label>
                    <input type="text" name="tinestigacion_metodologia" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" placeholder="Ingrese Metodología">
                </div>
            </div>
            <div class="input">
                <label>Fecha de presentación<span class="asterisco_onbligatorio"> *</span></label>
                <input type="month" name="tinestigacion_fecha">
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
            <h2 id="title">Modificar Trabajo</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST">

            <input id="modulo-hidden" type="hidden" name="modulo_tinestigacion" value="actualizar">
            <input id="input_oculto_cota" type="hidden" name="trabajo_cota_modificar" value="">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <input id="modificar_id" type="hidden" name="tinestigacion_id" value="">
            <div class="input">
                <label>Cota</label>
                <input id="modificar_cota" type="text" name="tinestigacion_cota" pattern="[a-zA-zñÑ0-9]{4,10}" minlength="4" maxlength="10" placeholder="Ingrese la cota de Trabajo" disabled>
            </div>
            <div class="input">
                <label>Título<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_titulo" type="text" name="tinestigacion_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100" placeholder="Ingrese el titulo de Trabajo" required>
            </div>
            <div class="input big">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_autor" type="text" name="tinestigacion_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el autor del Trabajo" required>
                <!-- <textarea name="sercomu_autores" placeholder="Ingrese los autores de del servicio comunitario"></textarea> -->
            </div>
            <div class="input">
                <label>Tutor Académico</label>
                <input id="modificar_tutor" type="text" name="tinestigacion_tutor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese nombre del tutor del Trabajo">
            </div>
            <div class="columna">
                <div class="input">
                    <label>Tipo trabajo<span class="asterisco_onbligatorio"> *</span></label>
                    <!-- <input type="text" name="sercomu_tutor_comunitario" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese el " required> -->
                    <select id="modificar_tipo" name="tinestigacion_tipo" class="select" required>
                        <option value="...">...</option>
                        <option value="Pregrado">Pregrado</option>
                        <option value="Postgrado">Postgrado</option>
                    </select>
                </div>
                <div class="input">
                    <label>Area del Trabajo<span class="asterisco_onbligatorio"> *</span></label>
                    <input id="modificar_area" type="text" name="tinestigacion_area" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,30}" maxlength="30" placeholder="Ingrese area del Trabajo">
                </div>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Mención del Trabajo</label>
                    <input id="modificar_mencion" type="text" name="tinestigacion_mencion" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" placeholder="Ingrese la Mención">
                </div>
                <div class="input">
                    <label>Metodología</label>
                    <input id="modificar_metodologia" type="text" name="tinestigacion_metodologia" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" placeholder="Ingrese Metodología">
                </div>
            </div>
            <div class="input">
                <label>Fecha de presentación<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_fecha" type="month" name="tinestigacion_fecha">
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Modificar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>
        </form>
    </div>
</article>