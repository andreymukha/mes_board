<?php

/**
 * Функция возвращает системное сообщение в отформатированном div блоке,
 * используется для вывода сообщения сообщения в
 * функциях с последующим сохранением в сессионной переменной, выводится в шаблоне page.tpl.php
 *
 * @param string $message
 *    (обязательно) Сообщение для вывода на экран.
 *
 * @see http://getbootstrap.com/components/#alerts Читать подробнее о типах сообщений
 *
 * @param string $type
 *    (опционально) Тип сообщения. По умолчанию 'info', доступные значения:
 *        - 'success' (alert-success)
 *        - 'info' (alert-info)
 *        - 'warning' (alert-warning)
 *        - 'error' (alert-danger)
 *
 * @return string
 *    Отформатированное сообщение
 *
 * @author Fly
 */
function setMessage($message, $type = 'info') {
	switch($type){
		case 'success':
			$type = 'alert-success';
		break;
		case 'warning':
			$type = 'alert-warning';
		break;
		case 'error':
			$type = 'alert-danger';
		break;
		case 'info':
			$type = 'alert-info';
		break;
		default:
			$type = 'alert-info';
	}
	return template('system_message.tpl.php', array('message' => $message, 'type' => $type));
}

function getTitle($action){
	foreach(scandir('actions') as $dir){
		if($dir == '..' or $dir == '.') continue;
		$dir = explode('.', $dir);
		$dir = $dir[0];
		if($action == $dir){
			switch($action){
				case 'index': return 'Главная страница'; break;
				case 'login': return 'Авторизация'; break;
				case 'registration': return 'Регистрация'; break;
				case 'add_message': return 'Добавить объявление'; break;
				case 'user_messages': return 'Мои объявления'; break;}
		}
	}
}

/**
 * Функция для очистки, введённых пользователем, данных
 *
 * @param resource $link
 *    Соединение с базой данных
 *
 * @param string $data
 *    Необработанная строка
 *
 * @param string $type
 *    Ожидаемый на выходе тип, доступные значения:
 *        - 's' - для преобразования в строку
 *        - 'i' - для преобразования в целое положительное число
 *
 * @return  number|string
 *    Отформатированная строка
 *
 * @author Fly
 */
function clearData($link, $data, $type="s"){
	$result = '';
	switch($type){
		case "s": $result = mysqli_real_escape_string($link, trim(strip_tags($data))); break;
		case "l": $result = mysqli_real_escape_string($link, trim(strip_tags($data, '<p><a><div><br><br /><span><div>'))); break;
		case "i": $result = abs((int)$data); break;
	}
	return $result;
}

/**
 * Функция-шаблонизатор - выводит в шаблон данные
 *
 * @param string $path
 *    Имя шаблона для вывода
 *
 * @param array $vars
 *    Данные, которые необходимо передать в шаблон
 *
 * @return string
 *    Возвращает готовый HTML код
 *
 * @author Fly
 */
function template($path, $vars = array()){
	if(!empty($vars) and is_array($vars)){
		extract($vars);
	}
	ob_start();
	include THEME.$path;
	return ob_get_clean();
}

/**
 * Регистрация учётной записи
 *
 * @param $mysql_link
 *    Соединение с базой данных
 *
 * @param $data
 *    Необработанные данные пользователя из регистрационной формы
 *
 * @return bool|string
 *    При неудачной регистрации возвращает отформатированный текст ошибки по шаблону system_message.tpl.php, при успехе
 *     возвращает булево значение TRUE
 *
 * @author Fly
 */
