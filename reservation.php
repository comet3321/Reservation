<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $day = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>予約画面</title>
  </head>
  <body>
    <h1>予約画面</h1>
    <p><?= h($day);  ?>の空き部屋は〇件です。</p>
    <h2>予約する</h2>
    <form class="" action="actions.php" method="post">
      名前：<input type="text" name="name">
      電話番号：<input type="text" name="tel">
      人数：<input type="radio" value="1" name="num">1人
      <input type="radio" value="2" name="num">2人
      <input type="radio" value="3" name="num">3人
      <input type="radio" value="4" name="num">4人
      <input type="hidden" name="day" value="<?php echo $day; ?>">
      <button type="submit">予約</button>
    </form>
  </body>
</html>
