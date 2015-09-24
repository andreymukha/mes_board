<?php

/**
 * Хост базы данных
 */
define('DB_HOST', 'localhost');

/**
 * Имя базы данных
 */
define('DB_NAME', 'board2');

/**
 * Юзер базы данных
 */
define('DB_USER', 'root');

/**
 * Пароль к юзеру базы данных
 */
define('DB_PASS', '');

/**
 * Префикс таблицы базы данных
 */
define('DB_PREF', 'mes_');

/**
 * Тема по умолчанию для скрипта
 */
define('THEME', 'templates/default/');

/**
 * Путь к папке с файлами
 */
define('FILES', 'files/');

/**
 * Путь к папке с изображениями
 */
define('IMAGES', FILES.'images/');

define('IMG_WIDTH', '200');

define('THUMBNAILS', IMAGES.'thumb/');

//define('PERPAGE', '10');

$mysql_link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error($mysql_link));

mysqli_query($mysql_link, "SET NAMES UTF8");