function registration($mysql_link, $data){
	$reg_login = clearData($mysql_link, $data['reg_login']);
	$reg_email = clearData($mysql_link, $data['reg_email']);
	$reg_name = clearData($mysql_link, $data['reg_name']);
	$reg_pass = trim($data['reg_password']);
	$reg_pass_confirm = trim($data['reg_password_confirm']);

	$msg = '';

	//todo сделать проверку на количество символов

	if(empty($reg_login)){
		$msg .= 'Введите логин<br \>';
	}

	if(empty($reg_email)){
		$msg .= 'Введите email<br \>';
	}

	if(empty($reg_name)){
		$msg .= 'Введите имя<br \>';
	}

	if(empty($reg_pass)){
		$msg .= 'Введите пароль<br \>';
	}

	if(!empty($reg_pass) and $reg_pass !== $reg_pass_confirm){
		$msg .= 'Пароли не совпадают<br \>';
	}

	$sql = "SELECT COUNT(*) as cnt FROM mes_users WHERE login = '$reg_login'";
	$result = mysqli_query($mysql_link, $sql);
	$result = mysqli_fetch_assoc($result);
	if($result['cnt'] != 0){
		$msg .= 'Такой логин уже существует<br \>';
	}

	$sql = "SELECT COUNT(*) as cnt FROM mes_users WHERE email = '$reg_email'";
	$result = mysqli_query($mysql_link, $sql);
	$result = mysqli_fetch_assoc($result);
	if($result['cnt'] != 0){
		$msg .= 'Такой email уже существует<br \>';
	}

	if(!empty($msg)){
		$_SESSION['msg']['reg'] = array(
			'login' => $reg_login,
			'name' => $reg_name,
			'email' => $reg_email,
		);
		return setMessage($msg, 'error');
	}

	$reg_pass = md5($reg_pass);
	$hash = md5(microtime());

	$sql = "INSERT INTO mes_users (login, password, name, hash, email, created, last_login) VALUES ('%s', '%s', '%s', '%s', '%s', UNIX_TIMESTAMP(), UNIX_TIMESTAMP())";
	$sql = sprintf($sql, $reg_login, $reg_pass, $reg_name, $hash, $reg_email);

	$result = mysqli_query($mysql_link, $sql);

	if(!$result){
		$_SESSION['msg']['reg'] = array(
			'login' => $reg_login,
			'name' => $reg_name,
			'email' => $reg_email,
		);
		return setMessage('Ошибка при регистрации, обратитесь к администратору или попробуйте зарегистрироваться позже', 'error');
	}

	$mail_headers = '';
	$mail_headers .= "From: Стройкасса <admin@stroikassa.com> \r\n";
	$mail_headers .= "Content-Type: text/plain; charset=utf8";
	$mail_subject = "Регистрация стройкасса.рф";
	$mail_body = "Спасибо за регистрацию на сайте. Ваша ссылка для активации учётной записи: http://{$_SERVER['SERVER_NAME']}/?action=registration&hash=" . $hash;

	mail($reg_email, $mail_subject, $mail_body, $mail_headers);

	return TRUE;
}

/**
 * Активация учётной записи по ссылке из email сообщения
 *
 * @param $mysql_link
 *    Соединение с базой данных
 *
 * @param $hash
 *    Хэш для активации пользователя, передаётся из GET параметра
 *
 * @return bool|string
 *    При успехе возвращает TRUE, при неудаче возвращает отформатированное сообщение об ошибке
 *
 * @author Fly
 */
function activation($mysql_link, $hash){
	$hash = clearData($mysql_link, $hash);
	$sql = "UPDATE mes_users SET active='1' WHERE hash = '%s'";
	$sql = sprintf($sql, $hash);
	$result = mysqli_query($mysql_link, $sql) or die(mysqli_error($mysql_link));
	if(mysqli_affected_rows($mysql_link) == 1){
		return TRUE;
	}else{
		return setMessage('Неверный код подтверждения регистрации', 'error');
	}
}

/**
 * Функция авторизует пользователя
 *
 * @param $mysql_link
 * 	Соединение с базой данных
 *
 * @param $data
 *
 * @return bool|string
 *
 * @author Fly
 */
