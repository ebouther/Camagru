<?php

include './config/database.php';
include './functions.php';

  if ($_POST['submit'] === "OK") {
    if (!empty($_POST['login']) && !empty($_POST['passwd'])) {
      try {
          $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $sql = "
          SELECT
              COUNT(*)
          FROM
              `camagru`.`users`
          WHERE
              `login` = :login";
          $query = $db->prepare($sql);
          $query->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
          $query->execute();
          $res = $query->fetchAll(PDO::FETCH_COLUMN);
          if ($res[0] > 0) {
            echo "Error, login " . $_POST['login'] . " already exists.";
            ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
          } else {
            $hash = hash("whirlpool", $_POST['passwd']);
            $activation_id = md5(microtime(true));
            $sql = "
            INSERT INTO
                `camagru`.`users`
                (`login`, `passwd`, `activated`, `activation_id`)
            VALUES
                (:login, :hash, FALSE, :activation_id)";
            $query = $db->prepare($sql);
            $query->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
            $query->bindParam(':hash', $hash, PDO::PARAM_STR);
            $query->bindParam(':activation_id', $activation_id, PDO::PARAM_STR);
            send_activation_mail($_POST['login'], 'eliot.boutherin@gmail.com', $activation_id);
            $query->execute();
            echo "User created !";
            ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
          }
      } catch (PDOException $e) {
          echo 'Caught Exception : ' . $e->getMessage();
      }
    }
    else
    {
      echo "Enter a login and password.";
      ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
    }
  }
  else {
    echo "Error.";
      ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
  }

?>
