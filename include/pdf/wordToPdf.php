<?php

$directory = __DIR__ . DIRECTORY_SEPARATOR;

$fileName = $_POST["fileName"];
echo $fileName;
$word = new COM("Word.Application") or die ("Could not initialise Object.");
// set it to 1 to see the MS Word window (the actual opening of the document)
$word->Visible = 0;
// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
$word->DisplayAlerts = 0;
// open the word 2007-2013 document
echo $directory . '../../_docs/' . $fileName . '.docx';
$word->Documents->Open($directory . '../../_docs/' . $fileName . '.docx');
// save it as word 2003
$word->ActiveDocument->SaveAs('newdocument.doc');
// convert word 2007-2013 to PDF
//D:\\school\\Semester 4\\web\\documents\\
$word->ActiveDocument->ExportAsFixedFormat($directory . '../../_pdf/' . $fileName . '.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
// $pdfList[] = '../_pdf\\' . $fileName . '.pdf';
// quit the Word process
$word->Quit(false);
// clean up
unset($word);

echo "succes";

 ?>
