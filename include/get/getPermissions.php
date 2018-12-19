<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
if(isset($_POST["ajax"])){
  include '../session.php';
}

$permissions = [];
if($_SESSION["admin"] == 0){
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

  if(count($permissions) <= 0 && $currentPage != "index.php"){
    header("Location: include/noPermissions.php");
  }
}else{
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

if(isset($_POST["ajax"])){
  echo json_encode($permissions);
}

?>
