<?php

  include 'database.php';

  try {
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_GET['delete'])) {
        $sql = 'DROP DATABASE camagru;';
      } else {
      $sql = '
        CREATE DATABASE IF NOT EXISTS camagru;
        USE camagru;
        CREATE TABLE users (
          ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
          login TEXT,
          passwd TEXT,
          email TEXT
        )
        ';
      }

      $db->exec($sql);

  } catch (PDOException $e) {
      echo 'Failed to connect : ' . $e->getMessage();
  }

?>
