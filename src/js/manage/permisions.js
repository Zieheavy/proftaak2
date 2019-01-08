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

  $.post("include/delete/deletePermissions.php", {
    userId: userid
  },function(response,status){
    items.each(function(){
      var collegeId = $(this).data("collegeid");
      var read = $(this).find(".read").is(":checked") ? 1 : 0;
      var edit = $(this).find(".edit").is(":checked") ? 1 : 0;
      console.log("college " + collegeId + " read " + read + " edit " + edit);
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
  })
});
