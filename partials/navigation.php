<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$active = -1;

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

<nav>
  <div class="nav-wrapper">
    <a href="#!" class="brand-logo right"><img class="logo" src="img/logo-trans.png"></a>
    <?php if($active != -1){ ?>
      <ul class="hide-on-med-and-down">
        <li class="<?php if($active == 1) echo "active"; ?>"><a href="home.php">Home</a></li>
        <li class="<?php if($active == 2) echo "active"; ?>"><a href="bronteksten.php">Bronteksten</a></li>
        <li class="<?php if($active == 3) echo "active"; ?>"><a href="nieuw-document.php">Nieuw Document</a></li>
      </ul>
    <a href="#!" class="btn waves-effect waves-light right js-logout">Loguot </a>
    <?php } ?>
  </div>
</nav>
