<?php
session_start();

// session_destory();
include 'database.php'; // Should create a var $conn
include 'functions.php';

// dump($_SESSION);
if (!isset($_SESSION['loggedIn'])) { // If this variable doesn't exist, it creates all the session vars
    resetSession();
}


if(isset($_POST["return"])){
  echo json_encode($_SESSION);
}

$loggedIn = $_SESSION['loggedIn'];
if ($loggedIn) {
    $id = $_SESSION['userId'];

    $sql = 'SELECT username, password FROM users WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $pass);
    // echo $name;
    // echo $pass;

    $userinfo = [];
    // If the query doesn't return anything it'll reset the session
    if($stmt->fetch()) {
        $userinfo = array('name'=>$name, 'pass'=>$pass);

        // If the returned values isn't the same as the session values it resets
        if ($_SESSION['username']  != $userinfo['name'] || $_SESSION['password'] != $userinfo['pass']) {
            resetSession();
        }
    }
    else{
        resetSession();
    }
    $stmt->close();

    unset($userinfo, $smtp, $sql);
}
else {
    // header('Location:index.php');
    // if( $_SESSION['loggedIn'] == 0){
    //   header("Location: ../index.php");
    // }
}
// The reset
function resetSession(){
    $_SESSION = [];
    $_SESSION['loggedIn'] = 0;
    $_SESSION['userId'] = -1;
    $_SESSION['username'] = '';
    $_SESSION['password'] = '';
    $_SESSION['userLevel'] = -1;
      header("Location: ../index.php");
}

function setSession($id, $usn, $pass, $userLevel){
    $_SESSION['loggedIn'] = 1;
    $_SESSION['userId'] = $id;
    $_SESSION['username'] = $usn;
    $_SESSION['password'] = $pass;
    $_SESSION['userLevel'] = $userLevel;
}

function setFlash($str,$type,$dism,$secs){
    array_push($_SESSION['flashMessages'],['mes' => $str, 'type' =>$type, 'dismissable' => $dism, 'secs'=>$secs]);
}
// Debug reset
function resetSessionDebug(){
    $_SESSION['loggedIn'] = 1;
    $_SESSION['userId'] = 1;
    $_SESSION['username'] = 'dylanbos';
    $_SESSION['password'] = 'hallo';
}
?>
