<section class="cuerpo">
    <div class="contenedor">
        <h2>Biblioteca Luis B. Prieto F.</h2>
        <p>     Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione unde nihil explicabo blanditiis doloribus debitis, velit ea nisi fugiat. Quos, nemo provident. Architecto, tempore libero sapiente suscipit reiciendis eveniet neque.</p>
    </div>

    <div class="contenedorimg">
        <!-- <img src="<?php echo APP_URL ?>Imagenes/fotoLb.jpeg" alt=""> -->
        <div class="decoration"></div>
    </div>

</section>

<!--Cartas de texto-->
<section class="contenedor-cartas">
    <div>
        <h2>Vida y pensamientos de Luis Beltran</h2>
    </div>

    <div class="cartas">
        <article class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb1.png" class="carta-img" alt="luisBeltran1">
            <div class="contenido-carta">
                <h1 class="titulo-carta">La Infancia y la Adolescencia</h1>
                <p class="parrafo-carta">
                    "El hombre no se forja a golpes de martillo sus aristas se pulen como las del diamante en el polvo que dejan sus facetas, por eso esplende solo".
                </p>
            </div>
        </article>
        <article class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb2.jpeg" class="carta-img" alt="luisBeltran2">
            <div class="contenido-carta">
                <h1 class="titulo-carta">Haciendo caminos: Estudiante-Maestro-Doctor</h1>
                <p class="parrafo-carta">
                    "La universidad es un laboratorio donde se procesan todas las investigaciones que requiere el desarrollo cultural y social, político y economico de Venezuela".
                </p>
            </div>
        </article>
        <article class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb3.jpeg" class="carta-img" alt="luisBeltran3">
            <div class="contenido-carta">
                <h1 class="titulo-carta">Prieto un Líder Político Nacional</h1>
                <p class="parrafo-carta">
                    "Fue uno de los políticos con mayor participación en la definición del futuro de Venezuela".
                </p>
            </div>
        </article>
        <div class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb4.jpeg" class="carta-img" alt="luisBeltran4">
            <div class="contenido-carta">
                <h1 class="titulo-carta">Prieto en el exilio: Una Proyección Continental</h1>
                <p class="parrafo-carta">
                    "Las bibliotecas deben ser organismos vivientes al servicio de la cultura, no museos donde todo permanece estático, si no más bien hervidero de ideas".
                </p>
            </div>
        </div>
        <div class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb5.jpeg" class="carta-img" alt="luisBeltran5">
            <div class="contenido-carta">
                <h1 class="titulo-carta">Vuelta a la lucha Política</h1>
                <p class="parrafo-carta">
                    "Retorno a la patria, otro renacer de la esperanza. Cada ínstante he vivido realizando y cumpliendo una tarea".
                </p>
            </div>
        </div>
        <div class="carta">
            <img src="<?php echo APP_URL ?>Imagenes/lb6.jpeg" class="carta-img" alt="luisBeltran6">
            <div class="contenido-carta">
                <h1 class="titulo-carta">Y le tocó el turno a la Poesía</h1>
                <p class="parrafo-carta">
                    A Luis Beltrán Prieto le florecieron de poesía las manos y la mente:<br><br>El hombre aprende camino de eficacia ensayando y errando.
                </p>
            </div>
        </div>
    </div>


</section>

<!-- Carrusel de Imagenes-->
<section class="contenedor-galeria">
    <div>
        <h2>Galeria</h2>
    </div>
    <article class="slider">
        <div class="slide">
            <input type="radio" name="radio-btn" id="radio1">
            <input type="radio" name="radio-btn" id="radio2">
            <input type="radio" name="radio-btn" id="radio3">
            <input type="radio" name="radio-btn" id="radio4">
            <input type="radio" name="radio-btn" id="radio5">

            <div class="st frist">
                <img src="<?php echo APP_URL ?>Imagenes/b1.jpeg" alt="">
            </div>
            <div class="st">
                <img src="<?php echo APP_URL ?>Imagenes/b2.jpeg" alt="">
            </div>
            <div class="st">
                <img src="<?php echo APP_URL ?>Imagenes/b3.jpeg" alt="">
            </div>
            <div class="st">
                <img src="<?php echo APP_URL ?>Imagenes/b4.jpeg" alt="">
            </div>
            <div class="st">
                <img src="<?php echo APP_URL ?>Imagenes/b5.jpeg" alt="">
            </div>

            <div class="nav-auto">
                <div class="a-bt1"></div>
                <div class="a-bt2"></div>
                <div class="a-bt3"></div>
                <div class="a-bt4"></div>
                <div class="a-bt5"></div>
            </div>
        </div>

        <div class="nav-m">
            <label for="radio1" class="m-btn"></label>
            <label for="radio2" class="m-btn"></label>
            <label for="radio3" class="m-btn"></label>
            <label for="radio4" class="m-btn"></label>
            <label for="radio5" class="m-btn"></label>
        </div>
    </article>
</section>

<script type="text/javascript">
    var counter = 1;
    setInterval(function() {
        document.getElementById('radio' + counter).checked = true;
        counter++;
        if (counter > 5) {
            counter = 1;
        }
    }, 8000);
</script>