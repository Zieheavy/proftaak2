$(document).ready(function(){
  console.log("index loaded2");
  if(getUrlParameter("s") == 1){
    M.toast({html: 'Gebruikernaam of Wachtwoord is incorrect', classes: "toast--error", displayLength: 2000});
  }
  if(getUrlParameter("s") == 2){
    M.toast({html: 'U bent succesvol uitgelogd', classes: "toast--succes", displayLength: 2000});
  }
  addUrlParameter(["th"],["1000000000"]);
  // removeUrlParameter("hal");
});
