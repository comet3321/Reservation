<?php
require_once('config.php');
session_start();

try {
  $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

if (!isset($_SESSION['email'])) {
  echo '不正なアクセスです。';
  exit();
}else{
  $stmt = $pdo->prepare("select * from admin where email = :email");
  $stmt->execute([
   ':email' => $_SESSION['email']
  ]);
  $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  $user = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $date = $_POST['date'];
  $stmt2 = $pdo->prepare("select * from customers where date = :date");
  $stmt2->execute([
    ':date' => $date
  ]);
  $stmt2->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  $reserves = $stmt2->fetch();
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>検索結果</title>
  </head>
  <body>
    <h2><?= $user->name ?></h2>
    <h1><?= $date ?>の予約</h1>
    <?php if(empty($reserve)) :?>
      <p>予約はありません。</p>
    <?php else : ?>
      <?php foreach ($reserves as $row): ?>
        <dt>
          <?= h($row["name"]) ?>様
        </dt>
        <dd>
          日付：<?= h($row["day"]) ?>
          人数：<?= h($row["num"]) ?>
        </dd>
      <?php endforeach; ?>
    <?php endif ?>
  </body>
</html>
