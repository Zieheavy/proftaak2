<?php
include 'include/database.php';
include 'include/functions.php';
$files = [];
$sql = "SELECT s.id as sourcefiles_id,
              s.name as sourcefile_name,
              s.extension,
              u.id as users_id,
              u.username as users_name,
              c.id as colleges_id,
              c.name as colleges_name,
              co.id as courses_id,
              co.name as courses_name
        FROM sourcefiles s
        INNER JOIN users u ON s.users_id = u.id
        INNER JOIN colleges c ON s.colleges_id = c.id
        INNER JOIN courses co ON s.courses_id = co.id";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row;
}
$stmt->close();
$newfiles = [];
foreach ($files as $key => $file) {
  $newfiles[$file['colleges_name']][$file['courses_name']] = $file;
}
dump($newfiles);
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div class="flash-message-container"> </div>

  <?php include 'partials/navigation.php'; ?>
  <!--  -->
  <!-- <div class="" style="min-height: 100px;">
    <h1>copy from here</h1>
    <ul class="js-sortable-copy" aria-dropeffect="move">
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 1</li>
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 2</li>
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 3</li>
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 4</li>
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 5</li>
      <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 6</li>
    </ul>
  </div>
  <div class="" style="min-height: 100px;"><h1>Copy here</h1>
    <ul class="js-sortable-copy-target" style="min-height: 100px;" aria-dropeffect="move">
		</ul>
  </div> -->
  <div class="container">
    <div class="row">
      <div class="col s3">
        <h4>Bestanden</h4>
        <ul class="js-sortable-copy" aria-dropeffect="move">
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 1</li>
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 2</li>
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 3</li>
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 4</li>
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 5</li>
          <li class="p1 mb1 yellow bg-maroon item" style="position: relative; z-index: 10" draggable="true" role="option" aria-grabbed="false">Item 6</li>
        </ul>
      </div>
      <div class="col-s4">

      </div>
    </div>
  </div>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <?php include 'partials/scripts.html'; ?>

  <script src="dest/js/html5sortable.min.js" charset="utf-8"></script>
  <script src="dest/js/main.js" charset="utf-8"></script>
  <script src="dest/js/newDocument.js" charset="utf-8"></script>
  <script type="text/javascript">

  </script>
  </body>
  </html>
