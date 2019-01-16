<?php

include "../database.php";

$courseId = $_POST["courseId"];

//deletes the selected course from the database
$sql = "DELETE FROM `courses` WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$stmt->close();

echo "succes";
?>
