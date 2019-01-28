var fileNames = [];
var fileExtensions = [];
var fileVersions = [];
var pageNumbers = [];
var permissions = [];
var session = [];
var mergeName = "";
var nameExists = false;
var loaderMessage = "";
// var updateFile = false;

$(document).ready(function(){
  if($(".container").data("update") == true){
    $(".container").removeAttr("data-update");
    updateFile = true;
  }
})

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
  if(loaderMessage <= 0){
    loaderMessage = setTimeout(function(){
      M.toast({html: "Bestanden worden omgezet&nbsp;"  + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
    }, 500);
  }
  var temp = false;
  $(".js-mergedName").each(function(){
    if($(this).val() != ""){
      temp = true;
      mergeName = $(this).val();
    }
  })
  if(temp == false){
    mergeName = "";
  }
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
        mergedFiles = response;
        var niewVersion = false;
        var m_permissions = false;

        //checks if atleast one file is chosen
        if($(".file--dragged").length > 0){
          for (var i = 0; i < mergedFiles.length; i++) {
            //checks if the file exists
            if(mergeName == response[i].name){
              nameExists = true;
              for(var j = 0; j < permissions.length; j++){
                //checks if you have permissions to edit the file
                if(permissions[j].colleges_id == response[i].colleges_id){
                  if(permissions[j].edit == 1){
                    m_permissions = true;
                    var toastHTML =  '<span>De naam van het bestand dat u probeert te creeren bestaat al <br>'
                        toastHTML += 'wilt u een nieuwe versie uploaden <br>'
                        toastHTML += '</span><button class="btn-flat toast-action js-toast-yes">yes</button>'
                        toastHTML += '<button class="btn-flat toast-action js-toast-no">no</button>';
                    if($('.js-toast-confirm').length <= 0){
                      //displays confirm message
                      M.toast({html: toastHTML, displayLength: 10000, classes:"js-toast-confirm"});
                    }
                  }
                }
              }
              if(m_permissions == false){
                M.toast({html: "U heeft geen rechten om nieuwe versies te maken", classes:"toast--error"});
                timeOutClear();
              }
            }
          }
          //if no existing files exist, create new file
          if(nameExists == false){
            for(var j = 0; j < permissions.length; j++){
              if(session.collegeId == permissions[j].colleges_id){
                if(permissions[j].edit == 1){
                  mergeFile();
                }
              }
            }
          }
        }else{
          M.toast({html: "U moet minimaal een bestand gekozen hebben", classes:"toast--error"});
          timeOutClear();
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
  timeOutClear();
  if($(".js-toast-warning").length > 0){
    M.Toast.getInstance($(".js-toast-warning")).dismiss()
  }
});

function timeOutClear(){
  nameExists = false;
  clearTimeout(loaderMessage);
  M.Toast.getInstance($(".js-toast-confirm")).dismiss();
  loaderMessage = "";
}

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
      loaderMessage = "";
      if($(".js-toast-warning").length > 0){
        M.Toast.getInstance($(".js-toast-warning")).dismiss()
      }
      M.toast({html: 'Succes', classes: 'toast--succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  });
}
