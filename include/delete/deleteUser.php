<?php

include '../database.php';
include '../db.php';

$userid = $_POST["userId"];

$sql = "DELETE FROM `permissions` WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->close();

//gets source files
$sql = "SELECT id FROM `sourcefiles` WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userid);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  //gets the versions
  $sql2 = "SELECT id FROM versions WHERE sourcefiles_id = ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param('i', $row["id"]);
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  while ($row2 = $result2->fetch_array(MYSQLI_ASSOC))
  {
    //deletes the attached file for all versions
    $sql3 = "DELETE FROM `attached-files` WHERE sourcev_id = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('i', $row2["id"]);
    $stmt3->execute();
    $stmt3->close();

    //delets all the versions
    $sql3 = "DELETE FROM `versions` WHERE id = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('i', $row2["id"]);
    $stmt3->execute();
    $stmt3->close();
  }
  $stmt2->close();

  //deletes all the source files
  $sql3 = "DELETE FROM `sourcefiles` WHERE id = ?";
  $stmt3 = $conn->prepare($sql3);
  $stmt3->bind_param('i', $row["id"]);
  $stmt3->execute();
  $stmt3->close();
}
$stmt->close();

//gets all the merged files id
$sql = "SELECT id FROM mergedfiles WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userid);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  echo $row["id"];
  echo "\n <br>  ";
  $db = new db($con);
  $db->prepare('DELETE FROM `attached-files` WHERE mergedfiles_id = ?');
  $db->bindParam('i', $row["id"]);
  $db->execute();
  // $sql3 = "DELETE FROM `attached-files` WHERE mergedfiles_id = ?";
  // $stmt3 = $conn->prepare($sql3);
  // $stmt3->bind_param('i', $row["id"]);
  // $stmt3->execute();
  // $stmt3->close();

  //delets the versions for each merged file
  $sql2 = "DELETE FROM `versions` WHERE mergedfiles_id = ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param('i', $row["id"]);
  $stmt2->execute();
  $stmt2->close();



  echo "mid point";

  //delets the mergedfiles
  $sql2 = "DELETE FROM `mergedfiles` WHERE id = ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param('i', $row["id"]);
  $stmt2->execute();
  $stmt2->close();
}
$stmt->close();

$sql = "DELETE FROM `users` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->close();

 ?>
