<?php 
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  require './../databases/db.php';

  $_POST = json_decode(file_get_contents('php://input'), true);
  $fio = $_POST['fio'];
  $email = $_POST['email'];

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
  
  $sql = "SELECT * FROM recording WHERE full_name='$fio' AND email='$email';";
  $result = $link->query($sql);

  $recordings = array();
  while($row = $result->fetch_assoc()) {
      array_push($recordings, mb_convert_encoding($row, 'UTF-8', 'UTF-8'));
  };

  echo json_encode($recordings);
?>