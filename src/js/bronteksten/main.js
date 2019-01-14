//reloads all the elements with the correct permssions
function reloadElements(){
  $.post("include/get/getPermissions.php",{
    ajax: true
  }, function(response,status){
    var perm = [];
    perm = JSON.parse(response);
    $.post("bronteksten.php",{
      ajax: true
    }, function(response,status){
      response = JSON.parse(response);

      for(var i = 0; i < perm.length; i++){
        for(var j = 0; j < response.length; j++){
          if(response[j].collegeId == perm[i].colleges_id && perm[i].edit == 1){
            response[j].perm = "perm";
          }
        }
      }

      //renders all the source files
      mustache(".sourcefiles-template", ".js-sourcefiles-container", response);

      //addes the edit buttons
      $(".card-action").each(function(){
        if($(this).hasClass("perm")){
          $(this) .html("")
                  .append('<a class="waves-effect waves-light btn js-open-edit">edit</a>')
                  .append('<a class="waves-effect waves-light btn js-delete-source">delete</a>')
                  .removeClass("perm");
          $(".js-open-edit").css("margin-right", "5px");
        };
      });
    });
  });
};
