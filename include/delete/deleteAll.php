<?php
$folderAr = ['_html', '_pdf', '_pdf-split', '_docs', '_excel', '_completed'];
foreach ($folderAr as $key => $fol) {
  $folder = array_diff(scandir("../" . $fol), array('..', '.'));
  foreach($folder as $file){ // iterate files
    if(is_file("../" . $fol . '/' . $file)){
      unlink("../" . $fol . '/' . $file); // delete file
    }
  }
}
echo 'success';
?>
