<?php 
  require './../databases/db.php';

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GET
    $sql = "SELECT * FROM dates;";
    $result = $link->query($sql);

    $dates = array();
    while($row = $result->fetch_assoc()) {
        array_push($dates, $row);
    };
    echo json_encode($dates);
    // end GET
  }
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    $sql = "INSERT INTO `dates` (`date`) VALUES ('$_POST[date]');";
    $result = $link->query($sql);
    // end POST
  }
  else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // PUT
    $_PUT = json_decode(file_get_contents('php://input'), true);
    
    $sql = "UPDATE `dates` SET date='$_PUT[date]' WHERE id=$_PUT[id] ;";
    $result = $link->query($sql);
    // end PUT
  }
  else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    
    $id = $_DELETE['id'];
    $sql = "DELETE FROM dates WHERE id = $id;";
    $result = $link->query($sql);
    // end DELETE
  }

  mysqli_close($link);
?>