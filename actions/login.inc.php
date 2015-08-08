<?php

if(!empty($user) or is_array($user)) {
	header("Location:http://" . $_SERVER['SERVER_NAME'] . "/");
}

if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['auth'])){
	$login = login($mysql_link, $_POST);
	if($login === TRUE){
		header("Location:http://".$_SERVER['SERVER_NAME']."/");
		$_SESSION['msg']['message'] = setMessage('Вы успешно авторизовались', 'success');
	}else{
		$_SESSION['msg']['message'] = $login;
		header('Location: ?' . $_SERVER['QUERY_STRING']);
	}
	exit;
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['logout']) and $_GET['logout'] == 1){
	$logout = logout();
	if($logout === TRUE){
		$_SESSION['msg']['message'] = setMessage('Вы успешно вышли из системы');
		header("Location:http://".$_SERVER['SERVER_NAME']."/");
	}else{
		$_SESSION['msg']['message'] = setMessage('Ошибка при попытке выхода из системы, обратитесь к администратору', 'error');
		header("Location:http://".$_SERVER['SERVER_NAME']."/");
	}
	exit;
}

$content = template('login.tpl.php', array('title' => 'Авторизация'));