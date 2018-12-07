<?php
include 'functions.php';
include 'database.php';

// If there is something wrong with the uploading of a file it just fucking dies
if ($_FILES['file']['error'] != 0){
  echo "Something whent Wrong";
  die();
}

// Gets the filename and extension in array
$temp = explode(".", $_FILES["file"]["name"]);
$filename = $temp[0];
$extension = $temp[1];
unset($temp);

$folder = getFolder($extension);

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

$newfilename = $filename . "_" . $version . "." . $extension;

// Moves file to new destination :)
move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $folder . $newfilename);

// Inserts database data


echo $newfilename;


//function used to get the correct folder for the selected file
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
