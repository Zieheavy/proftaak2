<?php
include 'session.php';
date_default_timezone_set('UTC');

// Gets the filename and extension in array
$temp = explode(".", $_FILES["file"]["name"]);
$filename = $temp[0];
$extension = $temp[1];
unset($temp);
$folder = getFolder($extension);

$userId = $_SESSION['userId'];
$collegeId = $_SESSION['collegeId'];
$courseId = $_SESSION['courseId'];
$dateLong = date("d-m-Y H:i:s");

// If there is something wrong with the uploading of a file it just fucking dies
if ($_FILES['file']['error'] != 0){
  echo "Something whent Wrong";
  die();
}

// Loop to determine which version is used
$version = 0;
$stopWhile = false;
do {
  $exists = file_exists("../" . $folder . $filename . "_" . $version . "." . $extension);
  if (!$exists) {
    $stopWhile = true;
  }
  else {
    $version++;
  }
} while (!$stopWhile);

$newfilename = $filename . "_" . $version;

// Moves file to new destination :)
move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $folder . $newfilename . "." . $extension);

// Inserts into sourcefiles and versioncontrol
$sql = "INSERT INTO `sourcefiles`(`name`, `extension`, `users_id`, `colleges_id`, `courses_id`) VALUES (?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssiii", $filename, $extension, $userId, $collegeId, $courseId);
$stmt->execute();
$insert_id = $stmt->insert_id;
$stmt->close();

$sql = "INSERT INTO `versions`(`version`, `filedate`, `sourcefiles_id`) VALUES (?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param('isi', $version, $dateLong, $insert_id);
$stmt->execute();
$stmt->close();


echo $newfilename . "." . $extension;

//function used to get the correct folder for the sel ected file
function getFolder($extension){
  $folder = "";
  if($extension == "xlsx" || $extension == "xls" || $extension  == "xlsm"){
    $folder.= "_excel/";
  }else if($extension == "docx" || $extension == "doc"){
    $folder .= "_docs/";
  }else if($extension == "pdf"){
    $folder .= "_pdf/";
  }
  return $folder;
}
?>
