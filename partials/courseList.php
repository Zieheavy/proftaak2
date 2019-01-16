<?php
$colleges = [];

//gets all the colleges from the database
$sql = "SELECT * FROM colleges";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  $colleges[] = $row;
}
$stmt->close();

//loops trew all the colleges and selects the correct course
for ($i=0; $i < count($colleges); $i++) {
  $colleges[$i]["courses"] = [];
  $sql = "SELECT * FROM courses WHERE colleges_id = ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("i", $colleges[$i]["id"]);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC))
  {
    $colleges[$i]["courses"][] = $row;
  }
  $stmt->close();
}
?>

<ul class="collapsible expandable">
  <!-- loops trew all the colleges and adds them to a list -->
  <?php foreach ($colleges as $key => $college): if($college["name"] != "none"){?>
    <li class="collapsible-expand active">
      <div class="collapsible-header">
        <div class="collapsible-header-text">
          <?= $college["name"] ?>
        </div>
      </div>
      <div class="collapsible-body">
        <ul class="collection">
          <!-- loops trew all the courses and adds them to a list -->
          <?php foreach ($college["courses"] as $key => $course): ?>
            <li data-college="<?= $college["name"] ?>" data-course="<?= $course["name"] ?>" class="collection-item item-cursor js-sortableItem"><?= $course["name"] ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </li>
  <?php } endforeach; ?>
</ul>
