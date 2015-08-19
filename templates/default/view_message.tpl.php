<!--@todo Сделать возиожность редактирования для пользователя-->
<? if(!empty($message) and is_array($message)): ?>
	<div class="t_mess unpublished<?= $message['published']; ?>">
		<div class="content">
			<? if($message['published'] == 0): ?>
				<div class="unpublish-mess">
					<i>U</i><i>N</i><i>P</i><i>U</i><i>B</i><i>L</i><i>I</i><i>S</i><i>H</i><i>E</i><i>D</i>
				</div>
			<? endif; ?>

			<div class="p_mess_cat">
				<strong>Категория:</strong> <?= $message['cname']; ?> |
				<strong>Тип объявления:</strong> <?= $message['tname']; ?> |
				<strong>Город:</strong> <?= $message['town']; ?>
			</div>

			<div class="p_mess_cat">
				<strong>Дата добавления объявления:</strong> <?= date('d.m.Y - H:i:s', $message['date']); ?> |
				<strong>Цена:</strong> <?= $message['price']; ?> |
				<strong>Автор</strong> <a href="mailto:<?= $message['uemail']; ?>"><?= $message['uname']; ?></a>
			</div>

			<div class="body">
				<div class="mini_mess">
					<img src="<?= THUMBNAILS . $message['img']; ?>">
					<?if(!empty($additional_images)):?>
						<?foreach($additional_images as $add_img):?>
							<?if(!empty($add_img)):?>
								<img style="width: 65px" src="<?= THUMBNAILS . $add_img; ?>">
							<?endif;?>
						<?endforeach;?>
					<?endif;?>
				</div>
				<?= nl2br($message['body']); ?>
			</div>
		</div>

		<div class="clearfix"></div>
		<div class="links">
			<ul>
				<li><a href="?action=edit_message&id=<?= $message['post_id']; ?>">Редактировать</a></li>
				<li><a href="?action=user_messages&delete=<?= $message['post_id']; ?>">Удалить</a></li>
			</ul>
		</div>
	</div>
<? else: ?>
	<p>Нет такого объявления</p>
<? endif; ?>
