<?php
include 'include/get/getColleges.php';
include 'include/get/getPermissions.php';

$currentPage = explode("/",$_SERVER['PHP_SELF'])[2];
$page = false;

if($currentPage == "bronteksten.php"){
  $page = true;

  dump($colleges, "");
  dump($permissions, "");
}

$permitedColleges = [];

foreach ($colleges as $key => $college) {
  foreach ($permissions as $key => $permission) {
    if($permission["colleges_id"] == $college["id"]){
      $permitedColleges[] = $college;
    }
  }
}

// dump($permitedColleges,"");


 ?>

<!-- all global modals will be saved here -->
<div id="uploadModal" class="modal">
  <div class="modal-content">
    <div class = "file-field input-field">
      <div class = "btn">
        <span>Browse</span>
        <input type="file" id="uploadMultiple" multiple />
      </div>
      <div class = "file-path-wrapper">
        <input class = "file-path validate" type = "text"
        placeholder = "Upload multiple files" />
      </div>
      <?php if($page == true){ ?>
        <div class="row">
          <div class="input-field col s6">
            <select class="js-college-select">
              <?php foreach ($permitedColleges as $key => $pCollege): ?>
                <option value="<?= $pCollege["id"] ?>"><?= $pCollege["name"] ?></option>
              <?php endforeach; ?>
            </select>
            <label>College</label>
          </div>
          <div class="input-field col s6">
            <select class="js-courseContainer-<?= $user["id"] ?>">
              <?php foreach ($permitedColleges[0]["courses"] as $key => $pCourse): ?>
                <option value="<?= $pCourse["id"] ?>"><?= $pCourse["name"] ?></option>
              <?php endforeach; ?>
            </select>
            <label>Opleiding</label>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="waves-effect waves-green btn-flat js-upload-multiple">Upload</a>
  </div>
</div>
<div id="editModal" class="modal">
  <div class="modal-content">
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file" id="uploadSingle">
      </div>
      <div class="file-path-wrapper">
        <input class = "file-path validate" type = "text"
        placeholder = "Upload file" />
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="waves-effect waves-green btn-flat js-upload">Upload</a>
  </div>
</div>
