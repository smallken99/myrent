<?php
require 'db_config.php';

 $ROOM  = $_POST["ROOM"];
 $INPUT_DATE  = $_POST["INPUT_DATE"];
 
 $sql = "DELETE FROM `DTSF02` WHERE `ROOM` = '".$ROOM."' AND `INPUT_DATE` = '".$INPUT_DATE."'";

 //echo $sql;
 mysql_query($sql); 

 echo json_encode("[$ROOM]");
?>
