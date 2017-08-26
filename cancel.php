<?php
require_once('config.php');

try {
  $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];

  if($name === "" || $id === ""){
    echo "入力が不正です。";
    return false;
  }

  $stmt = $pdo->prepare("select * from customers where id = :id");
  $stmt->execute([
    ':id' => $id
  ]);
  $result = $stmt->fetch();

  $stmt = $pdo->prepare('insert into cancel(name, tel, num, day, employee, created, canceler) values(?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$result["name"], $result["tel"], $result["num"], $result["day"], $result["employee"], $result["created_at"], $name]);

  $stmt = $pdo->prepare("delete from customers where id = :id");
  $stmt->execute([
    ':id' => $id
  ]);
  echo 'success';
  exit();


}

 ?>
