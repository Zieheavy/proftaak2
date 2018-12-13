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
    $(i).addClass('file--dragged');
    var dropdown = $(i).find('.dropdown-trigger');
    $(dropdown).addClass('drp');
    var rnd = randomString2(10)
    $(dropdown).attr('data-target', "dropdown" + rnd);
    $(dropdown).data('target', "dropdown" + rnd);
    $(i).find('#dropdown').attr('id', "dropdown" +  rnd);
    M.updateTextFields();
    $('.drp').dropdown();
    $('.version').formSelect();
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
