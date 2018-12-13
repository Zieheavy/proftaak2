$(document).ready(function(){
  var message = "";
  var type = "";

  var param = getUrlParameter("s");
  //gets the correct error message returned from include/login.php
  if(param >= 0){
    switch (param) {
      case "1":
      message = 'Gebruikernaam of Wachtwoord is incorrect';
      type = 'toast--error';
      break;
      case "2":
      console.log("2 2 2")
      message = 'U bent succesvol uitgelogd';
      type = 'toast--succes';
      break;
      case "3":
      message = 'Gebruiker bestaat al';
      type = 'toast--succes';
      break;
    }
    M.toast({html: message, classes: type, displayLength: 2000});
    removeUrlParameter("s");
  }
});
