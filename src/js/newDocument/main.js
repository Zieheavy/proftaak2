sortable('.js-sortable-copy', {
  forcePlaceholderSize: true,
  copy: true,
  acceptFrom: false,
  placeholderClass: 'fuuuuuck',
});
sortable('.js-sortable-copy-target', {
  forcePlaceholderSize: true,
  acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
  placeholderClass: 'file__placeholder',
});
$(sortable('.js-sortable-copy')).each(function(index, el) {
  sortable('.js-sortable-copy')[index].addEventListener('sortstop', function(e) {
    console.log("hello");
    var i = e.detail.item;
    $(i).addClass('file--dragged');
    $(i).find('.card--file').removeClass('card--file');
    M.updateTextFields();
  });
});
$(document).ready(function(){
  $('.collapsible.expandable').collapsible({accordion: false});
  $('.dropdown-trigger').dropdown();
});

$('body').on('click', '.file__title', function(){
  var file = $(this).closest('.file').data('name');
  $('.js-frm').attr('src', '_pdf/' + file + ".pdf");
});
$('body').on('click', '.js-delete-file', function(){
  $(this).closest('.file').remove();
});
