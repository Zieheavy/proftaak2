<?php

include "../database.php";

$sourceId = $_POST["sourceid"];
$files = [];

//delets all the version of the source file
$sql = "DELETE FROM `versions` WHERE sourcefiles_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $sourceId);
$stmt->execute();
$stmt->close();

//selects the source files from the database
$sql = "SELECT * FROM `sourcefiles` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sourceId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row["name"];
}
$stmt->close();

//removes all the files from the server
foreach ($files as $num => $name) {
  foreach (scandir("../../_pdf/") as $key => $value2) {
    if(file_exists("../../_docs/" . $name . "_" . $key . ".docx")){
      unlink("../../_docs/" . $name . "_" . $key . ".docx"); // delete file
    }
    if(file_exists("../../_docs/" . $name . "_" . $key . ".doc")){
      unlink("../../_docs/" . $name . "_" . $key . ".doc"); // delete file
    }
    if(file_exists("../../_excel/" . $name . "_" . $key . ".xlsx")){
      unlink("../../_excel/" . $name . "_" . $key . ".xlsx"); // delete file
    }
    if(file_exists("../../_excel/" . $name . "_" . $key . ".xls")){
      unlink("../../_excel/" . $name . "_" . $key . ".xls"); // delete file
    }
    if(file_exists("../../_excel/" . $name . "_" . $key . ".xlsm")){
      unlink("../../_excel/" . $name . "_" . $key . ".xlsm"); // delete file
    }
    if(file_exists("../../_pdf/" . $name . "_" . $key . ".pdf")){
      unlink("../../_pdf/" . $name . "_" . $key . ".pdf"); // delete file
    }
  }
}

//deletes the sourcefiles from the database
$sql = "DELETE FROM `sourcefiles` WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $sourceId);
$result = $stmt->execute();
if ($result) {
  echo 'succes';
}else{
  echo "cant";
}
$stmt->close();
?>
