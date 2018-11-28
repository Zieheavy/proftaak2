$(document).ready(function(){
  console.log("index loaded2");
  if(getUrlParameter("stat") == 1){
    M.toast({html: 'Gebruikernaam of Wachtwoord is incorrect', classes: "error", displayLength: 2000});
  }
});
