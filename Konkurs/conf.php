<?php
$servernimi = 'localhost';
$kasutajanimi = 'artemstryz';
$parool = '123456';
$andmebaasinimi = 'artemstryz';
$yhendus = new mysqli($servernimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus -> set_charset('UTF8');

/*
 create table konkurss(
	id int primary key AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int default 0,
    kommentaar text,
    avalik int default 1
)*/
?>
