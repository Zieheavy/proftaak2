  <?php
include 'database.php';
include 'session.php';
// session_start();
// include 'functions.php';

$loginError = "";
$registerError = "";
if (isset($_POST['logoutSub'])) {
    resetSession();
    $loggedIn = false;
    echo "succes";
}
if (isset($_POST['loginSub'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];
    login($name, $pass);
}

if (isset($_POST['registerSub'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $passE = encrypt($_POST['password']);
    $userLevel = $_POST['userLevel'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();
    if (!$num) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $name, $passE);
        $stmt->execute();
        $stmt->close();
        login($name, $pass);
    }
    else{
        echo "userExists";
    }
}

function login($name, $pass){
  include 'database.php';
  $sql = 'SELECT id, password, confirm, newcollege FROM users WHERE username = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);

  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($idResult, $hash, $confirm, $newcollege);
  if ($stmt->num_rows == 1) {
      if($stmt->fetch()) {
          if (password_verify($pass, $hash)) {
              setSession($idResult, $name, $hash, $confirm, $newcollege);
              $loggedIn = true;
              echo "succes";
              header("Location: ../home.php");
          }
          else{
            echo "Username or password is wrong";
            // header("Location: login.php");
          }
      }
      else{
        echo "Username or password is wrong";
        // header("Location: login.php");
        $loggedIn = false;
      }
  }
  else{
    echo "Username or password is wrong";
    // header("Location: login.php");
  }
  $stmt->close();
}

die();

function encrypt($str){
    return password_hash($str, PASSWORD_BCRYPT);
}
?>
