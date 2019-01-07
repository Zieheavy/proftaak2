<?php
$file = $_POST['file'];
define("APPLICATION_PATH",  str_replace("include\\pdf","",dirname(__FILE__)));
$directory = APPLICATION_PATH;
// die();
$word = new COM("Word.Application") or die ("Could not initialise Object.");
// set it to 1 to see the MS Word window (the actual opening of the document)
$word->Visible = 0;
// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
$word->DisplayAlerts = 0;
$word->Documents->Open($directory . '\\_completed\\' . $file . ".pdf", false, true, false);
$word->ActiveDocument->SaveAs($directory . '\\_completed\\' . $file . '.docx');

$word->Quit(false);
// clean up
unset($word);
echo "success";
?>
