<?php
include '../database.php';
$name = $_POST['name'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $name);
$stmt->execute();
$stmt->store_result();
$num = $stmt->num_rows;
$stmt->close();
if (!$num) {
  echo 0;
}
else {
  echo 1;
}

?>
