<?php
  require './../databases/db.php';

  // подключаемся к серверу

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

  // выполняем операции с базой данных
  $sql = "SELECT * FROM types;";
  $result = $link->query($sql);

  $types = array();
  while($row = $result->fetch_assoc()) {
      array_push($types, $row);
  };

  mysqli_close($link);
  // закрываем подключение
  echo json_encode($types);
?>