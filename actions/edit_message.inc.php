<?php
if(!$user or !privileges($mysql_link, $user['role_id'], array('ADD_MESS'))) {
	$_SESSION['msg']['message'] = setMessage('Ошибка доступа, у вас нет прав для посещения данный страницы. Пожалуйста, <a href="/?action=login">войдите под своей учётной записью</a> или <a href="/?action=registration">загеристрируйтесь</a>', 'error');
	$content = '';
}else {
	if($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['id'])){
		$message_id = clearData($mysql_link, $_GET['id']);
		$message = editMessage($mysql_link, $message_id);
		$additional_images = explode('|', $message['additional_images']);
		if($user['user_id'] != $message['user_id'] and $message['published'] == 0){
			$_SESSION['msg']['message'] = setMessage('Данное объявление не существует', 'error');
			$content = template('view_message.tpl.php');
		}else{
			$content = template('edit_message.tpl.php', array('message' => $message, 'additional_images' => $additional_images, 'categories' => $categories, 'types' => $types));
		}

	}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
		$update = updateMessage($mysql_link, $_POST, $user);
		if($update === TRUE){
			$_SESSION['msg']['message'] = setMessage('Ваше объявление успешно обновлено, оно появится после модерации', 'success');
			header('Location: '.$_SERVER['PHP_SELF']);
			exit;
		}else{
			$_SESSION['msg']['message'] = $update;
			header('Location: '.$_SERVER['REQUEST_URI']);
			exit;
		}
	}
}