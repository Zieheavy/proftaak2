<?php

include "../database.php";

$collegeId = $_POST["collegeId"];

//deletes the courses from the college you have selected
$sql = "DELETE FROM `courses` WHERE colleges_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $collegeId);
$stmt->execute();
$stmt->close();

//deletes the college you selected
$sql = "DELETE FROM `colleges` WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $collegeId);
$stmt->execute();
$stmt->close();

echo "succes";
?>
