<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('libs/fpdf.php');
require_once 'config.php'; // conexión PDO

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Reporte de Proyectos - TecnoSoluciones',0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(10,10,'ID',1);
        $this->Cell(60,10,'Nombre',1);
        $this->Cell(120,10,'Descripcion',1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$stmt = $pdo->query("SELECT * FROM proyectos");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10,10,$row['id'],1);
    $pdf->Cell(60,10,utf8_decode($row['nombre']),1);
    $pdf->Cell(120,10,utf8_decode($row['descripcion']),1);
    $pdf->Ln();
}

$pdf->Output();

