<?php
include "../database.php";
include "../db.php";
include "../functions.php";
$error = "";
$collegeId = $_POST["collegeId"];

$sql = "SELECT id FROM courses WHERE colleges_id = ?";
$db = new db($con, $sql);
$db->bindParam("i", $collegeId);
$courseIds = $db->getResult();
$courseIds = array_column($courseIds, "id");

$sql = "SELECT * FROM mergedfiles WHERE courses_id in";
$sql .= "(";
foreach ($courseIds as $key => $value) {
  if ($key > 0) {
    $sql .= ", " . $value;
  }
  else {
    $sql .= $value;
  }
}
$sql .= ");";
$db = new db($con, $sql);
$db->execute();
$num = $db->num_rows();
$db->close();

if (!$num) {
  $sql = "SELECT * FROM sourcefiles WHERE colleges_id = ?";
  $db = new db($con, $sql);
  $db->bindParam("i", $collegeId);
  $db->execute();
  $sourceNums = $db->num_rows();
  $db->close();
  if (!$sourceNums) {
    //deletes the courses from the college you have selected
    $sql = "DELETE FROM `courses` WHERE colleges_id = ?";
    $db = new db($con);
    $db->prepare($sql);
    $db->bindParam("i", $collegeId);
    $db->execute(1);

    //deletes the college you selected
    $sql = "DELETE FROM `colleges` WHERE id = ?";
    $db = new db($con);
    $db->prepare($sql);
    $db->bindParam("i", $collegeId);
    $db->execute(1);
    echo "succes";
  }
  else {
    echo "sourcefiles";
  }
}
else {
  echo "mergedfiles";
}



?>
