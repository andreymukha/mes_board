<? if(!empty($messages)): ?>
	<? foreach($messages as $message): ?>
		<div class="message">
			<div class="content clearfix">
				<div class="heading">
					<h3>
						<a href="?action=view_message&id=<?= $message['post_id']; ?>"><?= $message['title']; ?></a>
					</h3>
				</div>


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
	
	<? if($pager) : ?>
		<div class="pagination-wrapper">
			<ul class="pagination">
				<? if($pager['first']) : ?>
					<li class="first">
						<a href="?action=index<?= $type; ?><?= $cat; ?>&page=1">Первая</a>
					</li>
				<? endif; ?>

				<? if($pager['prev_page']) : ?>
					<li>
						<a href="?action=index<?= $type; ?><?= $cat; ?>&page=<?= $pager['prev_page'] ?>">&lt;</a>
					</li>
				<? endif; ?>

				<? if($pager['previous']) : ?>
					<? foreach($pager['previous'] as $val) : ?>
						<li>
							<a href="?action=index<?= $type; ?><?= $cat; ?>&page=<?= $val; ?>"><?= $val; ?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>

				<? if($pager['current']) : ?>
					<li class="active">
						<span><?= $pager['current']; ?></span>
					</li>
				<? endif; ?>

				<? if($pager['next']) : ?>
					<? foreach($pager['next'] as $v) : ?>
						<li>
							<a href="?action=index<?= $type; ?><?= $cat; ?>&page=<?= $v; ?>"><?= $v; ?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>

				<? if($pager['next_page']) : ?>
					<li>
						<a href="?action=index<?= $type; ?><?= $cat; ?>&page=<?= $pager['next_page'] ?>">&gt;</a>
					</li>
				<? endif; ?>

				<? if($pager['last']) : ?>
					<li class="last">
						<a href="?action=index<?= $type; ?><?= $cat; ?>&page=<?= $pager['last'] ?>">Последняя</a>
					</li>
				<? endif; ?>
			</ul>
		</div>
	<? endif; ?>
	
<? else: ?>
	<p>На данной странице нет объявлений</p>
<? endif; ?>