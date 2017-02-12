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

  function send_new_comment_mail($login, $email, $sender) {
    $to      =  $email;
    $subject = 'Camagru - New Comment';
    $message = 'Hello ' . $login . '!' . PHP_EOL .
              'Check your photos on Camagru, you have a new comment from ' . $sender . ' !';
    return mail($to, $subject, $message);
  }

  function secure_pass($pass) {
	  if (strlen($pass) >= 6 && preg_match('/[A-Z]+[a-z]+[0-9]+/', $pass))
		  return true;
	  return false;
  }
?>
