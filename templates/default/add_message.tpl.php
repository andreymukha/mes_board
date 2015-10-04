<form id="add_message" method="post" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
	<div class="form-group">
		<label for="mes_title" class="control-label">Название объявления</label>
		<input id="mes_title" class="form-control" name="mes_title" type="text"
			   value="<?= $_SESSION['msg']['mess']['title']; ?>" placeholder="Название"/>
	</div>

	<div class="radio form-group">
		<? if(!empty($types) and is_array($types)): ?>
			<? foreach($types as $type): ?>
				<label for="mes_type" class="control-label">
					<? if(!empty($_SESSION['msg']['mess']['type']) and $_SESSION['msg']['mess']['type'] == $type['type_id']): ?>
						<input type="radio" name="mes_type" checked
							   value="<?= $type['type_id'] ?>"/> <?= $type['name'] ?>
					<? else: ?>
						<input type="radio" name="mes_type" value="<?= $type['type_id'] ?>"/> <?= $type['name'] ?>
					<? endif; ?>
				</label>
			<? endforeach; ?>
		<? endif; ?>
	</div>

	<div class="form-group mes_image">
		<label for="mes_image" class="control-label">Загрузить изображение</label>
		<input id="mes_image" class="mes_image" name="mes_image" type="file" value=""/>
	</div>

	<!-- Аккордеон для дополнительных изображений -->
	<div class="panel-group" id="additional_img" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse"
					   aria-expanded="false" aria-controls="collapseTwo">
						Загрузить дополнительные изображения
					</a>
				</h4>
			</div>
			<div id="collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
				<div class="panel-body">
					<!--ФОРМА ДЛЯ ЗАГРУЗКИ КАРТИНОК-->
					<div class="additional_images">
						<div class="img">
							<label for="add_mes_image1" class="control-label">Дополнительное изображение 1</label>
							<input id="add_mes_image1" class="mes_image" name="additional_img[]" type="file"
								   value=""/><br/>
						</div>
					</div>
					<input id="add_img" type="button" class="btn" value="Добавить дополнительное поле"/>
					<!--ФОРМА ДЛЯ ЗАГРУЗКИ КАРТИНОК-->
				</div>
			</div>
		</div>
	</div>
	<!-- Аккордеон для дополнительных изображений -->

	<div class="form-group mes_categories">
		<label for="mes_categories" class="control-label">Выбрать категорию</label>
		<select name="mes_categories" id="mes_categories">
			<option value=""></option>
			<? if(!empty($categories) and is_array($categories)): ?>
				<? foreach($categories as $p_cat_id => $p_category): ?>
					<optgroup label="<?= $p_category['0'] ?>">
						<? foreach($p_category['parent'] as $cat_id => $category): ?>
							<? if(!empty($_SESSION['msg']['mess']['mes_category']) and $_SESSION['msg']['mess']['mes_category'] == $cat_id): ?>
								<option selected value="<?= $cat_id ?>">— <?= $category ?></option>
							<? else: ?>
								<option value="<?= $cat_id ?>">— <?= $category ?></option>
							<? endif; ?>
						<? endforeach; ?>
					</optgroup>
				<? endforeach; ?>
			<? endif; ?>
		</select>
	</div>

	<div class="form-group">
		<label for="mes_town" class="control-label">Город</label>
		<input id="mes_town" class="form-control" name="mes_town" type="text"
		   	value="<?= $_SESSION['msg']['mess']['town']; ?>" placeholder="Город"/>
	</div>

	<div class="form-group">
		<label for="mes_price" class="control-label">Цена</label>
		<input id="mes_price" class="form-control" type='text' name='mes_price'
			value="<?= $_SESSION['msg']['mess']['price'] ?>" placeholder="Цена">
	</div>

	<div class="form-group">
		<label for="mes_body" class="control-label">Текст объявления</label>
		<textarea name="mes_body" class="form-control" id="mes_body" cols="30"
			  rows="10"><?= $_SESSION['msg']['mess']['body'] ?></textarea>
	</div>

	<div class="form-group capcha">
		<label for="capcha" class="control-label">Введите код с картинки</label><br/>
		<img src="capcha.php"><br/><br/>
		<input id="capcha" class="form-control" type='text' name='capcha'>
	</div>

	<div class="form-group">
		<button id="validateButton" type="submit" name="add_message" class="btn btn-primary">Добавить объявление</button>
	</div>
</form>