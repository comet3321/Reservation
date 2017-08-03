<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

ini_set('display_errors', 1);
define('DSN', 'mysql:host=localhost;dbname=reserve_shop');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'gkjka32e98ud');
