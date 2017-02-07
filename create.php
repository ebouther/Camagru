<?php

include './config/database.php';
include './functions.php';

if ($_POST['submit'] === "OK") {
	if (!empty($_POST['login']) && !empty($_POST['passwd']) && !empty($_POST['email'])) {
		if (strlen ($_POST['login']) > 8) {
			echo "Login too long (8 char max)";
			?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
		} else {
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
					$reset_id = md5($activation_id + rand());
					$sql = "
						INSERT INTO
						`camagru`.`users`
						(`login`, `passwd`, `email`, `activated`, `activation_id`, `reset_id`)
						VALUES
						(:login, :hash, :email, FALSE, :activation_id, :reset_id)";
					$query = $db->prepare($sql);
					$query->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
					$query->bindParam(':hash', $hash, PDO::PARAM_STR);
					$query->bindParam(':activation_id', $activation_id, PDO::PARAM_STR);
					$query->bindParam(':reset_id', $reset_id, PDO::PARAM_STR);
					$query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

					send_activation_mail($_POST['login'], $_POST['email'], $activation_id);

					$query->execute();
					echo "User created !";
					?><script>setTimeout(function() {window.location.href = "./index.php";}, 1000);</script><?php
				}
			} catch (PDOException $e) {
				echo 'Bad Input';
				?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
			}
		}
	} else {
		echo "Enter a login and password.";
		?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
	}
}
else {
	echo "Hum, hello ?";
	?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
}

?>
