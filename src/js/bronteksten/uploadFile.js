var fileToEdit = "";
var amountToUpload = 0;
var amountUploaded = 0;
$('select').formSelect();
var existingFiles = [];
//gets all the existing sourcefiles
$.post("include/get/getSourceFiles.php",{}, function(response,status){
  existingFiles = JSON.parse(response);
});
//multiple file upload
$("body").on("click", ".js-upload-multiple", function(){
  var file = $('#uploadMultiple')[0].files;
  amountToUpload = file.length;
  amountUploaded = 0;
  M.toast({html: "Bestanden worden omgezet&nbsp;"  + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
  for(var i = 0; i < file.length; i++){
    var filename = file[i].name.split(".")[0];
    if(existingFiles.indexOf(filename) != -1){
      amountUploaded++;
      M.toast({html: filename + " bestaat al,<br> om het bestand aantepassen gebruik edit", classes: "toast--error"});
    }else{
       $('#uploadModal').modal('close');
      var upload = new Upload(file[i]);
      upload.doUpload();
    }
    handleWorkingMessage();
  }
});
//single file upload
$("body").on("click", ".js-upload", function(){
  var file = $('#uploadSingle')[0].files;
  amountToUpload = 1;
  amountUploaded = 0;
  M.toast({html: "Bestanden worden omgezet"  + getLoaderHTML(), classes: "toast--info js-toast-warning", displayLength: 99999999});
  console.log("upload name: ", file[0].name, ",    filetoedit: ", fileToEdit);
  if(file[0].name != fileToEdit){
    amountUploaded = 1;
    handleWorkingMessage();
  }else{
    $('#editModal').modal('close');
    for(var i = 0; i < file.length; i++){
      var upload = new Upload(file[i]);
      upload.doUpload();
    }
  }
});

//opens the edit modal
$("body").on("click", ".js-open-edit", function(){
  $('#editModal').modal('open');
  var container = $(this).closest(".js-source-files")
  console.log(container);
  fileToEdit = container.data("name") + "." + container.data("ext")
  console.log(fileToEdit);;
})

// //////////////////////////////
// // default upload functions //
// //////////////////////////////
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
  formData.append("course", $(".js-source-course").val());
  formData.append("college", $(".js-source-college").val());
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
      if(extension[1] != "pdf"){
        //if the file is excel file convert the excel to pdf
        if(extension[1] == "xlsx" || extension[1] == "xls" || extension[1] == "xlsm"){
          $.post( "include/pdf/excelToPdf.php", {
            fileName: extension[0],
            extension: extension[1]
          }, function(response,status){
            amountUploaded++;
            handleWorkingMessage();
            if(response == "succes"){
              M.toast({html: "Het excel bestand " + extension[0] + " is succes upgeload", classes: "toast--succes"});
              reloadElements();
            }else{
              M.toast({html: "Er is iets fout gegaan tijdens het uploaden van " + extension[0], classes: "toast--error"});
            }
          })
          //if the file is word file convert the word to pdf
        }else if(extension[1] == "docx" || extension[1] == "doc"){
          $.post( "include/pdf/wordToPdf.php", {
            fileName: extension[0],
            extension: extension[1]
          }, function(response,status){
            amountUploaded++;
            handleWorkingMessage();
            if(response == "succes"){
              M.toast({html: "Het word bestand " + extension[0] + " is succes upgeload", classes: "toast--succes"});
              reloadElements();
            }else{
              M.toast({html: "Er is iets fout gegaan tijdens het uploaden van " + extension[0], classes: "toast--error"});
            }
          })
        }
        else {
          amountUploaded++;
          handleWorkingMessage();
          M.toast({html: "Het bestand " + extension[0] + " heeft een ongeldig bestandstype", classes: "toast--error"});
        }
      }else{
        amountUploaded++;
        handleWorkingMessage();
        M.toast({html: "Het pdf bestand " + extension[0] + " is succes upgeload", classes: "toast--succes"});
        reloadElements();
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

function handleWorkingMessage(){
  if(amountUploaded == amountToUpload) M.Toast.getInstance($(".js-toast-warning")).dismiss();
}

Upload.prototype.progressHandling = function (event) {
  var percent = 0;
  var position = event.loaded || event.position;
  var total = event.total;
  var progress_bar_id = "#progress-wrp";
  if (event.lengthComputable) {
    percent = Math.ceil(position / total * 100);
  }
  // update progressbars classes so it fits your code
  $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
  $(progress_bar_id + " .status").text(percent + "%");
};
