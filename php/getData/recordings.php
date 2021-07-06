<?php 
  // header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  require './../databases/db.php';

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GET
    $sql = "SELECT * FROM recording;";
    // $sql = "SELECT * FROM recording limit 48 offset 0;";
    // SELECT COUNT(1) FROM название_таблицы
    $result = $link->query($sql);
    // var_dump($result);

    $recordings = array();
    while($row = $result->fetch_assoc()) {
        array_push($recordings, mb_convert_encoding($row, 'UTF-8', 'UTF-8'));
    };
    // var_dump($recordings);
    echo json_encode($recordings);
    // echo json_last_error_msg(); 
    // end GET
  }
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST
    $_POST = json_decode(file_get_contents('php://input'), true);

    $sql = "INSERT INTO `recording` (`type`, `date`, `time`, `full_name`, `email`, `education`, `phone`) VALUES ('$_POST[type]', '$_POST[date]', '$_POST[time]', '$_POST[full_name]', '$_POST[email]', '$_POST[education]', '$_POST[phone]');";
    $result = $link->query($sql);
    // end POST
  }
  else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    
    $id = $_DELETE['id'];
    $sql = "DELETE FROM recording WHERE id = $id;";
    $result = $link->query($sql);
    // end DELETE
  }

  mysqli_close($link);
?>