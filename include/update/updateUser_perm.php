<?php
  include '../database.php';
  $id = $_POST['id'];
  $newcollege = $_POST['newcollege'];
  $comfirm = $_POST['comfirm'];
  $admin = $_POST['admin'];

  $sql = "UPDATE `users` SET `confirm`=?, `newcollege` = ?, `admin` = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iiii',$comfirm, $newcollege, $admin, $id);
  $result = $stmt->execute();
  if ($result) {
    echo 'succes';
  }
?>
