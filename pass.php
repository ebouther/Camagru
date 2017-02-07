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
                `users`.`email`, `users`.`reset_id`
          FROM
                `camagru`.`users`
		  WHERE
				`login` = :login
          ';
          $query = $db->prepare($sql);
		  $query->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
          $query->execute();
          $res = $query->fetchAll();
          if (!empty($res[0]['email']) && !empty($res[0]['reset_id'])) {
            echo 'An email was sent to you to change your password.';
            send_pass_reset_mail($_POST['login'], $res[0]['email'], $res[0]['reset_id']);
          }
          else {
            echo 'Error: bad login.';
          }
    } catch (PDOException $e) {
        echo 'PDO error : ' . $e->getMessage();
    }
  }
  else if (!empty($_POST['new_pass']) && !empty($_POST['url']))
  {
	parse_str(parse_url($_POST['url'], PHP_URL_QUERY), $url_args);
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '
          UPDATE
                `camagru`.`users`
		  SET
		  		`users`.`passwd` = :hash
		  WHERE
				`users`.`reset_id` = :reset_id
          ';
          $query = $db->prepare($sql);
		  $query->bindParam(':reset_id', $url_args['reset'], PDO::PARAM_STR);
		  $query->bindParam(':hash', hash("whirlpool", $_POST['new_pass']), PDO::PARAM_STR);
          $query->execute();
		  if ($query->rowCount() > 0) {
            echo 'Password successfully updated !';
		  } else {
            echo 'Error: bad id.';
          }
    } catch (PDOException $e) {
        echo 'PDO error : ' . $e->getMessage();
    }
  }
 ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script>
