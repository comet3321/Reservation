<?php
session_start();

require_once('config.php');
if (!isset($_SESSION['email'])) {
  echo '不正なアクセスです。';
}

try {
  $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['name']) || !is_string($_POST['name'])) {
    echo '名前の値が不正です。';
    return false;
  }
if (!isset($_POST['email'])) {
  echo 'emailの値が不正です。';
  return false;
}
if (!isset($_POST['password'])) {
  echo 'パスワードの値が不正です。';
  return false;
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash( $_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare('insert into admin(name, email, password) values(?, ?, ?)');
$stmt->execute([$name, $email, $password,]);
header('location: admin.php');
exit();
 }
