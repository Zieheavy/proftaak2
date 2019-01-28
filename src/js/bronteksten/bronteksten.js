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
  var toastHTML =  '<span>Weet u zeker dat u een bron bestand wilt verwijderen'
      toastHTML += '</span><button class="btn-flat toast-action js-delete-sourcefile">yes</button>'
      toastHTML += '<button class="btn-flat toast-action js-toast-no">no</button>';
  if($('.js-toast-confirm').length <= 0){
    //displays confirm message
    M.toast({html: toastHTML, displayLength: 10000, classes:"js-toast-confirm"});
  }
  // confirmModal("Confirm", "Weet u zeker dat u een bron bestand wilt verwijderen", "js-delete-sourcefile");
});

$('body').on('click', '.js-toast-yes', function(){
  mergeFile();
  M.Toast.getInstance($(".js-toast-confirm")).dismiss();
});

//delete all the source files if possible
$('body').on('click', '.js-delete-sourcefile', function(){
  $('.js-confirm-modal').modal("close");
  $.post("include/delete/deleteSourceFile.php",{
    sourceid: fileId
  }, function(response,status){
    M.Toast.getInstance($(".js-toast-confirm")).dismiss();
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
