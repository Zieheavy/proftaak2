<?php
  include '../database.php';
  
  $userid = $_POST["userId"];

  $sql = "DELETE FROM `permissions` WHERE users_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $userid);
  $stmt->execute();
  $stmt->close();
?>
