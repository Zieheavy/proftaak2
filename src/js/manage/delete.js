$('body').on('click', '.js-delete-college', function(){
  $("#deleteCollege").modal("close");
  var collegeId = $(".js-delete-college-collegeId").val();
  $.post("include/delete/deleteCollege.php",{
    collegeId: collegeId
  }, function(response,status){
    console.log(response);
    if(response == "succes"){
      M.toast({html: "Opleiding succesvol verwijderd", classes: "toast--succes"});
    }else{
      M.toast({html: "Er is iets fout gegaan bij het verwijderen van een nieuw opleiding", classes: "toast--error"});
    }
  });
})


$('body').on('click', '.js-delete-course', function(){
  $("#deleteCourse").modal("close");
  var courseId = $(".js-delete-course-courseId").val();
  $.post("include/delete/deleteCourse.php",{
    courseId: courseId
  }, function(response,status){
    console.log(response);
    if(response == "succes"){
      M.toast({html: "Opleiding succesvol verwijderd", classes: "toast--succes"});
    }else{
      M.toast({html: "Er is iets fout gegaan bij het verwijderen van een nieuw opleiding", classes: "toast--error"});
    }
  });
})
