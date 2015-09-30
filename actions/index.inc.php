<?php

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : NULL;
$count = countMessages($mysql_link, $type);

if($count != 0){
	$messages = getMessages($mysql_link, $type, FALSE, $page, PERPAGE);
	if(is_array($messages)){
		$messages = messageIntro($messages);
	}
	$pager = Pager($page, $count, PERPAGE);
}else{
	$messages = FALSE;
	$pager = FALSE;
}

if($type){
	$type = '&type='.$type;
}



$content = template('content.tpl.php', array('title' => 'Главная страница', 'messages' => $messages, 'pager' => $pager, 'type' => $type));
