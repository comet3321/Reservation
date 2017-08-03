<?php

require_once('config.php');

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
  if (!isset($_POST['day']) || !preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $_POST['day'])) {
    echo '日付の値が不正です。';
    return false;
  }
  if (!preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $_POST['tel']) || !isset($_POST['tel'])) {
    echo '電話番号の値が不正です。';
    return false;
  }
  if (!is_numeric($_POST['num']) || !isset($_POST['num'])) {
    echo '予約人数の値が不正です。';
    return false;
  }
  $name = $_POST['name'];
  $tel = $_POST['tel'];
  $num = $_POST['num'];
  $day = $_POST['day'];

  $stmt = $pdo->prepare('insert into customers(name, tel, num, day) values(?, ?, ?, ?)');
  $stmt->execute([$name, $tel, $num, $day]);

  header('location: index.php');
  exit();

 }
