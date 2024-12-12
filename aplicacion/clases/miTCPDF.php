<?php
require_once(RUTA_BASE.'/scripts/TCPDF/examples/tcpdf_include.php');
class miTCPDF extends TCPDF {

//Page header
public function Header() {
    // Logo
    $image_file = K_PATH_IMAGES.'logo.jpg';
    $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
    $this->SetFont('dejavusans', 'B', 20);
    // Title
    $fecha = date("d/m/Y");
   // $this->Cell(0, 0, 'Compra - ' . $fecha, 0, false, 'C', 0, '', 0, false, 'M', 'M');
    // Apply style to the title
    $this->writeHTMLCell(0, 0, '', '', '', 0, 1, false, true, 'C', true);
}

// Page footer
public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('dejavusans', '', 8);
    // Page number
    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // Apply style to the page number
    $this->writeHTMLCell(0, 0, '', '', '', 0, 1, false, true, 'C', true);
}


public function createTextBox($text, $x, $y, $w, $h, $fontSize, $fontStyle = '', $align = 'L') {
    $this->SetXY($x, $y);
    $this->SetFont(PDF_FONT_NAME_MAIN, $fontStyle, $fontSize);
    $this->Cell($w, $h, $text, 0, false, $align);
}

}