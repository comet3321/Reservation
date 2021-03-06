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
  $day = $_POST['date'];
}

$Day = str_replace(array('-'), '', $day);
$today = new \DateTime('today');
$Today = $today->format('Ymd');
if ($Day < $Today) {
  echo '過去の日の予約はできません。';
  exit();
}

$sql_result = $pdo->query("select id from customers where day = '$day'");
$Result = $sql_result->fetchAll();
$count = count($Result);

$available = 5 - $count;

if ($count >= 5) {
  echo '満席御礼！！！！！！！';
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>予約画面</title>
  </head>
  <body>
    <p><?= $user->name; ?>さん</p>
    <h1>予約画面</h1>
    <p><?= h($day);  ?>は現在残り<?= h($available) ?>部屋です。</p>
    <h2>予約する</h2>
    <form class="" action="actions.php" method="post">
      名前：<input type="text" name="name">
      電話番号：<input type="text" name="tel">
      人数：<input type="radio" value="1" name="num">1人
      <input type="radio" value="2" name="num">2人
      <input type="radio" value="3" name="num">3人
      <input type="radio" value="4" name="num">4人
      <input type="hidden" name="day" value="<?php echo $day; ?>">
      <input type="hidden" name="employee" value="<?= $user->name; ?>">
      <button type="submit">予約</button>
    </form>
  </body>
</html>
