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

  var data = [];
  $(".card").each(function(){
    var name = $(this).find(".card-title").html();
    data[name] = null;
  })

  $('input.js-merge').autocomplete({
    data: data,
  });

  $(".js-merge").on("change paste keyup", function(){
    var search = $(this).val();

    $(".home-card").each(function(){
      var name = $(this).find(".card-title").html();
      if(name.indexOf(search) == -1){
        $(this).hide();
      }else{
        $(this).show();
      }
      console.log(search)
    });
  })
});
