<?php
  include '../database.php';

  $name = $_POST["name"];
  $collegeId = $_POST["collegeId"];

  //inserts a new course in the database with the correct college id
  $sql = "INSERT INTO `courses`(`name`, `colleges_id`) VALUES (?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $name, $collegeId);
  $stmt->execute();
  $stmt->close();
  echo 'succes';

?>
