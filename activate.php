<?php
  include './config/database.php';

  if (!empty($_GET['id']))
  {
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '
          CREATE DATABASE IF NOT EXISTS camagru;
          USE camagru;
          UPDATE `users` SET `activated`=TRUE WHERE `activation_id`=:activation_id;
          ';
          $query = $db->prepare($sql);
          $query->bindParam(':activation_id', $_GET['id'], PDO::PARAM_STR);
          $query->execute();
        $db->exec($sql);

    } catch (PDOException $e) {
        echo 'Failed to activate account : ' . $e->getMessage();
    }
  }
?>
