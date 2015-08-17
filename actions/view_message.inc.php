<?php

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'GET' and $_GET['action'] == 'view_message' and isset($_GET['id'])){
	$id = clearData($mysql_link, $_GET['id'], 'i');
	$message = getMessage($mysql_link, $id);

	if($user['user_id'] != $message['post_uid'] and $message['published'] == 0){
		$content = template('view_message.tpl.php');
	}
	else{
		$content = template('view_message.tpl.php', array('message' => $message));
	}

}else{
	$content = template('view_message.tpl.php');
}

