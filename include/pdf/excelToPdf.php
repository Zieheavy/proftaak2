<?php

$directory = __DIR__ . DIRECTORY_SEPARATOR;

$fileName = $_POST["fileName"];
// echo $fileName;
// $fileName = "urenSeletor2";

///////////////////////////
// converts xlms to html //
///////////////////////////

require_once('../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../../_excel/" . $fileName . ".xlsx");

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($spreadsheet);
$writer->save('../../_html/' . $fileName . '.html');

//////////////////////////
// converts html to pdf //
//////////////////////////

require_once '../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
$html = file_get_contents("../../_html/" . $fileName . ".html");

$html = str_replace("page-break-after:always"," ",(string)$html);

$mpdf->WriteHTML($html);

$mpdf->Output('../../_pdf/' . $fileName . ".pdf",'F');

die("succes");

 ?>
