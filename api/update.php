<?php
require 'db_config.php';


  $ROOM  = $_POST["ROOM"];
  $BEGIN_DATE  = $_POST["BEGIN_DATE"];
  $END_DATE  = $_POST["END_DATE"];
  $RENT_AMT  = $_POST["RENT_AMT"];
 

  $sql = "UPDATE dtsf01 SET END_DATE = '".$END_DATE."'

    ,RENT_AMT = '".$RENT_AMT."' 

    WHERE ROOM = '".$ROOM."' AND BEGIN_DATE = '".$BEGIN_DATE."' ";

  $result = $mysqli->query($sql);


  $sql = "SELECT * FROM dtsf01 WHERE ROOM = '".$ROOM."' AND BEGIN_DATE = '".$BEGIN_DATE."' ";

  $result = $mysqli->query($sql);

  $data = $result->fetch_assoc();


echo json_encode($data);
?>