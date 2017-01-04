<?php
session_start();
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
	<script type="text/javascript" src="templates.js"></script> 
  </head>

  <body>
    <div id="container">
       <div id="header"></div>
       <div id="body"></div>
       <div id="aside">
       <div id="aside_buttons"></div>
         <div style="width:10;height:10;overflow:scroll" ></div>
       </div>
       <div id="footer"></div>
    </div>
  </body>

  <script src="script.js"></script>
  <script>
	//window.onresize = function(event) {
	//	var canvas = document.getElementsByClassName('snap');
	//	var length = canvas.length;
	//	var ratio = 480.0 / 640.0;
	//	for (var n = 0; n < length; n++)
	//	{
	//    	console.log("ratio : " + ratio);
	//    	console.log("height : " + canvas[n].height);
	//    	console.log("width : " + canvas[n].width);
	//		canvas[n].height = (canvas[n].width * ratio);
	//    	console.log("height2 : " + canvas[n].height);
	//	}	
	//};
    useTemplate(t_header.cloneNode (true), "header");
    <?php
    if (!empty($_SESSION['logged_on_user'])) { ?>
      useTemplate(t_camera.cloneNode (true), "body");
    <?php
  } else {?>
      useTemplate(t_login.cloneNode (true), "body");
    <?php
    } ?>
    useTemplate(t_footer.cloneNode (true), "footer");
  </script>
</html>
