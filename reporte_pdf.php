<?php
require('libs/fpdf.php');
require_once 'config.php';

$fecha = date("d/m/Y H:i");

// Obtener los proyectos con datos del cliente
$stmt = $pdo->prepare("
    SELECT proyectos.id, proyectos.nombre, proyectos.descripcion, clientes.nombre AS cliente
    FROM proyectos
    INNER JOIN clientes ON proyectos.cliente_id = clientes.id
");
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo (opcional)
$pdf->Image('img/logo.png', 10, 10, 30);
$pdf->Cell(40);
$pdf->Cell(110, 10, utf8_decode('Reporte de Proyectos - TecnoSoluciones S.A.'), 0, 1, 'C');
$pdf->Ln(10);

// Fecha
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Fecha y Hora: $fecha", 0, 1, 'R');
$pdf->Ln(5);

// Encabezado tabla
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(80, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Cliente', 1, 1, 'C', true);

// Datos
$pdf->SetFont('Arial', '', 11);
foreach ($proyectos as $proyecto) {
    $pdf->Cell(10, 10, $proyecto['id'], 1);
    $pdf->Cell(50, 10, utf8_decode($proyecto['nombre']), 1);
    $pdf->Cell(80, 10, utf8_decode($proyecto['descripcion']), 1);
    $pdf->Cell(50, 10, utf8_decode($proyecto['cliente']), 1);
    $pdf->Ln();
}

// Salida
$pdf->Output('I', 'reporte_proyectos_pdf');

?>

