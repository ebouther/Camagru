var t_header = document.createElement("div");
t_header.innerHTML = "Camagru";

t_login = document.createElement("div");
t_login.innerHTML = "<form class=\"form-login\" action=\"./login.php\" method=\"post\"> \
    <h1>Login</h1> \
    <input type=\"text\" name=\"login\" value=\"\" placeholder=\"Login\" /> \
    <br /> \
    <input type=\"password\" name=\"passwd\" value=\"\" placeholder=\"Password\" /> <br/> \
    <input type=\"submit\" value=\"Submit\" /> \
  </form> \
  <script>useTemplate(t_aside.cloneNode (true), 'aside_buttons');</script>";

var t_reset = document.createElement("div");
t_reset.innerHTML = "<form class=\"form-login\" action=\"./pass.php\" method=\"post\"> \
    <h1>New Password</h1> \
    <input type=\"password\" name=\"new_pass\" value=\"\" placeholder=\"New Password\" /> \
    <input id=\"reset_id\" type=\"hidden\" name=\"url\" value=\"\" /> <br/> \
    <input type=\"submit\" value=\"Submit\" /> \
  </form> \
  <script> \
	useTemplate(t_aside.cloneNode (true), 'aside_buttons'); \
    document.getElementById('reset_id').value = window.location.href; \
  </script>";

var t_aside_create = document.createElement("div");
t_aside_create.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"javascript:useTemplate(t_login.cloneNode (true), 'body');\" value=\"Log in.\" />";

var t_images = document.createElement("div");
t_images.innerHTML = "<img src='img/cadre2.png' class='accessories' onclick='javascript:selection(\"cadre2.png\")'> \
<img src='img/glasses.png' class='accessories' onclick='javascript:selection(\"glasses.png\")'> \
<img src='img/cadre1.png' class='accessories' onclick='javascript:selection(\"cadre1.png\")'> \
<img src='img/leaves.png' class='accessories' onclick='javascript:selection(\"leaves.png\")'> \
<img src='img/sumo.png' class='accessories' onclick='javascript:selection(\"sumo.png\")'> \
";

var t_camera = document.createElement("div");
t_camera.innerHTML = "<img id=\"upload_img\" /> \
  <video id=\"video\" autoplay=\"\"></video> \
  <button class=\"aside_btn\" id=\"snap\">Snap Photo</button> \
  <input type=\"file\" onchange=\"previewFile()\" accept=\"image/*\"> \
	<canvas></canvas> \
  <div id=\"images\"></div> \
  <script> \
  	useTemplate(t_aside_logged.cloneNode (true), 'aside_buttons'); \
  	useTemplate(t_images.cloneNode (true), 'images'); \
  	useCamera(); \
  </script>";

var t_snap = document.createElement("div");
t_snap.innerHTML = "<img src > \
";

var t_aside_modify = document.createElement("div");
t_aside_modify.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"location.href='./logout.php?';\" value=\"Disconnect\" /></br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"location.href='./index.php'\" value=\"Back to Camera.\" />";

var t_create_user = document.createElement("div");
t_create_user.innerHTML = "<form class=\"form-login\" action=\"./create.php\" method=\"post\"> \
        <h1>Create an account</h1> \
        <input type=\"text\" name=\"login\" placeholder=\"Login\"/> \
        <br /> \
        <input type=\"password\" name=\"passwd\" placeholder=\"Password\" /> \
        <br /> \
        <input type=\"text\" name=\"email\" placeholder=\"Email\"/> \
        <input type=\"submit\" value=\"OK\" name=\"submit\" /> \
      </form> \
      <script>useTemplate(t_aside_create.cloneNode (true), 'aside_buttons');</script>";

var t_forgot_pass = document.createElement("div");
t_forgot_pass.innerHTML = "<form class=\"form-login\" action=\"./pass.php\" method=\"post\"> \
    Login: <input type=\"text\" name=\"login\" /> \
    <input type=\"submit\" value=\"OK\" name=\"submit\"/> \
  </form> \
  <script>useTemplate(t_aside_modify.cloneNode (true), 'aside_buttons');</script>";

var t_change_passwd = document.createElement("div");
t_change_passwd.innerHTML = "<form class=\"form-login\" action=\"./modif.php\" method=\"post\"> \
    Login: <input type=\"text\" name=\"login\" /> \
    <br /> \
    Old pass: <input type=\"text\" name=\"oldpw\" /> \
    <br /> \
    New pass: <input type=\"text\" name=\"newpw\" /> \
    <input type=\"submit\" value=\"OK\" name=\"submit\"/> \
  </form> \
  <script>useTemplate(t_aside_modify.cloneNode (true), 'aside_buttons');</script>";

var t_aside = document.createElement("div");
t_aside.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"javascript:useTemplate(t_create_user.cloneNode (true), 'body');\" value=\"Create an account.\" /></br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"javascript:useTemplate(t_forgot_pass.cloneNode (true), 'body');\" value=\"Forgot your password ?\" /></br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"location.href='./index.php?gallery';\" value=\"Gallery\" />";

var t_aside_logged = document.createElement("div");
t_aside_logged.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"location.href='./logout.php';\" value=\"Disconnect\" /></br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"javascript:useTemplate(t_change_passwd.cloneNode (true), 'body');\" value=\"Modify your password.\"/> </br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"location.href='index.php?gallery'\" value=\"Gallery\" /> \
  <div id='snapshots'></div> \
  <script>loadUserSnaps()</script>";

var t_aside_gallery = document.createElement("div");
t_aside_gallery.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"location.href='./logout.php';\" value=\"Disconnect\" /></br> \
  <input class=\"aside_btn\" type=\"button\" onclick=\"location.href='index.php?gallery';\" value=\"Gallery\" /> \
  <div id='snapshots'></div>";

var t_aside_public_gallery = document.createElement("div");
t_aside_public_gallery.innerHTML = "<input class=\"aside_btn\" type=\"button\" onclick=\"location.href='index.php';\" value=\"Back to Home\" />";

var t_gallery = document.createElement("div");
t_gallery.innerHTML = "<div id='snapshots'></div> \
  <input id=\"prev_page\" class=\"aside_btn\" type=\"button\" onclick=\"javascript:loadPage('prev')\" value=\"Previous\" /> \
  <input id=\"next_page\" class=\"aside_btn\" type=\"button\" onclick=\"javascript:loadPage('next')\" value=\"Next\" /> \
  <script>loadSnapshots(true, 0); \
  </script>";

var t_public_gallery = document.createElement("div");
t_public_gallery.innerHTML = "<div id='snapshots'></div> \
  <input id=\"prev_page\" class=\"aside_btn\" type=\"button\" onclick=\"javascript:loadPage('prev')\" value=\"Previous\" /> \
  <input id=\"next_page\" class=\"aside_btn\" type=\"button\" onclick=\"javascript:loadPage('next')\" value=\"Next\" /> \
  <script>loadSnapshots(false, 0); \
  </script>";

var t_comment = document.createElement("div");
t_comment.innerHTML = "<input type='text' style='100%' name='commentSnap' id='comment'> \
	<input type='submit' value='Comment' id='submit'>";

var t_footer = document.createElement("div");
t_footer.innerHTML = "<p id=\"test\">Copyright &copy; 2017</br>Made with love by ebouther.</p>";
