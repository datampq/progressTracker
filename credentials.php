<?php
include '_main.php';
include 'pdf/fpdf.php';

class PDF extends FPDF
{
    protected $_toc = array();
    protected $_numbering = false;
    protected $_numberingFooter = false;
    protected $_numPageNum = 1;
    public $_dtitle = '';

    function AddPage($orientation = '', $format = '', $rotation = 0)
    {
        parent::AddPage($orientation, $format, $rotation);
        if ($this->_numbering)
            $this->_numPageNum++;
    }

    function startPageNums()
    {
        $this->_numbering = true;
        $this->_numberingFooter = true;
    }

    function stopPageNums()
    {
        $this->_numbering = false;
    }

    function numPageNo()
    {
        return $this->_numPageNum;
    }

    function TOC_Entry($txt, $level = 0)
    {
        $this->_toc[] = array('t' => $txt, 'l' => $level, 'p' => $this->numPageNo());
    }

    function insertTOC(
        $location = 1,
        $labelSize = 20,
        $entrySize = 10,
        $tocfont = 'HelveticaNeue-Light',
        $label = 'Table of Contents'
    ) {
        //   $this->AddFont('$tocfont', '', $tocfont . '.php');
        //make toc at end
        $this->stopPageNums();
        $this->AddPage();
        $tocstart = $this->page;
        $this->AddFont('HelveticaNeue-Light', '',  'HelveticaNeue-Light.php');
        $this->SetFont('HelveticaNeue-Light', '', $labelSize);
        $this->Cell(0, 5, $label, 0, 1, 'C');
        $this->Ln(10);

        foreach ($this->_toc as $t) {

            //Offset
            $level = $t['l'];
            if ($level > 0)
                $this->Cell($level * 8);

            $str = $t['t'];
            $this->SetFont('HelveticaNeue-Light', '', $entrySize);
            $strsize = $this->GetStringWidth($str);
            $this->Cell($strsize + 2, $this->FontSize + 2, $str);

            //Filling dots
            $this->SetFont('HelveticaNeue-Light', '', $entrySize);
            $PageCellSize = $this->GetStringWidth($t['p']) + 2;
            $w = $this->w - 30 - $this->rMargin - $PageCellSize - ($level * 8) - ($strsize + 2);
            $nb = intval($w / $this->GetStringWidth('.'));
            $dots = str_repeat('.', $nb);
            $this->Cell($w, $this->FontSize + 2, $dots, 0, 0, 'R');

            //Page number
            $this->Cell($PageCellSize, $this->FontSize + 2, $t['p'], 0, 1, 'R');
        }

        //Grab it and move to selected location
        $n = $this->page;
        $n_toc = $n - $tocstart + 1;
        $last = array();

        //store toc pages
        for ($i = $tocstart; $i <= $n; $i++)
            $last[] = $this->pages[$i];

        //move pages
        for ($i = $tocstart - 1; $i >= $location - 1; $i--)
            $this->pages[$i + $n_toc] = $this->pages[$i];

        //Put toc pages at insert point
        for ($i = 0; $i < $n_toc; $i++)
            $this->pages[$location + $i] = $last[$i];
    }

    function Header()
    {
    }
    function Footer()
    {
        if ($this->PageNo() > 1) {
            $this->SetY(-15);
            $font = 'HelveticaNeue-Light';
            $this->SetFont($font, '', 8);
            $t = $this->PageNo() - 1;
            $this->Cell(0, 10, $this->_dtitle . ' | drowToday | Page ' . $t . '/{nb}', 0, 0, 'C');
        }
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
$pdf->_dtitle = $title;
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
$h5 = 10;
$pdf->Ln(80);
$pdf->SetFont('HelveticaNeue-Light', '', $h1);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h1 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $title), 0, 1);

$pdf->SetFont('HelveticaNeue-Light', '', $h3);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h3 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited on: ' . $dateEdited . ' by: ' . $author), 0, 1);


$pdf->Ln(10);

$pdf->SetFont('HelveticaNeue-Light', '', $h5);
$pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $description), 0, 1);


$pdf->AddPage();
$pdf->Ln(20);


$pdf->startPageNums();
$pdf->TOC_Entry('Credentials', 0);
//get oage where projectId = $id:

$pdf->SetFont('HelveticaNeue-Light', '', $h2);
$pdf->Cell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h2 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Credentials'), 0, 1);

$request = "SELECT * FROM credentials WHERE projectid = '" . $id . "'";
$results = mysqli_query(Database::$conn, $request);

while ($row = mysqli_fetch_assoc($results)) {
    $pdf->Ln(6);
    $pdf->SetFont('HelveticaNeue-Light', '', $h4);

    $pdf->Cell($pdf->GetPageWidth() / 2 - intval($rightMargin) * 4, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $row['title']), 'B', 0);
    $pdf->SetFont('HelveticaNeue-Light', '', $h5);
    $pdf->Cell($pdf->GetPageWidth() / 2, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Last edited: ' . $row['dateEdited']), 'B', 1, 'R');


    $pdf->Ln(4);
    $pdf->MultiCell($pdf->GetPageWidth() - intval($rightMargin) * 4, $h5 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $row['note']), 0, 1);
    $pdf->SetFont('HelveticaNeue-Light', '', $h5);
    $pdf->Ln(2);
    $pdf->Cell($pdf->GetPageWidth() / 4 - intval($rightMargin) * 2, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Username'), 1, 0);
    $pdf->Cell($pdf->GetPageWidth() / 4, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $row['username']), 1, 0);
    $pdf->Cell($pdf->GetPageWidth() / 4 - intval($rightMargin) * 2, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", 'Password'), 1, 0);
    $pdf->Cell($pdf->GetPageWidth() / 4, $h4 / 2, iconv("UTF-8", "CP1254//TRANSLIT", $row['pass']), 1, 1,);
    //function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')

}




$pdf->Output();
exit;
