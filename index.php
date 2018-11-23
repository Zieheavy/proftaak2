<?php include 'include/functions.php';
session_start();
  // dump($_SESSION)
 ?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div class="flash-message-container"> </div>

  <?php include 'partials/navigation.php'; ?>

  <div class="row login js-login login--active">
    <form class="col s12" method="post" action="include/logIn.php">
      <div class="card login-card">
        <div class="card-title">Login</div>
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="text" class="validate" name="username">
            <label for="email">Gebruikersnaam</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label class="active" for="password">Wachtwoord</label>
          </div>
        </div>
        <div class="row btn-row">
          <div class="input-field col s12">
            <button class="btn waves-effect waves-light login-btn" type="submit" name="loginSub">Login</button>
          </div>
        </div>
        <div class="card-action">
          <a class="blue-text js-activate-registerForm" href="#">Of klik hier om te registreren</a>
        </div>
      </div>
    </form>
  </div>
  <div class="row login js-register">
    <form class="col s12" method="post" action="include/logIn.php">
      <div class="card login-card">
        <div class="card-title">Login</div>
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="text" class="validate" name="username">
            <label for="email">Gebruikersnaam</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label class="active" for="password">Wachtwoord</label>
          </div>
        </div>
        <div class="row btn-row">
          <div class="input-field col s6">
            <button class="btn waves-effect waves-light login-btn" type="submit" name="loginSub">Login</button>
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

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
