<?php
  session_start();
  date_default_timezone_set('Europe/Paris');

  if (file_exists("../htdocs/private/chat"))
    {
      $messages = unserialize(file_get_contents("../htdocs/private/chat", LOCK_EX));
      foreach ($messages as $message)
      {
        echo "[" . date('H:i', $message['time']) . "] ";
        echo "<b>" . $message['login'] . "</b>: ";
        echo $message['msg'] . "<br />";
      }
  }
?>
