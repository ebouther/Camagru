<?php
function auth($login, $passwd)
{
  include './config/database.php';

  $hash = hash("whirlpool", $passwd);

  try {
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "
      SELECT COUNT(*)
      FROM `camagru`.`users`
      WHERE login = :login AND passwd = :hash AND activated = TRUE;

      $query = $db->prepare($sql);
      $query->bindValue(':login', $login, PDO::PARAM_STR);
      $query->bindValue(':hash', $hash, PDO::PARAM_STR);
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_COLUMN);
      if (intval($res[0]) === 1) {
        return true;
      }
  } catch (PDOException $e) {
      echo 'Caught Exception : ' . $e->getMessage();
      return false;
  }
  return false;
}
?>
