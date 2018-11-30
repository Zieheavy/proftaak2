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

function removeUrlParameter(key){
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
  var obj = {
    keys: [],
    vals: []
  };
  for (var i = 0; i < sURLVariables.length; i++) {
    var spl = sURLVariables[i].split("=");
    obj.keys.push(spl[0]);
    obj.vals.push(spl[1]);
  }
  var index = obj.keys.getIndex(key);
  if (index != -1) {
    obj.keys = obj.keys.removeIndex(index);
    obj.vals = obj.vals.removeIndex(index);
  }
  var newStr = "";
  for (var i = 0; i < obj.keys.length; i++) {
    if (i > 0) {
      newStr += "&";
    }
    newStr += obj.keys[i] + "=" + obj.vals[i];
  }
  window.history.pushState(null, null, "?" + newStr);
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

function filter(string, type){
  switch(type){
    case 1:
      string = string.replace(/[^A-Za-z0-9\s_:]/g,'');
    break;
  }
  return string;
}

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] == obj) {
            return true;
        }
    }
    return false;
}

Array.prototype.getIndex = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] == obj) {
            return i;
        }
    }
    return -1;
}

Array.prototype.removeIndex = function(n) {
    var t = [];
    var l = this.length;
    for (var i = 0; i < l; i++) {
        if (i != n) {
            t.push(this[i]);
        }
    }
    return t;
};
