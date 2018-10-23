<html>
<head>
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
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <div class="container"></div>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
