<?php

$word = new COM("word.application") or die("Cannot start MS Word");

// Hide MS Word application window
$word->Visible = 0;

//Create new document
$word->Documents->Add();

// Define page margins
$word->Selection->PageSetup->LeftMargin = '2';
$word->Selection->PageSetup->RightMargin = '2';

// Define font settings
$word->Selection->Font->Name = 'Arial';
$word->Selection->Font->Size = 10;

// Add text
// Dim wrdApp As New Word.Application
//     wrdApp.Visible = False
//     Dim docNew As Word.Document
//     Set docNew = wrdApp.Documents.Add
//     'Insert a file
//     docNew.Range.InsertFile "C:\File1.DOC"
//     'Insert another file
//     docNew.Range.InsertFile "C:\File2.DOC"
//     'insert another file
//     docNew.Range.InsertFile "C:\File3.DOC"
//     'save the document
//     docNew.SaveAs "C:\NewFile.doc"
//     wrdApp.Quit
//     Set docNew = Nothing
//     Set wrdApp = Nothing

$word->Selection->TypeText("TEXT!");

// Save document
$filename = tempnam(sys_get_temp_dir(), "word");
// echo $filename;
$word->Documents[1]->SaveAs("D:\\school\\test.doc");

// Close and quit
$word->quit();
unset($word);

echo "succes?";

// Send file to browser
readfile($filename);
unlink($filename);

 ?>
