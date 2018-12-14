$('body').on("change paste keyup", ".js-mergedName" , function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 1);
  $(this).val(search);
});

var fileNames = [];
var fileExtensions = [];
var fileVersions = [];
var pageNumbers = [];
var permissions = [];
var session = [];
var mergeName = "";
var nameExists = false;
$('body').on('click', '.js-merge', function(){
  mergeName = $(".js-mergedName").val();
  $('.file--dragged').each(function(){
    fileNames.push($(this).data("name"));
    fileExtensions.push($(this).data("ext"));
    fileVersions.push($(this).data("version"));
    var pageVal = $(this).find(".js-pages").val();
    if(pageVal == ""){
      pageVal = "all";
    }
    pageNumbers.push(pageVal);
  });
  console.log("fileNames: ", fileNames);
  console.log("fileVersions: ", fileVersions);
  console.log("pageNumbers: ", pageNumbers);

  $.post("include/get/getSession.php",{
    ajax: true
  },function(response,status){
    session = JSON.parse(response);
    console.log(session);

    $.post("include/get/getPermissions.php",{
      ajax: true
    },function(response,status){
      permissions = JSON.parse(response);
      console.log(permissions);

      $.post("include/get/getMergedFiles.php",{ },function(response,status){
        response = JSON.parse(response);
        console.log(response);

        for (var i = 0; i < response.length; i++) {
          if(mergeName == response[i].name){
            nameExists = true;
            if(response[i].colleges_id == session.collegeId && response[i].courses_id == session.courseId){
              for (var j = 0; j < permissions.length; j++) {
                if(response[i].colleges_id == permissions[j].colleges_id){
                  console.log(permissions[j])
                  if(permissions[j].edit == 1){
                    console.log("new version");
                    var toastHTML =  '<span>De naam van het bestand dat u probeert te creeren bestaat al <br>'
                        toastHTML += 'wilt u een nieuwe versie uploaden <br>'
                        toastHTML += '</span><button class="btn-flat toast-action js-toast-yes">yes</button>'
                        toastHTML += '<button class="btn-flat toast-action js-toast-no">no</button>';
                    M.toast({html: toastHTML, displayLength: 99999});
                  }else{
                    console.log("no permission for new version")
                  }
                }
              }
            }
            else{
              console.log("de naam is in gebruik door een andere college, om verder te geaan hernoem uw bestand")
            }
          }
        }

        if(nameExists == false){
          mergeFile();
        }
      });
    });
  });
});

$('body').on('click', '.js-toast-yes', function(){
  mergeFile();
  M.Toast.dismissAll();
});
$('body').on('click', '.js-toast-no', function(){
  M.Toast.dismissAll();
});

function mergeFile(){
  console.log("merge");
  $.post("include/pdf/pdfMerge.php",{
    files: fileNames,
    pages: pageNumbers,
    mergeName: mergeName,
    pageExt: fileExtensions,
    fileVersions: fileVersions
  },function(response,status){
    console.log(response);
    if(response == ""){
      M.toast({html: 'Succes', classes: 'toast--succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  });
}
