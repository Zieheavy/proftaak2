$(document).ready(function(){
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

  $("body").on("click", ".bfd-ok", function(){
    var file = $('input:file')[0].files;
    for(var i = 0; i < file.length; i++){
      var upload = new Upload(file[i]);
      upload.doUpload();
    }
  })

  $("body").on("input paste keyup", ".pages", function(){
    var checkbox = $(this).closest(".iframe-container").find(".selected");
    checkbox.attr("checked", true)
  })

  $("body").on("click", ".js-mergeSelected", function(){
    var files = [];
    var pages = [];

    $(".iframe-container").each(function(){
      var m_pages = $(this).find(".pages");
      var m_checked = $(this).find(".selected");
      if(m_checked.prop('checked') == true){
        files.push(m_pages.data("file").split(".")[0].split("/")[1])
        if(m_pages.val() == ""){
          pages.push("all")
        }else{
          pages.push(m_pages.val())
        }
      }
    })
    //
    // console.log(files);
    // console.log(pages);

    $.post( "include/pdfMerge.php", {
      files: files,
      pages: pages
    }, function(response,status){
      console.log(response)
      if(response == "succes"){
        showFlashMessage("Pdf succesfuly merged", "success")
      }
    })
  })

  loadIframes();

  function loadIframes(){
    $.post("include/getPdfs.php",{
    }, function(response, status){
      response = JSON.parse(response);
      var m_data = [];
      for(var i = 0; i < response.length; i++){
        m_data.push({name: "_pdf/" + response[i]});
      }

      mustache(".iframe-template", ".container", m_data)
    })
  }
});

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
        url: "include/editProfilePic.php",
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
            if(extension != "pdf"){
              if(extension[1] == "xlsx" || extension[1] == "xls"){
                $.post( "include/excelToPdf.php", {
                  fileName: extension[0]
                }, function(response,status){
                  console.log(response)
                  if(response == "succes"){
                    showFlashMessage("Upload excel Succes", "success")
                  }
                })
              }else if(extension[1] == "docx" || extension[1] == "doc"){
                console.log(extension[0])
                $.post( "include/wordToPdf.php", {
                  fileName: extension[0]
                }, function(response,status){
                  console.log(response)
                  if(response == "succes"){
                    showFlashMessage("Upload word Succes", "success")
                  }
                })
              }

            }else{
              showFlashMessage("Upload pdf Succes","success")
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
