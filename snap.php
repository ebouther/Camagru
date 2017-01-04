<?php
	if ($_POST['img'] && $_POST['snap'])
	{
		$snap = base64_decode(explode(',', $_POST['snap'])[1]);
		$fd = fopen("tmp.png" , 'w+b');
     	fwrite($fd, $snap);
     	fclose($fd);
		$dest = imagecreatefrompng("./tmp.png");
		$src = imagecreatefrompng("img/" . $_POST['img']);
		$size = getimagesize("img/" . $_POST['img']);
		imagecopy($dest, $src, 0, 0, 0, 0, $size[0], $size[1]);
		imagepng($dest, "tmp.png");
		$data = file_get_contents("tmp.png");
		$base64 = 'data:image/png;base64,' . base64_encode($data);
		echo $base64;
	}
?>
