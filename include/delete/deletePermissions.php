<?php
  include '../database.php';

  $userid = $_POST["userId"];

  //delets al the permissions of the selected user
  $sql = "DELETE FROM `permissions` WHERE users_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $userid);
  $stmt->execute();
  $stmt->close();
?>
