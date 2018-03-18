<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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