<?php
  include './config/database.php';
  include './functions.php';

  if (!empty($_POST['login']))
  {
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '
          SELECT
                `users`.`email` AND `users`.`reset_id`
          FROM
                `camagru`.`users`
          ';
          $query = $db->prepare($sql);
          $query->execute();
          $res = $query->fetchAll(PDO::FETCH_COLUMN);
          print_r($res);
          if (!empty($res[0])) {
            echo 'An email was sent to you to change your password.';
            send_pass_reset_mail($_POST['login'], $res[0], $reset_id);
          }
          else {
            echo 'Error: bad login.';
          }
    } catch (PDOException $e) {
        echo 'PDO error : ' . $e->getMessage();
    }
  }
  else if (!empty($_POST['id']))
  {
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '
          SELECT
                `users`.`email`
          FROM
                `camagru`.`users`
          ';
          $query = $db->prepare($sql);
          $query->execute();
          $res = $query->fetchAll(PDO::FETCH_COLUMN);
          if (!empty($res[0])) {
            echo 'An email was sent to you to change your password.';
          }
          else {
            echo 'Error: bad login.';
          }
    } catch (PDOException $e) {
        echo 'PDO error : ' . $e->getMessage();
    }
  }
?>
