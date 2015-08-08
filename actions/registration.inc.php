<?php

if(!empty($user) or is_array($user)) {
	header("Location:http://" . $_SERVER['SERVER_NAME'] . "/");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['reg'])) {
		$registration = registration($mysql_link, $_POST);
		if ($registration === TRUE) {
			header('Location: ?' . $_SERVER['QUERY_STRING']);
			$_SESSION['msg']['message'] = setMessage('Ваша регистрация принята, дальнейшая инструкция отправлена Вам на email.', 'success');
			exit;
		} else {
			header('Location: ?' . $_SERVER['QUERY_STRING']);
			$_SESSION['msg']['message'] = $registration;
			exit;
		}
	}
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['hash'])) {
		$activate = activation($mysql_link, $_GET['hash']);
		if ($activate === TRUE) {
			$_SESSION['msg']['message'] = setMessage('Ваша учётная запись успешно активирована, можете зайти на сайт под своими учётными данными', 'success');
		} else {
			$_SESSION['msg']['message'] = $activate;
		}
	}
}

$content = template('registration.tpl.php', array('title' => 'Регистрация', 'active' => $activate));