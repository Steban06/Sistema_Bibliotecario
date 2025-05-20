<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Reporte-de-estudiantes.xls");

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
<h1>Listado de Estudiantes</h1>
<p style="text-align: center;">Generado el: <?php echo date("d/m/Y"); ?></p>
    <table>
        <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Email</th>
            <th>Carrera</th>
            <th>Semestre</th>
            <th>Estado</th>
        </tr>

<?php // Abre la etiqueta <table> aquí

$mysqli = new mysqli("localhost", "root","","biblioteca_bd");
$consulta = "SELECT * FROM estudiantes";
$resultado = $mysqli->query($consulta);
$mysqli->set_charset("utf8mb4");

if ($resultado) {
    while($row = $resultado->fetch_assoc()){
?>
        <tr>
            <td><?php echo $row['cedula']; ?></td>
            <td><?php echo $row['nombres']; ?></td>
            <td><?php echo $row['apellidos']; ?></td>
            <td><?php echo $row['telefono']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['carrera']; ?></td>
            <td><?php echo $row['semestre']; ?></td>
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