function login($mysql_link, $data){
	if(!is_array($data)){
		return FALSE;
	}

	if(empty($data['auth_login']) or empty($data['auth_password'])){
		return setMessage('Заполните все поля', 'error');
	}

	$login = clearData($mysql_link, $data['auth_login']);
	$password = md5(trim($data['auth_password']));

	$sql = "SELECT user_id, active FROM mes_users WHERE login='%s' AND password='%s'";
	$sql = sprintf($sql, $login, $password);
	$result = mysqli_query($mysql_link, $sql);

	if(mysqli_num_rows($result) == 0){
		return setMessage('Неправильный логин или пароль', 'error');
	}

	$confirm = mysqli_fetch_assoc($result);

	if($confirm['active'] == 0){
		return setMessage('Ваша учётная запись не активирована, пожалуйста, активируйте вашу учётную запись по ссылке из письма у вас в почтовом ящике', 'warning');
	}

	$sess = md5(microtime());
	$sql = "UPDATE mes_users SET sess='$sess' WHERE login='%s'";
	$sql = sprintf($sql, $login);
	$result = mysqli_query($mysql_link, $sql);
	if(!$result){
		return setMessage('Ошибка авторизации, обратитесь к администратору', 'error');
	}

	$_SESSION['sess'] = $sess;

	if($data['remember'] == 'on'){
		$time = time() + (30*24*3600);
		setcookie('uid', $confirm['user_id'], $time);
		setcookie('login', $login, $time);
		setcookie('password', $password, $time);
	}

	//Обновляем дату входа пользователя под своей учётной записью
	$sql = "UPDATE mes_users SET last_login=UNIX_TIMESTAMP() WHERE user_id={$confirm['user_id']}";
	mysqli_query($mysql_link, $sql);

	return TRUE;
}

function checkUser($mysql_link){
	if(isset($_SESSION['sess'])){
		$sess = $_SESSION['sess'];
		$sql = "SELECT user_id, login, name, email, role_id, created, last_login FROM mes_users WHERE sess='$sess' AND active='1'";
		$result = mysqli_query($mysql_link, $sql);

		if(!$result or mysqli_num_rows($result) < 1){
			return FALSE;
		}

		return mysqli_fetch_assoc($result);

	}elseif(isset($_COOKIE['login']) and isset($_COOKIE['password'])){
		$login = clearData($mysql_link, $_COOKIE['login']);
		$password = clearData($mysql_link, $_COOKIE['password']);

		$sql = "SELECT user_id, login, name, email, role_id, created, last_login FROM mes_users WHERE login='$login' AND password='$password' AND active='1'";
		$result = mysqli_query($mysql_link, $sql);

		if(!$result or mysqli_num_rows($result) < 1){
			return FALSE;
		}

		$sess = md5(microtime());
		$sql = "UPDATE mes_users SET sess='$sess' WHERE `login`='%s'";
		$sql = sprintf($sql, $login);
		$result2 = mysqli_query($mysql_link, $sql);
		if(!$result2){
			return FALSE;
		}

		$_SESSION['sess'] = $sess;

		return mysqli_fetch_assoc($result);
	}else{
		return FALSE;
	}
}

function logout(){
	unset($_SESSION['sess']);
	if(!setcookie('login', '', time()-3600)){
		return FALSE;
	}
	if(!setcookie('password', '', time()-3600)){
		return FALSE;
	}
	if(!setcookie('uid', '', time()-3600)){
		return FALSE;
	}
	return TRUE;
}

//todo сделать восстановление пароля
//todo сделать возможность смены пароля

function privileges($mysql_link, $id, $priv_adm) {
	$priv = getPrivileges($mysql_link, $id);

	if(!$priv) {
		$priv = array();
	}

	$arr = array_intersect($priv_adm, $priv);

	if($arr === $priv_adm) {
		return TRUE;
	}

	return FALSE;
}

function getPrivileges($mysql_link, $id) {
	$sql = "SELECT mes_privilegies.name AS priv FROM mes_privilegies LEFT JOIN mes_role_priv ON mes_role_priv.priv_id = mes_privilegies.priv_id WHERE mes_role_priv.role_id = '$id'";

	$result = mysqli_query($mysql_link, $sql);

	if(!$result) {
		return FALSE;
	}

	for($i = 0; $i < mysqli_num_rows($result); $i++) {
		$row = mysqli_fetch_array($result, MYSQL_NUM);
		$arr[] = $row[0];
	}

	return $arr;
}

