<?php
require 'db_config.php';


  $sql="SELECT * FROM `DTSF01` WHERE `STATUS` = 'Y' ORDER BY `ROOM` "; 


  $result=mysql_query($sql);

  $json=array();

  while($row=mysql_fetch_assoc($result)){

     $json[]=$row;

  }

  $data['data']=$json;
  $data['total']=10;

  echo json_encode($data);
  mysql_close($Link);
?>
