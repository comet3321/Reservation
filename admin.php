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
//AdminUserの場合新規Userの追加ページを表示

//前回のログイン以降の予約を表示

//1週間ごとの詳しい予約内容を表示

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>管理ページ</title>
   </head>
   <body>
     <p>ようこそ<?= $user->name; ?>さん</p>
   </body>
 </html>
