<?php
  function send_activation_mail($login, $email, $activation_id) {
    $to      =  $email;
    $subject = 'Welcome to Camagru ' . $login . ' !';
    $message = 'Welcome ' . $login . '!' . PHP_EOL .
              'To activate your account go to: http://' . $_SERVER[HTTP_HOST] . '/camagru/activate.php?id=' . $activation_id;
    $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
  }

  function send_pass_reset_mail($login, $email, $reset_id) {
    $to      =  $email;
    $subject = 'Camagru password reset ' . $login . ' !';
    $message = 'Hello ' . $login . '!' . PHP_EOL .
              'To reset your account password go to: http://' . $_SERVER[HTTP_HOST] . '/camagru/pass.php?id=' . $reset_id;
    $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
  }
?>
