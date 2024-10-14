<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'shop';

// Создание подключения к базе данных
$link = mysqli_connect($host, $user, $password, $db);

if (!$link) {
   die("Ошибка подключения: " . mysqli_connect_error());
}

// Устанавливаем кодировку соединения
mysqli_set_charset($link, 'utf8mb4');
?>
