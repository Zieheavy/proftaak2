$('body').on('click', '.deleteAll', function(){
  $.post("include/deleteAll.php",{}, function(response,status){
    console.log(response);
    if (response == "success") {
      showFlashMessage('Gelukt', 'success');
      loadIframes();
    }
  });
});
 
