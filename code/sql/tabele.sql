drop database if exists filmi;
create database filmi;
use filmi;


/*create table IF NOT EXISTS user (
    UID int primary key auto_increment,
    name char(30) not null,
    mail char(30) not null,
    password_hash char(60) not null,
    status int not null default 0,
    date_created timestamp not null
);


CREATE TABLE IF NOT EXISTS film (tabele.sql
  FID int primary key AUTO_INCREMENT,
  naslov char(100) NOT NULL
);

create table IF NOT EXISTS UserFilm (
FID int not null,
UID int not null,
watched bool NOT NULL,
primary key(uid,fid),
FOREIGN KEY (fid) references film(fid),
FOREIGN KEY (uid) REFERENCES user(uid)
);
*/




create table IF NOT EXISTS user (
    UID int primary key auto_increment,
    name char(30) not null,
    mail char(30) not null,
    password_hash char(60) not null,
    status int not null default 0,
    date_created timestamp not null
);


CREATE TABLE IF NOT EXISTS film (
  FID int primary key AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  year int not null,
  runtime int not null,
  director varchar(30),
  imdb float not null,
  rt int not null
);

create table IF NOT EXISTS UserFilm (
FID int not null,
UID int not null,
watched bool NOT NULL,
primary key(uid,fid),
FOREIGN KEY (fid) references film(fid),
FOREIGN KEY (uid) REFERENCES user(uid)
);