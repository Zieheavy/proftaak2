<?php
include 'include/session.php';
include 'include/database.php';
$id = $_SESSION['userId'];
$menuCollums = "6";

$permNew = $_SESSION["newcollege"];
$permConfirm = $_SESSION["confirm"];
$permAdmin = $_SESSION["admin"];
$permStat = "";
$permCollums = "12";

if($permNew == 0 && $permConfirm == 0){
    header("Location: no.php");
}

$users = [];
$sql = "SELECT * FROM `users`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $users[] = $row;
}
$stmt->close();
// dump($users, "");


for($j = 0; $j < count($users); $j++){
  $colleges = [];
  $sql = "SELECT c.id as collegeId, c.name as collegeName FROM `colleges` c";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $colleges[] = $row;
  }
  $stmt->close();

  for ($i = 0; $i < count($colleges); $i++) {
    $sql = "SELECT * FROM `permissions` WHERE users_id = ? AND colleges_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $users[$j]["id"], $colleges[$i]["collegeId"]);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      $colleges[$i]["permId"] = $row["id"];
      $colleges[$i]["read"] = $row["read"];
      $colleges[$i]["edit"] = $row["edit"];
    }
    $stmt->close();
  }
  $users[$j]["colleges"] = $colleges;
}

if($permNew == 1){
  $permStat .= 1;
}
if($permConfirm == 1){
  $permStat .= 2;
}
if($permAdmin == 1){
  $permStat .= 3;
}

if(strlen($permStat) == 3){ $permCollums = "4"; }
else if(strlen($permStat) == 2){ $permCollums = "6"; }

include 'include/get/getColleges.php';

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
      <!-- <div class="col s10 offset-s1"> -->
      <div class="col s12">
        <?php foreach ($users as $key => $user): ?>
          <?php if ($_SESSION["userId"] != $user["id"]) { ?>
            <div class="card col s6" data-id="<?= $user["id"] ?>">
              <div class="card-content" style="padding-bottom: 60px">
                <span class="card-title"><?= $user["username"] ?></span>
                <?php if($user["colleges_id"] == $_SESSION["collegeId"] || $permAdmin == 1){ ?>
                  <?php if(strpos($permStat, '1') !== false){ ?>
                    <label class="col s<?= $permCollums ?>">
                      <input type="checkbox" <?php if($user["newcollege"] == 1) echo "checked=\"checked\""; ?>/>
                      <span>new college</span>
                    </label>
                  <?php } ?>
                  <?php if(strpos($permStat, '2') !== false){ ?>
                    <label class="col s<?= $permCollums ?>">
                      <input type="checkbox" <?php if($user["confirm"] == 1) echo "checked=\"checked\""; ?>/>
                      <span>verify user</span>
                    </label>
                  <?php } ?>
                  <?php if(strpos($permStat, '3') !== false){ ?>
                    <label class="col s<?= $permCollums ?>">
                      <input type="checkbox" <?php if($user["admin"] == 1) echo "checked=\"checked\""; ?>/>
                      <span>admin</span>
                    </label>
                  <?php } ?>
                <?php } ?>
                <table>
                  <thead>
                    <tr>
                        <th>College</th>
                        <th>Read</th>
                        <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($user["colleges"] as $key => $college): ?>
                      <tr>
                        <form>
                          <td><?= $college["collegeName"] ?></td>
                          <td>
                            <label>
                              <input type="checkbox" <?php if(isset($college["read"]) && $college["read"] == 1) echo "checked=\"checked\""; ?> />
                              <span></span>
                            </label>
                          </td>
                          <td>
                            <label>
                              <input type="checkbox" <?php if(isset($college["edit"]) && $college["edit"] == 1) echo "checked=\"checked\""; ?> />
                              <span></span>
                            </label>
                          </td>
                        </form>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <a class="waves-effect waves-light btn col s12">SAVE</a>
              </div>
              <?php if($user["verified"] == 0 && $permConfirm == 1){ ?>
                <div class="card-action" style="height:100px">
                  <div class="input-field col s4">
                    <select class="js-college-select">
                      <?php foreach ($colleges as $key => $college): ?>
                        <option value="<?= $college["id"] ?>"><?= $college["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>College</label>
                  </div>
                  <div class="input-field col s4">
                    <select class="js-courseContainer-<?= $user["id"] ?>">
                      <option value="-1" selected>none</option>
                      <?php foreach ($colleges[0]["courses"] as $key => $course): ?>
                        <option value="<?= $course["id"] ?>"><?= $course["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Opleiding</label>
                  </div>
                  <a class="waves-effect waves-light btn col s4 js-btn-verifiy">VERIFIY</a>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.html'; ?>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
