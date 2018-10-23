<?php
  $folderContent = array_diff(scandir("../_pdf"), array('..', '.'));
  $_SESSION['pdfs'] = [];
  foreach ($folderContent as $value) {
    $_SESSION['pdfs'][] = $value;
  }

  echo json_encode($_SESSION["pdfs"]);
?>
