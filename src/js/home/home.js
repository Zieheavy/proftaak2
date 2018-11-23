$(document).ready(function(){
  $('select').formSelect();

  $(document).on('change', '.js-versionSelect', function() {
    var source = "";
    source += "_completed/";
    source += $(this).data("name") + "_" + $(this).val();
    source += ".pdf";
    $(this).closest(".card").find(".iframe").attr("src", source);
  });
});
