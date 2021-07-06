<?php 
  use PHPMailer\PHPMailer\PHPMailer;

  require_once './../libs/PHPMailer/Exception.php';
  require_once './../libs/PHPMailer/PHPMailer.php';
  require_once './../libs/PHPMailer/SMTP.php';

  $mail = new PHPMailer(true);

  $_POST = json_decode(file_get_contents('php://input'), true);
  $type = $_POST['type'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $education = $_POST['education'];
  $phone = $_POST['phone'];

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->CharSet = "utf-8";
  $mail->SMTPAuth = true;
  $mail->Username = 'tgieklazur@gmail.com';
  $mail->Password = 'f4nVjF0B0D27';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = '587';

  $mail->setFrom($email);
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = 'Запись на приём в колледж им. А.Н.Коняева';
  $mail->Body = "
    <p> 
      Здравствуйте, <strong>$full_name</strong> <br>
      Вы записались на $date $time <br>
      С уважением, <em>ГБПОУ \"Тверской колледж имени А.Н. Коняева\"</em> <br>
      Наличие маски обязательно
    </p>
  ";
  $mail->send();
?>