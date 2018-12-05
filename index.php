<?php
include 'include/session.php';
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body class="indexPage">
  <?php include 'partials/navigation.php'; ?>

  <div class="row login js-login login--active">
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
  <div class="row login js-register">
    <form class="col s12 m8 l6 offset-l3 offset-m2" method="post" action="include/logIn.php">
      <div class="card login__card-register">
        <div class="card-title">Register</div>
        <div class="row">
          <div class="input-field col s12">
            <input id="name" type="text" data-type="2" class="validate js-name" name="name">
            <label for="name">Gebruikersnaam</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="mail" type="email" class="validate js-mail" name="mail">
            <label class="active" for="mail">email</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="pass" type="password" class="validate js-pass" name="pass">
            <label class="active" for="pass">Wachtwoord</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="repeatPass" type="password" class="validate js-passR" name="repeatPass">
            <label class="active" for="repeatPass">Heraal wachtwoord</label>
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
  <?php include 'partials/modals.html'; ?>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
