<?php 
  require "./connect.php";

  $data = $_POST;
  if( isset($data['do_signup']) ) {

    if( R::count('users', "login = ?", [$data['login']]) ) {
      echo "Такой логин уже есть";
    }
    else {
      $user = R::dispense('users');
      $user->login = $data['login'];
      $user->password = $data['password'];
      R::store($user);
    }
  }
?>

<form action='' method='POST'>
  <p>
    <strong>Логин</strong>
    <input type='text' name='login'>
  </p>

  <p>
    <strong>Пароль</strong>
    <input type='text' name='password'>
  </p>

  <p>
    <button type='submit' name='do_signup'>Зарегистрироваться</button>
  </p>
</form>