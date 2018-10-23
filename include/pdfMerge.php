<?php

$mergeOrder = [];
require_once('../fpdf/fpdf.php');
require_once("../tcpdf/tcpdf.php");
require_once('../fpdi/fpdi.php');
define("APPLICATION_PATH",  str_replace("include","",dirname(__FILE__)));

$files = $_POST["files"];
$pages = $_POST["pages"];

for($i = 0; $i < count($files); $i++){
  if($pages[$i] != "all"){
    split_pdf($files[$i], '_pdf', "_pdf-split");
    $numbers = explode(",",$pages[$i]);
    for($j = 0; $j < count($numbers); $j++){
      $mergeOrder[] = "../_pdf-split/" . $files[$i] . "_" . $numbers[$j] . ".pdf";
    }
  }else{
    $mergeOrder[] = "../_pdf/" . $files[$i] . ".pdf";
  }
}

// echo json_encode($mergeOrder);


require_once("../MergePdf.class.php");
MergePdf::merge(
  $mergeOrder,
  MergePdf::DESTINATION__DISK_INLINE
);

function split_pdf($filename, $directory, $split_directory)
{
  $filename = $filename . ".pdf";

	$pdf = new FPDI();
  $pdf->AddPage();
	$pagecount = $pdf->setSourceFile( APPLICATION_PATH . $directory . "/" . $filename); // How many pages?

	// Split each page into a new PDF
	for ($i = 1; $i <= $pagecount; $i++) {
		$new_pdf = new FPDI();
		$new_pdf->AddPage();
		$new_pdf->setSourceFile(APPLICATION_PATH . $directory . "/" . $filename);
		$new_pdf->useTemplate($new_pdf->importPage($i));

		try {
			$new_filename = str_replace('.pdf', '', $filename).'_'.$i.".pdf";
      // echo $new_filename;
			$new_pdf->Output(APPLICATION_PATH . $split_directory . "/" . $new_filename, "F");
			echo "Page ".$i." split into ".$new_filename."<br />\n";
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

// Create and check permissions on end directory!
// split_pdf("verslag3.pdf", '_pdf', "_pdf-split");




 ?>
