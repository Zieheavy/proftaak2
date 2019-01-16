<?php

include '../database.php';

$files = [];

//selects all the sourcefiles from the server
$sql = "SELECT * FROM `sourcefiles`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row["name"];
}
$stmt->close();

//echo the array so that ajax can read it
echo json_encode($files);

 ?>
