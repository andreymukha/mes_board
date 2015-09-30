<? if(!empty($messages)): ?>
	<? foreach($messages as $message): ?>
		<div class="t_mess unpublished<?= $message['published']; ?>">
			<div class="content">
				<? if($message['published'] == 0): ?>
					<div class="unpublish-mess">
						<i>U</i><i>N</i><i>P</i><i>U</i><i>B</i><i>L</i><i>I</i><i>S</i><i>H</i><i>E</i><i>D</i>
					</div>
				<? endif; ?>

				<h4 class="title_p_mess">
					<a href="?action=view_message&id=<?= $message['post_id']; ?>"><?= $message['title']; ?></a>
				</h4>

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
					<li><a href="?action=edit_message&id=<?=$message['post_id'];?>">Редактировать</a></li>
					<li><a href="?action=view_message&delete=<?=$message['post_id'];?>">Удалить</a></li>
					<li><a href="?action=view_message&id=<?= $message['post_id']; ?>">Подробнее</a></li>
				</ul>
			</div>
		</div>
	<? endforeach; ?>
	
	<? if($pager) : ?>
		<ul class="pager">
			<? if($pager['first']) : ?>
				<li class="first">
					<a href="?page=1<?= $type; ?>">Первая</a>
				</li>
			<? endif; ?>

			<? if($pager['prev_page']) : ?>
				<li>
					<a href="?page=<?= $pager['prev_page'] ?><?= $type; ?>">&lt;</a>
				</li>
			<? endif; ?>

			<? if($pager['previous']) : ?>
				<? foreach($pager['previous'] as $val) : ?>
					<li>
						<a href="?page=<?= $val; ?><?= $type; ?>"><?= $val; ?></a>
					</li>
				<? endforeach; ?>
			<? endif; ?>

			<? if($pager['current']) : ?>
				<li>
					<span><?= $pager['current']; ?></span>
				</li>
			<? endif; ?>

			<? if($pager['next']) : ?>
				<? foreach($pager['next'] as $v) : ?>
					<li>
						<a href="?page=<?= $v; ?><?= $type; ?>"><?= $v; ?></a>
					</li>
				<? endforeach; ?>
			<? endif; ?>

			<? if($pager['next_page']) : ?>
				<li>
					<a href="?page=<?= $pager['next_page'] ?><?= $type; ?>">&gt;</a>
				</li>
			<? endif; ?>

			<? if($pager['last']) : ?>
				<li class="last">
					<a href="?page=<?= $pager['last'] ?><?= $type; ?>">Последняя</a>
				</li>
			<? endif; ?>
		</ul>
	<? endif; ?>
	
<? else: ?>
	<p>На данной странице нет объявлений</p>
<? endif; ?>