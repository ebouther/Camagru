<?php
  if ($_POST['submit'] === "OK")
  {
    if ($_POST['login'] != NULL && $_POST['oldpw'] != NULL && $_POST['newpw'] != NULL)
    {
      $oldpw_hash = hash("whirlpool", $_POST['oldpw']);
      $newpw_hash = hash("whirlpool", $_POST['newpw']);

      $users = unserialize(file_get_contents("../htdocs/private/passwd"));

      $modify = false;
      foreach ($users as $key => $user) {
        if ($user['login'] === $_POST['login'] && $user['passwd'] === $oldpw_hash)
        {
          $modify = true;
          break ;
        }
      }
      if ($modify === true)
      {
        $users[$key]['passwd'] = $newpw_hash;
        file_put_contents("../htdocs/private/passwd", serialize($users));
        echo "OK\n";
      }
      else {
        echo "ERROR\n";
      }
    }
    else {
        echo "ERROR\n";
      }
  }
  else
    echo "ERROR\n";
?>
