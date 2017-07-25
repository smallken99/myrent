<?php
require 'db_config.php';


  $INPUT_DATE  = $_POST["INPUT_DATE"];   
  $ROOM  = $_POST["ROOM"];
  $NAME  = $_POST["NAME"];
 
  $sql = "INSERT INTO `DTSF02`(`INPUT_DATE`, `ROOM`, `NAME`, `LAST_DEGREES`, `THIS_DEGREES`, `RENT_AMT`, `PUB_ELECTRIC_AMT`, `ELECTRIC_AMT`, `DIPOSIT_AMT`, `TOTAL_AMT`, `MESSAGE`) 
				VALUES ('".$_POST["INPUT_DATE"]."','".$_POST["ROOM"]."','".$_POST["NAME"]."','".$_POST["LAST_DEGREES"]."','".
				$_POST["THIS_DEGREES"]."','".$_POST["RENT_AMT"]."','".$_POST["PUB_ELECTRIC_AMT"]."','".$_POST["ELECTRIC_AMT"]."','".
				$_POST["DIPOSIT_AMT"]."','".$_POST["TOTAL_AMT"]."','".$_POST["MESSAGE"]."')";


  $result=mysql_query($sql);

  // 更新最近電表度數
  $sql = "UPDATE DTSF01 SET `THIS_DEGREES`=".$_POST["THIS_DEGREES"]." WHERE ROOM = '".$_POST["ROOM"]."' AND NAME='".$_POST["NAME"]."'";
  mysql_query($sql);

  $sql = "SELECT * FROM DTSF02 WHERE ROOM = '".$ROOM."' AND INPUT_DATE = '".$INPUT_DATE."' AND NAME = '".$NAME."'";

  $result=mysql_query($sql);

  $data = mysql_fetch_assoc($result);


echo json_encode($data);
?>
