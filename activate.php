<?php
include './config/database.php';
if (!empty($_GET['id']))
{
	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = '
			UPDATE
				  `camagru`.`users`
			SET
				  `users`.`activated` = TRUE
			WHERE
				  `users`.`activation_id`=:activation_id;
			';
		$query = $db->prepare($sql);
		$query->bindParam(':activation_id', $_GET['id'], PDO::PARAM_STR);
		$query->execute();
		if ($query->rowCount() > 0)
			echo 'Account successfully activated.';
		else {
			echo 'Error: cannot activate your account.';
		}
	}
	catch (PDOException $e) {
		echo 'Failed to activate account : ' . $e->getMessage();
	}
}
?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
?>
