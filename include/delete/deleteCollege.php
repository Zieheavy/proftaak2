<?php

include "../database.php";

$collegeId = $_POST["collegeId"];

$sql = "DELETE FROM `courses` WHERE colleges_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $collegeId);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM `colleges` WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $collegeId);
$stmt->execute();
$stmt->close();

echo "succes";
?>