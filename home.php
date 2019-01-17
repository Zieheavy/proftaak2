<?php
include 'include/session.php';
include 'include/database.php';
include 'include/get/getPermissions.php';
$id = $_SESSION['userId'];
// Gets all the mergedfiles from the database
$itemArrays = [];
$sql = "SELECT
          m.id as mergedId,
          m.name,
          c.name as courseName,
          co.name as collegeName,
          co.id as collegeId,
          u.username
        FROM
          mergedfiles m,
          courses c,
          colleges co,
          users u
        WHERE m.courses_id = c.id
          AND m.users_id = u.id
          AND c.colleges_id = co.id
        ORDER BY  co.name ASC,
                  c.name ASC,
                  m.name ASC";

if (false === ($stmt = $conn->prepare($sql))) {
  echo 'error preparing statement: ' . $conn->error;
}
elseif (!$stmt->execute()) {
  echo 'error executing statement: ' . $stmt->error;
}

$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $itemArrays[] = $row;
}
$stmt->close();

// Gets the versions for every file
for($i = 0; $i < count($itemArrays); $i++){
  $tempVersionArray = [];
  $sql = "SELECT * FROM versions WHERE mergedfiles_id = ? ORDER BY version";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $itemArrays[$i]["mergedId"]);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $tempVersionArray[] = $row;
  }
  $stmt->close();
  $itemArrays[$i]["versions"] = $tempVersionArray;
  $fileName = "";
  $fileName .= $itemArrays[$i]["name"] . "_";
  $selectedVersion = $itemArrays[$i]["versions"][count($itemArrays[$i]["versions"]) - 1];
  $fileName .= $selectedVersion["version"];
  if($selectedVersion["version"] >= 5){
    $tempName = $fileName;
    $fileName = $itemArrays[$i]["name"] . "/" . $tempName;
  }
  $itemArrays[$i]['filename'] = $fileName;
}
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <?php include 'partials/navigation.php'; ?>
  <div class="container">
    <div class="row">
      <div class="col s4">
        <?php include 'partials/courseList.php'; ?>
      </div>
      <div class="col s8">
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input class="js-merge" type="text" id="autocomplete-input" class="autocomplete">
            <label for="autocomplete-input">Zoek</label>
          </div>
        </div>
        <?php
        foreach($itemArrays as $item){
          foreach ($permissions as $key => $permission):
            if($permission["colleges_id"] == $item["collegeId"] && $permission["read"] == 1){?>
              <div class="home-card col m12" id="<?=$item['mergedId']?>" data-college="<?= $item["collegeName"] ?>" data-course="<?= $item["courseName"] ?>" data-name="<?= $item["name"] ?>">
                <div class="card horizontal">
                  <div class="card-image">
                    <?php
                      $selectedVersion = $item["versions"][count($item["versions"]) - 1];
                    ?>
                    <iframe class="iframe js-lazyload-iframe" data-src="_completed/<?= $item['filename'] ?>.pdf" src=""></iframe>
                  </div>
                  <div class="card-stacked">
                    <span class="card-title center"><?= $item["name"] ?></span>
                    <div class="card-content">
                      <p>CreatorName: <?= $item["username"]; ?></p>
                      <p>Datum:       <?= $selectedVersion["filedate"]; ?></p>
                      <p>College:     <?= $item["collegeName"] ?></p>
                      <p>Opleiding:   <?= $item["courseName"]; ?></p>
                    </div>
                    <div class="card-action home-card-action">
                      <div class="row">
                        <a class='dropdown-trigger btn <?=($permission["edit"] == 1) ? "w30" : "w100"?>' href='#' data-target='drp<?=$item['mergedId']?>'>
                          <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                        <ul class='dropdown-content' id="drp<?=$item['mergedId']?>">
                          <li>
                            <a class="js-download-pdf" href="_completed\<?= $item['filename'] ?>.pdf" download>pdf</a>
                          </li>
                          <li>
                            <a class="js-download-doc" href="#" data-file="<?=$item['filename']?>">DOC</a>
                          </li>
                        </ul>
                        <?php if($permission["edit"] == 1){ ?>
                          <a href="nieuw-document.php?v=<?= $selectedVersion["id"]; ?>" class="btn w30"><i class="material-icons">edit</i></a>
                          <button class="btn w30 js-delete-merged" data-mergedid="<?=$item['mergedId']?>"><i class="material-icons">delete</i></button>
                        <?php } ?>
                      </div>
                      <div class="row">
                        <div class="input-field">
                          <select class="js-versionSelect" data-name="<?= $item["name"] ?>">
                            <?php
                            foreach ($item["versions"] as $key => $version) {
                              ?>
                              <option <?=($key == count($item["versions"]) - 1) ? "selected" : ""?> value="<?=$version['version']?>"><?=$version['version']?></option>
                              <?php
                            }
                            ?>
                          </select>
                          <label>Versie</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php endforeach; ?>
        <?php } ?>
      </div>
    </div>
  </div>

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.php'; ?>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
