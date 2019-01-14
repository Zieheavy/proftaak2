//creates a array of names, array is used for the search bar
var shownItems = [];

//loops to all the items that are loaded from the database
$(".home-card").each(function(){
  var name = $(this).data("name");
  shownItems.push(name);
});

//sets the initial search autofill function
setSearch(shownItems);

//checks if the user collapses a option if so all selected option will be unchecked
$("body").on("click", ".collapsible-header", function(){
  if($(this).hasClass("active") == false){
    $(this).closest(".collapsible-expand").find(".js-sortableItem").each(function(){
      if($(this).hasClass("active")){
        $(this).trigger("click");
      }
    })
  }
});

//if the search bar text has change check if the search bar value is in the items array hide all other items
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
});

//changes update color then edit the searchable array
$("body").on("click", ".js-sortableItem", function(){
  var courses = [];

  if($(this).hasClass("active")){
    $(this).removeClass("active");
  }else{
    $(this).addClass("active");
  }

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
        shownItems.push($(this).data("name"));
      }else{
        $(this).hide();
      }
    }else{
      $(this).show();
      shownItems.push($(this).data("name"));
    }
  })
  $(".js-merge").trigger("change");

  setSearch(shownItems);
});

//sets autocomplete in the search bar to a max of 2
function setSearch(array){
  var data = [];
  for (var i = 0; i < array.length; i++) {
    data[array[i]] = null;
  }

  $('input.js-merge').autocomplete({
    data: data,
    limit: 2
  });
};
