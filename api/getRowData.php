<?php
require 'db_config.php';

 


$ROOM = $_GET["ROOM"];
$INPUT_DATE = $_GET['INPUT_DATE'];


$sql = "SELECT * FROM `DTSF02` where `ROOM` = '".$ROOM."' AND INPUT_DATE = '".$INPUT_DATE."' ";


  $result = mysql_query($sql);

  $json = array();
  while($row=mysql_fetch_assoc($result)){

     $json[] = $row;

  }

  $data['data'] = $json;



echo json_encode($data);

?>
