$(document).ready(function(){
  $('select').formSelect();
  var shownItems = [];

  $(document).on('change', '.js-versionSelect', function() {
    var source = "";
    var container = $(this).closest(".card");

    source += "_completed/";

    if($(this).find("option").last().val() > 5){
      source += $(this).data("name") + "/";
    }

    source += $(this).data("name") + "_" + $(this).val();
    source += ".pdf";
    container.find(".iframe").attr("src", source);
    container.find(".js-download").attr("href", source);
  });

  $(".home-card").each(function(){
    var name = $(this).data("name");
    shownItems.push(name);
  })
  setSearch(shownItems);

  $(".js-merge").on("change paste keyup", function(){
    var search = $(this).val().toLowerCase();
    search = filter(search, 1);
    $(this).val(search);

    $(".home-card").each(function(){
      if(shownItems.indexOf($(this).data("name")) != -1){
        var name = $(this).data("name").toLowerCase();
        if(name.indexOf(search) == -1){
          $(this).hide();
        }else{
          $(this).show();
        }
      }
    });
  })

  $("body").on("click", ".js-sortableItem", function(){
    if($(this).hasClass("active")){
      $(this).removeClass("active")
    }else{
      $(this).addClass("active");
    }

    var courses = [];
    $(".js-sortableItem").each(function(){
      if($(this).hasClass("active")){
        courses.push($(this).data("course"));
      }
    })

    shownItems = [];
    $(".home-card").each(function(){
      if(courses.length > 0){
        if(courses.indexOf($(this).data("course")) != -1){
          $(this).show();
          shownItems.push($(this).data("name"))
        }else{
          $(this).hide();
        }
      }else{
        $(this).show();
        shownItems.push($(this).data("name"))
      }
    })
    $(".js-merge").trigger("change")
    setSearch(shownItems);
  })

  function setSearch(array){
    var data = [];
    for (var i = 0; i < array.length; i++) {
      data[array[i]] = null;
    }

    $('input.js-merge').autocomplete({
      data: data,
    });
  }
});
