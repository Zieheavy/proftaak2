$(document).ready(function(){
  //opens the upload dialog window
  $("#open_btn").click(function() {
    setTimeout(function () {
      $('input:file').filestyle({
        buttonName : 'btn-primary',
        buttonText : ' File selection'
      });
      $(".modal .btn").removeClass("btn-default").removeClass("btn-primary").addClass("btn-secondary").addClass("btn-block")
    }, 100);
    $.FileDialog({
      // MIME type of accepted files, e. g. image/jpeg
      accept: "*",
      // accept: "*",
      // cancel button
      cancelButton: "Close",
      // drop zone message
      dragMessage: "Drop files here",
      // the height of drop zone in pixels
      dropheight: 100,
      // error message
      errorMessage: "An error occured while loading file",
      // whether it is possible to choose multiple files or not.
      multiple: true,
      // OK button
      okButton: "OK",
      // file reading mode.
      // BinaryString, Text, DataURL, ArrayBuffer
      readAs: "DataURL",
      // remove message
      removeMessage: "Remove&nbsp;file",
      // file dialog title
      title: "Load file(s)"
    })
  });

  //if you press ok in the upload window upload the files to php
  $("body").on("click", ".bfd-ok", function(){
    var file = $('input:file')[0].files;
    for(var i = 0; i < file.length; i++){
      var upload = new Upload(file[i]);
      upload.doUpload();
    }
  })

  //automaticly checks the checkbox whenever you start typing page numbers
  $("body").on("input paste keyup", ".pages", function(){
    var checkbox = $(this).closest(".iframe-container").find(".selected");
    checkbox.attr("checked", true)
  })

  //merges the selected files
  $("body").on("click", ".js-mergeSelected", function(){
    var files = [];
    var pages = [];

    //checks if the checkbox is checked
    $(".iframe-container").each(function(){
      var m_pages = $(this).find(".pages");
      var m_checked = $(this).find(".selected");
      if(m_checked.prop('checked') == true){
        files.push(m_pages.data("file").split(".")[0].split("/")[1])
        //checks if you want all pages or a select range of pages
        if(m_pages.val() == ""){
          pages.push("all")
        }else{
          pages.push(m_pages.val())
        }
      }
    })

    //sends the merge command to php
    $.post( "include/pdf/pdfMerge.php", {
      files: files,
      pages: pages,
      mergeName: $(".js-merge-name").val()
    }, function(response,status){
      console.log(response)
      // console.log(response.split("splitHere")[1])
      if(response.indexOf("%PDF-1.7") != -1 && response.indexOf("%PDF-1.7") < 5){
        showFlashMessage("Pdf succesfuly merged", "success")
      }
    })
  })

  loadIframes();
});

function loadIframes(){
  //gets all the pdfs in the pdf folder
  $.post("include/pdf/getPdfs.php",{
  }, function(response, status){
    console.log(response);
    response = JSON.parse(response);
    var m_data = [];
    for(var i = 0; i < response.length; i++){
      m_data.push({name: "_pdf/" + response[i]});
    }

    //loads all the found pdfs to the page
    mustache(".iframe-template", ".container", m_data)
  })
}


//////////////////////////////
// default upload functions //
//////////////////////////////

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
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
    formData.append('name', that.getName());

    $.ajax({
        type: "POST",
        url: "include/uploadDocs.php",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
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
                    showFlashMessage("Upload excel Succes", "success")
                    loadIframes();
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
                    showFlashMessage("Upload word Succes", "success")
                    loadIframes();
                  }
                })
              }

            }else{
              showFlashMessage("Upload pdf Succes","success")
              loadIframes();
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
        timeout: 60000
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
