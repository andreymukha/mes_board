<?php
//todo сделать JQ валидацию форм
header('Content-Type: text/html; charset= utf-8');

session_start();

require_once 'config.php';
require_once 'functions.php';

$categories = getCategories($mysql_link);
$types = get_type($mysql_link);
$user = checkUser($mysql_link);

if(!empty($user) and is_array($user)){
	$add_mess = privileges($mysql_link, $user['role_id'], array('ADD_MESS'));
}

$action = clearData($mysql_link, $_GET['action']);


if(!$action){
	$action = 'index';
}

$title = getTitle($mysql_link, $action, $user);

if(file_exists('actions/' . $action . '.inc.php')){
	include 'actions/' . $action . '.inc.php';
}else{
	include 'actions/' . 'index.inc.php';
}

require_once THEME . 'index.tpl.php';

unset($_SESSION['msg']);

echo '<pre><br /><h4>Текущий пользователь</h4><br />';
print_r($user);
echo '</pre>';

echo '<pre><br /><h4>Данные SERVER</h4><br />';
print_r($_SERVER);
echo '</pre>';