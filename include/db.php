<?php
class db {

  var $con;
  var $query;
  var $stmt;
  var $insertid;
  var $executed = false;

  function __construct($con)
  {
    $this->con = $con;
    // echo $con;
  }

  function setQuery($q){
    $this->query = $q;
  }

  function prepare($q = ""){
    if ($q == "") {
      $q = $this->query;
    }
    else {
      $this->query = $q;
    }

    if (false === ($this->stmt = $this->con->prepare($q))) {
      echo 'error preparing statement: ' . $this->con->error;
    }
  }

  function bindParam($s, ...$params){
    if (false === ($this->stmt->bind_param($s, ...$params))) {
      echo 'error binding params to statement: ' . $this->con->error;
    }
  }

  function execute($c = false){
    if (false === ($this->stmt->execute())) {
      echo 'error executing statement: ' . $this->stmt->error;
    }
    else{
      $this->insertid = $this->stmt->insert_id;
      $this->executed = true;
    }
    if ($c) {
      $this->stmt->close();
    }
  }

  function close(){
    $this->stmt->close();
  }

  function getResult(){
    $e = $this->executed;
    if (!$e) {
      $this->execute();
    }
    $result = $this->stmt->get_result();
    $returnAr = [];
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      $returnAr[] = $row;
    }
    return $returnAr;
  }

  function insert_id(){
    return $this->insertid;
  }
}
?>
