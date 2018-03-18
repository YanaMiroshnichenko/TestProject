<?php

$dbhost = "localhost"; // Имя хоста БД
$dbusername = "root"; // Пользователь БД
$dbpass = ""; // Пароль к базе
$dbname = "guest-book"; // Имя базы

// Open Connection
$link = mysqli_connect('localhost', 'root', '', 'guest-book');

if (!$link) {
    echo "Error: " . mysqli_connect_error();
	exit();
}



?>