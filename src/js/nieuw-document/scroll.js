$('.drp').dropdown();
$('.version').formSelect();
M.updateTextFields();
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
    var rnd = randomString2(10)
    var dropdownTrigger = $(i).find('.dropdown-trigger');
    var dropdownContent = $(i).find('.dropdown-content');
    var versionSelect = $(i).find('.js-version-select');

    var random = randomString2(15);
    var inputContainer = $(i).closest("li").find(".file__pagenrs");
    inputContainer.find("input").attr("id",random);
    inputContainer.find("label").attr("for",random);

    $(i).addClass('file--dragged');
    $(dropdownTrigger).addClass('drp');
    $(dropdownTrigger).attr('data-target', "dropdown" + rnd);
    $(dropdownTrigger).data('target', "dropdown" + rnd);
    $(dropdownContent).attr('id', "dropdown" +  rnd);
    $(dropdownTrigger).dropdown();
    M.updateTextFields();
    $(versionSelect).find('option:last-child()').attr('selected', '');
    $(versionSelect).formSelect();
    $(versionSelect).on('change', function(e) {
      var newVersion = $(this).val();
      var fileElem = $(this).closest('.file');
      var ext = $(fileElem).data('ext');
      console.log(newVersion);
      $(fileElem).data('version', newVersion);
      $(fileElem).attr('data-version', newVersion);
      var pdfSrc = $(fileElem).find('.js-download-pdf').attr('href');
      pdfSrc = pdfSrc.replace('.pdf', '');
      pdfSrc = pdfSrc.slice(0, -1) + newVersion + ".pdf";
      $(fileElem).find('.js-download-pdf').attr('href', pdfSrc);

      var docSrc = $(fileElem).find('.js-download-doc').attr('href');
      docSrc = docSrc.replace('.' + ext, '');
      docSrc = docSrc.slice(0, -1) + newVersion + "." + ext;
      $(fileElem).find('.js-download-doc').attr('href', docSrc);

      // TODO: DOWNLOAD BUTTON LINK FIX
    });
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
  if (y >= yBot) {
    var y2 = $(window).scrollTop();  //your current y position on the page
    $(window).scrollTop(y2+10);
  }
  else if (y <= yTop) {
    var y2 = $(window).scrollTop();  //your current y position on the page
    $(window).scrollTop(y2-10);
  }
}
