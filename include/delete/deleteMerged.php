<?php
include '../database.php';
$merged = $_POST['id'];
$versionids = [];
$sql = "SELECT id FROM versions WHERE mergedfiles_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
  array_push($versionids, $row['id']);
}
$stmt->close();
$questionStr = "";
foreach ($versionids as $key => $value) {
  $questionStr .= "," . $value;
}
$questionStr = substr($questionStr, 1);
$sql = "DELETE FROM `attached-files` WHERE versions_id IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM `versions` WHERE `id` IN($questionStr)";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM `mergedfiles` WHERE `id` = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $merged);
$stmt->execute();
$stmt->close();
echo "succes";
?>
