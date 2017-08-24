create database reserve_shop;

grant all on reserve_shop.* to dbuser@localhost identified by 'gkjka32e98ud';

use reserve_shop

create table customers(
  id int not null auto_increment primary key,
  name varchar(255),
  tel  varchar(255),
  day varchar(255),
  num int,
  employee varchar(255)  default 'お客さん',
  created_at datetime not null default current_timestamp
);

 create table admin(
   id int not null auto_increment primary key,
   name varchar(255),
   email varchar(255),
   password varchar(255),
   lastlogin varchar(255),
   created_at datetime not null default current_timestamp
 );

insert into admin (name, email, password, lastlogin) values ('admin', 'apd.jinx@gmail.com', 'admin', now());
