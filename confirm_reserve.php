<?php
session_start();

require_once('config.php');

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
  $stmt = $pdo->prepare("select * from customers where day = :date");
  $stmt->execute([
    ':date' => $date
  ]);
  $reserves = $stmt->fetchAll();

  $stmt = $pdo->prepare("select * from cancel where day = :date");
  $stmt->execute([
    ':date' => $date
  ]);
  $cancels = $stmt->fetchAll();
}


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>検索結果</title>
  </head>
  <body>
    <h2><?= h($user->name); ?></h2>
    <h1><?= h($date); ?>の予約</h1>
    <?php if(empty($reserves)) :?>
      <p>予約はありません。</p>
    <?php else : ?>
      <?php foreach ($reserves as $row): ?>
        <dt>
          <?= h($row["name"]) ?>様
        </dt>
        <dd>
          人数：<?= h($row["num"]) ?>
          予約した人<?= h($row["employee"]) ?>
        </dd>
        <form class="" action="cancel.php" method="post">
          <input type="hidden" name="id" value="<?= h($row["id"]); ?>">
          <input type="hidden" name="name" value="<?= h($user->name) ; ?>">
          <button type="submit" name="button">キャンセル</button>
        </form>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if(isset($cancels)) :?>
      <?php foreach ($cancels as $row): ?>
        <dt style="color: red;">
          <?= h($row["name"]) ?>様
        </dt>
        <dd style="color: red;">
          人数：<?= h($row["num"]) ?>
          予約した人：<?= h($row["employee"]) ?>
          キャンセルした人：<?= h($row["canceler"]) ?>
        </dd>
        <form class="" action="cancel.php" method="post">
          <input type="hidden" name="id" value="<?= h($row["id"]); ?>">
          <input type="hidden" name="name" value="<?= h($user->name) ; ?>">
        </form>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
