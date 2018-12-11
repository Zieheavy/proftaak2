$(document).ready(function(){
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
    console.log(colleges);
  });

  $('body').on('change', '.js-college-select', function(){
    var id = $(this).closest(".card").data("id")
    var courseContainer = ".js-courseContainer-" + id;

    for(var i = 0; i < colleges.length; i++){
      if(colleges[i].id == $(this).val()){
        mustache(".courses-manage-template", courseContainer, colleges[i].courses);
        $('select').formSelect();
      }
    }
  })

  $('body').on("click", ".js-btn-verifiy", function(){
    var container = $(this).closest(".card");
    var usersId = container.data("id");
    var colleges = container.find(".js-college-select").val();
    var courses = container.find(".js-courseContainer-"+usersId).val();

    console.log("col " + colleges + " cour " + courses);


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

  $('body').on("click", ".js-perm-update", function(){
    var cardContainer = $(this).closest(".card");
    var permContainer = cardContainer.find(".js-perm-container");
    var items = permContainer.find(".js-perm-rows");
    var succesMaxCount = items.length + 1;
    var succesCount = 0;
    var userid = cardContainer.data("id");
    var newcollege = cardContainer.find(".js-new").is(":checked") ? 1 : 0;
    var comfirm = cardContainer.find(".js-confirm").is(":checked") ? 1 : 0;
    var admin = cardContainer.find(".js-admin").is(":checked") ? 1 : 0;

    console.log(".." + newcollege + comfirm + admin + "..")
    $.post("include/update/updateUser_perm.php",{
      id: userid,
      newcollege: newcollege,
      comfirm: comfirm,
      admin: admin
    }, function(response,status){
      console.log(response)
      if(response == "succes"){
        succesCount++;
      }
    })

    items.each(function(){
      var collegeId = $(this).data("collegeid");
      var read = $(this).find(".read").is(":checked") ? 1 : 0;
      var edit = $(this).find(".edit").is(":checked") ? 1 : 0;
      $.post("include/insert/insertPermissions.php",{
        userid: userid,
        collegeId: collegeId,
        read: read,
        edit: edit
      }, function(response,status){
        console.log(response)
        if(response == "success"){
          succesCount++;
          if(succesCount == succesMaxCount){
            M.toast({html: "Permissions van " + cardContainer.data("name") + " succesvol geupdate", classes: "toast--succes"});
          }
        }
      });
    })
  });
});
