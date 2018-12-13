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
      console.log(newVersion);
      $(this).closest('.file').data('version', newVersion);
      $(this).closest('.file').attr('data-version', newVersion);
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
