  <?php 
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  require './../databases/db.php';

  $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
  
  // RECORDINGS
  $sql = "SELECT * FROM `recording`";
  $result = $link->query($sql);

  $recordings = array();
  while($row = $result->fetch_assoc()) {
      array_push($recordings, mb_convert_encoding($row, 'UTF-8', 'UTF-8'));
  };

  // LIMIT
  $limit = 48;
  $page = $_GET['page'];
  if($page == NULL) {
    $page = 0;
  }
  $offset = $limit * $page - 48;

  // FILTER
  $filter = $_GET['filter'];
  if($filter == 'fioUp') {

    $results = array();
    foreach($recordings as $key=>$row) {
      $str = trim($row['full_name']);
      $results[$key] = mb_strtoupper($str);
    }
    array_multisort($results, SORT_ASC, $recordings );
  }
  else if ($filter == 'fioDown') {

    $results = array();
    foreach($recordings as $key=>$row) {
      $str = trim($row['full_name']);
      $results[$key] = mb_strtoupper($str);
    }
    array_multisort($results, SORT_DESC, $recordings );
  }

  $recordings = array_slice($recordings, $offset, $limit);

  // COUNT
  $sql = "SELECT * FROM recording;";
  $result = $link->query($sql);
  $count = intval($result->num_rows / $limit);

  echo json_encode(array('recordings' => $recordings, 'count' => $count));
  // echo json_last_error_msg(); 

  mysqli_close($link);
?>