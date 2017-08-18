<?php

require_once('config.php');

//もしログインに失敗した場合はログインページへ飛ばす

$stmt = $this->db->prepare("select * from admin where email = :email");
 $stmt->execute([
   ':email' => $_POST['email']
 ]);
 $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
 $user = $stmt->fetch();

 if (empty($user)) {
   echo '失敗';
   exit()
 }

 if (!password_verify($_POST['password'], $user->password)) {
   echo '失敗'
 }

//AdminUserの場合新規Userの追加ページを表示

//一般Userの場合

//前回のログイン以降の予約を表示

//1週間ごとの詳しい予約内容を表示

 ?>
