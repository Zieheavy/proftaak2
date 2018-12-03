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

function addUrlParameter(keys, values){
  var sPageURL = decodeURIComponent(window.location.search.substring(1));
  var sURLVariables = sPageURL.split('&');
  var newString = "";
  var sParamaters = [];

  newString += "?";

  for (var i = 0; i < sURLVariables.length; i++) {
    newString += sURLVariables[i];
    sParamaters.push(sURLVariables[i].split('=')[0]);
    if(i != sURLVariables.length -1){
      newString += "&";
    }
  }

  if(keys != undefined && values != undefined){
    if(keys.length == values.length){
      if(sURLVariables.length > 1 ){
        newString += "&";
      }
      for (var i = 0; i < keys.length; i++) {
        if (sParamaters.indexOf(keys[i]) == -1) {
          newString += keys[i] + "=" + values[i];
          if(i != keys.length -1){
            newString += "&";
          }
        }else{
          // console.log(keys[i])
          var array = newString.split(keys[i]);
          var end = array[1].substring(array[1].indexOf("&"));
          var begin = array[0] + keys[i] + "=" + values[i];
          if(i == keys.length -1){
            end = "";;
          }
          console.log(begin+end)
          newString = begin+end;
        }
      }
    }
  }

  window.history.pushState(null, null, newString);
}

function removeUrlParameter(key){
  // Gets everything behind the ? in the url
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
  // Makes an object array splitting the keys and vals
  var obj = {
    keys: [],
    vals: []
  };
  for (var i = 0; i < sURLVariables.length; i++) {
    var spl = sURLVariables[i].split("=");
    obj.keys.push(spl[0]);
    obj.vals.push(spl[1]);
  }
  // if the given key is in the url, it removes it from the obj
  var index = obj.keys.getIndex(key);
  if (index != -1) {
    obj.keys = obj.keys.removeIndex(index);
    obj.vals = obj.vals.removeIndex(index);
  }
  // creates new string
  var newStr = "";
  for (var i = 0; i < obj.keys.length; i++) {
    if (i > 0) {
      newStr += "&";
    }
    newStr += obj.keys[i] + "=" + obj.vals[i];
  }
  // Sets the url
  window.history.pushState(null, null, "?" +  newStr);
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
    case 2:
      string = string.replace(/[^A-Za-z0-9\s]/g,'');
    break;
  }
  return string;
}

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
