<?php

include("./auth.php");

session_start();

$login = $_POST['login'];
$passwd = $_POST['passwd'];

if (auth($login, $passwd) === true) {
  $_SESSION['logged_on_user'] = $login;
  header("Location: ./index.php");
} else {
  $_SESSION['logged_on_user'] = "";
  echo "ERROR\n";
  ?><script>setTimeout(function() {window.location.href = "./index.php";}, 3000);</script><?php
}
?>
