<!-- All je external javascript files that must be used on all the pages -->
<!-- JQuery -->
<script type="text/javascript" src="dest/js/jquery.min.js"></script>
<!-- Materialize JS -->
<script type="text/javascript" src="dest/js/materialize.min.js"></script>
<script type="text/javascript" src="dest/js/mustache.js"></script>
<script type="text/javascript" src="dest/js/lazyload.js"></script>
<script src="dest/js/main.js" charset="utf-8"></script>
<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
?>
<script src="dest/js/<?=substr($currentPage, 0, -4);?>.js" charset="utf-8"></script>
