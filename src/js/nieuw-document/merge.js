$('body').on("change paste keyup", ".js-mergedName" , function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 1);
  $(this).val(search);
});

$('body').on('click', '.js-merge', function(){
  var fileNames = [];
  var fileExtensions = [];
  var fileVersions = [];
  var pageNumbers = [];
  var mergeName = $(".js-mergedName").val();
  $('.file--dragged').each(function(){
    fileNames.push($(this).data("name"));
    fileExtensions.push($(this).data("ext"));
    fileVersions.push($(this).data("version"));
    var pageVal = $(this).find(".js-pages").val();
    if(pageVal == ""){
      pageVal = "all";
    }
    pageNumbers.push(pageVal);
  });
  console.log("fileNames: ", fileNames);
  console.log("fileVersions: ", fileVersions);
  console.log("pageNumbers: ", pageNumbers);

  $.post("include/pdf/pdfMerge.php",{
    files: fileNames,
    pages: pageNumbers,
    mergeName: mergeName,
    pageExt: fileExtensions,
    fileVersions: fileVersions
  },function(response,status){
    console.log(response);
    if(response == ""){
      M.toast({html: 'Succes', classes: 'toast--succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  });
});
