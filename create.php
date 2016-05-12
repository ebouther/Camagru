<?php

include './config/database.php';

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
            $sql = "
            INSERT INTO
                `camagru`.`users`
                (`login`, `passwd`)
            VALUES
                (:login, :hash)";
            $query = $db->prepare($sql);
            $query->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
            $query->bindParam(':hash', $hash, PDO::PARAM_STR);

             $to      = 'eliot.boutherin@gmail.com';
             $subject = 'Welcome to Camagru !';
             $message = 'Welcome !';
             $headers = 'From: webmaster@example.com' . "\r\n" .
             'Reply-To: webmaster@example.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
              mail($to, $subject, $message, $headers);
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
