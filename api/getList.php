<?php
require 'db_config.php';

 


$ROOM = $_POST["ROOM"];

if($ROOM ==''){
$ROOM = $_GET["ROOM"];
} 

$sql = "SELECT * FROM `DTSF02` where `ROOM` = '".$ROOM."' Order By  INPUT_DATE DESC "; 

 

  $result = mysql_query($sql);

  $json = array();
  while($row=mysql_fetch_assoc($result)){

     $json[] = $row;

  }

  $data['data'] = $json;



echo json_encode($data);

?>
