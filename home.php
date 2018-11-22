<?php
include 'include/session.php';
include 'include/database.php';

dump($_SESSION);
$id = $_SESSION['userId'];

$itemArrays = [];
$sql = "SELECT m.id as mergedId, m.name, m.version, u.id as userId FROM mergedfiles m,users u WHERE m.users_id = ? AND m.users_id = u.id";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
if (false === ($stmt = $conn->prepare($sql))) {
    echo 'error preparing statement: ' . $conn->error;
} elseif (!$stmt->bind_param("i", $id)) {
    echo 'error binding params: ' . $stmt->error;
} elseif (!$stmt->execute()) {
    echo 'error executing statement: ' . $stmt->error;
}
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
    $itemArrays[] = $row;
}

// echo json_encode($itemArrays);


?>
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
  <!-- <button class="btn btn-primary deleteAll">Delete all</button>
  <div class="btn btn-primary js-mergeSelected">Merge selected</div>
  <input type="text" class="js-merge-name" placeholder="Merge name"> -->

  <?php foreach($itemArrays as $item){ ?>
  <div class="container">
    <div class="home-card col s10 offset-s1 m7">
      <div class="card horizontal">
        <div class="card-image">
          <iframe class="iframe" src="_completed\<?php echo $item["name"]; ?>.pdf"></iframe>
        </div>
        <div class="card-stacked">
          <div class="card-content">
            <p>I am a very simple card. I am good at containing small bits of information.</p>
          </div>
          <div class="card-action home-card-action">
            <a href="#">Edit</a>
            <a href="#">Download</a>
            <div class="input-field">
              <select>
                <option value="" disabled selected></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
              <label>Versie</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>


  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <div class="container"></div>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
