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
        var html = "";
        html += '<div class="row">';
        html += '  <div class="col s6">';
        html += '    <a class="waves-effect waves-light btn js-open-edit w100">edit</a>';
        html += '  </div>';
        html += '  <div class="col s6">';
        html += '    <a class="waves-effect waves-light btn js-delete-source w100">delete</a>';
        html += '  </div>';
        html += '</div>';
        if($(this).hasClass("perm")){
          $(this) .html(html)
                  .removeClass("perm");
          $(".js-open-edit").css("margin-right", "5px");
        };
      });
    });
  });
};
