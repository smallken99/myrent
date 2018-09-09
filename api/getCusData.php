<?php
require 'db_config.php';

 


$ROOM = $_POST["ROOM"];
$BEGIN_DATE = $_POST["BEGIN_DATE"];
 

$sql = "SELECT * FROM `DTSF01` where `ROOM` = '".$ROOM."' AND
	   `BEGIN_DATE` = '".$BEGIN_DATE."'"; 

 
//echo $sql;
  $result = mysql_query($sql);

  $json = array();
  while($row=mysql_fetch_assoc($result)){

     $json[] = $row;

  }

  $data['data'] = $json;



echo json_encode($data);

?>
