<?php

if($_SERVER['REQUEST_METHOD'] == 'GET' and $_GET['action'] == 'view_message' and isset($_GET['id'])){
	$id = clearData($mysql_link, $_GET['id'], 'i');
	$message = getMessage($mysql_link, $id);
	$additional_images = explode('|', $message['additional_images']);
	$links = FALSE;

	if($user['user_id'] != $message['post_uid'] and $message['published'] == 0){
		$_SESSION['msg']['message'] = setMessage('Данное объявление не существует', 'error');
		$content = template('view_message.tpl.php');
	}
	else{
		if($user['user_id'] == $message['post_uid']){
			$links = TRUE;
		}
		$content = template('view_message.tpl.php', array('message' => $message, 'additional_images' => $additional_images, 'links' => $links));
	}

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' and $_GET['action'] == 'view_message' and isset($_GET['delete'])){
	$message_id = $_GET['delete'];
	$message = getMessage($mysql_link, $message_id);
	if(!$user or $user['user_id'] != $message['post_uid']) {
		$_SESSION['msg']['message'] = setMessage('Ошибка доступа, у вас нет прав для посещения данный страницы. Пожалуйста, <a href="/?action=login">войдите под своей учётной записью</a> или <a href="/?action=registration">загеристрируйтесь</a>', 'error');
		$content = '';
	}else {
		$delete = deleteMessage($mysql_link, $message_id);
		if($delete === TRUE){
			header('Location: ?action=user_messages');
			$_SESSION['msg']['message'] = setMessage('Ваше объявление удалено', 'success');
			exit;
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']);
			$_SESSION['msg']['message'] = $delete;
			exit;
		}
	}
}else{
	$_SESSION['msg']['message'] = setMessage('Данное объявление не существует', 'error');
	$content = template('view_message.tpl.php');
}

