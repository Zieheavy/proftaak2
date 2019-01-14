//this will create a new college and then it will render the list of colleges again
$('body').on('click', '.js-new-college', function(){
  $("#newCollege").modal("close");
  var name = $(".js-college-input").val();
  $.post("include/insert/newCollege.php",{
    name: name
  }, function(response,status){
    if(response == "succes"){
      M.toast({html: "Nieuw college succesvol aangemaakt", classes: "toast--succes"});
      $.post("include/get/getColleges.php",{
        ajax: true
      }, function(response,status){
        response = JSON.parse(response);
        mustache(".courses-manage-template", ".js-new-cource-collegeId", response);
        $('select').formSelect();
      });
    }else{
      M.toast({ html: "Er is iets fout gegaan bij het aanmaken van een nieuw college",
                classes: "toast--error"});
    }
  });
});

//this will insert a new course in the choosen college
$('body').on('click', '.js-new-course', function(){
  $("#newCourse").modal("close");
  var name = $(".js-course-input").val();
  var collegeId = $(".js-new-cource-collegeId").val();
  $.post("include/insert/newCourse.php",{
    name: name,
    collegeId: collegeId
  }, function(response,status){
    if(response == "succes"){
      M.toast({ html: "Nieuwe opleiding succesvol aangemaakt",
                classes: "toast--succes"});
    }else{
      M.toast({ html: "Er is iets fout gegaan bij het aanmaken van een nieuw opleiding",
                classes: "toast--error"});
    }
  });
});
