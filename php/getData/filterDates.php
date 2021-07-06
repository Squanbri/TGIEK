<?php 
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  require './../databases/db.php';

  $_POST = json_decode(file_get_contents('php://input'), true);
  $date = $_POST['date'];

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
  
  if ($date == 'Дата записи') {
    $sql = "SELECT * FROM recording;";
  }
  else {
    $sql = "SELECT * FROM recording WHERE date='$date';";
  }
  $result = $link->query($sql);

  $items = array();
  while($row = $result->fetch_assoc()) {
      array_push($items, mb_convert_encoding($row, 'UTF-8', 'UTF-8'));
  };


  /*пустой массив по которому будем сортировать*/
  $results = array();
  foreach($items as $key=>$arr){
    $str = floatval(join('.', explode(':', explode('-', $arr['time'])[0])));
    // var_dump($str);
    $results[$key] = $str;
  }
  array_multisort($results, SORT_NUMERIC, $items );


  echo json_encode($items);
?>