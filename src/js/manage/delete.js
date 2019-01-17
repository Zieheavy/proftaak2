//this will try to delete a college from the database if not succesvol a error message will be displayed
$('body').on('click', '.js-delete-college', function(){
  $("#deleteCollege").modal("close");
  var collegeId = $(".js-delete-college-collegeId").val();
  $.post("include/delete/deleteCollege.php",{
    collegeId: collegeId
  }, function(response,status){
    if(response == "succes"){
      M.toast({ html: "Opleiding succesvol verwijderd",
                classes: "toast--succes"});
    }else{
      M.toast({ html: "Er is iets fout gegaan bij het verwijderen van een nieuw opleiding",
                classes: "toast--error"});
    }
  });
})

//this will try delete a course if it failes it will display a error message
$('body').on('click', '.js-delete-course', function(){
  $("#deleteCourse").modal("close");
  var courseId = $(".js-delete-course-courseId").val();
  $.post("include/delete/deleteCourse.php",{
    courseId: courseId
  }, function(response,status){
    if(response == "succes"){
      M.toast({ html: "Opleiding succesvol verwijderd",
                classes: "toast--succes"});
    }else{
      M.toast({ html: "Er is iets fout gegaan bij het verwijderen van een nieuw opleiding",
                classes: "toast--error"});
    }
  });
})


$('body').on("click", ".js-delete-user", function(){
  var cardContainer = $(this).closest(".card");
  var userid = cardContainer.data("id");

  //first all the old college permission will be deleted
  $.post("include/delete/deleteUser.php", {
    userId: userid
  },function(response,status){
    console.log(response);
  });
});
