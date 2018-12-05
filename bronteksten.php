<?php
include 'include/database.php';
include 'include/functions.php';

?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <?php include 'partials/navigation.php'; ?>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <div class="container">
    <div class="row">
      <div class="col s4">
        <?php include 'partials/courseList.php'; ?>
      </div>
    </div>
    <div class = "row">
      <label>Materialize Multi File Input</label>
      <div class = "file-field input-field">
        <div class = "btn">
          <span>Browse</span>
          <input type="file" id="uploadFiles" multiple />
        </div>
        <div class = "file-path-wrapper">
          <input class = "file-path validate" type = "text"
          placeholder = "Upload multiple files" />
        </div>
      </div>
    </div>
    <div class="row">
      <button class="js-ok">Upload</button>
    </div>
  </div>
  <?php include 'partials/scripts.html'; ?>
</body>
</html>
