drop database if exists reserve_db;
create database reserve_db;

drop user if exists 'user'@'localhost';
create user 'user'@'localhost' identified by '@Password1';
grant all on reserve_db.* to 'user'@'localhost';
flush privileges;

use reserve_db;

drop table if exists seq;
create table seq
(
    reserve_seq bigint unsigned not null default '0',
    reserve_seat_seq bigint unsigned not null default '0',
    customer_seq bigint unsigned not null default '0'
);

drop table if exists reserve_info;
create table reserve_info
(
    reserve_id char(10) primary key,
    customer_id char(10) not null,
    customer_name varchar(20) not null,
    customer_tel varchar(20) not null,
    reserve_date_from datetime,
    reserve_date_to datetime,
    reserve_quantity int,
    seat_type char(10),
    smoking_flg bool,
    reserve_seat_id char(10),
    reserve_notes varchar(512),
    staff_code char(10),
    cancel_staff_code char(10),
    cancel_date datetime,
    cancel_reason varchar(512),
    delete_staff_code char(10),
    delete_reason varchar(512),
    insert_date datetime,
    update_date datetime,
    delete_date datetime
);

drop table if exists reserve_seat_info;
create table reserve_seat_info
(
    reserve_seat_id char(10),
    reserve_id char(10),
    seat_id char(10),
    insert_date datetime,
    update_date datetime,
    delete_date datetime,
    primary key (reserve_seat_id, reserve_id, seat_id)
);

drop table if exists m_seat;
create table m_seat
(
    seat_id char(10) primary key,
    seat_name varchar(20),
    seat_type char(10),
    seat_quantity int,
    smoking_flg bool,
    insert_date datetime,
    update_date datetime,
    delete_date datetime
);

drop table if exists m_customer;
create table m_customer
(
    customer_id char(10) primary key,
    customer_tel varchar(20) not null,
    customer_name varchar(20) not null,
    customer_notes varchar(1024),
    blacklist_flg bool,
    blacklist_notes varchar(1024),
    insert_date datetime,
    update_date datetime,
    delete_date datetime
);

insert into seq
(
    reserve_seq
    ,reserve_seat_seq
    ,customer_seq
) values (
    0
    ,0
    ,0
);

insert into m_seat 
(
seat_id
,seat_name
,seat_type
,seat_quantity
,smoking_flg
)
values (
    'S0001'
    ,'席A'
    ,'table'
    ,4
    ,0
);
insert into m_seat 
(
seat_id
,seat_name
,seat_type
,seat_quantity
,smoking_flg
)
values (
    'S0002'
    ,'席B'
    ,'table'
    ,4
    ,0
);
insert into m_seat 
(
seat_id
,seat_name
,seat_type
,seat_quantity
,smoking_flg
)
values (
    'S0003'
    ,'席C'
    ,'box'
    ,6
    ,1
);

insert into m_seat 
(
seat_id
,seat_name
,seat_type
,seat_quantity
,smoking_flg
)
values (
    'S0004'
    ,'席D'
    ,'counter'
    ,1
    ,1
);

