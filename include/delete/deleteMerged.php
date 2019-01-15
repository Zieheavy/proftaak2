<?php
include '../database.php';
$merged = $_POST['id'];
$versionids = [];
$versionNames = [];
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
$questionStr = "";
foreach ($versionids as $key => $value) {
  $questionStr .= "," . $value;
}
$questionStr = substr($questionStr, 1);

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
    }
    rmdir("../../_completed/" . $name); // delete folder
  }

  for ($i=0; $i < 10; $i++) {
    if(file_exists("../../_completed/" . $name . "_" . $i . ".pdf")){
      unlink("../../_completed/" . $name . "_" . $i . ".pdf"); // delete file
    }
  }
}

$sql = "DELETE FROM `attached-files` WHERE versions_id IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM `versions` WHERE `id` IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM `mergedfiles` WHERE `id` = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$stmt->close();
echo "succes";
?>
