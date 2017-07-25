<?php
require 'db_config.php';


  $sql="SELECT * FROM `DTSF03` WHERE 1"; 


  $result=mysql_query($sql);

  $json=array();

  while($row=mysql_fetch_assoc($result)){

     $json[]=$row;

  }

  $data['rows']=$json;
  
  echo json_encode($data);
  mysql_close($Link);
?>
