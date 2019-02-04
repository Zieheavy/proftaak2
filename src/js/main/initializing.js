// Some standard MAterialize inits
$(document).ready(function() {
  M.updateTextFields();
  $('.collapsible.expandable').collapsible({accordion: false});
  $('.collapsible:not(.expandable)').collapsible();
  $('.modal').modal();
  $('.fixed-action-btn').floatingActionButton({hoverEnabled: false});
  $('.sidenav').sidenav();
});
