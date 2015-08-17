<?php

if(!$user or privileges($mysql_link, !$user['role_id'], array('ADD_MESS'))) {
	$_SESSION['msg']['message'] = setMessage('Ошибка доступа, у вас нет прав для посещения данный страницы. Пожалуйста, <a href="/?action=login">войдите под своей учётной записью</a> или <a href="/?action=registration">загеристрируйтесь</a>', 'error');
	$content = '';
}else{
	$user_messages = getUserMessages($mysql_link, $user['user_id']);
	$content = template('user_messages.tpl.php', array('user_messages' => $user_messages));
}