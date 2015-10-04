<? if(!empty($message) and is_array($message)): ?>
	<div class="message<?=$message['unpublished'];?>">
		<div class="content">
			<? if($message['unpublished']): ?>
				<div class="unpublish-mess">
					UNPUBLISHED
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

					<div class="connected-carousels">
						<div class="stage">
							<div class="carousel carousel-stage">
								<ul>
									<li><a class="group1" href="<?= IMAGES . $message['img']; ?>"><img src="<?= THUMBNAILS . $message['img']; ?>"></a></li>

									<?foreach($additional_images as $add_img):?>
										<?if(!empty($add_img)):?>
											<li>
												<a class="group1" href="<?= IMAGES . $add_img; ?>">
													<img src="<?= THUMBNAILS . $add_img; ?>">
												</a>
											</li>
										<?endif;?>
									<?endforeach;?>
								</ul>
							</div>

							<a href="#" class="prev prev-stage"><span>&lsaquo;</span></a>
							<a href="#" class="next next-stage"><span>&rsaquo;</span></a>
						</div>
						<?if(!empty($additional_images[0]) or count($additional_images) > 1):?>
						<div class="navigation">
							<a href="#" class="prev prev-navigation">&lsaquo;</a>
							<a href="#" class="next next-navigation">&rsaquo;</a>
							<div class="carousel carousel-navigation">
								<ul>
									<li><a class="group1" href="<?= IMAGES . $message['img']; ?>"><img src="<?= THUMBNAILS . $message['img']; ?>"></a></li>
									<?foreach($additional_images as $add_img):?>
										<?if(!empty($add_img)):?>
											<li class="additional">
												<a class="group1" href="<?= IMAGES . $add_img; ?>">
													<img style="width: 65px" src="<?= THUMBNAILS . $add_img; ?>">
												</a>
											</li>
										<?endif;?>
									<?endforeach;?>
								</ul>
							</div>
						</div>
						<?endif;?>
					</div>

				</div>
				<?= nl2br($message['body']); ?>
			</div>
		</div>

		<div class="clearfix"></div>
		<? if($links): ?>
		<div class="links">
			<ul>
				<li><a href="?action=edit_message&id=<?= $message['post_id']; ?>">Редактировать</a></li>
				<li><a href="?action=view_message&delete=<?= $message['post_id']; ?>">Удалить</a></li>
			</ul>
		</div>
		<? endif; ?>
	</div>
<? endif; ?>
