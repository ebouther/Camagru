<?php

include("./auth.php");
include("./config/database.php");

session_start();

$login = $_POST['login'];
$passwd = $_POST['passwd'];

if (auth($login, $passwd) === true) {
  $_SESSION['logged_on_user'] = $login;
    	try {
        	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
         	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT ID
			FROM
            	`camagru`.`users`
			WHERE
                `login` = :login";
			$query = $db->prepare($sql);
			$query->bindParam(':login', $login, PDO::PARAM_STR);
			$query->execute();
        	$res = $query->fetchAll(PDO::FETCH_COLUMN);
  			$_SESSION['logged_on_user_id'] = $res[0];
    	} catch (PDOException $e) {
        	echo 'Caught Exception : ' . $e->getMessage();
    	}
  header("Location: ./index.php");
} else {
  $_SESSION['logged_on_user'] = "";
  echo "Cannot log in, is your account activated ?\n";
  ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
}
?>
