<?php

include '../database.php';

$name = $_POST['name'];

//selects the user with the correct user name from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $name);
$stmt->execute();
$stmt->store_result();
$num = $stmt->num_rows;
$stmt->close();
if (!$num) {
  //if no users exits return false
  echo 0;
}
else {
  //if user exits return true
  echo 1;
}

?>
