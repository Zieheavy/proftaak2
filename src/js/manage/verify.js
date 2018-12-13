$('body').on("click", ".js-btn-verifiy", function(){
  var container = $(this).closest(".card");
  var usersId = container.data("id");
  var colleges = container.find(".js-college-select").val();
  var courses = container.find(".js-courseContainer-"+usersId).val();

  $.post("include/update/updateUser_verify.php",{
    id: usersId,
    college: colleges,
    course: courses
  }, function(response,status){
    console.log(response)
    if(response == "succes"){
    M.toast({html: "Gebruiker is succesvol geverifierd", classes: "toast--succes"});
      container.find(".card-action").remove();
    }
  });
})
