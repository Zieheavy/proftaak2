<?php
include '../session.php';

date_default_timezone_set('UTC');

require_once("../../tcpdf/tcpdf.php");
require_once('../../fpdi/fpdi.php');
define("APPLICATION_PATH",  str_replace("include\\pdf","",dirname(__FILE__)));

//global varialbes
$mergeOrder = [];
$files = $_POST["files"];
$pages = $_POST["pages"];
$pageExt = $_POST["pageExt"];
$mergeName = $_POST["mergeName"];
$userId = $_SESSION["userId"];
$courseId = $_SESSION["courseId"];
$dateShort = date("zHis");
$dateLong = date("d-m-Y H:i:s");
$file = "_completed/";
$mergeVersion = 0;
$mergeId = -1;
$versionId = -1;
$mVersion = -1;

//checks if the users is logged in if not stop the code
if($_SESSION["loggedIn"] == -1){
  echo "noUser";
  die();
}

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

//checks if the name is empty if so the name becouse the date
if($mergeName == ""){
  $mergeName =  "unnamed".$dateShort;
}

// get all the files in a folder
$folderContent = array_diff(scandir("../../_completed"), array('..', '.'));
foreach ($folderContent as $value) {
  //checks if a file name is equal to the file name you have given version++
  if($value == $mergeName . "_" . $mergeVersion . ".pdf"){
    $mergeVersion++;
  }
}

// check if a folder is created is so check all the files in the folder
if(file_exists("../../_completed/" . $mergeName)){
  //get all the files in a folder
  $folderContent = array_diff(scandir("../../_completed/".$mergeName), array('..', '.'));
  foreach ($folderContent as $value) {
    //checks if a file name is equal to the file name you have given version++

    $temp = -1;
    $temp = explode("_",$value)[1];
    $temp = explode(".",$temp)[0] + 1;
    if($mergeVersion < $temp){
      $mergeVersion = $temp;
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

//sets the file name
if ($mergeVersion  > 5) {
  $file .= $mergeName . "/" . $mergeName . "_" . ($i - 1) . ".pdf";
}
else {
  $file .= $mergeName . "_" . ($i - 1) . ".pdf";
}

//sets the latest version
$mVersion = $mergeVersion - 1;

//check if the file is already in the database
if(getMergedFiles($mergeName,$userId,$courseId, $conn) == -1){
  $sql = "INSERT INTO `mergedfiles`(`name`, `users_id`, `courses_id`) VALUES (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sii', $mergeName,$userId,$courseId);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  $mergeId = getMergedFiles($mergeName,$userId,$courseId, $conn);
}else{
  $mergeId = getMergedFiles($mergeName,$userId,$courseId, $conn);
}

//inserst a new version into the database
$sql = "INSERT INTO versions (version, filedate, mergedfiles_id)
VALUES ('$mVersion', '$dateLong', '$mergeId')";
if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$versionId = getVersion($mVersion, $mergeId, $conn);

// $sql = "INSERT INTO `versions`(`version`, `filedate`, `mergedfiles_id`) VALUES (?,?,?)";
// if (false === ($stmt = $conn->prepare($sql))) {
//     echo 'error preparing statement: ' . $conn->error;
// }
// elseif (!$stmt->bind_param('isi', $mergeVersion, $dateLong, $mergeId)) {
//     echo 'error binding params: ' . $stmt->error;
// }
// elseif (!$stmt->execute()) {
//     echo 'error executing statement: ' . $stmt->error;
// }
// $result = $stmt->get_result();
// $stmt->close();

//for all source files loop
for ($i=0; $i < count($files); $i++) {
  $page = $pages[$i];
  $sourceId = -1;

  $sourceFiles = [];
  //select the correct source file;
  $sql = "SELECT * FROM `sourcefiles` WHERE name = ? AND extension = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $files[$i],$pageExt[$i]);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
      $sourceFiles[] = $row;
  }
  $stmt->close();

  $sourceId = $sourceFiles[0]["id"];

  //insert new attached file with selected source file id
  $sql = "INSERT INTO `attached-files`(`pages`, `versions_id`, `sourcefiles_id`) VALUES (?,?,?)";
  if (false === ($stmt = $conn->prepare($sql))) {
      echo 'error preparing statement: ' . $conn->error;
  }
  elseif (!$stmt->bind_param('sii', $page,$versionId,$sourceId)) {
      echo 'error binding params: ' . $stmt->error;
  }
  elseif (!$stmt->execute()) {
      echo 'error executing statement: ' . $stmt->error;
  }
  $result = $stmt->get_result();
  $stmt->close();
}

//function to get the id of a merged_file
function getMergedFiles($mergeName,$userId,$courseId, $conn){
  $tempArray = [];
  $sql = "SELECT * FROM `mergedfiles` WHERE name = ? AND users_id = ? AND courses_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sii', $mergeName,$userId,$courseId);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
      $tempArray[] = $row;
  }
  $stmt->close();

  if(count($tempArray) <= 0){
    return -1;
  }else{
    return $tempArray[0]["id"];
  }
}

//function to get the id of a version
function getVersion($mVersion, $mergeId, $conn){
  $tempArray = [];
  $sql = "SELECT * FROM `versions` WHERE version = ? AND mergedfiles_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $mVersion,$mergeId);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
      $tempArray[] = $row;
  }
  $stmt->close();

  if(count($tempArray) <= 0){
    return -1;
  }else{
    return $tempArray[0]["id"];
  }
}

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
