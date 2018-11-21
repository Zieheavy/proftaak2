<?php
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

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
