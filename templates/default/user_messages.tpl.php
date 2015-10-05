<? if(!empty($user_messages)): ?>
	<? foreach($user_messages as $message): ?>
		<div class="message<?=$message['unpublished'];?>">
			<div class="content clearfix">
				<? if($message['unpublished']): ?>
					<div class="unpublish-mess">
						UNPUBLISHED
					</div>
				<? endif; ?>

				<h3>
					<a href="?action=view_message&id=<?= $message['post_id']; ?>"><?= $message['title']; ?></a>
				</h3>

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

				<a href="<?= IMAGES . $message['img']; ?>" class="thumbnail clearfix pull-left group2">
					<img class="mini_mess" src="<?= THUMBNAILS . $message['img']; ?>">
				</a>
				<?= nl2br($message['body']); ?>
			</div>

			<div class="links">
				<ul>
					<li><a href="?action=edit_message&id=<?=$message['post_id'];?>">Редактировать</a></li>
					<li><a href="?action=view_message&delete=<?=$message['post_id'];?>">Удалить</a></li>
					<li><a href="?action=view_message&id=<?= $message['post_id']; ?>">Подробнее</a></li>
				</ul>
			</div>
		</div>

	<? endforeach; ?>
<? else: ?>
	<p>У вас нет объявлений</p>
<? endif; ?>
