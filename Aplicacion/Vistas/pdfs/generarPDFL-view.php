<?php
require_once "../../../Configuraciones/Conexion.php";
require_once "../../../autoload.php";
require_once "../../../Aplicacion/Templates/session_start.php";
require 'fpdf/fpdf.php';

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $fecha_actual = date('d/m/Y');
    $this->Image('../../../imagenes/fondo.png',180,8,18);
    $this->Image('../../../imagenes/FANB.png',10,8,18);

    $this->SetFont('Arial','B',6);
    $this->Cell(68);
    $this->Cell(100,4,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,'C');
    $this->Cell(-6);
    $this->Cell(100,4,utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA DEFENSA'),0,'C');
    $this->Cell(-10);
    $this->Cell(100,4,utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL DE LA FUERZA ARMADA NACIONAL'),0,'C');
    $this->Cell(20);
    $this->Cell(100,4, utf8_decode('UNEFA - NÚCLEO NUEVA ESPARTA'),0,'C');

    $this->SetFont('Arial','B',26);
    $this->Ln(2);
    // Movernos a la derecha
    $this->Cell(45);
    // Título
    $this->Cell(30,10,'Libros Registrados',0,'C');
    $this->SetFont('Arial','B',9);
    $this->Cell(85, 0, '', 'T', 0, 'C');
    $this->Ln(1.5);
    $this->Cell(60,10,'Fecha: '. $fecha_actual, 0, 0, 'C');
    $this->Cell(180,10,'Solicitante: '. $_SESSION['nombres'].' '.$_SESSION['apellidos'], 0, 1, 'C');

    $this->SetFont('Arial','B',10);
    $this->SetFillColor(0, 0, 0); // Negro
    $this->SetTextColor(255, 255, 255);
    $this->Cell(4,10,utf8_decode('ID'),1,0,'C',1);
    $this->Cell(12,10,utf8_decode('Cota'),1,0,'C',1);
    $this->Cell(32,10,utf8_decode('Título'), 1,0,'C',1);
    $this->Cell(22,10,utf8_decode('Autor'), 1,0,'C',1);
    $this->Cell(26,10,utf8_decode('Área'), 1,0,'C',1);
    $this->Cell(20,10,utf8_decode('Editorial'), 1,0,'C',1);
    $this->SetFont('Arial','B',7);
    $this->Cell(12,10,utf8_decode('Edición'), 1,0,'C',1);
    $this->Cell(12,10,utf8_decode('Tomos'), 1,0,'C',1);
    $this->Cell(10,10,utf8_decode('Totales'), 1,0,'C',1);
    $this->Cell(10,10,utf8_decode('Disp.'), 1,0,'C',1);
    $this->Cell(14,10,utf8_decode('Fecha'), 1,0,'C',1);
    $this->Cell(17,10,utf8_decode('Estado'), 1,1,'C',1);

}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}

$mysqli = new mysqli("localhost", "root","","biblioteca_bd");
$consulta = ("SELECT * FROM  libros");
$resultado = $mysqli->query($consulta);

$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',7);

while($row = $resultado->fetch_assoc()){
    $pdf->Cell(4,10,$row[('id')],1,0,'C',0);
    $pdf->Cell(12,10,$row[('cota')],1,0,'C',0);
    $pdf->Cell(32,10,$row['titulo'], 1,0,'C',0);
    $pdf->Cell(22,10,$row['autor'], 1,0,'C',0);
    $pdf->Cell(26,10,$row['area'], 1,0,'C',0);
    $pdf->Cell(20,10,$row['editorial'], 1,0,'C',0);
    $pdf->Cell(12,10,$row['edicion'], 1,0,'C',0);
    $pdf->Cell(12,10,$row['tomos'], 1,0,'C',0);
    $pdf->Cell(10,10,$row['ejemplares_tot'], 1,0,'C',0);
    $pdf->Cell(10,10,$row['ejemplares_dis'], 1,0,'C',0);
    $pdf->Cell(14,10,$row['fecha'], 1,0,'C',0);
    $pdf->Cell(17,10,$row['estado'], 1,1,'C',0);

}

$pdf->Output();

?>

