<?php
include '_main.php';
include 'pdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
    }
    function Footer()
    {
        $this->SetY(-15);
        $font = 'HelveticaNeue-Light';
        $this->SetFont($font, '', 8);
        $this->Cell(0, 10, 'drowTracker | Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location:index.php');
    exit;
}
$request = "SELECT * FROM project WHERE id = '" . $id . "'";
$results = mysqli_query(Database::$conn, $request);
$row = mysqli_fetch_assoc($results);
$title = $row['title'];
$dateEdited = $row['dateEdited'];
$description = $row['description'];
$author = $row['author'];
$hoursW = $row['hoursW'];
$startd = $row['startd'];
$endd = $row['endd'];




date_default_timezone_set('Europe/Berlin');
$dateTimeCurrentCHHeure = date("d-m-Y H:i");
$dateTimeCurrentCH = date("d-m-Y");
$yearStamp = date("Y");
$dayStamp = date("d");
$monthStamp = date("m");



$topMargin = 10;
$leftMargin = 25;
$rightMargin = 10;
$pdf = new PDF();
$font = 'HelveticaNeue-Light';
$pdf->AddFont($font, '', $font . '.php');
$pdf->SetFont($font, '', 11);
$pdf->setMargins($leftMargin, 10, $rightMargin);
$pdf->AliasNbPages();

$pdf->SetFont($font, '', 14);

$pdf->AddPage();


//ad half page spacing:
$h1 = 28;
$h2 = 18;
$h3 = 14;
$h4 = 12;
$h5 = 11;
$pdf->Ln(80);
$pdf->SetFont('HelveticaNeue-Light', '', $h1);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h1 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $title), 0, 1);

$pdf->SetFont('HelveticaNeue-Light', '', $h3);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h3 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $dateEdited . ' by: ' . $author), 0, 1);



$pdf->SetFont('HelveticaNeue-Light', '', $h5);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $description), 0, 1);


$pdf->AddPage();

$pdf->Ln(20);
$pdf->SetFont('HelveticaNeue-Light', '', $h2);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h2 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Notes'), 0, 1);

$request = "SELECT * FROM todos WHERE projectid = '" . $id . "'";
$results = mysqli_query(Database::$conn, $request);
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
    $pdf->Ln(4);
    $pdf->SetFont('HelveticaNeue-Light', '', $h4);
    //function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    $pdf->Cell($pdf->GetPageWidth()  - intval($rightMargin) * 4, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $i . '. ' . $row['dateEdited']), 'B', 1);
    $pdf->SetFont('HelveticaNeue-Light', '', $h5);
    $pdf->Ln(2);
    $pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $row['content']), 0, 1);

    $i++;
}


$pdf->Output();
exit;
