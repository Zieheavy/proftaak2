<?php
include 'include/get/getPermissions.php';

$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$active = -1;
$admin = -1;
$verified = $_SESSION["verified"];
$anyEditRights = false;
$createDocument = false;

//checks if you have permisons to verify a user or if you have permission to create a new college
if($_SESSION["newcollege"] == 1 || $_SESSION["confirm"] == 1){
  $admin = 1;
}

//checks a user is logged in
if($verified <= 0 && $_SESSION["loggedIn"] == 1){
  resetSession();
  header("Location: include/noPermissions.php");
}

//checks what the active page is
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

foreach ($permissions as $key => $permission) {
  if($permission["edit"] == 1){
    $anyEditRights = true;
    if($_SESSION["collegeId"] == $permission["colleges_id"]){
      $createDocument = true;
    }
  }
}

?>

<nav>
  <div class="nav-wrapper">
    <a href="#!" class="brand-logo"><img class="logo" src="img/logo-trans.png"></a>
    <?php if($active != -1){ ?>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger nav-btn"><i class="material-icons">menu</i></a>
      <ul class="hide-on-med-and-down">
        <div>
          <!-- displays the active page  -->
          <li class="<?php if($active == 1) echo "active"; ?>"><a href="home.php">Home</a></li>
          <?php if($anyEditRights == true){ ?>
            <li class="<?php if($active == 2) echo "active"; ?>"><a href="bronteksten.php">Bronteksten</a></li>
            <?php if($createDocument == true){ ?>
              <li class="<?php if($active == 3) echo "active"; ?>"><a href="nieuw-document.php">Nieuw Document</a></li>
            <?php } ?>
          <?php } ?>
          <!-- only displays the cms page if you have the correct privilages -->
          <?php if ($admin == 1) { ?>
            <li class="<?php if($active == 4) echo "active"; ?>"><a href="manage.php">Manage</a></li>
          <?php } ?>
        </div>
        <div>
          <form class="" action="include/login.php" method="post">
            <button type="submit" name="logoutSub" class=" logout-btn js-logout">Logout</button>
          </form>
        </div>
      </ul>

    <?php } ?>
  </div>
</nav>

<ul class="sidenav" id="mobile-demo">
  <li class="<?php if($active == 1) echo "active"; ?>"><a href="home.php">Home</a></li>
  <li class="<?php if($active == 2) echo "active"; ?>"><a href="bronteksten.php">Bronteksten</a></li>
  <li class="<?php if($active == 3) echo "active"; ?>"><a href="nieuw-document.php">Nieuw Document</a></li>
  <!-- only displays the cms page if you have the correct privilages -->
  <?php if ($admin == 1) { ?>
    <li class="<?php if($active == 4) echo "active"; ?>"><a href="manage.php">Manage</a></li>
  <?php } ?>
  <li>
    <form class="" action="include/login.php" method="post">
      <button type="submit" name="logoutSub" class=" logout-btn js-logout">Logout</button>
    </form>
  </li>
</ul>
