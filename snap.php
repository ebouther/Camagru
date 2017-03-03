<?php
  	session_start();
  	include './config/database.php';
    include './functions.php';

	if ($_POST['img'] && $_POST['snap'] && $_SESSION['logged_on_user'])
	{
		$snap = base64_decode(explode(',', $_POST['snap'])[1]);
		$fd = fopen("tmp.png" , 'w+b');
	   	fwrite($fd, $snap);
	   	fclose($fd);

			$dest = imagecreatefrompng("./tmp.png");
			$src = imagecreatefrompng("img/" . $_POST['img']);
			$size = getimagesize("./tmp.png");
			$size2 = getimagesize("img/" . $_POST['img']);
			try {
				imagecopyresized($dest, $src, 0, 0, 0, 0, $size[0], $size[1], $size2[0], $size2[1]);
			} catch (Exception $e) {
	   			null;
	   		}
			$file =  time() . "-" . $_SESSION['logged_on_user'] . ".png";
			
			try {
				imagepng($dest, "./photos/" . $file);
			} catch (Exception $e) {
	   			null;
	   		}
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
        	null;
    	}

	} else if ($_POST['user_snaps'] && $_SESSION['logged_on_user']) {
		if (!file_exists('./photos')) {
			mkdir('./photos', 0777);
		}
		$files = array_reverse (preg_grep ('~^[0-9]*-' . $_SESSION['logged_on_user'] . '\.(png)$~', scandir("./photos/")));
		echo json_encode($files);

	} else if (!empty($_POST['removeSnap']) && $_SESSION['logged_on_user']) {
		if (preg_match('~^[0-9]+(-)(.+)(.png)~', $_POST['removeSnap'], $m) !== null) {
    	if ($m[2] === $_SESSION['logged_on_user']) {
	    	try {
		        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        $sql = "
		          DELETE FROM
		            `camagru`.`snaps`
		          WHERE
		            `snaps`.`snap_file` = :snap
		          ";
		
		        $query = $db->prepare($sql);
		        $query->bindParam(':snap', $_POST['removeSnap'], PDO::PARAM_STR);
		        $query->execute();
		        if (file_exists('./photos/' . $_POST['removeSnap']))
		        	unlink('./photos/' . $_POST['removeSnap']);
		        
		    } catch (PDOException $e) {
		            echo 'Caught Exception : ' . $e->getMessage();
		    }
		}
        //remove_snap($_POST['removeSnap']);
    }

	} else if (!empty($_POST['snapshots'])) {
		$files = array_reverse (preg_grep ('~^[0-9]*-.*\.(png)$~', scandir("./photos/")));
		echo json_encode(array_slice($files, $_POST['page'] * 5, $_POST['page'] * 5 + 5));

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
  			SELECT
          `login`,`email`
        FROM
          `camagru`.`snaps`
        JOIN
          `camagru`.`users` ON `snaps`.`user_id` = `users`.`ID`
        WHERE
          `snap_file` = :snap_file
        ";

  			$query = $db->prepare($sql);
  			$query->bindParam(':snap_file', $_POST['snap_file'], PDO::PARAM_STR);
  			$query->execute();
        $res = $query->fetch();
        send_new_comment_mail($res['login'], $res['email'], $_SESSION['logged_on_user']);

  			$sql = "
  			INSERT INTO
  				`camagru`.`comments`
  				(`comment`, `login`, `timestamp`, `snap_file`)
  			VALUES
  				(:comment, :login, :timestamp, :snap_file)";
  			$query = $db->prepare($sql);
  			$query->bindParam(':comment', htmlspecialchars($_POST['commentSnap']), PDO::PARAM_STR);
  			$query->bindParam(':login', htmlspecialchars($_SESSION['logged_on_user']), PDO::PARAM_STR);
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
  	}
?>
