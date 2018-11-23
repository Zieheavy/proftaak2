<?php
include 'include/session.php';
include 'include/database.php';

// dump($_SESSION);
$id = $_SESSION['userId'];

$itemArrays = [];
$sql = "SELECT  m.id as mergedId,
                m.name,
                m.users_id as creatorId,
                m.courses_id,
                p.read,
                p.edit,
                u.username,
                c.name as collageName,
                z.name as courseName,
                z.colleges_id
                FROM  mergedfiles m,
                      permissions p,
                      users u,
                      colleges c,
                      courses z WHERE p.users_id = ? AND
                                      p.read = 1 AND
                                      u.id = m.users_id AND
                                      z.id = m.courses_id AND
                                      c.id = z.colleges_id ORDER BY p.colleges_id ASC,
                                                                    m.courses_id ASC,
                                                                    m.name ASC";
if (false === ($stmt = $conn->prepare($sql))) {
    echo 'error preparing statement: ' . $conn->error;
}
elseif (!$stmt->bind_param("i", $id)) {
    echo 'error binding params: ' . $stmt->error;
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
}

// dump($itemArrays);
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
    <?php foreach($itemArrays as $item){ ?>
      <div class="home-card col m10 offset-m1">
        <div class="card horizontal">
          <div class="card-image">
              <?php
                $fileName = "";
                $fileName .= $item["name"] . "_";
                $fileName .= $item["versions"][count($item["versions"]) - 1]["version"];
              ?>
              <iframe class="iframe" src="_completed\<?php echo $fileName ?>.pdf"></iframe>
          </div>
          <div class="card-stacked">
            <span class="card-title center"><?php echo $item["name"] ?></span>
            <div class="card-content">
              <p>CreatorName: <?php echo $item["username"]; ?></p>
              <p>Datum:       00-00-0000</p>
              <p>College:     <?php echo $item["collageName"]; ?></p>
              <p>Opleiding:   <?php echo $item["courseName"]; ?></p>
            </div>
            <div class="card-action home-card-action">
              <?php if($_SESSION["collegeId"] == $item["colleges_id"] && $item["edit"] == 1){ ?>
                <a href="#">Edit</a>
              <?php } ?>
              <a href="#">Download</a>
              <div class="input-field">
                <select class="js-versionSelect" data-name="<?php echo $item["name"] ?>">
                  <?php
                    $counter = 0;
                    $echoVar = "";
                    foreach ($item["versions"] as $version) {
                      $counter++;
                      $ver = $version["version"];
                      $echoVar .= '<option value="' . $ver . '"';
                      if($counter == count($item["versions"])){
                        $echoVar .= " selected";
                      }
                      $echoVar.= '> ' . $ver . '</option>';
                    }
                    echo $echoVar;
                  ?>
                </select>
                <label>Versie</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>



  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>

  <div class="container"></div>

  <?php include 'partials/scripts.html'; ?>
  <script src="dest/js/main.js" charset="utf-8"></script>
</body>
</html>
