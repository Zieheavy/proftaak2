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
        message = 'U bent succesvol uitgelogd';
        type = 'toast--succes';
        break;
      case "3":
        message = 'Gebruiker bestaat al';
        type = 'toast--succes';
        break;
      case "4":
        message = 'U heeft geen rechten voor de pagina die u probeert te bereiken <br> u bent uitgelogd';
        type = 'toast--error';
        break;
      case "5":
        message = 'U heeft geen rechten voor de pagina die u probeert te bereiken';
        type = 'toast--error';
        break;
      case "6":
        message = 'De 2 wachtwoorden moeten hetzelfde zijn';
        type = 'toast--error';
        break;
      case "7":
        message = 'De gebruikersnaam moet langer dan 4 tekens zijn';
        type = 'toast--error';
        break;
      case "8":
        message = 'Het wachtwoordmoet langer dan 6 tekens zijn';
        type = 'toast--error';
        break;
      default:
        message = 'default message';
        type = 'toast--info';
        break;
    }
    M.toast({html: message, classes: type, displayLength: 2000});
    removeUrlParameter("s");
    removeUrlParameter("e");
    removeUrlParameter("n");
  }
});
