<?php

  include '../database.php';
  $id = $_POST['id'];
  $college = $_POST['college'];
  $course = $_POST['course'];

  //updates the college and course of a user, it also verifies the user
  $sql = "UPDATE `users` SET `colleges_id`=?, `courses_id` = ?, `verified` = 1 WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iii',$college, $course, $id);
  $result = $stmt->execute();
  if ($result) {
    echo 'succes';
  }
?>
