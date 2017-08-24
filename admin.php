<?php

require_once('config.php');

//もしログインに失敗した場合はログインページへ飛ばす
try {
  $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("select * from admin where email = :email");
  $stmt->execute([
   ':email' => $_POST['email']
  ]);
  $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  $user = $stmt->fetch();

  if (empty($user)) {
   echo 'ログイン失敗';
   exit();
  }

  //if (!password_verify($_POST['password'], $user->password)) {
  if(!$_POST['password'] == $user->password){ //登録画面を作るまで
   echo 'ログイン失敗';
   exit();
  }
}
//前回のログイン以降の予約を表示
$stmt = $pdo->prepare("select * from customers where created_at > :lastlogin");
$stmt->execute([
 ':lastlogin' => $user->lastlogin
]);
$reserves = $stmt->fetchAll();
$count = count($reserves);

//lastlogin更新
$stmt = $pdo->prepare("update admin set lastlogin = now() where email = :email");
$stmt->execute([
 ':email' => $user->email
]);
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>管理ページ</title>
   </head>
   <body>
     <h1>ようこそ<?= $user->name; ?>さん</h1>
     <h2>前回のログイン以降の予約は <?= $count ?>件です。</h2>
     <?php if ($count >= 1) :?>
       <?php foreach ($reserves as $row): ?>
         <dt>
           <?= h($row["name"]) ?>様
         </dt>
         <dd>
           日付：<?= h($row["day"]) ?>
           人数：<?= h($row["num"]) ?>
         </dd>
       <?php endforeach; ?>
     <?php endif; ?>
     <a href="#">新規ユーザー登録</a>
   </body>
 </html>
