colleges = [];
$.post("include/get/getColleges.php",{
  ajax: true
}, function(response,status){
  colleges = JSON.parse(response);
  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id != 1){
      colleges[i].courses.unshift({colleges_id: 1, id: 1, name: "none"})
    }
  }
});

$('body').on('change', '.js-college-select', function(){
  var id = $(this).closest(".card").data("id")
  var courseContainer = ".js-courseContainer-" + id;

  for(var i = 0; i < colleges.length; i++){
    if(colleges[i].id == $(this).val()){
      mustache(".courses-manage-template", courseContainer, colleges[i].courses);
      $('select').formSelect();
    }
  }
})
