<?php

include '../database.php';

$merged = $_POST['id'];
$versionids = [];
$versionNames = [];

//gets all the version from the selected file
$sql = "SELECT id FROM versions WHERE mergedfiles_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  array_push($versionids, $row['id']);
}
$stmt->close();

//turns all the version ids in to a string sql can check
$questionStr = "";
foreach ($versionids as $key => $value) {
  $questionStr .= "," . $value;
}
$questionStr = substr($questionStr, 1);

//gets all the selected files and removes them from the server
$sql = "SELECT * FROM mergedfiles WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  array_push($versionNames, $row['name']);
}
$stmt->close();
foreach ($versionNames as $key => $name) {
  if(file_exists("../../_completed/" . $name)){
    foreach (scandir("../../_completed/" . $name) as $key => $value) {
      if(file_exists("../../_completed/" . $name . "/"  . $name . "_" . $key . ".pdf")){
        unlink("../../_completed/" . $name . "/"  . $name . "_" . $key . ".pdf"); // delete file
      }
      if(file_exists("../../_completed/" . $name . "/"  . $name . "_" . $key . ".docx")){
        unlink("../../_completed/" . $name . "/"  . $name . "_" . $key . ".docx"); // delete file
      }
    }
    rmdir("../../_completed/" . $name); // delete folder
  }

  for ($i=0; $i < 10; $i++) {
    if(file_exists("../../_completed/" . $name . "_" . $i . ".pdf")){
      unlink("../../_completed/" . $name . "_" . $i . ".pdf"); // delete file
    }
    if(file_exists("../../_completed/" . $name . "_" . $i . ".docx")){
      unlink("../../_completed/" . $name . "_" . $i . ".docx"); // delete file
    }
  }
}

//deletes the attach files from the database where id is in the string of versions
$sql = "DELETE FROM `attached-files` WHERE versions_id IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

//deletes all the version from the database where id is in the string of versions
$sql = "DELETE FROM `versions` WHERE `id` IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

//deletes the file from the database
$sql = "DELETE FROM `mergedfiles` WHERE `id` = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$stmt->close();

echo "succes";
?>
