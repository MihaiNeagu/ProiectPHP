<?php
include('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',16);
$pdf->Text(25,40,'Prima pagina PDF.');
$pdf->Output();
?>