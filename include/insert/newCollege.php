<?php
  include '../database.php';

  $name = $_POST["name"];

  //inserts a new college in to the database
  $sql = "INSERT INTO `colleges`(`name`) VALUES (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $stmt->close();
  echo 'succes';

?>
