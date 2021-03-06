<?php

$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$permissions = [];

//checks if you enterd the page via a ajax request
if(isset($_POST["ajax"])){
  include '../session.php';
}

//check if a admin is not logged in
if($_SESSION["admin"] == 0){
  //get the permisions from the logged in user
  $sql = "SELECT * FROM permissions WHERE users_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $permissions[] = $row;
  }
  $stmt->close();

  //if you do not have permsions and are not on the loggin page you will be redirected to login
  if(count($permissions) <= 0 && $currentPage != "index.php"){
    header("Location: include/noPermissions.php");
  }
}
else{
  //sets all the permision for a admin user
  $sql = "SELECT c.id as colleges_id  FROM `colleges` c";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $row["read"] = 1;
    $row["edit"] = 1;
    $permissions[] = $row;
  }
  $stmt->close();
}

//if you have enterd the page via ajax request return the object array
if(isset($_POST["ajax"])){
  echo json_encode($permissions);
}

?>
