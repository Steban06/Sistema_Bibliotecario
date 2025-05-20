<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Reporte-de-Prestamos-Realizados.xls");

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
<h1>Listado de Prestamos Realizados</h1>
<p style="text-align: center;">Generado el: <?php echo date("d/m/Y"); ?></p>
    <table>
        <tr>
            <th>Cédula del solicitante</th>
            <th>Cota del Documento</th>
            <th>Fecha de salida</th>
            <th>Fecha de Devolucioón</th>
            <th>Estado</th>
            <th>Observaciones</th>
        </tr>

<?php // Abre la etiqueta <table> aquí

$mysqli = new mysqli("localhost", "root","","biblioteca_bd");
$consulta = "SELECT * FROM prestamos";
$resultado = $mysqli->query($consulta);
$mysqli->set_charset("utf8mb4");

if ($resultado) {
    while($row = $resultado->fetch_assoc()){
?>
        <tr>
            <td><?php echo $row['cedula_persona']; ?></td>
            <td><?php echo $row['cota_documento']; ?></td>
            <td><?php echo $row['fecha_salida']; ?></td>
            <td><?php echo $row['fecha_entrada']; ?></td>
            <td><?php echo $row['estado']; ?></td>
            <td><?php echo $row['observaciones']; ?></td>
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