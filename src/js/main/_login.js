$(document).ready(function(){
  var session = [];
  var loggedIn = false;

  //gets the information stored in the session
  $.post("include/session.php",{
    return: true
  },function(response,status){
    console.log(response);
    session = JSON.parse(response);

    //checks if there is a user in the session if so log the user in
    if(session.loggedIn == 1){
      login();
    }else{
      logout();
    }
  }); 

  $("body").on("click",".login",function(){
    //checks if username and password are not blank
    if($(".username").val() != "" && $(".password").val() != ""){
      //submits the login information to php
      $.post( "include/login.php", {
        loginSub: true,
        username: $(".username").val(),
        password: $(".password").val()
      }, function(response,status){
        //checks if php was succesful with inloggen
        if(response == "succes"){
          showFlashMessage("User succesfully logged in","success");
          login();
        }else{
          showFlashMessage("Username or Password is not correct","danger");
        }
      })
    }else{
      showFlashMessage("Inputs can not be left empty","danger");
    }
  })

  $("body").on("click",".logout",function(){
    //logs the user out
    $.post("include/login.php",{
      logoutSub: true
    },function(response,status){
      // console.log(response)
      if(response == "succes"){
        logout();
      }else{
      }
    })
  })

  $("body").on("click", ".register", function(){
    //checks if username and password are not left empty
    if($(".username").val() != "" && $(".password").val() != ""){
      //inserts username and password to the database
      $.post("include/login.php",{
        registerSub: true,
        username: $(".username").val(),
        password: $(".password").val()
      },function(response,status){
        if(response == "succes"){

          //after new user is regestired it will be automaticaly loggedin
          $.post( "include/login.php", {
            loginSub: true,
            username: $(".username").val(),
            password: $(".password").val()
          }, function(response,status){
              login();
          })

          showFlashMessage("User Succesfully registered","success");
        }else{
          //checks if the user already exists
          if(response != "userExists"){
            showFlashMessage("Password or username can not be blank","danger");
          }else{
            showFlashMessage("Users already exists","danger")
          }
        }
      })
    }else{
      showFlashMessage("Inputs can not be left empty","danger")
    }
  })

  //checks if any buttons are pressed in the login-container
  $(".login-container").keypress(function (e) {
    //checks if the pressed key is enter
    if (e.which == 13) {
      //checks if there is already a user loggedin
      if (!loggedIn) {
        $('.login').trigger('click');
      }
    }
  });

  function login(){
    $(".logout").show();
    $(".login-container").hide();
    loggedIn = true;

    //checks if there is a user loggedin in the session
    //if there is no user update the local session variable
    if($(".username").val() != ""){
      session.loggedIn = 1;
      session.username = $(".username").val();
      session.password = $(".password").val();
    }
  }

  function logout(){
    $(".logout").hide();
    $(".login-container").show();
    loggedIn = false;
    $(".webShop").hide();
    $(".shopController").hide();
  }
});
