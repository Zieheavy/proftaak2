$('body').on('click', '.js-delete-merged', function(){
  $.post("include/delete/deleteMerged.php",{
  }, function(response,status){
    console.log(response);
  });
});
