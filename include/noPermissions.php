<?php
// for ($i=0; $i < 10; $i++) {
//   echo "NO PERMISSIONS <br>";
// }
include 'session.php';
// include '../partials/navigation.php';
// include '../partials/head.html';
// include '../partials/scripts.php';

$logedin = false;
if($_SESSION["loggedIn"] == 1){
  $logedin = true;
}

resetSession();

if($logedin == true){
  header("Location: ../index.php?s=4");
}else{
  header("Location: ../index.php?s=5");
}

?>
