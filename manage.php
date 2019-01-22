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
  header("Location: include/noPermissions.php");
}

$users = [];
//selects all th euser from the database
$sql = "SELECT * FROM `users`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $users[] = $row;
}
$stmt->close();

for($j = 0; $j < count($users); $j++){
  $colleges = [];
  //selects all the colleges from the database with clearer names
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
    //gets all the permsion for the selected user from the correct college
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

//checks what permison you have and adds them to a string
if($permNew == 1){
  $permStat .= 1;
}
if($permConfirm == 1){
  $permStat .= 2;
}
if($permAdmin == 1){
  $permStat = 123;
}

//removes the admin from the user list
if($permAdmin == 0){
  array_shift($users);
}

//checks how many permision the user has
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
      <?php if(strpos($permStat, '1') !== false){ ?>
        <!-- <div class="row">
          <div class="col s6">
            <a class="s12 col waves-effect waves-light btn modal-trigger" href="#newCollege">Nieuwe college</a>
          </div>
          <div class="col s6">
            <a class="s12 col waves-effect waves-light btn modal-trigger" href="#newCourse">Nieuwe opleiding</a>
          </div>
        </div>
        <div class="row">
          <div class="col s6">
            <a class="s12 col waves-effect waves-light btn modal-trigger" href="#deleteCollege">Delete college</a>
          </div>
          <div class="col s6">
            <a class="s12 col waves-effect waves-light btn modal-trigger" href="#deleteCourse">Delete opleiding</a>
          </div>
        </div> -->
      <?php } ?>
    <div class="row">
      <div class="col s12">
        <?php foreach ($users as $key => $user): ?>
          <?php if ($_SESSION["userId"] != $user["id"]) { ?>
            <div class="col xl6 l12">
              <div class="card col s12" data-id="<?= $user["id"] ?>" data-name="<?= $user["username"] ?>">
                <div class="card-content">
                  <span class="card-title"><?= $user["username"] ?></span>
                  <?php if($user["colleges_id"] == $_SESSION["collegeId"] || $permAdmin == 1){ ?>
                    <?php if(strpos($permStat, '1') !== false){ ?>
                      <label class="col s<?= $permCollums ?>">
                        <input class="js-new" type="checkbox" <?php if($user["newcollege"] == 1) echo "checked=\"checked\""; ?>/>
                        <span>new college</span>
                      </label>
                    <?php } ?>
                    <?php if(strpos($permStat, '2') !== false){ ?>
                      <label class="col s<?= $permCollums ?>">
                        <input class="js-confirm" type="checkbox" <?php if($user["confirm"] == 1) echo "checked=\"checked\""; ?>/>
                        <span>verify user</span>
                      </label>
                    <?php } ?>
                    <?php if(strpos($permStat, '3') !== false){ ?>
                      <label class="col s<?= $permCollums ?>">
                        <input class="js-admin" type="checkbox" <?php if($user["admin"] == 1) echo "checked=\"checked\""; ?>/>
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
                    <tbody class="js-perm-container">
                      <?php foreach ($user["colleges"] as $key => $college): ?>
                        <?php if($college["collegeId"] == $_SESSION["collegeId"] || $permAdmin == 1){?>
                          <tr class="js-perm-rows" data-collegeid="<?=$college["collegeId"]?>">
                            <form>
                              <td><?= $college["collegeName"] ?></td>
                              <td>
                                <label>
                                  <input class="read" type="checkbox" <?php if(isset($college["read"]) && $college["read"] == 1) echo "checked=\"checked\""; ?> />
                                  <span></span>
                                </label>
                              </td>
                              <td>
                                <label>
                                  <input class="edit" type="checkbox" <?php if(isset($college["edit"]) && $college["edit"] == 1) echo "checked=\"checked\""; ?> />
                                  <span></span>
                                </label>
                              </td>
                            </form>
                          </tr>
                        <?php } ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col s6">
                      <a class="waves-effect waves-light btn col s12 js-perm-update">SAVE</a>
                    </div>
                    <div class="col s6">
                      <a class="waves-effect waves-light btn col s12 js-delete-user">delete</a>
                    </div>
                  </div>
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
            </div>
          <?php } ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php if(strpos($permStat, '1') !== false){ ?>
    <div class="fixed-action-btn">
      <a class="btn-floating floating-btn-activate btn">
        <i class="large material-icons">mode_edit</i>
      </a>
      <ul class="floating-btn-container">
        <li><a class="btn-floating floating-btn waves-effect waves-light btn modal-trigger" href="#newCollege">Nieuwe college</a></li>
        <li><a class="btn-floating floating-btn waves-effect waves-light btn modal-trigger" href="#newCourse">Nieuwe opleiding</a></li>
        <li><a class="btn-floating floating-btn waves-effect waves-light btn modal-trigger" href="#deleteCollege">Delete college</a></li>
        <li><a class="btn-floating floating-btn waves-effect waves-light btn modal-trigger" href="#deleteCourse">Delete opleiding</a></li>
      </ul>
    </div>
  <?php } ?>

  <?php include 'partials/templates.html'; ?>
  <?php include 'partials/modals.php'; ?>
  <?php include 'partials/scripts.php'; ?>
</body>
</html>
