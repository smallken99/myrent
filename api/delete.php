<?php

 require 'db_config.php';

 $ROOM  = $_POST["ROOM"];
 $BEGIN_DATE  = $_POST["BEGIN_DATE"];
 
 $sql = "UPDATE  dtsf01 SET `STATUS` = 'N' WHERE ROOM = '".$ROOM."' AND BEGIN_DATE = '".$BEGIN_DATE."' ";

 $result = $mysqli->query($sql);

 echo json_encode([$id]);
 
?>