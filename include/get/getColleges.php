<?php

$colleges = [];

//checks if you enterd the page via a ajax request
if(isset($_POST["ajax"])){
  include '../database.php';
}

//selects all the colleges from the database
$sql = "SELECT * FROM `colleges`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $row["courses"] = [];
  $colleges[] = $row;
}
$stmt->close();

//puts the courses with the correct college in a object array
for ($i=0; $i < count($colleges); $i++) {
  $temp = [];
  $sql = "SELECT * FROM `courses` WHERE colleges_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $colleges[$i]["id"]);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $temp[] = $row;

  }
  $stmt->close();
  $colleges[$i]["courses"] = $temp;
}

//if you have enterd the page via ajax request return the object array
if(isset($_POST["ajax"])){
  echo json_encode($colleges);
}

 ?>
