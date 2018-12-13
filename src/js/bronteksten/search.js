//creates a array of names, array is used for the search bar
var shownItems = [];
$(".js-source-files").each(function(){
  var name = $(this).data("name");
  shownItems.push(name);
})
setSearch(shownItems);

//if the search bar text has change check if the search bar value is in the items array hide all other items
$(".js-merge").on("change paste keyup", function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 1);
  $(this).val(search);

  $(".js-source-files").each(function(){
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

//changes update color then edit the searchable array
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
  $(".js-source-files").each(function(){
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
}
