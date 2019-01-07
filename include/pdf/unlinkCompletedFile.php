<?php
define("APPLICATION_PATH",  str_replace("include\\pdf","",dirname(__FILE__)));
$directory = APPLICATION_PATH;
$file = $_POST['file'];
if(is_file($directory . "\\_completed\\" . $file . ".docx")){
  unlink($directory . "\\_completed\\" . $file . ".docx"); // delete file
  echo " success";
}
?>
