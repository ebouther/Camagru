<?php
include("./auth.php");
date_default_timezone_set('Europe/Paris');
session_start();

if ($_POST['msg'] != NULL)
{
  if (file_exists("../htdocs/private/chat"))
  {
      $messages = unserialize(file_get_contents("../htdocs/private/chat", LOCK_EX));
      $messages[] = array("login" => $_SESSION['loggued_on_user'], "time" => time(), "msg" => $_POST['msg']);
  }
  else
  {
    if (!file_exists("../htdocs/private/"))
      mkdir("../htdocs/private/", 0777, true);
    $messages[] = array("login" => $_SESSION['loggued_on_user'], "time" => time(), "msg" => $_POST['msg']);
  }
  file_put_contents("../htdocs/private/chat", serialize($messages));
}

if ($_SESSION['loggued_on_user'] != NULL)
{
?>
<html>
  <body>
    <form action="./speak.php" method="post">
      <input type="text" name="msg" value="" />
      <input type="submit" value="OK" />
    </form>
  </body>
</html>
<?php
}
else
  {
    echo "Please login to chat.\n";
  }
?>
