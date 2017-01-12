<?php
  	session_start();
  	include './config/database.php';

	if ($_POST['img'] && $_POST['snap'] && $_SESSION['logged_on_user'])
	{
		$snap = base64_decode(explode(',', $_POST['snap'])[1]);
		$fd = fopen("tmp.png" , 'w+b');
     	fwrite($fd, $snap);
     	fclose($fd);
		$dest = imagecreatefrompng("./tmp.png");
		$src = imagecreatefrompng("img/" . $_POST['img']);
		$size = getimagesize("img/" . $_POST['img']);
		imagecopy($dest, $src, 0, 0, 0, 0, $size[0], $size[1]);
		$file =  time() . "-" . $_SESSION['logged_on_user'] . ".png";
		imagepng($dest, "./photos/" . $file);

		echo "./photos/" . $file;

    	try {
        	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
         	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			INSERT INTO
            	`camagru`.`snaps`
                (`snap_file`, `user_id`, `likes`)
            VALUES
                (:snap_file, :user_id, 0)";
			$query = $db->prepare($sql);
			$query->bindParam(':snap_file', $file, PDO::PARAM_STR);
			$query->bindParam(':user_id', $_SESSION['logged_on_user_id'], PDO::PARAM_INT);
			$query->execute();
    	} catch (PDOException $e) {
        	echo 'Caught Exception : ' . $e->getMessage();
    	}

	} else if ($_POST['user_snaps'] && $_SESSION['logged_on_user']) {
		$files = array_reverse (preg_grep ('~^' .  $_SESSION['logged_on_user'] . '.*\.(png)$~', scandir("./photos/")));
		echo json_encode($files);
	} else if ($_POST['snapshots'] && $_SESSION['logged_on_user']) {
		$files = array_reverse (preg_grep('~^.*\.(png)$~', scandir("./photos/")));	
		echo json_encode($files);
	} else if ($_POST['getSnapLikes'] && $_SESSION['logged_on_user']) {
    	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
     	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "
			SELECT
				`snaps`.`likes`
			FROM
				`camagru`.`snaps`
			WHERE
				`snap_file` = :snap_file";
		$query = $db->prepare($sql);
		$query->bindParam(':snap_file', $_POST['getSnapLikes'], PDO::PARAM_STR);
		$query->execute();
      	$res = $query->fetchAll(PDO::FETCH_COLUMN);
		echo $res[0];
	} else if ($_POST['likeSnap'] && $_SESSION['logged_on_user']) {
    	try {
        	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
         	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
          	SELECT
          	    COUNT(*)
          	FROM
          	    `camagru`.`likes`
          	WHERE
				`user_id` = :user_id
			AND `snap_file` = :snap_file";
			$query = $db->prepare($sql);
			$query->bindParam(':snap_file', $_POST['likeSnap'], PDO::PARAM_STR);
			$query->bindParam(':user_id', $_SESSION['logged_on_user_id'], PDO::PARAM_INT);
			$query->execute();
          	$res = $query->fetchAll(PDO::FETCH_COLUMN);
			if ($res[0] == 0)
			{
				$sql = "
				INSERT INTO
					`camagru`.`likes`
					(`snap_file`, `user_id`)
				VALUES
					(:snap_file, :user_id)";
				$query = $db->prepare($sql);
				$query->bindParam(':snap_file', $_POST['likeSnap'], PDO::PARAM_STR);
				$query->bindParam(':user_id', $_SESSION['logged_on_user_id'], PDO::PARAM_INT);
				$query->execute();

				$sql = "
				UPDATE	
					`camagru`.`snaps`
				SET
					`likes` = `likes` + 1
				WHERE
					`snap_file` = :snap_file";
				$query = $db->prepare($sql);
				$query->bindParam(':snap_file', $_POST['likeSnap'], PDO::PARAM_STR);
				$query->execute();
			}
    	} catch (PDOException $e) {
        	echo 'Caught Exception : ' . $e->getMessage();
    	}
	} else if ($_POST['commentSnap'] && $_POST['snap_file'] && $_SESSION['logged_on_user']) {
    	try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			INSERT INTO
				`camagru`.`comments`
				(`comment`, `login`, `timestamp`, `snap_file`)
			VALUES
				(:comment, :login, :timestamp, :snap_file)";
			$query = $db->prepare($sql);
			$query->bindParam(':comment', $_POST['commentSnap'], PDO::PARAM_STR);
			$query->bindParam(':login', $_SESSION['logged_on_user'], PDO::PARAM_STR);
			$query->bindParam(':timestamp', time(), PDO::PARAM_INT);
			$query->bindParam(':snap_file', $_POST['snap_file'], PDO::PARAM_STR);
			$query->execute();
    	} catch (PDOException $e) {
        	echo 'Caught Exception : ' . $e->getMessage();
    	}
	} else if ($_POST['getComments'] && $_SESSION['logged_on_user']) {
    	try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
          	SELECT *
          	FROM
          	    `camagru`.`comments`
          	WHERE
				`snap_file` = :snap_file";
			$query = $db->prepare($sql);
			$query->bindParam(':snap_file', $_POST['getComments'], PDO::PARAM_STR);
			$query->execute();
          	$res = $query->fetchAll();
			echo json_encode($res);
    	} catch (PDOException $e) {
        	echo 'Caught Exception : ' . $e->getMessage();
    	}
  	} else {
		echo "[404] Hum, c't'embarrassant...";
	}
?>
