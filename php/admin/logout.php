<?php 
  require "./../databases/connect.php";
  
  unset($_SESSION['logged_user']);
  header ('Location: login.php');  // перенаправление на нужную страницу
  exit();
?>