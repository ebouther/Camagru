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
          login VARCHAR(8),
          passwd TEXT,
          email TEXT,
          activated BOOLEAN,
          activation_id TEXT,
          reset_id TEXT
        );

        CREATE TABLE snaps (
          ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
		  snap_file VARCHAR(30),
          user_id INT,
		  likes INT
		);

        CREATE TABLE likes (
          ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
		  user_id INT,
          snap_file VARCHAR(30)
		);

        CREATE TABLE comments (
          ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
          comment TEXT,
          snap_file VARCHAR(30),
		  timestamp INT,
		  login VARCHAR(8)
		);
        ';
      }

      $db->exec($sql);

  } catch (PDOException $e) {
      echo 'Failed to connect : ' . $e->getMessage();
  }

?>
