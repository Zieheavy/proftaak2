<?php
session_start();
include 'database.php'; // Should create a var $conn (and $con)
include 'functions.php';

// This is what the session should look like, customize this however you want. If the session is not like this it will reset
// The values are the standard values the session has when you enter the site for the first time
$shouldBeInSession = [
  'loggedIn' => 0,
  'userId' => -1,
  'username' => '',
  'password' => '',
  'confirm' => 0,
  'admin' => 0,
  'newcollege' => 0,
  'verified' => 0,
  'collegeId' => -1,
  'courseId' => -1
];

// Checks if all session variables exist, if not it resets the session to the default values
foreach ($shouldBeInSession as $key => $value) {
  if (!array_key_exists($key, $_SESSION)) {
    resetSession();
  }
}

// Checks if there are variables in the session that shouldnt be there, if there are, resets
foreach ($_SESSION as $key => $value) {
  if (!array_key_exists($key, $shouldBeInSession)) {
    resetSession();
  }
}

// If a _POST is given it returns the whole session as a JSON
if(isset($_POST["return"])){
  echo json_encode($_SESSION);
}

// if the user is logged in it checks the username and password in the database
if ($_SESSION['loggedIn']) {
  $id = $_SESSION['userId'];
  $sql = 'SELECT username, password FROM users WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($name, $pass);

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

// The reset
function resetSession(){
  global $shouldBeInSession;
  $_SESSION = [];
  foreach ($shouldBeInSession as $key => $value) {
    $_SESSION[$key] = $value;
  }
  // header("Location: index.php");
}

// Function to set the session, the $params count should be equal to or less than the amount of vars in $shouldBeInSession
// You can also give 1 array with the same keys as the $shouldBeInSession
function setSession_revised(...$params){
  // GLobalized the $shouldBeInSession to use in this funciton
  global $shouldBeInSession;

  if (!is_array($params[0])) {
    $shouldCount = count($shouldBeInSession);
    $paramCount = count($params);
    // If the amount of params is equal it just sets the session with the values of the given params
    if ($paramCount == $shouldCount) {
      $_SESSION = [];
      $keys = array_keys($shouldBeInSession);
      $newAr = array_combine($keys, $params);
      $_SESSION = $newAr;
    }
    // If the amount of params is lower than $shouldBeInSession, it fills the rest with whats left from $shouldBeInSession
    else if ($paramCount < $shouldCount){
      $_SESSION = [];
      $numerical = array_values($shouldBeInSession);
      $keys = array_keys($shouldBeInSession);
      $values = [];
      for ($i=0; $i < $shouldCount; $i++) {
        if (isset($params[$i])) {
          array_push($values, $params[$i]);
        }
        else {
          array_push($values, $numerical[$i]);
        }
      }
      $newAr = array_combine($keys, $values);
      $_SESSION = $newAr;
    }
    // Can't have too many
    else{
      return "too many params";
    }
  }
  // If it's an array it just sets the keys with the values to the session
  else{
    $params = $params[0];
    foreach ($params as $key => $value) {
      $_SESSION[$key] = $value;
    }
  }
}
?>
