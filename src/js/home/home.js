$(document).ready(function(){
  $('select').formSelect();

  $(document).on('change', '.js-versionSelect', function() {
    var source = "";
    var container = $(this).closest(".card");
    source += "_completed/";
    source += $(this).data("name") + "_" + $(this).val();
    source += ".pdf";
    container.find(".iframe").attr("src", source);
    container.find(".js-download").attr("href", source);
  });
});
