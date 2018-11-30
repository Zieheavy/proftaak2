<?php
include 'database.php';
$sql = "DELETE FROM `attached-files`";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();
$sql = "DELETE FROM `versions`";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();
$sql = "DELETE FROM `mergedfiles`";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();
?>
