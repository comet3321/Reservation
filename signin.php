<?php
session_start();

require_once('config.php');


try {
  $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['email'] === 'apd.jinx@gmail.com' || password_verify($_POST['password'], $user->password)){
    echo 'success';
  }else{
    echo 'error';
    exit();
  }


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

  if (!password_verify($_POST['password'], $user->password)) {
   echo 'ログイン失敗';
   exit();
  }
}

if (!isset($_SESSION['email'])) {
  echo '不正なアクセスです。';
  exit();
}
$_SESSION['email'] = $user->email;

 ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>sign up</title>
  </head>
  <body>
    <h2>新しいユーザーを登録できます</h2>
    <form action="signup.php" method="post">
      <input type="text" name="name" placeholder="名前">
      <input type="email" name="email" placeholder="email">
      <input type="password" name="password" placeholder="パスワード">
      <button type="submit" name="button">登録</button>
    </form>
  </body>
</html>
