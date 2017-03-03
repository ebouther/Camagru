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
         <div style="overflow:scroll;" ></div>
       </div>
    </div>
    <div id="footer"></div>
  </body>

  <script src="script.js"></script>
  <script>
    useTemplate(t_header.cloneNode (true), "header");
    <?php
    if (!empty($_SESSION['logged_on_user'])) {
		if (isset ($_GET["gallery"])) {
			?>
				useTemplate(t_gallery.cloneNode (true), "body");
				useTemplate(t_aside_modify.cloneNode (true), 'aside_buttons');
			<?php
		} else if (isset ($_GET['snap'])) {
			?>
				useTemplate(t_aside_gallery, "aside");
				getComments("<?php echo $_GET['snap']; ?>", function (template) {
					useTemplate(template, "body");
				});
			<?php
		} else { ?>
			useTemplate(t_camera.cloneNode (true), "body"); <?php
		}
	} else {
		if (isset ($_GET['gallery'])) {
			?>
				useTemplate(t_public_gallery.cloneNode (true), "body");
				useTemplate(t_aside_public_gallery.cloneNode (true), 'aside_buttons');
			<?php
		} else if (isset ($_GET['reset'])) {
			?> useTemplate(t_reset.cloneNode (true), "body"); <?php
		} else {
			?> useTemplate(t_login.cloneNode (true), "body"); <?php
		}
    } ?>
    useTemplate(t_footer.cloneNode (true), "footer");
  </script>
</html>
