// URL
const url = document.querySelector("#URL").value;
// MODALS BOTONES
// const btnModal = document.querySelector("#btn-modal");
// const btnModalestudiante = document.querySelector("#btn_modal_estudiante")
// const btnModalA = document.querySelector("#modalActualizar");
// MODALS FORMULARIOS
const contModal = document.querySelector("#modal");
const contModalA = document.querySelector("#modalActualizar");
const btnCerrarModal = document.querySelector("#cerrar-modal");
const btnCerrarModalA = document.querySelector("#cerrar-modalA");
const contModalVM = document.querySelector("#modalVermas");

// Constante de prueba
const tablaa = document.querySelector("#tabla");
const inputhidden = document.getElementById("modulo-hidden");

// Funcion para autocompletado en las cotas
document.getElementById("prestamo_cota").addEventListener("keyup", getCotas)
document.getElementById("prestamo_cedula_persona").addEventListener("keyup", getCedulas)

// capturando lista que desplega las cotas
let listaCotas   = document.getElementById("lista_cotas");
// capturando lista que desplega las cedulas
let listaCedulas = document.getElementById("lista_cedulas");


// ESTO VAAAAA NO BORRAR
function mostrarModalRegistrar(){
    contModal.classList.add("active");
}

function cerrarModalRegistrar(){
    contModal.classList.remove("active");
}

function cerrarModalActualizar(){
    contModalA.classList.remove("active");
}
// 

function btnEditarEstudiante(ced) {
    let cedula = String(ced);
    const nombreTabla = "estudiantes";
    const nombreCampo = "cedula";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('cedula='+cedula+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cedula").value = res.cedula;

            document.querySelector("#modificar-cedula").value = res.cedula;
            document.querySelector("#modificar-nombres").value = res.nombres;
            document.querySelector("#modificar-apellidos").value = res.apellidos;
            document.querySelector("#modificar-telefono").value = res.telefono;
            document.querySelector("#modificar-direccion").value = res.direccion;
            document.querySelector("#modificar-email").value = res.email;
            document.querySelector("#modificar-carrera").value = res.carrera;
            document.querySelector("#modificar-semestre").value = res.semestre;
            contModalA.classList.add("active");
        }
    })
}

function btnEditarDocente(ced) {
    let cedula = String(ced);
    const nombreTabla = "docentes";
    const nombreCampo = "cedula";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('cedula='+cedula+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cedula").value = res.cedula;

            document.querySelector("#modificar_cedula").value = res.cedula;
            document.querySelector("#modificar_nombre").value = res.nombres;
            document.querySelector("#modificar_apellido").value = res.apellidos;
            document.querySelector("#modificar_telefono").value = res.telefono;
            document.querySelector("#modificar_direccion").value = res.direccion;
            document.querySelector("#modificar_email").value = res.email;
            document.querySelector("#modificar_materia").value = res.materia;
            contModalA.classList.add("active");
        }
    })
}

function btnEditarLibro(id){
    const nombreTabla = "libros";
    const nombreCampo = "id";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('id='+id+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cota").value = res.cota;

            document.querySelector("#modificar_id").value = res.id;
            document.querySelector("#modificar_cota").value = res.cota;
            document.querySelector("#modificar_titulo").value = res.titulo;
            document.querySelector("#modificar_autor").value = res.autor;
            document.querySelector("#modificar_area").value = res.area;
            document.querySelector("#modificar_editorial").value = res.editorial;
            document.querySelector("#modificar_edicion").value = res.edicion;
            document.querySelector("#modificar_tomo").value = res.tomos;
            document.querySelector("#modificar_ejemplares").value = res.ejemplares_tot;
            document.querySelector("#modificar_fecha").value = res.fecha;
            contModalA.classList.add("active");
        }
    })
}

function btnEditarServicio(id) {
    const nombreTabla = "servicios_comunitarios";
    const nombreCampo = "id";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('id='+id+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cota").value = res.cota;

            document.querySelector("#modificar_id").value = res.id;
            document.querySelector("#modificar_cota").value = res.cota;
            document.querySelector("#modificar_titulo").value = res.titulo;
            document.querySelector("#modificar_autores").value = res.autores;
            document.querySelector("#modificar_tutor_academico").value = res.tutor_academico;
            document.querySelector("#modificar_tutor_comunitario").value = res.tutor_comunitario;
            document.querySelector("#modificar_institucion").value = res.institucion;
            document.querySelector("#modificar_fecha").value = res.fecha_presentacion;
            contModalA.classList.add("active");
        }
    })
}

