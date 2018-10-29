<?php
$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$active = -1;

switch ($currentPage) {
  case 'index.php':
  $active = 1;
    break;
  default:
  $active = -1;
    break;
}
?>

<nav>
  <div class="nav-wrapper">
    <a href="#!" class="brand-logo right">Logo</a>
    <ul class="left hide-on-med-and-down">
      <li class="<?php if($active == 1) echo "active"; ?>"><a href="">Home</a></li>
      <li class="<?php if($active == 2) echo "active"; ?>"><a href="">Components</a></li>
      <li class="<?php if($active == 3) echo "active"; ?>"><a href="">JavaScript</a></li>
    </ul>
  </div>
</nav>
