<?php
ini_set('memory_limit', '1024M');
require('libs/fpdf186/fpdf.php');
require_once 'config.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Reporte de Proyectos - TecnoSoluciones',0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(10,10,'ID',1);
        $this->Cell(40,10,'Nombre',1);
        $this->Cell(90,10,utf8_decode('Descripción'),1);
        $this->Cell(50,10,'Cliente',1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
    }

    function Row($data) {
        $widths = [10, 40, 90, 50]; // Anchos
        $maxHeight = 0;
        $heights = [];

        // Calcular altura necesaria
        foreach ($data as $i => $txt) {
            $nb = $this->NbLines($widths[$i], utf8_decode($txt));
            $height = $nb * 5;
            $heights[] = $height;
            if ($height > $maxHeight) $maxHeight = $height;
        }

        $yStart = $this->GetY();
        $xStart = $this->GetX();

        // Dibujar celdas con contenido
        foreach ($data as $i => $txt) {
            $this->SetXY($xStart, $yStart);
            $this->MultiCell($widths[$i], 5, utf8_decode($txt), 1);
            $xStart += $widths[$i];
            $this->SetXY($xStart, $yStart); // Volver al tope
        }

        // Mover a la siguiente línea
        $this->Ln($maxHeight);
    }

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1;
        $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$stmt = $pdo->query("SELECT p.id, p.nombre, p.descripcion, c.nombre AS cliente 
                     FROM proyectos p 
                     INNER JOIN clientes c ON p.cliente_id = c.id 
                     ORDER BY p.id DESC 
                     LIMIT 100");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Row([
        $row['id'],
        $row['nombre'],
        $row['descripcion'],
        $row['cliente']
    ]);
}

ob_end_clean();
$pdf->Output();
