<?php

include "../database.php";

$sourceId = $_POST["sourceid"];

$sql = "DELETE FROM `versions` WHERE sourcefiles_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $sourceId);
$stmt->execute();
$stmt->close();

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
