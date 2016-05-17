<?php
  function send_activation_mail($login, $email, $activation_id) {
    $to      =  $email;//'eliot.boutherin@gmail.com';
    $subject = 'Welcome to Camagru ' . $login . ' !';
    $message = 'Welcome ' . $login . '!' . PHP_EOL .
              'To activate your account go to: http://' . $_SERVER[HTTP_HOST] . '?id=' . $activation_id);
    $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
  }
?>
