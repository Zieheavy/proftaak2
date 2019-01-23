<?php
include 'include/database.php';
include 'include/session.php';

// // This query gets every sourceFile
include 'include/get/getPermissions.php';

// This query gets every sourceFile
$files = [];
$sql = "SELECT s.id as sourcefiles_id,
          s.name as sourcefile_name,
          s.extension,
          u.id as users_id,
          u.username as users_name,
          c.id as colleges_id,
          c.name as colleges_name,
          co.id as courses_id,
          co.name as courses_name
        FROM sourcefiles s
        INNER JOIN users u ON s.users_id = u.id
        INNER JOIN colleges c ON s.colleges_id = c.id
        INNER JOIN courses co ON s.courses_id = co.id";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  //gets all the versions from the selected source file
  $sql2 = "SELECT * FROM versions WHERE sourcefiles_id = ? ORDER BY version";
  $stmt2 = $con->prepare($sql2);
  $stmt2->bind_param('i', $row['sourcefiles_id']);
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  while ($row2 = $result2->fetch_array(MYSQLI_ASSOC))
  {
    $row["versions"][] = $row2;
  }
  $stmt2->close();
  $files[] = $row;
}
$stmt->close();

//Restructures the array into a multi-dimensional array, where the keys are the colleges and courses
$newfiles = [];
foreach ($files as $key => $file) {
  $ext = $file['extension'];
  $file['folder'] = getFolder($ext);
  if (!isset($newfiles[$file['colleges_name']])) {
    $newfiles[$file['colleges_name']] = [];
  }
  if (!isset($newfiles[$file['colleges_name']][$file['courses_name']])) {
    $newfiles[$file['colleges_name']][$file['courses_name']] = [];
  }
  array_push($newfiles[$file['colleges_name']][$file['courses_name']], $file);
}
$files = $newfiles;

//checks if you want to edit the page
if(isset($_GET["v"])){
  $itemArrays = [];
  $mergeId = $_GET["v"];
  //gets the correct version of the selected file
  $sql = "SELECT
            v.version,
            v.filedate,
            v.id as versionId,
            m.name
          FROM
            versions v,
            mergedfiles m
          WHERE v.id = ?
            AND v.mergedfiles_id = m.id
          ORDER BY v.id ASC";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $mergeId);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $temp = [];
    //gets all the files that where to create the document
    $sql2 = "SELECT
              a.pages,
              v.version,
              s.name,
              s.extension,
              s.id as sourceId
            FROM
              `attached-files` a,
              `versions` v,
              `sourcefiles` s
            WHERE a.versions_id = ?
              AND a.sourcev_id = v.id
              AND v.sourcefiles_id = s.id
            ORDER BY a.id ASC";
    if (false === ($stmt2 = $conn->prepare($sql2))) {
      echo 'error preparing statement: ' . $conn->error;
    }
    $stmt2->bind_param("i", $row["versionId"]);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC))
    {
      $row2["folder"] = getFolder($row2["extension"]);
      //gets all the version of the selected sourcefile
      $sql3 = "SELECT * FROM versions WHERE sourcefiles_id = ? ORDER BY version";
      $stmt3 = $con->prepare($sql3);
      $stmt3->bind_param('i', $row2['sourceId']);
      $stmt3->execute();
      $result3 = $stmt3->get_result();
      while ($row3 = $result3->fetch_array(MYSQLI_ASSOC))
      {
        $row2["versions"][] = $row3;
      }
      $stmt3->close();
      $temp[] = $row2;
    }
    $stmt2->close();

    $row["sources"] = $temp;
    $itemArrays = $row;
  }
  $stmt->close();
}

