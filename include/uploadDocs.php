<?php
include 'functions.php';
$id = $_POST['name'];
$oldFileAr = [
    "id" =>$id,
];

$img = getImage($oldFileAr, "../");

$temp = explode(".", $_FILES["file"]["name"]);
$folder = getFolder($temp);
$newfilename = $id;
if ($_FILES['file']['error'] != 0){
  echo "Something whent Wrong";
}else{
  move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $folder . $newfilename);
  echo $newfilename;
}

//checks if the image already exist if so it will delete the image
function getImage($ar, $map = ""){
    $name = $ar["id"];
    $folder = "";
    if(strrpos($name, ".xlsx") != -1 || strrpos($name, ".xls")  != -1){
      $folder = "_excel/";
    }else if(strrpos($name, ".docx") != -1 || strrpos($name, ".doc")  != -1){
      $folder = "_docs/";
    }else if(strrpos($name, ".pdf") != -1){
      $folder = "_pdf/";
    }

    $img = $map . $folder . $ar['id'] ;

    if (file_exists($img)) {
      unlink($img);
    }else{
      $img = "";
    }
    return $img;
}

//function used to get the correct folder for the selected file
function getFolder($arr){
  $folder = "";
  if($arr[1] == "xlsx" || $arr[1] == "xls"){
    $folder.= "_excel/";
  }else if($arr[1] == "docx" || $arr[1] == "doc"){
    $folder .= "_docs/";
  }else if($arr[1] == "pdf"){
    $folder .= "_pdf/";
  }
  return $folder;
}
?>
