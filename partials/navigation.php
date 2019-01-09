<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$active = -1;
$admin = -1;
$verified = $_SESSION["verified"];

// dump($_SESSION, "");

if($_SESSION["newcollege"] == 1 || $_SESSION["confirm"] == 1){
  $admin = 1;
}

if($verified <= 0 && $_SESSION["loggedIn"] == 1){
  resetSession();
  header("Location: include/noPermissions.php");
}

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
  case 'manage.php':
    $active = 4;
    break;
  case 'no.php':
    $active = 99;
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
        <?php if ($admin == 1) { ?>
          <li class="<?php if($active == 4) echo "active"; ?>"><a href="manage.php">Manage</a></li>
        <?php } ?>
      </ul>
      <form class="" action="include/login.php" method="post">
        <button type="submit" name="logoutSub" class="btn waves-effect waves-light right js-logout" style="display:none;">Logout</button>
      </form>
    <?php } ?>
  </div>
</nav>
