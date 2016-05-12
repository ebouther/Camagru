<html>
  <head>
    <link rel="import" href="templates.html" id="templates">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>

  <body>

    <div id="container">
       <div id="header"></div>
       <div id="body"></div>
       <div id="footer"></div>
    </div>

  </body>

  <script src="script.js"></script>
  <script>
    useTemplate("t_header", "header");
    useTemplate("t_camera", "body");
  //  useTemplate("t_login", "body");
    useTemplate("t_footer", "footer");
  </script>
</html>
