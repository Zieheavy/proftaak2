<?php
include 'functions.php';
$id = $_POST['name'];
$oldFileAr = [
    "id" =>$id,
];

$img = getImage($oldFileAr, "../");
// if (file_exists($img)) {
//     unlink($img);
//     $temp = explode(".", $_FILES["file"]["name"]);
//     // echo json_encode($temp);
//     $folder = getFolder($temp);
//     $newfilename = $id . '.' . end($temp);
//     if ($_FILES['file']['error'] != 0){
//       echo "Something whent Wrong";
//     }else{
//       move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $folder . $newfilename);
//       echo $newfilename;
//     }
// }else{
  $temp = explode(".", $_FILES["file"]["name"]);
  // echo json_encode($temp);
  $folder = getFolder($temp);
  $newfilename = $id;
  // echo json_encode($_FILES);
  if ($_FILES['file']['error'] != 0){
    echo "Something whent Wrong";
  }else{
    move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $folder . $newfilename);
    echo $newfilename;
  }
// }

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
