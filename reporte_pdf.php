<?php
require('libs/fpdf.php');
require_once 'config.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Reporte de Clientes - TecnoSoluciones',0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(10,10,'ID',1);
        $this->Cell(50,10,'Nombre',1);
        $this->Cell(70,10,'Correo',1);
        $this->Cell(50,10,'Telefono',1);
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
$pdf->SetFont('Arial','',12);

// Obtener los datos
$stmt = $pdo->query("SELECT * FROM clientes");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10,10,$row['id'],1);
    $pdf->Cell(50,10,utf8_decode($row['nombre']),1);
    $pdf->Cell(70,10,utf8_decode($row['correo']),1);
    $pdf->Cell(50,10,utf8_decode($row['telefono']),1);
    $pdf->Ln();
}

$pdf->Output();
