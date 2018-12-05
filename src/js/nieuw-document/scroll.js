sortable('.js-sortable-copy', {
  forcePlaceholderSize: true,
  copy: true,
  acceptFrom: false,
  placeholderClass: 'file__placeholder',
});
sortable('.js-sortable-copy-target', {
  forcePlaceholderSize: true,
  acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
  placeholderClass: 'file__placeholder',
});

$(sortable('.js-sortable-copy')).each(function(index, el) {
  sortable('.js-sortable-copy')[index].addEventListener('sortstart', function(e) {
    $('.scroll').addClass('scroll--show');
  });
  sortable('.js-sortable-copy')[index].addEventListener('sortstop', function(e) {
    $('.scroll').removeClass('scroll--show');
    var i = e.detail.item;
    $(i).addClass('file--dragged');
    M.updateTextFields();
    var dropdown = $(i).find('.dropdown-trigger');
    $(dropdown).addClass('drp');
    var rnd = randomString2(10)
    $(dropdown).attr('data-target', "dropdown" + rnd);
    $(dropdown).data('target', "dropdown" + rnd);
    $(i).find('#dropdown').attr('id', "dropdown" +  rnd);
    $('.drp').dropdown();
  });
});
$(sortable('.js-sortable-copy-target')).each(function(index, el) {
  sortable('.js-sortable-copy-target')[index].addEventListener('sortstart', function(e) {
    $('.scroll').addClass('scroll--show');
  });
  sortable('.js-sortable-copy-target')[index].addEventListener('sortstop', function(e) {
    $('.scroll').removeClass('scroll--show');
  });
});

function isDragging(){
  var y = event.clientY;
  var yBot = $('#dragScrolBot').position().top;
  var yTopElem = $('#dragScrolTop');
  var yTop = yTopElem.position().top + yTopElem.outerHeight(true);
  console.log("y:", y, "yBot:", yBot, "ytop:", yTop);
  if (y >= yBot) {
    console.log("to bot");
    var y2 = $(window).scrollTop();  //your current y position on the page
    $(window).scrollTop(y2+10);
  }
  else if (y <= yTop) {
    console.log("to top");
    var y2 = $(window).scrollTop();  //your current y position on the page
    $(window).scrollTop(y2-10);
  }
}

$('body').on('click', '.file__title', function(){
  var file = $(this).closest('.file').data('name');
  $('.js-frm').attr('src', '_pdf/' + file + ".pdf");
});

$('body').on('click', '.js-delete-file', function(){
  $(this).closest('.file').remove();
});

$('body').on("change paste keyup", ".js-mergedName" , function(){
  var search = $(this).val().toLowerCase();
  search = filter(search, 1);
  $(this).val(search);
})

$('body').on('click', '.js-merge', function(){
  var fileNames = [];
  var pageNumbers = [];
  var pageExtension = [];
  var mergeName = $(".js-mergedName").val();
  $('.file--dragged').each(function(){
    fileNames.push($(this).data("name"));
    pageExtension.push($(this).data("ext"));
    var pageVal = $(this).find(".js-pages").val();
    if(pageVal == ""){
      pageVal = "all";
    }
    pageNumbers.push(pageVal);
  })
  console.log(fileNames)
  console.log(pageNumbers)

  $.post("include/pdf/pdfMerge.php",{
    files: fileNames,
    pages: pageNumbers,
    mergeName: mergeName,
    pageExt: pageExtension
  },function(response,status){
    console.log(response);
    if(response == ""){
      M.toast({html: 'Succes', classes: 'toast--succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  })
})
