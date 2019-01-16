<?php

include 'session.php';

//checks if a user is logged in
$logedin = false;
if($_SESSION["loggedIn"] == 1){
  $logedin = true;
}

resetSession();

//if the user is not loggedin he will be redirected to the home page
if($logedin == true){
  header("Location: ../index.php?s=4");
}else{
  header("Location: ../index.php?s=5");
}

?>
