<?php
include 'include/database.php';
include 'include/session.php';
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
dump($files, "");
// die();

// REstructures the array into a multi-dimensional array, where the keys are the colleges and courses
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

if(isset($_GET["v"])){
  $mergeId = $_GET["v"];
  $itemArrays = [];
  $sql = "SELECT
            v.version,
            v.filedate,
            v.id as versionId,
            m.name
          FROM
            versions v,
            mergedfiles m
          WHERE v.id = ?
            AND v.mergedfiles_id = m.id";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $mergeId);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $temp = [];
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
              AND v.sourcefiles_id = s.id";
    if (false === ($stmt2 = $conn->prepare($sql2))) {
      echo 'error preparing statement: ' . $conn->error;
    }
    $stmt2->bind_param("i", $row["versionId"]);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC))
    {
      $row2["folder"] = getFolder($row2["extension"]);
      $temp[] = $row2;
    }
    $stmt2->close();

    $row["sources"] = $temp;
    $itemArrays = $row;
  }
  $stmt->close();
}
dump($itemArrays ,"");

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
    <div class="row">
      <div class="col s4">
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
                                  data-versionid="<?=$file['versions'][count($file['versions']) - 1]['id']?>"
                                  class="p1 mb1 item file active" draggable="true" role="option" aria-grabbed="false" ondrag="isDragging()">
                                  <div class="card card--file">
                                    <div class="card-content card-content-nopad">
                                      <span class="card-title file__title">
                                        <i class="material-icons">insert_drive_file</i>
                                        <span class="file__name"><?=$file['sourcefile_name']?></span>
                                      </span>
                                      <div class="input-field inline file__pagenrs">
                                        <input id="pagenrs<?=$file['sourcefiles_id']?>" type="text" class="validate js-pages">
                                        <label for="pagenrs<?=$file['sourcefiles_id']?>">Pagina's</label>
                                      </div>
                                    </div>
                                    <div class="card-action file__links">
                                      <a class='dropdown-trigger btn' href='#' data-target='dropdown<?=$file['sourcefiles_id']?>'>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <ul id='dropdown' class='dropdown-content'>
                                        <li>
                                          <a href="_pdf/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.pdf" download>pdf</a>
                                        </li>
                                        <li>
                                          <a href="<?=$file['folder']?>/<?=$file['sourcefile_name']?>_<?=$file['versions'][count($file['versions']) - 1]['version']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
                                        </li>
                                      </ul>
                                      <a class="btn js-delete-file" href="#">
                                        <i class="material-icons">delete</i>
                                      </a>
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
      <div class="col s4">
        <ul class="js-sortable-copy-target copy-target col-min-500" style="min-height: 200px"aria-dropeffect="move">
          <?php if(isset($itemArrays)){ foreach ($itemArrays["sources"] as $key => $file): ?>
            <li data-name="<?=$file['name']?>" data-ext="<?=$file['extension']?>" data-version="<?=$file['version']?>" class="p1 mb1 item file active file--dragged" draggable="true" role="option" aria-grabbed="false" ondrag="isDragging()" aria-copied="true">
              <div class="card card--file">
                <div class="card-content card-content-nopad">
                  <span class="card-title file__title">
                    <i class="material-icons">insert_drive_file</i>
                    <span class="file__name"><?=$file['name']?></span>
                  </span>
                  <div class="input-field inline file__pagenrs">
                    <input id="pagenrs<?=$file['sourceId']?>" type="text" class="validate js-pages" value=<?=$file['pages']?>>
                    <label for="pagenrs<?=$file['sourceId']?>">Pagina's</label>
                  </div>
                </div>
                <div class="card-action file__links">
                  <a class="dropdown-trigger btn drp" href="#" data-target="dropdown<?=$file['sourceId']?>">
                    <i class="fa fa-download" aria-hidden="true"></i>
                  </a><ul id="dropdown<?=$file['sourceId']?>" class="dropdown-content" tabindex="0" style="">
                    <li tabindex="0">
                      <a href="_pdf/<?=$file["name"]?>_<?=$file["version"]?>.pdf" download="">pdf</a>
                    </li>
                    <li tabindex="0">
                      <a href="<?=$file["folder"]?>/<?=$file["name"]?>_<?=$file["version"]?>.<?=$file["extension"]?>" download=""><?=$file["extension"]?></a>
                    </li>
                  </ul>
                  <a class="btn js-delete-file" href="#">
                    <i class="material-icons">delete</i>
                  </a>
                </div>
              </div>
            </li>
          <?php endforeach; } ?>
        </ul>
      </div>
      <div class="col s4">
        <iframe class="js-frm preview" src="" width="" height=""></iframe>
        <div class="input-field col s6">
          <?php if(!isset($itemArrays["name"])){?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName">
          <?php }else{ ?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName" value="<?=$itemArrays["name"]?>">
          <?php } ?>
          <label for="merged_name">First Name</label>
        </div>
        <div class="btn waves-effect waves-light w100 js-merge">Merge</div>
      </div>
    </div>
  </div>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <script src="dest/js/html5sortable.min.js" charset="utf-8"></script>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