function btnEditarPasantia(id){
    const nombreTabla = "pasantias";
    const nombreCampo = "id";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('id='+id+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cota").value = res.cota;

            document.querySelector("#modificar_id").value = res.id;
            document.querySelector("#modificar_cota").value = res.cota;
            document.querySelector("#modificar_titulo").value = res.titulo;
            document.querySelector("#modificar_autor").value = res.autor;
            document.querySelector("#modificar_tutor").value = res.tutor;
            document.querySelector("#modificar_institucion").value = res.institucion;
            document.querySelector("#modificar_fecha").value = res.fecha_presentacion;
            contModalA.classList.add("active");
        }
    })
}

function btnEditarTrabajoI(id){
    const nombreTabla = "trabajos_investigacion";
    const nombreCampo = "id";

    const url_html = url + "modificarModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('id='+id+'&tabla='+nombreTabla+'&campo='+nombreCampo),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#input_oculto_cota").value = res.cota;

            document.querySelector("#modificar_id").value = res.id;
            document.querySelector("#modificar_cota").value = res.cota;
            document.querySelector("#modificar_titulo").value = res.titulo;
            document.querySelector("#modificar_autor").value = res.autor;
            document.querySelector("#modificar_tutor").value = res.tutor;
            document.querySelector("#modificar_tipo").value = res.tipo;
            document.querySelector("#modificar_area").value = res.area;
            document.querySelector("#modificar_mencion").value = res.mencion;
            document.querySelector("#modificar_metodologia").value = res.metodologia;
            document.querySelector("#modificar_fecha").value = res.fecha_presentacion;
            contModalA.classList.add("active");
        }
    })
}

function getCotas(){
    let cota = document.getElementById("prestamo_cota").value;

    if (cota.length > 0) {
        let link = url + "listarCotas.php";
        let formData = new FormData();
        formData.append("cota", cota);

        fetch(link, {
            method: "POST",
            body: formData,
            mode: "cors"
        }).then(response => response.json())
        .then(data => {
            listaCotas.style.display = 'block'
            listaCotas.innerHTML = data
        })
        .catch(err => console.log(err))
    } else {
        listaCotas.style.display = 'none';
    }
}

function mostrar(cota){
    listaCotas.style.display = 'none';
    document.getElementById("prestamo_cota").value = cota;
}

function getCedulas(){
    let cedula = document.getElementById("prestamo_cedula_persona").value;

    if (cedula.length > 0) {
        let link = url + "listarCedulas.php";
        let formData = new FormData();
        formData.append("cedula", cedula);

        fetch(link, {
            method: "POST",
            body: formData,
            mode: "cors"
        }).then(response => response.json())
        .then(data => {
            listaCedulas.style.display = 'block'
            listaCedulas.innerHTML = data
        })
        .catch(err => console.log(err))
    } else {
        listaCedulas.style.display = 'none';
    }
}

function mostrarCedula(cedula){
    listaCedulas.style.display = 'none';
    document.getElementById("prestamo_cedula_persona").value = cedula;
}

