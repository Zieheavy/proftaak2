<?php
include 'include/database.php';
include 'include/functions.php';
$files = [];
$sql = "SELECT * FROM sourcefiles";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $files[] = $row;
}
$stmt->close();
dump($files);
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
  <div class="" style="min-height: 100px;">
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
  </div>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <?php include 'partials/scripts.html'; ?>

  <script src="dest/js/html5sortable.min.js" charset="utf-8"></script>
  <script src="dest/js/main.js" charset="utf-8"></script>
  <script type="text/javascript">
    sortable('.js-sortable-copy', {
      forcePlaceholderSize: true,
      copy: true,
  		acceptFrom: false,
  	  placeholderClass: 'fuuuuuck',
  	});
  	sortable('.js-sortable-copy-target', {
  	  forcePlaceholderSize: true,
  		acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
  	  placeholderClass: 'fuuuuuck',
    });
  </script>
  </body>
  </html>
