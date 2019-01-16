<?php
include 'include/session.php';
// If the login fails it has get variables so it fills the inputs
$email = "";
$name = "";
if (isset($_GET['e'])) {
  $email = $_GET['e'];
}
if (isset($_GET['n'])) {
  $name = $_GET['n'];
}
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body class="indexPage">
  <?php include 'partials/navigation.php'; ?>

  <div class="row login js-login <?=($name == "" && $email == "") ? "login--active" : ""?> ">
    <form class="col s10 m6 l4 offset-l4 offset-m3 offset-s1" method="post" action="include/logIn.php">
      <div class="card login__card">
        <div class="card-title">Login</div>
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="text" data-type="2" class="validate" name="username">
            <label for="email">Gebruikersnaam</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label class="active" for="password">Wachtwoord</label>
          </div>
        </div>
        <div class="row login__btn-row">
          <div class="input-field col s12">
            <button class="btn waves-effect waves-light login__btn" type="submit" name="loginSub">Login</button>
          </div>
        </div>
        <div class="card-action">
          <a class="blue-text js-activate-registerForm" href="#">Of klik hier om te registreren</a>
        </div>
      </div>
    </form>
  </div>
  <div class="row login js-register <?=($name != "" || $email != "") ? "login--active" : ""?>">
    <form class="col s12 m8 l6 offset-l3 offset-m2 js-formsubmit" method="post" action="include/logIn.php">
      <div class="card login__card-register">
        <div class="card-title">Register</div>
        <div class="row">
          <div class="input-field col s12">
            <input id="username" type="text" data-type="2" value="<?=$name?>" class="validate js-name" name="username">
            <label for="username">Gebruikersnaam</label>
            <span class="helper-text js-name-helper" data-error="Gebruikernaam bestaat al" data-success=""></span>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="mail" type="email" value="<?=$email?>" class="validate js-mail" name="email">
            <label class="active" for="mail">email</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="pass" type="text" class="validate js-pass" name="password">
            <label class="active" for="pass">Wachtwoord</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password2" type="text" class="validate js-passR" name="password2">
            <label class="active" for="password2">Heraal wachtwoord</label>
          </div>
        </div>
        <div class="row btn-row">
          <div class="input-field col s6">
            <button class="btn waves-effect waves-light login-btn jsRegister" name="registerSub">Registreer</button>
          </div>
          <div class="col s6">
            <a class="js-activate-loginSub btn white black-text waves-effect waves-light" href="#">Terug</a>
          </div>
        </div>
      </div>
    </form>
  </div>

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.php'; ?>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
