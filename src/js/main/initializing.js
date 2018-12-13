$(document).ready(function() {
  M.updateTextFields();
  $('.collapsible.expandable').collapsible({accordion: false});
  $('.collapsible:not(.expandable)').collapsible();
  $('select').formSelect();
});
// $(document).ready(function(){
//   $('.collapsible.expandable').collapsible({accordion: false});
// });
// $(document).ready(function(){
//   $('.collapsible:not(.expandable)').collapsible();
// });
// $(document).ready(function(){
//   $('select').formSelect();
// });
