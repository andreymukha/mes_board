<div id="wrapper" class="container">
	<div id="header" class="row">
		<h2 class="col-md-8">
			<a href="<? $_SERVER['SERVER_NAME'] ?>/">Доска объявлений</a>
		</h2>

		<div class="auth col-md-4">
			<? if(empty($user) and !is_array($user)): ?>
				<a href="?action=login">Вход</a> | <a href="?action=registration">Регистрация</a>
			<? else: ?>
				Добро пожаловать, <?= $user['name'] ?> | <a href="?action=login&logout=1">Выход</a><br/>
				Ваш последний вход: <?= date('d.m.Y H:i:s', $user['last_login']) ?>
			<? endif; ?>
		</div>
	</div>

	<div id="main-menu" class="navbar navbar-default">
		<ul class="nav navbar-nav navbar-right">
			<? foreach($main_menu as $item): ?>
				<li class="<?=$item['classes'];?>"><a href="<?= $item['link']; ?>"><?= $item['name'] ?></a></li>
			<? endforeach; ?>
		</ul>
	</div>

	<div class="row">
		<div id="sidebar" class="col-md-3">
			<div class="block">
				<h3>Категории</h3>
				<ul class="categories">
					<? if(!empty($categories) and is_array($categories)): ?>
						<? foreach($categories as $category_id => $category): ?>
							<? if(isset($category['parent']) and is_array($category['parent'])): ?>
								<strong>
									<li><?= $category[0] ?></li>
								</strong>
								<ul>
									<? foreach($category['parent'] as $p_category_id => $p_category): ?>
										<li>- <a href="?cat=<?= $p_category_id ?>"><?= $p_category ?></a></li>
									<? endforeach; ?>
								</ul>
							<? endif; ?>
						<? endforeach; ?>
					<? endif; ?>
				</ul>
			</div>

			<div class="block">
				<h3>Поиск</h3>
				<form method="GET" action="?action=search">
					<input name="action" value="search" type="hidden">
					Поиск<br>
					<input name="search" type="text">
					<br>
					<br>
					Категория:<br>
					<select name="id_categories">
						<option selected="selected" value="">Выберите категорию</option>
						<optgroup label="Транспорт">
							<option value="5">--Автомобили</option>
							<option value="6">--Мото</option>
						</optgroup>
						<optgroup label="Интернет">
							<option value="7">--Компьютеры</option>
							<option value="8">--Игры</option>
						</optgroup>
						<optgroup label="Дом">
							<option value="9">--Мебель</option>
							<option value="10">--Сантехника</option>
						</optgroup>
						<optgroup label="Сад, огород">
							<option value="11">--Интсрумент</option>
							<option value="12">--Строй материалы</option>
						</optgroup>
					</select>
					<br>
					<br>
					Тип объявления:<br>
					<input name="id_razd" value="1" type="radio">Предложение
					<input name="id_razd" value="2" type="radio">Спрос
					<br><br>
					Диапазон цен:<br>
					От <input name="p_min" class="p_search" type="text"> До <input name="p_max" class="p_search"
																				   type="text">
					<br><br>
					<input value="Поиск" type="submit">
				</form>
			</div>
		</div>
		<div id="content" class="col-md-9 <?= $action ?>">
			<div class="page-header">
				<h2 class="title_page"><?= $title ?></h2>
			</div>
			<? if($_SESSION['msg']): ?>
				<?= $_SESSION['msg']['message']; ?>
			<? endif; ?>
			<?= $content ?>
		</div>
	</div>

	<div id="footer">
		<p class="footer_text">Доска объявлений</p>
	</div>
</div>