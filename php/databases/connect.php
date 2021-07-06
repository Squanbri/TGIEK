<?php 
  // var_dump(scandir("./../../../libs/RedBeanPHP/rb-mysql.php"));
  require "./../../libs/RedBeanPHP/rb-mysql.php";
  require "./../databases/db.php";
  R::setup( "mysql:host=$host;dbname=$database", "$user", "$password" );

  session_start();
?>