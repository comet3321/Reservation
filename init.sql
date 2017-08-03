create database reserve_shop;

grant all on reserve_shop.* to dbuser@localhost identified by 'gkjka32e98ud';

use reserve_shop

create table customers(
  id int not null auto_increment primary key,
  name varchar(255),
  tel  varchar(255),
  day varchar(255),
  num int,
  created_at datetime
);
