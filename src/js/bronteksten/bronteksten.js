$("body").on("click", ".js-sortableItem", function(){
  if($(this).hasClass("active")){
    $(this).removeClass("active")
  }else{
    $(this).addClass("active");
  }

  // var courses = [];
  // $(".js-sortableItem").each(function(){
  //   if($(this).hasClass("active")){
  //     courses.push($(this).data("course"));
  //   }
  // })
  //
  // shownItems = [];
  // $(".home-card").each(function(){
  //   if(courses.length > 0){
  //     if(courses.indexOf($(this).data("course")) != -1){
  //       $(this).show();
  //       shownItems.push($(this).data("name"))
  //     }else{
  //       $(this).hide();
  //     }
  //   }else{
  //     $(this).show();
  //     shownItems.push($(this).data("name"))
  //   }
  // })
  // $(".js-merge").trigger("change")
  // setSearch(shownItems);
});
