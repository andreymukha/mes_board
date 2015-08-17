<!--@todo Сделать возиожность редактирования для пользователя-->
<? if(!empty($message) and is_array($message)): ?>
	<div class="t_mess unpublished<?= $message['published']; ?>">
		<div class="content">
			<? if($message['published'] == 0): ?>
				<div class="unpublish-mess">
					<i>U</i><i>N</i><i>P</i><i>U</i><i>B</i><i>L</i><i>I</i><i>S</i><i>H</i><i>E</i><i>D</i>
				</div>
			<? endif; ?>

			<h4 class="title_p_mess"><?= $message['title']; ?></h4>

			<p class="p_mess_cat">
				<strong>Категория:</strong> <?= $message['cname']; ?> |
				<strong>Тип объявления:</strong> <?= $message['tname']; ?> |
				<strong>Город:</strong> <?= $message['town']; ?>
			</p>

			<p class="p_mess_cat">
				<strong>Дата добавления объявления:</strong> <?= date('d.m.Y - H:i:s', $message['date']); ?> |
				<strong>Цена:</strong> <?= $message['price']; ?> |
				<strong>Автор</strong> <a href="mailto:<?= $message['uemail']; ?>"><?= $message['uname']; ?></a>
			</p>

			<p>
				<img class="mini_mess" src="<?= THUMBNAILS . $message['img']; ?>">
				<?= nl2br($message['body']); ?>
			</p>
		</div>

		<div class="clearfix"></div>
		<div class="links">
			<ul>
				<li><a href="?action=user_idit_message&id=<?= $message['post_id']; ?>">Редактировать</a></li>
				<li><a href="?action=user_messages&delete=<?= $message['post_id']; ?>">Удалить</a></li>
			</ul>
		</div>
	</div>
<? else: ?>
	<p>Нет такого объявления</p>
<? endif; ?>
