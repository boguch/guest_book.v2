<?php
$host = "MySQL-8.2"; // Имя хоста
$login = "root"; // Логин
$pass = ""; // Пароль
$db_name = "db_guestBook"; // Имя базы данных
$mysql = new mysqli($host,$login,$pass,$db_name); // Подключение к БД
?>