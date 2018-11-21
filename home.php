<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div class="flash-message-container"> </div>

  <?php include 'partials/navigation.php'; ?>

  <!-- <div class="btn btn-primary js-wordToPdf">word to pdf</div>
  <div class="btn btn-primary js-excelToPdf">excel to pdf</div>
  <div class="btn btn-primary js-mergePdf">Merge pdf</div> -->
  <!-- <button id="open_btn" class="btn btn-primary open-dialog">Upload File</button> -->
  <!-- <div class="col s12 m8 l9">
      <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Sorry, this file is too large</p></div><input type="file" id="input-file-now" class="dropify" data-default-file=""><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
  </div> -->
  <button class="btn btn-primary deleteAll">Delete all</button>
  <div class="btn btn-primary js-mergeSelected">Merge selected</div>
  <input type="text" class="js-merge-name" placeholder="Merge name">
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <div class="container"></div>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
