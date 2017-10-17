<?php
/*
$db_host = "sql.computerstudi.es";
$db_name = "gc200305897";
$db_user = "gc200305897";
$db_pass = "WYxYzwXX"; 


 $db_host = "localhost";
 $db_name = "muskoka_db";
 $db_user = "root";
 $db_pass = ""; */
 
$db_host = "db672705311.db.1and1.com";
$db_name = "db672705311";
$db_user = "dbo672705311";
$db_pass = "WYxYzw@X"; 
 
 try{
  
  $conn = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);  
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e){
  echo $e->getMessage();
 }
?>