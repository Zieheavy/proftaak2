<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proftaak</title>
    <?php include 'partials/head.html'; ?>
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
  ///////////////////////////////
  // empty a folder completely //
  ///////////////////////////////

// $files = glob($directory . '_pdf\\*'); // get all file names
// foreach($files as $file){ // iterate files
//   if(is_file($file)){
//     unlink($file); // delete file
//   }
// }

?>