function getResult($result){
	if(!$result){
		return FALSE;
	}

	if(mysqli_num_rows($result) == 0){
		return FALSE;
	}

	$list = array();

	while($row = mysqli_fetch_assoc($result)){
		$list[] = $row;
	}

	return $list;
}

function get_type($mysql_link){
	$sql = "SELECT type_id, name FROM mes_types";
	$result = mysqli_query($mysql_link, $sql);
	return getResult($result);
}

function getCategories($mysql_link){
	$sql = "SELECT * FROM mes_categories";
	$result = mysqli_query($mysql_link, $sql);

	if(!$result or mysqli_num_rows($result) == 0){
		return FALSE;
	}

	$categories = array();

	while($row = mysqli_fetch_assoc($result)){
		if($row['parent_id'] == 0){
			$categories[$row['category_id']][] = $row['name'];
		}else{
			$categories[$row['parent_id']]['parent'][$row['category_id']] = $row['name'];
		}
	}
	return $categories;
}

function getImg(){
	$with = 160;
	$height = 80;

	$r = mt_rand(100, 255);
	$g = mt_rand(100, 255);
	$b = mt_rand(100, 255);

	$img = imagecreatetruecolor($with, $height);
	$bg = imagecolorallocate($img, $r, $g, $b);
	$color = imagecolorallocate($img, 7, 7, 7);

	imagefilledrectangle($img, 0, 0, $with, $height, $bg);

	for($h = mt_rand(1, 10); $h < $height; $h = $h + mt_rand(1 , 10)){
		for($w = mt_rand(1, 10); $w < $with; $w = $w + mt_rand(1 , 20)){
			imagesetpixel($img, $w, $h, $color);
		}
	}

	$str = genStr(1);

	$_SESSION['capcha'] = $str;

	$dir = opendir('fonts/');
	$fonts = array();
	while(FALSE != ($file = readdir($dir))){
		if($file == '.' or $file == '..') continue;
		$fonts[] = $file;
	}

	$x = 20;
	for($i = 0; $i < strlen($str); $i++){
		$font = 'fonts/'.$fonts[mt_rand(0, count($fonts) - 1)];
		$size = mt_rand(20, 35);
		$angle = mt_rand(-30, 30);
		$y = mt_rand(40, 45);

		imagettftext($img, $size, $angle, $x, $y, $color, $font, $str[$i]);
		$x += $size - 5;
	}

	for($c = 0; $c < 5; $c++){
		$x1 = mt_rand(0, intval($with*0.1));
		$x2 = mt_rand(intval($with*0.8), $with);

		$y1 = mt_rand(0, intval($height*0.6));
		$y2 = mt_rand(intval($height*0.3), $height);

		imageline($img, $x1, $y1, $x2, $y2, $color);
	}

	header('Content-Type: image/png');
	imagepng($img);
	imagedestroy($img);
}

function genStr($max_letters){
	$str = '23456789abcdegikpqsvxz';
	$str_g = '';
	for($i = 0; $i < $max_letters; $i++){
		$index = mt_rand(0 , strlen($str) - 1);
		if($i != 0){
			if($str_g[strlen($str_g) - 1] == $str[$index]){
				$i--;
				continue;
			}
		}
		$str_g .= $str[$index];
	}
	return $str_g;
}

