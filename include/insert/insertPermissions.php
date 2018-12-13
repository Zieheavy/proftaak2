<?php
  include '../database.php';

  $userid = $_POST["userid"];
  $collegeid = $_POST['collegeId'];
  $read = $_POST['read'];
  $edit = $_POST['edit'];

  $sql = "DELETE FROM `permissions` WHERE users_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $userid);
  $stmt->execute();
  $stmt->close();

  $sql = "INSERT INTO `permissions`(`read`, `edit`, `users_id`, `colleges_id`) VALUES (?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iiii', $read,$edit,$userid,$collegeid);
  $stmt->execute();
  $stmt->close();
  echo 'success';
?>