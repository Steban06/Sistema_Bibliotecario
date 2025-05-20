<?php
use Aplicacion\models\mainModel;
$consulta = new mainModel();
?>
<section class="contenedor-tabla">
    <div class="subtitulo">
        <h2>Apartado de Préstamos</h2>
    </div>

    <div class="contenedor-botones">
        <div class="grupo-botones">
            <button id="btn-modal" class="boton_tabla btn_registrar" onclick="mostrarModalRegistrar()"><i class="fa-solid fa-plus"></i>Iniciar prestamo</button>
        </div>
        <div class="grupo-botones">
            <button id="generar-pdf" class="boton_tabla btn_pdf" value="funciona"><i class="fa-solid fa-file-pdf"></i>Generar PDF</button>
            <button id="generar-excel" class="boton_tabla btn_exel"><i class="fa-solid fa-file-excel"></i>Generar Excel</button>
        </div>
    </div>

    <script>
        document.getElementById('generar-pdf').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/pdfs/generarPDFP-view.php');
        });

        document.getElementById('generar-excel').addEventListener('click', function() {
            window.open('http://localhost/SistemaBibliotecario/Aplicacion/Vistas/excels/generarexpr-view.php');
        });
    </script>

    <div class="scroll">
        <table id="tabla" class="tablaprueba">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cedula persona</th>
                    <th>Cota documento</th>
                    <th>Fecha prestamo</th>
                    <th>Fecha devolucion</th>
                    <th>registro</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="contenido_tabla">
                <?php
                use Aplicacion\controllers\prestamosController;

                $insPrestamo = new prestamosController();
                echo $insPrestamo->listarPrestamosControlador();
                ?>
            </tbody>
        </table>
    </div>
</section>

<article id="modal" class="contenedor-modal">
    <div class="modal">
        <div class="titulo-form">
            <h2 id="title">REGISTRAR PRESTAMO</h2>
        </div>

        <form class="FormularioAjax" action="http://localhost/SistemaBibliotecario/Aplicacion/Ajax/controllerAjax.php" method="POST" autocomplete="off">

            <input id="modulo-hidden" type="hidden" name="modulo_prestamos" value="registrar">

            <div class="input">
                <label>Cédula de la persona</label>
                <input type="number" id="prestamo_cedula_persona" name="prestamo_cedula" pattern="[0-9]{4,9}" minlength="6" maxlength="9" placeholder="Ingrese la cedula del solicitante" required>
                <ul id="lista_cedulas" class="listado_cedulas"></ul>
            </div>
            <div class="input">
                <label>Cota del documento</label>
                <input type="text" id="prestamo_cota" name="prestamo_cota" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9]{3,15}" maxlength="15" placeholder="Ingrese la cota del documento solicitado" required>
                <ul id="lista_cotas" class="listado_cotas"></ul>
            </div>
            <div class="input">
                <label>Fecha de entrega</label>
                <input type="date" name="prestamo_fecha_entrega" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ ]{3,50}" minlength="3" maxlength="50" placeholder="Ingrese area del libro" required>
            </div>

            <p class="botones">
                <button type="submit" class="registrar" id="registrarCerrar">Registrar</button>
                <button type="reset" class="cerrar" id="cerrar-modal" onclick="cerrarModalRegistrar()">Regresar</button>
            </p>
        </form>
    </div>
</article>

<article id="modalVermas" class="contenedor-modal">
    <div class="modal-vermas">
        <div class="titulo-form">
            <h2 id="title">Información sobre el prestamo</h2>
        </div>

            <article class="contenedor_columnas_modal">
                <div class="columna_modal">
                    <h3>Solicitante del prestamo</h3>
                    <h4>Cédula:</h4>
                    <h5 id="cedula_persona"></h5>
                    <h4>Nombres:</h4>
                    <h5 id="nombres_persona"></h5>
                    <h4>Apellidos:</h4>
                    <h5 id="apellido_persona"></h5>
                    <h4>Cargo del solicitante:</h4>
                    <h5 id="tipo_persona"></h5>
                    <h4>Estado persona:</h4>
                    <h5><span id="Estado_persona"></span></h5>
                </div>

                <div class="columna_modal">
                    <h3>Documento del prestamo</h3>
                    <h4>Cota:</h4>
                    <h5 id="cota_documento">    </h5>
                    <h4>Titulo:</h4>
                    <h5 id="titulo_documento"></h5>
                    <h4>Autor(es):</h4>
                    <h5 id="autor_documento"></h5>
                    <h4>Tipo de documento:</h4>
                    <h5 id="tipo_documento"></h5>
                    <h4>Estado del Documento:</h4>
                    <h5><span id="estado_documento"></span></h5>
                </div>

                <div class="columna_modal">
                    <h3>Detalles sobre el prestamo</h3>
                    <h4>Codigo de prestamo:</h4>
                    <h5 id="id_prestamo"></h5>
                    <h4>Fecha de salida:</h4>
                    <h5 id="fechasalida_prestamo"></h5>
                    <h4>Fecha de devolución:</h4>
                    <h5 id="fechadevolucion_prestamo"></h5>
                    <h4>Estado del prestamo:</h4>
                    <h5><span id="estado_prestamo"></span></h5>
                </div>
            </article>

        <p class="botones">
            <!-- <button type="submit" class="registrar" id="registrarCerrar">Registrar</button> -->
            <button type="reset" class="cerrar" id="cerrar-modal" onclick="cerrarModalVermas()">Regresar</button>
        </p>
    </div>
</article>