$('body').on('click', '.js-activate-registerForm', function(){
  $('.js-login').addClass('login--disappear');
  $('.js-register').addClass('login--inline');
  setTimeout(function () {
    $('.js-login').attr('class', 'row login js-login');
    $('.js-register').addClass('login--appear');
  }, 200);
  setTimeout(function () {
    $('.js-register').attr('class', 'row login login--active js-register');
  }, 200);
});
$('body').on('click', '.js-activate-loginSub', function(){
  $('.js-register').addClass('login--disappear');
  $('.js-login').addClass('login--inline');
  setTimeout(function () {
    $('.js-register').attr('class', 'row login js-register');
    $('.js-login').addClass('login--appear');
  }, 200);
  setTimeout(function () {
    $('.js-login').attr('class', 'row login login--active js-login');
  }, 200);
});
