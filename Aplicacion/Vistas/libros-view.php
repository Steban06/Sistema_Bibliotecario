<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Listado de Libros</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-file-circle-plus"></i><span>Registrar nuevo libro</span></button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFL-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexl-view.php');
        });
    </script>

    <div class="scroll">
        <table id="tabla" class="tablaprueba">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cota</th>
                    <th>Titulo</th>
                    <th>Autor/es</th>
                    <th>Area</th>
                    <th>Editorial</th>
                    <th>Edición</th>
                    <th>Tomo</th>
                    <th>Ejemplares totales</th>
                    <th>Ejemplares disponibles</th>
                    <th>Fecha libro</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\librosController;

                $inslibro = new librosController();
                echo $inslibro->listarLibrosControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">REGISTRAR LIBRO</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" enctype="multipart/form-data">

            <input id="modulo-hidden" type="hidden" name="modulo_libros" value="registrar">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <div class="input">
                <label>Cota<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="libro_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="15" placeholder="Ingrese la cota del libro" required>
            </div>
            <div class="input">
                <label>Titulo<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="libro_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" placeholder="Ingrese el titulo del libro" required>
            </div>
            <div class="input">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="libro_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el autor del libro" required>
            </div>
            <div class="input">
                <label>Area<span class="asterisco_onbligatorio"> *</span></label>
                <input type="text" name="libro_area" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese area del libro" required>
            </div>
            <div class="input">
                <label>Editorial</label>
                <input type="text" name="libro_editorial" placeholder="Ingrese editorial del libro">
            </div>
            <div class="columna">
                <div class="input">
                    <label>Edicion</label>
                    <input type="text" name="libro_edicion" >
                </div>
                <div class="input">
                    <label>Tomo</label>
                    <input type="text" name="libro_tomo">
                </div>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Cantidad Ejemplares<span class="asterisco_onbligatorio">*</span></label>
                    <input type="text" name="libro_ejemplares" maxlength="3" placeholder="Número de ejemplares totales" required>
                </div>
                <div class="input">
                    <label>Fecha<span class="asterisco_onbligatorio"> *</span></label>
                    <input type="date" name="libro_fecha">
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
            <h2 id="title">ACTUALIZAR LIBRO</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST">

            <input id="modulo-hidden" type="hidden" name="modulo_libros" value="actualizar">
            <input id="input_oculto_cota" type="hidden" name="libro_cota_modificar" value="">

            <p class="incicacion">Los campos con "<span class="asterisco_onbligatorio">*</span>" son obligatorios.</p>

            <input id="modificar_id" type="hidden" name="libro_id" value="">
            <div class="input">
                <label>Cota</label>
                <input id="modificar_cota" type="text" name="libro_cota" pattern="[a-zA-zñÑ0-9]{4,15}" minlength="4" maxlength="10" placeholder="Ingrese la cota del libro" disabled>
            </div>
            <div class="input">
                <label>Titulo<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_titulo" type="text" name="libro_titulo" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" placeholder="Ingrese el titulo del libro" required>
            </div>
            <div class="input">
                <label>Autor<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_autor" type="text" name="libro_autor" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" placeholder="Ingrese el autor del libro" required>
            </div>
            <div class="input">
                <label>Area<span class="asterisco_onbligatorio"> *</span></label>
                <input id="modificar_area" type="text" name="libro_area" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese area del libro" required>
            </div>
            <div class="input">
                <label>Editorial</label>
                <input id="modificar_editorial" type="text" name="libro_editorial" placeholder="Ingrese editorial del libro">
            </div>
            <div class="columna">
                <div class="input">
                    <label>Edición</label>
                    <input id="modificar_edicion" type="text" name="libro_edicion" >
                </div>
                <div class="input">
                    <label>Tomo</label>
                    <input id="modificar_tomo" type="text" name="libro_tomo">
                </div>
            </div>
            <div class="columna">
                <div class="input">
                    <label>Cantidad Ejemplares<span class="asterisco_onbligatorio"> *</span></label>
                    <input id="modificar_ejemplares" type="text" name="libro_ejemplares">
                </div>
                <div class="input">
                    <label>Fecha<span class="asterisco_onbligatorio"> *</span></label>
                    <input id="modificar_fecha" type="date" name="libro_fecha">
                </div>
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Modificar</button>
                <button type="reset" class="cerrar" id="cerrar-modalA" onclick="cerrarModalActualizar()">Regresar</button>
            </p>
        </form>
    </div>
</article>