<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Reporte-de-Trabajos-de-Servicio-Comunitario.xls");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Tabla</title>

    <style>
        h1 {
            text-align: center; /* Centra el título horizontalmente */
            border: 1px
        }
        h3 {
            text-align: center; /* Centra el subtítulo horizontalmente */
            border-collapse: collapse;
            margin-top: 0.5em; /* Ajusta el margen superior */
            margin-bottom: 0.5em; /* Ajusta el margen inferior */
        }
        table {
            width: 100%; /* O un ancho específico si lo deseas */
            border-collapse: collapse; /* Para evitar espacios entre celdas */
            margin-top: 20px; /* Espacio entre el subtítulo y la tabla */
        }
        th, td {
            border: 1px solid black; /* Bordes para las celdas */
            padding: 8px; /* Espacio dentro de las celdas */
            text-align: center; /* Alineación del texto en las celdas */
        }

        th { /* Estilos específicos para los encabezados (<th>) */
            background-color: lightblue; /* Color de fondo azul claro */
            color: black; /* Color de texto negro (opcional) */
        }
    </style>

</head>
<body>

<h3>REPÚBLICA BOLIVARIANA DE VENEZUELA</h3>
<h3>MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN</h3>
<h3>UNIVERSIDAD NACIONAL EXPERIMENTAL DE LA FUERZA ARMADA</h3>
<h3>NÚCLEO NUEVA ESPARTA</h3>
<h1>Listado de Trabajos de Servicios Comunitarios</h1>
<p style="text-align: center;">Generado el: <?php echo date("d/m/Y"); ?></p>
    <table>
        <tr>
            <th>Cota</th>
            <th>Título</th>
            <th>Autores</th>
            <th>Tutor Académico</th>
            <th>Tutor Comunitario</th>
            <th>Institución</th>
            <th>Fecha de Presentación</th>
            <th>Estado</th>
        </tr>

<?php // Abre la etiqueta <table> aquí

$mysqli = new mysqli("localhost", "root","","biblioteca_bd");
$consulta = "SELECT * FROM servicios_comunitarios";
$resultado = $mysqli->query($consulta);
$mysqli->set_charset("utf8mb4");

if ($resultado) {
    while($row = $resultado->fetch_assoc()){
?>
        <tr>
            <td><?php echo $row['cota']; ?></td>
            <td><?php echo $row['titulo']; ?></td>
            <td><?php echo $row['autores']; ?></td>
            <td><?php echo $row['tutor_academico']; ?></td>
            <td><?php echo $row['tutor_comunitario']; ?></td>
            <td><?php echo $row['institucion']; ?></td>
            <td><?php echo $row['fecha_presentacion']; ?></td>
            <td><?php echo $row['estado']; ?></td>
        </tr>

<?php
    }
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

$mysqli->close();

?>

    </table>  </body>
</html>