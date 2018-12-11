<?php
include 'database.php';
include 'session.php';

$loginError = "";
$registerError = "";
if (isset($_POST['logoutSub'])) {
  logout();
}
if (isset($_POST['loginSub'])) {
  $name = $_POST['username'];
  $pass = $_POST['password'];
  login($name, $pass);
}

if (isset($_POST['registerSub'])) {
  echo "register";
  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $pass = $_POST['pass'];

  $passE = encrypt($pass);
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;
  $stmt->close();
  if (!$num) {
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $name, $passE);
    $stmt->execute();
    $stmt->close();
    login($name, $pass);
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
