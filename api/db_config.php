<?php
	define (DB_USER, "apuser");
	define (DB_PASSWORD, "A12345678");
	define (DB_DATABASE, "myrent");
	define (DB_HOST, "localhost");
	if(!($Link=mysql_connect(DB_HOST,DB_USER, DB_PASSWORD)))
        	die("connect fail");
 


	if(!mysql_select_db( DB_DATABASE))
        	die("can't use database server");
	mysql_query("SET NAMES 'UTF8'"); 
?>
