<?php
date_default_timezone_set('UTC');

require_once("../../tcpdf/tcpdf.php");
require_once('../../fpdi/fpdi.php');
define("APPLICATION_PATH",  str_replace("include\\pdf","",dirname(__FILE__)));

$mergeOrder = [];
$files = $_POST["files"];
$pages = $_POST["pages"];
$mergeName = $_POST["mergeName"];
$date = date("zHis");
$mergeVersion = 0;

//check if you want to split the file
for($i = 0; $i < count($files); $i++){
  if($pages[$i] != "all"){
    split_pdf($files[$i], '_pdf', "_pdf-split");
    $numbers = explode(",",$pages[$i]);
    for($j = 0; $j < count($numbers); $j++){
      $mergeOrder[] = "../../_pdf-split/" . $files[$i] . "_" . $numbers[$j] . ".pdf";
    }
  }else{
    $mergeOrder[] = "../../_pdf/" . $files[$i] . ".pdf";
  }
}

//get all the files in a folder
$folderContent = array_diff(scandir("../../_completed"), array('..', '.'));
foreach ($folderContent as $value) {
  //checks if a file name is equal to the file name you have given version++
  if($value == $mergeName . "_" . $mergeVersion . ".pdf"){
    $mergeVersion++;
  }
}

//check if a folder is created is so check all the files in the folder
if(file_exists("../../_completed/" . $mergeName)){
  //get all the files in a folder
  $folderContent = array_diff(scandir("../../_completed/".$mergeName), array('..', '.'));
  foreach ($folderContent as $value) {
    //checks if a file name is equal to the file name you have given version++
    if($value == $mergeName . "_" . $mergeVersion . ".pdf"){
      $mergeVersion++;
    }
  }
}

//requires mergepdf that is then merges the selected files in the array
require_once("../../MergePdf.class.php");
MergePdf::merge(
  $mergeOrder,
  MergePdf::DESTINATION__DISK_INLINE
);

//emptys all the spilt pdf files
$folder = array_diff(scandir("../../_pdf-split"), array('..', '.'));
foreach($folder as $file){ // iterate files
  if(is_file("../../_pdf-split/" . $file)){
    unlink("../../_pdf-split/" . $file); // delete file
  }
}

//checks if the name is empty if so the name becouse the date
if($mergeName == ""){
  $mergeName =  "unnamed".$date;
}

//moves the default merged file
rename ("../../merged-files.pdf", "../../_completed/" . $mergeName . "_" . $mergeVersion . ".pdf");
$mergeVersion++;

//check if the mergeversion is 5 or higher and if a folder is already created if not create a new folder with the file name
if($mergeVersion > 5 && !file_exists("../../_completed/" . $mergeName)){
  mkdir("../../_completed/" . $mergeName, 0777);
}

//moves the files to the new folder
for($i = 0; $i < $mergeVersion; $i++){
  $file = $mergeName . "_" . $i . ".pdf";
  if(file_exists("../../_completed/" . $file) == 1 && $mergeVersion > 5){
    rename ("../../_completed/" . $file, "../../_completed/" . $mergeName . "/" . $file);
  }
}

$file = "_completed/";
if ($mergeVersion  > 5) {
  $file .= $mergeName . "/" . $mergeName . "_" . ($i - 1) . ".pdf";
}
else {
  $file .= $mergeName . "_" . ($i - 1) . ".pdf";
}
echo $file;

//function used to split the pdf in seaprated pages
function split_pdf($filename, $directory, $split_directory)
{
  $filename = $filename . ".pdf";

	$pdf = new FPDI();
  $pdf->AddPage();
	$pagecount = $pdf->setSourceFile( APPLICATION_PATH . $directory . "/" . $filename); // How many pages?

	// Split each page into a new PDF
	for ($i = 1; $i <= $pagecount; $i++) {
		$new_pdf = new FPDI();
    $size = $pdf->getTemplateSize($pdf->importPage($i));
    $orientation = $size['w'] > $size['h'] ? 'L' : 'P';
		$new_pdf->AddPage($orientation);
		$new_pdf->setSourceFile(APPLICATION_PATH . $directory . "/" . $filename);
		$new_pdf->useTemplate($new_pdf->importPage($i));

		try {
			$new_filename = str_replace('.pdf', '', $filename).'_'.$i.".pdf";
      // echo $new_filename;
			$new_pdf->Output(APPLICATION_PATH . $split_directory . "/" . $new_filename, "F");
			// echo "Page ".$i." split into ".$new_filename."<br />\n";
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>
