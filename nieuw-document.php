<?php
include 'include/database.php';
include 'include/functions.php';
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
  $files[] = $row;
}
$stmt->close();
$newfiles = [];
foreach ($files as $key => $file) {
  $ext = $file['extension'];
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
  $file['folder'] = $folder;
  if (!isset($newfiles[$file['colleges_name']])) {
    $newfiles[$file['colleges_name']] = [];
  }
  if (!isset($newfiles[$file['colleges_name']][$file['courses_name']])) {
    $newfiles[$file['colleges_name']][$file['courses_name']] = [];
  }
  array_push($newfiles[$file['colleges_name']][$file['courses_name']], $file);
}
$files = $newfiles;
dump($files, "");
?>
<html>
<head>
  <title>Proftaak</title>
  <?php include 'partials/head.html'; ?>
</head>
<body>
  <div class="flash-message-container"> </div>
  <?php include 'partials/navigation.php'; ?>
  <div class="container">
    <div class="row">
      <div class="col s4">
        <h4>Bestanden</h4>
        <?php foreach ($files as $key => $college): ?>
          <ul class="collapsible expandable" data-collapsible="accordion">
          	<li class="collapsible-expand active">
          		<div class="collapsible-header">
          			<div class="collapsible-header-text"><?=$key?></div>
              </div>
          		<div class="collapsible-body no-border-bot">
          			<div class="row">
          				<div class="col s12 m12">
          					<ul class="collapsible expandable" data-collapsible="accordion">
                      <?php foreach ($college as $key => $course): ?>
                        <li class="collapsible-expand active">
                          <div class="collapsible-header">
                            <div class="collapsible-header-text"><?=$key?></div>
                          </div>
                          <div class="collapsible-body">
                            <ul class="js-sortable-copy" aria-dropeffect="move">
                              <?php foreach ($course as $key => $file): ?>
                                <li data-name="<?=$file['sourcefile_name']?>" data-ext="<?=$file['extension']?>" class="p1 mb1 item file active" draggable="true" role="option" aria-grabbed="false">
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
    		</ul>
      </div>
      <div class="col s4">
        <iframe class="js-frm preview" src="" width="" height=""></iframe>
        <div class="input-field col s6">
          <input placeholder="Merged name" id="merged_name" type="text" class="validate js-mergedName">
          <label for="merged_name">First Name</label>
        </div>
        <div class="btn waves-effect waves-light w100 js-merge">Merge</div>
      </div>
    </div>
  </div>
  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <?php include 'partials/scripts.html'; ?>

  <script src="dest/js/html5sortable.min.js" charset="utf-8"></script>
  <script src="dest/js/newDocument.js" charset="utf-8"></script>
  </body>
  </html>
