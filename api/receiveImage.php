<?php
 $ROOM = $_POST["ROOM"];
 $data = $_POST["data"];
 $file = $_POST["file"].".jpg";
 
 $path = "../upload/".$ROOM."/";
 if (!file_exists($path)) {
    mkdir($path, 0777, true);
 }
 $data = base64_decode($data);

 file_put_contents($path.$file, $data);
?>


