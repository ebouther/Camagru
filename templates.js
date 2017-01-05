var t_header = document.createElement("div");
t_header.innerHTML = "<p>Header.</p>";

var t_login = document.createElement("div");
t_login.innerHTML = "<form action=\"./login.php\" method=\"post\"> \
    Login: <input type=\"text\" name=\"login\" value=\"\" /> \
    <br /> \
    Password: <input type=\"text\" name=\"passwd\" value=\"\" /> \
    <input type=\"submit\" value=\"OK\" /> \
  </form> \
  <script>useTemplate(t_aside.cloneNode (true), 'aside_buttons');</script>";

var t_aside_create = document.createElement("div");
t_aside_create.innerHTML = "<input type=\"button\" onclick=\"javascript:useTemplate(t_login.cloneNode (true), 'body');\" value=\"Log in.\" />";

var t_images = document.createElement("div");
t_images.innerHTML = "<img src='img/mask.png' style='width: 300px' onclick='javascript:selection(\"mask.png\")'>";

var t_camera = document.createElement("div");
t_camera.innerHTML = "<button id=\"snap\">Snap Photo</button> \
    <video id=\"video\" width=\"640\" height=\"480\" autoplay=\"\"></video> \
	<canvas></canvas> \
  <div id=\"images\"></div> \
  <script> \
  	useTemplate(t_aside_logged.cloneNode (true), 'aside_buttons'); \
  	useTemplate(t_images.cloneNode (true), 'images'); \
  	useCamera(); \
  </script>";

var t_snap = document.createElement("div");
t_snap.innerHTML = "<canvas class=\"snap\" style=\"width: 100%;\"></canvas>"; 

var t_aside_modify = document.createElement("div");
t_aside_modify.innerHTML = "<input type=\"button\" onclick=\"location.href='./logout.php';\" value=\"Disconnect\" /></br> \
  <input type=\"button\" onclick=\"javascript:useTemplate(t_camera.cloneNode (true), 'body');\" value=\"Back to home.\" />";

var t_create_user = document.createElement("div");
t_create_user.innerHTML = "<form action=\"./create.php\" method=\"post\"> \
        Login: <input type=\"text\" name=\"login\" /> \
        <br /> \
        Password: <input type=\"password\" name=\"passwd\" /> \
        <br /> \
        Email: <input type=\"text\" name=\"email\" /> \
        <input type=\"submit\" value=\"OK\" name=\"submit\" /> \
      </form> \
      <script>useTemplate(t_aside_create.cloneNode (true), 'aside_buttons');</script>";

var t_forgot_pass = document.createElement("div");
t_forgot_pass.innerHTML = "<form action=\"./pass.php\" method=\"post\"> \
    Login: <input type=\"text\" name=\"login\" /> \
    <input type=\"submit\" value=\"OK\" name=\"submit\"/> \
  </form> \
  <script>useTemplate(t_aside_modify.cloneNode (true), 'aside_buttons');</script>";

var t_change_passwd = document.createElement("div");
t_change_passwd.innerHTML = "<form action=\"./modif.php\" method=\"post\"> \
    Login: <input type=\"text\" name=\"login\" /> \
    <br /> \
    Old pass: <input type=\"text\" name=\"oldpw\" /> \
    <br /> \
    New pass: <input type=\"text\" name=\"newpw\" /> \
    <input type=\"submit\" value=\"OK\" name=\"submit\"/> \
  </form> \
  <script>useTemplate(t_aside_modify.cloneNode (true), 'aside_buttons');</script>";

var t_aside = document.createElement("div");
t_aside.innerHTML = "<input type=\"button\" onclick=\"javascript:useTemplate(t_create_user.cloneNode (true), 'body');\" value=\"Create an account.\" /></br> \
  <input type=\"button\" onclick=\"javascript:useTemplate(t_forgot_pass.cloneNode (true), 'body');\" value=\"Forgot your password ?\" />";

var t_aside_logged = document.createElement("div");
t_aside_logged.innerHTML = "<input type=\"button\" onclick=\"location.href='./logout.php';\" value=\"Disconnect\" /></br> \
  <input type=\"button\" onclick=\"javascript:useTemplate(t_change_passwd.cloneNode (true), 'body');\" value=\"Modify your password.\" /> \
  <div id='snapshots'></div> \
  <script>loadSnapshots()</script>";

var t_footer = document.createElement("div");
t_footer.innerHTML = "<p id=\"test\">Footer.</p>";
