<?php
require_once('config.php');

session_start();

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
  $_SESSION['email'] = $user->email;

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

$today = date('Y-m-d');


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
     <h2>予約をする</h2>
     <form class="" action="employee_reserve.php" method="post">
       <input type="date" name="date" value=""  min="<?= $today; ?>">
       <button type="submit" name="button">予約を入れる！</button>
     </form>
     <h2>予約を見る/変更する</h2>
     <form class="" action="confirm_reserve.php" method="post">
       <input type="date" name="date" value="">
       <button type="submit" name="button">予約を確認する！</button>
     </form>
     <a href="signin.html">新規ユーザー登録</a>
   </body>
 </html>
