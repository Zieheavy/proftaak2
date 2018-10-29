<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div class="flash-message-container"> </div>

  <!-- <?php include 'partials/navigation.php'; ?> -->

  <div class="row">
    <form class="col s12" method="post" action="include/logIn.php">
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
      <div class="row">
        <button class="btn waves-effect waves-light" type="submit" name="loginSub">Login</button>
      </div>
    </form>
  </div>

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
