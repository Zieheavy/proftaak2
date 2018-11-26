var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function addUrlParameter(indentifer,key,indentifer2,key2,indentifer3,key3){
  if(indentifer3 != undefined){
    window.history.pushState(null, null, "?" + indentifer + "="+key+"&"+indentifer2+"="+key2+"&"+indentifer3+"="+key3);
  }else if(indentifer2 != undefined){
    window.history.pushState(null, null, "?" + indentifer + "="+key+"&"+indentifer2+"="+key2);
  }else{
    window.history.pushState(null, null, "?" + indentifer + "="+key);
  }
}

function uppercase(str){
  var array1 = str.split(' ');
  var newarray1 = [];

  for(var x = 0; x < array1.length; x++){
      newarray1.push(array1[x].charAt(0).toUpperCase()+array1[x].slice(1));
  }
  return newarray1.join(' ');
}

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

function initMap(x, y, location) {
  var myLatLng = "";
  if(x == undefined || y == undefined){
    // myLatLng = {lat: 51.5320051, lng: 5.628627599999959};
    myLatLng = {lat: 53.2734, lng: -7.77832031};
  }else{
    myLatLng = {lat: x, lng: y};
  }
  var map = new google.maps.Map(($(location)[0]), {
    zoom: 18,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      title: 'Hello World!'
    });
}
function setupMap(location,container){
  // var location = "5741KP, beek en donk, netherlands";
  location = location.replace(/\s+/g, '%20');
  $.post( "http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/find?text="+ location +"&f=pjson", {
  }, function(response,status){
    response = JSON.parse(response);
    var array = response.locations[0].feature.geometry;
    initMap(array.y, array.x, container);
  });
}

function mustache(origin, location, information, append){
    if(append == undefined){
      append = false;
    }
    var template = $(origin).html();
    console.log(origin)
    var renderTemplate = Mustache.render(template, information);

    if(append == false){
      $(location).html(renderTemplate);
    }else{
      $(location).append(renderTemplate);
    }
}

// var confirmClassOld = "";
// var deleteClassOld = "";
// function confirmModal(title, body, confirmClass, deleteClass, data){
//     if(deleteClass == undefined){
//         deleteClass = "close-confirm"
//     }
//     if(confirmClass != "" && deleteClassOld != ""){
//         $('.confirm-save-change').removeClass(confirmClassOld)
//         $('.confirm-delete-change').removeClass(deleteClassOld)
//     }
//     $('.confirm-save-change').addClass(confirmClass)
//
//     if(data != undefined){
//       $('.confirm-save-change').attr("data",data)
//     }else{
//       $('.confirm-save-change').attr("data","")
//     }
//     $('.confirm-delete-change').addClass(deleteClass)
//
//     confirmClassOld = confirmClass;
//     deleteClassOld = deleteClass;
//
//     $('.confirm-title').text(title)
//     $('.confirm-text').text(body)
//
//     $('.js-confirm').modal("show")
// }

function checkInput(container,button){
  button.closest(container).find(".form-control").each(function(i){
    if($(this).val() == ""){
      $(this).addClass("empty")
    }else{
      $(this).removeClass("empty")
    }
  })
}

function generateQR(container, text, type){
  $(container).html('');
  $(container).qrcode({
    // render method: 'canvas', 'image' or 'div'
    render: type,

    // version range somewhere in 1 .. 40
    minVersion: 1,
    maxVersion: 40,

    // error correction level: 'L', 'M', 'Q' or 'H'
    ecLevel: 'L',

    // offset in pixel if drawn onto existing canvas
    left: 0,
    top: 0,

    // size in pixel
    size: 500,

    // code color or image element
    fill: '#000',

    // background color or image element, null for transparent background
    background: null,

    // content
    text: text,

    // corner radius relative to module width: 0.0 .. 0.5
    radius: 0,

    // quiet zone in modules
    quiet: 0,

    // modes
    // 0: normal
    // 1: label strip
    // 2: label box
    // 3: image strip
    // 4: image box
    mode: 0,

    mSize: 0.1,
    mPosX: 0.5,
    mPosY: 0.5,

    label: 'no label',
    fontname: 'sans',
    fontcolor: '#000',

    image: null
  });
}
