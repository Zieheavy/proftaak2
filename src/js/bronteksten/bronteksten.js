colleges = [];
var fileId = -1;

//gets all the colleges and removes the college none
$.post("include/get/getColleges.php",{
  ajax: true
}, function(response,status){
  colleges = JSON.parse(response);
  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id != 1){
      colleges[i].courses.unshift({colleges_id: 1, id: 1, name: "none"});
    }
  }
});

//checks if the college dropdown has changed if so update the coruse dropdown
$('body').on('change', '.js-college-select', function(){
  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id == $(this).val()){
      mustache(".courses-manage-template", ".js-courseContainer", colleges[i].courses);
      $('select').formSelect();
    }
  }
});

//shows a confirm modal to check if the user is sure
$('body').on('click', '.js-delete-source', function(){
  fileId = $(this).closest(".js-source-files").data("id");
  confirmModal("Confirm", "Weet u zeker dat u een bron bestand wilt verwijderen", "js-delete-sourcefile");
});

//delete all the source files if possible
$('body').on('click', '.js-delete-sourcefile', function(){
  $('.js-confirm-modal').modal("close");
  $.post("include/delete/deleteSourceFile.php",{
    sourceid: fileId
  }, function(response,status){
    if(response == "succes"){
      M.toast({ html: "bestand is succesvol verwijderd",
                classes: "toast--succes"});
      reloadElements();
    }else{
      M.toast({ html: "het bestand kan niet worden verwijderd <br> het bestand wordt gebruikt in een studiegids",
                classes: "toast--error"});
    }
  });
});
