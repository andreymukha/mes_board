<?php

if($_SERVER['REQUEST_METHOD'] == 'GET' and $_GET['action'] == 'view_message' and isset($_GET['id'])){
	$id = clearData($mysql_link, $_GET['id'], 'i');
	$message = getMessage($mysql_link, $id);
	$additional_images = explode('|', $message['additional_images']);

	if($user['user_id'] != $message['post_uid'] and $message['published'] == 0){
		$_SESSION['msg']['message'] = setMessage('Данное объявление не существует', 'error');
		$content = template('view_message.tpl.php');
	}
	else{
		$content = template('view_message.tpl.php', array('message' => $message, 'additional_images' => $additional_images));
	}

}else{
	$_SESSION['msg']['message'] = setMessage('Данное объявление не существует', 'error');
	$content = template('view_message.tpl.php');
}

