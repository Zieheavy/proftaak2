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

  <div class="row">
    <form class="col s12" method="post" action="include/logIn.php">
      <div class="card login-card">
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="text" class="validate" name="username">
            <label for="Gebruikersnaam">Gebruikersnaam</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label for="Wachtwoord">Wachtwoord</label>
          </div>
        </div>
        <!-- <div class="row">
          <div class="input-field col s12">
            <input id="userlevel" type="text" class="validate" name="userLevel">
            <label for="userlevel">Wachtwoord</label>
          </div>
        </div> -->
        <div class="row btn-row">
          <div class="input-field col s12">
            <button class="btn waves-effect waves-light login-btn" type="submit" name="loginSub">Login</button>
            <!-- <button class="btn waves-effect waves-light" type="submit" name="registerSub">Register</button> -->
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
