<?php
if(!$user or privileges($mysql_link, !$user['role_id'], array('ADD_MESS'))) {
	$_SESSION['msg']['message'] = setMessage('Ошибка доступа, у вас нет прав для посещения данный страницы. Пожалуйста, <a href="/?action=login">войдите под своей учётной записью</a> или <a href="/?action=registration">загеристрируйтесь</a>', 'error');
	$content = '';
}else {
	if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['add_message'])){
		$message = addMessage($mysql_link, $_POST, $user);
		if($message === TRUE){
			$_SESSION['msg']['message'] = setMessage('Ваше объявление успешно добавлено, оно появится после модерации', 'success');
			header('Location: '.$_SERVER['PHP_SELF']);
			exit;
		}else{
			$_SESSION['msg']['message'] = $message;
			header('Location: '.$_SERVER['REQUEST_URI']);
			exit;
		}
	}
	$content = template('add_message.tpl.php', array('categories' => $categories, 'types' => $types));
}