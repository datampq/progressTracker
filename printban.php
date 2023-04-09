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
//landscape:

$font = 'HelveticaNeue-Light';
$pdf->AddFont($font, '', $font . '.php');
$pdf->SetFont($font, '', 11);
$pdf->setMargins($leftMargin, 10, $rightMargin);
$pdf->AliasNbPages();

$pdf->SetFont($font, '', 14);

$pdf->AddPage('L');


//ad half page spacing:
$h1 = 28;
$h2 = 18;
$h3 = 11;
$h4 = 12;
$h5 = 10;
$h6 = 8;
$pdf->Ln(80);
$pdf->SetFont('HelveticaNeue-Light', '', $h1);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h1 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $title), 0, 1);

$pdf->SetFont('HelveticaNeue-Light', '', $h3);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h3 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $dateEdited . ' by: ' . $author), 0, 1);



$pdf->SetFont('HelveticaNeue-Light', '', $h5);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $description), 0, 1);


$pdf->AddPage('L');

$pdf->Ln(20);
$pdf->SetFont('HelveticaNeue-Light', '', $h2);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h2 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Tasks'), 0, 1);

//table pending - progress - done:
$pdf->Ln(4);
$pdf->SetFont('HelveticaNeue-Light', '', $h4);
$pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Pending'), 'B', 0);
$pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'In Progress'), 'B', 0);
$pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Done'), 'B', 1);





$request = "SELECT * FROM task WHERE projectid = '" . $id . "'";
$results = mysqli_query(Database::$conn, $request);
$i = 1;
$pending = array();
$progress = array();
$done = array();
while ($row = mysqli_fetch_assoc($results)) {
    if ($row['stat'] == 'pending') {
        array_push($pending, $row);
    } elseif ($row['stat'] == 'inProgress') {
        array_push($progress, $row);
    } elseif ($row['stat'] == 'done') {
        array_push($done, $row);
    }
    $i++;
}
$pendingCount = count($pending);
$progressCount = count($progress);
$doneCount = count($done);
$max = max($pendingCount, $progressCount, $doneCount);

for ($i = 0; $i < $max; $i++) {
    $pdf->SetFont('HelveticaNeue-Light', '', $h6);
    $pdf->Ln(4);
    if ($i < $pendingCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $pending[$i]['title']), 'T', 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $progressCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $progress[$i]['title']), 'T', 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $doneCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $done[$i]['title']), 'T', 1);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 1);
    }

    //date edited:
    $pdf->SetFont('HelveticaNeue-Light', '', $h6);

    if ($i < $pendingCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Priority: ' . $pending[$i]['prioritytask'] . ' validated: ' . $pending[$i]['validated']), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $progressCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Priority: ' . $progress[$i]['prioritytask'] . ' validated: ' . $progress[$i]['validated']), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $doneCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Priority: ' . $done[$i]['prioritytask'] . ' validated: ' . $done[$i]['validated']), 0, 1);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 1);
    }
















    if ($i < $pendingCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $pending[$i]['dateEdited'] . ' by: ' . $pending[$i]['author']), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $progressCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $progress[$i]['dateEdited'] . ' by: ' . $progress[$i]['author']), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $doneCount) {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $done[$i]['dateEdited'] . ' by: ' . $done[$i]['author']), 0, 1);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 1);
    }
    if ($i < $pendingCount) {
        $hs = $pending[$i]['hoursW'];
        //it is a number representing minutes, to hours and minutes:
        $hs = intval($hs);
        $hs = floor($hs / 60) . 'h ' . $hs % 60 . 'm';
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Estimated hours: ' . $hs), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $progressCount) {
        $hs = $progress[$i]['hoursW'];
        //it is a number representing minutes, to hours and minutes:
        $hs = intval($hs);
        $hs = floor($hs / 60) . 'h ' . $hs % 60 . 'm';
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Estimated hours: ' . $hs), 0, 0);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    if ($i < $doneCount) {
        $hs = $done[$i]['hoursW'];
        //it is a decimal number  representing minutess stored as varchar, to hours and minutes:
        //parse it to int:
        $hs = intval($hs);
        $hs = floor($hs / 60) . 'h ' . $hs % 60 . 'm';
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Estimated hours: ' . $hs), 0, 1);
    } else {
        $pdf->Cell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 1);
    }
    //description:
    //get cursor position:
    $x = $pdf->GetX();
    $y = $pdf->GetY();


    if ($i < $pendingCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $pending[$i]['description']), 0, 0);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    //update cursor position:
    $pdf->SetXY($x + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $y);



    if ($i < $progressCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $progress[$i]['description']), 0, 0);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 0);
    }
    //update cursor position:
    $pdf->SetXY($x + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3 + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $y);

    if ($i < $doneCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin)  - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $done[$i]['description']), 0, 1);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '', 0, 1);
    }
    //update cursor position:
    $pdf->SetXY($x, $y + $h5 / 2);

    //hours:



    $x = $pdf->GetX();
    $y = $pdf->GetY();

    if ($i < $pendingCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT",  $pending[$i]['note']), "B", 0);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '-', "B", 0);
    }
    $pdf->SetXY($x + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $y);

    if ($i < $progressCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT",  $progress[$i]['note']), "B", 0);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '-', "B", 0);
    }
    $pdf->SetXY($x + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3 + $pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $y);
    if ($i < $doneCount) {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT",  $done[$i]['note']), "B", 1);
    } else {
        $pdf->MultiCell($pdf->GetPageWidth() / 3 - intval($rightMargin) - 3, $h5 / 2, '-', "B", 1);
    }
    $pdf->SetXY($x, $y + $h5 / 2);

    //space:


}


$pdf->Output();
exit;
