<?php

include '../database.php';

$files = [];
$sql = "SELECT m.name, m.users_id, m.courses_id, c.colleges_id FROM `mergedfiles` m, courses c WHERE m.courses_id = c.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row;
}
$stmt->close();

echo json_encode($files);

 ?>
