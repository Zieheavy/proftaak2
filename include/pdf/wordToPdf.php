<?php
define("APPLICATION_PATH",  str_replace("include\\pdf","",dirname(__FILE__)));
$directory = APPLICATION_PATH;

$fileName = $_POST['fileName'];
$extension = $_POST['extension'];

$word = new COM("Word.Application") or die ("Could not initialise Object.");
// set it to 1 to see the MS Word window (the actual opening of the document)
$word->Visible = 0;
// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
$word->DisplayAlerts = 0;
// open the word 2007-2013 document
echo $extension . "  ";
if($extension == "docx"){
  $word->Documents->Open($directory . '_docs\\' . $fileName . '.docx');

  // save it as word 2003
  $word->ActiveDocument->SaveAs('newdocument.doc');
}else{
  $word->Documents->Open($directory . '_docs\\' . $fileName . '.doc');
}

// convert word 2007-2013 to PDF
$word->ActiveDocument->ExportAsFixedFormat($directory . '_pdf\\' . $fileName . '.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
// quit the Word process
$word->Quit(false);
// clean up
unset($word);

echo "succes";

 ?>
