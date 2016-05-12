<?php session_start(); ?>

<html>
  <head>
    <link rel="import" href="templates.html" id="templates">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
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
    useTemplate("t_header", "header");
    <?php
    if (!empty($_SESSION['logged_on_user'])) { ?>
      useTemplate("t_camera", "body");
    <?php
  } else {?>
      useTemplate("t_login", "body");
    <?php
    } ?>
    useTemplate("t_footer", "footer");
  </script>
</html>
