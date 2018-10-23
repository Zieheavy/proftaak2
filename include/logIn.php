<?php
include 'database.php';
include 'session.php';

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
    $sql = 'SELECT id, password FROM users WHERE username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($idResult, $hash);
    if ($stmt->num_rows == 1) {
        if($stmt->fetch()) {
            if (password_verify($pass, $hash)) {
                setSession($idResult, $name, $hash);
                $loggedIn = true;
                    echo "succes";
            }
            else{
                echo "Username or password is wrong";
            }
        }
        else{
            echo "Username or password is wrong";
            $loggedIn = false;
        }
    }
    else{
        echo "Username or password is wrong";
    }
    $stmt->close();
}
if (isset($_POST['registerSub'])) {
    $name = $_POST['username'];
    $pass = encrypt($_POST['password']);
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
        $stmt->bind_param('ss', $name, $pass);
        $stmt->execute();
        $stmt->close();
        echo "succes";
    }
    else{
        echo "userExists";
    }
}

function encrypt($str){
    return password_hash($str, PASSWORD_BCRYPT);
}
?>
