<?php
include 'include/database.php';
include 'include/session.php';
include 'include/get/getPermissions.php';

$sourceFiles = [];
$sql = "SELECT
          s.name,
          s.extension,
          s.id as sourceId,
          c.id as collegeId,
          c.name as collegeName,
          co.name as courseName
        FROM
          sourcefiles s,
          colleges c,
          courses co
        WHERE s.colleges_id = c.id
          AND s.courses_id = co.id
        ORDER BY  c.name ASC,
                  co.name ASC,
                  s.name ASC";
if (false === ($stmt = $conn->prepare($sql))) {
  echo 'error preparing statement: ' . $conn->error;
}
// $stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $sourceFiles[] = $row;
}
$stmt->close();

dump($sourceFiles,"");
dump($permissions,"");

?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <?php include 'partials/navigation.php'; ?>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <div class="container">
    <div class="row">
      <a class="col s12 waves-effect waves-light btn modal-trigger" href="#uploadModal">button</a>
    </div>
    <div class="row">
      <div class="col s4">
        <?php include 'partials/courseList.php'; ?>
      </div>
      <div class="col s8">
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input class="js-merge" type="text" id="autocomplete-input" class="autocomplete">
            <label for="autocomplete-input">Search</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <div class="row">
              <?php foreach ($sourceFiles as $key => $file): ?>
                <?php foreach ($permissions as $key => $permission): ?>
                  <?php if($file["collegeId"] == $permission["colleges_id"] && $permission["read"] == 1){ ?>
                  <div class="col s12 m6 js-source-files" data-course="<?=$file["courseName"]?>" data-name="<?=$file["name"]?>" data-id="<?=$file["id"]?>" data-ext="<?=$file["extension"]?>">
                    <div class="card">
                      <div class="card-content">
                        <span class="card-title"><?=$file["name"]?></span>
                          <p>college: <?=$file["collegeName"]?></p>
                          <p>course: <?=$file["courseName"]?></p>
                        <p></p>
                      </div>
                      <div class="card-action">
                        <?php if($permission["edit"] == 1){ ?>
                          <a class="js-open-edit">edit</a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } endforeach; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class = "row">
      <label>Materialize Multi File Input</label>
      <div class = "file-field input-field">
        <div class = "btn">
          <span>Browse</span>
          <input type="file" id="uploadFiles" multiple />
        </div>
        <div class = "file-path-wrapper">
          <input class = "file-path validate" type = "text"
          placeholder = "Upload multiple files" />
        </div>
      </div>
    </div> -->
    <!-- <div class="row">
      <button class="js-ok">Upload</button>
    </div> -->
  </div>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
