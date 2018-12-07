<?php

$colleges = [];
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

if(isset($_POST["ajax"])){
  echo json_encode($colleges);
}

 ?>
