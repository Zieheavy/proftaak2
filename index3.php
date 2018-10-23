<?php

include_once('tbszip.php');

$zip = new clsTbsZip();

// echo "succes?";

$word = new COM("word.application") or die("Cannot start MS Word");
$word->Visible = 0;
$word->Documents->Add();
$word->Selection->TypeText("TEXT!");
$word->Documents[1]->SaveAs("D:\\school\\Semester 4\\web\\documents\\merge.docx");
$word->quit();

for($i = 1; $i < 7; $i++){

  // echo 'doc' . $i . '.docx';
  // Open the first document
  $zip->Open('merge.docx');
  $content1 = $zip->FileRead('word/document.xml');
  $zip->Close();

  // Extract the content of the first document
  $p = strpos($content1, '<w:body');
  if ($p===false) exit("Tag <w:body> not found in document 1.");
  $p = strpos($content1, '>', $p);
  $content1 = substr($content1, $p+1);
  $p = strpos($content1, '</w:body>');
  if ($p===false) exit("Tag </w:body> not found in document 1.");
  $content1 = substr($content1, 0, $p);


  // Insert into the second document
  $zip->Open('doc' . $i . '.docx');
  $content2 = $zip->FileRead('word/document.xml');
  $p = strpos($content2, '</w:body>');
  if ($p===false) exit("Tag </w:body> not found in document 2.");
  $content2 = substr_replace($content2, $content1, $p, 0);
  // $content1 = $content2;
  $zip->FileReplace('word/document.xml', $content2, TBSZIP_STRING);

  $zip->Flush(TBSZIP_FILE, 'merge.docx');
}

// Save the merge into a third file

echo "succes";
