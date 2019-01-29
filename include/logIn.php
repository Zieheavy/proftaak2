<?php

include 'database.php';
include 'session.php';

$loginError = "";
$registerError = "";

//checks if the users is set
if (isset($_POST['logoutSub'])) {
  logout();
}

//check if the loggin button is clicked
if (isset($_POST['loginSub'])) {
  $name = $_POST['username'];
  $pass = $_POST['password'];
  login($name, $pass);
}

//checks if the register button is clicked
if (isset($_POST['registerSub'])) {
  echo "register";
  $name = $_POST['username'];
  $mail = $_POST['email'];
  $pass = $_POST['password'];
  $pass2 = $_POST['password2'];
  $er = 0;

  //checks if the password hase more than 6 characters
  if (strlen($pass) < 7) {
    echo "shortpass";
    header("Location: ../index.php?s=8&e=" . $mail . "&n=" . $name);
    die();
  }

  //checks if the username has more than 4 characters
  if (strlen($name) < 5) {
    echo "shortname";
    header("Location: ../index.php?s=7&e=" . $mail . "&n=" . $name);
    die();
  }

  //checks if the two passwords are the same
  if ($pass != $pass2) {
    echo "wrongPass2";
    header("Location: ../index.php?s=6&e=" . $mail . "&n=" . $name);
    die();
  }


  $passE = encrypt($pass);
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;
  $stmt->close();
  //checks if the user already exists
  if (!$num) {
    echo "numpassed<br>";
    //insert the new user into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $name, $passE);
    $stmt->execute();
    $stmt->close();
    echo "Succesfully created user";
    header("Location: ../index.php?s=9");
  }
  else{
    echo "userExists";
    header("Location: ../index.php?s=3");
  }
}

function logout(){
  resetSession();
  $loggedIn = false;
  header("Location: ../index.php?s=2");
}

function login($name, $pass){
  include 'database.php';
  $sql = 'SELECT  u.id,
  u.password,
  u.confirm,
  u.newcollege,
  u.verified,
  u.colleges_id,
  u.admin,
  u.courses_id
  FROM  users u
  WHERE username = ?';

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);

  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($idResult, $hash, $confirm, $newcollege, $verified, $collegeid, $admin, $course);
  if($stmt->fetch()) {
    if (password_verify($pass, $hash)) {
      setSession_revised(1, $idResult, $name, $hash, $confirm, $admin, $newcollege, $verified, $collegeid, $course);
      $loggedIn = true;
      echo "succes";
      header("Location: ../home.php");
    }
    else{
      echo "Username or password is wrong1";
      header("Location: ../index.php?s=1");
    }
  }
  else{
    echo "Username or password is wrong2";
    header("Location: ../index.php?s=1");
    $loggedIn = false;
  }
  $stmt->close();
}

function encrypt($str){
  return password_hash($str, PASSWORD_BCRYPT);
}
?>