function addMessage($mysql_link, $data, $user) {
	$title = clearData($mysql_link, $data['mes_title']);
	$type = clearData($mysql_link, $data['mes_type'], 'i');
	$category = clearData($mysql_link, $data['mes_categories'], 'i');
	$town = clearData($mysql_link, $data['mes_town']);
	$time = clearData($mysql_link, $data['mes_time'], 'i');
	$price = clearData($mysql_link, $data['mes_price']);
	$body = clearData($mysql_link, $data['mes_body'], 'l');

	$msg = '';

	if(empty($_SESSION['capcha']) or $_SESSION['capcha'] !== $data['capcha']) {
		$msg .= 'Неправильный код с картинки<br \>';
	}

	unset($_SESSION['capcha']);

	if(empty($title)) {
		$msg .= 'Введите название объявления<br \>';
	}

	if(empty($type)) {
		$msg .= 'Выберите тип объявления<br \>';
	}

	if(empty($category)) {
		$msg .= 'Выберите категорию<br \>';
	}

	if(empty($town)) {
		$msg .= 'Введите город<br \>';
	}

	if(empty($time)) {
		$msg .= 'Выберите период актуальности объявления<br \>';
	}

	if(empty($price)) {
		$msg .= 'Введите цену<br \>';
	}

	if(empty($body)) {
		$msg .= 'Введите текст объявления<br \>';
	}


	if(empty($_FILES['mes_image']['tmp_name'])){
		$msg .= 'Поле для изображения не должно быть пустым<br \>';
	}

	if(!empty($msg)) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage($msg, 'error');
	}

	if(!empty($_FILES['mes_image']['erroe'])) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Ошибка при загрузке файла, обратитесь к администратору', 'error');
	}

	$mime_types = array(
		'jpeg' => 'image/jpeg',
		'pjpeg' => 'image/pjpeg',
		'png' => 'image/png',
		'x-png' => 'image/x-png',
		'gif' => 'image/gif',
	);

	$mime_img = array_search($_FILES['mes_image']['type'], $mime_types);

	if(!$mime_img) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Неверный тип изображения, доспускаются только '.implode(', ', $mime_types), 'error');
	}

	if($_FILES['mes_image']['size'] > (2 * 1024 * 1024)) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Слишком большое изображение', 'error');
	}

	$filename = pathinfo($_FILES['mes_image']['name']);
	$filename = time().'-'. uniqid() . '.' . $filename['extension'];

	if(!file_exists(FILES)){
		mkdir(FILES, 0755);
	}

	if(!file_exists(IMAGES)){
		mkdir(IMAGES, 0755);
	}

	if(!file_exists(THUMBNAILS)){
		mkdir(THUMBNAILS, 0755);
	}


	if(!move_uploaded_file($_FILES['mes_image']['tmp_name'], IMAGES . $filename)) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Ошибка при копировании файла, обратитесь к администратору', 'error');
	}

	if(!img_resize($filename, $mime_img)) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Ошибка при создании уменьшенной копии изображения, обратитесь к администратору'. 'error');
	}


	//Дополнительные изображения
	$additional_images = '';

	$msg = '';

	if(!empty($_FILES['additional_img'])){
		for($i = 0; $i < count($_FILES['additional_img']['name']); $i++){
			if(empty($_FILES['additional_img']['name'][$i])) continue;

			if(!empty($_FILES['additional_img']['erroe'][$i])) {
				$msg .= 'Ошибка при загрузке дополнительного изображения '.$i.', обратитесь к администратору<br \>';
				continue;
			}

			$mime_img = array_search($_FILES['additional_img']['type'][$i], $mime_types);

			if(!$mime_img) {
				$msg .= 'Неверный тип дополнительного изображения '.$i.'<br \>';
				continue;
			}

			if($_FILES['additional_img']['size'][$i] > (2 * 1024 * 1024)) {
				$msg .= 'Слишком большое дополнительное изображение '.$i.'<br \>';
				continue;
			}

			$additional_filename = pathinfo($_FILES['additional_img']['name'][$i]);
			$additional_filename = $i.'-'.time().'-'.uniqid().'.'.$additional_filename['extension'];

			if(!move_uploaded_file($_FILES['additional_img']['tmp_name'][$i], IMAGES . $additional_filename)) {
				$msg .= 'Ошибка при копировании дополнительного изображения '.$i.', обратитесь к администратору<br \>';
				continue;
			}

			if(!img_resize($additional_filename, $mime_img)) {
				$_SESSION['msg']['mess']['title'] = $title;
				$_SESSION['msg']['mess']['town'] = $town;
				$_SESSION['msg']['mess']['time'] = $time;
				$_SESSION['msg']['mess']['price'] = $price;
				$_SESSION['msg']['mess']['body'] = $body;
				$msg .= 'Ошибка при создании уменьшенной копии дополнительного изображения '.$i.', обратитесь к администратору<br \>';
			}

			$additional_images .= $additional_filename.'|';
		}

		if(!empty($msg)) {
			$_SESSION['msg']['mess']['title'] = $title;
			$_SESSION['msg']['mess']['town'] = $town;
			$_SESSION['msg']['mess']['time'] = $time;
			$_SESSION['msg']['mess']['price'] = $price;
			$_SESSION['msg']['mess']['body'] = $body;
			return setMessage($msg, 'error');
		}

		$additional_images = rtrim($additional_images, '|');
	}

	$sql = "INSERT INTO mes_posts (title, body, date, user_id, category_id, type_id, town, img, additional_images, time_over, price) VALUES ('%s', '%s', UNIX_TIMESTAMP(), '%d', '%d', '%d', '%s', '%s', '%s', '%d', '%d')";
	$sql = sprintf($sql, $title, $body, $user['user_id'], $category, $type, $town, $filename, $additional_images, $time, $price);

	$result = mysqli_query($mysql_link, $sql);

	if(!$result) {
		$_SESSION['msg']['mess']['title'] = $title;
		$_SESSION['msg']['mess']['town'] = $town;
		$_SESSION['msg']['mess']['time'] = $time;
		$_SESSION['msg']['mess']['price'] = $price;
		$_SESSION['msg']['mess']['body'] = $body;
		return setMessage('Ошибка при добавлении объявления, обратитесь к администратору', 'error');
	}

	return TRUE;
}

