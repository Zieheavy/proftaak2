<?php
// After downloading file as a DOCX, the temporary file is deleted
define("APPLICATION_PATH",  str_replace("include\\delete","",dirname(__FILE__)));
$directory = APPLICATION_PATH;
$file = $_POST['file'];
if(is_file($directory . "\\_completed\\" . $file . ".docx")){
  unlink($directory . "\\_completed\\" . $file . ".docx"); // delete file
}
?>
