$('body').on('click', '.js-delete-merged', function(){
  $.post("include/deleteMerged.php",{
  }, function(response,status){
    console.log(response);
  });
});
