$('select').formSelect();
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
var mergedId;
$('body').on('click', '.js-delete-merged', function(){
  mergedId = $(this).data('mergedid');
  confirmModal("Weet u het zeker?", "Dit bestand zal permanent verwijderd worden", "js-delete-merged-confirmed");
  console.log(mergedId);
});
$(document).ready(function() {
  $('.dropdown-trigger').dropdown();
});
$('body').on('click', '.js-delete-merged-confirmed', function(){
  $.post("include/delete/deleteMerged.php",{
    id: mergedId
  }, function(response,status){
    console.log(response);
    if (response == "succes") {
      $('#' + mergedId).remove();
      M.toast({html: 'Succes', classes: 'toast--succes'})
      $('.js-confirm-modal').modal("close");
    }
  });
});
$(document).ready(function() {
  $('.js-lazyload-iframe').lazyload();
});
$('body').on('click', '.js-download-doc', function(){
  var file = $(this).data('file');
  M.toast({html: 'Bestand word omgezet naar DOCX &nbsp;' + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
  $.post("include/pdf/downloadPdfDoc.php",{
    file: file
  }, function(response,status){
    console.log(response);
    if (response == "success") {
      $('body').append('<a id="temp" href="' + "_completed/" + file + '.docx" download></a>');
      $('#temp')[0].click();
      $('#temp').remove();
      M.Toast.getInstance($(".js-toast-warning")).dismiss()
    }
  });
});
