<!-- All je external javascript files that must be used on all the pages -->
<!-- JQuery -->
<script type="text/javascript" src="dest/js/jquery.min.js"></script>
<!-- Materialize JS -->
<script type="text/javascript" src="dest/js/materialize.min.js"></script>
<script type="text/javascript" src="dest/js/mustache.js"></script>
<script src="dest/js/main.js" charset="utf-8"></script>
<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
switch ($currentPage) {
  case 'home.php':
  $active = 1;
  break;
  case 'bronteksten.php':
  $active = 2;
  break;
  case 'nieuw-document.php':
  $active = 3;
  break;
  default:
  $active = -1;
  break;
}
?>
<script src="dest/js/<?=substr($currentPage, 0, -4);?>.js" charset="utf-8"></script>
