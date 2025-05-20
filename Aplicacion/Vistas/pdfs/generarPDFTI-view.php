<?php
require_once "../../../Configuraciones/Conexion.php";
require_once "../../../autoload.php";
require_once "../../../Aplicacion/Templates/session_start.php";
include('pdf_mc_table.php');

// Rutas a los logos
$fecha_actual = date('d/m/Y');
$logo1 = '../../../imagenes/fondo.png';
$logo2 = '../../../imagenes/FANB.png';

// 1. Crear la instancia de PDF_MC_Table ANTES de usar Image()
$pdf = new PDF_MC_Table();

$pdf->Addpage();

// 2. Añadir los logos
$pdf->Image($logo1, 180, 5, 18); // Logo 1: x=10, y=10, ancho=30
$pdf->Image($logo2, 10, 5, 18); 

$pdf->SetFont('Arial','B',6);
$pdf->Cell(68);
$pdf->Cell(100,4,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,'C');
$pdf->Cell(-6);
$pdf->Cell(100,4,utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA DEFENSA'),0,'C');
$pdf->Cell(-10);
$pdf->Cell(100,4,utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL DE LA FUERZA ARMADA NACIONAL'),0,'C');
$pdf->Cell(20);
$pdf->Cell(100,4, utf8_decode('UNEFA - NÚCLEO NUEVA ESPARTA'),0,'C');

$pdf->SetFont('Arial','B',26);
$pdf->Ln(2);
// Movernos a la derecha
$pdf->Cell(40);
// Título
$pdf->Cell(30,10,utf8_decode('Trabajos de investigación'),0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(115, 0, '', 'T', 0, 'C');
$pdf->Ln(1.5);
$pdf->Cell(60,10,'Fecha: '. $fecha_actual, 0, 0, 'C');
$pdf->Cell(180,10,'Solicitante: '. $_SESSION['nombres'].' '.$_SESSION['apellidos'], 0, 1, 'C');

$pdf->Ln(0.5);
$pdf->SetFont('Arial','',8);

// 3. Establecer la conexión a la base de datos
$mysqli = new mysqli("localhost", "root","","biblioteca_bd"); // Reemplaza con tus datos de conexión

// 4. Realizar la consulta a la base de datos
$consulta = "SELECT * FROM trabajos_investigacion"; // Reemplaza con tu consulta
$resultado = $mysqli->query($consulta);

// 5. Almacenar los datos en un array
$data = array();
while($row = $resultado->fetch_assoc()){
    $data[] = $row;
}

$pdf->SetWidths(Array(13,35,15,15,20,30,17,18,23));

$pdf->SetLineHeight(5);
$pdf->SetFillColor(0, 0, 0); // Negro
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(13,5,"Cota",1,0,'C', 1); 
$pdf->Cell(35,5,utf8_decode("Título"),1,0,'C', 1);
$pdf->Cell(15,5,"Autor",1,0,'C', 1);
$pdf->Cell(15,5,"Tipo",1,0,'C', 1);
$pdf->Cell(20,5,utf8_decode("Área"),1,0,'C', 1);
$pdf->Cell(30,5,utf8_decode("Mención"),1,0,'C', 1);
$pdf->Cell(17,5,utf8_decode("Metodología"),1,0,'C', 1);
$pdf->Cell(18,5,utf8_decode("Fecha P"),1,0,'C', 1);
$pdf->Cell(23,5,"Estado",1,0,'C', 1);

$pdf->Ln();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0, 0, 0);
foreach($data as $item){
    $row = array();
    foreach($item as $key => $value){
        if(is_string($value)){
            $value = utf8_decode($value);
        }
        $row [] = $value;
    }

    $pdf->row(Array(
        $item[utf8_decode('cota')],
        $item[utf8_decode('titulo')],
        $item[utf8_decode('autor')],
        $item[utf8_decode('tipo')],
        $item[utf8_decode('area')],
        $item[utf8_decode('mencion')],
        $item[utf8_decode('metodologia')],
        $item[utf8_decode('fecha_presentacion')],
        $item[utf8_decode('estado')],
    ));
}

$pdf->Output();

// Cerrar la conexión a la base de datos
$mysqli->close();
?>