//gets the folder for the selected extension
function getFolder($ext){
  $folder = "";
  switch ($ext) {
    case 'docx':
    case 'doc':
    $folder = "_docs";
    break;
    case 'xlsx':
    case 'xls':
    case 'xlsm':
    $folder = "_excel";
    break;
    default:
    $folder = "_pdf";
    break;
  }
  return $folder;
}
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div id="dragScrolTop" class="scroll scroll--top"></div>
  <div id="dragScrolBot" class="scroll scroll--bot"></div>
  <?php include 'partials/navigation.php'; ?>
  <div class="container">
    <div class="row hide-on-med-and-up show-on-medium-and-down">
      <div class="input-field col s12 m6">
        <?php if(!isset($itemArrays["name"])){?>
          <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName">
        <?php }else{ ?>
          <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName" value="<?=$itemArrays["name"]?>">
        <?php } ?>
        <label for="merged_name">First Name</label>
      </div>
      <div class="col s12 m6">
        <?php if(!isset($_GET["v"])){ ?>
          <div class="btn waves-effect waves-light w100 js-merge">Merge</div>
        <?php }else{ ?>
          <div class="btn waves-effect waves-light w100 js-merge">Update</div>
        <?php } ?>
      </div>
    </div>
    <div class="row">
      <div class="col s6 l4 drag-container">
        <h4>Bestanden</h4>
        <?php foreach ($files as $key => $college): ?>
          <ul class="collapsible expandable noMargin" data-collapsible="accordion">
            <li class="collapsible-expand active">
              <div class="collapsible-header">
                <div class="collapsible-header-text"><?=$key?></div>
              </div>
              <div class="collapsible-body no-border-bot">
                <div class="row">
                  <div class="col s12 m12">
                    <ul class="collapsible expandable noMargin" data-collapsible="accordion">
                      <?php foreach ($college as $key => $course): ?>
                        <li class="collapsible-expand active">
                          <div class="collapsible-header">
                            <div class="collapsible-header-text"><?=$key?></div>
                          </div>
                          <div class="collapsible-body">
                            <ul class="js-sortable-copy" aria-dropeffect="move">
                              <?php foreach ($course as $key => $file): ?>
                                <li data-name="<?=$file['sourcefile_name']?>"
                                  data-ext="<?=$file['extension']?>"
                                  data-version="<?=$file['versions'][count($file['versions']) - 1]['version']?>"
                                  class="p1 mb1 item file active" draggable="true" role="option" aria-grabbed="false" ondrag="isDragging()">
                                  <div class="card card--file">
                                    <div class="card-content card-content-nopad">
                                      <span class="card-title file__title">
                                        <i class="material-icons">insert_drive_file</i>
                                        <span class="file__name"><?=$file['sourcefile_name']?></span>
                                      </span>
                                      <div class="input-field inline file__pagenrs">
                                        <?php $random = randomString();?>
                                        <input id="pagenrs<?=$file['sourcefiles_id'].$random?>" type="text" class="validate js-pages pageNrs">
                                        <label for="pagenrs<?=$file['sourcefiles_id'].$random?>">Pagina's</label>
                                      </div>
                                    </div>
                                    <div class="card-action file__links hide-on-small-only">
                                      <a class='dropdown-trigger btn w30' href='#' data-target=''>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <ul class='dropdown-content'>
                                        <li>
                                          <a class="js-download-pdf" href="_pdf/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.pdf" download>pdf</a>
                                        </li>
                                        <li>
                                          <a class="js-download-doc" href="<?=$file['folder']?>/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
                                        </li>
                                      </ul>
                                      <button class="btn js-delete-file w30">
                                        <i class="material-icons">delete</i>
                                      </button>
                                      <div class="input-field w30">
                                        <select class="js-version-select">
                                          <?php foreach ($file['versions'] as $key => $version): ?>
                                            <option value="<?=$version['version']?>"><?=$version['version']?></option>
                                          <?php endforeach; ?>
                                        </select>
                                        <label>Versie</label>
                                      </div>
                                    </div>
                                    <div class="card-action file__links show-on-small hide-on-med-and-up">
                                      <a class='dropdown-trigger btn w100' href='#' data-target=''>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <ul class='dropdown-content'>
                                        <li>
                                          <a class="js-download-pdf" href="_pdf/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.pdf" download>pdf</a>
                                        </li>
                                        <li>
                                          <a class="js-download-doc" href="<?=$file['folder']?>/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
                                        </li>
                                      </ul>
                                      <button class="btn js-delete-file w100">
                                        <i class="material-icons">delete</i>
                                      </button>
                                      <div class="input-field w100">
                                        <select class="js-version-select">
                                          <?php foreach ($file['versions'] as $key => $version): ?>
                                            <option value="<?=$version['version']?>"><?=$version['version']?></option>
                                          <?php endforeach; ?>
                                        </select>
                                        <label>Versie</label>
                                      </div>
                                    </div>
                                  </div>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        <?php endforeach; ?>
      </div>
      <div class="col s6 l4 drop-container">
        <ul class="js-sortable-copy-target copy-target col-min-500" style="min-height: 200px" aria-dropeffect="move">
          <?php if(isset($itemArrays)){ foreach ($itemArrays["sources"] as $key => $file): ?>
            <li data-name="<?=$file['name']?>"
              data-ext="<?=$file['extension']?>"
              data-version="<?=$file['version']?>"
              class="p1 mb1 item file active file--dragged" draggable="true" role="option" aria-grabbed="false" ondrag="isDragging()">
              <div class="card card--file">
                <div class="card-content card-content-nopad">
                  <span class="card-title file__title">
                    <i class="material-icons">insert_drive_file</i>
                    <span class="file__name"><?=$file['name']?></span>
                  </span>
                  <div class="input-field inline file__pagenrs">
                    <?php $random = randomString();?>
                    <input id="pagenrs<?=$file['sourceId'].$random?>" value="<?=$file['pages']?>" type="text" class="validate js-pages pageNrs">
                    <label for="pagenrs<?=$file['sourceId'].$random?>">Pagina's</label>
                  </div>
                </div>
                <div class="card-action file__links hide-on-small-only">
                  <a class='dropdown-trigger btn w30' href='#' data-target=''>
                    <i class="fa fa-download" aria-hidden="true"></i>
                  </a>
                  <ul class='dropdown-content'>
                    <li>
                      <a class="js-download-pdf" href="_pdf/<?=$file['name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.pdf" download>pdf</a>
                    </li>
                    <li>
                      <a class="js-download-doc" href="<?=$file['folder']?>/<?=$file['name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
                    </li>
                  </ul>
                  <button class="btn js-delete-file w30">
                    <i class="material-icons">delete</i>
                  </button>
                  <div class="input-field w30">
                    <select class="js-version-select js-version-getselect">
                      <?php foreach ($file['versions'] as $key => $version): ?>
                        <option <?=($file['version'] == $version['version']) ? "selected" : "" ?> value="<?=$version['version']?>"><?=$version['version']?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Versie</label>
                  </div>
                </div>
                <div class="card-action file__links show-on-small hide-on-med-and-up">
                  <a class='dropdown-trigger btn w100' href='#' data-target=''>
                    <i class="fa fa-download" aria-hidden="true"></i>
                  </a>
                  <ul class='dropdown-content'>
                    <li>
                      <a class="js-download-pdf" href="_pdf/<?=$file['name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.pdf" download>pdf</a>
                    </li>
                    <li>
                      <a class="js-download-doc" href="<?=$file['folder']?>/<?=$file['name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
                    </li>
                  </ul>
                  <button class="btn js-delete-file w100">
                    <i class="material-icons">delete</i>
                  </button>
                  <div class="input-field w100">
                    <select class="js-version-select">
                      <?php foreach ($file['versions'] as $key => $version): ?>
                        <option <?=($file['version'] == $version['version']) ? "selected" : "" ?> value="<?=$version['version']?>"><?=$version['version']?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Versie</label>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach;  }?>
        </ul>
      </div>
      <div class="col l4 hide-on-med-and-down">
        <iframe class="js-frm preview" src="" width="" height=""></iframe>
        <div class="input-field col s12">
          <?php if(!isset($itemArrays["name"])){?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName">
          <?php }else{ ?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName" value="<?=$itemArrays["name"]?>">
          <?php } ?>
          <label for="merged_name">First Name</label>
        </div>
        <?php if(!isset($_GET["v"])){ ?>
          <div class="btn waves-effect waves-light w100 js-merge">Merge</div>
        <?php }else{ ?>
          <div class="btn waves-effect waves-light w100 js-merge">Update</div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.php'; ?>
  <script src="dest/js/html5sortable.min.js" charset="utf-8"></script>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
