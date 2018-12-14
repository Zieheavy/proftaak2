<?php
if(isset($_POST["ajax"])){
  include '../session.php';
}
echo json_encode($_SESSION)
?>
