$('select').formSelect();
$(document).ready(function() {
  $('.dropdown-trigger').dropdown();
  $('.js-lazyload-iframe').lazyload();
});

var mergedId;

//checks if the user changed the version if so it will update all the download and edit tags
$(document).on('change', '.js-versionSelect', function() {
  var source = "";
  var container = $(this).closest(".card");
  source += "_completed/";

  if($(this).find("option").last().val() >= 5){
    source += $(this).data("name") + "/";
  }

  source += $(this).data("name") + "_" + $(this).val();
  source += ".pdf";
  container.find(".iframe").attr("src", source);
  container.find(".js-download").attr("href", source);
});

//open a confirm modal so the user can confirm that a item wil be deleted
$('body').on('click', '.js-delete-merged', function(){
  mergedId = $(this).data('mergedid');
  confirmModal( "Weet u het zeker?",
                "Dit bestand zal permanent verwijderd worden",
                "js-delete-merged-confirmed");
});
//if the user has pressed confirm deletes the item from the database and server
$('body').on('click', '.js-delete-merged-confirmed', function(){
  $.post("include/delete/deleteMerged.php",{
    id: mergedId
  }, function(response,status){
    console.log(response);
    if (response == "succes") {
      $('#' + mergedId).remove();
      M.toast({html: 'Succes', classes: 'toast--succes'});
      $('.js-confirm-modal').modal("close");
    }
  });
});

//this wil download the selected file, a waiting message will be shown so the user knows the website is working
$('body').on('click', '.js-download-doc', function(){
  var file = $(this).data('file');
  M.toast({ html: 'Bestand word omgezet naar DOCX &nbsp;' + getLoaderHTML(),
            classes: "toast--info js-toast-warning",
            displayLength: 99999999});
  $.post("include/pdf/downloadPdfDoc.php",{
    file: file
  }, function(response,status){
    if (response == "success") {
      $('body').append('<a id="temp" href="' + "_completed/" + file + '.docx" download></a>');
      $('#temp')[0].click();
      $('#temp').remove();
      M.Toast.getInstance($(".js-toast-warning")).dismiss();
    }
  });
});
