//if you press ok in the upload window upload the files to php
$("body").on("click", ".js-ok", function(){
  var file = $('#uploadFiles')[0].files;
  for(var i = 0; i < file.length; i++){
    var upload = new Upload(file[i]);
    upload.doUpload();
  }
})
// //////////////////////////////
// // default upload functions //
// //////////////////////////////
//
var Upload = function (file) {
  this.file = file;
};

Upload.prototype.getType = function() {
  return this.file.type;
};
Upload.prototype.getSize = function() {
  return this.file.size;
};
Upload.prototype.getName = function() {
  return this.file.name;
};
Upload.prototype.doUpload = function () {
  var formData = new FormData();

  // add assoc key values, this will be posts values
  formData.append("file", this.file, this.getName());
  formData.append("upload_file", true);

  $.ajax({
    type: "POST",
    url: "include/uploadDocs.php",
    xhr: function () {
      var myXhr = $.ajaxSettings.xhr();
      return myXhr;
    },
    success: function (data) {
      console.log(data);
      var extension = data.split(".");
      //checks if the file is not a pdf
      if(extension != "pdf"){
        //if the file is excel file convert the excel to pdf
        if(extension[1] == "xlsx" || extension[1] == "xls" || extension[1] == "xlsm"){
          $.post( "include/pdf/excelToPdf.php", {
            fileName: extension[0],
            extension: extension[1]
          }, function(response,status){
            console.log(response)
            if(response == "succes"){
              console.log("excel success");
            }
          })
          //if the file is word file convert the word to pdf
        }else if(extension[1] == "docx" || extension[1] == "doc"){
          console.log(extension[0])
          $.post( "include/pdf/wordToPdf.php", {
            fileName: extension[0],
            extension: extension[1]
          }, function(response,status){
            console.log(response)
            if(response == "succes"){
              console.log("word success");
            }
          })
        }

      }else{
        console.log("pdf success");
      }

    },
    error: function (error) {
      // handle error
      console.log(error)
    },
    async: true,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    timeout: 120000
  });
};

Upload.prototype.progressHandling = function (event) {
  var percent = 0;
  var position = event.loaded || event.position;
  var total = event.total;
  var progress_bar_id = "#progress-wrp";
  if (event.lengthComputable) {
    percent = Math.ceil(position / total * 100);
  }
  console.log(percent)
  // update progressbars classes so it fits your code
  $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
  $(progress_bar_id + " .status").text(percent + "%");
};
