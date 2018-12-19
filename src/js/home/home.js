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
