<?php

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : NULL;
$count = countMessages($mysql_link);

if($count != 0){
	$messages = getMessages($mysql_link, $type, FALSE, $page, PERPAGE);
	$pager = Pager($page, $count, PERPAGE);
	echo '<pre>';
	print_r($pager);
	echo '</pre>';
}else{
	$messages = FALSE;
}

$content = template('content.tpl.php', array('title' => 'Главная страница', 'messages' => $messages, 'pager' => $pager));
