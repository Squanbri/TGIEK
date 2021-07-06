<?php 
  require './../databases/connect.php';

  if( !isset($_SESSION['logged_user']) ) {
    header ('Location: ./login.php');  // перенаправление на нужную страницу
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Записи</title>
  <link rel="shortcut icon" href="https://ab.tgiek.ru/assets/images/logo-blue.png" type="image/png">
  <link rel="stylesheet" href="https://ab.tgiek.ru/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://ab.tgiek.ru/assets/css/admin.css">
</head>

<body>
  <header>
    <nav class='container'>
      <ul class="nav">
        <li class="nav__item">
          <a class="nav__link" href="https://ab.tgiek.ru/">ЗАПИСЬ</a>
        </li>
        <li class="nav__item">
          <a class="nav__link" href="https://tgiek.ru/">КОЛЛЕДЖ</a>
        </li>
        <li class="nav__item">
          <a class="nav__link" href="https://ab.tgiek.ru/php/admin/logout.php">ВЫХОД</a>
        </li>
      </ul>
    </nav>
  </header>
  <main class="container-fluid">
    <section class="header__main-middle mb-2">
      <a href="https://tgiek.ru/">
        <img src="https://ab.tgiek.ru/assets/images/logo-blue.png">
      </a>
    </section>
    <section class="block-tgiek-recordings">
      <h1 class="mb-4">Записи</h1>
      
      <table class="table">
        <thead>
          <tr>
            <th scope="col" id="fio" class="fio">ФИО</th>
            <th scope="col" id="phone" class="phone">Телефон</th>
            <th scope="col" id="email" class="email">Email</th>
            <th scope="col" id="education" class="education">Образование</th>
            <th scope="col" id="type" class="type">Форма обучения</th>
            <th scope="col" class="date">
              <select id="date-select" name="" id="" class='form-control'>
                <option>Дата записи</option>
              </select>
            </th>
            <th scope="col" id="time" class="time">Время записи</th>
            <th scope="col" class="delete"></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        <ul class="pagination" id="pagination">
        </ul>
      </div>
    </section>
  </main>
  <script src="https://ab.tgiek.ru/assets/js/fontawesome.js"></script>
  <script src="https://ab.tgiek.ru/assets/js/admin.js"></script>
</body>
</html>