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
  // $sql = "SELECT a.pages,
  // s.name,
  // s.id as sourcefiles_id,
  // s.extension,
  // m.name as mergedName
  // FROM  `attached-files` a,
  // sourcefiles s,
  // versions v,
  // mergedfiles m
  // WHERE a.versions_id = ?
  // AND v.id = a.versions_id
  // AND v.mergedfiles_id = m.id";
  $sql = "SELECT  a.pages,
                  v.id as merged_versionid, v.version as merged_version,
                  m.id as mergedfile_id, m.name as mergedfile_name,
                  vs.version as sourcefile_version, vs.id as sourcefile_versionid,
                  s.name as sourcefile_name
          FROM `attached-files` a
          INNER JOIN versions v ON a.versions_id = v.id
          INNER JOIN mergedfiles m ON m.id = v.mergedfiles_id
          INNER JOIN versions vs ON a.sourcev_id = vs.id
          INNER JOIN sourcefiles s ON vs.sourcefiles_id = s.id
          WHERE a.versions_id = ?";
  if (false === ($stmt = $conn->prepare($sql))) {
    echo 'error preparing statement: ' . $conn->error;
  }
  elseif (!$stmt->bind_param("i", $mergeId)) {
    echo 'error binding params: ' . $stmt->error;
  }
  elseif (!$stmt->execute()) {
    echo 'error executing statement: ' . $stmt->error;
  }
  $itemName = -1;
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
    $itemName = $row["mergedName"];
    $i = count($itemArrays);
    $itemArrays[] = $row;
    $itemArrays[$i]["folder"] = getFolder($row["extension"]);
  }
  $stmt->close();
  dump($itemArrays);
}

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
                                        <input id="pagenrs" type="text" class="validate js-pages">
                                        <label for="pagenrs">Pagina's</label>
                                      </div>
                                    </div>
                                    <div class="card-action file__links">
                                      <a class='dropdown-trigger btn' href='#' data-target='dropdown<?=$file['sourcefiles_id']?>'>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <ul id='dropdown' class='dropdown-content'>
                                        <li>
                                          <a href="_pdf/<?=$file['sourcefile_name']?>.pdf" download>pdf</a>
                                        </li>
                                        <li>
                                          <a href="<?=$file['folder']?>/<?=$file['sourcefile_name']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
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
          <?php if(isset($itemArrays)){ foreach ($itemArrays as $key => $file): ?>
            <li data-name="<?=$file['name']?>" data-ext="<?=$file['extension']?>" class="p1 mb1 item file active file--dragged" draggable="true" role="option" aria-grabbed="false">
              <div class="card">
                <div class="card-content card-content-nopad">
                  <span class="card-title file__title">
                    <i class="material-icons">insert_drive_file</i>
                    <span class="file__name"><?=$file['name']?></span>
                  </span>
                  <div class="input-field inline file__pagenrs">
                    <input id="pagenrs" type="text" class="validate js-pages" value="<?=$file["pages"]?>">
                    <label for="pagenrs">Pagina's</label>
                  </div>
                </div>
                <div class="card-action file__links">
                  <a class='dropdown-trigger btn' href='#' data-target='dropdown<?=$file['sourcefiles_id']?>'>
                    <i class="fa fa-download" aria-hidden="true"></i>
                  </a>
                  <ul id='dropdown' class='dropdown-content'>//random id
                    <li>
                      <a href="_pdf/<?=$file['sourcefile_name']?>.pdf" download>pdf</a>
                    </li>
                    <li>
                      <a href="<?=$file['folder']?>/<?=$file['name']?>.<?=$file['extension']?>" download><?=$file['extension']?></a>
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
          <?php if(!isset($itemName)){?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName">
          <?php }else{ ?>
            <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName" value="<?=$itemName?>">
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
