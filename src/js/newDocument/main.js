sortable('.js-sortable-copy', {
  forcePlaceholderSize: true,
  copy: true,
  acceptFrom: false,
  placeholderClass: 'fuuuuuck',
});
sortable('.js-sortable-copy-target', {
  forcePlaceholderSize: true,
  acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
  placeholderClass: 'file__placeholder',
});
$(sortable('.js-sortable-copy')).each(function(index, el) {
  sortable('.js-sortable-copy')[index].addEventListener('sortstop', function(e) {
    var i = e.detail.item;
    $(i).addClass('file--dragged');
    $(i).find('.card--file').removeClass('card--file');
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
$(document).ready(function(){
  $('.collapsible.expandable').collapsible({accordion: false});
});

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
      M.toast({html: 'Succes', classes: 'succes'})
    }else if(response == "noUser"){
      window.location = 'index.php';
    }
  })
})

function randomString2(len, beforestr = '', arraytocheck = null) {
    // Charset, every character in this string is an optional one it can use as a random character.
    var charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        // creates a random number between 0 and the charSet length. Rounds it down to a whole number
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    // If an array is given it will check the array, and if the generated string exists in it it will create a new one until a unique one is found *WATCH OUT. If all available options are used it will cause a loop it cannot break out*
    if (arraytocheck == null) {
        return beforestr + randomString;
    } else {
        var isIn = $.inArray(beforestr + randomString, arraytocheck); // checks if the string is in the array, returns a position
        if (isIn > -1) {
            // if the position is not -1 (meaning, it is not in the array) it will start doing a loop
            var count = 0;
            do {
                randomString = '';
                for (var i = 0; i < len; i++) {
                    var randomPoz = Math.floor(Math.random() * charSet.length);
                    randomString += charSet.substring(randomPoz, randomPoz + 1);
                }
                isIn = $.inArray(beforestr + randomString, arraytocheck);
                count++;
            } while (isIn > -1);
            return beforestr + randomString;
        } else {
            return beforestr + randomString;
        }
    }
}