function img_resize($img, $type) {
	$img_id = '';
	ini_set("gd.jpeg_ignore_warning", 1);

	switch($type){
		case 'jpeg':
		case 'pjpeg':
			$img_id = @imagecreatefromjpeg(IMAGES.$img);
		break;
		case 'png':
		case 'xpng':
			$img_id = @imagecreatefrompng(IMAGES.$img);
		break;
		case 'gif':
			$img_id = @imagecreatefromgif(IMAGES.$img);
		break;
		default: return FALSE;
	}

	$img_with = @imagesx($img_id);
	$img_height = @imagesy($img_id);

	$ratio = round($img_with/IMG_WIDTH, 2);

	$img_resized_width = round($img_with/$ratio);
	$img_resized_height = round($img_height/$ratio);

	$img_bg_id = @imagecreatetruecolor($img_resized_width, $img_resized_height);

	@imagecopyresampled($img_bg_id, $img_id, 0, 0, 0, 0, $img_resized_width, $img_resized_height, $img_with, $img_height);

	$img = @imagejpeg($img_bg_id, THUMBNAILS.$img, 100);

	@imagedestroy($img_id);
	@imagedestroy($img_bg_id);

	if($img){
		return TRUE;
	}else{
		return FALSE;
	}
}

function getUserMessages($mysql_link, $user_id){
	$sql = "SELECT
				mes_posts.post_id,
				mes_posts.title,
				mes_posts.body,
				mes_posts.date,
				mes_posts.town,
				mes_posts.img,
				mes_posts.published,
				mes_posts.time_over,
				mes_posts.is_actual,
				mes_posts.price,
				mes_users.user_id AS uid,
				mes_users.name AS uname,
				mes_users.email AS uemail,
				mes_categories.name AS cname,
				mes_types.name AS tname
			FROM mes_posts
			LEFT JOIN mes_users ON mes_users.user_id = '$user_id'
			LEFT JOIN mes_categories ON mes_categories.category_id = mes_posts.category_id
			LEFT JOIN mes_types ON mes_types.type_id = mes_posts.type_id
			WHERE mes_posts.user_id = '$user_id'
			ORDER BY mes_posts.date DESC
	";
	$result = mysqli_query($mysql_link, $sql);
	$user_messages = getResult($result);
	return $user_messages;
}



























