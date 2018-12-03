// If the "register" button is clicked the form changes from login to register
$('body').on('click', '.js-activate-registerForm', function(){
  $('.js-login').addClass('login--disappear');
  $('.js-register').addClass('login--inline');
  setTimeout(function () {
    $('.js-login').attr('class', 'row login js-login');
    $('.js-register').addClass('login--appear');
    setTimeout(function () {
      $('.js-register').attr('class', 'row login login--active js-register');
    }, 200);
  }, 200);
});
// other way around
$('body').on('click', '.js-activate-loginSub', function(){
  $('.js-register').addClass('login--disappear');
  $('.js-login').addClass('login--inline');
  setTimeout(function () {
    $('.js-register').attr('class', 'row login js-register');
    $('.js-login').addClass('login--appear');
    setTimeout(function () {
      $('.js-login').attr('class', 'row login login--active js-login');
    }, 200);
  }, 200);
});

$(".validate").on("change paste keyup", function(){
  if($(this).data("type") == 2){
    var search = $(this).val();
    search = filter(search, 2);
    $(this).val(search);
  }
})

// $("body").on("click", ".jsRegister", function(){
//   var name = $(".js-name").val();
//   var mail = $(".js-mail").val();
//   var pass = $(".js-pass").val();
//   var passR = $(".js-passR").val();
//
//   if(name.length < 5){
//     toast("gebruikers naam moet langer zijn dan 4 characters");
//     return;
//   }
//
//   if(!validateEmail(mail)){
//     toast("email is niet correct");
//     return;
//   }
//
//   if(pass != passR){
//     toast("wachtwoorden niet gelijk") ;
//     return;
//   }
//
//   if(pass.length < 7){
//     toast("wachtwoord moet langer zijn dan 6 characters");
//     return;
//   }
//
//   switch(checkStringUpper(pass)){
//     case 1:
//       toast("wachtwoord heeft geen hoofdletter en geen nummers");
//       return;
//     break;
//     case 2:
//       toast("wachtwoord heeft geen hoofdletter");
//       return;
//     break;
//     case 3:
//       toast("wachtwoord heeft geen nummers");
//       return;
//     break;
//     case 4:
//       toast("wachtwoord heeft geen normale letter");
//       return;
//     break;
//   }
//
//
//   $.post("include/logIn.php",{
//     registerSub: true,
//     name: name,
//     mail: mail,
//     pass: pass
//   }, function(response,status){
//     console.log(response);
//   });
// })
// function toast(messgae){
//   M.toast({html: messgae, classes: "toast--error", displayLength: 2000});
// }
// function validateEmail(email) {
//   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//   return re.test(email);
// }
// function checkStringUpper(string){
//   var num = false;
//   var upper = false;
//   var letter = false;
//   var i = 0;
//   while (i <= string.length){
//     character = string.charAt(i);
//     if (!isNaN(character * 1)){
//       num = true;
//     }else{
//       if (character == character.toUpperCase()) {
//         upper = true;
//       }else{
//         letter = true;
//       }
//     }
//     i++;
//   }
//   if(num == true && upper == true && letter == true){
//     return 99;
//   }else if(num == false && upper == false && letter == false){
//     return 1;
//   }else if(upper == false){
//     return 2;
//   }else if(num == false){
//     return 3;
//   }else if(letter == false){
//     return 4;
//   }
// }
