<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proftaak</title>
    <script src="dest/js/jquery.min.js"></script>
    <script src="dest/js/popper.min.js"></script>
    <script src="dest/js/bootstrap.min.js"></script>
    <script src="dest/js/mustache.js"></script>
    <script type="text/javascript" src="dest/js/bootstrap-filestyle.js"></script>

    <link href="dist/bootstrap.fd.css" rel="stylesheet">
    <script src="dist/bootstrap.fd.js"></script>
    <script type="text/javascript" src="dest/js/bootstrap-filestyle.js"></script>

    <link rel="stylesheet" href="dest/css/bootstrap.min.css">
    <link rel="stylesheet" href="dest/css/fontawesome-all.css">
    <link rel="stylesheet" href="dest/css/app.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="flash-message-container"> </div>

  <!-- <div class="btn btn-primary js-wordToPdf">word to pdf</div>
  <div class="btn btn-primary js-excelToPdf">excel to pdf</div>
  <div class="btn btn-primary js-mergePdf">Merge pdf</div> -->
  <button id="open_btn" class="btn btn-primary open-dialog">Upload File</button>
  <div class="btn btn-primary js-mergeSelected">Merge selected</div>

  <div class="container"></div>

  <div class="templateContainer">
    <template class="iframe-template">
        {{#.}}
          <div class="iframe-container">
            <iframe class="iframe" src="{{name}}" width="100%"></iframe>
            <input class="pages" type="text" data-file={{name}} placeholder="Pages... (1,2,3 all)" value="">
            <input class="selected" type="checkbox">Select pdf
          </div>
        {{/.}}
    </template>
  </div>

  <div class="modal js-confirm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title confirm-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="confirm-text">Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success confirm-save-change">Accepteren</button>
          <button type="button" class="btn btn-danger confirm-delete-change" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>

<?php
// $documents = ["doc1","doc3","doc6"];
// $directory = __DIR__ . DIRECTORY_SEPARATOR;
// $pdfList = Array("_pdf/doc1.pdf","_pdf/doc3.pdf","_pdf/urenSeletor2.pdf","_pdf/doc6.pdf");

  ////////////////////////////////////
  // converts word doucments to pdf //
  ////////////////////////////////////

  // addFunction("doc4");

  // function wordToPdf($fileName) {
  //   $directory = __DIR__ . DIRECTORY_SEPARATOR;
  //
  //   $word = new COM("Word.Application") or die ("Could not initialise Object.");
  //   // set it to 1 to see the MS Word window (the actual opening of the document)
  //   $word->Visible = 0;
  //   // recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
  //   $word->DisplayAlerts = 0;
  //   // open the word 2007-2013 document
  //   $word->Documents->Open($directory . '_docs/' . $fileName . '.docx');
  //   // save it as word 2003
  //   $word->ActiveDocument->SaveAs('newdocument.doc');
  //   // convert word 2007-2013 to PDF
  // //D:\\school\\Semester 4\\web\\documents\\
  //   $word->ActiveDocument->ExportAsFixedFormat($directory . '_pdf/' . $fileName . '.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
  //   $pdfList[] = '_pdf\\' . $fileName . '.pdf';
  //   // quit the Word process
  //   $word->Quit(false);
  //   // clean up
  //   unset($word);
  // }

  /////////////////////////////////
  // merges all the selected pdf //
  /////////////////////////////////

  // mergePdf(["_pdf/doc1.pdf","_pdf/doc4.pdf"]);

  // function mergePdf($files){
  //   require_once("MergePdf.class.php");
  //   MergePdf::merge(
  //   	$files,
  //   	MergePdf::DESTINATION__DISK_INLINE
  //   );
  // }

  ///////////////////////////////
  // empty a folder completely //
  ///////////////////////////////

// $files = glob($directory . '_pdf\\*'); // get all file names
// foreach($files as $file){ // iterate files
//   if(is_file($file)){
//     unlink($file); // delete file
//   }
// }

  ///////////////////////////
  // converts xlms to html //
  ///////////////////////////

// $fileName = "urenSeletor2";
//
// require_once 'vendor/autoload.php';
//
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//
// $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("_excel/" . $fileName . ".xlsx");
//
// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($spreadsheet);
// $writer->save('_html/' . $fileName . '.html');

  //////////////////////////
  // converts html to pdf //
  //////////////////////////

// require_once 'vendor/autoload.php';
//
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
// $html = file_get_contents("_html/" . $fileName . ".html");
//
// str_replace("page-break-after:always"," ",$html);
//
// $mpdf->WriteHTML($html);
//
// $mpdf->Output('_pdf/' . $fileName . ".pdf",'F');

?>
