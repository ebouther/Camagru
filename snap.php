<?php
  	session_start();
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
		$file = "./photos/" . $_SESSION['logged_on_user'] . "-" . time()  . ".png";
		imagepng($dest, $file);
		echo $file;
	} else if ($_POST['snapshots'] && $_SESSION['logged_on_user']) {
		$files = array_reverse (preg_grep('~^' .  $_SESSION['logged_on_user'] . '.*\.(png)$~', scandir("./photos/")));	
		echo json_encode($files);
	} else {
		echo "Hum, c't'embarrassant...";
	}
?>