function mostrarModalVerMas(id){
    const nombreTabla = "prestamos";
    const nombreCampo = "ID";

    const url_html = url + "Aplicacion/Vistas/modelsAuxiliares/verMasModel.php";

    $.ajax({
        type: 'POST',
        url: url_html,
        data: ('id='+id),
        success: function(respuesta){
            // console.log(respuesta);
            const res = JSON.parse(respuesta);
            // console.log(res);
            document.querySelector("#cedula_persona").textContent = res.cedula_persona;
            document.querySelector("#nombres_persona").textContent = res.nombres;
            document.querySelector("#apellido_persona").textContent = res.apellidos;
            document.querySelector("#tipo_persona").textContent = res.tipo_p;
            document.querySelector("#Estado_persona").textContent = res.estado_persona;
            document.querySelector("#Estado_persona").classList.add("badge");
            if (res.estado_persona == "Activo") {
                document.querySelector("#Estado_persona").classList.remove("registro-inactivo");
                document.querySelector("#Estado_persona").classList.add("registro-activo");
            } else {
                document.querySelector("#Estado_persona").classList.remove("registro-activo");
                document.querySelector("#Estado_persona").classList.add("registro-inactivo");
            }


            document.querySelector("#cota_documento").textContent = res.cota_documento;
            document.querySelector("#titulo_documento").textContent = res.titulo;
            document.querySelector("#autor_documento").textContent = res.autor;
            document.querySelector("#estado_documento").textContent = res.estado_documento;
            document.querySelector("#tipo_documento").textContent = res.tipo_d;
            document.querySelector("#estado_documento").classList.add("badge");
            if (res.estado_documento == "Disponible") {
                document.querySelector("#estado_documento").classList.remove("registro-inactivo");
                document.querySelector("#estado_documento").classList.add("registro-activo");
            } else {
                document.querySelector("#estado_documento").classList.remove("registro-activo");
                document.querySelector("#estado_documento").classList.add("registro-inactivo");
            }


            document.querySelector("#id_prestamo").textContent = res.ID;
            document.querySelector("#fechasalida_prestamo").textContent = convertirFechaMostrar(res.fecha_salida);
            document.querySelector("#fechadevolucion_prestamo").textContent = convertirFechaMostrar(res.fecha_entrada);
            document.querySelector("#estado_prestamo").classList.add("badge");
            if (res.estado == "Prestado") {
                var fechaActual = new Date();
                let fechaEntrada = res.fecha_entrada;
                var fechaDevolucion = new Date(fechaEntrada);

                console.log("FECHA ACTUAL:" + fechaActual.getDate() + "/" + (fechaActual.getMonth()+1) + "/" + fechaActual.getFullYear())
                console.log("FECHA DEVOLUCION: " + (fechaDevolucion.getDate()+1) + "/" + (fechaDevolucion.getMonth()+1) + "/" + (fechaDevolucion.getFullYear()))

                // if (fechaActual.getFullYear() > fechaDevolucion.getFullYear()) {
                //     console.log("FECHA ACTUAL ES MAYOR: ", fechaActual, ">", fechaDevolucion)
                // } else {
                //     console.log("FECHA DEVOLUCION ES MAYOR: ", fechaDevolucion, ">", fechaActual)
                // }

                if (fechaActual.getFullYear() > fechaDevolucion.getFullYear() || (fechaActual.getMonth()+1) > (fechaDevolucion.getMonth()+1) || fechaActual.getDate() > (fechaDevolucion.getDate()+1)) {
                    console.log("Se paso del plazo MOROZOOOOOO")
                    document.querySelector("#estado_prestamo").textContent = "No devuelto";
                    document.querySelector("#estado_prestamo").classList.remove("registro-activo");
                    document.querySelector("#estado_prestamo").classList.remove("registro-prestado");
                    document.querySelector("#estado_prestamo").classList.add("registro-inactivo");
                } else {
                    // console.log("No se paso del plazo, activo")
                    document.querySelector("#estado_prestamo").textContent = res.estado;
                    document.querySelector("#estado_prestamo").classList.remove("registro-activo");
                    document.querySelector("#estado_prestamo").classList.remove("registro-inactivo");
                    document.querySelector("#estado_prestamo").classList.add("registro-prestado");
                }
            } else {
                document.querySelector("#estado_prestamo").textContent = res.estado;
                document.querySelector("#estado_prestamo").classList.remove("registro-inactivo");
                document.querySelector("#estado_prestamo").classList.remove("registro-prestado");
                document.querySelector("#estado_prestamo").classList.add("registro-activo");
            }

            contModalVM.classList.add("active");
        }
    })
    
}

function convertirFecha(f) {
    let fechaa = f.split("-");
    
    let fechaConvertida = fechaa[1] + "/" + fechaa[2] + "/" + fechaa[0];

    return fechaConvertida;
}

function convertirFechaMostrar(f) {
    let fechaa = f.split("-");
    
    // let fechaConvertida = fechaa[2] + "-" + fechaa[1] + "-" + fechaa[0];

    return fechaa[2] + "-" + fechaa[1] + "-" + fechaa[0];
}

function cerrarModalVermas(){
    contModalVM.classList.remove("active");
}