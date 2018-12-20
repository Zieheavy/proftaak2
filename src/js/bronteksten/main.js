function reloadElements(){
  $.post("include/get/getPermissions.php",{
    ajax: true
  }, function(response,status){
    var perm = [];
    perm = JSON.parse(response);
    console.log(perm);
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

      console.log(response);
      mustache(".sourcefiles-template", ".js-sourcefiles-container", response);

      $(".card-action").each(function(){
        if($(this).hasClass("perm")){
          $(this).html("");
          $(this).append('<a class="waves-effect waves-light btn js-open-edit">edit</a>');
          $(".js-open-edit").css("margin-right", "5px")
          $(this).append('<a class="waves-effect waves-light btn js-delete-source">delete</a>');
          $(this).removeClass("perm");
        };
      })
    });
});
}
