<?php

include '../database.php';

$files = [];
$sql = "SELECT * FROM `sourcefiles`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row["name"];
}
$stmt->close();

echo json_encode($files);

 ?>
