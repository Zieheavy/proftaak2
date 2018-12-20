colleges = [];
$.post("include/get/getColleges.php",{
  ajax: true
}, function(response,status){
  colleges = JSON.parse(response);
  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id != 1){
      colleges[i].courses.unshift({colleges_id: 1, id: 1, name: "none"})
    }
  }
});

$('body').on('change', '.js-college-select', function(){
  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id == $(this).val()){
      mustache(".courses-manage-template", ".js-courseContainer", colleges[i].courses);
      $('select').formSelect();
    }
  }
});

var fileId = -1;
$('body').on('click', '.js-delete-source', function(){
  fileId = $(this).closest(".js-source-files").data("id");
  console.log($(this).closest(".js-source-files"));
  confirmModal("Confirm", "Weet u zeker dat u een bron bestand wilt verwijderen", "js-delete-sourcefile")
})

$('body').on('click', '.js-delete-sourcefile', function(){


  $('.js-confirm-modal').modal("close");
  $.post("include/delete/deleteSourceFile.php",{
    sourceid: fileId
  }, function(response,status){
    console.log(response);
    if(response == "succes"){
      M.toast({html: "bestand is succesvol verwijderd", classes: "toast--succes"});
      reloadElements();
    }else{
      M.toast({html: "het bestand kan niet worden verwijderd <br> het bestand wordt gebruikt in een studiegids", classes: "toast--error"});
    }
  });
})
