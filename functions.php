<?php

  function send_activation_mail($login, $email, $activation_id) {
    $subject = 'Welcome to Camagru ' . $login . ' !';
    $message = 'Welcome ' . $login . '!' . PHP_EOL .
              'To activate your account go to: http://' . $_SERVER['HTTP_HOST'] . '/camagru/activate.php?id=' . $activation_id;
    mail($email, $subject, $message);
  }

  function send_pass_reset_mail($login, $email, $reset_id) {
    $to      =  $email;
    $subject = 'Camagru password reset ' . $login . ' !';
    $message = 'Hello ' . $login . '!' . PHP_EOL .
              'To reset your account password go to: http://' . $_SERVER['HTTP_HOST'] . '/camagru/index.php?reset=' . $reset_id;
    return mail($to, $subject, $message);
  }
?>
