var fileNames = [];
var fileExtensions = [];
var fileVersions = [];
var pageNumbers = [];
var permissions = [];
var session = [];
var mergeName = "";
var nameExists = false;
var loaderMessage = "";

//checks the input of the file name and removes all characters that are not allouwd
$('body').on("change paste keyup", ".js-mergedName" , function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 1);
  $(this).val(search);
});

//checks the input of the page numbers and removes all characters that are not allouwd
$('body').on("change paste keyup", ".js-pages", function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 3);
  $(this).val(search);
})

//starts the merging process
$('body').on('click', '.js-merge', function(){
  //displays a loading message
  loaderMessage = setTimeout(function(){
    M.toast({html: "Bestanden worden omgezet&nbsp;"  + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
  }, 500);
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

  //gets the session information
  $.post("include/session.php",{
    return: true
  },function(response,status){
    session = JSON.parse(response);

    //gets the users permissions
    $.post("include/get/getPermissions.php",{
      ajax: true
    },function(response,status){
      permissions = JSON.parse(response);

      //gets all the merged files
      $.post("include/get/getMergedFiles.php",{ },function(response,status){
        response = JSON.parse(response);
        var niewVersion = false;

        for (var i = 0; i < response.length; i++) {
          if(mergeName == response[i].name){
            nameExists = true;
            if(response[i].colleges_id == session.collegeId && response[i].courses_id == session.courseId || session.admin == 1){
              for (var j = 0; j < permissions.length; j++) {
                if(response[i].colleges_id == permissions[j].colleges_id){
                  if(permissions[j].edit == 1){
                    var toastHTML =  '<span>De naam van het bestand dat u probeert te creeren bestaat al <br>'
                        toastHTML += 'wilt u een nieuwe versie uploaden <br>'
                        toastHTML += '</span><button class="btn-flat toast-action js-toast-yes">yes</button>'
                        toastHTML += '<button class="btn-flat toast-action js-toast-no">no</button>';
                    clearTimeout(loaderMessage);
                    if($(".js-toast-warning").length <= 0){
                      M.toast({html: "Bestanden worden omgezet&nbsp;"  + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
                    }
                    M.toast({html: toastHTML, displayLength: 10000, classes:"js-toast-confirm"});
                  }else{
                    M.toast({html: "U heeft geen rechten om nieuwe versies te maken"});
                  }
                }
              }
            }
            else{
              M.toast({html: "De naam die u heeft opgegeven is al ingebruik <br>Hernoem u bestand en probeer het opnieuw"});
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
  M.Toast.getInstance($(".js-toast-confirm")).dismiss();
});
$('body').on('click', '.js-toast-no', function(){
    M.Toast.getInstance($(".js-toast-confirm")).dismiss();
    clearTimeout(loaderMessage);
  if($(".js-toast-warning").length > 0){
    M.Toast.getInstance($(".js-toast-warning")).dismiss()
  }
});

//sends the post request to php to start the mergin process
function mergeFile(){
  $.post("include/pdf/pdfMerge.php",{
    files: fileNames,
    pages: pageNumbers,
    mergeName: mergeName,
    pageExt: fileExtensions,
    fileVersions: fileVersions
  },function(response,status){
    if(response == ""){
      clearTimeout(loaderMessage);
      if($(".js-toast-warning").length > 0){
        M.Toast.getInstance($(".js-toast-warning")).dismiss()
      }
      M.toast({html: 'Succes', classes: 'toast--succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  });
}
