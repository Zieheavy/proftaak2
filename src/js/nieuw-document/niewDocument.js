$('body').on('click', '.file__title', function(){
  var elem = $(this).closest('.file');
  var file = $(elem).data('name');
  var version = $(elem).data('version');
  $('.js-frm').attr('src', '_pdf/' + file + "_" + version + ".pdf");
});

$('body').on('click', '.js-delete-file', function(){
  $(this).closest('.file').remove();
});
$(document).ready(function() {
  $('.js-version-getselect').formSelect();
});
