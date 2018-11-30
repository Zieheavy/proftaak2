$(document).ready(function() {
    M.updateTextFields();
  });
  $(document).ready(function(){
    $('.collapsible.expandable').collapsible({accordion: false});
  });
  $(document).ready(function(){
    $('.collapsible:not(.expandable)').collapsible();
  });
