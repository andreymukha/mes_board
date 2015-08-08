<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="mes_title">Название объявления</label>
		<input class="form-control" name="mes_title" type="text" value="<?=$_SESSION['msg']['message']['title']?>" placeholder="Название"/><br />

		<div class="radio">
			<? if(!empty($types) and is_array($types)): ?>
				<? foreach($types as $type): ?>
					<label for="mes_type">
						<input type="radio" name="mes_type" value="<?=$type['type_id']?>"/> <?=$type['name']?>
					</label>
				<? endforeach; ?>
			<? endif; ?>
		</div>

		<label for="mes_image">Загрузить изображение</label>
		<input class="mes_image" name="mes_image" type="file" value=""/><br />

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
						<label for="mes_image">Дополнительное изображение 1</label>
						<input class="mes_image" name="mini[]" type="file" value=""/><br />

						<label for="mes_image">Дополнительное изображение 2</label>
						<input class="mes_image" name="mini[]" type="file" value=""/><br />

						<label for="mes_image">Дополнительное изображение 3</label>
						<input class="mes_image" name="mini[]" type="file" value=""/><br />
					</div>
				</div>
			</div>
		</div>
		<!-- Аккордеон для дополнительных изображений -->

		<label for="mes_categories">Выбрать категорию</label>
		<select name="mes_categories" id="mes_categories">
			<? if(!empty($categories) and is_array($categories)): ?>
				<? foreach($categories as $p_cat_id => $p_category): ?>
					<optgroup label="<?= $p_category['0'] ?>">
						<? foreach($p_category['parent'] as $cat_id => $category): ?>
							<option value="<?=$cat_id?>">— <?=$category?></option>
						<? endforeach; ?>
					</optgroup>
				<? endforeach; ?>
			<? endif; ?>
		</select>
		<br />

		<label for="mes_town">Город</label>
		<input class="form-control" name="mes_town" type="text" value="<?=$_SESSION['msg']['message']['town']?>" placeholder="Город"/><br />

		<label for="mes_time">Период актуальности объявления</label>
			<select name="mes_time">
				<option value="10">10 дней</option>
				<option value="15">15 дней</option>
				<option value="20">20 дней</option>
				<option value="30">30 дней</option>
			</select>
		<br />

		<label for="mes_price">Цена</label>
		<input class="form-control" type='text' name='mes_price' value="<?=$_SESSION['msg']['message']['price']?>" placeholder="Цена"><br />

		<label for="mes_body">Текст объявления</label>
		<textarea name="mes_body" class="form-control" id="mes_body" cols="30" rows="10"><?=$_SESSION['msg']['message']['body']?></textarea><br />

		<label for="capcha">Введите код с картинки</label><br />
		<img src="capcha.php"><br /><br />
		<input class="form-control" type='text' name='capcha'>
		<br />

		<input type="submit" name="add_message" class="btn btn-primary" value="Добавить объявление"/>
	</div>
</form>